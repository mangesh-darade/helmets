<?php include_once 'header.php'; ?>
<!-- banner -->
<div class="banner">
    <section class="slider">
        <div class="flexslider">
            <ul class="slides">
                <?php
                $homeBanner = [];
                $b=0;
                if(is_array($defaultBanner = json_decode($eshop_settings->default_banner , true))){
                    foreach ($defaultBanner as $key => $img) {
                        $homeBanner[$key] = $eshop_image . $img;
                    }
                }
                
                for($i=1; $i<=3; $i++){
                    $bimg = 'banner_image_'.$i;
                    $homeBanner[$i+3] = $eshop_settings->$bimg;
                }                
               
                //Manage Default Banner                
                if(is_array($homeBanner)){
                    
                    foreach ($homeBanner as $key => $bannerImg) {
                        $k = ($key-1) ? $key-1 : '';
                        if(file_exists($bannerImg)){
                ?>
                <li>
                    <div class="w3l_banner_nav_right_banner<?=$k?>">
<!--                        <h3>Make your food with Spicy.</h3>-->
                        <div class="more">
                            <a href="<?= base_url('shop/home') ?>" class="button--saqui button--round-l button--text-thick" data-text="Shop now"> Shop now</a>
                        </div>
                    </div>
                </li>
                <?php
                        }//end if.
                    }//end foreach
                }//end if                     
                ?>

            </ul>
        </div>
    </section>
    <!-- flexSlider -->
    <link rel="stylesheet" href="<?= $assets . $shoptheme ?>/css/flexslider.css" type="text/css" media="screen" property="" />
    <script defer src="<?= $assets . $shoptheme ?>/js/jquery.flexslider.js"></script>
    <script type="text/javascript">
        $(window).load(function () {
            $('.flexslider').flexslider({
                animation: "slide",
                start: function (slider) {
                    $('body').removeClass('loading');
                }
            });
        });
    </script>
    <!-- //flexSlider -->

    <div class="clearfix"></div>
</div>
<!-- banner -->
<?php
$hamepage_image_1 = file_exists($eshop_settings->homepage_image_1) ? $eshop_settings->homepage_image_1 : $eshop_image.'default_homepage_image_1.jpg';
$hamepage_image_2 = file_exists($eshop_settings->homepage_image_2) ? $eshop_settings->homepage_image_2 : $eshop_image.'default_homepage_image_2.jpg';
$hamepage_image_3 = file_exists($eshop_settings->homepage_image_3) ? $eshop_settings->homepage_image_3 : $eshop_image.'default_homepage_image_3.jpg';
?>
<div class="banner_bottom">
    <div class="wthree_banner_bottom_left_grid_sub2">
        <div class="col-md-4 wthree_banner_bottom_left">
            <div class="wthree_banner_bottom_left_grid">
                <img src="<?= base_url($hamepage_image_1) ?>" alt="homepage_image_1" class="img-responsive img-rounded hmp-img" />
                <?php
//                if($eshop_settings->show_homepage_images_text) {
//                  
//                    if(!empty($eshop_settings->homepage_image_text_1) || !empty($eshop_settings->homepage_image_text_1_2)) {
//                        $start_1 = '<div class="wthree_banner_bottom_left_grid_pos"><h4>';
//                        $end_1   = '</h4></div>';
//                    } 
//                    if(!empty($eshop_settings->homepage_image_text_1_2)) {
//                         $spn_1 = ' <span>'.$eshop_settings->homepage_image_text_1_2.'</span>';
//                    }
//                    
//                    echo $start_1 . $eshop_settings->homepage_image_text_1 . $spn_1 . $end_1;
//                } 
                ?>
            </div>
        </div>
        <div class="col-md-4 wthree_banner_bottom_left">
            <div class="wthree_banner_bottom_left_grid">
                <img src="<?= base_url($hamepage_image_2) ?>" alt="homepage_image_2" class="img-responsive img-rounded hmp-img" />
                <?php
//                if($eshop_settings->show_homepage_images_text) {
//                  
//                    if(!empty($eshop_settings->homepage_image_text_2)) {
//                        echo '<div class="wthree_banner_btm_pos"><h3>'.$eshop_settings->homepage_image_text_2.'</h3></div>';
//                    }
//                } 
                ?>
            </div>
        </div>
        <div class="col-md-4 wthree_banner_bottom_left">
            <div class="wthree_banner_bottom_left_grid">
                <img src="<?= base_url($hamepage_image_3) ?>" alt="homepage_image_3" class="img-responsive img-rounded hmp-img" />
                <?php
//                if($eshop_settings->show_homepage_images_text) {
//                  
//                    if(!empty($eshop_settings->homepage_image_text_3)) {
//                        echo '<div class="wthree_banner_btm_pos1"><h3>'.$eshop_settings->homepage_image_text_3.'</h3></div>';
//                    }
//                } 
                ?>
            </div>
        </div>
        <div class="clearfix"> </div>
    </div>
    <div class="clearfix"> </div>
