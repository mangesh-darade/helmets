<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script type="text/javascript">
    var count = 1, an = 1;
    var type_opt = {'addition': '<?= lang('addition'); ?>', 'subtraction': '<?= lang('subtraction'); ?>'};
    var wp_id=0;
    function getVariantDetails(VarientId, ProductId){
		//alert(VarientId+' '+ProductId);
		var WarehouseId =  $('#qawarehouse').val();
		$.ajax({
               type: 'get',
               url:'<?= site_url('products/get_variant_details') ?>',
				data:{
					VarientId:VarientId,
					ProductId:ProductId,
					WarehouseId:WarehouseId,
				},			   
               async:false,
               success:function(result){
				   var Res = $.parseJSON(result);
				   
				   $.each(Res, function(key,value){
					   $('#ShowQty_'+ProductId).text(formatDecimal(value.quantity));
					   //console.log(key+' '+value.name);
				   });
                },error:function(result){
                    
                    console.log(result);
                }
                
        });
	}
    $(document).ready(function () {
        // Display List 
        var warehouse_name;
        var display_list =  $('#display_product').val();
        if(display_list=='search_product'){
            block_view('show','#search_product');
            block_view('hide','#product_list');
            var get_warehouse = $('#qawarehouse').val();
            product_get_list(get_warehouse);
            
            warehouse_name = $("#qawarehouse option:selected").text();
            document.getElementById('wp_id').value=get_warehouse;
            $('#title_warehouse').html('<br/>('+warehouse_name+')');
            
        }else{
           block_view('show','#product_list');
           block_view('hide','#search_product');
           $('#title_warehouse').html('');
        }
        
        // warehouse Change
         document.getElementById('wp_id').value=$('#qawarehouse').val();
        $('#qawarehouse').change(function(){
            var get_warehouse = $(this).val();
            product_get_list(get_warehouse);
            warehouse_name = $("#qawarehouse option:selected").text();
            $('#title_warehouse').html('<br/>('+warehouse_name+')');
             document.getElementById('wp_id').value=get_warehouse;
        });
        // End warehouse Change
        
        $('#display_product').change(function(){
            if($(this).val()=='warehouse_product'){
                block_view('hide','#search_product');
                block_view('show','#product_list');
                
            }else if($(this).val()=='search_product'){
                block_view('show','#search_product');
                block_view('hide','#product_list');
            }
        });
        
          
        // End Display List  
          
        
        if (localStorage.getItem('remove_qals')) {
            if (localStorage.getItem('qaitems')) {
                localStorage.removeItem('qaitems');
            }
            if (localStorage.getItem('qaref')) {
                localStorage.removeItem('qaref');
            }
            if (localStorage.getItem('qawarehouse')) {
                localStorage.removeItem('qawarehouse');
            }
            if (localStorage.getItem('qanote')) {
                localStorage.removeItem('qanote');
            }
            if (localStorage.getItem('qadate')) {
                localStorage.removeItem('qadate');
            }
            localStorage.removeItem('remove_qals');
        }

        <?php if ($adjustment_items) { ?>
        localStorage.setItem('qaitems', JSON.stringify(<?= $adjustment_items; ?>));
        <?php } ?>
        <?php if ($warehouse_id) { ?>
        localStorage.setItem('qawarehouse', '<?= $warehouse_id; ?>');
        $('#qawarehouse').select2('readonly', true);
        <?php } ?>

        <?php if ($Owner || $Admin) { ?>
        if (!localStorage.getItem('qadate')) {
            $("#qadate").datetimepicker({
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
        }
        $(document).on('change', '#qadate', function (e) {
            localStorage.setItem('qadate', $(this).val());
        });
        if (qadate = localStorage.getItem('qadate')) {
            $('#qadate').val(qadate);
        }
        <?php } ?>
               

      //$("#add_item").click(function(){  
        $("#add_item").autocomplete({
            source: '<?= site_url('products/qa_suggestions/'); ?>'+ $('#wp_id').val() ,
            minLength: 1,
            autoFocus: false,
            delay: 250,
            response: function (event, ui) {
                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    bootbox.alert('<?= lang('no_match_found') ?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).removeClass('ui-autocomplete-loading');
                    $(this).val('');
                }
                else if (ui.content.length == 1 && ui.content[0].id != 0) {
                    ui.item = ui.content[0];
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close');
                    $(this).removeClass('ui-autocomplete-loading');
                }
                else if (ui.content.length == 1 && ui.content[0].id == 0) {
                    bootbox.alert('<?= lang('no_match_found') ?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).removeClass('ui-autocomplete-loading');
                    $(this).val('');
                }
            },
            select: function (event, ui) {
                event.preventDefault();
                    if (ui.item.id !== 0) {
                    var row = add_adjustment_item(ui.item);
                    if (row)
                        $(this).val('');
                } else {
                    bootbox.alert('<?= lang('no_match_found') ?>');
                }
            }
        });
    //});
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
        
        function product_get_list(){
            $.ajax({
               type:'ajax',
               dataType:'json',
               url:'<?= site_url('products/product_list/') ?>'+arguments[0],             
               async:false,
               success:function(result){
             
                   var htmlset ='<table id="qaTable2" class="table  qaTable2 items table-striped table-bordered table-condensed table-hover dataTable">';
                  htmlset+='<thead>';
                    htmlset+='<tr>';
                        htmlset+='<th style="min-width:30px; width: 30px; text-align: center;">';
                            htmlset+='<input class="checkbox checkth input-xs" type="checkbox" name="check"/>';
                        htmlset+='</th>';
                        htmlset+='<th><?= lang("product_name") . " (" . lang("product_code") . ")"; ?></th>';
                        htmlset+='<th><?= lang('Stock'); ?> <span id="title_warehouse" style="text-transform: uppercase;"></span></th>';
                        htmlset+='<th><?= lang("variant"); ?></th>';
                        htmlset+='<th><?= lang("type"); ?></th>';
                        htmlset+='<th><?= lang("quantity"); ?></th>';
                        <?php if ($Settings->product_serial) { ?>
                       	 htmlset+='<th><?= lang("serial_no"); ?></th>';    
                         <?php } ?>                      
                    htmlset+='</tr>';      
                htmlset+='</thead>';
                htmlset+='<tbody>' ;
                   if(result!=''){
					   //console.log(result);
                       var i=0,k=0;
                       for(i=0;i<result.length;i++ ){
                            var pass_variant,quantity;
							console.log(result[i].variant);
                            if(Object.keys(result[i].variant).length != 0){ 
                                pass_variant='<select name="variant[]"  id="poption_'+result[i].item.product_id+'" disabled="true" class="form-control select  input-xs" onchange="return getVariantDetails(this.value, '+result[i].item.product_id+');">';
								
                                for(k=0;k<Object.keys(result[i].variant).length;k++ ){
                                    pass_variant +='<option value="'+result[i].variant[k].id+'" >'+result[i].variant[k].name+'</option>';
                                    quantity =result[i].variant[0].quantity;
                                }   
                                pass_variant+='</select>'  
                            }else{
                               quantity =result[i].item.quantity
                               pass_variant = 'N/A'; 
                            }
                                htmlset+='<tr id="row_'+result[i].item.product_id+'">';
                                htmlset+='<td ><input class="checkbox multi-select input-xs" type="checkbox" onclick="myfunction('+result[i].item.product_id+')" value="'+result[i].item.product_id+'" name="check" id="check_box_'+result[i].item.product_id+'" /></td>';
                                htmlset+='<td ><label  for="check_box_'+result[i].item.product_id+'" style="font-weight: normal !important;">'+result[i].item.name+'('+result[i].item.code+') <input name="product_id[]" disabled="true" id="product_id_'+result[i].item.product_id+'"  type="hidden" class="rid allcheck" value="'+result[i].item.product_id+'"></label></td>';
                                htmlset+='<td class="text-center" id="ShowQty_'+result[i].item.product_id+'">'+ formatDecimal(quantity)+'</td>';
                                htmlset+='<td>'+pass_variant+'</td>';
                                htmlset+='<td><select name="type[]"  disabled="true" id="type_'+result[i].item.product_id+'" class="form-control select allcheck "><option value=""> Select </option><option value="subtraction" selected>Subtraction</option><option value="addition" >Addition</option></select> </td>';
                               
                                htmlset+='<td><input  style="width:80px;" class="form-control text-center rquantity  allcheck " disabled="true"  tabindex="2" name="quantity[]" type="number" value="0" data-id="'+result[i].item.product_id+'" data-item="31" id="quantity_'+result[i].item.product_id+'" onclick="this.select();"></td>';
                                <?php if ($Settings->product_serial) { ?>
                                    htmlset+='<td><input style="width:120px;" class="form-control input-sm rserial allcheck" id="serial_'+result[i].item.product_id+'"" name="serial[]"  disabled="false" type="text"  value=""></td>';
                                <?php } ?>    
                                htmlset+='</tr>';
                       }
                      
                   }else{
                        htmlset+='<tr>';
                             htmlset+='<td colspan="7" class="text-center"> Product Not Found</td>';
                        htmlset+='</tr>';
                    }
                   htmlset+='</tbody>';  
                htmlset+='</table>'; 
                    $('#show_data ').html(htmlset);
                    $('.qaTable2').DataTable({
                        "destroy": true,
                    });
                   // $('#qaTable2 tbody').html(htmlset);
//                    $('#qaTable2').DataTable({ 
//                      "destroy": true, //use for reinitialize datatable
//                   });
                },error:function(){
                    console.log('error');
                }
                
            });
        }
        
      
        
       
    });
    function myfunction(get){
        if($('#check_box_'+get).prop("checked")==true){
          
           $('#product_id_'+get).attr('disabled', false);
            $('#poption_'+get).attr('disabled', false);
           $('#quantity_'+get).attr('disabled', false);
           $('#serial_'+get).attr('disabled', false);
           $('#type_'+get).attr('disabled', false);

        }else{
            $('#poption_'+get).attr('disabled', true);
            $('#product_id_'+get).attr('disabled', true);
            $('#quantity_'+get).attr('disabled', true);
            $('#serial_'+get).attr('disabled', true);
             $('#type_'+get).attr('disabled', true);
        }
    }
    
   
   
    
</script>
<style>
    .select {
        width: 100% !important;
    }
</style>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('add_adjustment'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?php echo lang('enter_info'); ?></p>
                <?php
                $attrib = array('data-toggle' => 'validator', 'role' => 'form');
                echo form_open_multipart("products/add_adjustment", $attrib);
                ?>
                <div class="row">
                    <div class="col-lg-12">
                        <?php if ($Owner || $Admin) { ?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?= lang("date", "qadate"); ?>
                                    <?php echo form_input('date', (isset($_POST['date']) ? $_POST['date'] : ""), 'class="form-control input-tip datetime" id="qadate" required="required"'); ?>
                                </div>
                            </div>
                        <?php } ?>

                        <div class="col-md-3">
                            <div class="form-group">
                                <?= lang("reference_no", "qaref"); ?>
                                <?php echo form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : ''), 'class="form-control input-tip" id="qaref"'); ?>
                            </div>
                        </div>
                        <?= form_hidden('count_id', $count_id); ?>
                        <input type="hidden" id="wp_id" value="" />
                        <?php //if ($Owner || $Admin || !$this->session->userdata('warehouse_id')) { ?>
                            <div class="col-md-3">
                                <div class="form-group">
                                    <?= lang("warehouse", "qawarehouse"); ?>
                                    <?php
                                    $permisions_werehouse = explode(",", $this->session->userdata('warehouse_id'));
                                    $wh[''] = '';
                                    foreach ($warehouses as $warehouse) {
                                       if($Owner || $Admin  ){
                                           $wh[$warehouse->id] = $warehouse->name;
                                       }else if(in_array($warehouse->id,$permisions_werehouse)){
                                               $wh[$warehouse->id] = $warehouse->name;
                                       }   
                                    }
                                    echo form_dropdown('warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : ($warehouse_id ? $warehouse_id :$Settings->default_warehouse)), 'id="qawarehouse" class="form-control input-tip select" data-placeholder="' . lang("select") . ' ' . lang("warehouse") . '" required="required" '.($warehouse_id ? 'readonly' : '').' style="width:100%;"');
                                    ?>
                                </div>
                            </div>
                            <?php /* } else {
                                $warehouse_input = array(
                                    'type' => 'hidden',
                                    'name' => 'warehouse',
                                    'id' => 'qawarehouse',
                                    'value' => $this->session->userdata('warehouse_id'),
                                    );

                                echo form_input($warehouse_input);
                            }*/ ?>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?= lang("Display Product", "display_product") ?>
                               <?php  
                                        $list_product =array('search_product'=>'Search Product','warehouse_product' =>'Warehouse Product');
                                       
                                        echo form_dropdown('product_list', $list_product,$list_product['warehouse_product'] , 'id="display_product" class="form-control input-tip select" data-placeholder="' . lang("select") . ' ' . lang("warehouse") . '" required="required" '.($warehouse_id ? 'readonly' : '').' style="width:100%;"');
                                ?>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="form-group">
                                <?= lang("document", "document") ?>
                                <input id="document" type="file" data-browse-label="<?= lang('browse'); ?>" name="document" data-show-upload="false"
                                       data-show-preview="false" class="form-control file">
                            </div>
                        </div>

                        <div class="clearfix"></div>
                        <div id="product_list">
                            <!--<h5 class='text-center' id="title_warehouse" style="text-transform: uppercase;font-weight: bold;"></h5>-->
                            <div class="col-md-12">
                                <label class="table-label"><?= lang("products"); ?> *</label>
                                <div class="controls table-controls" id="show_data">
                                    <table class="table  table-striped table-bordered table-condensed table-hover">
                                        <thead>
                                        <tr>
                                            <th><?= lang("product_name") . " (" . lang("product_code") . ")"; ?></th>
                                            <th class="col-md-1"><?= lang("Stock"); ?></th>
                                            <th class="col-md-2"><?= lang("variant"); ?></th>
                                            <th class="col-md-2"><?= lang("type"); ?></th>
                                            <th class="col-md-1"><?= lang("quantity"); ?></th>
                                            <?php
                                            if ($Settings->product_serial) {
                                                echo '<th class="col-md-3">' . lang("serial_no") . '</th>';
                                            }
                                            ?>
                                            <th style="max-width: 30px !important; text-align: center;">
                                                <i class="fa fa-trash-o" style="opacity:0.5; filter:alpha(opacity=50);"></i>
                                            </th>
                                        </tr>
                                        </thead>
                                       
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
                                            <?php echo form_input('add_item', '', 'class="form-control input-lg" id="add_item" placeholder="' . lang("add_product_to_order") . '"'); ?>
                                        </div>
                                    </div>
                                    <div class="clearfix"></div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="control-group table-group">
                                <label class="table-label"><?= lang("products"); ?> *</label>

                                <div class="controls table-controls">
                                    <table id="qaTable" class="table items table-striped table-bordered table-condensed table-hover">
                                        <thead>
                                        <tr>
                                            <th><?= lang("product_name") . " (" . lang("product_code") . ")"; ?></th>
                                            <th class="col-md-1"><?= lang("Stock"); ?></th>
                                            <th class="col-md-2"><?= lang("variant"); ?></th>
                                            <th class="col-md-2"><?= lang("type"); ?></th>
                                            <th class="col-md-1"><?= lang("quantity"); ?></th>
                                            <?php
                                            if ($Settings->product_serial) {
                                                echo '<th class="col-md-3">' . lang("serial_no") . '</th>';
                                            }
                                            ?>
                                            <th style="max-width: 30px !important; text-align: center;">
                                                <i class="fa fa-trash-o" style="opacity:0.5; filter:alpha(opacity=50);"></i>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody></tbody>
                                        <tfoot></tfoot>
                                    </table>
                                </div>
                            </div>
                            </div>
                        </div>
                        <div class="clearfix"></div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <?= lang("note", "qanote"); ?>
                                    <?php echo form_textarea('note', (isset($_POST['note']) ? $_POST['note'] : ""), 'class="form-control" id="qanote" style="margin-top: 10px; height: 100px;"'); ?>
                                </div>
                            </div>
                            <div class="clearfix"></div>

                        <div class="col-md-12">
                            <div
                                class="fprom-group"><?php echo form_submit('add_adjustment', lang("submit"), 'id="add_adjustment" class="btn btn-primary" style="padding: 6px 15px; margin:15px 0;"'); ?>
                                <button type="button" class="btn btn-danger" id="reset"><?= lang('reset') ?></div>
                        </div>
                    </div>
                </div>
                <?php echo form_close(); ?>

            </div>

        </div>
    </div>
</div>
  <script>
  $(document).ready(function() {
    /* $('#qaTable2').DataTable({
         "destroy": true,
     });*/

} );
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
 </script>