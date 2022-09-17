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
            $passHash = hash("sha256", $_POST["password"]);
            $pass .= "a";
            $query = $this->mysqli->prepare("SELECT `username` FROM `users` WHERE `email` = :email AND `password` = :password");
            $query->bind_param("sss", $username, $email,$password);
            $query->execute();

            $count = $query->rowCount();
            $user = $query->fetch(mysqli::FETCH_OBJ);

            if($count > 0){
                $_SESSION['username'] = $user->username;
                header('Location: index.html');
            }
            else{
                return false;
            }
        }

        public function register($name,$email,$password){
            $passHash = hash("sha256", $_POST["password"]);
            $pass .= "a";
            $query = $this->mysqli->prepare("INSERT INTO `users` (`name`,`email`, `password`, `profile_image`, `profile_cover`) VALUES (? ,?, ?, 'images/defaultprofileimage.png', 'images/defaultCoverImage.png')");
            $query->bind_param("sss", $name, $email,$password);
            $query->execute();

            $user_id = $this->mysqli->lastInsertId();
            $_SESSION['user_id'] = $user_id;
        }

        public function logout(){
            $_SESSION = array();
            session_destroy();
            header('Location: ./frontend/index.html');
        }
        public function create($table, $fields = array()){
            $columns = implode(',',array_keys($fields));
            $value = ':'.implode(', :',array_keys($field));
            $sql = "INSERT INTO {$table} ({$columns}) VALUES ({$value})";

            if($stmt = $this->mysqli->prepare($sql)){
                foreach($field as $key =>$data){
                    $stmt->bindValue(':'.$key,$data);
                }
                $stmt->execute();
                return $this->mysqli->lastInsertId();
            }
            
        }
        public function update($table, $user_id, $fields){
            $columns = '';
            $i       = 1;
    
            foreach ($fields as $name => $value) {
                $columns .= "`{$name}` = :{$name} ";
                if($i < count($fields)){
                    $columns .= ', ';
                }
                $i++;
            }
            $sql = "UPDATE {$table} SET {$columns} WHERE `user_id` = {$user_id}";
            if($stmt = $this->pdo->prepare($sql)){
                foreach ($fields as $key => $value) {
                    $stmt->bindValue(':'.$key, $value);
                }
                $stmt->execute();
            }
        }

    


    }



?>    