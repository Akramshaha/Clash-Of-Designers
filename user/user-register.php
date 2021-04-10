<?php

if( $_SERVER["REQUEST_METHOD"] == "POST") {
    
    $arePostVarsSet = isset( $_POST['name']) && isset( $_POST['mail']) && isset( $_POST['pass']);
    $alert = "";

    if( $arePostVarsSet) {
        include('../model/connect-db.php');

        // Taking POST form variables
        $name = $_POST['name'];
        $mail = $_POST['mail'];
        $pass = $_POST['pass'];
        $encryptedPass = password_hash( $pass, PASSWORD_DEFAULT);

        // Trying to get user
        $userCheckQuery = "SELECT id FROM users WHERE mail='$mail' LIMIT 1";
        $userCheckResult = mysqli_query($db, $userCheckQuery);
        $userCheckRow = mysqli_fetch_assoc($userCheckResult);

        // if user exists
        if ($userCheckRow) {
            $alert = 'User already registered with given mail';
        } else {
            $insertUserQuery = "INSERT INTO users(name, mail, password) VALUES('$name', '$mail', '$encryptedPass')";
            $insertUserResult = mysqli_query($db, $insertUserQuery);

            if(! $insertUserResult) {
                $alert = 'Registration failed contact developers';
                $alert = mysqli_error($db);
            } else {
                session_start();
                $GetIdUserQuery = "SELECT id FROM users WHERE mail='$mail' LIMIT 1";
                $GetIdUserResult = mysqli_query($db, $GetIdUserQuery);
                $GetIdUserRow = mysqli_fetch_assoc($GetIdUserResult);

                $_SESSION['LOGIN_USER'] = base64_encode( $GetIdUserRow["id"]);
                $alert = 'Registration Successful';   
            }
        }
    } else {
        $alert = "Problem occured while login reach developers for more information";
    }
    echo "<script>window.alert('$alert'); window.location='../index.php';</script>";
}

?>