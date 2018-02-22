<!-- ================================== MEGAMENU 4 ACCESSORIES ================================== -->
<div class="row">
<?php $auto_accessories = array_chunk($auto_accessories,8); ?>
    <div class="col-xs-12 col-lg-4">
        <ul>
		<?php
		foreach($auto_accessories[0] AS $key => $val){
		?>
            <li><a href="#" name='<?=trim($key)?>'><?=ucwords(trim($val))?></a></li>
		<?php
		}///END 4each
		?>
		</ul>
    </div>

    <div class="col-xs-12 col-lg-4">
        <ul>
		<?php
		foreach($auto_accessories[1] AS $key => $val){
		?>
            <li><?=ucwords(trim($val))?></li>
		<?php
		}///END 4each
		?>
		</ul>
    </div>

    <div class="dropdown-banner-holder">
        <a href="#"><img alt="" src="assets/images/banners/auto_accessories_banner1.png" /></a>
    </div>
</div>
<!-- ================================== MEGAMENU VERTICAL ================================== -->