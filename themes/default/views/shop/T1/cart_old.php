<?php include_once 'header.php';?>

<section class="middle_section"><!--Middle section view-->
    <div class="container">
        <?php
//                    echo '<pre>Cart:';
//                    print_r($cart);
//                    print_r($taxes['methods']);
//                    echo '</pre>';

        ?>
        <div class="col-sm-12">
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="<?php echo site_url('shop/home');?>">Home</a></li>
                    <li class="active">Shopping Cart</li>
                </ol>
            </div>
    
       <?php if($cartqty) { ?> 
        <?php echo form_open('shop/checkout');?>
        <div class="alert alert-success"><?= $cartqty?> product(s) in cart.</div>  
	<div class="table-responsive cart_info desktop-view">
            
            <table class="table table-condensed cart-page">
                    <thead>
                        <tr class="cart_menu">
                            <td colspan="2">Item</td>   
                            <td>Quantity</td>
                            <td>Tax(%)</td>
                            <td>Price</td>                            
                            <td>Total</td>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                                                       
                            $itemTax = $taxes['methods'];
                        
                            $cart_tax_total = $cart_sub_total = $cart_gross_total = 0;
                            
                            foreach ( $cart as $key => $item) {
                                
                                $item_tax_total = $item_price_total = 0;
                                
                                $taxrate = ($item['tax_rate']) ? $itemTax[$item['tax_rate']]['rate'] : 0;
                                $taxname = $itemTax[$item['tax_method']]['name'];
                                $itemPrice = $item['price'];
                                $taxType = $inclusiveInfo = "";
                                
                                if($item['tax_method']==0) {
                                    
                                    if($taxrate) {
                                      $taxType = 'Tax-Inclusive' ; 
                                         
                                        $itemPrice = (($item['price'] * 100) / (100 + $taxrate));
                                        $inclusiveTaxAmt = ($item['price'] - $itemPrice);
                                        $inclusiveInfo = '<br/><i class="text-warning">'.$itemPrice .' + (Tax: '.$inclusiveTaxAmt.')</i>';
                                    }                                    
                                }
                                
                                $item_tax_total     = (($item['qty'] * $itemPrice) * $taxrate ) / 100;
                                $item_price_total   = ($item['qty'] * $itemPrice);
                                
                                $cart_tax_total += $item_tax_total;
                                $cart_sub_total += $item_price_total;
                                $cart_gross_total = ($cart_tax_total + $cart_sub_total);
                        ?>
                        
                        <tr id="item_<?= $key?>">
                            <td class="product-image">
                                <input type="hidden" name="items[]" value="<?= $key?>" />
                                <input type="hidden" id="baseurl" value="<?= $baseurl;?>" />
                                <input type="hidden" name="item_tax_id[<?= $key?>]" value="<?= $item['tax_rate']?>" />
                                <input type="hidden" name="item_tax_method[<?= $key?>]" value="<?= $item['tax_method']?>" />
                                <input type="hidden" name="item_tax_rate[<?= $key?>]" id='item_tax_rate_<?= $key?>' value="<?= $taxrate?>" />                                
                                <input type="hidden" name="item_price[<?= $key?>]" id="item_price_<?= $key?>" value="<?= $itemPrice?>" />
                                <input type="hidden" class="item_tax_total" name="item_tax_total[<?= $key?>]" id="item_tax_total_<?= $key?>" value="<?= $item_tax_total?>" />
                                <input type="hidden" class="item_price_total" name="item_price_total[<?= $key?>]" id="item_price_total_<?= $key?>" value="<?= $item_price_total?>" />
                                <img src="<?= $baseurl;?>assets/uploads/thumbs/<?= $item['image']?>" alt="<?= $item['code']?>" style="max-width:60px;" />
                            </td>
                            <td>
                                <span class="cart_description">
                                    <h4><?= $item['name']?></h4>
                                </span>
                            </td>
                            <td class="product-qty">
                                <div class="cart_quantity_button">
                                    <span class="mobile-show">Qty </span><input id="qty_<?= $item['id']?>" class="cart_quantity_input" name="qty[<?= $item['id']?>]" min="1" max="100" value="<?= $item['qty']?>" onchange="updateQtyCost(<?= $item['id']?>);" type="number" size="2"  />
                                </div>
                            </td>
                            <td class="product-tax">
                                <p><?= $taxname?><br/><?= $taxType?></p>
                            </td>
                            <td class="product-name">
                                <p><span class="mobile-show text-right">Price</span><?= $Settings->symbol ?> <?= number_format($item['price'],2)?><?= $inclusiveInfo?></p>
                            </td>
                            <td class="product-total">
                                <p class="item_total_price text-right" >
                                    <span class="mobile-show">Items Price</span> <?= $Settings->symbol ?> <span id="show_total_<?= $item['id']?>"><?= number_format($item_price_total,2)?></span>
                                    <br/><small class="text-info">(Tax: <?= $Settings->symbol ?> <i id="show_tax_total_<?= $item['id']?>"><?php echo number_format($item_tax_total,2);?></i> )</small>
                                </p>
                            </td>
                             
                            <td class="product-close">
                                <a class="cart_quantity_delete" href="<?php echo site_url('shop/removeCartItems?id='.$item['id']);?>"><i class="fa fa-times"></i></a>
                            </td>
                        </tr>
                        <?php 
                                                    
                            }//end foreach. ?>
                            <tr class="total-count">                                     
                                <td colspan="4"></td>
                                <td>Sub Total:</td>
                                <td class="tot-price text-right"><?= $Settings->symbol ?> <b id="cart_sub_total_show"><?= number_format($cart_sub_total,2)?></b></td>
                                <td></td>
                            </tr>
                        <?php if($cart_tax_total > 0) { ?>
                            <tr class="total-count">                                     
                                <td colspan="4"></td>
                                <td>Total Tax</td>
                                <td class="tot-price text-right"><?= $Settings->symbol ?> <b id="cart_tax_total_show"><?= number_format($cart_tax_total,2)?></b></td>
                                <td></td>
                            </tr>
                        <?php } ?>
                            <tr class="total-count">                                    
                                <td colspan="4"></td>
                                <td>Gross Total</td>
                                <td class="tot-price text-right"><?= $Settings->symbol ?> <b id="cart_gross_total_show"><?= number_format($cart_gross_total,2)?></b></td>
                                <td></td>
                            </tr>
                    </tbody>
		</table>
	</div>
	<div class="row">
            <div class="col-sm-6">               
                <input type="hidden" name="cart_sub_total"  id="cart_sub_total" value="<?= $cart_sub_total?>" />                   
                <input type="hidden" name="cart_tax_total" id="cart_tax_total" value="<?= $cart_tax_total?>" />
                <input type="hidden" name="cart_gross_total" id="cart_gross_total" value="<?= $cart_gross_total?>" />                
            </div>
            <div class="col-sm-6">
                <div class="total_area checkout-btn">
                    <a class="btn btn-success btn-lg update" href="<?php echo site_url('shop/home');?>">Continue Shopping</a>
                    <button type="submit" class="btn btn-default btn-lg check_out">Checkout</button>
                </div>
            </div>
	</div>
        <?php echo form_close();?>
       <?php } else { ?>
        <div class="alert alert-info">No product in cart.</div>
       <?php }//end else. ?> 
            </div>
            </div>             
        </section><!--/Middle section view-->
    
<?php include_once 'footer.php';?>
 
