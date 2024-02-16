<?php include('header.php'); ?>
<!-- banner -->
<div class="banner">
     
    <div class="col-md-8 col-md-offset-2 col-xs-12">
        <!-- payment -->
        <div class="privacy about">
            <h3>COD <span>Invoice</span></h3>
            <br/>
            <?php
            if($order_status == 'SUCCESS') {
            ?>
            <div class="alert alert-success"><h4 class="text-center text-success">Dear <?=$order_info['customer']?>! <br/>Your order has been place successfully.</h4></div>
                <h4 class="text-center">Order Reference : <?=$order_info['reference_no']?></h4>
                <br/>
                <div class="text-center"><a href="<?= base_url('shop/myaccount#parentHorizontalTab2')?>" class="btn btn-success btn-md">View Order</a></div>
            <?php } else { ?>
                 <div class="alert alert-danger"><h4 class="text-center text-danger">Order has been failed. Please continue with cart.</h4></div>
                 <a href="<?= base_url('shop/home')?>" class="btn btn-primary btn-lg submit" class="submit">View Order</a>
            <?php } ?>            
        </div>
        <!-- //payment -->
    </div>
    <div class="clearfix"></div>
</div>
<!-- //banner -->

<?php include('footer.php'); ?>
