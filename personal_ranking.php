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
    $url = "https://students.mimuw.edu.pl/~ps347277/BD/api/user/ranking.php?user=".$_SESSION['CurrentUser'];
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $result = json_decode($response);
    if (!isset($_SESSION['CurrentUser']))
    {
      header('Location: index.php');
    }
  ?>
  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Twoje Punkty</h3>
      </div>
      <div class="panel-body">
        <?php
            if (count($result->data) > 0) {
              echo '<table class="table">';
              echo '<tr>';
              echo '<th>Gra</th>';
              echo '<th>Punkty</th>';
              echo '</tr>';

              $i = 0;
              foreach ($result->data as $c) {
                echo '<tr>';
                  echo'<td><a href="game.php?game='.$c->GAME.'">'.ucwords($c->GAME).'</a></td>';
                  echo'<td>'.$c->ELO.'</td>';
                echo '</tr>';
              }
              echo '</table>';
            } else {
              echo '<div class="alert alert-info" role="alert">Nie grales w zadne gry</div>';
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
