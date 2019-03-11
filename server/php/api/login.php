<?php 
session_start();
require_once '../configs/headers.php';
//var_dump($_COOKIE); //['PHPSESSID']

// POST
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    //print_r($_POST);
    //if ($_SERVER['HTTP_ACCEPT'] === 'multipart/form-data' ) { //"application/json"
        require_once '../library/db.php';
        //print_r($_POST);
        $link = connectToDb();
        $login = $_POST['login'];
        $password = $_POST['password'];
        $sql = "SELECT `tvSerialUserId`, `login`, `isAdmin` FROM `tvserialuser` WHERE `login` = '$login' AND `password` = '$password'";//`tvSerialUserId`, `password`, 
        $res = selectDataInDb($sql);
        mysqli_close($link);
        if (mysqli_num_rows($res) === 0){
            $result=['errorMes'=>'There is no such login or password'];
        }else{
            $result = mysqli_fetch_all($res, MYSQLI_ASSOC);  
            $_SESSION['user_login']=$result[0]['login']; 
            $_SESSION['user_isadmin']=$result[0]['isAdmin']; 
            $_SESSION['user_id']=$result[0]['tvSerialUserId']; 
        }
        header('Content-type:application/json'); //;charset=utf-8
        echo json_encode($result);
    //}
}

//GET

if ($_SERVER['REQUEST_METHOD'] === 'GET'){

    if ($_SERVER['HTTP_ACCEPT'] === "application/xml") { 
        //strpos($_SERVER['HTTP_ACCEPT'], "application/xml") !== -1
        header("Content-Type: application/xml"); //;charset=utf-8'
        echo xmlrpc_encode(getData());
    } else {
        $login = $_GET['login'];
        $password = $_GET['password'];
        require_once '../library/db.php';
        $link = connectToDb();
        $sql = "SELECT `tvSerialUserId`, `login`, `isAdmin` FROM `tvserialuser` WHERE `login` = '$login' and `password`='$password'";//`password`, 
        $res = selectDataInDb($sql);   
        mysqli_close($link);
        //$result;
        if (mysqli_num_rows($res) === 0){
            $result=['errorMes'=>'There is no such login or password'];
        }else{                 
            $result = mysqli_fetch_all($res, MYSQLI_ASSOC);  
            $_SESSION['user_login'] = $result[0]['login']; 
            $_SESSION['user_isadmin'] = $result[0]['isAdmin']; 
            $_SESSION['user_id']=$result[0]['tvSerialUserId']; 
            //echo $_SESSION['user_login'];
            //echo $_SESSION['user_isadmin'];
            //[
               // 'login'=>$result[0]['login'],
               // 'isAdmin'=>$result['0']['isAdmin'],
                //'userId'=>$result[0]['tvSerialUserId']     
            //];
            //print_r($result[0]);
        }
        header('Content-type:application/json'); //;charset=utf-8
        //echo $_SESSION['user_login'];
        //echo $_SESSION['user_isadmin'];
        echo json_encode($result);
    } 
}