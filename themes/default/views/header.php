<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?><!DOCTYPE html>
<html>
    <head> 
        <meta charset="utf-8">
        <base href="<?= site_url() ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?= $page_title ?> - <?= $Settings->site_name ?></title>
        <link rel="shortcut icon" href="<?= $assets ?>images/icon.png"/>
        <link href="<?= $assets ?>styles/theme.css" rel="stylesheet"/>
        <link href="<?= $assets ?>styles/style.css" rel="stylesheet"/>
        <script type="text/javascript" src="<?= $assets ?>js/jquery-2.0.3.min.js"></script>
        <script type="text/javascript" src="<?= $assets ?>js/jquery-migrate-1.2.1.min.js"></script>
    <!--<script type="text/javascript"  src="<?= $assets ?>js/use.fontawesome.2d4bde2e03.js"></script>-->     
        <!--[if lt IE 9]>
        <script src="<?= $assets ?>js/jquery.js"></script>
        <![endif]-->
        <noscript>
        <style type="text/css">
            #loading {
                display: none;
            }
        </style>
        </noscript>
        <?php if ($Settings->user_rtl) { ?>
            <link href="<?= $assets ?>styles/helpers/bootstrap-rtl.min.css" rel="stylesheet"/>
            <link href="<?= $assets ?>styles/style-rtl.css" rel="stylesheet"/>
            <script type="text/javascript">
                $(document).ready(function () {
                    $('.pull-right, .pull-left').addClass('flip');
                }
                );
            </script>
        <?php } ?>
        <script type="text/javascript">
            $(window).load(function () {
                $("#loading").fadeOut("slow");
            });

            function display_WifiPrinterSetting() {
                $('#printers_wifi').css('display', 'block');
            }

        </script>
        <script>
            setTimeout(function () {
                $('#errs').fadeOut('slow');
            }, 3000);
        </script>

        <style>
            .alert_notify {            
                position: absolute;
                top: 50px;
                right: 10px;
                width: 350px;
                z-index: 55555;
                -webkit-box-shadow: 0px 5px 10px 0px rgba(102,102,102,1);
                -moz-box-shadow: 0px 5px 10px 0px rgba(102,102,102,1);
                box-shadow: 0px 5px 10px 0px rgba(102,102,102,1);
                display: block;
            }
        </style>
        <style>
         .input-group .form-control{
          z-index: 1;
         }
        </style>
        <link rel="stylesheet" href="<?= $assets ?>styles/bootstrap-tagsinput.css" />
        <link rel="stylesheet" href="<?= $assets ?>styles/bootstrap-tagsinput-app.css" />
    </head>

    <body>

        <noscript>
        <div class="global-site-notice noscript">
            <div class="notice-inner">
                <p><strong>JavaScript seems to be disabled in your browser.</strong><br>You must have JavaScript enabled in
                    your browser to utilize the functionality of this website.</p>
            </div>
        </div>
        </noscript>
        <div id="eshop-order-alert"></div>
        <div id="urbanpiper-order-alert"></div>
        <div id="loading"></div>
        <div id="app_wrapper">
            <header id="header" class="navbar">
                <div class="container">
                    <a class="navbar-brand" href="<?= site_url() ?>"><span class="logo"><?= $Settings->site_name ?></span>&nbsp;<sub>
                            <?php
                            $pos_res = json_decode($Settings->pos_version, TRUE);
                            $pos_ver = $pos_res['version'];
                            ?>

                            <?= "Version " . $pos_ver ?></sub></a>

                    <div class="btn-group visible-xs pull-right btn-visible-sm">
                        <button class="navbar-toggle btn" type="button" data-toggle="collapse" data-target="#sidebar_menu">
                            <span class="fa fa-bars"></span>
                        </button>
                        <a href="<?= site_url('users/profile/' . $this->session->userdata('user_id')); ?>" class="btn">
                            <span class="fa fa-user"></span>
                        </a>
                        <a href="<?= site_url('logout'); ?>" class="btn">
                            <span class="fa fa-sign-out"></span>
                        </a>
                    </div>
                    <div class="header-nav">
                        <ul class="nav navbar-nav pull-right">
                            <li class="dropdown">
                                <a class="btn account no-effect dropdown-toggle" data-toggle="dropdown" href="#">
                                    <img alt=""
                                         src="<?= $this->session->userdata('avatar') ? site_url() . 'assets/uploads/avatars/thumbs/' . $this->session->userdata('avatar') : base_url('assets/images/male.png'); ?>"
                                         class="mini_avatar img-rounded">

                                    <div class="user">
                                        <span><?= lang('welcome') ?> <?= $this->session->userdata('username'); ?></span>
                                    </div>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li>
                                        <a href="<?= site_url('users/profile/' . $this->session->userdata('user_id')); ?>">
                                            <i class="fa fa-user"></i> <?= lang('profile'); ?>
                                        </a>
                                    </li>
                                    <li>
                                        <a href="<?= site_url('users/profile/' . $this->session->userdata('user_id') . '/#cpassword'); ?>"><i
                                                class="fa fa-key"></i> <?= lang('change_password'); ?>
                                        </a>
                                    </li>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?= site_url('logout'); ?>">
                                            <i class="fa fa-sign-out"></i> <?= lang('logout'); ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>
                        </ul>
                        <ul class="nav navbar-nav pull-right">
                            <li class="dropdown hidden-xs"><a class="btn blightOrange tip" title="<?= lang('dashboard') ?>"
                                                              data-placement="bottom" href="<?= site_url('welcome') ?>"><i
                                        class="fa fa-dashboard"></i></a></li>
                                <?php if ($Owner) { ?>
                                <li class="dropdown hidden-sm">
                                    <a class="btn bblue tip" title="<?= lang('settings') ?>" data-placement="bottom"
                                       href="<?= site_url('system_settings') ?>">
                                        <i class="fa fa-cogs"></i>
                                    </a>
                                </li>
                            <?php } ?>
                            <li class="dropdown hidden-xs">
                                <a class="btn bdarkGreen tip" title="<?= lang('calculator') ?>" data-placement="bottom" href="#"
                                   data-toggle="dropdown">
                                    <i class="fa fa-calculator"></i>
                                </a>
                                <ul class="dropdown-menu pull-right calc">
                                    <li class="dropdown-content">
                                        <span id="inlineCalc"></span>
                                    </li>
                                </ul>
                            </li>
                            <?php if ($info) { ?>
                                <li class="dropdown hidden-sm">
                                    <a class="btn  tip" title="<?= lang('notifications') ?>" data-placement="bottom" href="#"
                                       data-toggle="dropdown">
                                        <i class="fa fa-bell"></i>
                                        <span class="number blightOrange black"><?= sizeof($info) ?></span>
                                    </a>
                                    <ul class="dropdown-menu pull-right content-scroll">
                                        <li class="dropdown-header"><i
                                                class="fa fa-info-circle"></i> <?= lang('notifications'); ?></li>
                                        <li class="dropdown-content">
                                            <div class="scroll-div">
                                                <div class="top-menu-scroll">
                                                    <ol class="oe">
                                                        <?php
                                                        foreach ($info as $n) {
                                                            echo '<li>' . $n->comment . '</li>';
                                                        }
                                                        ?>
                                                    </ol>
                                                </div>
                                            </div>
                                        </li>
                                    </ul>
                                </li>
                            <?php } ?>
<?php if ($events) { ?>
                                <li class="dropdown hidden-xs">
                                    <a class="btn borange tip" title="<?= lang('calendar') ?>" data-placement="bottom" href="#"
                                       data-toggle="dropdown">
                                        <i class="fa fa-calendar"></i>
                                        <span class="number blightOrange black"><?= sizeof($events) ?></span>
                                    </a>
                                    <ul class="dropdown-menu pull-right content-scroll">
                                        <li class="dropdown-header">
                                            <i class="fa fa-calendar"></i> <?= lang('upcoming_events'); ?>
                                        </li>
                                        <li class="dropdown-content">
                                            <div class="top-menu-scroll">
                                                <ol class="oe">
                                                    <?php
                                                    foreach ($events as $event) {
                                                        echo '<li>' . date($dateFormats['php_ldate'], strtotime($event->start)) . ' <strong>' . $event->title . '</strong><br>' . $event->description . '</li>';
                                                    }
                                                    ?>
                                                </ol>
                                            </div>
                                        </li>
                                        <li class="dropdown-footer">
                                            <a href="<?= site_url('calendar') ?>" class="btn-block link">
                                                <i class="fa fa-calendar"></i> <?= lang('calendar') ?>
                                            </a>
                                        </li>
                                    </ul>
                                </li>
<?php } else { ?>
                                <li class="dropdown hidden-xs">
                                    <a class="btn borange tip" title="<?= lang('calendar') ?>" data-placement="bottom"
                                       href="<?= site_url('calendar') ?>">
                                        <i class="fa fa-calendar"></i>
                                    </a>
                                </li>
<?php } ?>


                            <li class="dropdown hidden-sm">
                                <a class="btn blightOrange tip" title="<?= lang('styles') ?>" data-placement="bottom"
                                   data-toggle="dropdown"
                                   href="#">
                                    <i class="fa fa-paint-brush"></i>
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <li class="bwhite noPadding">
                                        <a href="#" id="fixed" class="">
                                            <i class="fa fa-angle-double-left"></i>
                                            <span id="fixedText">Fixed</span>
                                        </a>
                                        <a href="#" id="cssLight" class="grey">
                                            <i class="fa fa-stop"></i> Grey
                                        </a>
                                        <a href="#" id="cssBlue" class="blue">
                                            <i class="fa fa-stop"></i> Blue
                                        </a>
                                        <a href="#" id="cssBlack" class="black">
                                            <i class="fa fa-stop"></i> Black
                                        </a>
                                    </li>
                                </ul>
                            </li>
                            <li class="dropdown hidden-xs">
                                <a class="btn bblue tip" title="<?= lang('language') ?>" data-placement="bottom"
                                   data-toggle="dropdown"
                                   href="#">
                                    <img src="<?= base_url('assets/images/' . $Settings->user_language . '.png'); ?>" alt="">
                                </a>
                                <ul class="dropdown-menu pull-right">
                                    <?php
                                    $scanned_lang_dir = array_map(function($path) {
                                        return basename($path);
                                    }, glob(APPPATH . 'language/*', GLOB_ONLYDIR));


                                    foreach ($scanned_lang_dir as $entry) {
                                        ?>
                                        <li>
                                            <a href="<?= site_url('welcome/language/' . $entry); ?>">
                                                <img src="<?= base_url(); ?>assets/images/<?= $entry; ?>.png"
                                                     class="language-img">
                                                &nbsp;&nbsp;<?= ucwords($entry); ?>
                                            </a>
                                        </li>
<?php } ?>
                                    <li class="divider"></li>
                                    <li>
                                        <a href="<?= site_url('welcome/toggle_rtl') ?>">
                                            <i class="fa fa-align-<?= $Settings->user_rtl ? 'right' : 'left'; ?>"></i>
