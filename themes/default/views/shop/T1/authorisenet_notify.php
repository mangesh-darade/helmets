<!DOCTYPE html>
<html ng-app="myApp" lang="en" style="background: rgba(0, 0, 0, 0.5) none repeat scroll 0 0;min-height: 100%;position: relative;">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Order Confirmation</title>
        <link href="<?= $assets?>T1/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= $assets?>T1/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?= $assets?>T1/css/main.css" rel="stylesheet">
        <link href="<?= $assets?>T1/css/responsive.css" rel="stylesheet">
    </head><!--/head-->
    <body style="padding:0;">
        <div class="outer-di">
            <div class="middle-di">
                <div class="inner-di">
                    <div class="col-sm-12">
                        <div class="col-md-6 col-md-offset-3">
                            <?php  if($order_info['sale_status']=='completed') {  ?>
                                <span class="ord"><i class="fa fa-check"  ></i></span>
                                <div class="suc-ord">
                                    <h2>Order has been placed successfully!</h2>
                                    <p> Hello  <?php echo $order_info['customer']?>,<br>
                                        your order has been placed successfully<br>
                                        Sales Reference Number :- <?php echo $order_info['reference_no']?><br/>
                                        <?php echo '<pre>'; 
                                        print_r($order_info); 
                                        echo '</pre>';
                                        
                                        if($order_info['payment_status']=='paid') { ?>
                                        Payment Status :- Success <br/>
                                        Transaction Id :- <?= $transaction_id?>
                                        
                                        <?php } else { ?>
                                        Payment Status :- Failed <br/>
                                        <?php } ?>
                                     </p>
                                    <a class="hvr-pop btn btn-default add-to-cart suc-ord-btn" href="<?php echo site_url('shop/home');?>" > Back to shop </a>
                                </div>
                                <div class="clearfix"></div>
                            <?php } else { ?>
                                <span class="ord declined"><i class="fa fa-warning" ></i></span>
                                <div class="suc-ord declined">
                                    <h2>Order has not been placed successfully!</h2>
                                    <p>  Sorry , your order  has  not been placed successfully!</p>
                                    <a class="btn btn-danger" style="border-radius:0;" href="<?php echo site_url('shop/home');?>" > Back to shop </a>
                                </div>
                                <div class="clearfix"></div>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div> 
		
    </body>
</html>