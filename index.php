<?php
/* jquery.min.js – Script (minified) for jQuery script usage
bootstrap.min.js – Script (minified) for Bootstraps front-end framework
bootstrap-hover-dropdown.min.js – Script (minified) for enabling Bootstrap dropdown menus on hover
jquery.easing.1.3.min.js – Script (minified) for easing jQuery transitions
owl.carousel.min.js – Script (minified) 		 content sliders/carousels
jquery.raty.min.js – Script (minified) for star rating usage
wow.min.js – Script (minified) for triggering animations on scroll
jquery.customSelect.min.js – Script for styling custom controls
scripts.js – Script for adjustments and activatb ion of all in the HTML files linked JavaScripts
html5shiv.js – Script for enabling HTML5 usage in Internet Explorer
respond.min.js – Script for enabling CSS3 Media Queries for Responsive Webdesign in Internet Explorer
echo.min.js – HTML5 lazy loading */

/**********FUNCTION FILE BIATCH************/
require_once(realpath(__DIR__ . '/fn.php'));
/******************************************/
isset($_GET['page']) ? $_GET['page'] : redirect2home(BASE_URL.'/PHP/?page=home');
$pg = (isset($_GET['page'])) ? $_GET['page'] : NULL;
?>

<!DOCTYPE html>
<html lang="en">
	<head>
	   
	   <title>FixQuick</title>
	
		<!-- Meta -->
		<meta charset="utf-8">
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
		<meta name="description" content="">
		<meta name="author" content="">
	    <meta name="keywords" content="MediaCenter, Template, eCommerce">
	    <meta name="robots" content="all">

	    <!-- Bootstrap Core CSS -->
	    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
	    
	    <!-- Customizable CSS -->
	    <link rel="stylesheet" href="assets/css/main.css">
	    <link rel="stylesheet" href="assets/css/red.css">
	    <link rel="stylesheet" href="assets/css/owl.carousel.css">
	    <link rel="stylesheet" href="assets/css/owl.theme.css">
		<link rel="stylesheet" href="assets/css/owl.transitions.css">
		<link rel="stylesheet" href="assets/css/animate.min.css">

		<!-- Demo Purpose Only. Should be removed in production -->
		<link rel="stylesheet" href="assets/css/config.css">

		<link href="assets/css/green.css" rel="alternate stylesheet" title="Green color">
		<link href="assets/css/blue.css" rel="alternate stylesheet" title="Blue color">
		<link href="assets/css/red.css" rel="alternate stylesheet" title="Red color">
		<link href="assets/css/orange.css" rel="alternate stylesheet" title="Orange color">
		<link href="assets/css/navy.css" rel="alternate stylesheet" title="Navy color">
		<link href="assets/css/dark-green.css" rel="alternate stylesheet" title="Darkgreen color">
		<!-- Demo Purpose Only. Should be removed in production : END -->

	    <!-- Fonts -->
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700,800' rel='stylesheet' type='text/css'>
		
		<!-- Icons/Glyphs -->
		<link rel="stylesheet" href="assets/css/font-awesome.css">
		
		<!-- Favicon -->
		<link rel="icon" href="assets/images/Vine2-Logo-_--Apple-App-Icon-180X180-Transparent.png">

		<!-- HTML5 elements and media queries Support for IE8 : HTML5 shim and Respond.js -->
		<!--[if lt IE 9]>
			<script src="assets/js/html5shiv.js"></script>
			<script src="assets/js/respond.min.js"></script>
		<![endif]-->
		
		<script src='https://www.google.com/recaptcha/api.js'></script>

	</head>
	
<body>

<input type='hidden' value='<?=$_GET['page']?>' id='curPg'/>

<span id="msgSntPopup" class="well well-sm lead text-center" style="display:none;font-weight:bold;z-index:2500;min-width:30%;position:fixed;top:25px;left:35%;right:auto;border:4px solid #777;border-radius:7px;box-shadow:0px 3px 5px #333;">
  <h1 class="text-center lead">
	<!-- jQry will insrt msg here -->
  </h1>
</span>
 
 <div id='myModal2' class='new_modal1'>
	<button class='oldModalCloseBtn btn btn-sm btn-link' type='button' class='btn-link pull-right modalCloseBtn'><i class='fa fa-lg fa-close'></i></button>
	  <div class='modal-content new_modal1_container' style='min-height:250px;'> 
	   <?///JAVASCRIPT\\\?>
	  </div>
 </div>

	<div class="wrapper">
	
		<?php 
		if($_GET['page'] !== 'checkout'){
			require MC_ROOT.'/parts/navigation/top-menu-bar.php';
		}////END if
		?>
		
		<?php
		////TOP MAIN CONTENT///
			switch($page){
				case 'authentication':
					require MC_ROOT.'/parts/section/header.php';
					break;
				default:
					require MC_ROOT.'/parts/section/header.php';
					require MC_ROOT.'/parts/section/top-menu-bar-btns.php';
					require MC_ROOT.'/parts/section/breadcrumbs.php';
					break;
			}///END switch
 /* 		if($headerStyle == 1):
				require MC_ROOT.'/parts/section/header.php';
				require MC_ROOT.'/parts/breadcrumb/breadcrumb.php';
				require MC_ROOT.'/parts/section/top-menu-bar-btns.php';
			else:
				require MC_ROOT.'/parts/section/header-2.php';
				require MC_ROOT.'/parts/section/header.php';
				require MC_ROOT.'/parts/section/top-menu-bar-btns.php';
		
			endif;		 
			*/	
		?>
		
		<!--MY GARAGE VEHICLE TABS-->
		<div class='row <?=(($_GET['page'] == 'checkout') || $_GET['page'] == 'cart') ? 'hide' : '' ?>'>
			<div class='col-lg-8 col-sm-12 pull-right garage_car_tab_div'>
				<ul class='list-inline' id='carTireTabsUlOutput'>
