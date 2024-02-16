<style>
        fieldset 
	{
            border: 1px solid #ddd !important;
            margin: 0;
            xmin-width: 0;
            padding: 10px;       
            position: relative;
            border-radius:4px;
            background-color:#f5f5f5;
            padding-left:10px!important;
	}	
	legend
	{
            font-size:14px;
            font-weight:bold;
            margin-bottom: 0px; 
            width: 35%; 
            border: 1px solid #ddd;
            border-radius: 4px; 
            padding: 5px 5px 5px 10px; 
            background-color: #ffffff;
	}
        .platform_btn{ font-size: 24px; height: 57px; color:#FFF;}
        .zomatobtn{ background: linear-gradient(to bottom, rgb(191, 18, 18) 0%,rgb(149, 29, 46) 100%);}
        .foodpandabtn{ background: linear-gradient(to bottom, #e65a32 0%,#e65a32 100%);}
        .swiggybtn{ background: linear-gradient(to bottom, #f87728 0%,#f87728 100%);}
        .urbanpiperbtn{ background: linear-gradient(to bottom, #2ed573 0%,#2ed573 100%);}
        .ubereatbtn{ background: linear-gradient(to bottom, #67b835 0%,#67b835 100%);} 
        .btn-sm{padding:2px 5px;border-radius: 5px !important;}
</style>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-cogs"></i><?= lang('Settings'); ?></h2>
    </div>
    <div class="box-content">
        <fieldset>
            <legend>API</legend>
            <div class="row">                
                <div class="col-sm-12 table-responsive">
                    <table class="table table-bordered" >
                        <tbody>
                            <tr>
                                <th>API Key </th>
                                <td><?= $urbanpiper_setting->api_key?></td>
                            </tr>
                            <tr>
                                <th>Quint Url </th>
                                <td><?= $config->config['UP_QUINT_URL']?></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
            
        </fieldset>
        <hr/>
        <fieldset>
            <legend>Package</legend>
            <div class="row">
                <div class="col-sm-6">Balance Orders : <span><?= $Settings->up_balance_order?></span></div>
                <div class="col-sm-6">Received Orders : <span><?= $Settings->up_order_received?></span></div>
            </div>
        </fieldset>
        <hr/>
        <?php if($urbanpiper_setting->api_key) { ?>
        <fieldset>
            <legend>Ordering Webhooks</legend>
            <div class="row">                
                <div class="col-sm-12 table-responsive">
                    <table class="table table-bordered" >
                        <thead>
                            <tr>
                                <th>Event Type</th>
                                <th>Webhook URL</th>
                                <th>Retries mode</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td>Order placed</td>
                                <td><?= base_url('urban_piper/add_order')?></td>
                                <td>minutes</td>
                            </tr>
                            <tr>
                                <td>Order status update</td>
                                <td><?= base_url('urban_piper/orderstatus')?></td>
                                <td>seconds</td>
                            </tr>
                            <tr>
                                <td>Order delivery status</td>
                                <td><?= base_url('urban_piper/orderrider')?></td>
                                <td>minutes</td>
                            </tr>
                            <tr>
                                <td>Inventory update callback  API</td>
                                <td><?= base_url('urban_piper/inventorycallback')?></td>
                                <td>minutes</td>
                            </tr>
                            <tr>
                                <td>Stores creation callback API</td>
                                <td><?= base_url('urban_piper/storescallback')?></td>
                                <td>minutes</td>
                            </tr>
                            <tr>
                                <td>Stores Action callback API</td>
                                <td><?= base_url('urban_piper/storeactioncallback')?></td>
                                <td>minutes</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </fieldset>
        <hr/>
        <fieldset>
            <legend>Stores</legend>
           
            <div class="table-responsive" id="platform_table"></div>
             
        </fieldset>
        <hr/>
        <fieldset>
            <legend>Sales Platform</legend>
            <?php $attrib = array( 'data-toggle' => 'validator','role' => 'form'); //
                echo form_open("urban_piper/settings", $attrib);
                ?>
                 <input type="hidden" name="setting_id" value="1"/>
                <div class="row">
                    <div class="col-sm-4">
                        <input type="checkbox" name="urbanpiper" value="1" <?= ($urbanpiper_setting->urbanpiper)?'checked':''?>> 
                           &nbsp;  <label>Urbanpiper</label>   
                    </div>
                    <div class="col-sm-4">
                        <input type="checkbox" name="zomato" value="1" <?= ($urbanpiper_setting->zomato)?'checked':''?>>
                           &nbsp;  <label>Zomato</label>   
                    </div>
                     <div class="col-sm-4">
                        <input type="checkbox" name="foodpanda" value="1" <?= ($urbanpiper_setting->foodpanda)?'checked':''?>>
                           &nbsp;  <label>Foodpanda</label>   
                    </div>
                     <div class="col-sm-4">
                        <input type="checkbox" name="swiggy" value="1" <?= ($urbanpiper_setting->swiggy)?'checked':''?>>
                           &nbsp;  <label>Swiggy</label>   
                    </div>
                     <div class="col-sm-4">
                        <input type="checkbox" name="ubereats" value="1"  <?= ($urbanpiper_setting->ubereats)?'checked':''?>>
                           &nbsp;  <label>Ubereats</label>   
                    </div>
                </div>
                <div class="row text-center">
                    <button type="submit" class="btn btn-success" > Update </button>  
                </div>  
            <?= form_close(); ?>
        </fieldset>
<!--        <fieldset>
            <legend>Ordering  Receive Status </legend>
            <div class="row">
                <div class="col-sm-3">
                    <strong> Ordering Status : </strong>
                </div>
                <div class="col-sm-2">
                  
                    
                        <?php //if($ordering_Status->ordering_enabled=='true'){ ?>
                        <button class="btn btn-success" onclick="action_ordering('ordering','Disable')" >Enabled</button>
                        <?php //}else{ ?>
                            <button class="btn btn-danger" onclick="action_ordering('ordering','Enabled')">Disabled</button>
                        <?php //} ?>
                    
                </div>
                <div class="col-sm-3">
                    <strong> Store Deactivate  on Urbanpiper : </strong>
                </div>
                <div class="col-sm-4">
                 
                    
                    
                      <button class="btn btn-danger" onclick="action_deactive('Store_Deactivate')" >Deactivate</button>
                    
                </div>
            </div>
        </fieldset>   -->
                
         <?php } ?>
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
                <span id="okbtn" ></span>
                <button type="button" id="closemodel" class=" btn btn-danger" >Close</button>
            </div>
          </div>
    </div>
</div>
<!-- End Message model --->

<script type="text/javascript">
    $(document).ready(function(){
        getplatformlist();
        //$('#pageloader').hide();
        
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
    
    
    function action_confirm(){
        var ag1=arguments[0],ag2=arguments[1],ag3=arguments[2], ag4=arguments[3],ag5=arguments[4];
        $('#modeltitle').html('Confirmation');
        $('#showmsg').html('Are you sure to change store status platform?');
        $('#okbtn').html('<button class="btn btn-success" onclick="confirm_ok(\''+ag1+'\',\''+ag2+'\',\''+ag3+'\',\''+ag4+'\',\''+ag5+'\')" >Ok</button>');
        modal.style.display = "block";
        
    }
    

    function confirm_ok(){
        $('#ajaxCall').show();
        var get_args = arguments;
        console.log(get_args);
        var url = '<?= site_url("urban_piper/action/") ?>'+get_args[0]+'/'+get_args[1]+'/'+get_args[2]+'?action='+get_args[3]+'&id='+get_args[4];
        modal.style.display = "none";
        $('#okbtn').html('');
        setTimeout(function(){action_form(url,'platform');},10);
       
    }

  
    function action_form(pass,action_function){
       

        $.ajax({
            type:'ajax',
            dataType:'json',
            url:pass,
            async:false,
            success:function(result){
                $('#ajaxCall').hide();
   
              
                if(result.status=='success'){
                    $('#showmsg').html(result.messages);
                    if(action_function=='platform'){
                        getplatformlist();
                    }else{
                       setTimeout(function(){location.reload()},100); 
                    }    
               }else{
                    $('#showmsg').html(result.messages);
               }

               $('#modeltitle').html('message');
               modal.style.display = "block";
                
            },error:function(){
                 $('#ajaxCall').hide();
                console.log('error');
               
            }   
        });
    }
    
    function getplatformlist(){
        $.ajax({
              dataType:'html',
              url:'<?= site_url("urban_piper/store_platform_list/")?>',
              async:false,
              success:function(result){
                  $('#platform_table').html(result);
               },error:function(){
                  console.log('error');
               }    
        });
    }
    
</script>    