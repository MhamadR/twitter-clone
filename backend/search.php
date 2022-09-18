<?php
include '../index.php';
if(isset($_POST["search"]) && !empty($_POST["search"])){
    $search = $getFromUser->checkInput($_POST["search"]);
    $result = $getFromUser->search($search);
    if(!empty($result)){
        echo '<div><ul>';
        foreach($result as $user){
            echo '
            <li>
                <div>
                    <div>
                        <a href="'.BASE_URL.$user->user_name.'"><img src="'.BASE_URL.$user->profile_image.'"></a>
                    </div>
                    <div>
                        <div>
                            <a href="'.BASE_URL.$user->user_name.'"><b>'.$user->name.'</b></a><br><span>@'.$user->user_name.'</span>
                        </div>
                    </div>
                </div> 
            </li> ';
        }
        echo '</ul></div>';
    }
}

?>