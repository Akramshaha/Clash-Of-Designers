<?php
   include('../model/connect-db.php');
   include('../model/admin-check.php');
   

   session_start();

   $client = new AdminCheckModel();
   $isUserAuthenticated = false;

   if( isset( $_SESSION["LOGIN_ADMIN"])) {
       if( $client->isUserAuthenticated()) {
           $login_admin = base64_decode($_SESSION["LOGIN_ADMIN"]);
           $isUserAuthenticated = true;
       } else {
           echo "<script> window.location = '../model/admin-logout.php' </script>";
       }
   } 

   if(! $isUserAuthenticated){
       include("../model/admin-logout.php");
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
    <title>Moderator</title>
    <style>
         #moderators {
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

        <div id="page-content-wrapper">

            <?php include("includes/navbar.php"); ?>

            <div class="container-fluid">
                <div class="tab-pane mt-2" id="signup">
                    <div class="row justify-content-center">
                        <div class="col-6">
                            <div class="card">

                                <div class="card-header bg-dark text-light">
                                    <h3 class="font-italic mt-2 text-center card-title">ADD MODERATOR</h3>

                                </div>


                                <div class="card-body">
                                    <form action="model/add_moderator.php" method="post">
                                        <div class="form-group">
                                            <label for="tag1">Section Event</label>
                                            <select name="event" id="tag1" class="form-control">
                                                <option>Select</option>
                                                <?php
                                                    $design_event_result = "SELECT * FROM design_event";
                                                    $design_event = mysqli_query($db, $design_event_result);
                                                    
                                                ?>
                                                <?php foreach($design_event as $key => $value){ ?>
                                                <option value="<?= $value['id'];?>"><?= $value['name']; ?></option>
                                                <?php } ?>
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input id="name" class="form-control" type="text" name="name">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">E-mail :</label>
                                            <input id="email" class="form-control" type="text" name="mail">
                                        </div>

                                        <div class="form-group">
                                            <label for="password">Password :</label>
                                            <input id="password" class="form-control" type="password" name="pass">
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-lg btn-info" type="submit">ADD</button>
                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /#page-content-wrapper -->


    </div>




    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.min.js"></script>
    <script>
        $("#menu-toggle").click(function (e) {
            e.preventDefault();
            $("#wrapper").toggleClass("toggled");
        });
    </script>
</body>

</html>