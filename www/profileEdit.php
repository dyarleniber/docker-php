<?php 

	include 'core/init.php';
	if($getFromU->loggedIn() === false){
		header('Location: index.php');
	}

	$user_ID = $_SESSION['user_id'];
	$user    = $getFromU->userData($user_ID);
	$notify  = $getFromM->getNotificationCount($user_ID);

 
	if(isset($_POST['screenName'])){
		if(!empty($_POST['screenName'])){
			$screenName  = $getFromU->checkInput($_POST['screenName']);
			$profileBio  = $getFromU->checkInput($_POST['bio']);
			$country     = $getFromU->checkInput($_POST['country']);
			$website     = $getFromU->checkInput($_POST['website']);

			if(strlen($screenName) > 20){
				$error  = "Name must be between in 6-20 characters";
			}else if(strlen($profileBio) > 120){
				$error = "Description is too long";
			}else if(strlen($country) > 80){
				$error = "Country name is too long";
			}else {
				 $getFromU->update('users', $user_ID, array('screenName' => $screenName, 'bio' => $profileBio, 'country' => $country, 'website' => $website));
				 header('Location:'.$user->username);
			}
		}else{
			$error = "Name field can't be blink";
		}
	}

	if(isset($_FILES['profileImage'])){
		if(!empty($_FILES['profileImage']['name'][0])){
			$fileRoot  = $getFromU->uploadImage($_FILES['profileImage']);
			$getFromU->update('users', $user_ID, array('profileImage' => $fileRoot));
		}
	}


	if(isset($_FILES['profileCover'])){
		if(!empty($_FILES['profileCover']['name'][0])){
			$fileRoot  = $getFromU->uploadImage($_FILES['profileCover']);
			$getFromU->update('users', $user_ID, array('profileCover' => $fileRoot));
		}
	}
?>
<!doctype html>
<html>
<head>
	<title>Edit Profile - PopularNetwork</title>
	<meta charset="UTF-8" />
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>
	<link rel="stylesheet" href="assets/css/style-complete.css"/>
	<script src="https://code.jquery.com/jquery-3.1.1.js" integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>
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
			   <li><a href="<?php echo BASE_URL;?>"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
				<?php if($getFromU->loggedIn()=== true){?>
					<li><a href="<?php echo BASE_URL;?>i/notifications"><i class="fa fa-bell" aria-hidden="true"></i>Notifications<span id="notificaiton"><?php if($notify->totalN > 0){echo '<span class="span-i">'.$notify->totalN.'</span>';}?></span></a></li>
					<li id="messagePopup"><i class="fa fa-envelope" aria-hidden="true"></i>Messages<span id="messages"><?php if($notify->totalM > 0){echo '<span class="span-i">'.$notify->totalM.'</span>';}?></span></li>
				<?php }?>
			</ul>
		</div>
		<!-- nav left ends-->
		<div class="nav-right">
			<ul>
				<li><input type="text" placeholder="Search" class="search"/><i class="fa fa-search" aria-hidden="true"></i>
				<div class="search-result">
					 			
				</div></li>
				<li class="hover"><label class="drop-label" for="drop-wrap1"><img src="<?php echo $user->profileImage;?>"/></label>
				<input type="checkbox" id="drop-wrap1">
				<div class="drop-wrap">
					<div class="drop-inner">
						<ul>
							<li><a href="<?php echo $user->username;?>"><?php echo $user->username;?></a></li>
							<li><a href="settings/account">Settings</a></li>
							<li><a href="includes/logout.php">Log out</a></li>
						</ul>
					</div>
				</div>
				</li>
				<li><label for="pop-up-tweet">Post</label></li>
			</ul>
		</div>
		<!-- nav right ends-->
	</div>
	<!-- nav ends -->
</div>
<!-- nav container ends -->
</div>
<!-- header wrapper end -->
 <script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/notification.js"></script>

<!--Profile cover-->
<div class="profile-cover-wrap"> 
<div class="profile-cover-inner">
	<div class="profile-cover-img">
		<img src="<?php echo $user->profileCover;?>"/>
		<!-- profileCover -->

		<div class="img-upload-button-wrap">
			<div class="img-upload-button1">
				<label for="cover-upload-btn">
					<i class="fa fa-camera" aria-hidden="true"></i>
				</label>
				<span class="span-text1">
					Change your profile photo
				</span>
				<input id="cover-upload-btn" type="checkbox"/>
				<div class="img-upload-menu1">
					<span class="img-upload-arrow"></span>
					<form method="post" enctype="multipart/form-data">
						<ul>
							<li>
								<label for="file-up">
									Upload photo
								</label>
								<input type="file" onchange="this.form.submit();" name="profileCover" id="file-up" />
							</li>
								<li>
								<label for="cover-upload-btn">
									Cancel
								</label>
							</li>
						</ul>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="profile-nav">
	<div class="profile-navigation">
		<ul>
			<li>
				<a href="#">
					<div class="n-head">
						POSTS
					</div>
					<div class="n-bottom">
					  <?php $getFromT->countPosts($user_ID); ?>
					</div>
				</a>
			</li>
			<li>
				<a href="#">
					<div class="n-head">
						FOLLOWINGS
					</div>
					<div class="n-bottom">
						<?php echo $user->following;?>
					</div>
				</a>
			</li>
			<li>
				<a href="#">
					<div class="n-head">
						FOLLOWERS
					</div>
					<div class="n-bottom">
						<?php echo $user->followers;?>
					</div>
				</a>
			</li>
			<li>
				<a href="#">
					<div class="n-head">
						LIKES
					</div>
					<div class="n-bottom">
						<?php $getFromT->countPosts($user_ID); ?>
					</div>
				</a>
			</li>
			
		</ul>
		<div class="edit-button">
			<span>
				<button class="f-btn" type="button" onclick="window.location.href='<?php echo BASE_URL.$user->username;?>'" value="Cancel">Cancel</button>
			</span>
			<span>
				<input type="submit" id="save" value="Save Changes">
			</span>
		 
		</div>
	</div>
