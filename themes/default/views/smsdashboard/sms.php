<style>
.sms_preview{display:none;font-size: 12px;
    color: initial;
    border: 1px solid #ccc;
    padding: 1%;
    overflow-y: scroll;}
 .sms_preview_d{display:inline}   
    
</style>
<?php  $DisSMSLink = (int)$sms_limit < 1  ? '<br><a href="https://simplypos.in/login.php" target="_blank" style="font-size:11px;color:#ff0000">Please Login on merchant panel & Rechagre Now</a>' :'';  ?>
<div class="section-heading">
    <i class="fa fa-newspaper-o" aria-hidden="true"></i> <?= lang('SMS'); ?>
    <ul id="myTab2" class="nav nav-tabs sms_tab">
        <li class="" id="single-sms-1"><a href="#single-sms" id="s1" class="tab-grey">Send Single SMS</a></li>
        <li class="" id="group-sms-1"><a href="#group-sms" id="s2" class="tab-grey">Send Group SMS</a></li>
    </ul>
</div>
<div class="row"><div class="col-md-12 "  id="sms-loader"></div></div>
<div class="row">
    <div class="tab-content col-sm-12">
        <div id="single-sms" class="tab-pane fade in">
            <?php
                $attrib = array(  'role' => 'form', 'name' => "sms-single", id=>"sms-single");
                echo form_open_multipart("", $attrib)
                ?>
                <input type="hidden" name="hiddencust_sms"  id="hiddencust_sms" >
                <div class="row">
                    <div class="col-lg-7">
                       
                        <div class="form-group all"> 
                        <div class="col-lg-12">
                         <?= lang("List *", "product_details") ?>
                       	 <select id="customers_sms" multiple="multiple"  ></select> 
                        </div>
                       	 <div class="col-lg-12">
                            <?= lang("Message *", "product_details") ?>
                            <textarea name="sms_body" cols="40" rows="7" class="form-control skip sms_body" id="sms_body1"></textarea>
                          </div>
                          <div class="col-lg-4">    
                            <?php echo form_submit('send_sms', lang('Send SMS'), 'class="btn btn-primary '.$sms_class.' "'.$sms_disable_attr); ?>
                          </div>  
                          <div class="col-lg-8">    
                            <div class="sms_note blue"> <span id="max_sms_chars1" class="max_sms_chars"></span> </div> 
                            <div class="sms_note blue"> <span class="sms_preview"><div class="sms_preview_d">##message##</div></span> </div> 
                            <div class="sms_note blue">(Note : Available SMS limit <span id="sms_count_limit"><?php print((int) $sms_limit) ?></span><?php echo $DisSMSLink ?>)</div>
                          </div>  
                        </div>
                    </div>
                    <div class="col-lg-5">
                        <label for="product_details">  Available Template</label>
                        <div class="sms_template message-template well">
                            <?php echo $this->sma->TemplateList($templateList, 1); ?>
                        </div>
                    </div>
                </div>
             <?= form_close(); ?>   
        </div>
        <div id="group-sms" class="tab-pane fade in">
            <?php
                $attrib = array(  'role' => 'form', 'name' => "sms-group", id=>"sms-group");
                echo form_open_multipart("", $attrib)
                ?>
            <input type="hidden" name="group_id"  id="sms_group_id"  class="group_id">
            <input type="hidden" name="group_count"  class="group_count" value="<?php echo $GroupCount?>">
            <div class="row">
                <div class="col-lg-7">
                    <div class="form-group all"> 
                    
	                 <div class="col-lg-12">
	                    <label for="product_details">  Group</label>
	                    <ul class="contact-group">
	                        <div class="row"> <?php  echo $GroupGrid  ?></div>
	                    </ul>
	                 </div>     

                 	<div class="col-lg-12">
	                   <?= lang("Message *", "product_details") ?>
	                    <textarea name="sms_body" cols="40" rows="7" class="form-control skip sms_body" id="sms_body2"></textarea>
	                 </div>     
	                 
	                 <div class="col-lg-12">
		                  <div class="col-lg-4">    
	                            <?php echo form_submit('send_sms', lang('Send SMS'), 'class="btn btn-primary '.$sms_class.' "'.$sms_disable_attr); ?>
	                          </div>  
	                          <div class="col-lg-8">    
	                            <div class="sms_note blue"> <span id="max_sms_chars2" class="max_sms_chars"></span> </div> 
	                            <div class="sms_note blue"> <span class="sms_preview"><div class="sms_preview_d">##message##</div></span> </div> 
	                            <div class="sms_note blue">(Note : Available SMS limit <span id="sms_count_limit"><?php print((int) $sms_limit) ?></span><?php echo $DisSMSLink ?>)</div>
	                          </div>  
	                 </div> 
                        
                       
                        
                    </div>


                </div>
                <div class="col-lg-5">
                    <label for="product_details">  Available Template</label>
                    <div class="sms_template message-template well">
                        <?php echo $this->sma->TemplateList($templateList, 1); ?>
                    </div>
                </div>
            </div>
            <?= form_close(); ?>   
        </div>
    </div>
