<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$f_field = isset($printer_option->f_column) && !empty($printer_option->f_column) ? $printer_option->f_column : NULL;
$l_field = isset($printer_option->l_column) && !empty($printer_option->l_column) ? $printer_option->l_column : NULL;

$column_id_str = isset($printer_option->column_id_str) && !empty($printer_option->column_id_str) ? $printer_option->column_id_str : NULL;
$column_name_str = isset($printer_option->column_name_str) && !empty($printer_option->column_name_str) ? $printer_option->column_name_str : NULL;

$column_id_arr = explode(',', $column_id_str);
$column_name_arr = explode(',', $column_name_str);
global $column_arr;
$column_arr = array_combine($column_id_arr, $column_name_arr);

$other_field_arr = array();
$last_field_arr = $first_field_arr = '';
foreach ($fields_option as $key => $fData) {
    if ($fData->id == $f_field):
        $first_field_arr = $fData;
    elseif ($fData->id == $l_field):
        $last_field_arr = $fData;
    else:
        $other_field_arr[] = $fData;
    endif;
}

function fieldName($id) {
    global $column_arr;
    return isset($column_arr[$id]) && !empty($column_arr[$id]) ? $column_arr[$id] : '';
}

$other_field_db_arr = array();
foreach ($column_id_arr as $_value) {
    foreach ($other_field_arr as $_key1 => $_value1) {
        if ($_value == $_value1->id):
            $other_field_db_arr[] = $_value1;
            unset($other_field_arr[$_key1]);
        endif;
    }
}
$result = array_merge((array) $other_field_db_arr, (array) $other_field_arr);
 $printer_arr = array('07'=>'07pt','08'=>'08pt','09'=>'09pt','10'=>'10pt','11'=>'11pt','12'=>'12pt','13'=>'13pt','14'=>'14pt','15'=>'15pt',)
?>

<?= form_open('', 'id="action-form"') ?>

