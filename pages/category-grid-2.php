<?php
    //isListView = isset($_GET['view']) && ($_GET['view'] == 'list') ? true : false;
	print("<br><br><hr>prduct page");
?>
<section id="category-grid" class='myAcct_mainContainer'>
    <div class="container">

        <!-- ========================================= SIDEBAR ========================================= -->
        <div class="col-xs-12 col-sm-3 no-margin sidebar narrow">

            <?php require MC_ROOT.'/myFixquick/sidebar/product-filter.php';?>

            <?php //require MC_ROOT.'/myFixquick/sidebar/category-tree.php';?>

            <?php require MC_ROOT.'/myFixquick/sidebar/my_information.php';?>

            <?php //require MC_ROOT.'/myFixquick/sidebar/sidebar-banner.php';?>

            <?php require MC_ROOT.'/myFixquick/sidebar/featured-products.php';?>

        </div>
        <!-- ========================================= SIDEBAR : END ========================================= -->

        <!-- ========================================= CONTENT ========================================= -->

        <div class="col-xs-12 col-sm-9 no-margin wide sidebar">

            <div id="grid-page-banner">
			
				<!--profile pic upload-->
				<div class='inline'>
					<button class='btn btn-default no-margin' id='myAcctProfPicBtn' title='Upload Profile Pic' type='button'>
						<img src="<?=BASE_URL?>/assets/images/upl/boy.png" alt="" class='img-responsive' width='200px' />
					</button>
				</div>
				
				<div class='col-lg-9 pull-right'>
				  <form id='profileInfoForm'>
				  
					<!--mem name-->
					<div class='field-row row form-row'>
						<div class='col-xs-12'>
							<label for='mem_name'>full name</label>
							<input class='le-input input-lg form-control' name='mem_name' type='name' minlength='4' maxlength='50' placeholder='Enter your full name' />
						</div>
					</div>
					
					<!--mem phone-->
					<div class='field-row row form-row'>
						<div class='col-xs-6'>
							<label for='mem_phone'>phone number</label>
							<input class='le-input input-lg form-control' name='mem_phone' type='tel' minlength='9' maxlength='12' placeholder='Enter your phone number' />
						</div>
						<div class='col-xs-6'>
							<label for='mem_zip'>zip code</label>
							<input class='le-input input-lg form-control' name='mem_zip' type='number' maxlength='5' size='5' placeholder='Enter your postal zip code' />
						</div>
					</div>
					
					<!--mem address-->
					<div class='field-row row form-row'>
						<div class='col-xs-12'>
							<label for='mem_address'>physical address</label>
							<input class='le-input input-lg form-control' name='mem_address' type='address' minlength='4' maxlength='50' placeholder='Enter your address' />
						</div>
					</div>
					
				  </form>
				</div>
            </div><!--//.grid-page-banner-->

            <?php require MC_ROOT.'/myFixquick/section/category-products.php';?>
                        
        </div><!-- /.col -->
        <!-- ========================================= CONTENT : END ========================================= -->    
    </div><!-- /.container -->
</section><!-- /#category-grid -->