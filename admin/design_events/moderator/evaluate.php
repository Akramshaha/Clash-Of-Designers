<?php 

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('../../model/connect-db.php');
    
    $eventId = $_POST["event_id"];
    $userId = $_POST["user_id"];
    $moderatorId = $_POST['moderator_id'];
    $uiPoints = $_POST["ui_points"];
    $uxPoints = $_POST["ux_points"];
    $colorPoints = $_POST["color_points"];
    $codePoints = $_POST["code_points"];
    $feedback = $_POST["feedback"];

    // echo $eventId. " " .$userId. " ".$moderatorId." ".$uiPoints." ".$uxPoints." ".$colorPoints." ".$codePoints;



    
    $evaluateCode = "INSERT INTO design_event_results 
    ( event_id, user_id, moderator_id, ui_points, ux_points, color_points, code_points, feedback) 
    VALUES('$eventId', '$userId', '$moderatorId', '$uiPoints', '$uxPoints', '$colorPoints', '$codePoints', '$feedback')";

    if(mysqli_query($db, $evaluateCode)){
        $msg = "result Captured";    
    }else{
        $msg ="Error Occured Please contact Developer";
    }
    echo "<script> window.alert('$msg');window.location='./users_designs.php';</script>";   
}

?>
<!-- <script>
    function windowClose() {
        window.open('','_parent','');
        window.close();
    }
</script> -->