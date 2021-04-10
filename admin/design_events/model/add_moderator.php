<?php

include('../../model/connect-db.php');
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $arePostVarsSet = isset( $_POST['name']) && isset( $_POST['mail']) && isset( $_POST['pass']);

    $alert = "";

    if( $arePostVarsSet) {

        $name = $_POST['name'];
        $mail = $_POST['mail'];
        $pass = $_POST['pass'];
        $event_id = strip_tags($_POST['event']);
        $encryptedPass = password_hash( $pass, PASSWORD_DEFAULT);
        

        $adminCheckQuery = "SELECT * FROM design_event_moderator WHERE email='$mail' AND event_id=$event_id";
        $adminCheckResult = mysqli_query($db, $adminCheckQuery);
        $adminCheckRow = mysqli_fetch_assoc($adminCheckResult);

        if ($adminCheckRow) { 
            $alert = 'Moderator already exist with given mail';
        } else {
            $insertAdminQuery = "INSERT INTO design_event_moderator(event_id, name, email, password) VALUES('$event_id', '$name', '$mail', '$encryptedPass')";
            $insertAdminResult = mysqli_query($db, $insertAdminQuery);

            if(! $insertAdminResult) {
                $alert = 'Registration failed contact developers';
                // $log->userLog( 'Login Register', 'Email', 'Email Register', -1, 'User Registeration Failed', 0, "");
                // $alert = trigger_error("there was an error....".$db->error, E_USER_WARNING);
            } else {
                
                
                $alert = 'Moderator Registered Successful<br>Email:'.$mail.'<br>Password:'.$pass;   
               
                // $log->userLog( 'Login Register', 'Email', 'Email Register', -1, 'User Registered', 1, "");
            }
        }

    }else {
        $alert = "Problem occured while Adding Moderator reach developers for more information";
        // $log->userLog( 'Login Register', 'Email', 'Email Register', -1, 'Post vars are not set', 0, "");
    }
    echo "<script>window.alert('$alert'); window.location='../moderator.php';</script>";


}

?>