<?php

function generateRandomString($length = 10) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}

/* no checking for errors */
if (!isset($_POST['game']))
{
  echo "Game not set";
  exit;
}

if (!isset($_POST['user1']))
{
  echo "User1 not set";
  exit;
}

if (!isset($_POST['user2']))
{
  echo "User2 not set";
  exit;
}

/* start new match */
$url = "https://students.mimuw.edu.pl/~ps347277/BD/api/game/new_match.php";
$ch = curl_init();

$post = array(
  'game' => $_POST['game']
);

curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$result = json_decode($response);

if ($result->status == 201) {
  $match_id = $result->data;
} else {
  exit;
}

echo $_POST['user1'];
echo $_POST['user2'];
echo $_POST['game'];
echo $match_id;

/* add participants */
$url = "https://students.mimuw.edu.pl/~ps347277/BD/api/game/new_participant.php";
$ch = curl_init();

$post = array(
  'user' => $_POST['user1'],
  'id' => $match_id
);

curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$result = json_decode($response);

if ($result->status != 201) {
  echo 'Particpant error';
  exit;
}

$url = "https://students.mimuw.edu.pl/~ps347277/BD/api/game/new_participant.php";
$ch = curl_init();

$post = array(
  'user' => $_POST['user2'],
  'id' => $match_id
);

curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$result = json_decode($response);

if ($result->status != 201) {
  echo 'Particpant error';
  exit;
}

/* add moves */
for ($i = 1; $i <= 10; $i++) {
  $url = "https://students.mimuw.edu.pl/~ps347277/BD/api/game/move.php";
  $ch = curl_init();

  $post = array(
    'user' => ($i % 2 == 0) ? $_POST['user2'] : $_POST['user1'],
    'id' => $match_id,
    'turn' => $i,
    'desc' => generateRandomString()
  );

  curl_setopt($ch,CURLOPT_URL, $url);
  curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

  $response = curl_exec($ch);
  $result = json_decode($response);

  if ($result->status != 201) {
    echo 'Move error';
    exit;
  }
}

/* update elo */
$rand = rand() % 2;
$winner = ($rand == 1) ? $_POST[user1] : $_POST[user2];
$looser = ($rand == 0) ? $_POST[user1] : $_POST[user2];
$win = rand(50, 240);
$lose = (-1) * rand(10, 50);

echo 'win'.$winner;
echo 'los'.$looser;

$url = "https://students.mimuw.edu.pl/~ps347277/BD/api/game/update_participant.php";
$ch = curl_init();

$post = array(
  'user' => $winner,
  'elo' => $win,
  'id' => $match_id,
  'game' => $_POST['game']
);

curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$result = json_decode($response);

if ($result->status != 201) {
  echo $result->status_message;
  echo ' '.$result->data;
  echo 'Particpant update error1';
  exit;
}

$url = "https://students.mimuw.edu.pl/~ps347277/BD/api/game/update_participant.php";
$ch = curl_init();

$post = array(
  'user' => $looser,
  'elo' => $lose,
  'id' => $match_id,
  'game' => $_POST['game']
);

curl_setopt($ch,CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($post));
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($ch);
$result = json_decode($response);

echo $result;

if ($result->status != 201) {
  echo $result->status_message;
  echo ' '.$result->data;
  echo 'Particpant update error2';
  exit;
}

echo 'Test game: OK!';

?>
