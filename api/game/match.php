<?php
  include '../../session.php';
  include '../response.php';
  include '../db.php';

  $conn = new mysqli($GLOBALS['db'], $GLOBALS['login'], $GLOBALS['pass'], $GLOBALS['dbname']);

  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  $query = "SELECT MATCH_ID, DATESTAMP, ELO_FOR_MATCH FROM GS_PARTICIPANT, GS_MATCH WHERE GS_PARTICIPANT.MATCH_ID = GS_MATCH.ID AND GAME='".$_GET['game']."' AND USER_ID = '".$_GET['user']."' ORDER BY DATESTAMP DESC";
  $result = $conn->query($query);

  $array = array();
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        array_push($array, array('MATCH' => $row['MATCH_ID'], 'DATE' => $row['DATESTAMP'], 'ELO' => $row['ELO_FOR_MATCH']));
    }
  }

  deliver_response(200, 'Games', $array);
?>
