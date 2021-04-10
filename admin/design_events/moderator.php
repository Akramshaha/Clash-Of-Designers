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



        $admin_query = "SELECT * FROM design_event_moderator WHERE id=$login_admin";
        $admin_result = mysqli_query($db, $admin_query);
        $admin_row = mysqli_fetch_row($admin_result);

        if(isset($_REQUEST['did'])){
            $did = $_REQUEST['did'];
            $del_moderator = "DELETE FROM design_event_moderator WHERE id=$did";
            if(mysqli_query($db,$del_moderator)){
                $msg = 'Moderator Deleted';
            }else{
                $msg = 'Error Occured';

            }
            
        }

        $form_show = 0;
        if(isset($_REQUEST['id'])){
            $id = $_REQUEST['id'];
            $form_show = 1;
        }else{
            $form_show = 0;
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

            <div class="container">

                <?php if($form_show == 1): ?>
                <div class="tab-pane mt-2" id="signup">
                    <div class="row justify-content-center">
                        <?php
                            
                            $moderator_query = "SELECT * FROM design_event_moderator WHERE id=$id";
                            $moderator_result = mysqli_query($db, $moderator_query);
                            $moderator_row = mysqli_fetch_row($moderator_result);


                        ?>
                        <div class="col-6">
                            <div class="card">

                                <div class="card-header bg-dark text-light">
                                    <h3 class="font-italic mt-2 text-center card-title">EDIT MODERATOR</h3>

                                </div>


                                <div class="card-body">
                                    <form action="model/edit_moderator.php" method="post">
                                        <input type="hidden" name="id" value="<?php echo $moderator_row[0]; ?>">
                                        <div class="form-group">
                                            <label for="name">Name</label>
                                            <input id="name" class="form-control" type="text" name="name"
                                                value="<?php echo $moderator_row[2]; ?>">
                                        </div>
                                        <div class="form-group">
                                            <label for="email">E-mail :</label>
                                            <input id="email" class="form-control" type="text" name="mail"
                                                value="<?php echo $moderator_row[3]; ?>">
                                        </div>

                                        <div class="form-group">
                                            <label for="password">Password :</label>
                                            <input id="password" class="form-control" type="password" name="pass"
                                                value="<?php echo $moderator_row[4]; ?>">
                                        </div>

                                        <div class="form-group">
                                            <button class="btn btn-info" type="submit">Edit</button>
                                            <a href="./moderator.php" class="btn float-right btn-danger"
                                                type="reset">Cancel</a>

                                        </div>

                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <?php endif; ?>


                <div class="mt-3">
                    <table class="table row-border table-light" id="users_row">
                        <thead class="thead-dark font-italic">
                            <tr>
                                <th>id</th>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Action</th>
                            </tr>
                        </thead>

                        <tbody>
                            <?php
                                $admin_info = "SELECT * FROM design_event_moderator";
                                $admin_result = mysqli_query($db, $admin_info);
                                if(mysqli_num_rows($admin_result) > 0){
                                while($admin_row1 = mysqli_fetch_assoc($admin_result)){
                            ?>
                            <tr>
                                <td><?php echo $admin_row1['id']; ?></td>
                                <td><?php echo $admin_row1['name']; ?></td>
                                <td><?php echo $admin_row1['email']; ?></td>
                                <td class="text-center">
                                    <a class=" btn btn-sm btn-primary" href="./moderator.php?id=<?php echo $admin_row1['id']; ?>">EDIT</a>
                                    <a class="btn btn-sm btn-danger"
                                        href="./moderator.php?did=<?php echo $admin_row1['id']; ?>">DELETE</a>

                                </td>
                            </tr>
                            <?php } }?>
                        </tbody>
                    </table>

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
        $(document).ready(function () {
            $('#users_row').DataTable();

        });
    </script>
</body>

</html>