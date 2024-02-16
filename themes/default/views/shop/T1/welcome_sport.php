<div class="landing-img-bg"><img src="<?= $assets?>/shop/img/sport-bg.jpg" class="img-responsive well-background-image"></div>
<div class="row">
        <div class="col-sm-8">
                <div class="left-content">
                        <div class="left-section-heading">
                                Get your Game on
                        </div>
                        <div class="left-section-content1">
                                All sports goods, accessories and fitness equipments under one roof. Find all that you need to keep up that active lifestyle – be it indoors or outdoors. Get the biggest brands at affordable prices.
                        </div>
                        <div class="left-section-content2">
                                Talk with your feet. Play with your heart.
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
