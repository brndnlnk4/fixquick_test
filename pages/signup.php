<!-- ========================================= MAIN ========================================= -->
<main id="registration_container" class="inner-bottom-md">
	<div class="container">
		<div class="row">

			<div class="col-sm-12 col-lg-7">
				<section class="section register inner-left-xs">
					<sub class='text-muted pull-right'>(*) Fields Required</sub>

					<h2 class="bordered">
						Create New Account 
					</h2>

					<form role="form" action="<?=BASE_URL."/ses.php"?>" method="POST" class="cd-form register-form cf-style-1">
						<p class="field-row">
							<label class='registrationEmailAddress'>Email Address*</label>
							<span class='label_icon fa fa-envelope-o fa-lg'></span>
							<input class="full-width has-padding has-border" value='' name='usr_email' id="signup-email" type="email" placeholder="Enter Email" required />
							<span class="cd-error-message"></span>
						</p>

						<p class="field-row">
							<label>Enter Password*</label>
							<span class='label_icon fa fa-lock fa-lg'></span>
							<input class="full-width has-padding has-border" value='' name='usr_pw1' id="signup-pw1" minlength='4' maxlength='15' type="password" placeholder="Enter Password" required />
							<span class="cd-error-message"></span>
						</p>

						<p class="field-row border">
							<label>Re-type Password*</label>
							<span class='label_icon fa fa-lock fa-lg'></span>
							<input class="full-width has-padding has-border" value='' name='usr_pw2' id="signup-pw2" minlength='4' maxlength='15' type="password" placeholder="Re-Enter Password" required />
							<span class="cd-error-message"></span>
						</p>

						<hr/>
							
                        <div class="buttons-holder">
							<span class='pull-left'>
							
							<!--security-bot check question-->
								<ul class='list-inline panel no-margin robotSecurity'>
									<li>
										<img src='' class='thumb img-responsive' alt='Security' width='40px'/>
									</li>
									<li>
										<input type='text' class='input-lg form-control has-border' maxlength='5' class='form-control' placeholder='Enter numbers in picture' />
									</li>
								</ul>
								
							</span>
							
                            <button type="submit" name="newSignup" class="le-button huge" disabled>Sign Up</button>
                       
					   <div class="g-recaptcha" data-sitekey="6LcVzBIUAAAAAKkBHn5rE57TlaoTT-w7e72DvnYT"></div>
						<!--secretKey:--6LcVzBIUAAAAAHfhpaxgZVL_MjNR9rTze84JHDFE-->
						</div><!-- /.buttons-holder -->
					</form>

				</section><!-- /.register -->

			</div><!-- /.col -->
			
			<div class='col-sm-12 col-lg-5 has-padding'>
			  <p align='center'>
				<h2 class="semi-bold">Sign up today and you'll be able to :</h2>

				<ul class="list-unstyled list-benefits">
					<li><i class="fa fa-check primary-color"></i> Find the part you need with ease</li>
					<li><i class="fa fa-check primary-color"></i> Track your orders conveniently</li>
					<li><i class="fa fa-check primary-color"></i> Price match our inventory against others</li>
					<li><i class="fa fa-check primary-color"></i> Get the best deals on autoparts</li>
					<li><img src='/fixquick/PHP/assets/images/Solomon-Little-Fix-Quick-Logo-Red Transparent.png' class='img-responsive hide' /></li>
				</ul>
			  </p>
			</div>
		</div><!-- /.row -->
	</div><!-- /.container -->
</main><!-- /.authentication -->
<!-- ========================================= MAIN : END ========================================= -->