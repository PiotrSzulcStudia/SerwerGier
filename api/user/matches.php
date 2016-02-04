<?php
  include '../../session.php';
  include '../response.php';
  include '../db.php';

  $conn = new mysqli($GLOBALS['db'], $GLOBALS['login'], $GLOBALS['pass'], $GLOBALS['dbname']);

  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  $query = "SELECT GAME, MATCH_ID, DATESTAMP, ELO_FOR_MATCH FROM GS_PARTICIPANT, GS_MATCH WHERE MATCH_ID = ID AND USER_ID = '".$_GET['user']."' ORDER BY DATESTAMP DESC";
  $result = $conn->query($query);

  $array = array();
  if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {
        array_push($array, array('GAME' => $row['GAME'],
         'ELO' => $row['ELO_FOR_MATCH'],
         'MATCH' => $row['MATCH_ID'],
         'DATE' => $row['DATESTAMP']
       ));
    }
  }

  deliver_response(200, 'Games', $array);
?>
