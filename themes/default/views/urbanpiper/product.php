<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
   .btn-small{padding: 1px 5px;
    border-radius: 4px !important;
    font-size: 12px;}
   .loaderclass{position:absolute;left:0;right:0;top:0;bottom:0;margin:auto; background: #FFF; }
   
</style>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-barcode"></i><?= lang('UrbanPiper Products')  ?>
        </h2>
         <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <button type="button" id="product_add" class="btn btn-primary"   ><i class="fa fa-cloud-download" aria-hidden="true"></i> Products Import</button>
                </li>
            </ul>
        </div>   
    </div>
    <div class="box-content">
    	 <?php $attrib = array( 'data-toggle' => 'validator','role' => 'form'); //
               echo form_open("urban_piper/product", $attrib); ?>
            <div class="row">
                <div class="col-lg-12">
                    <?php if(validation_errors()){ ?>
                        <div class="alert alert-danger" id="errormsg"> <<button type="button" class="close fa-2x" id="msgclose">&times;</button>
                            <?=  validation_errors() ?>            
                        </div>
                    <?php  } 
                        if($this->session->flashdata('success')){ ?>
                          <div class="alert alert-success" id="errormsg"> <button type="button" class="close fa-2x" id="msgclose">&times;</button>
                                <?=  $this->session->flashdata('success') ?>            
                            </div>
                     <?php }else if($this->session->flashdata('errors')){ ?>
                    <div class="alert alert-danger" id="errormsg"> <button type="button" class="close fa-2x" id="msgclose">&times;</button>
                                <?=  $this->session->flashdata('errors') ?>            
                            </div>
                    <?php } ?>
		        <div class="row">
		            <div class="col-lg-12">
		           	 <?php // if($store_setting->store_add_urbanpiper =='1'){?>
			                <div class="table-responsive" id="product_list">
			
			                </div>
			        <?php //}else{ ?>   
			        
			         	<!-- <h2 class="text-center"> Store not add on urbanpiper.</h2> -->
		                <?php //} ?>   
		            </div>
		        </div>
		         <div class="row">
                        <div class="col-sm-2">
                            <strong> Action by urbanpiper </strong>
                        </div>
                        <div class="col-sm-3">
                            <select class="form-control" id="actionvalue" name="action" required="true">
                                <option value="">-- Select --</option>
                                <option value="Add_product">Add</option>
                                <option value="Enable_product">Enable</option>
                                <option value="Disable_product">Disable</option>
                                <option value="Delete_product">Delete</option>
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <button type="submit" class="btn btn-primary" id="btnaction"> Go</button>
                        </div>
                    </div>
                </div>
            </div>
         <?= form_close(); ?>
    </div>    
</div>
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
            	<span id="btnokaction"></span>
                <button type="button" id="closemodel" class=" btn btn-danger" >Close</button>
            </div>
          </div>
    </div>
</div>
<!-- End Message model --->

<script type="text/javascript">
    $(document).ready(function(){
     
        getproductlist();
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
    
    
    <?php //if($store_setting->store_add_urbanpiper=='1'){ ?>
	    function getproductlist(){
	        $.ajax({
	            type:'ajax',
	            dataType:'json',
	            url:'<?= site_url('/urban_piper/getproduct_list') ?>',
	            async:false,
	            success:function(result){
	                $('#product_list').html(result);
	                
	            },error:function(){
	                console.log('error');
	            }    
	        });
	         $('#productlist').DataTable(); 
	    }
    
    <?php //} ?>
     // Action on button
    function category_status(){
         var args = arguments;
         var ex_args = (args[4])?args[4]:'';
        var passdata = 'onclick="action_call(\''+args[1]+'\',\''+args[2]+'\',\''+args[3]+'\',\''+ex_args+'\')"';
       
        $('#modeltitle').html('confirmation');
        $('#showmsg').html('Are you sure product  '+ args[0]+ ' on urbanpiper portal?');
        $('#btnokaction').html('Test');
        modal.style.display = "block";
        $('#btnokaction').html('<button type="button" class="btn btn-success" '+passdata+'>Ok</button>');
    }
    
    function action_call(){
        $('#ajaxCall').show();  
        modal.style.display = "none";
        $('#btnokaction').html('');
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
                       
                       console.log(result);
	           	$('#ajaxCall').hide();  
	               if(result.status=='success'){
	                    $('#showmsg').html('<span class="text-success"> '+result.messages+'</span>');
	                    setTimeout(function(){getproductlist();},1000);
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
    // End Action on Button
    
    
     // Product add 
    $('#product_add').click(function(){
        $('#ajaxCall').show();
        setTimeout(function(){
             $.ajax({
                 type:'ajax',
                 dataType:'json',
                 url:'<?= site_url("urban_piper/add_product/") ?>',
                 async:false,
                 success:function(result){
                        if(result.status=='success'){
//	                    $('#showmsg').html('<span class="text-success"> '+result.messages+'</span>');
	                    setTimeout(function(){getproductlist();},1000);
	               }
//                       $('#modeltitle').html('message');
//	               modal.style.display = "block";
                 },error:function(){
                     console.log('error');
                 }
             });
        },100);
    });
    $('#msgclose').click(function(){
        $('#errormsg').hide();
    });
</script>    