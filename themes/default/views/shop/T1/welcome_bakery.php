<div class="landing-img-bg"><img src="<?= $assets?>/shop/img/welcom_beck.jpg" class="img-responsive well-background-image"></div>
<div class="row">
    <div class="col-sm-8">
        <div class="left-content">
                <div class="left-section-heading">
                        Making your life sweeter one bite at a time!
                </div>
                <div class="left-section-content1">
                        Many of us dream of starting a bakery, but for some of us it’s just too expensive. But thanks to the Internet, bakers have the chance to live out their dream. They can do business online and on the storefront.
                </div>
                <div class="left-section-content2">
                        Post your products and have drooling customers orders
                </div>

                <a href="<?php echo site_url('shop/home');?>"><button type="button" class="btn btn-warning">Continue Shopping</button></a>
        </div>

    </div>
            <div class="col-sm-4 animated fadeInRight">
                    <div class="right-section">
                        <div class="left-section-heading" style="text-align:center; color:#fff; padding-top: 20px;"><?= $shopinfo['site_name']?></div>						
                        <p class="field-address"> <?= $shopinfo['address']?> <?= $shopinfo['state']?> <?= $shopinfo['city']?> <?= $shopinfo['postal_code']?></p>
                        <p class="field-phone"> <?= $shopinfo['phone']?> </p>
                        <p class="field-mail"> <?= $shopinfo['default_email']?> </p>
                    </div>
            </div>
    </div>
