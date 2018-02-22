<?php
	include(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'fn.php');

	$type = (isset($_REQUEST['type']) && $_REQUEST['type'] == true) ? trim(strip_tags($_REQUEST['type'])) : NULL;
	$category = (isset($_REQUEST['category']) && $_REQUEST['category'] == true) ? trim(strip_tags($_REQUEST['category'])) : NULL;
	$order = ((isset($_REQUEST['orderBy'])) && trim($_REQUEST['orderBy']) !== 'false') ? strtolower(trim($_REQUEST['orderBy'])) : false;
	$orderSql = (((isset($_REQUEST['orderBy'])) && trim($_REQUEST['orderBy']) !== 'false') && trim($_REQUEST['orderBy']) !== '') ? "ORDER BY $order ASC" : NULL;
?>  
 
<div class="col-xs-12 col-sm-4 col-md-3 sidemenu-holder">
  <div id='top-banner-and-menu'>
	<?php require MC_ROOT.'/parts/navigation/sidemenu.php' ?>
  </div>
</div><!--grid /.sidemenu-holder -->

<div class='col-lg-12'>
	<div class="grid-list-buttons pull-right" style="margin-top: -55px;">
		<ul class="nav nav-pills viewProductsGridOrListUl">
			<li class="grid-list-button-item active">
				<button type='button' class='btn btn-default'><i class="fa fa-th-large"></i> 
					Grid
				</button>
			</li>
			<li class="grid-list-button-item">
				<button type='button' class='btn btn-link'><i class="fa fa-th-list"></i> 
					List
				</button>
			</li>
			<li class="orderByProductsGridOrListOutput" style="padding-right:5px;">
				<select class="form-control">
					<option class="bold" value="">Filter Results
					<option value="item_name" <?=(($order) && $order == 'item_name') ? 'selected' : ''?>>Name
					<option value="item_price" <?=(($order) && $order == 'item_price') ? 'selected' : ''?>>Price
					<option value="item_qty" <?=(($order) && $order == 'item_qty') ? 'selected' : ''?>>Quantity
					<option value="item_condition" <?=(($order) && $order == 'item_condition') ? 'selected' : ''?>>Condition
				</select>
			</li>
		</ul>
	</div> 
</div>

<!--========================= GRID VIEW ========================-->

	<div id='prod_output' class="col-xs-12 col-sm-8 col-md-9">
	 <div class="product-grid-holder product-grid-holder-pulled">
