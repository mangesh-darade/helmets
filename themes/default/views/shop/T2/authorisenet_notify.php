<?php include('header.php'); ?>
<!-- banner -->
<div class="banner" style="padding:100px 0">
     
    <div class="col-md-6 col-md-offset-3">
        <?php  if($order_info['id']) {  ?>
             
            <div class="suc-ord">
                <div class="alert alert-success"><h2><i class="fa fa-check"  ></i> Order has been placed successfully!</h2></div>
                <div class=" alert alert-success"> Hello  <?php echo $order_info['customer']?>,<br>
                    your order has been placed successfully<br><br>
                    <b>Order Reference Number :</b> <?php echo $order_info['reference_no']?><br/>
                </div>
                <?php if($transaction_id != 'false' && $order_status == 'SUCCESS') { ?>
                <div class="alert alert-success">   
                    Payment Status : <?= $order_status?> <br/>                     
                    Transaction Id : <?= $transaction_id?>                    
                </div>
                <?php } else { ?>
                   <div class="alert alert-danger"> Payment Status : <?= $order_status?>
                   <br/> Payment Transaction : Failed
                   </div>
               <?php } ?>
            </div>
        <?php } else { ?>
            <div class="suc-ord declined">
                <div class="alert alert-danger"><h2><i class="fa fa-warning" ></i> Order has been failed!</h2></div> 
                <div class="alert alert-danger"> Payment Status : Failed </div>
            </div>
         <?php } ?>
        
            <div class="text-center" style="margin: 20px;">
                <a class="btn btn-danger" style="border-radius:0;" href="<?php echo site_url('shop/home');?>" > Back to shop </a> 
            </div> 
            <div class="clearfix"></div>
    </div>
    <div class="clearfix"></div>
</div>
<!-- //banner -->

<?php include('footer.php'); ?>
