<?php
if ($_SERVER['REQUEST_METHOD'] == "GET" && realpath(__FILE__) == realpath($_SERVER['SCRIPT_FILENAME'])) {
	header('Location: ../index.php');
}
if(isset($_POST['signup'])){
	$screenName = $_POST['screenName'];
	$email = $_POST['email'];
	$password = $_POST['password'];
	$error = '';

	if(empty($screenName) or empty($password) or empty($email)){
		$error = 'All fields are required';
	}else {
		$email = $getFromU->checkInput($email);
		$screenName = $getFromU->checkInput($screenName);
		$password = $getFromU->checkInput($password);

		if(!filter_var($email)) {
			$error = 'Invalid email format';
		}else if(strlen($screenName) > 20){
			$error = 'Name must be between in 6-20 characters';
		}else if(strlen($password) < 5){
			$error = 'Password is too short';
		}else {
			if($getFromU->checkEmail($email) === true){
				$error = 'Email is already in use';
			}else {
				$user_id = $getFromU->create('users', array('email' => $email, 'password' => md5($password) , 'screenName' => $screenName, 'profileImage' => 'assets/images/defaultProfileImage.png', 'profileCover' => 'assets/images/defaultCoverImage.png'));
				$_SESSION['user_id'] = $user_id;
				header('Location: includes/signup.php?step=1');
			}
		}
	}
}
?>
<form method="post">
<div class="signup-div">
	<h3>Sign up </h3>
	<ul>
		<li>
		    <input type="text" name="screenName" placeholder="Full Name"/>
		</li>
		<li>
		    <input type="email" name="email" placeholder="Email"/>
		</li>
		<li>
			<input type="password" name="password" placeholder="Password"/>
		</li>
		<li>
			<input type="password" name="password" placeholder="Repeat Password"/>
		</li>
		<li>
		    <input type="radio" name="gender" required > Male        
            <input type="radio" name="gender" required > Female 
			<input type="radio" name="gender" required > Costum
		</li>
		<li>
		    <input type="date" required> Birthday
		</li>
		<br>
		<p>By clicking Sign Up, you agree to our <a href="">Terms</a> . 
		Learn how we collect, use and share your data in our <a href="">Data Policy</a> and how we use cookies and similar technology in our <a href="">Cookie Policy</a>.
		 You may receive SMS notifications from us and can opt out at any time.</p>
		 <li>
			<input type="submit" name="signup" Value="Signup for Popular Network">
		</li>
		<?php
      if(isset($error)){
        echo '<li class="error-li">
        <div class="span-fp-error">'.$error.'</div>
        </li>';
      }
    ?>
	</ul>

</div>
</form>
