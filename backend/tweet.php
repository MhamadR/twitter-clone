<?php
class Tweet extends User{
    protected $message;

    public function __construct($mysqli){
        $this->mysqli = $mysqli;
        $this->message = new Message($this->mysqli);
    }
    public function tweets($user_id,$number){
        $mk = $this->mysqli->prepare("SELECT * FROM `tweets` WHERE `tweet_by` = $user_id AND `tweetBy` IN (SELECT `receiver` FROM `follow` WHERE `sender` = $user_id) ORDER BY `tweet_id` DESC LIMIT $number");
        $mk->bind_param("ss",$user_id,$number);
        $mk = execute();
        $tweets = $mk->fetchALL(mysqli->fetch);

        foreach($tweets as $tweet){
            $likes = $this->likes($user_id,$tweet->tweet_id);
            // echo "tweet section html"
        }
    }
    public function getUserTweets($user_id){
        $mk = $this->mysqli->prepare("SELECT * FROM `tweets` LEFT JOIN `users` ON `tweet_by` = `user_id` WHERE `tweetBy` = $user_id ORDER BY `tweet_id` DESC");
        $mk->bind_param("s",$user_id);
        $mk->execute();
        return $mk->fetchAll(mysqli->fetch);//fetch
    }
    public function addLike($user_id,$tweet_id,$get_id){
        $mk = $this->mysqli->prepare("UPDATE `tweets` SET `likes_count` = `likes_count`+1 WHERE `tweetID` = $tweet_id");
		$mk->bindParam("i", $tweet_id);
		$mk->execute();

		$this->create('likes', array('likeBy' => $user_id, 'liked_on' => $tweet_id));
	
		if($get_id != $user_id){
			$this->message->sendNotification($get_id, $user_id, $tweet_id, 'like');
		}
    }
    public function unLike($user_id, $tweet_id, $get_id){
		$mk = $this->mysqli->prepare("UPDATE `tweets` SET `likesCount` = `likesCount`-1 WHERE `tweetID` = $tweet_id");
		$mk->bind_param("i", $tweet_id);
		$mk->execute();

		$mk = $this->pdo->prepare("DELETE FROM `likes` WHERE `likeBy` = :user_id and `likeOn` = :tweet_id");
		$mk->bind_param("ii", $user_id,$tweet_id);
		$mk->execute(); 
	}
    public function likes($user_id, $tweet_id){
		$mk = $this->mysqli->prepare("SELECT * FROM `likes` WHERE `like_by` = $user_id AND `likeOn` = $tweet_id");
		$mk->bind_param("ii", $user_id, $tweet_id);
		$mk->execute();
		return $mk->fetch(mysqli);
	}










}

?>