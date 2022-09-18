<?php
class Tweet extends User{

    public function __construct($mysqli){
        $this->mysqli = $mysqli;
    }

    public function tweets($user_id,$number){
        $query = $this->mysqli->prepare("SELECT * FROM `tweets` WHERE `tweet_by` = $user_id AND `tweet_by` IN (SELECT `receiver` FROM `follow` WHERE `sender` = $user_id) ORDER BY `tweet_id` DESC LIMIT $number");
        $query->bind_param("ii",$user_id,$number);
        $query = execute();
        $tweets = $query->fetch_assoc();

        foreach($tweets as $tweet){
            $likes = $this->likes($user_id,$tweet->tweet_id);
            // echo "tweet section html"
        }
    }

    public function getUserTweets($user_id){
        $query = $this->mysqli->prepare("SELECT * FROM `tweets` LEFT JOIN `users` ON `tweet_by` = `user_id` WHERE `tweet_by` = $user_id ORDER BY `tweet_id` DESC");
        $query->bind_param("i",$user_id);
        $query->execute();
        return $query->fetch_assoc();
    }

    public function addLike($user_id,$tweet_id,$get_id){
        $query = $this->mysqli->prepare("UPDATE `tweets` SET `likes_count` = `likes_count`+1 WHERE `tweet_id` = $tweet_id");
		$query->bind_param("i", $tweet_id);
		$query->execute();

		$this->create('likes', array('like_by' => $user_id, 'liked_on' => $tweet_id));
	
    }

    public function unLike($user_id, $tweet_id, $get_id){
		$query = $this->mysqli->prepare("UPDATE `tweets` SET `likes_count` = `likes_count`-1 WHERE `tweet_id` = $tweet_id");
		$query->bind_param("i", $tweet_id);
		$query->execute();

		$query = $this->pdo->prepare("DELETE FROM `likes` WHERE `like_by` = $user_id and `like_on` = $tweet_id");
		$query->bind_param("ii", $user_id,$tweet_id);
		$query->execute(); 
	}

    public function likes($user_id, $tweet_id){
		$query = $this->mysqli->prepare("SELECT * FROM `likes` WHERE `like_by` = $user_id AND `like_on` = $tweet_id");
		$query->bind_param("ii", $user_id, $tweet_id);
		$query->execute();
		return $query->fetch_assoc();
	}
    
    public function countLikes($user_id){
		$query = $this->mysqli->prepare("SELECT COUNT(`like_id`) AS `LikesNumber` FROM `likes` WHERE `liked_by` = $user_id");
		$query->bind_param("i", $user_id);
		$query->execute();
		$count = $query->fetch(mysqli);
		echo $count->LikesNumber;
	}
}

?>