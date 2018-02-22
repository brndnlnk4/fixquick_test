<?php
$path2fn = (file_exists((realpath('../'). DIRECTORY_SEPARATOR .'/PHP/fn.php'))) ? (realpath('../'). DIRECTORY_SEPARATOR .'/PHP/fn.php') : (dirname(__DIR__). DIRECTORY_SEPARATOR .'fn.php');

require_once($path2fn);

if(isset($_REQUEST['check4loginMatch'])){
 $login = mysqli_real_escape_string($dbCon,$_REQUEST['login']);
 $pw = mysqli_real_escape_string($dbCon,$_REQUEST['pw']);
 $login = trim($login);
 $pw = trim($pw);
 
 $rzlt = mysqli_query($dbCon,"SELECT * 
							FROM members 
							WHERE mem_username = '$login'
							AND mem_password = '$pw'");
	if(mysqli_num_rows($rzlt) > 0){
		echo 'ok';
	}else{
		echo "no";
	}////end if
}/////END if

////////////////////////////////////////////////////
if(isset($_REQUEST['add2wishList'])){
	if($fn->ifLoggedInReturnAsMember(true)){
		$item_id = trim(intval($_REQUEST['item_id']));
		$chk_num_rows = $sql->numRowsV2('mem_wishlist','mem_id',_ID_,array("item_id"=>$item_id));
		$merc_id = $fn->getItemFieldById($item_id,'merchant_id');
		
		if($chk_num_rows == 0){
			$sql->insertArrayIntoDb('mem_wishlist',array(
																																																"mem_id="._ID_,
																																																"item_id=$item_id",
																																																"merc_id=$merc_id",
																																																"d8_added=".date('Y-m-d')
																																																));
			
			exit((mysqli_affected_rows($dbCon) > 0) ? 'ok' : 'fail');
		}else{
			print('dup');	
		}///END if		
	}else{
		print('loggedout');
	}///END ifelse
}///END if

if(isset($_REQUEST['remFromWishlist']) && $fn->ifLoggedInReturnAsMember(true)){
		$item_id = trim(intval($_REQUEST['item_id']));
		$row_id = $sql->getRowsV2('mem_wishlist','mem_id',_ID_,array("item_id"=>$item_id))[0]['id'];
	
		$sql->delRow('mem_wishlist',$row_id);
		exit((mysqli_affected_rows($dbCon) > 0) ? 'ok' : 'fail');
}//END if

////////////////////////////////////////////////////
///check 4 email match during registration process
if(isset($_REQUEST['chk4emailMatch'])){		
	$chk4match = $sql->numRows('members','mem_email',$_REQUEST['chk4emailMatch']);
	if($chk4match > 0){
		print('dup');
	}else{
		print('ok');
	}///END ifelse
}///END if
////////////////////////////////////////////////////
///ITEM RATING PROCESS
if(isset($_REQUEST['r8_num']) && !empty($_REQUEST['r8_num'])){
	$rating = trim(intval($_REQUEST['r8_num']));
	$item_id = trim(intval($_REQUEST['item_id']));
	$usr = _USER_;
	///check for previous submited rating for this item_id
	$q = "SELECT item_rating 
		 FROM item_ratings
		 WHERE mem_username = '$usr'
		 AND item_id LIKE '$item_id'";
	$chk4PrevR8 = mysqli_query($dbCon,$q) or die(mysqli_error($dbCon));
	if(mysqli_num_rows($chk4PrevR8) > 0){
		$qr = "UPDATE item_ratings
			 SET item_rating = '$rating'
			 WHERE mem_username = '$usr'";
		mysqli_query($dbCon,$qr) or die(mysqli_error($dbCon).', coldnt upd8 rating');
		if(mysqli_affected_rows($dbCon) > 0){
			print('ok');
		}else{
			print('update failed, '.mysqli_error($dbCon));
		}////END if
	}else{
		$qry = "INSERT INTO item_ratings (
						item_rating,
						item_id,
						mem_username)
					VALUES (
						'$rating',
						'$item_id',
						'$usr')";
		mysqli_query($dbCon,$qry) or die(mysqli_error($dbCon).', coldnt insert item rating');
		if(mysqli_affected_rows($dbCon) > 0){
			print('ok');
		}else{
			print('insert failed');
		}////END if
	}///END if
}///END fn
////////////////////////////////////////////////////
////REFRESH SCART 'items-in-cart' count #
if(isset($_REQUEST['refreshScartCount']) && $fn->ifLoggedInReturnAsMember(true)){
	$scart_tbl = 'shopping_cart_'.strtolower(trim(_USER_));
	$chk4sCartTbl = mysqli_query($dbCon,"SHOW TABLES LIKE '$scart_tbl'");
	
	if(mysqli_num_rows($chk4sCartTbl) > 0){
		$rows = $fn->getRows($scart_tbl,'','');
		$count = count(array_values($rows));
		$data = array('check'=>'ok','count'=>$count);
			echo json_encode($data);
	}///END if
}///END if
////////////////////////////////////////////////////
////DELETE ITEM FROM SCART PROCESS
if(isset($_REQUEST['delFromCart']) && $fn->ifLoggedInReturnAsMember(true)){
	$scart_tbl = 'shopping_cart_'.strtolower(trim(_USER_));
	$chk4sCartTbl = mysqli_query($dbCon,"SHOW TABLES LIKE '$scart_tbl'");
	$id = trim(intval($_REQUEST['id']));
	$item_id = trim(intval($_REQUEST['item_id']));
	
	if(mysqli_num_rows($chk4sCartTbl) > 0){
		$q = "DELETE 
			FROM $scart_tbl
			WHERE id LIKE '$id'";	
		mysqli_query($dbCon,$q) or die(mysqli_error($dbCon).', delete item from cart issue');
		print('ok');
	}///END if
}////END if
///////////////////////////////////////////////////
if(isset($_REQUEST['upd8EditProfileInfo'])){
	/*mem_name,mem_phone,mem_zip,mem_address*/
	 $mem_info_array = array(
						'mem_name'=>"mem_name={$_REQUEST['mem_name']}",
						'mem_phone'=>"mem_phone={$_REQUEST['mem_phone']}",
						//'mem_zip'=>"mem_zip={$_REQUEST['mem_zip']}",
						'mem_address'=>"mem_address={$_REQUEST['mem_address']}"
						);
	  
		$sql->updateArrayIntoDb('members',$mem_info_array,'id',_ID_);
		print('ok');
}//END 
///////////////////////////////////////////////////
if(isset($_REQUEST['new_cc'])){
	$cc_owner = $_REQUEST['cc_owner'];
	$cc_num = str_ireplace('-','',trim($_REQUEST['cc_num']));
	$cc_csv = $_REQUEST['cc_csv'];
	$cc_type = $_REQUEST['cc_type'];
	$cc_exp = explode('-',$_REQUEST['cc_exp']);
	$cc_exp_month = trim($cc_exp[1]);
	$cc_exp_year = trim($cc_exp[0]);
	$id = _ID_;
		
	$c = "SELECT id 
			FROM cc 
			WHERE cc_owner = '$cc_owner' 
			AND cc_num LIKE '$cc_num' 
			AND cc_csv LIKE '$cc_csv' 
			AND cc_card_type = '$cc_type'";
	$chk = mysqli_query($dbCon,$c) or print(mysqli_error($dbCon));
	if(mysqli_num_rows($chk) == 0){
		$q = "INSERT INTO cc (
						mem_id,
						cc_owner,
						cc_num,
						cc_card_type,
						cc_csv,
						cc_exp_year,
						cc_exp_month)
					VALUES (
							'$id',
							'$cc_owner',
							'$cc_num',
							'$cc_type',
							'$cc_csv',
							'$cc_exp_year',
							'$cc_exp_month')";
		mysqli_query($dbCon,$q) or die(mysqli_error($dbCon));
		//print($cc_owner.'/'.$cc_num.'/'.$cc_csv.'/'.$cc_type.'/'.$cc_exp_month.'/'.$cc_exp_year);

		if(mysqli_affected_rows($dbCon) > 0){
			$id = _ID_;
			$last_id = mysqli_insert_id($dbCon);
			////SET ANY OLD DEFAULTS TO 0
			$s = "UPDATE cc
				 SET default_card = '0' 
				 WHERE mem_id LIKE '$id'";
			mysqli_query($dbCon,$s) or die(mysqli_error($dbCon));
			////UPDATE SELECTED CC 2 DEFAULT
			$q = "UPDATE cc
				 SET default_card = '1' 
				 WHERE id LIKE '$last_id'";
			mysqli_query($dbCon,$q) or die(mysqli_error($dbCon));
			if(mysqli_affected_rows($dbCon) > 0){
				print("ok");
			}///END if
		}///END if 		
	}else{
		print('dup');
	}///END if else
}///END new_cc
///////////////////////////////////////////////////
////SET SELECTED CC 2 DEFAULT CARD
if(isset($_REQUEST['default_cc'])){
	$id = _ID_;
	////SET ANY OLD DEFAULTS TO 0
	$s = "UPDATE cc
		 SET default_card = '0' 
		 WHERE mem_id LIKE '$id'";
	mysqli_query($dbCon,$s) or die(mysqli_error($dbCon));
	////UPDATE SELECTED CC 2 DEFAULT
	$q = "UPDATE cc
		 SET default_card = '1' 
		 WHERE id LIKE '{$_REQUEST['cc_id']}'";
	mysqli_query($dbCon,$q) or die(mysqli_error($dbCon));
	if(mysqli_affected_rows($dbCon) > 0){
		print("ok");
	}///END if
}///END if
///////////////////////////////////////////////////
////ADD ITEM TO GUEST SHOPPING CART
if(isset($_REQUEST['add2GuestOrMemCart'])){
	$item_id = $_REQUEST['item_id'];
				
	function add2memCart($item_id){
		global $dbCon,$sql,$fn;
		
		$shopping_cart_table = "shopping_cart_"._ID_;
		
		if($fn->checkIfTableExist($shopping_cart_table)){
			print(strtoupper($shopping_cart_table.' table exist  '));
		 }else{
			$table_sql = "CREATE TABLE `{$shopping_cart_table}` (
			 `id` int(11) NOT NULL AUTO_INCREMENT,
			 `item_qty` int(4) NOT NULL DEFAULT '1',
			 `item_id` int(4) NOT NULL,
			 `item_price` int(6) NOT NULL,
			 `item_seller` varchar(50) DEFAULT NULL,
			 `part_or_tire_num` varchar(23) NOT NULL,
			 `checked_out` int(11) NOT NULL DEFAULT '0' COMMENT 'items successfully checked out?',
			 `d8_exp` date NOT NULL,
			 PRIMARY KEY (`id`)
			) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1";
			
			mysqli_query($dbCon, $table_sql) or die('couldnt create shopping_cart_table: '.mysqli_error($dbCon));
			
			print(" table does not exist, making new one ");
		 }/////END if !shopping_cart_table
	
/////ADD ITEM 2 CART PROCESS	
 		$item_details = $sql->getRows('items_4_sale','id',$item_id)[0];
		$tbl_name = "shopping_cart_"._ID_;

		$unpaid_dup_item_in_sCart_chk = $sql->numRowsV2($tbl_name,'item_id',$item_id,array('checked_out'=>0));
		$pending_payment_dup_item_in_sCart_chk = $sql->numRowsV2($tbl_name,'item_id',$item_id,array('checked_out'=>1));
		$max_item_qty = trim(intval($item_details['item_qty']));
		$item_qty = (isset($_REQUEST['item_qty'])) ? trim(intval($_REQUEST['item_qty'])) : 1;

		if(trim(intval($unpaid_dup_item_in_sCart_chk)) < 1 
		&& trim(intval($pending_payment_dup_item_in_sCart_chk)) < 1){
		////IF !ITEM OR !DUP ITEM IN SCART
		
					$ins3rtThisIntoThatArray = array(
						"item_id={$item_details['id']}",
						"item_price={$item_details['item_price']}",
						"item_seller={$item_details['item_seller']}",
						"part_or_tire_num={$item_details['item_part_number']}",
						"item_qty=$item_qty"
					); ////END array()
					
			$sql->insertArrayIntoDb($tbl_name,$ins3rtThisIntoThatArray);
			
			exit((mysqli_affected_rows($dbCon) > 0) ? '  **inserting new row into db** ' : '  **failed to insert new item into db**  ');
		
		}elseif(trim(intval($pending_payment_dup_item_in_sCart_chk)) >= 1){
		////IF DUP PENDING_PAYMENT ITEM FOUND IN SCART
			
			exit(' !!!duplicate \'checked_out:1\' row found in sCart');
		
		}elseif(trim(intval($unpaid_dup_item_in_sCart_chk)) >= 1){
		////IF DUP UNPAID ITEM FOUND IN SCART
		
			$this_item_props = $sql->getRowsV2($tbl_name,'item_id',$item_id,array('checked_out'=>0))[0];
			$row_id = trim(intval($this_item_props['id']));
			$current_item_qty = trim(intval($this_item_props['item_qty']));
			$allowed_qty_4_upd8 = (($item_qty + $current_item_qty) < $max_item_qty) ? trim($item_qty + $current_item_qty) : trim($max_item_qty);
						
			$sql->updateArrayIntoDb($tbl_name,array("item_qty=$allowed_qty_4_upd8"),'id',$row_id);
			
			exit((mysqli_affected_rows($dbCon) > 0) ? '  **item_updated***  ' : ' !!!item not updated!!!  ');
		
		}////END ifelse
	}///END add2memCart()
				
	function add2GuestCart($item_id){
		// print("adding item_id {$item_id} to guest cart");
		if(!isset($_COOKIE['guest_cart_items'])){
			
			setcookie('guest_cart_items',$item_id.',',time() + 86400,'/');
			
		}else{
			
			$cookie = trim($_COOKIE['guest_cart_items']); //entire contents of cookie
			
			if(!strstr($cookie,$item_id.',')){
				
				setcookie('guest_cart_items',$cookie.trim($item_id).',',time() + 86400,'/');				
			
			echo "guest cookie: {$_COOKIE['guest_cart_items']}";
			}///END else
		}//END ifelse
	}///END fn
			
	($fn->ifLoggedInReturnAsMember(true)) ? add2memCart($item_id) : add2GuestCart($item_id);
	
	
}//END if

