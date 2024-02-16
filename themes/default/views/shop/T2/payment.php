<?php include('header.php'); ?>
<?php
 
    ?>
<!-- banner -->
<div class="banner">
    <div class="w3l_banner_nav_left">
        <div class="privacy about">            
            <h3>Billing & <span>Shipping</span></h3>

            <div class="checkout-right">
                <!--Horizontal Tab-->
                <div id="parentHorizontalTab2">
                    <ul class="resp-tabs-list hor_2">
                        <li>Billing </li>
                        <li>Shipping </li>
                        <li>Order</li>
                    </ul>
                    <div class="resp-tabs-container hor_2">                        
                        <div>
                           <h4>Billing <span>Address</span></h4>
                           <div class="clearfix">
                                <div class="form-group">
                                    <label>Billing Name: </label>
                                    <p><?= ($checkoutData['billing_name']) ? $checkoutData['billing_name'] :''?></p>
                                </div>                                
                                <div class="form-group">
                                    <label>Billing Contact:</label>
                                    <p><?= ($checkoutData['billing_phone']) ? $checkoutData['billing_phone'] :''?></p>
                                    <p><?= ($checkoutData['billing_email']) ? $checkoutData['billing_email'] :''?></p>
                                </div>
                                <div class="form-group">
                                    <label>Billing Address:</label>
                                    <p><?= ($checkoutData['billing_addr1']) ? $checkoutData['billing_addr1'] :''?></p>
                                    <p><?= ($checkoutData['billing_addr2']) ? $checkoutData['billing_addr2'] :''?></p>
                                    <p><?= ($checkoutData['billing_city']) ? $checkoutData['billing_city'] :''?>,
                                       <?= ($checkoutData['billing_state']) ? $checkoutData['billing_state'] :''?></p>
                                    <p><?= ($checkoutData['billing_country']) ? $checkoutData['billing_country'] :''?>-
                                        <?= ($checkoutData['billing_zipcode']) ? $checkoutData['billing_zipcode'] :''?>
                                    </p>                                   
                                </div>                                                           
                            </div>
                        </div>                       
                        <div>
                            <h4>Shipping <span>Address</span></h4>
                             <div class="clearfix">
                                <div class="form-group">
                                    <label>Shipping Name: </label>
                                    <p><?= ($checkoutData['shipping_name']) ? $checkoutData['shipping_name'] :''?></p>
                                </div>                                
                                <div class="form-group">
                                    <label>Shipping Contact:</label>
                                    <p><?= ($checkoutData['shipping_phone']) ? $checkoutData['shipping_phone'] :''?></p>
                                    <p><?= ($checkoutData['shipping_email']) ? $checkoutData['shipping_email'] :''?></p>
                                </div>                                
                                <div class="form-group">
                                    <label>Shipping Address:</label>
                                    <p><?= ($checkoutData['shipping_addr1']) ? $checkoutData['shipping_addr1'] :''?></p>
                                    <p><?= ($checkoutData['shipping_addr2']) ? $checkoutData['shipping_addr2'] :''?></p>
                                    <p><?= ($checkoutData['shipping_city']) ? $checkoutData['shipping_city'] :''?>,
                                       <?= ($checkoutData['shipping_state']) ? $checkoutData['shipping_state'] :''?></p>
                                    <p><?= ($checkoutData['shipping_country']) ? $checkoutData['shipping_country'] :''?>-
                                        <?= ($checkoutData['shipping_zipcode']) ? $checkoutData['shipping_zipcode'] :''?>
                                    </p>                                   
                                </div>                                                           
                            </div>
                        </div> 
                        <div>
                            <h4>Order <span>Details</span></h4>
                            <div class="row table-responsive">
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
                                        foreach ($order_data['items'] as $pid => $items) {
                                        //echo number_format($items['item_tax_total'],2);
                                        //echo $order_data['item_tax_total'];
                                      $cart_gross_total = str_replace(",","",$order_data['cart_gross_total']);
                                    ?>
                                        <tr>
                                            <td><?= $items['name']?><?php if($items['vname']){echo '<sub>('.$items['vname'].')</sub>';} ?></td>
                                            <td><?= $items['qty']?></td>
                                            <td><?= $currency_symbol?> <?= number_format($items['item_price'],2)?></td>
                                            <td><?= $currency_symbol?> <?= number_format($items['item_tax_total'],2) ?></td>
                                            <td><?= $currency_symbol?> <?= number_format($items['item_price']*$items['qty'],2)?></td>                                
                                        </tr>
                                        <?php } ?>    
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th colspan="5">
                                                <span class="pull-left">Items Subtotal</span>
                                                <span class="pull-right"><?= $currency_symbol?> <?= number_format($order_data['cart_sub_total'],2)?></span>
                                                <span class="clearfix"></span>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="5">
                                                <span class="pull-left">Item Tax</span>
                                                <span class="pull-right"><?= $currency_symbol?> <?= number_format($order_data['cart_tax_total'],2)?></span>
                                                <span class="clearfix"></span>
                                            </th>
                                        </tr>
                                           <?php if($checkoutData['withordertax_amount']>0){?>
                                          <tr>
                                            <th colspan="5">
                                                <span class="pull-left">Order Tax</span>
                                                <span class="pull-right"><?= $currency_symbol?> <?= number_format($checkoutData['withordertax_amount'],2);?></span>
                                                <span class="clearfix"></span>
                                            </th>
                                        </tr>
                                        <?php }?>
                                        
                                        <tr>
                                            <th colspan="5">
                                                <span class="pull-left">Shipping Amount</span>
                                                <span class="pull-right"><?= $currency_symbol?> <?= number_format($shipping_amount,2)?></span>
                                                <span class="clearfix"></span>
                                            </th>
                                        </tr>
                                        <tr>
                                            <th colspan="5">
                                                <span class="pull-left">Total Bill Amount</span>
                                                <span class="pull-right"><?= $currency_symbol?> <?= $shipping_amount + $cart_gross_total?></span>
                                                <span class="clearfix"></span>
                                            </th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <!--Plug-in Initialisation-->             
            </div>
        </div> 
    </div>
    <div class="w3l_banner_nav_right">
        <!-- payment -->
        <div class="privacy about">
            <h3>Pay<span>ment</span></h3>

            <div class="checkout-right">
                <!--Horizontal Tab-->
                <div id="parentHorizontalTab">
                    <ul class="resp-tabs-list hor_1">
                        <?php
                        foreach ($payment_methods as $key => $PatmentMethod) {
                            $paymethods[] = $PatmentMethod['code'];
                            if($PatmentMethod['code'] == 'cod'){ 
                                echo "<li>Cash on delivery (COD)</li>";                            
                            } else {
                                echo "<li>".$PatmentMethod['name']."</li>";
                            }
                        }
                        ?>                     
                    </ul>
                    <div class="resp-tabs-container hor_1">
                     <?php
                        if(in_array('cod', $paymethods)) {
                     ?>
                        <div>
                            <div class="vertical_post check_box_agile">
                                <div style="width:50%; margin: auto;">
                                    <img class="pp-img img-responsive" src="<?= $assets . $shoptheme ?>/images/cod.jpg" alt="Cash on delivery " title="Cash on delivery  Payment">
                                </div> 
                                <div class="checkbox">								
                                    <div class="check_box_one cashon_delivery">
                                        <label class="anim">
                                            <input type="checkbox" class="checkbox">
                                            <span> We also accept Credit/Debit card on delivery. Please Check with the agent.</span> 
                                        </label> 
                                        <label class="anim" style="margin-top: 20px;">
                                            <h4>Bill<span> Amount</span></h4>
                                            <h4><?= $currency_symbol?> <?= $shipping_amount + $cart_gross_total?></h4>
                                        </label>
                                    </div>
                                </div>
                               <div class="row">
                                <?php
                                    $hidden['checkoutData'] = serialize($checkoutData);
                                    $hidden['payment_type'] = 'cod';
                                    $hidden['shipping_amount'] = $shipping_amount;
                                    echo form_open('shop/submit_payment', $attrib, $hidden);
                                ?>
                                    <input class="btn btn-primary submit" type="submit" class="submit" value="Proceed Payment" style="width: 50%;" />
                                <?php
                                    echo form_close();
                                ?>
                                </div>  
                            </div>
                            <div class="clearfix"></div>
                        </div>
                    <?php } ?>
                    <?php
                        if(in_array('authorize', $paymethods)) {
                    ?>
                        <div>
                            <div class="row">
                                <div class="col-md-6">
                                    <img class="pp-img" src="<?= $assets . $shoptheme ?>/images/authorizenet.png" alt="authorizenet" title="Authorizenet Payment">
                                    <p style="margin-top: 20px;">Important: Don't worry, We have not save your card details.</p>
                                    <label class="anim" style="margin-top: 20px;">
                                        <h4>Bill<span> Amount</span></h4>
                                        <h4><?= $currency_symbol?><?= number_format($shipping_amount + $order_data['cart_gross_total'],2)?></h4>
                                    </label>
                                </div>
                                <div class="col-md-6">
                                        <?php
                                            $hidden['checkoutData'] = serialize($checkoutData);
                                            $hidden['payment_type'] = 'authorize';
                                            $hidden['amount'] = $shipping_amount + $order_data['cart_gross_total'];
                                            $hidden['shipping_amount'] = $shipping_amount;
                                            echo form_open('shop/submit_payment', $attrib, $hidden);
                                        ?>
                                            <div class="clearfix">
                                                <div class="form-group form-group-cc-number">
                                                    <label>Card Number</label>
                                                    <input class="form-control" name="cc_number" id="cc_number" maxlength="20" required="required" placeholder="xxxx xxxx xxxx xxxx"  data-inputmask="'mask': '9999 9999 9999 9999'" type="text" /><span class="cc-card-icon"></span>
                                                </div>
                                                <div class="form-group form-group-cc-name">
                                                    <label>Card Holder Name</label>
                                                    <input class="form-control" name="cc_holder" id="cc_holder" maxlength="40" required="required" placeholder="Card Holder Name" type="text" />
                                                </div>                                                
                                            </div>
                                            <div class="clearfix">                                                
                                                <div class="form-group form-group-cc-date">
                                                    <label>Expiry Date On Card </label>
                                                    <input class="form-control" name="cc_expiry" autocomplete="false" id="cc_expiry" required="required" placeholder="20xx-xx" data-inputmask="'mask': '2099-99'" maxlength="7" type="text" />
                                                </div>
                                                <div class="form-group form-group-cc-cvc">
                                                    <label>CVV</label>
                                                    <input class="form-control" name="cc_cvv" id="cc_cvv" autocomplete="new" required="required" maxlength="4" placeholder="xxxx" data-inputmask="'mask': '9999'" type="text" />
                                                </div>
                                            </div>                                            
                                            <input class="btn btn-primary submit" type="submit" class="submit" value="Proceed Payment">
                                        <?php echo form_close()?>
                                    </div>
                            </div>
                        </div>
                    <?php } ?>
                    <?php
                        if(in_array('instamojo', $paymethods)) {
                     ?> 
                        <div>
                            <div class="vertical_post check_box_agile">
                                <img class="pp-img" src="<?= $assets . $shoptheme ?>/images/instamojo.png" alt="instamojo" title="Instamojo Payment">
                                <div class="checkbox">								
                                    <div class="check_box_one cashon_delivery">
                                        <label class="anim">
                                            <input type="checkbox" class="checkbox">
                                            <span> We also accept Credit Card / Debit Card / Netbanking. Please proceed with instamojo payment options.</span> 
                                        </label> 
                                        <label class="anim" style="margin-top: 20px;">
                                            <h4> Amount : <?= $currency_symbol?><?= number_format($shipping_amount + $order_data['cart_gross_total'],2)?></h4>
                                        </label>
                                    </div>
                                </div>
                               <div class="row">
                                <?php
                                    $hidden['checkoutData'] = serialize($checkoutData);
                                    $hidden['payment_type'] = 'instamojo';
                                    $hidden['amount'] = $shipping_amount + $order_data['cart_gross_total'];
                                    $hidden['shipping_amount'] = $shipping_amount;
                                    echo form_open('shop/submit_payment', $attrib, $hidden);
                                ?>
                                   <input class="btn btn-primary submit" type="submit" class="submit" value="Proceed Payment" style="width: 50%;" />
                                <?php
                                    echo form_close();
                                ?>
                                </div>  
                            </div>
                            <div class="clearfix"></div>
                        </div>
                     <?php } ?>

                    </div>
                </div>
                <!--Plug-in Initialisation-->
                <!-- // Pay -->
            </div>
        </div>
        <!-- //payment -->
    </div>
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

        $('#parentHorizontalTab2').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            tabidentify: 'hor_2', // The tab groups identifier
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
<!-- credit-card -->
<script type="text/javascript" src="<?= $assets . $shoptheme ?>/js/creditly.js"></script>
<link rel="stylesheet" href="<?= $assets . $shoptheme ?>/css/creditly.css" type="text/css" media="all" />

