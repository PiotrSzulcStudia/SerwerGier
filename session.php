<?php
  session_start();
/*  $_SESSION['CurrentUser'] = "kkragoth";
*/
  $isUserLoggedIn = isset($_SESSION['CurrentUser']);
  $currentUser = $_SESSION['CurrentUser'];
  
  $isAdmin = false;
?>
