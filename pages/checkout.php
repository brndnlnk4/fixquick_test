<!-- ========================================= CONTENT ========================================= -->
<?php
	(!defined(_ID_)) ? "<script>window.open('../?logout','_self');</script>": '';

	$mem_name = $sql->getFld('members','id',_ID_,'mem_name');
	$first_name = (strstr(trim($mem_name),' ')) ? explode(' ',$mem_name)[0] : $mem_name;
	$last_name = (strstr($mem_name,' ') && trim(explode(' ',$mem_name)[0])) ? explode(' ',$mem_name)[1] : NULL;
	
	$tbl_name = "shopping_cart_"._ID_;
	// $sCart_items = mysqli_query($dbCon,"SELECT * FROM $tbl_name WHERE checked_out LIKE 0 ORDER BY id DESC");
	$sCart_items = $sql->getRows($tbl_name,'checked_out','0','ORDER BY id DESC');
	$item_total = [];
	
	foreach($sCart_items AS $item){
		$item_qty = intval($item['item_qty']);
		$item_price = $item['item_price'];
		
		$item_total_prices = trim($item_qty) * trim($item_price);
		
		array_push($item_total,$item_total_prices);
	}///END 4each
	
	$checkout_total = array_sum($item_total);
?>

<section id="checkout-page" >
    <div class="container" >
		
        <div class="col-xs-12 no-margin" >
			<section id="payment_information">

				<div class="col-lg-3"></div>
				<div class="col-lg-6 col-xs-12" id="checkoutPaymentDetails">
				 <h2 class="border h1 text-left inner-xs">Payment details</h2>
<style>
	#dropin-container button{
		width:100%;
		display: block;
	}
</style>
					<form action="../PHP/pages/payment.php" method="post">
						<div class="panel panel-default" align="center">
							<label for="firstName" class="bold pull-left">First name</label>
								<input type="name" value="<?=$first_name?>" class="form-control" name="firstName" />
							<label for="lastName" class="bold pull-left">Last name</label>
								<input type="name" value="<?=$last_name?>" class="form-control" name="lastName" />
							<label for="amount" class="bold pull-left">Amount (USD)</label>
								<input type="number" class="form-control" value="<?=number_format($checkout_total,2)?>" name="amount" readonly disbabled />
			
							<div class="center-block text-center" align="center">
								<div id="dropin-container" class="inner-xs" align='center'></div>	

								<div class="center-block inner-bottom-xs" align="center">
									<button type="submit" class="le-button btn" id="buy_btn" >Purchase</button>
								</div>
							</div>
						</div><!--/END panel-->
					</form>
					
				</div><!--/END .col-lg-6-->
				
				<!-- #dropin-container -->
				<div class="col-lg-3"></div>
				
			</section>
		</div>
        <div class="col-xs-12 no-margin" >

            <section id="shipping-address" >
                <h2 class="border h1">shipping address</h2>
				
                <form>
                    <div class="row field-row" >
                        <div class="col-xs-12" >
							<ul class="list-group" >
						<?php
							$mem_addres_rows = $sql->getRows('mem_address','mem_id',_ID_);
							$default_mem_address = '';
							
							if(($mem_addres_rows) && count($mem_addres_rows) > 0){
								foreach($mem_addres_rows AS $mem_details){
									$row_id = $mem_details['id'];
									$default_addy = $mem_details['default_address'];
									$mem_id = $mem_details['mem_id'];
									$mem_name = ucwords(trim($mem_details['mem_name']));
									$mem_address = trim(ucwords($mem_details['mem_street']).' '.ucwords($mem_details['mem_city']).' '.strtoupper($mem_details['mem_state']).' '.intval($mem_details['mem_zip']));
								
									$default_mem_address = ($default_addy == '1') ? $mem_address : '';
								?>
									<li <?=($default_addy == '1') ? "class='list-group-item list-group-item-success'" : "class='list-group-item'" ?> >
										<input type="radio" name="shipping_address" class="le-radio" value="<?=$mem_address?>" <?=($default_addy == '1') ? "checked" : '' ?>><strong><?=$mem_address?></strong></input>
									</li>
								<?php
								}////END 4each
							}///END if
						?>
							</ul>
						
                            <!--<input  class="le-checkbox big" type="checkbox"  />-->
                            <button type="button" class="simple-link bold btn-link" data-toggle="collapse" data-target=".billing-address" >ship to different address?</button>
                        </div>
                    </div><!-- /.field-row -->
                </form>
            </section><!-- /#shipping-address -->

