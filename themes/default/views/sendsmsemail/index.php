<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="box">
    <style>
        .select2-drop select2-drop-multi{width: 211px!important;}
        .select2-container{width: 100%!important;}
        .disabled_sms{ cursor: no-drop;}
    </style>
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('Customer_Email'); ?></h2>
    </div>
    <div class="box-content">
        <?php
        $attrib = array(  'role' => 'form', 'name' => "sendsmsemail", id=>"sendsmsemail");
        echo form_open_multipart("sendsmsemail/add", $attrib)
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
                <div class="col-md-6">
                    <div class="form-group all">
                        <?= lang("Sender", "subject") ?>
                        <?php 
                         $email_placeholder = '';
                         if(empty($default_email)){
                         $email_placeholder = 'placeholder="Please provide your email in profile"';
                         }	
                        ?>
                        <?= form_input('sender', $default_email, 'class="form-control" id="sender"  readonly="true" '.$email_placeholder ); ?>
                    </div>
                    <div class="form-group all">
                        <?= lang("Subject *", "subject") ?>
                        <?= form_input('subject', '', 'class="form-control" id="subject" '); ?>
                    </div>

                    <div class="form-group all">
                        <input type="hidden" value="<?php echo base_url('assets/uploads/logos/' . $Settings->logo2) ?>" id="logo" name="logo"/>
                        <?= lang("Message *", "product_details") ?>
                        <?= form_textarea('message', (isset($_POST['message']) ? $_POST['message'] : ($product ? $product->message : '')), 'class="form-control" id="message"'); ?>
                        <span id="html_msg"></span>
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="form-group">
                        <?= lang("Customer List *", "product_details") ?>
                        <select id="customers" multiple="multiple" required="required"></select>
                        <!--<input name="cf" type="checkbox" class="checkbox" id="extras" value="" <?= isset($_POST['cf']) ? 'checked="checked"' : '' ?>/>
                        <label for="extras" class="padding05"><?= lang('Customer_List') ?></label>-->
                        <input type="hidden" value="" name="hiddencust" id="hiddencust">
                    </div>

                    <div class="form-group">
                        <?= lang("Type ", "product_details") ?>     
                        <?= form_checkbox('cmbtype[]', 'email', $checked = FALSE, $extra = 'class="form-control cmbtype_email" id="cmbtype"  '); ?> Email              
                       <?php  $DisSMS = (int)$sms_limit < 1  ? 'disabled style="style="cursor:no-drop""' :''; ?>
                       <?php  $DisSMSClass = (int)$sms_limit < 1  ? '<i class="fa  fa-ban red"></i>' :''; ?> 
                       <?php  $DisSMSLink = (int)$sms_limit < 1  ? '<br><a href="http://simplypos.in/login.php" target="_blank">Please Login on merchant panel & Rechagre Now</a>' :''; ?>
                       
                       
                        <?= form_checkbox('cmbtype[]', 'sms', $checked = FALSE, $extra = 'class="form-control cmbtype_sms  " id="cmbtype"  '.$DisSMS); ?> <?php echo  $DisSMSClass?> Sms              
                        
                        <?= form_checkbox('cmbtype[]', 'push_message', $checked = FALSE, $extra = 'class="form-control cmbtype_push" id="cmbtype"  '); ?> Application Message  
                        <div class="sms_note blue"><br>(Note : Available SMS limit <?php print((int)$sms_limit)?> <?php echo  $DisSMSLink?>)</div>               
                        
                    </div>
                    <div class="form-group">
                        <?= lang("Message Type ", "product_details") ?>
                        <?php $yn1 = array('promotional' => lang('Promotional'), 'transactional' => lang('Transactional')); ?>   
                        <?= form_dropdown('msgtype', $yn1, '', 'class="form-control" id="msgtype"  '); ?>                           

                    </div>
                    <div class="form-group">
                        <?= lang("Unicode ", "product_details") ?>
                        <?php $yn = array('1' => lang('yes'), '0' => lang('no')); ?>   
                        <?= form_dropdown('unicode', $yn, '', 'class="form-control" id="unicode"  '); ?>                           

                    </div>

                    <div class="form-group">
                        <?= lang("Image ", "product_details") ?>
                        <input id="image" type="file" data-browse-label="<?= lang('browse'); ?>" name="image" data-show-upload="false"
                               data-show-preview="false" accept="image/*" class="form-control file">
                    </div>
                </div>
            </div>
            <div>
            	<div class="form-group" style="padding-left: 15px;">
                    <?php echo form_submit('send', $this->lang->line("send"), 'id="send" class="btn btn-primary"'); ?> 
                   
                </div>
            </div>
           

        <?= form_close(); ?>
    </div>
</div>
</div>


<script type="text/javascript">

function validateEmail($email) {
  var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
  return emailReg.test( $email );
}

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
                
                $("#customers option").each(function() {
                        $customer_list=$(this).val(); 

                });
                },
                error: function () {
                     
               }

            });
            $( "#sendsmsemail" ).submit(function( event ) { 
                
                var cust_list = $('.select2-container').select2('val');
                $('#hiddencust').val(cust_list);
                var subject = $('#subject').val();
                 if(subject.trim()==''){
                     alert('Please Enter Subject ');
                      $('#subject').focus();
                    return false;
                    event.preventDefault();
                }
                var email_opt ='';
		$('input[name="cmbtype[]"]:checked').each(function() {
		   if(this.value=='email'){
		   	email_opt =1
		   	  
		   } 
		});
		if(email_opt ==1){
			var sender= $('#sender').val();
	                 if(sender.trim()==''){
	                    alert('Please Enter Sender Email1');
	                     $('#sender').focus();
	                    return false;
	                    event.preventDefault();
	                 }
	                 
		}
		 
               
            }); 
});
</script>
 