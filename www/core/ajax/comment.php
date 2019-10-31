<?php 
	include '../init.php';
 
	if(isset($_POST['comment']) && !empty($_POST['comment'])){
		$comment = $getFromU->checkInput($_POST['comment']);
		$user_ID = $_SESSION['user_ID'];
		$postID = $_POST['post_ID'];

		$getFromU->create('comments', array('comment' => $comment, 'commentOn' => $postID, 'commentBy' => $user_ID));
		$comments = $getFromT->comments($postID);
		$post = $getFromT->postPopup($postID);

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
											<li><a href="#"><i class="fa fa-heart-o" aria-hidden="true"></i></a></li>
											'.(($comment->commentBy === $user_ID) ?  
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
						<!--POST SHOW POPUP COMMENT inner END-->
						</div>
						';
	 		}
	}
?>