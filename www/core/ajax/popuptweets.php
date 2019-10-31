<?php 
	include '../init.php';
	
	if(isset($_POST['showpopup']) && !empty($_POST['showpopup'])){
		$postID = $_POST['showpopup'];
		$user_id = @$_SESSION['user_id'];
		$post   = $getFromT->postPopup($postID);
		$user    = $getFromU->userData($user_id);
		$likes   = $getFromT->likes($user_id, $postID);
		$repost = $getFromT->checkRepost($postID,$user_id);
		$comments = $getFromT->comments($postID);

   	}
?>
<div class="tweet-show-popup-wrap">
<input type="checkbox" id="tweet-show-popup-wrap">
<div class="wrap4">
	<label for="tweet-show-popup-wrap">
		<div class="tweet-show-popup-box-cut">
			<i class="fa fa-times" aria-hidden="true"></i>
		</div>
	</label>
	<div class="tweet-show-popup-box">
	<div class="tweet-show-popup-inner">
		<div class="tweet-show-popup-head">
			<div class="tweet-show-popup-head-left">
				<div class="tweet-show-popup-img">
					<img src="<?php echo BASE_URL.$post->profileImage;?>"/>
				</div>
				<div class="tweet-show-popup-name">
					<div class="t-s-p-n">
						<a href="<?php echo BASE_URL.$post->username;?>">
							<?php echo $post->screenName;?>
						</a>
					</div>
					<div class="t-s-p-n-b">
						<a href="<?php echo BASE_URL.$post->username;?>">
							@<?php echo $post->username;?>
						</a>
					</div>
				</div>
			</div>
			<div class="tweet-show-popup-head-right">
			<?php echo $getFromF->followBtn($post->tweetBy, $user_id, $user_id);?>
 			</div>
		</div>
		<div class="tweet-show-popup-tweet-wrap">
			<div class="tweet-show-popup-tweet">
				<?php echo $getFromT->getTweetLinks($post->status);?>
			</div>
			<div class="tweet-show-popup-tweet-ifram">
			<?php 
				if(!empty($post->tweetImage)){
  			    	echo '<img src="'.$post->tweetImage.'"/>'; 
  				}
  			?>	
			</div>
		</div>
		<div class="tweet-show-popup-footer-wrap">
			<div class="tweet-show-popup-retweet-like">
				<div class="tweet-show-popup-retweet-left">
					<div class="tweet-retweet-count-wrap">
						<div class="tweet-retweet-count-head">
							RETWEET
						</div>
						<div class="tweet-retweet-count-body">
							<?php echo $post->retweetCount;?>
						</div>
					</div>
					<div class="tweet-like-count-wrap">
						<div class="tweet-like-count-head">
							LIKES
						</div>
						<div class="tweet-like-count-body">
							<?php echo $post->likesCount;?>
						</div>
					</div>
				</div>
				<div class="tweet-show-popup-retweet-right">
				 
				</div>
			</div>
			<div class="tweet-show-popup-time">
				<span><?php echo $getFromU->timeAgo($post->postedOn);?></span>
			</div>
			<div class="tweet-show-popup-footer-menu">
				<?php 
					echo '<ul> 
						'.(($getFromU->loggedIn()) ?   '
							<li><button><i class="fa fa-share" aria-hidden="true"></i></button></li>	
							<li>'.(($post->tweetID === $retweet['retweetID'] OR $user_id === $retweet['retweetBy']) ? '<button class="retweeted" data-tweet="'.$post->tweetID.'" data-user="'.$post->tweetBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($post->retweetCount > 0) ? $post->retweetCount : '').'</span></button>' : '<button class="retweet" data-tweet="'.$post->tweetID.'" data-user="'.$post->tweetBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($post->retweetCount > 0) ? $post->retweetCount : '').'</span></button>').'</li>
							<li>'.(($likes['likeOn'] == $post->tweetID) ? '<button class="unlike-btn" data-tweet="'.$post->tweetID.'" data-user="'.$post->tweetBy.'"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCounter">'.(($post->likesCount > 0) ? $post->likesCount : '' ).'</span></button>' : '<button class="like-btn" data-tweet="'.$post->tweetID.'" data-user="'.$post->tweetBy.'"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($post->likesCount > 0) ? $post->likesCount : '').'</span></button>').'</li>
							'.(($post->tweetBy === $user_id) ? ' 
							<li>
								<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
								<ul> 
								  <li><label class="deleteTweet" data-tweet="'.$post->tweetID.'">Delete Tweet</label></li>
								</ul>
							</li>' : '').'
						' : '
							<li><button><i class="fa fa-share" aria-hidden="true"></i></button></li>	
							<li><button><i class="fa fa-retweet" aria-hidden="true"></i></button></li>	
							<li><button><i class="fa fa-heart-o" aria-hidden="true"></i></button></li>	
						').'
						</ul>';
				?>
			</div>
		</div>
	</div><!--tweet-show-popup-inner end-->
	<?php if($getFromU->loggedIn() === true){?>
 	<div class="tweet-show-popup-footer-input-wrap">
		<div class="tweet-show-popup-footer-input-inner">
			<div class="tweet-show-popup-footer-input-left">
				<img src="<?php echo BASE_URL.$user->profileImage;?>"/>
			</div>
			<div class="tweet-show-popup-footer-input-right">
				<input id="commentField" type="text" name="comment"  data-tweet="<?php echo $post->tweetID;?>" placeholder="Reply to @<?php echo $post->username;?>">
			</div>
		</div>
		<div class="tweet-footer">
		 	<div class="t-fo-left">
		 		<ul>
		 			<li>
		 				<!-- <label for="t-show-file"><i class="fa fa-camera" aria-hidden="true"></i></label>
		 				<input type="file" id="t-show-file"> -->
		 			</li>
		 		</ul>
		 	</div>
		 	<div class="t-fo-right">
 		 		<input type="submit" id="postComment" value="Tweet">
 		 		<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/comment.js"></script>
 		 		<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/follow.js"></script>
  		 	</div>
		 </div>
	</div><!--tweet-show-popup-footer-input-wrap end-->
	<?php }?>

