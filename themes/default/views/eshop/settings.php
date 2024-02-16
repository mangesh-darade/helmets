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
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('Eshop_Settings'); ?></h2>
    </div>
    <div class="box-content">
        <?php
        $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'name' => "eshop_settings", id=>"eshop_settings");
        echo form_open_multipart("eshop_admin/settings", $attrib, ['action'=>'save_settings'])
        ?>
        <div class="row">
            <div class="col-lg-12">
                <p class="introtext"><?php echo lang('enter_info'); ?></p>
   		 
                <div class="row" style="padding:10px; background-color: #f7f3e8;">
                <?php
                
                $check_1 = $check_2 = $check_3 = '';
                if(!empty($eshop_settings->default_banner)){
                    $default_banner = json_decode($eshop_settings->default_banner , true); 
                    if(is_array($default_banner)){
                        foreach($default_banner as $key => $value){
                            $check_key = 'check_'.$key;
                            $$check_key = ' checked="checked" ';
                        }
                    }
                }
                for($d=1; $d<=3; $d++){
                ?>
                    <div class="col-md-4">
                        <div class="form-group all">
                            <?php 
                             $checkkey = 'check_'.$d;
                                if(@getimagesize($eshop_upload . "banner_$d.jpg")){
                             
                                    echo '<label><i class="fa fa-image text-success"></i> Default Banner Image '.$d.' </label>';
                             
                                    echo img(array('src'=>$eshop_upload. "banner_$d.jpg", 'class'=>'img img-responsive img-rounded','alt'=>"banner_$d.jpg"));
                        ?>        
                                    <label class="col-sm-12" style="margin-top:10px; padding: 0;"><input type="checkbox"  name="default_banner[<?=$d?>]" value="<?="banner_$d.jpg"?>" <?=$$checkkey?> /> Show in banner</label>    
                        <?php          
                                } 
                            ?>
                            
                        </div>                   
                    </div>
                <?php }  ?>
                </div>
                <div class="row" style="padding:10px; background-color: #ebf2e1;">
                <?php
                    for($b=1; $b<=3; $b++){
                ?>
                    <div class="col-md-4">
                        <div class="form-group all">
                            <?php 
                                $bl = "banner_image_".$b;
                                if(!empty($eshop_settings->$bl) && @getimagesize($eshop_settings->$bl)){
                             
                                echo '<label><i class="fa fa-image text-success"></i> Custom Banner Image '.$b.' <span><a class="text-danger" href="'.base_url('eshop_admin/deleteimage/'.$bl).'"><i class="fa fa-remove"></i> Delete</a></span></label>';
                             
                                   echo img(array('src'=>$eshop_settings->$bl, 'class'=>'img img-responsive img-rounded','alt'=>$eshop_settings->$bl));
                                } else {
                             
                                echo '<label><i class="fa fa-image text-success"></i> Custom Banner Image '.$b.'<br/><small class="text-primary">(Minimum image size: 1600 x 500 pixcel)</small></label>';
                                    
                                    echo '<h1 class="upload-image"><label for="'.$bl.'"><i class="fa fa-cloud-upload"></i><br/><small id="'.$bl.'_selectedfile">Upload Image</small></label></h1>';
                                    echo form_upload("banner_image[$b]", (isset($_POST[$bl]) && !empty($_POST[$bl]) ? $_POST[$bl] : ($eshop_settings ? $eshop_settings->$bl : '')), 'class="form-control cloud_upload" style="display:none;" id="'.$bl.'"');
                                }   
                                ?>
                            <span id="html_msg"></span>
                        </div>                   
                    </div>
                    <?php } ?>
                </div>
                <div class="row" style="padding:10px; background-color: #f7f3e8;">
                <?php
                    for($h=1; $h<=3; $h++){
                ?>
                    <div class="col-md-4">
                        <div class="form-group all">
                            <?php 
                                $hm = "homepage_image_".$h;                                
                                $hmtx = "homepage_image_text_".$h;
                                $txtmaxlength = ['1'=>30, '2'=>50, '3'=>40]; 
                                if(!empty($eshop_settings->$hm) && @getimagesize($eshop_settings->$hm)){
                             
                                echo '<label><i class="fa fa-image text-danger"></i> Homepage Image '.$h.' <span><a class="text-danger" href="'.base_url('eshop_admin/deleteimage/'.$hm).'"><i class="fa fa-remove"></i> Delete</a></span></label>';
                             
                                   echo img(array('src'=>$eshop_settings->$hm, 'class'=>'img img-responsive img-rounded hmp-img','alt'=>$eshop_settings->$hm, 'style'=>'max-height:200px; width:100%;'));
                                } else {
                             
                                echo '<label><i class="fa fa-image text-danger"></i> Homepage Image '.$h.'<br/><small class="text-primary">(Minimum image size: 350 x 230 pixcel)</small></label>';
                                    
                                    echo '<h1 class="upload-image"><label for="'.$hm.'"><i class="fa fa-cloud-upload"></i><br/><small id="'.$hm.'_selectedfile">Upload Image</small></label></h1>';
                                    echo form_upload("homepage_image[$h]", (isset($_POST[$hm]) && !empty($_POST[$hm]) ? $_POST[$hm] : ($eshop_settings ? $eshop_settings->$hm : '')), 'class="form-control cloud_upload" style="display:none;" id="'.$hm.'"');
                                }   
                                ?>
<!--                            <div>
                                <input type="text" name="< ?= $hmtx?>" class="form-control" maxlength="< ?=$txtmaxlength[$h]?>" placeholder="Homepage Image < ?=$h?> Text" value="< ?= (isset($_POST[$hmtx]) && !empty($_POST[$hmtx])) ? $_POST[$hmtx] : (!empty($eshop_settings) ? $eshop_settings->$hmtx : '');?>" />
                                < ?php
                                if($h==1) {
                                    $hmtx_1_2 = "homepage_image_text_1_2";
                                ?>   
                                <br/><input type="text" class="form-control" maxlength="10" placeholder="Homepage Image < ?=$h?> Text 2" name="< ?= $hmtx_1_2?>" value="< ?= (isset($_POST[$hmtx_1_2]) && !empty($_POST[$hmtx_1_2])) ? $_POST[$hmtx_1_2] : (!empty($eshop_settings) ? $eshop_settings->$hmtx_1_2 : '');?>" />
                                < ?php
                                }
                                if($h ==2){
                                ?>
                                <br/><label class="col-sm-12" style="margin-top:10px; padding: 0;"><input type="checkbox"  name="show_homepage_images_text" value="1" < ?= $eshop_settings->show_homepage_images_text ? 'checked="checked"' : ''?> /> Show All Homepage Image Text</label>
                                < ?php
                                }
                                ?>
                            </div>-->
                        </div>                   
                    </div>
                    <?php } ?>
                </div>
                 
                <div class="row" style="padding:10px; background-color: #ebf2e1;">                    
                    <div class="col-md-4" style="padding-right: 20px;">
                        <div class="form-group all">
                            <label><i class="fa fa-list text-danger"></i> Show/Hide Top Products</label>
                            <?php
                                $display_top_products = 'selected_'.  $eshop_settings->display_top_products;
                                $$display_top_products = ' selected="selected" ';
                            ?>
                            <select name="display_top_products" class="form-control">
                                <option value="0" <?=$selected_0?> >Hide Top Products</option> 
                                <option value="4" <?=$selected_4?> >4 Products</option> 
                                <option value="8" <?=$selected_8?> >8 Products</option> 
                                <option value="12" <?=$selected_12?> >12 Products</option>
                                <option value="20" <?=$selected_20?> >20 Products</option> 
                            </select>
                        </div> 
                        <div class="form-group all" style="margin-top:50px;">
                            <label><i class="fa fa-list text-danger"></i> Show/Hide Hot Offers</label>
                            <?php
                            $offercheck = 'offffer_' . $eshop_settings->display_hot_offers;
                            $$offercheck = ' checked="checked" ';
                            ?>
                            <div class="col-sm-12">
                                <label class="col-sm-6"><input type="radio" name="display_hot_offers" value="1" <?=$offffer_1?> /> Show Offers </label>
                                <label class="col-sm-6"><input type="radio" name="display_hot_offers" value="0" <?=$offffer_0?> /> Hide Offers </label>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group all" >                            
                            <?php 
                                if(!empty($eshop_settings->hot_offers_banner) && @getimagesize($eshop_settings->hot_offers_banner)){                             
                                     echo '<label><i class="fa fa-image text-warning"></i> Hot Offers Banner  <span><a class="text-danger" href="'.base_url('eshop_admin/deleteimage/hot_offers_banner').'"><i class="fa fa-remove"></i> Delete</a></span></label>';
                                    
                                     echo img(array('src'=>$eshop_settings->hot_offers_banner, 'class'=>'img img-responsive img-rounded','alt'=>$eshop_settings->hot_offers_banner));
                                } else {
                             
                                    echo '<label><i class="fa fa-image text-warning"></i> Hot Offers Banner  </label>';
                                    echo '<h1 class="upload-image"><label for="hot_offers_banner"><i class="fa fa-cloud-upload"></i><br/><small id="hot_offers_banner_selectedfile">Upload Image</small></label></h1>';
                                    echo form_upload('hot_offers_banner', (isset($_POST['hot_offers_banner']) && !empty($_POST['hot_offers_banner']) ? $_POST['hot_offers_banner'] : ($eshop_settings ? $eshop_settings->hot_offers_banner : '')), 'class="form-control cloud_upload" style="display:none;" id="hot_offers_banner"');
                                }   
                            ?>                            
                        </div>                        
                        
                    </div>
                    <div class="col-md-4">
                        <div class="form-group all">                            
                            <?php 
                                if(!empty($eshop_settings->eshop_logo) && @getimagesize($eshop_settings->eshop_logo)){                             
                                     echo '<label><i class="fa fa-image text-warning"></i> Eshop Logo <span><a class="text-danger" href="'.base_url('eshop_admin/deleteimage/eshop_logo').'"><i class="fa fa-remove"></i> Delete</a></span></label>';
                                    
                                     echo '<div>'. img(array('src'=>$eshop_settings->eshop_logo, 'class'=>'img img-responsive img-rounded', 'style'=>"margin:auto; padding:50px;", 'alt'=>$eshop_settings->eshop_logo, 'style'=>'height:100px;')) . '</div>';
                                } else {
                             
                                    echo '<label><i class="fa fa-image text-warning"></i> Eshop Logo <br/><small class="text-primary">(Maximum image size: 100 x 100 pixcel)</small></label>';
                                    echo '<h1 class="upload-image"><label for="eshop_logo"><i class="fa fa-cloud-upload"></i><br/><small id="eshop_logo_selectedfile">Upload Logo</small></label></h1>';
                                    echo form_upload('eshop_logo', (isset($_POST['eshop_logo']) && !empty($_POST['eshop_logo']) ? $_POST['eshop_logo'] : ($eshop_settings ? $eshop_settings->eshop_logo : '')), 'class="form-control cloud_upload" style="display:none;" id="eshop_logo"');
                                }   
                            ?>                            
                        </div>                   
                    </div>
                </div>
                <div class="row" style="padding:10px; background-color: #f7f3e8;">
                    <div class="col-md-4">
                        <div class="form-group all">
                            <label><i class="fa fa-shopping-bag text-info"></i> Eshop Name<br/><small class="text-primary">Name will display on eshop logo</small></label>
                            <?= form_input('shop_name', (isset($_POST['shop_name']) && !empty($_POST['shop_name']) ? $_POST['shop_name'] : ($eshop_settings ? $eshop_settings->shop_name : '')), 'class="form-control" id="shop_name" maxlength="25"'); ?>
                            <span id="html_msg"></span>
                        </div>                   
                    </div>
                    <div class="col-md-4">
                        <div class="form-group all">
                            <label><i class="fa fa-phone-square text-info"></i> Phone  <br/><small class="text-primary">(Can enter multiple numbers separated by comma)</small></label>
                            <?= form_input('shop_phone', (isset($_POST['shop_phone']) && !empty($_POST['shop_phone']) ? $_POST['shop_phone'] : ($eshop_settings ? $eshop_settings->shop_phone : '')), 'class="form-control" id="shop_phone" maxlength="35"'); ?>
                            <span id="html_msg"></span>
                        </div>                   
                    </div>
                    <div class="col-md-4">
                        <div class="form-group all">
                            <label><i class="fa fa-mail-forward text-info"></i> Email<br/><small class="text-primary">Enter email if want to display on eshop customers</small></label>
                            <?= form_input('shop_email', (isset($_POST['shop_email']) && !empty($_POST['shop_email']) ? $_POST['shop_email'] : ($eshop_settings ? $eshop_settings->shop_email : '')), 'class="form-control" id="shop_email" maxlength="40"'); ?>
                            
                        </div>                   
                    </div>
                </div>
                <div class="row" style="padding:10px; background-color: #ebf2e1;">
                    <div class="col-md-4">
                        <div class="form-group all">
                            <label><i class="fa fa-facebook-official text-primary"></i> Facebook Page Link</label>
                            <?= form_input('facebook_link', (isset($_POST['facebook_link']) && !empty($_POST['facebook_link']) ? $_POST['facebook_link'] : ($eshop_settings ? $eshop_settings->facebook_link : '')), 'class="form-control" id="facebook_link" maxlength="100"'); ?>
                            <span id="html_msg"></span>
                        </div>                   
                    </div>
                    <div class="col-md-4">
                        <div class="form-group all">
                            <label><i class="fa fa-google-plus-official text-danger"></i> Google Profile Link</label>
                            <?= form_input('google_link', (isset($_POST['google_link']) && !empty($_POST['google_link']) ? $_POST['google_link'] : ($eshop_settings ? $eshop_settings->google_link : '')), 'class="form-control" id="google_link" maxlength="100"'); ?>
                            <span id="html_msg"></span>
                        </div>                   
                    </div>
                    <div class="col-md-4">
                        <div class="form-group all">
                            <label><i class="fa fa-twitter-square text-warning"></i> Twitter Profile Link</label>
                            <?= form_input('twitter_link', (isset($_POST['twitter_link']) && !empty($_POST['twitter_link']) ? $_POST['twitter_link'] : ($eshop_settings ? $eshop_settings->twitter_link : '')), 'class="form-control" id="twitter_link" maxlength="100"'); ?>
                            <span id="html_msg"></span>
                        </div>                   
                    </div>
                </div>
            </div>
            <div style="padding:10px; background-color: #f7f3e8;">
            	<div class="form-group text-center">
                    <?php echo form_submit('send', $this->lang->line("Submit"), 'id="send" class="btn btn-primary"  style="margin-top:20px;"'); ?> 
                </div>
            </div>
        <?= form_close(); ?>
    </div>
