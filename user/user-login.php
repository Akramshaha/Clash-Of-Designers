<?php 

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $arePostVarsSet = isset( $_POST['mail']) && isset( $_POST['pass']);

        if( $arePostVarsSet) {
            include('../model/connect-db.php');

            $userMail = $_POST['mail'];
            $userPassword = $_POST['pass'];
        
            $userQuery = "SELECT id, password FROM users WHERE mail = '$userMail' LIMIT 1";
            $result = mysqli_query($db, $userQuery);
            $userRow = mysqli_fetch_assoc($result);

            // if user exists
            if( $userRow) {
                session_start();

                $decryptedPass = $userRow['password'];
                
                if( password_verify( $userPassword, $decryptedPass)){
                    $_SESSION['LOGIN_USER'] = base64_encode($userRow["id"]);
                    $alertMsg = "Login Successfull";
                    $urlForward = "../events/index.php";
                } else {
                    $alertMsg = "Your login or password is invalid";
                    $urlForward = "../index.php";
                }
                    
            } else {
                $alertMsg = "You are not registered";
                $urlForward = "../index.php";
            }
            
        } else {
            $alertMsg = "Problem occured while login reach developers for more information";
        }
        echo "<script> window.alert('$alertMsg'); window.location = './$urlForward'; </script>";
    }

?>