<?php defined('BASEPATH') OR exit('No direct script access allowed');
$itemTaxes = isset($inv->rows_tax) ? $inv->rows_tax : array(); ?>
  
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-file"></i><?= lang("quote_no") . '. ' . $inv->id; ?></h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-tasks tip"
                                                                                  data-placement="left"
                                                                                  title="<?= lang("actions") ?>"></i></a>
                    <ul class="dropdown-menu pull-right tasks-menus" role="menu" aria-labelledby="dLabel">
                        <?php if($inv->attachment){ ?>
                            <li>
                                <a href="<?= site_url('welcome/download/' . $inv->attachment) ?>">
                                    <i class="fa fa-chain"></i> <?= lang('attachment') ?>
                                </a>
                            </li>
                        <?php } ?>
                        <li>
                            <a href="<?= site_url('quotes/edit/' . $inv->id) ?>">
                                <i class="fa fa-edit"></i> <?= lang('edit_quote') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('sales/add/' . $inv->id) ?>">
                                <i class="fa fa-plus-circle"></i> <?= lang('create_invoice') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('quotes/email/' . $inv->id) ?>" data-target="#myModal"
                               data-toggle="modal">
                                <i class="fa fa-envelope-o"></i> <?= lang('send_email') ?>
                            </a>
                        </li>
                        <li>
                            <a href="<?= site_url('quotes/pdf/' . $inv->id) ?>">
                                <i class="fa fa-file-pdf-o"></i> <?= lang('export_to_pdf') ?>
                            </a>
                        </li>
                        <!--<li><a href="<?= site_url('quotes/excel/' . $inv->id) ?>"><i class="fa fa-file-excel-o"></i> <?= lang('export_to_excel') ?></a></li>-->
                    </ul>
                </li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <div class="print-only col-xs-12">
                    <img src="<?= base_url() . 'assets/uploads/logos/' . $biller->logo; ?>"
                         alt="<?= $biller->company != '-' ? $biller->company : $biller->name; ?>">
                </div>
                <div class="well well-sm">
                    <div class="col-xs-4 border-right">

                        <div class="col-xs-2"><i class="fa fa-3x fa-building padding010 text-muted"></i></div>
                        <div class="col-xs-10">
                            <h2 class=""><?= $biller->company != '-' ? $biller->company : $biller->name; ?></h2>
                            <h3 class=""><?= $biller->name != '-' ? $biller->name : $biller->name; ?></h3>
                            <?= $biller->company ? "" : "Attn: " . $biller->name ?>
                            <?php
                            echo $biller->address . "<br>" . $biller->city . " " . $biller->postal_code . " " . $biller->state . "<br>" . $biller->country;
                            echo "<p>";
                            if($biller->gstn_no != "-" && $biller->gstn_no != "" && count($itemTaxes) > 0)
                            {
                                echo "<br>" . lang("gstn_no") . ": " . $biller->gstn_no;
                            }elseif($biller->vat_no != "-" && $biller->vat_no != "" && count($itemTaxes) == 0)
                            {
                                echo "<br>" . lang("vat_no") . ": " . $biller->vat_no;
                            }
                            if($biller->cf1 != "-" && $biller->cf1 != "")
                            {
                                echo "<br>" . $biller->cf1;
                            }
                            if($biller->cf2 != "-" && $biller->cf2 != "")
                            {
                                echo "<br>" . $biller->cf2;
                            }
                            if($biller->cf3 != "-" && $biller->cf3 != "")
                            {
                                echo "<br>" . $biller->cf3;
                            }
                            if($biller->cf4 != "-" && $biller->cf4 != "")
                            {
                                echo "<br>" . $biller->cf4;
                            }
                            if($biller->cf5 != "-" && $biller->cf5 != "")
                            {
                                echo "<br>" . $biller->cf5;
                            }
                            if($biller->cf6 != "-" && $biller->cf6 != "")
                            {
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
                            if($customer->gstn_no != "-" && $customer->gstn_no != "" && count($itemTaxes) > 0)
                            {
                                echo "<br>" . lang("gstn_no") . ": " . $customer->gstn_no;
                            }elseif($customer->vat_no != "-" && $customer->vat_no != "" && count($itemTaxes) == 0)
                            {
                                echo "<br>" . lang("vat_no") . ": " . $customer->vat_no;
                            }
                            if($customer->cf1 != "-" && $customer->cf1 != "")
                            {
                                echo "<br>" . $customer->cf1;
                            }
                            if($customer->cf2 != "-" && $customer->cf2 != "")
                            {
                                echo "<br>" . $customer->cf2;
                            }
                            if($customer->cf3 != "-" && $customer->cf3 != "")
                            {
                                echo "<br>" . $customer->cf3;
                            }
                            if($customer->cf4 != "-" && $customer->cf4 != "")
                            {
                                echo "<br>" . $customer->cf4;
                            }
                            if($customer->cf5 != "-" && $customer->cf5 != "")
                            {
                                echo "<br>" . $customer->cf5;
                            }
                            if($customer->cf6 != "-" && $customer->cf6 != "")
                            {
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
                <div class="col-xs-8 pull-right">
                    <div class="col-xs-12 text-right order_barcodes">
                        <?= $this->sma->save_barcode($inv->reference_no, 'code128', 66, FALSE); ?>
                        <?= $this->sma->qrcode('link', urlencode(site_url('quotes/view/' . $inv->id)), 2); ?>
                    </div>
                    <div class="clearfix"></div>
                </div>

                <div class="col-xs-4">
                    <div class="col-xs-2"><i class="fa fa-3x fa-file-text-o padding010 text-muted"></i></div>
                    <div class="col-xs-10">
                        <h2 class=""><?= lang("ref"); ?>: <?= $inv->reference_no; ?></h2>

                        <p style="font-weight:bold;"><?= lang("date"); ?>
                            : <?= $this->sma->hrld($inv->date); ?></p>

                        <p style="font-weight:bold;"><?= lang("status"); ?>: <?= $inv->status; ?></p>

                        <p>&nbsp;</p>
                    </div>
                    <div class="clearfix"></div>
                </div>
                <div class="clearfix"></div>

                <div class="table-responsive">
                   
                    <table class="table table-bordered table-hover table-striped print-table order-table">
                        <thead>
                        <tr>
                            <th><?= lang("no"); ?></th>
                            <th><?= lang("description"); ?> (<?= lang("code"); ?>)</th>
                            <th style="padding-right:20px;"><?= lang("mrp"); ?></th>
                            <th style="padding-right:20px;"><?= lang("Unit Cost"); ?></th>
                            <th><?= lang("quantity"); ?></th>
                            
                            <?php
                            if($Settings->show_quotation_unit_price == 'both'){
                              ?>
                            <th style="padding-right:20px;"><?= lang("unit_price"); ?></th>
                            <th style="padding-right:20px;"><?= lang("net_unit_price"); ?></th>
                            <?php  
                            } else {
                               $show_quotation_unit_price = $Settings->show_quotation_unit_price ? $Settings->show_quotation_unit_price : 'Net Unit Price';
                             ?>
                            <th style="padding-right:20px;"><?= lang($show_quotation_unit_price); ?></th>
                            <?php   
                            }
                            ?>
                            
                            <?php
                             if($Settings->product_discount && $inv->product_discount != 0)
                            {
                                echo '<th style="padding-right:20px; text-align:center; vertical-align:middle;">' . lang("discount") . '</th>';
                            }
                            if($Settings->tax1 && $inv->product_tax > 0)
                            {
                                echo '<th style="padding-right:20px; text-align:center; vertical-align:middle;">' . lang("tax") . '</th>';
                            }
                           
                            ?>
                            <th style="padding-right:20px;"><?= lang("subtotal"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php $r = 1;
                       
                        foreach($rows as $row):
                           
                            $offset = 6;
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
                            /*if(isset($tax_summary[$row->tax_code]))
                            {
                                $tax_summary[$row->tax_code]['items'] += $row->quantity;
                                $tax_summary[$row->tax_code]['tax'] += $row->item_tax;
                                $tax_summary[$row->tax_code]['amt'] += ($row->quantity * $row->net_unit_price);
                            }
                            else
                            {
                                $tax_summary[$row->tax_code]['items'] = $row->quantity;
                                $tax_summary[$row->tax_code]['tax'] = $row->item_tax;
                                $tax_summary[$row->tax_code]['amt'] = ($row->quantity * $row->net_unit_price);
                                $tax_summary[$row->tax_code]['name'] = $row->tax_name;
                                $tax_summary[$row->tax_code]['code'] = $row->tax_code;
                                $tax_summary[$row->tax_code]['rate'] = $row->tax_rate;
                                $tax_summary[$row->tax_code]['tax_rate_id'] = $row->tax_rate_id;
                            }*/
                            ?>
                            <tr>
                                <td style="text-align:center; width:40px; vertical-align:middle;"><?= $r; ?></td>
                                <td style="vertical-align:middle;">
                                <?php if($Settings->quotation_image == '1') { ?>
                                <img src="assets/uploads/thumbs/<?=$row->image?>" style="width:30px; height:30px;" alt="<?=$row->product_code?>" />
                                <?php } ?>
                                <?= $row->product_code . ' - ' . $row->product_name . ($row->variant ? ' (' . $row->variant . ')' : ''); ?>
                                <?= $row->details ? '<br>' . $row->details : ''; ?></td>
                               <td style="text-align:right; width:100px;"><?= $this->sma->formatMoney($row->mrp); ?></td>
                                <td style="text-align:right; width:100px;"><?= $this->sma->formatMoney($row->real_unit_price ); //$row->net_unit_price + $row->discount ?> </td>

                                <td style="width: 120px; text-align:center; vertical-align:middle;"><?= $this->sma->formatQuantity($row->unit_quantity) . ' ' . $row->product_unit_code; ?></td>
                               
                                <?php
                                $addcol = 0;
                                if($Settings->show_quotation_unit_price == 'both'){
                                    $addcol = 1;
                                  ?>
                                <td style="text-align:right; width:100px; padding-right:10px;"><?= $this->sma->formatMoney($row->unit_price); ?></td>
                                <td style="text-align:right; width:100px; padding-right:10px;"><?= $this->sma->formatMoney($row->net_unit_price); ?></td>
                                <?php  
                                } else {                                  
                                 ?>
                                <td style="text-align:right; width:100px;"><?= $this->sma->formatMoney($row->real_unit_price *$row->unit_quantity); ?></td>

                                
                                <?php   
                                }
                                ?>
                                
                                <?php
                                 if($Settings->product_discount && $inv->product_discount != 0)
                                {
                                    echo '<td style="width: 120px; text-align:right; vertical-align:middle;">' . ($row->discount != 0 ? '<small>(' . $row->discount . ')</small> ' : '') . $this->sma->formatMoney($row->item_discount) . '</td>';
                                    $offset++;;
                                }
                                if($Settings->tax1 && $inv->product_tax > 0)
                                {
                                    echo '<td style="width: 120px; text-align:right; vertical-align:middle;">' . ($row->item_tax != 0 && $row->tax_code ? '<small>(' . $row->tax_code . ')</small> ' : '') . $this->sma->formatMoney($row->item_tax) . '</td>';
                                    $offset++;;
                                }
                               
                                ?>
                                <td style="text-align:right; width:120px; padding-right:10px;"><?= $this->sma->formatMoney($row->subtotal); ?></td>
                            </tr>
                            <?php echo $this->sma->taxAttrTBL($itemTaxes, $row->id, $offset + $addcol); ?>
                            <?php
                            $r++;
                        endforeach;
                        ?>
                        </tbody>
                        <tfoot>
                        <?php
                        $col = 6 + $addcol;
                        if($Settings->product_discount && $inv->product_discount != 0)
                        {
                            $col++;
                        }
                        if($Settings->tax1 && $inv->product_tax > 0)
                        {
                            $col++;
                        }
                        if($Settings->product_discount && $inv->product_discount != 0 && $Settings->tax1 && $inv->product_tax > 0)
                        {
                            $tcol = $col - 2;
                        }elseif($Settings->product_discount && $inv->product_discount != 0)
                        {
                            $tcol = $col - 1;
                        }elseif($Settings->tax1 && $inv->product_tax > 0)
                        {
                            $tcol = $col - 1;
                        }else
                        {
                            $tcol = $col;
                        }
                        ?>
                        <tr>
                            <td colspan="<?= $tcol; ?>"
                                style="text-align:right; padding-right:10px;"><?= lang("total1"); ?>
                                (<?= $default_currency->code; ?>)
                            </td>
                            <?php
                            if($Settings->product_discount && $inv->product_discount != 0)
                            {
                                echo '<td style="text-align:right;">' . $this->sma->formatMoney($inv->product_discount) . '</td>';
                            }
                            if($Settings->tax1 && $inv->product_tax > 0)
                            {
                                echo '<td style="text-align:right;">' . $this->sma->formatMoney($inv->product_tax) . '</td>';
                            }
                            
                            ?>
                            <td style="text-align:right; padding-right:10px;"><?= $this->sma->formatMoney($inv->total + $inv->product_tax); ?></td>
                        </tr>
                        <?php
                        if($inv->order_discount != 0)
                        {
                            echo '<tr><td colspan="' . $col . '" style="text-align:right; padding-right:10px;;">' . lang("order_discount") . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;">' . ($inv->order_discount_id ? '<small>(' . $inv->order_discount_id . ')</small> ' : '') . $this->sma->formatMoney($inv->order_discount) . '</td></tr>';
                        }
                        if($Settings->tax2 && $inv->order_tax != 0)
                        {
                            echo '<tr><td colspan="' . $col . '" style="text-align:right; padding-right:10px;;">' . lang("order_tax") . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;">' . $this->sma->formatMoney($inv->order_tax) . '</td></tr>';
                        }
                        if($inv->shipping != 0)
                        {
                            echo '<tr><td colspan="' . $col . '" style="text-align:right; padding-right:10px;;">' . lang("shipping") . ' (' . $default_currency->code . ')</td><td style="text-align:right; padding-right:10px;">' . $this->sma->formatMoney($inv->shipping) . '</td></tr>';
                        }
                        ?>
                        <tr>
                            <td colspan="<?= $col; ?>"
                                style="text-align:right; padding-right:10px; font-weight:bold;"><?= lang("total_amount"); ?>
                                (<?= $default_currency->code; ?>)
                            </td>
                            <td style="text-align:right; padding-right:10px; font-weight:bold;"><?= $this->sma->formatMoney($inv->grand_total); ?></td>
                        </tr>

                        </tfoot>
                    </table>
                </div>

                <div class="row">
                    <div class="col-xs-6">
                        <?php if($inv->note || $inv->note != ""){ ?>
                            <div class="well well-sm">
                                <p class="bold"><?= lang("note"); ?>:</p>

                                <div><?= $this->sma->decode_html($inv->note); ?></div>
                            </div>
                        <?php } ?>
                    </div>

                    <div class="col-xs-6">
                        <?php
                        if($Settings->invoice_view == 1)
                        { 
                            $resTaxTbl = $this->sma->quoteTaxInvvoiceTabel($tax_summary, $taxItems, $inv, $return_sale, $Settings, 1);
                            echo $resTaxTbl;
                        } 
                        ?>
                        <div class="well well-sm">
                            <p><?= lang("created_by"); ?>
                                : <?= $created_by->first_name . ' ' . $created_by->last_name; ?> </p>

                            <p><?= lang("date"); ?>: <?= $this->sma->hrld($inv->date); ?></p>
                            <?php if($inv->updated_by){ ?>
                                <p><?= lang("updated_by"); ?>
                                    : <?= $updated_by->first_name . ' ' . $updated_by->last_name;; ?></p>
                                <p><?= lang("update_at"); ?>: <?= $this->sma->hrld($inv->updated_at); ?></p>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if( ! $Supplier || ! $Customer){ ?>
            <div class="buttons">
                <?php if($inv->attachment){ ?>
                    <div class="btn-group">
                        <a href="<?= site_url('welcome/download/' . $inv->attachment) ?>" class="tip btn btn-primary"
                           title="<?= lang('attachment') ?>">
                            <i class="fa fa-chain"></i>
                            <span class="hidden-sm hidden-xs"><?= lang('attachment') ?></span>
                        </a>
                    </div>
                <?php } ?>
                <div class="btn-group btn-group-justified">
                    <div class="btn-group">
                        <a href="<?= site_url('sales/add/' . $inv->id) ?>" class="tip btn btn-primary"
                           title="<?= lang('create_invoice') ?>">
                            <i class="fa fa-plus-circle"></i> <span
                                    class="hidden-sm hidden-xs"><?= lang('create_invoice') ?></span>
                        </a>
                    </div>
                    <div class="btn-group">
                        <a href="<?= site_url('quotes/pdf/' . $inv->id) ?>" class="tip btn btn-primary"
                           title="<?= lang('download_pdf') ?>">
                            <i class="fa fa-download"></i> <span class="hidden-sm hidden-xs"><?= lang('pdf') ?></span>
                        </a>
                    </div>
                    <div class="btn-group">
                        <a href="<?= site_url('quotes/email/' . $inv->id) ?>" data-toggle="modal" data-target="#myModal"
                           class="tip btn btn-info tip" title="<?= lang('email') ?>">
                            <i class="fa fa-envelope-o"></i> <span
                                    class="hidden-sm hidden-xs"><?= lang('email') ?></span>
                        </a>
                    </div>
                    <div class="btn-group">
                        <a href="<?= site_url('quotes/edit/' . $inv->id) ?>" class="tip btn btn-warning tip"
                           title="<?= lang('edit') ?>">
                            <i class="fa fa-edit"></i> <span class="hidden-sm hidden-xs"><?= lang('edit') ?></span>
                        </a>
                    </div>
                    <div class="btn-group">
                        <a href="#" class="tip btn btn-danger bpo"
                           title="<b><?= $this->lang->line("delete_quote") ?></b>"
                           data-content="<div style='width:150px;'><p><?= lang('r_u_sure') ?></p><a class='btn btn-danger' href='<?= site_url('quotes/delete/' . $inv->id) ?>'><?= lang('i_m_sure') ?></a> <button class='btn bpo-close'><?= lang('no') ?></button></div>"
                           data-html="true" data-placement="top">
                            <i class="fa fa-trash-o"></i> <span class="hidden-sm hidden-xs"><?= lang('delete') ?></span>
                        </a>
                    </div>
                </div>
            </div>
        <?php } ?>
    </div>
</div>
