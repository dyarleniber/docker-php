<?php

include 'core/init.php';
 if (isset($_GET['username']) === true && empty($_GET['username']) === false) {
  $username = $getFromU->checkInput($_GET['username']);
  $profileId = $getFromU->userIdByUsername($username);
  $profileData = $getFromU->userData($profileId);
  $user_ID = @$_SESSION['user_id'];
  $user = $getFromU->userData($user_ID);
  $notify  = $getFromM->getNotificationCount($user_ID);

 
  if (!$profileData) {
    header('Location: '.BASE_URL.'index.php');
  }
}

?>

<!doctype html>
<html>
	<head>
	<title><?php echo $profileData->screenName.' (@'.$profileData->username.')'; ?></title>
	<meta charset="UTF-8" />
  	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.3/css/font-awesome.css"/>
  	<link rel="stylesheet" href="<?php echo BASE_URL; ?>assets/css/style-complete.css"/>
	  <script src="https://code.jquery.com/jquery-3.1.1.js" integrity="sha256-16cdPddA6VdVInumRGo6IbivbERE8p7CQR3HzTBuELA=" crossorigin="anonymous"></script>
	  
	   <!-- Bootstrap CSS -->
	   <link rel="stylesheet" href="css/bootstrap.css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/themify-icons.css"/>
    <!-- main css -->
    <link rel="stylesheet" href="css/style.css"/>
    <link rel="stylesheet" href="css/responsive.css"/>
	<link rel="stylesheet" href="css/final.css"/>
	
	<!-- Optional JavaScript -->
    <!-- jQuery first, then Bootstrap JS -->
    <script src="js/jquery-3.2.1.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
	
	<script type="text/javascript">
		
		function changeProductAll()
		{
			$('#product_detail').hide();
			$('#product_all').show();
		}
		
		function changeProduct(productId)
		{
			$('#product_detail').css('display', 'flex');
			$('#product_all').hide();
			
			/*changeProductDetail(productId);
			changeProductPhotos(productId);
			changeProductReviews(productId);*/
		}
		
		function changeProductDetail(productId)
		{
			//$('#product_detail').load("product-detail.html");
			// Get data from server
			$('#product_detail').html("");
		}
		
		function changeProductPhotos(productId)
		{
			// Get data from server
			$('#photo').html("");
		}
		
		function changeProductReviews(productId)
		{
			// Get data from server
			$('#review').html("");
		}
    </script>
    </head>
<!--Helvetica Neue-->
<body>
<div class="wrapper">
<!-- header wrapper -->
<div class="header-wrapper">
	<div class="nav-container">
    	<div class="nav">
		<div class="nav-left">
			<ul>
				 <li><a href="<?php echo BASE_URL; ?>home.php"><i class="fa fa-home" aria-hidden="true"></i>Home</a></li>
      			
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
        <?php if($getFromU->loggedIn() === true){ ?>
				<li class="hover"><label class="drop-label" for="drop-wrap1"><img src="<?php echo BASE_URL.$user->profileImage; ?>"/></label>
				<input type="checkbox" id="drop-wrap1">
				<div class="drop-wrap">
					<div class="drop-inner">
						<ul>
							<li><a href="<?php echo BASE_URL.$user->username; ?>"><?php echo $user->username; ?></a></li>
							<li><a href="<?php echo BASE_URL; ?>settings/account">Settings</a></li>
							<li><a href="<?php echo BASE_URL; ?>includes/logout.php">Log out</a></li>
						</ul>
					</div>
				</div>
				</li>
				<li><label for="pop-up-tweet" class="addTweetBtn">Post</label></li>
      <?php }else{
        echo '<li><a href="'.BASE_URL.'index.php">Have an account? Log in!</a></li>';
      } ?>
      </ul>
		</div><!-- nav right ends-->

	</div><!-- nav ends -->
	</div><!-- nav container ends -->
</div><!-- header wrapper end -->
<!--Profile cover-->
<div class="profile-cover-wrap">
<div class="profile-cover-inner">
	<div class="profile-cover-img">
		<!-- PROFILE-COVER -->
		<img src="<?php echo BASE_URL.$profileData->profileCover; ?>"/>
	</div>
