<?php
  include '../../session.php';
  include '../response.php';
  include '../db.php';

  header("Content-Type:application/json");

  function verify_new_user()
  {
    if (empty($_POST['name']))
    {
      deliver_response(400, "No name set", NULL);
      return false;
    }

    if (empty($_POST['password']))
    {
      deliver_response(400, "No password set", NULL);
      return false;
    }

    if (empty($_POST['email']))
    {
      deliver_response(400, "No email set", NULL);
      return false;
    }

    return true;
  }

  function add_new_user()
  {
    $conn = new mysqli($GLOBALS['db'], $GLOBALS['login'], $GLOBALS['pass'], $GLOBALS['dbname']);

    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    $query = "INSERT INTO GS_USER (NICKNAME, PASSWORD, EMAIL) VALUES (
      '".$_POST['name']."',
      '".sha1($_POST['password'])."',
      '".$_POST['email']."'
      )";

      if (mysqli_query($conn, $query)) {
        deliver_response(201, "Success", 2);
      } else {
        deliver_response(400, "Query error", 232);
      }
    }

  if (verify_new_user())
    add_new_user();

?>
