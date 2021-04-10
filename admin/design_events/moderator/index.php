<?php
    //include('../model/google-config.php');
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
    if(isset($_REQUEST['accept'])){
        $usr_id = base64_decode($_REQUEST['accept']);
        if(mysqli_query($db, "UPDATE design_event_registration SET response=1 WHERE user_id=$usr_id")){
            echo "<script> window.location = './' </script>";
        }    
    }
    if(isset($_REQUEST['reject'])){
        $usr_id = base64_decode($_REQUEST['reject']);
        if(mysqli_query($db, "UPDATE design_event_registration SET response=-1 WHERE user_id=$usr_id")){
            echo "<script> window.location = './' </script>";
        }   
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
    <link rel="stylesheet" href="../assets/sidebar.css">
    <title>Admin</title>
    <style>
         #dashboard {
            background-color: black;
            color: white;
        }
        .cod {
            border-radius: 10px;

        }
       
    </style>
</head>
<body>
    <div class="d-flex" id="wrapper">

        <!-- Sidebar -->
        <div class="border border-right" id="sidebar-wrapper">
            <?php include("includes/sidebar.php"); ?>
        </div>
        <!-- /#sidebar-wrapper -->

        <div id="page-content-wrapper" class="bg-light" style="width:100%">
            <?php include("includes/navbar.php"); ?>
            

            <div class="container-fluid justify-content-center p-3">
                <div class="row text-light text-center font-italic">
                    <?php 
                        include("includes/query_files.php");
                    ?>
                    <div class="col-sm-3 p-4 mx-4 bg-success border border-success">
                        <div class="fa fa-user-check fa-5x "></div>
                         <br>
                            <span>REGISTERED USERS <br><?php echo $user_all; ?></span>
                    </div>
                    

                   
                    <div class="col-sm-3 p-4 mx-4 bg-warning border border-warning">
                        <div class="fa fa-user-clock fa-5x">
                            
                        </div>
                         <br>
                            <span>REGISTRATION REQUESTS <br><?php echo $user_co; ?></span>
                    </div>
                

                    <div class="col-sm-3 p-4 mx-4 bg-danger border-danger">
                        <div class="fa fa-user-alt-slash fa-5x">
                            
                        </div><br>
                        <span>DECLINE<br><?php echo $user_decline; ?></span>
                    </div>

                </div>
            </div>
            <div class="container-fluid">
                <div class="table-responsive">
                    <table class="table row-border table-light" id="users_row">
                        <thead class="thead-dark">
                            <tr>
                                <th>id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                           
                        <tbody>
                            <?php
                                $user_info = "SELECT users.*, design_event_registration.event_id,design_event_registration.user_id,design_event_moderator.event_id FROM users 
                                INNER JOIN design_event_registration,design_event_moderator  WHERE users.id = design_event_registration.user_id AND design_event_registration.event_id=design_event_moderator.event_id AND design_event_registration.response = 0";
                                $user_result = mysqli_query($db, $user_info);
                                
                                while($user_row = mysqli_fetch_assoc($user_result)){
                                
                                
                            ?>
                            <tr>
                                <td><?php echo $user_row['id']; ?></td>
                                <td><?php echo $user_row['name']; ?></td>
                                <td><?php echo $user_row['mail']; ?></td>
                                <td>
                                    <a href="./?accept=<?=base64_encode( $user_row['id'])?>" class="btn btn-sm btn-info">ACCEPT</a>
                                    <a href="./?reject=<?=base64_encode( $user_row['id'])?>" class="btn btn-sm btn-danger">REJECT</a>
                                </td>
                            </tr>
                            <?php } ?>
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->


    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.23/js/jquery.dataTables.min.js"></script>
    <script>
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
