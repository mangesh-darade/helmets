<?php
defined('BASEPATH') or exit('No direct script access allowed');
$is_pharma = isset($Settings->pos_type) && $Settings->pos_type == 'pharma' ? true : false;
$disblePage = $enablePage = "hidden";
if (isset($featuerd_products) && $featuerd_products == 1) {
    $pos_settings->default_category = null;
    $disblePage = "";
} else {
    $enablePage = "";
}

$permisions = array();
if (is_array($GP)) {
    foreach ($GP as $key => $val) {
        $permisions[str_replace("-", "_", $key)] = $val;
    }
}
//print_r($pos_settings->pos_theme);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=lang('pos_module') . " | " . $Settings->site_name;?></title>
    <script type="text/javascript">if(parent.frames.length !== 0){top.location = '<?=site_url('pos')?>';} var permisions = JSON.parse('<?php echo json_encode($permisions); ?>');</script>
    <base href="<?=base_url()?>"/>
    <meta http-equiv="cache-control" content="max-age=0" />
    <meta http-equiv="cache-control" content="no-cache"  />
    <meta http-equiv="expires" content="0"/>
    <meta http-equiv="pragma" content="no-cache"/>
    <link rel="shortcut icon" href="<?=$assets?>images/icon.png"/>
    <link rel="stylesheet" href="<?=$assets?>styles/theme.css" type="text/css"/>
    <link rel="stylesheet" href="<?=$assets?>styles/style.css" type="text/css"/>
    <link rel="stylesheet" href="<?=$assets?>pos/css/posajax.css" type="text/css"/>
    <link rel="stylesheet" href="<?=$assets?>pos/css/print.css" type="text/css" media="print"/>
    <script type="text/javascript" src="<?=$assets?>js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="<?=$assets?>js/jquery-migrate-1.2.1.min.js"></script>
    <!--[if lt IE 9]>
    <script src="<?=$assets?>js/jquery.js"></script>
    <![endif]-->
    <?php if ($Settings->user_rtl) {?>
        <link href="<?=$assets?>styles/helpers/bootstrap-rtl.min.css" rel="stylesheet"/>
        <link href="<?=$assets?>styles/style-rtl.css" rel="stylesheet"/>

    <?php }
