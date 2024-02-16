<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<link href="<?= $assets ?>styles/report_style.css" rel="stylesheet"/>
<script>$(document).ready(function () {
        CURI = '<?= site_url('reports/profit_loss'); ?>';
    });</script>
<style>

.small-box h3{
        font-size: 14px;
        }
@media print {
        .fa {
            color: #EEE;
            display: none;
        }

        .small-box {
            border: 1px solid #CCC;
        }
        .small-box h3{
        font-size: 14px;
        }
    }</style>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-bars"></i>Profit & Loss</h2>

        <div class="box-icon">
            <div class="form-group choose-date hidden-xs">
                <div class="controls">
                    <div class="input-group">
                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                        <input type="text"
                               value="<?= ($start ? $this->sma->hrld($start) : '') . ' - ' . ($end ? $this->sma->hrld($end) : ''); ?>"
                               id="daterange" class="form-control">
                        <span class="input-group-addon" style="display:none;"><i class="fa fa-chevron-down"></i></span>
                    </div>
                </div>
            </div>
        </div>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a href="#" id="pdf" class="tip" title="<?= lang('download_pdf') ?>">
                        <i class="icon fa fa-file-pdf-o"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" id="image" class="tip" title="<?= lang('save_image') ?>">
                        <i class="icon fa fa-file-picture-o"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="box-content ">
        <div class="row">
            <div class="col-lg-12">
                <p class="introtext"><?= lang('view_pl_report'); ?></p>
                 <!-- New Report Theme start -->
                <div class="row" style="margin-right:0;">
                    <div class="col-xs-12 col-sm-4 col-md-4 mob-section" style="padding-right:0;">
                        <div class="green-box gray-cart">
                            <div class="top-section">
                                <h2><?= lang('purchases') ?></h2>
                                <p><?= $this->sma->formatMoney($total_purchases->total_amount) ?></p>
                                <p><?= $total_purchases->total . ' ' . lang('purchases') ?></p>
                                <p><!--<?= $this->sma->formatMoney($total_purchases->total) . ' ' . lang('purchases') ?>
                                    &  --><?= $this->sma->formatMoney($total_purchases->paid) . ' ' . lang('paid') ?>
                                    & <?= $this->sma->formatMoney($total_purchases->tax) . ' ' . lang('tax') ?>
                                </p>
                            </div>
                            <div class="btm-section">
                                <img src="<?= $assets ?>img/ft-cart.png" class="icon" />                                        
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 mob-section" style="padding-right:0;">
                        <div class=" orange-box gray-sale">
                            <div class="top-section">
                                <h2><?= lang('sales') ?></h2>
                                <p><?= $this->sma->formatMoney($total_sales->total_amount) ?></p>
                                <p><?= $total_sales->total . ' ' . lang('sales') ?></p>
                                <p><!--<?= $this->sma->formatMoney($total_sales->total) . ' ' . lang('sales') ?>
                                    &  --><?= $this->sma->formatMoney($total_sales->paid) . ' ' . lang('paid') ?>
                                    & <?= $this->sma->formatMoney($total_sales->tax) . ' ' . lang('tax') ?>
                                </p>
                            </div>
                            <div class="btm-section">
                                <img src="<?= $assets ?>img/ft-sale.png" class="icon" />                                        
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 mob-section" style="padding-right:0;">
                        <div class=" blue-box gray-rupee">
                            <div class="top-section">
                                <h2><?= lang('payments') ?></h2>
                                <p><?=lang('received')?> - <?=lang('returned')?> - <?=lang('sent')?> - <?=lang('expenses')?></p>
                                <p><?= $this->sma->formatMoney($total_received->total_amount) ?>
                                    - <?= $this->sma->formatMoney($total_returned->total_amount) ?>
                                    - <?= $this->sma->formatMoney($total_paid->total_amount) ?>
                                    - <?= $this->sma->formatMoney($total_expenses->total_amount) ?></p>
                                <p>&nbsp;</p>
                                <h2 style="text-align:center;"><small><?= $this->sma->formatMoney($total_received->total_amount - $total_returned->total_amount - $total_paid->total_amount - $total_expenses->total_amount) ?></small></h2>
                            </div>
                            <div class="btm-section">
                                <img src="<?= $assets ?>img/rupee1.png" class="icon" />
                            </div>
                        </div>
                    </div>
                    
                </div><!-- //.row-->
                <div class="row" style="margin-right:0;">
                    <div class="col-xs-12 col-sm-3 col-md-3 mob-section" style="padding-right:0;">
                        <div class=" orange-box gray-pay">
                            <div class="top-section">
                                <h2><?= lang('payments_received') ?></h2>
                                <p><?= $this->sma->formatMoney($total_received->total_amount) ?></p>
                                <p>&nbsp;</p>
                                <p><?= $total_received->total . ' ' . lang('payments_received') ?></p>                                
                            </div>
                            <div class="btm-section">
                                <img src="<?= $assets ?>img/ft-payment.png" class="icon" />                                        
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3 mob-section" style="padding-right:0;">
                        <div class=" blue-box gray-return">
                            <div class="top-section">
                                <h2><?= lang('payments_returned') ?></h2>
                                <p><?= $this->sma->formatMoney($total_returned->total_amount) ?></p>
                                <p>&nbsp;</p>
                                <p><?= $total_returned->total . ' ' . lang('payments_returned') ?></p>
                            </div>
                            <div class="btm-section">
                                <img src="<?= $assets ?>img/return-doloor.png" class="icon" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3 mob-section" style="padding-right:0;">
                        <div class="green-box gray-sent">
                            <div class="top-section">
                                <h2><?= lang('payments_sent') ?></h2>
                                <p><?= $this->sma->formatMoney($total_paid->total_amount) ?></p>
                                <p>&nbsp;</p>
                                <p><?= $total_paid->total . ' ' . lang('payments_sent') ?></p>
                            </div>
                            <div class="btm-section">
                                <img src="<?= $assets ?>img/payment-sent.png" class="icon" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3 mob-section" style="padding-right:0;">
                        <div class=" orange-box gray-dollar">
                            <div class="top-section">
                                <h2><?= lang('expenses') ?></h2>
                                <p><?= $this->sma->formatMoney($total_expenses->total_amount) ?></p>
                                <p>&nbsp;</p>
                                <p><?= $total_expenses->total . ' ' . lang('expenses') ?></p>
                            </div>
                            <div class="btm-section">
                                <img src="<?= $assets ?>img/ft-dollar.png" class="icon" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-right:0;">
                    <div class="col-xs-12 col-sm-3 col-md-3 mob-section" style="padding-right:0;">
                        <div class="green-box gray-sale">
                            <div class="top-section">
                                <h2>Sales <?= lang('order_tax') ?></h2>
                                <p><?= $this->sma->formatMoney($taxReportSales->order_tax) ?></p>
                            </div>
                            <div class="btm-section">
                                <img src="<?= $assets ?>img/ft-sale.png" class="icon" />
                            </div>
                        </div>

                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3 mob-section" style="padding-right:0;">
                        <div class=" orange-box gray-sale">
                            <div class="top-section">
                                <h2>Sales <?= lang('product_tax') ?></h2>
                                <p><?= $this->sma->formatMoney($taxReportSales->product_tax) ?></p>                                
                            </div>
                            <div class="btm-section">
                                <img src="<?= $assets ?>img/ft-sale.png" class="icon" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2 mob-section" style="padding-right:0;">
                        <div class=" blue-box gray-rupee">
                            <div class="top-section">
                                <h2>Sales <?= lang('CGST') ?></h2>
                                <p><?= $this->sma->formatMoney($taxReportSales->CGST) ?></p>
                            </div>
                            <div class="btm-section">
                                <img src="<?= $assets ?>img/rupee1.png" class="icon" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2 mob-section" style="padding-right:0;">
                        <div class=" blue-box gray-rupee">
                            <div class="top-section">
                                <h2>Sales <?= lang('SGST') ?></h2>
                                <p><?= $this->sma->formatMoney($taxReportSales->SGST) ?></p>
                            </div>
                            <div class="btm-section">
                                <img src="<?= $assets ?>img/rupee1.png" class="icon" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2 mob-section" style="padding-right:0;">
                        <div class=" blue-box gray-rupee">
                            <div class="top-section">
                                <h2>Sales <?= lang('IGST') ?></h2>
                                <p><?= $this->sma->formatMoney($taxReportSales->IGST) ?></p>
                            </div>
                            <div class="btm-section">
                                <img src="<?= $assets ?>img/rupee1.png" class="icon" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-right:0;">
                    <div class="col-xs-12 col-sm-3 col-md-3 mob-section" style="padding-right:0;">
                        <div class="blue-box gray-sale">
                            <div class="top-section">
                                <h2>Purchases <?= lang('order_tax') ?></h2>
                                <p><?= $this->sma->formatMoney($taxReportPurchases->order_tax) ?></p>
                            </div>
                            <div class="btm-section">
                                <img src="<?= $assets ?>img/ft-sale.png" class="icon" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-3 col-md-3 mob-section" style="padding-right:0;">
                        <div class=" green-box gray-sale">
                            <div class="top-section">
                                <h2>Purchases <?= lang('product_tax') ?></h2>
                                <p><?= $this->sma->formatMoney($taxReportPurchases->product_tax) ?></p>                                
                            </div>
                            <div class="btm-section">
                                <img src="<?= $assets ?>img/ft-sale.png" class="icon" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2 mob-section" style="padding-right:0;">
                        <div class=" orange-box gray-rupee">
                            <div class="top-section">
                                <h2><small>Purchases <?= lang('CGST') ?></small></h2>
                                <p><?= $this->sma->formatMoney($taxReportPurchases->CGST) ?></p>
                            </div>
                            <div class="btm-section">
                                <img src="<?= $assets ?>img/rupee1.png" class="icon" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2 mob-section" style="padding-right:0;">
                        <div class=" orange-box gray-rupee">
                            <div class="top-section">
                                <h2><small>Purchases <?= lang('SGST') ?></small></h2>
                                <p><?= $this->sma->formatMoney($taxReportPurchases->SGST) ?></p>
                            </div>
                            <div class="btm-section">
                                <img src="<?= $assets ?>img/rupee1.png" class="icon" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-2 col-md-2 mob-section" style="padding-right:0;">
                        <div class=" orange-box gray-rupee">
                            <div class="top-section">
                                <h2><small>Purchases <?= lang('IGST') ?></small></h2>
                                <p><?= $this->sma->formatMoney($taxReportPurchases->IGST) ?></p>
                            </div>
                            <div class="btm-section">
                                <img src="<?= $assets ?>img/rupee1.png" class="icon" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-right:0;">         
                    <div class="col-xs-12 col-sm-4 col-md-4 mob-section" style="padding-right:0;">
                        <div class=" green-box gray-rupee">
                            <div class="top-section">
                                <h2>Gross <?= lang('profit_loss') ?></h2>
                                <p><?=lang('sales')?> - <?=lang('purchases')?></p>
                                <p><?= $this->sma->formatMoney($total_sales->total_amount) ?>
                                    - <?= $this->sma->formatMoney($total_purchases->total_amount)?></p>
                                <p>&nbsp;</p>
                                <h2 style="text-align:center;"><small><?= $this->sma->formatMoney($total_sales->total_amount - $total_purchases->total_amount) ?></small></h2>
                            </div>
                            <div class="btm-section">
                                <img src="<?= $assets ?>img/rupee1.png" class="icon" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 mob-section" style="padding-right:0;">
                        <div class=" orange-box gray-rupee">
                            <div class="top-section">
                                <h2>Net <?= lang('profit_loss') ?></h2>
                                <p><?=lang('sales')?> - <?=lang('tax')?> - <?=lang('purchases')?></p>
                                <p><?= $this->sma->formatMoney($total_sales->total_amount) ?>
                                    - <?= $this->sma->formatMoney($total_sales->tax)?>
                                    - <?= $this->sma->formatMoney($total_purchases->total_amount) ?> </p>
                                <p>&nbsp;</p>
                                <h2 style="text-align:center;"><small><?= $this->sma->formatMoney($total_sales->total_amount - $total_purchases->total_amount - $total_sales->tax) ?></small></h2>
                            </div>
                            <div class="btm-section">
                                <img src="<?= $assets ?>img/rupee1.png" class="icon" />
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 mob-section" style="padding-right:0;">
                        <div class=" blue-box gray-rupee">
                            <div class="top-section">
                                <h2>Pure <?= lang('profit_loss') ?></h2>
                                <p>(<?=lang('sales')?> - <?=lang('tax')?>) - (<?=lang('purchases')?> - <?=lang('tax')?>)</p>
                                <p>(<?= $this->sma->formatMoney($total_sales->total_amount) ?>
                                    - <?= $this->sma->formatMoney($total_sales->tax)?>)
                                    <br/>- (<?= $this->sma->formatMoney($total_purchases->total_amount) ?>
                                    - <?= $this->sma->formatMoney($total_purchases->tax) ?>)
                                </p>
                                <p>&nbsp;</p>
                                <h2 style="text-align:center;"><small><?= $this->sma->formatMoney(($total_sales->total_amount - $total_sales->tax) - ($total_purchases->total_amount - $total_purchases->tax)) ?></small></h2>
                            </div>
                            <div class="btm-section">
                                <img src="<?= $assets ?>img/rupee1.png" class="icon" />
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row" style="margin-right:0;">  
                    
                </div>
                  <!-- New Report Theme end -->
                
                
               
		<div class="row">
                <?php 
                $i=0;
                foreach ($warehouses_report as $warehouse_report) {
                   
                    if($i==3) {
                       echo '</div><div class="row">';
                       $i=0;
                    } 
                    $i++;
                    ?>
                    <div class="col-sm-4">
                        <div class="small-box padding1010 bblue">
                            <h4 class="bold"><?= $warehouse_report['warehouse']->name.' ('.$warehouse_report['warehouse']->code.')'; ?></h4>
                            <i class="fa fa-building"></i>

                            <h3 class="bold"><?= $this->sma->formatMoney(($warehouse_report['total_sales']->total_amount) - ($warehouse_report['total_purchases']->total_amount)) ?></h3>

                            <p>
                            <?= lang('sales').' - '.lang('purchases'); ?>
                            </p>
                            <hr style="border-color: rgba(255, 255, 255, 0.4);">
                            <p>
                            <?= $this->sma->formatMoney($warehouse_report['total_sales']->total_amount) . ' ' . lang('sales'); ?>
                                - <?= $this->sma->formatMoney($warehouse_report['total_sales']->tax) . ' ' . lang('tax') ?>
                                = <?= $this->sma->formatMoney($warehouse_report['total_sales']->total_amount-$warehouse_report['total_sales']->tax).' '.lang('net_sales'); ?>
                                </p>
                                <p>
                                <?= $this->sma->formatMoney($warehouse_report['total_purchases']->total_amount) . ' ' . lang('purchases') ?>
                                - <?= $this->sma->formatMoney($warehouse_report['total_purchases']->tax) . ' ' . lang('tax') ?>
                                = <?= $this->sma->formatMoney($warehouse_report['total_purchases']->total_amount-$warehouse_report['total_purchases']->tax).' '.lang('net_purchases'); ?>
                                </p>
                                <hr style="border-color: rgba(255, 255, 255, 0.4);">
                                
                                <?= '<h3 class="bold">'.$this->sma->formatMoney((($warehouse_report['total_sales']->total_amount-$warehouse_report['total_sales']->tax))-($warehouse_report['total_purchases']->total_amount-$warehouse_report['total_purchases']->tax)).'</h3>'; ?>
                                <p>
                                <?= lang('net_sales').' - '.lang('net_purchases'); ?>
                                </p>
                                <hr style="border-color: rgba(255, 255, 255, 0.4);">
                                
                                <?= '<h3 class="bold">'.$this->sma->formatMoney($warehouse_report['total_expenses']->total_amount).'</h3>'; ?>
                                <p>
                                <?= $warehouse_report['total_expenses']->total.' '.lang('expenses'); ?>
                                </p>

                        </div>
                    </div>
                <?php  
                    } ?>
		</div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= $assets ?>js/html2canvas.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#pdf').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('reports/profit_loss_pdf')?>/" + encodeURIComponent('<?=$start?>') + "/" + encodeURIComponent('<?=$end?>');
            return false;
        });
        $('#image').click(function (event) {
            event.preventDefault();
            html2canvas($('.box'), {
                onrendered: function (canvas) {
                    var img = canvas.toDataURL()
                    window.open(img);
                }
            });
            return false;
        });
    });
</script>
