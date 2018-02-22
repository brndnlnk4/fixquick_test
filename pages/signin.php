<section class='center-block row'> 
		<div class="col-sm-12 col-lg-10 center-block " align='center'>
			<section class="section sign-in">
				<h2 class="bordered">Sign In</h2>
				<p class='lead'>Hello, Sign-in to your account</p>

<!------------------------------------------
	facebook and twitter autologin api btn
------------------------------------------>
				<div class="social-auth-buttons center-block">
					<div class="row">
						<div class="col-md-6">
							<button class="btn-block btn-lg btn btn-facebook"><i class="fa fa-facebook"></i> Sign In with Facebook</button>
						</div>
						<div class="col-md-6">
							<button class="btn-block btn-lg btn btn-twitter"><i class="fa fa-twitter"></i> Sign In with Twitter</button>
						</div>
					</div>
				</div>

<!--------------------------------------
	login and password fields
------------------------------------------>
			<form role="form" class="cd-form login-form cf-style-1" action='../PHP/ses.php' method='POST' autocomplete="off" >
				<p class="field-row">
					<span class='label_icon fa fa-user fa-lg'></span>
 					<input class="full-width has-padding has-border" tabindex="1" value='' name='usr_email' id="signin-username" type="email" placeholder="Enter Email Address" minlength='3' autofocus required>
					<span class="cd-error-message"></span>
				</p>

				<p class="field-row">
					<span class='label_icon fa fa-lock fa-lg'></span>
 					<input class="full-width has-padding has-border" tabindex="2" value='' name='usr_pw' id="signin-password" type="password"  placeholder="Enter Password" minlength='3' required>
					<a href="#" class="hide-password"></a>
					<span class="cd-error-message"></span>
				</p>

				<p class="field-row">
					<input class="full-width btn-primary btn-lg" tabindex="3" name="userLoginProcess" type="submit" value="Login">
				</p>
			</form>
			
			</section><!-- /.sign-in -->
		</div><!-- /.col -->	
	</div>
  </main>
</section>