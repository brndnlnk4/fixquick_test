<?php include_once(dirname(__DIR__) . DIRECTORY_SEPARATOR . "fn.php"); ?>

    <div class="container">
        <!-- ========================================= CONTENT ========================================= -->
        <div class="col-xs-12 col-md-9 items-holder no-margin">
<?php
if($fn->ifLoggedInReturnAsMember(true)){
	$tbl_name = "shopping_cart_"._ID_;
	
	///calculate total price
	if(trim($sql->numRows($tbl_name,'checked_out','0')) > 0){
		$rows = $sql->getRows($tbl_name,'checked_out','0');		
		$added_prices = array();
		
		foreach($rows AS $row){
			$added_prices[$row['id']] = ($row['item_qty'] * $row['item_price']);
		}///END 4each
		$total_price = trim(number_format(array_sum($added_prices),2));
	}else{
		$total_price = NULL;
	}//END num_rws

	$shopping_cart_tbl_name = "shopping_cart_"._ID_;
	$items_in_cart = $sql->getRows($shopping_cart_tbl_name,'checked_out',0,'ORDER BY id DESC',false);
	
  if($sql->numRows($tbl_name,'checked_out','0')){	
	foreach($items_in_cart AS $item){
?>
            <div class="row no-margin cart-item" row-id='<?=$item['id']?>' item-id='<?=$item['item_id']?>' price='<?=$item['item_price']?>'>
                
				<!-- ITEM THUMBNAIL -->
				<div class="col-xs-12 col-sm-2 no-margin">
                    <a href="#" class="thumb-holder">
                        <img class="lazy" alt="" src="<?=$fn->getItemPic($item['item_id'],false,false)?>" />
                    </a>
                </div>
				
				<!-- ITEM NAME -->
                <div class="col-xs-12 col-sm-5 ">
                    <div class="title">
                        <a href="<?=$fn->echoItemPgUrlById($item['item_id'])?>"><?=$fn->getItemNameById($item['item_id'])?></a>
                    </div>
                    <div class="brand"><?=trim($fn->getItemFieldById($item['item_id'],'item_category'))?></div>
                </div> 
				
				<!-- ITEM QTY -->
                <div class="col-xs-12 col-sm-3 no-margin">
                    <div class="quantity cartItemQtyContainer">
                        <div class="le-quantity" item-qty='1' mq='<?=trim(intval($fn->getItemFieldById($item['item_id'],'item_qty'),0))?>'>
							<form>
								<a class="minus" href="#reduce"></a>
									<input name="quantity" type="number" value="<?=$item['item_qty']?>" readonly />
								<a class="plus" href="#add"></a>
							</form>
                        </div>
                    </div>	
                </div> 

				<!-- ITEM PRICE -->
                <div class="col-xs-12 col-sm-2 no-margin">
                    <div class="price">
                        <?=number_format($item['item_price'] * $item['item_qty'],2)?>
                    </div>
					
					<!-- REMOVE FROM CART BUTTON -->
                    <button type='button' class="close-btn btn btn-link"></button>
                </div>
				
            </div><!-- /.cart-item -->
<?php		
	}////END 4each
  }else{
	  echo "<span class='center-block panel lead text-muted text-center'>Cart Empty</span>";
  }////END ifelse
}else{
	// print(strtoupper('need to develope shopping cart for guest user'));
	
	//========================= CART ITEMS FOR GUEST ===============================//
	if(isset($_COOKIE['guest_cart_items'])){
		
		$items = explode(',',$_COOKIE['guest_cart_items']);
		$total_price = 0;
		foreach($items AS $item){
			$total_price = $total_price + $fn->getItemFieldById($item,'item_price');
		}//END 4each
		$total_price = trim(number_format($total_price,2));
		
		foreach($items AS $item_id){
			if(trim($item_id)){
?>
	   <div class="row no-margin cart-item" item-id='<?=$item_id?>' row-id='<?=$item_id?>' price='<?=$fn->getItemFieldById($item_id,'item_price')?>'>
			
			<!-- ITEM THUMBNAIL -->
			<div class="col-xs-12 col-sm-2 no-margin">
				<a href="#" class="thumb-holder">
					<img class="lazy" alt="" src="<?=$fn->getItemPic($item_id)?>" />
				</a>
			</div>
			
			<!-- ITEM NAME -->
			<div class="col-xs-12 col-sm-5 ">
				<div class="title">
					<a href="<?=$fn->echoItemPgUrlById($item_id)?>"><?=$fn->getItemNameById($item_id)?></a>
				</div>
				<div class="brand"><?=trim($fn->getItemFieldById($item_id,'item_category'))?></div>
			</div> 
			
			<!-- ITEM QTY -->
			<div class="col-xs-12 col-sm-3 no-margin">
				<div class="quantity cartItemQtyContainer">
					<div class="le-quantity" item-qty='1' mq='<?=trim(intval($fn->getItemFieldById($item_id,'item_qty'),0))?>'>
						<form>
								<input name="quantity" type="number" value="<?=$fn->getItemFieldById($item_id,'item_qty')?>" readonly disabled />
						</form>
					</div>
				</div>	
			</div> 

			<!-- ITEM PRICE -->
			<div class="col-xs-12 col-sm-2 no-margin">
				<div class="price">
					10.00
				</div>
				
				<!-- REMOVE FROM CART BUTTON -->
				<button type='button' class="close-btn btn btn-link"></button>
			</div>
			
		</div><!-- /.cart-item -->
<?php			
		  }///END if		
		}//END 4each
	}else{
		$total_price = NULL;
		echo "<span class='center-block panel lead text-muted text-center'>Cart Empty</span>";
	}///END ifelse
}////END ifLoggedInReturnAsMember()
?>
        </div>
        <!-- ========================================= CONTENT : END ========================================= -->

        <!-- ========================================= SIDEBAR ========================================= -->

        <div class="col-xs-12 col-md-3 no-margin sidebar ">
            <div class="widget cart-summary">
                <h1 class="border">shopping cart</h1>
                <div class="body" id='sideBarUlContainerSummary'>
                    <ul class="tabled-data no-border inverse-bold">
                        <li>
                            <label>cart subtotal</label>
                            <div class="value pull-right"><?=$total_price?></div>
                        </li>
                        <li>
                            <label>shipping</label>
                            <div class="value pull-right">free shipping</div>
                        </li>
                    </ul>
                    <ul id="total-price" class="tabled-data inverse-bold no-border">
                        <li>
                            <label>order total</label>
                            <div class="value pull-right"><?=$total_price?></div>
                        </li>
                    </ul>
                    <div class="buttons-holder">
                        <a class="le-button big" href="../PHP/?page=checkout" >checkout</a>
                        <a class="simple-link block" href="../PHP/?page=home" >continue shopping</a>
                    </div>
                </div>
            </div><!-- /.widget -->

            <div id="cupon-widget" class="widget">
                <h1 class="border">use coupon</h1>
                <div class="body">
                    <form>
                        <div class="inline-input">
                            <input data-placeholder="enter coupon code" type="text" />
                            <button class="le-button" type="submit">Apply</button>
                        </div>
                    </form>
                </div>
            </div><!-- /.widget -->
        </div><!-- /.sidebar -->

        <!-- ========================================= SIDEBAR : END ========================================= -->
    </div>