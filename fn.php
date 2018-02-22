<?php

/****************************************************** 
MYSQL NEW METHODS:
	UNIX_DATETIME = converts d8 format mmddyyyy to seconds 
 	COUNT(*) = count rows in tbl: SELECT CNT(*) AS items
 	eregi() = same as stristr() for regexp'z
 	session_id = id for guest and member users
 	$_SRVR[HTTP_REFERER] = URL of current pg user visited
 	$_SRVR[HTTP_USER_AGENT] = browser used by user
 	exec() = executes string in command line
 	number_format() = like toFixed() or round()
 	PHP_OS = OS of computer
 	$_SERVER['REQUEST_URI'] = parent dir
 	$_SERVER['SERVER_NAME'] = server 'localhost'
 	DIRECTORY_SEPARATOR = '/'
 	dirname() = converts filepath/string to director
*///COOL NEW MYSQL & PHP FUNCTIONS
/* jquery.min.js – Script (minified) for jQuery script usage
bootstrap.min.js – Script (minified) for Bootstraps front-end framework
bootstrap-hover-dropdown.min.js – Script (minified) for enabling Bootstrap dropdown menus on hover
jquery.easing.1.3.min.js – Script (minified) for easing jQuery transitions
owl.carousel.min.js – Script (minified) 		 content sliders/carousels
jquery.raty.min.js – Script (minified) for star rating usage
wow.min.js – Script (minified) for triggering animations on scroll
jquery.customSelect.min.js – Script for styling custom controls
scripts.js – Script for adjustments and activation of all in the HTML files linked JavaScripts
html5shiv.js – Script for enabling HTML5 usage in Internet Explorer
respond.min.js – Script for enabling CSS3 Media Queries for Responsive Webdesign in Internet Explorer
echo.min.js – HTML5 lazy loading
 *///INCLUDED JS SCRIPTS & DETAILS
/**************************************************
	COOKIES & DETAILS: 
			*login: email || username if !email
			*guest_car: car selected by user || guest 4 garage 
			*guest_cart_items: items added 2 cart
***************************************************///COOKIES & DETAILS

/**************************************************
		CONSTANTS AND OTHER WORTHLESS SHIT
***************************************************/

/***** MUST LOAD 'FUNCTIONS' FIRST********/
	function redirect2home($url){
		$url = trim(urldecode($url));
		print("<script>window.open('$url','_self');</script>");
	}///END fn
	
	function baseURL(){
		///check if site loading via HTTPS | HTTP;
		return sprintf(
			"%s://%s%s",
			isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off' ? 'https' : 'http',
			$_SERVER['SERVER_NAME'],
			dirname($_SERVER['REQUEST_URI'])
		);
	}///END baseURL()
/********************************************/

	/**************************
		DEFINE CONSTANTS
	***************************/
	define('DOMAIN_NAME','fixquick.newTmpl8');
	define('BASE_URL', baseURL());
	define('THIS_DIR',dirname($_SERVER['DOCUMENT_ROOT'].str_replace('\\','/',$_SERVER['REQUEST_URI'])));
	define('IMAGES_DIR', trim(BASE_URL.'/assets/images/'));
	define('CSS_DIR', trim(BASE_URL.'/assets/css'));
	define('PAGES_DIR', trim(BASE_URL.'/pages/'));
	define('PARTS_DIR', trim(BASE_URL.'/parts/'));
	define('HEADER_DIR', trim(BASE_URL.'/parts/widgets/header/'));
	define('JS_DIR', trim(BASE_URL.'/assets/js/'));
	define('LOGO_IMG', IMAGES_DIR.'Solomon-Little-Fix-Quick-Logo-Red Transparent.png');
	define('MC_ROOT', dirname(__FILE__));
	
	$page = isset($_GET['page']) ? $_GET['page'] : 'home';
	if($page == 'home'){
		$_GET['style'] = 'alt2';
	}elseif($page == 'home-2'){
		$_GET['style'] = 'alt';
	}

	if( !isset ($_GET['style'])){
		$_GET['style'] = 'alt';
	}

	if($_GET['style'] == 'alt'){
		$headerStyle = 2;
	}else{
		$headerStyle = 1;
	}

/**************************
    SRV & SES FILES
**************************/
require_once(MC_ROOT.'/sv.php');
require_once(MC_ROOT.'/ses.php');
	
