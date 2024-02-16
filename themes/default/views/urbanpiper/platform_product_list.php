<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
   .btn-small{padding: 1px 5px;
    border-radius: 4px !important;
    font-size: 12px;}
   .loaderclass{position:absolute;left:0;right:0;top:0;bottom:0;margin:auto; background: #FFF; }   
</style>
<div class="box">
<?php $attrib = array( 'data-toggle' => 'validator','role' => 'form'); //
   echo form_open("urban_piper/platfrom_product_list/".$store_info->id, $attrib); ?>
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-barcode"></i> <?= $store_info->name; ?> : <?= lang(' Products List ')  ?>
        </h2>        
        <div class="box-icon">
            <ul class="btn-tasks">
                 <li class="dropdown">
                    <button type="button" id="product_add" class="btn btn-primary" onclick="window.location='<?= site_url('urban_piper/product_platform') ?>'"  ><i class="fa fa-reply" aria-hidden="true"></i> Back</button>
                </li>
                
                <li class="dropdown">
                    
                    <select name="store_categories" id="store_categories" style="width:200px;" >
                        <option value="">--Select&nbsp;Category--</option>
                        
                        <?php
                        if(is_array($storeCategories)){
                            foreach ($storeCategories as $catid => $category) {
                                $selected = ($category_id == $catid) ? ' selected="selected" ' : '';
                                if($category->parent_id){
                                    $subcategories[$category->parent_id][$catid] = '<option value="'.$catid.'" '.$selected.'>----'.$category->name.'</option>';
                                } else {
                                    $mainCat[$catid] = '<option value="'.$catid.'" '.$selected.'>'.$category->name.'</option>';
                                }
                            }//end foreach
                            
                            foreach ($mainCat as $cid => $parentoption) {
                                $options .= $parentoption;
                                if($subcategories[$cid]){
                                    foreach ($subcategories[$cid] as $scid => $suboption) {
                                         $options .= $suboption;
                                    }//end inner foreach
                                }
                            }//end foreach
                            
                            echo $options;
                        }//end if
                        ?>
                    </select>
                </li>
               
            </ul>
        </div>   
    </div>   
    <div class="box-content">
      
        <input type="hidden" name="store_id" value="<?= $store_info->id ?>" />
         
            <div class="row">
                <div class="col-lg-12">
                    <?php if(validation_errors()){ ?>
                        <div class="alert alert-danger" id="errormsg">
                            <button type="button" class="close fa-2x" id="msgclose">&times;</button>
                            <?=  validation_errors() ?>            
                        </div>
                    <?php  } 
                        if($this->session->flashdata('success')){ ?>
                          <div class="alert alert-success" id="errormsg">
                              <button type="button" class="close fa-2x" id="msgclose">&times;</button>
                                <?=  $this->session->flashdata('success') ?>            
                            </div>
                     <?php }else if($this->session->flashdata('errors')){ ?>
                            <div class="alert alert-danger" id="errormsg">
                                <button type="button" class="close fa-2x" id="msgclose">&times;</button>
                                <?=  $this->session->flashdata('errors') ?>            
                            </div>
                    <?php } ?>
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="table-responsive" id="product_list"></div>
                        </div>
                    </div>
                    <div class="row">
                        <?php if($platform->urbanpiper=='1' || $platform->zomato=='1' || $platform->foodpanda=='1' || $platform->swiggy=='1' || $platform->ubereats ){ ?>
<!--                            <div class="col-sm-3">
                                <select class="form-control" id="platform" name="paltfrom" required="true">
                                    <option value="">-- Select Platfrom --</option>

                                        <?= ($platform->urbanpiper)?'<option value="urbanpiper">Urbanpiper</option>':'';?>
                                        <?= ($platform->zomato)?'<option value="zomato">Zomato</option>':'';?>
                                        <?= ($platform->foodpanda)?'<option value="foodpanda">Foodpanda</option>':'';?>
                                        <?= ($platform->swiggy)?'<option value="swiggy">Swiggy</option>':'';?>
                                        <?= ($platform->ubereats)?'<option value="ubereats">Ubereats</option>':'';?>
                                </select>
                            </div>-->
                        <?php } ?>
                        <div class="col-sm-3">
                            <select class="form-control" id="actionvalue" name="action" required="true">
                                <option value="0">-- Select Action--</option>
                                    <option value="add"> Product Add</option>
                                    <option value="product_enable"> Product Enable </option>
                                    <option value="product_disable"> Product Disable </option>
<!--                                    <option value="product_delete"> Product Delete </option>-->
                                   <?php if($platform->urbanpiper=='1' || $platform->zomato=='1' || $platform->foodpanda=='1' || $platform->swiggy=='1' || $platform->ubereats ){ ?>
<!--                                        <option value="Enable">Enable</option>
                                        <option value="Disable">Disable</option>-->
                                   <?php } ?>    
                               
                            </select>
                        </div>
                        <div class="col-sm-1">
                            <button type="submit" class="btn btn-primary" id="btnaction"> Go</button>
                        </div>
                    </div>
                </div>
            </div>        
    </div>     
 <?= form_close(); ?>
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
       
        getproductlist('<?=$store_info->id?>', '<?= $category_id?$category_id:0 ?>');
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
    
    // Bulk Action 
    $('#btnaction').click(function(){
        var getvalue = $('#actionvalue').val();
       if(getvalue=='add' || getvalue=='product_enable' || getvalue=='product_disable' || getvalue=='product_delete' ){
           return true;
       }else{
            if($('#platform').val()==''){
                $('#modeltitle').html('message');
                $('#showmsg').html('Please select platfrom. ');
                modal.style.display = "block";
                $('#okbtn').html('');
                return false;
            }else if($('#actionvalue').val()==''){
                $('#modeltitle').html('message');
                $('#showmsg').html('Please select action by urbanpiper. ');
                modal.style.display = "block";
                $('#okbtn').html('');
                return false;
            }else{
              return true;
            }
        } 
    });
    
    
    function getproductlist(storeId , CatId){
           
        $.ajax({
            type:'ajax',
            dataType:'json',
            url:'<?= site_url('/urban_piper/getproductplatform/')?>'+storeId+'/'+CatId,
            async:false,
            success:function(result){
                $('#product_list').html(result);              
            },error:function(){
                console.log('error');
            }    
        });
        $('#productlist').DataTable(); 
    }
     
    // Action on button
    function category_status(){
         var args = arguments;
         var action     = (args[4])?args[4]:'';
         var new_status = (args[5])?args[5]:'';
         
         /*
          * Para: 
          *         [0] : Action Alert Title
          *         [1] : Action Type
          *         [2] : Item Id
          *         [3] : Store Id
          *         [4] : Action
          *         [5] : New Status
          */
         
         var passdata = 'onclick="action_call(\''+args[1]+'\',\''+args[2]+'\',\''+args[3]+'\',\''+action+'\',\''+new_status+'\')"';
             
        $('#modeltitle').html('confirmation');
        $('#showmsg').html('Are you sure  '+ args[0]+ ' on urbanpiper portal?');
        $('#btnokaction').html('Test');
        modal.style.display = "block";
        $('#btnokaction').html('<button type="button" class="btn btn-success" '+passdata+'>Ok</button>');
    }
    
    // Action on button
    function change_product_status(action_type, item_id, store_id, action, new_status){
        
         //PARA: action_type = Single_Store_Product       
        var passdata = 'onclick="action_call(\''+action_type+'\',\''+item_id+'\',\''+store_id+'\',\''+action+'\',\''+new_status+'\')"';
             
        $('#modeltitle').html('confirmation');
        $('#showmsg').html('Are you sure to '+new_status+' product on sale portal?');
        $('#btnokaction').html('Test');
        modal.style.display = "block";
        $('#btnokaction').html('<button type="button" class="btn btn-success" '+passdata+'>Ok</button>');
    }
    
    function action_call(){
        //$('#ajaxCall').show();  
        modal.style.display = "none";
        $('#btnokaction').html('');
       
        var pass='';
        pass = arguments[0]+"/"+arguments[1]+"/"+arguments[2]+"/"+arguments[3]+"?action="+arguments[4];
       
      var  action_type  =  arguments[0];
      var  item_id      =  arguments[1];
      var  store_id     =  arguments[2];
      var  action       =  arguments[3];
      var  new_status   =  arguments[4];
       
        $('#tdstatus_'+arguments[1]).html('<img src="<?= base_url('assets/images/ajax-loader.gif'); ?>" alt="Please Wait.." />');
                             
        setTimeout(function(){
            $.ajax({
	           type:'ajax',
	           dataType:'json',
	           url:'<?= site_url("urban_piper/action/") ?>'+pass,
	           async:false,
	           success:function(result){
                       
                      // console.log(result);
	           	//$('#ajaxCall').hide();
                                                
                        
	               if(result.status=='success'){
	                    $('#showmsg').html('<span class="text-success"> '+result.messages+'</span>');
	                    //setTimeout(function(){getproductlist('<?=$store_info->id?>');},1000);
                             
                            if(new_status == 'Disable'){ 
                                btnname = 'Disable';
                                classnm = 'btn-danger';
                                new_status = 'Enable';
                            } else {
                                btnname = 'Enable';
                                classnm = 'btn-success';
                                new_status = 'Disable';
                            }
                            var changebtn = '<span class="btn btn-small '+classnm+'" onclick="change_product_status(\''+action_type+'\',\''+item_id+'\','+store_id+',\''+action+'\',\''+new_status+'\')">'+btnname+'</span>';
                            
                            $('#tdstatus_'+item_id).html(changebtn);
                            
	               } else {
	                    $('#showmsg').html('<span class="text-danger"> '+result.messages+'</span>');
                            
                            if(new_status == 'Disable'){ 
                                btnname = 'Enable';
                                classnm = 'btn-success';
                            } else {
                                btnname = 'Disable';
                                classnm = 'btn-danger';
                            }
                            var changebtn = '<span class="btn btn-small '+classnm+'" onclick="change_product_status(\''+action_type+'\',\''+item_id+'\','+store_id+',\''+action+'\',\''+new_status+'\')">'+btnname+'</span>';
                            
                             $('#tdstatus_'+item_id).html(changebtn);        
                            
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
     $('#msgclose').click(function(){
        $('#errormsg').hide();
    });
    
    $('#store_categories').change(function(){
        
        var CatId = $(this).val();
        
        getproductlist('<?=$store_info->id?>' , CatId);
    });
    
</script>    