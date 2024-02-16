<?php include_once 'header.php'; ?>
<div class="banner">
 
<div class="privacy about">
<?php

$attributes = ["name"=>"frm_checkout"];
$hidden = ["frm_checkout"=> base_url()];
echo form_open(base_url('shop/checkout'), $attributes, $hidden);
?>
<div class="checkout-right">
 
    <h4>Your shopping cart contains: <span class="cart-count"><?=$cartqty?></span> Items</h4>
<table class="timetable_sub">
    <thead>
        <tr>
            <th>Product</th>            
            <th>Product Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Item Tax</th>
            <th>Total</th>
            <th>Remove</th>
        </tr>
    </thead>
    <tbody>
    <?php
//    echo '<pre>';
//    print_r($eshop_order_tax);
//    print_r($cart);
//    echo '</pre>';
    
    $cartSubtotal = $totalTax = $grossTotal = $ordertax = $total_qty = 0 ;
    
    if(count($cart))
    {
        foreach ($cart as $key => $product) {
            $i++;
           $tax_type = $taxes['methods'][$product['tax_rate']]['type'];
           $tax_rate = $taxes['methods'][$product['tax_rate']]['rate'];
           $product['option_price'] = $product['option_price'] ? $product['option_price'] : 0;    
           $inclusiveInfo = "";
           if($product['tax_method'] == 0) {
                if($tax_rate) {
                  $taxType = 'Tax-Inclusive' ;
                  
                   //Inclusive Tax Type percentage
                    if($tax_type == 1){                        
                        $itemPrice = (((($product['price'] + $product['option_price']) * 100) / (100 + $tax_rate)));
                        if($product['tax_rate']>0){
                           $itemTax = (($product['price'] + $product['option_price'])- $itemPrice) * $product['qty'];
                        }
                        else{
                           $itemTax = 0;
                        }
                    }
                    //Tax Type Fixed
                    if($tax_type == 2){
                    	
                        $itemPrice = (($product['price'] + $product['option_price']) - $tax_rate);
                        if($product['tax_rate']>0){
                            $itemTax = $tax_rate * $product['qty'];
                        }
                        else {
                            $itemTax = 0;
                        }
                    }
                    
                    $inclusiveTaxAmt = (($product['price']+$product['option_price']) - $itemPrice);
                    $inclusiveInfo   = '<br/><i class="text-warning">'.$itemPrice .' + (Tax: '.$inclusiveTaxAmt.')</i>';
                }                                    
            } else  {   
               $itemPrice = $product['price']+$product['option_price'];
                //Exclusive Tax Type percentage
                if($tax_type == 1){
                    $itemTax = (($itemPrice * $tax_rate / 100) * $product['qty']);
                }
                //Tax Type Fixed
                if($tax_type == 2){
                    $itemTax = $tax_rate * $product['qty'];
                }                
            }                   
           $cartItemSubTotal = ( $itemPrice  * $product['qty']);
           $cartItemTotal = $cartItemSubTotal;
            
        $cartSubtotal += $cartItemSubTotal;
        $totalTax += $itemTax;
        
        $productId = $product['id'];
        $total_qty += $product['qty'];
        $real_unit_price = $product['option_price'] ? $product['option_price'] + $product['real_unit_price'] : $product['real_unit_price'];
    ?>
        <tr class="rem<?= $i?>"> 
            <input type="hidden" name="items[]" value="<?= $key?>" />            
            <input type="hidden" name="items_ids[<?= $key?>]" value="<?= $product['id']?>" />            
            <input type="hidden" name="item_tax_id[<?= $key?>]" value="<?= $product['tax_rate']?>" />
            <input type="hidden" name="qty[<?= $key?>]" id="qty_<?= $key?>" value="<?= $product['qty']?>" />
            <input type="hidden" name="item_tax_method[<?= $key?>]" id="item_tax_method_<?= $key?>" value="<?= $product['tax_method']?>" />
            <input type="hidden" name="item_tax_type[<?= $key?>]" id='item_tax_type_<?= $key?>' value="<?= $tax_type?>" />
            <input type="hidden" name="item_tax_rate[<?= $key?>]" id='item_tax_rate_<?= $key?>' value="<?= $tax_rate?>" />                                
<!--        <input type="hidden" name="order_tax[<?= $key?>]" id='order_tax_<?= $key?>' value="<?= $order_tax_rate?>" /> -->
            <input type="hidden" name="real_unit_price[<?= $key?>]" id="real_unit_price_<?= $key?>" value="<?= $real_unit_price ?>" />
            <input type="hidden" name="item_price[<?= $key?>]" id="item_price_<?= $key?>" value="<?= str_replace( ',', '', $itemPrice ) ?>" />
           <?php if($product['option_id']) { ?>
            <input type="hidden" name="item_option_id[<?= $key?>]" id="item_option_id_<?= $key?>" value="<?= $product['option_id'] ?>" />
            <input type="hidden" name="item_option_name[<?= $key?>]" id="item_option_name_<?= $key?>" value="<?= $product['option_name'] ?>" />
            <input type="hidden" name="item_option_price[<?= $key?>]" id="item_option_price_<?= $key?>" value="<?= $product['option_price'] ?>" />
           <?php } ?> 
            <input type="hidden" class="item_tax_total" name="item_tax_total[<?= $key?>]" id="item_tax_total_<?= $key?>" value="<?= $itemTax ?>" />
            <input type="hidden" class="item_price_total" name="item_price_total[<?= $key?>]" id="item_price_total_<?= $key?>" value="<?= str_replace( ',', '', $cartItemTotal ) ?>" />

            <td class="invert-image"><a href="#"><img src="<?= $thumbs.$product['image']?>" alt="Image" class="img-responsive img-rounded"></a></td>            
            <td class="invert" style="text-align: left;"><?= $product['name']?> <?php if($product['option_name']){?><sub>(<?php echo $product['option_name'];?>)</sub> <?php } ?></td>
            <td class="invert"><?= $currency_symbol?> <?= number_format($itemPrice, 2)?></td>
            <td class="invert">
                <div class="quantity"> 
                    <div class="quantity-select">                           
                        <div class="entry value-minus" iid="<?= $key?>" >&nbsp;</div>
                        <div class="entry value"><span><?= $product['qty']?></span></div>
                        <div class="entry value-plus active" iid="<?= $key?>" >&nbsp;</div>
                    </div>
                </div>
            </td>
            
            <td class="invert"><?= $currency_symbol?> <span id="show_tax_total_<?= $key?>"><?= number_format($itemTax, 2)?></span></td>
            <td class="invert"><?= $currency_symbol?> <span id="show_total_<?= $key?>"><?= number_format($cartItemTotal, 2)?></span></td>
            <td class="invert">
                <div class="rem">
                    <div class="close1" onclick="remove_item('<?= $key?>');"> </div>
                </div>
            </td>
        </tr>
<?php
        }//end foreach
        
        //Manage Order level tax
        if($eshop_order_tax['rate']) {
            $ordertax_id = $eshop_order_tax['id'];
            $order_tax = $eshop_order_tax['name'];
            $order_tax_rate = $eshop_order_tax['rate'];
            $order_tax_type = $eshop_order_tax['type'];
            if($order_tax_type == 1 ){
                $ordertax = ($totalTax + $cartSubtotal)*($order_tax_rate)/100;
            } else if($order_tax_type==2){
                $ordertax = $order_tax_rate; //Fixed order tax amount
            }
        } else {
            $ordertax = 0;
        }
        
        $grossTotal =  $cartSubtotal + $totalTax + $ordertax;
        
    }//end if
                                 
