<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box">
    <div class="box-header">
        <div class="col-sm-10"><h2 class="blue"><i class="fa-fw fa fa-barcode"></i><?= lang('Inactive Order')?></h2></div>
        <div class="col-sm-2"><a href="<?=base_url('urban_piper')?>" class="btn btn-primary"><?= lang('Active Orders')?></a></div>       
    </div>
    <div class="box-content">
        <div class="row">
            <div id="showmsgalert"></div>
        </div>
       
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive" id="uporderstable">
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
                                <th colspan="2">action</th>
                            </tr>                            
                        </thead>
                        <tbody>
                        <?php
                         if(is_array($upOrders)){
                             foreach ($upOrders as $key => $order) {
                                 
                                  $up_response =  unserialize($order->up_response);
                         ?>
                            <tr>
                                <td><?=++$i?></td>
                                <td><?=$order->up_state_timestamp?></td>
                                <td><?=$order->up_order_id?></td>
                                <td><?=$order->up_delivery_datetime?></td>
                                <td>Rs.&nbsp;<?=$up_response->order->details->order_total?></td>
                                <td>
                                <?php
                                 
                                 $btn_class = $order->sale_status == 'Cancelled' ? 'btn-danger' : ($order->sale_status == 'Completed' ? 'btn-success' : 'btn-default');
                                  
                                 echo $status_data='<button type="button" class="btn btn-xs '.$btn_class.' " >'.$order->sale_status.' </button>';
                              
                                ?>
                                </td>
                                <td><img class="img img-responsive" src="<?=base_url("assets/logs/".$order->up_channel.".jpg")?>" alt="<?=$order->up_channel?>" title="<?=$order->up_channel?>" /></td>
                                <td onclick="view_customer('<?=$order->order_rider_id?>')" ><?=$up_response->customer->name?><br/>Mb.:<?=$up_response->customer->phone?></td>
                                <td><?php if($order->order_rider_id) { ?><a class="btn btn-xs btn-info" onclick="view_rider_info('<?=$order->order_rider_id?>')" ><?=$order->current_state?></a><?php } else { echo '<button class="btn btn-xs default">Not Assign</button>'; } ?></td>
                                <td><?=substr($up_response->customer->phone, -4)?></td>
                                <td><button class="btn btn-xs btn-primary" data-toggle="modal" data-target="#orderdetails" onclick="order_details('<?=$order->sale_id?>');" id="<?=$order->sale_id?>" >Order Details</button></td>                                
                                <td><a class="btn btn-xs btn-info" target="_new" href="<?=base_url('pos/view_up/'.$order->sale_id);?>">Recept</a></td>                                
                            </tr>
                        <?php
                             } //end foreach.                             
                         }//end if
                        ?>
                        </tbody>
                    </table>    
                </div>
            </div>
        </div>
    </div>    
</div>    

  


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
        $('#orderlist').DataTable();
        
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
  
    
  
    
</script>    