////REFRESH SHOPPING CART ITEMS////
if(isset($_REQUEST['pullCartItems'])){
	$items = array();
	
	if($fn->ifLoggedInReturnAsMember(true)){
		
		///pull cart items if logged in
		$tbl_name = "shopping_cart_"._ID_;
		
		if($fn->checkIfTableExist($tbl_name)){
			$sCart_num_rows = mysqli_num_rows(mysqli_query($dbCon,"SELECT * FROM $tbl_name WHERE checked_out LIKE 0"));
				
			if($sCart_num_rows > 0){
				$sCart_items = mysqli_query($dbCon,"SELECT * FROM $tbl_name WHERE checked_out LIKE 0");

				if(isset($_REQUEST['json_cart'])){
					foreach($sCart_items AS $item){
						$item_id = $item['item_id'];
						$items[] = array(
							"item_qty"=>$item['item_qty'],
							"max_qty"=>$fn->getItemFieldById($item_id,'item_qty'),
							"item_price"=>$item['item_price'],
							"item_id"=>$item_id,
							"item_seller"=>$item['item_seller'],
							"part_num"=>$item['part_or_tire_num'],
							"item_name"=>$fn->getItemNameById($item_id),
							"item_pic"=>$fn->getItemPic($item_id),
							"id"=>$item['id']
						);
					}///END 4each
					
					print(json_encode($items));					
				}else{
					///include sCart php page
				}///END ifelse
			
			}///END num_rows 
		}///END if table exist
	}else{
		///pull guest cart items from cookie
		if(isset($_COOKIE['guest_cart_items'])){
			$guest_cookie = (trim(substr($_COOKIE['guest_cart_items'],-1)) == ',') ? substr_replace(trim($_COOKIE['guest_cart_items']),'',-1) : $_COOKIE['guest_cart_items'];
			$guest_cookie = explode(',',$guest_cookie);
			
			foreach($guest_cookie AS $item_id){
				$items[] = array(
					'item_name'=>$fn->getItemNameById($item_id),
					'item_pic'=>$fn->getItemPic($item_id),
					'item_price'=>number_format($fn->getItemFieldById($item_id,'item_price'),2),
					'item_qty'=>$fn->getItemFieldById($item_id,'item_qty'),
					'item_category'=>$fn->getItemFieldById($item_id,'item_category'),
					'item_type'=>$fn->getItemFieldById($item_id,'item_type'),
					'item_id'=>$item_id
				);
			}//END 4each
			
			print(json_encode($items));
			
		}///END if
	}///END ifelse $_REQUEST['pullCartItems']
}///END if

