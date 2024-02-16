<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>POS e-shop</title>
        <link href="<?= $assets?>T1/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= $assets?>T1/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?= $assets?>T1/css/animate.css" rel="stylesheet">
        <link href="<?= $assets?>T1/css/main.css" rel="stylesheet">
        <link href="<?= $assets?>T1/css/responsive.css" rel="stylesheet">	
        <link href="<?= $assets?>T1/css/hover.css" rel="stylesheet" media="all">
    </head><!--/head-->
    <body>   
        
        <header id="header"><!--header--> 
            <div class="header-middle"><!--header-middle-->
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4 logo-div" >
                            <div class="logo pull-left">
                                <span class="logo1" ><a href="<?= $baseurl;?>/shop/"><img src="<?= $baseurl;?>assets/uploads/logos/<?= $this->Settings->logo?>" alt="Logo" class="img-responsivee" /></a></span><br/>
                            </div>
                        </div>
                        <div class="col-sm-8 account-menu">
                            <div class="shop-menu pull-right">
                                <ul class="nav navbar-nav">                                   
                                    <li class="item">
                                        <a class="" href="/cart">
                                            <i class="fa-shopping-cart fa"></i>Cart</a>
                                        <span class="cart-count">0</span>
                                    </li>
                                    <li>
                                     <a href="<?=base_url('shop/logout');?>" class="btn btn-link btn-md"><i class="fa-lock fa"></i>Logout</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div><!--/header-middle-->
             
        </header><!--/header-->
        
        <section class="middle_section"><!--Middle section view-->
            <div class="container">
                <div class="row">                    
<div class="container wrapper login-page">
    <div class="login-bg"></div>
    <div class="col-md-4 col-md-offset-4  col-xs-12">
    	<p><span class="login-logo1" ><img src="<?= $baseurl;?>assets/uploads/logos/<?= $this->Settings->logo?>" alt="Logo" class="img-responsivee" /></span></p>
        <input type="hidden" id="baseurl" value="<?= $baseurl;?>" />
        <div class="login-form"><!--login form-->
            <h2>Login to your account</h2>            
            <p class="text-danger bg-danger"><?php echo $login_error; ?></p>
            <?php
            if($resend_verification_link === TRUE)
            {   
            ?>                             
            <p class="text-center"><a href="<?=base_url("shop/resend_verification_link/$customer_id")?>">Resend Email Verification Link</a></p>
            <?php
            }
            ?>
            <?php echo form_open('shop/login');?>
            <input type="text" id="login_id" name="login_id" required="required" class="form-control" maxlength="30" placeholder="Email/Phone number" />
            <input type="password" id="login_passkey" required="required" name="login_passkey" autocomplete="new_password" maxlength="30" class="form-control" placeholder="Password" />
                <span>
                    <input type="checkbox" class="checkbox" /> 
                    Keep me signed in
                </span>
            <button type="submit" name="btn_submit" value="Authentication" class="btn btn-lg">Login</button><br/>
               <!-- <a href="https://signup.simplypos.co.in/?merchant=#!/login">Forgot Password</a> -->
			   <a href="<?=base_url('shop/forgot_password')?>">Forgot Password</a>
                <?php echo form_close();?>
                <div>
             
              <!--  <div class="sign-up"><a href="https://signup.simplypos.co.in?merchant=<?= $phone;?>" class="btn btn-lg" ng-model="custdata.submit" >New User Signup! </a></div> -->
                 <div class="sign-up"><a href="<?= base_url('shop/signup');?>" class="btn btn-lg" >New User Signup! </a></div> 
                    
                </div> 
            </div>
        </div><!--/login form-->
    </div>
</div>
        </div>
    </div>
</section><!--/Middle section view -->
<script src="<?= $assets?>T1/js/jquery.js"></script>
<script src="<?= $assets?>T1/js/bootstrap.min.js"></script>

    </body>
</html>