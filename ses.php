<?php 
 require_once(realpath(__DIR__ . DIRECTORY_SEPARATOR . 'fn.php'));
////////////////SESSION BEGIN/////////////////
$logout = 'logout';
$login  = 'login';
$success = md5('success');
$wrong  = md5('wrong');
$emptyField = md5('empty');
$max = md5('max');
	
global $fn,$sql,$hdr;	
	
  /////////////SESSION STARTED/////////////////			
  if(isset($_SESSION)){
	  return $_SESSION;
  }else{
	   session_start();
	   session_name('fixQuick');
  }////END ifelse

/*************************************
	SIGN-OUT / LOGOUT PROCESS
*************************************/	
if(isset($_GET['logoutUser'])){
	$_SESSION = array();
	session_unset();
	session_destroy();
	setcookie("login",'',time()-30000,'/');
	setcookie("login_info",'',time()-30000,'/');
	setcookie("merchant",'',time()-30000,'/');
	
 	  header("Location: /".DOMAIN_NAME."/PHP/?page=home&".md5('userloggedout'));
	  exit();
}///END if

/************************************
  SIGN-IN / LOGIN PROCESS 4 MEMBERS
*************************************/	  
if(isset($_POST['userLoginProcess'])){

  if((isset($_POST['usr_email']) && !is_null($_POST['usr_email'])) &&
	 (isset($_POST['usr_pw']) && !is_null($_POST['usr_pw']))){
	  
	if((strlen(trim($_POST['usr_email'])) > '0') &&
		strlen(trim($_POST['usr_pw'])) > '0'){
	 
	 require_once(realpath(__DIR__ . '/sv.php'));
		
		$login_email = trim(strip_tags($_POST['usr_email']));
		$login_email = mysqli_real_escape_string($dbCon,$login_email);
 		$login_pw = trim(strip_tags($_POST['usr_pw']));
		$login_pw = mysqli_real_escape_string($dbCon,$login_pw);
		
		///chk db for pw and email match
		$numRows_of_chk4Match = $sql->numRows('members','mem_email',$login_email,false,false,false,"mem_password=$login_pw");
		
		//print($login_email.' & '.$login_pw.' rows = '.$numRows_of_chk4Match);

	  if($numRows_of_chk4Match > 0){
		//////-----LOGIN SUCCESSFULL BY MEMBER------////////
		($_COOKIE['guest_cart_items']) ? setcookie('guest_cart_items','',date()-20000,'/') : null;
		
		/////SET SESSION COOKIE
		$_SESSION['email'] = $login_email;
		$_SESSION['username'] = (!is_null(trim($sql->getFld('members','mem_email',$login_email,'mem_username')))) ? trim($sql->getFld('members','mem_email',$login_email,'mem_username')) : $login_email;	
		$_SESSION['id'] = trim($sql->getFld('members','mem_email',$login_email,'id'));		
		$_SESSION['name'] = (!is_null(trim($sql->getFld('members','mem_email',$login_email,'mem_name')))) ? trim($sql->getFld('members','mem_email',$login_email,'mem_name')) : 'New Member';
					
		/////SET REGULAR COOKIE
		$mem_address = $sql->getFld('members','mem_email',$login_email,'mem_address');
		$mem_phone = $sql->getFld('members','mem_email',$login_email,'mem_phone');
		$mem_id = $sql->getFld('members','mem_email',$login_email,'id');
		$login_info = serialize(array(
								'username'=>$_SESSION['email'],
								'phone'=>$mem_phone,
								'address'=>$mem_address,
								'id'=>$mem_id)
								);
		
		setcookie('login',$login_email,time() + 30000, '/'); //default time: 86400000
		setcookie('login_info',$login_info,time() + 30000, '/'); //default time: 86400000
		setcookie('guest_car','',time() - 30000, '/'); //default time: 86400000
		
		  header("Location: /".DOMAIN_NAME."/PHP/?page=$page&".md5("login")."=".md5("1"));
		  exit();
	  }else{
		  header("Location: /".DOMAIN_NAME."/PHP/?page=$page&".md5("login")."=".md5("0"));
		  if(isset($_SESSION)){
			  session_destroy();
			  $_SESSION = array();
		  }///END if
		  exit();
	  }///END ifelse login & pw found in db
 /* 
			////IF LOGIN FOUND IN DATABASE
			print("<script>window.open('/fixitquick/?$login=$success','_self');</script>");
			
			////CR8 COOKIE 
			setcookie('login',$_SESSION['username'],time() + 30000, '/');
			
			////IF REMEMBER_ME BOX CHECKED CR8 COOKIE
			$_POST['rememberMe'] == true ? setcookie('rememberMe',$login_name.','.$login_pw,time() + 90000, '/') : setcookie('rememberMe','',0, '/');
			
*/
	}else{
		header("Location:/".DOMAIN_NAME."/?page=$page&login=$emptyField");
	}//END IF LOGIN OR PASSWORRD FIELDS !ISSET
  }////END if isset login and password submitted 
}/////END if isset $_POST['login'] 	 

