<?php
    session_start();
    //print_r($_POST);
    if(isset($_SESSION['user_login']) && $_SESSION['user_isadmin']==='1'){
        require_once '../configs/headers.php';
        //print_r($_SESSION);   
        //var_dump($_COOKIE); //['PHPSESSID']
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if ($_SERVER['HTTP_ACCEPT'] === "application/xml") { 
                //strpos($_SERVER['HTTP_ACCEPT'], "application/xml") !== -1
                header("Content-Type: application/xml"); //;charset=utf-8'
                echo xmlrpc_encode(insertEpisode());
            } else {
                header('Content-type:application/json'); //;charset=utf-8                
                //echo $_SESSION['user_login'];
                //echo $_SESSION['user_isadmin'];
                echo json_encode(insertEpisode());
            }
        }
    }
    /**
     * 
     * 
     */
    function insertEpisode(){        
        require_once '../library/db.php';        
        require_once '../library/testinput.php';    
        $link = connectToDb();      
        $titleFile = 'sh'.test_input($_POST['tvShowId']).'s'.test_input($_POST['seasonNumber']).'s'.test_input($_POST['episodeNumber']);
        //print_r($_FILES['fileImage']);  
        $fileName = '';  
        if(isset($_FILES['fileImage'])){
            if($_FILES['fileImage']['error']==0){
                $tmpName = $_FILES['fileImage']['tmp_name'];
                //$fileName = "img_".time().'.'.pathinfo($_FILES['fileImage']['name'], PATHINFO_EXTENSION);
                //$fileName = basename($_FILES["fileImage"]["name"]);
                $fileName = $titleFile.'.'.pathinfo($_FILES['fileImage']['name'], PATHINFO_EXTENSION);
                $fileDir = "../../images/episodes/$fileName";
                if(move_uploaded_file($tmpName, $fileDir)){
                    //die('yes');
                } else {
                    die('Cannot save file! From insertEpisode()');
                };                
            } else {
                die('Uploaded file error! Code: '.$_FILES['fileImage']['error'].' From insertEpisode()');
            } 
        }
        $episodeName = mysqli_escape_string($link, test_input($_POST['episodeName']));   
        $episodeNumber = mysqli_escape_string($link, test_input($_POST['episodeNumber']));
        $tvShowId = mysqli_escape_string($link, test_input($_POST['tvShowId'])); 
        $seasonId = mysqli_escape_string($link, test_input($_POST['seasonId'])); 
        $longDescription = mysqli_escape_string($link, test_input($_POST['longDescription']));
        $shortDescription = mysqli_escape_string($link, test_input($_POST['shortDescription']));
        $featuredImage = mysqli_escape_string($link, $fileName);
        $videoFragmentUrl = mysqli_escape_string($link, test_input($_POST['videoFragmentUrl']));
        $usersRating = mysqli_escape_string($link, test_input($_POST['usersRating']));//, `usersRating` $usersRating ,'%b'

        $sql = sprintf("INSERT INTO `episode`(`episodeName`, `episodeNumber`, `tvShowId`, `seasonId`, `longDescription`, `shortDescription`,
                `featuredImage`, `videoFragmentUrl`) VALUES ('%s','%d','%d','%d','%s', '%s','%s','%s')", $episodeName, $episodeNumber, 
                $tvShowId, $seasonId, $longDescription, $shortDescription, $featuredImage, $videoFragmentUrl );

        $res = insertUpdeteDeleteInDb($sql);        
        if (!$res){
            die('Cannot update database. From insertEpisode()');
        }
        if($usersRating){  
            // look for eposodeId
            $sql = "SELECT `episodeId` FROM `episode` WHERE `seasonId`=$seasonId AND `episodeNumber`=$episodeNumber";
            $res = selectDataInDb($sql);
            if (mysqli_num_rows($res) === 0){
                die('Error to find inserted id. From insertEpisode()');
            }else{                 
                $result = mysqli_fetch_all($res, MYSQLI_ASSOC);  
                $episodeId = $result[0]['episodeId']; 
            }
            $userId = mysqli_escape_string($link, $_SESSION['user_id']);
            $sql = sprintf("INSERT INTO `rating`(`userId`, `episodeId`, `ratingValue`) 
                VALUES ('%d','%d','%d')", $userId, $episodeId, $usersRating);       
            $res = insertUpdeteDeleteInDb($sql);
            if (!$res){
                die('Cannot isert rating. From insertEpisode()');
            }
        }
        return ['resultMes'=>'The data insert Success!'];      
               
    }