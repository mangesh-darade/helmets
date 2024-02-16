 <?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php     
     function get_times( $default = '', $interval = '+30 minutes' ) {
         $output = "<option value=''>Any Time</option>";
          $current = strtotime( '00:00' );
           $end = strtotime( '23:59' );
         while( $current <= $end ) {
                $time = date( 'H:i', $current );
                $sel = ( $time == $default ) ? ' selected' : '';
                $output .= "<option value=\"{$time}\"{$sel}>" . date( 'h.i A', $current ) .'</option>';
                $current = strtotime( $interval, $current );
         }
         return $output;
}?>
<style>
    hr{height: 0.05em;
    background: #cccccc;}
</style>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-cogs"></i><?= lang('pos_settings'); ?></h2>
        <?php if(isset($pos->purchase_code) && ! empty($pos->purchase_code) && $pos->purchase_code != 'purchase_code') { ?>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown"><a href="<?= site_url('pos/updates') ?>" class="toggle_down"><i
                            class="icon fa fa-upload"></i><span class="padding-right-10"><?= lang('updates'); ?></span></a>
                </li>
            </ul>
        </div>
        <?php } ?>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <p class="introtext"><?= lang('update_info'); ?></p>
                <?php
                $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id' => 'pos_setting');
                echo form_open("pos/settings", $attrib);
                ?>
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border"><?= lang('pos_config') ?></legend>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('pro_limit', 'limit'); ?>
                            <?= form_input('pro_limit', $pos->pro_limit, 'class="form-control" id="limit" required="required"'); ?>
                        </div>
                    </div>
                     <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('pos_screen_products', 'pos_screen_products'); ?>
                            <?php $arr1 = array('0'=>'Default Category','1'=>'Favourite Products')?>
                            <?= form_dropdown('pos_screen_products', $arr1, $pos->pos_screen_products, 'class="form-control" id="pos_screen_products" required="required" style="width:100%;"');
                            ?>  
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('delete_code', 'pin_code'); ?>
                            <?= form_input('pin_code', $pos->pin_code, 'class="form-control" pattern="[0-9]{4,8}"id="pin_code"'); ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('default_category', 'default_category'); ?>
                            <?php
                            $ct[''] = lang('select').' '.lang('default_category');
                            foreach ($categories as $catrgory) {
                                $ct[$catrgory->id] = $catrgory->name;
                            }
                            echo form_dropdown('category', $ct, $pos->default_category, 'class="form-control" id="default_category" required="required" style="width:100%;"');
                            ?>
                        </div>
                    </div>
                    
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('default_biller', 'default_biller'); ?>
                            <?php
                            $bl[0] = "";
                            foreach ($billers as $biller) {
                                $bl[$biller->id] = $biller->company != '-' ? $biller->company : $biller->name;
                            }
                            if (isset($_POST['biller'])) {
                                $biller = $_POST['biller'];
                            } else {
                                $biller = "";
                            }
                            echo form_dropdown('biller', $bl, $pos->default_biller, 'class="form-control" id="default_biller" required="required" style="width:100%;"');
                            ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('default_customer', 'customer1'); ?>
                            <?= form_input('customer', (isset($_POST['customer']) ? $_POST['customer'] : $pos->default_customer), 'id="customer1" data-placeholder="' . lang("select") . ' ' . lang("customer") . '" required="required" class="form-control" style="width:100%;"'); ?>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('display_time', 'display_time'); ?>
                            <?php
                            $yn = array('1' => lang('yes'), '0' => lang('no'));
                            echo form_dropdown('display_time', $yn, $pos->display_time, 'class="form-control" id="display_time" required="required"');
                            ?>
                        </div>
                    </div>

                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('onscreen_keyboard', 'keyboard'); ?>
                            <?php
                            echo form_dropdown('keyboard', $yn, $pos->keyboard, 'class="form-control" id="keyboard" required="required"');
                            ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('product_button_color', 'product_button_color'); ?>
                            <?php $col = array('default' => lang('default'), 'primary' => lang('primary'), 'info' => lang('info'), 'warning' => lang('warning'), 'danger' => lang('danger'));
                            echo form_dropdown('product_button_color', $col, $pos->product_button_color, 'class="form-control" id="product_button_color" required="required"');
                            ?>
                        </div>
                    </div>
<div class="col-md-4 col-sm-4">
                        <div class="form-group">

                            <?= lang('product_background_color', 'limit'); ?>
                            <?= form_input('pos_theme[css_class_product][background_color]', $pos->pos_theme->css_class_product->background_color, 'class="form-control"  required="required"'); ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('tooltips', 'tooltips'); ?>
                            <?php
                            echo form_dropdown('tooltips', $yn, $pos->tooltips, 'class="form-control" id="tooltips" required="required"');
                            ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('rounding', 'rounding'); ?>
                            <?php
                            $rnd = array('0' => lang('disable'), '1' => lang('to_nearest_005'), '2' => lang('to_nearest_050'), '3' => lang('to_nearest_number'), '4' => lang('to_next_number'));
                            echo form_dropdown('rounding', $rnd, $pos->rounding, 'class="form-control" id="rounding" required="required"');
                            ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('item_order', 'item_order'); ?>
                            <?php $oopts = array(0 => lang('default'), 1 => lang('category')); ?>
                            <?= form_dropdown('item_order', $oopts, $pos->item_order, 'class="form-control" id="item_order" required="required"'); ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('after_sale_page', 'after_sale_page'); ?>
                            <?php $popts = array(0 => lang('receipt'), 1 => lang('pos')); ?>
                            <?= form_dropdown('after_sale_page', $popts, $pos->after_sale_page, 'class="form-control" id="after_sale_page" required="required"'); ?>
                        </div>
                    </div>
               
                    
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('enable_java_applet', 'enable_java_applet'); ?>
                            <?= form_dropdown('enable_java_applet', $yn, $pos->java_applet, 'class="form-control" id="enable_java_applet" required="required"'); ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('Auto Invoice SMS','Auto Invoice SMS') ?>
                            <?php $sms_option = array(1 => lang('Yes'), 0 => lang('No')); ?>
                            <?= form_dropdown('invoice_auto_sms', $sms_option, $pos->invoice_auto_sms, 'class="form-control" id="invoice_auto_sms" required="required"'); ?>
                        </div>
                    </div>  
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <label>Apply Offers* <img src="<?= $assets ?>images/new.gif" height="30px" alt="new" /></label>
                            <?php $offersStatus = array(1 => lang('Enable'), 0 => lang('Disable')); ?>
                            <?= form_dropdown('offers_status', $offersStatus, $pos->offers_status, 'class="form-control" id="offers_status" required="required"'); ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <label>Active Offers <img src="<?= $assets ?>images/new.gif" height="30px" alt="new" /></label>
                            <?php
                             $offersCategory[''] = 'None'; 
                            foreach ($offer_categories as $id => $offer) {
                                $offersCategory[$offer->offer_keyword] = $offer->offer_category;                             
                            }
                            ?>
                            <?= form_dropdown('active_offer_category', $offersCategory, $pos->active_offer_category, 'class="form-control" id="active_offer_category" '); ?>
                        </div>
                    </div>
<div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('Recent_Sale_Limit', 'Recent_Sale_Limit'); ?>
                            <?php //$ArrPosSaleLimit = array('5'=>5, '10'=>10, '15'=>15, '20'=>20); 
                                       $ArrPosSaleLimit=[];
				    for($i=10; $i<=100; $i=$i+10){
					$ArrPosSaleLimit[$i] = $i;
				    }
                            ?>
                            <?= form_dropdown('recent_pos_limit', $ArrPosSaleLimit, $pos->recent_pos_limit, 'class="form-control" id="Recent_POS_Limit" '); ?>
                        </div>
                    </div>
                   <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <label>Display Token No <img src="<?= $assets ?>images/new.gif" height="30px" alt="new" /></label>
                            <?php $TokenArr = array(1 => 'Yes', 0 => 'No'); ?>
                            <?= form_dropdown('display_token', $TokenArr, $pos->display_token, 'class="form-control" id="display_token" required="required"'); ?>
                        </div>
                    </div>
					<div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <label>Auto Selected Checkout Amount <img src="<?= $assets ?>images/new.gif" height="30px" alt="new" /></label>
                            <?php $AmtArr = array(1 => 'Yes', 0 => 'No'); ?>
                            <?= form_dropdown('pos_amount', $AmtArr, $pos->pos_amount, 'class="form-control" id="pos_amount" required="required"'); ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <label>Display Seller on POS<img src="<?= $assets ?>images/new.gif" height="30px" alt="new" /></label>
                            <?php $TokenArr = array(1 => 'Yes', 0 => 'No'); ?>
                            <?= form_dropdown('display_seller', $TokenArr, $pos->display_seller, 'class="form-control" id="display_seller" required="required"'); ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 ">
                        <div class="form-group">
                            <label>Auto Email For Alert Quantity</label>
                            <?php //$autoEmail = array(1 => 'Yes', 0 => 'No'); ?>
                            <select name='alert_qty_auto_email' id="alert_qty_auto_email" class="form-control">
                                <option value="" selected>Choose here</option>
                                <option value="0" <?php echo ($pos->alert_qty_auto_email ==0)?"selected":""?>>Don't Send</option>
                                <option value="1" <?php echo ($pos->alert_qty_auto_email == 1)?"selected":""?>>Send Email on Register closed</option>
                                <option value="2" <?php echo ($pos->alert_qty_auto_email == 2)?"selected":""?>>Send Email on Logout</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4 ">
                        <div class="form-group">
                            <label>Auto Email For Daily Sale</label>
                            <?php //$autoEmail = array(1 => 'Yes', 0 => 'No'); ?>
                            <select name='daily_sale_auto_email' id="daily_sale_auto_email" class="form-control">
                                <option value="" selected>Choose here</option>
                                <option value="0" <?php echo ($pos->daily_sale_auto_email == 0)?"selected":""?>>Don't Send</option>
                                <option value="1" <?php echo ($pos->daily_sale_auto_email == 1)?"selected":""?>>Send Email on Register closed</option>
                                <option value="2" <?php echo ($pos->daily_sale_auto_email == 2)?"selected":""?>>Send Email on Logout</option>
                            </select>
                        </div>
                    </div>
<div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <label>Display Category <img src="<?= $assets ?>images/new.gif" height="30px" alt="new" /></label>
                            <?php $DisplayCategoryArr = array(1 => 'Yes', 0 => 'No'); ?>
                            <?= form_dropdown('display_category', $DisplayCategoryArr, $pos->display_category, 'class="form-control" id="display_category" required="required"'); ?>
                        </div>
                    </div>
                    <!-- <div class="col-md-4 col-sm-4 ">
                        <div class="form-group">
                            <label>Auto Email For Alert Quantity</label>
                            <?php $autoEmail = array(1 => 'Yes', 0 => 'No'); ?>
                            <?= form_dropdown('alert_qty_auto_email', $autoEmail, $pos->alert_qty_auto_email, 'class="form-control" id="alert_qty_auto_email" required="required"'); ?>
                        </div>
                    </div>
                       <div class="col-md-4 col-sm-4 <?php if($pos->alert_qty_auto_email==0){ echo 'auto_email_time';} ?>" >
                      <div class="form-group">
                            <label>Select Time</label>
                            <?= form_dropdown('auto_email_time', get_times(), $pos->auto_email_time, 'class="form-control" id="auto_email_time" required="required"'); ?>

                        </div>
                     </div>-->
                   
                    <div class="clearfix"></div>
                    <div id="jac" class="col-md-12" style="display: none;">
                        <div class="col-md-3 col-sm-3">
                            <div class="form-group">
                                <?= lang('receipt_printer', 'rec1'); ?>
                                <?= form_input('receipt_printer', $pos->receipt_printer, 'class="form-control tip" id="rec1"'); ?>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <div class="form-group">
                                <?= lang('char_per_line', 'char_per_line'); ?>
                                <?= form_input('char_per_line', $pos->char_per_line, 'class="form-control tip" id="char_per_line" placeholder="' . lang('char_per_line') . '"'); ?>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <div class="form-group">
                                <?= lang('cash_drawer_codes', 'cash1'); ?>
                                <?= form_input('cash_drawer_codes', $pos->cash_drawer_codes, 'class="form-control tip" id="cash1" placeholder="Hex value (x1C)"'); ?>
                            </div>
                        </div>

                        <div class="col-md-3 col-sm-3">
                            <div class="form-group">
                                <?= lang('pos_list_printers', 'pos_printers'); ?>
                                <?= form_input('pos_printers', $pos->pos_printers, 'class="form-control tip" id="pos_printers"'); ?>
                            </div>
                        </div>
                        <div class="well well-sm">
                            <p>Please add <strong><?= base_url() ?></strong> to your java Exception Site List under
                                Security tab.</p>

                            <p><strong>Access Java Control Panel</strong></p>
                            <pre><strong>Windows:</strong> Control Panel > (Java Icon) Java > Security tab > Exception Site List > Edit Site List > add<br><strong>Mac:</strong> System Preferences > (Java Icon) Java > Security tab > Exception Site List > Edit Site List > add</pre>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border"><?= lang('custom_fileds') ?></legend>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <?= lang('cf_title1', 'tcf1'); ?>
                            <?= form_input('cf_title1', $pos->cf_title1, 'class="form-control tip" id="tcf1"'); ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <?= lang('cf_value1', 'vcf1'); ?>
                            <?= form_input('cf_value1', $pos->cf_value1, 'class="form-control tip" id="vcf1"'); ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <?= lang('cf_title2', 'tcf2'); ?>
                            <?= form_input('cf_title2', $pos->cf_title2, 'class="form-control tip" id="tcf2"'); ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <?= lang('cf_value2', 'vcf2'); ?>
                            <?= form_input('cf_value2', $pos->cf_value2, 'class="form-control tip" id="vcf2"'); ?>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border"><?= lang('shortcuts') ?></legend>
                    <p><?= lang('shortcut_heading') ?></p>

                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('focus_add_item', 'focus_add_item'); ?>
                            <?= form_input('focus_add_item', $pos->focus_add_item, 'class="form-control tip" id="focus_add_item"  readonly="disabled"'); ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('add_manual_product', 'add_manual_product'); ?>
                            <?= form_input('add_manual_product', $pos->add_manual_product, 'class="form-control tip" id="add_manual_product"  readonly="disabled"'); ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('customer_selection', 'customer_selection'); ?>
                            <?= form_input('customer_selection', $pos->customer_selection, 'class="form-control tip" id="customer_selection"  readonly="disabled"'); ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('add_customer', 'add_customer'); ?>
                            <?= form_input('add_customer', $pos->add_customer, 'class="form-control tip" id="add_customer"  readonly="disabled"'); ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4" style="display: none;">
                        <div class="form-group">
                            <?= lang('toggle_category_slider', 'toggle_category_slider'); ?>
                            <?= form_input('toggle_category_slider', $pos->toggle_category_slider, 'class="form-control tip" id="toggle_category_slider"  readonly="disabled"'); ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4" style="display: none;">
                        <div class="form-group">
                            <?= lang('toggle_subcategory_slider', 'toggle_subcategory_slider'); ?>
                            <?= form_input('toggle_subcategory_slider', $pos->toggle_subcategory_slider, 'class="form-control tip" id="toggle_subcategory_slider"  readonly="disabled"'); ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4" style="display: none;">
                        <div class="form-group">
                            <?= lang('toggle_brands_slider', 'toggle_brands_slider'); ?>
                            <?= form_input('toggle_brands_slider', $pos->toggle_brands_slider, 'class="form-control tip" id="toggle_brands_slider"  readonly="disabled"'); ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('cancel_sale', 'cancel_sale'); ?>
                            <?= form_input('cancel_sale', $pos->cancel_sale, 'class="form-control tip" id="cancel_sale"  readonly="disabled"'); ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('suspend_sale', 'suspend_sale'); ?>
                            <?= form_input('suspend_sale', $pos->suspend_sale, 'class="form-control tip" id="suspend_sale"  readonly="disabled"'); ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4" style="display: none;">
                        <div class="form-group">
                            <?= lang('print_items_list', 'print_items_list'); ?>
                            <?= form_input('print_items_list', $pos->print_items_list, 'class="form-control tip" id="print_items_list"  readonly="disabled"'); ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('finalize_sale', 'finalize_sale'); ?>
                            <?= form_input('finalize_sale', $pos->finalize_sale, 'class="form-control tip" id="finalize_sale"  readonly="disabled"'); ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('today_sale', 'today_sale'); ?>
                            <?= form_input('today_sale', $pos->today_sale, 'class="form-control tip" id="today_sale"  readonly="disabled"'); ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('open_hold_bills', 'open_hold_bills'); ?>
                            <?= form_input('open_hold_bills', $pos->open_hold_bills, 'class="form-control tip" id="open_hold_bills"  readonly="disabled"'); ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('close_register', 'close_register'); ?>
                            <?= form_input('close_register', $pos->close_register, 'class="form-control tip" id="close_register"  readonly="disabled"'); ?>
                        </div>
                    </div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('submit_and_print', 'submit_and_print'); ?>
                            <?= form_input('submit_and_print', $pos->submit_and_print, 'class="form-control tip" id="submit_and_print"  readonly="disabled"'); ?>
                        </div>
                    </div>
					 <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('other', 'other'); ?>
                            <?= form_input('other', $pos->other, 'class="form-control tip" id="other"  readonly="disabled"'); ?>
                        </div>
                    </div>
                </fieldset>
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border"><?= lang('payment_option') ?></legend>
                    <div class="row form-group all">
                        
                        <div class="col-sm-3 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo($pos->gift_card) ? 'Checked' : ''; ?>  value="1" name="gift_card">
                                <b> <?= lang("Gift Card"); ?></b>
                            </div>
                        </div>
                        
                        <div class="col-sm-3 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo($pos->debit_card) ? 'Checked' : ''; ?>  value="1" name="debit_card">
                                <b> <?= lang("Debit Card"); ?></b>
                            </div>
                        </div>
                        
                        <div class="col-sm-3 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo($pos->credit_card) ? 'Checked' : ''; ?>  value="1" name="credit_card">
                                <b> <?= lang("Credit Card"); ?></b>
                            </div>
                        </div>
                        <div class="col-sm-3 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo($pos->neft) ? 'Checked' : ''; ?>  value="1" name="neft">
                                <b> <?= lang("NEFT"); ?></b>
                            </div>
                        </div>
                        
                        <div class="col-sm-3 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo($pos->paytm_opt) ? 'Checked' : ''; ?>  value="1" name="paytm_opt">
                                <b> <?= lang("PAYTM"); ?></b>
                            </div>
                        </div>
                        
                        <div class="col-sm-3 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo($pos->google_pay) ? 'Checked' : ''; ?>  value="1" name="google_pay">
                                <b> <?= lang("Google Pay"); ?></b>
                            </div>
                        </div>
                        
                        <div class="col-sm-3 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo($pos->swiggy) ? 'Checked' : ''; ?>  value="1" name="swiggy">
                                <b> <?= lang("Swiggy"); ?></b>
                            </div>
                        </div>
                        
                        <div class="col-sm-3 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo($pos->zomato) ? 'Checked' : ''; ?>  value="1" name="zomato">
                                <b> <?= lang("Zomato"); ?></b>
                            </div>
                        </div>
                        
                        <div class="col-sm-3 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo($pos->ubereats) ? 'Checked' : ''; ?>  value="1" name="ubereats">
                                <b> <?= lang("Ubereats"); ?></b>
                            </div>
                        </div>
                        
                        <div class="col-sm-3 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo($pos->complimentary) ? 'Checked' : ''; ?>  value="1" name="complimentary">
                                <b> <?= lang("Complimentary"); ?></b>
                            </div>
                        </div>
                        
                        
                        
                    </div> 
                   
                </fieldset>
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border"><?= lang('payment_gateways') ?></legend>
                    <?php
                    if ($paypal_balance) {
                        if (! isset ($paypal_balance['error']) ) {
                            echo '<div class="alert alert-success"><button data-dismiss="alert" class="close" type="button">Ã—</button><strong>' . lang('paypal_balance') . '</strong><p>';
                            $blns = sizeof($paypal_balance['amount']);
                            $r = 1;
                            foreach ($paypal_balance['amount'] as $balance) {
                                echo lang('balance') . ': ' . $balance['L_AMT'] . ' (' . $balance['L_CURRENCYCODE'] . ')';
                                if ($blns != $r) {
                                    echo ', ';
                                }
                                $r++;
                            }
                            echo '</p></div>';
                        } else {
                            echo '<div class="alert alert-danger"><button data-dismiss="alert" class="close" type="button">Ã—</button><p>';
                            foreach ($paypal_balance['message'] as $msg) {
                                echo $msg['L_SHORTMESSAGE'].' ('.$msg['L_ERRORCODE'].'): '.$msg['L_LONGMESSAGE'].'<br>';
                            }
                            echo '</p></div>';
                        }
                    }
                    ?>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('paypal_pro', 'paypal_pro'); ?>
                            <?= form_dropdown('paypal_pro', $yn, $pos->paypal_pro, 'class="form-control" id="paypal_pro" required="required"'); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div id="paypal_pro_con">
                        <div class="col-md-3 col-sm-3">
                            <div class="form-group">
                                <?= lang('APIUsername', 'APIUsername'); ?>
                                <?= form_input('APIUsername', $APIUsername, 'class="form-control tip" id="APIUsername"'); ?>
                            </div>
                        </div>
                        <div class="col-md-3 col-sm-3">
                            <div class="form-group">
                                <?= lang('APIPassword', 'APIPassword'); ?>
                                <?= form_input('APIPassword', $APIPassword, 'class="form-control tip" id="APIPassword"'); ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <?= lang('APISignature', 'APISignature'); ?>
                                <?= form_input('APISignature', $APISignature, 'class="form-control tip" id="APISignature"'); ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <hr/>
                    <?php
                    if ($stripe_balance) {
                        echo '<div class="alert alert-success"><button data-dismiss="alert" class="close" type="button">Ã—</button><strong>' . lang('stripe_balance') . '</strong>';
                        echo '<p>' . lang('pending_amount') . ': ' . $stripe_balance['pending_amount'] . ' (' . $stripe_balance['pending_currency'] . ')';
                        echo ', ' . lang('available_amount') . ': ' . $stripe_balance['available_amount'] . ' (' . $stripe_balance['available_currency'] . ')</p>';
                        echo '</div>';
                    }
                    ?>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('stripe', 'stripe'); ?>
                            <?= form_dropdown('stripe', $yn, $pos->stripe, 'class="form-control" id="stripe" required="required"'); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div id="stripe_con">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <?= lang('stripe_secret_key', 'stripe_secret_key'); ?>
                                <?= form_input('stripe_secret_key', $stripe_secret_key, 'class="form-control tip" id="stripe_secret_key"'); ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <?= lang('stripe_publishable_key', 'stripe_publishable_key'); ?>
                                <?= form_input('stripe_publishable_key', $stripe_publishable_key, 'class="form-control tip" id="stripe_publishable_key"'); ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <hr/>
                    <div class="clearfix"></div>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('authorize', 'authorize'); ?>
                            <?= form_dropdown('authorize', $yn, $pos->authorize, 'class="form-control" id="authorize" required="required"'); ?>
                        </div>
                    </div>
                     <div class="clearfix"></div>
                    <div id="authorize_con">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <?= lang('api_login_id', 'api_login_id'); ?>
                                <?= form_input('api_login_id', $api_login_id, 'class="form-control tip" id="api_login_id"'); ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <b></b><?= 'API Transaction Key'; ?></b>
                                <?= form_input('api_transaction_key', $api_transaction_key, 'class="form-control tip" id="api_transaction_key"'); ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                     <hr/>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                           <?= lang('instamojo', 'instamojo'); ?>
                            <?= form_dropdown('instamojo', $yn, $pos->instamojo, 'class="form-control" id="instamojo" required="required"'); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div> 
                    <div id="instamojo_con">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                  <?= lang('instamojo_api_key', 'instamojo_api_key'); ?>
  
                                <?= form_input('instamojo_api_key', $instamojo_api_key, 'class="form-control tip" id="instamojo_api_key"'); ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                               <?= lang('instamojo_auth_token', 'instamojo_auth_token'); ?>
                                 <?= form_input('instamojo_auth_token', $instamojo_auth_token, 'class="form-control tip" id="instamojo_auth_token"'); ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <hr/>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('ccavenue', 'ccavenue'); ?>
                            <?= form_dropdown('ccavenue', $yn, $pos->ccavenue, 'class="form-control" id="ccavenue" required="required"'); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div> 
                    <div id="ccavenue_con">
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <?= lang('ccavenue_merchant_id', 'ccavenue_merchant_id'); ?>
                                <?= form_input('ccavenue_merchant_id', $ccavenue_merchant_id, 'class="form-control tip" id="ccavenue_merchant_id"'); ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <?= lang('ccavenue_access_code', 'ccavenue_access_code'); ?>
                                 <?= form_input('ccavenue_access_code', $ccavenue_access_code, 'class="form-control tip" id="ccavenue_access_code"'); ?>
                            </div>
                        </div>
                        <div class="col-md-6 col-sm-6">
                            <div class="form-group">
                                <?= lang('ccavenue_working_key', 'ccavenue_working_key'); ?>
                                 <?= form_input('ccavenue_working_key', $ccavenue_working_key, 'class="form-control tip" id="ccavenue_working_key"'); ?>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <hr/>
                    <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <?= lang('paytm', 'paytm'); ?>
                            <?= form_dropdown('paytm', $yn, $pos->paytm, 'class="form-control" id="paytm" required="required"'); ?>
                        </div>
                    </div>
                <div class="clearfix"></div> 
                <div id="paytm_con">
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <?= lang('paytm_environment', 'paytm_environment'); ?>
                            <?= form_dropdown('PAYTM_ENVIRONMENT',  array('TEST' => lang('TEST'), 'PROD' => lang('PROD')) , $PAYTM_ENVIRONMENT, 'class="form-control" id="PAYTM_ENVIRONMENT" required="required"'); ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                                <?= lang('paytm_merchant_key', 'paytm_merchant_key'); ?>
                                <?= form_input('PAYTM_MERCHANT_KEY', $PAYTM_MERCHANT_KEY, 'class="form-control tip" id="PAYTM_MERCHANT_KEY"'); ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                           <?= lang('paytm_merchant_mid', 'paytm_merchant_mid'); ?>
                                 <?= form_input('PAYTM_MERCHANT_MID', $PAYTM_MERCHANT_MID, 'class="form-control tip" id="PAYTM_MERCHANT_MID"'); ?>
                        </div>
                    </div>
                    <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                           <?= lang('paytm_merchant_website', 'paytm_merchant_website'); ?>
                                 <?= form_input('PAYTM_MERCHANT_WEBSITE', $PAYTM_MERCHANT_WEBSITE, 'class="form-control tip" id="PAYTM_MERCHANT_WEBSITE"'); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div> 
                </div>  
                 <hr>
                <div class="col-md-4 col-sm-4">
                     <div class="form-group">
                        <?= lang('paynear', 'paynear'); ?>
                        
                         <?= form_dropdown('paynear', $yn, $pos->paynear, 'class="form-control" id="paynear" required="required"'); ?>
                     </div>
                 </div>
                 <div class="clearfix"></div> 
                 <div id="paynear_con">
                 
                    <div class="col-md-6 col-sm-6">
                         <div class="form-group">
                            <?= lang('paynear_app_merchant_id', 'paynear_app_merchant_id'); ?>
                            <?= form_input('PAYNEAR_APP_MERCHANT_ID', $PAYNEAR_APP_MERCHANT_ID, 'class="form-control tip" id="PAYNEAR_APP_MERCHANT_ID"'); ?>
                         </div>
                     </div>
                     
                     <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <?= lang('paynear_app_secret_key', 'paynear_app_secret_key'); ?>
                            <?= form_input('PAYNEAR_APP_SECRET_KEY', $PAYNEAR_APP_SECRET_KEY, 'class="form-control tip" id="PAYNEAR_APP_SECRET_KEY"'); ?>
                        </div>
                     </div>
                     
                      <div class="col-md-6 col-sm-6">
                         <div class="form-group">
                            <?= lang('paynear_merchant_id', 'paynear_merchant_id'); ?>
                            <?= form_input('PAYNEAR_MERCHANT_ID', $PAYNEAR_MERCHANT_ID, 'class="form-control tip" id="PAYNEAR_MERCHANT_ID"'); ?>
                         </div>
                     </div>
                     <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <?= lang('paynear_secret_key', 'paynear_secret_key'); ?>
                            <?= form_input('PAYNEAR_SECRET_KEY', $PAYNEAR_SECRET_KEY, 'class="form-control tip" id="PAYNEAR_SECRET_KEY"'); ?>
                        </div>
                     </div>
                     
                    
                     <div class="clearfix"></div> 
                 </div> 
                  <hr>
                 <div class="col-md-4 col-sm-4">
                     <div class="form-group">
                        <?= lang('payumoney', 'payumoney'); ?>
                        <?= form_dropdown('payumoney', $yn, $pos->payumoney, 'class="form-control" id="payumoney" required="required"'); ?>
                     </div>
                 </div>
                 <div class="clearfix"></div> 
                 <div id="payumoney_con">
                 
                    <div class="col-md-6 col-sm-6">
                         <div class="form-group">
                            <?= lang('payumoney_mid', 'payumoney_mid'); ?>
                            <?= form_input('PAYUMONEY_MID', $PAYUMONEY_MID, 'class="form-control tip" id="PAYUMONEY_MID"'); ?>
                         </div>
                     </div>
                     
                     <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <?= lang('payumoney_key', 'payumoney_key'); ?>
                            <?= form_input('PAYUMONEY_KEY', $PAYUMONEY_KEY, 'class="form-control tip" id="PAYUMONEY_KEY"'); ?>
                        </div>
                     </div>
                     
                      <div class="col-md-6 col-sm-6">
                         <div class="form-group">
                            <?= lang('payumoney_salt', 'payumoney_salt'); ?>
                            <?= form_input('PAYUMONEY_SALT', $PAYUMONEY_SALT, 'class="form-control tip" id="PAYUMONEY_SALT"'); ?>
                         </div>
                     </div>
                     
                     <div class="col-md-6 col-sm-6">
                        <div class="form-group">
                            <?= lang('payumoney_auth_header', 'payumoney_auth_header'); ?>
                             <?= form_input('PAYUMONEY_AUTH_HEADER', $PAYUMONEY_AUTH_HEADER, 'class="form-control tip" id="PAYUMONEY_AUTH_HEADER"'); ?>
                        </div>
                     </div>
                    <div class="clearfix"></div> 
                 </div> 
                 
                </fieldset>
 
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Eshop Setting</legend>
                    <div class="row">
                        <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <b><?= lang('Default Warehouse'); ?></b>
                            <?php
                            $wh = array();
                            $wh[0] = "";
                            foreach ($warehouses as $warehouse) {
                                $wh[$warehouse->id] =   $warehouse->name;
                            }
                            $_warehouse = '';
                            if (isset($_POST['warehouse'])) {
                                $_warehouse = $_POST['warehouse'];
                            }
                            echo form_dropdown('default_eshop_warehouse', $wh, $pos->default_eshop_warehouse, 'class="form-control" id="default_eshop_warehouse" required="required" style="width:100%;"');
                            ?>
                        </div> 
                    </div>
                        <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                            <b><?= lang('Eshop Payment System'); ?></b>
                            <?php
                            $es_pay = array();
                            $es_pay[''] = "";
                            if(!empty($pos->instamojo)){ $es_pay['instamojo'] = "Instamojo";}
                            if(!empty($pos->ccavenue)){ $es_pay['ccavenue'] = "CCavenue";}
                            if(empty($pos->paypal_pro)){ $es_pay['paypal_pro'] = "Paypal_pro";}
                            if(!empty($pos->payumoney)){ $es_pay['payumoney'] = "Payumoney";}
                            if(!empty($pos->paynear)){ $es_pay['paynear'] = "Paynear";} 
                            if(empty($pos->stripe)){ $es_pay['stripe'] = "Stripe";}
                            if(!empty($pos->authorize)){ $es_pay['authorize'] = "Authorize.net";} 
                            echo form_dropdown('default_eshop_pay', $es_pay, $pos->default_eshop_pay, 'class="form-control" id="default_eshop_pay"   style="width:100%;"');
                            ?>
                        </div> 
                    </div>
                        <div class="col-md-4 col-sm-4">
                        <div class="form-group">
                           <b> <?= lang('Allow COD Option'); ?></b>
                            <?= form_dropdown('eshop_cod', $yn, $pos->eshop_cod, 'class="form-control" id="eshop_cod" required="required"'); ?>
                        </div> 
                    </div>
                    </div>
                    <div class="row">
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("order_tax", "sltax2"); ?>
                                <?php
                                $tr[""] = "";
                                foreach ($tax_rates as $tax) {
                                    $tr[$tax->id] = $tax->name;
                                }
                               echo form_dropdown('eshop_order_tax', $tr, (isset($_POST['eshop_order_tax']) ? $_POST['eshop_order_tax'] : $pos->eshop_order_tax), 'id="eshop_order_tax" data-placeholder="' . lang("select") . ' ' . lang("order_tax") . '" class="form-contro" style="width:100%;"');
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Default Eshop Theme *</label>
                                <?php
                                $eshopThems = array('T1'=>'Default', 'T2'=>'Green & Red');
                                
                               echo form_dropdown('default_eshop_theame', $eshopThems, (isset($_POST['default_eshop_theame']) ? $_POST['default_eshop_theame'] : $pos->default_eshop_theame), 'id="default_eshop_theame" data-placeholder="' . lang("select") . ' " class="form-contro" style="width:100%;"');
                                ?>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label>Free delivery on minimum order (Rs.)* <img src="<?= $assets ?>images/new.gif" height="30px" alt="new" /></label>
                                <?= form_input('eshop_free_delivery_on_order', $pos->eshop_free_delivery_on_order, 'class="form-control tip" id="eshop_free_delivery_on_order"'); ?>
                            </div>
                        </div>
                    </div>
                </fieldset>
                <?= form_submit('update_settings', lang('update_settings'), 'class="btn btn-primary"'); ?>

                <?= form_close(); ?>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function (e) {
    $('.auto_email_time').hide();
    	<?php if($_GET["pos_setting_change"]==1):?>
        	localStorage.setItem('poscustomer', '<?php echo $pos->default_customer;?>' );
       <?php endif;?>  
//        $('#pos_setting').bootstrapValidator({
//            feedbackIcons: {
//                valid: 'fa fa-check',
//                invalid: 'fa fa-times',
//                validating: 'fa fa-refresh'
//            }, excluded: [':disabled']
//        });
        $('select.select').select2({minimumResultsForSearch: 7});
         fields = $('.form-control');
         $.each(fields, function () {
            var id = $(this).attr('id');
            var iname = $(this).attr('name');
          
            var iid = '#' + id;
             if (!!$(this).attr('data-bv-notempty') || !!$(this).attr('required')) {
               // $("label[for='" + id + "']").append(' *');
                 $(document).on('change', iid, function () {
                    $('#pos_setting').bootstrapValidator('revalidateField', iname);
                });
             }
         });
        $('input[type="checkbox"],[type="radio"]').not('.skip').iCheck({
            checkboxClass: 'icheckbox_square-blue',
            radioClass: 'iradio_square-blue',
            increaseArea: '20%' // optional
        });

        $('#customer1').val('<?= $pos->default_customer; ?>').select2({
            minimumInputLength: 1,
            data: [],
            initSelection: function (element, callback) {
                $.ajax({
                    type: "get", async: false,
                    url: site.base_url+"customers/getCustomer/" + $(element).val(),
                    dataType: "json",
                    success: function (data) {
                        callback(data[0]);
                    }
                });
            },
            ajax: {
                url: site.base_url + "customers/suggestions",
                dataType: 'json',
                quietMillis: 15,
                data: function (term, page) {
                    return {
                        term: term,
                        limit: 10
                    };
                },
                results: function (data, page) {
                    if (data.results != null) {
                        return {results: data.results};
                    } else {
                        return {results: [{id: '', text: 'No Match Found'}]};
                    }
                }
            }
        });

        $('#enable_java_applet').change(function () {
            var ja = $(this).val();
            if (ja == 1) {
                $('#jac').slideDown();
            } else {
                $('#jac').slideUp();
            }
        });
        var ja = '<?=$pos->java_applet?>';
        if (ja == 1) {
            $('#jac').slideDown();
        } else {
            $('#jac').slideUp();
        }
        $('#paypal_pro').change(function () {
            var pp = $(this).val();
            if (pp == 1) {
                $('#paypal_pro_con').slideDown();
            } else {
                $('#paypal_pro_con').slideUp();
            }
        });
        $('#stripe').change(function () {
            var st = $(this).val();
            if (st == 1) {
                $('#stripe_con').slideDown();
            } else {
                $('#stripe_con').slideUp();
            }
        });
        $('#authorize').change(function () {
            var st = $(this).val();
            if (st == 1) {
                $('#authorize_con').slideDown();
            } else {
                $('#authorize_con').slideUp();
            }
        });
        
        $('#instamojo').change(function () {
            var st = $(this).val();
            if (st == 1) {
                $('#instamojo_con').slideDown();
            } else {
                $('#instamojo_con').slideUp();
            }
        });
        
         $('#ccavenue').change(function () {
            var st = $(this).val();
            if (st == 1) {
                $('#ccavenue_con').slideDown();
            } else {
                $('#ccavenue_con').slideUp();
            }
        });
        
         $('#paynear').change(function () {
            var st = $(this).val();
            if (st == 1) {
                $('#paynear_con').slideDown();
            } else {
                $('#paynear_con').slideUp();
            }
        });
        
         $('#payumoney').change(function () {
            var st = $(this).val();
            if (st == 1) {
                $('#payumoney_con').slideDown();
            } else {
                $('#payumoney_con').slideUp();
            }
        });

        
        var st = '<?=$pos->stripe?>';
        var pp = '<?=$pos->paypal_pro?>';
        var az = '<?=$pos->authorize?>';
        var im = '<?= $pos->instamojo ?>';
        var cc = '<?= $pos->ccavenue ?>';
        var pn = '<?= $pos->paynear ?>';
        var pu = '<?= $pos->payumoney ?>';
       
        
        if (st == 1) {
            $('#stripe_con').slideDown();
        } else {
            $('#stripe_con').slideUp();
        }
        if (pp == 1) {
            $('#paypal_pro_con').slideDown();
        } else {
            $('#paypal_pro_con').slideUp();
        }
        if (az == 1) {
            $('#authorize_con').slideDown();
        } else {
            $('#authorize_con').slideUp();
        }
        
        if (im == 1) {
            $('#instamojo_con').slideDown();
        } else {
            $('#instamojo_con').slideUp();
        }
        
         if (cc == 1) {
            $('#ccavenue_con').slideDown();
        } else {
            $('#ccavenue_con').slideUp();
        }
        
         if (pn == 1) {
            $('#paynear_con').slideDown();
        } else {
            $('#paynear_con').slideUp();
        }
          if (pu == 1) {
            $('#payumoney_con').slideDown();
        } else {
            $('#payumoney_con').slideUp();
        }
         $('.auto_email_time').hide();
         $('#alert_qty_auto_email').change(function(){
            var email = $(this).val();
            if(email == 1){
             $('.auto_email_time').show();
            }else{
                $('.auto_email_time').hide();
            }
         })

    });
      function changeText1() {
      var setEmail = '<?= $this->pos_settings->alert_qty_auto_email ?>';
      var setTime = '<?php echo $this->pos_settings->auto_email_time ?>';
      
        // var m = (d.getMinutes()<10?'0':'') + d.getMinutes() ;var d = new Date();
     // var h = d.getHours();
     var d = new Date($.now());
     var currtime = d.getHours()+":"+d.getMinutes();
      if(String(setTime)==String(currtime)) {
         $.ajax({
            type: "get", 
            async: false,
            url: "<?= base_url('pos/SendAutoEmail')?>",
            success: function (data) {
            console.log('success');
               // alert('success' + currtime +'$$$' +  setTime);
               /* if(data) {
                    alert('success');
                }
                 else{
                     alert('failed');
                 }*/
            },
            error:function(){
              console.log('error');  
            },
        });
    }
   }
    

setInterval(changeText1, 30000);
changeText1();
     

</script>
