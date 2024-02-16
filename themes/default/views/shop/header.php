<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>POS e-shop</title>
        <link href="<?= $assets.$shoptheme?>/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= $assets.$shoptheme?>/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?= $assets.$shoptheme?>/css/animate.css" rel="stylesheet">
        <link href="<?= $assets.$shoptheme?>/css/main.css" rel="stylesheet">
        <link href="<?= $assets.$shoptheme?>/css/responsive.css" rel="stylesheet">	
        <link href="<?= $assets.$shoptheme?>/css/hover.css" rel="stylesheet" media="all">
    </head><!--/head-->
    <body>
      
        <header id="header"><!--header-->          

            <div class="header-middle"><!--header-middle-->
                <div class="container">
                    <div class="row">
                        <div class="col-sm-4 logo-div" >
                            <div class="logo pull-left">
                                <span class="logo1" ><a href="<?= $baseurl;?>/shop/"><img src="<?= $baseurl;?>assets/uploads/logos/<?= $this->Settings->logo?>" alt="Logo" class="img-responsivee" /></a></span>
                            </div>
                        </div>
                        <div class="col-sm-8 account-menu">
                            <div class="shop-menu pull-right">
                                <ul class="nav navbar-nav">                                   
                                    <li class="item">
                                        <a class="" href="<?php echo site_url('shop/cart');?>">
                                            <i class="fa-shopping-cart fa"></i>Cart</a>
                                        <span class="cart-count"><?php echo $cartqty ?> </span>
                                    </li>
                                    <li>
                                     <a href="<?php echo site_url('shop/logout');?>" class="btn btn-link btn-md"><i class="fa-lock fa"></i>Logout</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div><!--/header-middle-->
            <div class="header-bottom"><!--header-bottom-->
                <div class="container">
                    <div class="row">
                        <div class="col-sm-9">
                            <div class="dropdown">
                                <button id="dropdownMenuButton" class="btn btn-secondary dropdown-toggle menu-toggle" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <span class="icon-bar"></span>
                                    <span class="icon-bar"></span>
                                    <span class="icon-bar"></span> 
                                </button>
                                <div class="dropdown-menu mainmenu pull-left" aria-labelledby="dropdownMenuButton">
                                    <ul class="nav navbar-nav navbar-collapse">
                                        <li class="item">
                                            <a class="" href="<?php echo site_url('shop/home');?>">Home</a>
                                        </li>
                                        <li class="item">
                                            <a class="" href="<?php echo site_url('shop/my_account');?>">My Account</a>
                                        </li>
                                        <li class="item">
                                            <a class="" href="<?php echo site_url('shop/contact');?>">Contact</a>
                                        </li>
                                    </ul>
                                   
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-3 text-right" style="padding-top:5px;">
                            <?php if($shop_pagename != 'cart') { ?>
                            <a href="<?php echo site_url('shop/cart');?>" class="btn btn-warning"><i class="fa-shopping-cart fa"></i> My Cart </a>
                            <?php } ?>
                        </div>
                    </div>
                </div>
            </div><!--/header-bottom-->
        </header><!--/header-->

    
 