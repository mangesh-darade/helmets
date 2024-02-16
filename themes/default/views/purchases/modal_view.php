<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 $itemTaxes = isset($inv->rows_tax)?$inv->rows_tax:array();
?>
<style>
   .modal-lg{width: 80%}
    table td p{    width: 250px;
      overflow-wrap: break-word;}
</style>
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
                    <div class="col-xs-5">
                    <p class="bold">
                        <?= lang("date"); ?>: <?= $this->sma->hrld($inv->date); ?><br>
                        <?= lang("ref"); ?>: <?= $inv->reference_no; ?><br>
                        <?php if (!empty($inv->return_purchase_ref)) {
                            echo lang("return_ref").': '.$inv->return_purchase_ref;
                            if ($inv->return_id) {
                                echo ' <a data-target="#myModal2" data-toggle="modal" href="'.site_url('purchases/modal_view/'.$inv->return_id).'"><i class="fa fa-external-link no-print"></i></a><br>';
                            } else {
                                echo '<br>';
                            }
                        } ?>
                        <?= lang("status"); ?>: <?= lang($inv->status); ?><br>
                        <?= lang("payment_status"); ?>: <?= lang($inv->payment_status); ?>
                    </p>
                    </div>
                    <div class="col-xs-7 text-right order_barcodes">
                        <?= $this->sma->save_barcode($inv->reference_no, 'code128', 66, false); ?>
                        <?= $this->sma->qrcode('link', urlencode(site_url('purchases/view/' . $inv->id)), 2); ?>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
            </div>

            <div class="row" style="margin-bottom:15px;">
                <div class="col-xs-6">
                    <strong><?php echo $this->lang->line("from"); ?></strong>
                    <h2 style="margin-top:10px;"><?= $Settings->site_name; ?></h2>
                    <?php  foreach($warehouse as $ware){ ?>
                         <?= ($ware->name!='')?'<b> Warehouse : </b> '.$ware->name:'' ?>
                    <address>
                        <?= ($ware->address!='')?'<b> Address : </b> '.$ware->address:'' ?>
                        <?= ($ware->phone!='')?'<br/><b> '.lang("tel").' : </b> '.$ware->phone:''?>
                        <?= ($ware->email!='')?'<br/><b> '.lang("email").' : </b>'.$ware->email:''?>
                    </address>
                    <?php } ?>
                </div>
                <div class="col-xs-6">
                    <strong><?php echo $this->lang->line("Supplier Details"); ?></strong>
                    <h2 style="margin-top:10px;"><?= $supplier->company ? $supplier->company : $supplier->name; ?></h2>
                        <?= $supplier->company ? "" : "Attn: " . $supplier->name ?>
                    <address>
                        <?= ($supplier->address!='')?'<b> Address : </b> '.$supplier->address.', <br/>':'' ?>
                        <?= ($supplier->city!='')?$supplier->city.' - ':'' ?> <?= ($supplier->postal_code!='')?$supplier->postal_code.', ':'' ?>
                        <?= ($supplier->state!='')?$supplier->state.', ':'' ?> <?= ($supplier->state!='')?$supplier->country.'. ':'' ?>
                        <?= ($supplier->phone!='')?'</br><b> '.lang("tel").' : </b> '.$supplier->phone:'' ?>
                        <?= ($supplier->email!='')?'</br><b> '.lang("email").' : </b> '.$supplier->email:'' ?>
                        <?php 
                            if ($supplier->gstn_no != "-" && $supplier->gstn_no != "" && count($itemTaxes) > 0) {
                                echo "<br><b> " . lang("gstn_no") . " : </b>" . $supplier->gstn_no ;
                            }
                            elseif ($supplier->vat_no != "-" && $supplier->vat_no != "" && count($itemTaxes) ==0) {
                                echo "<br><b> " . lang("vat_no") . " :  </b>" . $supplier->vat_no;
                            }
                            if ($supplier->cf1 != "-" && $supplier->cf1 != "") {
                                echo "<br><b> ".$this->Settings->prd_cmfield1 . " :  </b>". $supplier->cf1;
                            }
                            if ($supplier->cf2 != "-" && $supplier->cf2 != "") {
                                echo "<br><b> " .$this->Settings->prd_cmfield2 ." : </b> ". $supplier->cf2;
                            }
                            if ($supplier->cf3 != "-" && $supplier->cf3 != "") {
                                echo "<br><b> " .$this->Settings->prd_cmfield3 . " : </b> ". $supplier->cf3;
                            }
                            if ($supplier->cf4 != "-" && $supplier->cf4 != "") {
                                echo "<br><b> "  .$this->Settings->prd_cmfield4 .  " : </b>". $supplier->cf4;
                            }
                            if ($supplier->cf5 != "-" && $supplier->cf5 != "") {
                                echo "<br><b> "  .$this->Settings->prd_cmfield5 .  " : </b>". $supplier->cf5;
                            }
                            if ($supplier->cf6 != "-" && $supplier->cf6 != "") {
                                echo "<br><b> ".$this->Settings->prd_cmfield6 ." : </b> ". $supplier->cf6;
                            }

                        ?>
                    </address>
                </div>
            </div>

            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped print-table order-table">

                    <thead>

                    <tr>
                        <th><?= lang("no"); ?></th>
                        <th ><?= lang("description"); ?></th>
						<th><?= lang("batch_number"); ?></th>
                        <th><?= lang("unit_cost"); ?></th>
                        <th><?= lang("quantity"); ?></th>
                        <?php
                            if ($inv->status == 'partial') {
                                echo '<th>'.lang("received").'</th>';
                            }
                        ?>
                        <th><?= lang("Net_Cost"); ?></th>
                        <?php
                        if ($Settings->tax1 && $inv->product_tax > 0) {
                            echo '<th>' . lang("tax") . '</th>';
                        }
                        if ($Settings->product_discount && $inv->product_discount != 0) {
                            echo '<th>' . lang("discount") . '</th>';
                        }
                        ?>
                        <th><?= lang("subtotal"); ?></th>
                    </tr>

                    </thead>

                    <tbody>

                    <?php $r = 1;
                    $tax_summary = array();
                    $total_netcost = 0;$totalqty =0;
                    foreach ($rows as $row):
                     $offset = 6;
                     if (isset($tax_summary[$row->tax_code])) {
                                $tax_summary[$row->tax_code]['items'] += $row->quantity;
                                $tax_summary[$row->tax_code]['tax'] += $row->item_tax;
                                $tax_summary[$row->tax_code]['amt'] += ($row->quantity * $row->net_unit_cost);
                            } else {
                                $tax_summary[$row->tax_code]['items'] = $row->quantity;
                                $tax_summary[$row->tax_code]['tax'] = $row->item_tax;
                                $tax_summary[$row->tax_code]['amt'] = ($row->quantity * $row->net_unit_cost);
                                $tax_summary[$row->tax_code]['name'] = $row->tax_name;
                                $tax_summary[$row->tax_code]['code'] = $row->tax_code;
                                $tax_summary[$row->tax_code]['rate'] = $row->tax_rate;
                                $tax_summary[$row->tax_code]['tax_rate_id'] =  $row->tax_rate_id;
                            }
                    ?>
                        <tr>
                            <td style="text-align:center; width:40px; vertical-align:middle;"><?= $r; ?></td>
                            <td style="vertical-align:middle;">
                                <?php if($Settings->purchase_image == '1') { ?>
                                    <img src="assets/uploads/thumbs/<?=$row->image?>" style="width:30px; height:30px;" alt="<?=$row->product_code?>" />
                                <?php } ?>
                                <?= $row->product_code.' - '.$row->product_name . ($row->variant ? ' (' . $row->variant . ')' : ''); ?>
                                <?= $row->supplier_part_no ? '<br>'.lang('supplier_part_no').': ' . $row->supplier_part_no : ''; ?>
                                <?= $row->details ? '<br>' . $row->details : ''; ?>
                                <?= ($row->expiry && $row->expiry != '0000-00-00') ? '<br>'.lang('expiry').': ' . $this->sma->hrsd($row->expiry) : ''; ?>
                            </td>
