<?php
    //include('../model/google-config.php');
    include('../model/connect-db.php');
    include('../model/admin-check.php');
    

    session_start();

    $client = new AdminCheckModel();
    $isUserAuthenticated = false;

    if( isset( $_SESSION["LOGIN_ADMIN"])) {
        if( $client->isUserAuthenticated()) {
            $isUserAuthenticated = true;
        } else {
            echo "<script> window.location = '../model/admin-logout.php' </script>";
        }
    } 
    if(! $isUserAuthenticated){
        include("../model/admin-logout.php");
    }
    $preview = 0;
    if(isset($_REQUEST['event_id'])){
        $preview = 1;
        
    }else{
        $preview = 0;
    }
        
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="Description" content="Enter your description here" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
    <link rel="stylesheet" href="https:////cdn.datatables.net/1.10.23/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="assets/sidebar.css">
    <title>Admin</title>
    <style>
         #events {
            background-color: black;
            color: white;
        }
        .snapshot-div {
            height: 220px;
        }

        .snapshot {

            height: 150px;
            width: auto;
            object-fit: cover;
            background-size: cover;
        }

        .snapshot-div:hover .snapshot {
            opacity: 0.3;

        }

        .snapshot-div:hover .snapshot-preview {
            visibility: visible;
            opacity: 1;
            position: absolute;
            top: 50%;
        }

        .snapshot-preview {
            position: absolute;
            top: 0;
            bottom: 0;
            left: 0;
            right: 0;
            /* background: rgba(29, 106, 154, 0.72); */
            visibility: hidden;
            opacity: 0;
        }
    </style>
</head>

<body>
    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div class="border border-right border-dark" id="sidebar-wrapper">
            <?php include("includes/sidebar.php"); ?>
        </div>
        <!-- /#sidebar-wrapper -->

        <div id="page-content-wrapper" class="bg-light" style="width:100%">
            <?php include("includes/navbar.php"); ?>


            <div class="container justify-content-center p-3">
                <a href="events_actions" class="btn btn-primary" type="button">Add Event</a>
                <br>


                <?php if($preview == 1): ?>
                <div class="container">
                        <?php
                            $event_id = $_REQUEST['event_id'];
                            $event_i = "SELECT * FROM design_event WHERE id=$event_id";
                            $event_i_result = mysqli_query($db, $event_i);
                                           
                            $event_i_row = mysqli_fetch_assoc($event_i_result);
                        ?>
                        <div class="modal-dialog modal-xl">
                            <div class="modal-content">
                                <div class="card mb-3">
                                    <img src="<?=$event_i_row['image'] ?>" class="card-img-top" alt="...">
                                    <div class="card-header">
                                        <div class="row justify-content-between">
                                            <h5 class="card-title"><?=$event_i_row['name'] ?></h5>
                                            <span class="text-right float-right">

                                                <strong>
                                                    <?= $event_i_row['created_on'] ?>
                                                </strong>
                                            </span>

                                        </div>
                                    </div>
                                    <div class="card-body">

                                        <p class="card-text">
                                            <span>DESCRIPTION :</span> <br>
                                            <?=$event_i_row['description'] ?>

                                        </p>
                                        <hr>
                                        <p class="card-text">
                                            <span>INSTRUCTION :</span> <br>
                                            <?=$event_i_row['instructions'] ?>

                                        </p>
                                        <hr>
                                        <p class="card-text">
                                            <span>PRIZES :</span> <br>
                                            <?=$event_i_row['prizes'] ?>

                                        </p>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <strong>DURATION</strong>
                                                <p><?= $event_i_row['duration'] ?></p>
                                            </div>
                                            <div class="col-sm-4">
                                                <strong>START TIME</strong>
                                                <p><?= $event_i_row['start_time'] ?></p>
                                            </div>
                                            <div class="col-sm-4">
                                                <strong>END TIME</strong>
                                                <p><?= $event_i_row['end_time'] ?></p>
                                            </div>
                                        </div>
                                        <hr>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <strong>REGISTRATION</strong>
                                                <p>
                                                    <?php if($event_i_row['registration'] == "open"): ?>
                                                    <span class="badge badge-pill badge-success">OPEN</span>
                                                    <?php else: ?>
                                                    <span class="badge badge-pill badge-danger">CLOSED</span>
                                                    <?php endif; ?>
                                                </p>
                                            </div>
                                            <div class="col-sm-4">
                                                <strong>REGISTRATION START TIME</strong>
                                                <p><?= $event_i_row['registration_starts'] ?></p>
                                            </div>
                                            <div class="col-sm-4">
                                                <strong>REGISTRATION END TIME</strong>
                                                <p><?= $event_i_row['registration_ends'] ?></p>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                                <div class="modal-footer">
                                <a href="./events_actions?eve_id=<?=$event_i_row['id']?>" type="button" class="btn btn-primary">EDIT</a>                                    
                                <a href="./design_events" type="button" class="btn btn-primary">CLOSE</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>




                
                <div class="row">
                    
                    <?php
                    $event_info = "SELECT * FROM design_event";
                    $event_result = mysqli_query($db, $event_info);
                   
                    while($event_row = mysqli_fetch_assoc($event_result)){
                ?>

                    <div class="card col-4 mt-2 mb-2 p-1 snapshot-div bg-light" style="border:none;">

                        <div class="card-body snapshot text-center"
                            style="background-image:url(<?=$event_row['image'] ?>);">
                            <p class="mt-5 content">
                                <h3 class="text-light"><?=$event_row['name'] ?></h3>
                            </p>
                        </div>
                        <div class="snapshot-preview text-center">
                            <a href="./events_actions?eve_id=<?=$event_row['id']?>" class=" btn btn-outline-primary">EDIT</a>

                            <a href="?event_id=<?=$event_row['id']?>" class="btn btn-outline-dark" >PREVIEW</a></td>';

                            <br>
                            <?php if($event_row['registration'] == "open"): ?>
                            <span class="badge badge-pill badge-success">OPEN</span>
                            <?php else: ?>
                            <span class="badge badge-pill badge-danger">CLOSED</span>
                            <?php endif; ?>
                        </div>




                    </div>
                

                    <?php
                    }
                    ?>

                </div>
                <?php endif; ?>

            </div>
            <div class="container-fluid">

            </div>
        </div>
        <!-- /#page-content-wrapper -->


    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.min.js"></script>
<!-- 
    <script>
        $(document).ready(function () {
            $('#staticBackdrop').on('show.bs.modal', function (e) {
                var event_id = $(e.relatedTarget).data('event_id');
                $.ajax({
                    type: 'post',
                    url: 'fetch_record.php', //Here you will fetch records 
                    data: 'rowid=' + event_id, //Pass $id
                    success: function (data) {
                        $('.fetched-data').html(data); //Show fetched data from database
                    }
                });
            });
        });
    </script> -->
   
</body>


</html>