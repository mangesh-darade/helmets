<?php include('header.php'); ?>
<style>
@media screen and (max-width: 767px){
div.dataTables_wrapper div.dataTables_length, div.dataTables_wrapper div.dataTables_filter, div.dataTables_wrapper div.dataTables_info, div.dataTables_wrapper div.dataTables_paginate {margin: 5px;}
div.dataTables_wrapper div.dataTables_length select {
    width: 50%;
    display: inline-block;
    margin-left: 3%;
}
.checkout-right {
    margin-top: 1em;
}
.logo_products {
    padding: 1em 0 0em;
}
.navbar-toggle {
    float: none;
    margin: 0.55em 8px;}
.vertical_post form input[type="submit"] {width:65%;}
.products-breadcrumb ul li i {
    padding-right: 5px;}
.products-breadcrumb ul li span {
    padding: 0 0em;
}
}
</style>
<!-- Modal -->
<div id="myModal" class="modal modal-md fade " role="dialog">
    <div class="modal-dialog modal-md">
        <div class="modal-content" id="model_order_details">
            <div class="modal-header alert alert-default">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <div class='overlay'><h1 class="modal-title"><i class='fa fa-refresh fa-spin'></i> Please Wait! Data is loading...</h1></div>
            </div>
        </div>                
    </div>