</div>
</div><!--Profile Cover End-->

<div class="in-wrapper">
<div class="in-full-wrap">
  <div class="in-left">
	<div class="in-left-wrap">
		<!--PROFILE INFO WRAPPER END-->
<div class="profile-info-wrap">
	<div class="profile-info-inner">
		<div class="profile-img">
			<img src="<?php echo $user->profileImage;?>"/>
			<!-- profileImage -->
			<div class="img-upload-button-wrap1">
			 <div class="img-upload-button">
				<label for="img-upload-btn">
					<i class="fa fa-camera" aria-hidden="true"></i>
				</label>
				<span class="span-text">
					Change your profile photo
				</span>
				<input id="img-upload-btn" type="checkbox"/>
				<div class="img-upload-menu">
				 <span class="img-upload-arrow"></span>
					<form method="post" enctype="multipart/form-data">
						<ul>
							<li>
								<label for="profileImage">
									Upload photo
								</label>
								<input id="profileImage" type="file"  onchange="this.form.submit();" name="profileImage"/>
								
							</li>
							<li><a href="#">Remove</a></li>
							<li>
								<label for="img-upload-btn">
									Cancel
								</label>
							</li>
						</ul>
					</form>
				</div>
			  </div>
			  <!-- img upload end-->
			</div>
		</div>

			    <form id="editForm" method="post" enctype="multipart/Form-data">	
  				<?php if(isset($imgError)){echo '<li>'.$imgError.'</li>';}?>
  				<div class="profile-name-wrap">
					<div class="profile-name">
						<input type="text" name="screenName" value="<?php echo $user->screenName;?>"/>
					</div>
					<div class="profile-tname">
						@<?php echo $user->username;?>
					</div>
				</div>
				<div class="profile-bio-wrap">
					<div class="profile-bio-inner">
						<textarea class="status" name="bio"><?php echo $user->bio;?></textarea>
						<div class="hash-box">
					 		<ul>
					 		</ul>
					 	</div>
					</div>
				</div>
					<div class="profile-extra-info">
					<div class="profile-extra-inner">
						<ul>
							<li>
								<div class="profile-ex-location">
									<input id="cn" type="text" name="country" placeholder="Country" value="<?php echo $user->country;?>" />
								</div>
							</li>
							<li>
								<div class="profile-ex-location">
									<input type="text" name="website" placeholder="Website" value="<?php echo $user->website;?>"/>
								</div>
							</li>
							<?php if(isset($error)){echo '<li>'.$error.'</li>';}?>
 				</form>
							<script type="text/javascript">
								$('#save').click(function(){
									$('#editForm').submit();
								}); 
							</script>
						</ul>						
					</div>
				</div>
				<div class="profile-extra-footer">
					<div class="profile-extra-footer-head">
						<div class="profile-extra-info">
							<ul>
								<li>
									<div class="profile-ex-location-i">
										<i class="fa fa-camera" aria-hidden="true"></i>
									</div>
									<div class="profile-ex-location">
										<a href="#">0 Photos and videos </a>
									</div>
								</li>
							</ul>
						</div>
					</div>
					<div class="profile-extra-footer-body">
						<ul>
						  <!-- <li><img src="#"></li> -->
						</ul>
					</div>
				</div>
			</div>
			<!--PROFILE INFO INNER END-->
		</div>
		<!--PROFILE INFO WRAPPER END-->
	</div>
	<!-- in left wrap-->
</div>
<!-- in left end-->

