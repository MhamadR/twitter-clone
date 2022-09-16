<?php 
    class User{
        protected $conn;

        public function __construct($conn){
            $this->conn = $conn;
        }

        public function checkInput($data){
            $data = htmlspecialchars($data);
            $data = trim($data);
            $data = stripcslashes($data);
            return $data;
        }

        public function preventAccess($request,$currentFile,$current1){
            if($request == 'GET' && $currentFile == $current1){
                header('location:'.BASE_URL.'index.php');
            }
        }
        public function login($username, $email, $password){
            
        }



    }



?>    