?>
        <style>
            #paymentModal #s2id_paid_by_1,#paymentModal #s2id_paid_by_1 a{  pointer-events:none !important;  cursor: none !important;  }
            .notification_counter{color: #ff0000;font-weight: bold;border: 1px solid;padding: 2px 4px;margin: 5px;border-radius: 12%}
            #posbiller{display:block !important;}
.btn-prni{
            background:<?php echo (!empty($pos_settings->pos_theme->css_class_product->background_color)) ? $pos_settings->pos_theme->css_class_product->background_color : '#fff'; ?>
            }

        </style>
<?php // print_r($Settings->pos_theme); ?>

        <!-- Source: https://www.jssor.com -->
    <script src="<?=$assets?>js/jssor.slider-27.1.0.min.js" type="text/javascript"></script>
    <script type="text/javascript">
        jssor_1_slider_init = function() {

            var jssor_1_options = {
              $AutoPlay: 1,
              $Idle: 4000,
              $SlideEasing: $Jease$.$InOutSine,
              $DragOrientation: 3,
              $ArrowNavigatorOptions: {
                $Class: $JssorArrowNavigator$
              },
              $BulletNavigatorOptions: {
                $Class: $JssorBulletNavigator$
              }
            };

            var jssor_1_slider = new $JssorSlider$("jssor_1", jssor_1_options);

            //make sure to clear margin of the slider container element
            jssor_1_slider.$Elmt.style.margin = "";

            /*#region responsive code begin*/

            /*
                parameters to scale jssor slider to fill parent container

                MAX_WIDTH
                    prevent slider from scaling too wide
                MAX_HEIGHT
                    prevent slider from scaling too high, default value is original height
                MAX_BLEEDING
                    prevent slider from bleeding outside too much, default value is 1
                    0: contain mode, allow up to 0% to bleed outside, the slider will be all inside parent container
                    1: cover mode, allow up to 100% to bleed outside, the slider will cover full area of parent container
                    0.1: flex mode, allow up to 10% to bleed outside, this is better way to make full window slider, especially for mobile devices
            */

            var MAX_WIDTH = 3000;
            var MAX_HEIGHT = 3000;
            var MAX_BLEEDING = 1;

            function ScaleSlider() {
                var containerElement = jssor_1_slider.$Elmt.parentNode;
                var containerWidth = containerElement.clientWidth;

                if (containerWidth) {
                    var originalWidth = jssor_1_slider.$OriginalWidth();
                    var originalHeight = jssor_1_slider.$OriginalHeight();

                    var containerHeight = containerElement.clientHeight || originalHeight;

                    var expectedWidth = Math.min(MAX_WIDTH || containerWidth, containerWidth);
                    var expectedHeight = Math.min(MAX_HEIGHT || containerHeight, containerHeight);

                    //scale the slider to expected size
                    jssor_1_slider.$ScaleSize(expectedWidth, expectedHeight, MAX_BLEEDING);

                    //position slider at center in vertical orientation
                    jssor_1_slider.$Elmt.style.top = ((containerHeight - expectedHeight) / 2) + "px";

                    //position slider at center in horizontal orientation
                    jssor_1_slider.$Elmt.style.left = ((containerWidth - expectedWidth) / 2) + "px";
                }
                else {
                    window.setTimeout(ScaleSlider, 30);
                }
            }

            ScaleSlider();

            $Jssor$.$AddEvent(window, "load", ScaleSlider);
            $Jssor$.$AddEvent(window, "resize", ScaleSlider);
            $Jssor$.$AddEvent(window, "orientationchange", ScaleSlider);
            /*#endregion responsive code end*/
        };
    </script>
    <style>
        /*jssor slider loading skin spin css*/
        .jssorl-009-spin img {
            animation-name: jssorl-009-spin;
            animation-duration: 1.6s;
            animation-iteration-count: infinite;
            animation-timing-function: linear;
        }

        @keyframes jssorl-009-spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /*jssor slider bullet skin 064 css*/
        .jssorb064 {position:absolute;}
        .jssorb064 .i {position:absolute;cursor:pointer;}
        .jssorb064 .i .b {fill:#000;fill-opacity:.5;stroke:#fff;stroke-width:400;stroke-miterlimit:10;stroke-opacity:0.5;}
        .jssorb064 .i:hover .b {fill-opacity:.8;}
        .jssorb064 .iav .b {fill:#ffe200;fill-opacity:1;stroke:#ffaa00;stroke-opacity:.7;stroke-width:2000;}
        .jssorb064 .iav:hover .b {fill-opacity:.6;}
        .jssorb064 .i.idn {opacity:.3;}

        /*jssor slider arrow skin 051 css*/
        .jssora051 {display:block;position:absolute;cursor:pointer;}
        .jssora051 .a {fill:none;stroke:#fff;stroke-width:360;stroke-miterlimit:10;}
        .jssora051:hover {opacity:.8;}
        .jssora051.jssora051dn {opacity:.5;}
        .jssora051.jssora051ds {opacity:.3;pointer-events:none;}
    </style>
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

<div id="wrapper">

    <div id="content">
        <div class="c1">
            <div class="pos">
                <?php
if ($error) {
    echo "<div class=\"alert alert-danger\"><button type=\"button\" class=\"close fa-2x\" data-dismiss=\"alert\">&times;</button>" . $error . "</div>";
    /*To set error log on cloud*/
    $errorUrl = "http://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI];
    $logger = array($error, $errorUrl);
    $this->sma->pos_error_log($logger);
    /* End To set error log on cloud*/
}
?>
                <?php
if ($message) {
    echo "<div class=\"alert alert-success\"><button type=\"button\" class=\"close fa-2x\" data-dismiss=\"alert\">&times;</button>" . $message . "</div>";
}
?>
                <div id="pos">
                    <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id' => 'pos-sale-form');
echo form_open("pos", $attrib);?>
                    <div id="leftdiv">
                        <div id="printhead">
                            <h4 style="text-transform:uppercase;"><?php echo $Settings->site_name; ?></h4>
                            <?php
echo "<h5 style=\"text-transform:uppercase;\">" . $this->lang->line('order_list') . "</h5>";
echo $this->lang->line("date") . " " . $this->sma->hrld(date('Y-m-d H:i:s'));
?>
                        </div>
                     <!--removed-->
                            <input type="hidden" value="" name="customer1" id="custname" />
                            <input type="hidden" value="" name="cust_search" id="custsearch" />
                        <div id="print">
                            <div id="left-middle">
                                <div id="product-list">
                                    <table class="table items table-striped table-bordered table-condensed table-hover sortable_table"
                                           id="posTable" style="margin-bottom: 0;">
                                        <thead>
                                        <tr>
                                            <th width="40%"><?=lang("product");?></th>
                                            <th width="15%"><?=lang("price");?></th>
                                            <th width="15%"><?=lang("qty");?></th>
                                            <th width="20%"><?=lang("subtotal");?></th>
                                            <th style="width: 5%; text-align: center;">
                                                <i class="fa fa-trash-o" style="opacity:0.5; filter:alpha(opacity=50);"></i>
                                            </th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                    </table>
                                    <div style="clear:both;"></div>
                                </div>
                                <div style="clear:both;"></div>
                            <div id="left-bottom">
                                <table id="totalTable"
                                       style="width:100%; float:right; padding:5px; color:#000; background: #FFF;">
                                    <tr>
                                        <td style="padding: 5px 10px;border-top: 1px solid #DDD;"><?=lang('items');?></td>
                                        <td class="text-right" style="padding: 5px 10px;font-size: 14px; font-weight:bold;border-top: 1px solid #DDD;">
                                            <span id="titems">0</span>
                                        </td>
                                        <td style="padding: 5px 10px;border-top: 1px solid #DDD;"><?=lang('total');?></td>
                                        <td class="text-right" style="padding: 5px 10px;font-size: 14px; font-weight:bold;border-top: 1px solid #DDD;">
                                            <span id="total">0.00</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px 10px;"><?=lang('order_tax');?>
                                            <a href="#" id="pptax2">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                        </td>
                                        <td class="text-right" style="padding: 5px 10px;font-size: 14px; font-weight:bold;">
                                            <span id="ttax2">0.00</span>
                                        </td>
                                        <td style="padding: 5px 10px;"><?=lang('discount');?>
                                            <?php if ($Owner || $Admin || $this->session->userdata('allow_discount')) {?>
                                            <a href="#" id="ppdiscount">
                                                <i class="fa fa-edit"></i>
                                            </a>
                                            <?php }?>
                                        </td>
                                        <td class="text-right" style="padding: 5px 10px;font-weight:bold;">
                                            <span id="tds">0.00</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td style="padding: 5px 10px; border-top: 1px solid #666; border-bottom: 1px solid #333; font-weight:bold; background:#333; color:#FFF;" colspan="2">
                                            <?=lang('total_payable');?>
                                        </td>
                                        <td class="text-right" style="padding:5px 10px 5px 10px; font-size: 14px;border-top: 1px solid #666; border-bottom: 1px solid #333; font-weight:bold; background:#333; color:#FFF;" colspan="2">
                                            <span id="gtotal">0.00</span>
                                        </td>
                                    </tr>
                                </table>

                                <div class="clearfix"></div>
                                <div id="botbuttons" class="col-xs-12 text-center">
                                    <input type="hidden" name="biller" id="biller" value="<?=($Owner || $Admin || !$this->session->userdata('biller_id')) ? $pos_settings->default_biller : $this->session->userdata('biller_id')?>"/>

                                </div>
                                <div style="clear:both; height:5px;"></div>
                                <div id="num">
                                    <div id="icon"></div>
                                </div>
                                <span id="hidesuspend"></span>
                                <input type="hidden" name="pos_note" value="" id="pos_note">
                                <input type="hidden" name="staff_note" value="" id="staff_note">

                                <div id="payment-con">
                                    <?php for ($i = 1; $i <= 5; $i++) {?>
                                        <input type="hidden" name="amount[]" id="amount_val_<?=$i?>" value=""/>
                                        <input type="hidden" name="balance_amount[]" id="balance_amount_<?=$i?>" value=""/>
                                        <input type="hidden" name="paid_by[]" id="paid_by_val_<?=$i?>" value="cash"/>
                                        <input type="hidden" name="cc_no[]" id="cc_no_val_<?=$i?>" value=""/>
                                        <input type="hidden" name="paying_gift_card_no[]" id="paying_gift_card_no_val_<?=$i?>" value=""/>
                                        <input type="hidden" name="cc_holder[]" id="cc_holder_val_<?=$i?>" value=""/>
                                        <input type="hidden" name="cheque_no[]" id="cheque_no_val_<?=$i?>" value=""/>
                                        <input type="hidden" name="other_tran[]" id="other_tran_no_val<?=$i?>" value=""/>
                                        <input type="hidden" name="cc_month[]" id="cc_month_val_<?=$i?>" value=""/>
                                        <input type="hidden" name="cc_year[]" id="cc_year_val_<?=$i?>" value=""/>
                                        <input type="hidden" name="cc_type[]" id="cc_type_val_<?=$i?>" value=""/>
                                        <input type="hidden" name="cc_cvv2[]" id="cc_cvv2_val_<?=$i?>" value=""/>
                                        <input type="hidden" name="payment_note[]" id="payment_note_val_<?=$i?>" value=""/>
                                        <input type="hidden" name="cc_transac_no[]" id="cc_transac_no_val<?=$i?>" value=""/>
                                    <?php }
?>
                                </div>
                                <input name="order_tax" type="hidden" value="<?=$suspend_sale ? $suspend_sale->order_tax_id : $Settings->default_tax_rate2;?>" id="postax2">
                                <input name="discount" type="hidden" value="<?=$suspend_sale ? $suspend_sale->order_discount_id : '';?>" id="posdiscount">
                                <input type="hidden" name="rpaidby" id="rpaidby" value="cash" style="display: none;"/>
                                <input type="hidden" name="total_items" id="total_items" value="0" style="display: none;"/>
                                <input type="submit" id="submit_sale" value="Submit Sale" style="display: none;"/>
                                <input type="hidden" name="paynear_mobile_app" id="paynear_mobile_app" value="" />
                                <input type="hidden" name="paynear_mobile_app_type" id="paynear_mobile_app_type" value="" />
                                  <?php /* ------ For checking Print/notPrint Button updated by SW 21/01/2017 --------------- */?>
                                <input type="hidden" name="submit_type" id="submit_type" value="">
                                 <?php if ($is_pharma): ?>
                                    <input type="hidden" name="patient_name" id="patient_name1" value="">
                                    <input type="hidden" name="doctor_name" id="doctor_name1" value="">
                                <?php endif;?>
                            </div>
                            </div>

                        </div>

                    </div>
                    <?php echo form_close(); ?>
                    <div id="cp">

                          <div style="position:fixed;top:0;left:0;width:100%;height:100%;overflow:hidden;z-index:-1;">
        <div id="jssor_1" style="position:relative;margin:0 auto;top:0px;left:0px;width:960px;height:640px;overflow:hidden;visibility:hidden;">
            <!-- Loading Screen -->
            <div data-u="loading" class="jssorl-009-spin" style="position:absolute;top:0px;left:0px;width:100%;height:100%;text-align:center;background-color:rgba(0,0,0,0.7);">
                <img style="margin-top:-19px;position:relative;top:50%;width:38px;height:38px;" src="img/spin.svg" />
            </div>
            <div data-u="slides" style="cursor:default;position:relative;top:0px;left:0px;width:960px;height:640px;overflow:hidden;">

                <div data-p="200.00">
                    <img data-u="image" src="<?=$assets?>images/FreeGreatPicture.com-24345-hd-women-shopping.jpg" />
                </div>
                <div data-p="200.00">
                    <img data-u="image" src="<?=$assets?>images/slider-holder.jpg" />
                </div>
            </div>
            <!-- Bullet Navigator >
            <div data-u="navigator" class="jssorb064" style="position:absolute;bottom:12px;right:12px;" data-autocenter="1" data-scale="0.5" data-scale-bottom="0.75">
                <div data-u="prototype" class="i" style="width:16px;height:16px;">
                    <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                        <circle class="b" cx="8000" cy="8000" r="5800"></circle>
                    </svg>
                </div>
            </div>
            <!-- Arrow Navigator >
            <div data-u="arrowleft" class="jssora051" style="width:55px;height:55px;top:0px;left:25px;" data-autocenter="2" data-scale="0.75" data-scale-left="0.75">
                <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                    <polyline class="a" points="11040,1920 4960,8000 11040,14080 "></polyline>
                </svg>
            </div>
            <div data-u="arrowright" class="jssora051" style="width:55px;height:55px;top:0px;right:25px;" data-autocenter="2" data-scale="0.75" data-scale-right="0.75">
                <svg viewbox="0 0 16000 16000" style="position:absolute;top:0;left:0;width:100%;height:100%;">
                    <polyline class="a" points="4960,1920 11040,8000 4960,14080 "></polyline>
                </svg>
            </div-->
        </div>
    </div>
    <script type="text/javascript">jssor_1_slider_init();</script>
                        <div style="clear:both;"></div>
                    </div>
                    <div style="clear:both;"></div>
                </div>
                <div style="clear:both;"></div>
            </div>
        </div>
    </div>
</div>
<div id="brands-slider">
    <div id="brands-list" class="">
        <?php

foreach ($brands as $brand) {
    echo "<button id=\"brand-" . $brand->id . "\" type=\"button\" value='" . $brand->id . "' class=\"btn-prni brand\" ><img src=\"assets/uploads/thumbs/" . ($brand->image ? $brand->image : 'no_image.png') . "\" style='width:" . $Settings->twidth . "px;height:" . $Settings->theight . "px;' class='img-rounded img-thumbnail' /><span>" . $brand->name . "</span></button>";

}
?>
    </div>
</div>
<div id="category-slider">
    <!--<button type="button" class="close open-category"><i class="fa fa-2x">&times;</i></button>-->
    <div id="category-list">
        <?php
//for ($i = 1; $i <= 40; $i++) {
foreach ($categories as $category) {
    echo "<button id=\"category-" . $category->id . "\" type=\"button\" value='" . $category->id . "' class=\"btn-prni category\" ><img src=\"assets/uploads/thumbs/" . ($category->image ? $category->image : 'no_image.png') . "\" style='width:" . $Settings->twidth . "px;height:" . $Settings->theight . "px;' class='img-rounded img-thumbnail' /><span>" . $category->name . "</span></button>";
}
//}
?>
    </div>
</div>
<div id="subcategory-slider">
    <!--<button type="button" class="close open-category"><i class="fa fa-2x">&times;</i></button>-->
    <div id="subcategory-list">
        <?php
if (!empty($subcategories)) {
    foreach ($subcategories as $category) {
        echo "<button id=\"subcategory-" . $category->id . "\" type=\"button\" value='" . $category->id . "' class=\"btn-prni subcategory\" ><img src=\"assets/uploads/thumbs/" . ($category->image ? $category->image : 'no_image.png') . "\" style='width:" . $Settings->twidth . "px;height:" . $Settings->theight . "px;' class='img-rounded img-thumbnail' /><span>" . $category->name . "</span></button>";
    }
}
?>
    </div>
</div>
<div class="modal fade in" id="paymentModal" tabindex="-1" role="dialog" aria-labelledby="payModalLabel"
     aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i class="fa fa-times-circle" aria-hidden="true"></i>
</span><span class="sr-only"><?=lang('close');?></span></button>
                <h4 class="modal-title" id="payModalLabel"><?=lang('finalize_sale');?></h4>
            </div>
            <div class="modal-body" id="payment_content">
                <!-- //////////////////////////////////////////////// -->
                <div class="row">
                    <div class="col-md-12 col-sm-12">
                        <div class="class-title" style="font-weight: bold;"><?=lang('quick_cash');?></div>

                        <div class="btn-group btn-group-vertical">
                            <button type="button" class="btn btn-lg btn-info quick-cash" id="quick-payable">0.00
                            </button>
                            <?php
foreach (lang('quick_cash_notes') as $cash_note_amount) {
    if ($cash_note_amount != 1000 && $cash_note_amount != 5000) {
        echo '<button type="button" class="btn btn-lg btn-warning quick-cash">' . $cash_note_amount . '</button>';
    }
}
?>
                            <button type="button" class="btn btn-lg btn-danger"
                                    id="clear-cash-notes"><?=lang('clear');?></button>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="amount-outer">

                        <div class="col-md-7 col-sm-7 col-xs-7">
                            <div id="amnt" class="ps-container">
                                <?php if ($Owner || $Admin || !$this->session->userdata('biller_id')) {?>
                                    <div class="form-group" style="margin:0;">
                                        <!--?=lang("biller", "biller");?-->
                                        <?php
foreach ($billers as $biller) {
    $bl[$biller->id] = $biller->company != '-' ? $biller->name . '(' . $biller->company . ')' : $biller->name;
}
    echo form_dropdown('biller', $bl, (isset($_POST['biller']) ? $_POST['biller'] : $pos_settings->default_biller), 'class="form-control" id="posbiller" required="required"');
    ?>
                                    </div>
                                <?php } else {
    $biller_input = array(
        'type' => 'hidden',
        'name' => 'biller',
        'id' => 'posbiller',
        'value' => $this->session->userdata('biller_id'),
    );

    echo form_input($biller_input);
}
?>
                                <div class="form-group">
                                    <div class="row">
                                        <div class="col-sm-6 col-xs-6">
                                            <?=form_textarea('sale_note', '', 'id="sale_note" class="form-control kb-text skip" style="height: 35px;" placeholder="' . lang('sale_note') . '" maxlength="250"');?>
                                        </div>
                                        <div class="col-sm-6 col-xs-6">
                                            <?=form_textarea('staffnote', '', 'id="staffnote" class="form-control kb-text skip" style="height: 35px;" placeholder="' . lang('staff_note') . '" maxlength="250"');?>
                                        </div>
                                    </div>
                                </div>
                                <div class="clearfir"></div>
                                <div id="payments" style="cursor:">
                                    <div class="well well-sm well_1">
                                        <div class="payment">
                                            <div class="row">
                                                <div class="col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                        <?=lang("amount", "amount_1");?>
                                                        <input name="amount[]" type="text" id="amount_1"
                                                               class="pa form-control kb-pad1 amount" onKeyPress="return isNumberKey(event)"/>
                                                        <button id="edt" class="btn-edt" onClick="enDis('amount_1')"><i class="fa fa-pencil" id="addIcon" style="font-size: 1.2em;"></i></button>
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 col-xs-6">
                                                    <div class="form-group">
                                                        <?=lang("paying_by", "paid_by_1");?>
                                                        <select name="paid_by[]" id="paid_by_1" class="form-control paid_by">
                                                            <?=$this->sma->paid_opts();?>
                                                            <?=$pos_settings->paypal_pro ? '<option value="ppp">' . lang("paypal_pro") . '</option>' : '';?>
                                                            <?=$pos_settings->stripe ? '<option value="stripe">' . lang("stripe") . '</option>' : '';?>
                                                            <?=$pos_settings->authorize ? '<option value="authorize">' . lang("authorize") . '</option>' : '';?>
                                                            <?php echo (isset($pos_settings->instamojo) && $pos_settings->instamojo == '1') ? ' <option value="instamojo">Instamojo</option>' : ''; ?>
                                                            <?php echo (isset($pos_settings->ccavenue) && $pos_settings->ccavenue == '1') ? ' <option value="ccavenue">CCavenue</option>' : ''; ?>
                                                            <?php echo (isset($pos_settings->paytm) && $pos_settings->paytm == '1') ? ' <option value="paytm">Paytm</option>' : ''; ?>
                                                            <?php echo (isset($pos_settings->paynear) && $pos_settings->paynear == '1') ? ' <option value="paynear">Paynear</option>' : ''; ?>
                                                            <?php echo (isset($pos_settings->payumoney) && $pos_settings->payumoney == '1') ? ' <option value="payumoney">Payumoney</option>' : ''; ?>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-sm-12">
                                                    <div class="form-group gc_1" style="display: none;">
                                                        <?=lang("gift_card_no", "gift_card_no_1");?>
                                                        <input name="paying_gift_card_no[]" type="text" id="gift_card_no_1" class="pa form-control kb-pad gift_card_no"/>

                                                        <div id="gc_details_1"></div>
                                                    </div>
                                                    <div class="display pcc_1" style="display:none;">
        <!--                                                Card Number: <div id="cardNo"></div>-->
                                                        <div id="cardty" style="display: none;"></div>
                                                        <div class="row">
                                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                                                    <input name="cc_transac_no[]" type="text" id="cc_transac_no_1"
                                                                        class="form-control kb-pad  ui-keyboard-input ui-widget-content ui-corner-all ui-keyboard-autoaccepted"
                                                                        placeholder="Transaction No."/>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-12 col-sm-12 col-xs-12">
                                                                <div class="form-group">
                                                                    <input name="cc_payment_other[]" type="text" id="cc_payment_other"
                                                                        class="form-control kb-text ui-keyboard-input ui-widget-content ui-corner-all ui-keyboard-autoaccepted"
                                                                        placeholder="Other"/>
                                                                </div>
                                                            </div>
                                                        </div>
        <!--                                                <div class="form-group">
                                                            <input type="text" id="swipe_1" class="form-control swipe kb-pad ui-keyboard-input ui-widget-content ui-corner-all ui-keyboard-autoaccepted"
                                                                placeholder="<?=lang('swipe')?>"/>
                                                        </div>
                                                        <div class="row">
                                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                                <div class="form-group">
                                                                    <input name="cc_no[]" type="text" id="pcc_no_1"
                                                                        class="form-control kb-pad  ui-keyboard-input ui-widget-content ui-corner-all ui-keyboard-autoaccepted"
                                                                        placeholder="<?=lang('cc_no')?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-6 col-sm-6 col-xs-6">
                                                                <div class="form-group">
                                                                    <input name="cc_holer[]" type="text" id="pcc_holder_1"
                                                                        class="form-control kb-text ui-keyboard-input ui-widget-content ui-corner-all ui-keyboard-autoaccepted"
                                                                        placeholder="<?=lang('cc_holder')?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 col-xs-3">
                                                                <div class="form-group">
                                                                    <select name="cc_type[]" id="pcc_type_1"  placeholder="<?=lang('card_type')?>">
                                                                        <option value="Visa"><?=lang("Visa");?></option>
                                                                        <option value="MasterCard"><?=lang("MasterCard");?></option>
                                                                        <option value="Amex"><?=lang("Amex");?></option>
                                                                        <option  value="Discover"><?=lang("Discover");?></option>
                                                                    </select>
                                                                     <input type="text" id="pcc_type_1" class="form-control" placeholder="<?=lang('card_type')?>" />
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 col-xs-3">
                                                                <div class="form-group">
                                                                    <input name="cc_month[]" type="text" id="pcc_month_1"
                                                                        class="form-control kb-pad  ui-keyboard-input ui-widget-content ui-corner-all ui-keyboard-autoaccepted"
                                                                        placeholder="<?=lang('month')?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 col-xs-3">
                                                                <div class="form-group">
                                                                    <input name="cc_year" type="text" id="pcc_year_1"
                                                                        class="form-control kb-pad  ui-keyboard-input ui-widget-content ui-corner-all ui-keyboard-autoaccepted"
                                                                        placeholder="<?=lang('year')?>"/>
                                                                </div>
                                                            </div>
                                                            <div class="col-md-3 col-sm-3 col-xs-3">
                                                                <div class="form-group">
                                                                    <input name="cc_cvv2" type="text" id="pcc_cvv2_1"
                                                                        class="form-control kb-pad  ui-keyboard-input ui-widget-content ui-corner-all ui-keyboard-autoaccepted"
                                                                        placeholder="cvv"/>
                                                                </div>
                                                            </div>
                                                        </div>-->
                                                    </div>
                                                    <div class="display pcheque_1" style="display:none;">
                                                        <div class="form-group"><?=lang("cheque_no", "cheque_no_1");?>
                                                            <input name="cheque_no[]" type="text" id="cheque_no_1"
                                                                   class="form-control cheque_no kb-pad gift_card_no ui-keyboard-input ui-widget-content ui-corner-all ui-keyboard-autoaccepted"/>
                                                        </div>
                                                    </div>

                                                    <div class="display pother_1" style="display:none;">
                                                        <div class="form-group">Transaction No
                                                            <input name="other_tran_no" type="text" id="other_tran_no_1"
                                                                   class="form-control cheque_no kb-pad gift_card_no ui-keyboard-input ui-widget-content ui-corner-all ui-keyboard-autoaccepted"/>
                                                        </div>
                                                    </div>
                                                    <div class="display form-group payment_note">
                                                        <?=lang('payment_note', 'payment_note');?>
                                                        <textarea name="payment_note[]" id="payment_note_1"
                                                                  class="pa form-control kb-text payment_note"></textarea>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="multi-payment"></div>
                                <button type="button" class="btn btn-primary col-md-12 addButton"><i
                                        class="fa fa-plus"></i> <?=lang('add_more_payments')?></button>
                            </div>
                        </div>
                        <div class="col-md-5 col-sm-5 col-xs-5 text-center card-div">
                            <div class="row card-box">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="radio-div" data-toggle="tooltip" title="Cash">
                                        <input type="radio" class="card custom_payment_icon" name="colorRadio" checked value="cash">
                                        <label for="checkbox1"><span><img src="<?=$assets?>pos/images/ico1.png" alt=""></span></label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="radio-div" data-toggle="tooltip" title="Gift Card">
                                        <input type="radio" class="card custom_payment_icon" name="colorRadio" value="gift_card"><label for="checkbox1"><span><img src="<?=$assets?>pos/images/ico2.png" alt=""></span></label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="radio-div" data-toggle="tooltip" title="Credit Card">
                                        <input title="Credit Card" type="radio" class="card custom_payment_icon" name="colorRadio" value="CC"><label for="checkbox1"><span><img src="<?=$assets?>pos/images/ico3.png" alt=""></span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row card-box">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="radio-div" data-toggle="tooltip" title="Cheque">
                                        <input type="radio" class="card custom_payment_icon" name="colorRadio" value="Cheque"><label for="checkbox1"><span><img src="<?=$assets?>pos/images/ico4.png" alt=""></span></label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="radio-div" data-toggle="tooltip" title="Other">
                                        <input type="radio" class="card custom_payment_icon" name="colorRadio" value="other"><label for="checkbox1"><span><img src="<?=$assets?>pos/images/ico5.png" alt=""></span></label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="radio-div" data-toggle="tooltip" title="Deposit">
                                        <input type="radio" class="card custom_payment_icon" name="colorRadio" value="deposit"><label for="checkbox1"><span><img src="<?=$assets?>pos/images/ico6.png" alt=""></span></label>
                                    </div>
                                </div>
                            </div>
                            <div class="row card-box">
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="radio-div" data-toggle="tooltip" title="Debit Card">
                                        <input title="Debit Card" type="radio" class="card custom_payment_icon" name="colorRadio" value="DC"><label for="checkbox1"><span><img src="<?=$assets?>pos/images/ico3.png" alt=""></span></label>
                                    </div>
                                </div>
    <!--                                                                </div>
                            <div class="row card-box">-->
                            <?php if ($pos_settings->paypal_pro == '1'): ?>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="radio-div" data-toggle="tooltip" title="PPP">
                                        <input type="radio" class="card custom_payment_icon" name="colorRadio" value="ppp"><label for="checkbox1"><span><img src="<?=$assets?>pos/images/ico7.png" alt=""></span></label>
                                    </div>
                                </div>
                                 <?php endif;?>
                                <?php if ($pos_settings->stripe == '1'): ?>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="radio-div" data-toggle="tooltip" title="Stripe">
                                        <input type="radio" class="card custom_payment_icon" name="colorRadio" value="stripe"><label for="checkbox1"><span><img src="<?=$assets?>pos/images/ico8.png" alt=""></span></label>
                                    </div>
                                </div>
                                <?php endif;?>
                                <?php if ($pos_settings->authorize == '1'): ?>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="radio-div"  data-toggle="tooltip" title="Authorize">
                                        <input type="radio" class="card custom_payment_icon" name="colorRadio" value="authorize"><label for="checkbox1"><span><img src="<?=$assets?>pos/images/ico9.png" alt=""></span></label>
                                    </diV>
                                </div>
                                 <?php endif;?>
    <!--                                                                </div>
                            <div class="row card-box">-->
                                <?php if ($pos_settings->instamojo == '1'): ?>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="radio-div"  data-toggle="tooltip" title="Instamojo">
                                        <input type="radio" class="card custom_payment_icon" name="colorRadio" value="instamojo"><label for="checkbox1"><span><img src="<?=$assets?>pos/images/ico10.png" alt=""></span></label>
                                    </div>
                                </div>
                                <?php endif;?>
                                <?php if ($pos_settings->ccavenue == '1'): ?>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="radio-div" data-toggle="tooltip" title="CCavenue">
                                        <input type="radio" class="card custom_payment_icon" name="colorRadio" value="ccavenue"><label for="checkbox1"><span><img src="<?=$assets?>pos/images/ico11.png" alt=""></span></label>
                                    </div>
                                </div>
                                <?php endif;?>
                                <?php if ($pos_settings->paytm == '1'): ?>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="radio-div" data-toggle="tooltip" title="Paytm">
                                        <input type="radio" class="card custom_payment_icon" name="colorRadio" value="paytm"><label for="checkbox1"><span><img src="<?=$assets?>pos/images/ico12.png" alt=""></span></label>
                                    </div>
                                </div>
                                <?php endif;?>
    <!--                                                                </div>
                            <div class="row card-box">-->

                                   <?php if ($pos_settings->paynear == '1' && !empty($this->pos_settings->paynear_web)): ?>
                                <div class="col-md-4 col-sm-4 col-xs-4" id="paynear_btn_holder" >
                                    <div class="radio-div" data-toggle="tooltip" title="Paynear">
                                        <input type="radio" class="card custom_payment_icon" name="colorRadio" id="paynear_btn" value="paynear"><label for="checkbox1"><span><img src="<?=$assets?>pos/images/ico13.png" alt=""></span></label>
                                    </div>
                                </div>
                                <?php endif;?>
                                <?php if ($pos_settings->payumoney == '1'): ?>
                                <div class="col-md-4 col-sm-4 col-xs-4" id="payumoney_btn_holder" >
                                    <div class="radio-div" data-toggle="tooltip" title="Payumoney">
                                        <input type="radio" class="card custom_payment_icon" name="colorRadio" id="payumoney_btn" value="payumoney"><label for="checkbox1"><span><img src="<?=$assets?>pos/images/ico17.png" alt=""></span></label>
                                    </div>
                                </div>
                                <?php endif;?>
                            </div>
                            <?php if ($pos_settings->paynear == '1' && !empty($this->pos_settings->paynear_app)): ?>
                            <div class="row card-box" id="paynear_btn_app_holder" style="display:none;">

                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="radio-div" data-toggle="tooltip" title="Paynear">
                                        <input type="radio" class="card custom_payment_icon" name="colorRadio" id="paynear_btn1" value="paynear" data-value="1"><label for="checkbox1"><span><img src="<?=$assets?>pos/images/ico14.png" alt=""></span></label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="radio-div" data-toggle="tooltip" title="Paynear">
                                        <input type="radio" class="card custom_payment_icon" name="colorRadio" id="paynear_btn2" value="paynear"  data-value="2"><label for="checkbox1"><span><img src="<?=$assets?>pos/images/ico15.png" alt=""></span></label>
                                    </div>
                                </div>
                                <div class="col-md-4 col-sm-4 col-xs-4">
                                    <div class="radio-div" data-toggle="tooltip" title="Paynear">
                                        <input type="radio" class="card custom_payment_icon" name="colorRadio" id="paynear_btn3" value="paynear"  data-value="3"><label for="checkbox1"><span><img src="<?=$assets?>pos/images/ico16.png" alt=""></span></label>
                                    </div>
                                </div>

                            </div>
                            <?php endif;?>
                        </div>
                    </div>
                    <div class="col-xs-12">
                        <div class="font16" style="margin-top: 17px;">
                            <table class="table table-bordered table-condensed table-striped" style="margin-bottom: 0;">
                                <tbody>
                                    <tr>
                                        <td>Total<br />Items</td>
                                        <td class="text-right"><span id="item_count">0.00</span></td>
                                        <td>Total<br />Payable</td>
                                        <td class="text-right"><span id="twt">0.00</span></td>
                                        <td>Total<br />Paying</td>
                                        <td class="text-right"><span id="total_paying">0.00</span></td>
                                        <td><?=lang("balance");?></td>
                                        <td class="text-right"><span id="balance" class="bal">0.00</span></td>
                                    </tr>
                                </tbody>
                            </table>
                            <div class="clearfix"></div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="modal-footer">
                <div class="row">
                     <div class="col-md-4 col-sm-4 col-xs-4">
                    <button class="btn btn-block btn-lg btn-primary cmdnotprint" name="cmd"  id="submit-sale">Quick <?=lang('submit');?></button>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-4">
                         <button class="btn btn-block btn-lg btn-primary cmdprint" name="cmdprint" id="submit-sale"><?=lang('submit');?> & Print</button>
                     </div>
                     <div class="col-md-4 col-sm-4 col-xs-4">
                         <button class="btn btn-block btn-lg btn-primary cmdprint1" name="cmdprint1" id="submit-sale">Other</button>
                          <!--  <a href="javascript:void(0);" onclick="return paynear_mobile_app()">Paynear APP</a> -->
                     </div>
                </div>
            </div>
        </div>
    </div>
</div>
<div class="modal" id="prModal" tabindex="-1" role="dialog" aria-labelledby="prModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i
                            class="fa fa-2x">&times;</i></span><span class="sr-only"><?=lang('close');?></span></button>
                <h4 class="modal-title" id="prModalLabel"></h4>
            </div>
            <div class="modal-body" id="pr_popover_content">
                <form class="form-horizontal" role="form">
                    <?php if ($Settings->tax1) {
    ?>
                        <div class="form-group">
                            <label class="col-sm-4 control-label"><?=lang('product_tax')?></label>
                            <div class="col-sm-8">
                                <?php
$tr[""] = "";
    foreach ($tax_rates as $tax) {
        $tr[$tax->id] = $tax->name;
    }
    echo form_dropdown('ptax', $tr, "", 'id="ptax" class="form-control pos-input-tip" style="width:100%;"');
    ?>
                            </div>
                        </div>
                    <?php }?>
                    <?php if ($Settings->product_serial) {?>
                        <div class="form-group">
                            <label for="pserial" class="col-sm-4 control-label"><?=lang('serial_no')?></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control kb-text" id="pserial">
                            </div>
                        </div>
                    <?php }?>
                    <div class="form-group">
                        <label for="pquantity" class="col-sm-4 control-label"><?=lang('quantity')?></label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control kb-pad" id="pquantity">
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="punit" class="col-sm-4 control-label"><?=lang('product_unit')?></label>
                        <div class="col-sm-8">
                            <div id="punits-div"></div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="poption" class="col-sm-4 control-label"><?=lang('product_option')?></label>
                        <div class="col-sm-8">
                            <div id="poptions-div"></div>
                        </div>
                    </div>
                    <?php if ($Settings->product_discount && ($Owner || $Admin || $this->session->userdata('allow_discount'))) {?>
                        <div class="form-group">
                            <label for="pdiscount" class="col-sm-4 control-label"><?=lang('product_discount')?></label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control kb-pad" id="pdiscount">
                            </div>
                        </div>
                    <?php }?>
                    <div class="form-group">
                        <label for="pprice" class="col-sm-4 control-label"><?=lang('unit_price')?></label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control kb-pad" id="pprice" <?=($Owner || $Admin || $GP['edit_price']) ? '' : 'readonly';?>>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th style="width:25%;"><?=lang('net_unit_price');?></th>
                            <th style="width:25%;"><span id="net_price"></span></th>
                            <th style="width:25%;"><?=lang('product_tax');?></th>
                            <th style="width:25%;"><span id="pro_tax"></span></th>
                        </tr>
                    </table>
                    <input type="hidden" id="punit_price" value=""/>
                    <input type="hidden" id="old_tax" value=""/>
                    <input type="hidden" id="old_qty" value=""/>
                    <input type="hidden" id="old_price" value=""/>
                    <input type="hidden" id="row_id" value=""/>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" id="editItem"><?=lang('submit')?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade in" id="gcModal" tabindex="-1" role="dialog" aria-labelledby="mModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                        class="fa fa-2x">&times;</i></button>
                <h4 class="modal-title" id="myModalLabel"><?=lang('sell_gift_card');?></h4>
            </div>
            <div class="modal-body">
                <p><?=lang('enter_info');?></p>

                <div class="alert alert-danger gcerror-con" style="display: none;">
                    <button data-dismiss="alert" class="close" type="button">Ã—</button>
                    <span id="gcerror"></span>
                </div>
                <div class="form-group">
                    <?=lang("card_no", "gccard_no");?> *
                    <div class="input-group">
                        <?php echo form_input('gccard_no', '', 'class="form-control" id="gccard_no"'); ?>
                        <div class="input-group-addon" style="padding-left: 10px; padding-right: 10px;">
                            <a href="#" id="genNo"><i class="fa fa-cogs"></i></a>
                        </div>
                    </div>
                </div>
                <input type="hidden" name="gcname" value="<?=lang('gift_card')?>" id="gcname"/>

                <div class="form-group">
                    <?=lang("value", "gcvalue");?> *
                    <?php echo form_input('gcvalue', '', 'class="form-control" id="gcvalue"'); ?>
                </div>
                <div class="form-group">
                    <?=lang("price", "gcprice");?> *
                    <?php echo form_input('gcprice', '', 'class="form-control" id="gcprice"'); ?>
                </div>
                <div class="form-group">
                    <?=lang("customer", "gccustomer");?>
                    <?php echo form_input('gccustomer', '', 'class="form-control" id="gccustomer"'); ?>
                </div>
                <div class="form-group">
                    <?=lang("expiry_date", "gcexpiry");?>
                    <?php echo form_input('gcexpiry', $this->sma->hrsd(date("Y-m-d", strtotime("+2 year"))), 'class="form-control date" id="gcexpiry"'); ?>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="addGiftCard" class="btn btn-primary"><?=lang('sell_gift_card')?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade in" id="mModal" tabindex="-1" role="dialog" aria-labelledby="mModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true"><i
                            class="fa fa-2x">&times;</i></span><span class="sr-only"><?=lang('close');?></span></button>
                <h4 class="modal-title" id="mModalLabel"><?=lang('add_product_manually')?></h4>
            </div>
            <div class="modal-body" id="pr_popover_content">
                <form class="form-horizontal" role="form">
                    <div class="form-group hide-me">
                        <label for="mcode" class="col-sm-4 control-label "><?=lang('product_code')?> *</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control kb-text" id="mcode">
                        </div>
                    </div>
                    <div id="pname" class="form-group">
                        <label for="mname" class="col-sm-4 control-label"><?=lang('product_name')?> *</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control kb-text" id="mname" onblur="jQuery('#mcode').val(this.value)">
                        </div>
                    </div>
                    <?php if ($Settings->tax1) {
    ?>
                        <div class="form-group hide-me">
                            <label for="mtax" class="col-sm-4 control-label"><?=lang('product_tax')?> *</label>

                            <div class="col-sm-8">
                                <?php
$tr[""] = "";
    foreach ($tax_rates as $tax) {
        $tr[$tax->id] = $tax->name;
    }
    echo form_dropdown('mtax', $tr, "1", 'id="mtax" class="form-control pos-input-tip" style="width:100%;"');
    ?>
                            </div>
                        </div>
                    <?php }
?>
                    <div class="form-group">
                        <label for="mquantity" class="col-sm-4 control-label"><?=lang('quantity')?> *</label>

                        <div class="col-sm-8">
                            <input type="number" class="form-control kb-pad" id="mquantity">
                        </div>
                    </div>
                    <?php if ($Settings->product_discount && ($Owner || $Admin || $this->session->userdata('allow_discount'))) {?>
                        <div class="form-group hide-me">
                            <label for="mdiscount"
                                   class="col-sm-4 control-label"><?=lang('product_discount')?></label>

                            <div class="col-sm-8">
                                <input type="text" class="form-control kb-pad" id="mdiscount">
                            </div>
                        </div>
                    <?php }
?>
                    <div class="form-group">
                        <label for="mprice" class="col-sm-4 control-label"><?=lang('unit_price')?> *</label>

                        <div class="col-sm-8">
                            <input type="text" class="form-control kb-pad" id="mprice"onkeypress="return IsNumeric(event);" ondrop="return false;" onpaste="return false;" >
            <span id="error" style="color:#a94442; font-size:11px;display: none">Please Enter numbers only</span>
                        </div>
                    </div>
                    <table class="table table-bordered table-striped">
                        <tr>
                            <th style="width:25%;"><?=lang('net_unit_price');?></th>
                            <th style="width:25%;"><span id="mnet_price"></span></th>
                            <th style="width:25%;"><?=lang('product_tax');?></th>
                            <th style="width:25%;"><span id="mpro_tax"></span></th>
                        </tr>
                    </table>
                </form>
                <div class="row">
                    <div class="pull-left col-xs-12">
                        <div class="row">
                            <div class="col-xs-3">
                                <button id="mitems" class="btn btn-primary til-btn misc">Miscellaneous item</button>
                            </div>
                            <div class="col-xs-3">
                                <button id="scharges" class="btn btn-primary til-btn serv">service charges</button>
                            </div>
                            <div class="col-xs-3">
                                <button id="tcharges" class="btn btn-primary til-btn trans">transportation charges</button>
                            </div>
                            <div class="col-xs-3">
                                <button id="other" class="btn btn-primary til-btn othr">other</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
        <button type="button" class="btn btn-primary" id="addItemManually"><?=lang('submit')?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade in" id="sckModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">
                <i class="fa fa-2x">&times;</i></span><span class="sr-only"><?=lang('close');?></span>
                </button>
                <button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onClick="window.print();">
                    <i class="fa fa-print"></i> <?=lang('print');?>
                </button>
                <h4 class="modal-title" id="mModalLabel"><?=lang('shortcut_keys')?></h4>
            </div>
            <div class="modal-body" id="pr_popover_content">
                <table class="table table-bordered table-striped table-condensed table-hover"
                       style="margin-bottom: 0px;">
                    <thead>
                    <tr>
                        <th><?=lang('shortcut_keys')?></th>
                        <th><?=lang('actions')?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td><?=$pos_settings->focus_add_item?></td>
                        <td><?=lang('focus_add_item')?></td>
                    </tr>
                    <tr>
                        <td><?=$pos_settings->add_manual_product?></td>
                        <td><?=lang('add_manual_product')?></td>
                    </tr>
                    <tr>
                        <td><?=$pos_settings->customer_selection?></td>
                        <td><?=lang('customer_selection')?></td>
                    </tr>
                    <tr>
                        <td><?=$pos_settings->add_customer?></td>
                        <td><?=lang('add_customer')?></td>
                    </tr>
                    <tr>
                        <td><?=$pos_settings->toggle_category_slider?></td>
                        <td><?=lang('toggle_category_slider')?></td>
                    </tr>
                    <tr>
                        <td><?=$pos_settings->toggle_subcategory_slider?></td>
                        <td><?=lang('toggle_subcategory_slider')?></td>
                    </tr>
                    <tr>
                        <td><?=$pos_settings->cancel_sale?></td>
                        <td><?=lang('cancel_sale')?></td>
                    </tr>
                    <tr>
                        <td><?=$pos_settings->suspend_sale?></td>
                        <td><?=lang('suspend_sale')?></td>
                    </tr>
                    <tr>
                        <td><?=$pos_settings->print_items_list?></td>
                        <td><?=lang('print_items_list')?></td>
                    </tr>
                    <tr>
                        <td><?=$pos_settings->finalize_sale?></td>
                        <td><?=lang('finalize_sale')?></td>
                    </tr>
                    <tr>
                        <td><?=$pos_settings->today_sale?></td>
                        <td><?=lang('today_sale')?></td>
                    </tr>
                    <tr>
                        <td><?=$pos_settings->open_hold_bills?></td>
                        <td><?=lang('open_hold_bills')?></td>
                    </tr>
                    <tr>
                        <td><?=$pos_settings->close_register?></td>
                        <td><?=lang('close_register')?></td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<div class="modal fade in" id="dsModal" tabindex="-1" role="dialog" aria-labelledby="dsModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                    <i class="fa fa-2x">&times;</i>
                </button>
                <h4 class="modal-title" id="dsModalLabel"><?=lang('edit_order_discount');?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?=lang("order_discount", "order_discount_input");?>
                    <?php echo form_input('order_discount_input', '', 'class="form-control kb-pad" id="order_discount_input"'); ?>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="updateOrderDiscount" class="btn btn-primary"><?=lang('update')?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade in" id="txModal" tabindex="-1" role="dialog" aria-labelledby="txModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-sm">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                        class="fa fa-2x">&times;</i></button>
                <h4 class="modal-title" id="txModalLabel"><?=lang('edit_order_tax');?></h4>
            </div>
            <div class="modal-body">
                <div class="form-group">
                    <?=lang("order_tax", "order_tax_input");?>
<?php
$tr[""] = "";
foreach ($tax_rates as $tax) {
    $tr[$tax->id] = $tax->name;
}
echo form_dropdown('order_tax_input', $tr, "", 'id="order_tax_input" class="form-control pos-input-tip" style="width:100%;"');
?>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" id="updateOrderTax" class="btn btn-primary"><?=lang('update')?></button>
            </div>
        </div>
    </div>
</div>

<div class="modal fade in" id="susModal" tabindex="-1" role="dialog" aria-labelledby="susModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i
                        class="fa fa-2x">&times;</i></button>
                <h4 class="modal-title" id="susModalLabel"><?=lang('suspend_sale');?></h4>
            </div>
            <div class="modal-body">
                <p><?=lang('type_reference_note');?></p>

                <div class="form-group">
                    <?=lang("reference_note", "reference_note");?>
<?php echo form_input('reference_note', $reference_note, 'class="form-control kb-text" id="reference_note"'); ?>
                </div>
                <?php
if (isset($Settings->pos_type) && $Settings->pos_type == 'restaurant') {
    ?>
        <div class="radio-btn-section">
            <!--div class="rd-btn">
                <input type="radio" name="gender" value="Table 1">
                <lable>Table 1</lable>
            </div>
            <div class="rd-btn">
                <input type="radio" name="gender" value="Table 2">
                <lable>Table 2</lable>
            </div>
            <div class="rd-btn">
                <input type="radio" name="gender" value="Table 3">
                <lable>Table 3</lable>
            </div>
            <div class="rd-btn">
                <input type="radio" name="gender" value="Table 4">
                <lable>Table 4</lable>
            </div>
            <div class="rd-btn">
                <input type="radio" name="gender" value="Table 5">
                <lable>Table 5</lable>
            </div>
            <div class="rd-btn">
                <input type="radio" name="gender" value="Table 6">
                <lable>Table 6</lable>
            </div>
            <div class="rd-btn">
                <input type="radio" name="gender" value="Table 7">
                <lable>Table 7</lable>
            </div>
            <div class="rd-btn">
                <input type="radio" name="gender" value="Table 8">
                <lable>Table 8</lable>
            </div>
            <div class="rd-btn">
                <input type="radio" name="gender" value="Table 9">
                <lable>Table 9</lable>
            </div>
            <div class="rd-btn">
                <input type="radio" name="gender" value="Table 10">
                <lable>Table 10</lable>
            </div>
            <div class="rd-btn">
                <input type="radio" name="gender" value="Table 11">
                <lable>Table 11</lable>
            </div>
            <div class="rd-btn">
                <input type="radio" name="gender" value="Table 12">
                <lable>Table 12</lable>
            </div>
            <div class="rd-btn">
                <input type="radio" name="gender" value="Table 13">
                <lable>Table 13</lable>
            </div>
            <div class="rd-btn">
                <input type="radio" name="gender" value="Table 14">
                <lable>Table 14</lable>
            </div>
            <div class="rd-btn">
                <input type="radio" name="gender" value="Table 15">
                <lable>Table 15</lable>
            </div>
            <div class="rd-btn">
                <input type="radio" name="gender" value="Table 16">
                <lable>Table 16</lable>
            </div-->
            <div class="row">
                <div class="col-md-6">

                    <div class="chk-btn">
                        <input class="carry_out" type="radio" name="carry_out" value="carry_out" onchange="valueChanged()"/>
                        <label>Carry Out</label>
                    </div>
                    <div class="information-field" style="display:none">
                        <div class="row">
                            <div class="col-md-12">
                                <input name="carry_out_customer_info" type="text" class="form-control" placeholder="Customer name / Mobile no">

                            </div>
                        </div>
                    </div>
                    <script type="text/javascript">
                    function valueChanged()
                    {
                        if($('.carry_out').is(":checked"))  {
                            $("#reference_note").val('');
                            $(".information-field").show();
                        }else{
                            $("#reference_note").val('');
                            $(".information-field").hide();
                        }
                        if($('.table-num').is(":checked"))  {
                            $("#reference_note").val('');
                            $(".keypad").show();
                        }else{
                            $("#reference_note").val('');
                            $(".keypad").hide();
                        }


                    }
                    </script>
                </div>
                <div class="col-md-6">
                    <div class="chk-btn">
                        <input class="table-num" type="radio" name="carry_out" value="carry_out" onchange="valueChanged()"/>
                        <label>Enter table number</label>
                    </div>
                    <div class="keypad" style="display:none">
                        <div class="key-btns">
                            <button value="1">1</button>
                        </div>
                        <div class="key-btns">
                            <button value="2">2</button>
                        </div>
                        <div class="key-btns">
                            <button value="3">3</button>
                        </div>
                        <div class="key-btns">
                            <button value="4">4</button>
                        </div>
                        <div class="key-btns">
                            <button value="5">5</button>
                        </div>
                        <div class="key-btns">
                            <button value="6">6</button>
                        </div>
                        <div class="key-btns">
                            <button value="7">7</button>
                        </div>
                        <div class="key-btns">
                            <button value="8">8</button>
                        </div>
                        <div class="key-btns">
                            <button value="9">9</button>
                        </div>
                        <div class="key-btns">
                            <button value="0">0</button>
                        </div>
                        <div class="bl-btn">
                            <button value="clear" onClick="$('#reference_note').val('')">CLEAR</button>
                        </div>
                    </div>
                </div>
            </div>
            <div style="clear:both"></div>
        </div>
        <?php
}
;?>

            </div>
            <div class="modal-footer">
                  <div class="row">
                    <?php
if (isset($Settings->pos_type) && $Settings->pos_type == 'restaurant') {
    ?>
                      <div class="col-md-4 col-sm-4 col-xs-4">
                            <button type="button" style="float:left" class="btn btn-block btn-lg btn-primary cmdnotprint print_kot" id="print">Print</button>
                      </div>
                        <?php }?>
                      <div class="col-md-4 col-sm-4 col-xs-4">
                            <button type="button" id="suspend_sale" class="btn btn-block btn-lg btn-primary cmdnotprint">Save</button>
                      </div>
                      <?php
if (isset($Settings->pos_type) && $Settings->pos_type == 'restaurant') {
    ?>
                      <div class="col-md-4 col-sm-4 col-xs-4">
                            <button onclick="call_checkout()" type="button" class="btn btn-block btn-lg btn-primary cmdnotprint">Checkout</button>
                      </div>
                        <?php }?>
                  </div>
            </div>
        </div>
    </div>
</div>



<div class="modal  modalvarient" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" onclick="modalClose('modalvarient')" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Modal title</h4>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">
                <button type="button" onclick="modalClose('modalvarient')" class="btn btn-default" data-toggle="modal">Close</button>
                <button type="button" class="btn btn-primary" onclick="addProductToVarientProduct('modalvarient')">Save changes</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->


<div class="kot_tbl" style="display: none;"></div>
<div id="order_tbl">
     <style>
       .btn_back{display:inline-block;padding:6px 12px;margin:15px;font-size:14px;font-weight:400;line-height:1.42857143;text-align:center;white-space:nowrap;vertical-align:middle;cursor:pointer;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;background-image:none;border:1px solid #357ebd;border-radius:4px;color:#fff;background-color:#428bca}
    </style>
    <span id="order_span"></span>
    <table id="order-table" class="prT table table-striped" style="margin-bottom:0;" width="100%"></table>
    <div style="text-align:center"  id="bk_pos" ><a  href="<?=site_url()?>/pos"  class="btn btn-primary btn_back"  >BACK TO POS</a></div>
</div>
<div id="bill_tbl">
    <style>
       .btn_back{display:inline-block;padding:6px 12px;margin-bottom:0;font-size:14px;font-weight:400;line-height:1.42857143;text-align:center;white-space:nowrap;vertical-align:middle;cursor:pointer;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;background-image:none;border:1px solid #357ebd;border-radius:4px;color:#fff;background-color:#428bca}
    </style>
    <span id="bill_span"></span>
    <table id="bill-table" width="100%" class="prT table table-striped" style="margin-bottom:0;"></table>
    <table id="bill-total-table" class="prT table" style="margin-bottom:0;" width="100%"></table>
    <div style="text-align:center"  id="bk_pos" ><a   href="<?=site_url()?>/pos"  class="btn btn-primary btn_back"  >BACK TO POS</a></div>
</div>
<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
     aria-hidden="true"></div>
<div class="modal fade in" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2"
     aria-hidden="true"></div>
<div id="modal-loading" style="display: none;">
    <div class="blackbg"></div>
    <div class="loader"></div>
</div>
<?php unset($Settings->setting_id, $Settings->smtp_user, $Settings->smtp_pass, $Settings->smtp_port, $Settings->update, $Settings->reg_ver, $Settings->allow_reg, $Settings->default_email, $Settings->mmode, $Settings->timezone, $Settings->restrict_calendar, $Settings->restrict_user, $Settings->auto_reg, $Settings->reg_notification, $Settings->protocol, $Settings->mailpath, $Settings->smtp_crypto, $Settings->corn, $Settings->customer_group, $Settings->envato_username, $Settings->purchase_code);?>
<script type="text/javascript">
var site = <?=json_encode(array('base_url' => base_url(), 'settings' => $Settings, 'dateFormats' => $dateFormats))?>, pos_settings = <?=json_encode($pos_settings);?>;
var lang = {unexpected_value: '<?=lang('unexpected_value');?>', select_above: '<?=lang('select_above');?>', r_u_sure: '<?=lang('r_u_sure');?>', bill: '<?=lang('bill');?>', order: '<?=lang('order');?>'};
</script>

<script type="text/javascript">
    // Create Base64 Object
    var Base64={_keyStr:"ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789+/=",encode:function(e){var t="";var n,r,i,s,o,u,a;var f=0;e=Base64._utf8_encode(e);while(f<e.length){n=e.charCodeAt(f++);r=e.charCodeAt(f++);i=e.charCodeAt(f++);s=n>>2;o=(n&3)<<4|r>>4;u=(r&15)<<2|i>>6;a=i&63;if(isNaN(r)){u=a=64}else if(isNaN(i)){a=64}t=t+this._keyStr.charAt(s)+this._keyStr.charAt(o)+this._keyStr.charAt(u)+this._keyStr.charAt(a)}return t},decode:function(e){var t="";var n,r,i;var s,o,u,a;var f=0;e=e.replace(/[^A-Za-z0-9+/=]/g,"");while(f<e.length){s=this._keyStr.indexOf(e.charAt(f++));o=this._keyStr.indexOf(e.charAt(f++));u=this._keyStr.indexOf(e.charAt(f++));a=this._keyStr.indexOf(e.charAt(f++));n=s<<2|o>>4;r=(o&15)<<4|u>>2;i=(u&3)<<6|a;t=t+String.fromCharCode(n);if(u!=64){t=t+String.fromCharCode(r)}if(a!=64){t=t+String.fromCharCode(i)}}t=Base64._utf8_decode(t);return t},_utf8_encode:function(e){e=e.replace(/rn/g,"n");var t="";for(var n=0;n<e.length;n++){var r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r)}else if(r>127&&r<2048){t+=String.fromCharCode(r>>6|192);t+=String.fromCharCode(r&63|128)}else{t+=String.fromCharCode(r>>12|224);t+=String.fromCharCode(r>>6&63|128);t+=String.fromCharCode(r&63|128)}}return t},_utf8_decode:function(e){var t="";var n=0;var r=c1=c2=0;while(n<e.length){r=e.charCodeAt(n);if(r<128){t+=String.fromCharCode(r);n++}else if(r>191&&r<224){c2=e.charCodeAt(n+1);t+=String.fromCharCode((r&31)<<6|c2&63);n+=2}else{c2=e.charCodeAt(n+1);c3=e.charCodeAt(n+2);t+=String.fromCharCode((r&15)<<12|(c2&63)<<6|c3&63);n+=3}}return t}}
    var product_variant = 0, shipping = 0, p_page = 0, per_page = 0, tcp = "<?=$tcp?>", pro_limit = <?=$pos_settings->pro_limit;?>,
        brand_id = 0, obrand_id = 0, cat_id = "<?=$pos_settings->default_category?>", ocat_id = "<?=$pos_settings->default_category?>", sub_cat_id = 0, osub_cat_id,
        count = 1, an = 1, DT = <?=$Settings->default_tax_rate?>,
        product_tax = 0, invoice_tax = 0, product_discount = 0, order_discount = 0, total_discount = 0, total = 0, total_paid = 0, grand_total = 0,
        KB = <?=$pos_settings->keyboard?>, tax_rates =<?php echo json_encode($tax_rates); ?>;
    var protect_delete = <?php if (!$Owner && !$Admin) {echo $pos_settings->pin_code ? '1' : '0';} else {echo '0';}?>
    //var audio_success = new Audio('<?=$assets?>sounds/sound2.mp3');
    //var audio_error = new Audio('<?=$assets?>sounds/sound3.mp3');
    var lang_total = '<?=lang('total');?>', lang_items = '<?=lang('items');?>', lang_discount = '<?=lang('discount');?>', lang_tax2 = '<?=lang('order_tax');?>', lang_total_payable = '<?=lang('total_payable');?>';
    var java_applet = <?=$pos_settings->java_applet?>, order_data = '', bill_data = '';
    function widthFunctions(e) {
        var wh = $(window).height(),
            lth = $('#left-top').height(),
            lbh = $('#left-bottom').height();
        $('#cpinner').css("height", wh - 60);
        $('#cpinner').css("min-height", 410);
        $('#left-middle').css("height", wh - 75);
        $('#left-middle').css("min-height", 410);
        $('#product-list').css("height", wh - 245);
        $('#product-list').css("min-height", 240);
    }
    $(window).bind("resize", widthFunctions);
    $(document).ready(function () {
        $('#view-customer').click(function(){
            $('#myModal').modal({remote: site.base_url + 'customers/view/' + $("input[name=customer]").val()});
            $('#myModal').modal('show');
        });
//alert(jQuery('#s2id_autogen8_search'));
        //jQuery('.select2-with-searchbox#s2id_autogen8_search').removeAttr("disabled");

        $('textarea').keydown(function (e) {
            if (e.which == 13) {
               var s = $(this).val();
               $(this).val(s+'\n').focus();
               e.preventDefault();
               return false;
            }
        });
        <?php if ($sid) {?>
        localStorage.setItem('positems', JSON.stringify(<?=$items;?>));
        <?php }
?>
<?php if ($this->session->userdata('remove_posls')) {?>
        if (localStorage.getItem('positems')) {
            localStorage.removeItem('positems');
        }
        if (localStorage.getItem('posdiscount')) {
            localStorage.removeItem('posdiscount');
        }
        if (localStorage.getItem('postax2')) {
            localStorage.removeItem('postax2');
        }
        if (localStorage.getItem('posshipping')) {
            localStorage.removeItem('posshipping');
        }
        if (localStorage.getItem('poswarehouse')) {
            localStorage.removeItem('poswarehouse');
        }
        if (localStorage.getItem('posnote')) {
            localStorage.removeItem('posnote');
        }
        if (localStorage.getItem('poscustomer')) {
            localStorage.removeItem('poscustomer');
        }
        if (localStorage.getItem('posbiller')) {
            localStorage.removeItem('posbiller');
        }
        if (localStorage.getItem('poscurrency')) {
            localStorage.removeItem('poscurrency');
        }
        if (localStorage.getItem('posnote')) {
            localStorage.removeItem('posnote');
        }
        if (localStorage.getItem('staffnote')) {
            localStorage.removeItem('staffnote');
        }
        <?php $this->sma->unset_data('remove_posls');}
?>
        widthFunctions();
        <?php if ($suspend_sale) {?>
        localStorage.setItem('postax2', '<?=$suspend_sale->order_tax_id;?>');
        localStorage.setItem('posdiscount', '<?=$suspend_sale->order_discount_id;?>');
        localStorage.setItem('poswarehouse', '<?=$suspend_sale->warehouse_id;?>');
        localStorage.setItem('poscustomer', '<?=$suspend_sale->customer_id;?>');
        localStorage.setItem('posbiller', '<?=$suspend_sale->biller_id;?>');
        <?php }
?>
<?php if ($this->input->get('customer')) {?>
        if (!localStorage.getItem('positems')) {
            localStorage.setItem('poscustomer', <?=$this->input->get('customer');?>);
        } else if (!localStorage.getItem('poscustomer')) {
            ///localStorage.setItem('poscustomer', <?=$customer->id;?>);
        }
        <?php } else {?>
        if (!localStorage.getItem('poscustomer')) {
            localStorage.setItem('poscustomer', <?=$customer->id;?>);
        }
        <?php }
?>
        if (!localStorage.getItem('postax2')) {
            localStorage.setItem('postax2', <?=$Settings->default_tax_rate2;?>);
        }
        $('.select').select2({minimumResultsForSearch: 7});
        // var customers = [{
        //     id: <?=$customer->id;?>,
        //     text: '<?=$customer->company == '-' ? $customer->name : $customer->company;?>'
        // }];
        $('#poscustomer').val(localStorage.getItem('poscustomer')).select2({
            minimumInputLength: 1,
            data: [],
            initSelection: function (element, callback) {
                $.ajax({
                    type: "get", async: false,
                    url: "<?=site_url('customers/getCustomer')?>/" + $(element).val(),
                    dataType: "json",
                    success: function (data) {
                        callback(data[0]);
                    }
                });
            },
            ajax: {
                url: site.base_url + "customers/suggestions",
                dataType: 'json',
                quietMillis: 15,
                data: function (term, page) {
                    return {
                        term: term,
                        limit: 10
                    };
                },
                results: function (data, page) {
                    if (data.results != null) {
                        return {results: data.results};
                    } else {
                        return {results: [{id: '', text: 'No Match Found'}]};
                    }
                }
            }
        });
        if (KB) {
            display_keyboards();

            var result = false, sct = '';
            $('#poscustomer').on('select2-opening', function () {
                sct = '';
                $('.select2-input').addClass('kb-text');
                display_keyboards();
                $('.select2-input').bind('change.keyboard', function (e, keyboard, el) {
                    if (el && el.value != '' && el.value.length > 0 && sct != el.value) {
                        sct = el.value;
                    }
                    if(!el && sct.length > 0) {
                        $('.select2-input').addClass('select2-active');
                        $.ajax({
                            type: "get",
                            async: false,
                            url: "<?=site_url('customers/suggestions')?>/" + sct,
                            dataType: "json",
                            success: function (res) {
                                if (res.results != null) {
                                    $('#poscustomer').select2({data: res}).select2('open');
                                    $('.select2-input').removeClass('select2-active');
                                } else {
                                    bootbox.alert('no_match_found');
                                    $('#poscustomer').select2('close');
                                    $('#test').click();
                                }
                            }
                        });
                    }
                });
            });

            $('#poscustomer').on('select2-close', function () {
                $('.select2-input').removeClass('kb-text');
                $('#test').click();
                $('select, .select').select2('destroy');
                $('select, .select').select2({minimumResultsForSearch: 7});
            });
            $(document).bind('click', '#test', function () {
                var kb = $('#test').keyboard().getkeyboard();
                kb.close();
                //kb.destroy();
                $('#add-item').focus();
            });

        }

        $(document).on('change', '#posbiller', function () {
            $('#biller').val($(this).val());
        });

        <?php for ($i = 1; $i <= 5; $i++) {?>
        $('#paymentModal').on('change', '#amount_<?=$i?>', function (e) {
            $('#amount_val_<?=$i?>').val($(this).val());
        });
        $('#paymentModal').on('blur', '#amount_<?=$i?>', function (e) {
            $('#amount_val_<?=$i?>').val($(this).val());
        });
        $('#paymentModal').on('select2-close', '#paid_by_<?=$i?>', function (e) {
            $('#paid_by_val_<?=$i?>').val($(this).val());
        });
        $('#paymentModal').on('change', '#pcc_no_<?=$i?>', function (e) {
            $('#cc_no_val_<?=$i?>').val($(this).val());
        });
        $('#paymentModal').on('change', '#pcc_holder_<?=$i?>', function (e) {
            $('#cc_holder_val_<?=$i?>').val($(this).val());
        });
        $('#paymentModal').on('change', '#gift_card_no_<?=$i?>', function (e) {
            $('#paying_gift_card_no_val_<?=$i?>').val($(this).val());
        });
        $('#paymentModal').on('change', '#pcc_month_<?=$i?>', function (e) {
            $('#cc_month_val_<?=$i?>').val($(this).val());
        });
        $('#paymentModal').on('change', '#pcc_year_<?=$i?>', function (e) {
            $('#cc_year_val_<?=$i?>').val($(this).val());
        });
        $('#paymentModal').on('change', '#pcc_type_<?=$i?>', function (e) {
            $('#cc_type_val_<?=$i?>').val($(this).val());
        });
        $('#paymentModal').on('change', '#pcc_cvv2_<?=$i?>', function (e) {
            $('#cc_cvv2_val_<?=$i?>').val($(this).val());
        });
        $('#paymentModal').on('change', '#cheque_no_<?=$i?>', function (e) {
            $('#cheque_no_val_<?=$i?>').val($(this).val());
        });
        $('#paymentModal').on('change', '#other_tran_no_<?=$i?>', function (e) {
            $('#other_tran_no_val<?=$i?>').val($(this).val());
        });
        $('#paymentModal').on('change', '#cc_transac_no_<?=$i?>', function (e) {

            $('#cc_transac_no_val<?=$i?>').val($(this).val());
        });
        $('#paymentModal').on('change', '#payment_note_<?=$i?>', function (e) {
            $('#payment_note_val_<?=$i?>').val($(this).val());
        });
        <?php }
?>

        $('#payment').click(function () {
            <?php if ($sid) {?>
            suspend = $('<span></span>');
            suspend.html('<input type="hidden" name="delete_id" value="<?php echo $sid; ?>" />');
            suspend.appendTo("#hidesuspend");
            <?php }
?>
            var twt = formatDecimal((total + invoice_tax) - order_discount);
            if (count == 1) {
                bootbox.alert('<?=lang('x_total');?>');
                return false;
            }
            gtotal = formatDecimal(twt);
            <?php if ($pos_settings->rounding) {?>
            round_total = roundNumber(gtotal, <?=$pos_settings->rounding?>);
            //$('#amount_1').val(round_total);
            $('#amount_1').val(0);
            var rounding = formatDecimal(0 - (gtotal - round_total));
            $('#twt').text(formatMoney(round_total) + ' (' + formatMoney(rounding) + ')');
            $('#quick-payable').text(round_total);
            <?php } else {?>
            $('#twt').text(formatMoney(gtotal));
            $('#quick-payable').text(gtotal);
            $payment_det = $('.card').val();

            if($payment_det == "cash"){$('#amount_1').val(0);}
            else{$('#amount_1').val(gtotal);}

            // $('#amount_1').val(gtotal);
            //$('#amount_1').val(0);
            <?php }
?>
            $('#item_count').text(count - 1);
            $('#paymentModal').appendTo("body").modal('show');
            $('#amount_1').focus();
            $('#payModalLabel').focus();

            //alert(jQuery('button#quick-payable').html());
            //$('#clear-cash-notes').trigger('click');
            //$('#quick-payable').trigger('click');
        });
        $('#paymentModal').on('show.bs.modal', function(e) {
            $('#submit-sale').attr('disabled', false);
        });
        $('#paymentModal').on('shown.bs.modal', function(e) {
            //$('#amount_1').prop('readonly','readonly');
            $('input#s2id_autogen4_search').prop('readonly','readonly');
            $('#amount_1').focus();
            //$('#amount_1').focusout()
            //alert('here');
            //alert($('.radio-div').trigger('click'));

            //$('#payModalLabel').focus();
        });
        var pi = 'amount_1', pa = 2;
        $(document).on('click', '.quick-cash', function () {
            var $quick_cash = $(this);
            var amt = $quick_cash.contents().filter(function () {
                return this.nodeType == 3;
            }).text();
            var th = ',';
            var $pi = $('#' + pi);
            amt = formatDecimal(amt.split(th).join("")) * 1 + $pi.val() * 1;
            $pi.val(formatDecimal(amt)).focus();
            var note_count = $quick_cash.find('span');
            if (note_count.length == 0) {
                $quick_cash.append('<span class="badge">1</span>');
            } else {
                note_count.text(parseInt(note_count.text()) + 1);
            }
        });

        $(document).on('click', '#clear-cash-notes', function () {
            $('.quick-cash').find('.badge').remove();
            $('#' + pi).val('0').focus();
            //$('#balance').text('0').focus();
        });

        $(document).on('change', '.gift_card_no', function () {
            var cn = $(this).val() ? $(this).val() : '';
            var payid = $(this).attr('id');

                id = payid.substr(payid.length - 1);
            if (cn != '' && payid=='gift_card_no_1') {
                $.ajax({
                    type: "get", async: false,
                    url: site.base_url + "sales/validate_gift_card/" + cn,
                    dataType: "json",
                    success: function (data) {
                        if (data === false) {
                            $('#gift_card_no_' + id).parent('.form-group').addClass('has-error');
                            bootbox.alert('<?=lang('incorrect_gift_card')?>');


                        } else if (data.customer_id !== null && data.customer_id !== $('#poscustomer').val()) {
                            $('#gift_card_no_' + id).parent('.form-group').addClass('has-error');
                            bootbox.alert('<?=lang('gift_card_not_for_customer')?>');
                            location.reload();
                            return false;
                        } else {
                            $('#gc_details_' + id).html('<small>Card No: ' + data.card_no + '<br>Value: ' + data.value + ' - Balance: ' + data.balance + '</small>');
                            $('#gift_card_no_' + id).parent('.form-group').removeClass('has-error');
                            //calculateTotals();
                            $('#amount_' + id).val(gtotal >= data.balance ? data.balance : gtotal).focus();
                        }
                    }
                });
            }

        });

        $(document).on('click', '.addButton', function () {
            if (pa <= 5) {
                $('#paid_by_1, #pcc_type_1').select2('destroy');
                var phtml = $('#payments').html(),
                    update_html = phtml.replace(/_1/g, '_' + pa);
                pi = 'amount_' + pa;
                $('#multi-payment').append('<button type="button" class="close close-payment" style="margin: -10px 0px 0 0;"><i class="fa fa-2x">&times;</i></button>' + update_html);
                $('#paid_by_1, #pcc_type_1, #paid_by_' + pa + ', #pcc_type_' + pa).select2({minimumResultsForSearch: 7});
                read_card();
                pa++;
            } else {
                bootbox.alert('<?=lang('max_reached')?>');
                return false;
            }
            display_keyboards();
            $('#paymentModal').css('overflow-y', 'scroll');
        });

        $(document).on('click', '.close-payment', function () {
            $(this).next().remove();
            $(this).remove();
            pa--;
        });

        $(document).on('focus', '.amount', function () {
            pi = $(this).attr('id');
            calculateTotals();
        }).on('blur', '.amount', function () {
            calculateTotals();
        });

    function calculateTotals() {
            var total_paying = 0;
            var ia = $(".amount");
            $.each(ia, function (i) {
                var this_amount = formatCNum($(this).val() ? $(this).val() : 0);
                total_paying += parseFloat(this_amount);
            });
            $('#total_paying').text(formatMoney(total_paying));
            <?php if ($pos_settings->rounding) {?>
            $('#balance').text(formatMoney(total_paying - round_total));
            $('#balance_' + pi).val(formatDecimal(total_paying - round_total));
            total_paid = total_paying;
            grand_total = round_total;
            <?php } else {?>
            $('#balance').text(formatNumber(total_paying - gtotal));
           $('#balance_' + pi).val(formatDecimal(total_paying - gtotal));
            total_paid = total_paying;
            grand_total = gtotal;
            <?php }
?>
        }

        $("#add_item").autocomplete({
            source: function (request, response) {
                if (!$('#poscustomer').val()) {
                    $('#add_item').val('').removeClass('ui-autocomplete-loading');
                    bootbox.alert('<?=lang('select_above');?>');
                    //response('');
                    $('#add_item').focus();
                    return false;
                }
                $.ajax({
                    type: 'get',
                    url: '<?=site_url('sales/suggestions');?>',
                    dataType: "json",
                    data: {
                        term: request.term,
                        warehouse_id: $("#poswarehouse").val(),
                        customer_id: $("#poscustomer").val()
                    },
                    beforeSend: function () {
                        return true;
                    },
                    success: function (data) {
                        response(data);
                    }
                });
            },
            minLength: 1,
            autoFocus: false,
            delay: 250,
            response: function (event, ui) {
                if ($(this).val().length >= 16 && ui.content[0].id == 0) {
                    bootbox.alert('<?=lang('no_match_found')?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).val('');
                }
                else if (ui.content.length == 1 && ui.content[0].id != 0) {
                    ui.item = ui.content[0];
                    $(this).data('ui-autocomplete')._trigger('select', 'autocompleteselect', ui);
                    $(this).autocomplete('close');
                }
                else if (ui.content.length == 1 && ui.content[0].id == 0) {
                    bootbox.alert('<?=lang('no_match_found')?>', function () {
                        $('#add_item').focus();
                    });
                    $(this).val('');

                }
            },
            select: function (event, ui) {
                event.preventDefault();
                if(ui.item.options){
                   console.log(ui.item);

                   var product_options = '';
                    product_options = "" +

                        "<div class=''>" +
                        "<label class=\"col-sm-4 control-label\"><?=lang('product_option')?></label>" +
                        "<div class='col-sm-8'><select class='form-control option_id'  name='option_id' >";
                    $.each(ui.item.options, function( index, element ) {
                        product_options +="<option value='"+element.id+"'>";
                        product_options +=element.name;
                        product_options +="</option>";
                    });

                    product_options +="</select></div><div style='clear:both'></div></div>";
                    product_options +="<input type='hidden' class='product_item_id' name='product_item_id' value='"+ui.item.row.id+"' >" ;
                    product_options +="<input type='hidden' class='product_term' name='product_term' value='"+ui.item.row.code+"' >" ;
                    //$('#modal-loading').show();
                    $('.modalvarient').find('.modal-title').html(ui.item.row.name);
                    $('.modalvarient').find('.modal-body').empty();
                    $('.modalvarient').find('.modal-body').append(product_options);
                    $('.modalvarient').show();
                    $(this).val('');
                    return true;
                }

                if (ui.item.id !== 0) {
                    var row = add_invoice_item(ui.item);
                    if (row)
                        $(this).val('');
                } else {
                    bootbox.alert('<?=lang('no_match_found')?>');
                }
            }
        });

        <?php if ($pos_settings->tooltips) {echo '$(".pos-tip").tooltip();';}
?>
        // $('#posTable').stickyTableHeaders({fixedOffset: $('#product-list')});
        $('#posTable').stickyTableHeaders({scrollableArea: $('#product-list')});
        $('#product-list, #category-list, #subcategory-list, #brands-list, #amnt').perfectScrollbar({suppressScrollX: true});
        $('select, .select').select2({minimumResultsForSearch: 7});

        $(document).on('click', '.product', function (e) {

        $('#modal-loading').hide();
            code = $(this).val(),
                wh = $('#poswarehouse').val(),
                cu = $('#poscustomer').val();
            $.ajax({
                type: "get",
                url: "<?=site_url('pos/getProductDataByCode')?>",
                data: {code: code, warehouse_id: wh, customer_id: cu},
                dataType: "json",
                success: function (data) {

                    e.preventDefault();
                    if (data !== null) {

                        add_invoice_item(data);
                        $('#modal-loading').hide();
                    } else {
                        bootbox.alert('<?=lang('no_match_found')?>');
                        $('#modal-loading').hide();
                    }
                },
                fail: function (e){

                }
            });
        });

        $(document).on('click', '.category', function () {
            $('#previous1').addClass('hidden');
            $('#next1').addClass('hidden');
            $('#previous').removeClass('hidden');
            $('#next').removeClass('hidden');
            if (cat_id != $(this).val()) {
                $('#open-category').click();
                $('#modal-loading').show();
                cat_id = $(this).val();
                $.ajax({
                    type: "get",
                    url: "<?=site_url('pos/ajaxcategorydata');?>",
                    data: {category_id: cat_id},
                    dataType: "json",
                    success: function (data) {
                        $('#item-list').empty();
                        var newPrs = $('<div></div>');
                        newPrs.html(data.products);
                        newPrs.appendTo("#item-list");
                        $('#subcategory-list').empty();
                        var newScs = $('<div></div>');
                        newScs.html(data.subcategories);
                        newScs.appendTo("#subcategory-list");
                        tcp = data.tcp;
                        nav_pointer();
                    }
                }).done(function () {
                    p_page = 'n';
                    $('#category-' + cat_id).addClass('active');
                    $('#category-' + ocat_id).removeClass('active');
                    ocat_id = cat_id;
                    $('#modal-loading').hide();
                    nav_pointer();
                });
            }
        });
        $('#category-' + cat_id).addClass('active');

        $(document).on('click', '.brand', function () {

            $('#previous1').addClass('hidden');
            $('#next1').addClass('hidden');
            $('#previous').removeClass('hidden');
            $('#next').removeClass('hidden');

            if (brand_id != $(this).val()) {
                $('#open-brands').click();
                $('#modal-loading').show();
                brand_id = $(this).val();
                $.ajax({
                    type: "get",
                    url: "<?=site_url('pos/ajaxbranddata');?>",
                    data: {brand_id: brand_id},
                    dataType: "json",
                    success: function (data) {
                        $('#item-list').empty();
                        var newPrs = $('<div></div>');
                        newPrs.html(data.products);
                        newPrs.appendTo("#item-list");
                        tcp = data.tcp;
                        nav_pointer();
                    }
                }).done(function () {
                    p_page = 'n';
                    $('#brand-' + brand_id).addClass('active');
                    $('#brand-' + obrand_id).removeClass('active');
                    obrand_id = brand_id;
                    $('#category-' + cat_id).removeClass('active');
                    $('#subcategory-' + sub_cat_id).removeClass('active');
                    cat_id = 0; sub_cat_id = 0;
                    $('#modal-loading').hide();
                    nav_pointer();
                });
            }
        });

        $(document).on('click', '.subcategory', function () {
            $('#previous1').addClass('hidden');
            $('#next1').addClass('hidden');
            $('#previous').removeClass('hidden');
            $('#next').removeClass('hidden');

            if (sub_cat_id != $(this).val()) {
                $('#open-subcategory').click();
                $('#modal-loading').show();
                sub_cat_id = $(this).val();
                $.ajax({
                    type: "get",
                    url: "<?=site_url('pos/ajaxproducts');?>",
                    data: {category_id: cat_id, subcategory_id: sub_cat_id, per_page: p_page},
                    dataType: "html",
                    success: function (data) {
                        $('#item-list').empty();
                        var newPrs = $('<div></div>');
                        newPrs.html(data);
                        newPrs.appendTo("#item-list");
                    }
                }).done(function () {
                    p_page = 'n';
                    $('#subcategory-' + sub_cat_id).addClass('active');
                    $('#subcategory-' + osub_cat_id).removeClass('active');
                    $('#modal-loading').hide();
                });
            }
        });
$( document ).ready(function() {
    $('#next').click(function () {
            if (p_page == 'n') {
                p_page = 0
            }
            p_page = p_page + pro_limit;
            console.log(tcp +'>='+ pro_limit +'|'+ p_page+' < '+tcp);
            if (tcp >= pro_limit && p_page < tcp) {
                $('#modal-loading').show();
                $.ajax({
                    type: "get",
                    url: "<?=site_url('pos/ajaxproducts');?>",
                    data: {category_id: cat_id, subcategory_id: sub_cat_id, per_page: p_page},
                    dataType: "html",
                    success: function (data) {
                        $('#item-list').empty();
                        var newPrs = $('<div></div>');
                        newPrs.html(data);
                        newPrs.appendTo("#item-list");
                        nav_pointer();
                    }
                }).done(function () {
                    $('#modal-loading').hide();
                });
            } else {
                p_page = p_page - pro_limit;
            }
        });

        $('#previous').click(function () {
            if (p_page == 'n') {
                p_page = 0;
            }
            if (p_page != 0) {
                $('#modal-loading').show();
                p_page = p_page - pro_limit;
                if (p_page == 0) {
                    p_page = 'n'
                }
                $.ajax({
                    type: "get",
                    url: "<?=site_url('pos/ajaxproducts');?>",
                    data: {category_id: cat_id, subcategory_id: sub_cat_id, per_page: p_page},
                    dataType: "html",
                    success: function (data) {
                        $('#item-list').empty();
                        var newPrs = $('<div></div>');
                        newPrs.html(data);
                        newPrs.appendTo("#item-list");
                        nav_pointer();
                    }

                }).done(function () {
                    $('#modal-loading').hide();
                });
            }
        });
myFunction();
});

function loadItemLoop(){
loadItems();
myFunction();
}
function myFunction() {

    setTimeout(function(){  loadItemLoop(); }, 500);


}
        $(document).on('change', '.paid_by', function () {
            var p_val = $(this).val(),
                id = $(this).attr('id'),
                pa_no = id.substr(id.length - 1);
            $('#rpaidby').val(p_val);
            if (p_val == 'cash') {
                $('.pcheque_' + pa_no).hide();
                $('.pcc_' + pa_no).hide();
                 $('.pother_' + pa_no).hide();
                $('.pcash_' + pa_no).show();
                $('#payment_note_' + pa_no).focus();
            } else if (p_val == 'CC' || p_val == 'DC' || p_val == 'stripe' || p_val == 'ppp' || p_val == 'authorize') {
                $('.pcheque_' + pa_no).hide();
                $('.pcash_' + pa_no).hide();
                $('.pother_' + pa_no).hide();
                $('.pcc_' + pa_no).show();
                $('#swipe_' + pa_no).focus();
            } else if (p_val == 'Cheque') {
                $('.pcc_' + pa_no).hide();
                $('.pcash_' + pa_no).hide();
                  $('.pother_' + pa_no).hide();
                $('.pcheque_' + pa_no).show();
                $('#cheque_no_' + pa_no).focus();
            } else if (p_val == 'other') {
                $('.pcc_' + pa_no).hide();
                $('.pcash_' + pa_no).hide();
                $('.pcheque_' + pa_no).hide();

                $('.pother_' + pa_no).show();
                $('#other_tran_no_' + pa_no).focus();
            }

            else {
                $('.pcheque_' + pa_no).hide();
                $('.pcc_' + pa_no).hide();
                $('.pcash_' + pa_no).hide();
                $('.pother_' + pa_no).hide();
            }
            if (p_val == 'gift_card') {
                $('.gc_' + pa_no).show();
                $('.ngc_' + pa_no).hide();
                $('#gift_card_no_' + pa_no).focus();
            } else {
                $('.ngc_' + pa_no).show();
                $('.gc_' + pa_no).hide();
                $('#gc_details_' + pa_no).html('');
            }
        });

        $(document).on('click', '#submit-sale', function (e) {

                var payid1 =   $('#paid_by_1').val();
                 var _self = $(this);
                <?php if ($is_pharma): ?>
                        var patient_name =   $('#patient_name').val();
                        if(patient_name==''){
                            patient_name ='-';
                           // bootbox.alert('Please enter Patient name.');
                           // return false;
                        }
                        var doctor_name =   $('#doctor_name').val();
                        if(doctor_name==''){
                            doctor_name = '-';
                           // bootbox.alert('Please enter Doctor name.');
                          //  return false;
                        }
                        $('#patient_name1').val(patient_name);
                        $('#doctor_name1').val(doctor_name);
                <?php endif;?>
                //--------------------- validation  For Cheque--------------//
                if(payid1=='Cheque'){
                 var cheque   =   $('#cheque_no_1').val();
                    if(cheque.trim()==''){
                        bootbox.alert('Please enter cheque number.');
                        return false;
                    }
                    if(cheque.length !=6){
                        bootbox.alert('Please enter valid cheque number.');
                        return false;
                    }
                }
                //------------------ validation  For Cheque End--------------//

                 //--------------------- validation  For Cheque--------------//
                if(payid1=='other'){
                 var other_tran_no_1   =   $('#other_tran_no_1').val();
                    if(other_tran_no_1.trim()==''){
                        bootbox.alert('Please enter Transaction No.');
                        return false;
                    }
                }
                //------------------ validation  For Cheque End--------------//

            if (total_paid == 0 || total_paid < grand_total) {
                bootbox.confirm("<?=lang('paid_l_t_payable');?>", function (res) {
                    if (res == true) {
                        $('#pos_note').val(localStorage.getItem('posnote'));
                        $('#staff_note').val(localStorage.getItem('staffnote'));
                        $('#submit-sale').text('<?=lang('loading');?>').attr('disabled', true);

                        //$('#pos-sale-form').submit();
//return false;
//alert($(this).prop('name'));
                if(_self.prop('name') == 'cmd'){
                    var form = $('#pos-sale-form');
                 $.ajax({
                     type: form.attr('method'),
                     url: form.attr('action'),
                     data: form.serialize()
                 }).done(function(data) {
                     location.reload();
                     // Optionally alert the user of success here...
                 }).fail(function(data) {
                     alert('failed');
                 });
                }else{
                    $('#pos-sale-form').submit();
                }

                    }
                });
                return false;
            } else {
                var paid_by = $('#paid_by_val_1').val();
                if(paid_by=='CC' || paid_by=='DC' || paid_by=='ppp' || paid_by=='stripe' || paid_by=='authorize'){
                    var cc_transac_no = $('#cc_transac_no_1').val().trim();
                    var cc_payment_other = $('#cc_payment_other').val().trim();
                    if(cc_transac_no==''){
                        bootbox.alert('Please Enter Card Transaction No.');
                        $('#cc_transac_no').parent().addClass('has-error');
                        $('#cc_transac_no').focus();
                        return false;
                    } else {
                        $('#cc_transac_no_1').val(cc_transac_no);
                        $('#payment_note_val_1').val(cc_payment_other);
                    }

                 /*   var pcc_no_1= $('#pcc_no_1').val().trim();
                    if(pcc_no_1==''){
                        bootbox.alert('Please Enter Card No.');
                        $('#pcc_no_1').parent().addClass('has-error');
                        $('#pcc_no_1').focus();
                        return false;
                    }
                    var pcc_holder_1 = $('#pcc_holder_1').val().trim();
                    if(pcc_holder_1==''){
                        bootbox.alert('Please Enter Card Holder Name.');
                        $('#pcc_holder_1').parent().addClass('has-error');
                        $('#pcc_holder_1').focus();
                        return false;
                    }
                    var pcc_month_1 = $('#pcc_month_1').val().trim();
                    if(pcc_month_1==''){
                        bootbox.alert('Please Enter Card Exp. Mont');
                        $('#pcc_month_1').parent().addClass('has-error');
                        $('#pcc_month_1').focus();
                        return false;
                    }
                    var cc_year = $('#pcc_year_1').val().trim();
                    if(cc_year==''){
                        bootbox.alert('Please Enter Card Exp. Year ');
                        $('#pcc_year_1').parent().addClass('has-error');
                        $('#pcc_year_1').focus();
                        return false;
                    }else{
                        if(!validYear($('#pcc_year_1').val())){
                            bootbox.alert('Please Enter Valid Card Exp. Year ');
                            $('#pcc_year_1').parent().addClass('has-error');
                            $('#pcc_year_1').focus();
                            return false;
                        }
                    }*/
                    /*
                    var pcc_cvv2  = $('#pcc_cvv2_1').val().trim();
                    if(pcc_cvv2==''){
                        bootbox.alert('Please Enter CVV No.');
                        $('#pcc_cvv2_1').parent().addClass('has-error');
                        $('#pcc_cvv2_1').focus();
                        return false;
                    }else{
                        if(!validCVV($('#pcc_cvv2_1').val())){
                            bootbox.alert('Please Enter Valid CVV ');
                            $('#pcc_cvv2_1').parent().addClass('has-error');
                            $('#pcc_cvv2_1').focus();
                            return false;
                        }
                    }*/
                }
                if(paid_by=='Cheque'){
                 var cheque_no_1 = $('#cheque_no_1').val().trim();
                    if(cheque_no_1==''){
                        bootbox.alert('Please Enter Cheque No.');
                        $('#cheque_no_1').parent().addClass('has-error');
                        $('#cheque_no_1').focus();
                        return false;
                    }
                }

               if(paid_by=='gift_card'){
                 var gift_card_no_1 = $('#gift_card_no_1').val().trim();
                    if(gift_card_no_1==''){
                        bootbox.alert('Please Enter Gift Card');
                        $('#gift_card_no_1').parent().addClass('has-error');
                        $('#gift_card_no_1').focus();
                        return false;
                    }
                }

                $('#pos_note').val(localStorage.getItem('posnote'));
                $('#staff_note').val(localStorage.getItem('staffnote'));
                $(this).text('<?=lang('loading');?>').attr('disabled', true);
                //$('#pos-sale-form').submit();

//alert($(this).prop('name'))
                //return false;
                if($(this).prop('name') == 'cmd'){
                    var form = $('#pos-sale-form');
                 $.ajax({
                     type: form.attr('method'),
                     url: form.attr('action'),
                     data: form.serialize()
                 }).done(function(data) {
                     location.reload();
                     // Optionally alert the user of success here...
                 }).fail(function(data) {
                     alert('failed');
                 });
                }else{
                    $('#pos-sale-form').submit();
                }

            }
        });
        $('#suspend').click(function () {
            if (count <= 1) {
                bootbox.alert('<?=lang('x_suspend');?>');
                return false;
            } else {
                $('#susModal').modal();
            }
        });
        $('#suspend_sale').click(function () {
            ref = $('#reference_note').val();

            if (!ref || ref == '') {
                bootbox.alert('<?=lang('type_reference_note');?>');
                return false;
            } else {
                suspend = $('<span></span>');
                <?php if ($sid) {?>
                suspend.html('<input type="hidden" name="delete_id" value="<?php echo $sid; ?>" /><input type="hidden" name="suspend" value="yes" /><input type="hidden" name="suspend_note" value="' + ref + '" />');
                <?php } else {?>
                suspend.html('<input type="hidden" name="suspend" value="yes" /><input type="hidden" name="suspend_note" value="' + ref + '" />');
                <?php }
?>
                suspend.appendTo("#hidesuspend");
                $('#total_items').val(count - 1);
                $('#pos-sale-form').submit();

            }
        });
    });

var printing_pos = {
        print:function(data,action){
            var mywindow = window.open('', 'sma_pos_print', 'height=500,width=300');
            mywindow.document.write('<html><head><title>Print</title><style>@media screen,print {    .btn { display:none }  }</style>');
            mywindow.document.write('<link rel="stylesheet" href="<?=$assets?>styles/helpers/bootstrap.min.css" type="text/css" />');
            mywindow.document.write('</head><body >');
            mywindow.document.write(data);
            //mywindow.document.write('<script>'+'  setTimeout(function(){ window.print(); window.close();this.checkChild(); /**/ }, 100); </'+'script>');
            mywindow.document.write('</body></html>');

            //setTimeout(function() {
                mywindow.print();
               mywindow.close();
                if(action == 'kot'){
                   this.checkChild();
                }
            //},100);

        },
        checkChild:function(){
            $("#suspend_sale").trigger('click');
            $('.kot_tbl').empty();
        }
    };
    $(".print_kot").click(function(){
        $('.kot_tbl').html($('#order_tbl').html());
        var kot_tbl_head_title = $('#reference_note').val();
        $('.kot_tbl').find('h4').html(kot_tbl_head_title);
        console.log($('.kot_tbl').html());
        //Popup($('.kot_tbl').html());
        printing_pos.print($('.kot_tbl').html(),'kot')
    });

    <?php if ($pos_settings->java_applet) {?>
    $(document).ready(function () {
        $('#print_order').click(function () {
            console.log(order_data)
            printBill(order_data);
        });
        $('#print_bill').click(function () {
            printBill(bill_data);
        });
    });
    <?php } else {?>
    $(document).ready(function () {
        $('#print_order').click(function () {
            Popup($('#order_tbl').html());
        });
        $('#print_bill').click(function () {
            console.log($('#bill_tbl').html());
            Popup($('#bill_tbl').html());
        });
    });
    <?php }
?>
    $(function () {
        $(".alert").effect("shake");
        setTimeout(function () {
            $(".alert").hide('blind', {}, 500)
        }, 15000);
        <?php if ($pos_settings->display_time) {?>
        var now = new moment();
        $('#display_time').text(now.format((site.dateFormats.js_sdate).toUpperCase() + " HH:mm"));
        setInterval(function () {
            var now = new moment();
            $('#display_time').text(now.format((site.dateFormats.js_sdate).toUpperCase() + " HH:mm"));
        }, 1000);
        <?php }
?>
    });
    <?php if (!$pos_settings->java_applet) {?>
        function Popup(data) {
        var mywindow = window.open('', 'sma_pos_print', 'height=500,width=300');
        mywindow.document.write('<html><head><title>Print</title><style>@media screen,print {    .btn { display:none }  }</style>');
        mywindow.document.write('<link rel="stylesheet" href="<?=$assets?>styles/helpers/bootstrap.min.css" type="text/css" />');
        mywindow.document.write('</head><body >');
        mywindow.document.write(data);
        mywindow.document.write('<script>'+'  setTimeout(function(){ window.print();window.close();/**/ }, 100); </'+'script>');
        mywindow.document.write('</body></html>');
    //    mywindow.print();
    //    mywindow.close();
        return false;
    }
    <?php }
?>
</script>
<?php
$s2_lang_file = read_file('./assets/config_dumps/s2_lang.js');
foreach (lang('select2_lang') as $s2_key => $s2_line) {
    $s2_data[$s2_key] = str_replace(array('{', '}'), array('"+', '+"'), $s2_line);
}
$s2_file_date = $this->parser->parse_string($s2_lang_file, $s2_data, true);
?>
<script type="text/javascript" src="<?=$assets?>js/bootstrap.min.js"></script>
<script type="text/javascript" src="<?=$assets?>js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?=$assets?>js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="<?=$assets?>js/select2.min.js"></script>
<script type="text/javascript" src="<?=$assets?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?=$assets?>js/custom.js"></script>
<script type="text/javascript" src="<?=$assets?>js/jquery.calculator.min.js"></script>
<script type="text/javascript" src="<?=$assets?>js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="<?=$assets?>pos/js/plugins.min.js"></script>
<script type="text/javascript" src="<?=$assets?>pos/js/parse-track-data.js"></script>
<script type="text/javascript" src="<?=$assets?>pos/js/pos.ajax.js"></script>
<?php if ($pos_settings->java_applet) {
    ?>
    <script type="text/javascript" src="<?=$assets?>pos/qz/js/deployJava.js"></script>
    <script type="text/javascript" src="<?=$assets?>pos/qz/qz-functions.js"></script>
    <script type="text/javascript">
        deployQZ('themes/<?=$Settings->theme?>/assets/pos/qz/qz-print.jar', '<?=$assets?>pos/qz/qz-print_jnlp.jnlp');
        function printBill(bill) {
            usePrinter("<?=$pos_settings->receipt_printer;?>");
            printData(bill);
        }
        <?php
$printers = json_encode(explode('|', $pos_settings->pos_printers));
    echo $printers . ';';
    ?>
        function printOrder(order) {
            for (index = 0; index < printers.length; index++) {
                usePrinter(printers[index]);
                printData(order);
            }
        }
    </script>

<?php }
?>

<script type="text/javascript">
 function paynear_mobile_app(){
       $('#paynear_mobile_app').val(1);
       $('#paynear_btn_holder').css("display",'none');
       $('#paynear_btn_app_holder').css("display",'block');
       //alert('IN MOBILE APP');
 }

$('.sortable_table tbody').sortable({
    containerSelector: 'tr'
});


function cardDetails(cart_no,card_name,card_month,card_year,card_cvv,txt){
    txt = GetCardType(cart_no);
    //alert(txt);
    jQuery('#cardNo').html(cart_no);
    //1234-XXXX-XXXX-1234
   jQuery('#pcc_no_1').val(cart_no);
   jQuery('#pcc_no_1').hide();
   jQuery('#pcc_holder_1').val(card_name);
   jQuery('#pcc_holder_1').hide();
   jQuery('#pcc_month_1').val(card_month);
   jQuery('#pcc_month_1').hide();
   jQuery('#pcc_year_1').val(card_year);
   jQuery('#pcc_year_1').hide();
   jQuery('#swipe_1').hide();

    var str =jQuery('#cardNo').html();
    str1 = str.split("");
    var card_split = str1[0] + '' + str1[1]+ '' + str1[2]+ '' + str1[3]+ '-XXXX-XXXX-' + str1[12] + '' + str1[13]+ '' + str1[14]+ '' + str1[15];
    jQuery('#cardNo').html(card_split);

    var ctype = jQuery('#cardty').html(txt);
    jQuery('#pcc_type_1 option[value=ctype]').attr('selected','selected');
    jQuery('#s2id_pcc_type_1').val(txt);
    jQuery('#s2id_pcc_type_1').hide();

    jQuery("#pcc_cvv2_1").css("margin-top", "-65px");
}

function GetCardType(number){
            var re = new RegExp("^4");
            if (number.match(re) != null){
                return "Visa";
            }
            re = new RegExp("^(34|37)");
            if (number.match(re) != null){
                return "American Express";
            }
            re = new RegExp("^5[1-5]");
            if (number.match(re) != null){
                return "MasterCard";
            }
            re = new RegExp("^6011");
            if (number.match(re) != null){
                return "Discover";
            }
            return "unknown";
}

function getQRCode(fullURL){
    param = fullURL.split('/');
    addItemTest(param[param.length-1]);
}
//getQRCode('http://dev.greatwebsoft.co.in/pos1/products/view/16');

function actQRCam(){
    window.MyHandler.activateQRCam(true);
    return false;
}

$(document).ready(function(){
$('#custname').val($("input[name=customer]").val());
$('#custname').prop('name','customer');
 $('#custsearch').val($('#poswarehouse').val());
 $('#custsearch').prop('name','warehouse');

    //var v = $('#poscustomer').val();
     $('#poscustomer').change(function () { $('#custname').val(jQuery('#poscustomer').val()); });
     $('#poswarehouse').change(function () { $('#custsearch').val(jQuery('#poswarehouse').val()); });


 });

 /*------------------ Payment Icon Button  updated on 21012017 BY SW------------------*/
 $(document).ready(function(){
    $('.custom_payment_icon').click(function(){
    var custom_payment_value  = $(this).val() ;

    $('select#paid_by_1.paid_by').val(custom_payment_value).change();
    $('#paid_by_val_1').val(custom_payment_value);

   if(custom_payment_value!='cash' && $('#amount_1').val()=='0' ){
       $('#quick-payable').click();
    }
    if(custom_payment_value=='paynear'){

        if($('#paynear_mobile_app').val()=='1'){
            paynear_opt = $(this).attr('data-value') ;
            $('#paynear_mobile_app_type').val(paynear_opt);
        }

        $('#amount_val_1').val(gtotal);
        setTimeout(function(){ jQuery('button#submit-sale.btn.btn-block.btn-lg.btn-primary.cmdprint1').trigger('click'); }, 100);

    }
    else if(custom_payment_value==  'instamojo'  || custom_payment_value==  'ccavenue' || custom_payment_value ==  'payumoney'){
        $('#amount_val_1').val(gtotal);
        setTimeout(function(){ jQuery('button#submit-sale.btn.btn-block.btn-lg.btn-primary.cmdprint1').trigger('click'); }, 100);
    }


        $('#amount_1').focus();
 });
    $('#add_item').blur();

});

 /*------------------ setting button  type in hidden  updated on 21012017 BY SW------------------*/
 jQuery('.cmdprint').on('click', function() {
     jQuery('#submit_type').val('print');
 });

 jQuery('.cmdprint1').on('click', function() {
     jQuery('#submit_type').val('notprint_notredirect');
 });

 jQuery('.cmdnotprint').on('click', function() {
     jQuery('#submit_type').val('notprint');
 });

  /*___________  End ___________________ */
 jQuery('#add_item').on('focus', function() {
// alert('test');
    $('#custname').val(jQuery('#poscustomer').val());
    $('#custname').prop('name','customer');
     $('#custsearch').val($('#poswarehouse :selected').val());
 $('#custsearch').prop('name','warehouse');
});

 function setCustomerName(valu){
     $('#custname').val(valu);
     $('#custname').prop('name','customer');
 }



function addItemTest(itemId){
        $('#modal-loading').show();
            var code;
            $.ajax({
                type: "get", //base_url("index.php/admin/do_search")
                url: "<?=site_url('pos/getProductByID')?>",
                data: {id: itemId},
                dataType: "json",
                success: function (data) {
                    code = data.code;
                    code = code,
                    wh = $('#poswarehouse').val(),
                    cu = $('#poscustomer').val();
                    $.ajax({
                        type: "get",
                        url: "<?=site_url('pos/getProductDataByCode')?>",
                        data: {code: code, warehouse_id: wh, customer_id: cu},
                        dataType: "json",
                        success: function (data) {
                            if (data !== null) {
                                add_invoice_item(data);
                                $('#modal-loading').hide();
                            } else {
                                bootbox.alert('<?=lang('no_match_found')?>');
                                $('#modal-loading').hide();
                            }
                        }
                    });
                }
            });

}

    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : event.keyCode
        if (charCode > 31 && (charCode < 48 || charCode > 57)){
            return false;
        }
        else{
            return true;
        }
    }
        function validCVV(cvv) {
            var re = /^[0-9]{3,4}$/;
            return re.test(cvv);
        }
        function validYear(year) {
            var re = /^(19|20)\d{2}$/;
            return re.test(year);
        }

</script>
<script type="text/javascript" charset="UTF-8"><?=$s2_file_date?></script>
<div id="ajaxCall"><i class="fa fa-spinner fa-pulse"></i></div>
<?php
if (isset($_REQUEST['test'])) {
    $errorUrl = "http://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI];
    $logger = array('Testing error view', $errorUrl);
    $this->sma->pos_error_log($logger);
}
?>
<script>
$(document).ready(function(){

    $(document).ready(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

//$("#s2id_autogen8_search").prop('disabled', 'true');

//quick sales start//
    var pname_mi = 'Miscellaneous Item';
    var pname_sc = 'Service Charges';
    var pname_tc = 'Transportation Charges';
    var qty = 1;
    $("#pname").hide();
    $('#mitems').click(function() {
        $("#pname").show();
        $('#mname').val(pname_mi);
        $('#mquantity').val(qty);
        $('#mname').focus();
        $('#mquantity').focus();
        $('#mprice').focus();
    });

    $('#scharges').click(function() {
        $("#pname").show();
        $('#mname').val(pname_sc);
        $('#mquantity').val(qty);
        $('#mname').focus();
        $('#mquantity').focus();
        $('#mprice').focus();
    });

    $('#tcharges').click(function() {
        $("#pname").show();
        $('#mname').val(pname_tc);
        $('#mquantity').val(qty);
        $('#mname').focus();
        $('#mquantity').focus();
        $('#mprice').focus();
    });

    $('#other').click(function() {
        $("#pname").show();
        $('#mname').val("");
        $('#mquantity').val(qty);
        $('#mname').focus();
        $('#mquantity').focus();
        $('#mprice').focus();
    });
//quick sales end//


})
function Rfid(){

    $.get( 'https://simplypos.in/api/rfid/?get=<?php echo site_url(); ?>', function( data ) {
        data3 = data.split(':');
        $.each(data3, function( index, value ) {
          data4 = value.split('A');
          addItemByProductCode(data4[1]);
        });
    });
}

function addItemByProductCode(code){


        code = code,
                wh = $('#poswarehouse').val(),
                cu = $('#poscustomer').val();
                $.ajax({
                        type: "get",
                        url: "<?=site_url('pos/getProductDataByCode')?>",
                        data: {code: code, warehouse_id: wh, customer_id: cu},
                        dataType: "json",
                        success: function (data) {
                                if (data !== null) {
                                        add_invoice_item(data);
                                        $('#modal-loading').hide();
                                } else {
                                        bootbox.alert('<?=lang('no_match_found')?>');
                                        $('#modal-loading').hide();
                                }
                        }
                });
}

               var specialKeys = new Array();
        function IsNumeric(e) {
            var keyCode = e.which ? e.which : e.keyCode
            var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
            document.getElementById("error").style.display = ret ? "none" : "inline";
            return ret;
        }
</script>
<script>
    $(document).ready(function () {
        $("input[type='radio']").on('change', function () {
            var selectedValue = $("input[name='gender']:checked").val();
            if (selectedValue) {
                $('#reference_note').val($("input[name='gender']:checked").val());
            }
        });
    });

    $("input[name='carry_out_customer_info']").on('change keyup', function () {

        var reference_note = "Carry Out : "+$(this).val();
        $("#reference_note").val(reference_note);
    });


    $(".key-btns").on('click', function () {
        //alert($(this).find('button').text())
        var reference_note = $("#reference_note").val();
        var keypad_val = $(this).find('button').text();
        if(reference_note == ''){
            reference_note = 'Table : '+keypad_val;
        }else{
            reference_note = reference_note.replace("Table", '');
            reference_note = 'Table'+reference_note+keypad_val;
        }
        $("#reference_note").val(reference_note);
    });

    function call_checkout(){

        localStorage.setItem('staffnote',$("#reference_note").val());
        $("#payment").trigger('click');
    }
function enDis(idName){
    var txt = jQuery('#'+idName).attr('readonly');
    if(txt == 'readonly'){
        jQuery('#'+idName).attr('readonly',false);
    }
    else{
        jQuery('#'+idName).attr('readonly','readonly');
    }
}



    function addProductToVarientProduct(){
        var itemId = $(".modalvarient").find('.product_item_id').attr("value")
            var option_id = $(".modalvarient").find('.option_id').val();
        var term = $(".modalvarient").find('.product_term').val()+"<?php echo $this->Settings->barcode_separator; ?>"+option_id;
        //alert(itemId);
        //alert(option_id);
        wh = $('#poswarehouse').val(),
        cu = $('#poscustomer').val();
        $.ajax({
            type: "get",
            url: "<?=site_url('sales/suggestions')?>",
            data: {term: term,option_id:option_id, warehouse_id: wh, customer_id: cu},
            dataType: "json",
            success: function (data) {
                if (data !== null) {
                    add_invoice_item(data[0]);
                    $('.modalvarient').hide();
                } else {
                    bootbox.alert('<?=lang('no_match_found')?>');
                    $('.modalvarient').hide();
                }
            }
        });
    }
    function modalClose(modalClass){
        $('.'+modalClass).modal('toggle')
    }

</script>
<input type='button' onClick="Rfid()" value="rfid 7635 record" style="display:none"  />
</body>
</html>