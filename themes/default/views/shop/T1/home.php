<?php include_once 'header.php'; ?>

<div id="cartNotify" class="modal fade" role="dialog">
    <div class="modal-dialog" id="bootstrapAlert">

    </div>
</div>

<section class="middle_section"><!--Middle section view-->
    <div class="container">
        <div class="home-section">
            <div class="category-toggle"><span class="catToggle" style="font-size:30px;cursor:pointer" onclick="openNav()"><i class="fa fa-tags" aria-hidden="true"></i>
                    <span class="menu-text">Category</span></span></div>

            <div class="col-sm-3 sidenav" id="mySidenav" style="padding-left:0 !important;">
                <a href="javascript:void(0)" class="closebtn" id="closeB" onclick="closeNav()">&times;</a>
                <a href="javascript:void(0)" class="closebtn" id="close-overLay" onclick="closeNav()"></a>
                <input type="hidden" id="baseurl" value="<?= $baseurl; ?>" />
                <input type="hidden" id="catId" value="<?= $default_category; ?>" />
                <input type="hidden" id="page" value="<?= $page_no; ?>" />
                <input type="hidden" id="limit" value="<?= $per_page_items; ?>" />
                <div class="left-sidebar" >
                    <div id="myCart"></div>
                    <h2>Category </h2>
                    <div class="search_box">
                        <div class="input-group input-group-sm">
                            <input type="text" id="searchCategory"  placeholder="Search Category" class="form-control">
                            <span class="input-group-btn">
                                <button type="button" id='searchCategoryButton' class="btn btn-info btn-flat">Go!</button>
                            </span>
                        </div>
                    </div>
                    <div id="searchCategoryList"></div>
                    <div class="accordion" id="myAccordion">
                        <?php
                        if (is_array($category)) {
                            foreach ($category as $catArr) {
                                ?>
                                <div class="panel">
                                    <?php
                                    if ($catArr['subcat_count'] > 0) {
                                        ?>
                                        <span style="font-size:14px;" onclick="loadSubCategory(<?= $catArr['id'] ?>);" type="button" class="panel-heading panel-title" data-toggle="collapse" data-target="#collapsible-<?= $catArr['id'] ?>" data-parent="#myAccordion"><?php echo $catArr['name']; ?> <span class="pull-right"><i class="fa fa-chevron-down"></i></span></span>
                                        <div id="collapsible-<?= $catArr['id'] ?>" class="collapse">
                                            <div class="panel-body" style="padding:0" id="subcategory_list_<?= $catArr['id'] ?>"></div>
                                        </div>
                                    <?php } else { ?>
                                        <span style="cursor: pointer; font-size:14px;" onclick="loadCategoryProducts(<?= $catArr['id'] ?>);" type="button" class="panel-heading panel-title" ><?php echo $catArr['name']; ?> <span class="pull-right">(<?php echo $catArr['products_count']; ?>) <i class="fa fa-chevron-right"></i></span></span>
                                    <?php } ?>
                                </div>
                                <?php
                            }//endforeach.
                        }//end if.
                        ?>
                    </div>

                </div>
            </div>

            <div class="col-sm-9 padding-right">
                <div class="category-tab"><!--category-tab-->
                    <div class="tab-content">                
                        <div class="tab-pane fade active in" id="products" >
                            <div class="product-page-outer">                        
                                <div id="catlog_products">
                                    <?php echo $default_products ?>
                                </div>                         
                            </div>                     
                        </div>
                    </div>
                </div><!--/category-tab-->
            </div>
        </div>

    </div>             
</section><!--/Middle section view-->

<?php include_once 'footer.php'; ?>