/**********************
 essential array items
**********************/
$animation_types = array(
	'fadeInDown',
	'fadeInUp',
	'fadeInLeft',
	'fadeInRight'
);
$home_sliders = array(
	array(
		"img" => "rims_slide.jpg",
		"top_header" => "Rims <span class=\"big text-primary\">30<span class=\"sign text-muted\">%</span> <br><text class='text-muted'>off</text></span>",
		"middle_desc" => "<span class='center-block	'></span>",
		"btm_btn" => "<a href=\"#\" type='button' class=\"big le-button has-padding\">shop for wheels</a>",
		"animation_type" => $animation_types[array_rand($animation_types)]
	),
	array(
		"img" => "airflow_slide.jpg",
		"top_header" => " <span class=\"big text-right\">save <br><span class=\"sign\">$</span><text class='text-primary'>50</text></span> on intakes!",
		"middle_desc" => "<span class='text-primary hide'>You can now buy air intakes, intake <br/> manifold, and more with select <br/>discounted rates right now</span>",
		"btm_btn" => "<a href=\"#\" class=\"big le-button has-padding \">see more</a>",
		"animation_type" => $animation_types[array_rand($animation_types)]
	),
	array(
		"img" => "car-cover.jpg",
		"top_header" => "cover deals <span class=\"big\">25<span class=\"sign\">%</span> off</span>",
		"middle_desc" => "<span class='text-info'>Hurry, dont wait to purchase <br/> your new cover for your vehicle, <br/> special deal won\'t last long</span>",
		"btm_btn" => "<a href=\"#\" class=\"big le-button \">shop now</a>",
		"animation_type" => $animation_types[array_rand($animation_types)]
	)
);
$pages = array(	
	"home" => "Home",
	"home-2" => "Home Alt",
	"category-grid" => "Category - Grid/List",
	"category-grid-2" => "Category 2 - Grid/List",
	"single-product" => "Single Product",
	"single-product-sidebar" => "Single Product with Sidebar",
	"cart" => "Shopping Cart",
	"checkout" => "Checkout",
	"about" => "About Us",
	"contact" => "Contact Us",
	"blog" => "Blog",
	"blog-fullwidth" => "Blog Full Width",
	"blog-post" => "Blog Post",
	"faq" => "FAQ",
	"terms" => "Terms & Conditions",
	"authentication" => "Login/Register",
	"404" => "404",
	"wishlist" => "Wishlist",
	"compare" => "Product Comparison",
	"track-your-order" => "Track your Order"
);
$brands = array(
	"pennzoil",
	"quakerstate",
	"prestone",
	"peak",
	"motorcraft",
	"valvoline",
	"shell",
	"royalpurple",
	"mobil1",
	"castrol"
);
$oil_brands = array(
	"pennzoil",
	"quakerstate",
	"prestone",
	"peak",
	"motorcraft",
	"valvoline",
	"shell",
	"royalpurple",
	"mobil1",
	"castrol"
);
$auto_accessories = array(
	"floormats" => "Floormats",
	"seat-covers" => "Seat Covers",
	"car-covers" => "Car Covers",
	"trailer-hitches" => "Trailer Hitches",
	"steering-wheel-covers" => "Steering Wheel Covers",
	"license-plate-frames" => "License Plate Frames",
	"wash-polish" => "Wash, Wax and Polish",
	"paint-body-repair" => "Paint and Body Repair",
	"mirrors" => "Mirrors",
	"vent-visors" => "Vent Visors",
	"door-parts" => "Door Parts",
	"window-tint" => "Window Tint",
	"bug-guards" => "Bug Guards",
	"lift-supports" => "Lift Supports",
	"wipers" => "Wipers",
	"wiper-blades" => "Wiper Blades",
	"wiper-motor" => "Wiper Motor",
	"wiper-arm" => "Wiper Arm",
	"window-regulator" => "Window Regulator",
	"window-lift-motor" => "Window Lift Motor",
	"window-switch" => "Window Switch",
	"washer-pump" => "Washer Pump"
);					
$car_brands = array(
	"acura",
	"alfaromeo",
	"audi",
	"bmw",
	"buick",
	"cadillac",
	"chevrolet",
	"chrysler",
	"daewoo",
	"dodge",
	"fiat",
	"ford",
	"gaz",
	"geely",
	"honda",
	"hummer",
	"hyundai",
	"infiniti",
	"isuzu",
	"iveco",
	"jaguar",
	"jeep",
	"kia",
	"landrover",
	"lexus",
	"lincoln",
	"mazda",
	"mercedes",
	"mini",
	"mitsubishi",
	"nissan",
	"pontiac",
	"porsche",
	"saab",
	"smart",
	"subaru",
	"suzuki",
	"toyota",
	"volbo",
	"vw"
);
$fluid_brand_pics = array(
	"chevron" => "engine_oils_0000_Layer 3",
	"exxon_mobil" => "engine_oils_0001_Layer 4",
	"texaco" => "engine_oils_0002_Layer 5",
	"pennzoil" => "engine_oils_0003_Layer 6",
	"quaker_state" => "engine_oils_0004_Layer 7",
	"trusouth_oil" => "engine_oils_0005_Layer 8",
	"shell" => "engine_oils_0006_Layer 9",
	"castrol" => "engine_oils_0007_Layer 10",
	"mobil1" => "mobil1",
	"mobilsuper" => "mobilsuper",
	"motorcraft" => "motorcraft",
	"peak" => "peak",
	"prestone" => "prestone",
	"royalpurple" => "royalpurple",
	"valvoline" => "valvoline"
);
$tire_brand_pics = array(
    "carlise" => NULL,
    "maxxis" => NULL,
    "cooper" => NULL,
    "falken " => NULL,
    "Mickey_Thompson" => NULL,
	"bridgestone" => "logo_tires_0000_Layer 3",
	"avon" => "logo_tires_0001_Layer 1",
	"bfgoodrich" => "logo_tires_0002_Layer 2",
	"continental" => "logo_tires_0003_Layer 4",
	"dunlop" => "logo_tires_0004_Layer 5",
	"firestone" => "logo_tires_0005_Layer 6",
	"fuzion" => "logo_tires_0006_Layer 7",
	"general" => "logo_tires_0007_Layer 8",
	"goodyear" => "logo_tires_0008_Layer 9",
	"hankook" => "logo_tires_0009_Layer 10",
	"kumho" => "logo_tires_0010_Layer 11",
	"michelin" => "logo_tires_0011_Layer 12",
	"pirelli" => "logo_tires_0012_Layer 13",
	"sumitomo" => "logo_tires_0013_Layer 14",
	"toyo_tires" => "logo_tires_0014_Layer 15",
	"uniroyal" => "logo_tires_0015_Layer 16",
	"yokohama" => "logo_tires_0016_Layer 17"
);

/////DEFINE CONSTANT _USR_
 if(isset($_SESSION['username']) &&
    isset($_SESSION['admin']) &&
    isset($_SESSION['id'])){
$qry = "SELECT mem_avatar
        FROM members
        WHERE id = '{$_SESSION['id']}'
        LIMIT 1";
$rzlt = mysqli_query($dbCon,$qry) or die(mysqli_error($dbCon));
 if(mysqli_num_rows($rzlt) > 0){
    while($pix = mysqli_fetch_array($rzlt)){
        if(trim($pix[0])){
            $pic = $pix[0];	
        }else{
            $pic = "boy.png";
        }////END ifelse
    break;
    }///END while loop	 
 }///END if
}////END if const !defined
define("_KEYWORDS_",NULL);
define("_AUTHOR_","brandon osuji");
define("_DESC_",NULL);

//////check if tire selection cookie set
if(isset($_COOKIE['tire_set']) && !is_null($_COOKIE['tire_set'])){
    $tire_specs = explode('/',$_COOKIE['tire_set']);
    define('_TIRE_WIDTH_',$tire_specs[0]);
    define('_TIRE_RATIO_',$tire_specs[1]);
    define('_TIRE_SIZE_',$tire_specs[2]);
}////END if

/////if isset $GET[logout]: logout user   
/*if(isset($_REQUEST['logout'])){
	 $_SESSION = array();
			session_unset();
			session_destroy();
			setcookie('login','',0,'/');
			
			header("Location: /".DOMAIN_NAME."/PHP/?page=home&login=2"); ///2 = logout
			exit();
}//END if*/

////CHCK IF MERCHANT SESSION ISSET
if((isset($_COOKIE['merchant'])) && strlen(trim($_COOKIE['merchant'])) > 0){
    
    $merchant_cred = unserialize($_COOKIE['merchant']);
    
        (!defined("_MERC_ID_")) ? define("_MERC_ID_",$merchant_cred['id']) : NULL;
        (!defined("_MERC_USER_")) ? define("_MERC_USER_",$merchant_cred['name']) : NULL;
        (!defined("_MERC_EMAIL_")) ? define("_MERC_EMAIL_",$merchant_cred['email']) : NULL;
        (!defined("_MERC_COMPANY_")) ? define("_MERC_COMPANY_",$merchant_cred['company']) : NULL;
}/*else{
    print("<center>session not detected!</center>");  
}*////END if


