<?php 
    require_once '../configs/headers.php';
    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        if ($_SERVER['HTTP_ACCEPT'] === "application/xml") { 
            //strpos($_SERVER['HTTP_ACCEPT'], "application/xml") !== -1
            header("Content-Type: application/xml"); //;charset=utf-8'
            echo xmlrpc_encode(getEpisodesFromSeasonId());
        } else {
            header('Content-type:application/json'); //;charset=utf-8
            echo json_encode(getEpisodesFromSeasonId());
        }
    }
    /**
     * returns all episodes from episode's table  where seasonId is equal given value ordered by column `episodeNumber`
     * @return Object
     */
    function getEpisodesFromSeasonId(){
        require_once '../library/db.php';
        $link = connectToDb();
        $id = $_GET['seasonId'];
        $sql = "SELECT `episodeId`, `episodeName`, `episodeNumber`,  `seasonId`, `longDescription`, `shortDescription`, `featuredImage`, `videoFragmentUrl`FROM `episode` WHERE `seasonId` = $id ORDER BY `episodeNumber` ";
        $res = selectDataInDb($sql);
        if (mysqli_num_rows($res) === 0){
            die('There is no TvShows in DataBase. From getEpisodesFromSeasonId()');
        }
        $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
        mysqli_close($link);
        return $result;
    }    