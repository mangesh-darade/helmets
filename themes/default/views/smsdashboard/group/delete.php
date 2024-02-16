<?php defined('BASEPATH') OR exit('No direct script access allowed');
  $action = site_url('smsdashboard/groupDelete').'?group_id='.$group->id;
    $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id' => 'edit-group-form');
    echo form_open_multipart($action, $attrib);  

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
<input type="hidden" name="delete_group" value="1"> 
<input type="hidden" name="group_action" value="del"> 
<div class="row">
    <div class="col-md-12">
        <div class="form-group" id="form_loader"></div>
    </div>
    <div class="col-md-12" id="form_element">
  
    <div class="col-md-12" class="group_member">
        <div class="form-group">
            <label for="product_details">Are you sure to delete this  record ?</label>
             
        </div>
    </div>
    <div class="col-md-12">
        <div class="form-group" >
           <?php echo form_submit('delete_group', lang('Yes'), 'class="btn btn-danger"'); ?>
            <button  class="btn btn-default" data-dismiss="modal">No</button>
        </div>
    </div>    
    </div>     
</div>

<script type="text/javascript">
    $(document).ready(function (e) {
       $('#edit-group-form').submit(function( event ) {
         $('#form_loader').html('Loding..');
         $.ajax({
                type: "POST",
                async: false,
                url:  $('#edit-group-form').attr('action'),
                data: $('#edit-group-form').serialize(),
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
</script>
