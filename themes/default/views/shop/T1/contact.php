<?php include_once 'header.php';?>

    <section class="middle_section"><!--Middle section view-->
        <div class="container">
           <div class="col-sm-12">
                    <div class="breadcrumbs">
                        <ol class="breadcrumb">
                          <li><a href="<?php echo site_url('shop/home');?>">Home</a></li>
                          <li class="active">Contact us</li>
                        </ol>
                    </div><!--/breadcrums-->
                     <div class="row">
                        <div class="col-sm-5 abt-image">
                            <img src="<?= $assets?>/shop/images/contact-us.png" class="img-responsive" alt="eShop">
                        </div>
                        <div class="col-sm-7">
                            <div class="abt-content">
                                <div><?php echo $page_containt->contact_us?></div>
                                <div>
                                    <p><span>Merchant name</span>: <?= $shopinfo['site_name']?></p>						
                                    <p><span>Merchant address</span>: <?= $shopinfo['address'].', '.$shopinfo['state'].', '.$shopinfo['city'].' '.$shopinfo['postal_code']?></p>
                                    <p><span>Contact Phone</span>: <?= $shopinfo['phone']?> </p>
                                    <p><span>Contact Email</span>: <?= $shopinfo['default_email']?> </p>
                                </div>
                           </div>
                       </div>
                    </div>

            </div> 
        </div>             
    </section><!--/Middle section view-->
    
<?php include_once 'footer.php';?>
 