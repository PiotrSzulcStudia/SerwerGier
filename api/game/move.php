<?php
  include '../../session.php';
  include '../response.php';
  include '../db.php';

  header("Content-Type:application/json");

  $conn = new mysqli($GLOBALS['db'], $GLOBALS['login'], $GLOBALS['pass'], $GLOBALS['dbname']);

  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  $query = "INSERT INTO GS_HISTORY (USER_ID, MATCH_ID, TURN, DESCRIPTION, DATESTAMP)
  VALUES ('".$_POST['user']."',
    ".$_POST['id'].",
    ".$_POST['turn'].",
    '".$_POST['desc']."',
    NOW())";

    if (mysqli_query($conn, $query)) {
      deliver_response(201, "Success", mysqli_insert_id($conn));
    } else {
      deliver_response(400, "Query error", 232);
    }
?>
