<div class="section-heading">
    <i class="fa fa-paper-plane" aria-hidden="true"></i> <?= lang('Application Message'); ?>
    <ul id="myTab2" class="nav nav-tabs appmsg_tab">
        <li class="active" id="single-appmsg-3" ><a href="#single-appmsg" class="tab-grey">Send Single Message</a></li>
        <li class="" id="group-appmsg-3" ><a href="#group-appmsg" class="tab-grey">Send Group Message</a></li>
    </ul>
</div>
<div class="row"><div class="col-md-12 " style="display: hidden" id="appmsg-loader"></div></div>
<div class="row">
    <div class="tab-content col-sm-12">
        <div id="single-appmsg" class="tab-pane fade in active">
            <?php
                $attrib = array(  'role' => 'form', 'name' => "appmsg-single", id=>"appmsg-single");
                echo form_open_multipart("", $attrib)
                ?>
            <div class="row">
                <div class="col-lg-7">
                    <?= lang("List *", "product_details") ?>
                    <select id="customers_app_msg" multiple="multiple"></select>
                    <input type="hidden" value="" name="hiddencust_appmsg" id="hiddencust_appmsg">
                    <div class="form-group all"> 
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group all">
                                    <?= lang("Subject *", "subject") ?>
                                    <?= form_input('subject', '', 'class="form-control" id="subject" '); ?>
                                </div>
                                <div class="form-group">
                                    <?= lang("Unicode ", "product_details") ?>
                                    <?php $yn = array('1' => lang('yes'), '0' => lang('no')); ?>   
                                    <?= form_dropdown('unicode', $yn, '', 'class="form-control" id="unicode"  '); ?>                           

                                </div>

                            </div>
                            <div class="col-lg-6">

                                <div class="form-group">
                                    <?= lang("Message Type ", "product_details") ?>
                                    <?php $yn1 = array('promotional' => lang('Promotional'), 'transactional' => lang('Transactional')); ?>   
                                    <?= form_dropdown('msgtype', $yn1, '', 'class="form-control" id="msgtype"  '); ?>                           

                                </div>


                                <div class="form-group">
                                    <?= lang("Image ", "product_details") ?>
                                    <input id="image" type="file" data-browse-label="<?= lang('browse'); ?>" name="attachment" data-show-upload="false"
                                           data-show-preview="false" accept="image/*" class="form-control file">
                                       <input type="hidden" name="attachment_template" class="attachment_template"> 
                                    <div class="attachment_wrapper"></div>           
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label for="product_details">Message *</label>
                                <textarea name="appmsg_body" cols="40" rows="7" class="form-control skip appmsg_body" id="appmsg_body"></textarea>
                            </div>

                        </div>
                    </div>


                </div>
                <div class="col-lg-5">
                    <label for="product_details">  Available Template</label>
                      <div class="appmsg_template  message-template well">
                        <?php echo $this->sma->TemplateList($templateList, 3); ?>
                    </div>
                </div>
                <div class="col-lg-12">
                    <br>
                    <?php echo form_submit('send_application_msg', lang('Send Application Message'), 'class="msg-section btn btn-primary"'); ?>
                    
                </div> 
            </div>
              <?= form_close(); ?>   
        </div>
        <div id="group-appmsg" class="tab-pane fade in">
             <?php
                $attrib = array(  'role' => 'form', 'name' => "appmsg-group", id=>"appmsg-group");
                echo form_open_multipart("", $attrib)
                ?>
            
             <input type="hidden" name="group_id"  id="appmsg_group_id"  class="group_id">
             
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
                            <div class="col-lg-6">
                                <div class="form-group all">
                                    <?= lang("Subject *", "subject") ?>
                                    <?= form_input('subject', '', 'class="form-control" id="subject" '); ?>
                                </div>
                                <div class="form-group">
                                    <?= lang("Unicode ", "product_details") ?>
                                    <?php $yn = array('1' => lang('yes'), '0' => lang('no')); ?>   
                                    <?= form_dropdown('unicode', $yn, '', 'class="form-control" id="unicode"  '); ?>                           

                                </div>

                            </div>
                            <div class="col-lg-6">

                                <div class="form-group">
                                    <?= lang("Message Type ", "product_details") ?>
                                    <?php $yn1 = array('promotional' => lang('Promotional'), 'transactional' => lang('Transactional')); ?>   
                                    <?= form_dropdown('msgtype', $yn1, '', 'class="form-control" id="msgtype"  '); ?>                           

                                </div>


                                <div class="form-group">
                                    <?= lang("Image ", "product_details") ?>
                                    <input id="image" type="file" data-browse-label="<?= lang('browse'); ?>" name="attachment" data-show-upload="false"
                                           data-show-preview="false" accept="image/*" class="form-control file">
                                     <input type="hidden" name="attachment_template" class="attachment_template"> 
                                    <div class="attachment_wrapper"></div>      
                                           
                                </div>
                            </div>
                            <div class="col-lg-12">
                                <label for="product_details">Message *</label>
                                <textarea name="appmsg_body" cols="40" rows="7" class="form-control skip appmsg_body" id="appmsg_body"></textarea>
                            </div>

                        </div>

                    </div>


                </div>
                <div class="col-lg-5">
                    <label for="product_details">  Available Template</label>
                     <div class="appmsg_template  message-template well">
                        <?php echo $this->sma->TemplateList($templateList, 3); ?>
                    </div>
                </div>
                <div class="col-lg-12">
                    <br>
                    <?php echo form_submit('send_application_msg', lang('Send Application Message'), 'class="msg-section btn btn-primary group_submit_button"'); ?>
                    
                </div> 
            </div>
            <?= form_close(); ?>   
        </div>
    </div>
