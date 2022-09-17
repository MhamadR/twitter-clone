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



}


?>