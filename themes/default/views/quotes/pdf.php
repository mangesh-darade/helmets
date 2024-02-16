<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
$itemTaxes = isset($inv->rows_tax)?$inv->rows_tax:array();
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $this->lang->line("purchase") . " " . $inv->reference_no; ?></title>
    <link href="<?php echo $assets ?>styles/style.css" rel="stylesheet">
    <style type="text/css">
        html, body { height: 100%; background: #FFF; }
        body:before, body:after { display: none !important; }
        .table th { text-align: center; padding: 5px; }
        .table td { padding: 4px; }
        table td p{    width: 100px;
     overflow-wrap: break-word;}
    </style>
</head>

<body>
<div id="wrap">
   <div class="text-center" style="margin-bottom:20px;"><strong><?php echo $this->lang->line("QUOTATION"); ?></strong></div>
    <div class="row">
        <div class="col-lg-12">
            <?php if ($logo) { ?>
                <div class="text-center" style="margin-bottom:20px;">
                    <img src="<?= base_url() . 'assets/uploads/logos/' . $biller->logo; ?>"
                         alt="<?= $biller->company ?>">
                </div>
            <?php } ?>
            <div class="clearfix"></div>
            <div class="row padding10">
                <div class="col-xs-5">
                    <strong><?php echo $this->lang->line("from"); ?></strong>
                    <h2 class=""><?= $biller->company != '-' ? $biller->company : $biller->name; ?></h2>
                        <?= $biller->company ? "" : "Attn: " . $biller->name ?>
                    <address>
                        <?= ($biller->address!='')?$biller->address.',<br/>':'' ?>
                        <?= ($biller->city!='')?$biller->city.' - ':''?> <?= ($biller->postal_code!='')?$biller->postal_code.', ':''?>
                        <?= ($biller->state!='')?$biller->state.', ':''?><?= ($biller->country!='')?$biller->country.'.':''?>
                       <?= ($biller->phone!='')?'<br/>'.lang("tel").': '.$biller->phone:'' ?>
                        <?= ($biller->email!='')?'<br/>'.lang("email").': '.$biller->email:'' ?>
                        <?php 
                            if ($biller->gstn_no != "-" && $biller->gstn_no != "" && count($itemTaxes) > 0) {
                                echo "<br>" . lang("gstn_no") . ": " . $biller->gstn_no ;
                            }
                            elseif ($biller->vat_no != "-" && $biller->vat_no != "" && count($itemTaxes) ==0) {
                                echo "<br>" . lang("vat_no") . ": " . $biller->vat_no;
                            }
                            if ($biller->cf1 != "-" && $biller->cf1 != "") {
                                echo "<br>"  .$this->Settings->prd_cmfield1 . ": ". $biller->cf1;
                            }
                            if ($biller->cf2 != "-" && $biller->cf2 != "") {
                                echo "<br>" .$this->Settings->prd_cmfield2 .  ": ". $biller->cf2;
                            }
                            if ($biller->cf3 != "-" && $biller->cf3 != "") {
                                echo "<br>" .$this->Settings->prd_cmfield3 . ": ".  $biller->cf3;
                            }
                            if ($biller->cf4 != "-" && $biller->cf4 != "") {
                                echo "<br>" .$this->Settings->prd_cmfield4 . ": ".  $biller->cf4;
                            }
                            if ($biller->cf5 != "-" && $biller->cf5 != "") {
                                echo "<br>" .$this->Settings->prd_cmfield5 . ": ".  $biller->cf5;
                            }
                            if ($biller->cf6 != "-" && $biller->cf6 != "") {
                                echo "<br>" .$this->Settings->prd_cmfield6 .  ": ".  $biller->cf6;
                            }
                        ?>
                    </address>
                    <div class="clearfix"></div>
                </div>
                <div class="col-xs-5">
                    <strong><?php echo $this->lang->line("Customer Details"); ?></strong>
                    <h2 class=""><?= $customer->company ? $customer->company : $customer->name; ?></h2>
                    <?= $customer->company ? "" : "Attn: " . $customer->name ?>
                    <address>
                        <?= ($customer->address!='')?'Address:'.$customer->address.',<br/>':'' ?>
                        <?= ($customer->city!='')?$customer->city.' - ':''?><?= ($customer->postal_code!='')?$customer->postal_code.', ':''?>
                        <?= ($customer->state!='')?$customer->state.', ':''?><?= ($customer->country!='')?$customer->country.'.<br/> ':''?>
                        <?= ($customer->phone!='')?lang("tel").': '.$customer->phone.'</br>':'' ?> 
                        <?= ($customer->email!='')?lang("email").': '.$customer->email:'' ?>
                        <?php
                            if ($customer->gstn_no != "-" && $customer->gstn_no != "" && count($itemTaxes) > 0) {
                                echo "<br>" . lang("gstn_no") . ": " . $customer->gstn_no ;
                            }
                            elseif ($customer->vat_no != "-" && $customer->vat_no != "" && count($itemTaxes) ==0) {
                                echo "<br>" . lang("vat_no") . ": " . $customer->vat_no;
                            }
                       
                            if ($customer->cf1 != "-" && $customer->cf1 != "") {
                                echo "<br>" .$this->Settings->prd_cmfield1 . ": ". $customer->cf1;
                            }
                            if ($customer->cf2 != "-" && $customer->cf2 != "") {
                                echo "<br>" .$this->Settings->prd_cmfield2 .": ". $customer->cf2;
                            }
                            if ($customer->cf3 != "-" && $customer->cf3 != "") {
                                echo "<br>" .$this->Settings->prd_cmfield3 . ": ".  $customer->cf3;
                            }
                            if ($customer->cf4 != "-" && $customer->cf4 != "") {
                                echo "<br>" .$this->Settings->prd_cmfield4 .  ": ". $customer->cf4;
                            }
                            if ($customer->cf5 != "-" && $customer->cf5 != "") {
                                echo "<br>" .$this->Settings->prd_cmfield5 .  ": ". $customer->cf5;
                            }
                            if ($customer->cf6 != "-" && $customer->cf6 != "") {
                                echo "<br>" .$this->Settings->prd_cmfield6 .  ": ".  $customer->cf6;
                            }
                        ?>
                    </address>
                </div>

            </div>
            <div class="clearfix"></div>
            <div class="row padding10">
                <div class="col-xs-5">
                    <h2 class=""><?= $Settings->site_name; ?></h2>
                    <?= $warehouse->name ?>

                    <?php
                    echo $warehouse->address . "<br>";
                    echo ($warehouse->phone ? lang("tel") . ": " . $warehouse->phone . "<br>" : '') . ($warehouse->email ? lang("email") . ": " . $warehouse->email : '');
                    ?>
                    <div class="clearfix"></div>
                </div>
                <div class="col-xs-5">
                    <div class="bold">
                        <?=lang("date");?>: <?=$this->sma->hrld($inv->date);?><br>
                        <?=lang("ref");?>: <?=$inv->reference_no;?>
                        <div class="clearfix"></div>
                        <div class="order_barcodes">
                           <div style="width:200px;float:left;"><?= $this->sma->save_barcode($inv->reference_no, 'code128', 66, false); ?></div>	
	                   <div style="width:78px;float:left;"><?= $this->sma->qrcode('link', urlencode(site_url('quotes/view/' . $inv->id)), 2); ?></div>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                </div>
            </div>


            <div class="clearfix"></div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped print-table order-table">
                    <thead>
                    <tr>
                        <th><?= lang("no"); ?></th>
                        <th style="width:10%"><?= lang("Product Name"); ?> (<?= lang("code"); ?>)</th>
                        <th><?= lang("MRP"); ?></th>
                        <th><?= lang("Unit_Price"); ?></th>
                        <th><?= lang("quantity"); ?> (Unit)</th>
                        <?php
                            if($Settings->show_quotation_unit_price == 'both'){
                              ?>
                            <th><?= lang("unit_price"); ?></th>
                            <th><?= lang("Net Price"); ?></th>
                            <?php  
                            } else {
                                $show_quotation_unit_price = $Settings->show_quotation_unit_price ? $Settings->show_quotation_unit_price : 'Net Price';
                             ?>
                            <th><?= lang($show_quotation_unit_price); ?></th>
                            <?php    
                            }
                            ?>                        
                        <?php
                       
                        if ($Settings->product_discount) {
                            echo '<th>' . lang("discount") . '</th>';
                        }
                        if ($Settings->tax1 && $inv->product_tax > 0) {
                            echo '<th>' . lang("Product Tax") . '</th>';
                        }
                        ?>
                        <th><?= lang("subtotal"); ?> (INR)</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php $r = 1;
                    foreach ($rows as $row):
                     $offset = 5;
                        /**
                          * Code add 03-09-2019
                          **/
                     	 if(isset($tax_summary[$row->tax_code]))
                            {
                                $tax_summary[$row->tax_code]['items'] += $row->quantity;
                                $tax_summary[$row->tax_code]['tax'] += $row->item_tax;
                                $tax_summary[$row->tax_code]['amt'] += ($row->quantity * $row->net_unit_price);
                            }else
                            {
                                $tax_summary[$row->tax_code]['items'] = $row->quantity;
                                $tax_summary[$row->tax_code]['tax'] = $row->item_tax;
                                $tax_summary[$row->tax_code]['amt'] = ($row->quantity * $row->net_unit_price);
                                $tax_summary[$row->tax_code]['name'] = $row->tax_name;
                                $tax_summary[$row->tax_code]['code'] = $row->tax_code;
                                $tax_summary[$row->tax_code]['rate'] = $row->tax_rate;
                                $tax_summary[$row->tax_code]['tax_rate_id'] = $row->tax_rate_id;
                            }
                        /**
                       	 * End Code add 03-09-2019
                         **/    
                        /**
                         * Comment Date 03-09-2019 form Chetan 
                         * Error : Taxt Summery in Tax Excl Amt not correct 
                         * Problem : Item discount diduction on two time  
                         ***/ 
                        /*
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
                                $tax_summary[$row->tax_code]['tax_rate_id'] =  $row->tax_rate_id;
                            }
                          */ 
                          /**
                           * End  Comments
                           *
                           **/ 
                        ?>
                        <tr>
                           
                            <td style="text-align:center; width:40px; vertical-align:middle;"><?= $r; ?></td>
                            <td style="vertical-align:middle;">
                                <?php if($Settings->quotation_image == '1') { ?>
                                <img src="assets/uploads/thumbs/<?=$row->image?>" style="width:30px; height:30px;" alt="<?=$row->product_code?>" />
                                <?php } ?>
                                <?= $row->product_name .' ('.$row->product_code.')'. ($row->variant ? ' (' . $row->variant . ')' : ''); ?>
                                <?= $row->details ? '<br>' . $row->details : ''; ?></td>
                            <td  style="text-align:right; width:100px;"><?= $this->sma->formatMoney($row->mrp); ?> </td>
                            <td style="text-align:right; width:100px;"><?= $this->sma->formatMoney($row->real_unit_price); ?></td>
                            <td style="width: 80px; text-align:center; vertical-align:middle;"><?= $this->sma->formatQuantity($row->unit_quantity).' '.$row->product_unit_code; ?></td>
                           
                            <?php
                            // $total_netcost += ($row->net_unit_price*$row->unit_quantity+$row->item_discount);
$total_netcost += ($row->real_unit_price*$row->unit_quantity);
                            $addcol = 0;
                            if($Settings->show_quotation_unit_price == 'both'){
                                    $addcol = 1;
                                  ?>
                                <td style="text-align:right; width:100px;"><?= $this->sma->formatMoney($row->unit_price); ?></td>
                                <td style="text-align:right; width:100px;"><?= $this->sma->formatMoney($row->real_unit_price*$row->unit_quantity); ?></td>
                                <?php  
                                } else {                                   
                                 ?>
                                <td style="text-align:right; width:100px;"><?= $this->sma->formatMoney($row->real_unit_price *$row->unit_quantity); ?></td>                                
                            <?php   
                            }
                            ?>
                            
                            <?php
                            
                            if ($Settings->product_discount) {
                                echo '<td style="width: 100px; text-align:right; vertical-align:middle;">' . ($row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '') . $this->sma->formatMoney($row->item_discount) . '</td>';
                                $offset++;;
                            }
                            if ($Settings->tax1 && $inv->product_tax > 0) {
                                echo '<td style="width: 100px; text-align:right; vertical-align:middle;">' . ($row->item_tax != 0 && $row->tax_code ? '<small>(' . $row->tax_code . ')</small> ' : '') . $this->sma->formatMoney($row->item_tax) . '</td>';
                                $offset++;;
                            }
                            ?>
                            <td style="text-align:right; width:120px;"><?= $this->sma->formatMoney($row->subtotal); ?></td>
                        </tr>
                         <?php echo $this->sma->taxAttrTblDiv($itemTaxes,$row->id,$offset+$addcol);?>
                        <?php
                        $r++;
                    endforeach;
                    ?>
                    </tbody>
                    <tfoot>
                    <?php
                    $col = 5 + $addcol;
                    if ($Settings->product_discount) {
                        $col++;
                    }
                    if ($Settings->tax1 && $inv->product_tax > 0) {
                        $col++;
                    }
                    if ($Settings->product_discount && $Settings->tax1 && $inv->product_tax > 0) {
                        $tcol = $col - 2;
                    } elseif ($Settings->product_discount) {
                        $tcol = $col - 1;
                    } elseif ($Settings->tax1 && $inv->product_tax > 0) {
                        $tcol = $col - 1;
                    } else {
                        $tcol = $col;
                    }
                    ?>
                    <tr>
                        <td colspan="<?= $tcol; ?>" style="text-align:right;"><?= lang("total"); ?>
                            (<?= $default_currency->code; ?>)
                        </td>
                        <td style="text-align:right;"><?php echo $this->sma->formatMoney($total_netcost)?></td>
                        <?php
if ($Settings->product_discount) {
                            echo '<td style="text-align:right;">' . $this->sma->formatMoney($inv->product_discount) . '</td>';
                        }
                        if ($Settings->tax1 && $inv->product_tax > 0) {
                            echo '<td style="text-align:right;">' . $this->sma->formatMoney($inv->product_tax) . '</td>';
                        }
                        
                        ?>
                        <td style="text-align:right;"><?= $this->sma->formatMoney($inv->total + $inv->product_tax); ?></td>
                    </tr>
                    <?php
                    if ($inv->order_discount != 0) {
                        echo '<tr><td colspan="' . $col . '" style="text-align:right;">' . lang("order_discount") . ' (' . $default_currency->code . ')</td><td style="text-align:right;">'.($inv->order_discount_id ? '<small>('.$inv->order_discount_id.')</small> ' : '') . $this->sma->formatMoney($inv->order_discount) . '</td></tr>';
                    }
                    if ($Settings->tax2 && $inv->order_tax != 0) {
                        echo '<tr><td colspan="' . $col . '" style="text-align:right;">' . lang("order_tax") . ' (' . $default_currency->code . ')</td><td style="text-align:right;">' . $this->sma->formatMoney($inv->order_tax) . '</td></tr>';
                    }
                    if ($inv->shipping != 0) {
                        echo '<tr><td colspan="' . $col . '" style="text-align:right;">' . lang("shipping") . ' (' . $default_currency->code . ')</td><td style="text-align:right;">' . $this->sma->formatMoney($inv->shipping) . '</td></tr>';
                    }
                    ?>
                    <tr>
                        <td colspan="<?= $col + 1; ?>"
                            style="text-align:right; font-weight:bold;"><?= lang("total_amount"); ?>
                            (<?= $default_currency->code; ?>)
                        </td>
                        <td style="text-align:right; font-weight:bold;"><?= $this->sma->formatMoney($inv->grand_total); ?></td>
                    </tr>

                    </tfoot>
                </table>
            </div>
		<div class="row">
                	<div class="col-xs-12"><?php
                        if ($Settings->invoice_view == 1) {
                            $resTaxTbl = $this->sma->quoteTaxInvvoiceTabel($tax_summary,$taxItems,$inv,$return_sale,$Settings,1);
            	     	    echo  $resTaxTbl;
                        } ?>
                        </div>
                </div>
            <div class="row">
                <div class="col-xs-12">
                    <?php if ($inv->note || $inv->note != "") { ?>
                        <div class="well well-sm">
                            <p class="bold"><?= lang("note"); ?>:</p>

                            <div><?= $this->sma->decode_html($inv->note); ?></div>
                        </div>
                    <?php } ?>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-4  pull-left">
                    <p><?= lang("seller"); ?>: <?= $biller->company != '-' ? $biller->company : $biller->name; ?> </p>

                    <p>&nbsp;</p>

                    <p>&nbsp;</p>
                    <hr>
                    <p><?= lang("stamp_sign"); ?></p>
                </div>
                <div class="col-xs-4  pull-right">
                    <p><?= lang("customer"); ?>: <?= $customer->company ? $customer->company : $customer->name; ?> </p>

                    <p>&nbsp;</p>

                    <p>&nbsp;</p>
                    <hr>
                    <p><?= lang("stamp_sign"); ?></p>
                </div>
            </div>

        </div>
    </div>
</div>
</body>
</html>