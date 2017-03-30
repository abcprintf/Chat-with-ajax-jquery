<?php
session_start();
require_once 'config/connect.php';
require_once 'config/core.php';
$pdo = Database::connect();
$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

$auth = new Auth();
$chat = new Chat();

if (isset($_SESSION["auth_id"])){
  $member_id = $_SESSION["auth_id"];
}

if(isset($_POST['chat'])){
  $chat = $_POST['chat'];

  if (isset($_SESSION["auth_id"])){
    $member_id = $_SESSION["auth_id"];
  }

  $valid = true;
  if(empty($chat)){
    $valid = false;
  }

  if($valid){
    //$chat->save_chat($chat,$member_id,$pdo);
    $sql = "INSERT INTO `abcprint_demo`.`chat` (`message`, `member_id`, `date_time`) VALUES (?, ?, CURRENT_TIMESTAMP);";
    $q = $pdo->prepare($sql);
    $q->execute(array($chat,$member_id));
  }
}

if(isset($_POST['chatUpdate'])){
  $chat->show_chat($member_id,$pdo);
}
Database::disconnect();
?>
