<!-- ========================================= 
		RELATED ITEMS 	RELATED ITEMS 
========================================= -->
<?php 
	//$carouselID = isset($carouselID) ? $carouselID : 'owl-recently-viewed';
	$containerClass = isset($containerClass) ? $containerClass : 'container';
	$productItemSize = isset($productItemSize) ? $productItemSize : 'size-small';
?>
<!-- ========================================= 
		RELATED ITEMS 	RELATED ITEMS 
========================================= -->
<section id="recently-reviewd" class="wow fadeInUp">
	<div class="<?php echo $containerClass;?>">
		<div class="carousel-holder hover">
<!-----
FLUIDS
------->			
			<div class="title-nav">
				<h2 class="h1"><i class='fa fa-fire text-danger fa'></i> 
					Hot Fluids
					<sup class='text-muted'>(<?=count($fn->getRows('items_4_sale','item_type','fluid'))?>)</sup>
				</h2>				<div class="nav-holder">
					<a href="#prev" data-target="#owl-recently-viewed" class="slider-prev btn-prev fa fa-angle-left"></a>
					<a href="#next" data-target="#owl-recently-viewed" class="slider-next btn-next fa fa-angle-right"></a>
				</div>
			</div><!-- /.title-nav -->
			
	<div id="owl-recently-viewed" class="owl-carousel product-grid-holder">
<?php
	$fluids = $fn->getRows('items_4_sale','item_type','fluid',false,'LIMIT 30');
	foreach($fluids AS $fluid){
		$item_id = $fluid['id'];
?>
		<div class="no-margin carousel-item product-item-holder <?php echo $productItemSize;?> hover">
			<div class="product-item" pid='<?=$item_id?>'>
				<div class="ribbon red">
					<span>
					sale
					</span>
				</div> 
				<div class="image">
					<img alt="" src="<?=$fn->getItemPic($item_id)?>" data-echo="<?=$fn->getItemPic($item_id)?>" />
				</div>
				<div class="body">
					<div class="title">
						<a href='#'>
							<?=$fn->getItemNameById($item_id)?>
						</a>
					</div>
					<div class="brand">
						<?=ucwords($fn->getItemFieldById($item_id,'item_name'))?>
					</div>
				</div>
				<div class="prices">
					<div class="price-current text-right">
						$<?=$fn->getItemFieldById($item_id,'item_price')?>
					</div>
				</div>
				<div class="hover-area">
					<div class="add-cart-button">
						<a href="#" class="le-button a2c">Add to Cart</a>
					</div>
					<div class="wish-compare">
						<a class="btn-add-to-wishlist" href="#">Add to Wishlist</a>
						<a class="btn-add-to-compare" href="#">Compare</a>
					</div>
				</div>
			</div><!-- /.product-item -->
		</div><!-- /.product-item-holder -->
<?php
	}///END 4each
?>
	</div><!-- /#recently-carousel -->

<!-----
PARTS
------->			
			<div class="title-nav">
				
				<h2 class="h1"><i class='fa fa-fire text-danger fa'></i> 
					Hot Parts
					<sup class='text-muted'>(<?=count($fn->getRows('items_4_sale','item_type','part'))?>)</sup>
				</h2>
				<div class="nav-holder">
					<a href="#prev" data-target="#owl-recently-viewed-2" class="slider-prev btn-prev fa fa-angle-left"></a>
					<a href="#next" data-target="#owl-recently-viewed-2" class="slider-next btn-next fa fa-angle-right"></a>
				</div>
			</div><!-- /.title-nav -->
			
	<div id="owl-recently-viewed-2" class="owl-carousel product-grid-holder">
<?php
	$fluids = $fn->getRows('items_4_sale','item_type','part','ORDER BY item_price ASC','LIMIT 30');
	foreach($fluids AS $fluid){
		$item_id = $fluid['id'];
?>
		<div class="no-margin carousel-item product-item-holder <?php echo $productItemSize;?> hover">
			<div class="product-item" pid='<?=$item_id?>'>
				<div class="ribbon red">
					<span>
					sale
					</span>
				</div> 
				<div class="image">
					<img alt="" src="<?=$fn->getItemPic($item_id)?>" data-echo="<?=$fn->getItemPic($item_id)?>" />
				</div>
				<div class="body">
					<div class="title">
						<a href='#'>
							<?=$fn->getItemNameById($item_id)?>
						</a>
					</div>
					<div class="brand">
						<?=ucwords($fn->getItemFieldById($item_id,'item_name'))?>
					</div>
				</div>
				<div class="prices">
					<div class="price-current text-right">
						$<?=$fn->getItemFieldById($item_id,'item_price')?>
					</div>
				</div>
				<div class="hover-area">
					<div class="add-cart-button">
						<a href="#" class="le-button a2c">Add to Cart</a>
					</div>
					<div class="wish-compare">
						<a class="btn-add-to-wishlist" href="#">Add to Wishlist</a>
						<a class="btn-add-to-compare" href="#">Compare</a>
					</div>
				</div>
			</div><!-- /.product-item -->
		</div><!-- /.product-item-holder -->
<?php
	}///END 4each
?>
	</div><!-- /#recently-carousel -->


		</div><!-- /.carousel-holder -->
	</div><!-- /.container -->
</section><!-- /#recently-reviewd -->
<!-- =========================================
	END RELATED ITEMS 	END RELATED ITEMS 
 ========================================= -->