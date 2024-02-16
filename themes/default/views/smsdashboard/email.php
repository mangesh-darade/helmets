<div class="section-heading">
    <i class="fa fa-envelope-o" aria-hidden="true"></i> <?= lang('Email'); ?>
    <ul id="myTab2" class="nav nav-tabs email_tab">
        <li class="active" id="single-email-2" ><a href="#single-email" class="tab-grey">Send Single Email</a></li>
        <li class="" id="group-email-2" ><a href="#group-email" class="tab-grey">Send Group Email</a></li>
    </ul>
</div>
<div class="row"><div class="col-md-12 " style="display: hidden" id="email-loader"></div></div>
<div class="row">
    <div class="tab-content col-sm-12">
        <div id="single-email" class="tab-pane fade in active">
            <?php
                $attrib = array(  'role' => 'form', 'name' => "email-single", id=>"email-single");
                echo form_open_multipart("", $attrib)
                ?>
                <input type="hidden" name="hiddencust_email"  id="hiddencust_email" >
            <div class="row">
                <div class="col-lg-7">
                    <?= lang("List *", "product_details") ?>
                    <select id="customers_email" multiple="multiple" ></select>
                    <input type="hidden" value="" name="hiddencust" id="hiddencust">
                    <div class="form-group all"> 
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group all">
                                    <?= lang("Subject *", "subject") ?>
                                    <?= form_input('subject', '', 'class="form-control" id="subject" '); ?>
                                </div> 
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <?= lang("Attachment ", "product_details") ?>
                                    <input id="image" type="file" data-browse-label="<?= lang('browse'); ?>" name="attachment" id="attachment-single" data-show-upload="false"
                                           data-show-preview="false" accept="image/*" class="form-control file">
                                           
                                    <input type="hidden" name="attachment_template" class="attachment_template"> 
                                    <div class="attachment_wrapper"></div>      
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label for="product_details">Message *</label>
                                <textarea name="email_body" cols="40" rows="7" class="form-control email_body" id="notification_note"></textarea>
                            </div>

                        </div>
                    </div>


                </div>
                <div class="col-lg-5">
                    <label for="product_details">  Available Template</label>
                    <div class="email_template message-template well">
                        <?php echo $this->sma->TemplateList($templateList, 2); ?>
                    </div>
                </div>
                <div class="col-lg-12">
                    <br>
                    <?php echo form_submit('send_email', lang('Send Email'), 'class="msg-section btn btn-primary"'); ?>
                    <button type="button" class="btn btn-primary  btn_email_preview" style="margin-left:15px;">Preview</button>
                </div>  
            </div>
                 <?= form_close(); ?>   
        </div>
        <div id="group-email" class="tab-pane fade in">
            <?php
                $attrib = array(  'role' => 'form', 'name' => "email-group", id=>"email-group");
                echo form_open_multipart("", $attrib)
                ?>
            <input type="hidden" name="group_id"  id="email_group_id"  class="group_id">
            <input type="hidden" name="group_count"  class="group_count" value="<?php echo $GroupCount?>">
            <div class="row">
                <div class="col-lg-7">
                    <label for="product_details">  Group</label>
                    <ul class="contact-group">
                        <div class="row">
                            <?php
                            echo $GroupGrid
                            ?>
                        </div>
                    </ul>
                    <div class="form-group all"> 
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="form-group all">
                                    <?= lang("Subject *", "subject") ?>
                                    <?= form_input('subject', '', 'class="form-control" id="subject" '); ?>
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <div class="form-group">
                                    <?= lang("Attachment ", "product_details") ?>
                                   <input id="image" type="file" data-browse-label="<?= lang('browse'); ?>" name="attachment" id="attachment-group" data-show-upload="false"
                                           data-show-preview="false" accept="image/*" class="form-control file">
                                           
                                    <input type="hidden" name="attachment_template" class="attachment_template" value=""> 
                                    <div class="attachment_wrapper"></div>      
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label for="product_details">Message *</label>
                                <textarea name="email_body" cols="40" rows="7" class="form-control email_body" id="notification_note"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5">
                    <label for="product_details">  Available Template</label>
                    <div class="email_template message-template well">
                        <?php echo $this->sma->TemplateList($templateList, 2); ?>
                    </div>
                </div>
                <div class="col-lg-12">
                    <br>
                    <?php echo form_submit('send_email', lang('Send Email'), 'class="msg-section btn btn-primary group_submit_button"'); ?>
                    <button type="button" class="btn btn-primary  btn_email_preview" style="margin-left:15px;">Preview</button>
                </div> 
            </div>
            <?= form_close(); ?>   
        </div>
    </div>
