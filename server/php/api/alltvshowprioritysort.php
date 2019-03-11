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
        require_once '../library/db.php';
        $link = connectToDb();//"SELECT * FROM `tvshow` ORDER BY `priority` DESC, `title` ASC";
        $sql =        "SELECT tvshow.tvShowId, tvshow.title, tvshow.subtitle, tvshow.startDate, tvshow.posterImage, tvshow.longDescription, 
                tvshow.shortDescription, tvshow.priority, tvshow.videoFragmentUrl, ratings.ratingValue FROM tvshow
                LEFT JOIN  (SELECT  `tvShowId`, ROUND(SUM(`ratingValue`)/COUNT(`ratingValue`), 1) AS ratingValue FROM `rating` 
                WHERE NOT `tvShowId`='NULL' GROUP BY `tvShowId`) as ratings
                ON tvshow.tvShowId = ratings.tvShowId ORDER BY tvshow.priority DESC, tvshow.title  ASC";
        $res = selectDataInDb($sql);
        if ($res->num_rows == 0){
            die('There is no TvShows in DataBase. From getAllTvShowPrioritySortJson()');
        }
        $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
        mysqli_close($link);
        return $result;
    }