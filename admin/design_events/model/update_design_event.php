<?php

include('../../model/connect-db.php');

    $name = $_POST['name'];
    $event_id = $_POST['event_id'];
    $image = $_POST['image'];
    $description = $_POST['description'];
    $instructions = $_POST['instructions'];
    $prizes = $_POST['prizes'];
    $duration = $_POST['duration'];
    $start_time = str_replace("T"," ", $_POST['start_time']);
    $start_time .= ":00";
    $end_time = str_replace("T"," ",$_POST['end_time']);
    $end_time .= ":00";
    $reg_starts = str_replace("T"," ",$_POST['reg_starts']);
    $reg_starts .= ":00";
    $reg_ends = str_replace("T"," ",$_POST['reg_ends']);
    $reg_ends .= ":00";

    $reg = strip_tags($_POST['reg']);

    $msg = "";
    $update_design_event = "UPDATE design_event SET
    name = '$name', 
    description = '$description',
    instructions = '$instructions', 
    prizes = '$prizes', 
    duration = '$duration', 
    start_time = '$start_time', 
    end_time = '$end_time',
    image = '$image',  
    registration = '$reg',
    registration_starts = '$reg_starts', 
    registration_ends = '$reg_ends'
    WHERE id = '$event_id'";
    if(mysqli_query($db, $update_design_event)){
        $msg = 'Design Event Updted Successfully';

    }else{
        $msg = 'Error Occured Deleted';

    }
    echo "<script>window.alert('$msg');window.location='../design_events';</script>";
    echo "<script></script>";





?>