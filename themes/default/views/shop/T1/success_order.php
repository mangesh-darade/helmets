<!DOCTYPE html>
<html>
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
        <div class="outer-di">
            <div class="middle-di">
                <div class="inner-di">
                    <div class="col-sm-12">
                        <div class="col-md-6 col-md-offset-3">
                            <span class="ord"><i class="fa fa-check aria-hidden" ></i></span>
                            <div class="suc-ord">
                                <h2>Order Completed Successfully!</h2>
                                <p> Hello  <?php echo $sale['customer']?>,<br>
                                    your order has been placed successfully<br>
                                    Sales Reference Number : - <?php echo $sale['reference_no']?>
                                 </p>
                                <a class="hvr-pop btn btn-default add-to-cart suc-ord-btn" href="<?php echo site_url('shop/home');?>" > Back to shop </a>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div> 
		
    </body>
</html>