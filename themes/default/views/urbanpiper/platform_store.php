<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
   .btn-small{padding: 1px 5px;
    border-radius: 4px !important;
    font-size: 12px;}
   .loaderclass{position:absolute;left:0;right:0;top:0;bottom:0;margin:auto; background: #FFF; }
   
</style>    
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-barcode"></i><?= lang('UrbanPiper Store')  ?>
        </h2>
         
       
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
                    <table class="table table-bordered table-hover table-striped">
                        <thead>
                            <th style="width: 7%;" > Sr. No.</th>
                            <th>Name</th>
                            <th>Reference No.</th>
                            <th>Category</th>
                            <th>Products</th>
                        </thead>
                        <tbody>
                            <?php 
                                $sr=1; 
                                foreach($store_list as $store_list){ ?>
                            <tr>
                                <td><?= $sr ?></td>
                                <td><?= $store_list->name ?></td>
                                <td><?= $store_list->ref_id ?></td>
                                <td class="text-center"><button class="btn btn-primary btn-small" id="product_list" onclick="window.location='<?= site_url('urban_piper/category/').$store_list->id ?>'"  >Category</button></td>
                                <td class="text-center"><button class="btn btn-primary btn-small" id="product_list" onclick="window.location='<?= site_url('urban_piper/platfrom_product_list/').$store_list->id ?>'">Products</button></td>
                            </tr>
                            <?php $sr++; } ?>
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
                <span id="okbtn"></span>
                <button type="button" id="closemodel" class=" btn btn-danger" >Close</button>
            </div>
          </div>
    </div>
</div>
<!-- End Message model --->
<script type="text/javascript">
    $('#msgclose').click(function(){
        $('#errormsg').hide();
    });
</script>  