class sql{
public function updateArrayIntoDb($tbl,$upd8ThisIntoThatArray,$whereThat,$whereThis){
//@param array $upd8ThisIntoThatArray this is just another dam array('field=data',...)
    global $dbCon;
    
    $chkRowExist = $this->getFld($tbl,$whereThat,$whereThis,'id');
    
    if(trim($chkRowExist)){
        $r = "UPDATE $tbl SET ";
            foreach($upd8ThisIntoThatArray AS $fld_val){
                $fld = explode('=',$fld_val)[0];
                $val = explode('=',$fld_val)[1];
        $r .= (count($upd8ThisIntoThatArray) > 1) ? "$fld = '{$val}'," : "$fld = '{$val}'";
            }///END 4each
        $r = (substr(rtrim($r),-1) == ',') ? substr_replace($r,'',-1) : $r;

        $r .= " WHERE $whereThat LIKE '{$whereThis}'";
                
        mysqli_query($dbCon,$r) or die('couldnt upd8 data: '.mysqli_error($dbCon));
    }///END if rowExist
}///END fn
//*****************************************///
public function insertArrayIntoDb($tbl,$ins3rtThisIntoThatArray){
/************************************************
* ex: $ins3rtThisIntoThatArray = array('Field=data2insert',...)
************************************************/
   global $dbCon;
    
	$q = "INSERT INTO `$tbl`(";
        foreach($ins3rtThisIntoThatArray AS $fld_val){
            $fld = explode('=',$fld_val)[0];
    $q .= (count($ins3rtThisIntoThatArray) > 1) ? "{$fld}," : "{$fld}";
        }///END 4each
    
    $q = (substr(rtrim($q),-1) == ',') ? substr_replace($q,'',-1) : $q;
    
    $q .= ") VALUES(";
        foreach($ins3rtThisIntoThatArray AS $fld_val){
            $val = explode('=',$fld_val)[1];
    $q .= (count($ins3rtThisIntoThatArray) > 1) ? "'{$val}'," : "'{$val}'";
        }///END 4each
    
    $q = (substr(rtrim($q),-1) == ',') ? substr_replace($q,'',-1) : $q;
    
    $q .= ")";
    
    mysqli_query($dbCon,$q) or die('couldnt insert data: '.mysqli_error($dbCon));
}///END fn
//*****************************************///
public function numRows($tbl,$whereThat,$whereThis,$orWhere=false,$andWhere1=false,$andWhere2=false,$andWhere3=false){
/**************************************************
*	$orWhere = string, NOT array ex: "field_name=$val"
* $andWhere = string, NOT array ex: "field_name=$val"
***************************************************/
		$whereThat = trim($whereThat);
		$whereThis = trim($whereThis);
		global $dbCon;
				$q = "SELECT DISTINCT * 
						 FROM $tbl 
                         WHERE $whereThat 
                         LIKE '$whereThis'";
				if($orWhere == true){
					$field = trim(explode('=',$orWhere)[0]);
					$val = trim(explode('=',$orWhere)[1]);
				$q .= " OR $field LIKE '$val' ";
				}if($andWhere1 == true){
					$field = trim(explode('=',$andWhere1)[0]);
					$val = trim(explode('=',$andWhere1)[1]);
				$q .= " AND $field LIKE '$val' ";
				}if($andWhere2 == true){
					$field = trim(explode('=',$andWhere2)[0]);
					$val = trim(explode('=',$andWhere2)[1]);
				$q .= " AND $field LIKE '$val' ";
				}if(isset($order) && trim($order)){
				$q .= " $order";
				}if(isset($limit) && trim($limit)){
				$q .= " $limit";
				}///END if
		  
        $r = mysqli_query($dbCon,$q) or die(mysqli_error($dbCon));
    
		return mysqli_num_rows($r);
}
//*****************************************///
public function getRowsV2($tblName,$whereThis,$whereThat,$andWhereKeyEqlsVal=false,$orWhereKeyEqlsVal=false,$limit=false,$order=false){
    global $dbCon;

    $q = "SELECT DISTINCT *
         FROM $tblName 
         WHERE $whereThis = '$whereThat' ";
    if(is_array($andWhereKeyEqlsVal)){
        foreach($andWhereKeyEqlsVal AS $whereThis => $eqlsThat){
            if(trim($eqlsThat) !== ''){
                $q .= " AND $whereThis LIKE '$eqlsThat' ";
            }///END if
        }///AND 4each
    }/////END if
    if(is_array($orWhereKeyEqlsVal)){
        foreach($orWhereKeyEqlsVal AS $whereThis => $eqlsThat){
            if(trim($eqlsThat) !== ''){
                $q .= " OR $whereThis LIKE '$eqlsThat' ";
            }///END if
        }///AND 4each
    }/////END if
    if($order){
        $order = trim($order);
        $q .= " $order ";
    }///END 
    if($limit){
        $limit = trim($limit);
        $q .= " $limit ";
    }///END if	
    
    $r = mysqli_query($dbCon,$q) or die('problem with get_rowsV2, '.mysqli_error($dbCon));
    
    if(mysqli_num_rows($r) > 0){
        $rows = array();
        
         while($row = mysqli_fetch_assoc($r)){
                $rows[] = $row;
         }///END while
                return $rows;
    }else{
            return false;
    }///END ifelse  
}////END fn
//*****************************************///
public function numRowsV2($tblName,$whereThis,$whereThat,$andWhereKeyEqlsVal=false,$orWhereKeyEqlsVal=false){
    global $dbCon;

    $q = "SELECT DISTINCT *
         FROM $tblName 
         WHERE $whereThis = '$whereThat' ";
    if(is_array($andWhereKeyEqlsVal)){
        foreach($andWhereKeyEqlsVal AS $whereThis => $eqlsThat){
            if(trim($eqlsThat) !== ''){
                $q .= " AND $whereThis LIKE '$eqlsThat' ";
            }///END if
        }///AND 4each
    }/////END if
    if(is_array($orWhereKeyEqlsVal)){
        foreach($orWhereKeyEqlsVal AS $whereThis => $eqlsThat){
            if(trim($eqlsThat) !== ''){
                $q .= " OR $whereThis LIKE '$eqlsThat' ";
            }///END if
        }///AND 4each
    }/////END if
    
    $r = mysqli_query($dbCon,$q) or die('problem with num_rowsV2, '.mysqli_error($dbCon));
    
    return mysqli_num_rows($r);
}////END fn
//*****************************************///
public function delRow($tbl,$id2rem){
	global $dbCon;
	
	$q = "DELETE FROM $tbl
		 		WHERE id LIKE '$id2rem'";
	$r = mysqli_query($dbCon,$q) or die('error deleting row: '.mysqli_error($dbCon));
}///END fn
//*****************************************///
public function getRows($tbl,$whereThat,$whereThis,$order=false,$limit=false,$orWhere=false,$andWhere1=false,$andWhere2=false){
	
		$whereThat = trim($whereThat);
		$whereThis = trim($whereThis);
		global $dbCon;
				$q = "SELECT DISTINCT * 
						 FROM $tbl 
                         WHERE $whereThat 
                         LIKE '$whereThis'";
				if($orWhere){
					$field = trim(explode('=',$orWhere)[0]);
					$val = trim(explode('=',$orWhere)[1]);
				$q .= " OR $field LIKE '$val' ";
				}if($andWhere1){
					$field = trim(explode('=',$andWhere1)[0]);
					$val = trim(explode('=',$andWhere1)[1]);
				$q .= " AND $field LIKE '$val' ";
				}if($andWhere2){
					$field = trim(explode('=',$andWhere2)[0]);
					$val = trim(explode('=',$andWhere2)[1]);
				$q .= " AND $field LIKE '$val' ";
				}if(isset($order) && trim($order)){
				$q .= " $order";
				}if(isset($limit) && trim($limit)){
				$q .= " $limit";
				}///END if
    
		$r = mysqli_query($dbCon,$q) or die(mysqli_error($dbCon));
		if(mysqli_num_rows($r) > 0){
		$rows = array();
		 while($row = mysqli_fetch_assoc($r)){
				$rows[] = $row;
		 }///END while
				return $rows;
		}else{
				return false;
		}///END ifelse   
}
//*****************************************///
public function getFld($tbl,$whereThat,$whereThis,$fld){
		global $dbCon;
				$q = "SELECT * 
					 FROM $tbl ";
				if(trim($whereThat) && trim($whereThis)){
				$q .= " WHERE $whereThat 
						LIKE '{$whereThis}'";            
				}///END if
		$r = mysqli_query($dbCon,$q) or die(mysqli_error($dbCon));
		if(mysqli_num_rows($r) > 0){
		 $field = NULL;   
		 while($row = mysqli_fetch_assoc($r)){
				if(trim($row[$fld])){
						$field = trim($row[$fld]);    
						break;
				}else{
						 continue;
						$field = NULL; 
				}     
		 }
		}else{
				$field = NULL;
		 }                
		return $field;
}
////////////////////////////////////////////////////
}

