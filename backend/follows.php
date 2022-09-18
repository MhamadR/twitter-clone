<?php
include '../backend/index.php';

$getFromUser->preventAccess($_SERVER['REQUEST_METHOD']);

if (isset($_POST['unFollow']) && !empty($_POST['unFollow'])) {
    $user_id = $_SESSION['user_id'];
    $follow_id = $_POST['unFollow'];
    $profile_id = $_POST['profile'];
    $getFromFollow->unFollow($follow_id, $user_id, $profile_id);
  }
  
  if (isset($_POST['follow']) && !empty($_POST['follow'])) {
    $user_id = $_SESSION['user_id'];
    $follow_id = $_POST['follow'];
    $profile_id = $_POST['profile'];
    $getFromFollow->follow($follow_id, $user_id, $profile_id);
  }
  



?>