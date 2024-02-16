<?php defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php echo $this->lang->line('purchase') . ' ' . $inv->reference_no; ?></title>
        <link href="<?php echo $assets ?>styles/style.css" rel="stylesheet">
        <style type="text/css">
            html, body {
                height: 100%;
                background: #FFF;
            }
            body:before, body:after {
                display: none !important;
            }
            .table th {
                text-align: center;
                padding: 5px;
            }
            .table td {
                padding: 4px;
            }
        </style>
    </head>

    <body>
        <div id="wrap">
            <div class="row">
                <div class="col-lg-12">
                    <?php if ($logo) { ?>
                        <div class="text-center" style="margin-bottom:20px;">
                            <?php if (isset($default_printer->show_invoice_logo) && $default_printer->show_invoice_logo == 1): ?>
                                <img src="<?= base_url('assets/uploads/logos/' . $biller->logo); ?>" alt="<?= $biller->company != '-' ? $biller->company : $biller->name; ?>">
                            <?php endif; ?>
                        </div>
                    <?php }
                    ?>
                    <div class="clearfix"></div>

                    <div class="row">
                        <div class="col-xs-12 text-center">
                            <span class="bold"><?= $Settings->site_name; ?></span>
                       <!--  <br>   < ?= $warehouse->name ?>
                            < ?php
                            echo $warehouse->address . '<br>';
                            echo ($warehouse->phone ? lang('tel') . ': ' . $warehouse->phone . '<br>' : '') . ($warehouse->email ? lang('email') . ': ' . $warehouse->email : '');
                            ?> -->
                        </div> 
                    </div>
                    <div class="clearfix"></div>
                    <div class="row padding10">
                        <div class="col-xs-5">
                            <?php
                            echo "<p>" . lang("reference_no") . ": " . $inv->reference_no . "<br>";
                            if (!empty($inv->return_sale_ref)) {
                                echo lang("return_ref") . ': ' . $inv->return_sale_ref . '<br>';
                            }
                            ?>
                            <?php echo lang("Invoice Number") . ": " . $inv->id . "<br>"; ?>
                            <?= lang('date'); ?>:  <? echo date("d/m/Y H:i",strtotime($inv->date)) ?><br>
                            <h2 class=""><?= $biller->company != '-' ? $biller->company : $biller->name; ?></h2>
                            <?= $biller->company ? '' : 'Attn: ' . $biller->name; ?>
                            <?php
                            echo $biller->address . '<br />' . $biller->city . ' ' . $biller->postal_code . ' ' . $biller->state . '<br />' . $biller->country;
                            echo '<p>';
                            if ($inv->GstSale):
                                echo lang("gstn_no") . ": " . $biller->gstn_no . "<br>";
                            elseif ($biller->vat_no != "-" && $biller->vat_no != ""):
                                echo "<br>" . lang("vat_no") . ": " . $biller->vat_no;
                            endif;

                            if ($biller->cf1 != '-' && $biller->cf1 != '') {
                                echo '<br>' . $biller->cf1;
                            }
                            if ($biller->cf2 != '-' && $biller->cf2 != '') {
                                echo '<br>' . $biller->cf2;
                            }
                            if ($biller->cf3 != '-' && $biller->cf3 != '') {
                                echo '<br>' . $biller->cf3;
                            }
                            if ($biller->cf4 != '-' && $biller->cf4 != '') {
                                echo '<br>' . $biller->cf4;
                            }
                            if ($biller->cf5 != '-' && $biller->cf5 != '') {
                                echo '<br>' . $biller->cf5;
                            }
                            if ($biller->cf6 != '-' && $biller->cf6 != '') {
                                echo '<br>' . $biller->cf6;
                            }
                            echo '</p>';
                            echo lang('tel') . ': ' . $biller->phone . '<br />' . lang('email') . ': ' . $biller->email . '<br />';
                            ?>

                            <div class="clearfix"></div>
                        </div>
                        <div class="col-xs-5">
                            <br><br><br>
                            <h2 class=""><?= $customer->company ? $customer->name . '(' . $customer->company . ')' : $customer->name; ?></h2>

                            <?php
                            echo $customer->address . '<br />' . $customer->city . ' ' . $customer->postal_code . ' ' . $customer->state . '<br />' . $customer->country;
                            echo '<p>';

                            if ($customer->cf1) {
                                echo "PAN card no: " . $customer->cf1 . "<br>";
                            }
                            if ($customer->cf2) {
                                echo "State code: " . $customer->cf2 . "<br>";
                            }

                            if (isset($default_printer->show_tin) && $default_printer->show_tin == 1) {
                                if ($customer->gstn_no != "-" && $customer->gstn_no != "") {
                                    echo lang("gstn_no") . ": " . $customer->gstn_no . "<br>";
                                } elseif ($customer->vat_no != "-" && $customer->vat_no != "") {
                                    echo "<br>" . lang("vat_no") . ": " . $customer->vat_no;
                                }
                            }

                            echo '</p>';
                            echo lang('tel') . ': ' . $customer->phone . '<br />' . lang('email') . ': ' . $customer->email;
                            ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