<?php
//////////////////////////////////////////////////////////
$i = 0;
if($category && $type){
	$Q = $sql->getRows('items_4_sale','item_type',$type,$orderSql,false,false,$category);
			
    $lim = (isset($_REQUEST['lim'])) ? intval($_REQUEST['lim']) : 12;
	/////////////////////////////////////
    if($Q){
		$r = $sql->getRows('items_4_sale','item_type',$type,$orderSql,"LIMIT $lim",false,$category);
        $rowCnt = count($r)-1;
            $rows = $rowCnt; //max rows
            $diviser = $rowCnt / $lim; //each pg = max rows divided by '5', '5' = limit
            $rowCnt = ceil($diviser); ///round up everything lol			
	///////////////////////////////	
		if($rows > $lim){
			$offset = 0;
			if(isset($_REQUEST['page_num'])){
				$p = intval($_REQUEST['page_num'], 0);
				$offset = $lim * $p; // limit end 'offset'	
			}///END if
		}else{
			$offset = 0;
		}///END if rows > lim
	}else{
		$p = 0;
		$offset = 0;
		$rows = NULL;
	}///END ifelse///END if
	/////PAGINATION/////
	$rws = $sql->getRows('items_4_sale','item_type',$type,$orderSql,"LIMIT $lim OFFSET $offset",false,$category);
		
	if($sql->numRows('items_4_sale','item_type',$type,false,"LIMIT $lim OFFSET $offset",false,$category) > 0){
		foreach($rws AS $row){
			$item_qty = trim(intval($row['item_qty']));
			$i++;
?>
	<div class="col-sm-4 col-md-4 no-margin product-item-holder hover">
		<div class="product-item" pid='<?=$row['id']?>'>
			<!--RIBBONS-->
			<div class="ribbon blue"><span>new!</span></div> 
			<div class="hide ribbon text-danger"><span class='text-primary'>new!</span></div> 
			<div class="hide ribbon red"><span>sale</span></div> 
			<div class="hide ribbon green"><span>bestseller</span></div> 
			
			<!--IMAGE-->
			<div class="image">
				<img alt="" src="<?=$fn->getItemPic($row['id'],$tireChk = (trim($row['item_type']) == 'tire') ? true : false)?>" data-echo="<?=$fn->getItemPic($row['id'],$tireChk = (trim($row['item_type']) == 'tire') ? true : false)?>" />
			</div>
			
			<!--BODY-->
			<div class="body">
				
				<div class="title">
				
				<!--ITEM_NAME-->
					<a href='#'>
						<?=$fn->getItemNameById($row['id'])?>
						B113-E-10072
					</a>
					
				</div>
				<div class="brand">
					<span class='text-muted'>sold by</span>
					<?=$fn->getItemFieldById($row['id'],'item_name')?>
				</div>
			</div>
			
			<!--PRICE-->
			<div class="prices">
				<!--<div class="price-prev">$1399.00</div>-->
								<!--SALE-->
				<div class="label-discount pull-left">-50% sale</div>
				<div class="price-current pull-right">$<?=number_format($row['item_price'],2)?></div>
			</div>
			<br>
			<div class="hover-area">
			
				<!--ADD 2 CART BTN1-->
				<div class="add-cart-button">
<?php
	if(trim($item_qty) > 0){
		echo "<button class=\"le-button a2c\">add to cart</button>";
	}else{
		echo "<strong class='text-center lead text-danger bold'>Out of stock</strong>";
	}///END ifelse
?>				
				</div>
				<div class="wish-compare">
					
					<!--ADD 2 CART BTN2-->
					<a class="btn-add-to-wishlist btn-link a2w" href="#">add to wishlist</a>
					
					<text class="text-muted" href="#"><i class='fa fa-plane'></i> 2-Day Shipping</text>
				</div>
			</div>
		</div>
	</div>
<?php
			($i == 4 || $i == 8 || $i == 12) ? print("</div></div><div class='col-xs-12 col-sm-8 col-md-9'><div class='product-grid-holder product-grid-holder-pulled'>") : '' ;
		}///END 4each
	}else{
			include_once(THIS_DIR.'/dummy_product_grid.php');
		// $fn->echoNoResultsMsg(ucwords('no results found for '.$type));
	}///END ifelse
///END type
//////////////////_PAGINATION_PAGE_NUMBERS_///////////////////
$rowCnt = $sql->numRows('items_4_sale','item_type',$type,false,"LIMIT $lim OFFSET $offset",false,$category);
$rowCnt = ceil($rowCnt / $lim);
	if($rowCnt > 0){
		print("<span class='pagination-holder'>"
				."<div class='row'>"
				."<div class='col-lg-3 col-sm-3 col-xs-3'></div>"
				."<div class='col-xs-6 col-sm-6 col-lg-6 text-center'>"
				."<ul class='pagination'>"
			);	
		if(empty($p)){
		  $p = 0;
	  }
 		for($i = 0; $i < $rowCnt; $i++){
		  $pgNumShown = $i + 1;
			$btn = "<li><button type='button' class='btn btn-sm btn-link' onclick='go2pg($i)' ";
		  if(isset($p) && $i == $p){
		  	$btn .= " disabled ";
		  }
			$btn .= " >".$pgNumShown."</button></li>";
			echo $btn;
		}
		print("</ul></div><div class='col-lg-3 col-sm-3 col-xs-3'></div</div></span>");
	}///END if
//////////////////////////////////////////////////////////////////////////
////END search && type
}elseif($category){
	
////END search
}elseif($type){
    $Q = $sql->getRows('items_4_sale','item_type',$type,$orderSql);
    $lim = (isset($_REQUEST['lim'])) ? intval($_REQUEST['lim']) : 12;
	/////////////////////////////////////
    if($Q){
        $r = $sql->getRows('items_4_sale','item_type',$type);								 
        $rowCnt = count($r)-1;
            $rows = $rowCnt; //max rows
            $diviser = $rowCnt / $lim; //each pg = max rows divided by '5', '5' = limit
            $rowCnt = ceil($diviser); ///round up everything lol			
	///////////////////////////////	
		if($rows > $lim){
			$offset = 0;
			if(isset($_REQUEST['page_num'])){
				$p = intval($_REQUEST['page_num'], 0);
				$offset = $lim * $p; // limit end 'offset'	
			}///END if
		}else{
			$offset = 0;
		}///END if rows > lim
	}else{
		$p = 0;
		$offset = 0;
		$rows = NULL;
	}///END ifelse///END if	
	/////PAGINATION/////
	//$row_count = count($sql->getRows('items_4_sale','item_type',$type)) - 1;
	$rws = $sql->getRows('items_4_sale','item_type',$type,$orderSql,'LIMIT '.$lim.' OFFSET '.$offset);
						
	if($rows && count($rows) > 0){
			
		foreach($rws AS $row){
			$item_qty = trim(intval($row['item_qty']));
			$i++;
?>
	<div class="col-sm-4 col-md-3 no-margin product-item-holder hover">
		<div class="product-item" pid='<?=$row['id']?>'>
			<!--RIBBONS-->
			<div class="ribbon blue"><span>new!</span></div> 
			<div class="hide ribbon text-danger"><span class='text-primary'>new!</span></div> 
			<div class="hide ribbon red"><span>sale</span></div> 
			<div class="hide ribbon green"><span>bestseller</span></div> 
			
			<!--IMAGE-->
			<div class="image">
				<img alt="" src="<?=$fn->getItemPic($row['id'],$tireChk = (trim($row['item_type']) == 'tire') ? true : false)?>" data-echo="<?=$fn->getItemPic($row['id'],$tireChk = (trim($row['item_type']) == 'tire') ? true : false)?>" />
			</div>
			
			<!--BODY-->
			<div class="body">
				
				<div class="title">
				
				<!--ITEM_NAME-->
					<a href='#'>
						<?=$fn->getItemNameById($row['id'])?>
						
						&nbsp;
						
						<small class='text-muted pull-right'>qty: <?=$row['item_qty']?></small>
					</a>
					
				</div>
				<div class="brand">
					<span class='text-muted'>sold by</span>
					<?=$fn->getItemFieldById($row['id'],'item_name')?>
				</div>
			</div>
			
			<!--PRICE-->
			<div class="prices">
				<!--<div class="price-prev">$1399.00</div>-->
								<!--SALE-->
				<div class="label-discount pull-left">-50% sale</div>
				<div class="price-current pull-right">$<?=number_format($row['item_price'],2)?></div>
			</div>
			<br>
			<div class="hover-area">
					
				<!--ADD 2 CART BTN1-->
				<div class="add-cart-button">
<?php
	if(trim($item_qty) > 0){
		echo "<button class=\"le-button a2c\">add to cart</button>";
	}else{
		echo "<strong class='text-center lead text-danger bold'>Out of stock</strong>";
	}///END ifelse
?>		
				</div>
				<div class="wish-compare">
					
<?php
if($fn->ifLoggedInReturnAsMember(true)){
	$num_rows = $sql->numRowsV2('mem_wishlist','mem_id',_ID_,array("item_id"=>$row['id']));
	
	$hide_a2w_btn = ($num_rows > 0) ? 'hide' : '';
}else{
	$hide_a2w_btn = NULL;
}////END ifelse
?>	
					<button class="btn-add-to-wishlist btn-link a2w <?=$hide_a2w_btn?>" type="button" >add to wishlist</button>
					
					<text class="text-muted" href="#"><i class='fa fa-plane'></i> 2-Day Shipping</text>
				</div>
			</div>
		</div>
	</div>
	
<?php
			($i == 4 || $i == 8 || $i == 12) ? print("</div></div><div class='col-xs-12 col-sm-8 col-md-9'><div class='product-grid-holder product-grid-holder-pulled'>") : '' ;
		}///END 4each	
	}else{
			include_once(THIS_DIR.'/dummy_product_grid.php');
		// $fn->echoNoResultsMsg(ucwords('no results found for '.$type));
	}///END ifelse
///END type
//////////////////_PAGINATION_PAGE_NUMBERS_///////////////////
$rowCnt = count($sql->getRows('items_4_sale','item_type',$type)) - 1;
$rowCnt = ceil($rowCnt / $lim);
	if($rowCnt > 1){
		print("<span class='pagination-holder'>"
				."<div class='row'>"
				."<div class='col-lg-3 col-sm-3 col-xs-3'></div>"
				."<div class='col-xs-6 col-sm-6 col-lg-6 text-center'>"
				."<ul class='pagination'>"
			);	
		if(empty($p)){
		  $p = 0;
	  }
 		for($i = 0; $i < $rowCnt; $i++){
		  $pgNumShown = $i + 1;
			$btn = "<li><button type='button' class='btn btn-sm btn-link' onclick='go2pg($i)' ";
		  if(isset($p) && $i == $p){
		  	$btn .= " disabled ";
		  }
			$btn .= " >".$pgNumShown."</button></li>";
			echo $btn;
		}
		print("</ul></div><div class='col-lg-3 col-sm-3 col-xs-3'></div</div></span>");
	}///END if
//////////////////////////////////////////////////////////////////////////

}else{
	include_once(THIS_DIR.'/dummy_product_grid.php');
}///END ifelse
?>	
	 </div>
	</div>
 <!--========================= END GRID VIEW ========================-->


	
<script>
function go2pg(p){
	$(document).ready(function(){
		
		$.post('/fixquick.newTmpl8/PHP/parts/section/pagination_product_grid.php',{
			page_num:p
		}, function(response){
		
		  $('#prod_output').html(response);
		})
	})
}	
</script>