/*************************************
	NEW USER REGISTRATON PROCESS
*************************************/	
if(isset($_REQUEST['newSignup'])){
	require_once(realpath(__DIR__ . '/sv.php'));

	$email_login = trim(strip_tags($_REQUEST['usr_email']));
	$email_login = mysqli_real_escape_string($dbCon,$email_login);
	$password = trim(strip_tags($_REQUEST['usr_pw2']));
	$password = mysqli_real_escape_string($dbCon,$password);
	$dup_rows = $sql->numRows('members','mem_email',$email_login);
	$ins3rtThisIntoThatArray = array(
		"mem_email=$email_login",
		"mem_password=$password"
	);
		
	///INSERT NEW MEM INFO INTO DB
	if(trim($dup_rows) == 0){
		$sql->insertArrayIntoDb('members',$ins3rtThisIntoThatArray);
		
		/////SET SESSION COOKIE
		$_SESSION['email'] = $email_login;
		$_SESSION['username'] = $email_login;	
		$_SESSION['id'] = trim($sql->getFld('members','mem_email',$email_login,'id'));		
		$_SESSION['name'] = (!is_null(trim($sql->getFld('members','mem_email',$email_login,'mem_name')))) ? trim($sql->getFld('members','mem_email',$email_login,'mem_name')) : 'New Member';
				
		/////SET REGULAR COOKIE
		$mem_id = $_SESSION['id'];
		$login_info = serialize(array(
									'username'=>$email_login,
									'id'=>$mem_id
									)
								); ///END serialize login info
		
		setcookie('login',$_SESSION['username'],time() + 30000, '/'); //default time: 86400000
		setcookie('login_info',$login_info,time() + 30000, '/'); //default time: 86400000
		setcookie('guest_car','',time() - 9000, '/'); //default time: 86400000
		
		header("Location: /".DOMAIN_NAME."/PHP/?page=$page&".md5("login")."=".md5("1"));
	}else{
		header("Location: /".DOMAIN_NAME."/PHP/?page=$page&".md5("login")."=".md5("0"));
		  if(isset($_SESSION)){
			  session_destroy();
			  $_SESSION = array();
		  }///END if
		  exit();
	}//END ifelse
	
/* 	if(!trim($chk4dupName) && $email_login && $password && $email){
		$q = "INSERT INTO members (
							mem_username,
							mem_email,
							mem_password,
							d8_created)
						VALUES (
							'$email_login',
							'$email',
							'$password',
							 NOW())"; 
		mysqli_query($dbCon,$q) or die('new registration error: '.mysqli_error($dbCon));					
			
		(mysqli_affected_rows($dbCon) > 0) ? print(json_encode(array('login'=>$email_login,'pw'=>$password))) : print('');
		/////SET SESSION COOKIE
		$_SESSION['email'] = $login_email;
		$_SESSION['username'] = (!is_null(trim($sql->getFld('members','mem_email',$login_email,'mem_username')))) ? trim($sql->getFld('members','mem_email',$login_email,'mem_username')) : $login_email;	
		$_SESSION['id'] = trim($sql->getFld('members','mem_email',$login_email,'id'));		
		$_SESSION['name'] = (!is_null(trim($sql->getFld('members','mem_email',$login_email,'mem_name')))) ? trim($sql->getFld('members','mem_email',$login_email,'mem_name')) : 'New Member';
				
		/////SET REGULAR COOKIE
		$mem_address = $sql->getFld('members','mem_email',$login_email,'mem_address');
		$mem_phone = $sql->getFld('members','mem_email',$login_email,'mem_phone');
		$mem_id = $sql->getFld('members','mem_email',$login_email,'id');
		$login_info = serialize(array(
								'username'=>$login_email,
								'phone'=>$mem_phone,
								'address'=>$mem_address,
								'id'=>$mem_id)
								);
		
		setcookie('login',$_SESSION['username'],time() + 900000, '/'); //default time: 86400000
		setcookie('login_info',$login_info,time() + 900000, '/'); //default time: 86400000
		
		  header("Location: /".DOMAIN_NAME."/PHP/?page=$page&".md5("login")."=".md5("1"));

	}////END if */
}///END if newSignup
/***********************************
////MERCHANT LOGIN LOGOUT PROCESS///////
************************************/
if(isset($_GET['logoutMerchant'])){
	$_SESSION = array();
	unset($_SESSION);
	session_unset();
	session_destroy();
	setcookie('login','',time()-30000);
	setcookie('login_info','',time()-30000);
	setcookie('merchant','',time()-30000,'/');
	
	header("Location: /".DOMAIN_NAME."/PHP/merchants/?logout=1");
	exit();
}elseif(isset($_POST['merchantLogin'])
 && !is_null(trim($_POST['signInEmail']))
 && !is_null(trim($_POST['signInPassword']))){
	 	 
	$merchant_login = mysqli_real_escape_string($dbCon,$_POST['signInEmail']);
	$merchant_password = mysqli_real_escape_string($dbCon,$_POST['signInPassword']);

	///check integrity of username and password match in db
	$chk_email = $sql->numRows('merchants','merchant_email',$merchant_login);
	
	if($chk_email > 0){
		$pull_password = $sql->getFld('merchants','merchant_email',$merchant_login,'merchant_pw');
		
		///if password match found then...
		if(password_verify($merchant_password, $pull_password)){
		  $merc_id = $sql->getFld('merchants','merchant_email',$merchant_login,'id');
		
			$pull_rows = $sql->getRows('merchants','id',$merc_id)[0]; //pull only row with merchant information
		
			$merc_cred = serialize(array(
				'id'=>trim(intval($pull_rows['id'])),
				'name'=>trim($pull_rows['merchant_name']),
				'company'=>trim($pull_rows['merchant_company']),
				'email'=>trim($pull_rows['merchant_email'])
			));////END $merc_cred array;
				
			// cr8 cookie 4 merchant credentials
			setcookie('merchant',$merc_cred,time() + 30000,'/');
			
			header("Location: /".DOMAIN_NAME."/PHP/merchants/?login=1");
			exit();
		}else{
			header("Location: /".DOMAIN_NAME."/PHP/merchants/?login=0");
			exit();
		}///END ifelse;
	}else{
		header("Location: /".DOMAIN_NAME."/PHP/merchants/?login=2");
		exit();
	}///END if
}///END ifelse
	
