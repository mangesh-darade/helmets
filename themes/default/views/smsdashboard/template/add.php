<?php defined('BASEPATH') OR exit('No direct script access allowed');

$sms_text_limit = $this->sma->smsCharLimit();
    $attrib = array( 'role' => 'form', 'id' => 'add-template-form');
    echo form_open_multipart("smsdashboard/templateAdd", $attrib);  

?>  
<input type="hidden" name="add_template" value="1">
<div class="row">
    <div class="col-md-12">
        <div class="form-group" id="form_loader"></div>
    </div>
    <div class="col-md-12" id="form_element">
        <div class="col-md-12">
            <div class="form-group">
               <label for="product_details">Name / Subject</label>
                <?php echo form_input('template_name', '', 'class="form-control tip" id="name" data-bv-notempty="true"'); ?>
            </div>
        </div>
	<div class="col-md-6">
            <div class="form-group">
                <label for="product_details">Type</label>
                <?= form_dropdown('template_type', $templateType, '', 'class="form-control" id="template_type"  '); ?>                
            </div>
        </div>
        <div class="col-md-6">
            <div class="form-group">
                <label for="product_details">Attchment</label>
               <input id="image" type="file" data-browse-label="<?= lang('browse'); ?>" name="attachment" id="attachment-single" data-show-upload="false"
                                           data-show-preview="false" accept="image/*" class="form-control file">      
            </div>
        </div>

        <div class="col-md-12">
            <div class="form-group">
               <label for="product_details">Content</label>
                <textarea name="template_content" cols="40" rows="12" class="form-control" id="template_content_e"></textarea>
            </div>
        </div>
<div class="col-md-12">
        <div class="form-group sms_text_counter" style="display:none">
           <div class="sms_note blue"> <span id="max_sms_charsE" class="max_sms_charsE"></span> </div> 
	   <div class="sms_note" style="border: 1px solid;padding: 1.5em;font-size: 12px;color: initial;"> 
	   	<span class="sms_previewE">Dear Customer, <div class="sms_preview_dE" style="display:inline;">##message##</div> Thanks and regards.</span>
	    </div> 
	</div>
    </div>  
        <div class="col-md-12">
            <div class="form-group" >
               <?php echo form_submit('add_template', lang('Add Template'), 'class="btn btn-primary"  style="float:left"'); ?>
            </div>
        </div>    
    </div>     
</div>

<script type="text/javascript">
    $(document).ready(function (e) {
    
      $('#template_type').on('change', function() {
 	 template_type1 = $('#template_type').val();
 	 if(template_type1 !=1){
 	    $('.sms_text_counter').css("display","none");
 	 }
 	 else{
 	    $('.sms_text_counter').css("display","block");
 	 }
    })

         $('#template_content_e').keyup(function (event) {    	 
	    	 template_type = $('#template_type').val();
	    	 console.log('test'+template_type);
	    	 if(template_type ==1){
	    	      $('.sms_text_counter').css("display","block");
		      var lengthE = $(this).val().length+34;
		      var smsLength = <?php echo $sms_text_limit?>;
	              $('.sms_text_counter .max_sms_charsE').text('SMS count : '+Math.ceil(lengthE/smsLength )+' ');    
	              $('.sms_text_counter .sms_preview_dE').text($(this).val()+lengthE+''+smsLength);	              
	              if($(this).val()==''){
	              	 $('.sms_text_counter').css('display','none');
	              }
	    	 }        
        });
        
    
       $('#add-template-form').submit(function( event ) {
         $('#form_loader').html('Loding..');
         $.ajax({
                type: "POST", 
                url:  $('#add-template-form').attr('action'),
                data: new FormData(this),
                dataType: "json",
                contentType: false,
                cache: false, // To unable request pages to be cached
                processData: false,
                success: function (data) {
                    if(data['error']){
                         $('#form_loader').html('<div class="alert alert-danger"><button data-dismiss="alert" class="close" type="button">×</button>'+data['error']+'</div>');
                    }
                    else{
                         $('#form_element').html('');   
                         $('#form_loader').html('<div class="alert alert-success"><button data-dismiss="alert" class="close" type="button">×</button>'+data['msg']+'</div>');
                    }
                    
                 },
                error: function () {
                }
            });  
        event.preventDefault();
       });
        
    });
</script>