?> 
    </tbody>
    <tfoot>
        <tr>
            <td style="text-align: right;" colspan="5"><b>Subtotal</b></td>
            <td><b><?= $currency_symbol?><span id="cart_sub_total_show"><?= number_format($cartSubtotal,2)?></span></b></td>
            <td></td>
        </tr>
        <tr>
            <td style="text-align: right;" colspan="5"><b>Item Tax</b></td>
            <td><b><?= $currency_symbol?><span id="cart_tax_total_show"><?= number_format($totalTax,2)?></span></b></td>
            <td></td>
        </tr>
        <?php if($ordertax > 0){ ?>
        <tr>
             <td style="text-align: right;" colspan="5"><b>Order Tax</b></td>
             <td><b><?= $currency_symbol?> <span id="cart_ordertax_total_show"><?= number_format($ordertax,2) ?></span></b></td>
             <td></td>
        </tr>
        <?php } ?>  
        <?php
           $grossRounding = number_format(round($grossTotal) - $grossTotal,4);
           $grossTotal = round($grossTotal);
           if($grossRounding >= 0.01) {
        ?>
        <tr>
             <td style="text-align: right;" colspan="5"><b>Rounding</b></td>
             <td><b><?= $currency_symbol?> <span id="cart_ordertax_total_show"><?= $grossRounding ?></span></b></td>
             <td></td>
        </tr>
           <?php } ?>
        <tr>
            <th style="text-align: right;" colspan="5">Gross Total</th>
            <th><?= $currency_symbol?><span id="cart_gross_total_show"><?= number_format($grossTotal,2)?>/-</span></th>
            <th></th>
        </tr>
    </tfoot>
