<!-- ========================================= TOP BRANDS ========================================= -->
<section id="top-brands" class="wow fadeInUp">
    <div class="container">
        <div class="carousel-holder" >
            
            <div class="title-nav">
                <h1>Top Brands</h1>
                <div class="nav-holder">
                    <a href="#prev" data-target="#owl-brands" class="slider-prev btn-prev fa fa-angle-left"></a>
                    <a href="#next" data-target="#owl-brands" class="slider-next btn-next fa fa-angle-right"></a>
                </div>
            </div><!-- /.title-nav -->
            
            <div id="owl-brands" class="owl-carousel brands-carousel">
<?php
	foreach(array_merge($tire_brand_pics,$fluid_brand_pics) AS $key=>$pic){
		$pic = (!file_exists("assets/images/brands/{$pic}.jpg")) ? $pic.'.png' : $pic.'.jpg';
?>
		<div class="carousel-item">
			<a type='button' href="#" brand-item='<?=trim($key)?>'>
				<img alt="" class='img-responsive' src="assets/images/brands/<?=trim($pic)?>" />
			</a>
		</div><!-- /.carousel-item -->
<?php
	}///END 4each
?>

            </div><!-- /.brands-caresoul -->

        </div><!-- /.carousel-holder -->
    </div><!-- /.container -->
</section><!-- /#top-brands -->
<!-- ========================================= TOP BRANDS : END ========================================= -->