<!--ADD NEW SHIPPING ADDRESS-->
            <div class="billing-address collapse">
				<sup class="text-muted pull-right">(*) Must be filled out</sup>
                <h2 class="border h1">new shipping address </h2>
                <form id="addNewMemAddressForm" action="post" method="<?=htmlspecialchars($_SERVER['PHP_SELF'])?>">
                    <div class="row field-row">
                        <div class="col-xs-12 col-sm-6">
                            <label>full name* <sup class="text-muted">Name on shipping label</sup></label>
                            <input class="le-input form-control" minlength="3" maxlength="50" type="name" required />
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <label>last name* <sup class="text-muted" >Name on shipping label</sup></label>
                            <input class="le-input form-control" minlength="3" maxlength="50" type="name" required />
                        </div>
                    </div><!-- /.field-row -->

                    <div class="row field-row">
                        <div class="col-xs-12 col-sm-6">
                            <label>address*</label>
                            <input class="le-input form-control" type="address" minlength="3" data-placeholder="street address" placeholder="street address" required />
                        </div>
                        <div class="col-xs-12 col-sm-6">
                            <label>city</label>
                            <input class="le-input form-control" type="name" minlength="3" data-placeholder="town or city" placeholder="town" />
                        </div>
                    </div><!-- /.field-row -->

                    <div class="row field-row">
                        <div class="col-xs-12 col-sm-6">
                            <label>postcode / Zip*</label>
                            <input class="le-input form-control" type="number" minlength="5" maxlength="5" data-placeholder="54321" required />
                        </div>

                        <div class="col-xs-12 col-sm-6">
                            <label>phone number*</label>
                            <input class="le-input" required />
                        </div>
                    </div><!-- /.field-row -->

                    <div class="row field-row">
                        <div id="create-account" class="col-xs-12">
							<button type="submit" class="le-button huge" id="addNewAddressBtn" >add address</button>
						</div>
                    </div><!-- /.field-row -->

                </form>
            </div><!-- /.billing-address -->
			
			
<!--SHOPPING CART ITEMS 2 ORDER-->			
            <section id="your-order">
                <h2 class="border h1">your orders</h2>
                <form>
					<div class="col-lg-8 col-xs-8">
<!--REMEMBER: no ajax use in checkout process-->		
<?php
	$tbl_name = "shopping_cart_"._ID_;
	// $sCart_items = mysqli_query($dbCon,"SELECT * FROM $tbl_name WHERE checked_out LIKE 0 ORDER BY id DESC");
	$sCart_items = $sql->getRows($tbl_name,'checked_out','0','ORDER BY id DESC');
	$sCart_prices = [];
	
	foreach($sCart_items AS $item){
		$item_qty = intval($item['item_qty']);
		$item_price = $item['item_price'];
		
		array_push($sCart_prices,$item_price * $item_qty);
	?>
						<div class="row no-margin order-item">
							<div class="col-xs-12 col-sm-1 no-margin bold">
 								<?=intval($item['item_qty'])?>x
							</div>

							<div class="col-xs-12 col-sm-9 inner-left-xs">
								<div class="title"><a href="<?=$fn->getItemPgUrlById($item['item_id'])?>" target="_blank"><?=$fn->getItemNameById($item['item_id'])?> </a></div>
								<div class="brand"><?=str_replace('_',' ',$fn->getItemFieldById($item['item_id'],'item_category'))?></div>
							</div>

							<div class="col-xs-12 col-sm-2 no-margin">
								<div class="price">$<?=number_format($item_qty * $item_price,2)?></div>
							</div>
						</div><!-- /.order-item -->
	<?php
	}///END 4each
