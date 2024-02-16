<?php include_once 'header.php';?>

<section class="middle_section"><!--Middle section view-->
    <div class="container">
        <div class="breadcrumbs">
            <ol class="breadcrumb">
                <li><a href="<?php echo site_url('shop/home');?>">Home</a></li>
                <li><a href="<?php echo site_url('shop/cart');?>">Payment</a></li>
                <li class="active">Credit Card</li>
            </ol>
        </div><!--/breadcrums-->
        <div class="clearfix"></div>
        <div class="shopper-informations">
            <?php echo form_open('shop/payment_authorisenet', 'name="payment_authorisenet"');?>
            <?php echo form_hidden('cart_data', serialize($cart));?>
            <?php echo form_hidden('amount', '5.25');?>
            <div class="form-outer">
            <div class="cart-heading">
                <h4>Credit Card Details</h4>
                <div class="clearfix"></div>
            </div>									 
            <div class="row">
                <div class="col-xs-12 col-md-6 col-md-offset-3">
                    <label><span class="text-danger">*</span>Credit Card Number</label>
                    <input type="text" name="cc_number" id="cc_number"  required="required" class="form-control" />                                            
                </div>
                <div class="col-xs-12 col-md-6 col-md-offset-3">
                    <label><span class="text-danger">*</span>Card Expiry Date</label>
                    <input type="text" name="cc_expiry" id="cc_expiry"  required="required" class="form-control" />                                            
                </div>
                <div class="col-xs-12 col-md-6 col-md-offset-3">
                    <label><span class="text-danger">*</span>Amount</label>
                    <input type="text" name="payment_amount" id="payment_amount" required="required" readonly="readonly" class="form-control" />                                            
                </div>
                <div class="col-xs-12 col-md-6 col-md-offset-3">
                    <label><span class="text-danger">*</span>Credit Card Pin</label>
                    <input type="text" name="cc_pin" id="cc_pin" required="required" class="form-control" />                                            
                </div>
                <div class="col-xs-12 col-md-6 col-md-offset-3">                     
                    <input type="submit" name="submit" id="submit" value="Payment Submit" />                                            
                </div>
            </div>

        </div>
                                
        </form>   
    </div>
    </div>             
</section>
<!--/Middle section view-->
    
<?php include_once 'footer.php';?>

<script>

$(document).ready(function(){
    
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
