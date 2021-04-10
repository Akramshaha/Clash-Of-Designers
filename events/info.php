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

    $eventQuery = "SELECT id, name, description, instructions, prizes, duration, start_time, end_time, image, registration, image, registration_starts, registration_ends 
        FROM design_event LIMIT 1";
    $eventResult = mysqli_query($db, $eventQuery);
    $eventRow = mysqli_fetch_assoc($eventResult);

    $eventId = $eventRow["id"];
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="../assets/styles/header.css">
</head>

<body>
<!-- header -->
<?php  include('header.php') ?>
    <!-- Content -->
    <div class="row container-fluid mx-auto px-0">
        <div class="col-md-9 px-0 mx-0">
            <div class="text-white text-center px-0"
                style="background: url('<?php echo $eventRow["image"] ?>'); background-repeat: no-repeat; background-position: center; background-size: cover; height: 40vh; width:auto;">
                <!-- <h1> <?php // echo $eventRow["name"] ?></h1> -->
            </div>
           <div class="px-4">
           <h1 class="border-bottom border-dark py-2 mb-4"><?php echo $eventRow["name"] ?></h1>
            <p class="text-justify pr-3">
                <?php echo $eventRow["description"] ?>
            </p>
            <div class="mt-4 pt-2 row">
                <div class="col-md-6">
                    <h6>START FROM</h6>
                    <h6>
                        <span class="badge badge-pill badge-secondary">
                            <?php echo date_format(date_create_from_format("Y-m-d H:i:s", $eventRow['start_time']), "d M Y") ?>
                        </span>
                        <span class="badge badge-pill badge-secondary">
                            <?php echo date_format(date_create_from_format("Y-m-d H:i:s", $eventRow['start_time']), "H:i:s A") ?>
                        </span>
                    </h6>
                </div>
                <div class="col-md-6">
                    <h6>TIME DURATION</h6>
                    <h6><?php echo $eventRow["duration"] ?></h6>
                </div>
            </div>

            <h5 class="border-bottom border-dark pb-2 mt-5">INSTRUCTION</h5>
            <p class="text-justify"> <?php echo $eventRow["instructions"] ?> </p>


            <h5 class="border-bottom border-dark pb-2 mt-5">Prizes</h5>
            <p class="text-justify">
                <?php echo $eventRow["prizes"] ?>
            </p>
           </div>
        </div>

        <div class="col-md-3 py-3" style="background-color: #D0D0D0;">

            <div class="card text-center" style="height:36vh;">
                <div class="card-body">

                    <p class="card-text">
                        <?php 
                        $eventId = $eventRow['id'];

                        $startTime=date_format(date_create_from_format("Y-m-d H:i:s", $eventRow['start_time']), "Y-m-d H:i:s");
                        $endTime=date_format(date_create_from_format("Y-m-d H:i:s", $eventRow['end_time']), "Y-m-d H:i:s");
                        $currentTime = date("Y-m-d H:i:s");
                        
                            
                        if($currentTime >= $startTime) {
                            if($currentTime < $endTime) {

                                $eventRegisterQuery = "SELECT * FROM design_event_registration WHERE event_id = $eventId and user_id = $userId";
                                $eventRegisterResult = mysqli_query($db, $eventRegisterQuery);
                                $eventRegisterRow = mysqli_fetch_assoc($eventRegisterResult);

                                // Competition Started 
                                // User Registered
                                if($eventRegisterRow) {

                                    if( $eventRegisterRow["response"]==1) {
                                        $currTimeStamp=strtotime($currentTime);
                                        $endTimeStamp=strtotime($endTime);
                                
                                        $min=floor(abs($endTimeStamp - $currTimeStamp) / (60));
                                
                                        $countDownEndTime=date("Y-m-d H:i:s", strtotime('+'.$min.'minutes', strtotime($currentTime)));
                                        $_SESSION['end_time'] = $countDownEndTime;
                                        $eventTiming = explode( " ", $endTime); 
                            ?>

                        <a href="solve?event=<?php echo $eventRow["id"] ?>" class="bg-danger text-light px-5 py-1"
                            style="border-radius: 30px;font-size: 1.2em;">START</a>
                        <?php   } 
                                    else { // User Request Not Accepted
                                        echo "<h5 class='text-dark'> You are not <br> authorized for the event </h5>";
                                    }
                                } else { // User Not Registered
                                    echo "<h5 class='text-dark'> You are not <br> registered for the event </h5>";
                                }

                            } else { // Competition Ended
                                echo "<h3 class='mb-4'> EVENT ENDED </h3>";
                            }

                        } else {
                            // Competition Isn't Started Yet
                            $eventTiming = explode( " ", $startTime);
                            echo 'Event Date : <span class="badge badge-pill badge-dark">'.date_format(date_create_from_format("Y-m-d H:i:s",$eventRow['start_time']), "d M Y").'</span> 
                            <br>';
                            echo 'Start Time : <span class="badge badge-pill badge-dark">'.date_format(date_create_from_format("Y-m-d H:i:s",$eventRow['start_time']), "H:i:s A").'</span> 
                            <br><br>';

                            $eventRegisterQuery = "SELECT * FROM design_event_registration WHERE event_id = $eventId and user_id = $userId";
                            $eventRegisterResult = mysqli_query($db, $eventRegisterQuery);
                            $eventRegisterRow = mysqli_fetch_assoc($eventRegisterResult);

                            if( $eventRegisterRow) {
                                echo "<h5 class='text-dark'> Thanks for Registration </h5>";
                            } else {
                                $regEndTime=date_format(date_create_from_format("Y-m-d H:i:s", $eventRow['registration_ends']), "Y-m-d H:i:s");

                                if($eventRow["registration"] == "open" && $currentTime < $regEndTime) {
                                    echo "<h6 class='text-dark'>
                                            <a href='register?event=".$eventRow["id"]."' class='btn btn-danger text-light px-3 py-1' style='border-radius: 20px;'>
                                                REGISTER NOW
                                            </a>
                                        </h6>
                                        
                                        <h6 style='font-size: 0.9em; line-height: 1.3em'> Registration ends on <br>"
                                            .date_format(date_create_from_format("Y-m-d H:i:s",$eventRow['registration_ends']), "d M Y").
                                            '&nbsp;&nbsp;&nbsp;&nbsp;'.
                                            date_format(date_create_from_format("Y-m-d H:i:s",$eventRow['registration_ends']), "H:i:s A").
                                        '</h6>';
                                } else {
                                    echo "<h5 class='text-dark'> Registration Ended </h5>";
                                }
                            }
                        }
                    ?>
                    </p>
                </div>
            </div>
            <!-- Walkthrough -->
            <div class="container rounded mt-3" style="background: #000000; height: 80vh;"> </div>
        </div>
    </div>

</body>

</html>