<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
 $itemTaxes = isset($inv->rows_tax)?$inv->rows_tax:array();
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
        
        li.attr_table_li {
   
}

ul.attr_table_ul {
    display: table-row;
}
    </style>
</head>

<body>
<div id="wrap">
    <div class="row">
        <div class="col-lg-12">
            
            <?php if ($logo) { ?>
                <div class="text-center" style="margin-bottom:20px;">
                    <img src="<?= base_url('assets/uploads/logos/' . $biller->logo); ?>" alt="<?= $biller->company != '-' ? $biller->company : $biller->name; ?>">
                    <div class="bold"><?= lang("Invoice Number");?> : <?= lang($inv->id ); ?></div>
                </div>
                
            <?php }
            ?>
            <div class="clearfix"></div>
            <div class="well well-sm">
                <div class="col-xs-3 border-right">
                     <div class="col-xs-2"><i class="fa fa-3x fa-building padding010 text-muted"></i></div>
                        <div class="col-xs-10">
                            <strong><?php  echo $this->lang->line("from"); ?>,</strong>                                
                            <h2 class=""><?= $biller->company != '-' ? $biller->company : $biller->name; ?></h2>
                            <?= $biller->company ? '' : 'Attn: ' . $biller->name; ?>
                            <address>
                        <?= ($biller->address!='')?'Address: '.$biller->address.', <br/>':'' ?>
                        <?= ($biller->city!='')?$biller->city.' - ':''?> <?= ($biller->postal_code!='')?$biller->postal_code.',':'' ?>
                        <?= ($biller->state!='')? $biller->state.', ':''?>  <?= ($biller->country!='')? $biller->country.'. <br/> ':''?>
                        <?= ($biller->phone!='')?lang("tel").': '.$biller->phone.'<br/> ':'' ?>
                        <?= ($biller->email!='')?lang("email").': '.$biller->email:'' ?>
                        <?php if ($biller->gstn_no != "-" && $biller->gstn_no != "" && count($itemTaxes) > 0) {
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
                        </div>
                        <div class="clearfix"></div>
                    </div>
              
                <div class="col-xs-4 border-right">
                     <div class="col-xs-12">
                        <strong><?php echo $this->lang->line("Customer Details"); ?></strong><br/>
                        <h2 class=""><?= $customer->company ? $customer->company : $customer->name; ?></h2>
                        <?= $customer->company ? '' : 'Attn: ' . $customer->name; ?>
                        <address>
                        <?= ($customer->address!='')?'Address:'.$customer->address.',<br/>':'' ?>
                        <?= ($customer->city!='')?$customer->city.' - ':''?><?= ($customer->postal_code!='')?$customer->postal_code.', ':''?>
                        <?= ($customer->state!='')?$customer->state.', ':''?><?= ($customer->country!='')?$customer->country.'.<br/> ':''?>
                        <?= ($customer->phone!='')?lang("tel").': '.$customer->phone.'</br>':'' ?> 
                        <?= ($customer->email!='')?'<br/>'.lang("email").': '.$customer->email:'' ?>
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
                    <div class="clearfix"></div>
                </div>
			
                <div class="col-xs-3">
                    <div class="col-xs-12">
                        <span class="bold"><?= $Settings->site_name; ?></span><br>
                        <?= ($warehouse->name!='')?$warehouse->name:'' ?>
                        <address>
                            <?= ($warehouse->address!='')?$warehouse->address:''?>
                            <?= ($warehouse->phone!='')?''.lang('tel').': '.$warehouse->phone:'' ?>
                            <?= ($warehouse->email!='')?'<br/>'.lang('email').': '.$warehouse->email:'' ?>
                        </address>
                        <div class="clearfix"></div>
                    </div>
		</div>
				
                
            </div>
			
                <div class="clearfix"></div>
 <div class="col-xs-5">
                  <div class="col-xs-10">
					<?= lang("Invoice Number");?> : <?= lang($inv->id ); ?><br>
                        <?= lang('date'); ?>: <?= $this->sma->hrld($inv->date); ?><br>
                        <?= lang('ref'); ?>: <?= $inv->reference_no; ?><br>
                        <?php if (!empty($inv->return_sale_ref)) {
                            echo lang("return_ref").': '.$inv->return_sale_ref.'<br>';
                        } ?>
                        <div class="clearfix"></div>
                        
                    </div>
                    <div class="clearfix"></div>
                </div>
            <div class="clearfix"></div>
            <?php
             
                $col = ($Settings->pos_type=='pharma') ? 8 : 6;
                if ( $Settings->product_discount && $inv->product_discount != 0) {
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
            
          
			 <div class="col-xs-12">&nbsp;</div>
            <div class="table-responsive">
                <table class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th><?= lang('no'); ?></th>
                        <th><?= lang('Product Name'); ?> (<?= lang('code'); ?>)</th>
                        <th><?= lang('Hsn_code'); ?></th>
                        <th><?= lang('Serial No.'); ?></th>
                       
                        <?php if($Settings->pos_type=='pharma'):?>
                         <th><?= lang("Exp. Date"); ?></th>
                         <th><?= lang("Batch No."); ?></th>
                        <?php endif;?>
                        <!--<th><?= lang('mrp'); ?></th>-->
                        <th><?= lang('unit_price'); ?></th>

                        <th><?= lang('quantity'); ?> (Unit)</th>
                         <th><?= lang('Net Price'); ?></th>
                        <?php
                           if ( $Settings->product_discount && $inv->product_discount != 0) {
                                echo '<th>' . lang('discount') . '</th>';
                            }
                            if ($Settings->tax1 && $inv->product_tax > 0) {
                                echo '<th>' . lang('tax') . '</th>';
                            }
                            
                        ?>
                        <th><?= lang('subtotal'); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    
                    <?php 
//                      print_r($rows);exit;
                    $r = 1;
                        foreach ($rows as $row):
                            $VariantPrice = 0;
			    if($row->option_id!=0)
				$VariantPrice = $row->variant_price;
                            if (isset($tax_summary[$row->tax_code])) {
                                $tax_summary[$row->tax_code]['items'] += $row->quantity;
                                $tax_summary[$row->tax_code]['tax'] += $row->item_tax;
                              //  $tax_summary[$row->tax_code]['amt'] += ($row->quantity * $row->net_unit_price) - $row->item_discount;
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
                            <tr>
                                <td style="text-align:center; width:40px; vertical-align:middle;"><?= $r; ?></td>
                                <td style="vertical-align:middle;">
                                    <?php if($Settings->sales_image == '1') { ?>
                                    <img src="assets/uploads/thumbs/<?=$row->image?>" style="width:30px; height:30px;" alt="<?=$row->product_code?>" />
                                    <?php } ?>
                                    <?= $row->product_code.' - '.$row->product_name . ($row->variant ? ' (' . $row->variant . ')' : ''); ?>
                                    <?= $row->details ? '<br>' . $row->details : ''; ?>
                                    <?= $row->serial_no ? '<br>' . $row->serial_no : ''; ?>
                                </td>
                                <td style="vertical-align:middle;"><?= $row->hsncode?></td>
                                <td style="vertical-align:middle;"><?= $row->serial_no?></td>
                                <?php if($Settings->pos_type=='pharma'):?>
		                         <td style="vertical-align:middle;"><?= $row->cf1?></td>
                          		  <td style="vertical-align:middle;"><?= $row->cf2?></td>
		                  <?php endif;?>
                                <!--<td style="text-align:right; width:100px;"><?= $this->sma->formatMoney($row->mrp); ?></td>-->
                                <td style="text-align:right; width:90px;"><?= $this->sma->formatMoney($row->real_unit_price+$VariantPrice); ?></td>

                                <td style="width: 80px; text-align:center; vertical-align:middle;"><?= $this->sma->formatQuantity($row->unit_quantity).' '.$row->product_unit_code; ?></td>
                                <td style="text-align:right; width:90px;"><?= $this->sma->formatMoney($row->unit_quantity*($row->real_unit_price+$VariantPrice)); ?></td>
                                <?php
                                   if ( $Settings->product_discount && $inv->product_discount != 0) {
                                        echo '<td style="width: 90px; text-align:right; vertical-align:middle;">' . ($row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '') . $this->sma->formatMoney($row->item_discount) . '</td>';
                                    }
                                    if ($Settings->tax1 && $inv->product_tax > 0) {
                                        echo '<td style="width: 90px; text-align:right; vertical-align:middle;">' . ($row->item_tax != 0 && $row->tax_code ? '<small>(' . $row->tax_code . ')</small> ' : '') . $this->sma->formatMoney($row->item_tax) . '</td>';
                                    }
                                    
                                ?>
                                <td style="vertical-align:middle; text-align:right; width:110px;"><?= $this->sma->formatMoney($row->subtotal); ?></td>
                            </tr>
                            <?php echo $this->sma->taxAttrTblDiv($itemTaxes,$row->id,($col));?>
                            <?php
                            $r++;
                        endforeach;
                        if ($return_rows) {
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
                            echo '<tr class="warning"><td colspan="'.($col+1).'" class="no-border"><strong>'.lang('returned_items').'</strong></td></tr>';
                            foreach ($return_rows as $row):
                            ?>
                                <tr class="warning">
                                    <td style="text-align:center; width:40px; vertical-align:middle;"><?= $r; ?></td>
                                    <td style="vertical-align:middle;">
                                        <?= $row->product_code.' - '.$row->product_name . ($row->variant ? ' (' . $row->variant . ')' : ''); ?>
                                        <?= $row->details ? '<br>' . $row->details : ''; ?>
                                        <?= $row->serial_no ? '<br>' . $row->serial_no : ''; ?>
                                    </td>
                                    <?php if($Settings->pos_type=='pharma'):?>
		                         <td style="vertical-align:middle;"><?= $row->cf1?></td>
                          		  <td style="vertical-align:middle;"><?= $row->cf2?></td>
		                  <?php endif;?>
                                    <!--<td style="text-align:right; width:100px;"><?= $this->sma->formatMoney($row->mrp); ?></td>-->
                                    <td style="text-align:right; width:100px;"><?= $this->sma->formatMoney($row->unit_price); ?></td>    
                                    <td style="width: 80px; text-align:center; vertical-align:middle;"><?= $this->sma->formatQuantity($row->quantity).' '.$row->product_unit_code; ?></td>
                                    <td style="text-align:right; width:90px;"><?= $this->sma->formatMoney($row->unit_quantity*$row->unit_price); ?></td>

                                    <?php
                                    if ($Settings->product_discount && $inv->product_discount != 0) {
                                        echo '<td style="text-align:right; vertical-align:middle;">' . ($row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '') . $this->sma->formatMoney($row->item_discount) . '</td>';
                                    }
                                    if ($Settings->tax1 && $inv->product_tax > 0) {
                                        echo '<td style="text-align:right; vertical-align:middle;">' . ($row->item_tax != 0 && $row->tax_code ? '<small>('.$row->tax_code.')</small>' : '') . ' ' . $this->sma->formatMoney($row->item_tax) . '</td>';
                                    }
                                    
                                    ?>
                                    <td style="text-align:right; width:120px;"><?= $this->sma->formatMoney($row->subtotal); ?></td>
                                </tr>
                                <?php echo $this->sma->taxAttrTblDiv($itemTaxes,$row->id,($col));?>
                                <?php
                                $r++;
                            endforeach;
                           
                        }
//                         exit;
                    ?>
                    </tbody>
                    <tfoot>
                    
                    <?php if ($inv->grand_total != $inv->total) {
                        ?>
                        <tr>
                            <td colspan="<?= $tcol+1; ?>" style="text-align:right;"><?= lang('total'); ?>
                                (<?= $default_currency->code; ?>)
                            </td>
                            <?php
                            if ( $Settings->product_discount && $inv->product_discount != 0) {
                                    echo '<td style="text-align:right;">' . $this->sma->formatMoney($return_sale ? ($inv->product_discount+$return_sale->product_discount) : $inv->product_discount) . '</td>';
                                }
                                if ($Settings->tax1 && $inv->product_tax > 0) {
                                    echo '<td style="text-align:right;">' . $this->sma->formatMoney($return_sale ? ($inv->product_tax+$return_sale->product_tax) : $inv->product_tax) . '</td>';
                                }
                                
                            ?>
                            <td style="text-align:right;"><?= $this->sma->formatMoney($return_sale ? (($inv->total + $inv->product_tax)+($return_sale->total + $return_sale->product_tax)) : ($inv->total + $inv->product_tax)); ?></td>
                        </tr>
                    <?php }
                    ?>
                    <?php
                    if ($return_sale) {
                        echo '<tr><td colspan="' . $col . '" style="text-align:right;">' . lang("return_total") . ' (' . $default_currency->code . ')</td><td style="text-align:right;">' . $this->sma->formatMoney($return_sale->grand_total) . '</td></tr>';
                    }
                    if ($inv->surcharge != 0) {
                        echo '<tr><td colspan="' . $col . '" style="text-align:right;">' . lang("return_surcharge") . ' (' . $default_currency->code . ')</td><td style="text-align:right;">' . $this->sma->formatMoney($inv->surcharge) . '</td></tr>';
                    }
                    ?>
                    <?php if ($inv->order_discount != 0) {
                        echo '<tr><td colspan="' . $col . '" style="text-align:right;">' . lang('order_discount') . ' (' . $default_currency->code . ')</td><td style="text-align:right;">'.($inv->order_discount_id ? '<small>('.$inv->order_discount_id.')</small> ' : '') . $this->sma->formatMoney($return_sale ? ($inv->order_discount+$return_sale->order_discount) : $inv->order_discount) . '</td></tr>';
                    }
                    ?>
                    <?php if ($Settings->tax2 && $inv->order_tax != 0) {
                        echo '<tr><td colspan="' . $col . '" style="text-align:right;">' . lang('order_tax') . ' (' . $default_currency->code . ')</td><td style="text-align:right;">' . $this->sma->formatMoney($return_sale ? ($inv->order_tax+$return_sale->order_tax) : $inv->order_tax) . '</td></tr>';
                    }
                    ?>
                    <?php if ($inv->shipping != 0) {
                        echo '<tr><td colspan="' . $col . '" style="text-align:right;">' . lang('shipping') . ' (' . $default_currency->code . ')</td><td style="text-align:right;">' . $this->sma->formatMoney($inv->shipping) . '</td></tr>';
                    }
                    ?>
                    <tr>
                        <td colspan="<?= $col+1; ?>"
                            style="text-align:right; font-weight:bold;"><?= lang('total_amount'); ?>
                            (<?= $default_currency->code; ?>)
                        </td>
                        <td style="text-align:right; font-weight:bold;"><?= $this->sma->formatMoney($return_sale ? ($inv->grand_total+$return_sale->grand_total) : $inv->grand_total); ?></td>
                    </tr>

                    <tr>
                        <td colspan="<?= $col+1; ?>" style="text-align:right; font-weight:bold;"><?= lang('paid'); ?>
                            (<?= $default_currency->code; ?>)
                        </td>
                        <td style="text-align:right; font-weight:bold;"><?= $this->sma->formatMoney($return_sale ? ($inv->paid+$return_sale->paid) : $inv->paid); ?></td>
                    </tr>
                    <tr>
                        <td colspan="<?= $col+1; ?>" style="text-align:right; font-weight:bold;"><?= lang('balance'); ?>
                            (<?= $default_currency->code; ?>)
                        </td>
                        <td style="text-align:right; font-weight:bold;">
                        <?php
                         $balance = ($return_sale ? ($inv->grand_total+$return_sale->grand_total) : $inv->grand_total) - ($return_sale ? ($inv->paid+$return_sale->paid) : $inv->paid);
                         echo $this->sma->formatMoney(($balance < 1)?0:$balance);
                          ?>
                        </td>
                    </tr>

                    </tfoot>
                </table>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <?php
                        if ($Settings->invoice_view == 1) {
                            $resTaxTbl = $this->sma->taxInvvoiceTabel($tax_summary,$taxItems,$inv,$return_sale,$Settings,1);
            	     	    echo  $resTaxTbl;
                        }
                    ?>
                </div>
                <div class="col-xs-12">
                    <?php if ($inv->note || $inv->note != '') { ?>
                        <div class="well well-sm">
                            <p class="bold"><?= lang('note'); ?>:</p>

                            <div><?= $this->sma->decode_html($inv->note); ?></div>
                        </div>
                    <?php }
                    ?>
                </div>
                <div class="clearfix"></div>
                <div class="col-xs-4  pull-left">
                    <p style="height: 80px;"><?= lang('seller'); ?>
                        : <?= $biller->company != '-' ? $biller->company : $biller->name; ?> </p>
                    <hr>
                    <p><?= lang('stamp_sign'); ?></p>
                </div>
                <div class="col-xs-4  pull-right">
                    <p style="height: 80px;"><?= lang('customer'); ?>
                        : <?= $customer->company ? $customer->company : $customer->name; ?> </p>
                    <hr>
                    <p><?= lang('stamp_sign'); ?></p>
                </div>
                <div class="clearfix"></div>
                <?php if ($customer->award_points != 0 && $Settings->each_spent > 0) { ?>
                <div class="col-xs-4 pull-right">
                    <div class="well well-sm">
                        <?=
                        '<p>'.lang('this_sale').': '.floor(($inv->grand_total/$Settings->each_spent)*$Settings->ca_point)
                        .'<br>'.
                        lang('total').' '.lang('award_points').': '. $customer->award_points . '</p>';?>
                    </div>
                </div>
                <?php } ?>
            </div>
			<div class="col-xs-12">
				<div class="col-xs-6 col-xs-offset-5" >
					<div class="order_barcodes" style="text-align:right;">
						<?= $this->sma->save_barcode($inv->reference_no, 'code128', 66, false); ?>&nbsp;&nbsp;
						<?= $this->sma->qrcode('link', urlencode(site_url('sales/view/' . $inv->id)), 2); ?>
					</div>
				</div>
				
			</div>
        </div>
    </div>
</div>
</body>
</html>