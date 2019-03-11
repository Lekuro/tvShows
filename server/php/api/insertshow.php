<?php
    session_start();
    if(isset($_SESSION['user_login']) && $_SESSION['user_isadmin']==='1'){
        require_once '../configs/headers.php';
        //print_r($_SESSION);   
        //var_dump($_COOKIE); //['PHPSESSID']
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if ($_SERVER['HTTP_ACCEPT'] === "application/xml") { 
                //strpos($_SERVER['HTTP_ACCEPT'], "application/xml") !== -1
                header("Content-Type: application/xml"); //;charset=utf-8'
                echo xmlrpc_encode(insertShow());
            } else {
                header('Content-type:application/json'); //;charset=utf-8                
                //echo $_SESSION['user_login'];
                //echo $_SESSION['user_isadmin'];
                echo json_encode(insertShow());
            }
        }
    }
    /**
     * 
     * 
     */
    function insertShow(){        
        require_once '../library/db.php';        
        require_once '../library/testinput.php';    
        $link = connectToDb();    
        //$titleFile = str_replace('', '_', $title);
        //print_r($_FILES['fileImage']);  
        $fileName = '';  
        if(isset($_FILES['fileImage'])){
            if($_FILES['fileImage']['error']==0){
                $tmpName = $_FILES['fileImage']['tmp_name'];
                //$fileName = "img_".time().'.'.pathinfo($_FILES['fileImage']['name'], PATHINFO_EXTENSION);
                $fileName = basename($_FILES["fileImage"]["name"]);
                $fileDir = "../../images/shows/$fileName";
                if(move_uploaded_file($tmpName, $fileDir)){
                    //die('yes');
                } else {
                    die('Cannot save file! From insertShow()');
                };                
            } else {
                die('Uploaded file error! Code: '.$_FILES['fileImage']['error'].' From insertShow()');
            } 
        }
        $title = mysqli_escape_string($link, test_input($_POST['title']));
        $subtitle = mysqli_escape_string($link, test_input($_POST['subtitle']));
        $startDate = mysqli_escape_string($link, test_input($_POST['startDate']));
        $posterImage = mysqli_escape_string($link, $fileName);
        $longDescription = mysqli_escape_string($link, test_input($_POST['longDescription']));
        $shortDescription = mysqli_escape_string($link, test_input($_POST['shortDescription']));
        $priority = mysqli_escape_string($link, test_input($_POST['priority']));
        $videoFragmentUrl = mysqli_escape_string($link, test_input($_POST['videoFragmentUrl']));
        $usersRating = mysqli_escape_string($link, test_input($_POST['usersRating']));//, `usersRating` $usersRating ,'%b'

        $sql = sprintf("INSERT INTO `tvshow`(`title`, `subtitle`, `startDate`, `posterImage`, `longDescription`, `shortDescription`,
                `priority`, `videoFragmentUrl`) VALUES ('%s','%s','%s','%s', '%s','%s','%d','%s')", $title, $subtitle, 
                $startDate, $posterImage, $longDescription, $shortDescription, $priority, $videoFragmentUrl );
        // $sql = "INSERT INTO `tvshow`(`title`, `subtitle`, `startDate`, `posterImage`, `longDescription`, `shortDescription`,
        // `priority`, `videoFragmentUrl`, `usersRating`) VALUES ('$title','$subtitle','$startDate','$posterImage',
        // '$longDescription','$shortDescription','$priority','$videoFragmentUrl',$usersRating)";

        $res = insertUpdeteDeleteInDb($sql);        
        if (!$res){
            die('Cannot update database. From insertShow()');
        }
        if($usersRating){  
            // look for eposodeId
            $sql = "SELECT `tvShowId` FROM `tvshow` WHERE `title`=$title";
            $res = selectDataInDb($sql);
            if (mysqli_num_rows($res) === 0){
                die('Error to find inserted id. From insertEpisode()');
            }else{                 
                $result = mysqli_fetch_all($res, MYSQLI_ASSOC);  
                $episodeId = $result[0]['tvShowId']; 
            }
            $userId = mysqli_escape_string($link, $_SESSION['user_id']);
            $sql = sprintf("INSERT INTO `rating`(`userId`, `tvShowId`, `ratingValue`) 
                VALUES ('%d','%d','%d')", $userId, $tvShowId, $usersRating);       
            $res = insertUpdeteDeleteInDb($sql);
            if (!$res){
                die('Cannot isert rating. From insertShow()');
            }
        }
        return ['resultMes'=>'The data insert Success!'];      
               
    }