<div class="tweet-show-popup-comment-wrap">
	<div id="comments">
	 	<?php 
	 		foreach ($comments as $comment) {
	 			echo '<div class="tweet-show-popup-comment-box">
						<div class="tweet-show-popup-comment-inner">
							<div class="tweet-show-popup-comment-head">
								<div class="tweet-show-popup-comment-head-left">
									 <div class="tweet-show-popup-comment-img">
									 	<img src="'.BASE_URL.$comment->profileImage.'">
									 </div>
								</div>
								<div class="tweet-show-popup-comment-head-right">
									  <div class="tweet-show-popup-comment-name-box">
									 	<div class="tweet-show-popup-comment-name-box-name"> 
									 		<a href="'.BASE_URL.$comment->username.'">'.$comment->screenName.'</a>
									 	</div>
									 	<div class="tweet-show-popup-comment-name-box-tname">
									 		<a href="'.BASE_URL.$comment->username.'">@'.$comment->username.'</a>
									 	</div>
									 </div>
									 <div class="tweet-show-popup-comment-right-tweet">
									 		<p><a href="'.BASE_URL.$post->username.'">@'.$post->username.'</a> '.$comment->comment.'</p>
									 </div>
								 	<div class="tweet-show-popup-footer-menu">
										<ul>
											<li><button><i class="fa fa-share" aria-hidden="true"></i></button></li>
											<li><button><i class="fa fa-heart-o" aria-hidden="true"></i></button></li>
											'.(($comment->commentBy === $user_id) ?  
											'<li>
												<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
												<ul> 
												  <li><label class="deleteComment" data-tweet="'.$post->tweetID.'" data-comment="'.$comment->commentID.'">Delete Tweet</label></li>
												</ul>
											</li>' : '').'
										</ul>
									</div>
								</div>
							</div>
						</div>
						<!--TWEET SHOW POPUP COMMENT inner END-->
						</div>
						';
	 		}
	 	?>
	</div>

</div>
<!--tweet-show-popup-box ends-->
</div>
</div>