</div>

<script>
    $(document).ready(function () { 
        /*---------------------------- Set Group Id  in  hidden  ----------------------------*/ 
        $(document).on('click', '#group-appmsg a.group_button', function () {
            gid2 = $(this).attr('data-value'); 
            if(gid2 > 0){
               $('#group-appmsg #appmsg_group_id').val(gid2);
            }
        });
          
          
        $(document).on('click', '#appmsg-single .btn-file', function () {
             $('#appmsg-single .attachment_template').val('');
             $('#appmsg-single .attachment_wrapper').html('');
        });
            
         $(document).on('click', '#group-appmsg .btn-file', function () {
             $('#group-appmsg .attachment_template').val('');
             $('#group-appmsg .attachment_wrapper').html('');
        });
            
        /*----------------------------App msg 1----------------------------*/
        
        $("#appmsg-single").submit(function (event) {
            event.preventDefault();
            var cust_list = $.trim($('#appmsg-single .select2-container').select2('val')); 
            var appmsg_content =  $('#appmsg-single #appmsg_body').val();
          
            var appmsg_subject = $.trim($('#appmsg-single #subject').val()); 
            
            if(cust_list==''){
               alert('Please select customer '); 
               return false; 
            }
            $('#hiddencust_appmsg').val(cust_list);
            
            if(appmsg_subject==''){
               alert('Please enter subject'); 
               return false; 
            }
            
            if(appmsg_content==''){
               alert('Message content is empty'); 
               return false; 
            }
            $('#appmsg-loader').css('display','block');
            $('#appmsg-loader').html('<div class="alert alert-info"><i class="fa fa-refresh  fa-spin fa-fw"></i><span class="">Loading...</span></div>');
                 
            $.ajax({
                url: "<?= site_url('smsdashboard/addSingleAppmsg') ?>", // Url to which the request is send
                type: "POST",             // Type of request to be send, called as method
                data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false
                dataType: "json",
                success: function (data)   // A function to be called if request succeeds
                {
                   if(data['error']){
                     $('#appmsg-loader').html('<div class="alert alert-danger"><button data-dismiss="alert" class="close" type="button">×</button> '+data['error']+' </div>');   
                   }
                   else if(data['success']){
                      $('#appmsg-single #customers_app_msg').select2("val", "");
                     $('#appmsg-single .attachment_template').val('');
	             $('#appmsg-single .attachment_wrapper').html('');
	             
                    $('#appmsg-single')[0].reset();
                    $('#appmsg-loader').html('<div class="alert alert-success"><button data-dismiss="alert" class="close" type="button">×</button> '+data['success']+' </div>');   
                   }
                }
            });
             
            
        });
          
        /*----------------------------App msg 2----------------------------*/
        
        $("#appmsg-group").submit(function (event) {
            event.preventDefault();
             var group_count = $.trim($('#appmsg-group .group_count').val()); 
            if(group_count==0){
                alert('No contact group available  '); 
                return false;     
            }
            var group_id2       = $.trim($('#appmsg-group #appmsg_group_id').val()); 
            var appmsg_content  =  $('#appmsg-group #appmsg_body').val();
            var appmsg_subject  = $.trim($('#appmsg-group #subject').val()); 
            
            if(group_id2==''){
               alert('Please select contact group '); 
               return false; 
            }
            if(appmsg_subject==''){
               alert('Please enter subject'); 
               return false; 
            }
            
            if(appmsg_content==''  ){
               alert('Message content is empty'); 
               return false; 
            }
            $('#appmsg-loader').css('display','block');
            $('#appmsg-loader').html('<div class="alert alert-success"><i class="fa fa-refresh  fa-spin fa-fw"></i><span class="">Loading...</span></div>');
            $.ajax({
                url: "<?= site_url('smsdashboard/addGroupAppmsg') ?>", // Url to which the request is send
                type: "POST",             // Type of request to be send, called as method
                data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
                contentType: false, // The content type used when sending data to the server.
                cache: false, // To unable request pages to be cached
                processData: false, // To send DOMDocument or non processed data file it is set to false
                dataType: "json",
                success: function (data)   // A function to be called if request succeeds
                {
                    if(data['error']){
                     $('#appmsg-loader').html('<div class="alert alert-danger"><button data-dismiss="alert" class="close" type="button">×</button> '+data['error']+' </div>');   
                   }
                   else if(data['success']){
                    $('#appmsg-group .group_id').val('');
                    $('#appmsg-group a.group_button').removeClass('active');
                    
                    
                    $('#appmsg-group .attachment_template').val('');
	             $('#appmsg-group .attachment_wrapper').html('');
                    
                    $('#appmsg-group')[0].reset();
                    $('#appmsg-loader').html('<div class="alert alert-success"><button data-dismiss="alert" class="close" type="button">×</button> '+data['success']+' </div>');   
                   }
                }
            });
             
            
        });
    });
</script>
