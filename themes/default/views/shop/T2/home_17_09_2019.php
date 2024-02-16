<?php include_once 'header.php';  ?>
<!-- banner -->
<div class="banner clearfix">
            
		<!--<div class="w3l_banner_nav_left category">                        
			<nav class="navbar nav_bottom">                             
			 <!-- Brand and toggle get grouped for better mobile display -->
			<!--  <div class="navbar-header nav_2">
                                <button type="button" class="navbar-toggle collapsed navbar-toggle1" data-toggle="collapse" data-target="#bs-megadropdown-tabs">
                                    <span class="sr-only">Toggle navigation</span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                </button>
			   </div> 
			   <!-- Collect the nav links, forms, and other content for toggling -->
				<!--<div class="collapse navbar-collapse" id="bs-megadropdown-tabs">
					<ul class="nav navbar-nav nav_1">
					<?php
                                        
                                        if(!empty($category)) {
                                            foreach ($category as $catdata) {                                                    
                                                if($catdata['subcat_count'] > 0) {
                                        ?>
                                                    <li class="dropdown mega-dropdown active">
                                                        <a href="#" class="dropdown-toggle" data-toggle="dropdown"><?= $catdata['name']?><span class="caret"></span></a>				
							<div class="dropdown-menu mega-dropdown-menu w3ls_vegetables_menu">
                                                            <div class="w3ls_vegetables">
                                                                <ul>
                                                                <?php
                                                                if(!empty($subCategories[$catdata['id']])) {
                                                                    foreach ($subCategories[$catdata['id']] as $subcat) {
                                                                ?>
                                                                    <li><a href="<?= base_url('shop/home/'.md5($subcat['id']))?>"><?= $subcat['name']?></a></li>
                                                                <?php           
                                                                    }//end foreach
                                                                }//end if
                                                                ?>    
                                                                </ul>
                                                            </div>                  
							</div>				
                                                    </li>
                                        <?php
                                                } else {
                                        ?>
                                                    <li><a href="<?= base_url('shop/home/'.md5($catdata['id']))?>"><?= $catdata['name']?></a></li>						
                                        <?php   }//end else.
                                            }//end foreach.
                                        }//End if.
                                        ?>	
					</ul>
				 </div><!-- /.navbar-collapse -->
			<!--</nav>
		</div>-->
		<button class="btn btn-danger" id="filterbtn">Filter Products</button>
               <div class="w3l_banner_nav_left category" id="filter_toggle">
<!--                   <div class="w3ls_vegetables_menu">-->
                        
                        <div align="center">
                        <div class="sidehead">
                            <h4 style="padding:10px 0;">Select Category</h4>
                        </div>    
                       <ul class="list-group" id='catlist'>
                           <?php
                           if(!empty($category)) {
                                foreach ($category as $catdata) {                                                    
                                    if($catdata['subcat_count'] > 0) {
                                        ?>
                           <li class="list-group-item category_check">
                               <div class="form-check">
                                   <label class="form-check-label">
                                       <input type="checkbox" name="category" class="form-check-input filter_check" id="cat_<?= $catdata['id']?>" value="<?= $catdata['id']?>"> <?= $catdata['name']?>
                                   </label>
                               </div>
                              <!-- <div class="w3ls_vegetables">
                                            <ul>
                                            <?php
                                            if(!empty($subCategories[$catdata['id']])) {
                                                foreach ($subCategories[$catdata['id']] as $subcat) {
                                            ?>
                                                <li><a href="<?= base_url('shop/home/'.md5($subcat['id']))?>"><?= $subcat['name']?></a></li>
                                            <?php           
                                                }//end foreach
                                            }//end if
                                            ?>    
                                            </ul>
                                        </div> -->
                           </li>
                           <?php } } } ?>
                           <span id="loadMore">Show more</span>
                       </ul>
                       </div>
                     
                       <div align="center">
                           <div class="sidehead">
                            <h4 style="padding:10px 0;">Select Brand</h4>
                        </div> 
                           <ul class="list-group" id="brandlist">
                               <?php if(!empty($brands)){
                                   foreach($brands as $BrandsName){
                                ?>
                               <li class="list-group-item brand_check" >
                               <div class="form-check">
                                   <label class="form-check-label">
                                       <input type="checkbox" name="brand" class="form-check-input filter_check" id="brands_<?= $BrandsName['id'];?>" value="<?= $BrandsName['id'];?>"> <?= $BrandsName['name'];?>
                                   </label>
                               </div>
                               </li>
                              <?php }
                               } ?>
                                <span id="more">Show More</span>
                           </ul>
                        </div>
                        <?php if(!empty($price)){ ?>
                       <div align="center">
                            <div class="sidehead">
                            <h4 style="padding:10px 0;">Select Price</h4>
                            </div>
                            <ul class="list-group" id="pricelist">
                           <?php if(!empty($price)){
                               foreach($price as $pricekey=>$pricevalue){
                              $arr =  array($pricekey =>$pricevalue, $pricekey => $pricevalue);
                              $minprice = $arr['minprice'];
                               $maxprice = $arr['maxprice'];
                               $i = $minprice;
                                while($i<=$maxprice){
                                    if($i=='')
                                        $i=0;
                                  $j = $i+10000;
                                ?>
                                <li class="list-group-item" >
                                    <div class="form-check">
                                        <label class="form-check-label">
                                            <input type="checkbox" name="price" class="form-check-input filter_check price_check" value="<?= $i.'~'.$j?>"> <?= $i.' To '. $j.' Rs.'?>
                                         </label>
                                    </div>
                               </li>
                               <?php $i = $j;  }
                               }
                           }?>
                                <span id="pmore">Show More</span>
                             </ul>
                          
                        </div>
                        <?php } ?>
