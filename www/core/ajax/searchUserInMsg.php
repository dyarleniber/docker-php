<?php 
	include '../init.php';
	if(isset($_POST['search']) && !empty($_POST['search'])){
		$user_ID = $_SESSION['user_ID'];
		$search  = $getFromU->checkInput($_POST['search']);
		$result  = $getFromU->search($search);
		echo '<h4>People</h4><div class="message-recent"> ';
		foreach ($result as $user) {
			if($user->user_ID != $user_ID){
			echo '<div class="people-message" data-user="'.$user->user_ID.'">
						<div class="people-inner">
							<div class="people-img">
								<img src="'.BASE_URL.$user->profileImage.'"/>
							</div>
							<div class="name-right">
								<span><a>'.$user->screenName.'</a></span><span>@'.$user->username.'</span>
							</div>
						</div>
					 </div>';
			}
		}
		echo '</div>';
	}
?>