<?php
    /**
     * connects with DataBase
     * @return mysqli 
     */
    function connectToDb(){
        $config = require '../configs/db.php';
        $link = mysqli_connect($config['host'], $config['user'], $config['password'], $config['db']);
        mysqli_set_charset($link, 'utf8');
        if(!$link){
            die('DataBase connect error');

        }
        return $link;
    }
    /** 
     * selects data from DataBase 
     * @return Object or false
    */
    function selectDataInDb($sql){
        $link = connectToDb();
        $res = mysqli_query($link, $sql);
        if(!$res){
            die('There is no result. Error: '.mysqli_error($link));
        }
        return $res;
    }
    /** 
     * function to does operations insert or update or delete
     * @return Boolean
     */
    function insertUpdeteDeleteInDb($sql){
        $link = connectToDb();
        $res = mysqli_query($link, $sql);
        if(!$res){
            die(mysqli_error($link));
        }
        return $res;
    }