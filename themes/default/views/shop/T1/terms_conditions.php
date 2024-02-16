<?php include_once 'header.php';?>

        <section class="middle_section"><!--Middle section view-->
            <div class="container">
                <div class="col-sm-12">
                        <div class="breadcrumbs">
                                <ol class="breadcrumb">
                                  <li><a href="<?php echo site_url('shop/home');?>">Home</a></li>
                                  <li class="active">Terms & conditions</li>
                                </ol>
                        </div>
                        <div class="col-sm-12 abt-content">
                            <?php echo $page_containt->terms?>
                        </div> 
                </div>
            </div>             
        </section><!--/Middle section view-->
    
<?php include_once 'footer.php';?>
 