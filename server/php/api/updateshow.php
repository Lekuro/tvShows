<?php
    session_start();
    //var_dump($_COOKIE); //['PHPSESSID']
    //print_r($_SESSION);
    //print_r($_POST);
    //print_r($_FILES);
        
    if(isset($_SESSION['user_login']) && $_SESSION['user_isadmin']==='1'){
        require_once '../configs/headers.php';       
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if ($_SERVER['HTTP_ACCEPT'] === "application/xml") { 
                //strpos($_SERVER['HTTP_ACCEPT'], "application/xml") !== -1
                header("Content-Type: application/xml"); //;charset=utf-8'
                echo xmlrpc_encode(updateShow());
            } else {
                header('Content-type:application/json'); //;charset=utf-8                
                //echo $_SESSION['user_login'];
                //echo $_SESSION['user_isadmin'];
                echo json_encode(updateShow());
                //setoldShow();
            }
        }
    }else{
        return ['errorMes'=>'You are not admin. Only admin can changes  database!'];
    }
    /**
     * 
     * 
     */
    function updateShow(){
        require_once '../library/db.php';        
        require_once '../library/testinput.php';
        $link = connectToDb();
        //print_r($_FILES['fileImage']);      
        $titleFile = str_replace('', '_', test_input($_POST['title']));
        $fileName = '';  
        if(isset($_FILES['fileImage'])){
            if($_FILES['fileImage']['error']==0){
                $tmpName = $_FILES['fileImage']['tmp_name'];
                //$fileName = "img_".time().'.'.pathinfo($_FILES['fileImage']['name'], PATHINFO_EXTENSION);
                $fileName = $titleFile.'.'.pathinfo($_FILES['fileImage']['name'], PATHINFO_EXTENSION);
                //$fileName = basename($_FILES["fileImage"]["name"]);
                $fileDir = "../../images/shows/$fileName";
                if(move_uploaded_file($tmpName, $fileDir)){
                    //die('yes');
                } else {
                    die('Cannot save file! From updateShow()');
                };                
            } else {
                die('Uploaded file error! Code: '.$_FILES['fileImage']['error'].' From updateShow()');
            } 
        }
        $showId = mysqli_escape_string($link, test_input($_POST['tvShowId'])); 
        $title = mysqli_escape_string($link, test_input($_POST['title']));   
        $subtitle = mysqli_escape_string($link, test_input($_POST['subtitle']));
        //$subtitle = test_input($_POST['subtitle']) ?? null;
        $startDate = mysqli_escape_string($link, test_input($_POST['startDate']));
        $posterImage = mysqli_escape_string($link, $fileName);
        $longDescription = mysqli_escape_string($link, test_input($_POST['longDescription']));
        $shortDescription = mysqli_escape_string($link, test_input($_POST['shortDescription']));
        $priority = mysqli_escape_string($link, test_input($_POST['priority']));
        $videoFragmentUrl = mysqli_escape_string($link, test_input($_POST['videoFragmentUrl']));
        $usersRating = mysqli_escape_string($link, test_input($_POST['usersRating']));//,`usersRating`='$usersRating'  

        if($fileName){
            $sql = sprintf("UPDATE `tvshow` SET `title`='%s',`subtitle`='%s',`startDate`='%s',`posterImage`='%s',
            `longDescription`='%s',`shortDescription`='%s',`priority`='%d', 
            `videoFragmentUrl`='%s'  WHERE `tvShowId`='%d'", $title, $subtitle, $startDate, $posterImage,
            $longDescription, $shortDescription, $priority, $videoFragmentUrl, $showId);
        } else {
            $sql = sprintf("UPDATE `tvshow` SET `title`='%s',`subtitle`='%s',`startDate`='%s',
            `longDescription`='%s',`shortDescription`='%s',`priority`='%d', 
            `videoFragmentUrl`='%s'  WHERE `tvShowId`='%d'", $title, $subtitle, $startDate, 
            $longDescription, $shortDescription, $priority, $videoFragmentUrl, $showId);
        }
        $res = insertUpdeteDeleteInDb($sql);
        if (!$res){
            die('Cannot update database. From updateShow()');
        }
        if($usersRating){     
            $userId = mysqli_escape_string($link, $_SESSION['user_id']);
            $sql = sprintf("INSERT INTO `rating`(`userId`, `tvShowId`, `ratingValue`) 
                VALUES ('%d','%d','%d')", $userId, $showId, $usersRating);
            $res = insertUpdeteDeleteInDb($sql);
            if (!$res){
                die('Cannot isert rating. From updateShow()');
            }
        }        
        return ['resultMes'=>'The database updated Success!'];            
    } 