<?php

include('./connect-db.php');
$id = $_REQUEST['id'];


$insc = "UPDATE users SET
    request = 2 WHERE id = '$id'";
if(mysqli_query($db, $insc)){
    $msg = "Request Rejected";

}else{
    $msg = "Error Occured Deleted";

}
echo "<script>window.alert('.$msg');window.location = '../super/requested_users.php'</script>";


?>