</table> 
    
    <p class="text-danger text-right">* Note: Free delivery on orders valued at Rs <?= $shopinfo['eshop_free_delivery_on_order']?> or more.</p>
</div>
    <div class="checkout-left">
        <div class="col-md-8 address_form_agile">
            <div class="checkout-right-basket">
                <button type="button" class="btn btn-lg btn-info" onclick="goto('<?= base_url('shop/home')?>')"><span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> Continue Shopping </button>
                <button type="submit" class="btn btn-lg btn-success">Checkout <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span></button>
            </div>
        </div>
        <div class="clearfix"></div>				
    </div>
    <input type="hidden" name="cart_sub_total"  id="cart_sub_total" value="<?= number_format($cartSubtotal,4);?>" />                   
    <input type="hidden" name="cart_tax_total" id="cart_tax_total" value="<?= number_format($totalTax,4);?>" /> 
    <input type="hidden" name="order_tax_total" id="order_tax_total" value="<?= number_format($ordertax,4)?>" />
    <input type="hidden" name="cart_gross_rounding" id="cart_gross_rounding" value="<?= $grossRounding?>" />
    <input type="hidden" name="cart_gross_total" id="cart_gross_total" value="<?= number_format($grossTotal,4)?>" />
    <input type="hidden" name="item_quantity_total" id="item_quantity_total" value="<?= $total_qty ?>" />
    
    <input type="hidden" name="order_tax_name" id="" value="<?= $eshop_order_tax['name'];?>" />
    <input type="hidden" name="order_tax_id" id="order_tax_id" value="<?= $ordertax_id?>" />
<!--    <input type="hidden" name="order_tax_fix" id="order_tax_fix" value="<?= $ordertax?>" />-->
    
 
    <input type="hidden" name="baseurl" id="baseurl" value="<?= base_url()?>" /> 
<?php echo form_close();?>
</div>
<!-- //about -->
<div class="clearfix"></div>

</div>
<!-- //banner -->
<?php
include_once 'footer.php';
?>
<script>
$('.value-plus').on('click', function(){
        
        var divUpd = $(this).parent().find('.value'), newVal = parseInt(divUpd.text(), 10)+1;
        if(newVal < 1) return false;
        divUpd.text(newVal);
         
        var iid = $(this).attr('iid');
        
        $('#qty_'+iid).val(newVal);
        updateQtyCost(iid);
});

$('.value-minus').on('click', function(){
   
        var divUpd = $(this).parent().find('.value'), newVal = parseInt(divUpd.text(), 10)-1;
        if(newVal < 1) return false;
        divUpd.text(newVal);        
        var iid = $(this).attr('iid');
        
        $('#qty_'+iid).val(newVal);
        
        updateQtyCost(iid);
});
</script>
<!--quantity-->
<script>
    $(document).ready(function(c) {
//        $('.close1').on('click', function(c){
//            var id = $(this).attr('id');
//            $('.rem'+id).fadeOut('slow', function(c){
//                $('.rem'+id).remove();
//            });
//        });	  
    });
    
    function remove_item(id){
        document.location = '<?=base_url()?>' + 'shop/removeCartItems/'+id;
    }
</script>


