<?php
	include '../init.php'; 
    if(isset($_POST['like']) && !empty($_POST['like'])){
    	$user_ID  = $_SESSION['user_id'];
    	$post_id = $_POST['like'];
    	$get_id   = $_POST['user_id'];
    	$getFromT->addLike($user_ID, $post_id, $get_id);
    }

    if(isset($_POST['unlike']) && !empty($_POST['unlike'])){
    	$user_ID  = $_SESSION['user_id'];
    	$post_id = $_POST['unlike'];
    	$get_id   = $_POST['user_id'];
    	$getFromT->unLike($user_ID, $post_id, $get_id);
    }

    if(isset($_POST['file'])){
        $getFromT->uploadImage($_POST['files']);
    } 


?>