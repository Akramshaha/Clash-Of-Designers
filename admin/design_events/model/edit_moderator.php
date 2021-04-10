<?php

include('../../model/connect-db.php');
$id = $_POST['id'];

$name = $_POST['name'];
$mail = $_POST['mail'];
$pass = $_POST['pass'];
$encryptedPass = password_hash( $pass, PASSWORD_DEFAULT);
$msg = "";
$insc = "UPDATE design_event_moderator SET
    name = '$name',
    email = '$mail',
    password = '$encryptedPass'
    WHERE id = '$id'";
if(mysqli_query($db, $insc)){
    $msg = 'Moderator Changes Successfully <br> Email:'.$mail.' <br> Password: '.$pass;

}else{
    $msg = 'Error Occured Deleted';

}
echo "<script>window.alert('$msg');window.location='../moderator';</script>";
echo "<script></script>";


?>