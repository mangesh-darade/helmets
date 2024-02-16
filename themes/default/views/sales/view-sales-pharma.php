<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
$is_pharma = isset($Settings->pos_type) && $Settings->pos_type=='pharma' ?true :false;
$itemTaxes = isset($inv->rows_tax)?$inv->rows_tax:array();
  
?>
<script type="text/javascript">
    $(document).ready(function () {
        $(document).on('click', '.sledit', function (e) {
            if (localStorage.getItem('slitems')) {
                e.preventDefault();
                var href = $(this).attr('href');
                bootbox.confirm("<?=lang('you_will_loss_sale_data')?>", function (result) {
                    if (result) {
                        window.location.href = href;
                    }
                });
            }
        });
    });
</script>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-file"></i><?= lang("invoice_no") . ' ' . $inv->id; ?></h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#">
                        <i class="icon fa fa-tasks tip" data-placement="left" title="<?= lang("actions") ?>">
                        </i>
                    </a>
                    <ul class="dropdown-menu pull-right tasks-menus" role="menu" aria-labelledby="dLabel">
                        <?php if ($inv->attachment) { ?>
                            <li>
                                <a href="<?= site_url('welcome/download/' . $inv->attachment) ?>">
                                    <i class="fa fa-chain"></i> <?= lang('attachment') ?>
                                </a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="<?= site_url('sales/edit/' . $inv->id) ?>" class="sledit">
                                <i class="fa fa-edit"></i> <?= lang('edit_sale') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('sales/payments/' . $inv->id) ?>" data-target="#myModal" data-toggle="modal">
                                <i class="fa fa-money"></i> <?= lang('view_payments') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('sales/add_payment/' . $inv->id) ?>" data-target="#myModal" data-toggle="modal">
                                <i class="fa fa-dollar"></i> <?= lang('add_payment') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('sales/email/' . $inv->id) ?>" data-target="#myModal" data-toggle="modal">
                                <i class="fa fa-envelope-o"></i> <?= lang('send_email') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('sales/pdf/' . $inv->id) ?>">
                                <i class="fa fa-file-pdf-o"></i> <?= lang('export_to_pdf') ?>
                            </a>
                        </li>
                        <?php if ( ! $inv->sale_id) { ?>
                        <li>
                            <a href="<?= site_url('sales/add_delivery/' . $inv->id) ?>" data-target="#myModal" data-toggle="modal">
                                <i class="fa fa-truck"></i> <?= lang('add_delivery') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('sales/return_sale/' . $inv->id) ?>">
                                <i class="fa fa-angle-double-left"></i> <?= lang('return_sale') ?>
                            </a>
                        </li>
                        <?php } ?>
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <?php if (!empty($inv->return_sale_ref) && $inv->return_id) {
                    echo '<div class="alert alert-info no-print"><p>'.lang("sale_is_returned").': '.$inv->return_sale_ref;
                    echo ' <a data-target="#myModal2" data-toggle="modal" href="'.site_url('sales/modal_view/'.$inv->return_id).'"><i class="fa fa-external-link no-print"></i></a><br>';
                    echo '</p></div>';
                } ?>
                <div class="print-only col-xs-12">
                    <img src="<?= base_url() . 'assets/uploads/logos/' . $biller->logo; ?>" alt="<?= $biller->company != '-' ? $biller->company : $biller->name; ?>">
                </div>
                <div class="well well-sm">
                    <div class="col-xs-4 border-right">

                        <div class="col-xs-2"><i class="fa fa-3x fa-building padding010 text-muted"></i></div>
                        <div class="col-xs-10">
                            <h2 class=""><?= $biller->company != '-' ? $biller->company : $biller->name; ?></h2>
                            <?= $biller->company ? "" : "Attn: " . $biller->name ?>

                            <?php
                            echo $biller->address . "<br>" . $biller->city . " " . $biller->postal_code . " " . $biller->state . "<br>" . $biller->country;

                            echo "<p>";

                            
                            if ($biller->gstn_no != "-" && $biller->gstn_no != "" && count($itemTaxes) > 0) {
                                echo "<br>" . lang("gstn_no") . ": " . $biller->gstn_no ;
                            }
                            elseif ($biller->vat_no != "-" && $biller->vat_no != "" && count($itemTaxes) ==0) {
                                echo "<br>" . lang("vat_no") . ": " . $biller->vat_no;
                            }
                            if ($biller->cf1 != "-" && $biller->cf1 != "") {
                                echo "<br>" . $biller->cf1;
                            }
                            if ($biller->cf2 != "-" && $biller->cf2 != "") {
                                echo "<br>" . $biller->cf2;
                            }
                            if ($biller->cf3 != "-" && $biller->cf3 != "") {
                                echo "<br>" . $biller->cf3;
                            }
                            if ($biller->cf4 != "-" && $biller->cf4 != "") {
                                echo "<br>" . $biller->cf4;
                            }
                            if ($biller->cf5 != "-" && $biller->cf5 != "") {
                                echo "<br>" . $biller->cf5;
                            }
                            if ($biller->cf6 != "-" && $biller->cf6 != "") {
                                echo "<br>" . $biller->cf6;
                            }

                            echo "</p>";
                            echo lang("tel") . ": " . $biller->phone . "<br>" . lang("email") . ": " . $biller->email;
                            ?>
                        </div>
                        <div class="clearfix"></div>

                    </div>
                    <div class="col-xs-4 border-right">

                        <div class="col-xs-2"><i class="fa fa-3x fa-user padding010 text-muted"></i></div>
                        <div class="col-xs-10">
                            <h2 class=""><?= $customer->company ? $customer->company : $customer->name; ?></h2>
                            <h3 class=""><?= $customer->name ? $customer->name : $customer->name; ?></h3>
                            <?= $customer->company ? "" : "Attn: " . $customer->name ?>

                            <?php
                            echo $customer->address . "<br>" . $customer->city . " " . $customer->postal_code . " " . $customer->state . "<br>" . $customer->country;

                            echo "<p>";

                            if ($customer->gstn_no != "-" && $customer->gstn_no != "" && count($itemTaxes) > 0) {
                                echo "<br>" . lang("gstn_no") . ": " . $customer->gstn_no ;
                            }
                            elseif ($customer->vat_no != "-" && $customer->vat_no != "" && count($itemTaxes) ==0) {
                                echo "<br>" . lang("vat_no") . ": " . $customer->vat_no;
                            }
                            
                            if ($customer->cf1 != "-" && $customer->cf1 != "") {
                                echo "<br>" . $customer->cf1;
                            }
                            if ($customer->cf2 != "-" && $customer->cf2 != "") {
                                echo "<br>" . $customer->cf2;
                            }
                            if ($customer->cf3 != "-" && $customer->cf3 != "") {
                                echo "<br>" . $customer->cf3;
                            }
                            if ($customer->cf4 != "-" && $customer->cf4 != "") {
                                echo "<br>" . $customer->cf4;
                            }
                            if ($customer->cf5 != "-" && $customer->cf5 != "") {
                                echo "<br>" . $customer->cf5;
                            }
                            if ($customer->cf6 != "-" && $customer->cf6 != "") {
                                echo "<br>" . $customer->cf6;
                            }

                            echo "</p>";
                            echo lang("tel") . ": " . $customer->phone . "<br>" . lang("email") . ": " . $customer->email;
                            ?>
                        </div>
                        <div class="clearfix"></div>

                    </div>
                    <div class="col-xs-4">
                        <div class="col-xs-2"><i class="fa fa-3x fa-building-o padding010 text-muted"></i></div>
                        <div class="col-xs-10">
                            <h2 class=""><?= $Settings->site_name; ?></h2>
                            <?= $warehouse->name ?>

                            <?php
                            echo $warehouse->address . "<br>";
                            echo ($warehouse->phone ? lang("tel") . ": " . $warehouse->phone . "<br>" : '') . ($warehouse->email ? lang("email") . ": " . $warehouse->email : '');
                            ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>
                <?php if ($Settings->invoice_view == 1) { ?>
                    <div class="col-xs-12 text-center">
                        <h1><?= lang('tax_invoice'); ?></h1>
                    </div>
                <?php } ?>
                <div class="clearfix"></div>
                  <?php if($is_pharma):?>
                <div class="col-xs-6">
                    <label>Patient Name : </label>
                    <?php echo $inv->cf1?>
                </div>   
                <div class="col-xs-6">
                    <label>Doctor Name :</label>
                    <?php echo $inv->cf2?>
                </div>  
                <div class="col-xs-12"></div>
                <div class="clearfix"></div>
                <?php endif;?>
                <!--<div class="col-xs-7 pull-right">
                    <div class="col-xs-12 text-right order_barcodes">
                        <?= $this->sma->save_barcode($inv->reference_no, 'code128', 66, false); ?>
                        <?= $this->sma->qrcode('link', urlencode(site_url('sales/view/' . $inv->id)), 2); ?>
                    </div>
                    <div class="clearfix"></div>
                </div>-->

                <div class="col-xs-5">
                    <div class="col-xs-2"><i class="fa fa-3x fa-file-text-o padding010 text-muted"></i></div>
                    <div class="col-xs-10">
                        <h2 class=""><?= lang("ref"); ?>: <?= $inv->reference_no; ?></h2>
                        <?php if (!empty($inv->return_sale_ref)) {
                            echo '<p>'.lang("return_ref").': '.$inv->return_sale_ref;
                            if ($inv->return_id) {
                                echo ' <a data-target="#myModal2" data-toggle="modal" href="'.site_url('sales/modal_view/'.$inv->return_id).'"><i class="fa fa-external-link no-print"></i></a><br>';
                            } else {
                                echo '</p>';
                            }
                        } ?>

                        <p style="font-weight:bold;"><?= lang("date"); ?>: <?= $this->sma->hrld($inv->date); ?></p>

                        <p style="font-weight:bold;"><?= lang("sale_status"); ?>: <?= lang($inv->sale_status); ?></p>

                        <p style="font-weight:bold;"><?= lang("payment_status"); ?>
                            : <?= lang($inv->payment_status); ?></p>
                            <p style="font-weight:bold;"><?= lang("Invoice Number");?> : <?= lang($inv->id ); ?></p>

                        <p>&nbsp;</p>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="clearfix"></div>
 <?php
               
                if (isset($eshop_order[0]) && is_array($eshop_order[0])):
                    $e_order = $eshop_order[0];
                    ?>
                    <div class="col-xs-4">
                        <div class="col-xs-2"><i class="fa fa-2x fa-money padding010 text-muted"></i></div>
                        <div class="col-xs-10">
                            <div class="col-xs-12"><h3 style="font-weight: bold;"><?= lang("Billing Details"); ?></h3></div>
                            <div class="col-xs-12"> Name : <?php echo isset($e_order['billing_name']) && !empty($e_order['billing_name'])?$e_order['billing_name']:'';?></div>
<div class="col-xs-12"> Phone : <?php echo isset($e_order['billing_phone']) && !empty($e_order['billing_phone'])?$e_order['billing_phone']:'';?></div>
<div class="col-xs-12"> Email : <?php echo isset($e_order['billing_email']) && !empty($e_order['billing_email'])?$e_order['billing_email']:'';?></div>
<div class="col-xs-12"> Address: <?php echo isset($e_order['billing_addr']) && !empty($e_order['billing_addr'])?$e_order['billing_addr']:'';?></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>

                    <div class="col-xs-4">
                        <div class="col-xs-2"><i class="fa fa-2x fa-bus padding010 text-muted"></i></div>
                        <div class="col-xs-10">
                            <div class="col-xs-12"><h3 style="font-weight: bold;"><?= lang("Shipping Details"); ?></h3></div>
                            <div class="col-xs-12"> Name : <?php echo isset($e_order['shipping_name']) && !empty($e_order['shipping_name'])?$e_order['shipping_name']:'';?></div>
                            <div class="col-xs-12"> Phone : <?php echo isset($e_order['shipping_phone']) && !empty($e_order['shipping_phone'])?$e_order['shipping_phone']:'';?></div>
                            <div class="col-xs-12"> Email : <?php echo isset($e_order['shipping_email']) && !empty($e_order['shipping_email'])?$e_order['shipping_email']:'';?></div>
                            <div class="col-xs-12"> Address: <?php echo isset($e_order['shipping_addr']) && !empty($e_order['shipping_addr'])?$e_order['shipping_addr']:'';?></div>
                        </div>
                        <div class="clearfix"></div>
                    </div>


                    <div class="col-xs-4">
                        <div class="col-xs-2"><i class="fa fa-2x fa-book padding010 text-muted"></i></div>
                        <div class="col-xs-10">
                            <div class="col-xs-12"><h3 style="font-weight: bold;"><?= lang("Payment & Shipping Method"); ?></h3></div>
                            <div class="col-xs-12">Payment Method : <?php echo isset($e_order['is_cod']) && ($e_order['is_cod']=='YES')?'Cash on delivery':'Online(Credit Card/ Debit Card / Net Banking)';?></div>
                            <div class="col-xs-12">&nbsp;</div>
                            <div class="col-xs-12">Shipping Method : <?php echo isset($e_order['shipping_method_name']) && !empty($e_order['shipping_method_name'])?$e_order['shipping_method_name']:'';?></div> 
                        </div>
                        <div class="clearfix"></div>
                    </div>
                <div class="clearfix"></div>
                <?php  endif;  ?>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped print-table order-table">

                        <thead>

                        <tr>
                            <th><?= lang("no"); ?></th>
                            <th><?= lang("description"); ?> (<?= lang("code"); ?>)</th>
                             <th><?= lang("Exp.Date"); ?> </th>
                            <th><?= lang("Batch.No"); ?>  </th>
                            <th><?= lang("quantity"); ?></th>
                            <?php
                            if ($Settings->product_serial) {
                                echo '<th style="text-align:center; vertical-align:middle;">' . lang("serial_no") . '</th>';
                            }
                            ?>
                            <th style="padding-right:20px;"><?= lang("mrp"); ?></th>
                            <th style="padding-right:20px;"><?= lang("unit_price"); ?></th>
                            <?php
                            if ($Settings->tax1 && $inv->product_tax > 0) {
                                echo '<th style="padding-right:20px; text-align:center; vertical-align:middle;">' . lang("tax") . '</th>';
                            }
                            if ($Settings->product_discount && $inv->product_discount != 0) {
                                echo '<th style="padding-right:20px; text-align:center; vertical-align:middle;">' . lang("discount") . '</th>';
                            }
                            ?>
                            <th style="padding-right:20px;"><?= lang("subtotal"); ?></th>
                        </tr>

                        </thead>

                        <tbody>

                        <?php $r = 1;
                        $tax_summary = array();
                        foreach ($rows as $row):
                        $offset = 9;
                            if (isset($tax_summary[$row->tax_code])) {
                                $tax_summary[$row->tax_code]['items'] += $row->quantity;
                                $tax_summary[$row->tax_code]['tax'] += $row->item_tax;
                                //$tax_summary[$row->tax_code]['amt'] += ($row->quantity * $row->net_unit_price) - $row->item_discount;
                                $tax_summary[$row->tax_code]['amt'] += ($row->quantity * $row->net_unit_price);
                            } else {
                                $tax_summary[$row->tax_code]['items'] = $row->quantity;
                                $tax_summary[$row->tax_code]['tax'] = $row->item_tax;
                                //$tax_summary[$row->tax_code]['amt'] = ($row->quantity * $row->net_unit_price) - $row->item_discount
                                $tax_summary[$row->tax_code]['amt'] = ($row->quantity * $row->net_unit_price);
                                $tax_summary[$row->tax_code]['name'] = $row->tax_name;
                                $tax_summary[$row->tax_code]['code'] = $row->tax_code;
                                $tax_summary[$row->tax_code]['rate'] = $row->tax_rate;
                                 $tax_summary[$row->tax_code]['tax_rate_id'] =  $row->tax_rate_id;
                            }
                            ?>
                            <tr>
                                <td style="text-align:center; width:40px; vertical-align:middle;"><?= $r; ?></td>
                                <td style="vertical-align:middle;">
                                    <?php if($Settings->sales_image == '1') { ?>
                                    <img src="assets/uploads/thumbs/<?=$row->image?>" style="width:30px; height:30px;" alt="<?=$row->product_code?>" />
                                    <?php } ?>
                                    <?= $row->product_code.' - '.$row->product_name . ($row->variant ? ' (' . $row->variant . ')' : ''); ?>
                                    <?= $row->details ? '<br>' . $row->details : ''; ?>
                                    </td>
                                <td style="text-align:center;   vertical-align:middle;"><?= $row->cf1; ?></td>
                                <td style="text-align:center;   vertical-align:middle;"><?= $row->cf2; ?></td>
                                <td style="width: 100px; text-align:center; vertical-align:middle;"><?= $this->sma->formatQuantity($row->unit_quantity).' '.$row->product_unit_code; ?></td>
                                <?php
                                if ($Settings->product_serial) {
                                    echo '<td>' . $row->serial_no . '</td>';
                                }
                                ?>
                                <td style="text-align:right; width:120px; padding-right:10px;"><?= $this->sma->formatMoney($row->mrp); ?></td>
                                <td style="text-align:right; width:120px; padding-right:10px;"><?= $this->sma->formatMoney($row->unit_price); ?></td>
                                <?php
                                if ($Settings->tax1 && $inv->product_tax > 0) {
                                    echo '<td style="width: 120px; text-align:right; vertical-align:middle;">' . ($row->item_tax != 0 && $row->tax_code ? '<small>('.$row->tax_code.')</small>' : '') . ' ' . $this->sma->formatMoney($row->item_tax) . '</td>';
                                }
                                if ($Settings->product_discount && $inv->product_discount != 0) {
                                    echo '<td style="width: 120px; text-align:right; vertical-align:middle;">' . ($row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '') . $this->sma->formatMoney($row->item_discount) . '</td>';
                                }
                                ?>
                                <td style="text-align:right; width:120px; padding-right:10px;"><?= $this->sma->formatMoney($row->subtotal); ?></td>
                            </tr>
                            <?php echo $this->sma->taxAttrTBL($itemTaxes,$row->id,$offset);?>
                            <?php
                            $r++;
                        endforeach;

                        if ($return_rows) {
                            echo '<tr class="warning"><td colspan="100%" class="no-border"><strong>'.lang('returned_items').'</strong></td></tr>';
                            foreach ($return_rows as $row):
                            $offset = 8;
                                if (isset($tax_summary[$row->tax_code])) {
                                    $tax_summary[$row->tax_code]['items'] += $row->quantity;
                                    $tax_summary[$row->tax_code]['tax'] += $row->item_tax;
                                    //$tax_summary[$row->tax_code]['amt'] += ($row->quantity * $row->net_unit_price) - $row->item_discount;
                                    $tax_summary[$row->tax_code]['amt'] += ($row->quantity * $row->net_unit_price);
                                } else {
                                    $tax_summary[$row->tax_code]['items'] = $row->quantity;
                                    $tax_summary[$row->tax_code]['tax'] = $row->item_tax;
                                    //$tax_summary[$row->tax_code]['amt'] = ($row->quantity * $row->net_unit_price) - $row->item_discount;
                                    $tax_summary[$row->tax_code]['amt'] = ($row->quantity * $row->net_unit_price);
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
                                        <?= $row->details ? '<br>' . $row->details : ''; ?> </td>
                                     <td style="text-align:center; vertical-align:middle;"><?= $row->cf1; ?></td>
                                    <td style="text-align:center; vertical-align:middle;"><?= $row->cf2; ?></td>
                               
                                    <td style="width: 100px; text-align:center; vertical-align:middle;"><?= $this->sma->formatQuantity($row->quantity).' '.$row->product_unit_code; ?></td>
                                    <?php
                                    if ($Settings->product_serial) {
                                        echo '<td>' . $row->serial_no . '</td>';
                                    }
                                    ?>
                                     <td style="text-align:right; width:120px; padding-right:10px;"><?= $this->sma->formatMoney($row->mrp); ?></td>
                                    <td style="text-align:right; width:120px; padding-right:10px;"><?= $this->sma->formatMoney($row->unit_price); ?></td>
                                    <?php
                                    if ($Settings->tax1 && $inv->product_tax > 0) {
                                        echo '<td style="width: 120px; text-align:right; vertical-align:middle;">' . ($row->item_tax != 0 && $row->tax_code ? '<small>('.$row->tax_code.')</small>' : '') . ' ' . $this->sma->formatMoney($row->item_tax) . '</td>';
                                    }
                                    if ($Settings->product_discount && $inv->product_discount != 0) {
                                        echo '<td style="width: 120px; text-align:right; vertical-align:middle;">' . ($row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '') . $this->sma->formatMoney($row->item_discount) . '</td>';
                                    }
                                    ?>
                                    <td style="text-align:right; width:120px; padding-right:10px;"><?= $this->sma->formatMoney($row->subtotal); ?></td>
                                </tr>
                                <?php echo $this->sma->taxAttrTBL($itemTaxes,$row->id,$offset);?>
                                <?php
                                $r++;
                            endforeach;
                        }

                        ?>
                        </tbody>
                        <tfoot>
                        <?php
                        $col = 7;
                        if ($Settings->product_serial) {
                            $col++;
                        }
                        if ($Settings->product_discount && $inv->product_discount != 0) {
                            $col++;
                        }
                        if ($Settings->tax1 && $inv->product_tax > 0) {
                            $col++;
                        }
                        if ($Settings->product_discount && $inv->product_discount != 0 && $Settings->tax1 && $inv->product_tax > 0) {
                            $tcol = $col - 2;
                        } elseif ($Settings->product_discount && $inv->product_discount != 0) {
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
                                    style="text-align:right; padding-right:10px;"><?= lang("total"); ?>
                                    (<?= $default_currency->code; ?>)
                                </td>
                                <?php
                                if ($Settings->tax1 && $inv->product_tax > 0) {
                                    echo '<td style="text-align:right;">' . $this->sma->formatMoney($return_sale ? ($inv->product_tax+$return_sale->product_tax) : $inv->product_tax) . '</td>';
                                }
                                if ($Settings->product_discount && $inv->product_discount != 0) {
                                    echo '<td style="text-align:right;">' . $this->sma->formatMoney($return_sale ? ($inv->product_discount+$return_sale->product_discount) : $inv->product_discount) . '</td>';
                                }
                                ?>
                                <td style="text-align:right; padding-right:10px;"><?= $this->sma->formatMoney($return_sale ? (($inv->total + $inv->product_tax)+($return_sale->total + $return_sale->product_tax)) : ($inv->total + $inv->product_tax)); ?></td>
                            </tr>
                        <?php } ?>
                        <?php
                        if ($return_sale) {
                           echo '<tr>';
                                ?> 
                            <?php
                            echo '<td colspan="' . $col . '" style="text-align:right; padding-right:10px;;">' . lang("return_total") . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;">' . $this->sma->formatMoney($return_sale->grand_total) . '</td></tr>';
                        }
                        if ($inv->surcharge != 0) {
                            echo '<tr>';
                            ?>
                           
                            <?php echo '<td colspan="' . $col . '" style="text-align:right; padding-right:10px;;">' . lang("return_surcharge") . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;">' . $this->sma->formatMoney($inv->surcharge) . '</td></tr>';
                        }
                       
                        ?>
                        <?php if ($inv->order_discount != 0) {
                             echo '<tr>';
                            ?>
                          
                               
                            <?php
                           echo '<td colspan="' . $col . '" style="text-align:right; padding-right:10px;;">' . lang("order_discount") . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;">'.($inv->order_discount_id ? '<small>('.$inv->order_discount_id.')</small> ' : '') . $this->sma->formatMoney($return_sale ? ($inv->order_discount+$return_sale->order_discount) : $inv->order_discount) . '</td></tr>';
                       
                     }
                        ?>
                        <?php if ($Settings->tax2 && $inv->order_tax != 0) {
                           echo '<tr>';
                            ?>
                             <?php echo '<td colspan="' . $col . '" style="text-align:right; padding-right:10px;">' . lang("order_tax") . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;">' . $this->sma->formatMoney($return_sale ? ($inv->order_tax+$return_sale->order_tax) : $inv->order_tax) . '</td></tr>'; ?>
                    <?php  
                    }
                        ?>
                        <?php if ($inv->shipping != 0) {
                             echo '<tr>'
                            ?>
                          <?php echo '<td colspan="' . $col . '" style="text-align:right; padding-right:10px;;">' . lang("shipping") . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;">' . $this->sma->formatMoney($inv->shipping) . '</td></tr>'; ?>
                        <?php
                            }
                        ?>
                        <tr> 
                            <td colspan="<?= $col; ?>"
                                style="text-align:right; font-weight:bold;"><?= lang("total_amount"); ?>
                                (<?= $default_currency->code; ?>)
                            </td>
                            <td style="text-align:right; padding-right:10px; font-weight:bold;"><?= $this->sma->formatMoney($return_sale ? ($inv->grand_total+$return_sale->grand_total) : $inv->grand_total); ?></td>
                        </tr>
                        <tr>
                            <td colspan="<?= $col; ?>"
                                style="text-align:right; font-weight:bold;"><?= lang("paid"); ?>
                                (<?= $default_currency->code; ?>)
                            </td>
                            <td style="text-align:right; font-weight:bold;"><?= $this->sma->formatMoney($return_sale ? ($inv->paid+$return_sale->paid) : $inv->paid); ?></td>
                        </tr>
                        <tr>
 
                            <td colspan="<?= $col; ?>"
                                style="text-align:right; font-weight:bold;"><?= lang("balance"); ?>
                                (<?= $default_currency->code; ?>)
                            </td>
                            <td style="text-align:right; font-weight:bold;"><?= $this->sma->formatMoney(($return_sale ? ($inv->grand_total+$return_sale->grand_total) : $inv->grand_total) - ($return_sale ? ($inv->paid+$return_sale->paid) : $inv->paid)); ?></td>
                        </tr>

                        </tfoot>
                    </table>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <?php
                        if ($inv->note || $inv->note != "") { ?>
                            <div class="well well-sm">
                                <p class="bold"><?= lang("note"); ?>:</p>

                                <div><?= $this->sma->decode_html($inv->note); ?></div>
                              <-- <div><h3>thank you for visit</h3></div>-->
                            </div>
                        <?php
                        }
                        if ($inv->staff_note || $inv->staff_note != "") { ?>
                            <div class="well well-sm staff_note">
                                <p class="bold"><?= lang("staff_note"); ?>:</p>

                                <div><?= $this->sma->decode_html($inv->staff_note); ?></div>
                               <!-- <div><h3>thank you for visit</h3></div>-->
                            </div>
                        <?php } ?>

                        <?php if ($customer->award_points != 0 && $Settings->each_spent > 0) { ?>
                      <!-- <div class="col-xs-12 col-sm-10 col-md-8 col-lg-6">
                            <div class="well well-sm">
                                <?=
                                '<p>'.lang('this_sale').': '.floor(($inv->grand_total/$Settings->each_spent)*$Settings->ca_point)
                                .'<br>'.
                                lang('total').' '.lang('award_points').': '. $customer->award_points . '</p>';?>
                            </div>
                        </div>-->
                        <?php } ?>
                    </div>
                    

                    <div class="col-xs-6">
                         
                         <?php
                        if ($Settings->invoice_view == 1) {
                            $resTaxTbl = $this->sma->taxInvvoiceTabel($tax_summary,$taxItems,$inv,$return_sale,$Settings);
            	     	    echo  $resTaxTbl;
                        }
                        ?>
                        <div class="well well-sm">
                        <h3>Thank you for visiting</h3>
                        </div>
                        
                        <div class="well well-sm">
                            <p><?= lang("created_by"); ?>
                                : <?= $created_by->first_name . ' ' . $created_by->last_name; ?> </p>

                            <p><?= lang("date"); ?>: <?= $this->sma->hrld($inv->date); ?></p>
                            <?php if ($inv->updated_by) { ?>
                                <p><?= lang("updated_by"); ?>
                                    : <?= $updated_by->first_name . ' ' . $updated_by->last_name;; ?></p>
                                <p><?= lang("update_at"); ?>: <?= $this->sma->hrld($inv->updated_at); ?></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>

                <?php if ($inv->payment_status != 'paid') { ?>
                    <div id="payment_buttons" class="row text-center padding10 no-print">

                        <?php if ($paypal->active == "1" && $inv->grand_total != "0.00") {
                            if (trim(strtolower($customer->country)) == $biller->country) {
                                $paypal_fee = $paypal->fixed_charges + ($inv->grand_total * $paypal->extra_charges_my / 100);
                            } else {
                                $paypal_fee = $paypal->fixed_charges + ($inv->grand_total * $paypal->extra_charges_other / 100);
                            }
                            ?>
                            <div class="col-xs-6 text-center">
                                <form action="https://www.paypal.com/cgi-bin/webscr" method="post">
                                    <input type="hidden" name="cmd" value="_xclick">
                                    <input type="hidden" name="business" value="<?= $paypal->account_email; ?>">
                                    <input type="hidden" name="item_name" value="<?= $inv->reference_no; ?>">
                                    <input type="hidden" name="item_number" value="<?= $inv->id; ?>">
                                    <input type="hidden" name="image_url"
                                           value="<?= base_url() . 'assets/uploads/logos/' . $Settings->logo; ?>">
                                    <input type="hidden" name="amount"
                                           value="<?= ($inv->grand_total - $inv->paid) + $paypal_fee; ?>">
                                    <input type="hidden" name="no_shipping" value="1">
                                    <input type="hidden" name="no_note" value="1">
                                    <input type="hidden" name="currency_code" value="<?= $default_currency->code; ?>">
                                    <input type="hidden" name="bn" value="FC-BuyNow">
                                    <input type="hidden" name="rm" value="2">
                                    <input type="hidden" name="return"
                                           value="<?= site_url('sales/view/' . $inv->id); ?>">
                                    <input type="hidden" name="cancel_return"
                                           value="<?= site_url('sales/view/' . $inv->id); ?>">
                                    <input type="hidden" name="notify_url"
                                           value="<?= site_url('payments/paypalipn'); ?>"/>
                                    <input type="hidden" name="custom"
                                           value="<?= $inv->reference_no . '__' . ($inv->grand_total - $inv->paid) . '__' . $paypal_fee; ?>">
                                    <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block"><i
                                            class="fa fa-money"></i> <?= lang('pay_by_paypal') ?></button>
                                </form>
                            </div>
                        <?php } ?>


                        <?php if ($skrill->active == "1" && $inv->grand_total != "0.00") {
                            if (trim(strtolower($customer->country)) == $biller->country) {
                                $skrill_fee = $skrill->fixed_charges + ($inv->grand_total * $skrill->extra_charges_my / 100);
                            } else {
                                $skrill_fee = $skrill->fixed_charges + ($inv->grand_total * $skrill->extra_charges_other / 100);
                            }
                            ?>
                            <div class="col-xs-6 text-center">
                                <form action="https://www.moneybookers.com/app/payment.pl" method="post">
                                    <input type="hidden" name="pay_to_email" value="<?= $skrill->account_email; ?>">
                                    <input type="hidden" name="status_url"
                                           value="<?= site_url('payments/skrillipn'); ?>">
                                    <input type="hidden" name="cancel_url"
                                           value="<?= site_url('sales/view/' . $inv->id); ?>">
                                    <input type="hidden" name="return_url"
                                           value="<?= site_url('sales/view/' . $inv->id); ?>">
                                    <input type="hidden" name="language" value="EN">
                                    <input type="hidden" name="ondemand_note" value="<?= $inv->reference_no; ?>">
                                    <input type="hidden" name="merchant_fields" value="item_name,item_number">
                                    <input type="hidden" name="item_name" value="<?= $inv->reference_no; ?>">
                                    <input type="hidden" name="item_number" value="<?= $inv->id; ?>">
                                    <input type="hidden" name="amount"
                                           value="<?= ($inv->grand_total - $inv->paid) + $skrill_fee; ?>">
                                    <input type="hidden" name="currency" value="<?= $default_currency->code; ?>">
                                    <input type="hidden" name="detail1_description" value="<?= $inv->reference_no; ?>">
                                    <input type="hidden" name="detail1_text"
                                           value="Payment for the sale invoice <?= $inv->reference_no . ': ' . $inv->grand_total . '(+ fee: ' . $skrill_fee . ') = ' . $this->sma->formatMoney($inv->grand_total + $skrill_fee); ?>">
                                    <input type="hidden" name="logo_url"
                                           value="<?= base_url() . 'assets/uploads/logos/' . $Settings->logo; ?>">
                                    <button type="submit" name="submit" class="btn btn-primary btn-lg btn-block"><i
                                            class="fa fa-money"></i> <?= lang('pay_by_skrill') ?></button>
                                </form>
                            </div>
                        <?php } ?>
                        <div class="clearfix"></div>
                    </div>
                <?php } ?>
                
                <?php if ($payments) { ?>
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="table-responsive">
                                <table class="table table-bordered table-striped table-condensed print-table">
                                    <thead>
                                    <tr>
                                        <th><?= lang('date') ?></th>
                                        <th><?= lang('payment_reference') ?></th>
                                        <th><?= lang('paid_by') ?></th>
                                           <?php
                                                if ($payments[0]->paid_by == 'gift_card' || $payments[0]->paid_by == 'CC' || $payments[0]->paid_by == 'DC') {
                                                    echo  '<th>'. lang('transaction_no') .'</th>' ;
                                                } elseif ($payments[0]->paid_by == 'Cheque') {
                                                    echo '<th>' . lang('cheque_no') . '</th>';
                                                }
                                            ?>
                                        <th><?= lang('amount') ?></th>
                                        <th><?= lang('created_by') ?></th>
                                        <th><?= lang('type') ?></th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($payments as $payment) { ?>
                                        <tr <?= $payment->type == 'returned' ? 'class="warning"' : ''; ?>>
                                            <td><?= $this->sma->hrld($payment->date) ?></td>
                                            <td><?= $payment->reference_no; ?></td>
                                            <td><?= lang($payment->paid_by);?></td>
                                            <?php
                                                if ($payment->paid_by == 'gift_card' || $payment->paid_by == 'CC' || $payment->paid_by == 'DC') {
                                                    //echo ' (' . $payment->cc_no . ')';
                                                      echo  '<td>'. $payment->transaction_id .'</td>' ;
                                                } elseif ($payment->paid_by == 'Cheque') {
                                                    echo '<td>' . $payment->cheque_no . '</td>';
                                                }
                                                ?>
                                            </td>                                             
                                            <td><?= $this->sma->formatMoney($payment->amount); ?></td>
                                            <td><?= $payment->first_name . ' ' . $payment->last_name; ?></td>
                                            <td><?= lang($payment->type); ?></td>
                                        </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        </div>
        <?php if (!$Supplier || !$Customer) { ?>
            <div class="buttons">
                <div class="btn-group btn-group-justified">
                    <?php if ($inv->attachment) { ?>
                        <div class="btn-group">
                            <a href="<?= site_url('welcome/download/' . $inv->attachment) ?>" class="tip btn btn-primary" title="<?= lang('attachment') ?>">
                                <i class="fa fa-chain"></i>
                                <span class="hidden-sm hidden-xs"><?= lang('attachment') ?></span>
                            </a>
                        </div>
                    <?php } ?>
                    <div class="btn-group">
                        <a href="<?= site_url('sales/payments/' . $inv->id) ?>" data-toggle="modal" data-target="#myModal" class="tip btn btn-primary tip" title="<?= lang('view_payments') ?>">
                            <i class="fa fa-money"></i> <span class="hidden-sm hidden-xs"><?= lang('view_payments') ?></span>
                        </a>
                    </div>
                    <div class="btn-group">
                        <a href="<?= site_url('sales/add_payment/' . $inv->id) ?>" data-toggle="modal" data-target="#myModal" class="tip btn btn-primary tip" title="<?= lang('add_payment') ?>">
                            <i class="fa fa-money"></i> <span class="hidden-sm hidden-xs"><?= lang('add_payment') ?></span>
                        </a>
                    </div>
                    <div class="btn-group">
                        <a href="<?= site_url('sales/email/' . $inv->id) ?>" data-toggle="modal" data-target="#myModal" class="tip btn btn-primary tip" title="<?= lang('email') ?>">
                            <i class="fa fa-envelope-o"></i> <span class="hidden-sm hidden-xs"><?= lang('email') ?></span>
                        </a>
                    </div>
                    <div class="btn-group">
                        <a href="<?= site_url('sales/pdf/' . $inv->id) ?>" class="tip btn btn-primary" title="<?= lang('download_pdf') ?>">
                            <i class="fa fa-download"></i> <span class="hidden-sm hidden-xs"><?= lang('pdf') ?></span>
                        </a>
                    </div>
                    <?php if ( ! $inv->sale_id) { ?>
                    <div class="btn-group">
                        <a href="<?= site_url('sales/add_delivery/' . $inv->id) ?>" data-toggle="modal" data-target="#myModal" class="tip btn btn-primary tip" title="<?= lang('add_delivery') ?>">
                            <i class="fa fa-truck"></i> <span class="hidden-sm hidden-xs"><?= lang('add_delivery') ?></span>
                        </a>
                    </div>
                    <div class="btn-group">
                        <a href="<?= site_url('sales/edit/' . $inv->id) ?>" class="tip btn btn-warning tip sledit" title="<?= lang('edit') ?>">
                            <i class="fa fa-edit"></i> <span class="hidden-sm hidden-xs"><?= lang('edit') ?></span>
                        </a>
                    </div>
                    <div class="btn-group">
                        <a href="#" class="tip btn btn-danger bpo"
                            title="<b><?= $this->lang->line("delete_sale") ?></b>"
                            data-content="<div style='width:150px;'><p><?= lang('r_u_sure') ?></p><a class='btn btn-danger' href='<?= site_url('sales/delete/' . $inv->id) ?>'><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button></div>"
                            data-html="true" data-placement="top"><i class="fa fa-trash-o"></i> 
                            <span class="hidden-sm hidden-xs"><?= lang('delete') ?></span>
                        </a>
                    </div>
                    <?php } ?>
                    <!--<div class="btn-group"><a href="<?= site_url('sales/excel/' . $inv->id) ?>" class="tip btn btn-primary"  title="<?= lang('download_excel') ?>"><i class="fa fa-download"></i> <?= lang('excel') ?></a></div>-->
                </div>
            </div>
        <?php } ?>
    </div>
</div>
