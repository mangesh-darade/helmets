<?php defined('BASEPATH') OR exit('No direct script access allowed');
    $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id' => 'add-group-form');
        echo form_open_multipart("smsdashboard/groupAdd", $attrib);  

?> 
<style>
    
#group_member_list {
    width: 100%;
    display: block;
    overflow-x: hidden;
    list-style-type: none;
    overflow-y: scroll;
    height: 250px;
}
#group_member_list li{
    padding: 0.25% 0;
}
</style>
<input type="hidden" name="add_group" value="1">
<div class="row">
    <div class="col-md-12">
        <div class="form-group" id="form_loader"></div>
    </div>
    <div class="col-md-12" id="form_element">
    <div class="col-md-12">
        <div class="form-group">
            <div class="col-md-2"> <?= lang("name", "name"); ?> </div>
            <div class="col-md-10">
            	<?php echo form_input('group_name', '', 'class="form-control tip" id="name" data-bv-notempty="true"'); ?>
            </div> 	
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-group">
           <label for="product_details" class="col-md-2" >Description</label>
            <div class="col-md-10">
            	<textarea name="group_desc" cols="40" rows="2" class="form-control skip" id="group_desc"></textarea>
            </div> 	
        </div>
    </div>

    <div class="col-md-12" class="group_member">
        <div class="form-group">
            <label for="product_details">Member</label>  <label for="mbselect"><span> &nbsp; &nbsp; <input type="checkbox" name="selectall" id="mbselect" title="Select All" /> </span> Select All</label>
            <?php echo $this->sma->contact_group_member($customer ,NULL); ?>
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group" >
           <?php echo form_submit('add_group', lang('Add Contact Group'), 'class="btn btn-primary"'); ?>
        </div>
    </div>    
    </div>     
</div>

<script type="text/javascript">
    $(document).ready(function (e) {
       $('#add-group-form').submit(function( event ) {
         $('#form_loader').html('Loding..');
         $.ajax({
                type: "POST",
                async: false,
                url:  $('#add-group-form').attr('action'),
                data: $('#add-group-form').serialize(),
                dataType: "json",
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
    
    $(document).on('click','#mbselect',function(){
        if($(this).prop("checked")==true){
          $('.mbselect').attr('checked',true);
        }else{
           $('.mbselect').attr('checked',false);
        }
    });
</script>
