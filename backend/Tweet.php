<?php
include "User.php";
class Tweet extends User{
    protected $message;

    public function __construct($mysqli){
        $this->mysqli = $mysqli;
        // $this->message = new Message($this->mysqli);
    }
    public function tweets($user_id,$number){
        $query = $this->mysqli->prepare("SELECT * FROM `tweets` WHERE `tweet_by` = $user_id AND `tweetBy` IN (SELECT `receiver` FROM `follow` WHERE `sender` = $user_id) ORDER BY `tweet_id` DESC LIMIT $number");
        $query->bind_param("ii",$user_id,$number);
        $query = execute();
        $tweets = $query->fetch_assoc();

        foreach($tweets as $tweet){
            $likes = $this->likes($user_id,$tweet->tweet_id);
            // echo "tweet section html"
        }
    }
    public function getUserTweets($user_id){
        $query = $this->mysqli->prepare("SELECT * FROM `tweets` LEFT JOIN `users` ON `tweet_by` = `user_id` WHERE `tweetBy` = $user_id ORDER BY `tweet_id` DESC");
        $query->bind_param("i",$user_id);
        $query->execute();
        return $query->fetch_assoc();
    }
    public function addLike($user_id,$tweet_id,$get_id){
        $query = $this->mysqli->prepare("UPDATE `tweets` SET `likes_count` = `likes_count`+1 WHERE `tweetID` = $tweet_id");
		$query->bindParam("i", $tweet_id);
		$query->execute();

		$this->create('likes', array('likeBy' => $user_id, 'liked_on' => $tweet_id));
	
    }
    public function unLike($user_id, $tweet_id, $get_id){
		$query = $this->mysqli->prepare("UPDATE `tweets` SET `likesCount` = `likesCount`-1 WHERE `tweetID` = $tweet_id");
		$query->bind_param("i", $tweet_id);
		$query->execute();

		$query = $this->pdo->prepare("DELETE FROM `likes` WHERE `likeBy` = :user_id and `likeOn` = :tweet_id");
		$query->bind_param("ii", $user_id,$tweet_id);
		$query->execute(); 
	}
    public function likes($user_id, $tweet_id){
		$query = $this->mysqli->prepare("SELECT * FROM `likes` WHERE `like_by` = $user_id AND `likeOn` = $tweet_id");
		$query->bind_param("ii", $user_id, $tweet_id);
		$query->execute();
		return $query->fetch_assoc();
	}
    public function countLikes($user_id){
		$query = $this->mysqli->prepare("SELECT COUNT(`like_id`) AS `totalLikes` FROM `likes` WHERE `liked_by` = $user_id");
		$query->bindParam("i", $user_id);
		$query->execute();
		$count = $query->fetch(mysqli);
		echo $count->totalLikes;
	}
}

?>