?>					

					</div>
                </form>
            </section><!-- /#your-order -->
		
            <div id="total-area" class="row no-margin">
                <div class="col-xs-12 col-lg-4 no-margin-right outer-top-xs panel panel-success">
                    <div id="<?//subtotal-holder?>" class="outer-top-xs">
                        <ul class="tabled-data inverse-bold no-border">
                            <li>
                                <label>cart subtotal</label>
                                <div class="value lead">$<?=number_format(array_sum($sCart_prices),2)?></div>
                            </li>
                            <li id="shipping_type_container">
                                <label>shipping</label>
                                <div class="value">
                                    <div class="radio-group">
                                        <input class="le-radio" type="radio" name="shipping_type" value="free" checked> <div class="radio-label bold">free shipping</div><br>
                                      <!-- <input class="le-radio" type="radio" name="shipping_type" value="local" >  <div class="radio-label">2-Day shipping<br><span class="bold">$15</span></div>-->
                                    </div>
                                </div>
                            </li>
                        </ul><!-- /.tabled-data -->

                        <ul id="total-field" class="tabled-data inverse-bold ">
                            <li>
                                <label>order total</label>
                                <div class="value">$<?=number_format(array_sum($sCart_prices),2)?></div>
                            </li>
                        </ul><!-- /.tabled-data -->

                    </div><!-- /#subtotal-holder -->
                </div><!-- /.col -->
            </div><!-- /#total-area -->


            <div id="payment-method-options" class="hide">
                <form>
                    <div class="payment-method-option">
                        <input class="le-radio" type="radio" name="group2" value="Direct">
                        <div class="radio-label bold ">Direct Bank Transfer<br>
                            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Fusce rutrum tempus elit, vestibulum vestibulum erat ornare id.</p>
                        </div>
                    </div><!-- /.payment-method-option -->
                    
                    <div class="payment-method-option">
                        <input class="le-radio" type="radio" name="group2" value="cheque">
                        <div class="radio-label bold ">cheque payment</div>
                    </div><!-- /.payment-method-option -->
                    
                    <div class="payment-method-option">
                        <input class="le-radio" type="radio" name="group2" value="paypal">
                        <div class="radio-label bold ">paypal system</div>
                    </div><!-- /.payment-method-option -->
                </form>
            </div><!-- /#payment-mitemsListethod-options -->
	
            <div class="place-order-button">
				<form method="post" action="../PHP/sCart_ajax_process.php">
					<input type="hidden" name="address_selected" value="<?=$default_mem_address?>" />
					<input type="hidden" name="shipping_selected" value="" />
					<input type="hidden" name="<?=md5('orders')?>" value="<?=base64_encode(serialize($sql->getRows($tbl_name,'checked_out','0')))?>" />
					<button type="submit" name="<?=md5('place_order')?>" class="le-button big">place order</button>
				</form>
            </div><!-- /.place-order-button -->

        </div><!-- /.col -->
    </div><!-- /.container -->    
</section><!-- /#checkout-page -->
<script>
document.body.onload = function(){
	$("#addNewMemAddressForm").validate();
	
	$(function(){
	    var selectShippingAddressContainer = $("#shipping-address"),
			shippingAddressRadioInputs = selectShippingAddressContainer.find("input[name='shipping_address']"),
			shippingTypeContainer = $("#shipping_type_container"),
			shippingTypeInputs = shippingTypeContainer.find("input[type='radio']"),
			addressInput = $("input[name='address_selected']"),
			shippingInput = $("input[name='shipping_selected']");
		
		shippingAddressRadioInputs.change(function(){
			($(this).prop('checked')) ? addressInput.val($.trim($(this).val())) : '';
		})///END change
		shippingTypeInputs.change(function(){
			console.log($(this).val());
		})////END change
	})////END $fn
}
</script>
<!-- ========================================= CONTENT : END ========================================= -->