</div>
<div class="profile-nav">
 <div class="profile-navigation">
	<ul>
		<li>
		<div class="n-head">
			POSTS
		</div>
		<div class="n-bottom">
		  <?php $getFromT->countPosts($profileId); ?>
		</div>
		</li>
		<li>
			<a href="<?php echo BASE_URL.$profileData->username; ?>/following">
				<div class="n-head">
					<a href="<?php echo BASE_URL.$profileData->username; ?>/following">FOLLOWING</a>
				</div>
				<div class="n-bottom">
					<span class="count-following"><?php echo $profileData->following; ?></span>
				</div>
			</a>
		</li>
		<li>
		 <a href="<?php echo BASE_URL.$profileData->username; ?>/followers">
				<div class="n-head">
					FOLLOWERS
				</div>
				<div class="n-bottom">
					<span class="count-followers"><?php echo $profileData->followers; ?></span>
				</div>
			</a>
		</li>
		<li>
			<a href="#">
				<div class="n-head">
					LIKES
				</div>
				<div class="n-bottom">
					<?php $getFromT->countLikes($profileId); ?>
				</div>
			</a>
		</li>
	</ul>
	<div class="edit-button">
		<span>
			<?php echo $getFromF->followBtn($profileId, $user_ID, $profileData->user_ID); ?>
 		</span>
	</div>
    </div>
</div>
</div><!--Profile Cover End-->
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/follow.js"></script>
<script type="text/javascript" src="<?php echo BASE_URL;?>assets/js/notification.js"></script>

<!---Inner wrapper-->
<div class="in-wrapper">
 <div class="in-full-wrap">
   <div class="in-left">
     <div class="in-left-wrap">
	<!--PROFILE INFO WRAPPER END-->
	<div class="profile-info-wrap">
	 <div class="profile-info-inner">
	 <!-- PROFILE-IMAGE -->
		<div class="profile-img">
			<img src="<?php echo BASE_URL.$profileData->profileImage; ?>"/>
		</div>

		<div class="profile-name-wrap">
			<div class="profile-name">
				<a href="<?php echo BASE_URL.$profileData->username; ?>"><?php echo $profileData->screenName; ?></a>
			</div>
			<div class="profile-tname">
				@<span class="username"><?php echo $profileData->username; ?></span>
			</div>
		</div>

		<div class="profile-bio-wrap">
		 <div class="profile-bio-inner">
		    <?php echo $getFromT->getPostLinks($profileData->bio); ?>
		 </div>
		</div>

<div class="profile-extra-info">
	<div class="profile-extra-inner">
		<ul>
      <?php if(!empty($profileData->country)){ ?>
			<li>
				<div class="profile-ex-location-i">
					<i class="fa fa-map-marker" aria-hidden="true"></i>
				</div>
				<div class="profile-ex-location">
					<?php echo $profileData->country; ?>
				</div>
			</li>
    <?php } ?>

    <?php if(!empty($profileData->website)){ ?>
			<li>
				<div class="profile-ex-location-i">
					<i class="fa fa-link" aria-hidden="true"></i>
				</div>
				<div class="profile-ex-location">
					<a href="<?php echo $profileData->website; ?>" target="_blank"><?php echo $profileData->website; ?></a>
				</div>
			</li>
    <?php } ?>

			<li>
				<div class="profile-ex-location-i">
					<!-- <i class="fa fa-calendar-o" aria-hidden="true"></i> -->
				</div>
				<div class="profile-ex-location">
 				</div>
			</li>
			<li>
				<div class="profile-ex-location-i">
					<!-- <i class="fa fa-tint" aria-hidden="true"></i> -->
				</div>
				<div class="profile-ex-location">
				</div>
			</li>
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
			 <!-- <li><img src="#"/></li> -->
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
































