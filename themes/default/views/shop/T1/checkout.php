<?php include_once 'header.php';?>

<section class="middle_section"><!--Middle section view-->
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url('shop/home');?>">Home</a></li>
                <li><a href="<?php echo site_url('shop/cart');?>">Cart</a></li>
                <li class="active">Checkout</li>
            </ol>
        </div><!--/breadcrums-->
        <div class="clearfix"></div>
        <div class="shopper-informations">
            <?php echo form_open('shop/order_submit', 'name="frm_checkout"');?>
            <?php echo form_hidden('order_data', serialize($cart));?>
            <div class="row">
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12 clearfix bling-div">
                            <div class="bill-to">
                                <div class="form-outer">
                                    <div class="cart-heading">
                                        <h4>Billing Details</h4>
                                        <div class="clearfix"></div>
                                    </div>									 
                                    <div class="row" >
                                        <div class="col-sm-6">
                                            <label><span class="text-danger">*</span> Name</label>
                                            <input  type="text" name="billing_name" id="billing_name" value="<?= (isset($billing_shipping)) ? $billing_shipping['billing_name'] : $customer['name']?>" required="required" class="form-control billing_input" maxlength="30" />                                            
                                        </div>
                                        <div class="col-sm-6">
                                    <?php if($currency === 'INR') { ?>                                        
                                            <label>GST Number</label>
                                            <input type="text" name="billing_gstn_no" id="billing_gstn_no" value="<?= $customer['gstn_no']?>" maxlength="16" class="form-control" />
                                    <?php } ?>
                                        </div> 
                                        <div class="col-sm-6">
                                            <label><span class="text-danger">*</span> Mobile</label>
                                            <input type="text" name="billing_phone" id="billing_phone" value="<?= (isset($billing_shipping)) ? $billing_shipping['billing_phone'] : $customer['phone']?>"  required="required" class="form-control billing_input" maxlength="10" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label><span class="text-danger">*</span> Email</label>
                                            <input type="email" name="billing_email" id="billing_email" value="<?= (isset($billing_shipping)) ? $billing_shipping['billing_email'] : $customer['email']?>" required="required" class="form-control billing_input" maxlength="35" />
                                        </div>
                                        <div class="col-sm-12">
                                            <label><span class="text-danger">*</span> Address 1</label>
                                            <input  type="text" name="billing_addr1" id="billing_addr1" value="<?= (isset($billing_shipping)) ? $billing_shipping['billing_addr1'] : $customer['address']?>" maxlength="155"  required="required" class="form-control billing_input" />
                                        </div>
                                        <div class="col-sm-12">
                                            <label>Address 2</label>
                                            <input  type="text" name="billing_addr2" id="billing_addr2" value="<?= (isset($billing_shipping)) ? $billing_shipping['billing_addr2'] : ''?>" maxlength="155" class="form-control billing_input" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label><span class="text-danger">*</span> City</label>
                                            <input type="text" name="billing_city" id="billing_city" value="<?= (isset($billing_shipping)) ? $billing_shipping['billing_city'] : $customer['city']?>" maxlength="50" required="required" class="form-control billing_input" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label><span class="text-danger">*</span> State</label>
                                            <input  type="text" name="billing_state" id="billing_state" value="<?= (isset($billing_shipping)) ? $billing_shipping['billing_state'] : $customer['state']?>" maxlength="50"  required="required" class="form-control billing_input" /></td>
                                        </div>
                                        <div class="col-sm-6">
                                            <label><span class="text-danger">*</span> Country</label>
                                            <input type="text" name="billing_country" id="billing_country" value="<?= (isset($billing_shipping)) ? $billing_shipping['billing_country'] : $customer['country']?>" required="required" value="India" maxlength="60" class="form-control billing_input" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label><span class="text-danger">*</span> Zip / Postal Code</label>
                                            <input  type="text" name="billing_zipcode" id="billing_zipcode" value="<?= (isset($billing_shipping)) ? $billing_shipping['billing_zipcode'] : $customer['postal_code']?>" required="required" maxlength="6" class="form-control billing_input" />
                                        </div>
                                    </div>
                                    <hr/>
                                    <label><input type="checkbox" name="shipping_billing_is_same" id="shipping_billing_is_same" value="1">Shipping address same as billing address</label>
                                    <div class="clearfix"></div>
                                    <label><input type="checkbox" name="save_info" value="1" /> Save address for future assistants.</label>
                                    <div class="clearfix"></div>
                                </div>
                                <div class="form-outer" id="shipping-address">
                                    <div class="cart-heading">
                                        <h4>Shipping Details</h4>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="row" >
                                        <div class="col-sm-6">
                                            <label><span class="text-danger">*</span> Name</label>
                                            <input  type="text" name="shipping_name" id="shipping_name" value="<?= (isset($billing_shipping)) ? $billing_shipping['shipping_name'] : $customer['name']?>" required="required" maxlength="100" class="form-control" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label><span class="text-danger">*</span> Mobile</label>
                                            <input  type="text" name="shipping_phone" id="shipping_phone" data-inputmask="'mask': '9999999999'" value="<?= (isset($billing_shipping)) ? $billing_shipping['shipping_phone'] : $customer['phone']?>" required="required"  class="form-control" />
                                        </div>
                                        <div class="col-sm-12">
                                            <label><span class="text-danger">*</span> Email</label>
                                            <input type="email" name="shipping_email" id="shipping_email" value="<?= (isset($billing_shipping)) ? $billing_shipping['shipping_email'] : $customer['email']?>" required="required" maxlength="60" class="form-control" />
                                        </div>
                                        <div class="col-sm-12">
                                            <label><span class="text-danger">*</span> Address 1</label>
                                            <input  type="text" name="shipping_addr1" id="shipping_addr1" value="<?= (isset($billing_shipping)) ? $billing_shipping['shipping_addr1'] : $customer['address']?>" required="required" maxlength="100"  class="form-control" />
                                        </div>
                                        <div class="col-sm-12">
                                            <label>Address 2</label>
                                            <input  type="text" name="shipping_addr2" id="shipping_addr2" value="<?= (isset($billing_shipping)) ? $billing_shipping['shipping_addr2'] : $customer['address']?>"  maxlength="100"  class="form-control" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label><span class="text-danger">*</span> City</label>
                                            <input type="text" name="shipping_city" id="shipping_city" value="<?= (isset($billing_shipping)) ? $billing_shipping['shipping_city'] : $customer['city']?>" required="required" maxlength="60" class="form-control" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label><span class="text-danger">*</span> State</label>
                                            <input type="text" name="shipping_state" id="shipping_state" value="<?= (isset($billing_shipping)) ? $billing_shipping['shipping_state'] : $customer['state']?>" required="required" maxlength="60" class="form-control" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label><span class="text-danger">*</span> Country</label>
                                            <input type="text" name="shipping_country" id="shipping_country" value="<?= (isset($billing_shipping)) ? $billing_shipping['shipping_country'] : $customer['country']?>" value="India" required="required" maxlength="60"  class="form-control" />
                                        </div>
                                        <div class="col-sm-6">
                                            <label><span class="text-danger">*</span> Zip / Postal Code</label>
                                            <input type="text" name="shipping_zipcode" id="shipping_zipcode" value="<?= (isset($billing_shipping)) ? $billing_shipping['shipping_zipcode'] : $customer['postal_code']?>"  required="required" maxlength="6"  class="form-control" />
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="row">
                        <div class="col-sm-12 clearfix bling-div">
                            <div class="bill-to">
                                <div class="form-outer">
                                    <div class="cart-heading">
                                        <h4>Shipping Method</h4>
                                        <div class="clearfix"></div>
                                    </div>
                                <?php
                                if(is_array($shipping_methods)){
                                    foreach ($shipping_methods as $key => $shippings) {
                                ?>
                                <div>
                                    <label>
                                        <input type="radio" name="shippingType" required="required" value="<?php echo $shippings['id'];?>" />
                                        <span class="price"> <?php echo $shippings['name'];?> </span>
                                    </label>
                                </div>
                                <?php } } ?> 
                                    <div class="clearfix"></div>                                   
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 clearfix bling-div">
                            <div class="bill-to">
                                <div class="form-outer">
                                    <div class="cart-heading">
                                        <h4>Payment Information</h4>
                                        <div class="clearfix"></div>
                                    </div>
                                    <?php                                    
                                        if(is_array($payment_methods)){
                                            foreach ($payment_methods as $key => $paymentmethod) {
                                       ?>
                                    <div>
                                    <label>
                                        <input type="radio" name="paymentType" id="type_<?php echo $paymentmethod['code'];?>" required="required" value="<?php echo $paymentmethod['id'];?>" />
                                        <?php echo $paymentmethod['name'];?>
                                    </label></div>
                                    <?php } } ?> 
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>                    
                        <div class="col-sm-12 clearfix bling-div" id="cc_div" style="display:none;">   
                            <div class="bill-to">
                                <div class="form-outer"> 
                                    <div class="cart-heading">
                                        <h4>Credit/Debit Card Details</h4>
                                        <div class="clearfix"></div>
                                    </div>
                                    <div class="col-xs-12 col-md-6">
                                        <label><span class="text-danger">*</span>Card Number</label>
                                        <input type="text" name="cc_number" id="cc_number" required="required" disabled="disabled" data-inputmask="'mask': '9999 9999 9999 9999'" class="form-control cc_input" />                                            
                                    </div>
                                    <div class="col-xs-12 col-md-3">
                                        <label><span class="text-danger">*</span>Expiry Date</label>
                                        <input type="text" name="cc_expiry" id="cc_expiry" maxlength="7" required="required" disabled="disabled" data-inputmask="'mask': '2099-99'" class="form-control cc_input" />                                            
                                    </div>                                
                                    <div class="col-xs-12 col-md-3">
                                        <label><span class="text-danger">*</span>Card Pin</label>
                                        <input type="text" name="cc_pin" id="cc_pin" maxlength="6" required="required" disabled="disabled" class="form-control cc_input" />                                            
                                    </div>  
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <?php
                            if($shopinfo['pos_type']=='pharma') {
                        ?>
                        <div class="col-sm-12 clearfix bling-div">   
                            <div class="bill-to">
                                <div class="form-outer">                                     
                                    <div class="col-sm-6">
                                        <label>Patient Name</label>
                                        <input type="text" name="cf1"  class="form-control" />
                                    </div>
                                    <div class="col-sm-6">
                                        <label>Doctor Name</label>
                                        <input type="text" name="cf2"  class="form-control" />
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div class="col-sm-12 clearfix bling-div">
                            <div class="bill-to">
                                <div class="form-outer" style="padding:15px 0px 0px 0px;">
                                    <div class="row cart-heading last" style="border-bottom: none;"  >
                                        <div class="col-sm-4"><h4>Order Review</h4></div>
                                        <div class="text-success col-sm-8" style="padding-top:15px;"><?php echo $cart['itemcount']?> Item(s) in cart.</div>                                        
                                    </div>
                                    <div class="table-outer">
                                    <?php 
                                        if($cart['itemcount']) {
                                    ?>                                          
                                        <div class="table-responsive cart_info desktop-view" >
                                            <table class="table table-responsive">
                                                <thead>
                                                    <tr class="cart_menu">
                                                        <td>Item</td>
                                                        <td>Price</td>
                                                        <td>Qty</td>
                                                        <td>Tax</td>
                                                        <td>Total</td>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                <?php
                                                if(is_array($cart['items']) && !empty($cart['items'])) {
                                                    foreach ($cart['items'] as $item_id => $product) {
                                                        if(!empty($product['tax_attr']) && isset($product['tax_attr'])) {
                                                            foreach($product['tax_attr'] as $taxkey => $taxinfo){
                                                                $taxratekey = $taxinfo['percentage'].'%';
                                                                $taxSummery[$taxkey][$taxratekey] += $taxinfo['taxamt'];
                                                                $taxSummeryTotal += $taxinfo['taxamt'];
                                                            }//end tax foreach.
                                                        }//end if.
                                                        
                                                ?>
                                                    <tr id="hideDivOnClick">
                                                        <td class="product-image">
<!--                                                            <img src="<?= $baseurl;?>assets/uploads/thumbs/<?= $product['image']?>" alt="<?= $product['code']?>" />-->
                                                            <span class="cart_description">
                                                                <input type="hidden" name="cart_items[]" value="<?= $item_id?>" />
                                                                <?= $product['name']?>
                                                            </span>
                                                        </td>
                                                        <td class="product-name text-right" >
                                                            <?= $Settings->symbol ?>&nbsp;<?= number_format($product['item_price'],2)?> 
                                                        </td>
                                                        <td class="product-qty text-right"><?= $product['qty']?></div> 
                                                        </td>
                                                        <td class=" align-right"><?= $Settings->symbol ?>&nbsp;<?= number_format($product['item_tax_total'],2)?></td>
                                                        <td class="product-total text-right">
                                                             <?= $Settings->symbol ?>&nbsp;<?= $product['item_subtotal']?>
                                                        </td>                                                                                                  
                                                    </tr>
                                                    <?php }//end foreach. 
                                                }//end if.
                                                ?>
                                                
                                                    <tr class="total-count">                                     
                                                        <th colspan="3" class="text-right">Sub Total</th>
                                                        <th colspan="2" class="tot-price text-right"><?= $Settings->symbol ?> <?= number_format($cart['cart_sub_total'],2)?></th>
                                                    </tr>
                                                <?php if($cart['cart_tax_total'] > 0) { ?>
                                                    <tr class="total-count">                                     
                                                        <th colspan="3" class="text-right">Total Tax</th>
                                                        <th colspan="2" class="tot-price text-right"><?= $Settings->symbol ?> <?= number_format($cart['cart_tax_total'],2)?></th>
                                                    </tr>
                                                <?php } ?>
                                                    <tr class="total-count">                                    
                                                        <th colspan="3" class="text-right"> Grand Total</th>
                                                        <th colspan="2" class="tot-price text-right"><?= $Settings->symbol ?> <?= number_format($cart['cart_gross_total'],2)?></th>

                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <?php } ?>
                                    </div>
                                     
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>			
                    </div>
                    <div class="clearfix"></div>
                    <div class="total_area checkout-btn col-sm-12">
                        <button type="button" class="btn btn-warning btn-lg check_out" onclick="history.back(-1);" >Back</button>
                        <button type="submit" class="btn btn-default btn-lg check_out" >Proceed to pay</button>
                    </div>
                </div>
            </div>
        </form>   
    </div>
    </div>             
</section>
<!--/Middle section view-->
    
<?php include_once 'footer.php';?>
<script src="<?= $assets . $shoptheme ?>/js/jquery.inputmask.js"  ></script> 
<script type="text/javascript" >
$(function () { 
     $('#cc_number').inputmask();
     $('#cc_expiry').inputmask();
     $('#billing_phone').inputmask();
     $('#shipping_phone').inputmask();
});

$(document).ready(function(){
    
    $('input:radio[name="paymentType"]').change(
    function(){
        if (this.checked && this.id == 'type_authorize') {
           //cc_div cc_input disabled required 
           $('#cc_div').show();
           $('.cc_input').removeAttr('disabled');
           $('.cc_input').attr('required', 'required');
        } else {
           $('#cc_div').hide();
           $('.cc_input').removeAttr('required');
           $('.cc_input').attr('disabled', 'disabled');
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

</script>
