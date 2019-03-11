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
        //print_r($id);
        //only season data without rating
        // $sql = "SELECT `seasonId`, `seasonName`, `seasonNumber`, `tvShowId`, `longDescription`, `shortDescription`, `featuredImage`, 
        //  `videoFragmentUrl` FROM `season` WHERE `tvShowId` = $id ORDER BY `seasonNumber` ";
        // ratings('tvShowId', 'ratingValue')
        // $sql = "SELECT  `seasonId`, ROUND(SUM(`ratingValue`)/COUNT(`ratingValue`), 1) AS ratingValue FROM `rating` 
        //         WHERE NOT `seasonId`='NULL' GROUP BY `seasonId`";
        //all tvShow data and ratingValue
        $sql = "SELECT season.seasonId, season.seasonName, season.seasonNumber, season.tvShowId, season.longDescription, 
                season.shortDescription, season.featuredImage, season.videoFragmentUrl, ratings.ratingValue 
                FROM season, (SELECT  `seasonId`, ROUND(SUM(`ratingValue`)/COUNT(`ratingValue`), 1) AS ratingValue FROM `rating` 
                WHERE NOT `seasonId`='NULL' GROUP BY `seasonId`) as ratings
                WHERE season.tvShowId = $id AND season.seasonId = ratings.seasonId ORDER BY season.seasonNumber;";                
        $res = selectDataInDb($sql);
        if (mysqli_num_rows($res) === 0){
            $result = ['resultMes'=>'There is no season yet!'];
        } else {
            $result = mysqli_fetch_all($res, MYSQLI_ASSOC);
        }
        mysqli_close($link);
        return $result;
    }    