<?php include('header.php'); ?>
<!-- banner -->
<div class="banner">
    <?php
     
    echo form_open('shop/payment' , $attributes, ['order_data'=>serialize($cart)]);     
    ?>
    <div class="w3l_banner_nav_left_col_8">
        <div class="privacy about">            
            <h3>Billing & <span>Shipping</span></h3>
            <div class="checkout-right">
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
                        <div class="checkbox checkbox-small">
                            <label>
                                <input class="i-check" name="shipping_billing_is_same" id="shipping_billing_is_same" value="1" type="checkbox" >Billing & Shipping Address is same</label>
                        </div>                        
                    </div>                       
                    <div class="col-md-6  col-xs-12">
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
                            <div class="checkbox checkbox-small">
                                <label><input class="i-check" name="save_info" type="checkbox" value="1">Save address for future reference</label>
                            </div>
                    </div> 
                    <div class="clearfix"></div>
                </div>
                <?php
                if($shopinfo['pos_type']=='pharma') {
            ?>            
            <div class="row">
                <div class="col-sm-12 clearfix bling-div">   
                    <div class="form-group">
                        <label>Prescription Details</label>
                    </div>
                    <div class="form-group">                                     
                        <div class="col-sm-6">
                            <label><span class="text-danger">*</span> Patient Name</label>
                            <input type="text" name="cf1" required="required" placeholder="Patient Name" class="form-control" />
                        </div>
                        <div class="col-sm-6">
                            <label>Doctor Name</label>
                            <input type="text" name="cf2" placeholder="Doctor Name" class="form-control" />
                        </div>
                        <div class="clearfix"></div>
                    </div>
                     
                </div>
            </div>
            <?php } ?>
            </div>
        </div> 
    </div>
    <div class="w3l_banner_nav_right_col_4">
        <!-- payment -->
        <div class="privacy about">
            <h3>Order <span>Review</span></h3>

            <div class="checkout-right">
                <div class="row">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Products</th>
                                <th>Qty</th>
                                <th>Rate</th>
                                <th>Tax</th>
                                <th>Total</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
//                        echo '<pre>';
//                        print_r($cart['items']);
                            foreach ($cart['items'] as $pid => $items) {
                        ?>
                            <tr>
                                <td><?= $items['name']?> <?php if($items['vname']){echo '<br/><sub>('.$items['vname'].')</sub>';} ?></td>
                                <td><?= $items['qty']?></td>
                                <td><?= $currency_symbol?>&nbsp;<?= number_format(str_replace(",","",$items['item_price']),2)?></td>
                                <td><?= $currency_symbol?>&nbsp;<?= number_format(str_replace(",","",$items['item_tax_total']),2)?></td>
                                <td><?= $currency_symbol?>&nbsp;<?= number_format(str_replace(",","",$items['item_price'] * $items['qty']),2)?></td>                                
                            </tr>
                            <?php } ?>    
                        </tbody>
                        <tfoot>
                            <tr>
                                <th colspan="5">
                                    <span class="pull-left">Items Subtotal</span>
                                    <span class="pull-right"><?= $currency_symbol?>&nbsp;<?= number_format(str_replace(",","",$cart['cart_sub_total']),2)?></span>
                                    <span class="clearfix"></span>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="5">
                                    <span class="pull-left">Tax Amount</span>
                                    <span class="pull-right"><?= $currency_symbol?>&nbsp;<?= number_format(str_replace(",","",$cart['cart_tax_total']),2)?></span>
                                    <span class="clearfix"></span>
                                </th>
                            </tr>
                            <tr>
                                <th colspan="5">
                                    <span class="pull-left">Total Order Amount</span>
                                    <span class="pull-right"><?= $currency_symbol?>&nbsp;<?= $grosstotal = number_format(str_replace(",","",($cart['cart_sub_total'] + $cart['cart_tax_total'])),2)?></span>
                                    <span class="clearfix"></span>
                                </th>
                            </tr>
                          <?php $ordert = array_values($cart['cart_order_tax']); if($ordert[0]>0){ ?>
                            <tr>
                                 <th colspan="5">
                                    <span class="pull-left">Order Tax</span>
                                    <span class="pull-center">&nbsp;(<?= $cart['order_tax_name'] ?>)</span>
                                    <span class="pull-right"><?= $currency_symbol?>&nbsp;<?= number_format(str_replace(",","",$cart['order_tax_total']),2);?></span>
                                    <span class="clearfix"></span>
                                </th>
                            </tr>
                          <?php } else{?>
                            <tr style="display:none;">
                                
                            </tr>
                            <?php } ?>
                            
                               <tr>
                                   <?php 
                                  
                                   $grosstotalnum = str_replace( ',', '', $grosstotal );
                                    if( is_numeric( $grosstotalnum ) ) {
                                       $grosstotal = $grosstotalnum;
                                    }
                                  
