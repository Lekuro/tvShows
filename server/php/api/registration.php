<?php
    session_start();
    require_once '../configs/headers.php';
// POST
if ($_SERVER['REQUEST_METHOD'] === 'POST'){

    if ($_SERVER['HTTP_ACCEPT'] === "application/xml") { 
        //strpos($_SERVER['HTTP_ACCEPT'], "application/xml") !== -1
        header("Content-Type: application/xml"); //;charset=utf-8'
        //echo xmlrpc_encode(getData());
    } else {
        $login = $_POST['login'];
        $password = $_POST['password'];
        $isAdmin = $_POST['isAdmin'];
        require_once '../library/db.php';
        $link = connectToDb();
        $sql = "SELECT `tvSerialUserId`, `login`, `isAdmin` FROM `tvserialuser` WHERE `login` = '$login'";// and `password`='$password'
        $res = selectDataInDb($sql);
        if(mysqli_num_rows($res) === 0){
            $sql = "INSERT INTO `tvserialuser`(`login`, `password`, `isAdmin`) VALUES ('$login','$password',$isAdmin)"; 
            $inserted = insertUpdeteDeleteInDb($sql);
            if($inserted){
                $sql = "SELECT `tvSerialUserId`, `login`, `isAdmin` FROM `tvserialuser` WHERE `login` = '$login' and `password`='$password'";
                $res = selectDataInDb($sql);       
                mysqli_close($link);
                if (mysqli_num_rows($res) === 0){
                    die('Can not find registered login or password');
                }else{   
                    $result = mysqli_fetch_all($res, MYSQLI_ASSOC);    
                    $_SESSION['user_login']=$result[0]['login']; 
                    $_SESSION['user_isadmin']=$result[0]['isAdmin'];  
                    $_SESSION['user_id']=$result[0]['tvSerialUserId']; 
                    /*$_SESSION['user_data']=[
                        'login'=>$result[0]['login'],
                        'isAdmin'=>$result['0']['isAdmin'],
                        'userId'=>$result[0]['tvSerialUserId']     
                    ];*/
                    //print_r($result[0]);
                    header('Content-type:application/json'); //;charset=utf-8
                    echo json_encode($result);
                }
            } else {       
                mysqli_close($link);
                die('Do not inserted');
            } 
        } else {       
            mysqli_close($link);
            header('Content-type:application/json'); //;charset=utf-8
            echo json_encode(['errorMes'=>'This login already exists']);
        } 
    } 
}
// GET
if ($_SERVER['REQUEST_METHOD'] === 'GET'){

    if ($_SERVER['HTTP_ACCEPT'] === "application/xml") { 
        //strpos($_SERVER['HTTP_ACCEPT'], "application/xml") !== -1
        header("Content-Type: application/xml"); //;charset=utf-8'
        echo xmlrpc_encode(getData());
    } else {
        $login = $_GET['login'];
        $password = $_GET['password'];
        $isAdmin = $_GET['isAdmin'];
        require_once '../library/db.php';
        $link = connectToDb();
        $sql = "SELECT `tvSerialUserId`, `login`, `isAdmin` FROM `tvserialuser` WHERE `login` = '$login'";// and `password`='$password'
        $res = selectDataInDb($sql);
        if(mysqli_num_rows($res) === 0){
            $sql = "INSERT INTO `tvserialuser`(`login`, `password`, `isAdmin`) VALUES ('$login','$password',$isAdmin)"; 
            $inserted = insertUpdeteDeleteInDb($sql);
            if($inserted){
                $sql = "SELECT `tvSerialUserId`, `login`, `isAdmin` FROM `tvserialuser` WHERE `login` = '$login' and `password`='$password'";
                $res = selectDataInDb($sql);       
                mysqli_close($link);
                if (mysqli_num_rows($res) === 0){
                    die('Can not find registered login or password');
                }else{   
                    $result = mysqli_fetch_all($res, MYSQLI_ASSOC);    
                    $_SESSION['user_login']=$result[0]['login']; 
                    $_SESSION['user_isadmin']=$result[0]['isAdmin'];  
                    $_SESSION['user_id']=$result[0]['tvSerialUserId']; 
                    /*$_SESSION['user_data']=[
                        'login'=>$result[0]['login'],
                        'isAdmin'=>$result['0']['isAdmin'],
                        'userId'=>$result[0]['tvSerialUserId']     
                    ];*/
                    //print_r($result[0]);
                    header('Content-type:application/json'); //;charset=utf-8
                    echo json_encode($result);
                }
            } else {       
                mysqli_close($link);
                die('Do not inserted');
            } 
        } else {       
            mysqli_close($link);
            header('Content-type:application/json'); //;charset=utf-8
            echo json_encode(['errorMes'=>'This login already exists']);
        } 
    } 
}
