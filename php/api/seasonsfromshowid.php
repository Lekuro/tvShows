<?php 
    require_once '../configs/headers.php';
    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        if ($_SERVER['HTTP_ACCEPT'] === "application/xml") { 
            //strpos($_SERVER['HTTP_ACCEPT'], "application/xml") !== -1
            header("Content-Type: application/xml"); //;charset=utf-8'
            echo xmlrpc_encode(getSeasonsFromTvShowId());
        } else {
            header('Content-type:application/json'); //;charset=utf-8
            echo json_encode(getSeasonsFromTvShowId());
        }
    }
    /**
     * returns all seasons from season's table  where tvShowId is equal given value ordered by column `seasonNumber`
     * @return Object
     */
    function getSeasonsFromTvShowId(){
        require_once '../library/db.php';
        $link = connectToDb();
        $id = $_GET['tvShowId'];
        $sql = "SELECT `seasonId`, `seasonName`, `seasonNumber`, `tvShoowId`, `longDescription`, `shortDescription`, `featuredImage`,  `videoFragmentUrl` FROM `season` WHERE `tvShoowId` = $id ORDER BY `seasonNumber` ";
        $res = selectDataInDb($sql);
        if (mysqli_num_rows($res) === 0){
            die('There is no TvShows in DataBase. From getSeasonsFromTvShowId()');
        }
        $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
        mysqli_close($link);
        return $result;
    }    