//                                   $ordert = array($eshop_order_tax['name']); 
//                                   $res = explode(" ", $ordert[0]);
//                                   // echo $res[0];
//                                    $gstnum = array($res[0]);
//                                    $gstnum1 = explode("%", $gstnum[0]);
//                                    $ordertax_cal =  $grosstotalnum + ($grosstotalnum*($gstnum1[0]/100));
                                  // echo  $ordertax_cal;
                                     ?>
                               
                                <th colspan="5">
                                    <span class="pull-left">Total Payable Amount</span>
                                    <span class="pull-right"><?= $currency_symbol?>&nbsp;<?= $grosstotal = number_format(str_replace(",","",$cart['cart_gross_total']),2)?></span>
                                    <span class="clearfix"></span>
                                </th>
                            </tr>
                            
                        </tfoot>
                    </table>
                </div>
                <!-- // Pay -->                
            </div>
            
            <div class="row">
                <div class="col-sm-12 clearfix bling-div">
                     
                        <div class="form-outer">
                            <div  class="form-group">
                                <label><span class="text-danger">*</span> Shipping Methods</label>
                            </div>
                        <?php
                        
                        if(is_array($shipping_methods)){
                          
                            foreach ($shipping_methods as $key => $shippings) {
                                if($shippings['code']=='home_delivery'){
                                
                                $shipingAmt = ($cart['cart_gross_total'] >= $shopinfo['eshop_free_delivery_on_order'] ) ? 0.00 : number_format($shippings['price'],2);
                         ?>
                            <div class="form-group">
                                <input type="radio" class="shippingType" name="shippingType" id="shippingType1" onChange="return getShippinMethodName('<?= $shippings['name']; ?>')" checked="checked" required="required" value="<?php echo $shippings['id'];?>" />
                                <span class="price"> <?php echo $shippings['name'];?> </span>
                                <span class="pull-right"><?= $currency_symbol?> <?=($cart['cart_gross_total'] >= $shopinfo['eshop_free_delivery_on_order'] ) ? '0.00 <del class="text-danger"> Rs.'.number_format($shippings['price'],2).'</del>' : number_format($shippings['price'],2);?> </span>
                                <input type="hidden" id="<?php echo 'shipping_price_'. $shippings['id'];?>" value="<?=$shipingAmt?>" />
                               
                               
                            </div>   
                         <?php } else {
                        ?>
                            <div class="form-group">
                                <input type="radio" class="shippingType" name="shippingType" id="shippingType2" required="required" value="<?php echo $shippings['id'];?>" />
                                <span class="price"> <?php echo $shippings['name'];?> </span>
                                <span class="pull-right"><?= $currency_symbol?> <?php echo number_format($shippings['price'],2);?> </span>
                                <input type="hidden" id="<?php echo 'shipping_price_'. $shippings['id'];?>" value="<?=$shippings['price']?>" />
                                
                            </div>
                                <?php } } ?><input type="hidden" name="shippingTypeName" id='shippingTypeName' value="<?= $shippings['name'];?>" /> <?php } ?> 
                            <div class="clearfix"></div>                                   
                        </div>
                     
                </div>                            
            </div>
            
            <div class="row">
                <h2>Total Billing Amount: <?= $currency_symbol?>&nbsp;<span id="billing_amt"><?php echo (number_format($shipingAmt + (str_replace(",","",$cart['cart_gross_total'])),2));?></span></h2>
            </div>
            <div style="padding: 20px; text-align: center;">
                <a href="<?= base_url('shop/cart')?>" class="btn btn-md btn-primary submit">Back To Cart</a>
                <input class="btn btn-md btn-primary submit" onClick="return changevalue();" name="submit_checkout" type="submit" value="Proceed To Payment" />
            </div>
        </div>
        <!-- //payment -->
    </div>
    <div class="clearfix"></div>
    <input type="hidden" id="order_total" value="<?= str_replace(",","",$cart['cart_gross_total'])?>" />
    <input type="hidden" name="shipping_amount" id="order_shipping_amt" value="<?= $shipingAmt?>" />
    <input type="hidden" name="withordertax_amount" id="withordertax_amount" value="<?= str_replace( ',', '', $cart['order_tax_total'])?>" />
    <input type="hidden" name="order_tax_id" id="order_tax_id" value="<?= $cart['cart_order_tax_id']?>" />
    <input type="hidden" name="order_tax" id="order_tax" value="<?= $ordert[0];?>" />
    
    
    <?php
    echo form_close();
    ?>
</div>
<!-- //banner -->

<?php include('footer.php'); ?>
  
<script>
$(document).ready(function(){
    $('.shippingType').on('click', function(){
        if($(this).is(':checked')) {
          var v = $(this).val();
          var shipping_price = $('#shipping_price_'+v).val(); 
        
          var order_total = $('#order_total').val();
//          alert(order_total);
//          alert(shipping_price);
        
          var orderwithtax = $('#withordertax_amount').val();
          //var total = parseInt(order_total) + parseInt(shipping_price);
           var total = (parseFloat(order_total) + parseFloat(shipping_price)).toFixed(2);
         // console.log(total);
         
          $('#billing_amt').html(total);
          $('#order_shipping_amt').val(shipping_price);          
        }
    });
    
    $('.billing_input').on('blur', function(){
      
        if($('#shipping_billing_is_same').is(':checked')) {
      
            billing_shipping_is_same();
      
        }
        
    });
    
    $('#shipping_billing_is_same').on('click',function(){
        
        if($('#shipping_billing_is_same').is(':checked')) {
      
            billing_shipping_is_same();
      
        }
        
    });
    
});

function billing_shipping_is_same(){
    $('#shipping_name').val( $('#billing_name').val() );
    $('#shipping_phone').val( $('#billing_phone').val() );
    $('#shipping_email').val( $('#billing_email').val() );
    $('#shipping_addr1').val( $('#billing_addr1').val() );
    $('#shipping_addr2').val( $('#billing_addr2').val() );
    $('#shipping_city').val( $('#billing_city').val() );
    $('#shipping_state').val( $('#billing_state').val() );
    $('#shipping_country').val( $('#billing_country').val() );
    $('#shipping_zipcode').val( $('#billing_zipcode').val() );
}
   function changevalue(){
       if($('#shippingType1').is(':checked'))
          $('#shippingTypeName').val('Delivery at home');
       if($('#shippingType2').is(':checked'))
          $('#shippingTypeName').val('Pickup from store');
    }
</script>