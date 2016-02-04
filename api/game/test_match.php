<?php
  include '../../session.php';
  include '../response.php';
  include '../db.php';

  header("Content-Type:application/json");

  $conn = new mysqli($db, $login, $pass, $dbname);

  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  $query = "INSERT INTO GS_MATCH (GAME, DATESTAMP) VALUES ('warcaby',NOW())";

    if (mysqli_query($conn, $query)) {
      deliver_response(201, "Success", mysqli_insert_id($conn));
    } else {
      deliver_response(400, "Query error", 232);
    }
?>
