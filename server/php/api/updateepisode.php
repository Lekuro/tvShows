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
                echo xmlrpc_encode(updateEpisode());
            } else {
                header('Content-type:application/json'); //;charset=utf-8                
                //echo $_SESSION['user_login'];
                //echo $_SESSION['user_isadmin'];
                echo json_encode(updateEpisode());
            }
        }
    }else{
        return ['errorMes'=>'You are not admin. Only admin can changes  database!'];
    }
    /**
     * 
     * 
     */
    function updateEpisode(){
        require_once '../library/db.php';        
        require_once '../library/testinput.php';
        $link = connectToDb();
        //print_r($_FILES['fileImage']);      
        $titleFile = 'sh'.test_input($_POST['tvShowId']).'s'.test_input($_POST['episodeNumber']);
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
                    die('Cannot save file! From updateEpisode()');
                };                
            } else {
                die('Uploaded file error! Code: '.$_FILES['fileImage']['error'].' From updateEpisode()');
            } 
        }
        $episodeId = mysqli_escape_string($link, test_input($_POST['episodeId'])); 
        $episodeName = mysqli_escape_string($link, test_input($_POST['episodeName']));   
        $episodeNumber = mysqli_escape_string($link, test_input($_POST['episodeNumber']));
        $tvShowId = mysqli_escape_string($link, test_input($_POST['tvShowId'])); 
        $seasonId = mysqli_escape_string($link, test_input($_POST['seasonId'])); 
        $longDescription = mysqli_escape_string($link, test_input($_POST['longDescription']));
        $shortDescription = mysqli_escape_string($link, test_input($_POST['shortDescription']));
        $featuredImage = mysqli_escape_string($link, $fileName);
        $videoFragmentUrl = mysqli_escape_string($link, test_input($_POST['videoFragmentUrl']));
        $usersRating = mysqli_escape_string($link, test_input($_POST['usersRating']));//,`usersRating`='$usersRating'       
        
        if($fileName){
            $sql = sprintf("UPDATE `episode` SET `episodeName`='%s',`episodeNumber`='%d',`tvShowId`='%d',
            `seasonId`='%d', `longDescription`='%s',`shortDescription`='%s',`featuredImage`='%s',
            `videoFragmentUrl`='%s'  WHERE `episodeId`='%d'", $episodeName, $episodeNumber, $tvShowId, 
            $seasonId, $longDescription, $shortDescription, $featuredImage, $videoFragmentUrl, $episodeId);
        } else {
            $sql = sprintf("UPDATE `episode` SET `episodeName`='%s',`episodeNumber`='%d',`tvShowId`='%d',
            `seasonId`='%d', `longDescription`='%s',`shortDescription`='%s',
            `videoFragmentUrl`='%s'  WHERE `episodeId`='%d'", $episodeName, $episodeNumber, $tvShowId, 
            $seasonId, $longDescription, $shortDescription, $videoFragmentUrl, $episodeId);
        }
        $res = insertUpdeteDeleteInDb($sql);
        if (!$res){
            die('Cannot update database. From updateEpisode()');
        }
        if($usersRating){     
            $userId = mysqli_escape_string($link, $_SESSION['user_id']);
            $sql = sprintf("INSERT INTO `rating`(`userId`, `episodeId`, `ratingValue`) 
                VALUES ('%d','%d','%d')", $userId, $episodeId, $usersRating);       
            $res = insertUpdeteDeleteInDb($sql);
            if (!$res){
                die('Cannot isert rating. From updateEpisode()');
            }
        } 
        return ['resultMes'=>'The database updated Success!'];            
    } 