<!-- ========================================== SECTION – HERO ========================================= -->		
<div id="hero">
	<div id="owl-main" class="home-top-slider owl-carousel height-lg owl-inner-nav owl-ui-lg">
<?php
	foreach($home_sliders AS $slide){
		$img = htmlspecialchars(trim($slide['img']));
		$header = ucfirst(trim($slide['top_header']));
		$desc = ucfirst(trim($slide['middle_desc']));
		$btn = trim($slide['btm_btn']);
		$animation = $slide['animation_type'];
?>
		
		<div class="item" style="background-image: url(assets/images/sliders/<?=$img?>);background-size:cover;background-repeat:no-repeat;">
			<div class="container-fluid">
				<div class="caption vertical-center text-left right" style="padding-right:0;">
					<div class="big-text <?=$animation?>-1">
						<?=$header?>
					</div>
					
					<div class="excerpt <?=$animation?>-2">
						<?=$desc?>
					</div>
					<div class="small <?=$animation?>-2">
						terms and conditions apply
					</div>
					<div class="button-holder <?=$animation?>-3">
						<?=$btn?>
					</div>
					
				</div><!-- /.caption -->
			</div><!-- /.container-fluid -->
		</div><!-- /.item -->

<?php		
		//print($header);
	}///END 4each
?>
	</div><!-- /.owl-carousel -->
</div>
			
<!-- ========================================= SECTION – HERO : END ========================================= -->