<div id="cartNotify" class="modal fade" role="dialog">
  <div class="modal-dialog" id="bootstrapAlert"></div>
</div>
<div id="cartNotify1" class="modal fade" role="dialog">
 <div class="modal-dialog" id="bootstrapAlert1"></div>
</div>
<!-- newsletter -->
<div class="newsletter">
    <div class="container">
        <div class="w3agile_newsletter_left">
            <!--				<h3>sign up for our newsletter</h3>-->
        </div>
        <div class="w3agile_newsletter_right">
            <!--				<form action="#" method="post">
                                                    <input type="email" name="Email" value="Email" onfocus="this.value = '';" onblur="if (this.value == '') {this.value = 'Email';}" required="">
                                                    <input type="submit" value="subscribe now">
                                            </form>-->
        </div>
        <div class="clearfix"> </div>
    </div>
</div>
<!-- //newsletter -->
<!-- footer -->
<div class="footer">
    <div class="container">
        <div class="col-md-4 w3_footer_grid">
            <h3>information</h3>
            <ul class="w3_footer_grid_list">					 
                <li><a href="<?= base_url('shop/about_us')?>">About Us</a></li>
                <li><a href="<?= base_url('shop/faq')?>">FAQ</a></li>
                <li><a href="<?= base_url('shop/privacy_policy')?>">Privacy Policy</a></li>
                <li><a href="<?= base_url('shop/terms_conditions')?>">Terms of use</a></li>
                <li><a href="<?= base_url('shop/contact')?>">Contact Us</a></li>
            </ul>
        </div>
         
        <div class="col-md-4 w3_footer_grid">
            <h3>what in stores</h3>
            <ul class="w3_footer_grid_list">
                <?php
                    if(!empty($category)) {
                        $i=0;
                        foreach ($category as $catdata) {
                            $i++;
                            if($visitor == 'user') {
                               $link =  base_url('shop/home/'.md5($catdata['id']));
                            } else {
                               $link =  base_url('shop/login'); 
                            }
                    ?>
                        <li><a href="<?= $link?>"><?= $catdata['name']?></a></li>
                   <?php 
                            if($i > 4) break;
                        }//end foreach.
                    }//End if.
                    ?>                
            </ul>
        </div>
        <div class="col-md-4 w3_footer_grid">
            <div class="col-md-12 w3_footer_grid agile_footer_grids_w3_footer">
                <div class="w3_footer_grid_bottom">
                    <h4>100% secure payments</h4>
                    <img src="<?= $assets . $shoptheme ?>/images/card.png" alt=" " class="img-responsive" />
                </div><br/>
            </div>
            <div class="col-md-12 w3_footer_grid agile_footer_grids_w3_footer">
                <div class="w3_footer_grid_bottom">
                    <h4>connect with us</h4>
                    <ul class="agileits_social_icons">
                        <li><a href="<?= empty($eshop_settings->facebook_link) ? '#' : $eshop_settings->facebook_link ?>" <?php if(!empty($eshop_settings->facebook_link)) { echo 'target="_new"'; }?> class="facebook"><i class="fa fa-facebook" aria-hidden="true"></i></a></li>
                        <li><a href="<?= empty($eshop_settings->twitter_link) ? '#' : $eshop_settings->twitter_link ?>" <?php if(!empty($eshop_settings->twitter_link)) { echo 'target="_new"'; }?> class="twitter"><i class="fa fa-twitter" aria-hidden="true"></i></a></li>
                        <li><a href="<?= empty($eshop_settings->google_link) ? '#' : $eshop_settings->google_link ?>" <?php if(!empty($eshop_settings->google_link)) { echo 'target="_new"'; }?> class="google"><i class="fa fa-google-plus" aria-hidden="true"></i></a></li>
