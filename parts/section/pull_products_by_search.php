<?php
	include(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'fn.php');

	$search_term = (isset($_REQUEST['searchTerm'])) ? strtolower(trim($_REQUEST['searchTerm'])) : NULL;
	$order = ((isset($_REQUEST['orderBy'])) && trim($_REQUEST['orderBy']) !== 'false') ? strtolower(trim($_REQUEST['orderBy'])) : NULL;
	$orderSql = ((isset($_REQUEST['orderBy'])) && trim($_REQUEST['orderBy']) !== '') ? "ORDER BY $order ASC" : NULL;
?>

<div class="col-xs-12 col-sm-4 col-md-3 sidemenu-holder">
  <div id='top-banner-and-menu'>
	<?php require MC_ROOT.'/parts/navigation/sidemenu.php' ?>
  </div>
</div><!--grid /.sidemenu-holder -->


<div class='col-lg-12'>
	<div class="grid-list-buttons pull-right" style="margin-top: -55px;">
		<ul class="nav nav-pills viewProductsGridOrListUl">
			<li class="orderByProductsGridOrListOutput" style="padding-right:5px;">
				<select class="form-control" >
					<option class="bold" value="">Filter Results
					<option value="item_name" order-type="ASC" <?=(($order) && $order == 'item_name') ? 'selected' : ''?>>Name
					<option value="item_price" order-type="ASC" <?=(($order) && $order == 'item_price') ? 'selected' : ''?>>Price
					<option value="item_qty" order-type="ASC" <?=(($order) && $order == 'item_qty') ? 'selected' : ''?>>Quantity
					<option value="item_condition" order-type="ASC" <?=(($order) && $order == 'item_condition') ? 'selected' : ''?>>Condition
				</select>
			</li>
		<!--
			<li class="grid-list-button-item">
				<button type='button' class='btn btn-link'><i class="fa fa-th-large"></i> 
					Grid
				</button>
			</li>
			<li class="grid-list-button-item">
				<button type='button' class='btn btn-default'><i class="fa fa-th-list"></i> 
					List
				</button>
			</li>
		-->
		</ul>
	</div> 
</div>


<!--========================= LIST VIEW ========================-->

<div class='tab-content' id='list-view'>
	<div id='' class="col-xs-12 col-sm-8 col-md-9 col-lg-12">
	 <div class="product-grid-holder products-list">
