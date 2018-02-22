<div id="products-tab" class="wow fadeInUp">

	<div class="container">
        <div class="tab-holder">
            <!-- Nav tabs -->
            <ul class="nav nav-tabs" >
                <li class="active"><a href="#featured" data-toggle="tab">deals</a></li>
                <li><a href="#new-arrivals" data-toggle="tab">new arrivals</a></li>
                <li><a href="#top-sales" data-toggle="tab">top sales</a></li>
            </ul>
<?php 
$item_rows = $fn->getRows('items_4_sale','item_type','part','ORDER BY item_price ASC');
$item = array_chunk($item_rows,4);
?>   
            <!-- Tab panes -->
            <div class="tab-content">
                <div class="tab-pane active" id="featured">
                    <div class="product-grid-holder">
<?php	
	foreach($item[0] AS $items){
		$item_id = $items['id'];
?>
	<div class="col-sm-4 col-md-3  no-margin product-item-holder hover">
		<div class="product-item" pid='<?=$item_id?>'>
			<div class="ribbon red"><span>15% off</span></div> 
			<div class="image">
				<img alt="" src="assets/images/blank.gif" data-echo="<?=$fn->getItemPic($item_id)?>" />
			</div>
			<div class="body">
				<div class="title">
					<a href="#" class='item_name' type='button'>
						<?=$fn->getItemNameById($item_id)?>
					</a>
				</div>
				<div class="brand">
					<?=ucwords($fn->getItemFieldById($item_id,'item_name'))?>
				</div>
			</div>
			<div class="prices">
				<div class="price-prev">$<?=number_format($items['item_price'] + 5,2)?></div>
				<div class="price-current puright">$<?=number_format($items['item_price'],2)?></div>
			</div>

			<div class="hover-area">
				<div class="add-cart-button">
					<a href="#" type='button' class="le-button a2c">add to cart</a>
				</div>
				<div class="wish-compare">
					<a class="btn-add-to-wishlist" href="#">add to wishlist</a>
					<a class="btn-add-to-compare" href="#">compare</a>
				</div>
			</div>
		</div>
	</div>
<?php
	}///END 4each
?>					

                    
					</div>
                    <div class="loadmore-holder text-center">
                        <a class="btn-loadmore" href="#">
                            <i class="fa fa-plus"></i>
                            load more products
						</a>
                    </div> 
                </div>
				
<!-------------------------------
		new-arrivals
------------------------------->
                <div class="tab-pane" id="new-arrivals">
                    <div class="product-grid-holder">
<?php
	foreach($item[1] AS $items_2){
		$item_id = $items_2['id'];
?>                       
	<div class="col-sm-4 col-md-3 no-margin product-item-holder hover">
		<div class="product-item" pid='<?=$item_id?>'>
			<div class="ribbon blue"><span>new!</span></div> 
			<div class="image">
				<img alt="" src="assets/images/blank.gif" data-echo="<?=$fn->getItemPic($item_id)?>" />
			</div>
			<div class="body">
				<div class="label-discount clear"></div>
				<div class="title">
			 		<a href="index.php?page=single-product">
						<?=$fn->getItemNameById($item_id)?>
					</a>
				</div>
				<div class="brand">
					<?=ucwords($fn->getItemFieldById($item_id,'item_name'))?>
				</div>
			</div>
			<div class="prices">
				<div class="price-prev">$<?=number_format($items['item_price'] + 5,2)?></div>
				<div class="price-current pull-right">$<?=number_format($items_2['item_price'],2)?></div>
			</div>
			<div class="hover-area">
				<div class="add-cart-button">
					<a href="#" class="le-button a2c">add to cart</a>
				</div>
				<div class="wish-compare">
					<a class="btn-add-to-wishlist" href="#">add to wishlist</a>
					<a class="btn-add-to-compare" href="#">compare</a>
				</div>
			</div>
		</div>
	</div>
 <?php
	}///END 4each
?>
                    </div>
                    <div class="loadmore-holder text-center">
                        <a class="btn-loadmore" href="#">
                            <i class="fa fa-plus"></i>
                            load more products</a>
                    </div> 

                </div>
				
<!-------------------------------
		top-sales
------------------------------->
                <div class="tab-pane" id="top-sales">
                    <div class="product-grid-holder">
<?php	
	foreach($item[2] AS $items_3){
		$item_id = $items_3['id'];
?>
	<div class="col-sm-4 col-md-3 no-margin product-item-holder hover">
		<div class="product-item" pid='<?=$item_id?>'>
			<div class="ribbon red"><span>sale</span></div> 
			<div class="ribbon green"><span>bestseller</span></div> 
			<div class="image">
				<img alt="" src="assets/images/blank.gif" data-echo="<?=$fn->getItemPic($item_id)?>" />
			</div>
			<div class="body">
				<div class="label-discount clear"></div>
				<div class="title">
					<a href="index.php?page=single-product">
						<?=$fn->getItemNameById($item_id)?>
					</a>
				</div>
				<div class="brand">
					<?=ucwords($fn->getItemFieldById($item_id,'item_name'))?>
				</div>
			</div>
			<div class="prices">
				<div class="price-prev">$1399.00</div>
				<div class="price-current pull-right">$1199.00</div>
			</div>
			<div class="hover-area">
				<div class="add-cart-button">
					<a href="#" class="le-button a2c">add to cart</a>
				</div>
				<div class="wish-compare">
					<a class="btn-add-to-wishlist" href="#">add to wishlist</a>
					<a class="btn-add-to-compare" href="#">compare</a>
				</div>
			</div>
		</div>
	</div>
<?php
	}///END 4each
?>
                    </div>
                    <div class="loadmore-holder text-center">
                        <a class="btn-loadmore" href="#">
                            <i class="fa fa-plus"></i>
                            load more products</a>
                    </div> 
                </div>
            </div>
        </div>
    </div>
</div>