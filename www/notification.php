<?php 

	include 'core/init.php';
 	$user_ID = $_SESSION['user_id'];
	$user    = $getFromU->userData($user_ID);
	$getFromM->notificationViewed($user_ID);
	$notify  = $getFromM->getNotificationCount($user_ID);
	if($getFromU->loggedIn() === false){
		header('Location: index.php');
	}
	$notification  = $getFromM->notification($user_ID);
 
 ?>

<!DOCTYPE html> 
 <html>
	<head>
		<title>Notifications</title>
		  <meta charset="UTF-8" />
		  <script src="https://code.jquery.com/jquery-3.1.1.min.js"  integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
 		  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>
 	  	  <link rel="stylesheet" href="<?php echo BASE_URL;?>assets/css/style-complete.css"/> 
 	</head>
	<!--Helvetica Neue-->
<body>
<div class="wrapper">
<!-- header wrapper -->
<div class="header-wrapper">

<div class="nav-container">
	<!-- Nav -->
	<div class="nav">
		
		<div class="nav-left">
			<ul>
				<li><a href="<?php echo BASE_URL;?>home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
				<?php if($getFromU->loggedIn()=== true){?>
				<li><a href="<?php echo BASE_URL;?>i/notifications"><i class="fa fa-bell" aria-hidden="true"></i>Notifications<span id="notification"><?php if($notify->totalN > 0){echo '<span class="span-i">'.$notify->totalN.'</span>';}?></span></a></li>
				<li id="messagePopup"><i class="fa fa-envelope" aria-hidden="true"></i>Messages<span id="messages"><?php if($notify->totalM > 0){echo '<span class="span-i">'.$notify->totalM.'</span>';}?></span></li>
				<?php }?>

			</ul>
		</div><!-- nav left ends-->

		<div class="nav-right">
			<ul>
				<li>
					<input type="text" placeholder="Search" class="search"/>
					<i class="fa fa-search" aria-hidden="true"></i>
					<div class="search-result">			
					</div>
				</li>

				<li class="hover"><label class="drop-label" for="drop-wrap1"><img src="<?php echo BASE_URL.$user->profileImage;?>"/></label>
				<input type="checkbox" id="drop-wrap1">
				<div class="drop-wrap">
					<div class="drop-inner">
						<ul>
							<li><a href="<?php echo BASE_URL.$user->username;?>"><?php echo $user->username;?></a></li>
							<li><a href="<?php echo BASE_URL;?>settings/account">Settings</a></li>
							<li><a href="<?php echo BASE_URL;?>includes/logout.php">Log out</a></li>
						</ul>
					</div>
				</div>
				</li>
				<li><label  class="addTweetBtn" for="pop-up-tweet">Post</label></li>
			</ul>
		</div><!-- nav right ends-->

	</div><!-- nav ends -->

</div><!-- nav container ends -->	
</div><!-- header wrapper end -->

