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
    if(isset($_REQUEST['accept'])){
        $usr_id = base64_decode($_REQUEST['accept']);
        if(mysqli_query($db, "UPDATE design_event_registration SET response=1 WHERE user_id=$usr_id")){
            echo "<script> window.location = './requested_users' </script>";
        }    
    }
    if(isset($_REQUEST['reject'])){
        $usr_id = base64_decode($_REQUEST['reject']);
        if(mysqli_query($db, "UPDATE design_event_registration SET response=-1 WHERE user_id=$usr_id")){
            echo "<script> window.location = './requested_users' </script>";
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
    <link rel="stylesheet" href="assets/sidebar.css">
    <title>Admin</title>
    <style>
         #users {
            background-color: black;
            color: white;
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

        <div id="page-content-wrapper" style="width:100%">
            <?php include("includes/navbar.php"); ?>
            

            <div class="container justify-content-center m-1">
                
            </div>
            <div class="container-fluid m-2">
                <div class="table-responsive">
                    <table class="table row-border table-light" id="users_row">
                        <thead class="thead-dark">
                            <tr>
                                <th>id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                           
                        <tbody>
                            <?php
                                $user_info = "SELECT users.*, design_event_registration.user_id,design_event_registration.response FROM users 
                                INNER JOIN design_event_registration  WHERE users.id = design_event_registration.user_id AND design_event_registration.response!=0";
                                $user_result = mysqli_query($db, $user_info);
                                while($user_row = mysqli_fetch_assoc($user_result)){
                            ?>
                            <tr>
                                <td><?php echo $user_row['id']; ?></td>
                                <td><?php echo $user_row['name']; ?></td>
                                <td><?php echo $user_row['mail']; ?></td>
                                <td>
                                    <?php if($user_row['response'] == 1): ?>
                                        <span class="badge badge-pill badge-success">accepted</span>
                                    <?php elseif($user_row['response'] == -1): ?>
                                        <span class="badge badge-pill badge-danger">rejected</span>
                                    <?php endif; ?>

                    
                                
                                </td>
                                <td>
                                     <?php if($user_row['response'] == 1): ?>
                                        <a href="./requested_users?reject=<?=base64_encode( $user_row['id'])?>" class="btn btn-sm btn-danger ">REJECT</a>
                                    <?php elseif($user_row['response'] == -1): ?>
                                        <a href="./requested_users?accept=<?=base64_encode( $user_row['id'])?>" class="btn btn-sm btn-success ">ACCEPT</a>
                                    <?php endif; ?> 
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
