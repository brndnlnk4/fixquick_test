<?php
require_once(__DIR__ . DIRECTORY_SEPARATOR ."fn.php");
//////////////////////ajax process begins////////////////////

///ASSUMING ONCE ITEMS AUTOMATICALLY PAID FOR & PASSED INTO CUST_PURCHASE_HISTORY TBL
///ASSUMING ONCE ITEMS AUTOMATICALLY PAID FOR & PASSED INTO CUST_PURCHASE_HISTORY TBL
if(isset($_POST[md5('place_order')])){
	$orders = unserialize(base64_decode($_REQUEST[md5('orders')]));	
	$tbl_name = "shopping_cart_"._ID_;
	
	// die(print_r($orders));
	
	foreach($orders AS $order){
		$item_id = trim(intval($order['item_id']));
		$merchant_id = $fn->getFld('merchants','merchant_email',trim($order['item_seller']),'merchant_id');
		$item_name = $fn->getItemNameById($item_id);
		$mem_name = (defined('_USER_') && !is_null(_USER_)) ? _USER_ : trim($fn->getNameById(_ID_));   ///mem_name is actually mems email
		$total_price = number_format(trim($order['item_price']) * trim($order['item_qty']),2);
		$d8_checkout = date('Y-m-d');
		$d8_exp = $fn->dateAdd(0,0,10); ///10 day expiration
		
		///upd8 'checked_out' field in mems shopping cart to '2'
		$sql->insertArrayIntoDb('customer_purchase_history',
				array(
					"mem_id="._ID_,
					"merchant_id=$merchant_id",
					"item_id=$item_id",
					"item_name=$item_name",
					"unit_price={$order['item_price']}",
					"mem_name=$mem_name",   ///mem_name is actually mems email
					"total_price=$total_price",
					"item_qty={$order['item_qty']}",
					"item_part_num={$order['part_or_tire_num']}",
					"d8_checkout=$d8_checkout"
				  //"transaction_status=1" test when using braintree api
					)////END array
				); ///END insertArrayIntoDb()
				
		$customer_purchase_history_row_id = mysqli_insert_id($dbCon);
		
		///insert into merchant_purchase_history			
		$sql->insertArrayIntoDb('merchant_purchase_history',
					array(
						"buyer_id="._ID_,
						"merchant_id=$merchant_id",
						"item_id=$item_id",
						"item_name=$item_name",
						"total_price=$total_price",
						"item_qty={$order['item_qty']}",
						"item_part_num={$order['part_or_tire_num']}",
						"d8_checkout=$d8_checkout",
						"customer_purchase_history_row_id=$customer_purchase_history_row_id"
						)////END array
					); ///END insertArrayIntoDb()

		///insert into merchant_notifications
		$sql->insertArrayIntoDb('merchant_notifications',
					array(
						"mem_id="._ID_,
						"merchant_id=$merchant_id",
						"item_id=$item_id",
						"alert_type=sold", ///sold, review, return...
						"notification_details=$mem_name just bought your $item_name, this notification will expire in 10 days",
						"date_created=$d8_checkout",
						"date_expiration=$d8_exp"
						)////END array
					); ///END insertArrayIntoDb()
		
				if(mysqli_affected_rows($dbCon) > 0){
					$sql->delRow($tbl_name,$order['id']);
				}///END if
				
								
		///insert purchased 'item_id' into members table 'purchased_items' as csv
		$get_purchased_item_id_field = $sql->getFld('members','id',_ID_,'purchased_items');
		
		//if(!strstr(trim($get_purchased_item_id_field),$order['item_id'].':')){
			////csv: of items purchased: item_id, item_qty, unit item_price
			$new_item_details_to_add = $get_purchased_item_id_field . $item_id.":".$order['item_qty'].":".$order['item_price'].",";
			
			$sql->updateArrayIntoDb('members',array("purchased_items=$new_item_details_to_add"),'id',_ID_);
		
		
////////////////////////////////////////////////		
////////////upd8 item_qty in items_4_sale table
			$get_current_inv_item_qty = $fn->getItemFieldById($order['item_id'],'item_qty');
			
			if(trim($get_current_inv_item_qty) > 0){
				$new_item_qty = ((trim(intval($get_current_inv_item_qty)) - $order['item_qty']) > 0) ? trim(intval($get_current_inv_item_qty)) - $order['item_qty'] : 0 ;
				
				if($new_item_qty > 0){
					$updates_2_be_made = array(
						"item_qty=$new_item_qty"
					);///END array()
				}else{
					$updates_2_be_made = array(
						"item_qty=$new_item_qty",
						"item_sold=1"
					);///END array()
				}///END ifelse
				
				$sql->updateArrayIntoDb('items_4_sale',$updates_2_be_made,'id',$order['item_id']);
			
			}else{
				$fn->alertString(ucwords('shopping cart item (id): '.$order['id'].' is already out of stock'));
				///set item_qty to 0 and items_4_sale field 'item_sold' to 0
			}//END ifelse

			$fn->alertString(' !!!!failed to update member\'s \'purchased_items\' field ');
	}///END 4each
	
	if(mysqli_affected_rows($dbCon) > 0){
		
		header("Location: /fixquick.newTmpl8/PHP/?page=home&items_ordered=1");
		exit();		
	}else{
		
		$fn->alertString('could not update any rows...error with adding/updating to cart');
	}///END ifelse
}///END if
?>