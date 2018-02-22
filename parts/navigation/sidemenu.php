<!-- ================================== TOP NAVIGATION ================================== -->
<div class="side-menu animate-dropdown">
    <div class="head">
		<i class="fa fa-list"></i> all categories
	</div>        
    
	<nav class="yamm megamenu-horizontal" role="navigation">
        <ul class="nav">
		
		<!--popular items-->
            <li class="dropdown menu-item">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Popular Items</a>
				 <!--create array of popular items 2 loop thru-->
                <ul class="dropdown-menu mega-menu">
                    <?php $pageChunkes = array_chunk($pages, 6, true); ?>
                    <li class="yamm-content">
                        <div class="row">
                            <div class="col-md-4">
                                <ul class="list-unstyled">
                                    <?php foreach ( $pageChunkes[0] as $key => $packagePage ) : ?>
                                    <li><a href="index.php?page=<?php echo $key;?>&amp;style=<?php echo $_GET['style'];?>"><?php echo $packagePage;?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <ul class="list-unstyled">
                                    <?php foreach ( $pageChunkes[1] as $key => $packagePage ) : ?>
                                    <li><a href="index.php?page=<?php echo $key;?>&amp;style=<?php echo $_GET['style'];?>"><?php echo $packagePage;?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                            <div class="col-md-4">
                                <ul class="list-unstyled">
                                    <?php foreach ( $pageChunkes[2] as $key => $packagePage ) : ?>
                                    <li><a href="index.php?page=<?php echo $key;?>&amp;style=<?php echo $_GET['style'];?>"><?php echo $packagePage;?></a></li>
                                    <?php endforeach; ?>
                                </ul>
                            </div>
                        </div>
                    </li>
                    
                </ul>
            </li><!-- /.menu-item -->
            <li class="dropdown menu-item">
                <a href="#" class="dropdown-toggle" data-toggle="dropdown">Accessories</a>
                <ul class="dropdown-menu mega-menu">
                    <li class="yamm-content">
                        <?php require MC_ROOT.'/parts/navigation/accessories_mega_menu.php';?>
                    </li>
                </ul>
            </li><!-- /.menu-item -->
<!-----------------
  autoparts begin
--------------------->
            <li class="menu-item">
                <a href="#">Belts(22)</a>
            </li><!-- /.menu-item -->
            <li class="menu-item">
                <a href="#">Brakes(22)</a>
            </li><!-- /.menu-item -->
            <li class="menu-item">
                <a href="#">Brake Pads(22)</a>
            </li><!-- /.menu-item -->
            <li class="menu-item">
                <a href="#">Brake Rotors(22)</a>
            </li><!-- /.menu-item -->
            <li class="menu-item">
                <a href="#">Bulbs(22)</a>
			</li>
            <li class="menu-item">
                <a href="#">Filters(22)</a>
            </li><!-- /.menu-item -->
            <li class="dropdown menu-item">
                <a href="#" class='dropdown-toggle' data-toggle='dropdown'>Oil(22)</a>
                <ul class="dropdown-menu mega-menu">
                    <li class="yamm-content">
                        <?php require MC_ROOT.'/parts/navigation/oil_mega_menu.php';?>
                    </li>
                </ul>
            </li><!-- /.menu-item -->
            <li class="menu-item">
                <a href="#">Spark Plugs(22)</a>
            </li><!-- /.menu-item -->
            <li class="menu-item">
                <a href="#">Transmission Fluid(22)</a>
            </li><!-- /.menu-item -->
            <li class="menu-item">
                <a href="#">Wiper Fluid(22)</a>
            </li><!-- /.menu-item -->
            <li class="menu-item">
                <a href="#">Wiper Blades(22)</a>
            </li><!-- /.menu-item -->
            <li class="menu-item">
                <a href="#">Coolant(22)</a>
            </li><!-- /.menu-item -->

        </ul><!-- /.nav -->
    </nav><!-- /.megamenu-horizontal -->
</div><!-- /.side-menu -->
<!-- ================================== TOP NAVIGATION : END ================================== -->