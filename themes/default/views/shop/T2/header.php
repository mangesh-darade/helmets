<!DOCTYPE html>
<html>
    <head>
        <title><?= empty($eshop_settings->shop_name) ? "E-Shop" : $eshop_settings->shop_name ?>:: <?= $shop_pagename ?></title>
        <!-- for-mobile-apps -->
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="keywords" content="<?= $shopMeta['keywords'] ?>" />
        <script type="application/x-javascript"> 
            addEventListener("load", function() { setTimeout(hideURLbar, 0); }, false);
            function hideURLbar(){ window.scrollTo(0,1); } 
        </script>
        <!-- //for-mobile-apps -->
        <link href="<?= $assets . $shoptheme ?>/css/bootstrap.css" rel="stylesheet" type="text/css" media="all" />
        <link href="<?= $assets . $shoptheme ?>/css/style.css" rel="stylesheet" type="text/css" media="all" />
        <!-- font-awesome icons -->
        <link href="<?= $assets . $shoptheme ?>/css/font-awesome.css" rel="stylesheet" type="text/css" media="all" /> 
        <!-- //font-awesome icons -->
        <!-- js -->
        <script src="<?= $assets . $shoptheme ?>/js/jquery-1.11.1.min.js"></script>
        <!-- //js -->
        <link href='//fonts.googleapis.com/css?family=Ubuntu:400,300,300italic,400italic,500,500italic,700,700italic' rel='stylesheet' type='text/css'>
        <link href='//fonts.googleapis.com/css?family=Open+Sans:400,300,300italic,400italic,600,600italic,700,700italic,800,800italic' rel='stylesheet' type='text/css'>
        <!-- start-smoth-scrolling -->
        <script type="text/javascript" src="<?= $assets . $shoptheme ?>/js/move-top.js"></script>
        <script type="text/javascript" src="<?= $assets . $shoptheme ?>/js/easing.js"></script>
        <script type="text/javascript">
            jQuery(document).ready(function ($) {
                $(".scroll").click(function (event) {
                    event.preventDefault();
                    $('html,body').animate({scrollTop: $(this.hash).offset().top}, 1000);
                });
            });
        </script>

        <!-- start-smoth-scrolling -->
        <!-- DataTables -->
        <link rel="stylesheet" href="<?= $assets ?>bs-assets/datatables.net-bs/css/dataTables.bootstrap.min.css">
<style>
.w3l_banner_nav_right_banner {
	background:url(<?=base_url('assets/uploads/eshop_user/banner_1.jpg')?>) no-repeat 0px 0px;
	background-size:cover;
	-webkit-background-size:cover;
	-moz-background-size:cover;
	-o-background-size:cover;
	-ms-background-size:cover;
}
.w3l_banner_nav_right_banner1{
	background:url(<?=base_url('assets/uploads/eshop_user/banner_2.jpg')?>) no-repeat 0px 0px;
	background-size:cover;
	-webkit-background-size:cover;
	-moz-background-size:cover;
	-o-background-size:cover;
	-ms-background-size:cover;
}
.w3l_banner_nav_right_banner2{
	background:url(<?=base_url('assets/uploads/eshop_user/banner_3.jpg')?>) no-repeat 0px 0px;
	background-size:cover;
	-webkit-background-size:cover;
	-moz-background-size:cover;
	-o-background-size:cover;
	-ms-background-size:cover;
}
.w3l_banner_nav_right_banner3{
	background:url(<?=base_url($eshop_settings->banner_image_1)?>) no-repeat 0px 0px;
	background-size:cover;
	-webkit-background-size:cover;
	-moz-background-size:cover;
	-o-background-size:cover;
	-ms-background-size:cover;
}
.w3l_banner_nav_right_banner4{
	background:url(<?=base_url($eshop_settings->banner_image_2)?>) no-repeat 0px 0px;
	background-size:cover;
	-webkit-background-size:cover;
	-moz-background-size:cover;
	-o-background-size:cover;
	-ms-background-size:cover;
}
.w3l_banner_nav_right_banner5{
	background:url(<?=base_url($eshop_settings->banner_image_3)?>) no-repeat 0px 0px;
	background-size:cover;
	-webkit-background-size:cover;
	-moz-background-size:cover;
	-o-background-size:cover;
	-ms-background-size:cover;
}
.w3l_header_right1 h2 a{
        font-size: 23px; padding: .5em 15px;
}
.product_list_header span {
    font-size: 14px;
    padding-left: 10px;
}
.w3ls_logo_products_left h1{font-size:29px;}
.sidehead{color:green; text-transform: uppercase; text-align: center; background: #f1f1f1; padding: 2px; border-bottom: 1px solid #D2D2D2;}
.list-group {
    margin-bottom: 26px;
}
.w3l_banner_nav_left{background:#fff;}
ul.pagination li a{cursor:pointer;}
.navbar-nav > li{float: left} .dropdown-menu > li > a{display: inline; padding: 3px 0}
            .agile_top_brand_left_grid1 p{ margin: 0.5em 0 0em;} .option{ margin-bottom:10px;border:none;width:10%;height:25px; padding:0 10px;}
            .snipcart-details input.button{width:55%; font-size:12px; padding:5px 0; margin-bottom:10px;}
            .product_list_header span.cart-count{margin-left: -20px;}
            #filterbtn{display:none;}
         
.option1{
    width: 65% !important;
    height: 24px!important;
    margin: 0 19%!important;
    padding: 0px 12px!important;
    border: 1px solid #ffecec!important;
 }
 #catlist li, #brandlist li, #pricelist li{ display:none;}
.list-group li{text-align: left;}
#loadMore, #more, #pmore {
    margin-left: 6%;
    color:red;
    cursor:pointer;
     float: left;
     font-size:12px;
}
.product_list_header{margin-left: 3em;}
#loadMore:hover {
    color:black;
}
.w3ls_w3l_banner_nav_right_grid {
    padding: 0 1em 5em;}

