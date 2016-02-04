<?php
  include '../../session.php';
  include '../response.php';
  include '../db.php';

  $conn = new mysqli($GLOBALS['db'], $GLOBALS['login'], $GLOBALS['pass'], $GLOBALS['dbname']);

  if (!$conn) {
      die("Connection failed: " . mysqli_connect_error());
  }

  $query = "SELECT * FROM GS_MATCH WHERE ID=".$_GET['id'];
  $result = $conn->query($query);

  if ($result->num_rows == 0)
    deliver_response(400, "No Match Found", NULL);
  else {
    $query = "SELECT * FROM GS_HISTORY WHERE MATCH_ID =".$_GET['id']." ORDER BY TURN";
    $result = $conn->query($query);

    $array = array();
    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
          array_push($array, array('turn' => $row['TURN'],
            'user' => $row['USER_ID'],
            'date' => $row['DATESTAMP'],
            'description' => $row['DESCRIPTION'])
          );
      }
    }
    deliver_response(200, 'Games', $array);
  }

?>
