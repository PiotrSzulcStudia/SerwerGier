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
    $url = "https://students.mimuw.edu.pl/~ps347277/BD/api/game/list_games.php";
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $result = json_decode($response);
    if (!isset($_GET['game']) || !in_array($_GET['game'], $result->data))
    {
      header('Location: index.php');
    }
  ?>

<div class="container">
  <div class="jumbotron">
    <h1><?php echo ucwords($_GET['game']); ?></h1>
    <p>
    <?php
      if ($isUserLoggedIn) {

      } else {
        echo "Nie jestes zalogowany. Zaloz konto lub zaloguj sie by zobaczyc twoje statystyki";
      }
    ?>
    </p>

  </div>


  <div class="col-sm-12 col-md-6 col-md-push-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Zagraj</h3>
      </div>
      <div class="panel-body">
<?php
if ($isUserLoggedIn) {
  $url = "https://students.mimuw.edu.pl/~ps347277/BD/api/user/list_users.php";
  $ch = curl_init();
  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  $response = curl_exec($ch);
  $result = json_decode($response);
   ?>
  <form action="tester.php" method="post">
    <div class="form-group">
      <label for="radio">Wybierz gracza</label><br>
      <?php foreach ($result->data as $c) {
        if ($c == $_SESSION['CurrentUser']) continue;
        echo '<input type="radio" name="user2" value="'.$c.'">'.$c.'<br>';
      } ?>
    </div>
    <input type="hidden" name="game" value="<?php echo $_GET['game']?>">
    <input type="hidden" name="user1" value="<?php echo $_SESSION['CurrentUser'] ?>">
    <button type="submit" name="submit" class="btn btn-default">Graj</button>
  </form>
        <?php } else {
          echo "Opcja dostepna dla zalogowanych uzytkownikow";
        } ?>
      </div>
    </div>

    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Twoje ostatnie mecze</h3>
      </div>
      <div class="panel-body">
<?php
  if (!$isUserLoggedIn) echo "Opcja dostepna dla zalogowanych uzytkownikow";
  else {

    $url = "https://students.mimuw.edu.pl/~ps347277/BD/api/game/match.php?game=".$_GET['game']."&user=".$_SESSION['CurrentUser'];
    $ch = curl_init();
    curl_setopt($ch,CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    $result = json_decode($response);

    if (count($result->data) > 0) {
      echo '<table class="table table-striped table-bordered">';
      echo '<tr>';
      echo '<th>#</th>';
      echo '<th>Data</th>';
      echo '<th>Punkty</th>';
      echo '</tr>';

      $i = 0;
      foreach ($result->data as $c) {
        echo '<tr>';
          echo'<td><a href="match.php?id='.$c->MATCH.'">'.++$i.'</a></td>';
          echo'<td>'.$c->DATE.'</td>';
          echo'<td>'.$c->ELO.'</td>';
        echo '</tr>';

        if ($i == 4) break;
      }
      echo '</table>';
    } else {
      echo '<div class="alert alert-info" role="alert">Nie rozegrales zadnych meczy</div>';
    }
  }
 ?>
      </div>
    </div>
  </div>
  <div class="col-sm-12 col-md-6 col-md-pull-6">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Ranking dla <?php echo $_GET['game']; ?></h3>
      </div>
      <div class="panel-body">
        <?php
            $url = "https://students.mimuw.edu.pl/~ps347277/BD/api/game/game_ranking.php?game=".$_GET['game'];
            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $response = curl_exec($ch);
            $result = json_decode($response);

            if (count($result->data) > 0) {
              echo '<table class="table table-striped table-bordered">';
              echo '<tr>';
              echo '<th>#</th>';
              echo '<th>Uzytkownik</th>';
              echo '<th>Punkty</th>';
              echo '</tr>';

              $i = 0;
              foreach ($result->data as $c) {
                echo '<tr>';
                  echo'<td>'.++$i.'</td>';
                  echo'<td>'.$c->USER.'</td>';
                  echo'<td>'.$c->ELO.'</td>';
                echo '</tr>';

                if ($i == 11) break;
              }
              echo '</table>';
            } else {
              echo '<div class="alert alert-info" role="alert">Nie ma dostepnych rankingow dla tej gry</div>';
            }
        ?>
      </div>
    </div>
  </div>
  </div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>

</html>
