<?php
//+echo $_SERVER['DOCUMENT_ROOT'].'/'.$_SERVER['SERVER_NAME'].'/fixquick.newTmpl8/php/fn.php';
	include($_SERVER['DOCUMENT_ROOT'].'/fixquick.newTmpl8/PHP/fn.php');
	
	$type = (isset($_REQUEST['type']) && $_REQUEST['type'] == true) ? trim(strip_tags($_REQUEST['type'])) : NULL;
	$search = (isset($_REQUEST['search']) && $_REQUEST['search'] == true) ? trim(strip_tags($_REQUEST['search'])) : NULL;
//////////////////////////////////////////////////////////
$i = 0;
if($search && $type){
	
////END search && type
}elseif($search){
	
////END search
}elseif($type){
	echo $type;
 ///////////PAGINATION////////////////
	$Q = count($sql->getRows('items_4_sale','item_type',$type)) - 1;
    /////////////////////////////////////
    if($Q !== 0){
        $r = $sql->getRows('items_4_sale','item_type',$type,'ORDER BY item_price ASC');								 
            $divideNum = 12;
			$rows = $Q; //max rows
            $diviser = $Q / $divideNum; //each pg = max rows divided by '5', '5' = limit
            $Q = ceil($diviser); ///round up everything lol
	///////////////////////////////	
    if($rows > $divideNum){
		$offset = '0';
		if(isset($_REQUEST['page_num'])){
			$p = intval($_REQUEST['page_num'], 0);
			$offset = $divideNum * $p; // limit end 'offset'	
		}
	}else{
		$p = 0;
		$offset = 0;
		}
	}else{
		$offset = 0;
	}					
//////////////////////////////////
//////////////////////////////////
//////////////////////////////////
$rows = $sql->getRows('items_4_sale','item_type',$type,'ORDER BY item_price ASC','LIMIT 12 OFFSET '.$offset);
				
	if($rows && count($rows)-1 > 0){
		foreach($rows AS $row){
			$i++;
?>
	<div class="col-sm-4 col-md-3 no-margin product-item-holder hover">
		<div class="product-item">
			<!--RIBBONS-->
			<div class="ribbon blue"><span>new!</span></div> 
			<div class="hide ribbon text-danger"><span class='text-primary'>new!</span></div> 
			<div class="hide ribbon red"><span>sale</span></div> 
			<div class="hide ribbon green"><span>bestseller</span></div> 
			
			<!--IMAGE-->
			<div class="image">
				<img alt="" src="<?=$fn->getItemPic($row['id'],$tireChk = (trim($row['item_type']) == 'tire') ? true : false)?>" data-echo="assets/images/products/product-04.jpg" />
			</div>
			
			<!--BODY-->
			<div class="body">
			
				<!--SALE-->
				<div class="label-discount">-50% sale</div>
				
				<div class="title">
				<!--ITEM_NAME-->
					<a href="index.php?page=single-product">
						<?=$fn->getItemNameById($row['id'])?>
						B113-E-10072
					</a>
				</div>
				<div class="brand">acer</div>
			</div>
			
			<!--PRICE-->
			<div class="prices">
				<div class="price-prev">$1399.00</div>
				<div class="price-current pull-right">$<?=number_format($row['item_price'],2)?></div>
			</div>
			
			<div class="hover-area">
				<div class="add-cart-button">
					<a href="index.php?page=single-product" class="le-button">add to cart</a>
				</div>
				<div class="wish-compare">
					<a class="btn-add-to-wishlist btn-link" href="#">add to wishlist</a>
					<text class="text-muted" href="#"><i class='fa fa-plane'></i> 2-Day Shipping</text>
				</div>
			</div>
		</div>
	</div>
	
<?php
			($i == 4 || $i == 8 || $i == 12) ? print("</div></div><div class='col-xs-12 col-sm-8 col-md-9'><div class='product-grid-holder product-grid-holder-pulled'>") : '' ;
		}///END 4each	
	//////////////////////////////////////////////////////////////////////////
	//////////////////_PAGINATION_PAGE_NUMBERS_///////////////////
	$rowCnt = count($sql->getRows('items_4_sale','item_type',$type)) - 1;
	$rowCnt = ceil($rowCnt / $divideNum);
		if($rowCnt > 0){
			
	print("<span class='pagination-holder'>"
			."<div class='row'>"
			."<div class='col-lg-3 col-sm-3 col-xs-3'></div>"
			."<div class='col-xs-6 col-sm-6 col-lg-6 text-center'>"
			."<ul class='pagination'>"
		);		
			
		  if(empty($p)){
			  $p = 0;
		  }///END if
			for($n = 0; $n < $rowCnt; $n++){
			  $pgNumShown = $n + 1;
				$btn = "<li p='$p - $i' ";
			  if(isset($p) && $n == $p){
				$btn .= " class='current' ";
			  }///END if
				$btn .= " ><button class='btn btn-default' onclick='go2page({$divideNum},{$pgNumShown},\"$type\")' type='button'>$pgNumShown</button></li>";
							
				echo $btn;
			}///END 4loop
			print("</ul></div><div class='col-lg-3 col-sm-3 col-xs-3'></div</div></span>");
		} 
	}else{
			include_once(THIS_DIR.'/dummy_product_grid.php');
		// $fn->echoNoResultsMsg(ucwords('no results found for '.$type));
	}///END ifelse
///END type
}else{
	include_once(THIS_DIR.'/dummy_product_grid.php');
}///END ifelse
?>	
<script>
$(function(){
	var paginateUl = $('.pagination');
	$.each(paginateUl.find('li'),function(){
		if($(this).hasClass('current')){
			$(this).children('button').attr('disabled','');
		}///END if
	})
})
////PAGINATION METHOD
function go2page(lim,p,type = false,search = false){
	var outpt = $('#products_output'),
        loadingIcon = $("<span class='center-block text-center'><br><br><br><i class='fa fa-4x fa-spinner fa-pulse'></i></span>");;

		outpt.html(loadingIcon);
		$.post('/fixquick.newTmpl8/PHP/parts/section/pagination_product_grid.php', {
				lim:lim,
				page_num:p,
				type:type,
				search:search
		}, function(response){
			outpt.html(response);
			console.log('curPg:',p)
		})///END $post
}///END fn
</script> 