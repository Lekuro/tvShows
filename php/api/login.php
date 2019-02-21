<?php
require_once '../configs/headers.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    if ($_SERVER['HTTP_ACCEPT'] === "application/json") { 
    require_once '../library/db.php';
    $link = connectToDb();
    $login =$_POST['login'];
    $password = $_POST['password'];
    $sql = "SELECT `login`, `isAdmin` FROM `tvserialuser` WHERE `login` = '$login' AND `password` = '$password'";//`tvSerialUserId`, `password`, 
    $res = selectDataInDb($sql);
    if (mysqli_num_rows($res) === 0){
        die('There is not such login or password');
    }
    $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
    mysqli_close($link);

    header('Content-type:application/json'); //;charset=utf-8
    echo json_encode($result);
    }
}

//GET

if ($_SERVER['REQUEST_METHOD'] === 'GET'){

    if ($_SERVER['HTTP_ACCEPT'] === "application/xml") { 
        //strpos($_SERVER['HTTP_ACCEPT'], "application/xml") !== -1
        header("Content-Type: application/xml"); //;charset=utf-8'
        echo xmlrpc_encode(getData());
    } else {
        header('Content-type:application/json'); //;charset=utf-8
        echo json_encode(getData());
    } 
}
function getData(){
    require_once '../library/db.php';
    $link = connectToDb();
    $login = $_GET['login'];
    $password = $_GET['password'];
    $sql = "SELECT `login`, `isAdmin` FROM `tvserialuser` WHERE `login` = '$login' and `password`='$password'";//`tvSerialUserId`, `password`, 
    $res = selectDataInDb($sql);
    if (mysqli_num_rows($res) === 0){
        die('There is not such login or password');
    }
    $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
    mysqli_close($link);
    return $result;
}  

/*session_start();
session_reset();
if($_POST['login'] === 'user') {//db&&$_POST['passw0rd'] === 'user'
    $_SESSION["userName"] = "user";
    destroy_session
}*/
