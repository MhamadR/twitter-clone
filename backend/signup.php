<?php
if(isset($_GET['step']) === true && empty($_GET['step']) === false){
include '../backend/index.php';
if (isset($_SESSION['user_id']) === false) {
  header('Location: ../index.html');
}

$user_id = $_SESSION['user_id'];
$user = $getFromUser->userData($user_id);
$step = $_GET['step'];

if(isset($_POST['next'])){
  $username = $getFromUser->checkInput($_POST['username']);

  if (!empty($username)) {
    if(strlen($username) > 20){
      $error = "Username must be between in 6-20 characters";
    }else if(!preg_match('/^[a-zA-Z0-9]{6,}$/', $username)){
      $error = 'Username must be more than  6 characters without spaces';
    } else if($getFromUser->checkUsername($username) === true){
      $error = "Username is already taken!";
    }else{
      $getFromUser->update('users', $user_id, array('username' => $username));
      header('Location: signup.php?step=2');
    }
  }else{
    $error = "Please enter your username to choose";
  }
}
?>
  