<!------------------------------------------------------------------------------------------------------------------------->
<!--================Product Description Area =================-->
<section class="product_area">
				  <!-- <div class="container"> -->
					<ul class="nav nav-tabs" id="myTab" role="tablist">
					  <li class="nav-item">
						<a
						  class="nav-link active"
						  id="photo-tab"
						  data-toggle="tab"
						  href="#photo"
						  role="tab"
						  aria-controls="photo"
						  aria-selected="false"
						  >Photos</a
						>
					  </li>
					  <li class="nav-item">
						<a
						  class="nav-link"
						  id="sell-tab"
						  data-toggle="tab"
						  href="#sell"
						  role="tab"
						  aria-controls="sell"
						  aria-selected="false"
						  >Products</a
						>
					  </li>
					  <li class="nav-item">
						<a
						  class="nav-link"
						  id="review-tab"
						  data-toggle="tab"
						  href="#review"
						  role="tab"
						  aria-controls="review"
						  aria-selected="false"
						  >Reviews</a
						>
					  </li>
					</ul>
					<div class="tab-content" id="myTabContent">
					  <div
						class="tab-pane fade show active"
						id="photo"
						role="tabpanel"
						aria-labelledby="photo-tab"
					  >
						<div class="row">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
								<div class="product-img">
									<img class="img-fluid w-100" src="img/product/single-product/s-product-1.jpg" alt="" />
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
								<div class="product-img">
									<img class="img-fluid w-100" src="img/product/single-product/s-product-1.jpg" alt="" />
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
								<div class="product-img">
									<img class="img-fluid w-100" src="img/product/single-product/s-product-1.jpg" alt="" />
								</div>
							</div>
						</div>
					  </div>
					  <div
						class="tab-pane fade"
						id="sell"
						role="tabpanel"
						aria-labelledby="sell-tab"
					  >
						<div id="product_detail" class="row s_product_inner dy-none">
							<!-- <div class="row"> -->
								<div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
									<div class="main_title product-link">
										<div class="page_link">
											<a href="#" onclick="changeProductAll();return false;">Home</a>
											<a href="#">Product Details</a>
										</div>
									</div>
								</div>
							<!-- </div> -->
							<div class="col-lg-6 col-md-6 col-sm-6 col-xs-6">
								<div class="s_product_img">
									<div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
										<ol class="carousel-indicators">
											<li data-target="#carouselExampleIndicators" data-slide-to="0" class="active">
												<img src="img/product/single-product/s-product-s-2.jpg" alt="" />
											</li>
											<li data-target="#carouselExampleIndicators" data-slide-to="1">
												<img src="img/product/single-product/s-product-s-3.jpg" alt=""/>
											</li>
											<li data-target="#carouselExampleIndicators" data-slide-to="2">
												<img src="img/product/single-product/s-product-s-4.jpg" alt=""/>
											</li>
										</ol>
										<div class="carousel-inner">
											<div class="carousel-item active">
												<img class="d-block w-100" src="img/product/single-product/s-product-1.jpg" alt="First slide"/>
											</div>
											<div class="carousel-item"> 
												<img class="d-block w-100" src="img/product/single-product/s-product-1.jpg" alt="Second slide"/>
											</div>
											<div class="carousel-item">
												<img class="d-block w-100" src="img/product/single-product/s-product-1.jpg" alt="Third slide"/>
											</div>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-5 col-md-5 col-sm-5 col-xs-5 offset-lg-1">
								<div class="sub_product_text">
									<h3>Faded SkyBlu Denim Jeans</h3>
									<h2>$149.99</h2>
									<ul class="list">
										<li>
											<a class="active" href="#"> <span>Category</span> : Household</a>
										</li>
										<li>
											<a href="#"> <span>Availibility</span> : In Stock</a>
										</li>
									</ul>
									<p>
										Mill Oil is an innovative oil filled radiator with the most
										modern technology. If you are looking for something that can
										make your interior look awesome, and at the same time give you
										the pleasant warm feeling during the winter.
									</p>
									<div class="product_count">
										<label for="qty">Quantity:</label>
										<input type="text" name="qty" id="sst" maxlength="12" value="1" title="Quantity:" class="input-text qty"/>
										<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst )) result.value++;return false;" class="increase items-count" type="button">
											<i class="lnr lnr-chevron-up"></i>
										</button>
										<button onclick="var result = document.getElementById('sst'); var sst = result.value; if( !isNaN( sst ) &amp;&amp; sst > 0 ) result.value--;return false;" class="reduced items-count" type="button">
											<i class="lnr lnr-chevron-down"></i>
										</button>
									</div>
									<div class="card_area">
										<a class="main_btn" href="#">Add to Cart</a>
									</div>
								</div>
							</div>
						</div>
						<div id="product_all" class="row">
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
								<div class="single-product">
									<div class="product-img">
										<img class="img-fluid w-100" src="img/product/inspired-product/i1.jpg" alt="" />
										<div class="p_icon">
											<a href="#" onclick="changeProduct(1);return false;">
												<i class="ti-eye"></i>
											</a>
											<a href="#">
												<i class="ti-shopping-cart"></i>
											</a>
										</div>
									</div>
									<div class="product-btm">
										<a href="#" class="d-block" onclick="changeProduct(1);return false;">
											<h4>Latest men’s sneaker</h4>
										</a>
										<div class="mt-3">
											<span class="mr-4">$25.00</span>
											<del>$35.00</del>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
								<div class="single-product">
									<div class="product-img">
										<img class="img-fluid w-100" src="img/product/inspired-product/i2.jpg" alt="" />
										<div class="p_icon">
											<a href="#" onclick="changeProduct(1);return false;">
												<i class="ti-eye"></i>
											</a>
											<a href="#">
												<i class="ti-shopping-cart"></i>
											</a>
										</div>
									</div>
									<div class="product-btm">
										<a href="#" class="d-block" onclick="changeProduct(1);return false;">
											<h4>Latest men’s sneaker</h4>
										</a>
										<div class="mt-3">
											<span class="mr-4">$25.00</span>
											<del>$35.00</del>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
								<div class="single-product">
									<div class="product-img">
										<img class="img-fluid w-100" src="img/product/inspired-product/i3.jpg" alt="" />
										<div class="p_icon">
											<a href="#" onclick="changeProduct(1);return false;">
												<i class="ti-eye" ></i>
											</a>
											<a href="#">
												<i class="ti-shopping-cart"></i>
											</a>
										</div>
									</div>
									<div class="product-btm">
										<a href="#" class="d-block" onclick="changeProduct(1);return false;">
											<h4>Latest men’s sneaker</h4>
										</a>
										<div class="mt-3">
											<span class="mr-4">$25.00</span>
											<del>$35.00</del>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
								<div class="single-product">
									<div class="product-img">
										<img class="img-fluid w-100" src="img/product/inspired-product/i4.jpg" alt="" />
										<div class="p_icon">
											<a href="#" onclick="changeProduct(1);return false;">
												<i class="ti-eye" ></i>
											</a>
											<a href="#">
												<i class="ti-shopping-cart"></i>
											</a>
										</div>
									</div>
									<div class="product-btm">
										<a href="#" class="d-block" onclick="changeProduct(1);return false;">
											<h4>Latest men’s sneaker</h4>
										</a>
										<div class="mt-3">
											<span class="mr-4">$25.00</span>
											<del>$35.00</del>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
								<div class="single-product">
									<div class="product-img">
										<img class="img-fluid w-100" src="img/product/inspired-product/i5.jpg" alt="" />
										<div class="p_icon">
											<a href="#" onclick="changeProduct(1);return false;">
												<i class="ti-eye"></i>
											</a>
											<a href="#">
												<i class="ti-shopping-cart"></i>
											</a>
										</div>
									</div>
									<div class="product-btm">
										<a href="#" class="d-block" onclick="changeProduct(1);return false;">
											<h4>Latest men’s sneaker</h4>
										</a>
										<div class="mt-3">
											<span class="mr-4">$25.00</span>
											<del>$35.00</del>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
								<div class="single-product">
									<div class="product-img">
										<img class="img-fluid w-100" src="img/product/inspired-product/i6.jpg" alt="" />
										<div class="p_icon">
											<a href="#" onclick="changeProduct(1);return false;">
												<i class="ti-eye"></i>
											</a>
											<a href="#">
												<i class="ti-shopping-cart"></i>
											</a>
										</div>
									</div>
									<div class="product-btm">
										<a href="#" class="d-block" onclick="changeProduct(1);return false;">
											<h4>Latest men’s sneaker</h4>
										</a>
										<div class="mt-3">
											<span class="mr-4">$25.00</span>
											<del>$35.00</del>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
								<div class="single-product">
									<div class="product-img">
										<img class="img-fluid w-100" src="img/product/inspired-product/i7.jpg" alt="" />
										<div class="p_icon">
											<a href="#" onclick="changeProduct(1);return false;">
												<i class="ti-eye"></i>
											</a>
											<a href="#">
												<i class="ti-shopping-cart"></i>
											</a>
										</div>
									</div>
									<div class="product-btm">
										<a href="#" class="d-block" onclick="changeProduct(1);return false;">
											<h4>Latest men’s sneaker</h4>
										</a>
										<div class="mt-3">
											<span class="mr-4">$25.00</span>
											<del>$35.00</del>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
								<div class="single-product">
									<div class="product-img">
										<img class="img-fluid w-100" src="img/product/inspired-product/i8.jpg" alt="" />
										<div class="p_icon">
											<a href="#" onclick="changeProduct(1);return false;">
												<i class="ti-eye"></i>
											</a>
											<a href="#">
												<i class="ti-shopping-cart"></i>
											</a>
										</div>
									</div>
									<div class="product-btm">
										<a href="#" class="d-block" onclick="changeProduct(1);return false;">
											<h4>Latest men’s sneaker</h4>
										</a>
										<div class="mt-3">
											<span class="mr-4">$25.00</span>
											<del>$35.00</del>
										</div>
									</div>
								</div>
							</div>
							<div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
								<div class="single-product">
									<div class="product-img">
										<img class="img-fluid w-100" src="img/product/inspired-product/i8.jpg" alt="" />
										<div class="p_icon">
											<a href="#" onclick="changeProduct(1);return false;">
												<i class="ti-eye" ></i>
											</a>
											<a href="#">
												<i class="ti-shopping-cart"></i>
											</a>
										</div>
									</div>
									<div class="product-btm">
										<a href="#" class="d-block" onclick="changeProduct(1);return false;">
											<h4>Latest men’s sneaker</h4>
										</a>
										<div class="mt-3">
											<span class="mr-4">$25.00</span>
											<del>$35.00</del>
										</div>
									</div>
								</div>
							</div>
						</div>
					  </div>
					  <div
						class="tab-pane fade"
						id="review"
						role="tabpanel"
						aria-labelledby="review-tab"
					  >
						<div class="row">
						  <div class="col-lg-6">
							<div class="row total_rate">
							  <div class="col-6">
								<div class="box_total">
								  <h5>Overall</h5>
								  <h4>4.0</h4>
								  <h6>(03 Reviews)</h6>
								</div>
							  </div>
							  <div class="col-6">
								<div class="rating_list">
								  <h3>Based on 3 Reviews</h3>
								  <ul class="list">
									<li>
									  <a href="#"
										>5 Star
										<i class="fa fa-star star-i-r star-i-r"></i>
										<i class="fa fa-star star-i-r star-i-r"></i>
										<i class="fa fa-star star-i-r star-i-r"></i>
										<i class="fa fa-star star-i-r star-i-r"></i>
										<i class="fa fa-star star-i-r star-i-r"></i> 01</a
									  >
									</li>
									<li>
									  <a href="#"
										>4 Star
										<i class="fa fa-star star-i-r star-i-r"></i>
										<i class="fa fa-star star-i-r star-i-r"></i>
										<i class="fa fa-star star-i-r star-i-r"></i>
										<i class="fa fa-star star-i-r star-i-r"></i>
										<i class="fa fa-star star-i-r star-i-r"></i> 01</a
									  >
									</li>
									<li>
									  <a href="#"
										>3 Star
										<i class="fa fa-star star-i-r"></i>
										<i class="fa fa-star star-i-r"></i>
										<i class="fa fa-star star-i-r"></i>
										<i class="fa fa-star star-i-r"></i>
										<i class="fa fa-star star-i-r"></i> 01</a
									  >
									</li>
									<li>
									  <a href="#"
										>2 Star
										<i class="fa fa-star star-i-r"></i>
										<i class="fa fa-star star-i-r"></i>
										<i class="fa fa-star star-i-r"></i>
										<i class="fa fa-star star-i-r"></i>
										<i class="fa fa-star star-i-r"></i> 01</a
									  >
									</li>
									<li>
									  <a href="#"
										>1 Star
										<i class="fa fa-star star-i-r"></i>
										<i class="fa fa-star star-i-r"></i>
										<i class="fa fa-star star-i-r"></i>
										<i class="fa fa-star star-i-r"></i>
										<i class="fa fa-star star-i-r"></i> 01</a
									  >
									</li>
								  </ul>
								</div>
							  </div>
							</div>
							<div class="review_list">
							  <div class="review_item">
								<div class="media">
								  <div class="d-flex">
									<img
									  src="img/product/single-product/review-1.png"
									  alt=""
									/>
								  </div>
								  <div class="media-body">
									<h4>Blake Ruiz</h4>
									<i class="fa fa-star star-i-r"></i>
									<i class="fa fa-star star-i-r"></i>
									<i class="fa fa-star star-i-r"></i>
									<i class="fa fa-star star-i-r"></i>
									<i class="fa fa-star star-i-r"></i>
								  </div>
								</div>
								<p>
								  Lorem ipsum dolor sit amet, consectetur adipisicing elit,
								  sed do eiusmod tempor incididunt ut labore et dolore magna
								  aliqua. Ut enim ad minim veniam, quis nostrud exercitation
								  ullamco laboris nisi ut aliquip ex ea commodo
								</p>
							  </div>
							  <div class="review_item">
								<div class="media">
								  <div class="d-flex">
									<img
									  src="img/product/single-product/review-2.png"
									  alt=""
									/>
								  </div>
								  <div class="media-body">
									<h4>Blake Ruiz</h4>
									<i class="fa fa-star star-i-r"></i>
									<i class="fa fa-star star-i-r"></i>
									<i class="fa fa-star star-i-r"></i>
									<i class="fa fa-star star-i-r"></i>
									<i class="fa fa-star star-i-r"></i>
								  </div>
								</div>
								<p>
								  Lorem ipsum dolor sit amet, consectetur adipisicing elit,
								  sed do eiusmod tempor incididunt ut labore et dolore magna
								  aliqua. Ut enim ad minim veniam, quis nostrud exercitation
								  ullamco laboris nisi ut aliquip ex ea commodo
								</p>
							  </div>
							  <div class="review_item">
								<div class="media">
								  <div class="d-flex">
									<img
									  src="img/product/single-product/review-3.png"
									  alt=""
									/>
								  </div>
								  <div class="media-body">
									<h4>Blake Ruiz</h4>
									<i class="fa fa-star star-i-r"></i>
									<i class="fa fa-star star-i-r"></i>
									<i class="fa fa-star star-i-r"></i>
									<i class="fa fa-star star-i-r"></i>
									<i class="fa fa-star star-i-r"></i>
								  </div>
								</div>
								<p>
								  Lorem ipsum dolor sit amet, consectetur adipisicing elit,
								  sed do eiusmod tempor incididunt ut labore et dolore magna
								  aliqua. Ut enim ad minim veniam, quis nostrud exercitation
								  ullamco laboris nisi ut aliquip ex ea commodo
								</p>
							  </div>
							</div>
						  </div>
						  <div class="col-lg-6">
							<div class="review_box">
							  <h4>Add a Review</h4>
							  <p>Your Rating:</p>
							  <ul class="list">
								<li>
								  <a href="#">
									<i class="fa fa-star star-i-r"></i>
								  </a>
								</li>
								<li>
								  <a href="#">
									<i class="fa fa-star star-i-r"></i>
								  </a>
								</li>
								<li>
								  <a href="#">
									<i class="fa fa-star star-i-r"></i>
								  </a>
								</li>
								<li>
								  <a href="#">
									<i class="fa fa-star star-i-r"></i>
								  </a>
								</li>
								<li>
								  <a href="#">
									<i class="fa fa-star star-i-r"></i>
								  </a>
								</li>
							  </ul>
							  <p>Outstanding</p>
							  <form
								class="row contact_form"
								action="contact_process.php"
								method="post"
								id="contactForm"
								novalidate="novalidate"
							  >
								<div class="col-md-12">
								  <div class="form-group">
									<input
									  type="text"
									  class="form-control"
									  id="name"
									  name="name"
									  placeholder="Your Full name"
									/>
								  </div>
								</div>
								<div class="col-md-12">
								  <div class="form-group">
									<input
									  type="email"
									  class="form-control"
									  id="email"
									  name="email"
									  placeholder="Email Address"
									/>
								  </div>
								</div>
				
								<div class="col-md-12">
								  <div class="form-group">
									<textarea
									  class="form-control"
									  name="message"
									  id="message"
									  rows="1"
									  placeholder="Review"
									></textarea>
								  </div>
								</div>
								<div class="col-md-12 text-right">
								  <button
									type="submit"
									value="submit"
									class="btn submit_btn"
								  >
									Submit Now
								  </button>
								</div>
							  </form>
							</div>
						  </div>
						</div>
					  </div>
					</div>
				  <!-- </div> -->
				</section>
				<!--================End Product Description Area =================-->
			</div>
		</div>
      </div>
    </div>
    <!--================End Single Product Area =================-->


<!------------------------------------------------------------------------------------------------------------------------->






















<!-- in center end -->

<div class="in-right">
	<div class="in-right-wrap">

		<!--==WHO TO FOLLOW==-->
	    <?php $getFromF->whoToFollow($user_ID, $profileId); ?>
 		<!--==WHO TO FOLLOW==-->

		<!--==TRENDS==-->
   	   <?php $getFromT->trends(); ?>
 	 	<!--==TRENDS==-->

	</div><!-- in right wrap-->
</div>
 <!-- in right end -->
<script type="text/javascript" src="<?php echo BASE_URL; ?>assets/js/follow.js"></script>

		</div>
		<!--in full wrap end-->
	</div>
	<!-- in wrappper ends-->
 </div>
 <!-- ends wrapper -->
</body>
</html>
