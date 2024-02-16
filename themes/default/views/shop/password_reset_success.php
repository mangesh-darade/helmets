<!DOCTYPE html>
<html>
    <title>Password Reset Success</title>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">        
        <link href="<?= $assets?>T1/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= $assets?>T1/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?= $assets?>T1/css/main.css" rel="stylesheet">
        <link href="<?= $assets?>T1/css/responsive.css" rel="stylesheet">	
        
    </head><!--/head-->
    <body style="background: rgba(0, 0, 0, 0.5) none repeat scroll 0 0;min-height: 100%;position: relative; padding: 0;">
        <div class="outer-di">
            <div class="middle-di">
                <div class="inner-di">
                    <div class="col-sm-12">
                        <div class="col-md-6 col-md-offset-3">
                            <span class="ord"><i class="fa fa-check aria-hidden" ></i></span>
                            <div class="suc-ord">
                                <h2>Congratulations! Password reset Successfully!</h2>
                                <p> Dear User,<br>
                                    Your account password has been reset successfully.<br>
                                    Please access your account with new password.
                                </p><br/>
                                <p class="text-center"><a href="<?=base_url('shop/login')?>" class="btn btn-success" >Shop login</a></p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div> 	
		
    </body>
</html>