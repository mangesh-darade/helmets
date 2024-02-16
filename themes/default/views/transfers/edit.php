<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
    var status = '<?= $transfer->status ?>'; 
    var count = 1, an = 1, product_variant = 0, shipping = 0,
        product_tax = 0, total = 0,
        tax_rates = <?php echo json_encode($tax_rates); ?>, toitems = {},
        audio_success = new Audio('<?= $assets ?>sounds/sound2.mp3'),
        audio_error = new Audio('<?= $assets ?>sounds/sound3.mp3');
        $(document).ready(function () {
        <?php if ($transfer) { ?>
        localStorage.setItem('todate', '<?= date($dateFormats['php_ldate'], strtotime($transfer->date)) ?>');
        localStorage.setItem('from_warehouse', '<?= $transfer->from_warehouse_id ?>');
        localStorage.setItem('toref', '<?= $transfer->transfer_no ?>');
        localStorage.setItem('to_warehouse', '<?= $transfer->to_warehouse_id ?>');
        localStorage.setItem('tostatus', '<?= $transfer->status ?>');
        localStorage.setItem('tonote', '<?= $this->sma->decode_html($transfer->note); ?>');
        localStorage.setItem('toshipping', '<?= $transfer->shipping ?>');
        localStorage.setItem('toitems', JSON.stringify(<?= $transfer_items; ?>));
        <?php } ?>
        <?php if ($Owner || $Admin || $GP['transfers-date']) { ?>
        $(document).on('change', '#todate', function (e) {
            localStorage.setItem('todate', $(this).val());
        });
        if (todate = localStorage.getItem('todate')) {
            $('#todate').val(todate);
        }
        <?php } ?>
        ItemnTotals();
        $("#add_item").autocomplete({
            //source: '<?= site_url('transfers/suggestions'); ?>',
            source: function (request, response) {
                if (!$('#from_warehouse').val()) {
                    $('#add_item').val('').removeClass('ui-autocomplete-loading');
                    bootbox.alert('<?=lang('select_above');?>');
                    //response('');
                    $('#add_item').focus();
                    return false;
                }
                $.ajax({
                    type: 'get',
                    url: '<?= site_url('transfers/suggestions'); ?>',
                    dataType: "json",
                    data: {
                        term: request.term,
                        warehouse_id: $("#from_warehouse").val(),
                        warehouse_2: $("#to_warehouse").val(),
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 1,
            autoFocus: false,
            delay: 250,
            response: function (event, ui) {
                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    //audio_error.play();
                    if ($('#from_warehouse').val()) {
                        bootbox.alert('<?= lang('no_match_found') ?>', function () {
                            $('#add_item').focus();
                        });
                    } else {
                        bootbox.alert('<?= lang('please_select_warehouse') ?>', function () {
                            $('#add_item').focus();
                        });
                    }
                    $(this).val('');
                }
                else if (ui.content.length == 1 && ui.content[0].id != 0) {
                    ui.item = ui.content[0];
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close');
                    $(this).removeClass('ui-autocomplete-loading');
                }
                else if (ui.content.length == 1 && ui.content[0].id == 0) {
                    //audio_error.play();
                    bootbox.alert('<?= lang('no_match_found') ?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).val('');

                }
            },
            select: function (event, ui) {
                event.preventDefault();
                if (ui.item.id !== 0) {
                    var row = add_transfer_item(ui.item);
                    if (row)
                        $(this).val('');
                } else {
                    //audio_error.play();
                    bootbox.alert('<?= lang('no_match_found') ?>');
                }
            }
        });
        $('#add_item').bind('keypress', function (e) {
            if (e.keyCode == 13) {
                e.preventDefault();
                $(this).autocomplete("search");
            }
        });

        $(window).bind('beforeunload', function (e) {
            $.get('<?= site_url('welcome/set_data/remove_tols/1'); ?>');
            if (count > 1) {
                var message = "You will loss data!";
                return message;
            }
        });
        $('#reset').click(function (e) {
            $(window).unbind('beforeunload');
        });
        $('#edit_transfer').click(function () {
            $(window).unbind('beforeunload');
            $('form.edit-to-form').submit();
        });
        var to_warehouse;
        $('#to_warehouse').on("select2-focus", function (e) {
            to_warehouse = $(this).val();
        }).on("select2-close", function (e) {
            if ($(this).val() == $('#from_warehouse').val()) {
                $(this).select2('val', to_warehouse);
                bootbox.alert('<?= lang('please_select_different_warehouse') ?>');
            }
        });
        var from_warehouse;
        $('#from_warehouse').on("select2-focus", function (e) {
            from_warehouse = $(this).val();
        }).on("select2-close", function (e) {
            if ($(this).val() == $('#to_warehouse').val()) {
                $(this).select2('val', from_warehouse);
                bootbox.alert('<?= lang('please_select_different_warehouse') ?>');
            }
        });
        /*var status = "
        <?=$transfer->status?>";
         $('#tostatus').change(function(){
         if(status == 'completed') {
         bootbox.alert('
        <?=lang('can_not_change_status_of_completed_transfer')?>');
         $('#tostatus').select2("val", tostatus);
         }
         });*/

    });
</script>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-edit"></i><?= lang('edit_transfer'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo lang('enter_info'); ?></p>
                <?php
                $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'class' => 'edit-to-form');
                echo form_open_multipart("transfers/edit/" . $transfer->id, $attrib);
                $wh[''] = '';
                foreach ($warehouses as $warehouse) {
                    $wh[$warehouse->id] = $warehouse->name;
                }
                ?>


                <div class="row">
                    <div class="col-lg-12">

                        <?php if ($Owner || $Admin || $GP['transfers-date']) { ?>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <?= lang("date", "todate"); ?>
                                    <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip datetime" id="todate" required="required"'); ?>
                                </div>
                            </div>
                        <?php } ?>
                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("reference_no", "ref"); ?>
                                <?php echo form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : $transfer->transfer_no), 'class="form-control input-tip" id="ref" required="required"'); ?>
                            </div>
                        </div>

                        

                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("status", "tostatus"); ?>
								<?php
								if($transfer->status=='request'){
									$post = array('request' => lang('Request'), 'partial' => lang('Partial sent'), 'sent' => lang('Sent'));
								}
								if($transfer->status=='partial'){
									$post = array('partial' => lang('Partial sent'), 'partial_completed' => lang('Partial Completed'), 'sent_balance' => lang('Sent Balance'));
								}
								if($transfer->status=='sent_balance'){
										$post = array('sent_balance' => lang('Sent Balance'), 'completed' => lang(' Completed'));
									}
								
								if($transfer->status=='partial_completed'){
									$post = array('partial_completed' => lang('Partial Completed'), 'sent_balance' => lang('Sent Balance'));
								}
								if($transfer->status=='sent'){
									$post = array('sent' => lang('Sent'), 'completed' => lang(' Completed'));
								}
								if($transfer->status=='completed'){
									$post = array('completed' => lang(' Completed'));
								}
								?>
                                <?php
                                
                                 /*if($Owner || $Admin || $this->session->userdata('view_right')=='1' ){
                                  $post = array('request' => lang('Request'),'sent' => lang('sent'), 'completed' => lang('completed'),'partial' => lang('Partial'));
                                }else{
                                    if($GP['transfer_status_completed']){
                                        $post['completed'] = lang('completed');
                                    }
                                    if($GP['transfer_status_request']){
                                        $post['request'] = lang('Request');
                                    }
                                    if($GP['transfer_status_sent']){
                                        $post['sent'] = lang('sent');
                                    }
                                    if($GP['transfer_status_partial']){
                                        $post['partial'] = lang('Partial');
                                    }
                                }*/
                                  echo form_dropdown('status', $post, (isset($_POST['status']) ? $_POST['status'] : ''), 'id="tostatus" class="form-control input-tip select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("status") . '" required="required" style="width:100%;" ');
                                ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group" style="margin-bottom:5px;">
                                <?= lang("shipping", "toshipping"); ?>
                                <?php echo form_input('shipping', '', 'class="form-control input-tip" id="toshipping"'); ?>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="form-group">
                                <?= lang("document", "document") ?>
                                <input id="document" type="file" data-browse-label="<?= lang('browse'); ?>" name="document" data-show-upload="false"
                                       data-show-preview="false" class="form-control file">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <div class="panel panel-warning">
                                <div
                                    class="panel-heading"><?= lang('please_select_these_before_adding_product') ?></div>
                                <div class="panel-body" style="padding: 5px;">
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?= lang("from_warehouse", "from_warehouse"); ?>
                                            <?php echo form_dropdown('from_warehouse', $wh, (isset($_POST['from_warehouse']) ? $_POST['from_warehouse'] :  $transfer->from_warehouse_id), 'id="from_warehouse" class="form-control input-tip select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("from_warehouse") . '" required="required" style="width:100%;" ');
                                            ?>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?= lang("to_warehouse", "to_warehouse"); ?>
                                            <?php
                                                $permisions_werehouse = explode(",", $this->session->userdata('warehouse_id'));
                                            $whto[''] = '';
                                            foreach ($warehouses as $warehouseto) {
                                                if($Owner || $Admin || $this->session->userdata('view_right')=='1'  ){
                                                    $whto[$warehouseto->id] = $warehouseto->name;
                                                }else if(in_array($warehouseto->id,$permisions_werehouse)){
                                                    $whto[$warehouseto->id] = $warehouseto->name;
                                                }    
                                            }
                                            echo form_dropdown('to_warehouse', $whto, (isset($_POST['to_warehouse']) ? $_POST['to_warehouse'] :  $transfer->to_warehouse_id), 'id="to_warehouse" class="form-control input-tip select" data-placeholder="' . $this->lang->line("select") . ' ' . $this->lang->line("to_warehouse") . '" required="required" style="width:100%;" ');
                                            ?>
                                        </div>
                                    </div>
                                    
                                    <div class="col-md-4">
                                        <div class="form-group">
                                            <?= lang("Display Product", "display_product") ?>
                                            <?php 
                                                $list_product =array( 'search_product'=>'Search Product','warehouse_product' =>'Warehouse Product');
                                                     
                                                  echo form_dropdown('product_list', $list_product,$list_product['warehouse_product'] , 'id="display_product" class="form-control input-tip select" data-placeholder="' . lang("select") . ' ' . lang("warehouse") . '" required="required" '.($warehouse_id ? 'readonly' : '').' style="width:100%;"');
                                            ?>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            <div class="clearfix"></div>
                        </div>
                        <div class="clearfix"></div>
                            <div id="product_list">
                            <h5 class='text-center' id="title_warehouse" style="text-transform: uppercase;font-weight: bold;"></h5>
                            <div class="col-md-12">
                                <label class="table-label"><?= lang("Order Items"); ?> *</label>
                                <div class="controls table-controls" id="show_data">
                                    <table id="" class="table table-bordered table-condensed table-hover table-striped dataTable">
                                        <thead>
                                            <tr>
                                                <th style="min-width:30px; width: 30px; text-align: center;">
                                                    <span class="select_all"> <input class="checkbox checkft input-xs" type="checkbox" name="check" id="select_all"/></span>
                                                </th>
                                                <th><?= lang("product_name") . " (" . lang("product_code") . ")"; ?></th>
                                                <th class="col-md-2" ><?= lang('Stock'); ?><span id="warehouse_form2"> </span></th>
                                                <th class="col-md-2" ><?= lang('Stock'); ?><span id="warehouse_to2"> </span></th>
                                               <?php
                                                    if ($Settings->product_expiry) {
                                                        echo '<th class="col-md-2">' . $this->lang->line("expiry_date") . '</th>';
                                                    }
                                                ?>
                                                <th class="col-md-1"><?= lang("net_unit_cost"); ?></th>
                                                 <th class="col-md-1"><?= lang("quantity "); ?></th>
                                               
                                                <?php
                                                    if ($Settings->tax1) {
                                                        echo '<th class="col-md-1">' . $this->lang->line("product_tax") . '</th>';
                                                    }
                                                ?>
                                                <th>
                                                    <?= lang("subtotal"); ?> 
                                                    (<span class="currency"><?= $default_currency->code ?></span>)
                                                </th>
                                            </tr>
                                        </thead>
                                        <tbody></tbody>
                                        
                                    </table>
                                </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                        <div id="search_product">
                            <div class="col-md-12" id="sticker">
                                <div class="well well-sm">
                                    <div class="form-group" style="margin-bottom:0;">
                                        <div class="input-group wide-tip">
                                            <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                                                <i class="fa fa-2x fa-barcode addIcon"></i></a></div>
                                            <?php echo form_input('add_item', '', 'class="form-control input-lg" id="add_item" placeholder="' . $this->lang->line("add_product_to_order") . '"'); ?>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="clearfix"></div>
                       
                            <div class="col-md-12">
                                <div class="control-group table-group">
                                    <label class="table-label"><?= lang("order_items"); ?></label>

                                    <div class="controls table-controls">
                                        <table id="toTable"
                                               class="table items table-striped table-bordered table-condensed table-hover sortable_table">
                                            <thead>
                                            <tr>
                                             <th class="col-md-4"><?= lang("product_name") . " (" . $this->lang->line("product_code") . ")"; ?></th> 
                                             <th class="col-md-1"><?= lang("Stock") ?><span id="stock_1"></span></th>
                                             <th class="col-md-1"><?= lang("Stock ") ?><span id="stock_2"></span></th> 
                                              <?php
                                                if ($Settings->product_expiry) {
                                                    echo '<th class="col-md-2">' . $this->lang->line("expiry_date") . '</th>';
                                                }
                                                ?>
                                                <th class="col-md-1"><?= lang("net_unit_cost"); ?></th>
                                                <!-- 2/04/19 -->
                                                <?php 
                                                    if($transfer->status=='request' ||$transfer->status=='partial'  || $transfer->status=='partial_completed'){ ?>
                                                         <th class="col-md-1"><?= lang("Request Quantity"); ?></th>
                                                         <th class="col-md-1"><?= lang("Sent Quantity"); ?></th>
                                                <?php } ?>
                                                <th class="col-md-1">
                                                        <?php if($transfer->status=='partial_completed' || $transfer->status=='partial'){
                                                            echo "Balance ".lang("quantity");
                                                        }else{
                                                            echo lang("quantity");
                                                        } ?>
                                                       
                                                </th>
                                               <!-- End  2/04/19 -->

                                                <?php
                                                if ($Settings->tax1) {
                                                    echo '<th class="col-md-1">' . $this->lang->line("product_tax") . '</th>';
                                                }
                                                ?>
                                                <th><?= lang("subtotal"); ?> (<span
                                                        class="currency"><?= $default_currency->code ?></span>)
                                                </th>
                                                <th style="width: 30px !important; text-align: center;"><i
                                                        class="fa fa-trash-o"
                                                        style="opacity:0.5; filter:alpha(opacity=50);"></i></th>
                                            </tr>
                                            </thead>
                                            <tbody></tbody>
                                        </table>
                                    </div>
                                </div>


                            </div>
                        </div>     
                        <div class="col-sm-12">
                             <div class="from-group">
                                <?= lang("note", "tonote"); ?>
                                <?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ""), 'id="tonote" class="form-control" style="margin-top: 10px; height: 100px;"'); ?>
                            </div>

                            <div
                                class="from-group"><?php echo form_submit('edit_transfer', $this->lang->line("submit"), 'id="edit_transfer" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?>
                                <button type="button" class="btn btn-danger" id="reset"><?= lang('reset') ?></button>
                            </div>
                        </div>
                        
                    </div>
                </div>

                <div id="bottom-total" class="well well-sm" style="margin-bottom: 0;">
                    <table class="table table-bordered table-condensed totals" style="margin-bottom:0;">
                        <tr class="warning">
                            <td><?= lang('items') ?> <span class="totals_val pull-right" id="titems">0</span></td>
                            <td><?= lang('total') ?><input name="total_warProduct" disabled="true"  id="total_warProduct" type="hidden" > <span class="totals_val pull-right" id="total">0.00</span></td>
                            <td><?= lang('shipping') ?><input name="tship_In" disabled="true"  id="tship_In" type="hidden" >  <span class="totals_val pull-right" id="tship">0.00</span></td>
                            <?php if ($Settings->tax1) { ?>
                                <td><?= lang('product_tax') ?><input name="tship_In" disabled="true"  id="tship_In" type="hidden" > <span class="totals_val pull-right" id="ttax1">0.00</span></td>
                            <?php } ?>
                            <td><?= lang('grand_total') ?> <span class="totals_val pull-right" id="gtotal">0.00</span>
                            </td>
                        </tr>
                    </table>
                </div>

                <?php echo form_close(); ?>

            </div>

        </div>
    </div>
</div>

<div class="modal" id="prModal" tabindex="-1" role="dialog" aria-labelledby="prModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i
                            class="fa fa-2x">&times;</i></span><span class="sr-only"><?=lang('close');?></span></button>
                <h4 class="modal-title" id="prModalLabel"></h4>
            </div>
            <div class="modal-body" id="pr_popover_content">
                <form class="form-horizontal" role="form">
                    <div class="form-group">
                        <label for="pquantity" class="col-sm-4 control-label"><?= lang('quantity') ?></label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="pquantity">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="punit" class="col-sm-4 control-label"><?= lang('product_unit') ?></label>
                        <div class="col-sm-8">
                            <div id="punits-div"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="poption" class="col-sm-4 control-label"><?= lang('product_option') ?></label>
                        <div class="col-sm-8">
                            <div id="poptions-div"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pprice" class="col-sm-4 control-label"><?= lang('cost') ?></label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control" id="pprice">
                        </div>
                    </div>
                    <input type="hidden" id="old_tax" value=""/>
                    <input type="hidden" id="old_qty" value=""/>
                    <input type="hidden" id="old_price" value=""/>
                    <input type="hidden" id="row_id" value=""/>
                    <input type="hidden" id="warh1qty" value=""/>
                    <input type="hidden" id="warh2qty" value=""/>
                </form>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="editItem"><?= lang('submit') ?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal" id="prModaltable" tabindex="-1" role="dialog" aria-labelledby="prModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" onclick="close_model()" class="close" data-dismiss="modal"><span aria-hidden="true"><i
                            class="fa fa-2x">&times;</i></span><span class="sr-only"><?=lang('close');?></span></button>
                <h4 class="modal-title" id="prModalLabelte"></h4>
            </div>
            <div class="modal-body" id="pr_popover_content">
                <form class="form-horizontal" role="form" id="edititemdata">
                    <div class="form-group">
                        <label for="pquantity" class="col-sm-4 control-label"><?= lang('quantity') ?></label>

                        <div class="col-sm-8">
                            <input type="text" name="editquantiry" class="form-control" id="pquantityte">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="punit" class="col-sm-4 control-label"><?= lang('product_unit') ?></label>
                        <div class="col-sm-8">
                            <div id="punits-divte"></div>
                        </div>
                    </div>
                    <div class="form-group" style="display:none;">
                        <label for="poption" class="col-sm-4 control-label"><?= lang('product_option') ?></label>
                        <div class="col-sm-8">
                            <div id="poptions-divte"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="pprice" class="col-sm-4 control-label"><?= lang('cost') ?></label>

                        <div class="col-sm-8">
                            <input type="text" name="editcost" class="form-control" id="ppricete">
                        </div>
                        <input type='hidden' name="rowid" id="editrowid"/>
                        <input type="hidden" name="warhv1qty" id="warhv1qty" value=""/>
                        <input type="hidden" name="warhv2qty" id="warhv2qty" value=""/>
                        <input type="hidden" name="vartientId" id="vartientId"  value=""/>
                    </div>
                    <input type="hidden" id="old_taxte" value=""/>
                    <input type="hidden" id="old_qtyte" value=""/>
                    <input type="hidden" id="old_pricete" value=""/>
                    <input type="hidden" id="row_idte" value=""/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="submit_form()" id="editItemte"><?= lang('submit') ?></button>
            </div>
        </div>
    </div>
</div>
<script>
    
 $(document).ready(function(){
           var  warehouse_form = $("#from_warehouse option:selected").text();
            var  warehouse_to = $("#to_warehouse option:selected").text();

             $('.warehouse_form1').html('<br/>('+warehouse_form+')');
            $('.warehouse_to1').html('<br/>('+warehouse_to+')');
             
            $('#warehouse_form2').html('<br/>('+warehouse_form+')');
            $('#warehouse_to2').html('<br/>('+warehouse_to+')');
            
             $('#stock_1').html('<br/>('+warehouse_form+')');
            $('#stock_2').html('<br/>('+warehouse_to+')');
            //warehouse_form
            var get_warehouse = $('#from_warehouse').val();
            var get_warehouse_to =$('#to_warehouse').val();
             product_get_list(get_warehouse,get_warehouse_to);
 });  
  $(document).ready(function () {
      
      
     // Display List 
        var warehouse_name;
       var display_list =  $('#display_product').val();
       if(display_list=='warehouse_product'){
            block_view('show','#search_product');
            block_view('hide','#product_list');
            var get_warehouse = $('#from_warehouse').val();
            product_get_list(get_warehouse);
        }else{
           block_view('hide','#product_list');
           block_view('show','#search_product');
           
        }
        
      if($('#display_product_search').prop("checked")==true){
            block_view('show','#search_product');
            block_view('hide','#product_list');
        }else{
            block_view('hide','#search_product');
            block_view('show','#product_list');
        }
        
       $('#display_product').change(function(){
            if($(this).val()=='warehouse_product'){
                if (!$('#from_warehouse').val()) {
                    bootbox.alert('<?=lang('Please Select Warehouse');?>');
                }
                    block_view('hide','#search_product');
                    block_view('show','#product_list');
               
            }else if($(this).val()=='search_product'){
                block_view('show','#search_product');
                block_view('hide','#product_list');
            }
        });
        
         // Werehouse Change
        $('#from_warehouse').change(function(){
            var  warehouse_form = $("#from_warehouse option:selected").text();
            var  warehouse_to = $("#to_warehouse option:selected").text();

             $('.warehouse_form1').html('<br/>('+warehouse_form+')');
            $('.warehouse_to1').html('<br/>('+warehouse_to+')');
             
            $('#warehouse_form2').html('<br/>('+warehouse_form+')');
            $('#warehouse_to2').html('<br/>('+warehouse_to+')');
            
             $('#stock_1').html('<br/>('+warehouse_form+')');
            $('#stock_2').html('<br/>('+warehouse_to+')');
            //warehouse_form
            var get_warehouse = $(this).val();
            var get_warehouse_to =$('#to_warehouse').val();
//            if(get_warehouse_to==false){
//                 bootbox.alert("Please Select Werehouse To");
//            }else{
                product_get_list(get_warehouse,get_warehouse_to);
//            }    
        });
        
        $('#to_warehouse').change(function(){
             var  warehouse_form = $("#from_warehouse option:selected").text();
            var  warehouse_to = $("#to_warehouse option:selected").text();

            $('#warehouse_form1').html('<br/>('+warehouse_form+')');
            $('#warehouse_to1').html('<br/>('+warehouse_to+')');
            
            $('#warehouse_form2').html('<br/>('+warehouse_form+')');
            $('#warehouse_to2').html('<br/>('+warehouse_to+')');
            
              $('#stock_1').html('<br/>('+warehouse_form+')');
            $('#stock_2').html('<br/>('+warehouse_to+')');
            var get_warehouse = $(this).val();
            var get_warehouse_form =$('#from_warehouse').val();
//           /*if(get_warehouse_form==false){
//                 bootbox.alert("Please Select Werehouse From");
//            }else{*/
//              product_get_list(get_warehouse_form,get_warehouse);
            /*}  */  
        });
        
           // End Werehouse Change
         
       
         
  });   
  
  // Bind List Product List
   function product_get_list(){
           
            $.ajax({
                type:'ajax',
                dataType:'json',
                method:'get',
                url:'<?= site_url('transfers/getTransferProduct/') ?>'+arguments[0]+'/'+arguments[1],
                async:false,
                success:function(result){
                    var  warehouse_form = $("#from_warehouse option:selected").text();
                    var  warehouse_to = $("#to_warehouse option:selected").text();
                    var htmlset =' <table id="qaTable2" class="table  qaTable2 table-bordered table-condensed table-hover table-striped dataTable">';
                        htmlset +='<thead>';
                            htmlset +='<tr>';
                                htmlset +='<th style="min-width:30px; width: 30px; text-align: center;">';
                                    htmlset +='<span class="select_all"> <input class="checkbox checkft input-xs" type="checkbox" name="check" id="select_all"/></span>';
                                htmlset +='</th>';
                                htmlset +='<th><?= lang("product_name") . " (" . lang("product_code") . ")" ?></th>';
                                htmlset +='<th class="col-md-2" ><?= lang('Stock'); ?><span id="warehouse_form1"><br/>('+warehouse_form+') </span></th>';
                                htmlset +='<th class="col-md-2" ><?= lang('Stock'); ?><span id="warehouse_to1"><br/>('+warehouse_to+')</span></th>';
                                <?php if ($Settings->product_expiry) { ?>
                                htmlset +='<th class="col-md-2"> <?=$this->lang->line("expiry_date")?></th>';
                                <?php  } ?>
                                htmlset +='<th class="col-md-1"><?= lang("net_unit_cost"); ?></th>';
                                htmlset +='<th class="col-md-1"><?= lang("quantity"); ?></th>';
                                <?php if ($Settings->tax1) { ?>
                                     htmlset +='<th class="col-md-1"><?= $this->lang->line("product_tax")?></th>';
                                <?php } ?>
                                htmlset +='<th><?= lang("subtotal"); ?> (<span class="currency"><?= $default_currency->code ?></span>) </th>';
                            htmlset +='</tr>';
                        htmlset +='</thead>';
                        htmlset +='<tbody>';
                    if(result!=''){  
                        var i=0;
                        for(i=0;i<result.length;i++){
//                            console.log(result[i].item.werehouse_2_quantity);
                              var warehouse2_quantity = result[i].item.werehouse_2_quantity;
                            //var warehouse2_quantity =result[i].item.warehouse_2_quantity;//==null?'0':result[i].item.warehouse_2_quantity;
                            var product_tax='0';
                            var item_cost=0;
                            var unit_cost =result[i].item.cost;
                             var pr_tax = result[i].item.tax_rate;
                             var pr_tax_val = 0, pr_tax_rate = 0;
                               if (site.settings.tax1 == 1) {
                                   if (pr_tax !== false) {
                                       if (result[i].item.tax_type == 1) {
                                           if (result[i].item.tax_method == '0') {
                                               pr_tax_val = formatDecimal(((unit_cost) * parseFloat(result[i].item.rate)) / (100 + parseFloat(result[i].item.rate)), 4);
                                               pr_tax_rate = formatDecimal(result[i].item.rate) + '%';
                                           }else{
                                               pr_tax_val = formatDecimal(((unit_cost) * parseFloat(result[i].item.rate)) / 100, 4);
                                               pr_tax_rate = formatDecimal(result[i].item.rate) + '%';
                                           }
                                       }else if(result[i].item.tax_type == 2){
                                            pr_tax_val = parseFloat(result[i].item.rate);
                                            pr_tax_rate = result[i].item.rate;
                                       }
                                        product_tax = pr_tax_val * 1;
                                        
                                   }
                                   item_cost = result[i].item.tax_method == '0' ? formatDecimal(unit_cost-pr_tax_val, 4) : formatDecimal(unit_cost);
                                   
                               }
                  
                          
                               
                               var pass_variant=''
                                if(Object.keys(result[i].variant).length != 0){
                                        var passvariant; var k=0;
//                                        var   pass_variant='<select name="variant[]"  id="poption_'+result[i].item.id+'"  class="form-control select rvariant input-xs">';
                                            for(k=0;k<Object.keys(result[i].variant).length;k++ ){
                                            pass_variant +='<option value="'+result[i].variant[k].id+'" >'+result[i].variant[k].name+'</option>';

                                            }   
//                                            pass_variant= passvariant ;  
                               
                                }else{
                                  
                                  pass_variant = '<option>N/A</option>';
                                }
                                    
                                var getunits='';var variant_val='';var variant_id = 0;
                                if(Object.keys(result[i].units).length !=0){
                                    var j=0;
                                    for(j=0;j<Object.keys(result[i].units).length; j++){
                                        getunits += '<option value="'+result[i].units[j].id+'">'+result[i].units[j].name+'</option>';
                                    }   
                                
                                }
                                var checkdesable = (result[i].item.quantity >= 1)?'':'disabled';

                                if(result[i].item.varentid != null){
                                  variant_id = '_'+result[i].item.varentid+'';
                                }else{
                                  variant_id = '_'+variant_id+'';
                                }

                                if(result[i].item.option != null){
                                   variant_val = '-('+result[i].item.option+')';
                                }
                                htmlset+='<tr>';
                                
                                htmlset+='<td ><div style="display:none" id="passunites_'+result[i].item.id+'" ><select name="passunit"  class="form-control select rvariant input-xs">'+getunits+'</select> </div> <div style="display:none" id="passvariant_'+result[i].item.id+'"><select name="variant"  id="poption_'+result[i].item.id+'" onChange="getvart('+result[i].item.id+', this.value);"   class="form-control select rvariant input-xs">'+pass_variant+'</select></div>';

                                htmlset+='<input '+checkdesable+'  class="checkbox  multi-select input-xs EachProduct" type="checkbox" onclick="myfunction('+result[i].item.id+')"value="'+result[i].item.id+''+variant_id+'" name="val[]" id="check_box_'+result[i].item.id+''+variant_id+'" /></td>';

                                htmlset+='<td ><label for="check_box_'+result[i].item.id+''+variant_id+'" style="font-weight:normal !important">'+result[i].item.name+'('+result[i].item.code+')'+variant_val+'</label><input name="product_id[]" type="hidden" disabled="ture" id="product_id_'+result[i].item.id+'" class="rid allcheck" value="'+result[i].item.id+'">';

                                htmlset+='<input name="product_type[]" type="hidden" disabled="ture" id="product_type_'+result[i].item.id+''+variant_id+'" class="rtype allcheck" value="'+result[i].item.type+'">';
                                
                               
                                htmlset+='<input name="product_code[]" type="hidden" disabled="ture" id="product_code_'+result[i].item.id+''+variant_id+'" class="rcode allcheck" value="'+result[i].item.code+'">';

                                htmlset+='<input name="product_name[]" type="hidden" disabled="ture" id="product_name_'+result[i].item.id+''+variant_id+'" class="rname allcheck" value="'+result[i].item.name+'">';

                                htmlset+='<input name="product_option[]" disabled="ture" id="product_option_'+result[i].item.id+''+variant_id+'"  type="hidden" class="roption allcheck" value="'+result[i].item.varentid+'">   <i class="pull-right fa fa-edit tip tointer " onclick="edit_row(&#34;'+result[i].item.id+''+variant_id+'&#34;)" title="Edit" style="cursor:pointer;"></i></td>';

                                htmlset+='<td class="text-right" id="vartstock1_' +result[i].item.varentid+ ' ">'+ formatDecimal(result[i].item.quantity)+'</td>';
                                htmlset+='<td class="text-right" id="vartstock2_' +result[i].item.varentid+ '">'+ formatDecimal(warehouse2_quantity)+'</td>';

                                 
                                <?php if ($Settings->product_expiry) { ?>
                                htmlset+='<td><input class="form-control date rexpiry allcheck" name="expiry[]" autocomplete="off" disabled="ture" type="text" value="" data-id="'+result[i].item.id+''+variant_id+'" data-item="3" id="expiry_'+result[i].item.id+''+variant_id+'"></td>';
                                 <?php } ?>

                                htmlset+='<td class="text-right"><span id="itemcostshow'+result[i].item.id+''+variant_id+'">'+formatMoney(item_cost)+'</span><input class="form-control input-sm text-right rcost allcheck" name="net_cost[]" disabled="ture" type="hidden" id="net_cost_'+result[i].item.id+''+variant_id+'" value="'+item_cost+'">';

                                htmlset+='<input class="rucost allcheck" name="unit_cost[]" disabled="ture"  id="unit_cost_'+result[i].item.id+''+variant_id+'" type="hidden" value="'+result[i].item.cost+'">';

                                htmlset+='<input class="realucost allcheck" name="real_unit_cost[]" disabled="ture" id="real_unit_cost_'+result[i].item.id+''+variant_id+'"  type="hidden" value="'+result[i].item.cost+'"</td>';

                                htmlset+='<td><input name="quantity_balance[]" type="hidden" class="rbqty allcheck" disabled="ture" id="quantity_balance_'+result[i].item.id+''+variant_id+'" value="0">';

                                htmlset+='<input name="ordered_quantity[]" type="hidden" class="roqty allcheck" disabled="ture" id="ordered_quantity_'+result[i].item.id+''+variant_id+'" value="0">';

                                htmlset+='<input class="form-control text-center allcheck" tabindex="2" name="quantity[]" type="number" value="1" data-id="'+result[i].item.id+'" data-item="3" id="quantity_'+result[i].item.id+''+variant_id+'" disabled="ture" onchange="change_quantity(&#34;'+result[i].item.id+''+variant_id+'&#34;)">';

                                htmlset+='<input name="product_unit[]" disabled="ture" id="product_unit_'+result[i].item.id+''+variant_id+'" type="hidden" class="runit allcheck" value="'+result[i].item.unit+'">';

                                htmlset+='<input name="product_base_quantity[]" disabled="ture" type="hidden" id="rbase_qty_'+result[i].item.id+''+variant_id+'" class="rbase_quantity allcheck" value="1"></td>';

                               <?php if ($Settings->tax1) { ?>
                                htmlset+='<td class="text-right">('+formatDecimal(result[i].item.rate)+'%)<br/><span id="total_tax_'+result[i].item.id+''+variant_id+'">'+formatMoney(product_tax)+'</span><input type="hidden" class="allcheck" name="tax_values" disabled="ture" id="tax_values_'+result[i].item.id+''+variant_id+'" value="'+pr_tax_val+'"> <input class="form-control input-sm text-right rproduct_tax allcheck" name="product_tax[]" type="hidden" disabled="ture" id="product_tax_'+result[i].item.id+''+variant_id+'" value="'+product_tax+'"></td>';
                                <?php } ?>
                                htmlset+='<td class="text-right"><span class="text-right ssubtotal" id="subtotal_'+result[i].item.id+''+variant_id+'">'+formatMoney((parseFloat(item_cost) + parseFloat(product_tax)) * 1 )+'</span></td>';
                                htmlset+='</tr>';
                                
                               
                        }
                    }else{
                        htmlset+='<tr>';
                             htmlset+='<td colspan="7" class="text-center"> Product Not Found</td>';
                        htmlset+='</tr>';
                    }
                    htmlset +='</tbody>';
                    htmlset +='</table>';
                    
  
                    $('#show_data').html(htmlset);
                        $('.qaTable2').DataTable({ 
                      "destroy": true, //use for reinitialize datatable
                   });

                   
                },error:function(){
                    console.log('error');
                }
            });
            
        
            
        } 
  // End Bind Product List
   // Block List Function
        function block_view(){
           
            switch(arguments[0]){
                case 'show':
                        $(arguments[1]).show();
                    break;
                    
                case 'hide':
                        $(arguments[1]).hide();
                    break;
            }
        }
        window.onload = function() {
           if (localStorage.getItem('to_warehouse')) {
                localStorage.removeItem('to_warehouse');
            }
           if (localStorage.getItem('from_warehouse')) {
                localStorage.removeItem('from_warehouse');
            } 
        }
          
       function myfunction(get){
        if($('#check_box_'+get).prop("checked")==true){
            boxdisabled('FALSE','#quantity_'+get);
            boxdisabled('FALSE','#expiry_'+get);
            boxdisabled('FALSE','#product_id_'+get);
            boxdisabled('FALSE','#product_type_'+get);
            boxdisabled('FALSE','#product_code_'+get);
            boxdisabled('FALSE','#product_name_'+get);
            boxdisabled('FALSE','#product_option_'+get);
            boxdisabled('FALSE','#net_cost_'+get);
            boxdisabled('FALSE','#unit_cost_'+get);
            boxdisabled('FALSE','#real_unit_cost_'+get);
            boxdisabled('FALSE','#quantity_balance_'+get);
            boxdisabled('FALSE','#ordered_quantity_'+get);
            boxdisabled('FALSE','#quantity_'+get);
            boxdisabled('FALSE','#product_unit_'+get);
            boxdisabled('FALSE','#rbase_qty_'+get);
            boxdisabled('FALSE','#product_tax_'+get);
        }else{
            boxdisabled('TRUE','#quantity_'+get);
            boxdisabled('TRUE','#expiry_'+get);
            boxdisabled('TRUE','#product_id_'+get);
            boxdisabled('TRUE','#product_type_'+get);
            boxdisabled('TRUE','#product_code_'+get);
            boxdisabled('TRUE','#product_name_'+get);
            boxdisabled('TRUE','#product_option_'+get);
            boxdisabled('TRUE','#net_cost_'+get);
            boxdisabled('TRUE','#unit_cost_'+get);
            boxdisabled('TRUE','#real_unit_cost_'+get);
            boxdisabled('TRUE','#quantity_balance_'+get);
            boxdisabled('TRUE','#ordered_quantity_'+get);
            boxdisabled('TRUE','#quantity_'+get);
            boxdisabled('TRUE','#product_unit_'+get);
            boxdisabled('TRUE','#rbase_qty_'+get);
            boxdisabled('TRUE','#product_tax_'+get);
            document.getElementById('rbase_qty_'+get).value='0';
            document.getElementById('quantity_'+get).value='0';
            document.getElementById('expiry_'+get).value='';
        }
        selectProductWarehouse();
    } 
    
    function boxdisabled(section,sectionid){
        switch(section){
            case 'TRUE':
                    $(sectionid).attr('disabled', true);
                break;
            
            case 'FALSE':
                    $(sectionid).attr('disabled', false);
                break;
        }
        
    }
    
    function change_quantity(get_id){
       var get_value = $('#quantity_'+get_id).val();
       var value_tax = $('#tax_values_'+get_id).val();
       var unit_cost = $('#net_cost_'+get_id).val();
       var total_tax_value = parseFloat(value_tax) * parseFloat(get_value);
       $('#total_tax_'+get_id).html(formatMoney(total_tax_value));
       var total_product_value = parseFloat(unit_cost) * parseFloat(get_value);
       var sub_total = parseFloat(total_product_value )+ parseFloat(total_tax_value);
       $('#subtotal_'+get_id).html(formatMoney(sub_total))
       document.getElementById('rbase_qty_'+get_id).value=get_value;
       selectProductWarehouse();
    }
    
     // Function Edit Row 
      function edit_row(get_row_id){
        //var get_row_id = arguments[0];
        var SplitId =  get_row_id.split('_');
        var MainId = SplitId[0];

        var product_name = $('#product_name_'+get_row_id).val();
        var product_code = $('#product_code_'+get_row_id).val();
        var product_quantity = $('#quantity_'+get_row_id).val();
        var produnct_unit = $('#product_unit_'+get_row_id).val();
        var product_cost = $('#net_cost_'+get_row_id).val();
        var unit_pass = document.getElementById('passunites_'+MainId).innerHTML; 
        
        $('#prModalLabelte').html(product_name+' ('+product_code+')');
        document.getElementById('pquantityte').value=product_quantity;
        $('#punits-divte').html(unit_pass);
        document.getElementById('ppricete').value=formatDecimal(product_cost);
        document.getElementById('editrowid').value=get_row_id; 
        var node = document.getElementById('passvariant_'+MainId).innerHTML;
        $('#poptions-divte').html(node);
       
       $('#prModaltable').show();
    }
     // End Function Edit Row
     // Fucntion Close Model
     function close_model(){
          $('#prModaltable').hide();
     }
     // End Function Close 
     
    function submit_form(){
      var row_id =0
      var editformdata = $("#edititemdata").serializeArray();
      var quantity = editformdata[0].value;
      row_id = editformdata[4].value;
      var varent_id = editformdata[7].value;
       document.getElementById('quantity_'+row_id).value=editformdata[0].value;
       document.getElementById('product_unit_'+row_id).value=editformdata[1].value;
       document.getElementById('net_cost_'+row_id).value=editformdata[3].value;

       $('#vartstock1_'+varent_id).text(editformdata[5].value);
       $('#vartstock2_'+varent_id).text(editformdata[6].value);

       $('#itemcostshow'+row_id).html(formatMoney(editformdata[3].value));
       $('#prModaltable').hide();
         
       /*12-17-2019 for quatity change product quantity*/
       var value_tax = $('#tax_values_'+row_id).val();
       var unit_cost = $('#net_cost_'+row_id).val();

       var total_tax_value = parseFloat(value_tax) * parseFloat(quantity);
       $('#total_tax_'+row_id).html(formatMoney(total_tax_value));
       var total_product_value = parseFloat(unit_cost) * parseFloat(quantity);
       var sub_total = parseFloat(total_product_value )+ parseFloat(total_tax_value);
       $('#subtotal_'+row_id).html(formatMoney(sub_total))
       document.getElementById('rbase_qty_'+row_id).value = quantity;
      /**/
       selectProductWarehouse();
    }
    
   $(document).ready(function() {
    block_view('hide','#product_list');
        block_view('show','#search_product');

   });
  /***/
   function selectProductWarehouse(){
        // Totals calculations after item addition
        var count = 1;
        var an = 1;
        var total = 0;
        var product_tax = 0;
        $('.Product_Tag_Box').html('');
        $('.EachProduct').each(function(){
            var Id = $(this).attr('id');
             if($('#'+Id).is(':checked')){
                var SplitId =  Id.split('_');
                var MainId = SplitId[2] + '_' + SplitId[3]; 
                var item_cost = $('#net_cost_'+MainId).val();
                var item_qty = $('#quantity_'+MainId).val();
                var pr_tax_val = $('#tax_values_'+MainId).val();
                var product_name = $('#product_name_'+MainId).val();
                //console.log('item_cost '+item_cost+' item_qty '+item_qty+' pr_tax_val '+pr_tax_val+'product_name'+product_name);
                total += formatDecimal(((parseFloat(item_cost) + parseFloat(pr_tax_val)) * parseFloat(item_qty)), 4);
                count += parseFloat(item_qty);
                an++;
                product_tax += pr_tax_val * item_qty;
                $('.Product_Tag_Box').append('<span class="Product_Tag ProductTag_'+MainId+'">'+product_name+' <a href="javascript:void(0);" onclick="return removeProduct('+MainId+');">X</a></span>');
            }
        
        });
        var shipping = ($('#tship_In').val()!='') ? parseFloat($('#tship_In').val()) : 0;
        var gtotal = total + shipping;
        $('#total_warProduct').val(total);
        $('#total').text(formatMoney(total));
        $('#titems').text((an-1)+' ('+(parseFloat(count)-1)+')');
        if (site.settings.tax1) {
            $('#ttax1').text(formatMoney(product_tax));
        }
        $('#gtotal').text(formatMoney(gtotal));
        if (an > parseInt(site.settings.bc_fix) && parseInt(site.settings.bc_fix) > 0) {
            $("html, body").animate({scrollTop: $('#sticker').offset().top}, 500);
            $(window).scrollTop($(window).scrollTop() + 1);
        }
    }
    



    function getvart(row_id, option_value){
    var qtyw1=0; var qtyw2=0;
    var vartient = option_value;
    var from_warehouse = $("#from_warehouse option:selected").val();
    var to_warehouse = $("#to_warehouse option:selected").val();
    
    $.ajax({
              type:'ajax',
              dataType:'json',
              method:'Get',
              data:{'from_warehouse': from_warehouse, 'to_warehouse': to_warehouse, 'vartient': vartient},
              url:'<?= site_url('transfers/getQuantity'); ?>',
              async:false,
              success:function(data){
                 if(data[0]){
                  qtyw1 = parseFloat(data[0]['quantity']);
                }
                
                if(data[1]){
                  qtyw2 = parseFloat(data[1]['quantity']);
                }
                $('#vartientId').val(varent_id);
                $('#warhv1qty').val(qtyw1);
                $('#warhv2qty').val(qtyw2);
            }
    });
    }

/***/

$('#pquantityte').change(function (e) {
    var quantity = $(this).val();
        if (!is_numeric(quantity)){
            var get_value = 1;
            $('#pquantityte').val('1');
            bootbox.alert("Unexpected value provided!");
        }
});


$(document).on('ifChecked', '.checkth, .checkft', function(event) {
    $('.checkth, .checkft').iCheck('check');
    $('.multi-select').each(function() {
        boxdisabled('FALSE','.allcheck');
    });
   
     
});
$(document).on('ifUnchecked', '.checkth, .checkft', function(event) {
    $('.checkth, .checkft').iCheck('uncheck');
    $('.multi-select').each(function() {
       
         boxdisabled('TRUE','.allcheck');
    });
   
});

$(document).on('ifChecked', '.multi-select', function(event) {
    myfunction($(this).attr('value'));
});

$(document).on('ifUnchecked', '.multi-select', function(event) {
    myfunction($(this).attr('value'));
});
</script>
