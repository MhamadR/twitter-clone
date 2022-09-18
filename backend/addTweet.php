<?php 
	include "index.php";
	$getFromUser->preventAccess($_SERVER['REQUEST_METHOD'], realpath(__FILE__),realpath($_SERVER['SCRIPT_FILENAME']));

 	if(isset($_POST) && !empty($_POST)){
		$text     = $getFromUser->checkInput($_POST['text']);
		$tweet_image = '';
		$user_id  = $_SESSION['user_id'];

		if(!empty($text) or !empty($_FILES['file']['name'][0])){
			if(strlen($text) > 280){
				$error  = "The limit of text tweet is 280 character only";
			}

			if(!empty($_FILES['file']['name'][0])){
				$tweet_image = $getFromUser->uploadImage($_FILES['file']);
			}

			$tweet_id = $getFromUser->create('tweets', array('text' => $text, 'tweet_by' => $user_id, 'tweet_image' => $tweet_image));
			preg_match_all("/#+([a-zA-Z0-9_]+)/i", $text);

			$result['success'] = "Your Tweet has been posted";
			echo json_encode($result);	

		}else {
			$error = "Please try again";
		}

		if(isset($error)){
			$result['error'] = $error;
			echo json_encode($result);
		}
	}
 

?>