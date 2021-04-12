<?php
    include('model/connect-db.php');
    include('model/client-check.php');

    session_start();

    $client = new UserCheckModel();
    $isUserAuthenticated = false;

    if( isset( $_SESSION["LOGIN_USER"])) {
        if( $client->isUserAuthenticated()) {
            $isUserAuthenticated = true;
        } else {
            echo "<script> window.location = 'user/user-logout.php' </script>";
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
    <link rel="stylesheet" href="./assets/styles/profile-util.css">
    <title>Login & Register</title>
</head>

<body>

    <!-- Login Pane -->
    <div id="loginModel" class="mt-5">
        <div class="div-center form1">
            <form action="user/user-login" method="post" class="px-5 pt-4 pb-4 rounded">
                <div class="div-center">
                    <img src="./assets/images/logo.png" alt="logo" style="height: 80px; width: auto;">
                </div><br>
                <h2 class="div-center" style="font-family: hacked;"> CLASH OF DESIGNERS </h2>
                <br> <input type="text" class="form-control" name="mail" size="40" required
                    placeholder="Enter Your Email"> <br>
                <input type="password" class="form-control" name="pass" required placeholder="Enter Your Password">
                <br>

                <div class="div-center">
                    <input type="submit" class="px-4 border login" value="login">
                </div>

                <a href="#" onclick="openRegister()" class="text-dark mt-4 div-center"> Not Registered? Create an
                    account </a>
            </form>
        </div>
    </div>


    <!-- Register Pane -->
    <div id="registerModel" class="mt-5">
        <div class="div-center form1">
            <form action="user/user-register" method="post" class="px-5 pt-4 pb-4 rounded">
                <div class="div-center">
                    <img src="./assets/images/logo.png" alt="logo" style="height: 80px; width: auto;">
                </div><br>
                <h2 class="div-center" style="font-family: hacked;"> CLASH OF DESIGNERS </h2>
                <br> 
                
                <input type="text" class="form-control" name="name" required placeholder="Enter Your Name"> <br>

                <input type="text" class="form-control" name="mail" size="40" required placeholder="Enter Your Email"> <br>

                <input type="password" class="form-control" name="pass" required placeholder="Enter Your Password">
                <br>

                <div class="div-center">
                    <input type="submit" class="px-4 border login" value="register">
                </div>

                <a href="#" onclick="openLogin()" class="text-dark mt-4 div-center">  Already register? Login here </a>
            </form>
        </div>
    </div>

</body>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.1/umd/popper.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.5.3/js/bootstrap.min.js"></script>

<script>
    function openRegister(){
        document.getElementById('loginModel').style.display = "none";
        document.getElementById('registerModel').style.display = "block";
    }

    function openLogin(){
        document.getElementById('loginModel').style.display = "block";
        document.getElementById('registerModel').style.display = "none";
    }
</script>

</html>