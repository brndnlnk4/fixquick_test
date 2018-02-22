<?php 
$item_id = isset($_REQUEST['item_id']) ? trim($_REQUEST['item_id']) : NULL;require_once('../fn.php');
$merc_id = $fn->getItemFieldById($item_id,'merchant_id');

$product_name = trim($fn->getItemFieldById($item_id,'item_name'));
$product_type = trim($fn->getItemFieldById($item_id,'item_type'));
$product_category = trim($fn->getItemFieldById($item_id,'item_category'));

/******** CR8 RECENT_VIEWED_ITEMS COOKIE IF LOGGED IN **********/////
 
 //if logged in add this item to 'recently_viewed' cookie...
 if($fn->ifLoggedInReturnAsMember(true)){
	 if($fn->ifCookieIssetReturn('recently_viewed_items',true,false)){
		 $recent_items_array = unserialize($_COOKIE['recently_viewed_items']);	
		 (count($recent_items_array) >= 100) ? array_pop($recent_items_array) : '';
		 if(!in_array($item_id,$recent_items_array)){
			 $recent_items_array[] = $item_id;
			 }///END if
	
		///SERIALIZE RECENLTY VIEWED ITEMS
		$recent_items = serialize($recent_items_array);	
	}else{	
		$recent_items = serialize(array($item_id));	
	}///END ifelse	
	
		setcookie('recently_viewed_items',$recent_items,time() + 432000, '/'); //432000s = 5 days}///END if
 }///END if 

 
/******** UPD8 ITEM_VIEWS IN MERCHANT_STATS TBL **********/
	$chk_4_dup = $sql->numRowsV2('merchant_stats','item_id',$item_id);
	if($chk_4_dup > 0){
		$current_views = $sql->getFld('merchant_stats','item_id',$item_id,'item_views');
		$views_updated = intval($current_views) + 1;
		
		$sql->updateArrayIntoDb('merchant_stats',array(
													   "merc_id=$merc_id",
													   "item_id=$item_id",
													   "item_views=$views_updated"
													   ),
								'item_id',$item_id);
	}else{
		
		$sql->insertArrayIntoDb('merchant_stats',array(
													   "merc_id=$merc_id",
													   "item_id=$item_id",
													   "item_views=1"
													   )
								);
	}////END ifelse
	
	/********** IF VEHICLE TABS ISSET THEN CHECK FOR COMPATIBILITY ***********/	
	if($fn->ifLoggedInReturnAsMember(true) && trim($product_type) == 'part'){
		$mem_garage_items = $sql->getRows('mem_garage','mem_id',_ID_);
		$match_found = false;
		$compatible_cars = str_getcsv($fn->getItemFieldById($item_id,'item_vehicle'));
		$compatible_years = str_getcsv($fn->getItemFieldById($item_id,'item_vehicle_years'));
			
	  if(count($mem_garage_items) > 0){
		foreach($mem_garage_items AS $garage_item){
			$car = $garage_item['car_make'].' '.$garage_item['car_model'];
			$year = $garage_item['car_year'];
			
			if(in_array($car,$compatible_cars) && in_array($year,$compatible_years)){
				$match_found = true;
			?>
			<div class='row'>
				<div class='col-lg-2'></div>
				<div class='col-lg-8 col-xs-12' align='center'>
					<div class='panel panel-body well'>
						<b class='h1 text-primary' style='color:#777;'><i class='fa fa-check fa-lg text-success'></i> This part fits your Vechicle:</b> <strong class='lead text-success h1'> <?=$year.' '.ucwords($car)?></strong>
					</div>
				</div>
				<div class='col-lg-2'></div>
			</div>
			<?php
				break;
			}///END if
		}///END 4each
			if(!$match_found){
				echo "<div class='col-lg-2'></div><div class='col-lg-8'><div class='text-center well'><strong class='h1'><i class='fa fa-lg fa-close text-danger'></i> This part does not fit your car</strong></div></div><div class='col-lg-2'></div>";
			}///END if
	  }///END if
	}elseif(isset($_COOKIE['guest_car'])){
		///chk 4 guest cookie
	}///END ifelse
?>					
	
<input type='hidden' value="<?=$product_name?>" id="current_item_name" />	
<input type='hidden' value="<?=$product_type?>" id="current_item_type" />	
<input type='hidden' value="<?=$product_category?>" id="current_item_category" />	
	
<!--scripts.js line# 2137: pullProductsBySearchTerm()--->	
	
	<div id="single-product">    
		<div class="container">
		
			<?php require MC_ROOT.'/parts/section/single-product-gallery.php';?>   
			<?php require MC_ROOT.'/parts/section/single-product-detail.php';?> 
			
		</div><!-- /.container -->
	</div><!-- /.single-product -->
	
		<?php require MC_ROOT.'/parts/section/single-product-tab.php';?>
		<?php require MC_ROOT.'/parts/section/recently-viewed.php';?>