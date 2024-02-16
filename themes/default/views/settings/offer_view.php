<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
    // Waarehouse 
    $getware = explode(',',$offerdata->offer_on_warehouses);
    if(is_array($getware)){
        foreach($getware as $werhs){
            $warehousename.=$warehouses[$werhs].', ';
        }
    }
    
   // Offer On Product
    $offeronproduct = explode(',',$offerdata->offer_on_products);
    if(is_array($offeronproduct)){
        foreach($offeronproduct as $oop){
            $offer_on_product.= $product_list[$oop].', ';
        }
    }
    
    // Free Offer On Product
    $offerfreeproduct = explode(',',$offerdata->offer_free_products);
    if(is_array($offerfreeproduct)){
        foreach($offerfreeproduct as $ofp){
            $offer_free_product.= $product_list[$ofp].', ';
        }
    }
    
    // Offer Category 
    $offercategory = explode(',', $offerdata->offer_on_category);
    if(is_array($offercategory)){
        foreach($offercategory as $ofc){
            $offer_category.= $category_list[$ofc].', ';
        }
    }
    
    // Offer Brand
     $offerbrand = explode(',', $offerdata->offer_on_brands);
     if(is_array($offerbrand)){
        foreach($offerbrand as $ofb){
            $offer_brand.= $brands_list[$ofb].'<br/>';
        }
    }
    
     $offerdyas = explode(",",$offerdata->offer_on_days);
         $showdays='';
            $days = array('0'=>'Sun','1'=>'Mon','2'=>'Tue','3'=>'Wed','4'=>'Thu','5'=>'Fri','6'=>'Sat');
            foreach($offerdyas as $val){
                $showdays[]= $days[$val];
            }
?>
<style>
    #view_data tr td{padding:1px 5px !important;}
    #view_data{margin-bottom: 5px !important;}
    .modal-footer {
    padding: 4px !important;
    text-align: right;
    border-top: 1px solid #e5e5e5;
}   .datashow{margin-left: 1em;}
</style>    

