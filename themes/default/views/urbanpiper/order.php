<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-barcode"></i><?= lang('Order')  ?> </h2> 
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive" id="order_list">

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
                <button type="button" id="confirm_ok" style="display:none;" class="btn btn-success"> Ok </button>
                <button type="button" id="closemodel" class=" btn btn-danger" >Close</button>
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
              <button type="button" class="close" data-dismiss="modal">&times;</button>
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
            <div class="modal-footer">
                <button type="button" id="passdatastatus" class="btn btn-success"> Ok </button>
                <button type="button" id="closemodels" class=" btn btn-danger" >Close</button>
            </div>
        </div>
    </div>
</div>
<!--  End pass Status -->



<img src="<?= $assets ?>images/loader.gif" class="loaderclass" id="pageloader">
<script>
    $(document).ready(function(){
         $('#pageloader').hide();
         $('#confirm_ok').hide();
         getstore();
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
    
    $('#closemodels').click(function(){
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
    
   
  function order_status(){
      var order_id = arguments[0];
      var order_status =  arguments[1];
      $('#up_order_id').val('');
      $('#up_order_status').val('');
      $('#status_message').val('');
      $('#confirm_ok').show();
      $('#showmsg').html('Are you sure confirm change status?');
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
        var order_id = $('#up_order_id').val();
        var order_status = $('#up_order_status').val();
        var status_message =  $('#status_message').val();
        statusmodal.style.display = "none";
         call_status('Order_status',order_id,order_status+"?"+"message="+status_message);
  });
    
    
    function call_status(){
        alert('In call_status function');
       // $('#confirm_ok').hide();
        var pass_data;
        pass_data = arguments[0]+"/"+arguments[1]+"/"+arguments[2];
        alert(pass_data);
        $.ajax({
           type:'ajax',
           dataType:'json',
           url:'<?= site_url("urban_piper/action/") ?>'+pass_data,
           async:false,
          //           beforeSend: function(){
//               $('#pageloader').show();
//           },
        
           success:function(result){
               alert(result.status);
               if(result.status=='success'){
                    $('#showmsg').html(result.message);
               }else{
                    $('#showmsg').html(result.message);
               }
           
               $('#modeltitle').html('message');
               modal.style.display = "block";
               getstore();
            },error:function(){
                console.log('error');
            }     
        });
    }
    
    
    
    
    function getstore(){
    $('#confirm_ok').hide();
        $.ajax({
           type:'ajax',
           dataType:'json',
           url:'<?= site_url() ?>/urban_piper/uprbanpiper_order',
           async:false,
//           beforeSend: function(){
//               $('#pageloader').show();
//           },
           success:function(result){
               //console.log(result);
              $('#order_list').html(result);
            },error:function(){
              console.log('error');
            } 
        });
        $('#storelist').DataTable(); 
    }
    
    function store_status(){
        
        $.ajax({
           type:'ajax',
           dataType:'json',
           url:'<?= site_url("urban_piper/action/") ?>'+arguments[0]+"/"+arguments[1],
           async:false,
           success:function(result){
               
               if(result.status=='success'){
                    $('#showmsg').html(result.messages);
                    setTimeout(function(){ location.reload(true); }, 2000);
                    
               }else{
                    $('#showmsg').html(result.messages);
               }
//               console.log(result);
               $('#modeltitle').html('message');
               modal.style.display = "block";
              
            },error:function(){
                console.log('error');
            }     
        });
    }
</script>    
