<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="box">
    <style>
        .select2-drop select2-drop-multi{width: 211px!important;}
        .select2-container{width: 100%!important;}
        h1.upload-image {            
            text-align: center!important;
        }
        
        h1.upload-image i {
            font-size: 50px !important;            
            cursor: pointer!important;           
        }
    </style>
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('Eshop_Shippings'); ?></h2>
    </div>
    <div class="box-content">
        <?php
        $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'name' => "eshop_shippings", 'id'=>"eshop_shippings");
        echo form_open_multipart("eshop_admin/shipping_methods", $attrib, ['action'=>'save_shipping'])
        ?>
        <div class="row">
            <div class="col-md-4"><label>Method</label></div>
            <div class="col-md-4"><label>Price (Rs.)</label></div>
            
        </div>
        
        <?php
                
        if(is_array($shippings)):
            foreach ($shippings as $key => $shiping) {
        ?>
        <hr/>
        <div class="row">
            <div class="col-md-4"> 
                <i class="fa fa-shopping-bag text-info"></i> <?=$shiping['name']?><br/><small class="text-primary"><?=$shiping['code']?></small>
            </div>
            <div class="col-md-2">         
                <?= form_input('price['.$shiping['id'].']', (isset($_POST['price']) && !empty($_POST['price']) ? $_POST['price'] : ($shiping ? number_format($shiping['price'],0) : '')), 'class="form-control" maxlength="4"'); ?>
            </div>
            
        </div>
        <?php 
        }//end foreach
        endif;  ?>
        <div class="row">
            <div class="form-group text-center">
                <?php echo form_submit('send', $this->lang->line("Submit"), 'id="send" class="btn btn-primary"  style="margin-top:20px;"'); ?> 
            </div>
            <?= form_close(); ?>
        </div>
</div>
</div>
 
 