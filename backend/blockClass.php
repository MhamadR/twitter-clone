<?php
  class Block extends User{
    protected $message;

    public function __construct($mysqli){
        $this->mysqli = $mysqli;
        $this->message = new Message($this->mysqli);
    }
    public function blockUser($user_id){
        unFollow($user_id);
    }

  }


?>