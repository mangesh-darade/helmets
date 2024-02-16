<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();">
                <i class="fa fa-print"></i> <?= lang('print'); ?>
            </button>
          
            <h4 class="modal-title"
                id="myModalLabel"><?= lang('sales') . ' (' . $this->sma->hrld($this->session->userdata('register_open_time')) . ' - ' . $this->sma->hrld(date('Y-m-d H:i:s')) . ')'; ?></h4>
        </div>
        <div class="modal-body">
       
         
            <table width="100%" class="stable">
                <tr>
                    <td style="border-bottom: 1px solid #EEE;"><h4><?= lang('cash_in_hand'); ?>:</h4></td>
                    <td style="text-align:right; border-bottom: 1px solid #EEE;"><h4>
                            <span><?= $this->sma->formatMoney($this->session->userdata('cash_in_hand')); ?></span></h4>
                    </td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #EEE;"><h4><?= lang('cash_sale'); ?>:</h4></td>
                    <td style="text-align:right; border-bottom: 1px solid #EEE;"><h4>
                            <span><?= $this->sma->formatMoney($cashsales->paid ? $cashsales->paid : '0.00') ?> </span>
                           <!-- <span><?= $this->sma->formatMoney($cashsales->paid ? $cashsales->paid : '0.00') . ' (' . $this->sma->formatMoney($cashsales->total ? $cashsales->total : '0.00') . ')'; ?></span>-->
                        </h4></td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #EEE;"><h4><?= lang('ch_sale'); ?>:</h4></td>
                    <td style="text-align:right;border-bottom: 1px solid #EEE;"><h4>
                            <span><?= $this->sma->formatMoney($chsales->paid ? $chsales->paid : '0.00')?> </span>
                            
                            <!--<span><?= $this->sma->formatMoney($chsales->paid ? $chsales->paid : '0.00') . ' (' . $this->sma->formatMoney($chsales->total ? $chsales->total : '0.00') . ')'; ?></span>-->
                        </h4></td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #EEE;"><h4><?= lang('cc_sale'); ?>:</h4></td>
                    <td style="text-align:right;border-bottom: 1px solid #EEE;"><h4>
                            <span><?= $this->sma->formatMoney($ccsales->paid ? $ccsales->paid : '0.00') ?></span>
                            <!--<span><?= $this->sma->formatMoney($ccsales->paid ? $ccsales->paid : '0.00') . ' (' . $this->sma->formatMoney($ccsales->total ? $ccsales->total : '0.00') . ')'; ?></span>-->
                        </h4></td>
                </tr>
                
                 <tr>
                    <td style="border-bottom: 1px solid #EEE;"><h4><?= lang('dc_sale'); ?>:</h4></td>
                    <td style="text-align:right;border-bottom: 1px solid #EEE;">
                        <span><?= $this->sma->formatMoney($dcsales->paid ? $dcsales->paid : '0.00') ?></td>
<!--                    <td style="text-align:right;border-bottom: 1px solid #EEE;">
                        <span><?= $this->sma->formatMoney($dcsales->total ? $dcsales->total : '0.00'); ?></span>
                    </td>-->
                </tr>
                
                <tr>
                    <td style="border-bottom: 1px solid #DDD;"><h4><?= lang('gc_sale'); ?>:</h4></td>
                    <td style="text-align:right;border-bottom: 1px solid #DDD;"><h4>
                            <span><?= $this->sma->formatMoney($gcsales->paid ? $gcsales->paid : '0.00') ?></span>
                            <!--<span><?= $this->sma->formatMoney($gcsales->paid ? $gcsales->paid : '0.00') . ' (' . $this->sma->formatMoney($gcsales->total ? $gcsales->total : '0.00') . ')'; ?></span>-->
                        </h4></td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #DDD;"><h4><?= lang('deposit_sale'); ?>:</h4></td>
                    <td style="text-align:right;border-bottom: 1px solid #DDD;"><h4>
                           <span><?= $this->sma->formatMoney($depositsales->paid ? $depositsales->paid : '0.00') ?></span>
                            <!--<span><?= $this->sma->formatMoney($depositsales->paid ? $depositsales->paid : '0.00') . ' (' . $this->sma->formatMoney($depositsales->total ? $depositsales->total : '0.00') . ')'; ?></span>-->
                        </h4></td>
                </tr>
                 <tr>
                    <td style="border-bottom: 1px solid #DDD;"><h4><?= lang('Other Sale'); ?>:</h4></td>
                    <td style="text-align:right;border-bottom: 1px solid #DDD;">
                        <?= $this->sma->formatMoney($othersales->paid ? $othersales->paid : '0.00') ?></td>
