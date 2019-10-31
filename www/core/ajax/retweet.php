<?php 
	include '../init.php';
	$user_ID = $_SESSION['user_ID'];
	if(isset($_POST['repost']) && !empty($_POST['repost'])){
		$post_id  = $_POST['repost'];
		$get_id    = $_POST['user_ID'];
		$comment   = $getFromU->checkInput($_POST['comment']);
		$getFromT->repost($post_id, $user_ID, $get_id, $comment);
	}
	if(isset($_POST['showPopup']) && !empty($_POST['showPopup'])){
		$post_id   = $_POST['showPopup'];
		$user       = $getFromU->userData($user_ID);
		$post      = $getFromT->getPopupPost($post_id);
	
?>
<div class="repost-popup">
<div class="wrap5">
	<div class="repost-popup-body-wrap">
		<div class="repost-popup-heading">
			<h3>Repost this to followers?</h3>
			<span><button class="close-repost-popup"><i class="fa fa-times" aria-hidden="true"></i></button></span>
		</div>
		<div class="repost-popup-input">
			<div class="repost-popup-input-inner">
				<input class="retweetMsg" type="text" placeholder="Add a comment.."/>
			</div>
		</div>
		<div class="repost-popup-inner-body">
			<div class="repost-popup-inner-body-inner">
				<div class="repost-popup-comment-wrap">
					 <div class="repost-popup-comment-head">
					 	<img src="<?php echo BASE_URL.$post->profileImage?>"/>
					 </div>
					 <div class="repost-popup-comment-right-wrap">
						 <div class="repost-popup-comment-headline">
						 	<a><?php echo $post->screenName;?> </a><span>‏@<?php echo $post->username;?> <?php echo $post->postedOn;?></span>
						 </div>
						 <div class="repost-popup-comment-body">
						 	<?php echo $post->status;?>  | <?php echo $post->postImage;?>
						 </div>
					 </div>
				</div>
			</div>
		</div>
		<div class="repost-popup-footer"> 
			<div class="repost-popup-footer-right">
				<button class="repost-it" data-post="<?php echo $post->postID;?>" data-user="<?php echo $post->user_ID;?>" type="submit"><i class="fa fa-repost" aria-hidden="true"></i>Repost</button>
			</div>
		</div>
	</div>
</div>
</div><!-- Retweet PopUp ends-->
<?php }?>
