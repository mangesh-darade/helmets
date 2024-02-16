<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Shop extends MY_Controller
{
    public $data;
    public $view_shop;
    public $Settings = '';

    public function __construct()
    {        
        parent::__construct();
        
        $this->view_shop = 'default/views/shop/';
        
        $this->data['user_id'] = $this->session->userdata('id');
        
        $this->data['assets'] = base_url() . "themes/default/assets/";
        
        $this->data['baseurl'] = base_url();
        
        $this->load->library('form_validation');
         
        $this->load->model('shop_model');
        
        $this->load->model('eshop_model');
        
        $this->load->model('pos_model');

        $this->load->helper('genfun_helper');

        $this->load->library('ion_auth');
        
        $this->Settings = $this->site->get_setting();
        
        $this->data['shopinfo']  = $this->storeInfo();
        
        $this->data['shop_pagename']  = $this->uri->segment(2); 
    }
    
    public function load_shop_view($method='', $data=array()) {
                    
        $this->load->view($this->view_shop . $method , $data);
    }
    
    public function authenticate() {
       
        if(!$this->shop_model->session_authenticate()){             
            redirect('shop/login');            
        } else {
            redirect('shop/home');
        }
    }
    
    public function exitInvalidSession() {
       
        if(!$this->shop_model->session_authenticate()){             
            redirect('shop/login');            
        }
    }
    
    public function welcomeValidSession() {
       
        if($this->shop_model->session_authenticate()){             
            redirect('shop/home');            
        }
    }
    
    public function index() {
        $this->authenticate();    
    }
    
    public function welcome() { 
        
        $this->exitInvalidSession();
        
        $this->load_shop_view('welcome', $this->data);          
    }
      
     public function order_details(){ 
        
        $this->exitInvalidSession();
     
        $this->load_shop_view('order_details1', $this->data);          
                    
    }
    
    public function storeInfo() {       
        
        return $storeInfo = $this->shop_model->storeDetails();
      
    }    
    
    public function searchCategories() {       
        
        $keyword = $_GET['keyword'];
        
        if(strlen($keyword) < 3) return false;
        
        $categoryList = $this->shop_model->searchCategory($keyword);
        
        if(is_array($categoryList)) {
            $html = '<ul class="no-style" style="padding:0px 20px;">';
            foreach ($categoryList as $key => $catArr) {
                
                 $html .= '<li class="cursor-pointer"><a onClick="loadCategoryProducts('.$catArr->id.');">'.$catArr->name.'</a></li>';
                    
            } 
            echo $html .= '<li style="text-align:right;"><i style="color:red; cursor:pointer;" onclick="clearSearchCategory()">Clear Search</i></li></ul><hr/>';
        }
                    
    } 
    
    public function allCategories($keyword='') {       
        
        $allCategory = $this->shop_model->getCategory('ALL', $keyword);
        
        $categoryArr['default'] = $allCategory['default_category'];
        
        foreach ($allCategory as $key => $catArr) {
            
            if( in_array( $key, ['status','count','default_category'])){
                continue;
            }
            
            $categoryArr['list'][$catArr['parent_id']][$catArr['id']] = $catArr;
        }
        
        echo json_encode($categoryArr);
    } 
                    
    public function parentCategories() {
        
       $parentsCategory = $this->shop_model->getCategory('PARENT');
       $categoryArr['default'] = $parentsCategory['default_category'];
       
       foreach ($parentsCategory as $key => $catArr) {
            
            if( in_array( $key, ['status','count','default_category'])){
                
                continue;
            }
            
            $categoryArr['list'][$catArr['id']] = $catArr;
            
            $categoryArr['ids'][] = $catArr['id'];
        }
        
        ksort($categoryArr['list']);
         
        return $categoryArr;
    } 
    
    public function childCategories($parent_id) {       
        
        $childCategory = $this->shop_model->getCategory('CHILD', $parent_id);
        
        foreach ($childCategory as $key => $catArr) {
            
            if( in_array( $key, ['status','count']) && !is_numeric($key)){                
                continue;
            }
           
            $categoryArr[$catArr['id']] = $catArr;
        } 
        
        return $categoryArr;
        
    }       
    
    public function loadCategories() {
        
        $categoryJson = $_POST['categoryJson'];
        
        if(empty($categoryJson)) { 
            
             $categoryArr = $this->parentCategories();
             $category = $categoryArr['list']; 
        }
        else {   $category =  json_decode($categoryJson);  }
        
        if(is_array($category)){ 
            
            foreach ($category as $key => $catArr) {
     ?>
            <div class="panel">
                <span onclick="loadSubCategory(<?= $key?>);" type="button" class="panel-heading panel-title" data-toggle="collapse" data-target="#collapsible-<?= $key;?>" data-parent="#myAccordion"><?php echo $catArr['name'];?> <span class="pull-right">(<?php echo $catArr['subcat_count'];?>) <i class="fa fa-angle-double-down"></i></span></span>
                <div id="collapsible-<?= $key;?>" class="collapse">
                    <div class="panel-body" style="padding:0" id="subcategory_list_<?= $key;?>"></div>
                </div>
            </div>
    <?php
            }//endforeach.
        }//end if.
               
    }  
    
    public function loadSubcategory() {
        
        $parent_id = $_GET['parent_id'];
        
        $subcategoryArr = $this->childCategories($parent_id);
       
        if(is_array($subcategoryArr)) {
            
            foreach ($subcategoryArr as $key => $catArr) {
               $list .= '<div style="font-weight: normal;cursor: pointer;" onClick="loadCategoryProducts('.$key.');" class="category-link">'.$catArr['name'].'</div>';
            }//end foreach.
            
            echo $list;
        } else {
            echo '';
        }        
    }  
    
    public function Pagignations($pagingData) {
        
        $total_records      = $pagingData['count'];
        $active_pageno      = $pagingData['pageno'];
        $itemsPerPage       = $pagingData['itemsPerPage'];
        $pagCallFunction    = $pagingData['pagCallFunction'];
        $displayPage        = (!empty($pagingData['displayPage'])) ? $pagingData['displayPage'] : 5;
        
        if($total_records <= $itemsPerPage ) return false;
        
        $pagelist = ceil($total_records / $itemsPerPage);

        $pagignation = '<ul class="pagination pagination-sm" style="margin-top: 0px; margin-bottom: 0px; baground-color:#FFF !important;">';

        $prePage = $active_pageno - 1;
        $nextPage = $active_pageno + 1;

        if($active_pageno == 1) {
               $pagignation .= '<li class="disabled"><a>&laquo;</a></li>';
        }

        if($active_pageno > 1) {
               $pagignation .= '<li><a onclick="'.$pagCallFunction.'('. $prePage .')">&laquo;</a></li>';
        }

        $initpage = ($displayPage < $active_pageno && $pagelist > $displayPage ) ? ceil($active_pageno - ($displayPage / 2)) : 1;

        if($initpage > 1) {
            $pagignation .= '<li><a onclick="'.$pagCallFunction.'(1)">1</a></li>';
            $pagignation .= '<li class="disabled"><a>...</a></li>';
        }

        for($i=1 ; $i <= $displayPage; $i++){

            $p = $initpage;

            if($p > $pagelist) break;

            $activeClass = ($active_pageno == $p) ? ' class="active" ' : '';

            $pagignation .= '<li '.$activeClass.' ><a onclick="'.$pagCallFunction.'('.$p.')">'.$p.'</a></li>';
            $initpage++;
        }

        if($pagelist > $displayPage && $pagelist > $p ){
             $pagignation .= '<li><a>...</a></li>';
             $pagignation .= '<li><a onclick="'.$pagCallFunction.'('.$pagelist.')">'.$pagelist.'</a></li>';
        }

        if($active_pageno < $pagelist) {
            $pagignation .= '<li><a  onclick="'.$pagCallFunction.'('. $nextPage .')">&raquo;</a></li>';
        }
        if($active_pageno == $pagelist) {
            $pagignation .= '<li class="disabled"><a>&raquo;</a></li>';
        }

        $pagignation .= ' </ul>';
        
        return $pagignation;
    }  
        
    public function catlogProducts() {
        
        $catId = $_GET['catId'];
        $page  = $_GET['page'];
        $limit = $_GET['limit'];
        $keyword = (isset($_GET['keyword']) && !empty($_GET['keyword'])) ? $_GET['keyword'] : '';
        
        $pageno = (empty($page)) ? 1 : $page;
        $itemsPerPage = (empty($limit)) ? 20 : $limit;
        
        if(!empty($keyword)) {
            $catlog = $this->shop_model->searchProducts($keyword, $pageno, $itemsPerPage);
        } else {
            $catlog = $this->shop_model->getCategoryProducts($catId, $pageno, $itemsPerPage);
        }
        
       
        
      //  echo $catlog['msg'];
        
        if($catlog['totalPages'] > 1) {
            
            $pagingData['count']            = $catlog['count'];
            $pagingData['pageno']           = $page;
            $pagingData['itemsPerPage']     = $limit;
            $pagingData['pagCallFunction']  = 'loadPageProducts';
            $pagingData['displayPage']      = 10;
            
            $pagignation = $this->Pagignations($pagingData);
        }
        
        if($catlog['count'] > 0) { 
        
        echo    '<div class="row search_box">
                    <div class=" col-sm-9">
                        <div class="sortby">
                         '.$pagignation.'    
                        </div>
                    </div>
                    <div class="col-sm-3" >
                        <div class="input-group input-group-sm">
                            <input type="text" id="searchProducts" value="'.$keyword.'" placeholder="Search Products" class="form-control">
                            <span class="input-group-btn">
                              <button type="button"  onClick="searchProducts();" class="btn btn-info btn-flat">Go!</button>
                            </span>
                        </div>
                    </div> 
                </div>';


        foreach ($catlog['items'] as $product) {

                  
            if($this->session->userdata('id') > 0){
                $product = (array)get_product_price($product,$this->session->userdata('id'));
            } 
            
            

            echo '<div class="col-sm-3 col-xs-6">
                    <div class="product-image-wrapper">
                        <div class="single-products">
                            <div class="productinfo text-center">
                                <div class="image-outer">
                                    <img src="'. base_url() .'assets/uploads/thumbs/'.$product['image'].'" alt="'.$product['code'].'" />                                            
                                </div>
                                <h2><i class="fa fa-inr" aria-hidden="true"></i> '. number_format($product['price'], 0).'</h2>
                                <p>'.$product['name'].'</p>
                                <a data-target="#" onclick="addToCart('.$product['id'].')" class="hvr-pop btn btn-default add-to-cart"><i class="fa fa-shopping-cart"></i>Add to cart</a>
                            </div>
                        </div>
                    </div>
                </div>';
          }//end foreach. 
          
        } else {
            
            echo '<div class="alert alert-ifo">Zero products available.</div>';
        }//end else.
    }  
    
    public function searchProducts($keyword, $pageno=1, $itemsPerPage=12) {       
        
       if(empty($keyword)) return false;
        
       $catlog_products = $this->shop_model->searchProducts($keyword, $pageno, $itemsPerPage);
       
                    
    }
    
    public function home() { 
       
        $category = $this->parentCategories();
        
        $this->data['default_category']     = ($category['default']) ? $category['default'] : $this->data['shopinfo']['default_category']; 
        $this->data['category']             = $category['list'];
        $this->data['catIds']               = $category['ids'];
        $this->data['page_no']              = 1;
        $this->data['per_page_items']       = 20;
        
        $this->load_shop_view('home', $this->data);        
    }
        
    public function addCartItems() {
        
        $product_id = $_GET['product_id'];
        
        if(isset($_SESSION['cart'][$product_id])){
            $_SESSION['cart'][$product_id]['qty'] += 1; 
        } else {
            $_SESSION['cart'][$product_id]['qty']=1;
        }
        
        echo count($_SESSION['cart']);
       
    }
    
    public function updateCartItems() {
        
        $product_id = $_GET['product_id'];
        $action = $_GET['action'];
        
        if(isset($_SESSION['cart'][$product_id])){
            if($action == '-') {
                $_SESSION['cart'][$product_id]['qty'] -= 1; 
            }
            if($action == '+') {
                $_SESSION['cart'][$product_id]['qty'] += 1; 
            }
            
            if($_SESSION['cart'][$product_id]['qty'] <= 0) {
                unset($_SESSION['cart'][$product_id]); 
            }
        }
        
        echo $_SESSION['cart'][$product_id]['qty'];
       
    }
    
    public function removeCartItems() {
        
        $product_id = $_GET['id'];
        
        if(isset($_SESSION['cart'][$product_id])){
            unset($_SESSION['cart'][$product_id]); 
        }
        
        redirect('shop/cart');
       
    }
    
    public function clearCart() {
        unset($_SESSION['cart']);
         redirect('shop/home'); 
    }
    
    public function cart() {
        
        $this->exitInvalidSession();
        
        $this->load->model('pos_model');
        
        if(count($_SESSION['cart'])>0) {
            
           $productIds =  array_keys($_SESSION['cart']);
            
           $items  = $this->shop_model->getProductInfo($productIds);
        
           foreach ($_SESSION['cart'] as $key => $value) {
               if($this->session->userdata('id') > 0){
                   $items[$key]= (array)get_product_price($items[$key],$this->session->userdata('id'));
               }
               $this->data['cart'][$key] = $items[$key];
               $this->data['cart'][$key]['qty'] = $value['qty'];
           }//end foreach
        }
        
        $this->data['taxes']['methods'] = $this->getTaxMethods();
        $this->data['taxes']['attribs'] = $this->getTaxAttribs();        
       
        $this->load_shop_view('cart', $this->data); 
    } 
    
    public function checkout() {
        
        $cartData = $_POST; 
       
       $tax_methods  = $this->getTaxMethods(); 
       
        if(count($cartData['items'])<=0) { redirect('shop/cart'); } 
        
        $cart['cart_sub_total']   = $cartData['cart_sub_total'];
        $cart['cart_tax_total']   = $cartData['cart_tax_total'];
        $cart['cart_gross_total'] = $cartData['cart_gross_total'];
        $itemcount = 0;
        
        foreach ($cartData['items'] as $item_id) {
            
           $itemcount++; 
           $productIds[] = $item_id;
           $gstAttrs = $tax_methods[$cartData['item_tax_id'][$item_id]]['tax_config'];            
           $item_subtotal = $cartData['item_price_total'][$item_id];
           
            $cart['items'][$item_id] = array(
                    'item_price'        => $cartData['item_price'][$item_id],
                    'qty'               => $cartData['qty'][$item_id],
                    'item_subtotal'     => $item_subtotal,
                    'tax_rate'          => $cartData['item_tax_rate'][$item_id],
                    'item_tax_total'    => $cartData['item_tax_total'][$item_id],                
                    'item_tax_id'       => $cartData['item_tax_id'][$item_id],
            );
           
            //To set Tax Attributes.
            foreach ($gstAttrs as $key => $gstattr) {
              
                $cart['items'][$item_id]['tax_attr'][$gstattr['code']] = [
                    'percentage' => $gstattr['percentage'],
                    'name' => $gstattr['name'],
                    'taxamt' => ($item_subtotal * $gstattr['percentage'] / 100),
                ];            
            }//end foreach.
            
        }//end foreach.
        
        $cart['itemcount'] = $itemcount;
        
        $products =  $this->shop_model->getProductInfo($productIds);
        
        foreach ($products as $pid => $prodata) {
            $cart['items'][$pid]['code'] = $prodata['code'];
            $cart['items'][$pid]['name'] = $prodata['name'];
            $cart['items'][$pid]['image'] = $prodata['image'];
            $cart['items'][$pid]['hsn_code'] = $prodata['hsn_code'];
            $cart['items'][$pid]['brand'] = $prodata['brand'];
        }//end foreach
        
       // $this->data['store'] = $this->storeInfo();
        
        $this->data['cart']             = $cart;
               
        $this->data['shipping_methods'] = $this->shipping_methods();
        $this->data['payment_methods']  = $this->payment_methods();
        
        $billing_shipping = $this->shop_model->get_billing_shipping($this->data['user_id']); 
        
        if($this->data['billing_shipping']===false){
            $this->data['customer'] = (array)$this->customer_info();
        } else {
            $this->data['billing_shipping'] = (array)$billing_shipping[0];
        }
        
        $this->load_shop_view('checkout', $this->data); 
        
    }    
                    
    public function order_submit() {
       
        $orderData = $_POST;
            
            $shopinfo = $this->data['shopinfo'];           

            $this->load->model('sales_model');

            $cart = unserialize($orderData['order_data']); 
                    
            $unites = $this->shop_model->getUnites();        

            $cart_items_count = count($orderData['cart_items']);
        
            $order_tax_id = ($cart['order_tax_id']) ? $cart['order_tax_id'] : 0;

            $order_tax = ($cart['order_tax']) ? $cart['order_tax'] : 0;

            $totalTax =  $cart['cart_tax_total'] +  $order_tax; 

            $paymentMethods = $this->payment_methods();

            $payment_methods = $paymentMethods[$orderData['paymentType']]['code']; 
            
            $ref_No  = $this->site->getReferenceNumber('eshop');
                    
            $userdata = $this->session->userdata(); 
            
            $user_id = $userdata['id'];
            $user_name = $userdata['name'];
            $order_date = date('Y-m-d H:i:s');
            
            $shippingMethodInfo = $this->eshop_model->getShippingMethods(['id'=>$orderData['shippingType']]); 
            
            $cf1 = ($orderData['cf1']) ? $orderData['cf1'] : '';
            $cf2 = ($orderData['cf2']) ? $orderData['cf2'] : '';
            
            $order = array(
                "date"=> $order_date,
                "reference_no"=> $ref_No,
                "customer_id"=> $user_id,
                "customer"=> $user_name,                
                "biller_id"=> $shopinfo['default_biller'],
                "biller"=> $shopinfo['biller_name'],
                "warehouse_id"=> $shopinfo['default_warehouse'],
                "total"=> $cart['cart_sub_total'],                
                "product_discount"=> 0,
                "order_discount_id"=> '',
                "order_discount"=> 0,
                "total_discount"=> 0,
                "product_tax"=> $cart['cart_tax_total'],
                "order_tax_id"=> $order_tax_id,
                "order_tax"=> $order_tax,
                "total_tax"=> $totalTax,
                "shipping"=> 0,
                "grand_total"=>$cart['cart_gross_total'],
                "sale_status"=> "completed",
                "payment_status"=> "due",
                "total_items"=> $cart_items_count,
                "paid"=> 0,
                "pos"=> 0,                
                "offline_sale"=> 0,
                "eshop_sale"=> 1,
                "cf1"=> $cf1,
                "cf2"=> $cf1,
                "note"=> '', 
            );         
           
            $billing_shipping = array(
                    "billing_name" => $orderData['billing_name'],
                    "billing_gstn_no" => $orderData['billing_gstn_no'],
                    "billing_phone" => $orderData['billing_phone'],
                    "billing_email" => $orderData['billing_email'],
                    "billing_addr1" => $orderData['billing_addr1'],
                    "billing_addr2" => $orderData['billing_addr2'],
                    "billing_city" => $orderData['billing_city'],
                    "billing_state" => $orderData['billing_state'],
                    "billing_country" => $orderData['billing_country'],
                    "billing_zipcode" => $orderData['billing_zipcode'],
                    "shipping_billing_is_same" => $orderData['shipping_billing_is_same'],
                    "save_info" => $orderData['save_info'],
                    "shipping_name" => $orderData['shipping_name'],
                    "shipping_phone" => $orderData['shipping_phone'],
                    "shipping_email" => $orderData['shipping_email'],
                    "shipping_addr1" => $orderData['shipping_addr1'], 
                    "shipping_city" => $orderData['shipping_city'],
                    "shipping_state" => $orderData['shipping_state'],
                    "shipping_country" => $orderData['shipping_country'],
                    "shipping_zipcode" => $orderData['shipping_zipcode'],
                    "shippingType" => $orderData['shippingType'],
                    "paymentType" => $orderData['paymentType'],
                );
                    
        if(is_array($cart['items']) && count($cart['items'])){ 
                    
          $order_sale_id = $this->eshop_model->addSales($order);
                       
           //If sale insert successfully.
           if($order_sale_id){
               
               //Get Eshop shipping info              
                $e_order['is_cod']                = ($payment_methods=='cod') ? 'YES':'NO';
                $e_order['shipping_method_name']  = $shippingMethodInfo[0]['name'];
                $e_order['sale_id']         =  $order_sale_id;     
                $e_order['date']            =  $order_date;     
                $e_order['customer_id']     =  $user_id;     
                $e_order['billing_name']    =  $orderData['billing_name'];
                $e_order['billing_addr']    =  $orderData['billing_addr1']. ', '.$orderData['billing_addr2'];
                $e_order['billing_email']   =  $orderData['billing_email'];
                $e_order['billing_phone']   =  $orderData['billing_phone'];
                $e_order['shipping_name']   =  $orderData['shipping_name'];
                $e_order['shipping_addr']   =  $orderData['shipping_addr1'].', '.$orderData['shipping_addr2'];
                $e_order['shipping_email']  =  $orderData['shipping_email'];
                $e_order['shipping_phone']  =  $orderData['shipping_phone'];
               
                //Insert Eshop order details.
               $order_id = $this->eshop_model->addOrder($e_order);
                  
               //Update Eshop sale refference no.
              $updateReference = $this->site->updateReference('eshop');
                    
                //Fourcefully save billing & shipping info
              /*  $save_info = 1;
                if($save_info==1):
                    //-------------------------------- Saving Billing Shippimg Info -----------------------------
                    $_param = array('billing_name', 'billing_phone', 'billing_email', 'shipping_phone', 'shipping_email', 'billing_addr1', 'billing_addr2', 'billing_city', 'billing_state', 'billing_country', 'billing_zipcode', 'shipping_name', 'shipping_addr1', 'shipping_addr2', 'shipping_city', 'shipping_state', 'shipping_country', 'shipping_zipcode');
                    $param = array();
                    if (is_array($_param)):
                        foreach ($_param as $_param_key) {
                            $_param_key_val = $this->input->post($_param_key);
                            if (!empty($_param_key_val)):
                                $param[$_param_key] = $this->input->post($_param_key);
                            endif;
                        }
                    endif;
                    if (count($param) > 0):
                       $res_copy = $this->companies_model->set_billing_shiiping_info($this->data['user_id'], $param);
                    endif;
                    //-------------------------------- Saving Billing Shippimg Info -----------------------------
                endif;
               */
                    
               //add order Items
               foreach ($cart['items'] as $pid => $cartitems) {

                    $productData  = $this->shop_model->getProductInfo($pid);
                    $productinfo = $productData[$pid];

                   if($this->session->userdata('id') > 0){
                       $productinfo = (array)get_product_price($productinfo,$this->session->userdata('id'));
                   }
                    $mrp = ($productinfo['mrp']) ? $productinfo['mrp'] : 0;
                    
                    $sale_items = array(
                        "sale_id" => $order_sale_id,
                        "product_id" => $pid,
                        "product_code"=> $cartitems['code'],
                        "product_name"=> $cartitems['name'],
                        "product_type"=> $productinfo['type'],                        
                        "net_unit_price"=> $cartitems['item_price'],
                        "unit_price"=> $cartitems['item_price'],
                        "real_unit_price"=> $cartitems['item_price'],
                        "quantity"=> $cartitems['qty'],
                        "warehouse_id"=> $shopinfo['default_warehouse'],                        
                        "item_tax"=> $cartitems['item_tax_total'],
                        "tax_rate_id"=> $cartitems['item_tax_id'],
                        "tax"=> $cartitems['tax_rate'],                        
                        "discount"=> 0,
                        "item_discount"=> 0,                        
                        "subtotal"=> $cartitems['item_subtotal'],
                        "product_unit_id"=> $productinfo['unit'],
                        "product_unit_code"=> $unites[$productinfo['unit']]['code'],                        
                        "unit_quantity"=> $cartitems['qty'],                        
                        "cf1"=> $productinfo['cf1'],
                        "cf2"=> $productinfo['cf2'],                        
                        "hsn_code"=> $productinfo['hsn_code'],              
                        "mrp"=> $mrp,              
                    );

                    if(is_array($cartitems['tax_attr'])){
                        foreach( $cartitems['tax_attr'] as $taxcode=>$taxattr){
                            if($taxattr['taxamt'] > 0) {
                                $cartItemsTax[] = array(
                                    "item_id" => $pid,
                                    "sale_id" => $order_sale_id,
                                    "attr_code" => $taxcode,
                                    "attr_name" => $taxattr['percentage'],
                                    "attr_per" => $taxattr['name'],
                                    "tax_amount" => $taxattr['taxamt'],               
                                );
                            }
                        }//end foreach.
                    }//end if.                    
                    
                  $sale_item_id = $this->eshop_model->addSalesItem($sale_items);
                    
                    if($sale_item_id) {
                        
                        unset($sale_items);
                        foreach( $cartItemsTax as $item_tax_attr){
                        
                            $taxAttrId = $this->eshop_model->addSalesItemTaxAttr($item_tax_attr);
                        }//end foreach
                        if($taxAttrId){
                            unset($cartItemsTax);
                        }
                    }//end if.
                    
                }//foreach
                
                $res = $this->pos_model->getSetting();
                $user_id = $this->data['user_id'];
                $ci = get_instance();
                $config = $ci->config;
                $result = array();
                $result['status'] = 'ERROR';

               $eshop_url = isset($config->config['eshop_url']) && !empty($config->config['eshop_url']) ? $config->config['eshop_url']:null;
                
                //------start Payment Process 
                               
                $_arr = array('x_amount' => $cart['cart_gross_total'], 'x_invoice_num' => $order_sale_id, 'x_description' => $ref_No);
                $_arr['x_amount'] = $cart['cart_gross_total'];
                $_arr['x_invoice_num'] = $order_sale_id;
                $_arr['x_description'] = $ref_No;
                $_arr['name'] = $orderData['billing_name'];
                $_arr['email'] = $orderData['billing_email'];
                $_arr['mobile'] = $orderData['billing_phone'];
                $_arr['notify_url'] = rtrim($eshop_url,'/').'/insta_notify';
                    
                //Empty the cart.
                unset($_SESSION['cart']);
                    
                switch($payment_methods):
                    
                    case 'cod':
                            $cod_shop_url = rtrim($eshop_url,'/') . '/cod_notify/' . md5('COD' . $ref_No);
                            
                            redirect($cod_shop_url);
                        break;
                    
                    case 'instamojo':
                            $pay_result = $this->eshop_model->instamojoEshop($_arr);  
                    
                            if(isset($pay_result['longurl']) && !empty($pay_result['longurl'])):
                    
                                redirect($pay_result['longurl']);
                            else:
                                $this->sales_model->deleteSale($order_sale_id);
                                $result['msg'] = $this->instamojo_error($pay_result['error']); 
                                return $result;
                            endif; 
                        break; 
                endswitch;
               
           }//end if.
           
        }//end if
        
    }
    
    public function cod_notify() {
        
        $TransKey = $this->uri->segment(3);    
        $User_id = $this->data['user_id'];
        
        $orderInfo = $this->eshop_model->validateCODSales($TransKey ,$User_id);
                    
        if($orderInfo) {
            $this->data['order_status'] = 'SUCCESS';
            $this->data['order_info'] = $orderInfo[0];
        } else {
            $this->data['order_status'] = 'FAIL';
        }
        
        $this->load_shop_view('cod_notify', $this->data); 
        
    }                
    
    private function insta_notify(){
        
        $payment_request_id = $this->input->get('payment_request_id');    
        $payment_id         = $this->input->get('payment_id');
        
        $this->data['payment_id'] = $payment_id;
        
        if(empty($payment_request_id) || empty($payment_id)):
            $this->data['error'] = 'Error in payment process';   
            $this->load_shop_view('decline_order', $this->data); 
        endif;
        
        $this->load->library('instamojo'); 
        
        $Transaction = $this->eshop_model->getInstamojoEshopTransaction(array('request_id'=>$payment_request_id));  
        $sid = $Transaction->order_id;
        $res12 = $this->eshop_model->updateInstamojoEshopTransaction($payment_request_id,array('payment_id'=>$payment_id)); 
        
        $ci = get_instance();
        $ci->config->load('payment_gateways', TRUE);
        
        $payment_config = $ci->config->item('payment_gateways');
        $instamojo_credential = $payment_config['instamojo'];
        
        try {
	     $api = new Instamojo($instamojo_credential['API_KEY'], $instamojo_credential['AUTH_TOKEN'], $instamojo_credential['API_URL']);
	        $paymentDetail = $api->paymentDetail($payment_id);
	        if(is_array($paymentDetail)):
	            $pay_res = serialize($paymentDetail);
	            $this->eshop_model->updateInstamojoEshopTransaction($payment_request_id,array('success_response'=>$pay_res));
	            if(isset($paymentDetail["status"]) && in_array($paymentDetail["status"],array('Credit','credit','Completed'))):
	                $res = $this->eshop_model->instomojoEshopAfterSale($paymentDetail,$sid);
	                if($res):
                            $this->data['sale'] = $this->eshop_model->getSalesDetails($sale_id);
                            $this->data['success'] = 'Payment done successfully';   
                            $this->load_shop_view('success_order', $this->data);  
	                endif;  
	            endif; 
                        $this->data['error'] = 'Payment process under review';
                        $this->load_shop_view('decline_order', $this->data);
	        endif;
	} catch (Exception $e) { 
	    $this->data['error'] = $e->getMessage();
            $this->load_shop_view('decline_order', $this->data);
	}
        
        $this->data['error'] = 'Payment process under review';      
        $this->load_shop_view('decline_order', $this->data); 
    }                
    
    public function customer_info() {
       return $this->shop_model->getCustomerInfo();    
    }
    
    public function shipping_methods() {
     
        $res = $this->eshop_model->getShippingMethods(array('is_deleted'=>0,'is_active'=>1)); 
        
        return $res;
    }
    
    private function payment_methods($flag=NULL){
        
        $res = $this->pos_model->getSetting();
                    
        $_eshop_cod = isset($res->eshop_cod) && !empty($res->eshop_cod) ? $res->eshop_cod : NUll;
        $_default_eshop_pay = isset($res->default_eshop_pay) && !empty($res->default_eshop_pay) ? $res->default_eshop_pay : NUll;
        
        $_instamozo = isset($res->instamojo) && !empty($res->instamojo) ? $res->instamojo : NUll;
        $_ccavenue  = isset($res->ccavenue)  && !empty($res->ccavenue) ? $res->ccavenue : NUll;
        $result = $payment_list = array();    
        if($_eshop_cod):
            $payment_list['cod'] = 'COD'; 
        endif;
        switch($_default_eshop_pay) {
            
            case 'instamojo':
                    if($_instamozo):
                        $payment_list['instamojo'] = 'Credit Card / Debit Card / Netbanking'; 
                    endif;
                break;
            
            case 'ccavenue':
                    if($_ccavenue):
                        $payment_list['ccavenue'] = 'CCavenue'; 
                    endif;
                break; 
            
            default:
                
                break;
        }  
        if($flag==1){
            return $payment_list;
        }
        if(count($payment_list)):                
            $i=1;
            foreach($payment_list as $payment_key => $payment_name) {
                $result[$i]['id']   = $i;
                $result[$i]['code'] = $payment_key;
                $result[$i]['name'] = $payment_name;
                $i++;
            }
        endif;
        
        return $result;
    }
    
    public function getTaxMethods() {
        
        $result = $this->pos_model->getAllTaxRates();
       
        foreach ($result as $key => $method) {
            $data[$method['id']] = $method;
        }
        
        return $data;
    }
    
    public function getTaxAttribs() {
        
        $result = $this->pos_model->getTaxAttributes();
       
        foreach ($result as $key => $attr) {
            $data[$attr->id] = (array)$attr;
        }
        
        return $data;
    }
        
    public function my_account() {
        
        $this->exitInvalidSession();
        
        $this->data['myorder'] = $this->shop_model->getRecentOrderByUser($this->data['user_id']);
        
        $this->load_shop_view('dashboard', $this->data); 
        
    }
    
    public function myorders() {
        
        $this->exitInvalidSession();
        
        $param['user_id']       = $this->data['user_id'];
        $param['limit']         = 20;
        $param['offset']        = 0;
        $param['sort_field']    = 'sales.eshop_sale';
        $param['sort_dir']      = 'DESC';
        $param['search_by']     = '';
        $param['search_param']  = '';
        
        $this->data['myorder']  = $this->shop_model->getOrdersByUser($param);
        
        $this->load_shop_view('myorders', $this->data); 
        
    }      
    
    public function cancle_order() {
     
        $this->exitInvalidSession();
        
        $TransKey = $_GET['oref'];
        $UserId = $this->data['user_id'];
        
        $OrderDeatil = $this->eshop_model->validateSales(NULL, $UserId,$TransKey);
        
        $redairecturl = rtrim( $this->data['baseurl'],'/') . '/shop/myorders';
        
        if (is_array($OrderDeatil) && count($OrderDeatil) > 0) {
            
            $saleupdate['sale_status'] = 'cancle';
            
                        $this->db->where('id', $TransKey);            
            $result =   $this->db->update('sales',$saleupdate);
            
        
            if($result) {
               $redairecturl .='?act=success';          
            } else {
               $redairecturl .='?act=fail';
            }
            
        } else {
            $redairecturl .='?act=invalid';
        }
        
        redirect($redairecturl);
        
    }
    
    public function orderDetails() { 
        
     $this->exitInvalidSession();
     
        $TransKey = $this->input->get('transaction_key');
        $UserId = $this->input->get('user_id');
        
        $result = array();
        
        if (empty($TransKey) || empty($UserId)) {
            if (empty($TransKey)) {
	        $result['status']     = 'ERROR';
                $result['msg'] = 'TransKey is  empty';
                return $this->json_op($result);
            }
            if (empty($UserId)) {
	        $result['status']     = 'ERROR';
                $result['msg'] = 'UserID is  empty';
                return $this->json_op($result);
            }
        }
        
        $OrderDeatil = $this->eshop_model->validateSales(NULL, $UserId,$TransKey);
        
        $array = array();
        $array['status'] = 'ERROR';
        if (is_array($OrderDeatil) && count($OrderDeatil) > 0) :
            $validOrder = $OrderDeatil[0]['id'];
            $array = array();
            $array['status']     = 'SUCCCESS';
           //--------------Order Details --------------------// 
            $order_details      = $this->site->getSaleByID($validOrder );
           
            $order['sale']     = (array)$order_details;
            
            
            $this->load->model('sales_model');
            
           //--------------Payments Details --------------------//
            $pay_details        = $this->sales_model->getInvoicePayments($validOrder ); 
            $order['payment']   =  $pay_details[0];
            
           
            //-------------- Shipping -------------//
            $deli = $this->sales_model->getDeliveryByID($id);
            $order['delivery']   =  $deli;
            
           //--------------billing_shipping Details --------------------//
            $billing_details        = $this->eshop_model->getOrderDetails(array('sale_id'=>$validOrder));;
            $order['billing_shipping']   = $billing_details[0];
           
            //--------------Item Details --------------------//
            $items_details                  = $this->sales_model->getAllInvoiceItems($validOrder );
            $items_details                  = (array)$items_details;
            $order['items_count'] = count($items_details);
            $i=1;
            foreach ($items_details as $item_details) {
                $order['items'][$i] = $item_details;
                $i++;
            }
            
            $this->data['order'] = $order; 
            
            $html = $this->load->view($this->theme . 'shop/orders_details' , $this->data);
            
	else:
          echo  '<div class="modal-header alert alert-danger">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">Invalid Order</h4>
                </div>';
        endif;  
    } 
    
    public function billing_shipping() {
        
        $this->exitInvalidSession(); 
        
        $this->data['billing_shipping'] = $this->shop_model->get_billing_shipping($this->data['user_id']); 
        
        if($this->data['billing_shipping']===false){
            $this->data['form_action'] = 'insert';
        } else {
             $this->data['form_action'] = 'update';
        }
        
        if(isset($_GET['act']) && !empty($_GET['act'])) {
             $this->data['actmsg'] = $_GET['act'];
        }
        
        $this->load_shop_view('billing_shipping', $this->data); 
        
    }
    
    public function change_password() {
        
        $this->exitInvalidSession(); 
        
        $this->data['user'] = $this->customer_info();
        
        if(isset($_POST['form_action']) && !empty($_POST['form_action'])){
            //form submit change_password
            if($_POST['form_action']=='change_password') {
                
                $result = $this->changeCustomerPasswd();
               
                if($result['status'] == 'SUCCESS') {
                    $this->data['cpactmsg'] = '<div class="alert alert-success">'.$result['msg'].'</div>';
                } else {
                    $this->data['cpactmsg'] = '<div class="alert alert-danger">'.$result['msg'].'</div>';
                }
                
            }//End if change_password
            
            //Form Submit update_profile
            if($_POST['form_action']=='update_profile'){
                
               $userInfo = $this->data['user'];
               $have_change = false;
               
                if($userInfo->name != $_POST['name']){
                    $have_change = true;
                    $postData['name'] = $_POST['name'];
                }
                if($userInfo->email != $_POST['email']){
                    $have_change = true;
                    $postData['email'] = $_POST['email'];
                }
                if($userInfo->company != $_POST['company']){
                    $have_change = true;
                    $postData['company'] = $_POST['company'];
                }
                if($userInfo->gstn_no != $_POST['gstn_no']){
                    $have_change = true;
                    $postData['gstn_no'] = $_POST['gstn_no'];
                }
            
                if($have_change === true) {
                   $result = $this->shop_model->updateCustomerInfo($postData, $_POST['user_id']);
                   if($result){
                       $this->data['actmsg']='<div class="alert alert-success">Profile details has been updated successfully.</div>';
                   } else {
                       $this->data['actmsg']='<div class="alert alert-danger">Error in update profile details.</div>';
                   }
                } else {
                    $this->data['actmsg']='<div class="alert alert-warning">No profile changes found.</div>';
                }
                
            }//end if update_profile
            
        }//end if form_action
        
        
        $this->load_shop_view('change_password', $this->data); 
        
    }
    
    public function changeCustomerPasswd() { 
        
        /* -------------------------------- Form Validation Start  ----------------------------- */
        $this->form_validation->set_rules('user_id', 'User Id', 'numeric|required');
        $this->form_validation->set_rules('password', 'Password ', 'required');
        $this->form_validation->set_rules('new_password', 'New Password ', 'required');
        $this->form_validation->set_rules('confirm_password', 'confirm Password ', 'required');
        if ($this->form_validation->run() === FALSE) {
            $this->validate_error_parsing();
        }
        /* -------------------------------- Form Validation End  ----------------------------- */
            
        $login_id           = $this->input->post('user_id');
        $password           = $this->input->post('password');
        $new_password       = $this->input->post('new_password');
        $confirm_password   = $this->input->post('confirm_password');
        $parra = array('id' => $login_id, 'password' => md5($password)); 
        
        $MsgArr['status'] = 'ERROR';
        
        if (empty($login_id) || empty($password) || empty($new_password)):
            if (empty($login_id)):
                $MsgArr['status'] = 'ERROR';
                $MsgArr['msg'] = "User Id is  required";
                 return $MsgArr;
            endif;
            if (empty($password)):
                $MsgArr['status'] = 'ERROR';
                $MsgArr['msg'] = "Password is  required";
                return $MsgArr;
            endif;
            if (empty($new_password)):
                $MsgArr['status'] = 'ERROR';
                $MsgArr['msg'] = "New password is  required";
                 return $MsgArr;
            endif;

            return  $MsgArr;
            
        else:
                if ( $new_password !=  $confirm_password):
                $MsgArr['status'] = 'ERROR';
                $MsgArr['msg'] = "Password not match";
                 return $MsgArr;
            endif;

            $res = $this->shop_model->getCompanyCustomer(array('id' => $login_id, 'password' => md5($password)));
          
            if (!is_object($res)):
                $MsgArr['status'] = 'ERROR';
                $MsgArr['msg'] = "Invalid current password";
                return $MsgArr;
            else:
                $res1 = $this->shop_model->updateCompany($res->id, array('password' => md5($new_password)));
             
                if ($res1):
                    $MsgArr['status'] = 'SUCCESS';
                    $MsgArr['msg'] = "password has been updated successfully";
                    return $MsgArr;
                endif;
                $MsgArr['status'] = 'ERROR';
                $MsgArr['msg'] = "New has not been updated successfully";
                    return $MsgArr;  
            endif;
           
        endif;
    }
        
    public function save_billing_shipping() {
        
        $this->exitInvalidSession();
            
        foreach ($_POST as $key => $value) {
            
            if(in_array($key, ['submit', 'user_id','form_action']))  continue;
            $data[$key] = $value;
        } 
        
        if($_POST['form_action']=='update') {            
            $this->db->where('user_id', $_POST['user_id']);
            $result = $this->db->update('eshop_user_details', $data);
        }
        
        if($_POST['form_action']=='insert') {             
            $data['user_id'] = $_POST['user_id'];
            $result = $this->db->insert('eshop_user_details', $data);
        }
        
        $redairecturl = rtrim( $this->data['baseurl'],'/') . '/shop/billing_shipping';
        
        if($result) {
           $redairecturl .='?act=success';          
        } else {
           $redairecturl .='?act=fail';
        }
            
        redirect($redairecturl);
        
    }
    
    public function about_us() {
        
        $this->exitInvalidSession();
        
        $this->data['page_containt'] = $this->shop_pages();
        
        $this->load_shop_view('about_us', $this->data); 
        
    }
        
    public function contact() {
        
        $this->exitInvalidSession();
        
        $this->data['page_containt'] = $this->shop_pages();
         
        $this->load_shop_view('contact', $this->data); 
        
    }
        
    public function faq() {
        
        $this->exitInvalidSession();
        
        $this->data['page_containt'] = $this->shop_pages();
         
        $this->load_shop_view('faq', $this->data); 
        
    }
    
    public function privacy_policy() {
        
        $this->exitInvalidSession();
        
        $this->data['page_containt'] = $this->shop_pages();
         
        $this->load_shop_view('privacy_policy', $this->data); 
        
    }
    
    public function terms_conditions() {
        
        $this->exitInvalidSession();
        
        $this->data['page_containt'] = $this->shop_pages();
         
        $this->load_shop_view('terms_conditions', $this->data); 
        
    }
    
    public function shop_pages(){ 
        
        $result = array();
        
        $res = $this->shop_model->getStaticPages(array('id'=>1));
        if(!$res->id){            
            $result = '<h2>Sorry! Pages containt yet not updated</h2>';           
        } else {            
            $result = $res;
        }
        
        return $result;
    }
    
    
    
    
    
    
    public function login()  {   
        $this->welcomeValidSession();
		//var_dump(); exit;
        // create curl resource 
        $ch = curl_init(); 

        // set url 
        curl_setopt($ch, CURLOPT_URL, "https://simplypos.in/api/merchant-api.php?action=marchantNo&merchant=".$_SERVER['HTTP_HOST']); 

        //return the transfer as a string 
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);

        // $output contains the output string 
        $output = curl_exec($ch); 
		$arr = json_decode($output);
		$this->data['phone'] = $arr->phone;
        $this->load_shop_view( 'login', $this->data);   
    }
    
    public function logout() {
        
        $this->shop_model->end_user_session();  
        $this->authenticate(); 
    }
    
    public function authcheck() {
        
        if(isset($_POST['btn_submit']) && $_POST['btn_submit'] === 'Authentication'){
            
            $authData['login_id'] = $_POST['login_id'];
            $authData['password'] = $_POST['login_passkey'];
            
            $responce = $this->shop_model->authenticate_user($authData);           
            
            if(is_array($responce)) 
            {
                if( $responce['status']=='SUCCESS') {
                   
                   $authData = $responce['result'][0]; 
                   
                   $this->shop_model->set_user_session($authData);
                   redirect('shop/welcome');
                } else {
                    $this->data['login_error'] = $responce['error'];
                    $this->load_shop_view('login', $this->data);
                }//end else.
            }
            
        } else {
             redirect('shop/login');
        }
         
    }
    
    
}
