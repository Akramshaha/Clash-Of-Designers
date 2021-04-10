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
    $start_time = $_POST['start_time'];
    $end_time = $_POST['end_time'];
    $reg_starts = $_POST['reg_starts'];
    $reg_ends = $_POST['reg_ends'];


    
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