//////////////////////////////////////////////
class fn extends sql{
public function echoNoResultsMsg($msg){
	$s = "<section class='noRzltsMsgContainer center-block text-center' align='center'>";
	$s .= "<span class='panel'><i class='fa fa-4x fa-exclamation-circle'></i>";
	$s .= "<p align='center' class='lead text-danger'>".$msg."</p>";
	$s .= "</span>";
	$s .= "</section>";
	echo $s;
}///END fn
//*****************************************///
public function checkIfTableExist($tbl_name){
	global $dbCon;
	
  $CheckTable = mysqli_query($dbCon, "SHOW TABLES LIKE '$tbl_name'");
  if(mysqli_num_rows($CheckTable) > 0 ) {
		return true;
  }else{
		return false;
  }///END if	
	
/*	if(mysqli_query($dbCon, "CHECK TABLE $tbl_name") == true){
		return true;
	}else{
		return false;
	}/////END if checkIfTableExist()*/
}//END fn
//*****************************************///
public function getItemReturnStatusByCustPurchaseHistRowId($row_id){
    $order_status = $this->getFld('customer_purchase_history','id',$row_id,'transaction_status');

    switch($order_status){
        case 0:
            $order_status_msg = 'in-process';
            break;
        case 1: 
            $order_status_msg = 'paid';
            break;
        case 2:
            $order_status_msg = 'shipped';
            break;
        case 3: 
            $order_status_msg = 'pending';
            break;
        case 4: 
            $order_status_msg = 'return-ok';
            break;
        case 5: 
            $order_status_msg = 'pending';
            break;
        case 6:
            $order_status_msg = 'cancel-ok';
            break;
		case 7:
			$order_status_msg = 'cancel-no';
			break;
		case 8:
			$order_status_msg = 'return-no';
			break;
		case 9:
			$order_status_msg = 'returned';
			break;
        default:
            $order_status_msg = NULL;
            break;
    }///END switch

    return $order_status_msg;
}///END fn
//*****************************************///
public function orderStatusMsgToCustomer($order_status){
	if($order_status == 1){
		echo "<div class='text-left bold' title='Item is being prepared for shipment'><i class='fa fa-exclamation fa-lg'></i> Item is being prepared for shipment</div>";
	}elseif($order_status == 2){
		echo "<div class='text-left bold' title='Item is being shipped'><i class='fa fa-check fa-lg'></i> Item is currently being shipped to you</div>";
	}elseif($order_status == 3){
		echo "<div class='text-left bold' title='Seller is reviewing return request'><i class='fa fa-lg fa-rotate-right fa-spin'></i> Item return request successfully sent</div>";
	}elseif($order_status == 4){
		echo "<div class='text-left bold' title='Seller approved return request'><i class='fa fa-lg fa-plane'></i> Seller approved your return request</div>";
	}elseif($order_status == 5){
		echo "<div class='text-left bold' title='Order cancellation request sent'><i class='fa fa-lg fa-hourglass fa-spin'></i> Order cancellation request successfully sent</div>";
	}elseif($order_status == 6){
		echo "<div class='text-left bold' title='Seller approved order cancellation'><i class='fa fa-lg fa-check'></i> Seller approved your order cancellation request</div>";
	}elseif($order_status == 7){
		echo "<div class='text-left bold' title='Seller denied order cancellation, check email for more details'><i class='fa fa-lg fa-exclamation'></i> Seller denied your order cancellation request</div>";	
	}elseif($order_status == 8){
		echo "<div class='text-left bold' title='Seller denied order return, check email for more details'><i class='fa fa-lg fa-exclamation'></i> Seller denied your order return request</div>";	
	}elseif($order_status == 9){
		echo "<div class='text-left bold' title='Seller denied order return, check email for more details'><i class='fa fa-lg fa-exclamation'></i> Item successfully returned and refunded</div>";	
	}///END ifelse	
}//END fn
//*****************************************///
public function ifCookieIssetReturn($cookie,$return,$else,$eqlsThis=false){
		if($eqlsThis == true){
				if(isset($_COOKIE[$cookie]) && $_COOKIE[$cookie] == trim($eqlsThis)){
						return $return;
				}else{
						return $else;
				}////end fn
		}else{
				if(isset($_COOKIE[$cookie]) && trim($_COOKIE[$cookie])){
						return $return;
				}else{
						return $else;
				}////end fn
		}
}///END fn
//*****************************************///
public function showRatingStarsByRatingNum($rating_number){
    for($i=0;$i<intval(trim($rating_number));$i++){
        echo "<img src='../assets/images/star-on.png' alt='$i' title='Rating' />";
    }///END 4each
    for($i=0;$i<(5 - trim($rating_number));$i++){
        echo "<img src='../assets/images/star-off.png' alt='$i' title='Rating' />";
    }
}////END fn
//*****************************************///
public function ifLoggedInEcho($echoThis,$elseEcho=false){
global $dbCon;
if(isset($_SESSION['username']) || isset($_SESSION['email'])){
	echo $echoThis;
	}else{
		 (trim($elseEcho)) ? print($elseEcho) : '';
	} 
}
//*****************************************///
public function getLocationDetails($address,$addy_field=false){
    ///$addy_field = individual address value/field to return
	if(isset($address) && !empty($address)){
	/////GET lat/lng FROM ZIP CODE 
		$maps_url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode(trim($address)); //&latlng=40,40&sensor=false;	
		$map_json = @file_get_contents($maps_url);

		if(trim(strlen($address)) > 2 
		&& trim($map_json)){
			//decode with jsonDecode() into array	
			$map_array = json_decode($map_json,true); 

			//store address in array
			$map_address[] = $map_array['results'][0]['formatted_address'];		

			//loop through address
			 foreach($map_address AS $address){
			 if(!is_null($map_address)){
				$addresses = str_getcsv($address); ///array
				$street = trim(strtolower($addresses[0]));
				$city = trim(strtolower($addresses[1]));
				$state = trim(explode(' ',trim($addresses[2]))[0]);
				///format zip
				(strstr(trim($addresses[2]),' ')) ? $zip = trim(explode(' ',trim($addresses[2]))[1]) : $zip = trim($addresses[2]);

				@$address = ucwords($addresses[0]).', '.ucwords($addresses[1]).', '.$addresses[2];		

				 if(trim($addy_field)){
					 switch(trim(strtolower($addy_field))){
					case 'street':
						return $street;
						break;
					case 'state':
						return $state;
						break;
					case 'city':
						return $city;
						break;
					case 'zip':
						return $zip;
						break;
					 }///END switchcase
				 }else{
					return $address;
				 }////END if	
			}////END if	
		 }///END 4each
		}else{
			return NULL;
		}///END if+
	}///END if isset(input addy)
}///END fn
//*****************************************///
public function ifLoggedInReturnAsMember($returnThis){
//global $dbCon;
if(isset($_COOKIE['login'])){
		return $returnThis;
	}elseif(isset($_COOKIE['login_info'])){
		return $returnThis;
	}else{
		return false;
	}//END ifelse
}//if logged in as regular members
//*****************************************///
public function ifLoggedInAsMerchantReturn($returnThis){ ////*need to finish this fn*/
//global $dbCon;
if((isset($_SESSION['merchant_login'])) || isset($_COOKIE['merchant'])){
	return $returnThis;
	}else{
		return false;
	} 
}//if logged in as merchant
//*****************************************///
public function ifLoggedOut($echoThis){
global $dbCon;
if(!isset($_SESSION['username'])){
	echo $echoThis;
	}else{
		 echo "";
	} 
}
//*****************************************///
public function ifLoggedInAsMerchant($returnThis,$else){
	if($_COOKIE){
		if(isset($_COOKIE['merchant']) && !empty($_COOKIE['merchant'])){
			return $returnThis;
		}else{
			return $else;
		}///END ifelse
	}///END ifcookie
}///END fn
//*****************************************///
public function getNameById($id){
		global $dbCon;
		$r = mysqli_query($dbCon,"SELECT mem_name 
                                 FROM members 
                                 WHERE id 
                                 LIKE '$id'") or die(mysqli_error($dbCon));
		if(mysqli_num_rows($r) > 0){
				while($row = mysqli_fetch_array($r)){
				 return $row[0];
				}        
		}else{
				return NULL;
		}
} ////get member names
//*****************************************///
public function getItemNameById($item_id){
    global $dbCon;
    $fields = $this->getRows('items_4_sale','id',$item_id,false,'LIMIT 1');
    if($fields){
        extract($fields[0]);
        return str_ireplace('_',' ',ucwords($item_name.' '.$item_category));
    }else{
        return NULL;
    }///END if
}///END fn
//*****************************************///
public function getMerchantCompnayName($id){
		global $dbCon;
		$r = mysqli_query($dbCon,"SELECT merchant_company 
								 FROM merchants 
								 WHERE mem_id 
								 LIKE '$id'") or die(mysqli_error($dbCon));
		if(mysqli_num_rows($r) > 0){
				while($row = mysqli_fetch_array($r)){
				 return $row[0];
				}        
		}else{
				return NULL;
		}
}///BY ID
//*****************************************///
public function getIdByName($name){
		global $dbCon;
		$r = mysqli_query($dbCon,"SELECT id 
								FROM members 													 LIKE '$name'") or die(mysqli_error($dbCon));
		if(mysqli_num_rows($r) > 0){
				while($row = mysqli_fetch_array($r)){
				 return $row[0];
				}        
		}else{
				return NULL;
		}
}	
//*****************************************///
public function getAvatar($nameOrId){
		global $dbCon;

				$q = "SELECT mem_avatar 
						 FROM members ";
		if(is_numeric($nameOrId)){
				$q .= " WHERE id LIKE '$nameOrId'";
		}else{
				$q .= " WHERE mem_username = '$nameOrId'";
		}
		$r = mysqli_query($dbCon,$q) or die(mysqli_error($dbCon));
		while($row = mysqli_fetch_array($r)){
				if(trim($row[0])){
						return dirname($_SERVER['REQUEST_URI']).'/assets/images/upl/'.urldecode(trim($row[0]));
				}else{
						return dirname($_SERVER['REQUEST_URI']).'/assets/images/upl/boy.png'; 
				}
				break;
		}///END WHILE
 }//END fn
//*****************************************///
public function echoItemPgUrlById($item_id){
	$page = (isset($page)) ? trim($page) : 'home' ;
	$item_type = $this->getItemFieldById($item_id,'item_type');
	
	printf(urldecode(trim(BASE_URL."/?page=%s&prdid=%s&prdtpe=%s")),
				$page,
				$item_id,
				$item_type);
}///END fn
//*****************************************///
public function getItemPgUrlById($item_id){
	$page = (isset($page)) ? trim($page) : 'home' ;
	$item_type = $this->getItemFieldById($item_id,'item_type');
	$host = $_SERVER['SERVER_NAME'];
	
	if(trim(strtolower($host)) == 'localhost'){
		$url = sprintf(urldecode(trim("/fixquick.newTmpl8/PHP/?page=%s&prdid=%s&prdtpe=%s")),
					$page,
					$item_id,
					$item_type);			
	}else{
		$url = sprintf(urldecode(trim(BASE_URL."/?page=%s&prdid=%s&prdtpe=%s")),
					$page,
					$item_id,
					$item_type);	
	}
	
	return $url;
}///END fn
//*****************************************///
public function getItemFieldById($item_id,$item_field){
	$item_id = trim(intval($item_id));
		global $dbCon;
		$q = "SELECT *
				 FROM items_4_sale 
				 WHERE id LIKE '$item_id'";
		$r = mysqli_query($dbCon,$q) or die(mysqli_error($dbCon).' prob wit getting itemname');
		if(mysqli_num_rows($r) > 0){
				while($row = mysqli_fetch_assoc($r)){
						return $row[$item_field];
				}///END while 
		}/*else{
			print("error with getItemFieldById Function while pulling item_id:".$item_id.' by item_field: '.$item_field);
		}*/
}
//*****************************************///
public function getFluidItemPic($item_id,$fluid_size = false){
 global $dbCon;
 global $brands;
		$q = "SELECT *
				 FROM items_4_sale 
				 WHERE id LIKE '$item_id' 
				 AND item_type = 'fluid'";
		$r = mysqli_query($dbCon,$q) or die(mysqli_error($dbCon).', wtf with prod_pic');
		if(mysqli_num_rows($r) > 0){
				while($row = mysqli_fetch_assoc($r)){
						$name = $row['item_name'];
						$size = strtolower($row['fluid_size']);
						$weight = strtolower($row['oil_weight']);
						$type = strtolower($row['fluid_type']);
						$spec = strtolower($row['fluid_specs']);
                        $cat = strtolower(trim($row['item_category']));
						break;
				}///END while
			global $brands;
		 ////check if returning gallon $fluid_size or quarts 
		foreach($brands AS $brand){
				if(stristr(trim($name),$brand)){
						if($fluid_size == true){
								return trim('/fixquick.newTmpl8/PHP/assets/images/'.$brand.'_'.$size.'.jpg'); 
						}elseif(trim(strtolower($cat)) == 'oil' || trim(strtolower($cat)) == 'engine_oil'){
								return trim('/fixquick.newTmpl8/PHP/assets/images/'.$brand.'_oil.jpg');
						}elseif(trim($type) == 'powersteering' || trim($type) == 'powersteering_fluid'){
								return trim('/fixquick.newTmpl8/PHP/assets/images/'.$brand.'_powersteering_fluid.jpg');
						}elseif(trim($type) == 'transmission' || trim($type) == 'transmission_fluid'){
								return trim('/fixquick.newTmpl8/PHP/assets/images/'.$brand.'_'.$spec.'.jpg');
						}elseif(trim($type) == 'coolant' || trim($type) == 'coolant_fluid'){
								return trim('/fixquick.newTmpl8/PHP/assets/images/'.$brand.'_coolant.jpg');
						}else{
								return trim('/fixquick.newTmpl8/PHP/assets/images/'.$brand.'.jpg'); 
						}///END ifelse
						break;
				}///END if
		}//END 4each
	}else{
        return "pic not found";    
    }///END if
}/////END fn
//*****************************************///
public function echoBrandLogoByItemName($item_name,$else_echo = false){
		global $brands;
		if(trim($item_name)){
				foreach($brands AS $brand){
						if(stristr($item_name,$brand)){
							$else_echo = (trim($else_echo)) ? $else_echo : '';
								$brand = trim(strtolower($brand));
								(!empty($brand)) ? print(urldecode("/fixquick/css/img/{$brand}.png")) : print($else_echo) ;
										break;
						}///END if
				}///END 4each
		}///END if
}////END fn
//*****************************************///
public function getItemPic($item_id,$skipUplPic = false,$useThisPic = false){
	global $dbCon;

	$item_type = trim($this->getFld('items_4_sale','id',$item_id,'item_type'));
	$item_cat = trim($this->getFld('items_4_sale','id',$item_id,'item_category'));
    $item_id = trim($item_id);
    $r = trim($this->getFld('item_4_sale_pics','item_id',$item_id,'item_pic_file'));    

	 	if($useThisPic){
            
			return urldecode('/fixquick.newTmpl8/PHP/assets/images/'.$useThisPic);
            
		}elseif((strlen($r) > 0) && file_exists('/fixquick.newTmpl8/PHP/assets/images/upl/'.$r)){

             return '/fixquick.newTmpl8/PHP/assets/images/upl/'.$r;

		}else{
            
			if($item_type == 'fluid'){
				return $this->getFluidItemPic($item_id);
			}elseif($item_type == 'part'){                
                $picName = (strstr($item_cat,'/')) ? str_replace('/','',$item_cat) : $item_cat;
                
                return '/fixquick.newTmpl8/PHP/assets/images/'.strtolower(str_replace(' ','_',$picName)).'.jpg';
			}elseif($item_type == 'tire'){
				return '/fixquick.newTmpl8/PHP/assets/images/tires.jpg';
			}elseif($item_type == 'accessory'){
				return urldecode('/fixquick.newTmpl8/PHP/assets/images/products/'.$this->getItemFieldById($item_id,'item_category').'.jpg');
			}else{
				return '/fixquick.newTmpl8/PHP/assets/images/picture.png';
			}///END elseif
		}///END num_rows
}///END fn    
//*****************************************///
public function echoIfIsset($chk,$Echo,$elseEcho){
		if(isset($chk) || !empty($chk)){
				echo $Echo;
		}else{
				echo $elseEcho;
		}
}
//*****************************************///
public function getFormatPriceWithoutDecimal($price){
		if(!strstr($price,'.')){
				return $price.'.00';
		}else{
				return round($price,2);
		}///END if
}///END fn
//*****************************************///
public function re4mattedPhoneNum($phone){
	(trim($phone)) ? substr($phone,0,3).'-'.substr($phone,3,3).'-'.substr($phone,6,10) : '';

	return $phone;
}///END fn
//*****************************************///
public function getD8Re4matted($d8){
 if(isset($d8) &&  $d8 !== 'Private'){
		$d8 = explode('-',$d8);
		$d8New = $d8[1].'-'.$d8[2].'-'.$d8[0];
	 return $d8New;     
 }else{
		 echo "";
 }//END else
}////END if
//*****************************************///
public function ifIssetAndEquals($var,$eqls,$Echo,$else){
				if(isset($var) && $var == $eqls){
					echo $Echo;
		 }else{
				 echo $else;
		 }
 }
//*****************************************///  
public function getAdminFld($usrName){
		global $dbCon;
		$q = "SELECT `admin` 
					FROM `members`
					WHERE `mem_username` = '$usrName'";
		$r = mysqli_query($dbCon,$q) or die(mysqli_error($dbCon));
				while($row = mysqli_fetch_assoc($r)){
						$adminStatus = $row['admin'];
						 break;
				}
		return $adminStatus;
}
//*******************************$**********///
public function chkIfScartTblExist(){
		global $dbCon;
	if($fn->ifLoggedInReturn(true)){
		$scart_tbl = 'shopping_cart_'.strtolower(trim(_USER_));
	$chk4sCartTbl = mysqli_query($dbCon,"SHOW TABLES LIKE '$scart_tbl'");
	if(mysqli_num_rows($chk4sCartTbl) > 0){
				return true;
		}else{
				return false;
		}///END ifelse
	}else{
			return false;
	}///END ifelse
}///END fn
//*****************************************///
public function getCompId($usrName){
		global $dbCon;
		$q = "SELECT `company_id` 
					FROM `members`
					WHERE `mem_username` = '$usrName'";
		$r = mysqli_query($dbCon,$q) or die(mysqli_error($dbCon));
				while($row = mysqli_fetch_assoc($r)){
						$company_id = $row['company_id'];
						 break;
				}
		return $company_id;
}
//*****************************************///
public function ifGet($get,$eqls,$echo,$else){
		if(trim($eqls)){
				if(isset($_GET[$get]) && $_GET[$get] == $eqls){
						echo $echo;
				}else{
						echo $else;
				}
		}else{
				if(isset($_GET[$get])){
						echo $echo;
				}else{
						echo $else;
				}
		}
}
//*****************************************///
public function ifStrstr($This,$inThis,$echo,$else){
		if(stristr($inThis,$This)){
				echo $echo;
		}else{
				echo $else;
		}
}
//*****************************************///
public function getFileByPath($path){
		if(trim($path)){
				$path = explode('\\',$path);
				$path = end($path);
				if(stristr($path,'.')){
						$end = explode('.',$path);
						$exts = array('php','html','htm','js');
						if(in_array(end($end),$exts)){
								$path = str_replace('.'.end($end),'',$path);
								return $path;
						}else{
								return false;
						}///END ifelse
				}///END if
		}///END if
}///$path = __file__
//*****************************************///
public function alertString($string){
		if(isset($string)){
				print("<script>alert('$string');</script>");
		}//END if
}//END fn    
//*****************************************///
public function popUpMsg($string){
		if(isset($string)){
				print("<script>popUpMsg('$string');</script>");
		}//END if
}//END fn  	
//*****************************************///
public function ifValGreaterThan($val,$greaterThanThis,$return,$else){
		if(trim(intval($val)) > trim(intval($greaterThanThis))){
				return $return;
		}else{
				return $else;
		}///END if
}////END fn
//*****************************************///
public function getItemRatingAvg($item_id){
		global $dbCon;
	//GET RATING FOR THIS ITEM
	$q = "SELECT *
		 FROM item_ratings
		 WHERE item_id LIKE '$item_id'";
	$rzlt = mysqli_query($dbCon,$q) or die(mysqli_error($dbCon));
	if(mysqli_num_rows($rzlt) > 0){
			$total_ratings = array();
		while($row = mysqli_fetch_assoc($rzlt)){
			$total_ratings[] = $row['item_rating'];
		}//END while
			$total_ratings_added = array_sum($total_ratings);
			$ratings_avg = $total_ratings_added / count(array_values($total_ratings));
			$ratings_avg = round($ratings_avg);
	}else{
		$ratings_avg = NULL;
	}//END ifelse    
        return $ratings_avg;
}///END fn
//*****************************************///
public function returnThisIfThat($ifThis,$isThat,$returnThis,$elseReturn = false){
    if(trim($ifThis) == trim($isThat)){
        return $returnThis;
    }elseif($elseReturn){
        return $elseReturn;
    }//END ifelse
}//END fn
//*****************************************///
public function dateAdd($hour,$minute,$day){	
		$newdate = date('Y-m-d', mktime(
		date('h') + $hour, ////hour
		date('i') + $minute, /////minute
		0,                  ////seconds
		date('m'), ////month
		date('d') + $day, /////day
		date('y'))); //////year
return $newdate;
}///END fn
    
}////END CLASS fn

////////////////////////////////////////
class shipping extends fn{
    
    protected $api_key;
    
    public function __CONSTRUCT(){
        $this->api_key = "shippo_test_5a99fe7699d70a84fe96115166e7359ae8ec9959";
    }///END fn

    public function getRetrieveRates($object_id){
        require_once($_SERVER['DOCUMENT_ROOT'].'/fixquick.newTmpl8/PHP/shippo-php-client-master/lib/Shippo.php');

        Shippo::setApiKey('shippo_test_5a99fe7699d70a84fe96115166e7359ae8ec9959');

        $retrieved_rates = Shippo_Rate::retrieve($object_id,$this->$api_key);

        return($retrieved_rates);
    }///END fn
    //*****************************************///
    public function getShippingRsrcIfLoggedIn($item_id,$getRates = false,$getRateInfo = false){
        require_once($_SERVER['DOCUMENT_ROOT'].'/fixquick.newTmpl8/PHP/shippo-php-client-master/lib/Shippo.php');

        Shippo::setApiKey('shippo_test_5a99fe7699d70a84fe96115166e7359ae8ec9959');

        // for demo purposes we set the max. transit time here
        //const MAX_TRANSIT_TIME_DAYS = 3;

        ///EXTRACT ITEMS DIMENSIONS AND WEIGHT
        extract($this->getRows('items_4_sale','id',$item_id)[0]);

        ///GET SHIPPERS ID
        $shippersId = $this->getIdByName(trim($item_seller));

        ///PULL RECIPIENTS ADDRESS INFORMATION
        $shipTo = $this->getRows('mem_address','mem_id',_ID_);
        $shipToPhone = $this->getFld('members','id',_ID_,'mem_phone');
        $shipFromEmail = $this->getFld('members','id',_ID_,'mem_email');

            foreach($shipTo AS $shippingTo){
                ($shippingTo['billing_address'] == '1') ? $shipTo = $shippingTo : '';
            }///END 4each

        ///PULL SENDERS-SHIPPERS ADDRESS INFORMATION
        $shipFrom = $this->getRows('mem_address','mem_id',$shippersId);
        $shipFromPhone = $this->getFld('members','id',$shippersId,'mem_phone');
        $shipToEmail = $this->getFld('members','id',$shippersId,'mem_email');

            foreach($shipFrom AS $shippingFrom){
                ($shippingFrom['billing_address'] == '1') ? $shipFrom = $shippingFrom : '';
            }///END 4each

        $fromAddress = array(
            'object_purpose' => 'PURCHASE',
            'name' => trim($item_seller),
            'company' => 'FixQuick',
            'street1' => $shipFrom['mem_street'],
            'city' => $shipFrom['mem_city'],
            'state' => $shipFrom['mem_state'],
            'zip' => $shipFrom['mem_zip'],
            'country' => 'US',
            'phone' => trim($shipFromPhone),
            'email' => trim($shipFromEmail));
        // example fromAddress
        $toAddress = array(
            'object_purpose' => 'PURCHASE',
            'name' => $shipTo['mem_name'],
            'company' => $this->getMerchantCompnayName(_ID_),
            'street1' => $shipTo['mem_street'],
            'city' => $shipTo['mem_city'],
            'state' => $shipTo['mem_state'],
            'zip' => $shipTo['mem_zip'],
            'country' => 'US',
            'phone' => trim($shipToPhone),
            'email' => trim($shipToEmail));
        // example parcel
        $parcel = array(
            'length'=> $item_length,
            'width'=> $item_width,
            'height'=> $item_height,
            'distance_unit'=> 'in',
            'weight'=> $item_weight,
            'mass_unit'=> 'lb'
        );	

        // example Shipment object
        $shipment = Shippo_Shipment::create(
        array(
            'object_purpose'=> 'PURCHASE',
            'address_from'=> $fromAddress,
            'address_to'=> $toAddress,
            'parcel'=> $parcel,
            'async'=> false
        ));
        // Select the rate you want to purchase.
        // We simply select the first rate in this example.
        $rates = array($shipment["rates_list"]);
        $r8 = $shipment["rates_list"][0];

        // label_url and tracking_number

        if($getRates == true){
            $lowestR8 = array();
            $allR8info = array();
            for($i=0;$i<count(array_values($rates));$i++){
                ///pull fields from array via loop
                for($n=0;$n<count($rates[$i]);$n++){

                    if($getRateInfo == true){
                        
                        return $rates[$i][$n][$getRateInfo];

                    }else{
                        
                        return $rates[$i][$n]['provider'].' '.$rates[$i][$n]['servicelevel_name'].' $'.$rates[$i][$n]['amount'].' <br>Estimated Time of Arrival: '.$rates[$i][$n]['days'].' Days';
                        
                    }//END ifelse

                }///END 4loop
            }///END foreach
        }else{
            ////purchase desired rate by making transaction request

            // Purchase the desired rate
            $transaction = Shippo_Transaction::create(array(
                'rate'=> $r8["object_id"],
                'async'=> false
            ));
            if ($transaction["object_status"] == "SUCCESS"){
                //echo('Label: '.$transaction["label_url"].'\n Trackging #: '.$transaction["tracking_number"]);
            print($transaction);

            }else{
                echo "Error with transaction: ";

                foreach ($transaction["messages"] as $message) {
                    echo($message);
                }///END for
            }///END ifelse
        }///END if

        /*
        if ($transaction["object_status"] == "SUCCESS"){
            echo($transaction["label_url"]);
            echo("\n");
            echo($transaction["tracking_number"]);
            echo "<br><br><hr><br>";

            echo print_r($transaction,true);
        }else{
            foreach ($transaction["messages"] as $message) {
                echo($message);
            }///END for
        }///END ifelse
    */
    }
}///END CLASS shipping

//////////////////////////////////////////////
class hdr{
    
    public function meta($keywords,$author,$desc){
    
    echo '
    <meta charset="utf-8"/>
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta http-equiv="content-type" content="text/html" />
    <meta http-equiv="content-type" content="cache" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="'.$author.'" />	
    <meta name="robots" content="INDEX,FOLLOW" />
    <meta name="keywords" content="'.$keywords.'" />
    <meta name="description" content="'.$desc.'" /> 	  
    
    <script src="/fixquick/js/jquery-1.11.3.min.js" ></script>
	<script src="/fixquick/js/jquery-ui.js" ></script>
  	<script src="/fixquick/js/bootstrap.min.js" ></script>
	<script src="/fixquick/js/custom.js" ></script>   
 	<script src="/fixquick/js/jquery.easing.min.js" ></script>
 	<script src="/fixquick/js/jquery-scrollto.js" ></script>
 	<script src="/fixquick/js/jquery.validate.js" ></script>
    <script src="/fixquick/js/modernizr.js"></script> 
    <script src="/fixquick/js/loadie.js"></script> 
    <script src="/fixquick/js/format_phone_input.js"></script> 
	

	<link rel="stylesheet" href="/fixquick/css/footer-distributed-with-address-and-phones.css">
    <link rel="icon" href="/fixquick/css/icon.ico" /> 
	<link rel="stylesheet" type="text/css" href="/fixquick/css/bootstrap.css" />   
    <link rel="stylesheet" type="text/css" href="/fixquick/css/jquery-ui.css" />	
 	<link rel="stylesheet" type="text/css" href="/fixquick/css/custom.css" />
    <link rel="stylesheet" href="/fixquick/css/font-awesome.css">
       
	<!--<link rel="stylesheet" href="/fixquick/css/reset.css">  -->
	<!--<link rel="stylesheet" href="/fixquick/css/style.css">   -->       
    ';
    }
    
    public static function page($pg){
	  if(defined('_PG_')){
		  $pg = true ? ($pg == _PG_ ? 'active' : '') : false;
	  }
	  return $pg;
  }///////////////////////////
}////END CLASS hdr

/*******************************************************
				DEFINE USER CREDENTIALS AS CONSTANTS
*******************************************************/
if(isset($_COOKIE['login']) && isset($_COOKIE['login_info'])){
	
    $credentials = unserialize($_COOKIE['login_info']);
											
    (!defined('_ID_')) ? define('_ID_',$credentials['id']) : '';
    (!defined('_USER_')) ? define('_USER_',$credentials['username']) : '';
	////just incase new mem registration instead of member loging in
	if(isset($credentials['address']) && isset($credentials['phone'])){
    (!defined('_ADDRESS_')) ? define('_ADDRESS_',$credentials['address']) : '';
    (!defined('_PHONE_')) ? define('_PHONE_',$credentials['phone']) : '';
	}///END if 
}///END if

/////////////// END FUNK \\\\\\\\\\\\\\\\\\\\\
$sql = new sql;
//////////////////////////////////////////////
$fn = new fn;
//////////////////////////////////////////////
$hdr = new hdr;
//////////////////////////////////////////////
$shipping = new shipping;
//////////////////////////////////////////////
?>
