<?php
  include '../../session.php';
  include '../response.php';
  include '../db.php';

  $conn = new mysqli($GLOBALS['db'], $GLOBALS['login'], $GLOBALS['pass'], $GLOBALS['dbname']);

  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  $query = "SELECT * FROM GS_LEADERBOARD WHERE USER='".$_GET['user']."' ORDER BY ELO DESC";
  $result = $conn->query($query);

  $array = array();
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        array_push($array, array('GAME' => $row['GAME'], 'ELO' => $row['ELO']));
    }
  }

  deliver_response(200, 'Games', $array);
?>
