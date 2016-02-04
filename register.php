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


  <div class="container">
    <div class="panel panel-default">
      <div class="panel-heading">
        <h3 class="panel-title">Rejestracja</h3>
      </div>
      <div class="panel-body">

<?php
          if (isset($_POST['submit']))
          {
            $url = "https://students.mimuw.edu.pl/~ps347277/BD/api/user/add.php";
            $ch = curl_init();

            $post = array(
              'name' => $_POST['name'],
              'password' =>  $_POST['password'],
              'email'   =>  $_POST['email'],
            );

            curl_setopt($ch,CURLOPT_URL, $url);
            curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

            $response = curl_exec($ch);
            $result = json_decode($response);

            if ($result->status == 201) {
              echo '<div class="alert alert-success" role="alert">Success</div>';
              $_SESSION['CurrentUser'] = $_POST['name'];
              $GLOBALS['isUserLoggedIn'] = true;
              header('Location: index.php');
            } else
            echo '<div class="alert alert-danger" role="alert">'.$result->status_message.'</div>';
          }
?>

        <form action="" method="post">
          <div class="form-group">
            <label for="nick">Nick</label>
            <input type="text" class="form-control" name="name" id="name" placeholder="Nick">
          </div>
          <div class="form-group">
            <label for="email">Adres email</label>
            <input type="email" class="form-control" name="email" id="email" placeholder="Email">
          </div>
          <div class="form-group">
            <label for="password">Haslo</label>
            <input type="password" class="form-control" name="password" id="password" placeholder="Haslo">
          </div>
          <button type="submit" name="submit" class="btn btn-default">Zarejestruj</button>
        </form>
      </div>

      <div class="panel-footer">
        ze wzgledu na brak ssla/algorytm hashujacy uzyj hasla w stylu 'abc'
      </div>
    </div>
  </div>
  <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
  <!-- Include all compiled plugins (below), or include individual files as needed -->
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
</body>

</html>
