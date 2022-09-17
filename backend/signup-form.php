<?php
if ($_SERVER['REQUEST_METHOD'] == "GET" && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
	header('Location: ../index.html');
}
if(isset($_POST['signup'])){
	$name = $_POST['name'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$error = '';

	if(empty($name) || empty($password) || empty($email)){
		$error = 'All fields are required';
	}else {
		$email = $getFromUser->checkInput($email);
		$screenName = $getFromUser->checkInput($screenName);
		$password = $getFromUser->checkInput($password);

		if(!filter_var($email)) {
			$error = 'Invalid email format';
		}else if(strlen($name) > 20){
			$error = 'Name must be between in 6-20 characters';
		}else if(strlen($password) < 5){
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
<form method="post" autocomplete="off">
              <?php
      if(isset($error)){
            echo '<div role="alert"> '.$error.' </div>';
      }
    ?>    
    <div>
            <div>
              <input type="text" name="name" placeholder="Name" />
            </div>
            <div>
              <input type="email" name="email" placeholder="Email" />
            </div>
            <div>
              <input type="password" name="password" placeholder="Password" />
            </div>
            <input type="submit" name="signup" Value="Signup">
          </div>

</form>
<script type="text/javascript">
        setTimeout(function() {
            // Time to close
            $('#alert').alert('close');
        }, 4000);
</script>