<div class="modal-dialog modal-lg">
    <div class="modal-content modal-lg">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-2x">&times;</i>
            </button>

            <h4 class="modal-title" id="myModalLabel">Offer Name : <?= $offerdata->offer_name;?></h4>
        </div>
        <div class="modal-body">
           <div class="form-group row">
                <strong class="col-sm-3" > <?= lang('offers_category')  ?>  </strong>
                <div class="col-sm-8">
                    <p > : <span class="datashow"> <?= $offerdata->offer_category?> </span> </p> 
                </div>
            </div>  
                       
            <div class="form-group row">
                <strong class="col-sm-3" > <?= lang('offers_name')  ?> </strong>
                <div class="col-sm-8">
                    <p > : <span class="datashow"> <?= $offerdata->offer_name?> </span> </p> 
                </div>
            </div>  
            
            <div class="form-group row">
                <strong class="col-sm-3"> <?= lang('validity_date')  ?>  </strong>
                <strong class="col-sm-2"> <?= lang('starting_date')  ?>  </strong>
                <div class="col-sm-2">
                    <p > : <span class="datashow"> <?= ($offerdata->offer_start_date=='0000-00-00'||$offerdata->offer_start_date=='')?'---':date('d - M - Y',strtotime($offerdata->offer_start_date)); ?> </span> </p> 
                </div>
                <strong class="col-sm-2"> <?= lang('end_date')  ?>  </strong>
                <div class="col-sm-2">
                    <p > : <span class="datashow"> <?= ($offerdata->offer_end_date=='0000-00-00'||$offerdata->offer_end_date=='')?'---':date('d - M - Y',strtotime($offerdata->offer_end_date)); ?> </span> </p> 
                </div>
            </div>
                    
            <div class="form-group row">
                <strong class="col-sm-3"> <?= lang('specific_time')  ?> </strong>
                <strong class="col-sm-2"> <?= lang('from_time')  ?> </strong>
                <div class="col-sm-2"> 
                    <p > : <span class="datashow"> <?= ($offerdata->offer_start_time=='00:00'||$offerdata->offer_start_time=='')?'---':date("g:i A", strtotime($offerdata->offer_start_time)); ?> </span> </p> 
                </div>
                <strong class="col-sm-2"> <?= lang('to_time')  ?>   </strong>
                <div class="col-sm-2">
                    <p > : <span class="datashow"> <?= ($offerdata->offer_end_time=='00:00'||$offerdata->offer_end_time=='')?'---':date("g:i A", strtotime($offerdata->offer_end_time)); ?> </span> </p> 
                </div>
            </div>
                    
            <div class="form-group row">
                <strong class="col-sm-3" style="padding-top: 0.5em;"> <?= lang('days')  ?>  </strong>
                <div class="col-sm-8">
                    <p > : <span class="datashow"> <?= (is_array($showdays))?  implode(", ", $showdays):'---'; ?> </span> </p> 
                </div>    
            </div>
                   
            <div class="form-group row">
                <strong class="col-sm-3"> Offer On Warehouse</strong>
                <div class="col-sm-8">
                    <p > : <span class="datashow"> <?= rtrim($warehousename,", ") ?> </span> </p> 
                </div>    
            </div> 
                        
            <div class="hideshowelement" id="block_offer_on_category"  >
                <div class="form-group row">
                    <strong class="col-sm-3" > Offer On Category  </strong>
                    <div class="col-sm-8">
                        <p > : <span class="datashow"> <?= ($offerdata->offer_on_category=='')?'---':rtrim($offer_category,", " ) ?> </span> </p>  
                    </div>
                </div>    
            </div> 
  
            <div class="hideshowelement" id="block_offer_on_category_quantity"  >
                <div class="form-group row "  >
                    <strong class="col-sm-3" >Offer on Category Quantity  </strong>
                    <div class="col-sm-8">
                        <p > : <span class="datashow"> <?= ($offerdata->offer_on_category_quantity=='')?'---':$offerdata->offer_on_category_quantity ?> </span> </p>  
                    </div>
                </div>
            </div>

            <div class="hideshowelement" id="block_offer_on_category_amount"  >
                <div class="form-group row "  >
                    <strong class="col-sm-3" >Offer on Category Amount  </strong>
                    <div class="col-sm-8">
                        <p > : <span class="datashow"> <?= ($offerdata->offer_on_category_amount=='')?'---':$offerdata->offer_on_category_amount ?> </span> </p>  
                    </div>
                </div>    
            </div>

            <div class="hideshowelement" id="block_offer_on_brands"  >
                <div class="form-group row"  >
                    <strong class="col-sm-3" > Offer on Brand   </strong>
                    <div class="col-sm-8">
                        <p > : <span class="datashow"> <?= ($offerdata->offer_on_brands=='')?'---':rtrim($offer_brand,", ") ?> </span> </p>  
                    </div>
                </div>    
            </div> 

            <div class="hideshowelement" id="block_offer_on_invoice_amount"  >
                <div class="form-group row "  >
                    <strong class="col-sm-3" > Offer on Invoice Amount   </strong>
                    <div class="col-sm-2">
                        <p > : <span class="datashow"> <?= ($offerdata->offer_on_invoice_amount=='')?'---':$offerdata->offer_on_invoice_amount ?> </span> </p>  
                    </div>
                </div>
            </div>

            <div class="hideshowelement" id="block_offer_on_products" >
                <div class="form-group row">
                    <strong class="col-sm-3" > Offer On Products    </strong>
                    <div class="col-sm-8">
                        <p > : <span class="datashow">  <?= ($offerdata->offer_on_products=='')?'---':rtrim($offer_on_product,", ") ?> </span> </p>  
                    </div>
                </div>
            </div>
            
            <div class="hideshowelement" id="block_offer_on_products_multiple" >
                <div class="form-group row">
                    <strong class="col-sm-3" >Offer On Products   </strong>
                    <div class="col-sm-8">
                        <p > : <span class="datashow">  <?= ($offerdata->offer_on_products=='')?'---':rtrim($offer_on_product,", ") ?> </span> </p>  
                    </div>
                </div>
            </div>
                    
            <div class="hideshowelement" id="block_offer_on_quantity" >
                <div class="form-group row">
                    <strong class="col-sm-3" >Offer Product Quantity  </strong>
                    <div class="col-sm-2">
                        <p > : <span class="datashow">  <?= ($offerdata->offer_on_products_quantity=='')?'---':$offerdata->offer_on_products_quantity ?> </span> </p>  
                    </div>
                </div>
            </div>

            <div class="hideshowelement" id="block_offer_items_condition" >
                <div class="form-group row">
                    <strong class="col-sm-3" ><?= lang('Minimum Products')  ?>  </strong>
                    <div class="col-sm-8">
                        <p > : <span class="datashow">  <?= ($offerdata->offer_items_condition=='0')?'---':($offerdata->offer_items_condition=='1')?'Any Product':'Any '.$offerdata->offer_items_condition.' Product' ?> </span> </p>  
                    </div>
                </div>
            </div>
                    
            <div class="hideshowelement" id="block_offer_on_products_amount" >
                <div class="form-group row" >
                    <strong class="col-sm-3" > Offer on Product Amount</strong>
                    <div class="col-sm-8">
                        <p > : <span class="datashow">  <?= $offerdata->offer_on_products_amount?> </span> </p>  
                    </div>
                </div>    
            </div>
            
            <div class="hideshowelement" id="block_offer_amount_including_tax" >
                <div class="form-group row" >
                    <strong class="col-sm-3" > Offer Amount Including Tax </strong>
                    <div class="col-sm-8">
                        <p > : <span class="datashow">  <?= ($offerdata->offer_amount_including_tax=='0')?'No':'Yes'?> </span> </p>  
                    </div>
                </div>    
            </div>

            <div class="hideshowelement" id="block_offer_free_products"  >
                <div class="form-group row"  > 
                    <strong class="col-sm-3" >Offer Free Product  </strong>
                    <div class="col-sm-8">
                        <p > : <span class="datashow"> <?= ($offerdata->offer_free_products=='')?'---':rtrim($offer_free_product,", ") ?></span> </p>  
                    </div>
                </div>    
            </div>
                    
            <div class="hideshowelement" id="block_offer_free_quantity"  >
                <div class="form-group row" >
                    <strong class="col-sm-3" > Free Product Quantity </strong>
                    <div class="col-sm-2">
                        <p > : <span class="datashow"> <?= ($offerdata->offer_free_products_quantity=='')?'---':$offerdata->offer_free_products_quantity ?></span> </p>  
                    </div>
                </div>
            </div>

            <div class="hideshowelement" id="block_offer_discount_rate">
                <div class="form-group row">
                    <strong class="col-sm-3" >  <?= lang('offer_discount_rate_amt')  ?>   </strong>
                    <div class="col-sm-2">
                        <p > : <span class="datashow">  <?= ($offerdata->offer_discount_rate=='')?'---':$offerdata->offer_discount_rate ?></span> </p>  
                    </div>  
                </div>
            </div> 

            <div class="" id=""  >
                <div class="form-group row">
                    <strong class="col-sm-3" ><?= lang('Invoice Note')  ?> </strong>
                    <div class="col-sm-8">
                        <p > : <span class="datashow">  <?= ($offerdata->offer_invoice_descriptions=='')?'---':$offerdata->offer_invoice_descriptions ?></span> </p>  
                    </div>
                </div>   
            </div>
                        
           <div class="modal-footer no-print">
                <button type="button" class="btn btn-danger pull-right" data-dismiss="modal"><?= lang('close'); ?></button>
            </div>
            
            <div class="clearfix"></div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        $('.hideshowelement').hide();
   
        block( );
        
    });
     function block(){
         
         var get_offer = '<?= $offerdata->offer_keyword ?>';

        switch(get_offer){
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
    }
</script>