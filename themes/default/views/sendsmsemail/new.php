<?php defined('BASEPATH') OR exit('No direct script access allowed');?>
<div class="box">
    <style>
        .select2-drop select2-drop-multi{width: 211px!important;}
        .select2-container{width: 100%!important;}
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
         <div class="col-md-12">
         
            <fieldset class="scheduler-border">
                    <legend class="scheduler-border"><?= lang('Contact') ?></legend>
                    
                       <div class="col-lg-12">
              		   		<?php 
			        $message = isset($_GET['msg']) && !empty($_GET['msg']) && $_GET['msg']=='done'?'Notification Send  successfully':NULL;
			        if ($message) {?>
			            <div class="alert alert-success">
			                <button data-dismiss="alert" class="close" type="button">×</button>
			                <?=!empty($message) ? print_r($message, true) : $message;?>
			            </div>
			        <?php }
			        ?> 
            	     </div>
                     <div class="col-md-12">
	                  <div class="form-group">
		                <?= lang("Customer List *", "product_details") ?>
		                <select id="customers" multiple="multiple" required="required"></select>
		                <!--<input name="cf" type="checkbox" class="checkbox" id="extras" value="" <?= isset($_POST['cf']) ? 'checked="checked"' : '' ?>/>
		                <label for="extras" class="padding05"><?= lang('Customer_List') ?></label>-->
		                <input type="hidden" value="" name="hiddencust" id="hiddencust">
		         </div>
                     </div>
                     
                        <div class="col-md-12">
		            <div class="col-lg-1 col-md-2 col-xs-6">
		                    <a class="bblue white quick-button small" href="">
		                        <i class="fa fa-user"></i>
		 			  <p>Group 1</p>
		                    </a>
		              </div>
		              <div class="col-lg-1 col-md-2 col-xs-6">
		                    <a class="bdarkGreen white quick-button small" href="">
		                        <i class="fa fa-user"></i>
		                        <p>Group 2</p>
		                    </a>
		              </div>
		              <div class="col-lg-1 col-md-2 col-xs-6">
		                    <a class="bpink white quick-button small" href="">
		                         <i class="fa fa-user"></i>
		                        <p>Group 3</p>
		                    </a>
		              </div>
		              <div class="col-lg-1 col-md-2 col-xs-6">
		                    <a class="borange white quick-button small" href="">
		                        <i class="fa fa-user"></i>
		                        <p>Group 4</p>
		                    </a>
		              </div>
		               <div class="col-lg-1 col-md-2 col-xs-6">
		                    <a class="bblue white quick-button small" href="">
		                        <i class="fa fa-user"></i>
		 			  <p>Group 1</p>
		                    </a>
		              </div>
		              <div class="col-lg-1 col-md-2 col-xs-6">
		                    <a class="bdarkGreen white quick-button small" href="">
		                        <i class="fa fa-user"></i>
		                        <p>Group 2</p>
		                    </a>
		              </div>
		              <div class="col-lg-1 col-md-2 col-xs-6">
		                    <a class="bpink white quick-button small" href="">
		                         <i class="fa fa-user"></i>
		                        <p>Group 3</p>
		                    </a>
		              </div>
		              <div class="col-lg-1 col-md-2 col-xs-6">
		                    <a class="borange white quick-button small" href="">
		                        <i class="fa fa-user"></i>
		                        <p>Group 4</p>
		                    </a>
		              </div>
		          </div>
             </fieldset>
		 
          </div> 
       
        </div> 
        
        <div class="row">
            <div class="col-lg-12">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border"><?= lang('SMS') ?></legend>
                     <div class="col-lg-6">
	                    <div class="form-group all"> 
	                        <?= lang("Message *", "product_details") ?>
	                        <textarea name="note" cols="40" rows="7" class="form-control skip" id="sms"></textarea>
	                        <div class="sms_note blue"><span id="max_sms_chars">160</span> characters remaining</div>          
	                    </div>
	                      <div class="sms_note blue"><br>(Note : Available SMS limit <?php print((int)$sms_limit)?>)</div>               
                        
                    </div>
                    
                 </fieldset>    
            </div> 
        </div>  
        
         <div class="row">
            <div class="col-lg-12">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border"><?= lang('Application Message') ?></legend>
                    <div class="col-lg-6">
                    <div class="form-group all">
                        <?= lang("Subject *", "subject") ?>
                        <?= form_input('subject', '', 'class="form-control" id="subject" '); ?>
                    </div>
                    <textarea name="note" cols="40" rows="7" class="form-control skip" id="note"></textarea></div>
                    <div class="col-lg-6">
                    
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
                 </fieldset>    
            </div> 
        </div>  
        
         <div class="row">
            <div class="col-lg-12">
                <fieldset class="scheduler-border">
                    <legend class="scheduler-border"><?= lang('Email') ?></legend>
                    
                   
                    
                    <div class="col-lg-6"> <div class="form-group all">
                        <?= lang("Subject *", "subject") ?>
                        <?= form_input('subject', '', 'class="form-control" id="subject" '); ?>
                    </div> 
                    
                    <textarea name="note" cols="40" rows="50" class="form-control" id="note"></textarea></div>
                    <div class="col-lg-6">
                    
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
                    


	                    <div class="form-group">
	                        <?= lang("Image ", "product_details") ?>
	                        <input id="image" type="file" data-browse-label="<?= lang('browse'); ?>" name="image" data-show-upload="false"
	                               data-show-preview="false" accept="image/*" class="form-control file">
	                    </div>
                    </div>
                 </fieldset>    
            </div> 
        </div>
        
     
          
        <div class="row">
         
            <div>
            	<div class="form-group" style="padding-left: 15px;">
                    <?php echo form_submit('send', $this->lang->line("Send"), 'id="send" class="btn btn-primary"'); ?> 
                   
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
var smsLength = 160;
$('#sms').keyup(function() {
  var length = $(this).val().length;
  
  $('#max_sms_chars').text(smsLength -length);
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
 