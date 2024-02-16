<?php include('header.php') ?>
<!-- banner -->
<div class="container" style="padding: 30px;height: 500px;">
     
    <div class="row">
        <div class="col-md-4">
            <div class="hover14 column">
                <div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
                    <div class="agile_top_brand_left_grid_pos"><img src="<?= $assets.$shoptheme?>/images/instock.png" alt=" " class="img-responsive img-rounded" /> </div>

                    <div class="agile_top_brand_left_grid1">
                        <figure>
                        <div class="snipcart-item block">
                            <div class="snipcart-thumb">
                                <?php
                                $fielname = (file_exists("assets/uploads/thumbs/".$product['image'])) ?  $product['image'] :  'no_image.png';
                                ?>
                                <img src="<?= $thumbs.$fielname?>" alt="<?= $product['code']?>" class="img-responsive img-rounded"  />

                            </div>
                            
                        </div>
                        </figure>
                    </div>
                </div>
            </div>
            <div class="snipcart-details">
                <p style="margin: 15px 0px;">
                 <a href="<?=base_url('shop/home')?>" class="btn btn-warning pull-left" >Back To Products</a> 
                 <input type="button" name="addtocart" onclick="addToCart('<?=$product['id']?>')" value="Add to cart" class="btn btn-success pull-right" /></p>
                
            </div>
        </div>
        <div class="col-md-8">
            <p> <nav style="color: #999999; font-size:14px; ">Home <?php 
                foreach ($navigation as $key => $nav) {
                    if($nav) echo ' / '. $nav;
                }
            ?></nav></p>
        <h3 class="product-title" style="margin-top: 20px;text-transform: capitalize; "><?=$product['name']?> <span>(<?=$product['code']?>)</span></h3>
         
        <div class="product-price" style="margin: 20px 0;">
            <?php
                if($product['promotion']){                
                     echo "<h1>Price : $currency_symbol ". number_format($product['promo_price'], 2). " <del> ". number_format($product['price'], 2) . "</del></h1>";
                } else {
                    echo "<h1>Price :  $currency_symbol ". number_format($product['price'], 2) . "</h1>";
                } 
            ?>
        </div>  
            <h4>Descriptions:</h4>
            <p><?=$product['product_details']?></p>
        </div>
    </div>
    
     

    <div class="clearfix"></div>
</div>
<!-- //banner -->
<?php include('footer.php') ?>

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