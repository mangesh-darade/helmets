<?php echo include('header.php') ?>
<!-- banner -->
<div class="banner">

    <!-- faq -->
    <div class="faq">
        <div class="col-md-6 col-md-offset-3">
            <span class="ord declined"><i class="fa fa-warning aria-hidden" ></i></span>
            <div class="suc-ord declined">
                <div class="alert alert-error">Error:  <?php echo $error; ?></div>    
                <h2>Order has  not been placed successfully!</h2>
                <p> Sorry , your order  has  not been placed successfully!</p>
                <a class="btn btn-danger" style="border-radius:0;" href="<?php echo site_url('shop/home'); ?>" > Back to shop </a>
            </div>
            <div class="clearfix"></div>
            <div class="clearfix"></div>
        </div>
    </div>
    <!-- //faq -->

    <div class="clearfix"></div>
</div>
<!-- //banner -->
<?php echo include('footer.php') ?>