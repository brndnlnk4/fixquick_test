<div class="no-margin col-xs-12 col-sm-7 body-holder">
    <div class="body" pid="<?=$item_id?>">
	
		<div class="star-holder inline">
			<div class="star" data-score="4" style="cursor: pointer; width: 80px;">
			<?//JS POPULATES HERE//?>
			</div>
		</div>        
		<div class="availability"><label>Availability:</label>
			<span class="available"> 
			in stock
			</span>
		</div>

        <div class="title">
			<a href="#">
				<?=$fn->getItemNameById($item_id)?>
			</a>
		</div>
        <div class="brand">
			<?=trim($fn->getItemFieldById($item_id,'item_name'))?>
		</div>

        <div class="social-row">
            <span class="st_facebook_hcount"></span>
            <span class="st_twitter_hcount"></span>
            <span class="st_pinterest_hcount"></span>
        </div>

        <div class="buttons-holder">
<?php
if($fn->ifLoggedInReturnAsMember(true)){
	$num_rows = $sql->numRowsV2('mem_wishlist','mem_id',_ID_,array("item_id"=>$item_id));
	
	if($num_rows > 0){
		echo "<button class='btn-remove-from-wishlist btn btn-link remFromWishlist text-capitalize' type='button' ><i class='fa fa-lg fa-trash'></i> delete from wishlist</button>";
	}else{
		echo "<button class='btn-add-to-wishlist btn-link a2w text-capitalize' type='button' >add to wishlist</button>";
	}//END ifelse
}else{
	$hide_a2w_btn = NULL;
}////END ifelse
?>	
			
        </div>

		<!--ITEM DESCRIPTION-->
        <div class="excerpt">
            <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Vivamus ornare turpis non risus semper dapibus. Quisque eu vehicula turpis. Donec sodales lacinia eros, sit amet auctor tellus volutpat non.</p>
        </div>
        
        <div class="prices">
			<!--ITEM PRICE-->
            <div class="price-current">$<?=number_format($fn->getItemFieldById($item_id,'item_price'),2)?></div>
            
			<!--ITEM DISCOUNT-->
			<div class="price-prev">$2199.00</div>
        </div>

		<!--ITEM QUANTITY-->
        <div class="qnt-holder">	<!-- mq = maxQty 4 JS -->
            <div class="le-quantity" item-qty='1' mq='<?=trim(intval($fn->getItemFieldById($item_id,'item_qty'),0))?>'>
                <form>
                    <a class="minus" href="#reduce"></a>
						<input name="quantity" type="number" value="1" readonly />
                    <a class="plus" href="#add"></a>
                </form>
            </div>
			
		<!--ADD 2 CART BUTTON-->
            <button id="add-to-cart" type="button" pid='<?=$item_id?>' class="le-button huge">add to cart</button>
        
		</div><!-- /.qnt-holder -->
    </div><!-- /.body -->

</div><!-- /.body-holder -->