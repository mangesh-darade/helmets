<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!doctype html>
<html>
    <head>
        <meta name="viewport" content="width=device-width">
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
        <title><?= $page_title . " " . lang("no") . " " . $inv->id; ?></title>
        <style>
            * { font-family: "Helvetica Neue", "Helvetica", Helvetica, Arial, sans-serif; font-size: 100%; line-height: 1.6em; margin: 0; padding: 0; } img { max-width: 100%; } body { -webkit-font-smoothing: antialiased; height: 100%; -webkit-text-size-adjust: none; width: 100% !important; } a { color: #348eda; } .btn-primary { Margin-bottom: 10px; width: auto !important; } .btn-primary td { background-color: #62cb31; border-radius: 3px; font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; font-size: 14px; text-align: center; vertical-align: top; } .btn-primary td a { background-color: #62cb31; border: solid 1px #62cb31; border-radius: 3px; border-width: 4px 20px; display: inline-block; color: #ffffff; cursor: pointer; font-weight: bold; line-height: 2; text-decoration: none; } .last { margin-bottom: 0; } .first { margin-top: 0; } .padding { padding: 10px 0; } table.body-wrap { padding: 20px 5px; width: 100%; } table.body-wrap .container { border: 1px solid #e4e5e7; } table.footer-wrap { clear: both !important; width: 100%; } .footer-wrap .container p { color: #666666; font-size: 12px; } table.footer-wrap a { color: #999999; } h1, h2, h3 { color: #111111; font-family: "Helvetica Neue", Helvetica, Arial, "Lucida Grande", sans-serif; font-weight: 200; line-height: 1.2em; margin: 10px 0 10px; } h1 { font-size: 36px; } h2 { font-size: 28px; } h3 { font-size: 22px; } p, ul, ol {font-size: 14px;font-weight: normal;margin-bottom: 10px;} ul li, ol li {margin-left: 5px;list-style-position: inside;} .container { clear: both !important; display: block !important; Margin: 0 auto !important; max-width: 600px !important; } .body-wrap .container { padding: 20 5pxpx; } .content { display: block; margin: 0 auto; max-width: 600px; } .content table { width: 100%; }
            .table-bordered>thead>tr>th,
            .table-bordered>tbody>tr>th,
            .table-bordered>tfoot>tr>th,
            .table-bordered>thead>tr>td,
            .table-bordered>tbody>tr>td,
            .table-bordered>tfoot>tr>td {
                border: 1px solid #ddd
            }
            .table-bordered>thead>tr>th,
            .table-bordered>thead>tr>td {
                border-bottom-width: 2px
            }
            .table-striped>tbody>tr:nth-child(odd)>td,
            .table-striped>tbody>tr:nth-child(odd)>th {
                background-color: #f9f9f9
            }
            .table-hover>tbody>tr:hover>td,
            .table-hover>tbody>tr:hover>th {
                background-color: #f5f5f5
            }
        </style>

    </head>

    <body bgcolor="#f7f9fa" style="width:auto;" >
        <table class="body-wrap" bgcolor="#f7f9fa">
            <tr>
                <td></td>
                <td class="container" bgcolor="#FFFFFF">
                    <div class="content">
                        <table>
                            <tr>
                                <td>
                                    <h2>
                                        <?php if (isset($default_printer->show_invoice_logo) && $default_printer->show_invoice_logo == 1): ?>
                                            <img src="<?= base_url('assets/uploads/logos/' . $biller->logo); ?>" alt="<?= $biller->company != '-' ? $biller->company : $biller->name; ?>">
                                        <?php endif; ?>
                                    </h2>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <div style="clear:both;height:15px;"></div>
                                    <!-- <strong><?= lang('receipt') . ' ' . lang('from') . ' ' . $Settings->site_name; ?></strong> -->
                                    <div style="text-align:left;">
                                        <?php //$this->sma->save_barcode($inv->reference_no, 'code128', 66, false); ?>
                                        <?php //$this->sma->qrcode('link', urlencode(site_url('pos/view/' . $inv->id)), 2); ?>
                                    </div>
                                    <div style="clear:both;height:15px;"></div>
                                    <div id="receiptData" style="border:1px solid #DDD; padding:10px; text-align:center;">

                                        <div class="text-center">
                                            <h3 style="text-transform:uppercase;"><?= $biller->company != '-' ? $biller->company : $biller->name; ?></h3>
                                            <?php
                                            if ($inv->GstSale):
                                            $TaxLable = ($Settings->default_currency == 'USD') ? 'ROC: ' : 'GSTIN: ';  
                                                
                                                echo $TaxLable . $biller->gstn_no . "<br>";
                                            endif;

                                            echo "<p>" . $biller->address . " " . $biller->city . " " . $biller->postal_code . " " . $biller->state . " " . $biller->country .
                                            "<br>" . lang("tel") . ": " . $biller->phone . "</p>";

                                            if ($Settings->invoice_view == 1) :
                                                echo '<h4 style="font-weight:bold;">' . lang('tax_invoice') . '</h4>';
                                            endif;
                                            ?>
                                            <?php echo lang("Invoice Number") . ": " . $inv->id . "<br><br>"; ?>
                                        </div>
                                        <?php
                                        if ($pos->cf_title1 != "" && $pos->cf_value1 != "") {
                                            echo $pos->cf_title1 . ": " . $pos->cf_value1 . "<br>";
                                        }
                                        if ($pos->cf_title2 != "" && $pos->cf_value2 != "") {
                                            echo $pos->cf_title2 . ": " . $pos->cf_value2 . "<br>";
                                        }
                                        echo "<p>" . lang("reference_no") . ": " . $inv->reference_no . "<br>";
                                        echo lang("customer") . ": " . $inv->customer . "<br>";

                                        if (isset($default_printer->show_customer_info) && $default_printer->show_customer_info == 1):
                                            if (isset($default_printer->show_tin) && $default_printer->show_tin == 1):
                                                if ($inv->GstSale):
                                                    echo $TaxLable . $customer->gstn_no . "<br>";
                                                elseif (!empty($customer->vat_no)):
                                                    echo lang('vat_no') . ": " . $customer->vat_no . "<br>";
                                                endif;
                                            endif;
                                        endif;
                                        echo "Email: " . $customer->email . "<br>";
                                        if ($customer->cf1) {
                                            echo "PAN card no: " . $customer->cf1 . "<br>";
                                        }
                                        if ($customer->cf2) {
                                            echo "State code: " . $customer->cf2 . "<br>";
                                        }
                                        echo lang("date") . ": " . $this->sma->hrld($inv->date) . "</p>";
                                        ?>
                                        <div style="clear:both;"></div>
                                        <?php if ($default_printer->show_order_cf && $Settings->pos_type == 'pharma'): ?>
                                            <table width="100%" style="margin:15px 0;">
                                                <tr>
                                                    <td style="width:50%;text-align: left; display: table-cell;"> Patient Name : <?php echo $inv->cf1 ?>   </td>
                                                    <td style="width:50%;text-align: left; display: table-cell;">Doctor Name : <?php echo $inv->cf2 ?></td>
                                                </tr>
                                            </table>
                                        <?php endif; ?>
                                        <div style="clear:both;"></div>
                                        <?php
                                        $resOutput = $this->sma->posBillTable($default_printer, $inv, $return_sale, $rows, $return_rows, 1);
                                        echo $resOutput = str_replace('<table ', '<table cellspacing="0" cellpadding="0" ', $resOutput);
                                        ?> 
                                        <p>&nbsp;</p>
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

                                        if ($return_payments) {
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
                                                $tax_summary[$row->tax_code]['amt'] += ($row->quantity * $row->net_unit_price);
                                            } else {
                                                $tax_summary[$row->tax_code]['items'] = $row->quantity;
                                                $tax_summary[$row->tax_code]['tax'] = $row->item_tax;
                                                $tax_summary[$row->tax_code]['amt'] = ($row->quantity * $row->net_unit_price);
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
                                            $resTaxTbl = $this->sma->taxInvvoiceTabel($tax_summary, $taxItems, $inv, $return_sale, $Settings);
                                            echo $resTaxTbl;
                                        endif;
                                        ?>



                                        <p class="text-center">
                                        <?= $this->sma->decode_html($biller->invoice_footer); ?>
                                        </p>
                                        <div style="clear:both;"></div>
                                    </div>

                                    </div>
                                    <div style="clear:both;height:25px;"></div>
                                    <strong><?= $Settings->site_name; ?></strong>
                                    <!-- <p><?= base_url(); ?></p> -->
                                    <div style="clear:both;height:15px;"></div>
                                    <p style="border-top:1px solid #CCC;margin-bottom:0;">This email is sent to <?= $customer->company; ?> (<?= $customer->email; ?>).</p>
                                </td>
                            </tr>
                        </table>
                    </div>

                </td>
                <td></td>
            </tr>
        </table>

    </body>
</html>
