<?php
 
if ($_SERVER['REQUEST_METHOD'] == "GET" && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
  header('Location: ../index.html');
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
<div>
    <form method="post" autocomplete="off">
        
    <h1>Log in to twitter</h1>
    <div>
        <input name="email" type="text" placeholder="Email" />
        <input name="password" type="password" placeholder="Password"/>
        
    <input name="login" type="submit" value="login">
    </div>
<?php
    if(isset($errorMsg)){
        echo '<div> '.$errorMsg.' </div>';
    }
?> 
    
    </form>
</div>