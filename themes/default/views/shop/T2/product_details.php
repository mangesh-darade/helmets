<?php include('header.php') ?>
<!-- banner -->
<style>.option{ margin-bottom:10px;border:none;width:30%;height:25px; padding:0 10px; border: 1px solid #ccc;} .padding10{padding:10px 0;} </style>
<div class="container" style="padding: 30px; height:500px">
     
    <div class="row">
        <div class="col-md-6">
            <div class="hover14 column">
                <div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
                    <div class="agile_top_brand_left_grid_pos"><img src="<?= $assets.$shoptheme?>/images/instock.png" alt=" " class="img-responsive img-rounded" /> </div>

                    <div class="agile_top_brand_left_grid1">
                        <figure>
                        <div class="snipcart-item block">
                            <div class="snipcart-thumb">
                                
                                <?php
                               
                               // echo $thumbs;
                                $fielname = (file_exists("assets/uploads/".$product['image'])) ?  $product['image'] :  'no_image.png';
                                ?>
                                <img src="<?= $thumbs.$fielname?>" id="bigimg" alt="<?= $product['code']?>" class="img-responsive img-rounded"  />
                            </div>
                          </div>
                        </figure>
                    </div>
                   </div>
                <div id="multiimages" class="padding10">
                                    <?php if (!empty($images)) {
                                       // echo '<a class="img-thumbnail" data-toggle="lightbox" data-gallery="multiimages" data-parent="#multiimages" href="' . base_url() . 'assets/uploads/' . $product->image . '" style="margin-right:5px;"><img class="img-responsive" src="' . base_url() . 'assets/uploads/thumbs/' . $product->image . '" alt="' . $product->image . '" style="width:' . $Settings->twidth . 'px; height:' . $Settings->theight . 'px;" /></a>';
                                        foreach ($images as $ph) {
                                            echo '<div class="gallery-image" style="float:left"><a class="img-thumbnail" data-toggle="lightbox" data-gallery="multiimages" data-parent="#multiimages" href="javascript:void(0);" style="margin-right:5px;"><img class="img-responsive gallery_image"  src="' . base_url() . 'assets/uploads/' . $ph->photo . '" alt="' . $ph->photo . '" style="width:' . $Settings->twidth . 'px; height:' . $Settings->theight . 'px;" /></a>';                                           
                                            echo '</div>';
                                        }
                                    }
                                    ?>
                  <div class="clearfix"></div>
                </div>
            </div>
            <div class="snipcart-details">
                <p style="margin: 15px 0px;">
                 <a href="<?=base_url('shop/home')?>" class="btn btn-warning pull-left" >Back To Products</a> 
                 <input type="button" name="addtocart" onclick="addToCart('<?=$product['id']?>')" value="Add to cart" class="btn btn-success pull-right" /></p>
                 <input type="button" name="addTowishlist" id="addtowishlist_<?=$product['id']?>" style="margin-right:10px;" onclick="addTowishlist('<?=$product['id']?>')" value="Add to Wishlist" class="btn btn-info pull-right" />
            </div>
        </div>
        <div class="col-md-6">
            <p> <nav style="color: #999999; font-size:14px; ">Home <?php 
                foreach ($navigation as $key => $nav) {
                    if($nav) echo ' / '. $nav;
                }
            ?></nav></p>
        <h3 class="product-title" style="margin-top: 10px;text-transform: capitalize; "><?=$product['name']?> <span>(<?=$product['code']?>)</span></h3>
         
            <h4>Descriptions:</h4>
            <p><?=$product['product_details']?></p>
            <input type='hidden' name="product_price" id="Pricehidden_<?= $product['id'] ?>" value='<?= $product['price'] ?>'>
           <div class="snipcart-details col-sm-12" style="margin-left:-3%">
                <?php if($veriants){?>
                <select class="form-control option" onChange="return getVariantDetails(this.value, this.id);" id="variants_<?=$product['id']?>" name="variants_<?=$product['id']?>">
                   <!-- <option value="null">select Variants</option>-->
                 <?php  $icounter=1; foreach($veriants as $veriantskey  => $veriantss){ 
                     if($icounter==1)
                      $PVPrice=$veriantss->price; ?>
                    <option value="<?php echo $veriantskey.'~' .$veriantss->name.'~'. $veriantss->price?>"><?php echo $veriantss->name; ?></option>
                        <?php $icounter++; }}?>
                </select>
               <?php if($product['promotion']){?>
                        <h3 class="text-left Price_<?= $product['id'] ?>">Price : <?= $currency_symbol . number_format($product['promo_price'] + $PVPrice, 2) ?> <del><?= number_format($product['price'], 2)?></del></h3>
                <?php } else{?>
                        <h3 class="text-left Price_<?= $product['id'] ?>">Price : <?= $currency_symbol ?> <?= number_format(($product['price'] + $PVPrice), 2)?></h3> 
                <?php } ?>
            </div>
<!--            <div class="product-price col-sm-12" style="margin: 10px 0;">-->
                
<!--            </div>-->
          </div>
    </div>
     <div class="clearfix"></div>
</div>
<?php include_once 'footer.php'; ?>
<!-- //banner -->
<script>
$('.gallery_image').on('click', function(){
	var img_src= $(this).attr('src');
	$('#bigimg').attr('src', img_src);
});
</script>
<?php

function is_url_exist($url){
    $ch = curl_init($url);    
    curl_setopt($ch, CURLOPT_NOBODY, true);
    curl_exec($ch);
    $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);

    if($code == 200){
       $status = true;
    }else{
      $status = false;
    }
    curl_close($ch);
   return $status;
}
?>