<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box">
    <div class="box-header">
        <div class="col-sm-10"><h2 class="blue"><i class="fa-fw fa fa-barcode"></i><?= lang('Active Order')  ?></h2></div>
        <div class="col-sm-2"><a href="<?=base_url('urban_piper/orders_inactive')?>" class="btn btn-primary">Inactive Orders</a></div>
    </div>
    <div class="box-content">
        <div class="row">
            <div id="showmsgalert"></div>
        </div>
       
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                <table class="table table-bordered" id="orderlist" >
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Order Time</th>
                            <th>UP Order Id</th>
                            <th>Delivery</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Cannel</th>                                
                            <th>Customer</th>
                            <th>Rider</th>
                            <th>Rider OTP</th>
                            <th colspan="3">action</th>
                        </tr>                            
                     </thead>
                     <tbody id="uporderstable">     
                    </tbody>
                </table>  
                </div>
            </div>
        </div>
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
                <button type="button" id="confirm_ok" style="display:none;" class="btn btn-success msg_model_buttons_ok"> Ok </button>
                <button type="button" id="closemodel" class="btn btn-danger msg_model_buttons_close"  data-dismiss="modal" >Close</button>
            </div>
          </div>
    </div>
</div>
<!-- End Message model --->

<!-- Pass Status -->
<div id="pass_datamodal" class="modal" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close closemodels" data-dismiss="modal">&times;</button>
              <h4 class="modal-title" > Message</h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <input type="hidden" id="up_order_id"/>
                    <input type="hidden" id="up_order_status"/>
                    <label> Message </label>
                    <input type="text" name="message" placeholder="Message"  id="status_message" class="form-control">
                </div>
            </div>
            <div class="modal-footer" id="msg_model_buttons">
                <button type="button" id="passdatastatus" class="btn btn-success "> Ok </button>
                <button type="button"  class="btn btn-danger closemodels "  data-dismiss="modal" >Close</button>
            </div>
        </div>
    </div>
</div>
<!--  End pass Status -->


<!-- Modal -->
<div class="modal fade" id="orderdetails" role="dialog">
    <div class="modal-dialog" style="width:80%;">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="orderdetailtitle">Modal Header</h4>
        </div>
        <div class="modal-body" id="model_body">
          <p>Some text in the modal.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
        </div>
      </div>
      
    </div>
  </div>
<!--<img src="< ?= $assets ?>images/loader.gif" class="loaderclass" id="pageloader">-->
<script>
    $(document).ready(function(){ 
        $('#pageloader').hide();
        $('#confirm_ok').hide();
        
    });
    
     // Get the modal
    var modal = document.getElementById('myModal');
    var statusmodal = document.getElementById('pass_datamodal');

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
    
    $('.closemodels').click(function(){
        statusmodal.style.display = "none";
        $('#status_message').val('');
        
    });
    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function(event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
      if(event.target==statusmodal){
          statusmodal.style.display = "none";
      }
    }
    
  function order_details(saleid){
      
      $('#orderdetailtitle').html('Order Details');
      
      $.ajax({
            type: "GET",
            url: '<?= site_url("urban_piper/order_details/")?>'+saleid,
            beforeSend: function(){
                $("#model_body").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
            },
            success: function(data){			 
                $("#model_body").html(data);			 
            },
            error:function(){
               $("#model_body").html("<div class='alert alert-danger'>Ajax Error</div>");
            }
       });
  }
  
  
  function order_kot(saleid){
   $('#orderdetailtitle').html('KOT Details');
   $.ajax({
        type:"GET",
        url:'<?= site_url("urban_piper/order_kot/")?>'+saleid,
        beforeSend: function(){
            $("#model_body").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
        },
        success: function(data){			 
            $("#model_body").html(data);
            
            printDiv('printableArea');
           
        },
        error:function(){
            $("#model_body").html("<div class='alert alert-danger'>Ajax Error</div>");
        }
    });

  }
  
  function printDiv(divId) {
       var printContents = document.getElementById(divId).innerHTML;
       var originalContents = document.body.innerHTML;
       document.body.innerHTML = "<html><head><title></title></head><body>" + printContents + "</body>";
       window.print();
       document.body.innerHTML = originalContents;
       window.location.reload()
   }
  
  function reloadOrdersTable(){
    
     $.ajax({
            type: "GET",
            url: '<?= site_url("urban_piper/orders_list/")?>',
            beforeSend: function(){
                $("#uporderstable").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i></div>");
            },
            success: function(data){			 
                $("#uporderstable").html(data);
               
            },
            error:function(){
               $("#uporderstable").html("<div class='alert alert-danger'>Ajax Error</div>");
            }
       });
       
        
  }
  
   
  
  function order_status(order_id, order_status){
      
      $('#up_order_id').val('');
      $('#up_order_status').val('');
      $('#status_message').val('');
      $('#confirm_ok').show();
      $('#showmsg').html('Are you sure to change '+order_status+' order status?');
      $('#modeltitle').html('confirm');
      modal.style.display = "block";
        
        $('#confirm_ok').click(function(){
             modal.style.display = "none";
             statusmodal.style.display = "block";
             $('#up_order_id').val(order_id);
             $('#up_order_status').val(order_status);
        });
  }
    
    
  $('#passdatastatus').click(function(){
        statusmodal.style.display = "none";
        modal.style.display = "block";
        var order_id = $('#up_order_id').val();
        var order_status = $('#up_order_status').val();
        var status_message =  $('#status_message').val();
       // statusmodal.style.display = "none";
        $('.msg_model_buttons_ok').hide();
        $('.msg_model_buttons_close').hide();
        $('#showmsg').html('<div style="text-align:center;"><img src="<?= base_url('assets/images/ajax-loader.gif')?>" alt="please wait loading..."></div>');
        
        setTimeout(function(){
            update_order_status( order_id, order_status, status_message); 
        }, 500);
  });
    
    
    function update_order_status( order_id, order_status, status_message){
        $('.msg_model_buttons_close').show();
        $('#modeltitle').html('response');
        $.ajax({
           type:'ajax',
           dataType:'json',
           url:'<?= site_url("urban_piper/update_order_status/") ?>'+order_id+'/'+order_status+'/'+status_message,
           async:false,
          
           success:function(result){
               
               if(result.status=='success'){
                   
                    $('#showmsgalert').html('<div class="alert alert-success">'+result.message+'</div>');
                    $('#showmsg').html('<div class="alert alert-success">'+result.message+'</div>');
                    
                    $('#current_status_'+order_id).html(order_status);
                    $('#current_status_'+order_id).removeClass('btn-info');
                    $('#current_status_'+order_id).removeClass('btn-warning');
                    $('#current_status_'+order_id).removeClass('btn-primady');
                    $('#current_status_'+order_id).removeClass('btn-danger');
                    $('#current_status_'+order_id).addClass('btn-success');
                    order_status = (order_status == 'Food Ready') ? 'FoodReady' : order_status;
                    
                    $('#'+order_status+'_status_'+order_id).hide();
               } else {
                    $('#showmsgalert').html('<div class="alert alert-danger">'+result.message+'</div>');
                    $('#showmsg').html('<div class="alert alert-danger">'+result.message+'</div>');                    
               }
              
               
              setTimeout(function(){  modal.style.display = "none"; }, 1000);
             // setTimeout(function(){ location.reload(true); }, 2000);
               
//               modal.style.display = "block";

            },error:function(){
                console.log('error');
            }     
        });
    } 
    
    setInterval(reloadOrdersTable, 30000);
    
    reloadOrdersTable();
    
</script>    
