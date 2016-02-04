<?php
  include '../../session.php';
  include '../response.php';
  include '../db.php';

  function authenticate()
  {
    if (empty($_POST['email'])) {
      return false;
    }

    if (empty($_POST['password'])) {
      return false;
    }

    $conn = new mysqli($GLOBALS['db'], $GLOBALS['login'], $GLOBALS['pass'], $GLOBALS['dbname']);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "SELECT NICKNAME FROM GS_USER WHERE EMAIL='".$_POST['email']."' AND PASSWORD='".sha1($_POST['password'])."'";

    $result = $conn->query($query);

    if ($result->num_rows == 1)
    {
      $row = mysqli_fetch_assoc($result);
      deliver_response(201, $query, $row['NICKNAME']);
      return true;
    }
    else
    {
      return false;
    }
  }

  if (!authenticate()) {
    deliver_response();
  }
/*
$query = "SELECT NICKNAME FROM GS_USER WHERE EMAIL='".$_POST['email']."' AND PASSWORD='".sha1($_POST['password'])."'";

  deliver_response(201, $query, $_POST['name']);*/
?>
