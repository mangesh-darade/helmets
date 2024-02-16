<div class="landing-img-bg"><img src="<?= $assets?>/shop/img/welcom_stat.jpg" class="img-responsive well-background-image"></div>
<div class="row">
        <div class="col-sm-8">
            <div class="left-content">
                <div class="left-section-heading">
                        Your stationery your store!
                </div>
                <div class="left-section-content1">
                        In India, though stationery is largely retailed through local or small players. Stationery products are required by everyone from school to organizations
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
