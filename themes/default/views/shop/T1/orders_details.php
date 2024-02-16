
<div class="modal-header alert alert-success">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
    <h4 class="modal-title">Order Details (Reff. No: <?= $order['sale']['reference_no'];?>) </h4>
</div>
<div class="modal-body">
    <div class="row">
        <div class="col-sm-6">
            <b class="modal-title">Customer Name : </b> <?= $order['sale']['customer'];?> 
        </div>
    <?php
        if(!empty($order['sale']['cf1']) || !empty($order['sale']['cf2'])) {
    ?>
        <div class="col-sm-6" >
            <div class="col-sm-6"><b>Patient Name : </b> <?= $order['sale']['cf1'];?></div>
            <div class="col-sm-6"><b>Doctor Name : </b> <?= $order['sale']['cf2'];?></div>
        </div>
    <?php }//end if. ?>
    </div>
    <div class="row">                        
        <div class="col-sm-12 clearfix bling-div">
            <div class="bill-to">
                <div class="form-outer">
                    <div class="cart-heading last">
                        <h4>Order Items <span class="pull-right" style="margin-right: 30px;">Date: <?= $order['sale']['date'];?></span></h4>
                        <div class="clearfix"></div>
                    </div>
                    <div class="table-outer">
                        <div class="table-responsive" ><br/>
                            <table class="table table-bordered table-responsive">
                                <thead>
                                    <tr class="cart_menu">
                                        <td>Item</td>
                                        <td>Price</td>
                                        <td>Quantity</td>
                                        <td>Tax</td>
                                        <td>Total</td>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php
                                  $orderitems = $order['items'];
                                  foreach ($orderitems as $key => $oitem) {
                                ?>
                                    <tr>
                                        <td class="product-image">
                                            <img src="<?= base_url('/assets/uploads/thumbs/'.$oitem->image);?>"  alt="<?= $oitem->product_name;?>" />
                                            <span class="cart_description"> 
                                                <h4><?= $oitem->product_name;?></h4></span>
                                        </td>
                                        <td class="text-right">
                                            <span><?= $Settings->symbol ?> <?= round($oitem->unit_price);?></span>
                                        </td>
                                        <td class="product-qty">
                                            <div class="cart_quantity_button text-center">
                                                <span><?= round($oitem->quantity);?></span> 
                                            </div> 
                                        </td>
                                        <td class="product-qty">
                                            <div class="cart_quantity_button text-right">
                                                <span><?= $Settings->symbol ?> <?= round($oitem->item_tax);?></span> 
                                            </div> 
                                        </td>
                                        <td class="product-total text-right">
                                            <span><?= $Settings->symbol ?> <?= round($oitem->subtotal);?></span>
                                        </td>                                                                                                  
                                    </tr>
                                <?php                                    
                                  }
                                ?>
                                    <tr class="total-count">                                     
                                        <td colspan="3"></td>
                                        <td>Sub Total:</td>
                                        <td class="tot-price"><?= $Settings->symbol ?> <?= round($order['sale']['total'])?></td>
                                    </tr>
                                <?php if($order['sale']['total_tax'] > 0) { ?>
                                    <tr class="total-count">                                     
                                        <td colspan="3"></td>
                                        <td>Tax Amt.:</td>
                                        <td class="tot-price"><?= $Settings->symbol ?> <?= round($order['sale']['total_tax'])?></td>
                                    </tr>
                                <?php } ?>
                                    <tr class="total-count">                                    
                                        <td colspan="3"></td>
                                        <td>Gross Total</td>
                                        <td class="tot-price"><?= $Settings->symbol ?> <?= round($order['sale']['grand_total'])?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>                                                                                    
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>			
    </div>
    <div class="row">
        <?php
        $billing_shipping = $order['billing_shipping'];
        $payments = $order['payment'];
        ?>
        <div class="col-sm-6 clearfix bling-div">
            <div class="bill-to">
                <div class="form-outer">
                    <div class="cart-heading">
                        <h4>Shipping Method</h4>
                        <div class="clearfix"></div>
                    </div>
                    <div>
                      <?= $billing_shipping['shipping_method_name']?>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
        <div class="col-sm-6 clearfix bling-div">
            <div class="bill-to">
                <div class="form-outer">
                    <div class="cart-heading">
                        <h4>Payment Information</h4>
                        <div class="clearfix"></div>
                    </div>
                    <b>Method: </b> <?php echo $paid_by = ($payments->paid_by == 'instomojo') ? 'Credit Card / Debit Card / Netbanking' : 'COD' ?>
                    <span class="pull-right"><b> Status:</b> <?= $order['sale']['payment_status']?></span>
                    <div class="clearfix"></div>
                </div>
            </div>
        </div>
    </div> 
    <div class="row">
        <div class="bill-to col-sm-6">
            <div class="form-outer">
                <div class="cart-heading">
                    <h4>Billing Details</h4>
                    <div class="clearfix"></div>
                </div>									 
                <div class="row" >
                    <div class="col-sm-12">
                        <table class="table table-bordered">
                            <tr>
                                <td><i class="fa fa-user" aria-hidden="true" style="width:20px;float:left;padding: 3px 0 8px;"></i> <?= $billing_shipping['billing_name']?></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-home" aria-hidden="true" style="width:20px;float:left;padding: 3px 0 8px;"></i> <?= $billing_shipping['billing_addr']?></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-envelope" aria-hidden="true" style="width:20px;float:left;padding: 3px 0 8px;"></i> <?= $billing_shipping['billing_email']?></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-phone" aria-hidden="true" style="width:20px;float:left;padding: 3px 0 8px;"></i> <?= $billing_shipping['billing_phone']?></td>
                            </tr>                                                 
                        </table>
                    </div>                                         
                </div> 
            </div> 
        </div>
        <div class="bill-to col-sm-6">
            <div class="form-outer">
                <div class="cart-heading">
                    <h4>Shipping Details</h4>
                    <div class="clearfix"></div>
                </div>									 
                <div class="row">
                    <div class="col-sm-12">
                        <table class="table table-bordered">
                            <tr>
                                <td><i class="fa fa-user" aria-hidden="true" style="width:20px;float:left;padding:3px 0 8px;"></i> <?= $billing_shipping['shipping_name']?></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-home" aria-hidden="true" style="width:20px;float:left;padding:3px 0 8px;"></i> <?= $billing_shipping['shipping_addr']?></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-envelope" aria-hidden="true" style="width:20px;float:left;padding:3px 0 8px;"></i> <?= $billing_shipping['shipping_email']?></td>
                            </tr>
                            <tr>
                                <td><i class="fa fa-phone" aria-hidden="true" style="width:20px;float:left;padding:3px 0 8px;"></i> <?= $billing_shipping['shipping_phone']?></td>
                            </tr>                                                 
                        </table>
                    </div>                                         
                </div> 
            </div> 
        </div>
    </div>
</div>
<div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
    </div>
