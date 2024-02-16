<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
    hr{height: 0.05em;
    background: #cccccc;}
    .select2-container-multi{height: auto;}
</style>
<?php 
    function get_times( $default = '', $interval = '+30 minutes' ) {

    $output = "<option value=''>Any Time</option>";

    $current = strtotime( '00:00' );
    $end = strtotime( '23:59' );

    while( $current <= $end ) {
        $time = date( 'H:i', $current );
        $sel = ( $time == $default ) ? ' selected' : '';
        
        $output .= "<option value=\"{$time}\"{$sel}>" . date( 'h.i A', $current ) .'</option>';
        $current = strtotime( $interval, $current );
    }

    return $output;
}
?>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-gift"></i><?= lang('offers_and_discount'); ?></h2>
        <?php if(isset($pos->purchase_code) && ! empty($pos->purchase_code) && $pos->purchase_code != 'purchase_code') { ?>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown"><a href="<?= site_url('pos/updates') ?>" class="toggle_down"><i
                            class="icon fa fa-upload"></i><span class="padding-right-10"><?= lang('updates'); ?></span></a>
                </li>
            </ul>
        </div>
        <?php } ?>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <p class="introtext"><?= lang('update_info'); ?></p>
                <?php
                $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id' => 'pos_setting');
                echo form_open("system_settings/offerdiscount","id='offerform'");//, $attrib
                ?>
               
                <fieldset class="scheduler-border">
                        <div class="form-group row">
                            <label class="col-sm-3" > <?= lang('Offers_Category')  ?> * </label>
                            <div class="col-sm-8">
                                <?php //print_r($offers_categories); ?>
                                <select name="offer_category_id" class="form-control" id="offers_category" required="required" style="width:100%;" >
                                    <option value="">Select Offer</option>
                                    <?php foreach($offers_categories as $offerCategory): ?>
                                    <option value="<?= $offerCategory->offer_keyword.'~'.$offerCategory->id ?>"> <?= $offerCategory->offer_category?> </option>
                                    <?php endforeach ?>
                                </select>
                                <span class="text-danger errormsg" id="categorytype"></span>
                                <?php //form_dropdown('offer_category_id', $arr1, $pos->pos_screen_products, 'class="form-control" id="offers_category" required="required" style="width:100%;"'); ?>
                            </div>
                        </div>  
                        
                        <div class="form-group row">
                            <label class="col-sm-3" > <?= lang('Offers_Name')  ?> * </label>
                            <div class="col-sm-8">
                                <?= form_input('offer_name', '', 'placeholder="Offer Name" class="form-control"  id="offer_name" '); ?>
                                <span class="text-danger errormsg" id="erroffername"></span>
                                
                            </div>
                        </div>  
                        <div class="form-group row">
                            <label class="col-sm-3"> <?= lang('Validity_Date')  ?> <span>*</span> </label>
                            <label class="col-sm-2"> <?= lang('starting_date')  ?>  </label>
                            <div class="col-sm-2">
                                <?= form_input('offer_start_date', (isset($_POST['offer_start_date']) ? $_POST['offer_start_date'] : ""), 'placeholder="Offer Start Date"  autocomplete="off" class="form-control date " onchange="date_validation()" id="offer_start_date" '); ?>
                                <span class="text-danger errormsg" id="erroffer_start_date"></span>
                            </div>
                           <label class="col-sm-2"> <?= lang('end_date')  ?>  </label>
                            <div class="col-sm-2">
                                <?= form_input('offer_end_date', (isset($_POST['offer_end_date']) ? $_POST['offer_end_date'] : ""), 'placeholder="Offer End Date" autocomplete="off"  class="form-control date " onchange="date_validation()" id="offer_end_date" '); ?>
                                <span class="text-danger errormsg" id="erroffer_end_date"></span>

                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <label class="col-sm-3"> <?= lang('Specific_Time')  ?> <span>*</span> </label>
                            <label class="col-sm-2"> <?= lang('from_time')  ?>  </label>
                            <div class="col-sm-2"> 
                                <select class="form-control"  name="offer_start_time" id="offer_start_time">
                                    <?php echo get_times(); ?>
                                </select> 
                                <span class="text-danger errormsg"  id="erroffer_start_time"></span>
                            </div>
                            <label class="col-sm-2"> <?= lang('to_time')  ?>  </label>
                            <div class="col-sm-2">
                                <select class="form-control"  name="offer_end_time" id="offer_end_time">
                                    <?php echo get_times(); ?>
                                </select>  
                                 <span class="text-danger errormsg"  id="erroffer_end_time"></span>
                            </div>
                        </div>
                    
                        <div class="form-group row">
                            <label class="col-sm-3" style="padding-top: 0.5em;"> <?= lang('Days')  ?> <span>*</span> </label>
                            <div class="col-sm-8">
                                <table class="table table-bordered text-center">
                                    <tr>
                                        <td> 
                                            <input type="checkbox" class="checkbox checkth input-xs " id="all_days" >
                                            <label for="all_days"> All </label>
                                            
                                        </td>
                                        <td> 
                                            <input type="checkbox" value="0" class="days multi-select input-xs select_custom_day"  name="offer_on_days[]" id="sun" >
                                            <label for="sun">SUN </label>
                                           
                                        </td>
                                        <td> 
                                            <input type="checkbox"   value="1" class=" days multi-select input-xs select_custom_day" name="offer_on_days[]" id="mon" >
                                            <label for="mon"> MON </label>
                                            
                                        </td>
                                        <td> 
                                             <input type="checkbox" value="2" class=" days multi-select input-xs select_custom_day"   name="offer_on_days[]" id="tue" >
                                            <label for="tue">TUE </label>
                                           
                                        </td>
                                        <td>  
                                             <input type="checkbox"  value="3" class=" days multi-select input-xs select_custom_day" name="offer_on_days[]" id="wed" >
                                            <label for="wed">WED </label>
                                           
                                        </td>
                                        <td>  
                                             <input type="checkbox"  value="4" class=" days multi-select input-xs select_custom_day" name="offer_on_days[]"id="thu" >
                                            <label for="thu">THU </label> 
                                           

                                        </td>
                                        <td>  
                                            <input type="checkbox" value="5" class=" days multi-select input-xs select_custom_day"  name="offer_on_days[]" id="fri" >
                                            <label for="fri">FRI </label>
                                            
                                        </td>
                                        <td>  
                                             <input type="checkbox" value="6" class=" days multi-select input-xs select_custom_day"  name="offer_on_days[]" id="sat" >
                                            <label for="sat">SAT </label>
                                           

                                        </td>
                                        
                                    </tr>    
                                </table>  
                                <span class="text-danger errormsg"  id="erroffer_days"></span>
                            </div>    
                        </div>
                    
                        <div class="form-group row">
                            <label class="col-sm-3">Offer On Warehouse <span>*</span> </label>
                            <div class="col-sm-8">
                                <?php
                                    $wh = array();
                                    $wh[0] = "";
                                    foreach ($warehouses as $warehouse) {
                                        $wh[$warehouse->id] =   $warehouse->name;
                                    }
                                    $_warehouse = '';
                                    if (isset($_POST['warehouse'])) {
                                        $_warehouse = $_POST['warehouse'];
                                    }
                                    echo form_multiselect('offer_on_warehouses[]', $wh, $pos->default_eshop_warehouse, 'class="form-control" id="offer_on_warehouses" required="required" data-role="materialtags"  style="width:100%;"');
                                    ?>
                                <span class="text-danger errormsg"  id="erroffer_on_warehouses"></span>
                            </div>    
                        </div> 
                     
                        <div class="hideshowelement" id="block_offer_on_category"  >
                            <div class="form-group row">

                                <label class="col-sm-3" > Offer On Category  <span>*</span> </label>
                                <div class="col-sm-8">
                                     <select name="offer_on_category[]" class="form-control requiredfield"  id="offer_on_category"  multiple="multiple"  style="width:100%;">
                                      
                                        <?php foreach($category_list as $catlist): ?>
                                        <option value="<?= $catlist->id ?>"><?= $catlist->name.'('.$catlist->code.')' ?></option>
                                        <?php endforeach; ?>
                                    </select>  
                                    <span class="text-danger errormsg" id="erroffer_on_category" ></span>
                                </div>
                            </div>    
                        </div> 
                    
                        <div class="hideshowelement" id="block_offer_on_category_quantity"  >
                           <div class="form-group row "  >
                                <label class="col-sm-3" > Offer On Category Quantity  <span>*</span> </label>
                                <div class="col-sm-8">
                                    <input type="number" min="0" max="1000" name='offer_on_category_quantity' value="<?= (isset($_POST['offer_on_category_quantity']))? $_POST['offer_on_category_quantity'] :''?>"  placeholder="Quantity" autocomplete="off" class="form-control requiredfield" id="offer_on_category_quantity" />
                                    <span class="text-danger errormsg" id="erroffer_on_category_quantity" ></span>
                                </div>
                            </div>
                        </div>
                    
                        <div class="hideshowelement" id="block_offer_on_category_amount"  >
                             <div class="form-group row "  >
                                <label class="col-sm-3" > Offer On Category Amount <span>*</span>  </label>
                                <div class="col-sm-8">
                                   <input type="number" maxlength="5" name='offer_on_category_amount' value="<?= (isset($_POST['offer_on_category_amount']))? $_POST['offer_on_category_amount'] :''?>" placeholder="Offer On Category Amount"  autocomplete="off" class="form-control requiredfield" id="offer_on_category_amount" />
                                <span class="text-danger errormsg" id="erroffer_on_category_amt" ></span>
                                </div>
                           </div>    
                        </div>
                    
                        <div class="hideshowelement" id="block_offer_on_brands"  >
                            <div class="form-group row"  >
                                <label class="col-sm-3" > <?= lang('offer_on_brands')  ?>   </label>
                                <div class="col-sm-8">
                                    <select name="offer_on_brands[]" class="form-control requiredfield" id="offer_on_brands"   multiple="multiple" style="width:100%;">
                                      
                                        <?php foreach($brands_list as $brdlist): ?>
                                        <option value="<?= $brdlist->id ?>"><?= $brdlist->name ?></option>
                                        <?php endforeach; ?>
                                    </select>  
                                  
                                </div>
                           </div>    
                        </div> 
                    
                        <div class="hideshowelement" id="block_offer_on_invoice_amount"  >
                            <div class="form-group row "  >
                                <label class="col-sm-3" > Offer On Invoice Amount <span>*</span> </label>
                                <div class="col-sm-2">
                                    <input type="number"  maxlength="5" name='offer_on_invoice_amount' value="<?= (isset($_POST['offer_on_invoice_amount']))? $_POST['offer_on_invoice_amount'] :''?>" placeholder="Amount"   autocomplete="off" class="form-control requiredfield" id="offer_on_invoice_amount" />
                                    <span class="text-danger errormsg" id="erroffer_on_invoice_amount"></span>
                                </div>
                            </div>
                        </div>
                       
                        <div class="hideshowelement" id="block_offer_on_products" >
                            <div class="form-group row">
                                <label class="col-sm-3" >Offer On Products <span>*</span>   </label>
                                <div class="col-sm-8">
                                    <select name="offer_on_products" class="form-control requiredfield"  id="offer_on_products"   style="width:100%;">
                                        <option value="" >Select Product</option>
                                        <?php foreach($product_list as $prdlist): ?>
                                        <option value="<?= $prdlist->id ?>"><?= $prdlist->name .'('.$prdlist->code.')' ?></option>
                                        <?php endforeach; ?>
                                    </select>    
                                    <span class="text-danger errormsg" id="errofferonproduct"> </span>
                                </div>
                             </div>
                        </div>
                    
                        <div class="hideshowelement" id="block_offer_on_products_multiple" >
                            <div class="form-group row">
                                <label class="col-sm-3" >Offer On Products  <span>*</span>   </label>
                                <div class="col-sm-8">
                                    <select name="offer_on_products_multiple[]" class="form-control requiredfield" id="offer_on_products_mullti" multiple="multiple"   style="width:100%;">
                                        <?php foreach($product_list as $prdlist): ?>
                                        <option value="<?= $prdlist->id ?>"><?= $prdlist->name .'('.$prdlist->code.')' ?></option>
                                        <?php endforeach; ?>
                                    </select>    
                                    <span class="text-danger errormsg" id="errofferonproductmulti"> </span>
                                </div>
                            </div>
                        </div>
                    
                        <div class="hideshowelement" id="block_offer_on_quantity" >
                            <div class="form-group row">
                             <label class="col-sm-3" ><?= lang('Products_Quantity')  ?> <span>*</span>  </label>
                                <div class="col-sm-2">
                                    <input type="number" min="0" max="1000" name='offer_on_products_quantity' value="<?= (isset($_POST['offer_on_products_quantity']))? $_POST['offer_on_products_quantity'] :''?>" placeholder="Quantity"  autocomplete="off" class="form-control requiredfield" id="offer_on_products_quantity" />
                                </div>
                             <span class="text-danger errormsg" id="errofferonproductquantity"> </span>
                            </div>
                        </div>
                    
                        <div class="hideshowelement" id="block_offer_items_condition" >
                            <div class="form-group row">
                                <label class="col-sm-3" ><?= lang('Minimum Products')  ?>  <span>*</span> </label>
                                <div class="col-sm-8">
                                    <select class="form-control requiredfield" name="offer_items_condition" id="offer_items_condition">
                                        <option value="">Select Minimum Product</option>
                                        <option value="1">Any Product</option>
                                        <?php for($i=2; $i<=10;$i++){ ?>
                                        <option value="<?= $i; ?>">Any <?= $i; ?> Product</option>
                                        <?php } ?>
                                    </select>
                                    <span class="text-danger errormsg" id="erroffer_items_condition"> </span>
                                </div>
                            </div>
                        </div>
                    
                        <div class="hideshowelement" id="block_offer_on_products_amount" >
                           <div class="form-group row" >
                                <label class="col-sm-3" >Offer On Product Amount  <span>*</span> </label>
                                <div class="col-sm-8">
                                    <input type="number" min="0"  name="offer_on_products_amount"  value="<?= (isset($_POST['offer_on_products_amount']))? $_POST['offer_on_products_amount'] :''?>"  placeholder="Offer on products amount"  autocomplete="off" class="form-control requiredfield" id="offer_on_products_amount" />
                                    <span class="text-danger errormsg" id="erroffer_on_products_amount"></span>
                                </div>
                            </div>    
                        </div>
                    
                        <div class="hideshowelement" id="block_offer_amount_including_tax" >
                            <div class="form-group row" >
                                <label class="col-sm-3" > Offer Amount Including Tax </label>
                                <div class="col-sm-8">
                                    <input type="radio" name="offer_amount_including_tax" checked class="requiredfield" value="0" id="offerWithout_Tax"> 
                                    <label for="offerWithout_Tax">No</label>
                                    &nbsp;
                                    <input type="radio" name="offer_amount_including_tax" class="requiredfield" value="1" id="offerIncluding_Tax"> 
                                    <label for="offerIncluding_Tax"> Yes</label>
                                </div>
                            </div>    
                        </div>
                    
                    
                        <div class="hideshowelement" id="block_offer_free_products"  >
                            <div class="form-group row"  > 
                                <label class="col-sm-3" >Offer Free Products   <span>*</span> </label>
                                <div class="col-sm-8">
                                    <select name="offer_free_products" class="form-control requiredfield " id="offer_free_products"  style="width:100%;" placeholder="Select Product">
                                        <option value="" >Select Product</option>
                                        <?php foreach($product_list as $prdlist): ?>
                                        <option value="<?= $prdlist->id ?>"><?= $prdlist->name.'('.$prdlist->code.')' ?></option>
                                        <?php endforeach; ?>
                                    </select> 
                                    <span class="text-danger errormsg" id="errofferonffreeproduct"></span>
                                </div>
                            </div>    
                        </div>
                    
                       <div class="hideshowelement" id="block_offer_free_quantity"  >
                            <div class="form-group row" >
                                <label class="col-sm-3" >Free <?= lang('Products_Quantity')  ?>  <span>*</span> </label>
                                <div class="col-sm-2">
                                    <input type="number" min="0" max="1000" name='offer_free_products_quantity' value="<?= (isset($_POST['offer_free_products_quantity']))? $_POST['offer_free_products_quantity'] :''?>" placeholder="Quantity"  autocomplete="off" class="form-control requiredfield" id="offer_free_products_quantity" />
                                </div>
                                <span class="text-danger errormsg" id="errofferonfreeproductquantity"></span>
                            </div>
                        </div>
                    
                        <div class="hideshowelement" id="block_offer_discount_rate">
                            <div class="form-group row">
                                <label class="col-sm-3" ><?= lang('Offer_Discount_Rate_Amt')  ?>  <span>*</span> </label>
                                <div class="col-sm-2">
                                    <input type="text" maxlength="5" name='offer_discount_rate' value="<?= (isset($_POST['offer_discount_rate']))? $_POST['offer_discount_rate'] :''?>" placeholder="Rate"  autocomplete="off" class="form-control requiredfield" id="offer_discount_rate" />
                                </div>
                                <span class="text-danger errormsg" id="erroffer_discount_rate"></span>
                            </div>
                        </div> 
                   
                        <div class="" id=""  >
                            <div class="form-group row">
                                 <label class="col-sm-3" ><?= lang('Invoice Note')  ?> </label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control " name="offer_invoice_descriptions" placeholder=" Invoice Note"/>
                                    </div>
                            </div>   
                        </div>
                        
                    </fieldset>    
                <button type="Submit" class="btn btn-primary" id="form_validation"> Save </button>
                <button type="button" class="btn btn-primary" onclick="window.location='system_settings/offer_list'" > Back </button>

                <?= form_close(); ?>
            </div>

        </div>
    </div>
</div>

<script type="text/javascript">
  
    $(document).ready(function(){
        $('.hideshowelement').hide();
       
    });  
    // Offer Show Form Fields 
    $('#offers_category').on('change',function(){
        var str = $(this).val();
        var get_offer = str.split("~");
        switch(get_offer[0]){
            case "BUY_X_GET_Y_FREE":
                    $('.hideshowelement').hide();
                    $('#block_offer_on_products').show();
                    $('#block_offer_on_quantity').show();
                    $('#block_offer_free_products').show();
                    $('#block_offer_free_quantity').show();
                break;
            case "DISCOUNT_ON_CATEGORY_AMOUNTS":
                    $('.hideshowelement').hide();
                    $('#block_offer_on_category').show();
                    $('#block_offer_on_category_amount').show();
                    $('#block_offer_amount_including_tax').show();
                    $('#block_offer_discount_rate').show(); 
                break;
            case "FREE_ITEM_ON_CATEGORY_AMOUNTS":
                   
                    $('.hideshowelement').hide();
                    $('#block_offer_on_category').show();
                    $('#block_offer_on_category_amount').show();
                    $('#block_offer_amount_including_tax').show();
                    $('#block_offer_free_products').show();
                    $('#block_offer_free_quantity').show();
                   
                break;
            case "DISCOUNT_ON_CATEGORY_QTY":
                    $('.hideshowelement').hide();
                    $('#block_offer_on_category').show();
                    $('#block_offer_on_category_quantity').show();
                    $('#block_offer_discount_rate').show(); 
                
                break;
            case "FREE_ITEM_ON_CATEGORY_QTY":
                    $('.hideshowelement').hide();
                    $('#block_offer_on_category').show();
                    $('#block_offer_on_category_quantity').show();
                    $('#block_offer_free_products').show();
                    $('#block_offer_free_quantity').show();
                
                break;
            case "DISCOUNT_ON_GROUPING_AMOUNTS":
                    $('.hideshowelement').hide();
                    $('#block_offer_on_category').show();
                    $('#block_offer_on_products_multiple').show();
                    $('#block_offer_items_condition').show();
                    $('#block_offer_on_products_amount').show();
                    $('#block_offer_amount_including_tax').show();
                    $('#block_offer_discount_rate').show(); 
                break;
            case "FREE_ITEM_ON_GROUPING_AMOUNTS":
                    $('.hideshowelement').hide();
                    $('#block_offer_on_category').show();
                    $('#block_offer_on_products_multiple').show();
                    $('#block_offer_items_condition').show();
                    $('#block_offer_on_products_amount').show();
                    $('#block_offer_amount_including_tax').show();
                    $('#block_offer_free_products').show();
                    $('#block_offer_free_quantity').show();
            
                break;
            case "DISCOUNT_ON_GROUPING_QTY":
                    $('.hideshowelement').hide();
                    $('#block_offer_on_category').show();
                    $('#block_offer_on_products_multiple').show();
                    $('#block_offer_on_quantity').show();
                    $('#block_offer_items_condition').show();
                    $('#block_offer_discount_rate').show(); 
            
                break;
            case "FREE_ITEM_ON_GROUPING_QTY":
                    $('.hideshowelement').hide();
                    $('#block_offer_on_category').show();
                    $('#block_offer_on_products_multiple').show();
                    $('#block_offer_on_quantity').show();
                    $('#block_offer_items_condition').show();
                    $('#block_offer_free_products').show();
                    $('#block_offer_free_quantity').show();
                break;
            case "DISCOUNT_ON_INVOICE_AMOUNT":
                    $('.hideshowelement').hide();
                    $('#block_offer_on_invoice_amount').show();
                    $('#block_offer_amount_including_tax').show();
                    $('#block_offer_discount_rate').show();
                break;
            case "FREE_ITEM_ON_INVOICE_AMOUNT":
                    $('.hideshowelement').hide();
                    $('#block_offer_on_invoice_amount').show();
                    $('#block_offer_amount_including_tax').show();
                    $('#block_offer_free_products').show();
                    $('#block_offer_free_quantity').show();
                break;
            case "DISCOUNT_ON_EVENTS":
                    $('.hideshowelement').hide();
                    $('#block_offer_on_invoice_amount').show();
                    $('#block_offer_amount_including_tax').show();
                    $('#block_offer_discount_rate').show();
                break;
            default:
           	 $('.hideshowelement').hide();
              break;
        }
        return;
    });
    // End Offer Show Form Fields
    
    // Date Validation
    function date_validation(){   
        var start_date = $('#offer_start_date').val();
        var enddate = $('#offer_end_date').val();
       if(start_date==''){
           if(enddate!=' '){
           bootbox.alert('Please Select Offer Start Date');
           $('#offer_start_date').focus();
          }
           
       }else{
          if(!enddate==' '){
            if(enddate <  start_date){
                bootbox.alert('The end date must be a valid date and later than the start date');
            }
          }  
       }
       
    };
    // End Date Validation
   
    // Form Validation
   $('#form_validation').click(function(){
		var flag=false;
       $('.errormsg').text('');
        var str = $('#offers_category').val();
        var offername = $('#offer_name').val();
        var offer_start_date = $('#offer_start_date').val();
        var offer_end_date = $('#offer_end_date').val();
        var offer_start_time = $('#offer_start_time').val();
        var offer_end_time = $('#offer_end_time').val();
        var offer_on_warehouses = $('#offer_on_warehouses').val();

       // console.log(checkboxObject.checked = true);
        if(str==''){
            $('#categorytype').html("Please Select Offer Category");
			flag=true;
        }else{
           /* if(offername==''){
                $('#erroffername').html("Enter Offer Name");
              
            }else*/
			if(offer_start_date==''){
                $('#erroffer_start_date').html("Select Start Date");
				flag=true;
            }
			if(offer_end_date==''){
                $('#erroffer_end_date').html("Select End Date");
				flag=true;
            }
			if(offer_start_time==''){
                $('#erroffer_start_time').html("Select Start Time");
				flag=true;
            }
			if(offer_end_time==''){
                $('#erroffer_end_time').html("Select End Time");
				flag=true;
            }
			if(offer_on_warehouses==null){
                $('#erroffer_on_warehouses').html("Select Warehouse");
				flag=true;
            }else{
                var offer_on_product = $("#offer_on_products").val(); 
                var offer_on_product_quantity = $('#offer_on_products_quantity').val();
                var offer_free_products =  $('#offer_free_products').val();
                var offer_free_products_quantity = $('#offer_free_products_quantity').val();
                var offer_on_category = $('#offer_on_category').val();
                var offer_on_category_amount = $('#offer_on_category_amount').val();
                var offer_discount_rate =$('#offer_discount_rate').val();
                var offer_on_category_quantity = $('#offer_on_category_quantity').val();
                var offer_on_products_mullti = $('#offer_on_products_mullti').val();
                var offer_items_condition = $('#offer_items_condition').val();
                var offer_on_products_amount = $('#offer_on_products_amount').val();
                var offer_on_invoice_amount = $('#offer_on_invoice_amount').val();
                
                var get_offer = str.split("~");
                switch(get_offer[0]){
                case "BUY_X_GET_Y_FREE":
                       if(offer_on_product==''){
                           $('#errofferonproduct').html("Please Select Product");
                         flag=true;
                       }else if(offer_on_product_quantity==''){
                            $('#errofferonproductquantity').html("Please Product Quantity");
                          flag=true;
                       }else if(offer_free_products==''){ 
                            $('#errofferonffreeproduct').html("Please Select Product");
                          flag=true;
                        }else if(offer_free_products_quantity==''){
                            $('#errofferonfreeproductquantity').html("Please Product Quantity");
                          flag=true;
                        }
                    break;
                case "DISCOUNT_ON_CATEGORY_AMOUNTS": 
                        if(offer_on_category==null){
                            $('#erroffer_on_category').html("Please Select Product Category");
							flag=true;
                        }else if(offer_on_category_amount==''){
                            $('#erroffer_on_category_amt').html("Enter Category Amount");
							flag=true;
                        }else if(offer_discount_rate==''){
                            $('#erroffer_discount_rate').html("Enter Discount Amount Or Rate");
							flag=true;
                        }
                       
                    break;
                    
                 case "FREE_ITEM_ON_CATEGORY_AMOUNTS":
                        if(offer_on_category==null){
                            $('#erroffer_on_category').html("Please Select Product Category");
							flag=true;
                        }else if(offer_on_category_amount==''){
                            $('#erroffer_on_category_amt').html("Enter Category Amount");
							flag=true;
                        }else if(offer_free_products==''){ 
                            $('#errofferonffreeproduct').html("Please Select Product");
							flag=true;
                        }else if(offer_free_products_quantity==''){
                            $('#errofferonfreeproductquantity').html("Please Product Quantity");
							flag=true;
                        }
                    break;
                    
                case "DISCOUNT_ON_CATEGORY_QTY":
                        if(offer_on_category==null){
                                $('#erroffer_on_category').html("Please Select Product Category");
								flag=true;
                        }else if(offer_on_category_quantity==''){
                             $('#erroffer_on_category_quantity').html("Enter Category Quantity");
							 flag=true;
                        }else if(offer_discount_rate==''){
                                $('#erroffer_discount_rate').html("Enter Discount Amount Or Rate");
								flag=true;
                        }
                    break;
            
                case "FREE_ITEM_ON_CATEGORY_QTY":
                        if(offer_on_category==null){
                                $('#erroffer_on_category').html("Please Select Product Category");
								flag=true;
                        }else if(offer_on_category_quantity==''){
                             $('#erroffer_on_category_quantity').html("Enter Category Quantity");
							 flag=true;
                        }else if(offer_free_products==''){ 
                            $('#errofferonffreeproduct').html("Please Select Product");
							flag=true;
                        }else if(offer_free_products_quantity==''){
                            $('#errofferonfreeproductquantity').html("Please Product Quantity");
							flag=true;
                        }
                break;
            
                case "DISCOUNT_ON_GROUPING_AMOUNTS":
                    if(offer_on_category==null){
                                $('#erroffer_on_category').html("Please Select Product Category");
								flag=true;
                    }/*else if(offer_on_products_mullti==null){
                        $('#errofferonproductmulti').html("Please Select Product ");
                    }*/else if(offer_items_condition==''){
                        $('#erroffer_items_condition').html("Please Select Minimum products ");
						flag=true;
                    }else if(offer_on_products_amount==''){
                        $('#erroffer_on_products_amount').html("Enter Product Amount ");
						flag=true;
                    }else if(offer_discount_rate==''){
                        $('#erroffer_discount_rate').html("Enter Discount Amount Or Rate");
						flag=true;
                    }
                    
                break;
            
            case "FREE_ITEM_ON_GROUPING_AMOUNTS":
                    if(offer_on_category==null){
                                $('#erroffer_on_category').html("Please Select Product Category");
								flag=true;
                    }/*else if(offer_on_products_mullti==null){
                        $('#errofferonproductmulti').html("Please Select Product ");
                    }*/else if(offer_items_condition==''){
                        $('#erroffer_items_condition').html("Please Select Minimum products ");
						flag=true;
                    }else if(offer_on_products_amount==''){
                        $('#erroffer_on_products_amount').html("Enter Product Amount ");
						flag=true;
                    }else if(offer_free_products==''){ 
                        $('#errofferonffreeproduct').html("Please Select Product");
						flag=true;
                    }else if(offer_free_products_quantity==''){
                        $('#errofferonfreeproductquantity').html("Please Product Quantity");
						flag=true;
                    }
                break;
            
            case "DISCOUNT_ON_GROUPING_QTY":
                    if(offer_on_category==null){
                                $('#erroffer_on_category').html("Please Select Product Category");
								flag=true;
                    }/*else if(offer_on_products_mullti==null){
                        $('#errofferonproductmulti').html("Please Select Product ");
                    }*/else if(offer_on_product_quantity==''){
                        $('#errofferonproductquantity').html("Please Product Quantity");
						flag=true;
                    }else if(offer_items_condition==''){
                        $('#erroffer_items_condition').html("Please Select Minimum products ");
						flag=true;
                    }else if(offer_discount_rate==''){
                        $('#erroffer_discount_rate').html("Enter Discount Amount Or Rate");
						flag=true;
                    }
                break;
                
            case "FREE_ITEM_ON_GROUPING_QTY":
                    if(offer_on_category==null){
                                $('#erroffer_on_category').html("Please Select Product Category");
								flag=true;
                    }/*else if(offer_on_products_mullti==null){
                        $('#errofferonproductmulti').html("Please Select Product ");
                    }*/else if(offer_on_product_quantity==''){
                        $('#errofferonproductquantity').html("Please Product Quantity");
						flag=true;
                    }else if(offer_items_condition==''){
                        $('#erroffer_items_condition').html("Please Select Minimum products ");
						flag=true;
                    }else if(offer_free_products==''){ 
                        $('#errofferonffreeproduct').html("Please Select Product");
						flag=true;
                    }else if(offer_free_products_quantity==''){
                        $('#errofferonfreeproductquantity').html("Please Product Quantity");
						flag=true;
                    }
                break;
            
            case "DISCOUNT_ON_INVOICE_AMOUNT":
                    if(offer_on_invoice_amount==''){
                        $('#erroffer_on_invoice_amount').html("Enter Invoice Amount");
						flag=true;
                    }else if(offer_discount_rate==''){
                        $('#erroffer_discount_rate').html("Enter Discount Amount Or Rate");
						flag=true;
                    }
                   
                break;
            
             case "FREE_ITEM_ON_INVOICE_AMOUNT":
                    if(offer_on_invoice_amount==''){
                        $('#erroffer_on_invoice_amount').html("Enter Invoice Amount");
						flag=true;
                    }else if(offer_free_products==''){ 
                        $('#errofferonffreeproduct').html("Please Select Product");
						flag=true;
                    }else if(offer_free_products_quantity==''){
                        $('#errofferonfreeproductquantity').html("Please Product Quantity");
						flag=true;
                    }
                
                break;
            
                case "DISCOUNT_ON_EVENTS":
                    if(offer_discount_rate==''){
                        $('#erroffer_discount_rate').html("Enter Discount Amount Or Rate");
						flag=true;
                    }
                break;
                    
                 default:
                     flag=false;
                  break;   
                }    
            }  
            
        }
        if(!$('.select_custom_day').is(':checked')){
			 $('#erroffer_days').html("Select atleast one day.");
			flag=true;
		}
//        
       if(flag)
		   return false;
        
    });
    // End Form Validation
    // Error Msg hide
   function timeouterror(){
     setTimeout(function(){ 
         $('.errormsg').hide();
    }, 5000);
   }
   // Error MSG hide
    
</script>