/*******************************
  MERCHANT REGISTRATON PROCESS
*********************************/
elseif(isset($_POST['merchantRegister'])){
	$first_name = (isset($_REQUEST['signUpFirstName']) && !is_null(trim($_REQUEST['signUpFirstName']))) ? mysqli_real_escape_string($dbCon,$_REQUEST['signUpFirstName']) : NULL;
	$last_name = (isset($_REQUEST['signUpLasttName']) && !is_null(trim($_REQUEST['signUpLasttName']))) ? mysqli_real_escape_string($dbCon,$_REQUEST['signUpLasttName']) : NULL;
	$email = (isset($_REQUEST['signUpEmail']) && !is_null(trim($_REQUEST['signUpEmail']))) ? mysqli_real_escape_string($dbCon,$_REQUEST['signUpEmail']) : NULL;
	$merchant_address = (isset($_REQUEST['signUpAddress']) && !is_null(trim($_REQUEST['signUpAddress']))) ? mysqli_real_escape_string($dbCon,$_REQUEST['signUpAddress']) : NULL;
	$company_name = (isset($_REQUEST['signUpCompanyName']) && !is_null(trim($_REQUEST['signUpCompanyName']))) ? mysqli_real_escape_string($dbCon,$_REQUEST['signUpCompanyName']) : NULL;
	$phone_number = (isset($_REQUEST['signUpPhoneNumber']) && !is_null(trim($_REQUEST['signUpPhoneNumber']))) ? mysqli_real_escape_string($dbCon,$_REQUEST['signUpPhoneNumber']) : NULL;
	$password = (isset($_REQUEST['signUpPassword1']) && trim($_REQUEST['signUpPassword1']) == trim($_REQUEST['signUpPassword2'])) ? mysqli_real_escape_string($dbCon,$_REQUEST['signUpPassword2']) : mysqli_real_escape_string($dbCon,$_REQUEST['signUpPassword1']);
	$password = password_hash($password,PASSWORD_DEFAULT);
	$tax_id = (isset($_REQUEST['signUpTaxId']) && !is_null(trim($_REQUEST['signUpTaxId']))) ? mysqli_real_escape_string($dbCon,$_REQUEST['signUpTaxId']) : NULL;
	
	///get address tokens from physical address field
	$city_state_country = (isset($_REQUEST['signUpZipCode']) && !is_null(trim($_REQUEST['signUpZipCode']))) ? trim($_REQUEST['signUpZipCode']) : NULL;
	$merchant_city = (strstr($city_state_country,',')) ? trim(strtolower(str_getcsv($city_state_country)[0])) : trim(strtolower($city_state_country));
	$merchant_state = (strstr($city_state_country,',')) ? trim(strtolower(str_getcsv($city_state_country)[1])) : trim(strtolower($city_state_country));
	$merchant_zip = (isset($_REQUEST['merchant_zip']) && !is_null(trim($_REQUEST['merchant_zip']))) ? trim($_REQUEST['merchant_zip']) : NULL;
	
	// print("your values: ".$first_name.' '.$last_name.' '.$merchant_address.' '.$merchant_city.' '.$merchant_state.' hashed password: '.password_hash($password,PASSWORD_DEFAULT).' '.$tax_id);

	$ins3rtThisIntoThatArray = array("merchant_name=".$first_name.' '.$last_name,
									 "merchant_pw=".$password,
									 "merchant_email=".$email,
									 "merchant_phone=".$phone_number,
									 "merchant_company=".$company_name,
									 "merchant_tax_id=".$tax_id,
									 "merchant_address=".$merchant_address,
									 "merchant_city=".$merchant_city,
									 "merchant_state=".$merchant_state,
									 "merchant_zip=".$merchant_zip
									 );
		
	$sql->insertArrayIntoDb('merchants',$ins3rtThisIntoThatArray);
	
	if(mysqli_affected_rows($dbCon) > 0){
	  header("Location: /".DOMAIN_NAME."/PHP/merchants/?newmerc=1");
	  exit();
	}else{
	  header("Location: /".DOMAIN_NAME."/PHP/merchants/?newmerc=0");
	  exit();
	}///END if
}else{
	//header("Location:/fixitquick/");
} 
 
	//////////LOGOUT PROCESS\\\\\\\\\\\\\\\\\\
	//////////LOGOUT PROCESS\\\\\\\\\\\\\\\\\\
	//////////LOGOUT PROCESS\\\\\\\\\\\\\\\\\\

?>