.w3l_agile_top_brand_left_grid {
    margin: 5px 0 !important;
}

.list-group-item{padding: 5px 15px; border:none;}
.snipcart-details {margin: 0.5em auto 0;}
.bootstrapAlert{display:none}
.top_brand_home_details{margin: 0.5em auto 0em;}
.agile_top_brands_grids { margin: 2em 0 0;}
.agile_top_brand_left_grid1 p{ margin: 0.5em 0 0em;}
.cross{font-size: 24px; color:red; position: absolute; right:0;left:0;top:-7px;}
.itemcard-removeIcon {
    position: absolute;
    right: 10px;
    top: 10px;
    -webkit-border-radius: 20px;
    -moz-border-radius: 20px;
    border-radius: 20px;
    height: 24px;
    width: 24px;
    background-color: rgba(255, 255, 255, 0.6);
    border: solid 1.2px #94969F;
    cursor: pointer;
    text-align: center;}
    .wishbtn{background:green; padding:5px; font-size:12px;color:#fff;width:40%; cursor: pointer;}
 </style>          
    </head>
    <body>
        <!-- header -->
        <div class="agileits_header">
            <div class="w3l_offers">
                <a href="#">Hello <?=$user_name?>! Welcome to <?= empty($eshop_settings->shop_name) ? "E-Shop" : $eshop_settings->shop_name ?></a>
            </div>
            
            <div class="w3l_search"> 
                <?php if($visitor == 'user') { ?> 
               <?php
               $search_hidden = ['action'=>"search_products"];
               $search_attributes = ['name'=>'search_products', 'method'=>'post', 'onsubmit'=>"return submitSearch(1)"];
               echo form_open(base_url('shop/home'), $search_attributes, $search_hidden);
               ?>
                <input type="hidden" name="page" id="page" value="1" />
                <input type="text" name="search_keyword" id="search_keyword" placeholder="Search a product..." value="<?php echo (isset($_POST['search_keyword'])) ? $_POST['search_keyword'] : '' ?>" required="required" >
                <input type="submit" name="search" value=" " />
              <?php echo form_close()?>
                <?php }?>
            </div>
             
            <!--<div class="product_list_header notifications-menu">  
               <?php if($visitor == 'user') { ?> 
                <a href="<?= base_url('shop/cart') ?>" class="button" ><input type="button" name="submit" value="View your cart" class="button" /></a>
                <span class="label label-warning cart-count"><?=$cartqty?></span>
                <a href="<?= base_url('shop/WishListItems') ?>"><span>Wishlist</span> 
                    <sub><i class="fa fa-heart" aria-hidden="true" style="color:red;"></i></sub> 
                    </a><span class="label label-warning wish-count"><?= $wishlistdata['count'];?></span>
                <?php } else { ?>
                <a href="<?= base_url('shop/login') ?>" class="button" ><input type="button" name="submit" value="Start Shoping" class="button" /></a>
                <a href="<?= base_url('shop/login') ?>"><span>Wishlist</span> <i class="fa fa-heart" aria-hidden="true" style="color:red;"></i></a>
               <?php }?>
             </div>--->
                <?php if($visitor == 'user') { ?>
             <div class="product_list_header notifications-menu">  
                <a href="<?= base_url('shop/cart') ?>" class="button" ><input type="button" name="submit" value="View your cart" class="button" /></a>
                <span class="label label-warning cart-count"><?=$cartqty?></span>
                <a href="<?= base_url('shop/WishListItems') ?>"><span>Wishlist</span> 
                  <sub><i class="fa fa-heart" aria-hidden="true" style="color:red;"></i></sub> </a>
                <span class="label label-warning wish-count"><?= $wishlistdata['count'];?></span>
                </div>
                <?php }else { ?>
             <div class="product_list_header notifications-menu withoutlogin"> 
                <a href="<?= base_url('shop/login') ?>" class="button" ><input type="button" name="submit" value="Start Shoping" class="button" /></a>
                <a href="<?= base_url('shop/login') ?>"><span>Wishlist</span> <i class="fa fa-heart" aria-hidden="true" style="color:red;"></i></a>
              </div>
            <?php } ?>
            
            <div class="w3l_header_right1">
                <?php if($visitor == 'user') { ?> 
                <h2><a href="<?= base_url('shop/logout') ?>">Logout</a></h2>
                <?php } else { ?>
                <h2><a href="<?= base_url('shop/login') ?>">Login</a></h2>
               <?php }?>
            </div>
            <div class="clearfix"> </div>
        </div>
        <!-- script-for sticky-nav -->
        <script>
            $(document).ready(function () {
                var navoffeset = $(".agileits_header").offset().top;
                $(window).scroll(function () {
                    var scrollpos = $(window).scrollTop();
                    if (scrollpos >= navoffeset) {
                        $(".agileits_header").addClass("fixed");
                    } else {
                        $(".agileits_header").removeClass("fixed");
                    }
                });

            });
        </script>
        <!-- //script-for sticky-nav -->
        <div class="logo_products">

            <div class="container">
                <div class="w3ls_logo_products_left col-md-2 col-xs-2">
                <?php
                if(file_exists($eshop_settings->eshop_logo)) {
                ?>
                    <a href="<?= base_url('shop/index') ?>"><img src="<?= base_url($eshop_settings->eshop_logo) ?>" alt="<?=$eshop_settings->shop_name?>" class="img-responsive" style="max-height: 100px;" /></a>
                <?php
                } else {
                ?>
                    <h1><a href="<?= base_url('shop/index') ?>"><span><?= empty($eshop_settings->shop_name) ? $Settings->site_name : $eshop_settings->shop_name ?></span> E-shop</a></h1>
                <?php } ?>
                </div>
                <div class="w3ls_logo_products_left1 xs-hide col-md-6">
                    <ul class="special_items">					
                        <li><a href="<?= base_url('shop/about_us') ?>">About Us</a><i>/</i></li>
                        <li><a href="<?= base_url('shop/contact') ?>">Contact Us</a><i>/</i></li>
                        <li><a href="<?= base_url('shop/terms_conditions') ?>">Terms & Conditions</a><i>/</i></li>
                        <li><a href="<?= base_url('shop/privacy_policy') ?>">Policies</a><i>/</i></li>
                        <li><a href="<?= base_url('shop/faq') ?>">Faq's</a></li>
                    </ul>
                </div>
                <div class="w3ls_logo_products_right xs-hide col-md-4">
                      <ul class="phone_email">
                            <?php if(!empty($eshop_settings->shop_phone)) { ?><li><i class="fa fa-phone" aria-hidden="true"></i> <a href="tel://<?=$eshop_settings->shop_phone?>"><?=$eshop_settings->shop_phone?></a></li><?php } ?>
                            <?php if(!empty($eshop_settings->shop_email)) { ?> | <li><i class="fa fa-envelope-o" aria-hidden="true"></i> <a href="mailto:<?=$eshop_settings->shop_email?>"><?=$eshop_settings->shop_email?></a></li><?php } ?>
                     </ul> 
                </div>
                <div class="clearfix"> </div>
            </div>
        </div>
        <!-- //header -->
        <!-- products-breadcrumb -->
<!--        <div class="products-breadcrumb">
            <div class="container">
                <?php if($visitor == 'user') { ?> 
                <ul>
                    <li><i class="fa fa-home" aria-hidden="true"></i><a href="<?= base_url('shop/welcome') ?>">Home <span>|</span></a></li>
                    <li><i class="fa fa-list" aria-hidden="true"></i><a href="<?= base_url('shop/home') ?>">Products <span>|</span></a></li>
                    <li class="xs-hide"><i class="fa fa-shopping-cart" aria-hidden="true"></i><a href="<?= base_url('shop/cart') ?>">My Cart <span>|</span></a></li>
                    <li class="xs-hide"><i class="fa fa-user" aria-hidden="true"></i><a href="<?= base_url('shop/myaccount') ?>">Account </a></li>                            
                </ul>
                <?php } else { echo '&nbsp;'; } ?> 
            </div>
        </div>-->
        <!-- //products-breadcrumb -->
        <!-- Static navbar -->
        <!--<div class="products-breadcrumb">
            <nav class="navbar" style="min-height:40px;">
        <div class="container-fluid">
          <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>            
          </div>
          <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li class="active" ><a href="<?= base_url('shop/welcome') ?>"><i class="fa fa-home" aria-hidden="true"></i> Home <span>|</span></a></li>
              <li class="dropdown">
                  <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true"><i class="fa fa-list" aria-hidden="true"></i> Categories <i class="fa fa-caret-down"></i>  <span>|</span></a>                
                  <div class="dropdown-menu" style="width:1000px;">
                      <ul>                 
                        <?php
                        if (!empty($category)) {
                            $i = 0;
                            foreach ($category as $catdata) {                                 
                                ?>
                                <?php if($visitor == 'user') { ?> 
                                    <li class="col-md-3" style="text-transform: capitalize;"><i class="fa fa-check" aria-hidden="true"></i><a href="<?= base_url('shop/home/' . md5($catdata['id'])) ?>"><?= $catdata['name'] ?></a></li>
                                   <?php } else { ?>
                                    <li class="col-md-3" style="text-transform: capitalize;"><i class="fa fa-check" aria-hidden="true"></i><a href="<?= base_url('shop/login') ?>"><?= $catdata['name'] ?></a></li>
                              <?php }//end else ?>  
                              <?php
                            }//end foreach.
                        }//End if.
                        ?>
                      </ul>
                     </div>
                 
              </li>
              <li class="xs-hide"><a href="<?= base_url('shop/cart') ?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i> My Cart  <span>|</span></a></li>
              <li class="xs-hide"><a href="<?= base_url('shop/myaccount') ?>"><i class="fa fa-user" aria-hidden="true"></i> Account </a></li>
            </ul>
             
          </div><!--/.nav-collapse -->
       <!-- </div><!--/.container-fluid -->
     <!-- </nav>
        </div>-->
    <div class="products-breadcrumb" style="background: #84C639;">
   <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
              <span class="sr-only">Toggle navigation</span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
              <span class="icon-bar"></span>
            </button>            
          </div>

   <div id="navbar" class="navbar-collapse collapse">     
  <nav class="navbar" style="background: #84C639;">
  <div class="container-fluid mobcont">
   <!-- <div class="navbar-header">
      <a class="navbar-brand" href="#">WebSiteName</a>
    </div>-->
    <ul class="nav navbar-nav">
      <li class="" ><a href="<?= base_url('shop/welcome') ?>"><i class="fa fa-home" aria-hidden="true"></i> Home <span>|</span></a></li>
      <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#">Categories <i class="fa fa-caret-down"></i>  <span>|</span></a>
        <ul class="dropdown-menu wid" style="width:1000px;">
          <?php
                        if (!empty($category)) {
                            $i = 0;
                            foreach ($category as $catdata) {                                 
                                ?>
                                <?php if($visitor == 'user') { ?> 
                                    <li class="col-md-3 col-xs-12" style="text-transform: capitalize;"><i class="fa fa-check" aria-hidden="true"></i><a href="<?= base_url('shop/home/' . md5($catdata['id'])) ?>"><?= $catdata['name'] ?></a></li>
                                   <?php } else { ?>
                                    <li class="col-md-3 col-xs-12" style="text-transform: capitalize;"><i class="fa fa-check" aria-hidden="true"></i><a href="<?= base_url('shop/login') ?>"><?= $catdata['name'] ?></a></li>
                              <?php }//end else ?>  
                              <?php
                            }//end foreach.
                        }//End if.
                        ?>
        </ul>
      </li>
      <li class="xs-hide"><a href="<?= base_url('shop/cart') ?>"><i class="fa fa-shopping-cart" aria-hidden="true"></i> My Cart  <span>|</span></a></li>
      <li class="xs-hide"><a href="<?= base_url('shop/myaccount') ?>"><i class="fa fa-user" aria-hidden="true"></i> Account </a></li>
    </ul>
  </div>
</nav>
 </div>
</div>

        <style>.navbar-nav > li{float: left;} .dropdown-menu > li > a{display: inline; padding: 3px 0} 
            @media only screen and (max-width: 767px) and (min-width: 280px){
                .wid{width:100% !important; text-align: left; position: absolute !important;}
                .dropdown-menu > li{float:none;}
                .navbar-nav > li{float: left; width:25%; font-size:13px;}
                .mobcont{padding-left:0!important;; padding-right:0!important; } 
                .navbar-nav > li > a {padding: 10px 0px 10px 0px;}
                .navbar-nav .open .dropdown-menu > li > a, .navbar-nav .open .dropdown-menu .dropdown-header {
    padding: 0px 0px 0px 0px;}
    ul li, ol li {font-size: 12px!important;}
    .navbar-nav .open .dropdown-menu{text-align:left;}
    .navbar-collapse.in { overflow-y: unset;}
            }
        </style>
            