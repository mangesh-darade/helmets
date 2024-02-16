 <div class="modal fade in" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i>
                            </span><span class="sr-only"><?= lang('close'); ?></span></button>
                        <h4 class="modal-title" id="payModalLabel"><?= lang('finalize_sale'); ?></h4>
                    </div>
                    <div class="modal-body" id="payment_content">
                        <!-- //////////////////////////////////////////////// -->
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                                <div class="class-title" style="font-weight: bold;"><?= lang('quick_cash'); ?></div>
                                <div class="btn-group btn-group-vertical">
                                    <button type="button" class="btn btn-lg btn-info quick-cash" id="quick-payable">0.00 </button>
                                    <?php
                                    foreach (lang('quick_cash_notes') as $cash_note_amount) {
                                        if ($cash_note_amount != 1000 && $cash_note_amount != 5000) {
                                            echo '<button type="button" class="btn btn-lg btn-warning quick-cash">' . $cash_note_amount . '</button>';
                                        }
                                    }
                                    ?>
                                    <button type="button" class="btn btn-lg btn-danger" id="clear-cash-notes"><?= lang('clear'); ?></button>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="amount-outer">
                                <div class="col-md-7 col-sm-7 col-xs-7">
                                    <div id="amnt" class="ps-container">
                                        <?php if ($Owner || $Admin || !$this->session->userdata('biller_id')) { ?>
                                            <div class="form-group" style="margin:0;">
                                                <!--?=lang("biller", "biller");?-->
                                                <?php
                                                foreach ($billers as $biller) {
                                                    $bl[$biller->id] = $biller->company != '-' ? $biller->name . '(' . $biller->company . ')' : $biller->name;
                                                }
                                                echo form_dropdown('biller', $bl, (isset($_POST['biller']) ? $_POST['biller'] : $pos_settings->default_biller), 'class="form-control" id="posbiller" required="required"');
                                                ?>
                                            </div>
                                            <?php
                                        } else {
                                            $biller_input = array(
                                                'type' => 'hidden',
                                                'name' => 'biller',
                                                'id' => 'posbiller',
                                                'value' => $this->session->userdata('biller_id'),
                                            );
                                            echo form_input($biller_input);
                                        }
                                        ?>
                                        <div class="form-group">
                                            <div class="row">
                                                <div class="col-sm-6 col-xs-6">
                                                    <?= form_textarea('sale_note', '', 'id="sale_note" class="form-control kb-text skip" style="height: 35px;" placeholder="' . lang('sale_note') . '" maxlength="250"'); ?>
                                                </div>
                                                <div class="col-sm-6 col-xs-6">
                                                    <?= form_textarea('staffnote', '', 'id="staffnote" class="form-control kb-text skip" style="height: 35px;" placeholder="' . lang('staff_note') . '" maxlength="250"'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="clearfir"></div>
                                        <div id="payments" style="cursor:">
                                            <div class="well well-sm well_1">
                                                <div class="payment">
                                                    <div class="row">
                                                        <div class="col-sm-6 col-xs-6">
                                                            <div class="form-group">
                                                                <?= lang("amount", "amount_1"); ?>
                                                                <input name="amount[]" type="text" id="amount_1"  class="pa form-control kb-pad1 amount paidby_amount" onKeyPress="return isNumberKey(event)"/>
                                                                <button id="edt" class="btn-edt" onClick="enDis('amount_1')"><i class="fa fa-pencil" id="addIcon" style="font-size: 1.2em;"></i></button>
                                                            </div>
                                                        </div>
                                                        <div class="col-sm-6 col-xs-6">
                                                            <div class="form-group">
                                                                <?= lang("paying_by", "paid_by_1"); ?>
                                                                <select name="paid_by[]" id="paid_by_1" class="form-control paid_by">
                                                                    <?= $this->sma->paid_opts(); ?>
                                                                    <?= '<option value="payswiff">' . lang("Payswiff") . '</option>'; ?>
                                                                    <?= $pos_settings->paypal_pro ? '<option value="ppp">' . lang("paypal_pro") . '</option>' : ''; ?>
                                                                    <?= $pos_settings->stripe ? '<option value="stripe">' . lang("stripe") . '</option>' : ''; ?>
                                                                    <?= $pos_settings->authorize ? '<option value="authorize">' . lang("authorize") . '</option>' : ''; ?>
                                                                    <?php echo (isset($pos_settings->instamojo) && $pos_settings->instamojo == '1') ? ' <option value="instamojo">Instamojo</option>' : ''; ?>
                                                                    <?php echo (isset($pos_settings->ccavenue) && $pos_settings->ccavenue == '1') ? ' <option value="ccavenue">CCavenue</option>' : ''; ?>
                                                                    <?php echo (isset($pos_settings->paytm_opt) && $pos_settings->paytm_opt== '1') ? ' <option value="paytm">Paytm</option>' : ''; ?>
<!--<?php echo (isset($pos_settings->paytm) && $pos_settings->paytm == '1') ? ' <option value="paytm">Paytm</option>' : ''; ?>-->
                                                                    <?php echo (isset($pos_settings->paynear) && $pos_settings->paynear == '1') ? ' <option value="paynear">Paynear</option>' : ''; ?>
                                                                    <?php echo (isset($pos_settings->payumoney) && $pos_settings->payumoney == '1') ? ' <option value="payumoney">Payumoney</option>' : ''; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-sm-12">
                                                            <div class="form-group gc_1" style="display: none;">
                                                                <?= lang("gift_card_no", "gift_card_no_1"); ?>
                                                                <input name="paying_gift_card_no[]" type="text" id="gift_card_no_1" class="pa form-control kb-pad gift_card_no"/>
                                                                <div id="gc_details_1"></div>
                                                                 <div id="errorgift_1"></div>
                                                            </div>
                                                            <!--Show Deposite Balance-->
                                                             <div class="form-group db_1" style="display:none;" >
                                                                <?= lang("Deposit Balance"); ?>
                                                                <div id="depositdetails_1"></div>
                                                                <div id="errordeposit_1"></div>
                                                            </div>
                                                            <!----->
                                                            <div class="display pcc_1" style="display:none;">
                                                                <!-- Card Number: <div id="cardNo"></div>-->
                                                                <div id="cardty" style="display: none;"></div>
                                                                <div class="row">
                                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                                        <div class="form-group">
                                                                            <input name="cc_transac_no[]" type="text" id="cc_transac_no_1"
                                                                                   class="form-control kb-pad  ui-keyboard-input ui-widget-content ui-corner-all ui-keyboard-autoaccepted"
                                                                                   placeholder="Transaction No."/>
                                                                        </div>
                                                                    </div>
                                                                </div>    
                                                                <div class="row">
                                                                    <div class="col-md-12 col-sm-12 col-xs-12">
                                                                        <div class="form-group">
                                                                            <input name="cc_payment_other[]" type="text" id="cc_payment_other"
                                                                                   class="form-control kb-text ui-keyboard-input ui-widget-content ui-corner-all ui-keyboard-autoaccepted"
                                                                                   placeholder="Other"/>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <!-- <div class="form-group">
                                                                    <input type="text" id="swipe_1" class="form-control swipe kb-pad ui-keyboard-input ui-widget-content ui-corner-all ui-keyboard-autoaccepted"
                                                                            placeholder="<?= lang('swipe') ?>"/>
                                                            </div>
                                                            <div class="row">
                                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                                            <div class="form-group">
                                                                                    <input name="cc_no[]" type="text" id="pcc_no_1"
                                                                                            class="form-control kb-pad  ui-keyboard-input ui-widget-content ui-corner-all ui-keyboard-autoaccepted"
                                                                                            placeholder="<?= lang('cc_no') ?>"/>
                                                                            </div>
                                                                    </div>
                                                                    <div class="col-md-6 col-sm-6 col-xs-6">
                                                                            <div class="form-group">
                                                                                    <input name="cc_holer[]" type="text" id="pcc_holder_1"
                                                                                            class="form-control kb-text ui-keyboard-input ui-widget-content ui-corner-all ui-keyboard-autoaccepted"
                                                                                            placeholder="<?= lang('cc_holder') ?>"/>
                                                                            </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                                                            <div class="form-group">
                                                                                    <select name="cc_type[]" id="pcc_type_1"  placeholder="<?= lang('card_type') ?>">
                                                                                            <option value="Visa"><?= lang("Visa"); ?></option>
                                                                                            <option value="MasterCard"><?= lang("MasterCard"); ?></option>
                                                                                            <option value="Amex"><?= lang("Amex"); ?></option>
                                                                                            <option  value="Discover"><?= lang("Discover"); ?></option>
                                                                                    </select>
                                                                                     <input type="text" id="pcc_type_1" class="form-control" placeholder="<?= lang('card_type') ?>" />
                                                                            </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                                                            <div class="form-group">
                                                                                    <input name="cc_month[]" type="text" id="pcc_month_1"
                                                                                            class="form-control kb-pad  ui-keyboard-input ui-widget-content ui-corner-all ui-keyboard-autoaccepted"
                                                                                            placeholder="<?= lang('month') ?>"/>
                                                                            </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                                                            <div class="form-group">
                                                                                    <input name="cc_year" type="text" id="pcc_year_1"
                                                                                            class="form-control kb-pad  ui-keyboard-input ui-widget-content ui-corner-all ui-keyboard-autoaccepted"
                                                                                            placeholder="<?= lang('year') ?>"/>
                                                                            </div>
                                                                    </div>
                                                                    <div class="col-md-3 col-sm-3 col-xs-3">
                                                                            <div class="form-group">
                                                                                    <input name="cc_cvv2" type="text" id="pcc_cvv2_1"
                                                                                            class="form-control kb-pad  ui-keyboard-input ui-widget-content ui-corner-all ui-keyboard-autoaccepted"
                                                                                            placeholder="cvv"/>
                                                                            </div>
                                                                    </div>
                                                            </div>-->
                                                            </div>
                                                            <div class="display pcheque_1" style="display:none;">
                                                                <div class="form-group"><?= lang("cheque_no", "cheque_no_1"); ?>
                                                                    <input name="cheque_no[]" type="text" id="cheque_no_1"
                                                                           class="form-control cheque_no kb-pad ui-keyboard-input ui-widget-content ui-corner-all ui-keyboard-autoaccepted"/>
                                                                </div>
                                                            </div>
                                                            <div class="display pother_1" style="display:none;">
                                                                <div class="form-group">
                                                                    <input name="other_tran_no" placeholder="Transaction No" type="text" id="other_tran_no_1"
                                                                           class="form-control cheque_no kb-pad ui-keyboard-input ui-widget-content ui-corner-all ui-keyboard-autoaccepted"/>
                                                                </div>
                                                                <div class="form-group" id="note">
                                                                    <input name="other_tran_mode" placeholder="Transaction Mode" type="text" id="other_tran_mode_1"
                                                                           class="form-control kb-text ui-keyboard-input ui-widget-content ui-corner-all ui-keyboard-autoaccepted" maxlength="55"/>
                                                                </div>
                                                            </div>

                                                          

                                                            <div class="display form-group payment_note">
                                                                <?= lang('payment_note', 'payment_note'); ?>
                                                                <textarea name="payment_note[]" id="payment_note_1" class="pa form-control kb-text payment_note"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div id="multi-payment"></div>
                                        <button type="button" class="btn btn-primary col-md-12 addButton"><i class="fa fa-plus"></i> <?= lang('add_more_payments') ?></button>
                                    </div>
                                </div>
                                <div class="col-md-5 col-sm-5 col-xs-5 text-center card-div">	
                                    <div class="row card-box">
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <div class="radio-div" data-toggle="tooltip" title="Cash">
                                                <input type="radio" class="card custom_payment_icon" name="colorRadio" checked value="cash">
                                                <label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico1.png" alt=""></span></label>
                                            </div>
                                        </div>
                                        
                                         <div class="col-md-4 col-sm-4 col-xs-4">
                                            <div class="radio-div" data-toggle="tooltip" title="Cheque">
                                                <input type="radio" class="card custom_payment_icon" name="colorRadio" value="Cheque"><label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico4.png" alt=""></span></label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <div class="radio-div" data-toggle="tooltip" title="Deposit">
                                                <input type="radio" class="card custom_payment_icon" name="colorRadio" value="deposit"><label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico6.png" alt=""></span></label>
                                            </div>
                                        </div>
                                        
                                        <div class="col-md-4 col-sm-4 col-xs-4">
                                            <div class="radio-div" data-toggle="tooltip" title="Other">
                                                <input type="radio" class="card custom_payment_icon" name="colorRadio" value="other"><label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico5.png" alt=""></span></label>
                                            </div>
                                        </div>
                                        <?php if ($pos_settings->gift_card == '1'): ?>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="radio-div" data-toggle="tooltip" title="Gift Card">
                                                    <input type="radio" class="card custom_payment_icon" name="colorRadio" value="gift_card"><label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico2.png" alt=""></span></label>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($pos_settings->neft == '1'): ?>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="radio-div" data-toggle="tooltip" title="NEFT">
                                                    <input type="radio" class="card custom_payment_icon" name="colorRadio" value="NEFT"><label for="checkbox1"><span style="padding:12px 0px 13px 0px; color:#fff;">NEFT</span></label>
                                                </div>
                                            </div>
                                         <?php endif; ?>
                                        
                                        <?php if ($pos_settings->debit_card == '1'): ?>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="radio-div" data-toggle="tooltip" title="Debit Card">
                                                    <input title="Debit Card" type="radio" class="card custom_payment_icon" name="colorRadio" value="DC"><label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico3.png" alt=""></span></label>
                                                </div>
                                            </div>
                                         <?php endif; ?>
                                        <?php if($pos_settings->credit_card == '1'): ?>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="radio-div" data-toggle="tooltip" title="Credit Card">
                                                    <input title="Credit Card" type="radio" class="card custom_payment_icon" name="colorRadio" value="CC"><label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico3.png" alt=""></span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="radio-div" data-toggle="tooltip" title="Payswiff">
                                                    <input title="Payswiff" type="radio" class="card custom_payment_icon" name="colorRadio" id="payswiff" value="payswiff" ><label for="payswiff"><span style="padding:12px 0px 13px 0px; color:#fff; font-size: 12px;">Pay Swiff</span></label>
                                                </div>
                                            </div>
                                         <?php endif; ?>
                                        
                                         <?php if ($pos_settings->paytm == '1'): ?>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="radio-div" data-toggle="tooltip" title="Paytm Gateway">
                                                    <input type="radio" class="card custom_payment_icon" name="colorRadio" value="paytm"><label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico12.png" alt=""></span></label>
                                                </div>
                                            </div>
<!--                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="radio-div" data-toggle="tooltip" title="Paytm ">
                                                    <input type="radio" class="card custom_payment_icon" name="colorRadio" value="PAYTM"><label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico12.png" alt=""></span></label>
                                                </div>
                                            </div>-->
                                         <?php endif; ?>

                                         <?php if ($pos_settings->paytm_opt== '1'): ?>
                                             <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="radio-div" data-toggle="tooltip" title="Paytm">
                                                    <input type="radio" class="card custom_payment_icon" name="colorRadio" value="PAYTM"><label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico12.png" alt=""></span></label>
                                                </div>
                                            </div>
                                         <?php endif; ?>

                                        <?php if ($pos_settings->google_pay == '1'): ?>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="radio-div" data-toggle="tooltip" title="Google pay">
                                                    <input title="Google pay" type="radio" class="card custom_payment_icon" name="colorRadio" value="Googlepay"><label for="checkbox1"><span style="padding:12px 0px 13px 0px; color:#fff; font-size: 12px;">Google pay</span></label>
                                                </div>
                                            </div>
                                         <?php endif; ?>
                                        <?php if ($pos_settings->swiggy == '1'): ?>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="radio-div" data-toggle="tooltip" title="Swiggy">
                                                    <input title="Swiggy" type="radio" class="card custom_payment_icon" name="colorRadio" value="swiggy"><label for="checkbox1"><span style="padding:12px 0px 13px 0px; color:#fff; font-size: 12px;">Swiggy</span></label>
                                                </div>
                                            </div>
                                         <?php endif; ?>
                                        
                                         <?php if ($pos_settings->zomato == '1'): ?>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="radio-div" data-toggle="tooltip" title="zomato">
                                                    <input title="Zomato" type="radio" class="card custom_payment_icon" name="colorRadio" value="zomato"><label for="checkbox1"><span style="padding:12px 0px 13px 0px; color:#fff; font-size: 12px;">zomato</span></label>
                                                </div>
                                            </div>
                                         <?php endif; ?>
                                        
                                         <?php if ($pos_settings->ubereats == '1'): ?>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="radio-div" data-toggle="tooltip" title="ubereats">
                                                    <input title="Ubereats" type="radio" class="card custom_payment_icon" name="colorRadio" value="ubereats"><label for="checkbox1"><span style="padding:12px 0px 13px 0px; color:#fff; font-size: 12px;">ubereats</span></label>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                         <?php if ($pos_settings->complimentary == '1'): ?>
                                           <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="radio-div" data-toggle="tooltip" title="Complimentry">
                                                    <input title="Debit Card" type="radio" class="card custom_payment_icon" name="colorRadio" value="complimentry"><label for="checkbox1"><span style="padding:12px 0px 13px 0px; color:#fff; font-size: 12px;">Complimentry</span></label>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                         <?php if ($pos_settings->paypal_pro == '1'): ?>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="radio-div" data-toggle="tooltip" title="PPP">
                                                    <input type="radio" class="card custom_payment_icon" name="colorRadio" value="ppp"><label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico7.png" alt=""></span></label>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($pos_settings->stripe == '1'): ?>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="radio-div" data-toggle="tooltip" title="Stripe">
                                                    <input type="radio" class="card custom_payment_icon" name="colorRadio" value="stripe"><label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico8.png" alt=""></span></label>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($pos_settings->authorize == '1'): ?>
                                            <div class="col-md-4 col-sm-4 col-xs-4">
                                                <div class="radio-div"  data-toggle="tooltip" title="Authorize">
                                                    <input type="radio" class="card custom_payment_icon" name="colorRadio" value="authorize"><label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico9.png" alt=""></span></label>
                                                </diV>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($pos_settings->instamojo == '1'): ?>
                                            <div class="col-md-4 col-sm-4 col-xs-4">  
                                                <div class="radio-div"  data-toggle="tooltip" title="Instamojo">
                                                    <input type="radio" class="card custom_payment_icon" name="colorRadio" value="instamojo"><label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico10.png" alt=""></span></label>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($pos_settings->ccavenue == '1'): ?>
                                            <div class="col-md-4 col-sm-4 col-xs-4">  
                                                <div class="radio-div" data-toggle="tooltip" title="CCavenue">
                                                    <input type="radio" class="card custom_payment_icon" name="colorRadio" value="ccavenue"><label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico11.png" alt=""></span></label>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <!--<?php //if ($pos_settings->paytm == '1'): ?>
                                            <div class="col-md-4 col-sm-4 col-xs-4">  
                                                <div class="radio-div" data-toggle="tooltip" title="Paytm">
                                                    <input type="radio" class="card custom_payment_icon" name="colorRadio" value="paytm"><label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico12.png" alt=""></span></label>
                                                </div>
                                            </div>
                                        <?php //endif; ?> -->
                                        
                                        <?php if ($pos_settings->paynear == '1' && !empty($this->pos_settings->paynear_web)): ?>
                                            <div class="col-md-4 col-sm-4 col-xs-4" id="paynear_btn_holder" >  
                                                <div class="radio-div" data-toggle="tooltip" title="Paynear">
                                                    <input type="radio" class="card custom_payment_icon" name="colorRadio" id="paynear_btn" value="paynear"><label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico13.png" alt=""></span></label>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($pos_settings->payumoney == '1'): ?>
                                            <div class="col-md-4 col-sm-4 col-xs-4" id="payumoney_btn_holder" >  
                                                <div class="radio-div" data-toggle="tooltip" title="Payumoney">
                                                    <input type="radio" class="card custom_payment_icon" name="colorRadio" id="payumoney_btn" value="payumoney"><label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico17.png" alt=""></span></label>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                    </div>
                                                       
                                    <?php if ($pos_settings->paynear == '1' && !empty($this->pos_settings->paynear_app)): ?>
                                        <div class="row card-box" id="paynear_btn_app_holder" style="display:none;">

                                            <div class="col-md-4 col-sm-4 col-xs-4">  
                                                <div class="radio-div" data-toggle="tooltip" title="Paynear">
                                                    <input type="radio" class="card custom_payment_icon" name="colorRadio" id="paynear_btn1" value="paynear" data-value="1"><label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico14.png" alt=""></span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4">  
                                                <div class="radio-div" data-toggle="tooltip" title="Paynear">
                                                    <input type="radio" class="card custom_payment_icon" name="colorRadio" id="paynear_btn2" value="paynear"  data-value="2"><label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico15.png" alt=""></span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-4 col-sm-4 col-xs-4">  
                                                <div class="radio-div" data-toggle="tooltip" title="Paynear">
                                                    <input type="radio" class="card custom_payment_icon" name="colorRadio" id="paynear_btn3" value="paynear"  data-value="3"><label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico16.png" alt=""></span></label>
                                                </div>
                                            </div>

                                        </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="font16" style="margin-top: 17px;">
                                    <table class="table table-bordered table-condensed table-striped" style="margin-bottom: 0;">
                                        <tbody>
                                            <tr>
                                                <td>Total<br />Items</td>
                                                <td class="text-right"><span id="item_count">0.00</span></td>
                                                <td>Total<br />Payable</td>
                                                <td class="text-right"><span id="twt">0.00</span></td>
                                                <td>Total<br />Paying</td>
                                                <td class="text-right"><span id="total_paying">0.00</span></td>
                                                <td><?= lang("balance"); ?></td>
                                                <td class="text-right"><span id="balance" class="bal">0.00</span></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="clearfix"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer">
                        <div class="btn-group col-sm-12 ">                                
                            <button class="col-5 col-xs-4 btn btn-primary cmdnotprint final-submit-btn" name="cmd"  id="submit-sale">Quick <?= lang('submit'); ?></button>                                 
                            <button class="col-5 col-xs-4 btn btn-primary cmdprint final-submit-btn" name="cmdprint" id="submit-sale"><?= lang('submit'); ?> & Print</button>                                 
                            <button class="col-5 col-xs-4 btn btn-primary splitpay final-submit-btn" name="splitpay" id="splitpay" onclick="split_order_pay()">Split Pay</button>                                 
                            <button class="col-5 col-xs-4 btn btn-primary final-submit-btn" type="button" onclick="split_order();"  > Split Check</button>                                 
                            <button class="col-5 col-xs-4 btn btn-primary cmdprint1 final-submit-btn" name="cmdprint1" id="submit-sale">Other</button>
                            <!--  <a href="javascript:void(0);" onclick="return paynear_mobile_app()">Paynear APP</a> -->                                 
                        </div>
                    </div>
                </div>
            </div>
        </div>