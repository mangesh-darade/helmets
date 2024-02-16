 <?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
    .btn, .form-control {border-radius: 4px !important;}
    .offeraction{text-decoration: none  !important;}
</style>
<?php $getdefaultoffet = $this->db->select('active_offer_category')->get('sma_pos_settings')->row();?>
<div class="box">
    <div class="box-header">
        <div class="col-sm-6">
            <h2 class="blue"><i class="fa-fw fa fa-gift"></i><?= lang('offers_and_discount'); ?></h2>
       </div>
        <div class="col-sm-6">
            
            <button onclick="window.location='system_settings/offerdiscount'" class=" pull-right btn btn-primary " > <i class="fa fa-plus" aria-hidden="true"></i> Offer</button>
        </div>  
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <label class="col-sm-2">Offer Category  : </label>
                  <div class="col-sm-6 ">
                      
                    <select class="form-control" name="offercategory" id="offercategory">
                        <option value=""> Select Offer Category </option>
                        <?php  foreach($offercategory as $offer){ ?>
                        <option value="<?= $offer->offer_keyword?>"> <?= $offer->offer_category ?> </option>
                        <?php } ?>
                    </select>
                </div>
                <div class="table-responsive" id="databody"> </div>   
            </div>
        </div>
    </div>    
</div>  


<script type="text/javascript">
$(document).ready(function() {
    
     var offer ='';
     if(localStorage.getItem('offeractive')==null){
         offer = '<?= $getdefaultoffet->active_offer_category ?>';
     }else{
        offer = localStorage.getItem('offeractive');

        
     }
      $('#offercategory').val(offer).trigger('change');
     getofferlist(offer);
});

$('#offercategory').change(function(){
     localStorage.removeItem('offeractive');
     localStorage.setItem('offeractive', $('#offercategory').val());
     getofferlist(localStorage.getItem('offeractive')); 
     
});

function getofferlist(getofferkey){
    $.ajax({
        dataType:'json',
        type:'ajax',
        method:'get',
        url:'<?= base_url() ?>system_settings/getofferlist/'+getofferkey,
        async:false,
        success:function(result){
            $('#databody').html(result);
        },error:function(){
            console.log('error');
        }
        
    });
     $('#offertable').DataTable({
         "destroy": true,
     });
}





</script>    