<!--<div id="showLess">Show less</div>-->
<!--                   </div>-->
                </div> 
		<div class="w3l_banner_nav_right products">
                    <div id="searchData" class="w3ls_w3l_banner_nav_right_grid" style="padding: 1px 1em 5em;"></div>
			<div class="w3ls_w3l_banner_nav_right_grid  defaultProlist">
                            <h4 class="w3l_fruit" style="padding: 20px 0 0 20px;"><?= $navigation?></h4>
                        <?php
                        $itemsPerRow = 4;
                        $item_col = 12 / $itemsPerRow;
                        if(is_array($catlogProducts['items']) && !empty($catlogProducts['items'])) {    
                            $p=0;
                            foreach ($catlogProducts['items'] as $product) {
                                 $p++;
                                if($p==1){                         
                                    echo '<div class="w3ls_w3l_banner_nav_right_grid1 w3ls_w3l_banner_nav_right_grid1_veg">';                         
                                }//end if.
                              //  echo $assets;
                            ?>    
                                <div class="col-md-<?=$item_col?> w3ls_w3l_banner_left w3ls_w3l_banner_left_asdfdfd">
                                     <div class="hover14 column">
                                    <div class="agile_top_brand_left_grid w3l_agile_top_brand_left_grid">
                                            <div class="agile_top_brand_left_grid_pos"><img src="<?= $assets.$shoptheme?>/images/instock.png" alt=" " class="img-responsive img-rounded" /> </div>
                                            <!--<div class="tag"><img src="<?= $assets.$shoptheme?>/images/tag.png" alt=" " class="img-responsive"></div>-->
                                            <div class="agile_top_brand_left_grid1">
                                                <figure>
                                                <div class="snipcart-item block">
                                                    <div class="snipcart-thumb">
                                                        <a href="<?=base_url('shop/product_info/'.md5($product['id']))?>" />   <?php
                                                        $fielname = (file_exists("assets/uploads/thumbs/".$product['image'])) ?  $product['image'] :  'no_image.png';
                                                        ?>
                                                        <img src="<?= $thumbs.$fielname?>" alt="<?= $product['code']?>" class="img-responsive img-rounded" />
                                                        <p class="text-center"><?= $product['name']?></p>
                                                        <h4 class="text-center"><?= $currency_symbol?> <?= number_format($product['price'], 2)?> 
<!--                                                            <span>< ?= $currency_symbol?> < ?= number_format($product['price'], 2)?></span>-->
                                                        </h4></a>
                                                       </div>

                                                        <?php $veriants = $this->shop_model->getProductVeriantsById($product['id']); 
                                                              if($veriants){?>
                                                             <div class="snipcart-details" style="margin: 0.5em auto 0">
                                                        <select class="form-control option1" style="" id="variants_<?=$product['id']?>" name="variants_<?=$product['id']?>">
                                                            <!--<option value="null">select</option>-->
                                                         <?php foreach($veriants as $veriantskey  => $veriantss){ ?>
                                                            <option value="<?php echo $veriantskey.'~' .$veriantss->name.'~'. $veriantss->price?>"><?php echo $veriantss->name; ?></option>
                                                                <?php }?>
                                                        </select>
                                                    </div>
                                                        <?php }else{ ?>
                                                        <div class="snipcart-details" style="margin: 0.5em auto 0">&nbsp;</div>
                                                        <?php } ?>
                                                    <div class="snipcart-details">
                                                      <input type="button" name="addtocart" id="addtocart"  onclick="addToCart('<?=$product['id']?>','')" value="Add to cart" class="button pull-left" />
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
                        else
                        {
                          echo  $catlogProducts['msg'] ;
                        }
                        ?>  
                            <div align="center" style="margin-top:20px;"><?php echo $pagignation;?></div>
			</div>
		</div>
	     
	</div>
<!-- //banner -->
<?php include_once 'footer.php'; ?>


