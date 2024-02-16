 <footer id="footer" ng-show="user"><!--Footer-->
    <div class="footer-bottom">
        <div class="container">
            <div class="row">
                <div class="col-sm-6">
                    <ul>
                        <li><a href="<?php echo site_url('shop/about_us');?>">About us</a></li>|
                        <li><a href="<?php echo site_url('shop/faq');?>">FAQ</a></li>|
                        <li><a href="<?php echo site_url('shop/privacy_policy');?>">Privacy Policy</a></li>|
                        <li><a href="<?php echo site_url('shop/terms_conditions');?>">Terms & conditions</a></li>
                    </ul>
                </div>
                <div class="col-sm-6 text-right">
                    <p>Designed by <span><a target="_blank" href="https://www.simplypos.in">Simply POS</a></span></p>
                </div>
            </div>
        </div>
    </div>
</footer><!--/Footer--> 
<script src="<?= $assets.$shoptheme?>/js/jquery.js"></script>
<script src="<?= $assets.$shoptheme?>/js/bootstrap.min.js"></script>
<script src="<?= $assets.$shoptheme?>/js/ajaxRequest.js"></script>

</body>
</html>
