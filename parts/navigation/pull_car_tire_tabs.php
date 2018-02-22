<?php
	include(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'fn.php');

	
////CHECK FOR CARS & TIRES IN GARAGE 2 LOAD ONTO TABS
	if($fn->ifLoggedInReturnAsMember(true)){
		$chk4CarRows = $sql->numRows('mem_garage','mem_id',_ID_,false,"item_type=car");
		$chk4TireRows = $sql->numRows('mem_garage','mem_id',_ID_,false,"item_type=tire");
		$garage_cars = (trim($chk4CarRows) > 0) ? $sql->getRows('mem_garage','mem_id',_ID_,"ORDER BY id DESC",false,false,"item_type=car") : NULL;
		$garage_tires = (trim($chk4TireRows) > 0) ? $sql->getRows('mem_garage','mem_id',_ID_,"ORDER BY id DESC",false,false,"item_type=tire") : NULL;
		
		///LOAD CAR TABS	
		if(!is_null($garage_cars)){
			foreach($garage_cars AS $garage_car){
				echo "<li class='dropdown'><i title='Your Car' class='fa fa-car text-muted'></i>";
				echo "<button data-toggle='dropdown' type='button' class='btn btn-link text-capitalize dropdown-toggle memCarTabBtn'>{$garage_car['car_year']} {$garage_car['car_make']} {$garage_car['car_model']}</button>";
				echo "<div class='dropdown-menu'>";
				echo "<span class='center-block text-center text-capitalize text-muted'>edit vehicle</span>";
				echo "<ul class='list-group le-links changeOrRemoveDropdown4carTab'>";
					echo "<li><button type='button' class='btn btn-link btn-sm' make2change='{$garage_car['car_make']}' id2change='{$garage_car['id']}'>Change</button></li>";
					echo "<li><button type='button' class='btn btn-link btn-sm'>Hide</button></li>";
					echo "<li><button type='button' class='btn btn-link btn-sm' id2rem='{$garage_car['id']}' onclick='$(this).parents('.dropdown').remove()' >Delete</button></li>";
				echo "</ul>";
				echo "</div>";
				echo "</li>";
			}///END 4each
		}////END if
		
		///LOAD TIRE TABS
		if(!is_null($garage_tires)){
			foreach($garage_tires AS $garage_tire){
				echo "<li class='dropdown'><i title='Your Tire' class='fa fa-dot-circle-o text-muted'></i>";
				echo "<button type='button' data-toggle='dropdown' class='btn btn-link dropdown-toggle memTireTabBtn'>{$garage_tire['tire_width']}/{$garage_tire['tire_ratio']}/{$garage_tire['tire_diameter']}</button> ";
				echo "<div class='dropdown-menu'>";
				echo "<span class='center-block text-center text-capitalize text-muted'>edit tire</span>";
				echo "<ul class='list-group le-links changeOrRemoveDropdown4tireTab'>";
					echo "<li><button type='button' class='btn btn-link btn-sm' id2change='{$garage_tire['id']}'>Change</button></li>";
					echo "<li><button type='button' class='btn btn-link btn-sm'>Hide</button></li>";
					echo "<li><button type='button' class='btn btn-link btn-sm' id2rem='{$garage_tire['id']}'>Delete</button></li>";
				echo "</ul>";
				echo "</div>";
				echo "</li>";
			}///END 4each
		}///END if
	}else{
		if(isset($_COOKIE['guest_car']) && !is_null(trim($_COOKIE['guest_car']))){
			$year = explode('-',$_COOKIE['guest_car'])[0];
			$make = ucwords(explode('-',$_COOKIE['guest_car'])[1]);
			$model = ucwords(explode('-',$_COOKIE['guest_car'])[2]);
			
				echo "<li><button type='button' class='btn btn-link guestCarTabBtn'>{$year} {$make} {$model}</button><a href='#' type='button' class='btn-link delGuestCarCookie'><i class='fa fa-close'></i></a></li>";
		}///END if								
	}///END if
?>