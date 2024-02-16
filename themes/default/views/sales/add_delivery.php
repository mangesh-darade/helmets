<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('add_delivery'); ?></h4>
        </div>
        <?php
        $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open_multipart("sales/add_delivery/" . $inv->id, $attrib);
        ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>
            
            <div class="row">
                <div class="col-md-6">
                    <?php if ($Owner || $Admin) { ?>
                        <div class="form-group">
                            <?= lang("date", "date"); ?>
                            <?= form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control datetime" id="date" required="required"'); ?>
                        </div>
                    <?php } ?>
                    <div class="form-group">
                        <?= lang("do_reference_no", "do_reference_no"); ?>
                        <?= form_input('do_reference_no', (isset($_POST['do_reference_no']) ? $_POST['do_reference_no'] : $do_reference_no), 'class="form-control tip" id="do_reference_no"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("sale_reference_no", "sale_reference_no"); ?>
                        <?= form_input('sale_reference_no', (isset($_POST['sale_reference_no']) ? $_POST['sale_reference_no'] : $inv->reference_no), 'class="form-control tip" id="sale_reference_no" required="required"'); ?>
                    </div>
                    <input type="hidden" value="<?php echo $inv->id; ?>" name="sale_id"/>

                    <div class="form-group">
                        <?= lang("customer", "customer"); ?>
                        <?php echo form_input('customer', (isset($_POST['customer']) ? $_POST['customer'] : $customer->name), 'class="form-control" id="customer" required="required" '); ?>
                    </div>

                    <div class="form-group">
                        <?= lang("address", "address"); ?>
                        <?php $_shipping_addr = isset($shipping_addr) && !empty($shipping_addr) ? $shipping_addr : $customer->address . " " . $customer->city . " " . $customer->state . " " . $customer->postal_code . " " . $customer->country . "<br>Tel: " . $customer->phone . " Email: " . $customer->email; ?>
                        <?php echo form_textarea('address', (isset($_POST['address']) ? $_POST['address'] : $_shipping_addr), 'class="form-control" id="address" required="required"'); ?>
                    </div>
                </div>
                
                <div class="col-md-6">
                    <div class="form-group">
                        <?= lang('status', 'status'); ?>
                        <?php
                        $opts = array('packing' => lang('packing'), 'delivering' => lang('delivering'), 'delivered' => lang('delivered'));
                        ?>
                        <?= form_dropdown('status', $opts, '', 'class="form-control" id="status" required="required" style="width:100%;"'); ?>
                    </div>

                    <div class="form-group">
                        <?= lang("delivered_by", "delivered_by"); ?>
                        <?= form_input('delivered_by', (isset($_POST['delivered_by']) ? $_POST['delivered_by'] : ''), 'class="form-control" id="delivered_by"'); ?>
                    </div>

                    <div class="form-group">
                        <?= lang("received_by", "received_by"); ?>
                        <?= form_input('received_by', (isset($_POST['received_by']) ? $_POST['received_by'] : ''), 'class="form-control" id="received_by"'); ?>
                    </div>

                    <div class="form-group">
                        <?= lang("attachment", "attachment") ?>
                        <input id="attachment" type="file" data-browse-label="<?= lang('browse'); ?>" name="document" data-show-upload="false" data-show-preview="false" class="form-control file">
                    </div>

                    <div class="form-group">
                        <?= lang("note", "note"); ?>
                        <?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ""), 'class="form-control" id="note"'); ?>
                    </div>
                </div>
            </div>
            
            <div class="row">
                <div class="form-group col-md-6">
                    <b><?= lang("Delivery Items"); ?> *</b>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <div class="form-group col-md-6"> <?= lang("Delivery Type"); ?></div>
                        <div class="col-md-6"><?php
                        $sdt = array(''=>'Pending','partial' => lang('partial'), 'overall' => lang('Overall'));
                        echo form_dropdown('delivery_status', $sdt, $inv->delivery_status, 'class="form-control input-tip" required="required" id="sldelivery_status"');
                        ?></div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="control-group table-group">                        
                        <div class="controls table-controls">
                            <table id="slTable"  class="table items table-striped table-bordered table-condensed table-hover sortable_table">
                                <thead>
                                    <tr>
                                        <th class="col-md-4"><?= lang("product_name") . " (" . lang("product_code") . ")"; ?></th>
                                        <th class="col-md-2"><?= lang("net_unit_price"); ?></th>
                                        <th class="col-md-1"><?= lang("tax"); ?></th>
                                        <th class="col-md-1"><?= lang("quantity"); ?></th>
                                        <th class="col-md-1 delivery_items"><?= lang("delivered"); ?></th>
                                        <th class="col-md-1 delivery_items"><?= lang("pending"); ?></th>
                                        <th class="col-md-2"><?= lang("subtotal"); ?> (<span class="currency"><?= $default_currency->code ?></span>)
                                        </th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php                                     
                                    if (!empty($inv_items)) {
                                        $row_no = 0;
                                        foreach ($inv_items as $key => $items) {
                                            $item_name = $items->product_code . '-' . $items->product_name;
                                            $pending_qty = $items->quantity - $items->delivered_quantity;
                                            ?>
                                            <tr>
                                                <td><?= $item_name ?></td>
                                                <td>Rs. <?= number_format($items->net_unit_price, 2) ?></td>
                                                <td>Rs. <?= number_format($items->item_tax, 2) ?></td>
                                                <td class="center"><?= number_format($items->quantity, 0) ?><input class="form-control text-center" name="quantity[<?= $items->id?>]" type="hidden" value="<?= (int)$items->quantity ?>" id="quantity_<?= $row_no ?>" ></td> 
                                                <td class="delivery_items"><input class="form-control text-center delivery_quantity" disabled="disabled" value="<?= (int)$items->delivered_quantity ?>"  name="delivered_quantity[<?= $items->id?>]" type="number" required="required" min="0" max="<?= (int)$items->quantity; ?>" id="delivered_quantity_<?= $row_no ?>" onchange="validate_qty(this);" onClick="this.select();"></td> 
                                                <td class="center delivery_items"><?= number_format($pending_qty, 0) ?></td> 
                                                <td class="text-right"><span class="text-right ssubtotal" id="subtotal_<?= $row_no ?>" > Rs. <?= number_format($items->subtotal, 2) ?> </span></td> 
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </tbody>
                                <tfoot></tfoot>
                            </table>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_delivery', lang('add_delivery'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<script type="text/javascript" charset="UTF-8">
                                                    $.fn.datetimepicker.dates['sma'] = <?= $dp_lang ?>;
</script>
<script type="text/javascript" src="<?= $assets ?>js/modal.js"></script>
<script type="text/javascript" charset="UTF-8">
    $(document).ready(function () {
$('#recent_pos_sale_modal-loading').hide();
        $.fn.datetimepicker.dates['sma'] = <?= $dp_lang ?>;
        $("#date").datetimepicker({
            format: site.dateFormats.js_ldate,
            fontAwesome: true,
            language: 'sma',
            weekStart: 1,
            todayBtn: 1,
            autoclose: 1,
            todayHighlight: 1,
            startView: 2,
            forceParse: 0
        }).datetimepicker('update', new Date());
        
        show_hide_delevey_options($('#sldelivery_status').val());
        
        $('#sldelivery_status').on('change', function(){
            
           show_hide_delevey_options(this.value)
             
        });
    });
    
    function validate_qty(Obj){
    
        if(parseInt(Obj.value) > parseInt(Obj.max)){ Obj.value=Obj.max } 
        if(parseInt(Obj.value) < 0){ Obj.value= 0 }
    }
    
    function show_hide_delevey_options(status){
        
        switch(status) {                
                case 'partial':
                 //   $('.delivery_items').show();
                    $('.delivery_quantity').removeAttr('disabled');
                    $('.delivery_quantity').val('');
                break;
                
                case '':
                case 'overall':                 
                  //  $('.delivery_items').hide();                      
                    $('.delivery_quantity').attr('disabled','disabled');
                    $('.delivery_quantity').val(0);
                break;
            }
    }
</script>
