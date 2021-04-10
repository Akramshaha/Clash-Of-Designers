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

            $pre_event = 0;
            if(isset($_REQUEST['eve_id'])){
                $pre_event = 1;
                $pre_event_id = $_REQUEST['eve_id'];
            }else{
                $pre_event = 0;
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

            </div>
            <div class="container-fluid">

                <div class="container">
                    <div class="card mt-2">
                        <?php if($pre_event == 1): ?>
                        <form action="model/update_design_event.php" method="post">
                        <?php
                            $event_data = mysqli_query($db, "SELECT * FROM design_event WHERE id=$pre_event_id");
                            $event_data_row = mysqli_fetch_assoc($event_data);
                    

                        ?>
                        <input type="hidden" name="event_id" value="<?= $pre_event_id?>">
                            <div class="card-header bg-white text-dark text-center">
                                <strong class="card-title">Add DESIGN Event</strong>
                            </div>
                            <div class="card-body bg-dark text-light">
                                <div class="row">

                                    <div class="col-6 form-group">
                                        <label for="my-input">Event Name</label>
                                        <input id="my-input" class="form-control" type="text" name="name" value="<?=$event_data_row['name']?>">
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="my-input">Event Image</label>
                                        <input id="my-input" class="form-control" type="text" name="image" value="<?=$event_data_row['image']?>">
                                    </div>
                                    
                                </div>

                                <div class="form-group">
                                    <label for="my-textarea"><strong>Event Description</strong></label>
                                    <textarea id="my-textarea" class="form-control" name="description"><?=$event_data_row['description']?></textarea>
                                </div><hr>

                                <div class="form-group">
                                    <label for="my-textarea"><strong>Event Instructions</strong></label>
                                    <textarea id="my-textarea" class="form-control" name="instructions"><?=$event_data_row['instructions']?></textarea>
                                </div><hr>

                                <div class="form-group">
                                    <label for="my-textarea"><strong>Event Prizes</strong></label>
                                    <textarea id="my-textarea" class="form-control" name="prizes"><?=$event_data_row['prizes']?></textarea>
                                </div><hr>

                                
                                <div class="row">
                                    <div class="col-4 form-group">
                                        <label for="my-input"><strong>DURATION</strong></label>
                                        <input id="my-input" class="form-control" type="text" name="duration" value="<?=$event_data_row['duration']?>">
                                    </div>

                                    <div class="col-4 form-group">
                                        <label for="my-input"><strong>START TIME</strong></label>
                                        <input id="my-input" class="form-control" type="datetime" name="start_time" value="<?=$event_data_row['start_time']?>" >
                                    </div>

                                    <div class="col-4 form-group">
                                        <label for="my-input"><strong>END TIME</strong></label>
                                        <input id="my-input" class="form-control" type="datetime" name="end_time" value="<?=$event_data_row['end_time']?>">
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-4 form-group">
                                        <label for="my-input"><strong>REGISTRATION START TIME</strong></label>
                                        <input id="my-input" class="form-control" type="datetime" name="reg_starts" value="<?=$event_data_row['registration_starts']?>">
                                    </div>

                                    <div class="col-4 form-group">
                                        <label for="my-input"><strong>REGISTRATION END TIME</strong></label>
                                        <input id="my-input" class="form-control" type="datetime" name="reg_ends" value="<?=$event_data_row['registration_ends']?>">
                                    </div>

                                    <div class="col-4 form-group">
                                    <label for="tag1">REGISTRATIONS</label>
                                            <select name="reg" id="tag1" class="form-control">
                                                <option><?=$event_data_row['registration'] ?></option>
                                                <option value="open">OPEN</option>
                                                <option value="close">CLOSE</option>
                                            </select>
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="form-group">
                                    <button class="btn btn-lg btn-primary" type="submit">UPDATE EVENT</button>
                                </div>
                            </div>
                        </form>

                        <?php else: ?>
                        <form action="model/add_design_event.php" method="post">
                            <input type="hidden" name="admin_id" value="<?= base64_decode($_SESSION['LOGIN_ADMIN'])?>">
                            <div class="card-header bg-white text-dark text-center">
                                <strong class="card-title">Add DESIGN Event</strong>
                            </div>
                            <div class="card-body bg-dark text-light">
                                <div class="row">

                                    <div class="col-6 form-group">
                                        <label for="my-input">Event Name</label>
                                        <input id="my-input" class="form-control" type="text" name="name">
                                    </div>
                                    <div class="col-6 form-group">
                                        <label for="my-input">Event Image</label>
                                        <input id="my-input" class="form-control" type="text" name="image">
                                    </div>
                                    
                                </div>

                                <div class="form-group">
                                    <label for="my-textarea"><strong>Event Description</strong></label>
                                    <textarea id="my-textarea" class="form-control" name="description"></textarea>
                                </div><hr>

                                <div class="form-group">
                                    <label for="my-textarea"><strong>Event Instructions</strong></label>
                                    <textarea id="my-textarea" class="form-control" name="instructions"></textarea>
                                </div><hr>

                                <div class="form-group">
                                    <label for="my-textarea"><strong>Event Prizes</strong></label>
                                    <textarea id="my-textarea" class="form-control" name="prizes"></textarea>
                                </div><hr>

                                
                                <div class="row">
                                    <div class="col-4 form-group">
                                        <label for="my-input"><strong>DURATION</strong></label>
                                        <input id="my-input" class="form-control" type="text" name="duration">
                                    </div>

                                    <div class="col-4 form-group">
                                        <label for="my-input"><strong>START TIME</strong></label>
                                        <input id="my-input" class="form-control" type="datetime" name="start_time" value="0">
                                    </div>

                                    <div class="col-4 form-group">
                                        <label for="my-input"><strong>END TIME</strong></label>
                                        <input id="my-input" class="form-control" type="datetime" name="end_time" value="0">
                                    </div>

                                </div>

                                <div class="row">
                                    <div class="col-6 form-group">
                                        <label for="my-input"><strong>REGISTRATION START TIME</strong></label>
                                        <input id="my-input" class="form-control" type="datetime" name="reg_starts">
                                    </div>

                                    <div class="col-6 form-group">
                                        <label for="my-input"><strong>REGISTRATION END TIME</strong></label>
                                        <input id="my-input" class="form-control" type="datetime" name="reg_ends" value="0">
                                    </div>

                                </div>
                            </div>
                            <div class="card-footer bg-white">
                                <div class="form-group">
                                    <button class="btn btn-lg btn-primary" type="submit">ADD EVENT</button>
                                </div>
                            </div>
                        </form>
                        <?php endif; ?>
                    </div>



                </div>



            </div>

        </div>
        <!-- /#page-content-wrapper -->


    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.ckeditor.com/4.15.1/standard/ckeditor.js"></script>
    <script>
        CKEDITOR.replace( 'description' );
        CKEDITOR.replace( 'instructions' );
        CKEDITOR.replace( 'prizes' );
        $("#menu-toggle").click(function (e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
        $(document).ready(function () {
            $('#users_row').DataTable();
            dom: 'frtip'
        });
    </script>
</body>


</html>