///REMOVE SCART ITEM FROM SCART////
if(isset($_REQUEST['deleteScartitem'])){
		global $dbCon, $sql, $fn;

	$row_id_to_del = (isset($_REQUEST['row_id'])) ? trim($_REQUEST['row_id']) : NULL;
	$item_id = (isset($_REQUEST['item_id'])) ? trim($_REQUEST['item_id']) : NULL;

	function removeFromGuestScart($item_id){
		if(isset($_COOKIE['guest_cart_items'])){
				//$cookie_items = (trim(substr($_COOKIE['guest_cart_items'],-1) == ',')) ? substr_replace(trim($_COOKIE['guest_cart_items']),'',-1) : trim($_COOKIE['guest_cart_items']) ;
				//$cookie_items = explode(',',$cookie_items);
				
				$new_cookie = (strstr($_COOKIE['guest_cart_items'],$item_id.',')) ? str_replace($item_id.',','',$_COOKIE['guest_cart_items']) : $_COOKIE['guest_cart_items'];
				//$new_cookie = str_replace($item_id.',','',$_COOKIE['guest_cart_items']); //$item_id.',','',$_COOKIE['guest_cart_items']
				setcookie('guest_cart_items',$new_cookie,time() + 86400,'/');
					
				}///END if				
	}///END fn;
		
	function removeFromMemScart($row_id_to_del){
				global $dbCon, $sql, $fn;

		////REMOVE FROM REGULAR SCART 
		$tbl_name = "shopping_cart_"._ID_;

		$sql->delRow($tbl_name,trim(intval($row_id_to_del)));
				
		if(mysqli_affected_rows($dbCon) > 0){
			$num_rows = $sql->numRows($tbl_name,'checked_out',0);
			
			exit((trim($num_rows) == 0) ? 'cart_empty' : 'ok');
		}//END if
	}///END fn
	
	($fn->ifLoggedInReturnAsMember(true)) ? removeFromMemScart($row_id_to_del) : removeFromGuestScart($item_id) ;

}///END if

