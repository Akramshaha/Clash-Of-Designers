<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    include('../../model/connect-db.php');
    
    $name = $_POST['name'];
    $admin_id = $_POST['admin_id'];
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


    
        $design_event = "INSERT INTO design_event 
        ( name, description,instructions, prizes, duration, start_time, end_time,image,  registration_starts, registration_ends, created_by) 
        VALUES('$name','$description','$instructions','$prizes','$duration','$start_time','$end_time', '$image','$reg_starts','$reg_ends', '$admin_id')";

        if(mysqli_query($db, $design_event)){
            $msg = "Design Event Added successfully";    
        }else{
            $msg ="Design Event Not Added";
        }
        echo "<script>window.alert('$msg');window.location = '../design_events'</script>";   
}
?>