<script type="text/javascript">
    $(function () {
        var creditly = Creditly.initialize(
                '.creditly-wrapper .expiration-month-and-year',
                '.creditly-wrapper .credit-card-number',
                '.creditly-wrapper .security-code',
                '.creditly-wrapper .card-type');

        $(".creditly-card-form .submit").click(function (e) {
            e.preventDefault();
            var output = creditly.validate();
            if (output) {
                // Your validated credit card output
                console.log(output);
            }
        });
    });
</script>
<!-- //credit-card -->

<!-- //js -->
<!-- script-for sticky-nav -->
<script type="text/javascript" >
    $(document).ready(function () {
        var navoffeset = $(".agileits_header").offset().top;
        $(window).scroll(function () {
            var scrollpos = $(window).scrollTop();
            if (scrollpos >= navoffeset) {
                $(".agileits_header").addClass("fixed");
            } else {
                $(".agileits_header").removeClass("fixed");
            }
        });
    });
</script>
<!-- //script-for sticky-nav -->
<!-- start-smoth-scrolling -->
<script type="text/javascript" src="<?= $assets . $shoptheme ?>/js/move-top.js"></script>
<script type="text/javascript" src="<?= $assets . $shoptheme ?>/js/easing.js"></script>
<script type="text/javascript" src="<?= $assets . $shoptheme ?>/js/jquery.inputmask.js"  ></script> 
<script type="text/javascript" >
jQuery(document).ready(function ($) {
     $('#cc_number').inputmask();
     $('#cc_expiry').inputmask();     
     $('#cc_cvv').inputmask();     
     
    $(".scroll").click(function (event) {
        event.preventDefault();
        $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1000);
    });
});
</script>
<!-- start-smoth-scrolling -->