///UPDATE SCART ITEM QTY////
if(isset($_REQUEST['updShoppingCartItem'])){
	if($fn->ifLoggedInReturnAsMember(true)){
		$item_qty = trim(intval($_REQUEST['item_qty']));
		$row_id = trim(intval($_REQUEST['id']));
		$tbl_name = "shopping_cart_"._ID_;
		
		$upd8ThisIntoThatArray = array("item_qty=$item_qty");
		
		// print('upd8_item_php: '.$item_id.' qty: '.$item_qty.' row_id: '.$row_id);
		
		$sql->updateArrayIntoDb($tbl_name,$upd8ThisIntoThatArray,'id',$row_id);
		
		(mysqli_affected_rows($dbCon) > 0) ? print('ok') : print('fail');
	}////END if
}//END if
///GET TOTAL PRICE OF ITEMS IN SCART
if(isset($_REQUEST['getShoppingCartTotal'])){
	if($fn->ifLoggedInReturnAsMember(true)){
		$tbl_name = "shopping_cart_"._ID_;
		
		if(trim(mysqli_num_rows(mysqli_query($dbCon,"SELECT * FROM $tbl_name WHERE checked_out LIKE 0"))) > 0){
			$rows = mysqli_query($dbCon,"SELECT * FROM $tbl_name WHERE checked_out LIKE 0");		
			$added_prices = array();
			
			foreach($rows AS $row){
				if(trim($row['item_price'])){
					array_push($added_prices,($row['item_qty'] * $row['item_price']));					
				}///END if
			}///END 4each
			
			print(trim(number_format(array_sum($added_prices),2)));
			
		}else{
			
			print(number_format(0,2));
			
		}//END num_rws
	}elseif(isset($_COOKIE['guest_cart_items'])){
		if(strlen(trim($_COOKIE['guest_cart_items'])) > 1){
			$C = explode(',',trim($_COOKIE['guest_cart_items']));
			$total_price = [];
			
			foreach($C AS $item_id){
				if(trim($item_id)){
					$price = $fn->getItemFieldById($item_id,'item_price');
					
					array_push($total_price,trim(intval($price)));
				}///END if
			}////END 4each
			
			echo trim(number_format(array_sum($total_price),2));
		}else{
			///DELETE GUEST SCART COOKIE IF STRLEN < 1
			setcookie('guest_cart_items','',date()-30000,'/');
			print('0.00');
		}//END ifelse
	}else{
		///IF GUST CART ITEMS COOKIE NOT SET	
		print('0.00');	
	}////END if
}///END if
////////////////////////////////////////////////////
/*================= myFixQuick Shit ================*/
if(isset($_REQUEST['addNewCar2Gar'])){
	$car_make = trim(strtolower($_REQUEST['carMake']));
	$car_model = trim(strtolower($_REQUEST['carModel']));
	$car_year = trim(strtolower($_REQUEST['carYear']));
	$car_trim = !is_null(trim($_REQUEST['carTrim'])) ? trim(strtolower($_REQUEST['carTrim'])) : NULL;
	$mem_id = _ID_;
	$mem_name = _USER_;
	
	$chk4dupRows = $sql->numRows('mem_garage','car_year',$car_year,false,"car_model=$car_model","car_make=$car_make");
	// print($car_make.'-'.$car_model.'-'.$car_year.' dup rows = '.$chk4dupRows);
	
	if(trim($chk4dupRows) == 0){
		$ins3rtThisIntoThatArray = array(
			"mem_id=$mem_id",
			"mem_name=$mem_name",
			"item_type=car",
			"car_make=$car_make",
			"car_model=$car_model",
			"car_year=$car_year",
			"car_trim=$car_trim"
		);
		$sql->insertArrayIntoDb('mem_garage',$ins3rtThisIntoThatArray);
		
		if(mysqli_affected_rows($dbCon) > 0){
			print('ok');
		}//END if	
	}else{
		//duplicat rows found
		print('dup');
	}///END ifelse adding_new/updating carInGarage
}///END if
////////////////////////////////////////////////////
if(isset($_REQUEST['upd8CarInGar'])){
	$car_model = trim(strtolower($_REQUEST['carModel']));
	$car_year = trim(strtolower($_REQUEST['carYear']));
	$car_trim = !is_null(trim($_REQUEST['carTrim'])) ? trim(strtolower($_REQUEST['carTrim'])) : NULL;
	$row_id = $_REQUEST['rowId'];
	
	$upd8ThisIntoThatArray = array(
								"car_model=$car_model",
								"car_year=$car_year",
								"car_trim=$car_trim"
								);
	$sql->updateArrayIntoDb('mem_garage',$upd8ThisIntoThatArray,'id',$row_id);
	
	(mysqli_affected_rows($dbCon) > 0) ? print('ok') : print('fail');
	
}///END upd8CarInGar
////////////////////////////////////////////////////
if(isset($_REQUEST['upd8TireInGar'])){
	$tire_width = $_REQUEST['tireWidth'];
	$tire_ratio = $_REQUEST['tireRatio'];
	$tire_diameter = $_REQUEST['tireDiameter'];
	$row_id = $_REQUEST['rowId'];
	
	// print($tire_width.' '.$tire_ratio.' '.$tire_diameter.' '.$row_id);
	$upd8ThisIntoThatArray = array(
								"tire_width=$tire_width",
								"tire_ratio=$tire_ratio",
								"tire_diameter=$tire_diameter"
								);
	$sql->updateArrayIntoDb('mem_garage',$upd8ThisIntoThatArray,'id',$row_id);
	
	(mysqli_affected_rows($dbCon) > 0) ? print('ok') : print('fail');
	
}///END upd8CarInGar
////////////////////////////////////////////////////
if(isset($_REQUEST['removeCarFromMemGarage'])){
	$sql->delRow('mem_garage',trim(intval($_REQUEST['id2rem'])));
}///END if
////////////////////////////////////////////////////
if(isset($_REQUEST['addTire2MemGarage'])){
	$tire_width = $_REQUEST['tireWidth'];
	$tire_ratio = $_REQUEST['tireRatio'];
	$tire_diameter = $_REQUEST['tireDiameter'];
	$mem_id = _ID_;
	$mem_name = _USER_;
	$chk4DupRows = $sql->numRows('mem_garage','mem_id',$mem_id,false,"tire_width=$tire_width","tire_ratio=$tire_ratio","tire_diameter=$tire_diameter");
			
	if(trim($chk4DupRows) == 0){
		$ins3rtThisIntoThatArray = array(
			"tire_width=$tire_width",
			"tire_ratio=$tire_ratio",
			"tire_diameter=$tire_diameter",
			"mem_id=$mem_id",
			"mem_name=$mem_name",
			"item_type=tire"
		);
		$sql->insertArrayIntoDb('mem_garage',$ins3rtThisIntoThatArray);
		
		if(mysqli_affected_rows($dbCon) > 0){
			print('ok');
		}else{
			(mysqli_error($dbCon)) ? print(mysqli_error('prob with adding tire 2 gar: '.$dbCon)) : '';
		}//END if
	}else{
		print('dup');
	}///END if
}////END if
////////////////////////////////////////////////////
if(isset($_REQUEST['removeTireFromMemGarage'])){
	$sql->delRow('mem_garage',trim(intval($_REQUEST['id2rem'])));
}///END if
////////////////////////////////////////////////////
////////////////////////////////////////////////////
if(isset($_REQUEST['remItemFromCookie']) && $_REQUEST['remItemFromCookie'] == true){
	$cur_ids = $_COOKIE['guest_cart'];
	$item_id = trim($_REQUEST['item_id']).',';
	$new_ids = str_ireplace($item_id,'',$cur_ids);
	
	///override guest shopping cart cookie
	setcookie('guest_cart',$new_ids,time() + 3000,'/');
}///END if
///////////////////////////////////////////////////
if(isset($_REQUEST['review_vote'])){
	$vote = $_REQUEST['review_vote'];
	$item_id = $_REQUEST['item_id'];
	$review_id = $_REQUEST['review_id'];
	
	switch($vote){
		case 'up': $vote_2_set = 'vote_up = vote_up + 1';
			break;
		case 'down': $vote_2_set = 'vote_down = vote_down + 1';
			break;
	}
	mysqli_query($dbCon,"UPDATE item_reviews SET $vote_2_set WHERE id LIKE '$review_id'") or die(mysqli_error($dbCon).' error with review_vote');
/*
	if(mysqli_affected_rows($dbCon) != 0){
		print('ok');
	}///END if
*/
	(!isset($_SESSION['item_review_vote_tracker'])) ? $_SESSION['item_review_vote_tracker'][] = $review_id : '';
	(!in_array($review_id,$_SESSION['item_review_vote_tracker'])) ? array_push($_SESSION['item_review_vote_tracker'],$review_id) : '';
	print('ok');
}///END if
///////////////////////////////////////////////////
//////PROFILE PICTURE UPLOAD PROCESS
if(isset($_FILES['profile_pic']) && !empty($_FILES['profile_pic'])){
	$pic_name = $_FILES['profile_pic']['name'];
	$pic_tmp = $_FILES['profile_pic']['tmp_name'];
	$pic_size = $_FILES['profile_pic']['size'];
	$pic_type = $_FILES['profile_pic']['type'];
	
	$file_ext = explode('.', $pic_name);
	$file_ext = end($file_ext);	
	$file_ext = strtolower($file_ext);
								
	$allowed_ext =  array( 'jpg', 'jpeg', 'png', 'bmp', 'gif');
															
	if(in_array($file_ext, $allowed_ext)){ 		   	
													
	   $file_name_new = uniqid('', false) . '.' . $file_ext;
															
	   $file_destination = $_SERVER['DOCUMENT_ROOT']."/fixitquick/upl/prof_pics/".$file_name_new; /////incudes new_file _name @ end of path		 
																
		if(move_uploaded_file($pic_tmp, $file_destination)){
								
		$q = "UPDATE members
			 SET mem_avatar = '$file_name_new' 
			 WHERE id LIKE '"._ID_."'";
		$rz = mysqli_query($dbCon,$q) or die($fn->alertString('prof pic upl prob..'.mysqli_error($dbCon)));	  
									
			if(mysqli_affected_rows($dbCon) > 0){
				header("Location: /fixitquick/?".md5('profPicUploaded')."=1");
				exit();
			}else{
				header("Location: /fixitquick/?".md5('profPicUploaded')."=0");
				exit();
			}///END if
		}// END OF IF_MOVE_UPL_FILE	
	}else{
		$fn->popUpMsg("You must select Picture in jpg, png, bmp, gif format.");
	}///END ifelse
}///END if isset(FILE)
////////////////////////////////////
///UPD8 PROFILE EMAIL, NAME & ADDY
if(isset($_REQUEST['upd8Prof'])){
	$q = "UPDATE members
		 SET mem_username = '"._USER_."'";
  if(isset($_REQUEST['profile_name']) && !empty(trim($_REQUEST['profile_name']))){
	$q .= ", mem_name = '{$_REQUEST['profile_name']}' ";
  }/////END if
  if(isset($_REQUEST['profile_pw']) && !empty(trim($_REQUEST['profile_pw']))){
	$q .= ", mem_password = '{$_REQUEST['profile_pw']}' ";
  }/////END if
  if(isset($_REQUEST['profile_address']) && !empty(trim($_REQUEST['profile_address']))){
	$q .= ", mem_address = '{$_REQUEST['profile_address']}' ";
			
	/////get location via google api & upload to addy_table in db
 	$maps_url = 'https://maps.googleapis.com/maps/api/geocode/json?address='.urlencode(trim($_REQUEST['profile_address'])); //&latlng=40,40&sensor=false;	
	$map_json = @file_get_contents($maps_url);
						
	if(trim($map_json)){
		//decode with jsonDecode() into array	
		$map_array = json_decode($map_json,true); 
		
		//store address in array
		$map_address[] = $map_array['results'][0]['formatted_address'];		
			
		//loop through address
		foreach($map_address AS $address){
		  $addresses = str_getcsv($address); ///array
		  $street = trim(strtolower($addresses[0]));
		  $city = trim(strtolower($addresses[1]));
		  $state = trim(explode(' ',trim($addresses[2]))[0]);
		  (strstr(trim($addresses[2]),' ')) ? $zip = trim(explode(' ',trim($addresses[2]))[1]) : $zip = trim($addresses[2]);
			////upload to address_table in db
			$chk4dupAddy = $fn->getRows('mem_address','mem_id',_ID_);
			$duplicateAddy = false;
			
			if($chk4dupAddy){
				foreach($chk4dupAddy AS $addy){
					if(trim(strtolower($addy['mem_street'])) == $street
					&& trim(strtolower($addy['mem_city'])) == $city){
						$duplicateAddy = true;
						break;
					}//END if
				}///END 4each 
			}///END if
			if($duplicateAddy == false){
				$sql = "INSERT INTO mem_address (
									mem_id,
									mem_name,
									mem_street,
									mem_zip,
									mem_city,
									mem_state)
							VALUES (
								'"._ID_."',
								'"._USER_."',
								'$street',
								'$zip',
								'$city',
								'$state')";
				mysqli_query($dbCon,$sql) or die('Error with dam addy upd8 '.mysqli_error($dbCon));
			}///END if
		}//////////END foreach			
	 }///END if
   }/////END if
  if(isset($_REQUEST['profile_phone']) && !empty(trim($_REQUEST['profile_phone']))){
	(strstr($_REQUEST['profile_phone'],'-')) ? str_replace('-','',$_REQUEST['profile_phone']) : $_REQUEST['profile_phone'] = intval($_REQUEST['profile_phone']);
	$q .= ", mem_phone = '{$_REQUEST['profile_phone']}' ";
  }/////END if
	$q .= " WHERE id LIKE '"._ID_."'";
				
	mysqli_query($dbCon,$q) or die(mysqli_error($dbCon).' error with updating profile');
	
	if(mysqli_affected_rows($dbCon) > 0){
		//$fn->popUpMsg('Profile Successfully Updated');
		print('ok');
	}else{
		print('fail '.mysqli_error($dbCon));
	}///END if
}///END if
///////////////////////////////////////////////////
///////////////////////////////////////////////////
///PULL LOCATION DETAILS
if(isset($_REQUEST['mem_address_details'])){
	echo $fn->getLocationDetails($_REQUEST['mem_address_details'],trim($_REQUEST['mem_address_field']));
}///END if
///////////////////////////////////////////////////
?>