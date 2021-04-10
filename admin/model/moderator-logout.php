<?php
   $_SESSION['LOGIN_MODERATOR'] = null;
   unset( $_SESSION['LOGIN_MODERATOR']);
   //unset( $_SESSION['EVENT_ID']);
   
      header("Location: ../index.php");
       
?>