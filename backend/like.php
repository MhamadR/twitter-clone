<?php
include 'index.php'; 

if(isset($_POST['like']) && !empty($_POST['like'])){
    $user_id  = $_SESSION['user_id'];
    $tweet_id = $_POST['like'];
    $get_id   = $_POST['user_id'];
    $getFromTweet->addLike($user_id, $tweet_id, $get_id);
}

if(isset($_POST['unlike']) && !empty($_POST['unlike'])){
    $user_id  = $_SESSION['user_id'];
    $tweet_id = $_POST['unlike'];
    $get_id   = $_POST['user_id'];
    $getFromTweet->unLike($user_id, $tweet_id, $get_id);
}

?>