<?php
  include '../../session.php';
  include '../response.php';
  include '../db.php';

  header("Content-Type:application/json");

  $conn = new mysqli($GLOBALS['db'], $GLOBALS['login'], $GLOBALS['pass'], $GLOBALS['dbname']);

  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  $query = "UPDATE GS_PARTICIPANT SET ELO_FOR_MATCH=".$_POST['elo']." WHERE USER_ID='".$_POST['user']."' AND MATCH_ID=".$_POST['id'];

    if (mysqli_query($conn, $query)) {

      $ifempty = "SELECT * FROM GS_LEADERBOARD WHERE USER='".$_POST['user']."' AND GAME='".$_POST['game']."'";
      $result = $conn->query($ifempty);
      if ($result->num_rows == 0)
      {
        $new = "INSERT INTO GS_LEADERBOARD(USER, GAME, ELO) VALUES (
          '".$_POST['user']."',
          '".$_POST['game']."',
          600)";

        if (!mysqli_query($conn, $new))
          deliver_response(400, "bad", 4);
      }

      $update = "UPDATE GS_LEADERBOARD SET ELO = ELO + ".$_POST['elo']." WHERE GAME = '".$_POST['game']."' AND USER = '".$_POST['user']."'";

      if (mysqli_query($conn, $update))
        deliver_response(201, "Success", 0);
      else {
        deliver_response(400, "Leaderboard Query Error", $update);
      }
    } else {
      deliver_response(400, "Query error", $query);
    }
?>