<!--                    <td style="text-align:right;border-bottom: 1px solid #DDD;">
                        <?= $this->sma->formatMoney($othersales->total ? $othersales->total : '0.00'); ?> 
                    </td>-->
                </tr>
                
                 <?php if($pos_settings->neft){ ?>
                    <tr>
                        <td style="border-bottom: 1px solid #EEE;"><h4><?= lang('NEFT'); ?>:</h4></td>
                        <td style="text-align:right;border-bottom: 1px solid #EEE;"><h4>
                                <span><?= $this->sma->formatMoney($neftsales->paid ? $neftsales->paid : '0.00') ?></span>
                            
                                <!--<span><?= $this->sma->formatMoney($neftsales->paid ? $neftsales->paid : '0.00') . ' (' . $this->sma->formatMoney($neftsales->total ? $neftsales->total : '0.00') . ')'; ?></span>-->
                        </h4></td>
                    </tr>
                <?php } ?>
                <?php if($pos_settings->paytm){ ?>
                    <tr>
                        <td style="border-bottom: 1px solid #EEE;"><h4><?= lang('PAYTM'); ?>:</h4></td>
                        <td style="text-align:right;border-bottom: 1px solid #EEE;"><h4>
                                <span><?= $this->sma->formatMoney($paytmsales->paid ? $paytmsales->paid : '0.00')?></span>
                            <!--<span><?= $this->sma->formatMoney($paytmsales->paid ? $paytmsales->paid : '0.00') . ' (' . $this->sma->formatMoney($paytmsales->total ? $paytmsales->total : '0.00') . ')'; ?></span>-->
                        </h4></td>
                    </tr>
                <?php } ?>
                
                <?php if($pos_settings->google_pay){ ?>
                    <tr>
                        <td style="border-bottom: 1px solid #EEE;"><h4><?= lang('Google Pay'); ?>:</h4></td>
                        <td style="text-align:right;border-bottom: 1px solid #EEE;"><h4>
                                <span><?= $this->sma->formatMoney($googlepaysales->paid ? $googlepaysales->paid : '0.00')?></span>
                            <!--<span><?= $this->sma->formatMoney($googlepaysales->paid ? $googlepaysales->paid : '0.00') . ' (' . $this->sma->formatMoney($googlepaysales->total ? $googlepaysales->total : '0.00') . ')'; ?></span>-->
                        </h4></td>
                    </tr>
                <?php } ?>
                
                 <?php if($pos_settings->swiggy){ ?>
                    <tr>
                        <td style="border-bottom: 1px solid #EEE;"><h4><?= lang('Swiggy'); ?>:</h4></td>
                        <td style="text-align:right;border-bottom: 1px solid #EEE;"><h4>
                                <span><?= $this->sma->formatMoney($swiggysales->paid ? $swiggysales->paid : '0.00') ?></span>
                            <!--<span><?= $this->sma->formatMoney($swiggysales->paid ? $swiggysales->paid : '0.00') . ' (' . $this->sma->formatMoney($swiggysales->total ? $swiggysales->total : '0.00') . ')'; ?></span>-->
                        </h4></td>
                    </tr>
                <?php } ?>
                
                <?php if($pos_settings->zomato){ ?>
                    <tr>
                        <td style="border-bottom: 1px solid #EEE;"><h4><?= lang('Zomato'); ?>:</h4></td>
                        <td style="text-align:right;border-bottom: 1px solid #EEE;"><h4>
                             <span><?= $this->sma->formatMoney($zomatosales->paid ? $zomatosales->paid : '0.00') ?></span>   
                            <!--<span><?= $this->sma->formatMoney($zomatosales->paid ? $zomatosales->paid : '0.00') . ' (' . $this->sma->formatMoney($zomatosales->total ? $zomatosales->total : '0.00') . ')'; ?></span>-->
                        </h4></td>
                    </tr>
                <?php } ?>
                    
                <?php if($pos_settings->ubereats){ ?>
                    <tr>
                        <td style="border-bottom: 1px solid #EEE;"><h4><?= lang('Ubereats'); ?>:</h4></td>
                        <td style="text-align:right;border-bottom: 1px solid #EEE;"><h4>
                            <span><?= $this->sma->formatMoney($ubereatssales->paid ? $ubereatssales->paid : '0.00') ?></span>
                            <!--<span><?= $this->sma->formatMoney($ubereatssales->paid ? $ubereatssales->paid : '0.00') . ' (' . $this->sma->formatMoney($ubereatssales->total ? $ubereatssales->total : '0.00') . ')'; ?></span>-->
                        </h4></td>
                    </tr>
                <?php } ?>   
                    
                <?php if($pos_settings->complimentary){ ?>
                    <tr>
                        <td style="border-bottom: 1px solid #EEE;"><h4><?= lang('Complimentary'); ?>:</h4></td>
                        <td style="text-align:right;border-bottom: 1px solid #EEE;"><h4>
                                <span><?= $this->sma->formatMoney($complimentrysales->paid ? $complimentrysales->paid : '0.00')?></span>
                            <!--<span><?= $this->sma->formatMoney($complimentrysales->paid ? $complimentrysales->paid : '0.00') . ' (' . $this->sma->formatMoney($complimentrysales->total ? $complimentrysales->total : '0.00') . ')'; ?></span>-->
                        </h4></td>
                    </tr>
                <?php } ?>   
                <?php if ($pos_settings->paypal_pro) { ?>
                    <tr>
                        <td style="border-bottom: 1px solid #EEE;"><h4><?= lang('paypal_pro'); ?>:</h4></td>
                        <td style="text-align:right;border-bottom: 1px solid #EEE;"><h4>
                                <span><?= $this->sma->formatMoney($pppsales->paid ? $pppsales->paid : '0.00') ?></span>
                                <!--<span><?= $this->sma->formatMoney($pppsales->paid ? $pppsales->paid : '0.00') . ' (' . $this->sma->formatMoney($pppsales->total ? $pppsales->total : '0.00') . ')'; ?></span>-->
                            </h4></td>
                    </tr>
                <?php } ?>
                <?php if ($pos_settings->stripe) { ?>
                    <tr>
                        <td style="border-bottom: 1px solid #EEE;"><h4><?= lang('stripe'); ?>:</h4></td>
                        <td style="text-align:right;border-bottom: 1px solid #EEE; "><h4>
                                <span><?= $this->sma->formatMoney($stripesales->paid ? $stripesales->paid : '0.00')?></span>
                                <!--<span><?= $this->sma->formatMoney($stripesales->paid ? $stripesales->paid : '0.00') . ' (' . $this->sma->formatMoney($stripesales->total ? $stripesales->total : '0.00') . ')'; ?></span>-->
                            </h4></td>
                    </tr>
                <?php } ?>
                <?php if ($pos_settings->authorize) { ?>
                    <tr>
                        <td style="border-bottom: 1px solid #DDD;"><h4><?= lang('authorize'); ?>:</h4></td>
                        <td style="text-align:right;border-bottom: 1px solid #DDD;"><h4>
                                <span><?= $this->sma->formatMoney($authorizesales->paid ? $authorizesales->paid : '0.00') ?></span>
                                <!--<span><?= $this->sma->formatMoney($authorizesales->paid ? $authorizesales->paid : '0.00') . ' (' . $this->sma->formatMoney($authorizesales->total ? $authorizesales->total : '0.00') . ')'; ?></span>-->
                            </h4></td>
                    </tr>
                <?php } ?>
                
                <tr>
                    <td width="300px;" style="font-weight:bold; border-bottom: 1px solid #DDD;""><h4><strong><?= lang('Total Paid'); ?>:</strong></h4></td>
                    <td width="200px;" style="font-weight:bold;text-align:right; border-bottom: 1px solid #DDD;""><h4>
                            <span><strong><?= $this->sma->formatMoney($totalsales->paid ? $totalsales->paid : '0.00') ?></strong> </span>
                          
                        </h4></td>
                </tr>
                 <tr>
                   
                    <td width="300px;" style="font-weight:bold; border-bottom: 1px solid #DDD;""><h4><strong><?= lang('Total Due'); ?>: </strong></h4></td>
                    <td width="200px;" style="font-weight:bold;text-align:right; border-bottom: 1px solid #DDD;""><h4>
                            <span><strong>   <?= $this->sma->formatMoney($duesales->duetotal + $duepartial->partial_due) ?> </strong></span>
                          
                        </h4></td>
                </tr>  
                 <tr>
                    <td width="300px;" style="font-weight:bold;border-bottom: 1px solid #DDD;""><h4><strong><?= lang('total_sales'); ?>:</strong></h4></td>
                    <td width="200px;" style="font-weight:bold;text-align:right; border-bottom: 1px solid #DDD;""><h4>
                          <!--<span><strong><?= $this->sma->formatMoney($totalsales->total ? $totalsales->total + $duesales->duetotal + str_replace("-", '', $refunds->returned) : '0.00') ?></strong> </span>-->
                          <span><strong><?= $this->sma->formatMoney($totalsales->paid ? $totalsales->paid + $duesales->duetotal  : '0.00') ?></strong> </span>
                            <!--<span><?= $this->sma->formatMoney($totalsales->paid ? $totalsales->paid : '0.00') . ' (' . $this->sma->formatMoney($totalsales->total ? $totalsales->total : '0.00') . ')'; ?></span>-->
                        </h4></td>
                </tr>
                 
               
                <tr>
                    <td style="border-top: 1px solid #DDD;"><h4><?= lang('refunds'); ?>:</h4></td>
                    <td style="text-align:right;border-top: 1px solid #DDD;"><h4>
                            <span><?= $this->sma->formatMoney($refunds->returned ? $refunds->returned : '0.00') ?></span>
                            <!--<span><?= $this->sma->formatMoney($refunds->returned ? $refunds->returned : '0.00') . ' (' . $this->sma->formatMoney($refunds->total ? $refunds->total : '0.00') . ')'; ?></span>-->
                        </h4></td>
                </tr>
                <tr>
                    <td style="border-bottom: 1px solid #DDD;"><h4><?= lang('expenses'); ?>:</h4></td>
                    <td style="text-align:right;border-bottom: 1px solid #DDD;"><h4>
                            <span><?php $expense = $expenses ? $expenses->total : 0; echo $this->sma->formatMoney($expense) ?></span>
                            <!--<span><?php $expense = $expenses ? $expenses->total : 0; echo $this->sma->formatMoney($expense) . ' (' . $this->sma->formatMoney($expense) . ')'; ?></span>-->
                        </h4></td>
                </tr>
                <tr>
                    <td width="300px;" style="font-weight:bold;"><h4><strong><?= lang('total_cash'); ?></strong>:</h4>
                    </td>
                    <td style="text-align:right;"><h4>
                          <span><strong><?= $cashsales->paid ? $this->sma->formatMoney(($cashsales->paid + ($this->session->userdata('cash_in_hand'))) + ($refunds->returned ? $refunds->returned : 0) - $expense) : $this->sma->formatMoney($this->session->userdata('cash_in_hand')-$expense); ?></strong></span>

                        </h4></td>
                </tr>
            </table>
        </div>
    </div>

</div>



