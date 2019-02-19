<?php 
    require_once '../configs/headers.php';
    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        if ($_SERVER['HTTP_ACCEPT'] === "application/xml") { 
            //strpos($_SERVER['HTTP_ACCEPT'], "application/xml") !== -1
            header("Content-Type: application/xml"); //;charset=utf-8'
            echo xmlrpc_encode(getAllTvShowTitleSort());
        } else {
            header('Content-type:application/json'); //;charset=utf-8
            echo json_encode(getAllTvShowTitleSort());
        }
    }
    /**
     * returns all shows from tvShow's table  ordered by column title
     * @return Object
     */
    function getAllTvShowTitleSort(){
        require_once '../library/db.php';
        $link = connectToDb();
        //$sql = "SELECT * FROM `tvshow` ORDER BY `title`";
        $sql = "SELECT `tvShowId`, `title`, `subtitle`, `startDate`, `posterImage`, `longDescription`, `shortDescription`, `priority`, `videoFragmentUrl` FROM `tvshow` ORDER BY `title`";
        $res = selectDataInDb($sql);
        if ($res->num_rows == 0){
            die('There is no TvShows in DataBase. From getAllTvShowTitleSortJson()');
        }
        $TvShows = mysqli_fetch_all($res, MYSQLI_ASSOC);
        mysqli_close($link);
        return $TvShows;
    } 