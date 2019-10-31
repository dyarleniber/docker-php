<?php
if(isset($_GET['step']) === true && empty($_GET['step']) === false){
include '../core/init.php';
if (isset($_SESSION['user_id']) === false) {
  header('Location: ../index.php');
}

$user_id = $_SESSION['user_id'];
$user = $getFromU->userData($user_id);
$step = $_GET['step'];

if(isset($_POST['next'])){
  $username = $getFromU->checkInput($_POST['username']);

  if (!empty($username)) {
    if(strlen($username) > 20){
      $error = "Username must be between in 6-20 characters";
    }else if(!preg_match('/^[a-zA-Z0-9]{6,}$/', $username)){
      $error = 'Username must be longer than 6 alphanumeric characters without any spaces';
    } else if($getFromU->checkUsername($username) === true){
      $error = "Username is already taken!";
    }else{
      $getFromU->update('users', $user_id, array('username' => $username));
      header('Location: signup.php?step=2');
    }
  }else{
    $error = "Please enter your username to choose";
  }
}
  ?>
  <!doctype html>
  <html>
  	<head>
  		<title>Popular Network</title>
  		<meta charset="UTF-8" />
   		<link rel="stylesheet" href="../assets/css/style-complete.css"/>
  	</head>
  	<!--Helvetica Neue-->
  <body>
  <div class="wrapper">
  <!-- nav wrapper -->
  <div class="nav-wrapper">

  	<div class="nav-container">
  		<div class="nav-second">
  			<ul>
  				<li><a href="#"<i class="fa fa-twitter" aria-hidden="true"></i></a></li>
  			</ul>
  		</div><!-- nav second ends-->
  	</div><!-- nav container ends -->

  </div><!-- nav wrapper end -->

  <!---Inner wrapper-->
  <div class="inner-wrapper">
  	<!-- main container -->
  	<div class="main-container">
  		<!-- step wrapper-->
    <?php if ($_GET['step'] == '1') {?>
   		<div class="step-wrapper">
  		    <div class="step-container">
  				<form method="post">
  					<h2>Choose a Username</h2>
  					<h4>Don't worry, you can always change it later.</h4>
  					<div>
  						<input type="text" name="username" placeholder="Username"/>
  					</div>
  					<div>
  						<ul>
  						  <li><?php if (isset($error)){echo $error;} ?></li>
  						</ul>
  					</div>
  					<div>
  						<input type="submit" name="next" value="Next"/>
  					</div>
  				 </form>
  			</div>
  		</div>
    <?php } ?>
    <?php if ($_GET['step'] == '2'){?>
  	<div class='lets-wrapper'>
  		<div class='step-letsgo'>
  			<h2>Congratulations you've joined the team!! <?php echo $user->screenName; ?> </h2>
  			<p>PopularNetwork is a constantly updating stream of the coolest, most important news, media, sports, TV, conversations and more all tailored just for you.</p>
  			<br/>
  			<p>
  				Tell us about what you would like to see changed or added to your plateform.
  			</p>
			  <br>
			  <h2> PopularNetwork Privacy Policy And Cookie Policy</h2>
			  <p>This privacy policy describes the personal data collected or generated (processed) when you use Nike’s websites (“Sites”) and mobile applications (“Apps”). It also explains how your personal data is used, shared and protected, what choices you have relating to your personal data and how you can contact us.</p>
  			<span>
  				<a href='../home.php' class='backButton'>I Accept!</a>
  			</span>
  		</div>
  	</div>
  <?php } ?>

  	</div><!-- main container end -->

  </div><!-- inner wrapper ends-->
  </div><!-- ends wrapper -->

  </body>
  </html>

  <?php
}
?>
