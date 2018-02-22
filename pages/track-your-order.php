<div class="main-content page-track-your-order" id="main-content">

	<div class="inner-xs">
		<div class="page-header">
			<h2 class="page-title">my orders</h2>
		</div>
	</div>
	
	<!---------------------
		LEFT BTN-MENU
	---------------------->
	<div class='col-lg-2 col-xs-12 widget'>
		<div class='inner-xs body bordered' id='myFixquick_myOrdesLeftMenu'>
		  <b class='page-title lead text-capitalize'>orders menu</b>
		   <hr/>
			<ul class='list-group'>
				<li>
					<button class='btn btn-link' load-target='#trackOrder' type='button'>Track My Order</button>
				</li>
				<li>
					<button class='btn btn-link' load-target='#viewOrder' type='button'>Total Orders</button>
				</li>
				<li>
					<button class='btn btn-link' load-target='#returnOrder' type='button'>Returned Orders</button>
				</li>
			</ul>
		</div>
	</div>
	
	<!--quick-intro section-->
	<div class='col-lg-10 col-xs-12 ordersIntro'>
		<p align='center'>
			<h2 class='text-center'>
				Welcome to your orders page
			</h2>
		</p>
	</div>
	
	<!---------------------
	  TRACK ORDER SECTION
	---------------------->
	<section class="section inner-bottom-sm" id='trackOrder'>
		<div class="col-lg-8">

			<div class="section">
				
				<p>To track your order please enter your Order ID in the box below and press return. This was given to you on your receipt and in the confirmation email you should have received.</p>
				
				<form class="track_order" method="post" action="http://demo.transvelo.com/media-center-wp/woocommerce-pages/track-your-order/">

					<div class="field-row row form-row form-row-first">
						<div class="col-xs-12">
							<label for="orderid">Order ID</label> 
							<input type="text" placeholder="Found in your order confirmation email." id="orderid" name="orderid" class="le-input input-text">
						</div>
					</div>

					<div class="field-row row form-row form-row-last">
						<div class="col-xs-12">
							<label for="order_email">Billing Email</label> 
							<input type="text" placeholder="Email you used during checkout." id="order_email" name="order_email" class="le-input input-text">
						</div>
					</div>

					<div class="form-row buttons-holder">
						<input type="submit" value="Track" name="track" class="le-button huge button">
					</div>
				</form>
			</div>	
		</div>
	</section>		   
	
	<!----------------------
		VIEW ORDERS SECTION
	------------------------->		
	<section class='section' id='viewOrder'>
		<div class='col-lg-10 col-sm-12'>
			
			<div class='section list-group-item inline full-width'>
				<div class='col-lg-2'>
					<a href='#' type='button'>
						<strong class='text-left lead'>
							Item Name
						</strong>
						<img src='<?=BASE_URL.'/assets/images/boy.png'?>' class='img-responsive thumbnail' alt='' title='' />
					</a>
				</div><!--//item pic & title-->
				
				<div class='col-lg-7'>
					<div class='well well-sm center-block'>
						<u class='page-title lead'>Item Details</u>
						<p align='left'>
							<ul>
								<li>
									<strong>Arrived on:</strong> 10-24-2042
								</li>
								<li>
									<strong>Shipped From:</strong> Canada
								</li>
								<li>
									<strong>Shipping Price:</strong> $34.00
								</li>
							</ul>
						</p>
					</div>
				</div><!--//item brief info-->
				
				<div class='col-lg-3'>
					<div class='well well-sm'>
						<ul>
							<li>
								<strong>Price:</strong> $40.40
							</li>
							<li>
								<strong>Shipping:</strong> $40.40
							</li>
							<!--star rating for item-->
							<li>
								<div class="star" data-score="4" style="cursor: pointer;width:auto;display:inline;">
								<!--?//JS POPULATES HERE//?-->
								</div>
								<strong class='rating-text'>
									<!--JS POPULATES HERE-->
								</strong>
							</li>
						</ul>
					</div>
					
					<!--view item details btn-->
					<a href='#' type='button' class='btn btn-default full-width btn-lg moreDetailsBtn'>More Details</a>
				
				</div><!--//view item desc-->
			</div>
		
		</div>
	</section>
	
	<!---------------------
    RETURNED ORDERS SECTION
	---------------------->	
	<section class='section' id='returnOrder'>
		<div class='col-lg-10 col-xs-12'>

			<div class='section list-group-item inline full-width'>
				<div class='col-lg-2'>
					<a href='#' type='button'>
						<strong class='text-left lead'>
							Item Name
						</strong>
						<img src='<?=BASE_URL.'/assets/images/boy.png'?>' class='img-responsive thumbnail' alt='' title='' />
					</a>
				</div><!--//item pic & title-->
				
				<div class='col-lg-10'>
					<div class='well well-sm center-block'>
						<u class='page-title lead'>Return Information</u>
						<p align='left'>
							<ul>
								<li class='bordered'>
									<strong>Return Status: </strong><text class='text-success'>IN-PROCESS</text>
								</li>
								<li>
									<strong>Return Request Date: </strong><text class='text-muted'>10-25-2014</text>
								</li>
							</ul>
						</p>
					</div>
				</div><!--//item brief info-->
			</div>
		
		</div>
	</section>
	
</div><!--//.main-content-->