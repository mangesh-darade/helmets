<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>E-shop: Forgot Password</title>
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
                            <h2>Forgot Password</h2>            
                            <p class="text-danger bg-danger"><?php echo $login_error; ?></p>
                            
                            <?php echo form_open('shop/forgot_password');?>
                                <input type="text" id="login_id" name="login_id" required="required" class="form-control" maxlength="30" placeholder="Email Id / Mobile Number" />
                            
                                <button type="submit" name="btn_submit" value="forgotpasswd" class="btn btn-lg">Submit</button><br/>
                              
                                <?php echo form_close();?>
                                
                                <div class="row">                                    
                                    <div class="sign-in"><a href="<?= base_url('shop/login');?>" class="btn btn-lg" >Login! </a></div>
                              
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