<?= lang('toggle_alignment') ?>
                                        </a>
                                    </li>
                                </ul>
                            </li>
<?php if ($Owner && $Settings->update) { ?>
                                <li class="dropdown hidden-sm">
                                    <a class="btn bdarkGreen tip" title="<?= lang('update_available') ?>"
                                       data-placement="bottom" data-container="body"
                                       href="<?= site_url('system_settings/updates') ?>">
                                        <i class="fa fa-download"></i>
                                    </a>
                                </li>
<?php } ?>
<?php if (($Owner || $Admin || $GP['reports-quantity_alerts'] || $GP['reports-expiry_alerts']) && ($qty_alert_num > 0 || $exp_alert_num > 0)) { ?>
                                <li class="dropdown hidden-sm">
                                    <a class="btn borange tip" title="<?= lang('alerts') ?>"
                                       data-placement="bottom" data-toggle="dropdown" href="#">
                                        <i class="fa fa-exclamation-triangle"></i>
                                    </a>
                                    <ul class="dropdown-menu pull-right">
                                        <li>
                                            <a href="<?= site_url('reports/quantity_alerts') ?>" class="">
                                                <span class="label label-danger pull-right"
                                                      style="margin-top:3px;"><?= $qty_alert_num; ?></span>
                                                <span style="padding-right: 35px;"><?= lang('quantity_alerts') ?></span>
                                            </a>
                                        </li>


    <?php if ($Settings->product_expiry) { ?>
                                            <li>
                                                <a href="<?= site_url('reports/expiry_alerts') ?>" class="">
                                                    <span class="label label-danger pull-right"
                                                          style="margin-top:3px;"><?= $exp_alert_num; ?></span>
                                                    <span style="padding-right: 35px;"><?= lang('expiry_alerts') ?></span>
                                                </a>
                                            </li>
                                <?php } ?>
                                    </ul>
                                </li>
<?php } ?>
<?php if (POS) { ?>
                                <li class="dropdown hidden-xs">
                                    <a class="btn blightOrange tip" title="<?= lang('pos') ?>" data-placement="bottom"
                                       href="<?= site_url('pos') ?>">
                                        <i class="fa fa-th-large"></i> <span class="padding05"><?= lang('pos') ?></span>
                                    </a>
                                </li>
<?php } ?>
<?php if ($Owner) { ?>
                                <li class="dropdown">
                                    <a class="btn bblue  tip" id="today_profit" title="<span><?= lang('today_profit') ?></span>"
                                       data-placement="bottom" data-html="true" href="<?= site_url('reports/profit') ?>"
                                       data-toggle="modal" data-target="#myModal">
                                        <i class="fa fa-line-chart"></i>
                                    </a>
                                </li>
<?php } ?>
<?php if ($Owner || $Admin) { ?>
    <?php if (POS) { ?>
                                    <li class="dropdown hidden-xs">
                                        <a class="btn bdarkGreen tip" title="<?= lang('list_open_registers') ?>"
                                           data-placement="bottom" href="<?= site_url('pos/registers') ?>">
                                            <i class="fa fa-book"></i>
                                        </a>
                                    </li>
    <?php } ?>
                                <li class="dropdown hidden-xs">
                                    <a class="btn borange bred tip" title="<?= lang('clear_ls') ?>" data-placement="bottom"
                                       id="clearLS" href="#">
                                        <i class="fa fa-trash"></i>
                                    </a>
                                </li>
<?php } ?>
<?php if ($eshop_due_payment && isset($eshop_due_payment->cnt) && $eshop_due_payment->cnt > 0): ?>
                                <li class="dropdown hidden-xs">
                                    <a class="btn blightOrange tip" title="Payment due orders (ESHOP)" data-placement="bottom"
                                        href="<?= site_url('sales/eshop_sales?status=due') ?>">
                                        <i class="fa fa-bell" aria-hidden="true"></i><?php echo $eshop_due_payment->cnt ?>
                                    </a>
                                </li>
