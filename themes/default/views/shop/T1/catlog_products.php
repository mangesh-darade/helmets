<?php foreach ($products['items'] as $product) { ?>   
    <div class="col-sm-3 col-xs-6">
        <div class="product-image-wrapper">
            <div class="single-products">
                <div class="productinfo text-center">
                    <div class="image-outer">
                        <img src="<?= $baseurl;?>assets/uploads/thumbs/<?= $product['image'];?>" alt="<?= $product['code'];?>" />                                            
                    </div>
                    <h2><i class="fa fa-inr" aria-hidden="true"></i> <?= number_format($product['price'], 0);?></h2>
                    <p><?= $product['name'];?></p>
                    <a data-target="#" onclick="addCart(<?= $product['id'];?>)" class="hvr-pop btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                </div>
            </div>
        </div>
    </div>
<?php } ?>