<?php 

    if($_SERVER["REQUEST_METHOD"] == "POST") {
        include('../model/connect-db.php');

        $leaderboardQuery = "SELECT users.id, users.name, design_event_results.user_id,
                            SUM(design_event_results.ui_points) AS ui_sums, 
                            SUM(design_event_results.ux_points) AS ux_sums,
                            SUM(design_event_results.color_points) AS color_sums, 
                            SUM(design_event_results.code_points) AS code_sums
                         FROM users, design_event_results WHERE design_event_results.user_id=users.id GROUP BY design_event_results.user_id";
        
        $leaderboardResults = mysqli_query($db, $leaderboardQuery);

        $returningObj = new \stdClass();
        $leaderboardArr = array();

        $i = 0;
        while($leaderboardRow = mysqli_fetch_assoc( $leaderboardResults)){
            $totalPoints = $leaderboardRow['ui_sums'] + $leaderboardRow['ux_sums'] + $leaderboardRow['color_sums'] + $leaderboardRow['code_sums'];
            
            $userObj = new \stdClass();

            $userId = $leaderboardRow['id'];
            $userObj->num = $i;
            $userObj->id = $userId;
            $userObj->name = $leaderboardRow['name'];
            $userObj->ui = $leaderboardRow['ui_sums'];
            $userObj->ux = $leaderboardRow['ux_sums'];
            $userObj->color = $leaderboardRow['color_sums'];
            $userObj->code = $leaderboardRow['code_sums'];
            $userObj->points = $totalPoints;

            array_push( $leaderboardArr, $userObj);
        }

        $returningObj->leaderboard = $leaderboardArr;
        echo json_encode($returningObj);
    }

?>