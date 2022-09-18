<?php
if ($_SERVER['REQUEST_METHOD'] == "GET" && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
	header('Location: ../frontend/login.html');
}
if(isset($_POST['signup'])){
	$name = $_POST['name'];
	$username = $_POST['user_name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$error = '';

	if(empty($username) || empty($name) || empty($password) || empty($email)){
		$error = 'All fields are required';
	}else {
		$username = $getFromUser->checkInput($username);
		$email = $getFromUser->checkInput($email);
		$name = $getFromUser->checkInput($name);
		$password = $getFromUser->checkInput($password);

		if(!filter_var($email)) {
			$error = 'Invalid email format';
		}else if(strlen($name) > 20){
			$error = 'Name must be between in 6-20 characters';
		}else if(strlen($password) < 10){
			$error = 'Password is too short';
		}else {
			if($getFromUser->checkEmail($email) === true){
				$error = 'Email is already in use';
			}else {
				$user_id = $getFromUser->create('users', array('email' => $email, 'password' => $passHash = hash("sha256", $_POST["password"]) , 'name' => $name, 'profile_image' => '', 'profileCover' => ''));
				$_SESSION['user_id'] = $user_id;
				header('Location: includes/signup.php?step=1');
			}
		}
	}
}
?>
<!-- Start of Sign up pop up -->
<div class="mask hide"></div>
    <div class="login-popup hide" id="signup-popup">
      <div
        class="close-popup-container"
        onclick="hideElement('#signup-popup'); hideElement('.mask')"
      >
        <div class="close-popup"></div>
      </div>
      <div class="popup-content">
        <h4>Create your account</h4>
        <form method="post" action="#">
			<?php
			if(isset($error)){
					echo '<div class="alert alert-danger" role="alert"style="width: 300px; margin:20px auto;text-align:center;">
					'.$error.'
					</div>';
			}
			?> 
          <input type="text" placeholder="Name" />
          <input type="text" placeholder="Username" />
          <input type="email" placeholder="Email" />
          <input type="password" placeholder="Password" />
          <input
            type="submit"
            class="signup-btn btn btn-blue"
            value="Sign up"
          />
        </form>
      </div>
    </div>
