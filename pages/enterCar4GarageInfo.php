<?php  
	$selected_make = trim($_REQUEST['selMake']); 
	$garage_row_2_change_id = (isset($_REQUEST['id2change'])) ? trim($_REQUEST['id2change']) : NULL;
?>

<div class='row'>
 <div class='col-lg-12 cd-form'>
  <p align='center' class='field-row'>
   <div class='outer-xs panel'>
    <span class='text-center center-block lead text-capitalize'>select year and model for your <?=ucwords($selected_make)?></span>
   </div>
  </p>
   <table class='changeCarInGarTbl table-responsive table-condensed' width='80%' style='margin:0 auto;'>
	<tbody>
	 <tr>
	  <td colspan='100%'>
	   <p align='center' class='field-row'>
	    <label class='text-left'>Select Vehicle Year</label>
		<span class='fa fa-calendar fa-lg label_icon'></span>
		 <select class='full-width has-padding has-border' id='yr'>
		  <option value='' selected>Select Year</option>
<?php
	$y = date('Y')+1;
	for($i=0;$i<50;$i++){
		echo "<option>".--$y."</option>";					 
	}///END 4loop
?>
		 </select>	
	   </p>
	  </td>
	 </tr>
	 <tr>
	  <td colspan='100%' align='center'>
	   <p align='center' class='field-row'>
	   <label class='text-left'>Select Vehicle Model</label>
		<span class='fa fa-car fa-lg label_icon'></span>
		 <select class='full-width has-padding has-border' id='vehModel' >
<?php
//include_once($_SERVER['DOCUMENT_ROOT'].'/fixitquick/incl/makeList.php'); 
	$data = file_get_contents(__DIR__ .'/makeList.php');
	$dataList = explode('</option>',$data);
////////////////////////
	echo '<option value="">Select Model</option>';
////////////////////////
foreach($dataList AS $model){	
	if(isset($selected_make) && stristr($model,trim($selected_make))){
		echo str_ireplace($selected_make,'',$model).'</option>';	
	}////END if
}///END 4each
?>
		 </select>		
	   </p>
	  </td>
	 </tr>
	 <tr>
	  <td colspan='100%' align='center'>
	   <p align='center' class='field-row'>
	   <label class='text-left'>Select Vehicle Trim</label>
		<span class='fa fa-bolt fa-lg label_icon'></span>
		 <select class='full-width has-padding has-border' id='vehTrim' >
		  <option value=''>Select Trim
		  <option>2.0L V6 
		  <option>2.4L V6
		  <option>3.0L V6 
		  <option>3.5L V6 
		 </select>		
	   </p>
	  </td>
	 </tr>
	 <tr>
	  <td colspan='100%' align='center'>
	   <p align='center' class='field-row'>
	    <button type='button' class='btn btn-lg btn-primary addCarBtn' style='min-width:140px;' disabled >
		 Add Vehicle to Garage
		</button>
	   </p>
	  </td>
	 </tr>
	</tbody>
   </table>
   <!--make model and year inputs-->
   <input type='hidden' value='<?=$selected_make?>' name='carMake' />
   <input type='hidden' value='' name='carModel' />
   <input type='hidden' value='' name='carYear' />
   <input type='hidden' value='' name='carTrim' />
   <input type='hidden' value='<?=$garage_row_2_change_id?>' name='rowId' />
 </div>
</div>