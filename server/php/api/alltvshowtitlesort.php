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
     * returns all shows from tvShow's table ordered by column `title`
     * @return Object
     */
    function getAllTvShowTitleSort(){
        require_once '../library/db.php';
        $link = connectToDb();
        //$sql = "SELECT * FROM `tvshow` ORDER BY `title`";
        //only tvShow data without rating
        //$sql = "SELECT `tvShowId`, `title`, `subtitle`, `startDate`, `posterImage`, `longDescription`, `shortDescription`, `priority`, `videoFragmentUrl` FROM `tvshow` ORDER BY `title`";
        // ratings('tvShowId', 'ratingValue')
        //$sql = "SELECT  `tvShowId`, ROUND(SUM(`ratingValue`)/COUNT(`ratingValue`), 1) AS ratingValue FROM `rating` 
        //       WHERE NOT `tvShowId`='NULL' GROUP BY `tvShowId`";
        //all tvShow data and ratingValue
        $sql = "SELECT tvshow.tvShowId, tvshow.title, tvshow.subtitle, tvshow.startDate, tvshow.posterImage, tvshow.longDescription, 
                tvshow.shortDescription, tvshow.priority, tvshow.videoFragmentUrl, ratings.ratingValue FROM tvshow
                LEFT JOIN  (SELECT  `tvShowId`, ROUND(SUM(`ratingValue`)/COUNT(`ratingValue`), 1) AS ratingValue FROM `rating` 
                WHERE NOT `tvShowId`='NULL' GROUP BY `tvShowId`) as ratings
                ON tvshow.tvShowId = ratings.tvShowId ORDER BY tvshow.title";
        $res = selectDataInDb($sql);
        if ($res->num_rows == 0){
            die('There is no TvShows in DataBase. From getAllTvShowTitleSortJson()');
        }
        $TvShows = mysqli_fetch_all($res, MYSQLI_ASSOC);
        //print_r($TvShows);
        mysqli_close($link);
        return $TvShows;
    } 