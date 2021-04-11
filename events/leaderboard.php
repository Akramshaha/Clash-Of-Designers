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

    if(isset($_REQUEST['event'])){
        $event_id = base64_decode($_REQUEST['event']);
    }
    
    $eventQuery = "SELECT * FROM design_event WHERE id=$event_id";
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
        <div class="col-md-7 px-0 mx-0">
            <div class="text-white text-center px-0"
                style="background: url('<?php echo $eventRow["image"] ?>'); background-repeat: no-repeat; background-position: center; background-size: cover; height: 40vh; width:auto;">
                <!-- <h1> <?php // echo $eventRow["name"] ?></h1> -->
            </div>
           <div class="px-5 py-2">
           <div class="justify-content-between border-bottom border-dark">
           
                <span class="h2 py-2 mb-4"><?php echo $eventRow["name"] ?></span>
                <span class="h4 py-2 mb-4"><?php echo $eventRow["duration"] ?></span>
           </div>

            <p class="text-justify pr-3">
                <?php echo $eventRow["description"] ?>
            </p>

            <h5 class="border-bottom border-dark pb-2 mt-5">INSTRUCTION</h5>
            <p class="text-justify"> <?php echo $eventRow["instructions"] ?> </p>


            <h5 class="border-bottom border-dark pb-2 mt-5">Prizes</h5>
            <p class="text-justify">
                <?php echo $eventRow["prizes"] ?>
            </p>
           </div>
        </div>

        <div class="col-md-5 py-3" style="background-color: #D0D0D0;">

            <div class="card" style="height:100vh;">
                <!-- <div class="card-body">

                    <p class="card-text">
                        
                    </p>
                </div> -->
               

                <table class="table table-light">
                    <thead class="thead-dark text-center">
                        <tr>
                            <th>Name</th>
                            <th>Points</th>
                        </tr>
                    </thead>
                    <tbody class="bg-light">
                    <?php
                        $codeResults = "SELECT users.id, users.name, design_event_results.user_id , 
                                        SUM(design_event_results.ui_points)AS ui_sums , 
                                        SUM(design_event_results.ux_points) AS ux_sums,
                                        SUM(design_event_results.color_points)AS color_sums , 
                                        SUM(design_event_results.code_points) AS code_sums
                         FROM users,design_event_results WHERE design_event_results.user_id=users.id GROUP BY design_event_results.user_id";
                        $codeQuery = mysqli_query($db, $codeResults);
                        while($codeRow = mysqli_fetch_assoc($codeQuery)){
                            $totalpoints = $codeRow['ui_sums']+$codeRow['ux_sums']+$codeRow['color_sums']+$codeRow['code_sums'];
                    ?>
                        <tr>
                            <td><?= $codeRow['name'] ?></td>
                            <td><?= $totalpoints ?></td>
                        </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                    <tfoot class="bg-dark text-center text-light">
                        <tr>
                            <th>#</th>
                            <th>#</th>
                        </tr>
                    </tfoot>
                </table>
            </div>
            
        </div>
    </div>

</body>

</html>