<div class="in-center">
	<div class="in-center-wrap">	
	<?php
	   $tweets = $getFromT->getUserPosts($user_ID); 
		 
		 foreach ($tweets as $post) {
			$likes        = $getFromT->likes($user_ID, $post->postID);
			$repost      = $getFromT->checkRetweet($post->postID, $user_ID);
			$user         = $getFromT->userData($post->repostBy);
   			
   			echo '<div class="all-tweet">
					<div class="t-show-wrap">	
					 <div class="t-show-inner">
   							'.(($repost['retweetID'] === $post->repostID or $post->repostID > 0) ? ' 
	 							<div class="t-show-popup" data-tweet="'.$post->postID.'" data-user="'.$post->repostBy.'">
	 							<div class="t-show-banner">
									<div class="t-show-banner-inner">
										<span><i class="fa fa-retweet" aria-hidden="true"></i></span><span>'.$user->screenName.'. Retweeted</span>
									</div>
								</div>' : '').'
					 		 '.((!empty($repost['retweetMsg']) && $post->postID === $repost['postID'] or $post->repostID > 0) ? '<div class="t-show-head">
 							<div class="t-show-img">
								<img src="'.$user->profileImage.'"/>
							</div>
							<div class="t-s-head-content">
								<div class="t-h-c-name">
									<span><a href="'.BASE_URL.$user->username.'">'.$user->screenName.'</a></span>
									<span>@'.$user->username.' </span>
									<span>'.$getFromT->timeAgo($repost['postedOn']).'</span>
								</div>
								<div class="t-h-c-dis">
									'.$getFromT->getPostLinks($post->repostMsg).'
								</div>
							</div>
						</div>
						<div class="t-s-b-inner">
							<div class="t-s-b-inner-in">
								<div class="retweet-t-s-b-inner">
									'.((!empty($post->postImage)) ? ' 
									<div class="retweet-t-s-b-inner-left">
										<img src="'.$post->postImage.'"/>	
									</div>' : '').'
									<div>
										<div class="t-h-c-name">
											<span><a href="#">'.$post->screenName.'</a></span>
											<span>@'.$post->username.'</span>
											<span>'.$getFromT->timeAgo($post->postedOn).'</span>
										</div>
										<div class="retweet-t-s-b-inner-right-text">		
											'.$getFromT->getTweetLinks($post->status).'
										</div>
									</div>
								</div>
							</div>
						</div>
						</div>
						' : ' 
							<div class="t-show-popup" data-tweet="'.$post->postID.'" data-user="'.$post->postBy.'">
								<div class="t-show-head">
									<div class="t-show-img">
										<img src="'.$post->profileImage.'"/>
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
										     <img src="'.$post->postImage.'" class="imagePopup" data-tweet="'.$post->postID.'" data-user="'.$post->postBy.'"/>
										   </div>
									  </div>	
								   </div>' : '' ) .'
						
				       </div>').'
						<div class="t-show-footer">
							<div class="t-s-f-right">
								<ul> 
									<li><button><i class="fa fa-share" aria-hidden="true"></i></button></li>	
									<li>'.(($post->postID === $repost['retweetID'] OR $user_ID === $repost['repostBy']) ? 
										'<button class="retweeted" data-tweet="'.$post->postID.'" data-user="'.$post->postBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($post->repostCount > 0) ? $post->repostCount : '').'</span></button>' : 
										'<button class="retweet" data-tweet="'.$post->postID.'" data-user="'.$post->postBy.'"><i class="fa fa-retweet" aria-hidden="true"></i><span class="retweetsCount">'.(($post->repostCount > 0) ? $post->repostCount : '').'</span></button>').'
									</li>
									
									<li>'.(($likes['likeOn'] == $post->postID) ? 
										'<button class="unlike-btn" data-tweet="'.$post->postID.'" data-user="'.$post->postBy.'"><i class="fa fa-heart" aria-hidden="true"></i><span class="likesCounter">'.(($post->likesCount > 0) ? $post->likesCount : '').'</span></button>' : 
										'<button class="like-btn" data-tweet="'.$post->postID.'" data-user="'.$post->postBy.'"><i class="fa fa-heart-o" aria-hidden="true"></i><span class="likesCounter">'.(($post->likesCount > 0) ? $post->likesCount : '').'</span></button>').'
									</li>
										
									'.(($post->postBy === $user_ID) ? ' 
									<li>
										<a href="#" class="more"><i class="fa fa-ellipsis-h" aria-hidden="true"></i></a>
										<ul> 
										  <li><label class="deleteTweet" data-tweet="'.$post->postID.'">Delete Tweet</label></li>
										</ul>
									</li>' : '').'

								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>';
		}
		?>
	</div>
	<!-- in left wrap-->
<div class="popupTweet"></div>
</div>
<!-- in center end -->

<!-- Who to Follow & Trends Section -->
<div class="in-right">
	<div class="in-right-wrap">
	<?php $getFromF->whoToFollow($user_ID,$user_ID);?>
 
 	<?php $getFromT->trends(); ?>

	</div>
	<!-- in left wrap-->
</div>
<!-- in right end -->

<!-- SCRIPTS -->
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/popuptweets.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/delete.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/popupForm.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/retweet.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/like.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/hashtag.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/search.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/follow.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/messages.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/postMessage.js"></script>
 

   </div>
   <!--in full wrap end-->
 
  </div>
  <!-- in wrappper ends-->

</div>
<!-- ends wrapper -->
</body>
</html>