</div>
<div class="banner">
        
        <!-- payment -->
        <div class="privacy about">
            
            <div class="checkout-right col-lg-8 col-md-10 col-sm-12 col-xs-12 col-lg-offset-2 col-md-offset-1">
                <?php
                    if(!empty($msg))
                    {
                        echo '<div class="alert alert-success alert-msg" >'.$msg.'</div>';
                    }
                    if(!empty($error))
                    {
                        echo '<div class="alert alert-danger alert-msg">'.$error.'</div>';
                    }
                ?>
                <!--Horizontal Tab-->
                <div id="parentHorizontalTab">
                    <ul class="resp-tabs-list hor_1">
                        <li>Profile</li>
                        <li>Orders</li>
                        <li>Address</li>
                        <li>Password</li>
                    </ul>
                    <div class="resp-tabs-container hor_1">                        
                        <div>                           
                            <div class="vertical_post check_box_agile tab-grid">
                                <?php
                                $hidden = ['customer_id'=>$customer['id'], 'action'=>"update_customer"];
                                $attributes = ['class'=>"cc-form"];
                                echo form_open('shop/myaccount', $attributes, $hidden);
                                ?>
                                 <div class="row">
                                    <div class="col-md-6">
                                       <div class="clearfix">
                                            <div class="form-group">
                                                <label><i class="text-danger">*</i> Full Name</label>
                                                <input class="form-control" name="name" placeholder="Full Name" required="required" value="<?=$customer['name']?>" type="text" maxlength="60" />
                                            </div>
                                            <div class="form-group">
                                                <label> Business Name</label>
                                                <input class="form-control" name="company" placeholder="Business Name" value="<?=$customer['company']?>" type="text" maxlength="100" />
                                            </div>
                                            <div class="form-group">
                                                <label><i class="text-danger">*</i> Address</label>
                                                <input class="form-control" name="address" placeholder="Address" required="required" value="<?=$customer['address']?>" type="text" maxlength="255" />
                                            </div>                                            
                                        </div>
                                        <div class="clearfix">
                                            <div class="form-group">
                                                <label><i class="text-danger">*</i> City</label>
                                                <input class="form-control" name="city" placeholder="City Name" required="required" value="<?=$customer['city']?>" type="text" maxlength="30" />
                                            </div>
                                            <div class="form-group">
                                                <label><i class="text-danger">*</i> State</label>
                                                <input class="form-control" name="state" placeholder="State Name" required="required" value="<?=$customer['state']?>" type="text" maxlength="30" />
                                            </div>                                            
                                        </div>                                        
                                    </div>
                                    <div class="col-md-6">                                        
                                        <div class="clearfix">
                                            <div class="form-group">
                                                <label><i class="text-danger">*</i> Mobile Number</label>
                                                <input class="form-control" value="<?=$customer['phone']?>" disabled="disabled" type="text" maxlength="10" />
                                            </div>
                                            <div class="form-group">
                                                <label><i class="text-danger">*</i> Email Id</label>
                                                <input class="form-control" name="email" placeholder="Email Id" type="email" value="<?=$customer['email']?>" required="required" maxlength="40">
                                            </div>
                                           <?php
                                            if($currency == 'INR') {
                                           ?>
                                            <div class="form-group">
                                                <label> GST Number </label>
                                                <input class="form-control" name="gstn_no" placeholder="GST Number" type="text" value="<?=$customer['gstn_no']?>" maxlength="20">
                                            </div> 
                                            <?php } else { ?>
                                            <div class="form-group">
                                                <label> Tax Registration Number</label>
                                                <input class="form-control" name="vat_no" placeholder="VAT Number" type="text" value="<?=$customer['vat_no']?>" maxlength="20">
                                            </div> 
                                            <?php } ?>
                                        </div>
                                        <div class="clearfix">
                                            <div class="form-group">
                                                <label><i class="text-danger">*</i> Country</label>
                                                <input class="form-control" name="country" placeholder="Country" value="<?=$customer['country']?>" required="required" type="text" maxlength="30" />
                                            </div>
                                            <div class="form-group">
                                                <label><i class="text-danger">*</i> Zip Code</label>
                                                <input class="form-control" name="postal_code" placeholder="Zip Code" value="<?=$customer['postal_code']?>" required="required" type="text" maxlength="6" />
                                            </div>                                            
                                        </div>
                                       
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="form-group text-center">
                                        <input class="btn btn-primary submit" type="submit" class="submit" value="Update Profile" />   
                                    </div>                                            
                                </div>
                               <?= form_close()?>
                            </div>
                        </div>
                        <div>
                             <div class="row">                                
                                <!-- /.box-header -->
                                <div class="box-body">
                                    <div class="table-responsive">
                                  <table id="datatable_order" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                          <th>Order Reference / Date</th>
                                          <th>Payment Status</th>
                                          <th>Payment Ref.</th>
                                          <th>Delivery Status</th>
                                          <th>Order Status</th>
                                          <th>&nbsp;</th>
                                          <th>Receipt</th>
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
                                    <tfoot>
                                    <tr>
                                      <th>Order Reference / Date</th>
                                      <th>Payment Status</th>
                                      <th>Payment Ref.</th>
                                      <th>Delivery Status</th>
                                      <th>Order Status</th>
                                      <th>&nbsp;</th>
                                      <th>Receipt</th>
                                    </tr>
                                    </tfoot>
                                  </table>
                                </div>
                                
                                </div>
                                <!-- /.box-body -->
                              </div>
                        </div>
                        <div>
                            <div class="vertical_post">
                            <?php
                                $hidden = ['customer_id'=>$customer['id'], 'action'=>"update_addresses"];
                                $attributes = ['class'=>"cc-form"];
                                echo form_open('shop/myaccount', $attributes, $hidden);
                            ?>    
                                <div class="row">                        
                                    <div class="col-md-6  col-xs-12">                        
                                    <div class="clearfix">
                                        <div class="form-group">
                                            <label><span class="text-danger">*</span> Billing Name</label>
                                            <input class="form-control billing_input" name="billing_name" id="billing_name" value="<?= ($billing_shipping['billing_name']) ? $billing_shipping['billing_name'] :''?>" required="required" placeholder="Billing Name" maxlength="50" type="text" />
                                        </div>                                
                                        <div class="form-group">
                                            <label><span class="text-danger">*</span> Billing Contact</label>
                                            <input class="form-control billing_input" name="billing_phone" id="billing_phone" value="<?= ($billing_shipping['billing_phone']) ? $billing_shipping['billing_phone'] :''?>"  required="required" placeholder="Mobile Number" maxlength="10" type="text" />
                                        </div>
                                        <div class="form-group">                                    
                                            <input class="form-control billing_input" name="billing_email" id="billing_email" value="<?= ($billing_shipping['billing_email']) ? $billing_shipping['billing_email'] :''?>"  placeholder="Email Address" maxlength="50" type="email" />
                                        </div>
                                        <div class="form-group">
                                            <label><span class="text-danger">*</span> Address Line 1</label>
                                            <input class="form-control billing_input" name="billing_addr1" id="billing_addr1" value="<?= ($billing_shipping['billing_addr1']) ? $billing_shipping['billing_addr1'] :''?>"  required="required" placeholder="Billing Address Line 1" maxlength="250" type="text" />
                                        </div>
                                        <div class="form-group">
                                            <label> Address Line 2</label>
                                            <input class="form-control billing_input" name="billing_addr2" id="billing_addr2" value="<?= ($billing_shipping['billing_addr2']) ? $billing_shipping['billing_addr2'] :''?>" placeholder="Billing Address Line 2" maxlength="250" type="text" />
                                        </div>
                                        <div class="form-group">                                    
                                            <input class="form-control billing_input" name="billing_city" id="billing_city" value="<?= ($billing_shipping['billing_city']) ? $billing_shipping['billing_city'] :''?>"  required="required" placeholder="City" maxlength="50" type="text" />
                                        </div>
                                        <div class="form-group">                                    
                                            <input class="form-control billing_input" name="billing_state" id="billing_state" value="<?= ($billing_shipping['billing_state']) ? $billing_shipping['billing_state'] :''?>"  required="required" placeholder="State" maxlength="50" type="text" />
                                        </div>
                                        <div class="form-group">                                    
                                            <input class="form-control billing_input" name="billing_country" id="billing_country" value="<?= ($billing_shipping['billing_country']) ? $billing_shipping['billing_country'] :''?>"  required="required" placeholder="Country" value="US" maxlength="50" type="text" />
                                        </div>
                                        <div class="form-group">                                    
                                            <input class="form-control billing_input" name="billing_zipcode" id="billing_zipcode" value="<?= ($billing_shipping['billing_zipcode']) ? $billing_shipping['billing_zipcode'] :''?>"  required="required" placeholder="Zipcode" maxlength="6" type="text" />
                                        </div>
                                    </div>                                                             
                                </div>                       
                                    <div class="col-md-6 col-xs-12">
                                        <div class="clearfix">
                                            <div class="form-group">
                                                <label><span class="text-danger">*</span> Shipping Name</label>
                                                <input class="form-control shipping_input" name="shipping_name" id="shipping_name" value="<?= ($billing_shipping['shipping_name']) ? $billing_shipping['shipping_name'] :''?>"  required="required" placeholder="Shipping Name" maxlength="60" type="text" />
                                            </div>                                
                                            <div class="form-group">
                                                <label><span class="text-danger">*</span> Shipping Contact</label>
                                                <input class="form-control shipping_input" name="shipping_phone" id="shipping_phone" value="<?= ($billing_shipping['shipping_phone']) ? $billing_shipping['shipping_phone'] :''?>"  required="required" placeholder="Mobile Number" maxlength="10" type="text" />
                                            </div>
                                            <div class="form-group">                                    
                                                <input class="form-control shipping_input" name="shipping_email" id="shipping_email" value="<?= ($billing_shipping['shipping_email']) ? $billing_shipping['shipping_email'] :''?>"  placeholder="Email Address" maxlength="50" type="email" />
                                            </div>
                                            <div class="form-group">
                                                <label><span class="text-danger">*</span> Shipping Address Line 1</label>
                                                <input class="form-control shipping_input" name="shipping_addr1" id="shipping_addr1" value="<?= ($billing_shipping['shipping_addr1']) ? $billing_shipping['shipping_addr1'] :''?>"  required="required" placeholder="Shipping Address Line 1" maxlength="250" type="text" />
                                            </div>
                                            <div class="form-group">
                                                <label> Shipping Address Line 2</label>
                                                <input class="form-control shipping_input" name="shipping_addr2" id="shipping_addr2" value="<?= ($billing_shipping['shipping_addr2']) ? $billing_shipping['shipping_addr2'] :''?>"  placeholder="Shipping Address Line 2" maxlength="250" type="text" />
                                            </div>
                                            <div class="form-group">                                    
                                                <input class="form-control shipping_input" name="shipping_city" id="shipping_city" value="<?= ($billing_shipping['shipping_city']) ? $billing_shipping['shipping_city'] :''?>"  required="required" placeholder="City" maxlength="50" type="text" />
                                            </div>
                                            <div class="form-group">                                    
                                                <input class="form-control shipping_input" name="shipping_state" id="shipping_state" value="<?= ($billing_shipping['shipping_state']) ? $billing_shipping['shipping_state'] :''?>"  required="required" placeholder="State" maxlength="50" type="text" />
                                            </div>
                                            <div class="form-group">                                    
                                                <input class="form-control shipping_input" name="shipping_country" id="shipping_country" value="<?= ($billing_shipping['shipping_country']) ? $billing_shipping['shipping_country'] :''?>"  required="required" placeholder="Country" value="US" maxlength="50" type="text" />
                                            </div>
                                            <div class="form-group">                                    
                                                <input class="form-control shipping_input" name="shipping_zipcode" id="shipping_zipcode" value="<?= ($billing_shipping['shipping_zipcode']) ? $billing_shipping['shipping_zipcode'] :''?>"  required="required" placeholder="Zipcode" maxlength="6" type="text" />
                                            </div>                                 
                                        </div>
                                         
                                    </div> 
                                    <div class="clearfix"></div>
                                </div>
                                <div class="row">
                                    <div class="form-group text-center">
                                        <input class="btn btn-primary submit" type="submit" class="submit" value="Save Address" />   
                                    </div>                                            
                                </div>
                            <?= form_close()?>
                            </div>
                        </div>
                        <div>
                            <div id="tab4" class="tab-grid" style="display: block;">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="text-center"><img src="<?= $assets . $shoptheme ?>/images/change_password.jpg" class="img-responsive" alt="change password" /></div>
                                    </div>
                                    <div class="col-md-6">
                                        <?php $input_hidden = array('user_id' => $user_id, 'action'=>'change_password'); ?>
                                        <?php echo form_open('shop/myaccount#parentHorizontalTab4', ['name'=>'frm_address'],$input_hidden); ?>
                                            <div class="clearfix">
                                                <div class="form-group">
                                                    <label><span class="text-danger">*</span> Current Password</label>
                                                    <input class="form-control" name="password" required="required" placeholder="Current Password" type="password" />
                                                </div>
                                                <div class="form-group">
                                                    <label><span class="text-danger">*</span> New Password</label>
                                                    <input class="form-control" name="new_password" required="required" placeholder="New Password" type="password" />
                                                </div>
                                                <div class="form-group">
                                                    <label><span class="text-danger">*</span> Confirm New Password</label>
                                                    <input class="form-control" name="confirm_password" required="required" placeholder="Confirm Password" type="password" />
                                                </div>
                                            </div>                                            
                                            <input class="btn btn-primary submit" type="submit" class="submit" value="Change Password" />
                                       <?php echo form_close();?>
                                    </div>
                                </div>

                            </div>
                        </div>

                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        </div>
        <!-- //payment -->
      
    <div class="clearfix"></div>
