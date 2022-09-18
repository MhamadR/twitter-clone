<?php
    session_start();
    include "connection.php";
    include "UserClass.php";
    include "TweetClass.php";
    include "FollowClass.php";
    
    global $conn;

    $getFromUser = new User($conn);
    $getFromTweet = new Tweet($conn);
    $getFromFollow = new Follow($conn);

    define("BASE_URL","http://localhost:8080/twitter-clone/backend/index.php");

?>