<?php 
include "index.php";
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
                header('location:'.BASE_URL.'index.html');
            }
        }

        public function login($username, $email, $password){
            $passHash = hash("sha256", $_POST["password"]);
            $password .= "a";
            $query = $this->mysqli->prepare("SELECT `username` FROM `users` WHERE `email` = :email AND `password` = :password");
            $query->bind_param("sss", $username, $email,$password);
            $query->execute();

            $count = $query->rowCount();
            $user = $query->fetch_assoc();

            if($count > 0){
                $_SESSION['username'] = $user->username;
                header('Location: index.html');//?
            }
            else{
                return false;
            }
        }
        public function loggedIn(){
            return (isset($_SESSION['user_id'])) ? true : false;
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
        public function userData($user_id){
            $query = $this->mysqli->prepare('SELECT * FROM `users` WHERE `user_id` = $user_id');
            $query->bind_param('i', $user_id);
            $query->execute();
    
            return $query->fetch_assoc();
        }
        public function search($search){
            $query = $this->mysqli->prepare("SELECT `user_id`,`username`,`name`,`profile_image`,`profile_cover` FROM `users` WHERE `username` LIKE ? OR `name` LIKE ?");
            $query->bind_value(1, $search.'%');
            $query->bind_value(2, $search.'%');
            $query->execute();
            return $query->fetch_assoc();
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

            if($query = $this->mysqli->prepare($sql)){
                foreach($field as $key =>$data){
                    $query->bindValue(':'.$key,$data);
                }
                $query->execute();
                return $this->mysqli->lastInsertId();
            }
            
        }
        // public function update($table, $user_id, $fields){
        //     $columns = '';
        //     $i       = 1;
    
        //     foreach ($fields as $name => $value) {
        //         $columns .= "`{$name}` = :{$name} ";
        //         if($i < count($fields)){
        //             $columns .= ', ';
        //         }
        //         $i++;
        //     }
        //     $sql = "UPDATE {$table} SET {$columns} WHERE `user_id` = {$user_id}";
        //     if($query = $this->pdo->prepare($sql)){
        //         foreach ($fields as $key => $value) {
        //             $query->bindValue(':'.$key, $value);
        //         }
        //         $query->execute();
        //     }
        // }
        public function checkUsername($username){
            $query = $this->mysqli->prepare("SELECT username FROM users WHERE username = $username");
            $query->bind_param('s',$username);
            $query->execute();

            $count =$query->$rowCount();
            if($count > 0){
                return true;
            }else{
                return false;
            }
        }
        public function checkPassword($password){
            $query = $this->mysqli->prepare("SELECT password FROM users WHERE password = $password");
            $passHash = hash("sha256", $_POST["password"]);
            $password .= "a";
            $query->bind_param('s',$passHash);
            $query->execute();

            $count = $query->rowCount();
            if($count > 0){
                return true;
            }else{
                return false;
            }
        }

        public function checkEmail($email){
            $query = $this->mysqli->prepare("SELECT email FROM users WHERE email = $email");
            $query->bind_param('s',$email);
            $query->execute();

            $count = $query->rowCount();
            if($count > 0){
                return true;
            }else{
                return false;
            }
        }
        public function delete($table, $array){
            $sql   = "DELETE FROM " . $table;
            $where = " WHERE ";
    
            foreach($array as $key => $value){
                $sql .= $where . $key . " = '" . $value . "'";
                $where = " AND ";
            }
            $sql .= ";";
            $query = $this->mysqli->prepare($sql);
            $query->execute();
        }
        


    


    }



?>    