</div>

<!-- //banner -->
<?php include('footer.php'); ?>

<!-- easy-responsive-tabs -->    
<link rel="stylesheet" type="text/css" href="<?= $assets . $shoptheme ?>/css/easy-responsive-tabs.css " />
<script src="<?= $assets . $shoptheme ?>/js/easyResponsiveTabs.js"></script>
<!-- //easy-responsive-tabs --> 
<script type="text/javascript">
    $(document).ready(function () {
        //Horizontal Tab
        $('#parentHorizontalTab').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            tabidentify: 'hor_1', // The tab groups identifier
            activate: function (event) { // Callback function if tab is switched
                var $tab = $(this);
                var $info = $('#nested-tabInfo');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });
    });
</script>
<!-- DataTables -->
<script src="<?= $assets ?>bs-assets/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="<?= $assets ?>bs-assets/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script>
  $(function () {
     
    $('.resp-tabs-list li').on('click', function(){        
        $('.alert-msg').hide();
    }); 
     
    $('#datatable_order').DataTable({
      'paging'      : true,
      'lengthChange': true,
      'searching'   : true,
      'ordering'    : false,
      'info'        : true,
      'autoWidth'   : true
    })
  })
  
  function confirmCancleOrder(orderno){
    
    if(!confirm('Are you sure to cancle the order? Order reff no: '+orderno)){
        return false;
    }
    
    return true;
}

function orderdetails(transaction_key){ 
     
    order_details(transaction_key, '<?= $user_id?>', '<?php echo rtrim($baseurl, '/');?>' ); 
    
}


function order_details(transaction_key, user_id, baseurl){
            
    var postData = 'transaction_key=' + transaction_key  + '&user_id=' + user_id;
    var url = baseurl + '/shop/orderDetails';
     
    $.ajax({
            type: 'get',
            url: url,
            data: postData,
            headers : {'Content-Type': 'application/x-www-form-urlencoded'},
            beforeSend: function(){ 
                var alert = '<div class="modal-header alert alert-info"><button type="button" class="close" data-dismiss="modal">&times;</button><div class="overlay"><h1 class="modal-title"><i class="fa fa-refresh fa-spin"></i> Please Wait! Data is loading...</h1></div></div>';
                $("#model_order_details").html(alert);                    
            },
            success: function(data){
                $("#model_order_details").html(data);
            },
            error: function(errormsg){
                console.log(errormsg);
            }
	});
            
}

</script>