</div>
<script>
    var smsLength = <?php echo $sms_text_limit?>;
    $(document).ready(function () {
        
     
        /*---------------------------- Set Group Id  in  hidden  ----------------------------*/ 
        $('.sms_body').keyup(function (event) {
         $('#'+smsId+' .max_sms_chars').css("display","block");
            var length = $(this).val().length;
           
     
             var smsId = getSmsTabIndex();  
              $('#'+smsId+' .max_sms_chars').text('SMS count : '+Math.ceil(length/smsLength )+' ');
              
              $('#'+smsId+' .sms_preview').css('display','block');
              $('#'+smsId+' .sms_preview_d').text($(this).val());
              if($(this).val()==''){
              	 $('#'+smsId+' .sms_preview').css('display','none');
              }
        });
        
        /*---------------------------- Set Group Id  in  hidden  ----------------------------*/ 
        $(document).on('click', '#group-sms a.group_button', function () {
            gid = $(this).attr('data-value'); 
            if(gid > 0){
               $('#group-sms #sms_group_id').val(gid);
            }
        });
        
        /*----------------------------SMS FROM SUBMIT 1  ----------------------------*/
        $("#sms-single").submit(function (event) {
            var cust_list = $.trim($('#sms-single .select2-container').select2('val')); 
            var sms_content = $.trim($('#sms-single .sms_body').val()); 
            if(cust_list==''){
               alert('Please select customer '); 
               return false; 
            }
            if(sms_content==''){
               alert('SMS content is  empty '); 
               return false; 
            }
            $('#hiddencust_sms').val(cust_list); 
            $('#sms-loader').html('<div class="alert alert-success"><i class="fa fa-refresh  fa-spin fa-fw"></i><span class="">Loading...</span></div>');
            
             setTimeout(function(){ console.log('loading') }, 1000);
            $.ajax({
                type: "POST",
                async: false,
                url: "<?= site_url('smsdashboard/addSingleSMS') ?>",
                data: $("#sms-single").serialize(),
                dataType: "json",
                success: function (data) {
                   if(data['error']){
                     $('#sms-loader').html('<div class="alert alert-danger"><button data-dismiss="alert" class="close" type="button">×</button> '+data['error']+' </div>');   
                   }
                   else if(data['success']){
                    $('#sms-single #customers_sms').select2("val", "");
                    $('#sms-single .sms_preview').css('display','none');
             	    $('#sms-single .sms_preview_d').html('');
             	    $('#sms-single #sms_count_limit').text(data['sms_count']);
                     $('#sms-single')[0].reset();  
                     $('#sms-loader').html('<div class="alert alert-success"><button data-dismiss="alert" class="close" type="button">×</button> '+data['success']+' </div>');   
                   }
                },
                error: function () {
                }
            });
            event.preventDefault();
        });
        /*----------------------------SMS FROM SUBMIT Group  ----------------------------*/
        $("#sms-group").submit(function (event) {
            event.preventDefault();
            var group_count = $.trim($('#sms-group .group_count').val()); 
            if(group_count==0){
                alert('No contact group available  '); 
                return false;     
            }
            
            var group_id = $.trim($('#sms-group #sms_group_id').val()); 
            var sms_content = $.trim($('#sms-group .sms_body').val()); 
            if(group_id==''){
               alert('Please select contact group '); 
               return false; 
            }
            if(sms_content==''){
               alert('SMS content is empty '); 
               return false; 
            } 
            
            $('#sms-loader').css('display','block');
            $('#sms-loader').html('<div class="alert alert-info"><i class="fa fa-refresh  fa-spin fa-fw"></i><span class="">Loading...</span></div>');
            $.ajax({
                type: "POST",
                async: false,
                url: "<?= site_url('smsdashboard/addGroupSMS') ?>",
                data: $("#sms-group").serialize(),
                dataType: "json",
                success: function (data) {
                   if(data['error']){
                     $('#sms-loader').html('<div class="alert alert-danger"><button data-dismiss="alert" class="close" type="button">×</button> '+data['error']+' </div>');   
                   }
                   else if(data['success']){
                    $('#sms-group .group_id').val('');
                    $('#sms-group a.group_button').removeClass('active');   
                    
                     $('#sms-group .sms_preview').css('display','none');
             	    $('#sms-group .sms_preview_d').html('');
             	     $('#sms-group #sms_count_limit').text(data['sms_count']);
                    $('#sms-group')[0].reset();
                    $('#sms-loader').html('<div class="alert alert-success"><button data-dismiss="alert" class="close" type="button">×</button> '+data['success']+' </div>');   
                   }
                },
                error: function () {
                }
            });
        });
         /*----------------------------SMS FROM SUBMIT  ----------------------------*/
    });
</script>    