<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="box">
    <style>
        .select2-drop select2-drop-multi{width: 211px!important;}
        .select2-container{width: 100%!important;}
    </style>
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('Eshop_Pages'); ?></h2>
    </div>
    <div class="box-content">
        <?php
        $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'name' => "sendsmsemail", id=>"sendsmsemail");
        echo form_open_multipart("eshop_admin/pages", $attrib)
        ?>
        <div class="row">
            <div class="col-lg-12">
                <p class="introtext"><?php echo lang('enter_info'); ?></p>
   		<?php 
	        $message = isset($_GET['msg']) && !empty($_GET['msg']) && $_GET['msg']=='done'?'Notification Send  successfully':NULL;
	        if ($message) {?>
	            <div class="alert alert-success">
	                <button data-dismiss="alert" class="close" type="button">×</button>
	                <?=!empty($message) ? print_r($message, true) : $message;?>
	            </div>
	        <?php }
	        ?> 
                <div class="col-md-12">
                   <div class="form-group all">
                          <?= lang("About US", "product_details") ; 
                        ?>
                        <?= form_textarea('about_us', (isset($_POST['about_us']) && !empty($_POST['about_us']) ? $_POST['about_us'] : ($pages ? $pages->about_us : '')), 'class="form-control" id="message"'); ?>
                        <span id="html_msg"></span>
                    </div>
                    <div class="form-group all">
                         <?= lang("Conatct US", "product_details") ?>
                        <?= form_textarea('contact_us', (isset($_POST['contact_us']) && !empty($_POST['contact_us']) ? $_POST['contact_us'] : ($pages ? $pages->contact_us : '')), 'class="form-control" id="message"'); ?>
                        <span id="html_msg"></span>
                    </div>
                    <div class="form-group all">
                         <?= lang("Terms & conditions", "product_details") ?>
                        <?= form_textarea('terms', (isset($_POST['terms']) && !empty($_POST['terms'])? $_POST['terms'] : ($pages ? $pages->terms : '')), 'class="form-control" id="message"'); ?>
                        <span id="html_msg"></span>
                    </div>
                    <div class="form-group all">
                         <?= lang("Privacy Policy", "product_details") ?>
                        <?= form_textarea('p_policy', (isset($_POST['p_policy']) && !empty($_POST['p_policy']) ? $_POST['p_policy'] : ($pages ? $pages->p_policy : '')), 'class="form-control" id="message"'); ?>
                        <span id="html_msg"></span>
                    </div>
                    <div class="form-group all">
                         <?= lang("FAQ", "product_details") ?>
                        <?= form_textarea('faq', (isset($_POST['faq'])  && !empty($_POST['faq']) ? $_POST['faq'] : ($pages ? $pages->faq : '')), 'class="form-control" id="message"'); ?>
                        <span id="html_msg"></span>
                    </div>
                </div>
            </div>
            <div>
            	<div class="form-group" style="padding-left: 15px;">
                    <?php echo form_submit('send', $this->lang->line("Submit"), 'id="send" class="btn btn-primary"'); ?> 
                </div>
            </div>
        <?= form_close(); ?>
    </div>
</div>
</div>


<script type="text/javascript">
$(document).ready(function() {
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
 