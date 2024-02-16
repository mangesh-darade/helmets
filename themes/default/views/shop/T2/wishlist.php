<?php include_once 'header.php'; ?>

<!-- banner -->
        
	<div class="banner">
            <div class="w3l_banner_nav_right products" style="width:100%; background-color: antiquewhite;">
                <div class="container">
                    <div class="w3ls_w3l_banner_nav_right_grid1 w3ls_w3l_banner_nav_right_grid1_veg" style="margin: 1.2em 0 2.2em 0em;">
                    <h4 class="w3l_fruit" style="padding: 20px 0 0 20px;"><?= $navigation?></h4>
                        <?php
                        $itemsPerRow = 4;
                        $item_col = 12 / $itemsPerRow;
                         if(is_array($wishlistdata['result']) && !empty($wishlistdata['result'])) {    
                         $p=0;
                         foreach ($wishlistdata['result'] as $wishlist) {
                         $p++;
                         /*if($p==1){                         
                            echo '<div class="w3ls_w3l_banner_nav_right_grid1 w3ls_w3l_banner_nav_right_grid1_veg">';                         
                        }*///end if.?>    
                         <div class="col-md-<?=$item_col?> w3ls_w3l_banner_left w3ls_w3l_banner_left_asdfdfd_<?= $wishlist['product_id']?>">
                            <div class="hover14 column" id="hover14_<?= $wishlist['product_id']?>'">
                                <div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid" id="removeIcon_<?= $wishlist['product_id']?>">
                                    <div class="agile_top_brand_left_grid_pos"><img src="<?= $assets.$shoptheme?>/images/instock.png" alt=" " class="img-responsive img-rounded" /> </div>
                                        <div class="agile_top_brand_left_grid1">
                                            <figure>
                                                <div class="snipcart-item block">                                           
                                                    <div class="itemcard-removeIcon" onclick="removeItemFromWishlist('<?= $wishlist['product_id']?>');"><span class="cross" aria-hidden="true" title="remove from wishlist">&times;</span></div>
                                                    <div class="snipcart-thumb">
                                                        <a href="<?=base_url('shop/product_info/'.md5($wishlist['product_id']))?>" />   <?php
                                                        $fielname = (file_exists("assets/uploads/thumbs/".$wishlist['image'])) ?  $wishlist['image'] :  'no_image.png';
                                                        ?>
                                                        <img src="<?= $thumbs.$fielname?>" alt="<?= $product['code']?>" class="img-responsive img-rounded" />
                                                        <p class="text-center"><?= $wishlist['name']?></p>
                                                        <h4 class="text-center"><?= $currency_symbol?> <?= number_format($wishlist['price'], 2)?> 
<!--                                                            <span>< ?= $currency_symbol?> < ?= number_format($product['price'], 2)?></span>-->
                                                        </h4></a>
                                                       </div>
                                                      <?php if($veriants){?>
                                                    <div class="snipcart-details" style="">
                                                       <select class="form-control option1" id="variants_<?= $wishlist['product_id']?>" name="variants_<?=$product['id']?>">
                                                         <?php  foreach($veriants as $veriantskey  => $veriantss){ ?>
                                                            <option value="<?php echo $veriantskey.'~' .$veriantss->name.'~'. $veriantss->price?>"><?php echo $veriantss->name; ?></option>
                                                                <?php }?>
                                                        </select>
                                                    </div>
                                                    <?php } else{?>
                                                    <div class="snipcart-details" style="">&nbsp;</div>
                                                    <?php } ?>
                                                    <div class="snipcart-details">
                                                      <input type="button" name="addtocart" id="addtocart"  onclick="addToCart('<?=$wishlist['product_id']?>','movetoaddtocart')" value="Add to cart" class="button" />

                                                    </div>
                                                    <div class="snipcart-details">
                                                        <a href="<?=base_url('shop/product_info/'.md5($wishlist['product_id']))?>"><input type="button" name="view"  value="View Details" class="btn btn-info col-sm-12" /></a>
                                                    </div>
                                                </div>
                                                </figure>
                                            </div>
                                    </div>
                                    </div>
                                </div>
                            <?php
                                /*if($p==$itemsPerRow){
                                   $p=0;                        
                                    echo ' <div class="clearfix"> </div>
                                        </div>'; 
                                }*///end if
                                
                        }//end foreach.
                            /*if($p!=$itemsPerRow && $p!=0){                    
                                    echo ' <div class="clearfix"> </div>
                                        </div>'; 
                            }*///end if
                        }//endif
                        else
                        {
                          echo '<div class="text-danger text-center" style="padding:50px 0;"><p>Sorry, you have not added any product to wishlist! </p></div>' ;
                        }
                        ?>  
                            <div style="margin: 20px;"><?php echo $pagignation;?></div>
                            <div class="clearfix"> </div>
                         </div>
	            </div>
                </div>
           <div class="clearfix"></div>
        </div>
<!-- //banner -->

<?php include_once 'footer.php'; ?>


