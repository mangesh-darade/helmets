<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
   .btn-small{padding: 1px 5px;
    border-radius: 4px !important;
    font-size: 12px;}
   .loaderclass{position:absolute;left:0;right:0;top:0;bottom:0;margin:auto; background: #FFF; }
   
</style>  
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-barcode"></i><?= $group_option->title   ?> (<?= $group_option->code ?>) 
        </h2>
        <div class="box-icon">
            <ul class="btn-tasks">
                 <li class="dropdown">
                    <button class="btn btn-primary" data-toggle="modal" data-target="#addoptions" ><i class="fa fa-plus" aria-hidden="true"></i> Option</button>
                </li> 
<!--                <li class="dropdown">
                    <button class="btn btn-primary"  onclick="window.location='<?= site_url('urban_piper/groups_option') ?>'" ><i class="fa fa-reply" aria-hidden="true"></i> Back</button>
                </li>-->
            </ul>
        </div>   
       
    </div>
    <?php if($this->session->flashdata('success')){ ?>
             <div class="alert alert-success" id="errormsg">
                 <button type="button" class="close fa-2x" id="msgclose">&times;</button>
                  <?=  $this->session->flashdata('success') ?>            
            </div>
    <?php }else if($this->session->flashdata('errors')){ ?>
             <div class="alert alert-danger" id="errormsg">
                 <button type="button" class="close fa-2x" id="msgclose">&times;</button>
                 <?=  $this->session->flashdata('errors') ?>            
             </div>
    <?php }?>
    <div class="box-content">
     
        <div class="row">
         <?php $attrib = array( 'data-toggle' => 'validator','role' => 'form'); //
                echo form_open("urban_piper/optionlist/".$group_option->id, $attrib);
            ?> 
            <div class="col-lg-12">
                <div class="table-responsive" id="option_list">

                </div>
                <div class="row">
                        <div class="col-sm-1">
                            <label>Action</label>
                        </div>  
                        <div class="col-sm-3">
                            <select class="form-control" name="action" id="actionvalue" required="true" >
                                <option value="">-- Select Action --</option>
                                <option value="add_option">Add</option>
                                <option value="delete_option">Delete</option>
                                <option value="enable_option">Enable</option>
                                <option value="disable_option">Disable</option>
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <button type="submit" id="action_go" class="btn btn-primary">Go</button>
                        </div>
                    </div>
            </div>
             <?= form_close(); ?>
        </div>
    </div>    
</div>

<!-- Add Option Modal -->

<div class="modal fade" id="addoptions" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Add Options</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <?php $attrib = array( 'data-toggle' => 'validator','role' => 'form'); //
        echo form_open("urban_piper/actionoptions", $attrib);
                ?>  
      <div class="modal-body">
          <div class="container">
              <div class="row">
                  <div class="form-group">
                      <label class="control-label">Name *</label>
                      <div class="controls">
                          <input type="text" class="form-control" name="title" placeholder="Option Name" required="true" id="optiontitle" />
                      </div>
                      <span class="text-danger" id="titleerr"></span>
                  </div>
                  <input type="hidden" name="keytype" value="add"/>
                  <input type="hidden" name="opt_group_code" value="<?= $group_option->code ?>">
               </div>
              <div class="row">
                  <div class="form-group">
                      <label class="control-label">Code *</label>
                      <div class="controls">
                          <input type="text" class="form-control" name="code" placeholder="Option code" required="true" id="optioncode" />
                      </div>
                      <span class="text-danger" id="optionerr"></span>
                  </div>
             </div>
             <div class="row">
                  <div class="form-group">
                      <label class="control-label">Description </label>
                      <div class="controls">
                          <input type="text" class="form-control" name="description" placeholder="Description"  id="description" />
                      </div>
                  </div>
             </div>
             <div class="row">
                  <div class="form-group">
                      <label class="control-label">Weight (gm.)</label>
                      <div class="controls">
                          <input type="number" min="0" class="form-control" name="weight" placeholder="Weight (gm.)"  id="weight" />
                      </div>
                  </div>
             </div>
              <div class="row">
                  <div class="form-group">
                      <label class="control-label">Food Type *</label>
                      <div class="controls">
                          <select class="form-control" name="food_type" id="foodtype" required="true">
                              <option value="">-- Select Option --</option>
                              <?php foreach($food_type as $food_type_vale ){ ?>
                              <option value="<?= $food_type_vale->id  ?>"><?= $food_type_vale->food_type ?></option>
                              <?php } ?>
                          </select>    
                      </div>
                      <span class="text-danger" id="foodtypeerr"></span>
                  </div>
             </div>
              <div class="row">
                  <div class="form-group">
                      <label class="control-label">Price *</label>
                      <div class="controls">
                          <input type="number" min="0" class="form-control" required="true" step="0.25" name="price" placeholder="Price"  id="price" />
                      </div>
                      <span class="text-danger" id="priceerr"></span>
                  </div>
             </div>
             
          </div>
          
          
      </div>
      <div class="modal-footer">
        <button type="submit" class="btn btn-success">Save </button>
        <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
      
      </div>
      <?= form_close(); ?>
    </div>
  </div>
</div>

<!-- End Add Option Modal

<!-- Message Modal -->
<div id="myModal" class="modal" role="dialog">
    <div class="modal-dialog">
      <!-- Modal content -->
      <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" id="modeltitle"></h4>
            </div>
            <div class="modal-body">
                <h3 class="text-center" id="showmsg"></h3>
            </div>
            <div class="modal-footer">
                <span id="okbtn"></span>
                <button type="button" id="closemodel" class=" btn btn-danger" >Close</button>
            </div>
          </div>
    </div>
</div>
<!-- End Message model --->

<script>
    $(document).ready(function(){
        getoption();
    });
    
     // Get the modal
    var modal = document.getElementById('myModal');

    // Get the button that opens the modal
    var btn = document.getElementById("myBtn");

    // Get the <span> element that closes the modal
    var span = document.getElementsByClassName("close")[0];

    // When the user clicks on the button, open the modal 
   

    // When the user clicks on <span> (x), close the modal
    span.onclick = function() {
      modal.style.display = "none";
    }

    $('#closemodel').click(function(){
        modal.style.display = "none";
    });
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
    
    $('#action_go').click(function(){
        var actionvalue = $('#actionvalue').val();
        if(actionvalue==''){
            $('#modeltitle').html('Message');
            $('#showmsg').html('Please select action');
            modal.style.display = "block";
            $('#okbtn').html('');
            return false;
        }
    });
    
    
   $("form").submit(function(){
       if($('#optiontitle').val()==''){
           $('#titleerr').html('Please enter option name.');
       }else if($('#optioncode').val()==''){
           $('#titleerr').html('');
            $('#optionerr').html('Please enter option code.');
       }else if($('#foodtype').val()==''){
            $('#titleerr').html('');
            $('#optionerr').html('');
            $('#foodtypeerr').html('Please select food type.');
       }else if($('#price').val()==''){
           $('#titleerr').html('');
            $('#optionerr').html('');
            $('#foodtypeerr').html('');
            $('#priceerr').html('Please enter price.');
       }else{
           $('#titleerr').html('');
            $('#optionerr').html('');
            $('#foodtypeerr').html('');
            $('#priceerr').html('');
//            var formdata = $(this).serialize();
//             
//            formaction(formdata);
         
        } 
      
   });

//   function formaction(datavalue){
//        console.log(datavalue);
//        $.ajax({
//            type:'ajax',
//            dataType:'json',
//            data:datavalue,
//            method:'post',
//            url:'<?= site_url('urban_piper/actionoptions') ?>',
//            async:fasle,
//            success:function(result){
//                console.log(result);
//            },error:function(){
//                console.log('error');
//            }
//        });
//        
//   }
    

    
    $('#msgclose').click(function(){
        $('#errormsg').hide();
    });
    
    function getoption(){
        $.ajax({
            type:'ajax',
            dataType:'html',
            url:'<?= site_url('urban_piper/getoptionlist/').$group_option->id ?>',
            async:false,
            success:function(result){
               $('#option_list').html(result);
              
            },error:function(){
                console.log('error');
            } 
        });
        $('#optionlist').DataTable(); 
    }
    
    // Single Action
    function category_status(){
        var args = arguments;
        var ex_arg = (args[4])?args[4]:'';
        var passdata = 'onclick="action_call(\''+args[1]+'\',\''+args[2]+'\',\''+args[3]+'\',\''+ex_arg+'\')"';
        $('#modeltitle').html('confirmation');
        $('#showmsg').html('Are you sure '+ args[0]+ ' on urbanpiper portal?');
        modal.style.display = "block";
        $('#okbtn').html('<button type="button" class="btn btn-success" '+passdata+'>Ok</button>');
    }
    // Single Action
    
    function action_call(){
        $('#ajaxCall').show();  
        modal.style.display = "none";
        var pass='';
        pass = arguments[0]+"/"+arguments[1];
        if(arguments[2]){
            pass +="/"+arguments[2];
        }
       if(arguments[3]){
            pass +="/"+arguments[3];
        }
       
       setTimeout(function(){
            $.ajax({
	           type:'ajax',
	           dataType:'json',
	           url:'<?= site_url("urban_piper/action/") ?>'+pass,
	           async:false,
	           success:function(result){
	           	$('#ajaxCall').hide();  
	               if(result.status=='success'){
	                    $('#showmsg').html('<span class="text-success"> '+result.messages+'</span>');
	                    setTimeout(function(){getoption();},1000);
	               }else{
	                    $('#showmsg').html('<span class="text-danger"> '+result.messages+'</span>');
	               }
		
	               $('#modeltitle').html('message');
	               modal.style.display = "block";
	               
	            },error:function(){
	            $('#ajaxCall').hide();  
	          
	          }    
                 
	       });
                $('#okbtn').html('');
	},100);     
       
    }    
   
    
 </script>   