<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/search.js"></script>	
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/like.js"></script>	
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/retweet.js"></script>	
 
  		
<!---Inner wrapper-->
<div class="inner-wrapper">
<div class="in-wrapper">
	<div class="in-full-wrap">
		<div class="in-left">
			<div class="in-left-wrap">
		<div class="info-box">
			<div class="info-inner">
				<div class="info-in-head">
					<img src="<?php echo BASE_URL.$user->profileCover;?>"/>
				</div><!-- info in head end -->
				<div class="info-in-body">
					<div class="in-b-box">
						<div class="in-b-img">
							<img src="<?php echo BASE_URL.$user->profileImage;?>"/>
						</div>
					</div><!--  in b box end-->
					<div class="info-body-name">
						<div class="in-b-name">
							<div><a href="<?php echo BASE_URL.$user->username;?>"><?php echo $user->screenName;?></a></div>
							<span><small><a href="<?php echo BASE_URL.$user->username;?>">@<?php echo $user->username;?></a></small></span>
						</div><!-- in b name end-->
					</div><!-- info body name end-->
				</div><!-- info in body end-->
				<div class="info-in-footer">
					<div class="number-wrapper">
						<div class="num-box">
							<div class="num-head">
								POSTS
							</div>
							<div class="num-body">
								<?php $getFromT->countPosts($user_ID);?>
							</div>
						</div>
						<div class="num-box">
							<div class="num-head">
								FOLLOWING
							</div>
							<div class="num-body">
								<span class="count-following"><?php echo $user->following;?></span>
							</div>
						</div>
						<div class="num-box">
							<div class="num-head">
								FOLLOWERS
							</div>
							<div class="num-body">
								<span class="count-followers"><?php echo $user->followers;?></span>
							</div>
						</div>	
					</div><!-- mumber wrapper-->
				</div><!-- info in footer -->
			</div><!-- info inner end -->
		</div><!-- info box end-->

	<!--==TRENDS==-->
 	 <?php $getFromT->trends();?>
  	<!--==TRENDS==-->

	</div><!-- in left wrap-->
		</div><!-- in left end-->
		<div class="in-center">
			<div class="in-center-wrap">
				
			<!--NOTIFICATION WRAPPER FULL WRAPPER-->
			<div class="notification-full-wrapper">

				<div class="notification-full-head">
					<div>
						<a href="#">All</a>
					</div>
					<div>
						<a href="#">Mention</a>
					</div>
					<div>
						<a href="#">settings</a>
					</div>
				</div>
		<?php foreach($notification as $data) :?>
			<?php if($data->type == 'follow') :?>
			<!-- Follow Notification -->
			<!--NOTIFICATION WRAPPER-->
			<div class="notification-wrapper">
				<div class="notification-inner">
					<div class="notification-header">
						
						<div class="notification-img">
							<span class="follow-logo">
								<i class="fa fa-child" aria-hidden="true"></i>
							</span>
						</div>
						<div class="notification-name">
							<div>
								 <img src="<?php echo BASE_URL.$data->profileImage;?>"/>
							</div>
						 
						</div>
						<div class="notification-tweet"> 
						<a href="<?php echo BASE_URL.$data->username;?>" class="notifi-name"><?php echo $data->screenName;?></a><span> Followed you - <span><?php echo $getFromU->timeAgo($data->time);?></span>
						
						</div>
					
					</div>
					
				</div>
				<!--NOTIFICATION-INNER END-->
			</div>
			<!--NOTIFICATION WRAPPER END-->
			<!-- Follow Notification -->
		<?php endif;?>

		<?php if($data->type == 'like') :?>
			<!-- Like Notification -->
			<!--NOTIFICATION WRAPPER-->
			<div class="notification-wrapper">
				<div class="notification-inner">
					<div class="notification-header">
						<div class="notification-img">
							<span class="heart-logo">
								<i class="fa fa-heart" aria-hidden="true"></i>
							</span>
						</div>
						<div class="notification-name">
							<div>
								 <img src="<?php echo BASE_URL.$data->profileImage;?>"/>
							</div>
						</div>
					</div>
					<div class="notification-tweet"> 
						<a href="<?php echo BASE_URL.$data->profileImage;?>" class="notifi-name"><?php echo $data->screenName;?></a><span> liked your <?php if($data->postBy === $user_ID){echo 'Post';}else{echo 'Repost';}?> - <span><?php echo $getFromU->timeAgo($data->time);?></span>
					</div>
					<div class="notification-footer">
						<div class="noti-footer-inner">
							<div class="noti-footer-inner-left">
								<div class="t-h-c-name">
									<span><a href="<?php echo BASE_URL.$user->username;?>"><?php echo $user->username;?></a></span>
									<span>@<?php echo $user->username;?></span>
									<span><?php echo $getFromU->timeAgo($data->postedOn);?></span>
								</div>
								<div class="noti-footer-inner-right-text">		
									<?php echo $getFromT->getPostlinks($data->status);?>
								</div>
							</div>
							<?php if(!empty($data->postImage)) :?>
							<div class="noti-footer-inner-right">
								<img src="<?php echo BASE_URL.$data->postImage;?>"/>	
							</div>
							<?php endif;?> 

						</div><!--END NOTIFICATION-inner-->
					</div>
				</div>
			</div>
			<!--NOTIFICATION WRAPPER END--> 
			<!-- Like Notification -->
		<?php endif;?>

		<?php if($data->type == 'repost') :?>
			<!-- Retweet Notification -->
			<!--NOTIFICATION WRAPPER-->
			<div class="notification-wrapper">
				<div class="notification-inner">
					<div class="notification-header">
						
						<div class="notification-img">
							<span class="retweet-logo">
								<i class="fa fa-retweet" aria-hidden="true"></i>
							</span>
						</div>
					<div class="notification-tweet"> 
						<a href="<?php echo BASE_URL.$data->username;?>" class="notifi-name"><?php echo $data->screenName;?></a><span> repost your <?php if($data->postBy === $user_ID){echo 'Post';}else{echo 'Repost';}?> - <span><?php echo $getFromU->timeAgo($data->time);?></span>
					</div>
					<div class="notification-footer">
						<div class="noti-footer-inner">

							<div class="noti-footer-inner-left">
								<div class="t-h-c-name">
									<span><a href="<?php echo BASE_URL.$user->username;?>"><?php echo $user->screenName;?></a></span>
									<span>@<?php echo $user->username;?></span>
									<span><?php echo $getFromU->timeAgo($data->postedOn);?></span>
								</div>
								<div class="noti-footer-inner-right-text">		
									<?php echo $getFromT->getPostLinks($data->status)?>
								</div>
							</div>

						 
							<?php if(!empty($data->postImage)) :?>
							<div class="noti-footer-inner-right">
								<img src="<?php echo BASE_URL.$data->postImage;?>"/>	
							</div>
							<?php endif;?> 

						</div><!--END NOTIFICATION-inner-->
					</div>
					</div>
				</div>
			</div>
			<!--NOTIFICATION WRAPPER END-->
			<!-- Retweet Notification -->
		<?php endif;?>

		<?php if($data->type == 'mention') :?>
			<?php 
			$post = $data;
			$likes        = $getFromT->likes($user_ID, $post->postID);
			$repost      = $getFromT->checkRepost($post->postID, $user_ID);
    			echo '<div class="all-tweet-inner">
					<div class="t-show-wrap">	
					 <div class="t-show-inner"> 
							<div class="t-show-popup" data-tweet="'.$post->postID.'" data-user="'.$post->postBy.'">
								<div class="t-show-head">
									<div class="t-show-img">
										<img src="'.BASE_URL.$post->profileImage.'"/>
									</div>
									<div class="t-s-head-co	ntent">
										<div class="t-h-c-name">
											<span><a href="'.BASE_URL.$post->username.'">'.$post->screenName.'</a></span>
											<span>@'.$post->username.'</span>
											<span>'.$getFromT->timeAgo($post->postedOn).'</span>
										</div>
										<div class="t-h-c-dis">
											'.$getFromT->getPostLinks($post->status).'
										</div>
									</div>
								</div>'.

						 ((!empty($post->postImage)) ?  
					       '<div class="t-show-body">
								  <div class="t-s-b-inner">
									   <div class="t-s-b-inner-in">
									     <img src="'.BASE_URL.$post->postImage.'" class="imagePopup" data-tweet="'.$post->postID.'" data-user="'.$post->postBy.'"/>
									   </div>
								  </div>	
							   </div>' : '' ) .'
						
				       </div>
						<div class="t-show-footer">
							<div class="t-s-f-right">
								<ul> 
									<li><button><i class="fa fa-share" aria-hidden="true"></i></button></li>	
									<li>'.(($post->postID === $repost['retweetID'] OR $user_ID === $repost['retweetBy']) ? '<button class="retweeted" data-tweet="'.$post->postID.'" data-user="'.$post->postBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($post->repostCount > 0) ? $post->repostCount : '').'</span></button>' : '<button class="retweet" data-tweet="'.$post->postID.'" data-user="'.$post->postBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($post->repostCount > 0) ? $post->repostCount : '').'</span></button>').'</li>
									<li>'.(($likes['likeOn'] == $post->postID) ? '<button class="unlike-btn" data-tweet="'.$post->postID.'" data-user="'.$post->postBy.'"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCounter">'.(($post->likesCount > 0) ? $post->likesCount : '').'</span></button>' : '<button class="like-btn" data-tweet="'.$post->postID.'" data-user="'.$post->postBy.'"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($post->likesCount > 0) ? $post->likesCount : '').'</span></button>').'</li>
									'.(($post->postBy === $user_ID) ? ' 
									<li>
										<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
										<ul> 
										  <li><label class="deleteTweet" data-tweet="'.$post->postID.'">Delete Post</label></li>
										</ul>
									</li>' : '').'
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>';		 
			?>
		<?php endif;?>
		<?php endforeach;?>
			</div>
			<!--NOTIFICATION WRAPPER FULL WRAPPER END-->

		    	<div class="loading-div">
		    		<img id="loader" src="<?php echo BASE_URL;?>assets/images/loading.svg" style="display: none;"/> 
		    	</div>
				<div class="popupTweet"></div>
				<!--Tweet END WRAPER-->
				<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/popuptweets.js"></script>
				<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/hashtag.js"></script>
				<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/delete.js"></script>
				<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/popupForm.js"></script>
				<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/messages.js"></script>
				<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/postMessage.js"></script>
				<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/notification.js"></script>
     			</div><!-- in left wrap-->
		</div><!-- in center end -->

		<div class="in-right"	>
			<div class="in-right-wrap">

		 	<!--Who To Follow-->
 		      <?php $getFromF->whoToFollow($user_ID, $user_ID);?>
      		<!--Who To Follow-->

 			</div><!-- in left wrap-->
 			<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/follow.js"></script>
		</div><!-- in right end -->

	</div><!--in full wrap end-->

</div><!-- in wrappper ends-->
</div><!-- inner wrapper ends-->
</div><!-- ends wrapper -->
</body>
</html>