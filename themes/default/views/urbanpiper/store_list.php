<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
   .btn-small{padding: 1px 5px;
    border-radius: 4px !important;
    font-size: 12px;}
   .loaderclass{position:absolute;left:0;right:0;top:0;bottom:0;margin:auto; background: #FFF; }
   .delete_up_store{
	   color: #fff;
    background: red;
    padding: 2px;
    border-radius: 4px;
    font-size: 12px;
   }
</style>    
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-barcode"></i><?= lang('UrbanPiper Store')  ?>
        </h2>
 <?php if($addnewstores) { ?>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <button class="btn btn-primary"  onclick="window.location='<?= site_url('urban_piper/add_store') ?>'" ><i class="fa fa-plus"></i> Store</button>
                </li>
            </ul>
        </div>   
        <?php } ?>
    </div>
    
     <?php if($this->session->flashdata('success')){ ?>
             <div class="alert alert-success" id="errormsg">
                  <button type="button" class="close fa-2x" id="msgclose">&times;</button>
                  <?=  $this->session->flashdata('success') ?>            
            </div>
    <?php }else if($this->session->flashdata('error1')){ ?>
             <div class="alert alert-danger" id="errormsg">
                 <button type="button" class="close fa-2x" id="msgclose">&times;</button>
                 <?=  $this->session->flashdata('error1') ?>            
             </div>
    <?php }?>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive" id="store_list">

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
                <span id="okbtn"></span>
                <button type="button" id="closemodel" class=" btn btn-danger" >Close</button>
            </div>
          </div>
    </div>
</div>
<!-- End Message model --->


<script>
function delete_up_store(Id){
	if(!confirm("Are you sure, you want to delete?")){
		return false;
	}
	
	$.ajax({type:'get', url: '<?php echo site_url('urban_piper/delete_up_store'); ?>', data:{id:Id}, success: function(result){
		$('#tr_'+Id).hide();
    //alert(result);
  }});
}
    $(document).ready(function(){
        
         getstore();
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

    function store_status(){
        var args = arguments;
         var exarg = (args[3])?args[3]:'';
         var passdata = 'onclick="action_call(\''+args[1]+'\',\''+args[2]+'\',\''+exarg+'\')"';
        $('#modeltitle').html('confirmation');
         var exmsg = (args[0]=='add')?' on urbanpiper portal':'';
        $('#showmsg').html('"Are you sure to '+ args[0]+ ' this  store'+exmsg+'?"');
        modal.style.display = "block";
        $('#okbtn').html('<button type="button" class="btn btn-success" '+passdata+'>Ok</button>');
       
    }
    
    function action_call(){
         modal.style.display = "none";
         $('#ajaxCall').show();  
         $('#okbtn').html('');
        var pass='';
        pass = arguments[0]+"/"+arguments[1];
        if(arguments[2]){
            pass +="/"+arguments[2];
        }
        setTimeout(function(){
            $.ajax({
                type:'ajax',
                dataType:'json',
                url:'<?= site_url("urban_piper/action/") ?>'+pass ,
                async:false,
                success:function(result){
                    if(result.status=='success'){
                         $('#showmsg').html(result.messages);
                    }else{
                         $('#showmsg').html(result.messages);
                    }
                    $('#modeltitle').html('message');
                    modal.style.display = "block";
                    getstore();
               },error:function(){
                   console.log('error');

               }     
           });
           },100);   
    }
    
    
    
    
    function getstore(){
        $.ajax({
           type:'ajax',
           dataType:'json',
           url:'<?= site_url() ?>/urban_piper/getstore',
           async:false,
//           beforeSend: function(){
//               $('#pageloader').show();
//           },
           success:function(result){
              $('#store_list').html(result);
            },error:function(){
              console.log('error');
            } 
        });
        $('#storelist').DataTable(); 
    }
    
    $('#msgclose').click(function(){
        $('#errormsg').hide();
    });
</script>    