</div>
<div class="modal fade" id="emailPreview" role="dialog">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"></h4>
            </div>
            <div class="modal-body">
                <p>This is a large modal.</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#emailPreview').on('hidden.bs.modal', function () {
            $('#emailPreview .modal-body').html('');
        });
        
            
       $(document).on('click', '#single-email .btn-file', function () {
             $('#single-email .attachment_template').val('');
             $('#single-email .attachment_wrapper').html('');
        });
            
         $(document).on('click', '#group-email .btn-file', function () {
             $('#group-email .attachment_template').val('');
             $('#group-email .attachment_wrapper').html('');
        });
               
        /*---------------------------- Set Group Id  in  hidden  ----------------------------*/ 
        $(document).on('click', '#group-email a.group_button', function () {
            gid1 = $(this).attr('data-value'); 
            if(gid1 > 0){
               $('#group-email #email_group_id').val(gid1);
            }
        });
          
        /*----------------------------Email----------------------------*/
        
        $("#email-single").submit(function (event) {
            event.preventDefault();
            var cust_list = $.trim($('#email-single .select2-container').select2('val')); 
            var email_content =  $('#email-single .email_body').redactor('get');
            var email_subject = $.trim($('#email-single #subject').val()); 
            
            if(cust_list==''){
               alert('Please select customer '); 
               return false; 
            }
            $('#hiddencust_email').val(cust_list);
            
            if(email_subject==''){
               alert('Please enter email subject'); 
               return false; 
            }
            
            if(email_content=='' || email_content=='<p></p>'){
               alert('Email content is empty'); 
               return false; 
            }
            
            $('#email-loader').css('display','block');
            $('#email-loader').html('<div class="alert alert-info"><i class="fa fa-refresh  fa-spin fa-fw"></i><span class="">Loading...</span></div>');
                 
            $.ajax({
                url: "<?= site_url('smsdashboard/addSingleEmail') ?>", // Url to which the request is send
                type: "POST",             // Type of request to be send, called as method
                data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false
                dataType: "json",
                success: function (data)   // A function to be called if request succeeds
                {
                   if(data['error']){
                     $('#email-loader').html('<div class="alert alert-danger"><button data-dismiss="alert" class="close" type="button">×</button> '+data['error']+' </div>');   
                   }
                   else if(data['success']){
                    $('#email-single #customers_email').select2("val", "");
                    $('#email-single .email_body').redactor('set', '');
                     $('#single-email .attachment_template').val('');
	             $('#single-email .attachment_wrapper').html('');
                    $('#email-single')[0].reset();
                    $('#email-loader').html('<div class="alert alert-success"><button data-dismiss="alert" class="close" type="button">×</button> '+data['success']+' </div>');   
                   }
                }
            });
             
            
        });
          
        /*----------------------------Email----------------------------*/
        
        $("#email-group").submit(function (event) {
            event.preventDefault();
            var group_count = $.trim($('#email-group .group_count').val()); 
            if(group_count==0){
                alert('No Contact Group available '); 
                return false;     
            }
    
            var group_id1 = $.trim($('#email-group #email_group_id').val()); 
            var email_content =  $('#email-group .email_body').redactor('get');
            var email_subject = $.trim($('#email-group #subject').val()); 
            
            if(group_id1==''){
               alert('Please select contact group '); 
               return false; 
            }
            if(email_subject==''){
               alert('Please enter email subject'); 
               return false; 
            }
            
            if(email_content=='' || email_content=='<p></p>'){
               alert('Email content is empty'); 
               return false; 
            }
            
           $('#email-loader').css('display','block');
           $('#email-loader').html('<div class="alert alert-info"><i class="fa fa-refresh  fa-spin fa-fw"></i><span class="">Loading...</span></div>');
            
            $.ajax({
                url: "<?= site_url('smsdashboard/addGroupEmail') ?>", // Url to which the request is send
                type: "POST",             // Type of request to be send, called as method
                data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false
                dataType: "json",
                success: function (data)   // A function to be called if request succeeds
                {
                  if(data['error']){
                     $('#email-loader').html('<div class="alert alert-danger"><button data-dismiss="alert" class="close" type="button">×</button> '+data['error']+' </div>');   
                   }
                   else if(data['success']){
                    $('#email-group .group_id').val('');
                    $('#email-group a.group_button').removeClass('active');
                    $('#email-group .email_body').redactor('set', '');
                     $('#email-group .attachment_template').val('');
	             $('#email-group .attachment_wrapper').html('');
                    $('#email-group')[0].reset();
                    $('#email-loader').html('<div class="alert alert-success"><button data-dismiss="alert" class="close" type="button">×</button> '+data['success']+' </div>');   
                   }
                }
            });
             
            
        });
    });
</script>