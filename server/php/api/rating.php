<?php
    session_start();             
    //print_r($_SESSION);
    //print_r($_POST);
    if(isset($_SESSION['user_login'])){
        require_once '../configs/headers.php';       
        if ($_SERVER['REQUEST_METHOD'] === 'POST'){
            if ($_SERVER['HTTP_ACCEPT'] === "application/xml") { 
                //strpos($_SERVER['HTTP_ACCEPT'], "application/xml") !== -1
                header("Content-Type: application/xml"); //;charset=utf-8'
                echo xmlrpc_encode(setRating());
            } else {
                header('Content-type:application/json'); //;charset=utf-8   
                //echo $_SESSION['user_isadmin'];['user_login']
                echo json_encode(setRating());
            }
        }
    }else{
        return ['errorMes'=>'You are not logined. Only logined can changes  database!'];
    }
    /**
     * 
     * 
     */
    function setRating(){        
        require_once '../library/db.php';  
        $link = connectToDb();    
         $userId = mysqli_escape_string($link, $_SESSION['user_id']);//$_POST['userId']);
        // $tvShowId = mysqli_escape_string($link, $_POST['tvShowId']); 
        // $seasonId = mysqli_escape_string($link, $_POST['seasonId']); 
        // $episodeId = mysqli_escape_string($link, $_POST['episodeId']); 
         $rating = mysqli_escape_string($link, $_POST['ratingValue']);
        //$usersRating = mysqli_escape_string($link, test_input($_POST['usersRating']));//, `usersRating` $usersRating ,'%b'

        /*$sql = sprintf("INSERT INTO `starrating`(`userId`, `tvShowId`, `seasonId`, `episodeId`, `ratingNumber`) 
                VALUES ('%d','%d','%d','%d', '%d')", $userId, $tvShowId, $seasonId, $episodeId, $rating);*/
        
        if(isset($_POST['tvShowId'])){
            $tvShowId = mysqli_escape_string($link, $_POST['tvShowId']);
            $sql = sprintf("INSERT INTO `rating`(`userId`, `tvShowId`, `ratingValue`) 
                VALUES ('%d','%d','%d')", $userId, $tvShowId, $rating);
        } else if(isset($_POST['seasonId'])){
            $seasonId = mysqli_escape_string($link, $_POST['seasonId']); 
            $sql = sprintf("INSERT INTO `rating`(`userId`, `seasonId`, `ratingValue`) 
                VALUES ('%d','%d','%d')", $userId, $seasonId, $rating);
        } else if(isset($_POST['episodeId'])){
            $episodeId = mysqli_escape_string($link, $_POST['episodeId']); 
            $sql = sprintf("INSERT INTO `rating`(`userId`, `episodeId`, `ratingValue`) 
                VALUES ('%d','%d','%d')", $userId, $episodeId, $rating);
        }
        
        $res = insertUpdeteDeleteInDb($sql);        
        if (!$res){
            die('Cannot update database. From setRating()');
        }
        return ['resultMes'=>'The rating insert Success!'];      
               
    }