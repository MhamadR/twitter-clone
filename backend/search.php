<?php
include '../index.php';
if(isset($_POST["search"]) && !empty($_POST["search"])){
    $search = $getFromUser->checkInput($_POST["search"]);
    $result = $getFromUser->search($search);
    if(!empty($result)){
        echo '<div><ul>'
        foreach($result as $user){
            echo '
            <li>
                <div>
                    <div>
                        <a href="'.BASE_URL.$user->username.'"><img src="'.BASE_URL.$user->profileImage.'"></a>
                    </div>
                    <div>
                        <div>
                            <a href="'.BASE_URL.$user->username.'"><b>'.$user->name.'</b></a><br><span>@'.$user->username.'</span>
                        </div>
                    </div>
                </div> 
            </li> ';
        }
        echo '</ul></div>';
    }
}

?>