<?php
$file = file_get_contents("questions.json");
$questions = json_decode($file, false);


//$_POST = json_decode(file_get_contents('php://input'), true);
if (isset($_GET['action'])) {
  switch ($_GET['action']) {
    case 'add':
      $questions[] = json_decode($_POST['question']);
      //if (file_put_contents("questions.json1", json_encode($questions, JSON_UNESCAPED_UNICODE) )) echo 'Ok';
      $f = fopen('questions.json', 'w');
      fwrite($f,  json_encode($questions, JSON_UNESCAPED_UNICODE));
      fclose($f);
      break;
    case 'remove':
      unset($questions[$_GET['number']]);
      $f = fopen('questions.json', 'w');
      fwrite($f,  json_encode($questions, JSON_UNESCAPED_UNICODE));
      fclose($f);
      break;
  }

}
//echo (json_encode($questions, JSON_UNESCAPED_UNICODE));
