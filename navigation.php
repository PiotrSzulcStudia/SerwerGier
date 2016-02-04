<?php

include 'session.php';

function print_navigation_bar()
{
?>
    <nav class="navbar navbar-inverse">
    <div class="container-fluid">
      <!-- Brand and toggle get grouped for better mobile display -->
      <div class="navbar-header">
        <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
          <span class="sr-only">Toggle navigation</span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
          <span class="icon-bar"></span>
        </button>
        <a class="navbar-brand" href="index.php">Serwer Gier</a>
      </div>

      <!-- Collect the nav links, forms, and other content for toggling -->
      <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
        <ul class="nav navbar-nav">
<?php
  if ($GLOBALS['isAdmin'])
  {
?>
          <li class="active"><a href="admin.php">Panel Admina <span class="sr-only">(current)</span></a></li>
<?php
  }
?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Gry<span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="games.php">Wszystkie</a></li>
              <li role="separator" class="divider"></li>
<?php
              $url = "https://students.mimuw.edu.pl/~ps347277/BD/api/game/list_games.php";
              $ch = curl_init();
              curl_setopt($ch,CURLOPT_URL, $url);
              curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
              $response = curl_exec($ch);
              $result = json_decode($response);
              foreach ($result->data as $c) {
                  echo '<li><a href="game.php?game='.$c.'">'.ucwords($c).'</a></li>';
              }
?>
            </ul>
          </li>
        </ul>
        <ul class="nav navbar-nav navbar-right">
<?php
  if (!$GLOBALS['isUserLoggedIn'])
  {
?>
          <li><a href="register.php">Rejestracja</a></li>
          <li><a href="login.php">Zaloguj sie</a></li>
<?php
  } else
  {
?>
          <li class="dropdown">
            <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><span class="glyphicon glyphicon-user" aria-hidden="true"></span> Profil (<?php echo $GLOBALS['currentUser'] ?>) <span class="caret"></span></a>
            <ul class="dropdown-menu">
              <li><a href="personal_ranking.php">Twoje punkty</a></li>
              <li><a href="personal_history.php">Historia rozgrywek</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="logout.php">Wyloguj</a></li>
            </ul>
          </li>

        </ul>
<?php
  }
?>
      </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
  </nav>
<?php
}
 ?>
