<?php 
    require_once '../configs/headers.php';
    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        if ($_SERVER['HTTP_ACCEPT'] == "application/xml") { 
            header("Content-Type: application/xml"); //; charset=utf-8
            echo xmlrpc_encode(getAllTvShowPrioritySort());
        } else { 
            header('Content-type:application/json'); 
            echo json_encode(getAllTvShowPrioritySort());
        }
    }
    /**
     * did not use yet
     */
    function getAllTvShowPrioritySort(){
        require_once 'php/library/db.php';
        $link = connectToDb();
        $sql = "SELECT * FROM `tvshow` ORDER BY `priority` DESC, `title` ASC";
        $res = selectDataInDb($sql);
        if ($res->num_rows == 0){
            die('There is no TvShows in DataBase. From getAllTvShowPrioritySortJson()');
        }
        $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
        mysqli_close($link);
        return $result;
    }