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

    <!-- content -->

    <div class="row m-5" id="running-events">
        <div class="col-sm-8 row ">

            <div class="col-sm-12 pl-4">
                <h2> Currently Running </h2>
            </div>

            <!-- currently running events cards -->

            <?php 
            $eventQuery = "SELECT id, name, description, start_time, end_time, image, registration, image, registration_starts, registration_ends FROM design_event";
            $eventResult = mysqli_query($db, $eventQuery);
            $i = 0;

            ?>

            <?php 
            while ( $eventRow = mysqli_fetch_assoc($eventResult)) {
                $eventId = $eventRow['id'];
                $startTime=date_format(date_create_from_format("Y-m-d H:i:s", $eventRow['start_time']), "Y-m-d H:i:s");
                $endTime=date_format(date_create_from_format("Y-m-d H:i:s", $eventRow['end_time']), "Y-m-d H:i:s");
                $currentTime = date("Y-m-d H:i:s");

                if($currentTime >= $startTime && $currentTime < $endTime) { ?>

                
            <div class="col-sm-4">
                <div class="card border-0" style="width: 100%;">
                    <div class="p-3" style="width:18rem;">
                        <img class="card-img-top" src="<?php echo $eventRow['image'] ?>" alt="Card image cap">
                        <div class="card-body">
                            <h4 class="card-title"> <?php echo $eventRow['name'] ?></h4>
                            <p class="card-text">
                                Event Date :
                                <span class="badge badge-pill badge-secondary">
                                    <?php echo date_format(date_create_from_format("Y-m-d H:i:s",$eventRow['start_time']), "d M Y") ?>
                                </span>
                                <br>
                                Start Time :
                                <span class="badge badge-pill badge-secondary">
                                    <?php echo date_format(date_create_from_format("Y-m-d H:i:s",$eventRow['start_time']), "H:i:s A") ?>
                                </span>
                                <br>
                            </p>
                        </div>
                        <div class="card-footer p-0">
                            <a href="info?event=<?php echo base64_encode($eventRow['id']) ?>"
                                class="btn btn-primary w-100 h-100"> Learn More </a>
                        </div>
                    </div>
                </div>

            </div>

            <?php    
            $i++;
                }  
            }  
            ?>

<?php      
             if ( $i==0) { ?>
 
             <div class="col-sm-12">
             <div class="jumbotron jumbotron-fluid">
                 <div class="container">
                     <h1 class="h3">No Events Currently Running</h1>
                     <p class="lead">We are sorry to inform you that no events are currently running... Check out our upcoming events!</p>
                 </div>
             </div>
             <br>
         </div>
     <?php }
     ?>


<div class="row m-2">
<div class="col-sm-12 pl-4">
                <h2> Upcoming Events </h2>
            </div>

        <?php 
        $eventQuery = "SELECT id, name, description, start_time, end_time, image, registration, image, registration_starts, registration_ends FROM design_event";
        $eventResult = mysqli_query($db, $eventQuery);
        $j = 0;
    
        while ( $eventRow = mysqli_fetch_assoc($eventResult)) {
            $eventId = $eventRow['id'];
            $startTime=date_format(date_create_from_format("Y-m-d H:i:s", $eventRow['start_time']), "Y-m-d H:i:s");
            $endTime=date_format(date_create_from_format("Y-m-d H:i:s", $eventRow['end_time']), "Y-m-d H:i:s");
            $currentTime = date("Y-m-d H:i:s");

            if($currentTime < $startTime ) { ?>
        <div class="col-sm-4">
            <div class="card border-0" style="width: 18rem;">

                <div class="p-3">
                <img class="card-img-top" src="<?php echo $eventRow['image'] ?>" alt="Card image cap">
                <div class="card-body">
                    <h4 class="card-title"> <?php echo $eventRow['name'] ?></h4>
                    <p class="card-text">
                        Event Date :
                        <span class="badge badge-pill badge-secondary">
                            <?php echo date_format(date_create_from_format("Y-m-d H:i:s",$eventRow['start_time']), "d M Y") ?>
                        </span>
                        <br>
                        Start Time :
                        <span class="badge badge-pill badge-secondary">
                            <?php echo date_format(date_create_from_format("Y-m-d H:i:s",$eventRow['start_time']), "H:i:s A") ?>
                        </span>
                        <br>
                    </p>
                </div>
                <div class="card-footer p-0">
                    <a href="info?event=<?php echo base64_encode($eventRow['id']) ?>"
                        class="btn btn-primary w-100 h-100"> Learn More </a>
                </div>
                </div>
            </div>
        </div>
        <?php   
            $j++;
            }  
        } ?>
    </div>

    <?php      
             

            if ( $j==0) { ?>

        <div class="col-sm-12">
            <div class="jumbotron jumbotron-fluid">
                <div class="container">
                    <h1 class="h3">No Upcoming Events</h1>
                    <p class="lead">We are sorry to inform you that there are no events to be held... Check out our past events!</p>
                </div>
            </div>
            <br>
        </div>
    <?php }
    ?>

    </div>

        <!-- Results -->
    <div class="col-sm-4">
        <h2>Results</h2>
        <div class="w-100">
            <?php 
                $eventQuery = "SELECT id, name, description, start_time, end_time, image, registration, image, registration_starts, registration_ends FROM design_event";
                $eventResult = mysqli_query($db, $eventQuery);
                $j = 0;
            
                while ( $eventRow = mysqli_fetch_assoc($eventResult)) {
                    $eventId = $eventRow['id'];
                    $startTime=date_format(date_create_from_format("Y-m-d H:i:s", $eventRow['start_time']), "Y-m-d H:i:s");
                    $endTime=date_format(date_create_from_format("Y-m-d H:i:s", $eventRow['end_time']), "Y-m-d H:i:s");
                    $currentTime = date("Y-m-d H:i:s");
                    if($currentTime > $endTime ) { ?>


                    <div class="card mb-3" style="width: 18rem;">
                        <img src="<?php echo $eventRow['image'] ?>" class="card-img-top" alt="bannner">
                        <div class="card-body">
                        <h5 class="card-title"><?php echo $eventRow['name'] ?></h5>
                                    <p class="card-text"><?php echo substr( $eventRow['description'],0,30);  ?></p>
                                    <a href="leaderboard.php?event=<?= base64_encode($eventRow['id']) ?>" class="btn btn-sm float-right btn-primary">Leaderboard</a>
                        </div>
                    </div>

                <?php 
                    }
                }
                ?>
            </div>
        </div>
    </div>

</body>

</html>