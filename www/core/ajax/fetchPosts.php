<?php 
	include '../init.php';
	if(isset($_POST['fetchPost']) && !empty($_POST['fetchPost'])){
		$user_id = $_SESSION['user_id'];
		$limit   = (int) trim($_POST['fetchPost']);
		$getFromT->tweets($user_id, $limit);
	}
?>