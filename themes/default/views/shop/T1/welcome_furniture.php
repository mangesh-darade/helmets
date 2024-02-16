<div class="landing-img-bg"><img src="<?= $assets?>/shop/img/welcom_furni.jpg" class="img-responsive well-background-image"></div>
    <div class="row">
    <div class="col-sm-8">
        <div class="left-content">
                <div class="left-section-heading">
                        Best Prices. Guaranteed.
                </div>
                <div class="left-section-content1">
                        Of the total online retail market, online furniture pieces are growing the quickest of all online retail sales. So, this is a huge opportunity for small furniture manufacturers who make up-scale or high-end furniture to either sell their products online or reach out to key online retailers to support their sales growth.
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