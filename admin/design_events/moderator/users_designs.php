<?php
    include('../../model/connect-db.php');
    include('../../model/moderator-check.php');
    

    session_start();

    $client = new ModeratorCheckModel();
    $isUserAuthenticated = false;
    
    if( isset( $_SESSION["LOGIN_MODERATOR"])) {
        if( $client->isUserAuthenticated()) {
            $isUserAuthenticated = true;
        } else {
            echo "<script> window.location = '../../model/moderator-logout.php' </script>";
        }
    } 
    if(! $isUserAuthenticated){
        include("../../model/moderator-logout.php");
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
    <link rel="stylesheet" href="../assets/sidebar.css">
    <title>Moderator</title>
    <style>
        #designs {
            background-color: black;
            color: white;
        }
        .snapshot {
            height: 200px;
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


        <div class="border border-right border-dark" id="sidebar-wrapper">
            <?php include("includes/sidebar.php"); ?>
        </div>
        <!-- /#sidebar-wrapper -->

        <div id="page-content-wrapper" class="bg-light" style="width:100%">
            <?php include("includes/navbar.php"); ?>

            <br>
            <div class="row">
                <?php
                    
                    $user_info = "SELECT DISTINCT design_event_codes.*, design_event_moderator.event_id FROM design_event_codes,design_event_moderator WHERE design_event_moderator.event_id=design_event_codes.event_id ";
                    $user_result = mysqli_query($db, $user_info);
                    $i = 1;
                    while($user_row = mysqli_fetch_assoc($user_result)){
                        $resultCode = "SELECT * FROM design_event_results WHERE user_id = ".$user_row['user_id']." AND moderator_id = ".base64_decode($_SESSION["LOGIN_MODERATOR"])."";
                        $codeResult = mysqli_query($db, $resultCode);
                        if(mysqli_num_rows($codeResult) <= 0){
                        // if($resultRow['user_id'] != $user_row['user_id'] && $resultRow['moderator_id'] != base64_decode($_SESSION["LOGIN_MODERATOR"])){


                ?>

                <div class="card col-3 m-2 ml-4 snapshot-div p-0" style="border:none;">
                    <a href="preview.php?code_id=<?php echo base64_encode($user_row['id']); ?>">
                        <div class="card-body snapshot border p-0 border-dark"
                            style="background-image:url(<?=$user_row['output_placeholder'] ?>);">

                        </div>
                        <div class="snapshot-preview text-center"><span class=" btn btn-outline-dark">CLICK TO
                                EVALUATE</span> </div>
                    </a>
                    <span class="m-auto h4"> <?php echo /* $user_row["name"] */ "Design ".$i; ?> </span>
                </div>

                <?php
                        $i++;
                    }
                }
                    ?>

            </div>



        </div>

    </div>
    <!-- /#page-content-wrapper -->


    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script>
        $("#menu-toggle").click(function (e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
</body>

</html>