<!--                        <li><a href="#" class="instagram"><i class="fa fa-instagram" aria-hidden="true"></i></a></li>
                        <li><a href="#" class="dribbble"><i class="fa fa-dribbble" aria-hidden="true"></i></a></li>-->
                    </ul>
                </div><br/>
            </div>
            <div class="col-md-12 w3_footer_grid agile_footer_grids_w3_footer">
                <div class="w3_footer_grid_bottom">
                    <h4>Get In Touch</h4>
                  <?php if(!empty($eshop_settings->shop_phone)) { ?>
                    <div style="color: #fff;"><i class="fa fa-phone"></i> : <a href="tel://<?=$eshop_settings->shop_phone?>"><?=$eshop_settings->shop_phone?></a></div>
                  <?php } ?>
                  <?php if(!empty($eshop_settings->shop_email)) { ?>  
                    <div style="color: #fff;"><i class="fa fa-envelope"></i> : <a href="mailto:<?=$eshop_settings->shop_email?>"><?=$eshop_settings->shop_email?></a></div>
                  <?php } ?>
                </div>
            </div>
        </div>
        <div class="clearfix"> </div>
         
        <div class="wthree_footer_copy">
            <p>© 2018 POS Eshop. All rights reserved</p>
        </div>
    </div>
</div>
<!-- //footer -->
<!-- Bootstrap Core JavaScript -->
<script src="<?= $assets . $shoptheme ?>/js/bootstrap.min.js"></script>
<script>
   /* $(document).ready(function () {
        
        $(".dropdown").hover(
                function () {
                    $('.dropdown-menu', this).stop(true, true).slideDown("fast");
                    $(this).toggleClass('open');
                },
                function () {
                    $('.dropdown-menu', this).stop(true, true).slideUp("fast");
                    $(this).toggleClass('open');
                }
        );     
     
        $().UItoTop({easingType: 'easeOutQuart'});

    });*/
     $(document).ready(function(){
     $('#filterbtn').click(function(){
           $('#filter_toggle').toggle();
       }); 
        // Show hide popover
        $('#searchData').hide();
       $('.bootstrapAlert').hide();
        $(".dropdown").click(function(){
            $(this).find(".dropdown-menu").slideToggle("fast");
        });
    });
    $(document).on("click", function(event){
        var $trigger = $(".dropdown");
        if($trigger !== event.target && !$trigger.has(event.target).length){
            $(".dropdown-menu").slideUp("fast");
        } 
                 
    });
 
    window.localStorage.setItem('baseurl', '<?= base_url() ?>');
 
    function goto(page) {
        window.location = page;
    }

    function addToCart(prodId, carttype='') { 
       var varId = $('#variants_'+prodId).val();
        if(varId == 'null'){
           alert('Please Select Option');
               return false;
        }
        var baseUrl = window.localStorage.getItem('baseurl');
        var postData = 'product_id=' + prodId +"&"+ 'option=' + varId;
        $('#cartNotify').modal('show');
        $('#bootstrapAlert').html('<div class="alert alert-info"><i class="fa fa-refresh fa-spin text-danger" ></i> Please Wait! Item is adding to cart</div>');
        $.ajax({
            type: "get",
            url: baseUrl + 'shop/addCartItems',
            data: postData,
            success: function (Data) {
            // console.log(Data);

                $('#bootstrapAlert').html('<div class="alert alert-success"><i class="fa fa-check"></i> Item successfully added. Thank you.</div>');

                $('.cart-count').html(Data);

                setTimeout(function () {
                    $('#cartNotify').modal('hide');
                }, 500);
                if(carttype=='movetoaddtocart')
               removeItemFromWishlist(prodId);
            }
        });
    }

    function updateCartCount(prodId, qty) {
        
        var baseUrl = $('#baseurl').val();
        var postData = 'product_id=' + prodId;
        postData = postData + '&qty=' + qty;
        
        $.ajax({
            type: "get",
            url: baseUrl + 'shop/addCartItems',
            data: postData,
            success: function (Data) {
               
                $('.cart-count').html(Data);
            }
        });

    }

    function updateQtyCost(itemId) {

        var qty = $('#qty_' + itemId).val();

        var tax = $('#item_tax_rate_' + itemId).val();
        
        var ordertax = $('#order_tax_'+itemId).val();
        var taxType = $('#item_tax_type_' + itemId).val();
        var order_tax_type = $('#order_tax_type_' + itemId).val();
         
        var price = $('#item_price_' + itemId).val();

        var total = qty * price;
        var itemtax = 0;
        //percentage Tax
        if(taxType == 1) {
           var itemtax = ((total * tax) / 100); 
        }
        //Fixed Tax
        if(taxType == 2) {
           var itemtax = tax * qty;
        }
       // alert(taxType+' gg '+itemtax);
        if(order_tax_type == 1){
        var order_tax = ((total + itemtax) * ordertax/100);
        //console.log(order_tax);
        }
        else if(order_tax_type == 2){
        var order_tax = $('#order_tax_fix').val();
        //console.log(order_tax);
        }

        $('#show_total_' + itemId).html(total.toFixed(2));
        $('#item_price_total_' + itemId).val(total.toFixed(2));
      

        $('#show_tax_total_' + itemId).html(itemtax.toFixed(2));
        $('#item_tax_total_' + itemId).val(itemtax.toFixed(2));

//        $('#cart_ordertax_total_show' + itemId).html(order_tax.toFixed(2));
       $('#order_tax_total_' + itemId).val(order_tax);
        //$('#show_total_ordertax_' + itemId).html(order_tax.toFixed(2));

        calculateCart();
        updateCartCount(itemId, qty);
    }

    function calculateCart() {

        var cart_sub_total = 0;
        var cart_tax_total = 0;
        var cart_ordertax_total = 0;
        var order_tax_type = $('#order_tax_type').val();
        var order_tax_fix = $('#order_tax_fix').val();

        $('.item_tax_total').each(function () {

            cart_tax_total += parseFloat($(this).val());
            
        });

        $('.item_price_total').each(function () {

            cart_sub_total += parseFloat($(this).val());
        });
        if(order_tax_type == 1){
        $('.order_tax_total').each(function () {
             cart_ordertax_total += parseFloat($(this).val());
             console.log(cart_ordertax_total);
         });
        }
           else if(order_tax_type == 2){
               $('.order_tax_fix').each(function () {
                cart_ordertax_total = parseFloat($(this).val());
                console.log(cart_ordertax_total);
            });
        }
     
    

        var cart_gross_total = (cart_sub_total + cart_tax_total + cart_ordertax_total);
        $('#cart_sub_total_show').html(cart_sub_total.toFixed(2));
        $('#cart_tax_total_show').html(cart_tax_total.toFixed(2));
         $('#cart_ordertax_total_show').html(cart_ordertax_total.toFixed(2));

        //console.log(cart_gross_total);
       

        $('#cart_sub_total').val(cart_sub_total.toFixed(2));
        $('#cart_tax_total').val(cart_tax_total.toFixed(2));
         $('#cart_ordertax_total_show').val(cart_ordertax_total.toFixed(2));
        $('#cart_gross_total').val(cart_gross_total.toFixed(2));
        $('#order_tax_total').val(cart_ordertax_total.toFixed(2));
         $('#cart_gross_total_show').html(cart_gross_total.toFixed(2));
       
    }
    
    function submitSearch(page){
        
       var search_keyword = $('#search_keyword').val();
       
      $('#search_keyword').val( $.trim(search_keyword));
      $('#page').val( page );
       
      if( $.trim(search_keyword).length >= 3 )
      {
          return true
      } else {
          alert('Search keyword should be at lease 3 charectors long');
        return false;  
      }
    }
    function searchPage(keyword , page){
      
      $('#search_keyword').val( $.trim(keyword));
      $('#page').val( page );
       
      document.search_products.submit(); 
       
    }
        //15/07/2019
    function addTowishlist(prodId){
    var baseUrl = window.localStorage.getItem('baseurl');
    var postData = 'product_id=' + prodId;
     
    $('#cartNotify1').modal('show');
    $('#bootstrapAlert1').html('<div class="alert alert-info"><i class="fa fa-refresh fa-spin text-danger" ></i> Please Wait! Item is adding to wishlist</div>');
        $.ajax({
             type:"get",
             url:baseUrl + 'shop/addTowishlistItems',
             data:postData,
             success:function(Data){
                // console.log(Data);
               $('#bootstrapAlert1').html('<div class="alert alert-success"><i class="fa fa-check"></i> Item to wishlist.</div>');
               $('.wish-count').html(Data);
             
                $('#addtowishlist_'+ prodId).html('wishlisted');
                $('#addtowishlist_'+ prodId).val('wishlisted');
                $('#addtowishlist_'+ prodId).css('background-color','green');
                setTimeout(function () {
                 $('#cartNotify1').modal('hide');
                }, 500);
            },
             error:function(){
                 console.log('error');
             }
         })
    }
   function removeItemFromWishlist(prodId){
    var postData = 'product_id=' + prodId;
    $('#cartNotify2').modal('show');
    var baseUrl = window.localStorage.getItem('baseurl');
     $('#bootstrapAlert2').html('<div class="alert alert-success"><i class="fa fa-check"></i>Wait, item is deleting.</div>');
    $.ajax({
        type:"get",
        url : baseUrl + 'shop/removewishlist',
        data: postData,
        cache: false,
        success:function(data){
        $('#bootstrapAlert2').html('<div class="alert alert-success"><i class="fa fa-check"></i> Item deleted.</div>');
            $('.w3ls_w3l_banner_left_asdfdfd_' + prodId).remove();
            $('.wish-count').html(data);
        },
        error:function(){
            console.log('error');
        }
    })
    return false;
    }

    $(document).ready(function () {
    size_li = $("#catlist li").size();
    size_li1 = $("#brandlist li").size();
    size_li2 = $("#pricelist li").size();
    x=5;
    $('#catlist li:lt('+x+')').show();
    $('#brandlist li:lt('+x+')').show();
    $('#pricelist li:lt('+x+')').show();
    $('#loadMore').click(function () {
        x = (x+10 <= size_li) ? x+10 : size_li;
        $('#catlist li:lt('+x+')').show();
        $('#catlist').css({'height':'150px', 'overflow-y':'scroll'});
    });
    $('#more').click(function () {
        x = (x+10 <= size_li1) ? x+10 : size_li1;
        $('#brandlist li:lt('+x+')').show();
        $('#brandlist').css({'height':'150px', 'overflow-y':'scroll'});
    });
     $('#pmore').click(function () {
        x = (x+10 <= size_li2) ? x+10 : size_li2;
        $('#pricelist li:lt('+x+')').show();
        $('#pricelist').css({'height':'150px', 'overflow-y':'scroll'});
    });
    
   /* $('#showLess').click(function () {
        x=(x-5<0) ? 3 : x-5;
        $('#catlist li').not(':lt('+x+')').hide();
    });*/
    })
  
    
        $(".filter_check").click(function(){
            filterProducts(1);
        });
    
    
    function filterProducts(pageNo){
        var select_brand = [];
           var select_cat = [];
           var select_price = [];
           var unchecked=0;
            pageNo = pageNo ? pageNo : 1;
            
           $.each($("input[name=brand]:checked"), function(){   
                 var brnd = (this).value;
                 select_brand.push(brnd);
                 unchecked=1;
                });
            $.each($("input[name=category]:checked"), function(){            
               var cat = (this).value;
               select_cat.push(cat);
               unchecked=1;
             });  
             $.each($("input[name=price]:checked"),function(){
                var price = (this).value;
                select_price.push(price);
                unchecked=1;
             });
            
             if(unchecked==0)
                 location.reload();
             var selected_CatId = select_cat.join("_");
             var selected_BrandsId = select_brand.join("_");
             var selected_Priceval = select_price.join("_");
             var baseUrl = window.localStorage.getItem('baseurl');
             var catId = 'catId=' + selected_CatId;
             var BrandsId = 'BrandsId=' + selected_BrandsId;
             var PriceVals = 'PriceVal=' + selected_Priceval;
             
             postData = catId +'&' + BrandsId + '&' + PriceVals + '&pageno='+pageNo+'&itemsPerPage='+20;
             
             $.ajax({
            type: "get",
            url: baseUrl + 'shop/Filterproducts',
            data: postData,
            
            success: function (Data) {
                //console.log(Data);
                $('#searchData').show();
                $('#searchData').html(Data);
                $('.defaultProlist').hide();
                
            
            }
        });
}

</script>
</body>
</html>