<?php
////CHECK FOR CARS & TIRES IN GARAGE 2 LOAD ONTO TABS
/* 	if($fn->ifLoggedInReturnAsMember(true)){
		$chk4CarRows = $sql->numRows('mem_garage','mem_id',_ID_,false,"item_type=car");
		$chk4TireRows = $sql->numRows('mem_garage','mem_id',_ID_,false,"item_type=tire");
		$garage_cars = (trim($chk4CarRows) > 0) ? $sql->getRows('mem_garage','mem_id',_ID_,"ORDER BY id DESC",false,false,"item_type=car") : NULL;
		$garage_tires = (trim($chk4TireRows) > 0) ? $sql->getRows('mem_garage','mem_id',_ID_,"ORDER BY id DESC",false,false,"item_type=tire") : NULL;
		
		// /LOAD CAR TABS	
		if(!is_null($garage_cars)){
			foreach($garage_cars AS $garage_car){
				echo "<li class='dropdown'><i title='Your Car' class='fa fa-car text-muted'></i><button data-toggle='dropdown' type='button' class='btn btn-link text-capitalize memCarTabBtn'>{$garage_car['car_year']} {$garage_car['car_make']} {$garage_car['car_model']}</button><a href='#' type='button' class='btn-link delMemCarTab' id2rem='{$garage_car['id']}'><i class='fa fa-close'></i></a>";
				echo "<div class='dropdown-menu'>";
				echo "<span class='center-block text-center text-capitalize text-muted'>edit vehicle</span>";
				echo "<ul class='list-group le-links changeOrRemoveDropdown4carTab'>";
				echo "<li><button type='button' class='btn btn-link btn-sm' make2change='{$garage_car['car_make']}' id2change='{$garage_car['id']}'>Change</button></li>";
				echo "<li><button type='button' class='btn btn-link btn-sm'>Hide</button></li>";
				echo "<li><button type='button' class='btn btn-link btn-sm' id2rem='{$garage_car['id']}'>Delete</button></li>";
				echo "</ul>";
				echo "</div>";
				echo "</li>";
			}///END 4each
		}////END if
		
		// /LOAD TIRE TABS
		if(!is_null($garage_tires)){
			foreach($garage_tires AS $garage_tire){
				echo  "<li><i title='Your Tire' class='fa fa-dot-circle-o text-muted'></i><button type='button' class='btn btn-link memTireTabBtn'>{$garage_tire['tire_width']}/{$garage_tire['tire_ratio']}/{$garage_tire['tire_diameter']}</button> <a href='#' type='button' class='btn-link delTireCarTab' id2rem='{$garage_tire['id']}'><i class='fa fa-close'></i></a></li>";
			}///END 4each
		}///END if
	}else{
		if(isset($_COOKIE['guest_car']) && !is_null(trim($_COOKIE['guest_car']))){
			$year = explode('-',$_COOKIE['guest_car'])[0];
			$make = ucwords(explode('-',$_COOKIE['guest_car'])[1]);
			$model = ucwords(explode('-',$_COOKIE['guest_car'])[2]);
			
				echo "<li><button type='button' class='btn btn-link guestCarTabBtn'>{$year} {$make} {$model}</button><a href='#' type='button' class='btn-link delGuestCarCookie'><i class='fa fa-close'></i></a><button class='btn-link changeCarBtn'>Change Car</button></li>";
		}///END if								
	}///END if */
?>
				</ul><!--//END car-tabs, tire-tabs ul -->
			</div>
		</div>
		
		<!--MAIN CONTENT-->
		<section class='container' id='main_content_container'>
			<?php require_once MC_ROOT.'/pages/'.$page.'.php'; ?>
		</section>
		
		<!--FOOTER-->
		<?php require MC_ROOT.'/parts/section/footer.php';?>
	</div><!-- /.wrapper -->
	
	<script src="assets/js/jquery-1.11.3.min.js"></script>
	<script src="assets/js/jquery-migrate-1.2.1.js"></script>
	<script src="assets/js/bootstrap.min.js"></script>
	<script src="assets/js/bootstrap-hover-dropdown.min.js"></script>
	<script src="assets/js/owl.carousel.min.js"></script>
	<script src="assets/js/css_browser_selector.min.js"></script>
	<script src="assets/js/echo.min.js"></script>
	<script src="assets/js/jquery.easing-1.3.min.js"></script>
	<script src="assets/js/bootstrap-slider.min.js"></script>
    <script src="assets/js/jquery.raty.min.js"></script>
    <script src="assets/js/jquery.prettyPhoto.min.js"></script>
    <script src="assets/js/jquery-ui.js"></script>
    <script src="assets/js/jquery.customSelect.min.js"></script>
    <script src="assets/js/wow.min.js"></script>
    <script src="assets/js/jquery.validate.js"></script>
	<script src="<?=BASE_URL?>/app/app.js"></script>
	<script src="https://js.braintreegateway.com/js/braintree-2.31.0.min.js"></script>

<?=(($_GET['page'] !== 'checkout') && $_GET['page'] !== 'cart') ? '<script src="'.BASE_URL.'/app/modules.js"></script>' : '' ?>	

	<!-- For demo purposes – can be removed on production -->
	
	<script src="switchstylesheet/switchstylesheet.js"></script>

	<!-- For demo purposes – can be removed on production : End -->

	<script src="http://w.sharethis.com/button/buttons.js"></script>
	
	<script>
		$(function(){
			$('.search-field').keyup(function(e){
				(e.which == 13) ? $('.search-button').trigger('click') : '';
			})
		})
	</script>
	
</body>
</html>