</div>
<?php if($eshop_settings->display_top_products) { ?>
<!-- top-brands -->
<div class="top-brands">
    <div class="container">
        <h3>Top Products</h3>        
        <?php
        $itemsPerRow = 4;
        $item_col = 12 / $itemsPerRow;                        
        if(is_array($hot_products) && !empty($hot_products)) {    
            $p=0;
            foreach ($hot_products as $product) {
                $p++;
                if($p==1){
                   echo '<div class="agile_top_brands_grids">';                                                      
                }//end if.
            ?>    
            <div class="col-md-<?=$item_col?> top_brand_left">
                <div class="hover14 column">
                    <div class="agile_top_brand_left_grid">
                        <div class="tag" style="top:0; left:0;"><img src="<?= $assets.$shoptheme?>/images/instock.png" alt=" " class="img-responsive" /></div>
                        <div class="agile_top_brand_left_grid1">
                            <figure>
                                <div class="snipcart-item block" >
                                    <div class="snipcart-thumb">
                                        <a href="<?=base_url('shop/product_info/'.md5($product['id']))?>" />  
                                            <?php
                                          
                                           
                                           $fielname = (is_url_exist($thumbs.$product['image'])) ?  $product['image'] :  'no_image.png';
                                            ?>
                                            <img src="<?= $thumbs.$fielname?>" alt="<?= $product['code']?>" class="img-responsive img-rounded" />
                                            <p class="text-center"><?= $product['name']?></p>
                                            <h4 class="text-center">
                                                <?= $currency_symbol?> <?= number_format($product['price'], 2)?>
                                            </h4>
                                        </a>
                                    </div>
                                     <div class="snipcart-details top_brand_home_details">
                                        <input type="button" name="addtocart"  onclick="addToCart('<?=$product['id']?>','')" value="Add to cart" class="button" />
                                        <span id="addtowishlist_<?=$product['id']?>" onclick="addTowishlist('<?=$product['id']?>')" class="button pull-right" style="background:green; padding:5px; font-size:12px;color:#fff;width:40%; cursor: pointer;">WISHLIST</span>
                                    </div>
                                    <div class="snipcart-details">
                                        <a href="<?=base_url('shop/product_info/'.md5($product['id']))?>"><input type="button" name="view"  value="View Details" class="btn btn-info col-sm-12" /></a>
                                    </div>
                                </div>
                            </figure>
                        </div>
                    </div>
                </div>
            </div>  
        <?php
            if($p==$itemsPerRow){
               $p=0;                        
                echo ' <div class="clearfix"> </div>
                    </div>'; 
            }//end if

        }//end foreach.
        if($p!=$itemsPerRow && $p!=0){                    
                echo ' <div class="clearfix"> </div>
                    </div>'; 
        }//end if
    }//endif
        ?>                
         
    </div>
</div>
<!-- //top-brands -->
<?php } ?>
<?php if($eshop_settings->display_hot_offers) { ?>
<!-- fresh-vegetables -->
<div class="fresh-vegetables">
    <div class="container">
        <h3>Hot Offers</h3>
        <div class="w3l_fresh_vegetables_grids">
            <div class="col-md-3 w3l_fresh_vegetables_grid w3l_fresh_vegetables_grid_left">
                <div class="w3l_fresh_vegetables_grid2">
                    <ul>
                        <?php
                        if (!empty($category)) {
                            $i = 0;
                            foreach ($category as $catdata) {
                                $i++;
                                if ($i > 12)
                                    break;
                                ?>
                                <li><i class="fa fa-check" aria-hidden="true"></i><a href="<?= base_url('shop/home/' . md5($catdata['id'])) ?>"><?= $catdata['name'] ?></a></li>
                                <?php
                            }//end foreach.
                        }//End if.
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-9 w3l_fresh_vegetables_grid_right">
            <?php
                $hot_offers_banner = file_exists($eshop_settings->hot_offers_banner) ? $eshop_settings->hot_offers_banner : $eshop_image.'default_hot_offers_banner.jpg';
            ?>
                <img src="<?= base_url($hot_offers_banner) ?>" alt="hot_offers_banner" class="img-responsive img-rounded" />
<!--                <div class="w3l_fresh_vegetables_grid1_rel_pos">
                    <div class="more m1">
                        <a href="< ?= base_url('shop/home') ?>" class="button--saqui button--round-l button--text-thick" data-text="Shop now">Shop now</a>
                    </div>
                </div>-->
            </div>
            <div class="clearfix"> </div>
        </div>
    </div>
</div>
<!-- //Hot offers -->
<?php } ?>

<?php include_once 'footer.php'; ?>

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