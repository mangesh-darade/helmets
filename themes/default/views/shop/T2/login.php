<?php include_once 'header.php'; ?>
<!-- banner -->
<div class="banner">
    <!-- login -->
            <div class="w3_login">
                    <h3>Sign In & Sign Up</h3>
                    <div class="w3_login_module">
                            <div class="module form-module">
                              <div class="toggle"><i class="fa fa-times fa-pencil"></i> 
                                    <div class="tooltip">New User</div>
                              </div>
                              <div class="form">
                                    <h2>Login to your account</h2>
                                    <form action="#" method="post">
                                      <input type="text" name="Username" placeholder="Username" required=" ">
                                      <input type="password" name="Password" placeholder="Password" required=" ">
                                      <input type="submit" value="Login">
                                    </form>
                              </div>
                              <div class="form">
                                    <h2>Create an account</h2>
                                    <form action="#" method="post">
                                      <input type="text" name="Username" placeholder="Username" required=" ">
                                      <input type="password" name="Password" placeholder="Password" required=" ">
                                      <input type="email" name="Email" placeholder="Email Address" required=" ">
                                      <input type="text" name="Phone" placeholder="Phone Number" required=" ">
                                      <input type="submit" value="Register">
                                    </form>
                              </div>
                              <div class="cta"><a href="#">Forgot your password?</a></div>
                            </div>
                    </div>
                    <script>
                            $('.toggle').click(function(){
                              // Switches the Icon
                              $(this).children('i').toggleClass('fa-pencil');
                              // Switches the forms  
                              $('.form').animate({
                                    height: "toggle",
                                    'padding-top': 'toggle',
                                    'padding-bottom': 'toggle',
                                    opacity: "toggle"
                              }, "slow");
                            });
                    </script>
            </div>
    <!-- //login -->
    <div class="clearfix"></div>
</div>
<!-- //banner -->
<!-- newsletter-top-serv-btm -->
	<div class="newsletter-top-serv-btm">
		<div class="container">
			<div class="col-md-4 wthree_news_top_serv_btm_grid">
				<div class="wthree_news_top_serv_btm_grid_icon">
					<i class="fa fa-shopping-cart" aria-hidden="true"></i>
				</div>
				<h3>Nam libero tempore</h3>
				<p>Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus 
					saepe eveniet ut et voluptates repudiandae sint et.</p>
			</div>
			<div class="col-md-4 wthree_news_top_serv_btm_grid">
				<div class="wthree_news_top_serv_btm_grid_icon">
					<i class="fa fa-bar-chart" aria-hidden="true"></i>
				</div>
				<h3>officiis debitis aut rerum</h3>
				<p>Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus 
					saepe eveniet ut et voluptates repudiandae sint et.</p>
			</div>
			<div class="col-md-4 wthree_news_top_serv_btm_grid">
				<div class="wthree_news_top_serv_btm_grid_icon">
					<i class="fa fa-truck" aria-hidden="true"></i>
				</div>
				<h3>eveniet ut et voluptates</h3>
				<p>Temporibus autem quibusdam et aut officiis debitis aut rerum necessitatibus 
					saepe eveniet ut et voluptates repudiandae sint et.</p>
			</div>
			<div class="clearfix"> </div>
		</div>
	</div>
<!-- //newsletter-top-serv-btm -->

<?php include_once 'footer.php'; ?>