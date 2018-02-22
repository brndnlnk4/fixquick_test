<!-- ================================== MEGAMENU 4 ACCESSORIES ================================== -->
<div class="row oil_menu_items_row">
    <div class="col-xs-12 col-lg-4">
        <ul class='oil_menu_items_ul'>
		<?php
		foreach($oil_brands AS $brand){
		?>
            <li>
				<a href="#" name='<?=trim($brand)?>'><?=ucwords(trim($brand))?></a>
			</li>
		<?php
		}///END 4each
		?>
		</ul>
    </div>
	<div class='col-lg-2 oil_weight_menu_div'>
		<ul class='pull-right'>
		 <li><a href='#'>5W-0</a></li>
		 <li><a href='#'>5W-20</a></li>
		 <li><a href='#'>5W-30</a></li>
		 <li><a href='#'>10W-30</a></li>
		 <li><a href='#'>10W-40</a></li>
		 <li><a href='#'>10W-50</a></li>
		 <li><a href='#'>15W-30</a></li>
		 <li><a href='#'>15W-40</a></li>
		</ul>
	</div>


    <div class="dropdown-banner-holder">
		<img src="assets/images/banners/engine_oils.png" />
    </div>
</div>
<!-- ================================== MEGAMENU VERTICAL ================================== -->