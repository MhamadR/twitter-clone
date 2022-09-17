<?php
class Follow extends User{
    protected $message;

    public function __construct($mysqli){
        $this->mysqli = $mysqli;
        $this->message = new Message($this->mysqli);
    }

    public function checkFollow($follower_id, $user_id){
		$query = $this->mysqli->prepare("SELECT * FROM `follow` WHERE `sender` = $user_id  AND `receiver` = $follower_id");
		$query->bind_param("ii", $user_id, $follower_id);
		$query->execute();
		return $query->fetch_assoc();
	}
    public function follow($follow_id, $user_id, $profile_id){
		$this->create('follow', array('sender' => $user_id, 'receiver' => $follow_id));
		$this->addFollowCount($follow_id, $user_id);
		$query = $this->mysqli->prepare('SELECT `user_id`, `following`, `followers` FROM `users` LEFT JOIN `follow` ON `sender` = $user_id AND CASE WHEN `receiver` = $user_id THEN `sender` = `user_id` END WHERE `user_id` = $profile_id');
		$query->execute(array("user_id" => $user_id,"profile_id" => $profile_id));
		$data = $query->fetch_assoc();
		echo json_encode($data);
  		// $this->message->sendNotification($follow_id, $user_id, $user_id, 'follow');
 
  	}


}


?>