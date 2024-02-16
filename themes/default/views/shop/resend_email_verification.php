<!DOCTYPE html>
<html>
    <title>Customer Add Success</title>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Home</title>
        <link href="<?= $assets?>T1/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= $assets?>T1/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?= $assets?>T1/css/main.css" rel="stylesheet">
        <link href="<?= $assets?>T1/css/responsive.css" rel="stylesheet">	
        
    </head><!--/head-->
    <body style="background: rgba(0, 0, 0, 0.5) none repeat scroll 0 0;min-height: 100%;position: relative; padding: 0;">
        <div class="outer-di" style="padding-top: 200px;">
            <div class="middle-di">
                <div class="inner-di">
                    <div class="col-sm-12">
                        <div class="col-md-6 col-md-offset-3">
                            <span class="ord"><i class="fa fa-check aria-hidden" ></i></span>
                            <div class="suc-ord">
                            <?php
                                if($action_status == TRUE) {
                            ?>
                                <h2>Congratulations! activation link has been sent successfully!</h2>
                                <p> Dear User,<br>
                                    Please check your mail inbox or spam folder for activate your account.
                                </p>
                                <?php } else { ?>
                                <h2 class="alert alert-danger">Sorry! Activation link mail sending failed!</h2>
                                    
                                <?php }?>
                                    <p class="text-center"><a href="<?=base_url('shop/login')?>" class="btn btn-primary" >E-Shop Home</a></p>
                            </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div> 
		
    </body>
</html>