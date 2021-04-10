<?php
    include('../model/connect-db.php');
    include('../model/client-check.php');
    date_default_timezone_set("Asia/Kolkata");

    session_start();

    $client = new UserCheckModel();
    $isUserAuthenticated = false;
    $userId = -1;

    if( isset( $_SESSION["LOGIN_USER"]) && $client->isUserAuthenticated()) {
        $isUserAuthenticated = true;
        $userId = base64_decode($_SESSION["LOGIN_USER"]);
    } else {
        echo "<script> window.location = '../user/user-logout.php' </script>";
    }
    

    $alertMsg = "";
    if( isset($_GET["event"])) {
        $eventId = $_GET["event"];

        $eventQuery = "SELECT * FROM design_event WHERE id = $eventId LIMIT 1";
        $eventResult = mysqli_query($db, $eventQuery);
        $eventRow = mysqli_fetch_assoc($eventResult);

        $eventRegisterQuery = "SELECT * FROM design_event_registration WHERE event_id = $eventId and user_id = $userId";
        $eventRegisterResult = mysqli_query($db, $eventRegisterQuery);
        $eventRegisterRow = mysqli_fetch_assoc($eventRegisterResult);

        if($eventRegisterRow) {
            $alertMsg = "You are already registered";
        } else {
            $registerQuery = "INSERT INTO design_event_registration (user_id, event_id) VALUES('$userId', '$eventId')";
            $registerResult = mysqli_query($db, $registerQuery);
        
            $alertMsg = ($registerResult ? 'Registration Successfull' : 'Registration failed contact developers');
        }
    } else {
        $alertMsg = "Bad Request";
    }

    echo "<script> window.alert('$alertMsg'); window.location = 'info?id=$eventId' </script>";
?>