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
 
  	}
      public function unFollow($follow_id, $user_id, $profile_id){
		$this->delete('follow', array('sender' => $user_id, 'receiver' => $followID));
		$this->removeFollowCount($follow_id, $user_id);
		$query = $this->mysqli->prepare('SELECT `user_id`, `following`, `followers` FROM `users` LEFT JOIN `follow` ON `sender` = $user_id AND CASE WHEN `receiver` = $user_id THEN `sender` = `user_id` END WHERE `user_id` = $profile_id');
		$query->execute(array("user_id" => $user_id,"profile_id" => $profile_id));
		$data = $query->fetch_assoc();
		echo json_encode($data);
	}
    public function addFollowCount( $follow_id, $user_id){
		$query = $this->mysqli->prepare("UPDATE `users` SET `following` = `following` + 1 WHERE `user_id` = $user_id; UPDATE `users` SET `followers` = `followers` + 1 WHERE `user_id` = $follow_id");
		$query->execute(array("user_id" => $user_id, "follow_id" => $follow_id));
	}
    public function removeFollowCount($follow_id, $user_id){
		$query = $this->mysqli->prepare("UPDATE `users` SET `following` = `following` - 1 WHERE `user_id` = $user_id; UPDATE `users` SET `followers` = `followers` - 1 WHERE `user_id` = :follow_id");
		$query->execute(array("user_id" => $user_id, "follow_id" => $follow_id));
	}
    public function followButton($profile_id, $user_id, $follow_id){
		$data = $this->checkFollow($profile_id, $user_id);
		if($this->loggedIn()===true){

			if($profileID != $user_id){
				if(isset($data['receiver']) && $data['receiver'] === $profile_id){
					//Following btn
					return "<button class='f-btn following-btn follow-btn' data-follow='".$profile_id."' data-profile='".$follow_id."' style='outline:none;'>Following</button>";
				}else{
					//Follow button
					return "<button class='f-btn follow-btn' data-follow='".$profile_id."' data-profile='".$follow_id."' style='outline:none;'><i class='fa fa-user-plus'></i>Follow</button>";
				}
			}else{
				//edit button
				return "<button class='new-btn' onclick=location.href='".BASE_URL."profileEdit.php' style='outline:none;'>Edit Profile</button>";
			}
		}else{
			return "<button style='outline:none;' class='f-btn' onclick=location.href='".BASE_URL."index.html'><i class='fa fa-user-plus'></i>Follow</button>";
		}
	}



}


?>