<td style="width: 120px; text-align:center; vertical-align:middle;"><?= $row->batch_number; ?></td>
                            <td style="text-align:right; width:100px;"><?= $this->sma->formatMoney($row->real_unit_cost); ?></td>
                            <td style="width: 80px; text-align:center; vertical-align:middle;"><?= $this->sma->formatQuantity($row->unit_quantity).' '.$row->product_unit_code; ?></td>
                            <?php
                            if ($inv->status == 'partial') {
                                echo '<td style="text-align:center;vertical-align:middle;width:80px;">'.$this->sma->formatQuantity($row->quantity_received).' '.$row->product_unit_code.'</td>';
                            }
                            $total_netcost += ($row->real_unit_cost*$row->unit_quantity);
                            ?>
                            <td style="text-align:right; width:100px;"><?= $this->sma->formatMoney($row->real_unit_cost*$row->unit_quantity); ?></td>
                            <?php
                            if ($Settings->tax1 && $inv->product_tax > 0) {
                                echo '<td style="width: 100px; text-align:right; vertical-align:middle;">' . ($row->item_tax != 0 && $row->tax_code ? '<small>('.$row->tax_code.')</small>' : '') . ' ' . $this->sma->formatMoney($row->item_tax) . '</td>';
                                $offset++;
                            }
                            if ($Settings->product_discount && $inv->product_discount != 0) {
                                echo '<td style="width: 100px; text-align:right; vertical-align:middle;">' . ($row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '') . $this->sma->formatMoney($row->item_discount) . '</td>';
                                 $offset++;
                            }
                            ?>
                            <td style="text-align:right; width:120px;"><?= $this->sma->formatMoney($row->subtotal); ?></td>
                        </tr>
                         <?php echo $this->sma->taxAttrTBL($itemTaxes,$row->id,($offset));?>
                        <?php
                        $r++;
                        $totalqty += $row->unit_quantity;
                    endforeach;
                    if ($return_rows) {
                        echo '<tr class="warning"><td colspan="100%" class="no-border"><strong>'.lang('returned_items').'</strong></td></tr>';
                        foreach ($return_rows as $row):
                         $offset = 6;
                         if (isset($tax_summary[$row->tax_code])) {
                                $tax_summary[$row->tax_code]['items'] += $row->quantity;
                                $tax_summary[$row->tax_code]['tax'] += $row->item_tax;
                                $tax_summary[$row->tax_code]['amt'] += ($row->quantity * $row->net_unit_cost);
                            } else {
                                $tax_summary[$row->tax_code]['items'] = $row->quantity;
                                $tax_summary[$row->tax_code]['tax'] = $row->item_tax;
                                $tax_summary[$row->tax_code]['amt'] = ($row->quantity * $row->net_unit_cost);
                                $tax_summary[$row->tax_code]['name'] = $row->tax_name;
                                $tax_summary[$row->tax_code]['code'] = $row->tax_code;
                                $tax_summary[$row->tax_code]['rate'] = $row->tax_rate;
                                $tax_summary[$row->tax_code]['tax_rate_id'] =  $row->tax_rate_id;
                            }
                            
                        ?>
                            <tr class="warning">
                                <td style="text-align:center; width:40px; vertical-align:middle;"><?= $r; ?></td>
                                <td style="vertical-align:middle;">
                                    <?= $row->product_code.' - '.$row->product_name . ($row->variant ? ' (' . $row->variant . ')' : ''); ?>
                                    <?= $row->supplier_part_no ? '<br>'.lang('supplier_part_no').': ' . $row->supplier_part_no : ''; ?>
                                    <?= $row->details ? '<br>' . $row->details : ''; ?>
                                    <?= ($row->expiry && $row->expiry != '0000-00-00') ? '<br>'.lang('expiry').': ' . $this->sma->hrsd($row->expiry) : ''; ?>
                                </td>
								<td style="width: 120px; text-align:center; vertical-align:middle;"><?= $row->batch_number; ?></td>
                                 <td style="text-align:right; width:100px;"><?= $this->sma->formatMoney($row->real_unit_cost); ?></td>
                                <td style="width: 80px; text-align:center; vertical-align:middle;"><?= $this->sma->formatQuantity($row->unit_quantity).' '.$row->product_unit_code; ?></td>
                                <?php
                                if ($inv->status == 'partial') {
                                    echo '<td style="text-align:center;vertical-align:middle;width:80px;">'.$this->sma->formatQuantity($row->quantity_received).' '.$row->product_unit_code.'</td>';
                                }
                                $total_netcost += ($row->real_unit_cost*$row->unit_quantity);
                                ?>
                                <td style="text-align:right; width:100px;"><?= $this->sma->formatMoney($row->real_unit_cost*$row->unit_quantity); ?></td>
                                <?php
                                if ($Settings->tax1 && $inv->product_tax > 0) {
                                    echo '<td style="width: 100px; text-align:right; vertical-align:middle;">' . ($row->item_tax != 0 && $row->tax_code ? '<small>('.$row->tax_code.')</small>' : '') . ' ' . $this->sma->formatMoney($row->item_tax) . '</td>';
                                     $offset++;
                                }
                                if ($Settings->product_discount && $inv->product_discount != 0) {
                                    echo '<td style="width: 100px; text-align:right; vertical-align:middle;">' . ($row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '') . $this->sma->formatMoney($row->item_discount) . '</td>';
                                     $offset++;
                                }
                                ?>
                                <td style="text-align:right; width:120px;"><?= $this->sma->formatMoney($row->subtotal); ?></td>
                            </tr>
                             <?php echo $this->sma->taxAttrTBL($itemTaxes,$row->id,($offset));?>
                            <?php
                            $r++;
                        endforeach;
                    }
                    ?>
                    </tbody>
                    <tfoot>
                    <?php
                    $col = 5;
                    if ($inv->status == 'partial') {
                        $col++;
                    }
                    if ($Settings->product_discount && $inv->product_discount != 0) {
                        $col++;
                    }
                    if ($Settings->tax1 && $inv->product_tax > 0) {
                        $col++;
                    }
                   
                    if ( $Settings->product_discount && $inv->product_discount != 0 && $Settings->tax1 && $inv->product_tax > 0) {
                        $tcol = $col - 2;
                    } elseif ( $Settings->product_discount && $inv->product_discount != 0) {
                        $tcol = $col - 1;
                    } elseif ($Settings->tax1 && $inv->product_tax > 0) {
                        $tcol = $col - 1;
                    } else {
                        $tcol = $col;
                    }
                    
                    ?>
                    <?php if ($inv->grand_total != $inv->total) { ?>
                        <tr>
                           
                            <td colspan="<?= $tcol; ?>"
                                style="text-align:right; padding-right:10px;"> <?= lang("total"); ?>
                                (<?= $default_currency->code; ?>)
                            </td>
                            <td><?php echo $this->sma->formatMoney($total_netcost)?></td>
                            <?php
                            if ($Settings->tax1 && $inv->product_tax > 0) {
                                echo '<td style="text-align:right;">' . $this->sma->formatMoney($return_purchase ? ($inv->product_tax+$return_purchase->product_tax) : $inv->product_tax) . '</td>';
                            }
                            if ($Settings->product_discount && $inv->product_discount != 0) {
                                echo '<td style="text-align:right;">' . $this->sma->formatMoney($return_purchase ? ($inv->product_discount+$return_purchase->product_discount) : $inv->product_discount) . '</td>';
                            }
                            ?>
                            <td style="text-align:right; padding-right:10px;"><?= $this->sma->formatMoney($return_purchase ? (($inv->total + $inv->product_tax)+($return_purchase->total + $return_purchase->product_tax)) : ($inv->total + $inv->product_tax)); ?></td>
                        </tr>
                    <?php } ?>
                    <?php
					$cc = $col+1;
                    if ($return_purchase) {
                        echo '<tr><td colspan="'.$cc.'" style="text-align:right; padding-right:20px;">' . lang("return_total") . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;">' . $this->sma->formatMoney($return_purchase->grand_total) . '</td></tr>';
                    }
                    if ($inv->surcharge != 0) {
                        echo '<tr><td colspan="' . $cc . '" style="text-align:right; padding-right:10px;;">' . lang("return_surcharge") . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;">' . $this->sma->formatMoney($inv->surcharge) . '</td></tr>';
                    }
                    ?>

                    <?php if ($inv->order_discount != 0) {
						$cc = $col+1;
                        echo '<tr><td colspan="' . $cc . '" style="text-align:right; padding-right:10px;;">' . lang("order_discount") . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;">'.($inv->order_discount_id ? '<small>('.$inv->order_discount_id.')</small> ' : '') . $this->sma->formatMoney($return_purchase ? ($inv->order_discount+$return_purchase->order_discount) : $inv->order_discount) . '</td></tr>';
                    }
                    ?>
                    <?php if ($Settings->tax2 && $inv->order_tax != 0) {
                        echo '<tr><td colspan="' . $cc . '" style="text-align:right; padding-right:10px;">' . lang("order_tax") . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;">' . $this->sma->formatMoney($return_purchase ? ($inv->order_tax+$return_purchase->order_tax) : $inv->order_tax) . '</td></tr>';
                    }
                    ?>
                    <?php if ($inv->shipping != 0) {
                        echo '<tr><td colspan="' . $cc . '" style="text-align:right; padding-right:10px;;">' . lang("shipping") . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;">' . $this->sma->formatMoney($inv->shipping) . '</td></tr>';
                    }
                    ?>
                    <?php if ($inv->rounding != 0.0000) {
                      echo '<tr><td colspan="' . $cc . '" style="text-align:right; padding-right:10px;">' . lang("rounding") . '</td><td style="text-align:right; padding-right:10px;">' . $this->sma->formatMoney($inv->rounding) . '</td></tr>';
                     }
                    ?>
                    <tr>
                        <td colspan="<?= $cc; ?>"
                            style="text-align:right; font-weight:bold;"><?= lang("total_amount"); ?>
                            (<?= $default_currency->code; ?>)
                        </td>
                        <td style="text-align:right; padding-right:10px; font-weight:bold;"><?= $this->sma->formatMoney($return_purchase ? ($inv->grand_total+$return_purchase->grand_total) : ($inv->grand_total+$inv->rounding)); ?></td>
                    </tr>
                    <tr>
                        <td colspan="<?= $cc; ?>"
                            style="text-align:right; font-weight:bold;"><?= lang("paid"); ?>
                            (<?= $default_currency->code; ?>)
                        </td>
                        <td style="text-align:right; font-weight:bold;"><?= $this->sma->formatMoney($return_purchase ? ($inv->paid+$return_purchase->paid) : $inv->paid); ?></td>
                    </tr>
                    <tr>
                        <td colspan="<?= $cc; ?>"
                            style="text-align:right; font-weight:bold;"><?= lang("balance"); ?>
                            (<?= $default_currency->code; ?>)
                        </td>
                        <td style="text-align:right; font-weight:bold;"><?= $this->sma->formatMoney(($return_purchase ? (($inv->grand_total+$inv->rounding)+$return_purchase->grand_total) : ($inv->grand_total+$inv->rounding)) - ($return_purchase ? ($inv->paid+$return_purchase->paid) : $inv->paid)); ?></td>
                    </tr>

                    </tfoot>
                </table>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <?php
                        if ($inv->note || $inv->note != "") { ?>
                            <div class="well well-sm">
                                <p class="bold"><?= lang("note"); ?>:</p>
                                <div><?= $this->sma->decode_html($inv->note); ?></div>
                            </div>
                        <?php
                        }
                        ?>
                </div>

                <div class="col-xs-6 pull-right">
                 <?php

                    if ($Settings->invoice_view_purchase== 1) { 
                         echo $this->sma->purchaseTaxInvvoiceTabel($tax_summary,$taxItems,$inv,$return_purchase,$Settings);
                      
                        }?>
                    <div class="well well-sm">
                        <p>
                            <?= lang("created_by"); ?>: <?= $created_by->first_name . ' ' . $created_by->last_name; ?> <br>
                            <?= lang("date"); ?>: <?= $this->sma->hrld($inv->date); ?>
                        </p>
                        <?php if ($inv->updated_by) { ?>
                        <p>
                            <?= lang("updated_by"); ?>: <?= $updated_by->first_name . ' ' . $updated_by->last_name;; ?><br>
                            <?= lang("update_at"); ?>: <?= $this->sma->hrld($inv->updated_at); ?>
                        </p>
                        <?php } ?>
                    </div>
                </div>
            </div>
            <?php if (!$Supplier || !$Customer) { ?>
                <div class="buttons">
                    <?php if ($inv->attachment) { ?>
                        <div class="btn-group">
                            <a href="<?= site_url('welcome/download/' . $inv->attachment) ?>" class="tip btn btn-primary" title="<?= lang('attachment') ?>">
                                <i class="fa fa-chain"></i>
                                <span class="hidden-sm hidden-xs"><?= lang('attachment') ?></span>
                            </a>
                        </div>
                    <?php } ?>
                    <div class="btn-group btn-group-justified">
                        <div class="btn-group"> 
                            <a href="<?= site_url('purchases/add_payment/' . $inv->id) ?>" data-toggle="modal" data-target="#myModal2" class="tip btn btn-primary" title="<?= lang('add_payment') ?>">
                                <i class="fa fa-dollar"></i>
                                <span class="hidden-sm hidden-xs"><?= lang('add_payment') ?></span>
                            </a>
                        </div>
                        <div class="btn-group">
                            <a href="<?= site_url('purchases/email/' . $inv->id) ?>" data-toggle="modal" data-target="#myModal2" class="tip btn btn-primary" title="<?= lang('email') ?>">
                                <i class="fa fa-envelope-o"></i>
                                <span class="hidden-sm hidden-xs"><?= lang('email') ?></span>
                            </a>
                        </div>
                        <div class="btn-group">
                            <a href="<?= site_url('purchases/pdf/' . $inv->id) ?>" class="tip btn btn-primary" title="<?= lang('download_pdf') ?>">
                                <i class="fa fa-download"></i>
                                <span class="hidden-sm hidden-xs"><?= lang('pdf') ?></span>
                            </a>
                        </div>
                        <div class="btn-group">
                            <a href="<?= site_url('purchases/edit/' . $inv->id) ?>" class="tip btn btn-warning sledit" title="<?= lang('edit') ?>">
                                <i class="fa fa-edit"></i>
                                <span class="hidden-sm hidden-xs"><?= lang('edit') ?></span>
                            </a>
                        </div>
                        <div class="btn-group">
                            <a href="#" class="tip btn btn-danger bpo" title="<b><?= $this->lang->line("delete") ?></b>"
                                data-content="<div style='width:150px;'><p><?= lang('r_u_sure') ?></p><a class='btn btn-danger' href='<?= site_url('purchases/delete/' . $inv->id) ?>'><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button></div>"
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
