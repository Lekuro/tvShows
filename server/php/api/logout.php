<?php
    session_start();
    require_once '../configs/headers.php';
    
    //print_r($_POST['login']);
    if($_POST['login']===$_SESSION['user_login']){
        unset( $_SESSION['user_login'] );
        unset( $_SESSION['user_isadmin'] );
        $result=['resultMes'=>'This session is unset!'];

    } else {
        $result=['errorMes'=>'There is not such login in this session'];
    }
    echo json_encode($result);
    // header('Content-type:application/json'); //;charset=utf-8
    // echo json_encode([
    //     'user_login'=>$_SESSION['user_login'],
    //     'user_isadmin'=>$_SESSION['user_isadmin']
    // ]);


    //https://www.tutorialspoint.com/php/php_sessions.htm
    /*The location of the temporary file is determined by a setting in the php.ini file called session.save_path. 
    Before using any session variable make sure you have setup this path.*/