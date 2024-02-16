<?php
defined('BASEPATH') OR exit('No direct script access allowed');

?>

<?= form_open('', 'id="action-form"') ?>
 
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-folder-open"></i><?= lang(' Add New Printer'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row form-group all">
            <div class="col-lg-12"> 
                <div class="col-lg-1"> </div> 
                <div class="col-lg-2"><b>Name *</b> </div>
                <div class="col-lg-4"><input type="text" name="name" value="" class="form-control tip" required="required"/> </div> 
            </div>
        </div>  
        <div class="row form-group all">
            <div class="col-lg-12"> 
                <div class="col-lg-1"> </div> 
                <div class="col-lg-2"><b>Width *</b> </div>
                <div class="col-lg-4"><input type="text" name="width" value="" class="form-control tip" required="required"/> </div> 
            </div>
        </div>      
         <div class="row form-group all">
            <div class="col-lg-12"> 
                <div class="col-lg-1"> </div> 
                <div class="col-lg-2">  </div>
                <div class="col-lg-4"> <?= form_submit('submit', 'Add', 'id="action-form-submit" class="btn btn-primary"') ?> </div> 
            </div>
        </div> 
    </div>    
</div>   

<?= form_close() ?>
 