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
                echo xmlrpc_encode(updateSeason());
            } else {
                header('Content-type:application/json'); //;charset=utf-8                
                //echo $_SESSION['user_login'];
                //echo $_SESSION['user_isadmin'];
                echo json_encode(updateSeason());
            }
        }
    }else{
        return ['errorMes'=>'You are not admin. Only admin can changes  database!'];
    }
    /**
     * 
     * 
     */
    function updateSeason(){
        require_once '../library/db.php';        
        require_once '../library/testinput.php';
        $link = connectToDb();
        //print_r($_FILES['fileImage']);      
        $titleFile = 'sh'.test_input($_POST['tvShowId']).'s'.test_input($_POST['seasonNumber']);
        $fileName = '';  
        if(isset($_FILES['fileImage'])){
            if($_FILES['fileImage']['error']==0){
                $tmpName = $_FILES['fileImage']['tmp_name'];
                //$fileName = "img_".time().'.'.pathinfo($_FILES['fileImage']['name'], PATHINFO_EXTENSION);
                //$fileName = basename($_FILES["fileImage"]["name"]);
                $fileName = $titleFile.'.'.pathinfo($_FILES['fileImage']['name'], PATHINFO_EXTENSION);
                $fileDir = "../../images/seasons/$fileName";
                if(move_uploaded_file($tmpName, $fileDir)){
                    //die('yes');
                } else {
                    die('Cannot save file! From updateSeason()');
                };                
            } else {
                die('Uploaded file error! Code: '.$_FILES['fileImage']['error'].' From updateSeason()');
            } 
        }
        $seasonId = mysqli_escape_string($link, test_input($_POST['seasonId'])); 
        $seasonName = mysqli_escape_string($link, test_input($_POST['seasonName']));   
        $seasonNumber = mysqli_escape_string($link, test_input($_POST['seasonNumber']));
        $tvShowId = mysqli_escape_string($link, test_input($_POST['tvShowId'])); 
        $featuredImage = mysqli_escape_string($link, $fileName);
        $longDescription = mysqli_escape_string($link, test_input($_POST['longDescription']));
        $shortDescription = mysqli_escape_string($link, test_input($_POST['shortDescription']));
        $videoFragmentUrl = mysqli_escape_string($link, test_input($_POST['videoFragmentUrl']));
        $usersRating = mysqli_escape_string($link, test_input($_POST['usersRating']));//,`usersRating`='$usersRating'       
        
        if($fileName){
            $sql = sprintf("UPDATE `season` SET `seasonName`='%s',`seasonNumber`='%d',`tvShowId`='%d',
            `longDescription`='%s',`shortDescription`='%s',`featuredImage`='%s',
            `videoFragmentUrl`='%s'  WHERE `seasonId`='%d'", $seasonName, $seasonNumber, $tvShowId, 
            $longDescription, $shortDescription, $featuredImage, $videoFragmentUrl, $seasonId);
        } else {
            $sql = sprintf("UPDATE `season` SET `seasonName`='%s',`seasonNumber`='%d',`tvShowId`='%d',
            `longDescription`='%s',`shortDescription`='%s',
            `videoFragmentUrl`='%s'  WHERE `seasonId`='%d'", $seasonName, $seasonNumber, $tvShowId, 
            $longDescription, $shortDescription, $videoFragmentUrl, $seasonId);
        }
        $res = insertUpdeteDeleteInDb($sql);
        if (!$res){
            die('Cannot update database. From updateSeason()');
        }
        if($usersRating){     
            $userId = mysqli_escape_string($link, $_SESSION['user_id']);
            $sql = sprintf("INSERT INTO `rating`(`userId`, `seasonId`, `ratingValue`) 
                VALUES ('%d','%d','%d')", $userId, $seasonId, $usersRating);       
            $res = insertUpdeteDeleteInDb($sql);
            if (!$res){
                die('Cannot isert rating. From updateSeason()');
            }
        } 
        return ['resultMes'=>'The database updated Success!'];            
    } 