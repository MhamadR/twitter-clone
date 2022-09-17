<?php
    session_start();
    include "/backend/connection.php";
    include "/backend/userClass.php";
    include "/backend/tweetClass.php";
    include "/backend/followClass.php";
    
    global $conn;

    $getFromUser = new User($conn);
    $getFromTweet = new Tweet($conn);
    $getFromFollow = new Follow($conn);

    define("BASE_URL","http://localhost:8080/twitter/twitter-clone/backend/");

?>