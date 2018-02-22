<?php
if(isset($_GET['page']) && $_GET['page'] == 'home'){
	?>
	<div class='container-fluid no-padding'>
		<div class='col-xs-12 col-lg-12 no-padding'>
		 <div class='top-menu-bar-btns'>
		  <ul class='list-inline list-group' role='menu-bar'>
		   <li class=''>
			<a href='#' type='button' class='btn btn-link'>
				<strong class='text-center text-muted lead'>mechanics</strong></a></li>
		   <li class=''>
			<a href='#' type='button' class='btn btn-link'>
				<strong class='text-center text-muted lead'>tires</strong></a></li>
		   <li class=''>
			<a href='#' type='button' class='btn btn-link'>
				<strong class='text-center text-muted lead'>parts</strong></a></li>
		   <li class=''>
			<a href='#' type='button' class='btn btn-link'>
				<strong class='text-center text-muted lead'>accessories</strong></a></li>
		   <li class=''>
			<a href='#' type='button' class='btn btn-link'>
				<strong class='text-center text-muted lead'>fluids</strong></a></li>
		  </ul>
		 </div>
		</div>
	</div>	
	<?php
}else{
	echo "<hr/>";
}////END ifelse
?>