</div>
</div>


<script type="text/javascript">
$(document).ready(function() {
    
    $('.cloud_upload').on('change', function(){
      var ID = this.id;
      
      $('#'+ID + '_selectedfile').html('Image: '+this.value);
    });
       
    
            $.ajax({
                type: "get",
                async: false,
                url: "<?= site_url('customers/getCustomers') ?>",
                                    data:"data",
                dataType: "json",
                success: function (data) { 
                    $('#customers').select2("destroy").empty().select2({closeOnSelect:false});
                    $.each(data.aaData, function () {
                    //console.log(data.aaData);
                        $("<option />", {value:this['4']+':'+this['3'], text: this['4']+'/'+this['3']+''}).appendTo($('#customers'));
                   });
                $('#customers').select2('val');
                $("#send").click(function() {
                var cust_list = $('.select2-container').select2('val');

                 $('#hiddencust').val(cust_list);
                });
                $("#customers option").each(function() {
                        $customer_list=$(this).val(); 

                });
                },
                error: function () {
                    bootbox.alert('<?= lang('ajax_error') ?>');
               }

            });
            $( "#sendsmsemail" ).submit(function( event ) { 
                var subject = $('#subject').val();
                if(subject.trim()==''){
                    bootbox.alert('Please Enter Subject ');
                    $('#pcc_year_1').parent().addClass('has-error');
                    $('#pcc_year_1').focus();
                    return false;
                    event.preventDefault();
                }
            }); 
});
</script>
 