<div class="landing-img-bg"><img src="<?= $assets?>/shop/img/welcom_med.jpg" class="img-responsive well-background-image"></div>
<div class="row">
        <div class="col-sm-8">
            <div class="left-content">
                    <div class="left-section-heading">
                            A pharmacy your family can trust
                    </div>
                    <div class="left-section-content1">
                            Online pharmacies have significantly increased due to growing E-commerce. An online pharmacy is a pharmacy that operate over the Internet and sends the orders to customers through the mail or shipping companies.
                    </div>
                    <div class="left-section-content2">
                            Where the old fashioned, neighborhood pharmacy of yesterday meets the high tech
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
