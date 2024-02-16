<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-lg no-modal-header">
    <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-2x">&times;</i>
            </button>
            <button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();">
                <i class="fa fa-print"></i> <?= lang('print'); ?>
            </button>
            <?php if ($logo) { ?>
                <div class="text-center" style="margin-bottom:20px;">
                    <img src="<?= base_url() . 'assets/uploads/logos/' . $Settings->logo; ?>"
                         alt="<?= $Settings->site_name; ?>">
                </div>
            <?php } ?>
            <div class="well well-sm">
                <div class="row bold">
                    <div class="col-xs-4"><?= lang("date"); ?>: <?= $this->sma->hrld($transfer->date); ?>
                        <br><?= lang("ref"); ?>: <?= $transfer->transfer_no; ?></div>
                    <div class="col-xs-6 pull-right text-right order_barcodes">
                        <?= $this->sma->save_barcode($transfer->transfer_no, 'code128', 66, false); ?>
                        <?= $this->sma->qrcode('link', urlencode(site_url('transfers/view/' . $transfer->id)), 2); ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="row">
                <div class="col-xs-6">
                    <strong><?php echo $this->lang->line("Warehouse From"); ?></strong>
                   <h2 style="margin-top:10px;"><?= ucfirst($from_warehouse->name) . " ( " . $from_warehouse->code . " )"; ?></h2>
                   <address>
                       <?= ($from_warehouse->address!='')?'<b> Address : </b> '.$from_warehouse->address:'' ?>
                       <?= ($from_warehouse->phone!='')?'<br/><b> '.lang("tel").' : </b>'.$from_warehouse->phone:''?>
                       <?= ($from_warehouse->email!='')?'<br/><b> '.lang("email").' : </b> '.$from_warehouse->email:''?>
                   </address>
                </div>
                <div class="col-xs-6">
                    <strong><?= lang(" Warehouse To"); ?></strong>
                    <h2 style="margin-top:10px;"><?= ucfirst($to_warehouse->name) . " ( " . $to_warehouse->code . " )"; ?></h2>
                    <address >
                        <?= ($to_warehouse->address!='')?'<b> Address : </b> '.$to_warehouse->address:'' ?>
                        <?= ($to_warehouse->phone!='')?'<br/><b> '.lang("tel").' : </b> '.$to_warehouse->phone:''?>
                        <?= ($to_warehouse->email!='')?'<br/><b> '.lang("email").' : </b> '.$to_warehouse->email:''?>
                    </address>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped order-table">
                    <thead>
                    <tr>
                        <th style="text-align:center; vertical-align:middle;"><?= lang("no"); ?></th>
                        <th style="vertical-align:middle;"><?= lang("description"); ?></th>
                        <th style="text-align:center; vertical-align:middle;"><?= lang("quantity"); ?></th>
                        <th style="text-align:center; vertical-align:middle;"><?= lang("unit_cost"); ?></th>
                        <?php if ($Settings->tax1) {
                            echo '<th style="text-align:center; vertical-align:middle;">' . lang("tax") . '</th>';
                        } ?>
                        <th style="text-align:center; vertical-align:middle;"><?= lang("subtotal"); ?></th>
                    </tr>
                    </thead>

                    <tbody>
                    <?php $r = 1;$totalqty =0;
                    foreach ($rows as $row): 
					if($transfer->status=='sent_balance'){
						
						
						$item_tax_rate = $row->tax_rate_id;
						$unit_cost = $row->unit_cost;
						$net_unit_cost = $row->net_unit_cost;
						$item_code = $row->product_code;
						$subtotal = $row->subtotal;
						$pr_item_tax=$row->item_tax;
						$Qty = $row->unit_quantity;
						$item_tax = 0;
						if($pr_item_tax==0){
							$Qty = $row->sent_quantity;
						}
							
							
							if (isset($item_tax_rate) && $item_tax_rate != 0) {
								
								$pr_tax = $item_tax_rate;
								$tax_details = $this->site->getTaxRateByID($pr_tax);
								$product_details = $this->transfers_model->getProductByCode($item_code);
								if ($tax_details->type == 1 && $tax_details->rate != 0) {
									
									if ($product_details && $product_details->tax_method == 1) {
										
										$item_tax = $this->sma->formatDecimal((($unit_cost) * $tax_details->rate) / 100, 4);
										$tax = $tax_details->rate . "%";
									} else {
									
										
										
										$item_tax = $this->sma->formatDecimal((($unit_cost) * $tax_details->rate) / (100 + $tax_details->rate), 4);
										$tax = $tax_details->rate . "%";

									}

								} elseif ($tax_details->type == 2) {
									$item_tax = $this->sma->formatDecimal($tax_details->rate);
									$tax = $tax_details->rate;

								}
								//echo $Qty;
								$pr_item_tax = $this->sma->formatDecimal($item_tax * $Qty, 4);

							}
							$subtotal =  $this->sma->formatDecimal((($net_unit_cost * $Qty) + $pr_item_tax), 4);
						
					}else{
						$Qty = $row->unit_quantity;
						$subtotal = $row->subtotal;
						$pr_item_tax = $row->item_tax;
					}
					?>
                        <tr>
                            <td style="text-align:center; width:25px;"><?= $r; ?></td>
                            <td style="text-align:left;">
                                <?= $row->product_code.' - '.$row->product_name . ($row->variant ? ' (' . $row->variant . ')' : ''); ?>
                            </td>
                            <td style="text-align:center; width:80px; "><?= $this->sma->formatQuantity($Qty).' '.$row->product_unit_code; ?></td>
                            <td style="width: 100px; text-align:right; padding-right:10px; vertical-align:middle;"><?= $this->sma->formatMoney($row->net_unit_cost); ?></td>
                            <?php if ($Settings->tax1) {
                                echo '<td style="width: 80px; text-align:right; vertical-align:middle;"><!--<small>(' . $row->tax . ')</small>--> ' . $this->sma->formatMoney($pr_item_tax) . '</td>';
                            } ?>
                            <td style="width: 100px; text-align:right; padding-right:10px; vertical-align:middle;"><?= $this->sma->formatMoney($subtotal); ?></td>
                        </tr>
                        <?php $r++;
                        $totalqty += $row->unit_quantity;
                    endforeach; ?>
                    </tbody>
                    <tfoot>
                    <?php $col = 3;$tcol = 3;
                    if ($Settings->tax1) {
                        $col += 1;
                        $tcol += 1;
                    } 
                    if ($Settings->show_total_unit_quantity != 0) {
                        $col = $col - 2;
                        //$tcol = $tcol + 1;
                    } 

                    ?>

                        <tr>
                            <td colspan="<?= $col; ?>"
                                style="text-align:right; padding-right:10px;"><?= lang("total"); ?>
                            </td>
                              <?php
                               if ($Settings->show_total_unit_quantity != 0) {
                                echo '<td   style="text-align:right;"   >'. $this->sma->formatQuantity($totalqty).'</td><td style="text-align:right;"></td>';
                            }?>
                            <td style="text-align:right; padding-right:10px;"><?= $this->sma->formatMoney($transfer->total_tax); ?>
                            <td style="text-align:right; padding-right:10px;"><?= $this->sma->formatMoney($transfer->total+$transfer->total_tax); ?></td>
                        </tr>
                    <tr>
                        <td colspan="<?= $tcol+1; ?>"
                            style="text-align:right; padding-right:10px; font-weight:bold;"><?= lang("total_amount"); ?>
                            (<?= $default_currency->code; ?>)
                        </td>
                        <td style="text-align:right; padding-right:10px; font-weight:bold;"><?= $this->sma->formatMoney($transfer->grand_total); ?></td>
                    </tr>
                    </tfoot>
                </table>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <?php if ($transfer->note || $transfer->note != "") { ?>
                        <div class="well well-sm">
                            <p class="bold"><?= lang("note"); ?>:</p>

                            <div><?= $this->sma->decode_html($transfer->note); ?></div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-xs-4 pull-left">
                    <p><?= lang("created_by"); ?>: <?= $created_by->first_name.' '.$created_by->last_name; ?> </p>

                    <p>&nbsp;</p>

                    <p>&nbsp;</p>
                    <hr>
                    <p><?= lang("stamp_sign"); ?></p>
                </div>
                <div class="col-xs-4 col-xs-offset-1 pull-right">
                    <p><?= lang("received_by"); ?>: </p>

                    <p>&nbsp;</p>

                    <p>&nbsp;</p>
                    <hr>
                    <p><?= lang("stamp_sign"); ?></p>
                </div>
            </div>
            <?php if (!$Supplier || !$Customer) { ?>
                <div class="buttons">
                    <div class="btn-group btn-group-justified">
                        <?php if ($transfer->attachment) { ?>
                            <div class="btn-group">
                                <a href="<?= site_url('welcome/download/' . $transfer->attachment) ?>" class="tip btn btn-primary" title="<?= lang('attachment') ?>">
                                    <i class="fa fa-chain"></i>
                                    <span class="hidden-sm hidden-xs"><?= lang('attachment') ?></span>
                                </a>
                            </div>
                        <?php } ?>
                        <div class="btn-group">
                            <a href="<?= site_url('transfers/email/' . $transfer->id) ?>" data-toggle="modal" data-target="#myModal2" class="tip btn btn-primary" title="<?= lang('email') ?>">
                                <i class="fa fa-envelope-o"></i>
                                <span class="hidden-sm hidden-xs"><?= lang('email') ?></span>
                            </a>
                        </div>
                        <div class="btn-group">
                            <a href="<?= site_url('transfers/pdf/' . $transfer->id) ?>" class="tip btn btn-primary" title="<?= lang('download_pdf') ?>">
                                <i class="fa fa-download"></i>
                                <span class="hidden-sm hidden-xs"><?= lang('pdf') ?></span>
                            </a>
                        </div>
                        <div class="btn-group">
                            <a href="<?= site_url('transfers/edit/' . $transfer->id) ?>" class="tip btn btn-warning sledit" title="<?= lang('edit') ?>">
                                <i class="fa fa-edit"></i>
                                <span class="hidden-sm hidden-xs"><?= lang('edit') ?></span>
                            </a>
                        </div>
                        <div class="btn-group">
                            <a href="#" class="tip btn btn-danger bpo" title="<b><?= $this->lang->line("delete") ?></b>"
                                data-content="<div style='width:150px;'><p><?= lang('r_u_sure') ?></p><a class='btn btn-danger' href='<?= site_url('transfers/delete/' . $transfer->id) ?>'><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button></div>"
                                data-html="true" data-placement="top">
                                <i class="fa fa-trash-o"></i>
                                <span class="hidden-sm hidden-xs"><?= lang('delete') ?></span>
                            </a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready( function() {
        $('.tip').tooltip();
    });
</script>
