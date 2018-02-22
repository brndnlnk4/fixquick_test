<!-- ============================================================= HEADER ============================================================= -->
<header>
<?php
	if($_GET['page'] !== 'cart'){
	?>
	<div class="container no-padding">
		
		<div class="col-xs-12 col-sm-12 col-md-3 logo-holder">
			<?php require_once MC_ROOT.'/parts/widgets/header/logo.php'; ?>
		</div><!-- /.logo-holder -->

		<div class="col-xs-12 col-sm-12 col-md-6 top-search-holder no-margin">
			<?php 
			if($_GET['page'] !== 'checkout'){
				require_once MC_ROOT.'/parts/widgets/header/search-bar.php'; 
			}///END if
			?>
		</div><!-- /.top-search-holder -->

		<div class="col-xs-12 col-sm-12 col-md-3 top-cart-row no-margin">
			<?php 
			if($_GET['page'] !== 'checkout'){
				require_once MC_ROOT.'/parts/widgets/header/shopping-cart-dropdown.php'; 
			}///END if
			?>
		</div><!-- /.top-cart-row -->

	</div><!-- /.container -->	
	<?php
	}///END if
?>

</header>
<!-- ==========a=================================================== HEADER : END ============================================================= -->