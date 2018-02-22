<?php
	include_once(dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'fn.php');

	$id2change = trim(intval($_REQUEST['id2change']));
	$tire_width = trim($sql->getFld('mem_garage','id',$id2change,'tire_width'));
	$tire_ratio = trim($sql->getFld('mem_garage','id',$id2change,'tire_ratio'));
	$tire_diameter = trim($sql->getFld('mem_garage','id',$id2change,'tire_diameter'));
?>
<div class='col-lg-12 col-xs-12 center-block widget'>
	<div class='outer-xs panel'>
		<span class='text-center center-block lead text-capitalize'>update your tire specifications</span>
		<ul id='tireSpecSelectionUl' class="list-inline" id2change='<?=$id2change?>' style="display: block;">
			<li>
			  <label class="">Tire Width:</label>
				 <select class="input-lg full-width le-select" name="tire_width">
				  <option value="">Width</option>
			<?php
				for($d = 1;$d < 10;$d++){
					$width = 215 + ($d * 10);
					$selected = ($width == $tire_width) ? 'selected' : '';
					echo "<option $selected>$width";
				}///END 4loop
			?>
				 </select>
			</li>	
			<li>
			  <label class="">Tire Ratio:</label>
				 <select class="input-lg full-width le-select" name="tire_ratio">
				  <option value="">Ratio</option>
			<?php
				for($d = 1;$d < 10;$d++){
					$ratio = 30 + ($d * 5);
					$selected = ($ratio == $tire_ratio) ? 'selected' : '';
					echo "<option $selected>$ratio";
				}///END 4loop
			?>
				 </select>
			</li>
			<li>
			  <label class="">Wheel Diameter:</label>
				 <select class="input-lg full-width le-select" name="tire_size">
					<option value="">Inches</option>
			<?php
				for($diameter = 14;$diameter < 30;$diameter++){
					$selected = ($diameter == $tire_diameter) ? 'selected' : '';
					echo "<option $selected>$diameter";
				}///END 4loop
			?>
				 </select>
			</li>
		</ul>
	</div>
	
	<!--show tire selection here-->
	<div class='center-block text-center page-header'>
		<p id='tireSpecUpd8SelectionDisplayContainer' align='center' class='fade page-title lead'>
			<?///JS POPULATES HERE?>
		</p>
	</div>
</div>