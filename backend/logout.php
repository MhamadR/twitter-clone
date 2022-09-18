<?php
  include '../backend/index.php';
  $getFromUser->logout();
  if ($getFromUser->loggedIn() === false) {
    header('Location:'.BASE_URL.'index.html');
  }
?>