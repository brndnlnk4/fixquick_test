<ul class="pull-right top-bar-ul">
	<li><a href="<?php echo BASE_URL;?>?page=home"><i class='fa fa-home fa-lg'></i>&nbsp;</a></li>
	<li><button class='btn-link' type='button'>Returns</button></li>
	<li><button class='btn-link' type='button'>Warranty</button></li>
	<li><button class='btn-link' type='button'>Price-Matching</button></li>
	
<!----------------------------
  'My Account' DROPDOWN MENU
----------------------------->
	<li class="dropdown">
	  
	  <a class="dropdown-toggle" data-toggle="dropdown" href="#pages"><i class='fa fa-user'></i>&nbsp;
		my account 
	  </a>
		
		<div class="dropdown-menu" role="menu">

		 <table class="editProfTbl table-condensed" width="100%">
		  <tbody>
		  <tr>
		   <td colspan="100%" class=''>
			<p align="center">
			
			 <span class="text-muted center-block text-center text-danger">
			  <small><?=strtoupper(_USER_)?></small>
			 </span>
			 
			 <!--EDIT PROFILE PIC & INFO-->
			 <button type="button" title="Edit Your Profile" onclick="window.open('<?=dirname($_SERVER['REQUEST_URI']).'/myFixquick'?>','_self')" name="editprofBtn" class="btn btn-link edit-profile-nav-btn">
			  <img src="<?=$fn->getAvatar(_ID_)?>" class="img-responsive thumbnail text-center center-block" width="90%">&nbsp;&nbsp;
			   <i class="fa fa-lg fa-edit" style="background-color:rgba(0,0,0,0.082);border-radius:5px;border:5px solid rgba(0,0,0,0.12);"></i>&nbsp;
				
				<b class="text-center" style="">
				Edit Profile
				</b>
			 </button>
			 <hr/>
			</p>
		   </td>
		  </tr>
		  <tr>
		   <td colspan="100%" align='center' class="<?=(stristr($_SERVER['PHP_SELF'],'MyFixquick')) ? ' hide ' : ''?>">
			<p align="">
			 <a href="<?=dirname($_SERVER['REQUEST_URI']).'/myFixquick/#profileInfoForm'?>" type="button" name="orderHistory" class="btn-link">
			 <i class="fa fa-inbox pull-left text-left fa-2x"></i>&nbsp;&nbsp;
			  My Fixquick
			 </a>
			</p>
		   </td>
		  </tr>
		  <tr>
		   <td colspan="100%" align='center' class="<?=(stristr($_SERVER['PHP_SELF'],'MyFixquick')) ? ' hide ' : ''?>">
			<p align="">
			 <a href="<?=dirname($_SERVER['REQUEST_URI']).'/myFixquick/#test2'?>" type="button" name="orderHistory" title="orders" class="btn-link">
			 <i class="fa fa-book pull-left text-left fa-2x"></i>&nbsp;&nbsp;
			  Your Orders
			 </a>
			</p>
		   </td>
		  </tr>
		  <tr>
<!--
		   <td colspan="100%" class=''>
			<p align="center">
			 <a href="#" type="button" name="warantiesBtn" class="btn-link">
			 <i class="fa fa-car pull-left text-left fa-2x"></i>&nbsp;&nbsp;
			 Warranties
			 </a>
			</p>
		   </td>
-->
		  </tr>
		  <tr>
		   <td colspan="100%" class="<?=(stristr($_SERVER['PHP_SELF'],'MyFixquick')) ? ' hide ' : ''?>">
			<p align="center">
			 <a href="<?=dirname($_SERVER['REQUEST_URI']).'/myFixquick/#test3'?>" type="button" name="settings" title="payment" class="btn-link">
			 <i class="fa fa-money pull-left text-left fa-2x"></i>&nbsp;&nbsp;
			 settings
			 </a>
			</p>
		   </td>
		  </tr>
		  <tr>
		   <td colspan="100%" style="background:#3737ac;" >
			<p align="center">
			 <button type="button" onclick="window.open('<?=dirname($_SERVER['REQUEST_URI'])?>/?page=home&logoutUser','_self')" class="btn text-center full-width btn-lg btn-primary full-width">
			 &nbsp;&nbsp;<i class="fa fa-sign-in fa-lg"></i>&nbsp;&nbsp;
			  Sign-Out
			 </button>
			</p>
		   </td>
		  </tr>
		 </tbody>
		</table>
		
		</div>
	</li>
</ul>