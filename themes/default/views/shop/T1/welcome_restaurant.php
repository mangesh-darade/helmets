<div class="landing-img-bg"><img src="<?= $assets?>/shop/img/welcom_resta.jpg" class="img-responsive well-background-image"></div>
<div class="row">
        <div class="col-sm-8">
                <div class="left-content">
                        <div class="left-section-heading">
                                Start the day with great taste!
                        </div>
                        <div class="left-section-content1">
                                Take your time reviewing and choosing the dishes without someone breathing down your neck, double check your order before making payment and many more
                        </div>
                        <div class="left-section-content2">
                                Ordering-in or take-away
                        </div>
                        <a href="<?php echo site_url('shop/home');?>"><button type="button" class="btn btn-warning">Continue Shopping</button></a>
                </div>

        </div>
        <div class="col-sm-4 animated fadeInRight">
                <div class="right-section">
                    <div class="left-section-heading" style="text-align:center; color:#fff; padding-top: 20px;"><?= $shopinfo['site_name']?></div>						
                    <p class="field-address"><?= $shopinfo['address']?> <?= $shopinfo['state']?> <?= $shopinfo['city']?> <?= $shopinfo['postal_code']?></p>
                    <p class="field-phone"><?= $shopinfo['phone']?> </p>
                    <p class="field-mail"><?= $shopinfo['default_email']?> </p>
                </div>
        </div>
</div>