<?php endif; ?>
                            <li class="dropdown hidden-xs">
                                <a class="btn blightOrange tip" title="New orders (ESHOP)" data-placement="bottom"
                                   href="<?= site_url('sales/eshop_sales') ?>">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span id="eshop_new_orders">0</span>
                                </a>
                            </li>
                            <li class="dropdown hidden-xs">
                                <a class="btn blightOrange tip" title="New orders (Urbanpiper)" data-placement="bottom"
                                   href="<?= site_url('urban_piper') ?>">
                                    <i class="fa fa-shopping-cart" aria-hidden="true"></i> <span id="urbanpipersorder">0</span>
                                </a>
                            </li>   

                        </ul>
                    </div>
                </div>
            </header>

            <div class="container" id="container">

                <div class="row" id="main-con">
                    <table class="lt">
                        <tr>
                            <td class="sidebar-con">
                                <div id="sidebar-left">
                                    <div class="sidebar-nav nav-collapse collapse navbar-collapse" id="sidebar_menu">
                                        <ul class="nav main-menu">
                                            <li class="mm_welcome">
                                                <a href="<?= site_url() ?>">
                                                    <i class="fa fa-dashboard"></i>
                                                    <span class="text"> <?= lang('dashboard'); ?></span>
                                                </a>
                                            </li>

                                            <?php
                                            if ($Owner || $Admin) {
                                                ?>

                                                <li class="mm_products">
                                                    <a class="dropmenu" href="#">
                                                        <i class="fa fa-archive"></i>
                                                        <span class="text"> <?= lang('products'); ?> </span>
                                                        <span class="chevron closed"></span>
                                                    </a>
                                                    <ul>
                                                        <li id="products_index">
                                                            <a class="submenu" href="<?= site_url('products'); ?>">
                                                                <i class="fa fa-barcode"></i>
                                                                <span class="text"> <?= lang('list_products'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="products_add">
                                                            <a class="submenu" href="<?= site_url('products/add'); ?>">
                                                                <i class="fa fa-plus-circle"></i>
                                                                <span class="text"> <?= lang('add_product'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="products_import_csv">
                                                            <a class="submenu" href="<?= site_url('products/import_csv'); ?>">
                                                                <i class="fa fa-file-text"></i>
                                                                <span class="text"> <?= lang('import_products'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="products_print_barcodes">
                                                            <a class="submenu"
                                                               href="<?= site_url('products/print_barcodes'); ?>">
                                                                <i class="fa fa-tags"></i>
                                                                <span class="text"> <?= lang('print_barcode_label'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="products_quantity_adjustments">
                                                            <a class="submenu"
                                                               href="<?= site_url('products/quantity_adjustments'); ?>">
                                                                <i class="fa fa-filter"></i>
                                                                <span class="text"> <?= lang('quantity_adjustments'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="products_add_adjustment">
                                                            <a class="submenu"
                                                               href="<?= site_url('products/add_adjustment'); ?>">
                                                                <i class="fa fa-filter"></i>
                                                                <span class="text"> <?= lang('add_adjustment'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="products_stock_counts">
                                                            <a class="submenu" href="<?= site_url('products/stock_counts'); ?>">
                                                                <i class="fa fa-list-ol"></i>
                                                                <span class="text"> <?= lang('stock_counts'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="products_count_stock">
                                                            <a class="submenu" href="<?= site_url('products/count_stock'); ?>">
                                                                <i class="fa fa-plus-circle"></i>
                                                                <span class="text"> <?= lang('count_stock'); ?></span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>

                                                <li class="mm_sales <?= strtolower($this->router->fetch_method()) == 'settings' ? '' : 'mm_pos' ?>">
                                                    <a class="dropmenu" href="#">
                                                        <i class="fa fa-bar-chart"></i>
                                                        <span class="text"> <?= lang('sales'); ?>
                                                        </span> <span class="chevron closed"></span>
                                                    </a>
                                                    <ul>
                                                        <li id="sales_index">
                                                            <a class="submenu" href="<?= site_url('sales'); ?>">
                                                                <i class="fa fa-heart"></i>
                                                                <span class="text"> <?= lang('list_sales'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="eshop_sales">
                                                            <a class="submenu" href="<?= site_url('eshop_sales/sales'); ?>">
                                                                <i class="fa fa-heart"></i>
                                                                <span class="text"> Eshop Sales</span>
                                                            </a>
                                                        </li>
                                                        <li id="offline_sales">
                                                            <a class="submenu" href="<?= site_url('offline/sales'); ?>">
                                                                <i class="fa fa-heart"></i>
                                                                <span class="text">  Offline Sales</span>
                                                            </a>
                                                        </li>
    <?php if (POS) { ?>
                                                            <li id="pos_sales">
                                                                <a class="submenu" href="<?= site_url('pos/sales'); ?>">
                                                                    <i class="fa fa-heart"></i>
                                                                    <span class="text"> <?= lang('pos_sales'); ?></span>
                                                                </a>
                                                            </li>
                                                        <?php } ?>

    <?php if ($Settings->pos_type == 'restaurant') { ?>
                                                            <li class="urbanpiper_sales"> 
                                                                <a class="submenu" href="<?= site_url('urban_piper/sales'); ?>">
                                                                    <i class="fa fa-plus-circle"></i>
                                                                    <span class="text"> <?= lang('Urban Piper Sales'); ?></span>
                                                                </a>
                                                            </li>  
    <?php } ?> 

                                                        <li id="mode_sales_index">
                                                            <a class="submenu" href="<?= site_url('sales/all_sale_lists'); ?>">
                                                                <i class="fa fa-heart"></i>
                                                                <span class="text"> <?= lang('All_Sale_List'); ?> <img src="<?= site_url('themes/default/assets/images/new.gif') ?>" height="30px" alt="new"></span>
                                                            </a>
                                                        </li>
                                                        <li id="sales_add">
                                                            <a class="submenu" href="<?= site_url('sales/add'); ?>">
                                                                <i class="fa fa-plus-circle"></i>
                                                                <span class="text"> <?= lang('add_sale'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="sales_sale_by_csv">
                                                            <a class="submenu" href="<?= site_url('sales/sale_by_csv'); ?>">
                                                                <i class="fa fa-plus-circle"></i>
                                                                <span class="text"> <?= lang('add_sale_by_csv'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="sales_deliveries">
                                                            <a class="submenu" href="<?= site_url('sales/deliveries'); ?>">
                                                                <i class="fa fa-truck"></i>
                                                                <span class="text"> <?= lang('deliveries'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="sales_gift_cards">
                                                            <a class="submenu" href="<?= site_url('sales/gift_cards'); ?>">
                                                                <i class="fa fa-gift"></i>
                                                                <span class="text"> <?= lang('list_gift_cards'); ?></span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>

                                                <li class="mm_quotes">
                                                    <a class="dropmenu" href="#">
                                                        <i class="fa fa-file-text-o"></i>
                                                        <span class="text"> <?= lang('quotes'); ?> </span>
                                                        <span class="chevron closed"></span>
                                                    </a>
                                                    <ul>
                                                        <li id="quotes_index">
                                                            <a class="submenu" href="<?= site_url('quotes'); ?>">
                                                                <i class="fa fa-heart-o"></i>
                                                                <span class="text"> <?= lang('list_quotes'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="quotes_add">
                                                            <a class="submenu" href="<?= site_url('quotes/add'); ?>">
                                                                <i class="fa fa-plus-circle"></i>
                                                                <span class="text"> <?= lang('add_quote'); ?></span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>

                                                <li class="mm_purchases">
                                                    <a class="dropmenu" href="#">
                                                        <i class="fa fa-shopping-cart"></i>
                                                        <span class="text"> <?= lang('purchases'); ?>
                                                        </span> <span class="chevron closed"></span>
                                                    </a>
                                                    <ul>
                                                        <li id="purchases_index">
                                                            <a class="submenu" href="<?= site_url('purchases'); ?>">
                                                                <i class="fa fa-star"></i>
                                                                <span class="text"> <?= lang('list_purchases'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="purchases_add">
                                                            <a class="submenu" href="<?= site_url('purchases/add'); ?>">
                                                                <i class="fa fa-plus-circle"></i>
                                                                <span class="text"> <?= lang('add_purchase'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="purchases_purchase_by_csv">
                                                            <a class="submenu"
                                                               href="<?= site_url('purchases/purchase_by_csv'); ?>">
                                                                <i class="fa fa-plus-circle"></i>
                                                                <span class="text"> <?= lang('add_purchase_by_csv'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="purchases_expenses">
                                                            <a class="submenu" href="<?= site_url('purchases/expenses'); ?>">
                                                                <i class="fa fa-dollar"></i>
                                                                <span class="text"> <?= lang('list_expenses'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="purchases_add_expense">
                                                            <a class="submenu" href="<?= site_url('purchases/add_expense'); ?>"
                                                               data-toggle="modal" data-target="#myModal">
                                                                <i class="fa fa-plus-circle"></i>
                                                                <span class="text"> <?= lang('add_expense'); ?></span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>

                                                <li class="mm_transfers">
                                                    <a class="dropmenu" href="#">
                                                        <i class="fa fa-exchange"></i>
                                                        <span class="text"> <?= lang('transfers'); ?> </span>
                                                        <span class="chevron closed"></span>
                                                    </a>
                                                    <ul>
                                                        <li id="transfers_index">
                                                            <a class="submenu" href="<?= site_url('transfers'); ?>">
                                                                <i class="fa fa-star-o"></i><span
                                                                    class="text"> <?= lang('list_transfers'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="transfers_add">
                                                            <a class="submenu" href="<?= site_url('transfers/add'); ?>">
                                                                <i class="fa fa-plus-circle"></i><span
                                                                    class="text"> <?= lang('add_transfer'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="transfers_purchase_by_csv">
                                                            <a class="submenu"
                                                               href="<?= site_url('transfers/transfer_by_csv'); ?>">
                                                                <i class="fa fa-plus-circle"></i><span
                                                                    class="text"> <?= lang('add_transfer_by_csv'); ?></span>
                                                            </a>
                                                        </li>
                                                        <!-- 2/04/19 -->
                                                        <li id="transfers_purchase_by_csv">
                                                            <a class="submenu"
                                                               href="<?= site_url('transfers/request'); ?>">
                                                                <i class="fa fa-plus-circle"></i><span
                                                                    class="text"> <?= lang('Add Products Request'); ?></span>
                                                            </a>
                                                        </li>
                                                        <!-- End 2/04/19 -->
                                                    </ul>
                                                </li>

                                                <li class="mm_auth mm_customers mm_suppliers mm_billers">
                                                    <a class="dropmenu" href="#">
                                                        <i class="fa fa-users"></i>
                                                        <span class="text"> <?= lang('people'); ?> </span>
                                                        <span class="chevron closed"></span>
                                                    </a>
                                                    <ul>
    <?php if ($Owner) { ?>
                                                            <li id="auth_users">
                                                                <a class="submenu" href="<?= site_url('users'); ?>">
                                                                    <i class="fa fa-users"></i><span
                                                                        class="text"> <?= lang('list_users'); ?></span>
                                                                </a>
                                                            </li>
                                                            <li id="auth_create_user">
                                                                <a class="submenu" href="<?= site_url('users/create_user'); ?>">
                                                                    <i class="fa fa-user-plus"></i><span
                                                                        class="text"> <?= lang('new_user'); ?></span>
                                                                </a>
                                                            </li>
                                                            <li id="billers_index">
                                                                <a class="submenu" href="<?= site_url('billers'); ?>">
                                                                    <i class="fa fa-users"></i><span
                                                                        class="text"> <?= lang('list_billers'); ?></span>
                                                                </a>
                                                            </li>
                                                            <li id="billers_index">
                                                                <a class="submenu" href="<?= site_url('billers/add'); ?>"
                                                                   data-toggle="modal" data-target="#myModal">
                                                                    <i class="fa fa-plus-circle"></i><span
                                                                        class="text"> <?= lang('add_biller'); ?></span>
                                                                </a>
                                                            </li>
	                                                    <li id="sales_person_index">
                                                                <a class="submenu" href="<?= site_url('sales_person'); ?>">
                                                                    <i class="fa fa-users"></i><span
                                                                        class="text"> <?= lang('List_Sales_Person'); ?></span> <img src="<?= $assets ?>images/new.gif" height="30px" alt="new" />
                                                                </a>
                                                            </li>
                                                            <li id="sales_person_index">
                                                                <a class="submenu" href="<?= site_url('sales_person/add'); ?>"
                                                                   data-toggle="modal" data-target="#myModal">
                                                                    <i class="fa fa-plus-circle"></i><span
                                                                        class="text"> <?= lang('Add_Sales_Person'); ?></span> <img src="<?= $assets ?>images/new.gif" height="30px" alt="new" />
                                                                </a>
                                                            </li>
    <?php } ?>
                                                        <li id="customers_index">
                                                            <a class="submenu" href="<?= site_url('customers'); ?>">
                                                                <i class="fa fa-users"></i><span
                                                                    class="text"> <?= lang('list_customers'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="customers_index">
                                                            <a class="submenu" href="<?= site_url('customers/add'); ?>"
                                                               data-toggle="modal" data-target="#myModal">
                                                                <i class="fa fa-plus-circle"></i><span
                                                                    class="text"> <?= lang('add_customer'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="suppliers_index">
                                                            <a class="submenu" href="<?= site_url('suppliers'); ?>">
                                                                <i class="fa fa-users"></i><span
                                                                    class="text"> <?= lang('list_suppliers'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="suppliers_index">
                                                            <a class="submenu" href="<?= site_url('suppliers/add'); ?>"
                                                               data-toggle="modal" data-target="#myModal">
                                                                <i class="fa fa-plus-circle"></i><span
                                                                    class="text"> <?= lang('add_supplier'); ?></span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>
                                                <li class="mm_notifications">
                                                    <a class="submenu" href="<?= site_url('notifications'); ?>">
                                                        <i class="fa fa-info-circle"></i><span
                                                            class="text"> <?= lang('notifications'); ?></span>
                                                    </a>
                                                </li>

                                                <li class="">
                                                    <a class="submenu" href="<?= site_url('smsdashboard'); ?>">
                                                        <i class="fa fa-envelope"></i><span
                                                            class="text"> <?= lang('CRM Portal'); ?></span>
                                                    </a>
                                                </li>
    <?php if ($Owner) { ?>
                                                    <li class="mm_eshop_admin <?= strtolower($this->router->fetch_method()) != 'eshop_admin' ? '' : 'eshop_admin' ?>">
                                                        <a class="dropmenu" href="#">
                                                            <i class="fa fa-cart-plus"></i><span
                                                                class="text">Eshop Admin </span>
                                                            <span class="chevron closed"></span>
                                                        </a>
                                                        <ul>
                                                            <li id="eshop_admin_pages">
                                                                <a href="<?= site_url('eshop_admin/pages'); ?>">
                                                                    <i class="fa fa-newspaper-o"></i>
                                                                    <span class="text"> Eshop Pages</span>
                                                                </a>
                                                            </li>
                                                            <li id="eshop_admin_settings">
                                                                <a href="<?= site_url('eshop_admin/shipping_methods'); ?>">
                                                                    <i class="fa fa-cog"></i>
                                                                    <span class="text"> Shipping Methods <img src="<?= $assets ?>images/new.gif" height="30px" alt="new" /></span>
                                                                </a>
                                                            </li>
                                                            <li id="eshop_admin_settings">
                                                                <a href="<?= site_url('eshop_admin/settings'); ?>">
                                                                    <i class="fa fa-cog"></i>
                                                                    <span class="text"> Eshop Settings</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>

                                                    <?php if ($Settings->pos_type == 'restaurant') { ?>
                                                        <!--  Urbanpiper -->
                                                        <li class="mm_urban_piper" >
                                                            <a class="dropmenu" href="#">
                                                                <i class="fa fa-magnet"></i>
                                                                <span class="text"> <?= lang('Urbanpiper'); ?> <img src="<?= site_url('themes/default/assets/images/new.gif') ?>" height="30px" alt="new"></span>
                                                                <span class="chevron closed"></span>
                                                            </a>
                                                            <ul>
                                                                <li id="urban_piper_settings">
                                                                    <a href="<?= site_url('urban_piper/settings') ?>">
                                                                        <i class="fa fa-cogs" aria-hidden="true"></i>
                                                                        <span  class="text" > Urbanpiper Settings </span>   
                                                                    </a>
                                                                </li>
                                                                <li id="urban_piper_store_info">
                                                                    <a href="<?= site_url('urban_piper/store_info') ?>">
                                                                        <i class="fa fa-list" aria-hidden="true"></i>
                                                                        <span  class="text" > Manage Stores </span>
                                                                    </a>    
                                                                </li>
                                                                <li id="urban_piper_product_platform">
                                                                    <a href="<?= site_url('urban_piper/product_platform') ?>">
                                                                        <i class="fa fa-archive" aria-hidden="true"></i>
                                                                        <span  class="text" > Manage Catalogue </span>
                                                                    </a> 

                                                                </li>
                                                                <li id="urban_piper_index">
                                                                    <a href="<?= site_url('urban_piper') ?>">
                                                                        <i class="fa fa-list" aria-hidden="true"></i>
                                                                        <span  class="text" > Manage Orders </span>
                                                                    </a>    
                                                                </li>


                                                                <!--                                                <li id="urbanpiper_category">
                                                                                                                    <a href="<?= site_url('urban_piper/category') ?>">
                                                                                                                        <i class="fa fa-folder-open" aria-hidden="true"></i>
                                                                                                                        <span  class="text" > Category </span>
                                                                                                                    </a> 
                                                                                                                    
                                                                                                                </li>

                                                               <li id="urbanpiper_product">
                                                                    <a href="<?= site_url('urban_piper/product') ?>">
                                                                        <i class="fa fa-archive" aria-hidden="true"></i>
                                                                        <span  class="text" > Product </span>
                                                                    </a> 

                                                                </li>-->
                                                              <!--    <li id="urbanpiper_product_platform">
                                                                     <a href="<?= site_url('urban_piper/groups_option') ?>">
                                                                         <i class="fa fa-archive" aria-hidden="true"></i>
                                                                         <span  class="text" > Option Groups</span>
                                                                     </a> 
                                                                 </li>-->
                                                                

                                                                
                                                            </ul>
                                                        </li> 
                                                        <!-- Urbanpiper -->
                                                    <?php }//end if ?>

                                                    <li class="mm_system_settings <?= strtolower($this->router->fetch_method()) != 'settings' ? '' : 'mm_pos' ?>">
                                                        <a class="dropmenu" href="#">
                                                            <i class="fa fa-cog"></i><span
                                                                class="text"> <?= lang('settings'); ?> </span>
                                                            <span class="chevron closed"></span>
                                                        </a>
                                                        <ul>
                                                            <li id="system_settings_index">
                                                                <a href="<?= site_url('system_settings') ?>">
                                                                    <i class="fa fa-cog"></i><span
                                                                        class="text"> <?= lang('system_settings'); ?></span>
                                                                </a>
                                                            </li>
        <?php if (POS) { ?>
                                                                <li id="pos_settings">
                                                                    <a href="<?= site_url('pos/settings') ?>">
                                                                        <i class="fa fa-th-large"></i><span
                                                                            class="text"> <?= lang('pos_settings'); ?></span>
                                                                    </a>
                                                                </li>
        <?php } ?>
                                                            <li id="system_settings_change_logo">
                                                                <a href="<?= site_url('system_settings/change_logo') ?>"
                                                                   data-toggle="modal" data-target="#myModal">
                                                                    <i class="fa fa-upload"></i><span
                                                                        class="text"> <?= lang('change_logo'); ?></span>
                                                                </a>
                                                            </li>
                                                            <li id="system_settings_currencies">
                                                                <a href="<?= site_url('system_settings/currencies') ?>">
                                                                    <i class="fa fa-money"></i><span
                                                                        class="text"> <?= lang('currencies'); ?></span>
                                                                </a>
                                                            </li>
                                                            <li id="system_settings_customer_groups">
                                                                <a href="<?= site_url('system_settings/customer_groups') ?>">
                                                                    <i class="fa fa-chain"></i><span
                                                                        class="text"> <?= lang('customer_groups'); ?></span>
                                                                </a>
                                                            </li>
                                                            <li id="system_settings_price_groups">
                                                                <a href="<?= site_url('system_settings/price_groups') ?>">
                                                                    <i class="fa fa-dollar"></i><span
                                                                        class="text"> <?= lang('price_groups'); ?></span>
                                                                </a>
                                                            </li>
                                                            <li id="system_settings_restaurant_tables">
                                                                <a href="<?= site_url('system_settings/restaurant_tables') ?>">
                                                                    <i class="fa fa-dollar"></i><span class="text"><?= lang('restaurant_tables'); ?></span>
                                                                </a>
                                                            </li>
                                                            <li id="system_settings_categories">
                                                                <a href="<?= site_url('system_settings/categories') ?>">
                                                                    <i class="fa fa-folder-open"></i><span
                                                                        class="text"> <?= lang('categories'); ?></span>
                                                                </a>
                                                            </li>
                                                            <li id="system_settings_expense_categories">
                                                                <a href="<?= site_url('system_settings/expense_categories') ?>">
                                                                    <i class="fa fa-folder-open"></i><span
                                                                        class="text"> <?= lang('expense_categories'); ?></span>
                                                                </a>
                                                            </li>
                                                            <li id="system_settings_units">
                                                                <a href="<?= site_url('system_settings/units') ?>">
                                                                    <i class="fa fa-wrench"></i><span
                                                                        class="text"> <?= lang('units'); ?></span>
                                                                </a>
                                                            </li>
                                                            <li id="system_settings_brands">
                                                                <a href="<?= site_url('system_settings/brands') ?>">
                                                                    <i class="fa fa-th-list"></i><span
                                                                        class="text"> <?= lang('brands'); ?></span>
                                                                </a>
                                                            </li>
                                                            <li id="system_settings_variants">
                                                                <a href="<?= site_url('system_settings/variants') ?>">
                                                                    <i class="fa fa-tags"></i><span
                                                                        class="text"> <?= lang('variants'); ?></span>
                                                                </a>
                                                            </li>
                                                            <li id="system_settings_tax_rates">
                                                                <a href="<?= site_url('system_settings/tax_rates') ?>">
                                                                    <i class="fa fa-plus-circle"></i><span
                                                                        class="text"> <?= lang('tax_rates'); ?></span>
                                                                </a>
                                                            </li>
                                                            <li id="system_settings_tax_rates_attr">
                                                                <a href="<?= site_url('system_settings/tax_rates_attr') ?>">
                                                                    <i class="fa fa-plus-circle"></i><span
                                                                        class="text"> <?= lang('tax_rates'); ?>
                                                                        Attributes </span>
                                                                </a>
                                                            </li>
                                                            <li id="system_settings_warehouses">
                                                                <a href="<?= site_url('system_settings/warehouses') ?>">
                                                                    <i class="fa fa-building-o"></i><span
                                                                        class="text"> <?= lang('warehouses'); ?></span>
                                                                </a>
                                                            </li>
                                                            <li id="system_settings_email_templates">
                                                                <a href="<?= site_url('system_settings/email_templates') ?>">
                                                                    <i class="fa fa-envelope"></i><span
                                                                        class="text"> <?= lang('email_templates'); ?></span>
                                                                </a>
                                                            </li>
                                                            <li id="system_settings_user_groups">
                                                                <a href="<?= site_url('system_settings/user_groups') ?>">
                                                                    <i class="fa fa-key"></i><span
                                                                        class="text"> <?= lang('group_permissions'); ?></span>
                                                                </a>
                                                            </li>
                                                            <li id="system_settings_backups">
                                                                <a href="<?= site_url('system_settings/backups') ?>">
                                                                    <i class="fa fa-database"></i><span
                                                                        class="text"> <?= lang('backups'); ?></span>
                                                                </a>
                                                            </li>
                                                            <!--<li id="system_settings_updates">
                                                        <a href="<?= site_url('system_settings/updates') ?>">
                                                            <i class="fa fa-upload"></i><span class="text"> <?= lang('updatesuuuuu'); ?></span>
                                                        </a>
                                                    </li>-->

                                                            <li id="offer&discount">
                                                                <a href="<?= site_url('system_settings/offer_list'); ?>" >
                                                                    <i class="fa fa-gift" aria-hidden="true"></i>
                                                                    <span class="text">  Offer <img src="<?= $assets ?>images/new.gif" height="30px" alt="new" /></span>
                                                                </a>    
                                                            </li>
                                                            <li id="offer&category">
                                                                <a href="<?= site_url('system_settings/offercategory'); ?>" >
                                                                    <i class="fa fa-gift" aria-hidden="true"></i>
                                                                    <span class="text">  Offer Category <img src="<?= $assets ?>images/new.gif" height="30px" alt="new" /></span>
                                                                </a>    
                                                            </li>
                                                            <li id="printers">
                                                                <a href="<?= site_url('system_settings/printers'); ?>">
                                                                    <i class="fa fa-print"></i>
                                                                    <span class="text">  Manage Printers Option</span>
                                                                </a>
                                                            </li>
                                                            <li id="printers_wifi" style="display:none">
                                                                <a href="javascript:window.MyHandler.OpenWifiPrinterDialog()">
                                                                    <i class="fa fa-wifi"></i>
                                                                    <span class="text"> Wifi Printer Setting</span>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </li>
    <?php } ?>
                                                <li class="mm_reports">
                                                    <a class="dropmenu" href="#">
                                                        <i class="fa fa-pie-chart"></i>
                                                        <span class="text"> <?= lang('reports'); ?> </span>
                                                        <span class="chevron closed"></span>
                                                    </a>
                                                    <ul>
                                                        <li id="reports_index">
                                                            <a href="<?= site_url('reports') ?>">
                                                                <i class="fa fa-bars"></i><span
                                                                    class="text"><?= lang('overview_chart'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="reports_warehouse_stock">
                                                            <a href="<?= site_url('reports/warehouse_stock') ?>">
                                                                <i class="fa fa-building"></i><span
                                                                    class="text"> <?= lang('warehouse_stock'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="reports_best_sellers">
                                                            <a href="<?= site_url('reports/best_sellers') ?>">
                                                                <i class="fa fa-thumbs-up"></i><span
                                                                    class="text"> <?= lang('best_sellers'); ?></span>
                                                            </a>
                                                        </li>
    <?php if (POS) { ?>
                                                            <li id="reports_register">
                                                                <a href="<?= site_url('reports/register') ?>">
                                                                    <i class="fa fa-th-large"></i><span
                                                                        class="text"> <?= lang('register_report'); ?></span>
                                                                </a>
                                                            </li>
    <?php } ?>
                                                        <li id="reports_quantity_alerts">
                                                            <a href="<?= site_url('reports/quantity_alerts') ?>">
                                                                <i class="fa fa-sort-amount-desc"></i><span
                                                                    class="text"> <?= lang('product_quantity_alerts'); ?></span>
                                                            </a>
                                                        </li>
    <?php if ($Settings->product_expiry) { ?>
                                                            <li id="reports_expiry_alerts">
                                                                <a href="<?= site_url('reports/expiry_alerts') ?>">
                                                                    <i class="fa fa-bar-chart-o"></i><span
                                                                        class="text"> <?= lang('product_expiry_alerts'); ?></span>
                                                                </a>
                                                            </li>
    <?php } ?>
                                                        <li id="reports_products">
                                                            <a href="<?= site_url('reports/products') ?>">
                                                                <i class="fa fa-barcode"></i><span
                                                                    class="text"> <?= lang('products_report'); ?></span>
                                                            </a>
                                                        </li>
                                                         <li id="products_combo_items">
                                                            <a href="<?= site_url('reports/products_combo_items') ?>">
                                                                <i class="fa fa-barcode"></i><span
                                                                    class="text"> <?= lang('Products_Combo_Items'); ?></span> <img src="<?= $assets ?>images/new.gif" height="30px" alt="new" />
                                                            </a>
                                                        </li>
<li id="product_varient_report">
                                                                                                                    <a href="<?= site_url('reports/product_varient_stock_report') ?>">
                                                                                                                        <i class="fa fa-barcode"></i><span
                                                                                                                            class="text"> <?= lang('Product_Varient_Stock_Report'); ?></span> <img src="<?= $assets ?>images/new.gif" height="30px" alt="new" />
                                                                                                                    </a>
                                                                                                                </li>
                                                                                                                                                                        <li id="product_varient_sale_report">
                                                                                                                    <a href="<?= site_url('reports/product_varient_sale_report') ?>">
                                                                                                                        <i class="fa fa-barcode"></i><span
                                                                                                                            class="text"> <?= lang('Product_Varient_Sale_Report'); ?></span> <img src="<?= $assets ?>images/new.gif" height="30px" alt="new" />
                                                                                                                    </a>
                                                                                                                </li>
																												<li id="product_varient_purchase_report">
                                                                                                                    <a href="<?= site_url('reports/product_varient_purchase_report') ?>">
                                                                                                                        <i class="fa fa-barcode"></i><span
                                                                                                                            class="text"> <?= lang('Product_Varient_Purchase_Report'); ?></span> <img src="<?= $assets ?>images/new.gif" height="30px" alt="new" />
                                                                                                                    </a>
                                                                                                                </li>
                                                        <li id="reports_adjustments">
                                                            <a href="<?= site_url('reports/adjustments') ?>">
                                                                <i class="fa fa-filter"></i><span
                                                                    class="text"> <?= lang('adjustments_report'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="reports_categories">
                                                            <a href="<?= site_url('reports/categories') ?>">
                                                                <i class="fa fa-folder-open"></i><span
                                                                    class="text"> <?= lang('categories_report'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="reports_brands">
                                                            <a href="<?= site_url('reports/brands') ?>">
                                                                <i class="fa fa-cubes"></i><span
                                                                    class="text"> <?= lang('brands_report'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="reports_daily_sales">
                                                            <a href="<?= site_url('reports/daily_sales') ?>">
                                                                <i class="fa fa-calendar-check-o"></i><span
                                                                    class="text"> <?= lang('daily_sales'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="reports_monthly_sales">
                                                            <a href="<?= site_url('reports/monthly_sales') ?>">
                                                                <i class="fa fa-calendar"></i><span
                                                                    class="text"> <?= lang('monthly_sales'); ?></span>
                                                            </a>
                                                        </li>
<li id="reports_sales">
                                                            <a href="<?= site_url('reports/sales_person_report') ?>">
                                                                <i class="fa fa-line-chart"></i><span
                                                                    class="text"> <?= lang('Sales_Person_Report'); ?></span> <img src="<?= $assets ?>images/new.gif" height="30px" alt="new" />
                                                            </a>
                                                        </li>
                                                        <li id="reports_sales">
                                                            <a href="<?= site_url('reports/sales') ?>">
                                                                <i class="fa fa-line-chart"></i><span
                                                                    class="text"> <?= lang('sales_report'); ?></span>
                                                            </a>
                                                        </li>
                                                        <!-- -->
                                                        <li id="reports_sales_gst">
                                                            <a href="<?= site_url('reports/sales_gst_report') ?>">
                                                                <i class="fa fa-line-chart"></i><span
                                                                    class="text"> <?= lang('sales_report'); ?> GST </span>
                                                            </a>
                                                        </li>
                                                        <li id="reports_warehouse_sales">
                                                            <a href="<?= site_url('reports/warehouse_sales') ?>">
                                                                <i class="fa fa-line-chart"></i><span class="text"> Warehouse <?= lang('sales_report'); ?> <img src="<?= $assets ?>images/new.gif" height="30px" alt="new" /></span>
                                                            </a>
                                                        </li>
                                                        <li id="reports_payments">
                                                            <a href="<?= site_url('reports/payments') ?>">
                                                                <i class="fa fa-credit-card"></i><span
                                                                    class="text"> <?= lang('payments_report'); ?></span>
                                                            </a>
                                                        </li>
  
                                                       <li id="reports_payments_summary">
                                                            <a href="<?= site_url('reports/paymentssummary') ?>">
                                                                <i class="fa fa-credit-card"></i><span
                                                                    class="text"> <?= lang('Payments Summary'); ?></span>
                                                            </a>
                                                        </li>


                                                        <li id="reports_profit_loss">
                                                            <a href="<?= site_url('reports/profit_loss') ?>">
                                                                <i class="fa fa-money"></i><span
                                                                    class="text"> Profit & Loss</span>
                                                            </a>
                                                        </li>
                                                        <li id="reports_daily_purchases">
                                                            <a href="<?= site_url('reports/daily_purchases') ?>">
                                                                <i class="fa fa-cart-plus"></i><span
                                                                    class="text"> <?= lang('daily_purchases'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="reports_monthly_purchases">
                                                            <a href="<?= site_url('reports/monthly_purchases') ?>">
                                                                <i class="fa fa-calendar"></i><span
                                                                    class="text"> <?= lang('monthly_purchases'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="reports_purchases">
                                                            <a href="<?= site_url('reports/purchases') ?>">
                                                                <i class="fa fa-file-text"></i><span
                                                                    class="text"> <?= lang('purchases_report'); ?></span>
                                                            </a>
                                                        </li>

                                                        <li id="reports_purchases_gst">
                                                            <a href="<?= site_url('reports/purchases_gst_report') ?>">
                                                                <i class="fa fa-line-chart"></i><span
                                                                    class="text"> <?= lang('purchases_report'); ?>
                                                                    GST </span>
                                                            </a>
                                                        </li>

                                                        <li id="reports_expenses">
                                                            <a href="<?= site_url('reports/expenses') ?>">
                                                                <i class="fa fa-star"></i><span
                                                                    class="text"> <?= lang('expenses_report'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="reports_customer_report">
                                                            <a href="<?= site_url('reports/customers') ?>">
                                                                <i class="fa fa-users"></i><span
                                                                    class="text"> <?= lang('customers_report'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="reports_supplier_report">
                                                            <a href="<?= site_url('reports/suppliers') ?>">
                                                                <i class="fa fa-truck"></i><span
                                                                    class="text"> <?= lang('suppliers_report'); ?></span>
                                                            </a>
                                                        </li>
                                                        <li id="reports_staff_report">
                                                            <a href="<?= site_url('reports/users') ?>">
                                                                <i class="fa fa-user" aria-hidden="true"></i><span
                                                                    class="text"> <?= lang('staff_report'); ?></span>
                                                            </a>
                                                        </li>
                                                    </ul>
                                                </li>

                                                <?php
                                            } else { // not owner and not admin
                                                ?>


                                                <?php if ($GP['products-index'] || $GP['products-add'] || $GP['products-barcode'] || $GP['products-adjustments'] || $GP['products-stock_count'] || $GP['products-import'] ) { ?>
                                                    <li class="mm_products">
                                                        <a class="dropmenu" href="#">
                                                            <i class="fa fa-barcode"></i>
                                                            <span class="text"> <?= lang('products'); ?>
                                                            </span> <span class="chevron closed"></span>
                                                        </a>
                                                        <ul>
                                                            <li id="products_index">
                                                                <a class="submenu" href="<?= site_url('products'); ?>">
                                                                    <i class="fa fa-barcode"></i><span
                                                                        class="text"> <?= lang('list_products'); ?></span>
                                                                </a>
                                                            </li>
                                                            <?php if ($GP['products-add']) { ?>
                                                                <li id="products_add">
                                                                    <a class="submenu" href="<?= site_url('products/add'); ?>">
                                                                        <i class="fa fa-plus-circle"></i><span
                                                                            class="text"> <?= lang('add_product'); ?></span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if ($GP['products-barcode']) { ?>
                                                                <li id="products_sheet">
                                                                    <a class="submenu"
                                                                       href="<?= site_url('products/print_barcodes'); ?>">
                                                                        <i class="fa fa-tags"></i><span
                                                                            class="text"> <?= lang('print_barcode_label'); ?></span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            
                                                             <?php if ($GP['products-import']) { ?>    
                                                                <li id="products_import_csv">
                                                                    <a class="submenu" href="<?= site_url('products/import_csv'); ?>">
                                                                        <i class="fa fa-file-text"></i>
                                                                        <span class="text"> <?= lang('import_products'); ?></span>
                                                                    </a>
                                                                </li>
                                                             <?php } ?>  
                                                            
                                                            <?php if ($GP['products-adjustments']) { ?>
                                                                <li id="products_quantity_adjustments">
                                                                    <a class="submenu"
                                                                       href="<?= site_url('products/quantity_adjustments'); ?>">
                                                                        <i class="fa fa-filter"></i><span
                                                                            class="text"> <?= lang('quantity_adjustments'); ?></span>
                                                                    </a>
                                                                </li>
                                                                <li id="products_add_adjustment">
                                                                    <a class="submenu"
                                                                       href="<?= site_url('products/add_adjustment'); ?>">
                                                                        <i class="fa fa-filter"></i>
                                                                        <span class="text"> <?= lang('add_adjustment'); ?></span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                            <?php if ($GP['products-stock_count']) { ?>
                                                                <li id="products_stock_counts">
                                                                    <a class="submenu"
                                                                       href="<?= site_url('products/stock_counts'); ?>">
                                                                        <i class="fa fa-list-ol"></i>
                                                                        <span class="text"> <?= lang('stock_counts'); ?></span>
                                                                    </a>
                                                                </li>
                                                                <li id="products_count_stock">
                                                                    <a class="submenu"
                                                                       href="<?= site_url('products/count_stock'); ?>">
                                                                        <i class="fa fa-plus-circle"></i>
                                                                        <span class="text"> <?= lang('count_stock'); ?></span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
                                                        </ul>
                                                    </li>
                                                <?php } ?>

                                                <?php if ($GP['sales-index'] || $GP['sales-add'] || $GP['sales-deliveries'] || $GP['sales-gift_cards'] || $GP['eshop_sales-sales'] || $GP['offline-sales']) { ?>
                                                    <li class="mm_sales <?= strtolower($this->router->fetch_method()) == 'settings' ? '' : 'mm_pos' ?>">
                                                        <a class="dropmenu" href="#">
                                                            <i class="fa fa-heart"></i>
                                                            <span class="text"> <?= lang('sales'); ?>
                                                            </span> <span class="chevron closed"></span>
                                                        </a>
                                                        <ul>
														<?php if ($GP['sales-index']) { ?>
                                                            <li id="sales_index">
                                                                <a class="submenu" href="<?= site_url('sales'); ?>">
                                                                    <i class="fa fa-heart"></i><span
                                                                        class="text"> <?= lang('list_sales'); ?></span>
                                                                </a>
                                                            </li>
															<?php } ?>
                                                            <?php if (POS && $GP['pos-index']) { ?>
                                                                <li id="pos_sales">
                                                                    <a class="submenu" href="<?= site_url('pos/sales'); ?>">
                                                                        <i class="fa fa-heart"></i><span
                                                                            class="text"> <?= lang('pos_sales'); ?></span>
                                                                    </a>
                                                                </li>
                                                            <?php } ?>
															<?php if ($GP['eshop_sales-sales']) { ?>
															 <li id="eshop_sales">
                                                            <a class="submenu" href="<?= site_url('eshop_sales/sales'); ?>">
                                                                <i class="fa fa-heart"></i>
                                                                <span class="text"> Eshop Sales</span>
                                                            </a>
                                                        </li>
														<?php } ?>
														<?php if ($GP['offline-sales']) { ?>
                                                        <li id="offline_sales">
                                                            <a class="submenu" href="<?= site_url('offline/sales'); ?>">
                                                                <i class="fa fa-heart"></i>
                                                                <span class="text">  Offline Sales</span>
                                                            </a>
                                                        </li>
														<?php } ?> 

                                                          <?php if ($Settings->pos_type == 'restaurant') { ?>
                                                           <?php if ($GP['urbanpiper_sales']) { ?>
                                                            <li class="urbanpiper_sales"> 
                                                                <a class="submenu" href="<?= site_url('urban_piper/sales'); ?>">
                                                                    <i class="fa fa-plus-circle"></i>
                                                                    <span class="text"> <?= lang('Urban Piper Sales'); ?></span>
                                                                </a>
                                                            </li>  
                                                           <?php } ?>
                                                        <?php } ?> 
                                                        
                                                            <?php if ($GP['sales-add']) { ?>
                                                                <li id="sales_add">
                                                                    <a class="submenu" href="<?= site_url('sales/add'); ?>">
                                                                        <i class="fa fa-plus-circle"></i><span
                                                                            class="text"> <?= lang('add_sale'); ?></span>
                                                                    </a>
                                                                </li>
                                                            <?php
                                                            }
                                                            if ($GP['sales-deliveries']) {
                                                                ?>
                                                                <li id="sales_deliveries">
                                                                    <a class="submenu" href="<?= site_url('sales/deliveries'); ?>">
                                                                        <i class="fa fa-truck"></i><span
                                                                            class="text"> <?= lang('deliveries'); ?></span>
                                                                    </a>
                                                                </li>
                                                            <?php
                                                            }
                                                            if ($GP['sales-gift_cards']) {
                                                                ?>
                                                                <li id="sales_gift_cards">
                                                                    <a class="submenu" href="<?= site_url('sales/gift_cards'); ?>">
                                                                        <i class="fa fa-gift"></i><span
                                                                            class="text"> <?= lang('gift_cards'); ?></span>
                                                                    </a>
                                                                </li>
        <?php } if ($GP['sales_add_csv']) { ?>

                                                                <li id="sales_sale_by_csv">
                                                                    <a class="submenu" href="<?= site_url('sales/sale_by_csv'); ?>">
                                                                        <i class="fa fa-plus-circle"></i>
                                                                        <span class="text"> <?= lang('add_sale_by_csv'); ?></span>
                                                                    </a>
                                                                </li>   
        <?php } if ($GP['all_sale_lists']) { ?>
                                                                <li id="all_sale_lists">
                                                                    <a class="submenu" href="<?= site_url('sales/all_sale_lists'); ?>">
                                                                        <i class="fa fa-plus-circle"></i>
                                                                        <span class="text"> <?= lang('All_Sale_List'); ?> <img src="<?= site_url('themes/default/assets/images/new.gif') ?>" height="30px" alt="new"></span>
                                                                    </a>
                                                                </li>
                                                    <?php } ?>
                                                        </ul>
                                                    </li>
                                                <?php
                                                } ?>
                                                 
                                             <?php if ($Settings->pos_type == 'restaurant') { ?>
                                                 
                                                        <!--  Urbanpiper -->
                                                        <li class="mm_urban_piper" >
                                                            <a class="dropmenu" href="#">
                                                                <i class="fa fa-magnet"></i>
                                                                <span class="text"> <?= lang('Urbanpiper'); ?> <img src="<?= site_url('themes/default/assets/images/new.gif') ?>" height="30px" alt="new"></span>
                                                                <span class="chevron closed"></span>
                                                            </a>
                                                            <ul> 
                                                                 <?php if ($GP['urbanpiper_settings']) { ?>
                                                                 <li id="urban_piper_settings">
                                                                    <a href="<?= site_url('urban_piper/settings') ?>">
                                                                        <i class="fa fa-cogs" aria-hidden="true"></i>
                                                                        <span  class="text" > Urbanpiper Settings </span>   
                                                                    </a>
                                                                </li>
                                                                <?php } ?>
                                                                <?php if ($GP['urbanpiper_maange_stores']) { ?>
                                                                    <li id="urban_piper_store_info">
                                                                        <a href="<?= site_url('urban_piper/store_info') ?>">
                                                                            <i class="fa fa-list" aria-hidden="true"></i>
                                                                            <span  class="text" > Manage Stores </span>
                                                                        </a>    
                                                                    </li>
                                                                <?php } ?>
                                                                <?php if ($GP['urbanpiper_maange_catalogue']) { ?>
                                                                    <li id="urban_piper_product_platform">
                                                                        <a href="<?= site_url('urban_piper/product_platform') ?>">
                                                                            <i class="fa fa-archive" aria-hidden="true"></i>
                                                                            <span  class="text" > Manage Catalogue </span>
                                                                        </a> 

                                                                    </li>
                                                                <?php } ?>
                                                                <?php if ($GP['urbanpiper_maange_order']) { ?>
                                                                   <li id="urban_piper_index">
                                                                      <a href="<?= site_url('urban_piper') ?>">
                                                                        <i class="fa fa-list" aria-hidden="true"></i>
                                                                        <span  class="text" > Manage Orders </span>
                                                                      </a>    
                                                                    </li>
                                                                 <?php } ?>
                                                            </ul>
                                                        </li> 
                                                        <!-- Urbanpiper -->
                                                      
                                                    <?php }//end if ?>

                                                <?php if ($GP['crm_portal']) {
                                                    ?>
                                                    <li class="">
                                                        <a class="submenu" href="<?= site_url('smsdashboard'); ?>">
                                                            <i class="fa fa-envelope"></i><span
                                                                class="text"> <?= lang('CRM Portal'); ?></span>
                                                        </a>
                                                    </li>
    <?php } if ($GP['quotes-index'] || $GP['quotes-add']) { ?>
                                                    <li class="mm_quotes">
                                                        <a class="dropmenu" href="#">
                                                            <i class="fa fa-heart-o"></i>
                                                            <span class="text"> <?= lang('quotes'); ?> </span>
                                                            <span class="chevron closed"></span>
                                                        </a>
                                                        <ul>
                                                            <li id="sales_index">
                                                                <a class="submenu" href="<?= site_url('quotes'); ?>">
                                                                    <i class="fa fa-heart-o"></i><span
                                                                        class="text"> <?= lang('list_quotes'); ?></span>
                                                                </a>
                                                            </li>
        <?php if ($GP['quotes-add']) { ?>
                                                                <li id="sales_add">
                                                                    <a class="submenu" href="<?= site_url('quotes/add'); ?>">
                                                                        <i class="fa fa-plus-circle"></i><span
                                                                            class="text"> <?= lang('add_quote'); ?></span>
                                                                    </a>
                                                                </li>
                                                    <?php } ?>
                                                        </ul>
                                                    </li>
    <?php } ?>

    <?php if ($GP['purchases-index'] || $GP['purchases-add'] || $GP['purchases-expenses']) { ?>
                                                    <li class="mm_purchases">
                                                        <a class="dropmenu" href="#">
                                                            <i class="fa fa-star"></i>
                                                            <span class="text"> <?= lang('purchases'); ?>
                                                            </span> <span class="chevron closed"></span>
                                                        </a>
                                                        <ul>
                                                            <li id="purchases_index">
                                                                <a class="submenu" href="<?= site_url('purchases'); ?>">
                                                                    <i class="fa fa-star"></i><span
                                                                        class="text"> <?= lang('list_purchases'); ?></span>
                                                                </a>
                                                            </li>


        <?php if ($GP['purchases-add']) { ?>
                                                                <li id="purchases_add">
                                                                    <a class="submenu" href="<?= site_url('purchases/add'); ?>">
                                                                        <i class="fa fa-plus-circle"></i><span
                                                                            class="text"> <?= lang('add_purchase'); ?></span>
                                                                    </a>
                                                                </li>
        <?php } ?>
        <?php if ($GP['purchases-expenses']) { ?>
                                                                <li id="purchases_expenses">
                                                                    <a class="submenu"
                                                                       href="<?= site_url('purchases/expenses'); ?>">
                                                                        <i class="fa fa-dollar"></i><span
                                                                            class="text"> <?= lang('list_expenses'); ?></span>
                                                                    </a>
                                                                </li>
                                                                <li id="purchases_add_expense">
                                                                    <a class="submenu"
                                                                       href="<?= site_url('purchases/add_expense'); ?>"
                                                                       data-toggle="modal" data-target="#myModal">
                                                                        <i class="fa fa-plus-circle"></i><span
                                                                            class="text"> <?= lang('add_expense'); ?></span>
                                                                    </a>
                                                                </li>
        <?php } if ($GP['purchase_add_csv']) { ?>

                                                                <li id="purchases_purchase_by_csv">
                                                                    <a class="submenu"
                                                                       href="<?= site_url('purchases/purchase_by_csv'); ?>">
                                                                        <i class="fa fa-plus-circle"></i>
                                                                        <span class="text"> <?= lang('add_purchase_by_csv'); ?></span>
                                                                    </a>
                                                                </li>  
                                                    <?php } ?>
                                                        </ul>
                                                    </li>
    <?php } ?>

    <?php if ($GP['transfers-index'] || $GP['transfers-add']) { ?>
                                                    <li class="mm_transfers">
                                                        <a class="dropmenu" href="#">
                                                            <i class="fa fa-star-o"></i>
                                                            <span class="text"> <?= lang('transfers'); ?> </span>
                                                            <span class="chevron closed"></span>
                                                        </a>
                                                        <ul>
                                                            <li id="transfers_index">
                                                                <a class="submenu" href="<?= site_url('transfers'); ?>">
                                                                    <i class="fa fa-star-o"></i><span
                                                                        class="text"> <?= lang('list_transfers'); ?></span>
                                                                </a>
                                                            </li>
        <?php if ($GP['transfers-add']) { ?>
                                                                <li id="transfers_add">
                                                                    <a class="submenu" href="<?= site_url('transfers/add'); ?>">
                                                                        <i class="fa fa-plus-circle"></i><span
                                                                            class="text"> <?= lang('add_transfer'); ?></span>
                                                                    </a>
                                                                </li>
        <?php } if ($GP['transfers_add_csv']) { ?>

                                                                <li id="transfers_purchase_by_csv">
                                                                    <a class="submenu"
                                                                       href="<?= site_url('transfers/transfer_by_csv'); ?>">
                                                                        <i class="fa fa-plus-circle"></i><span
                                                                            class="text"> <?= lang('add_transfer_by_csv'); ?></span>
                                                                    </a>
                                                                </li>   
        <?php } if ($GP['transfers_add_request']) { ?>
                                                                <li id="transfers_purchase_by_csv">
                                                                    <a class="submenu"
                                                                       href="<?= site_url('transfers/request'); ?>">
                                                                        <i class="fa fa-plus-circle"></i><span
                                                                            class="text"> <?= lang('Add Products Request'); ?></span>
                                                                    </a>
                                                                </li>
                                                    <?php } ?> 
                                                        </ul>
                                                    </li>
    <?php } ?>

    <?php if ($GP['customers-index'] || $GP['customers-add'] || $GP['suppliers-index'] || $GP['suppliers-add']) { ?>
                                                    <li class="mm_auth mm_customers mm_suppliers mm_billers">
                                                        <a class="dropmenu" href="#">
                                                            <i class="fa fa-users"></i>
                                                            <span class="text"> <?= lang('people'); ?> </span>
                                                            <span class="chevron closed"></span>
                                                        </a>
                                                        <ul>
        <?php if ($GP['customers-index']) { ?>
                                                                <li id="customers_index">
                                                                    <a class="submenu" href="<?= site_url('customers'); ?>">
                                                                        <i class="fa fa-users"></i><span class="text"> <?= lang('list_customers'); ?></span>
                                                                    </a>
                                                                </li>
        <?php
        }
        if ($GP['customers-add']) {
            ?>
                                                                <li id="customers_index">
                                                                    <a class="submenu" href="<?= site_url('customers/add'); ?>"
                                                                       data-toggle="modal" data-target="#myModal">
                                                                        <i class="fa fa-plus-circle"></i><span
                                                                            class="text"> <?= lang('add_customer'); ?></span>
                                                                    </a>
                                                                </li>
        <?php
        }
        if ($GP['suppliers-index']) {
            ?>
                                                                <li id="suppliers_index">
                                                                    <a class="submenu" href="<?= site_url('suppliers'); ?>">
                                                                        <i class="fa fa-users"></i><span
                                                                            class="text"> <?= lang('list_suppliers'); ?></span>
                                                                    </a>
                                                                </li>
        <?php
        }
        if ($GP['suppliers-add']) {
            ?>
                                                                <li id="suppliers_index">
                                                                    <a class="submenu" href="<?= site_url('suppliers/add'); ?>"
                                                                       data-toggle="modal" data-target="#myModal">
                                                                        <i class="fa fa-plus-circle"></i><span
                                                                            class="text"> <?= lang('add_supplier'); ?></span>
                                                                    </a>
                                                                </li>
        <?php } ?>
                                                        </ul>
                                                    </li>
    <?php } ?>

    <?php if ($GP['reports-quantity_alerts'] || $GP['reports-expiry_alerts'] || $GP['reports-products'] || $GP['reports-monthly_sales'] || $GP['reports-sales'] || $GP['reports-payments'] || $GP['reports-purchases'] || $GP['reports-customers'] || $GP['reports-suppliers'] || $GP['reports-expenses'] || $GP['reports-warehouse_sales_report']) { ?>
                                                    <li class="mm_reports">
                                                        <a class="dropmenu" href="#">
                                                            <i class="fa fa-bar-chart-o"></i>
                                                            <span class="text"> <?= lang('reports'); ?> </span>
                                                            <span class="chevron closed"></span>
                                                        </a>
                                                        <ul>
                                                            <?php if ($GP['reports-quantity_alerts']) { ?>
                                                                <li id="reports_quantity_alerts">
                                                                    <a href="<?= site_url('reports/quantity_alerts') ?>">
                                                                        <i class="fa fa-sort-amount-desc"></i><span
                                                                            class="text"> <?= lang('product_quantity_alerts'); ?></span>
                                                                    </a>
                                                                </li>
        <?php
        }
        if ($GP['reports-expiry_alerts']) {
            ?>
                                                                <?php if ($Settings->product_expiry) { ?>
                                                                    <li id="reports_expiry_alerts">
                                                                        <a href="<?= site_url('reports/expiry_alerts') ?>">
                                                                            <i class="fa fa-bar-chart-o"></i><span class="text"> <?= lang('product_expiry_alerts'); ?></span>
                                                                        </a>
                                                                    </li>
            <?php } ?>
        <?php
        }
        if ($GP['reports-products']) {
            ?>
                                                                <li id="reports_products">
                                                                    <a href="<?= site_url('reports/products') ?>">
                                                                        <i class="fa fa-filter"></i><span
                                                                            class="text"> <?= lang('products_report'); ?></span>
                                                                    </a>
                                                                </li>
                                                                <li id="reports_adjustments">
                                                                    <a href="<?= site_url('reports/adjustments') ?>">
                                                                        <i class="fa fa-barcode"></i><span
                                                                            class="text"> <?= lang('adjustments_report'); ?></span>
                                                                    </a>
                                                                </li>
                                                                <li id="reports_categories">
                                                                    <a href="<?= site_url('reports/categories') ?>">
                                                                        <i class="fa fa-folder-open"></i><span
                                                                            class="text"> <?= lang('categories_report'); ?></span>
                                                                    </a>
                                                                </li>
                                                                <li id="reports_brands">
                                                                    <a href="<?= site_url('reports/brands') ?>">
                                                                        <i class="fa fa-cubes"></i><span
                                                                            class="text"> <?= lang('brands_report'); ?></span>
                                                                    </a>
                                                                </li>
                                                            <?php
                                                            }
                                                            if ($GP['reports-daily_sales']) {
                                                                ?>
                                                                <li id="reports_daily_sales">
                                                                    <a href="<?= site_url('reports/daily_sales') ?>">
                                                                        <i class="fa fa-calendar-o"></i><span class="text"> <?= lang('daily_sales'); ?></span>
                                                                    </a>
                                                                </li>
                                                            <?php
                                                            }
                                                            if ($GP['reports-monthly_sales']) {
                                                                ?>
                                                                <li id="reports_monthly_sales">
                                                                    <a href="<?= site_url('reports/monthly_sales') ?>">
                                                                        <i class="fa fa-calendar-o"></i><span
                                                                            class="text"> <?= lang('monthly_sales'); ?></span>
                                                                    </a>
                                                                </li>
        <?php } ?>                                                  
        <?php
        if ($GP['reports-sales']) {
            ?>
                                                                <li id="reports_sales">
                                                                    <a href="<?= site_url('reports/sales') ?>">
                                                                        <i class="fa fa-line-chart"></i><span
                                                                            class="text"> <?= lang('sales_report'); ?></span>
                                                                    </a>
                                                                </li>
                                                                <li id="reports_sales_gst">
                                                                    <a href="<?= site_url('reports/sales_gst_report') ?>">
                                                                        <i class="fa fa-line-chart"></i><span class="text"> <?= lang('sales_report'); ?>
                                                                            GST </span>
                                                                    </a>
                                                                </li>
            <?php if ($GP['reports-warehouse_sales_report']) { ?>
                                                                    <li id="reports_warehouse_sales">
                                                                        <a href="<?= site_url('reports/warehouse_sales') ?>">
                                                                            <i class="fa fa-line-chart"></i><span class="text"> Compare Warehouse <?= lang('sales_report'); ?></span>
                                                                        </a>
                                                                    </li>
                                                                <?php } ?>
                                                            <?php
                                                            }
                                                            if ($GP['reports-payments']) {
                                                                ?>
                                                                <li id="reports_payments">
                                                                    <a href="<?= site_url('reports/payments') ?>">
                                                                        <i class="fa fa-money"></i><span
                                                                            class="text"> <?= lang('payments_report'); ?></span>
                                                                    </a>
                                                                </li>
                                                            <?php
                                                            }
                                                            if ($GP['reports-daily_purchases']) {
                                                                ?>
                                                                <li id="reports_daily_purchases">
                                                                    <a href="<?= site_url('reports/daily_purchases') ?>">
                                                                        <i class="fa fa-calendar-check-o"></i><span
                                                                            class="text"> <?= lang('daily_purchases'); ?></span>
                                                                    </a>
                                                                </li>
        <?php
        }
        if ($GP['reports-monthly_purchases']) {
            ?>
                                                                <li id="reports_monthly_purchases">
                                                                    <a href="<?= site_url('reports/monthly_purchases') ?>">
                                                                        <i class="fa fa-calendar"></i><span
                                                                            class="text"> <?= lang('monthly_purchases'); ?></span>
                                                                    </a>
                                                                </li>
        <?php
        }
        if ($GP['reports-purchases']) {
            ?>
                                                                <li id="reports_purchases">
                                                                    <a href="<?= site_url('reports/purchases') ?>">
                                                                        <i class="fa fa-cart-plus"></i><span
                                                                            class="text"> <?= lang('purchases_report'); ?></span>
                                                                    </a>
                                                                </li>
                                                            <?php
                                                            }
                                                            if ($GP['report_purchase_gst']) {
                                                                ?>

                                                                <li id="reports_purchases_gst">
                                                                    <a href="<?= site_url('reports/purchases_gst_report') ?>">
                                                                        <i class="fa fa-line-chart"></i><span
                                                                            class="text"> <?= lang('purchases_report'); ?>
                                                                            GST </span>
                                                                    </a>
                                                                </li>

        <?php
        }
        if ($GP['reports-expenses']) {
            ?>
                                                                <li id="reports_expenses">
                                                                    <a href="<?= site_url('reports/expenses') ?>">
                                                                        <i class="fa fa-star"></i><span
                                                                            class="text"> <?= lang('expenses_report'); ?></span>
                                                                    </a>
                                                                </li>
        <?php
        }
        if ($GP['reports-customers'] || TRUE) {
            ?>
                                                                <li id="reports_customer_report">
                                                                    <a href="<?= site_url('reports/customers') ?>">
                                                                        <i class="fa fa-users"></i><span
                                                                            class="text"> <?= lang('customers_report'); ?></span>
                                                                    </a>
                                                                </li>
<li id="product_varient_report">
                                                                                                                    <a href="<?= site_url('reports/product_varient_stock_report') ?>">
                                                                                                                        <i class="fa fa-barcode"></i><span
                                                                                                                            class="text"> <?= lang('Product_Varient_Stock_Report'); ?></span> <img src="<?= $assets ?>images/new.gif" height="30px" alt="new" />
                                                                                                                    </a>
                                                                                                                </li>
                                                                                                                                                                        <li id="product_varient_sale_report">
                                                                                                                    <a href="<?= site_url('reports/product_varient_sale_report') ?>">
                                                                                                                        <i class="fa fa-barcode"></i><span
                                                                                                                            class="text"> <?= lang('Product_Varient_Sale_Report'); ?></span> <img src="<?= $assets ?>images/new.gif" height="30px" alt="new" />
                                                                                                                    </a>
                                                                                                                </li>
																												<li id="product_varient_purchase_report">
                                                                                                                    <a href="<?= site_url('reports/product_varient_purchase_report') ?>">
                                                                                                                        <i class="fa fa-barcode"></i><span
                                                                                                                            class="text"> <?= lang('Product_Varient_Purchase_Report'); ?></span> <img src="<?= $assets ?>images/new.gif" height="30px" alt="new" />
                                                                                                                    </a>
                                                                                                                </li>
        <?php
        }
        if ($GP['reports-suppliers']) {
            ?>
                                                                <li id="reports_supplier_report">
                                                                    <a href="<?= site_url('reports/suppliers') ?>">
                                                                        <i class="fa fa-truck"></i><span
                                                                            class="text"> <?= lang('suppliers_report'); ?></span>
                                                                    </a>
                                                                </li>
        <?php } ?>
                                                        </ul>
                                                    </li>
    <?php } ?>
    <?php
    if ($GP['printer-setting']) {
        ?>
                                                    <li id="printers">
                                                        <a href="<?= site_url('system_settings/printers'); ?>">
                                                            <i class="fa fa-print"></i>
                                                            <span class="text">  Manage Printers Option</span>
                                                        </a>
                                                    </li>
                                                    <?php } ?>
                                                <?php } ?>
                                        </ul>
                                    </div>
                                    <a href="#" id="main-menu-act" class="full visible-md visible-lg">
                                        <i class="fa fa-angle-double-left"></i>
                                    </a>
                                </div>
                            </td>
                            <td class="content-con">
                                <div id="content">
                                    <div class="row">
                                        <div class="col-sm-12 col-md-12">
                                            <ul class="breadcrumb">
<?php
foreach ($bc as $b) {
    if ($b['link'] === '#') {
        echo '<li class="active">' . $b['page'] . '</li>';
    } else {
        echo '<li><a href="' . $b['link'] . '">' . $b['page'] . '</a></li>';
    }
}
?>
                                                <li class="right_log hidden-xs">
                                                <?= lang('your_ip') . ' ' . $ip_address . " <span class='hidden-sm'>( " . lang('last_login_at') . ": " . date($dateFormats['php_ldate'], $this->session->userdata('old_last_login')) . " " . ($this->session->userdata('last_ip') != $ip_address ? lang('ip:') . ' ' . $this->session->userdata('last_ip') : '') . " )</span>" ?>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12">
                                                <?php if ($message) { ?>
                                                <div class="alert alert-success" id="errs">
                                                    <button data-dismiss="alert" class="close" type="button">×</button>
                                                <?= $message; ?>
                                                </div>
                                            <?php } ?>
                                            <?php if ($error) { ?>
                                                <div class="alert alert-danger" >
                                                    <button data-dismiss="alert" class="close" type="button">×</button>
                                                <?= $error; ?>
                                                </div>
                                            <?php } ?>
<?php if ($warning) { ?>
                                                <div class="alert alert-warning">
                                                    <button data-dismiss="alert" class="close" type="button">×</button>
                                                       <?= $warning; ?>
                                                </div>
                                            <?php } ?>
                                            <?php
                                            if ($info) {

                                                foreach ($info as $n) {
                                                    if (!$this->session->userdata('hidden' . $n->id)) {
                                                        ?>
                                                        <div class="alert alert-info" style="display:block;">
                                                            <a href="#" id="<?= $n->id ?>" class="close hideComment external"
                                                               data-dismiss="alert">&times;</a>
            <?= $n->comment; ?>
                                                        </div>
        <?php
        }
    }
}
?>
                                            <div class="alerts-con" id="err"></div>

