<?php 

	include 'core/init.php';
	$user_ID = $_SESSION['user_id'];
	$user    = $getFromU->userData($user_ID);
	$notify  = $getFromM->getNotificationCount($user_ID);


	if($getFromU->loggedIn() === false){
		header('Location: index.php');
	}

	if(isset($_POST['submit'])){
		$username  = $_POST['username'];
		$email     = $_POST['email'];
 		$error     = array();

		if(!empty($username) && !empty($email)){
			if($user->username != $username and $getFromU->checkUsername($username) === true){
				$error['username'] = "Username is not available";
			}
			if(preg_match("/[^a-zA-Z0-9\!]/", $username)){
				$error['username']  = "Only characters and numbers allowed";
			}else if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
				$error['email'] = "Invalid email format";
			}else if($user->email != $email and $getFromU->checkEmail($email) === true){
				$error['email'] = "Email is already in use";
			}else{
				$getFromU->update('users', $user_ID, array('username' => $username, 'email' => $email));
				header('Location:'.BASE_URL.'settings/account');
			}
		}else{
			$error['fields']  = "Please fill all the fields";
		}
	}
?>
<html>
	<head>
		<title>Accounts Settings</title>
		<meta charset="UTF-8" />
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>
		<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
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
				<li><a href="<?php echo BASE_URL;?>"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
				<?php if($getFromU->loggedIn()=== true){?>
					<li><a href="<?php echo BASE_URL;?>i/notifications"><i class="fa fa-bell" aria-hidden="true"></i>Notifications<span id="notificaiton"><?php if($notify->totalN > 0){echo '<span class="span-i">'.$notify->totalN.'</span>';}?></span></a></li>
					<li id="messagePopup"><i class="fa fa-envelope" aria-hidden="true"></i>Messages<span id="messages"><?php if($notify->totalM > 0){echo '<span class="span-i">'.$notify->totalM.'</span>';}?></span></li>
				<?php }?>
			</ul>
		</div><!-- nav left ends-->
		<div class="nav-right">
			<ul>
				<li><input type="text" placeholder="Search" class="search"/><i class="fa fa-search" aria-hidden="true"></i>
					<div class="search-result"> 			
					</div>
				</li>
			<?php if($getFromU->loggedIn() === true){?>
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
				<li><label class="addTweetBtn" for="pop-up-tweet">Post</label></li>
				<?php } else{
							echo '<li><a href="'.BASE_URL.'/index.php">Have an account? Log in!</a></li>';
						}
				?>
			</ul>
		</div><!-- nav right ends-->
	</div><!-- nav ends -->
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/popupForm.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/hashtag.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/search.js"></script>
	<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/notification.js"></script>

	</div><!-- nav container ends -->
</div><!-- header wrapper end -->
<div class="container-wrap">
	<div class="lefter">
		<div class="inner-lefter">
			<div class="acc-info-wrap">
				<div class="acc-info-bg">
					<img src="<?php echo BASE_URL.$user->profileCover;?>"/>
				</div>
				<div class="acc-info-img">
					<img src="<?php echo BASE_URL.$user->profileImage;?>"/>
				</div>
				<div class="acc-info-name">
					<h3><?php echo $user->screenName;?></h3>
					<span><a href="#">@<?php echo $user->username;?></a></span>
				</div>
			</div>

				</div><!--Acc info wrap end-->

				<div class="option-box">
					<ul> 
					<li>
							<a href="<?php echo BASE_URL?>settings/account" class="bold">
							<div>
								Account
								<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
							</div>
							</a>
						</li>
						<li>
							<a href="<?php echo BASE_URL?>settings/password">
							<div>
								password
								<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
							</div>
							</a>
						</li>
						<li>
							<a href="<?php echo BASE_URL;?>settings/account">
							<div>
								Selling
								<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
							</div>
							</a>
						</li>
						<li>
							<a href="<?php echo BASE_URL?>settings/account">
							<div>
								Payments
								<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
							</div>
							</a>
						</li>
						<li>
							<a href="<?php echo BASE_URL?>settings/account">
							<div>
								Activate sellers account 
								<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
							</div>
							</a>
						</li>
						<li>
							<a href="<?php echo BASE_URL?>settings/account">
							<div>
								Ads
								<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
							</div>
							</a>
						</li>
						<li>
							<a href="<?php echo BASE_URL?>settings/account" >
							<div>
							Privacy and Security
								<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
							</div>
							</a>
						</li>
						<li>
							<a href="<?php echo BASE_URL?>settings/account">
							<div>
							Invite friends to plateform
								<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
							</div>
							</a>
						</li>
						<li>
							<a href="<?php echo BASE_URL?>about.html">
							<div>
								About
								<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
								
							</div>
							</a>
						</li>
						<li>
							<a href="<?php echo BASE_URL?>contacts.html" >
							<div>
								Help?
								<span><i class="fa fa-angle-right" aria-hidden="true"></i></span>
							</div>
							</a>
						</li>
					</ul>
				</div>

			</div>
		</div><!--LEFTER ENDS-->
		
		<div class="righter">
			<div class="inner-righter">
				<div class="acc">
					<div class="acc-heading">
						<h2>Account</h2>
						<h3>Change your basic account settings.</h3>
					</div>
					<div class="acc-content">
					<form method="POST">
						<div class="acc-wrap">
							<div class="acc-left">
								Username
							</div>
							<div class="acc-right">
								<input type="text" name="username" value="<?php echo $user->username;?>"/>
								<span>
								<?php if(isset($error['username'])){echo $error['username'];}?>
								</span>
							</div>
						</div>

						<div class="acc-wrap">
							<div class="acc-left">
								Email
							</div>
							<div class="acc-right">
								<input type="text" name="email" value="<?php echo $user->email;?>"/>
								<span>
									<?php if(isset($error['email'])){echo $error['email'];}?>
								</span>
							</div>
						</div>
						<div class="acc-wrap">
							<div class="acc-left">
								
							</div>
							<div class="acc-right">
								<input type="Submit" name="submit" value="Save changes"/>
							</div>
							<div class="settings-error">
								<?php if(isset($error['fields'])){echo $error['fields'];}?>
   							</div>	
						</div>
					</form>
					</div>
				</div>
				<div class="content-setting">
					<div class="content-heading">
						
					</div>
					<div class="content-content">
						<div class="content-left">
							
						</div>
						<div class="content-right">
							
						</div>
					</div>
				</div>
			</div>	
		</div><!--RIGHTER ENDS-->
		<div class="popupTweet"></div>
		<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/messages.js"></script>
		
	</div>
	<!--CONTAINER_WRAP ENDS-->

	</div><!-- ends wrapper -->
</body>

</html>

