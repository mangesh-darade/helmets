<style>
    .select2-container-multi{
        height: auto;
    }
</style>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-plus"></i><?= lang('Add Store'); ?></h2>
    </div>
    <div class="box-content">
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
                 <?php }/*else if($this->session->flashdata('error')){ ?>
                        <div class="alert alert-danger" id="msg">
                            <?=  $this->session->flashdata('error') ?>            
                        </div>
                <?php }*/ ?>
               
                
                
                <?php $attrib = array( 'data-toggle' => 'validator','role' => 'form'); //
                echo form_open("urban_piper/addgroup", $attrib);
                ?>
                
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"> Title <span> * </span> </label>
                            <input type="text" class="form-control" required="true" name="title" value="<?= set_value('title') ?>" placeholder="Title" id="title"/>
                        </div>
                    </div>  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"> Code <span> * </span> </label>
                            <input type="text" class="form-control" required="true" name="code" value="<?= set_value('code') ?>" placeholder="Code" id="goptcode"/>
                        </div>
                    </div>    
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"> Min Selectable  </label>
                            <input type="number" class="form-control"  name="min_selectable" value="<?= set_value('min_selectable') ?>" placeholder="Min Selectable" id="min_selectable"/>
                        </div>
                    </div>  
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="control-label"> Max Selectable </label>
                            <input type="number" class="form-control"  name="max_selectable" value="<?= set_value('max_selectable') ?>" placeholder="Max Selectable" id="max_selectable"/>
                        </div>
                    </div>    
                </div>
                
                <div class="row">
                    <div class="col-sm-12">
                        <label class="control-label">Products <span>*</span> </label>
                        <select class="form-control" name="item_code[]" required="true" multiple="multiple" data-placeholder="Select Product" >
                           <?php foreach($products as $products_list){ ?>
                            <option value="<?= $products_list->code ?>"><?= $products_list->name ?> (<?= $products_list->code ?>) </option>
                           <?php } ?> 
                        </select>    
                    </div>
                </div>
                <br/>
                <div class="row">
                    <div class="col-sm-6">
                        <button type="submit" class="btn btn-success" > Save </button> 
                        <button type="button" onclick="window.location='<?= site_url('urban_piper/groups_option') ?>'" class="btn btn-primary" > Back </button> 
                    </div>
                </div>
                <?= form_close(); ?>
            </div>
        </div>
    </div>    
</div>    

<script>
    $(document).ready(function(){
         get_warehouse_details($('#warehouse').val())
         
    });
    
    $('#warehouse').change(function(){
         get_warehouse_details($(this).val())
    }); 
    
    function get_warehouse_details(){
        $.ajax({
            type:'ajax',
            dataType:'json',
            method:'get',
            url:'<?= site_url() ?>/urban_piper/getstore_details/'+arguments[0],
            async:false,
            success:function(data) {
               document.getElementById('email').value=data.email;
               document.getElementById('name').value=data.name;
               document.getElementById('code').value=data.code;
               document.getElementById('address').value=data.address;
               document.getElementById('contact_phone').value=data.phone;
            },error:function(){
                console.log('error');
            }  
        });
    }
     $('#msgclose').click(function(){
        $('#errormsg').hide();
    });
   
</script>    
