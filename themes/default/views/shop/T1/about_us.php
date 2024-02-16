<?php include_once 'header.php';?>

        <section class="middle_section"><!--Middle section view-->
            <div class="container">
                <div class="col-sm-12">
                    <div class="breadcrumbs">
                            <ol class="breadcrumb">
                              <li><a href="<?php echo site_url('shop/home');?>">Home</a></li>
                              <li class="active">About Us</li>
                            </ol>
                            </div>
                            <div class="row">
                            <div class="col-sm-5 abt-image">
                            <img src="<?= $assets?>/shop/images/aboutus.jpg" class="img-responsive" alt="eShop" />
                            </div>
                            <div class="col-sm-7">
                                <div class="abt-content">
                                    <p><?php echo $page_containt->about_us?></p>
                               </div>
                            </div>
                    </div>
                </div>
            </div>             
        </section><!--/Middle section view-->
    
<?php include_once 'footer.php';?>
 