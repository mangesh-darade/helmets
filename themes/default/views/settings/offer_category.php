 <?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box">
    <div class="box-header">
        <div class="col-sm-6">
            <h2 class="blue"><i class="fa-fw fa fa-gift"></i> Offer Category</h2>
       </div>
        <div class="col-sm-6">
            
            
        </div>  
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive" id="showtable">
                   
                    
                </div>   
            </div>
        </div>
    </div>    
</div>  

<!-- Edit  Modal -->






<!-- The Modal -->
<div id="myModal" class="modal" role="dialog">
<div class="modal-dialog">
  <!-- Modal content -->
  <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
          <h4 class="modal-title" id="modeltitle"></h4>
        </div>
        <div class="modal-body">
            <form id="categoty_status" >
                <input type="hidden"  name="id" id="passid"/>
                <input type="hidden"  name="keytype" id="keytype"/>
                <input type="hidden"  name="value" id="keyvalue" class="form-control"/>
            
            <h3 class="text-center" id="showmsg"></h3>
        </div>
        <div class="modal-footer">
            <button type="button" id="submitbtn" class="btn btn-success">Ok</button>
            </form>
            <button type="button" id="closemodel" class=" btn btn-danger" >Close</button>
        </div>
      </div>
</div>
</div>
    
<script type="text/javascript">
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
    
    $(document).ready(function() {
      //  model.hide();
     
        getofferlist();
    });    
    
    function getofferlist(){
        $.ajax({
            dataType:'json',
            type:'ajax',
            method:'get',
            url:'<?= base_url() ?>system_settings/getcategory/',
            async:false,
            success:function(result){
                $('#showtable').html(result);
            },error:function(){
                console.log('error');
            }

        });
        $('#offertable').DataTable({
            "destroy": true,
        });
    }
    
    
    function myfunction(){
        var getid = arguments[0];
        var getvalue=arguments[1];
        var getkey=arguments[2];
        document.getElementById('passid').value=getid;
        document.getElementById('keytype').value=getkey;
        document.getElementById('keyvalue').value=getvalue;

        if(getkey=='status'){
            $('#modeltitle').html('Status Change');
            $('#showmsg').html('Are You Sure Change Status?');
             document.getElementById('keyvalue').type='hidden';
            $('#submitbtn').show();
        }else if(getkey=='edit'){
            $('#modeltitle').html(' Offer Category Update');
             document.getElementById('keyvalue').type='text';
            $('#showmsg').html('');
            $('#submitbtn').show();
        }    
          modal.style.display = "block";
          
          
    }
    
    $('#submitbtn').click(function(){
        var data_pass = $('#categoty_status').serialize();
            var msg;
            if($('#keytype').val()=='status'){
                msg = 'Status ';
            }else if($('#keytype').val()=='edit'){
                msg = 'Offer Category ';
            } 
           
        
        actionform(data_pass,msg);
        
    });
    
    function actionform(passdata,msg){
        $.ajax({
            type:'ajax',
            dataType:'json',
            url:'<?= base_url() ?>system_settings/offer_category_action',
            method:'get',
            data:passdata,
            async:false,
            success:function(result){
                 modal.style.display = "none";
                 document.getElementById('keyvalue').type='hidden';
                if(result== 'TRUE'){
                    $('#modeltitle').html(msg+' Update');
                    $('#showmsg').html('<span class="text-success">'+ msg+' update successfully!</span>');
                }else{
                    $('#modeltitle').html(msg+' Update');
                    $('#showmsg').html('<span class="text-danger">'+msg+' not update, Please try again later</span>');
                }
                $('#submitbtn').hide();
                modal.style.display = "block";
                getofferlist();
               
            },error:function(){
                modal.style.display = "block";
            }    
        });
    }
    
//    $('#statuschange').click(function(){
//        alert($(this).val());
//    });
</script>    