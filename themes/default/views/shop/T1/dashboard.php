<?php include_once 'header.php';?>

<section class="middle_section"><!--Middle section view-->
    <div class="container">
        <div class="col-sm-12" >
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="<?php echo site_url('shop/home');?>">Home</a></li>
                    <li class="active">Dashboard</li>
                </ol>
            </div>
             
            <div class="account-tab">
                <ul class="nav nav-tabs col-sm-3">
                    <li class="active"><a href="#">Dashboard</a></li>
                    <li><a href="<?php echo site_url('shop/myorders');?>">My Orders</a></li>             
                    <li><a href="<?php echo site_url('shop/billing_shipping');?>">Billing & Shipping</a></li>
                    <li><a href="<?php echo site_url('shop/change_password');?>">Profile</a></li>
                    <li><a href="<?php echo site_url('shop/home');?>">Products</a></li>
                </ul>

                <div class="tab-content col-sm-9">
                    <div id="home" class="tab-pane fade in active">
                        <div class="col-sm-12 text-address">
                            <p>Hello <?php $_SESSION['name']; ?>,</p>

                            <p>From your account dashboard you can view your recent orders, manage your shipping and billing addresses and edit your password and account details.</p>
                            <div class="form-outer acc-page" >
                                <div class="cart-heading">
                                    <h4>Recent Orders</h4>
                                    <div class="clearfix"></div>
                                </div>

                                <div class="table-responsive" id="my_order">

                                    <table class="table table-condensed">
                                        <thead>
                                            <tr class="cart_menu">
                                                <td>Order Number</td>
                                                <td>Order Date</td>
                                                <td>Payment Status</td>
                                                <td>Payment Number</td>
                                                <td>Delivery Status</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                        if(is_array($myorder)){
                                            foreach ($myorder as $key => $order) {
                                        ?>        
                                            <tr>
                                                <td class="orders_link" >
                                                    <button  onClick="orderdetails(<?= $order->order_id?>)" class="btn-default"  data-toggle="modal" data-target="#myModal" ><?= $order->order_no?></button>
                                                </td>
                                                <td>
                                                    <p><?= $order->order_date?></p>
                                                </td>
                                                <td class="msg msg_<?= $order->payment_status?>">
                                                    <p><?= $order->payment_status?></p>
                                                </td>
                                                <td>
                                                    <p class="cart_total_price"><?= $order->payment_no?></p>
                                                </td>
                                                <td>
                                                    <p><?= $order->delivery_status?></p>
                                                </td>
                                            </tr>    
                                        <?php        
                                            }//end foreach.                                            
                                        }//end if.
                                        ?> 
                                        </tbody>
                                    </table>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Modal -->
        <div id="myModal" class="modal modal-lg fade " role="dialog">
            <div class="modal-dialog modal-lg" style="width:65%;">
                <div class="modal-content" id="model_order_details">
                    <div class="modal-header alert alert-default">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <div class='overlay'><h1 class="modal-title"><i class='fa fa-refresh fa-spin'></i> Please Wait! Data is loading...</h1></div>
                    </div>
                </div>                
            </div>
        </div>
    </div>             
</section><!--/Middle section view-->
    
<?php include_once 'footer.php';?>

<script>

function orderdetails(transaction_key){ 
     
    order_details(transaction_key, '<?= $user_id?>', '<?php echo rtrim($baseurl, '/');?>' ); 
    
}

</script>
 