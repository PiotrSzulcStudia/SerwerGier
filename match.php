<?php
  include('session.php');
  include('navigation.php');
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>[BD 2016]</title>

  <!-- Bootstrap -->
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">

  <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
  <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
  <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.2/html5shiv.js"></script>
      <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body>
  <?php print_navigation_bar(); ?>
  <?php
    $url = "https://students.mimuw.edu.pl/~ps347277/BD/api/game/match_history.php?id=".$_GET['id'];
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $result = json_decode($response);
    if (!isset($_GET['id']) || $result->status != 200)
    {
      header('Location: index.php');
    }
  ?>
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Historia Rozgrywki</h3>
      </div>
      <div class="panel-body">
        <?php
            if (count($result->data) > 0) {
              echo '<table class="table table-striped table-bordered">';
              echo '<tr>';
              echo '<th>Ruch</th>';
              echo '<th>Czas</th>';
              echo '<th>Uzytkownik</th>';
              echo '<th>Ruch</th>';
              echo '</tr>';

              $i = 0;
              foreach ($result->data as $c) {
                echo '<tr>';
                  echo'<td>'.++$i.'</td>';
                  echo'<td>'.$c->date.'</td>';
                  echo'<td>'.$c->user.'</td>';
                  echo'<td>'.$c->description.'</td>';
                echo '</tr>';
              }
              echo '</table>';
            } else {
              echo '<div class="alert alert-info" role="alert">Nie ma historii dla tego meczu</div>';
            }
        ?>
      </div>
    </div>
  </div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>

</html>
