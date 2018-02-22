<!-- ============================================================= TOP NAVIGATION ============================================================= -->
<div id='filler' style='width:100%;height:41px;display:none;'></div>

<nav class="top-bar animate-dropdown">
    <div class="container">
	
        <div class="col-xs-12 col-sm-12 no-margin">
			<span id='searchBarWhenNavStick' class="pull-left hide">
				
				<input type="name" placeholder='Search' class="input-sm form-control no-border">
				
				<button class='btn btn-sm' type='button'><i class='fa fa-search'></i></button>
			</span>
			
	<!---------------------------------------
		VERY TOP MENU FOR GUEST / MEMBER 
	---------------------------------------->
 	<?php ($fn->ifLoggedInReturnAsMember(true)) ? include_once(MC_ROOT."/pages/top-menu-bar-btns-loggedInUsr.php") : include_once(MC_ROOT."/pages/top-menu-bar-btns-guestUser.php"); ?>

        </div><!-- /.col -->
    </div><!-- /.container -->
</nav><!-- /.top-bar -->
<!-- ============================================================= TOP NAVIGATION : END ============================================================= -->