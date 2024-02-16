<?php include_once 'header.php';?>
 
<section class="middle_section"><!--Middle section view-->
    <div class="container">
        <div class="row" >
            <div class="col-sm-3">
                <div class="breadcrumbs">
                    <ol class="breadcrumb">
                        <li><a href="<?php echo site_url('shop/home');?>">Home</a></li>
                        <li class="active">My Orders</li>
                    </ol>
                </div>
            </div>
            <div class="col-sm-9">
                <?php
                    if($_GET['act']=="success") {
                        echo '<div class="alert alert-success">Your request to cancle order has been complited.</div>';
                    }
                    elseif($_GET['act']=="fail") {
                        echo '<div class="alert alert-danger">Your request to cancle order has been failed.</div>';
                    }
                    elseif($_GET['act']=="invalid") {
                        echo '<div class="alert alert-danger">Your request to cancle order is not valid.</div>';
                    }
                ?>
            </div>
        </div>
        <div class="row" >
            <div class="account-tab">
                <ul class="nav nav-tabs col-sm-3">
                    <li><a href="<?php echo site_url('shop/my_account');?>">Dashboard</a></li>
                    <li class="active"><a href="#">My Orders</a></li>             
                    <li><a href="<?php echo site_url('shop/billing_shipping');?>">Billing & Shipping</a></li>
                    <li><a href="<?php echo site_url('shop/change_password');?>">Profile</a></li>
                    <li><a href="<?php echo site_url('shop/home');?>">Products</a></li>
                </ul>

                <div class="tab-content col-sm-9"> 
                    <div class="order-list"  >
                        <div class="table-responsive cart_info">
                              <table class="table table-condensed">
                                        <thead>
                                            <tr class="cart_menu">
                                                <td>Order Reference / Date</td>
                                                <td>Payment Status</td>
                                                <td>Payment Reff.</td>
                                                <td>Delivery Status</td>
                                                <td colspan="2">Order Status</td>
                                                <td>Recept</td>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        <?php
                                                                               
                                        if(is_array($myorder)){
                                            foreach ($myorder as $key => $order) {
                                        ?>        
                                            <tr>
                                                <td class="orders_link" >
                                                    <i class="text-info"> <?= $order->order_no?></i>
                                                 
                                                    <p class="text-center"><?= $order->order_date?></p>
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
                                                
                                                <?php
                                                    
                                                    $cancleIcon = '';
                                                    if($order->sale_status == 'cancle') { $salestatus = '<span class="pull-left text-danger">Canceled</span>'; }
                                                 
                                                    elseif(empty($order->delivery_status) && empty($order->payment_no) && $order->sale_status == 'pending'){  
                                                       $salestatus = '<span class="pull-left text-primary">Pending</span>';
                                                       $cancleIcon = '<span class="pull-right"><a title="Cancele Order" onclick="return confirmCancleOrder(\''.$order->order_no.'\');" href="'. base_url('shop/cancle_order?oref='.$order->order_id).'" class="text-danger"><i class="fa fa-close"></i></a></span>';
                                                    }                                                    
                                                    elseif($order->sale_status == 'completed' || empty($order->delivery_status) || empty($order->payment_no) ) 
                                                    {  
                                                        $salestatus = '<span class="pull-left text-success">Completed</span>';
                                                        $cancleIcon = '<i class="fa fa-check text-success"></i>';
                                                    } 
                                                ?>
                                                <td style="text-transform: capitalize;"><?php echo $salestatus;?></td>
                                                <td><?php echo $cancleIcon;?></td>
                                                <td><a href="#" onClick="orderdetails(<?= $order->order_id?>)" class="btn-default"  data-toggle="modal" data-target="#myModal" ><i class="fa fa-file"></i></a></td>
                                            </tr>    
                                        <?php        
                                            }//end foreach.                                            
                                        }//end if.
                                        ?> 
                                        </tbody>
                                    </table>
                        </div>
                        <br/>
                        <div class="clearfix"></div>
                         
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

function confirmCancleOrder(orderno){
    
    if(!confirm('Are you sure to cancle the order? Order reff no: '+orderno)){
        return false;
    }
    
    return true;
}

function orderdetails(transaction_key){ 
     
    order_details(transaction_key, '<?= $user_id?>', '<?php echo rtrim($baseurl, '/');?>' ); 
    
}

</script>