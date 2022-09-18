<?php
 
if ($_SERVER['REQUEST_METHOD'] == "GET" && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
  header('Location: ../frontend/login.html');
}
if(isset($_POST['login']) && !empty($_POST['login'])) {
$email = $_POST['email'];
$password = $_POST['password'];

if(!empty($email) || !empty($password)) {
    $email = $getFromUser->checkInput($email);
    $password = $getFromUser->checkInput($password);

    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
        $errorMsg = "Invalid format";
    }else {
        if($getFromUser->login($email, $password) === false){
          $errorMsg = "The email or password is not correct!";
        }
    }
} else {
    $errorMsg = "Please enter username and password!";
  }
}
?>

<!-- Start of Sign in pop up -->
<div class="login-popup signin-popup hide" id="signin-popup">
    <div
    class="close-popup-container"
    onclick="hideElement('#signin-popup'); hideElement('.mask')"
    >
    <div class="close-popup"></div>
    </div>
    <div class="signin-logo">
    <img src="./Images/twitter-logo.png" alt="twitter logo" />
    </div>
    <div class="popup-content popup-content-sign-in">
    <h4>Sign in to Twitter</h4>
    <form action="#" method="post">
        <input type="email" placeholder="Email" />
        <input type="password" placeholder="Password" />
        <input
        type="submit"
        class="signin-btn btn btn-blue"
        value="Sign up"
        />
    <?php

        if(isset($errorMsg)){
            echo '<div role="alert"> '.$errorMsg.' </div>';
        }
    
    ?>
    </form>
    <p>Don't have an account? <span class="twitter-blue">Sign up</span></p>
    </div>
</div>
<!-- End of Sign in pop up -->