<?php
//////////////////////////////////////////////////////////
$i = 0;
if(isset($search_term)){
	
	$search_term_reformatted = (strstr(trim($search_term),' ')) ? str_replace(' ','_',trim($search_term)) : $search_term;
	
	//$Q = $sql->getRows('items_4_sale','item_type',$type,false,false,false,$category);
	//fields to search in: item_name,item_type,item_category,fluid_type
			
	$chk_sql = "SELECT DISTINCT * 
				FROM items_4_sale 
				WHERE item_name LIKE '$search_term'
				OR item_type LIKE '$search_term'
				OR item_category LIKE '$search_term'
				OR fluid_type LIKE '$search_term' 
				OR item_type LIKE '$search_term_reformatted'
				OR item_category LIKE '$search_term_reformatted' 
				OR item_name LIKE '$search_term_reformatted' 
				OR fluid_type LIKE '$search_term_reformatted'";
			
	$Q = mysqli_query($dbCon,$chk_sql) or die('problem with search query: '.mysqli_error($dbCon));
	
	$Q_rows = mysqli_num_rows($Q);
	
    $lim = (isset($_REQUEST['lim'])) ? intval($_REQUEST['lim']) : 12;
	/////////////////////////////////////
    if($Q){
		$r = $Q_rows;
        $rowCnt = $r;
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
	
	$rws = mysqli_query($dbCon,"SELECT DISTINCT * 
								FROM items_4_sale 
								WHERE item_name LIKE '$search_term'
								OR item_type LIKE '$search_term'
								OR item_category LIKE '$search_term'
								OR fluid_type LIKE '$search_term' 
								OR item_type LIKE '$search_term_reformatted'
								OR item_category LIKE '$search_term_reformatted' 
								OR item_name LIKE '$search_term_reformatted' 
								OR fluid_type LIKE '$search_term_reformatted' 
								$orderSql 
								LIMIT $lim OFFSET $offset") or die('error with dam search query '.mysqli_error($dbCon));
							 
	if($Q_rows > 0){
		foreach($rws AS $row){
			$item_qty = trim(intval($row['item_qty']));
			$i++;
			// echo "item_id: ".$row['id'];
?>
	<div class="product-item product-item-holder" pid='<?=$row['id']?>'>
		<div class="ribbon red"><span>sale</span></div> 
		<div class="ribbon blue"><span>new!</span></div>
		<div class="row">
			<div class="no-margin col-xs-12 col-sm-4 image-holder">
				<div class="image">
					<img alt="" src="<?=$fn->getItemPic($row['id'],$tireChk = (trim($row['item_type']) == 'tire') ? true : false)?>" data-echo="<?=$fn->getItemPic($row['id'],$tireChk = (trim($row['item_type']) == 'tire') ? true : false)?>" />
				</div>
			</div><!-- /.image-holder -->
			<div class="no-margin col-xs-12 col-sm-5 body-holder">
				<div class="body">
					<div class="label-discount green">-50% sale</div>
					<div class="title">
						<a href="#"><?=$fn->getItemNameById($row['id'])?></a>
					</div>
					<div class="brand">
						<?=$fn->getItemFieldById($row['id'],'item_name')?>						
					</div>
					<div class="excerpt">
						<p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Ut lobortis euismod erat sit amet porta. Etiam venenatis ac diam ac tristique. Morbi accumsan consectetur odio ut tincidunt.</p>
					</div>
					<div class="addto-compare">
						<a class="btn-add-to-compare" href="#">add to compare list</a>
					</div>
				</div>
			</div><!-- /.body-holder -->
			<div class="no-margin col-xs-12 col-sm-3 price-area">
				<div class="right-clmn">
					
					<div class="price-current">$<?=number_format($row['item_price'],2)?></div>
					<!--<div class="price-prev">$1399.00</div>-->
					<div class="availability"><label>availability:</label><span class="available">  in stock</span></div>
					
<?php
	if(trim($item_qty) > 0){
		echo "<button class=\"le-button a2c\">add to cart</button>";
	}else{
		echo "<strong class='text-center lead text-danger bold'>Out of stock</strong>";
	}///END ifelse
?>		
					
<?php
if($fn->ifLoggedInReturnAsMember(true)){
	$num_rows = $sql->numRowsV2('mem_wishlist','mem_id',_ID_,array("item_id"=>$row['id']));
	
	$hide_a2w_btn = ($num_rows > 0) ? 'hide' : '';
}else{
	$hide_a2w_btn = NULL;
}////END ifelse
?>	
					<button class="btn-add-to-wishlist btn-link a2w <?=$hide_a2w_btn?>" type="button" >add to wishlist</button>
				
				</div>
			</div><!-- /.price-area -->
		</div><!-- /.row -->
	</div>	
<?php
			($i == 4 || $i == 8 || $i == 12) ? print("</div></div><div class='col-xs-12 col-sm-8 col-md-9 col-lg-12'><div class='product-grid-holder products-list'>") : '' ;
		}///END 4each
	}else{
		////else no results....
			// include_once(THIS_DIR.'/dummy_product_grid.php');
		 $fn->echoNoResultsMsg(ucwords('no results found for '.$search_term));
	}///END ifelse
///END type
//////////////////_PAGINATION_PAGE_NUMBERS_///////////////////
$rowCnt = $Q_rows;
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
}else{
	include_once(THIS_DIR.'/dummy_product_grid.php');
}///END ifelse
?>	
	 </div>
	</div>
</div>
<!--========================= END LIST VIEW ========================-->

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