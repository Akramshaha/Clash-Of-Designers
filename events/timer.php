<?php 

if( $_SERVER["REQUEST_METHOD"] == "POST") {
    session_start();
    date_default_timezone_set("Asia/Kolkata");

    $from_time1 = date("Y-m-d H:i:s");
    $to_time1 = $_SESSION["end_time"];

    $timefirst = strtotime($from_time1);
    $timesecond = strtotime($to_time1);

    $diffinsec = $timesecond-$timefirst;

    $hour = (int) gmdate("H", $diffinsec);
    $min = (int) gmdate("i", $diffinsec);
    $sec = (int) gmdate("s", $diffinsec);

    // Object for sending response as JSON
    $ajaxResponse = json_decode('{ "countdown" : "'.gmdate("H:i:s", $diffinsec).'", "end" : false }', TRUE);

    if( $hour==0 && $min==0 && $sec==0) {
        $ajaxResponse["end"] = true;
    }

    echo json_encode($ajaxResponse); 
}
?>