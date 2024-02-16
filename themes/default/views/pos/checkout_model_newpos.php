 <div class="modal fade in" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i>
                            </span><span class="sr-only"><?= lang('close'); ?></span></button>
                        <h2 class="modal-title" id="payModalLabel"><?= lang('finalize_sale'); ?></h2>
                    </div>
                    <div class="modal-body" id="payment_content">
                        <!-- //////////////////////////////////////////////// -->
                        <div class="row">
                            <div class="col-md-12 col-sm-12">
                            <div class="col-md-1 col-sm-3" id="verticalbtns">
                                <div class="class-title" style="font-weight: bold;"><?= lang('quick_cash'); ?></div>
                                <div class="btn-group btn-group-vertical" >
                                    <button type="button" class="btn btn-lg btn-info quick-cash" id="quick-payable"><i class="fa fa-inr" aria-hidden="true"></i> 0.00 </button>
                                    <?php
                                    foreach (lang('quick_cash_notes') as $cash_note_amount) {
                                        if ($cash_note_amount != 1000 && $cash_note_amount != 5000) {
                                            echo '<button type="button" class="btn btn-lg btn-warning quick-cash">'.'<i class="fa fa-inr" aria-hidden="true"></i>'.' ' . $cash_note_amount . '</button>';
                                        }
                                    }
                                    ?>
                                    <button type="button" class="btn btn-lg btn-danger" id="clear-cash-notes"><?= lang('clear'); ?></button>
                                </div>
                            </div>
                          <div class="col-md-4 col-sm-5 col-xs-7">
                                    <div class="amount-outer">
                                    <div id="amnt" class="ps-container">
                                        <?php if ($Owner || $Admin || !$this->session->userdata('biller_id')) { ?>
                                            <div class="form-group" style="margin:15px 0;">
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
                                        <div class="card-div" id="payments" style="cursor:pointer">
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
                                                                    <?php echo (isset($pos_settings->paytm) && $pos_settings->paytm == '1') ? ' <option value="paytm">Paytm</option>' : ''; ?>

                                                                    <!--<?php echo (isset($pos_settings->paytm_opt) && $pos_settings->paytm_opt== '1') ? ' <option value="paytm">Paytm</option>' : ''; ?>-->                                              
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
                                </div>
                                <div class="col-md-7 col-sm-4 col-xs-6 text-center mobcard card-div">	
                                    <div class="row card-box ps-scrollbar-y">
                                         <div class="col-md-3 col-sm-6 col-xs-6">
                                            <div class="radio-div">
                                                <input type="radio" id="checkbox1" class="card custom_payment_icon" name="colorRadio" checked value="cash">
                                                <label for="checkbox1" class="payment-method"><span class="paddingTop whitebgredB">Cash</span></label>
                                                <span class="whitebgredB payment-icon">
                                                    <img class="icon_image_option" src="<?= $assets ?>pos/images/cashh.png" alt="" class="icon_image_option2"></span></label>
                                            </div>
                                        </div>
                                         <div class="col-md-3 col-sm-6 col-xs-6">
                                            <div class="radio-div">
                                                <input type="radio" id="checkbox2" class="card custom_payment_icon" name="colorRadio" value="Cheque">
                                                <label for="checkbox2" class="payment-method"><span class="paddingTop whitebgredB">Cheque</span></label>
                                                <span class="payment-icon whitebgredB"><img src="<?= $assets ?>pos/images/cheque.jpg" alt="" class="icon_image_option"></span>
                                            </div>
                                        </div>
                                         <div class="col-md-3 col-sm-6 col-xs-6">
                                            <div class="radio-div">
                                                <input type="radio" id="checkbox3" class="card custom_payment_icon" name="colorRadio" value="deposit">
                                                <label for="checkbox3" class="payment-method"><span class="paddingTop whitebgredB">Deposit</span></label>
                                                <span class="payment-icon whitebgredB"> <img src="<?= $assets ?>pos/images/Deposit.png" alt="" class="icon_image_option"></span>
                                            </div>
                                        </div>
                                        <div class="col-md-3 col-sm-6 col-xs-6">
                                            <div class="radio-div">
                                                <input type="radio" id="checkbox4" class="card custom_payment_icon" name="colorRadio" value="other">
                                                <label for="checkbox4" class="payment-method"><span class="paddingTop whitebgredB">Other</span></label>
                                                    <span class="payment-icon whitebgredB"><img src="<?= $assets ?>pos/images/other.png" alt="" class="icon_image_option"></span>
                                            </div>
                                        </div>
                                        <?php if ($pos_settings->gift_card == '1'): ?>
                                            <div class="col-md-3 col-sm-6 col-xs-6">
                                                <div class="radio-div">
                                                    <input id="checkbox5" type="radio" class="card custom_payment_icon" name="colorRadio" value="gift_card">
                                                    <label for="checkbox5" class="payment-method"><span class="paddingTop orangebg">Gift Card</span></label>
                                                    <span class="payment-icon orangebg"><img src="<?= $assets ?>pos/images/gift-card1.jpg" alt="" class="icon_image_option"> </span></label>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($pos_settings->neft == '1'): ?>
                                            <div class="col-md-3 col-sm-6 col-xs-6">
                                                <div class="radio-div">
                                                    <input id="checkbox6" type="radio" class="card custom_payment_icon" name="colorRadio" value="NEFT">
                                                    <label for="checkbox6"  class="payment-method"><span class="paddingTop orangebg">NEFT</span></label>
                                                    <span class="payment-icon orangebg"><img src="<?= $assets ?>pos/images/neft.png" alt="" class="icon_image_option2"></span>
                                                </div>
                                            </div>
                                         <?php endif; ?>
                                        <?php if($pos_settings->debit_card == '1'): ?>
                                            <div class="col-md-3 col-sm-6 col-xs-6">
                                                <div class="radio-div">
                                                    <input id="checkbox7" title="Debit Card" type="radio" class="card custom_payment_icon" name="colorRadio" value="DC">
                                                    <label for="checkbox7" class="payment-method">
                                                         <span class="paddingTop whitebgblueB">Debit Card</span></label>
                                                        <span class="payment-icon whitebgblueB"><img src="<?= $assets ?>pos/images/debit.png" alt="debit" class="icon_image_option"></span>
                                                </div>
                                            </div>
                                         <?php endif; ?>
                                        <?php if ($pos_settings->credit_card == '1'): ?>
                                            <div class="col-md-3 col-sm-6 col-xs-6">
                                                <div class="radio-div">
                                                    <input id="checkbox8" title="Credit Card" type="radio" class="card custom_payment_icon" name="colorRadio" value="CC">
                                                    <label for="checkbox8" class="payment-method">
                                                          <span class="paddingTop whitebgblueB">Credit Card</span></label>
                                                     <span class="payment-icon whitebgblueB"><img src="<?= $assets ?>pos/images/creaditcard.jpg" alt="creaditcard" class="icon_image_option"></span>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-xs-6">
                                                <div class="radio-div">
                                                    <input title="Payswiff" type="radio" class="card custom_payment_icon" name="colorRadio" id="payswiff" value="payswiff" >
                                                    <label for="payswiff" class="payment-method">
                                                        <span class="paddingTop whitebgblueB">Pay Swiff</span></label>
                                                     <span class="payment-icon whitebgblueB">
                                                        <img src="<?= $assets ?>pos/images/paysweef.jpg" class="icon_image_option" alt="credit-card">
                                                    </span>
                                                </div>
                                            </div>
                                         <?php endif; ?>
                                        
                                         <?php if($pos_settings->paytm == '1'): ?>
                                            <div class="col-md-3 col-sm-6 col-xs-6">
                                                <div class="radio-div">
                                                    <input id="checkbox9" type="radio" class="card custom_payment_icon" name="colorRadio" value="paytm">
                                                    <label for="checkbox9" class="payment-method">
                                                        <span class="paddingTop whitebgblueB">Paytm Gateway</span>
                                                     </label>
                                                     <span class="payment-icon whitebgblueB">
                                                        <img src="<?= $assets ?>pos/images/patm.png" class="icon_image_option" alt="credit-card""></span>
                                                </div>
                                            </div>
                                         <?php endif; ?>

                                         <?php if($pos_settings->paytm_opt== '1'): ?>
                                            <div class="col-md-3 col-sm-6 col-xs-6">
                                                <div class="radio-div">
                                                    <input id="checkbox20" type="radio" class="card custom_payment_icon" name="colorRadio" value="PAYTM">
                                                    <label for="checkbox20" class="payment-method">
                                                        <span class="paddingTop whitebgblueB">PAYTM</span>
                                                     </label>
                                                     <span class="payment-icon whitebgblueB">
                                                        <img src="<?= $assets ?>pos/images/patm.png" class="icon_image_option" alt="credit-card""></span>
                                                </div>
                                            </div>
                                         <?php endif; ?>                                        

                                        <?php if($pos_settings->google_pay == '1'): ?>
                                            <div class="col-md-3 col-sm-6 col-xs-6">
                                                <div class="radio-div">
                                                    <input id="checkbox10" title="Google pay" type="radio" class="card custom_payment_icon" name="colorRadio" value="Googlepay">
                                                    <label for="checkbox10" class="payment-method">
                                                          <span class="paddingTop whitebgblueB">Google pay</span>
                                                    </label>
                                                    <span class="payment-icon whitebgblueB">
                                                        <img src="<?= $assets ?>pos/images/googlepay.jpg" class="icon_image_option" alt="googlepay">
                                                    </span>
                                                 </div>
                                            </div>
                                         <?php endif; ?>
                                        <?php if ($pos_settings->swiggy == '1'): ?>
                                            <div class="col-md-3 col-sm-6 col-xs-6">
                                                <div class="radio-div">
                                                    <input id="checkbox11" title="Swiggy" type="radio" class="card custom_payment_icon" name="colorRadio" value="swiggy">
                                                    <label for="checkbox11" class="payment-method"><span class="paddingTop whitebgblueB">Swiggy</span></label>
                                                    <span class="payment-icon whitebgblueB">
                                                        <img src="<?= $assets ?>pos/images/swiggy.png" class="icon_image_option1">
                                                    </span>
                                                </div>
                                            </div>
                                         <?php endif; ?>
                                        
                                         <?php if ($pos_settings->zomato == '1'): ?>
                                            <div class="col-md-3 col-sm-6 col-xs-6">
                                                <div class="radio-div">
                                                    <input id="checkbox12" title="Zomato" type="radio" class="card custom_payment_icon" name="colorRadio" value="zomato">
                                                    <label for="checkbox12" class="payment-method"><span class="paddingTop whitebgblueB">zomato</span></label>
                                                     <span class="payment-icon whitebgblueB">
                                                        <img src="<?= $assets ?>pos/images/zomato.png" class="icon_image_option">
                                                    </span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($pos_settings->ubereats == '1'): ?>
                                            <div class="col-md-3 col-sm-6 col-xs-6">
                                                <div class="radio-div">
                                                    <input id="checkbox13" title="Ubereats" type="radio" class="card custom_payment_icon" name="colorRadio" value="ubereats">
                                                    <label for="checkbox13" class="payment-method"><span class="paddingTop whitebgblueB">ubereats</span></label>
                                                    <span class="payment-icon whitebgblueB">
                                                        <img src="<?= $assets ?>pos/images/ubereats.jpg" class="icon_image_option">
                                                    </span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($pos_settings->complimentary == '1'): ?>
                                        <div class="col-md-3 col-sm-6 col-xs-6" >
                                                <div class="radio-div">
                                                    <input id="checkbox14" title="Debit Card" type="radio" class="card custom_payment_icon" name="colorRadio" value="complimentry">
                                                    <label for="checkbox14" class="payment-method"><span class="paddingTop whitebgblueB">Complimentry</span></label>
                                                    <span class="payment-icon whitebgblueB">
                                                        <img src="<?= $assets ?>pos/images/credit-card.jpg" class="icon_image_option2" alt="credit-card">
                                                    </span>
                                                </div>
                                        </div>
                                        <?php endif; ?>
                                        <?php if ($pos_settings->paypal_pro == '1'): ?>
                                            <div class="col-md-3 col-sm-6 col-xs-6">
                                                <div class="radio-div">
                                                    <input id="checkbox15" type="radio" class="card custom_payment_icon" name="colorRadio" value="ppp">
                                                    <label for="checkbox15" class="payment-method"><span class="paddingTop whitebgredB">PayPal</span></label>
                                                    <span class="payment-icon whitebgredB"><img src="<?= $assets ?>pos/images/paypal.jpg" class="icon_image_option" alt=""></span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($pos_settings->stripe == '1'): ?>
                                            <div class="col-md-3 col-sm-6 col-xs-6">
                                                <div class="radio-div">
                                                    <input id="checkbox16" type="radio" class="card custom_payment_icon" name="colorRadio" value="stripe">
                                                    <label for="checkbox16" class="payment-method"><span class="paddingTop orangebg">Stripe</span></label>
                                                    <span class="payment-icon orangebg ">
                                                    <img src="<?= $assets ?>pos/images/Stripe.png" class="icon_image_option1" alt=""></span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($pos_settings->authorize == '1'): ?>
                                            <div class="col-md-3 col-sm-6 col-xs-6">
                                                <div class="radio-div">
                                                    <input id="checkbox17" type="radio" class="card custom_payment_icon" name="colorRadio" value="authorize">
                                                    <label for="checkbox17" class="payment-method"><span class="paddingTop orangebg">Authorize</span></label>
                                                    <span class="payment-icon orangebg"><img src="<?= $assets ?>pos/images/authorize.png" class="icon_image_option1" alt=""></span>
                                                </diV>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($pos_settings->instamojo == '1'): ?>
                                            <div class="col-md-3 col-sm-6 col-xs-6">  
                                                <div class="radio-div">
                                                    <input id="checkbox18" type="radio" class="card custom_payment_icon" name="colorRadio" value="instamojo">
                                                    <label for="checkbox18" class="payment-method"><span class="paddingTop whitebg">Instamojo</span></label>
                                                    <span class="payment-icon whitebg"><img src="<?= $assets ?>pos/images/instamojo.jpg" class="icon_image_option"  alt="">
                                                    </span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($pos_settings->ccavenue == '1'): ?>
                                            <div class="col-md-3 col-sm-6 col-xs-6">  
                                                <div class="radio-div">
                                                    <input id="checkbox19" type="radio" class="card custom_payment_icon" name="colorRadio" value="ccavenue">
                                                    <label for="checkbox19" class="payment-method"><span class="paddingTop whitebgredB">CCavenue</span></label>
                                                    <span class="payment-icon whitebgredB"><img src="<?= $assets ?>pos/images/ccavenue.png" class="icon_image_option" alt=""></span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        
                                        
                                        <?php if ($pos_settings->paynear == '1' && !empty($this->pos_settings->paynear_web)): ?>
                                            <div class="col-md-3 col-sm-6 col-xs-6" id="paynear_btn_holder" >  
                                                <div class="radio-div">
                                                    <input type="radio" class="card custom_payment_icon" name="colorRadio" id="paynear_btn" value="paynear">
                                                    <label for="paynear_btn" class="payment-method"><span class="paddingTop whitebgredB">Paynear</span></label>
                                                    <span class="payment-icon whitebgredB"><img src="<?= $assets ?>pos/images/paynear.png" class="icon_image_option1"   alt=""></span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                        
                                        <?php if ($pos_settings->payumoney == '1'): ?>
                                            <div class="col-md-3 col-sm-6 col-xs-6" id="payumoney_btn_holder" >  
                                                <div class="radio-div">
                                                    <input type="radio" class="card custom_payment_icon" name="colorRadio" id="payumoney_btn" value="payumoney">
                                                    <label for="payumoney_btn" class="payment-method"><span class="paddingTop whitebgredB">Payumoney</span></label>
                                                    <span class="payment-icon whitebgredB"><img src="<?= $assets ?>pos/images/payu.png" class="icon_image_option1" alt=""></span>
                                                </div>
                                            </div>
                                        <?php endif; ?>
                                      </div>
                                                       
                                    <?php if ($pos_settings->paynear == '1' && !empty($this->pos_settings->paynear_app)): ?>
                                        <div class="row card-box" id="paynear_btn_app_holder" style="display:none;">

                                            <div class="col-md-3 col-sm-6 col-xs-6">  
                                                <div class="radio-div" data-toggle="tooltip" title="Paynear">
                                                    <input type="radio" class="card custom_payment_icon" name="colorRadio" id="paynear_btn1" value="paynear" data-value="1"><label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico14.png" alt=""></span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-xs-6">  
                                                <div class="radio-div" data-toggle="tooltip" title="Paynear">
                                                    <input type="radio" class="card custom_payment_icon" name="colorRadio" id="paynear_btn2" value="paynear"  data-value="2"><label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico15.png" alt=""></span></label>
                                                </div>
                                            </div>
                                            <div class="col-md-3 col-sm-6 col-xs-6">  
                                                <div class="radio-div" data-toggle="tooltip" title="Paynear">
                                                    <input type="radio" class="card custom_payment_icon" name="colorRadio" id="paynear_btn3" value="paynear"  data-value="3"><label for="checkbox1"><span><img src="<?= $assets ?>pos/images/ico16.png" alt=""></span></label>
                                                </div>
                                            </div>

                                        </div>
                                    <?php endif; ?>
                                     
                                </div>
                            </div>
                            <div class="col-xs-12">
                                <div class="font16" style="margin-top: 10px;">
                                    <table class="table table-bordered table-condensed table-striped" id="totaltab" style="margin-bottom: 0;">
                                        <tbody>
                                            <tr>
                                                <td>Total Items</td>
                                                <td class="text-right"><span id="item_count">0.00</span></td>
                                                <td>Total Payable</td>
                                                <td class="text-right"><span id="twt">0.00</span></td>
                                                <td>Total Paying</td>
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
                        <div class="btn-group col-sm-12 marginleft1 checkoutmodalbtn">                                
                            <button class="col-5 col-xs-4 btn btn-primary cmdnotprint marginLR10 final-submit-btn" name="cmd"  id="submit-sale"><strong>Quick <?= lang('submit'); ?></strong> <img src="<?= $assets ?>pos/images/submit.png" alt="submit"></button>                                 
                            <button class="col-5 col-xs-4 btn btn-info cmdprint marginLR10 borderradius padding10 final-submit-btn" name="cmdprint" id="submit-sale"><strong><?= lang('submit'); ?> & Print</strong> <img src="<?= $assets ?>pos/images/print.png" alt="submit"></button>                                 
                            <button class="col-5 col-xs-4 btn btn-success splitpay marginLR10 borderradius padding10 final-submit-btn" name="splitpay" id="splitpay" onclick="split_order_pay()"><strong>Split Pay</strong> <img src="<?= $assets ?>pos/images/split-pay.png" alt="submit"></button>                                 
                            <button class="col-5 col-xs-4 btn btn-danger marginLR10 borderradius padding10 splitcheck final-submit-btn" type="button" onclick="split_order();" ><strong>Split Check</strong> <img src="<?= $assets ?>pos/images/split-check.png" alt="submit"></button>                                 
                            <button class="col-5 col-xs-4 btn cmdprint1 newblue marginLR10 padding10 final-submit-btn" name="cmdprint1" id="submit-sale"><strong>Other</strong> <img src="<?= $assets ?>pos/images/check.png" alt="submit"></button>
                            <!--  <a href="javascript:void(0);" onclick="return paynear_mobile_app()">Paynear APP</a> -->                                 
                        </div>
                    </div>
                  </div>
               </div>
            </div>