<?php if ($default_printer->show_order_cf && $Settings->pos_type == 'pharma'): ?>
                        <table width="100%" style="margin:15px 0;">
                            <tr>
                                <td style="width:50%;text-align: left; display: table-cell;"> Patient Name : <?php echo $inv->cf1 ?>   </td>
                                <td style="width:50%;text-align: left; display: table-cell;">Doctor Name : <?php echo $inv->cf2 ?></td>
                            </tr>
                        </table>
<?php endif; ?>
                    <div style="clearfix"></div>
                    <?php
                    $col = 4;
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

                    <div class="table-responsive">
                    <?php echo $resOutput = $this->sma->posBillTable($default_printer, $inv, $return_sale, $rows, $return_rows, 1, 1); ?>
                    </div>
                        <?php
                        if ($payments) {
                            echo '<table class="table table-striped table-condensed"><tbody>';
                            foreach ($payments as $payment) {
                                echo '<tr>';
                                //if (($payment->paid_by == 'cash' || $payment->paid_by == 'deposit') && $payment->pos_paid) {
                                if ($payment->paid_by == 'cash' || $payment->paid_by == 'deposit' || $payment->paid_by == 'Due Payment') {
                                    echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                    echo '<td>Paid ' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                    echo '<td>' . (($payment->pos_balance >= 0) ? lang("balance") . ': ' : lang("change") . ': ') . $this->sma->formatMoney($payment->pos_balance) . '</td>';
                                } elseif (( $payment->paid_by == 'ppp' || $payment->paid_by == 'stripe') && $payment->cc_no) {
                                    echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                    echo '<td>Paid ' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                    echo '<td>' . lang("no") . ': ' . 'xxxx xxxx xxxx ' . substr($payment->cc_no, -4) . '</td>';
                                    echo '<td>' . lang("name") . ': ' . $payment->cc_holder . '</td>';
                                } elseif (($payment->paid_by == 'CC' || $payment->paid_by == 'DC' ) && $payment->transaction_id) {
                                    echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                    echo '<td>Transaction No : ' . $payment->transaction_id . '</td>';
                                    echo '<td>Paid ' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                } elseif ($payment->paid_by == 'instomojo' && $payment->transaction_id) {
                                    echo '<td>' . lang("paid_by") . ': Instomojo</td>';
                                    echo '<td>Payment ID: ' . $payment->transaction_id . '</td>';
                                    echo '<td>Paid ' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                    echo '<td>' . lang("balance") . ': ' . ($payment->pos_balance > 0 ? $this->sma->formatMoney($payment->pos_balance) : 0) . '</td>';
                                } elseif ($payment->paid_by == 'ccavenue' && $payment->transaction_id) {
                                    echo '<td>' . lang("paid_by") . ': CCavenue</td>';
                                    echo '<td>Payment ID: ' . $payment->transaction_id . '</td>';
                                    echo '<td>Paid ' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                    echo '<td>' . lang("balance") . ': ' . ($payment->pos_balance > 0 ? $this->sma->formatMoney($payment->pos_balance) : 0) . '</td>';
                                } elseif ($payment->paid_by == 'paytm' && $payment->transaction_id) {
                                    echo '<td>' . lang("paid_by") . ': Paytm</td>';
                                    echo '<td>Payment ID: ' . $payment->transaction_id . '</td>';
                                    echo '<td>Paid ' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                    echo '<td>' . lang("balance") . ': ' . ($payment->pos_balance > 0 ? $this->sma->formatMoney($payment->pos_balance) : 0) . '</td>';
                                } elseif ($payment->paid_by == 'paynear' && $payment->transaction_id) {
                                    echo '<td>' . lang("paid_by") . ': Paynear</td>';
                                    echo '<td>Payment ID: ' . $payment->transaction_id . '</td>';
                                    echo '<td>Paid ' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                    echo '<td>' . lang("balance") . ': ' . ($payment->pos_balance > 0 ? $this->sma->formatMoney($payment->pos_balance) : 0) . '</td>';
                                } elseif ($payment->paid_by == 'payumoney' && $payment->transaction_id) {
                                    echo '<td>' . lang("paid_by") . ': Payumoney</td>';
                                    echo '<td>Payment ID: ' . $payment->transaction_id . '</td>';
                                    echo '<td>Paid ' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                    echo '<td>' . lang("balance") . ': ' . ($payment->pos_balance > 0 ? $this->sma->formatMoney($payment->pos_balance) : 0) . '</td>';
                                } elseif ($payment->paid_by == 'Cheque' && $payment->cheque_no) {
                                    echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                    echo '<td>Paid ' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                    echo '<td>' . lang("cheque_no") . ': ' . $payment->cheque_no . '</td>';
                                } elseif ($payment->paid_by == 'gift_card' && $payment->pos_paid) {
                                    echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                    echo '<td>' . lang("no") . ': ' . $payment->cc_no . '</td>';
                                    echo '<td>Paid ' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                    echo '<td>' . lang("balance") . ': ' . ($payment->pos_balance > 0 ? $this->sma->formatMoney($payment->pos_balance) : 0) . '</td>';
                                } elseif ($payment->paid_by == 'other' && $payment->amount) {
                                    echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                    echo '<td>Transaction No : ' . $payment->transaction_id . '</td>';
                                    echo '<td>Paid ' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                    echo $payment->note ? '</tr><td colspan="2">' . lang("payment_note") . ': ' . $payment->note . '</td>' : '';
                                }
                                echo '</tr>';
                            }
                            echo '</tbody></table>';
                        }

                        if(!empty($return_payments)){
                            echo '<strong>' . lang('return_payments') . '</strong><table class="table table-striped table-condensed"><tbody>';
                            foreach ($return_payments as $payment) {
                                $payment->amount = (0 - $payment->amount);
                                echo '<tr>';
                                if ($payment->paid_by == 'cash' || $payment->paid_by == 'deposit') {
                                    echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                    echo '<td>Paid ' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                    echo '<td>' . (($payment->pos_balance >= 0) ? lang("balance") . ': ' : lang("change") . ': ') . $this->sma->formatMoney($payment->pos_balance) . '</td>';
                                } elseif (( $payment->paid_by == 'ppp' || $payment->paid_by == 'stripe') && $payment->cc_no) {
                                    echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                    echo '<td>Paid ' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                    echo '<td>' . lang("no") . ': ' . 'xxxx xxxx xxxx ' . substr($payment->cc_no, -4) . '</td>';
                                    echo '<td>' . lang("name") . ': ' . $payment->cc_holder . '</td>';
                                } elseif (($payment->paid_by == 'CC' || $payment->paid_by == 'DC') && $payment->transaction_id) {
                                    echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                    echo '<td>Transaction No: ' . $payment->transaction_id . '</td>';
                                    echo '<td>Paid ' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                    echo '<td>' . lang("no") . ': ' . 'xxxx xxxx xxxx ' . substr($payment->cc_no, -4) . '</td>';
                                    echo '<td>' . lang("name") . ': ' . $payment->cc_holder . '</td>';
                                } elseif ($payment->paid_by == 'Cheque' && $payment->cheque_no) {
                                    echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                    echo '<td>Paid ' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                    echo '<td>' . lang("cheque_no") . ': ' . $payment->cheque_no . '</td>';
                                } elseif ($payment->paid_by == 'gift_card' && $payment->pos_paid) {
                                    echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                    echo '<td>' . lang("no") . ': ' . $payment->cc_no . '</td>';
                                    echo '<td>Paid ' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                    echo '<td>' . lang("balance") . ': ' . ($payment->pos_balance > 0 ? $this->sma->formatMoney($payment->pos_balance) : 0) . '</td>';
                                } elseif ($payment->paid_by == 'other' && $payment->amount) {
                                    echo '<td>' . lang("paid_by") . ': ' . lang($payment->paid_by) . '</td>';
                                    echo '<td>Transaction No: ' . $payment->transaction_id . '</td>';
                                    echo '<td>Paid ' . lang("amount") . ': ' . $this->sma->formatMoney($payment->pos_paid == 0 ? $payment->amount : $payment->pos_paid) . ($payment->return_id ? ' (' . lang('returned') . ')' : '') . '</td>';
                                    echo $payment->note ? '</tr><td colspan="2">' . lang("payment_note") . ': ' . $payment->note . '</td>' : '';
                                }
                                echo '</tr>';
                            }
                            echo '</tbody></table>';
                        }
                        ?>
                    <p>&nbsp;</p>
                    <?php
                    $r = 1;
                    $category = 0;
                    $tax_summary = array();
                    foreach ($rows as $row) {

                        if (isset($tax_summary[$row->tax_code])) {
                            $tax_summary[$row->tax_code]['items'] += $row->quantity;
                            $tax_summary[$row->tax_code]['tax'] += $row->item_tax;
                            $tax_summary[$row->tax_code]['amt'] += ($row->quantity * $row->net_unit_price) - $row->item_discount;
                        } else {
                            $tax_summary[$row->tax_code]['items'] = $row->quantity;
                            $tax_summary[$row->tax_code]['tax'] = $row->item_tax;
                            $tax_summary[$row->tax_code]['amt'] = ($row->quantity * $row->net_unit_price) - $row->item_discount;
                            $tax_summary[$row->tax_code]['name'] = $row->tax_name;
                            $tax_summary[$row->tax_code]['code'] = $row->tax_code;
                            $tax_summary[$row->tax_code]['rate'] = $row->tax_rate;
                            $tax_summary[$row->tax_code]['tax_rate_id'] = $row->tax_rate_id;
                        }
                    }

                    if ($return_rows) {
                        foreach ($return_rows as $row) {
                            if (isset($tax_summary[$row->tax_code])) {
                                $tax_summary[$row->tax_code]['items'] += $row->quantity;
                                $tax_summary[$row->tax_code]['tax'] += $row->item_tax;
                                $tax_summary[$row->tax_code]['amt'] += ($row->quantity * $row->net_unit_price) - $row->item_discount;
                            } else {
                                $tax_summary[$row->tax_code]['items'] = $row->quantity;
                                $tax_summary[$row->tax_code]['tax'] = $row->item_tax;
                                $tax_summary[$row->tax_code]['amt'] = ($row->quantity * $row->net_unit_price) - $row->item_discount;
                                $tax_summary[$row->tax_code]['name'] = $row->tax_name;
                                $tax_summary[$row->tax_code]['code'] = $row->tax_code;
                                $tax_summary[$row->tax_code]['rate'] = $row->tax_rate;
                                $tax_summary[$row->tax_code]['tax_rate_id'] = $row->tax_rate_id;
                            }
                            $r++;
                        }
                    }

                    if ($Settings->invoice_view == 1) :
                        echo '<pagebreak />';
                        $resTaxTbl = $this->sma->taxInvvoiceTabel($tax_summary, $taxItems, $inv, $return_sale, $Settings, 1);
                        echo $resTaxTbl;
                    endif;
                    ?>
                    <?php
                    if ($default_printer->show_barcode_qrcode) {
                        ?>
                        <div class="order_barcodes">
                        <?= $this->sma->save_barcode($inv->reference_no, 'code128', 66, false); ?>
                        <?= $this->sma->qrcode('link', urlencode(site_url('sales/view/' . $inv->id)), 2); ?>
                        </div>
                        <?php } //close if $showbarcode?>

                    <div class="row">
                        <div class="col-xs-12">
                            <?php if ($inv->note || $inv->note != '') { ?>
                                <div class="well well-sm">
                                    <p class="bold"><?= lang('note'); ?>:</p>

                                    <div><?= $this->sma->decode_html($inv->note); ?></div>
                                </div>
                            <?php } ?>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
    </body>
</html>