<style>
    #sortable span{
        background-repeat: no-repeat;
        background-position: center;
        display: inline-block;
        float: left;
        cursor: move;
    }
    #sortable span.disabled{
        color: #b4b3b3;
        cursor: none;
    }
    #sortable .sortable_row { 
        minheight: 35px;
        background: #fdfcfc; 
        color: #333333;
        vertical-align: middle;
    }
    .f_desc {
        display: inline;
    }
    .box .form-group {
    overflow-x: initial;
}
</style>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-folder-open"></i><?= lang('Configure Bill Table Option For "' . $printer_option->name . ' "'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row form-group all">
            <div class="col-lg-12">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Details</legend>
                     <div class="row form-group all">
                        <div class=""> 
                            <div class="col-sm-1"> </div> 
                            <div class="col-sm-2"><b>Name</b> </div>
                            <div class="col-sm-4"><input type="text" name="name" value="<?php echo !empty($_POST['name'])?$_POST['name']:$printer_option->name?>" class="form-control tip" required="required"/> </div> 
                        </div>
                    </div>  
                    <div class="row form-group all">
                        <div class=""> 
                            <div class="col-sm-1"> </div> 
                            <div class="col-sm-2"><b>Width</b> </div>
                            <div class="col-sm-4"><input type="text" name="width"  value="<?php echo !empty($_POST['width'])?$_POST['width']:$printer_option->width?>" class="form-control tip" required="required"/> </div> 
                        </div>
                    </div> 
                </fieldset>	
            </div>
        </div> 
        <div class="row form-group all">
            <div class="">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Field Configuration</legend>
                    <div class="row form-group all">
                        <div class=""> 
                            <div class="col-sm-2"> </div>
                            <span  class="col-sm-2"></span> 
                            <div class="col-sm-4"><b>Field Name (Description)</b> </div>
                            <div class="col-sm-4"><b>Custom Title </b><br>(if this field balank ,Field Name mark as  title)  </div> 
                        </div>
                    </div>  
                    <!-- First Field -->
                    <?php
                    if (is_object($first_field_arr) && !empty($first_field_arr->id)):
                        $i = 1;
                        ?>
                        <div class="row form-group all">
                            <div class="form-group  "> 
                                <div class="col-sm-2 form-group  "> 
                                    <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                    <input type="hidden"  value="<?php echo $first_field_arr->id ?>" name="val_<?php echo $first_field_arr->id ?>">
                                </div>
                                <span  class="col-sm-2 form-group  "></span> 
                                <div class="col-sm-4 form-group  "> <?= lang($first_field_arr->name) ?> <?php if (!empty($first_field_arr->desc)): ?>(<div class="f_desc"><?php echo $first_field_arr->desc ?></div>)<?php endif; ?>
                                </div>
                                <div class="col-sm-4 form-group  "> 
                                    <input type="text" class="o_name form-control" name="o_name_<?php echo $first_field_arr->id ?>" value="<?php echo fieldName($first_field_arr->id) ?>" placeholder="-" >
                                </div> 
                            </div>
                        </div>  
                        <?php
                    endif;
                    ?>
                    <div  id="sortable" >
                        <?php
                        $c_field_seq = array();
                        foreach ($result as $resOption) {
                            $i++;
                            $checkOption = in_array($resOption->id, $column_id_arr) ? 'checked="checked"' : '';
                            $c_field_seq[] = $resOption->id;
                            ?>
                            <div class="row form-group  all sortable_row" id="<?php echo $resOption->id ?>">
                                <div class="form-group  "> 
                                    <div class="col-sm-2 form-group "> 
                                        <input type="hidden"  value="<?php echo $resOption->id ?>" name="val_<?php echo $resOption->id ?>">
                                        <input type="checkbox" <?php echo $checkOption ?>  value="<?php echo $resOption->id ?>" name="opt_<?php echo $resOption->id ?>">
                                    </div>
                                    <div class="col-sm-2 form-group "> 
                                        <span ><i class="fa fa-bars" aria-hidden="true"></i></span>
                                    </div>
                                    <div class="col-sm-4 form-group "> <?= lang($resOption->name) ?> <?php if (!empty($resOption->desc)): ?>(<div class="f_desc"><?php echo $resOption->desc ?></div>)<?php endif; ?></div>
                                    <div class="col-sm-4 form-group "> 
                                        <input type="text" class="o_name form-control" name="o_name_<?php echo $resOption->id ?>" value="<?php echo fieldName($resOption->id) ?>" placeholder="-" >
                                    </div> 
                                </div>
                            </div> 
                            <?php
                        }
                        ?>
                    </div>
                    <!-- Last Field -->
                    <?php
                    if (is_object($last_field_arr) && !empty($last_field_arr->id)):
                        $i = 1;
                        ?>
                        <div class="row form-group all">
                            <div class="form-group  "> 
                                <div class="col-sm-2 form-group  "> 
                                    <i class="fa fa-check-square-o" aria-hidden="true"></i>
                                    <input type="hidden"  value="<?php echo $last_field_arr->id ?>" name="val_<?php echo $last_field_arr->id ?>">
                                </div>

                                <div class="col-sm-2 form-group  "> 
                                    <span ></span>
                                </div>
                                <div class="col-sm-4 form-group  "> <?= lang($last_field_arr->name) ?><?php if (!empty($last_field_arr->desc)): ?>
                                        (<div class="f_desc"><?php echo $last_field_arr->desc ?></div>)<?php endif; ?></div>
                                <div class="col-sm-4 form-group  "> 
                                    <input type="text" class="o_name form-control" name="o_name_<?php echo $last_field_arr->id ?>" value="<?php echo fieldName($last_field_arr->id) ?>"  placeholder="-" >
                                </div> 
                            </div>
                        </div> 

                        <?php
                    endif;
                    ?>
                    
                </fieldset>	
            </div>
        </div>
        <div class="row form-group all">
            <div class="col-lg-12">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Other Option </legend>
                    <div class="row ">
                        <div class="col-sm-6 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo!empty($printer_option->crop_product_name) ? 'Checked' : ''; ?>  value="1" name="crop_product_name">
                                <b> Truncate product's name </b></div>
                        </div>
                        <div class="col-sm-6 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo!empty($printer_option->show_invoice_logo) ? 'Checked' : ''; ?>  value="1" name="show_invoice_logo">
                                <b> Show Company Logo</b>
                            </div>
                        </div>
                    </div>  
                    <div class="row form-group all">
                        <div class="col-sm-6 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo !empty($printer_option->show_sr_no) ? 'Checked' : ''; ?>  value="1" name="show_sr_no">
                                <b> Show Item Sr. no</b></div>
                        </div>
                        <div class="col-sm-6 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo !empty($printer_option->show_tin) ? 'Checked' : ''; ?>  value="1" name="show_tin">
                                <b> Show Customer TIN / GSTIN</b></div>
                        </div>
                    </div>  
                     <div class="row form-group all">
                        <div class="col-sm-6 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                
                                <b>Font Size : </b>
                           <?php     echo form_dropdown('font_size', $printer_arr, $printer_option->font_size, 'class="form-control" id="font_size"   style="width:30%;"');?>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo !empty($printer_option->show_customer_info) ? 'Checked' : ''; ?>  value="1" name="show_customer_info">
                                <b> Show Customer Info</b></div>
                        </div>
                    </div>  
                    <div class="row form-group all">
                        <div class="col-sm-6 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo!empty($printer_option->tax_classification_view) ? 'Checked' : ''; ?>  value="1" name="tax_classification_view">
                                <b> <?= lang("tax_classification_view"); ?></b></div>
                        </div>
                        <div class="col-sm-6 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo!empty($printer_option->show_order_cf) ? 'Checked' : ''; ?>  value="1" name="show_order_cf">
                                <b> <?= lang("show_order_cf"); ?></b>
                            </div>
                        </div>
                    </div> 
                    <div class="row form-group all">
                        <div class="col-sm-6 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo!empty($printer_option->show_award_point) ? 'Checked' : ''; ?>  value="1" name="show_award_point">
                                <b> <?= lang("show_award_point"); ?></b>
                            </div>
                        </div>
                        
                        <div class="col-sm-6 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo!empty($printer_option->show_barcode_qrcode) ? 'Checked' : ''; ?>  value="1" name="show_barcode_qrcode">
                                <b> <?= lang("show_barcode_qrcode"); ?></b>
                            </div>
                        </div>
                    </div> 
                    <div class="row form-group all">
                        <div class="col-sm-6 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo!empty($printer_option->show_saving_amount) ? 'Checked' : ''; ?>  value="1" name="show_saving_amount">
                                <b style="text-transform: capitalize;"> <?= lang("show_saving_amount"); ?> <img src="<?= base_url('themes/default/assets/images/new.gif')?>" height="30px" alt="new"></b>
                            </div>
                        </div>
                        <div class="col-sm-6 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo!empty($printer_option->show_kot_tokan) ? 'Checked' : ''; ?>  value="1" name="show_kot_tokan">
                                <b style="text-transform: capitalize;"> <?= lang("Show KOT Tokan"); ?> <img src="<?= base_url('themes/default/assets/images/new.gif')?>" height="30px" alt="new"></b>
                            </div>
                        </div>
                    </div> 
                    <div class="row form-group all">
                        <div class="col-sm-6 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo!empty($printer_option->show_offer_description) ? 'Checked' : ''; ?>  value="1" name="show_offer_description">
                                <b style="text-transform: capitalize;"> <?= lang("show_offer_description"); ?> <img src="<?= base_url('themes/default/assets/images/new.gif')?>" height="30px" alt="new"></b>
                            </div>
                        </div>                        
                    </div>                     
                </fieldset>	
            </div>
        </div>
        <div class="row form-group all">
            <div class="col-lg-12">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border">Product Description </legend>
                    <div class="row form-group all">
                        <div class="col-sm-4 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo!empty($printer_option->append_product_code_in_name) ? 'Checked' : ''; ?>  value="1" name="append_product_code_in_name">
                                <b> <?= lang("Show_product_code_in_product_name"); ?></b>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo!empty($printer_option->append_hsn_code_in_name) ? 'Checked' : ''; ?>  value="1" name="append_hsn_code_in_name">
                                <b> <?= lang("Show_hsn_code_in_product_name"); ?></b>
                            </div>
                        </div> 
                        <div class="col-sm-4 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo!empty($printer_option->append_note_in_name) ? 'Checked' : ''; ?>  value="1" name="append_note_in_name">
                                <b><?= lang("Show_item_note_in_product_name"); ?></b>
                            </div>
                        </div> 
                    </div>
                    <div class="row form-group all">
                        <div class="col-sm-4 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo!empty($printer_option->show_combo_products_list) ? 'Checked' : ''; ?>  value="1" name="show_combo_products_list">
                                <b> <?= lang("Show_combo_products_list"); ?></b>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo!empty($printer_option->show_product_image) ? 'Checked' : ''; ?>  value="1" name="show_product_image">
                                <b> <?= lang("Show_product_image"); ?></b>
                            </div>
                        </div>
                        <div class="col-sm-4 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo!empty($printer_option->append_taxval_in_productname) ? 'Checked' : ''; ?>  value="1" name="append_taxval_in_productname">
                                <b> <?= lang("append_taxval_in_productname"); ?></b>
                            </div>
                        </div>
                        
                         <div class="col-sm-4 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">
                                <input type="checkbox" <?php echo!empty($printer_option->append_article_code_in_name) ? 'Checked' : ''; ?>  value="1" name="append_article_code_in_name">
                                <b> <?= lang("Show Product Article Number"); ?> <img src="<?= base_url('themes/default/assets/images/new.gif')?>" height="30px" alt="new"></b>
                            </div>
                        </div>
                       
                        
                    </div>
                    <div class="row form-group all">
                        
                        <div class="col-sm-6 col-xs-12 form-group"> 
                            <div class="col-sm-12 col-xs-12">                                
                                <b>Product image size : </b>
                           <?php    
                           $thumb_sizr_arr = ['width:30px;height:30px;'=>'30px','width:40px;height:40px;'=>'40px','width:50px;height:50px;'=>'50px','width:60px;height:60px;'=>'60px'];
                           echo form_dropdown('product_image_size', $thumb_sizr_arr, $printer_option->product_image_size, 'class="form-control" id="product_image_size" style="width:30%; "');?>
                            </div>
                        </div>
                        
                    </div>  
                </fieldset>	
            </div>
        </div>
        <div class="form-group">
            <input type="hidden" name="id" value="<?php echo $printer_option->id ?>"  />
            <input type="hidden" id="option_sequence" name="option_sequence" value="<?php echo implode(',', $c_field_seq) ?>"  />
            <?= form_submit('submit', 'Save Configure Option', 'id="action-form-submit" class="btn btn-primary"') ?>
        </div> 
    </div>    
</div>   

<?= form_close() ?>
<script>
    $(function () {
        $('#sortable').sortable({
            axis: 'y',
            opacity: 0.9,
            handle: 'span',
            update: function (event, ui) {
                var list_sortable = $(this).sortable('toArray').toString();
                $('#option_sequence').val(list_sortable);
            }
        }); // fin sortable
    });
</script>    