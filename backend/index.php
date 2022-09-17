<?php
    session_start();
    include "/backend/connection.php";
    include "/backend/user.php";
    include "/backend/tweet.php";
    include "/backend/follow.php";
    include "backend/block.php";
    global $conn;

    $getFromUser = new User($conn);
    $getFromTweet = new Tweet($conn);
    $getFromFollow = new Follow($conn);
    $getFromBlock = new Block($conn);

    define("BASE_URL","http://localhost:8080/twitter/twitter-clone/backend/");

?>