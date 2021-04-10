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
</head>

<body>

    <h1 class="text-center my-5"> Web Designing Competition System</h1>

    <div class="row m-5" id="running-events">
        <div class="col-sm-12 pl-0">
            <h2> Currently Running </h2>
            <br>
        </div>
        <?php 
            $eventQuery = "SELECT id, name, description, start_time, end_time, image, registration, image, registration_starts, registration_ends FROM design_event";
            $eventResult = mysqli_query($db, $eventQuery);
            $i = 0;

            while ( $eventRow = mysqli_fetch_assoc($eventResult)) {
                $eventId = $eventRow['id'];
                $startTime=date_format(date_create_from_format("Y-m-d H:i:s", $eventRow['start_time']), "Y-m-d H:i:s");
                $endTime=date_format(date_create_from_format("Y-m-d H:i:s", $eventRow['end_time']), "Y-m-d H:i:s");
                $currentTime = date("Y-m-d H:i:s");

                if($currentTime >= $startTime && $currentTime < $endTime) { ?>
                    <div class="col-sm-3">
                        <div class="card" style="width: 18rem;">

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
    <a href="info?event=<?php echo base64_encode($eventRow['id']) ?>" class="btn btn-primary w-100 h-100"> Learn More </a>
</div>
</div>
                        </div>
                    </div>
    <?php      
                $i++;
                }  
            }

            if ( $i==0) { ?>
             <div class="jumbotron jumbotron">
                <div class="container">
                    <h4 class="display-6 ml-0">No Events Currently Running</h4>
                    <p class="lead">We are sorry to inform you that no events are currently running... Check out our upcoming events!</p>
                </div>
            </div>
        <?php }
    ?>
    </div>

    <div class="row m-5">
        <div class="col-sm-12">
            <h2>Upcoming Events</h2>
            <br>
        </div>
        <?php 
        $eventQuery = "SELECT id, name, description, start_time, end_time, image, registration, image, registration_starts, registration_ends FROM design_event";
        $eventResult = mysqli_query($db, $eventQuery);
    
        while ( $eventRow = mysqli_fetch_assoc($eventResult)) { 
            $eventId = $eventRow['id'];
            $startTime=date_format(date_create_from_format("Y-m-d H:i:s", $eventRow['start_time']), "Y-m-d H:i:s");
            $endTime=date_format(date_create_from_format("Y-m-d H:i:s", $eventRow['end_time']), "Y-m-d H:i:s");
            $currentTime = date("Y-m-d H:i:s");

            if($currentTime < $startTime ) { ?>
                <div class="col-sm-3">
                    <div class="card" style="width: 18rem;">

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
                            <a href="info?event=<?php echo base64_encode($eventRow['id']) ?>" class="btn btn-primary w-100 h-100"> Learn More </a>
                        </div>
                    </div>
                </div>
        <?php   }  
        } ?>
    </div>

</body>

</html>