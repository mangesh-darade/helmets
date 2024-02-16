<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Shop_model extends CI_Model {

    public $errors;
    public $messages;
    public $basePath;
    public $apiResponce;
    public $apiUrl;

    public function __construct() {
        parent::__construct();

        //initialize messages and error
        $this->messages = array();
        $this->errors = array();
        $this->basePath = base_url();
        $this->apiResponce = '';
        $this->apiUrl = '';
    }

    public function get_setting() {
        $q = $this->db->select('setting_id,logo,logo2,default_warehouse,default_currency,default_tax_rate,symbol,pos_type')
                ->get('settings');

        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getOrdertax() {
        $q = $this->db->select('sma_tax_rates.id, sma_tax_rates.name, sma_tax_rates.type, sma_tax_rates.rate,')->join('sma_tax_rates', 'sma_pos_settings.eshop_order_tax = sma_tax_rates.id', 'inner')
                ->get('sma_pos_settings');
//            echo '<pre>';
//            print_r($q->row_array());exit;

        return $q->row_array();
        echo $data['name'];

        $this->load_shop_view($this->shoptheme . '/checkout', $data);
        // print_r($data);
    }

    public function postUrl($url, $data = array()) {

        if (is_array($data)) {
            foreach ($data as $key => $value) {
                $postDataArr[] = $key . "=" . $value;
            }

            $postData = join('&', $postDataArr);
        } else {
            $postData = '';
        }

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 30,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "POST",
            CURLOPT_POSTFIELDS => $postData,
            CURLOPT_HTTPHEADER => array(
                "cache-control: no-cache",
                "content-type: application/x-www-form-urlencoded",
                "postman-token: 3bda5de7-1610-baef-2618-ff16b9dce0da"
            ),
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            echo "API Error :" . $err;
            exit;
        } else {
            return $response;
        }
    }

    public function isJSON($string) {
        return is_string($string) && is_array(json_decode($string, true)) ? true : false;
    }

    public function JSon2Arr($string) {

        if ($this->isJSon($string)) {
            return (array) json_decode($string, true);
        }

        return $string;
    }

    public function Arr2JSon(array $arr) {

        if (is_array($arr)) {
            return json_encode($arr, true);
        }

        return $arr;
    }

    /**     * 
     * @param array $userData = Array("id"=>"125","name"=>"Jon Thomas","phone"=>"1111111111","email"=>"jonthomas@gmail.com","auth_token"=>"zO15IBpmeuxGb9N4dAEXCQK2g")
     */
    public function set_user_session($userData) {

        $this->session->set_userdata($userData);
    }

    /**
     * 
     * @return boolean
     */
    public function session_authenticate() {

        if ($this->session->has_userdata('id') && $this->session->has_userdata('auth_token')) {
            return $this->session->has_userdata('id');
        } else {
            return false;
        }
    }

    /**
     * 
     */
    public function destory_user_token() {
        $this->session->unset_userdata('auth_token');
    }

    public function end_user_session() {

        $array_items = ['id', 'name', 'phone', 'email', 'auth_token'];
        $this->session->unset_userdata($array_items);
        session_destroy();
    }

    /**
     * 
     * @param array $authData
     * @return type
     */
    public function authenticate_user(array $authData) {

        $this->apiUrl = $this->basePath . "api/user?action=auth";

        $this->apiResponce = $this->postUrl($this->apiUrl, $authData);

        return $this->JSon2Arr($this->apiResponce);
    }

    public function getAuthCustomer(array $param) {

        $loginid = $param['login_id'];
        $password = md5($param['password']);
        $data['status'] = 'ERROR';
        $where = "password='$password' AND ( email='$loginid' OR phone='$loginid' )";

        $this->db->select('id,name,email,phone,mobile_verification_code,email_verification_code,email_is_verified,mobile_is_verified');
        $this->db->where($where);
        $this->db->limit(1, 0);
        $q = $this->db->get('companies');
        //  echo $this->db->last_query(); 

        if ($q->num_rows() > 0) {
            $data['status'] = 'SUCCESS';
            $data['result'] = $q->result_array();
        } else {
            $data['error'] = "Invalid User Input";
        }

        return $data;
    }

    public function getCustomerInfo() {

        $id = $this->session->userdata('id');

        $q = $this->db->select('id,name, company, vat_no, address, city, state, postal_code, country, phone, email, dob, gstn_no')
                ->where(array('group_name' => 'customer', 'id' => $id))
                ->get('companies');

        if ($q->num_rows() > 0) {
            $data = (array) $q->result();
            return $data[0];
        }

        return false;
    }

    public function updateCustomerInfo(array $data, $id = '') {

        if (!$id) {
            $id = $this->session->userdata('id');
        }

        $this->db->where('id', $id);
        $q = $this->db->update('companies', $data);

        if ($q) {
            return true;
        }

        return false;
    }

    public function storeDetails() {

        $this->apiUrl = $this->basePath . "api/store?action=generalDetails";

        $this->apiResponce = $this->JSon2Arr($this->postUrl($this->apiUrl, $authData = ''));

        return $this->apiResponce['setting'];
    }

    public function getProducts($cat_id, $keyword = '', $limit = 20, $offset = 0) {

        $this->apiUrl = $this->basePath . "api/catlog?action=allProducts";

        $authData['category_id'] = $cat_id;
        $authData['limit'] = $limit;
        $authData['offset'] = $offset;

        if (!empty($keyword)) {
            $authData['keyword'] = $keyword;
        }

        $this->apiResponce = $this->JSon2Arr($this->postUrl($this->apiUrl, $authData));

        return $this->apiResponce;
    }

    public function getUnites() {

        $q = $this->db->select('`id`, `code`,`name`')
                ->get('units');

        $count = $q->num_rows();

        $data = [];

        if ($count > 0) {
            $rowArr = $q->result();
            foreach ($rowArr as $row) {

                $data[$row->id] = (array) $row;
            }
        }

        return $data;
    }

    public function getProductInfo($product_ids) {

        $q = $this->db->select('`id`, `code`,`name`,`image`,`unit`,`cost`,`price`,`category_id`,`subcategory_id`,`cf1`,`cf2`,`tax_rate`, `tax_method`, `type`, `sale_unit`,`purchase_unit`,`brand`,`hsn_code`')
                ->where_in('id', $product_ids)
                ->get('products');

        $count = $q->num_rows();

        $data = [];

        if ($count > 0) {
            $rowArr = $q->result();
            foreach ($rowArr as $row) {

                $data[$row->id] = (array) $row;
            }
        }

        return $data;
    }
    
    public function getProductVeriantsInfo($pvid) {

        $q = $this->db->select('`id`,`name`,`cost`,`price`,`quantity`')
                ->where_in('id', $pvid)
                ->get('product_variants');

        $count = $q->num_rows();

        $data = [];

        if ($count > 0) {
            $rowArr = $q->result();
            //print_r($rowArr);
            foreach ($rowArr as $row) {

                $data[$row->id] = (array)$row;
            }
            return $data;
        }
        return false;
    }

    public function getProductInfovariant($product_ids) {
        $data = [];
        if (is_array($product_ids)) {
            
            foreach ($product_ids as $ids) {
                
                $ArrExplode = explode('_', $ids);
                $item_id = $ArrExplode[0];
                $option_id = $ArrExplode[1];
                $Opt = '';
                if ($option_id) { $Opt = ', `pv`.`id` as `option_id`, `pv`.`name` as `vname`'; }
                
                $q = "SELECT `p`.`id`, `p`.`code`, `p`.`name`, `p`.`image`, `p`.`unit`, `p`.`cost`, `p`.`price`, `p`.`category_id`, `p`.`subcategory_id`, `p`.`cf1`, `p`.`cf2`, `p`.`tax_rate`, `p`.`tax_method`, `p`.`type`, `p`.`sale_unit`, `p`.`purchase_unit`, `p`.`brand`, `p`.`hsn_code` " . $Opt . " FROM `sma_products` `p` ";
                
                if ($option_id) { $q .= " inner JOIN `sma_product_variants` `pv` ON `pv`.`product_id` = `p`.`id`"; }
                
                $q .= " WHERE `p`.`id` IN($item_id)";
                
                if ($option_id) { $q .= " and pv.id='" . $option_id . "'"; }
                
                $qr = $this->db->query($q);
            
                $count = $qr->num_rows();

                if ($count > 0) {
                    $rowArr = $qr->result();
                    foreach ($rowArr as $row) {
                        //echo $row->id.'_'.$row->option_id;
                        $data[$ids] = (array) $row;
                    }
                }
            }
            return $data;
        }
        return false;
    }

    public function getProductInfoByHash($product_hash) {

        $q = $this->db->select('`id`, `code`,`name`,`image`,`unit`,`cost`,`price`,`category_id`,`subcategory_id`,`cf1`,`cf2`,`tax_rate`, `tax_method`, `type`, `sale_unit`,`purchase_unit`,`brand`,`hsn_code`,`details`,`product_details`,`promotion`,`promo_price`,`start_date`,`end_date`')
                ->where_in('md5(id)', $product_hash)
                ->get('products');

        $count = $q->num_rows();
        if ($count > 0) {
            $row = $q->result();
            return (array) $row[0];
        }

        return false;
    }

    public function getProductVeriantsByHash($product_hash) {

        $q = $this->db->select('`id`,`name`,`cost`,`price`,`quantity`')
                ->where_in('md5(product_id)', $product_hash)
                ->get('product_variants');

        $count = $q->num_rows();

        $data = [];

        if ($count > 0) {
            $rowArr = $q->result();
            foreach ($rowArr as $row) {

                $data[$row->id] = $row;
            }
            return $data;
        }

        return false;
    }

    public function getProductVeriantsById($product_hash) {

        $q = $this->db->select('`id`,`name`,`cost`,`price`,`quantity`')
                ->where_in('(product_id)', $product_hash)
                ->get('product_variants');

        $count = $q->num_rows();

        $data = [];

        if ($count > 0) {
            $rowArr = $q->result();
            //print_r($rowArr);
            foreach ($rowArr as $row) {

                $data[$row->id] = $row;
            }
            return $data;
        }
        return false;
    }

    public function getProductImagesByHash($product_hash) {

        $q = $this->db->select('`id`,`photo`')
                ->where_in('md5(product_id)', $product_hash)
                ->get('product_photos');

        $count = $q->num_rows();

        $data = [];

        if ($count > 0) {
            $rowArr = $q->result();
            foreach ($rowArr as $row) {

                $data[] = $row;
            }
            return $data;
        }

        return false;
    }

    /*
     * Para: $category_hash should be md5() hash of category_id
     */

    public function getCategoryProducts($category, $pageno = 1, $itemsPerPage = 20) {
        if (is_numeric($category)) {
            $data['count'] = 0;
            $category_hash = md5($category);
        } else {
            $category_hash = $category;
        }

        $offset = ( $pageno - 1 ) * $itemsPerPage;

        for ($i = 1; $i <= 2; $i++) {

            if ($i == 1) {
                $this->db->select('`id`');
            } else {
                $this->db->select('`id`, `code`,`name`,`image`,`unit`,`cost`,`price`,`category_id`,`subcategory_id`,`cf1`,`cf2`,`tax_rate`, `tax_method`, `type`, `sale_unit`,`purchase_unit`,`brand`,`hsn_code`');
            }

            $this->db->where(['md5(category_id)' => $category_hash]);

            $this->db->or_where('md5(subcategory_id)', $category_hash);

            if ($i == 2) {

                $offset = ($pageno - 1 ) * $itemsPerPage;

                $this->db->limit($itemsPerPage, $offset);
                //$this->db->limit($itemsPerPage);
            }
            $var = 'q' . $i;
            $$var = $this->db->get('products');
        }//end for.

        $count = $q1->num_rows();
        $data['count'] = $count;
        $data['totalPages'] = ceil($count / $itemsPerPage);

        if ($count > 0) {
            $data['msg'] = '<div class="alert alert-info">Result: ' . $count . ' products found.</div>';

            foreach (($q2->result()) as $row) {
                $data['items'][] = (array) $row;
            }
        } else {
            $data['msg'] = '<div class="alert alert-info">Products not found in this category</div>';
        }
        return $data;
    }

    public function getHotProducts($limit = 8) {
        $sql = "SELECT `id`,`code`, `name`, `price`, `image` "
                . "FROM `sma_products` "
                . "WHERE `id` IN ( SELECT `product_id` FROM `sma_sale_items` group by `product_code` order by count(`product_name`) desc ) limit $limit ";

        $rec = $this->db->query($sql);

        if ($rec->num_rows()) {
            return $rec->result_array();
        }

        return FALSE;
    }

    public function searchProducts($keyword, $pageno = 1, $itemsPerPage = 20) {
        if (empty($keyword)) {

            $data['count'] = 0;
            $data['msg'] = '<div class="alert alert-danger">Invalid keyword</div>';
            return $data;
        }

        $offset = ( $pageno - 1 ) * $itemsPerPage;

        for ($i = 1; $i <= 2; $i++) {

            if ($i == 1) {
                $this->db->select('`id`');
            } else {
                $this->db->select('`id`, `code`,`name`,`image`,`unit`,`cost`,`price`,`category_id`,`subcategory_id`,`cf1`,`cf2`,`tax_rate`, `tax_method`, `type`, `sale_unit`,`purchase_unit`,`brand`,`hsn_code`');
            }

            $this->db->like('name', $keyword);
            $this->db->or_like('code', $keyword);
            $this->db->or_like('hsn_code', $keyword);

            if ($i == 2) {

                $offset = ($pageno - 1 ) * $itemsPerPage;

                $this->db->limit($itemsPerPage, $offset);
                //$this->db->limit($itemsPerPage);
            }
            $var = 'q' . $i;
            $$var = $this->db->get('products');
        }//end for.

        $count = $q1->num_rows();
        $data['count'] = $count;
        $data['totalPages'] = ceil($count / $itemsPerPage);

        if ($count > 0) {
            $data['msg'] = '<div class="alert alert-info">Result: ' . $count . ' products found.</div>';

            foreach (($q2->result()) as $row) {
                $data['items'][] = (array) $row;
            }
        } else {
            $data['msg'] = '<div class="alert alert-info">Result: ' . $count . ' products found.</div>';
        }
        return $data;
    }

    public function ____searchProducts($keyword, $pageno = 1, $itemsPerPage = 12) {
        if (empty($keyword))
            return false;

        $this->db->select('`id`, `code`,`name`,`image`,`unit`,`cost`,`price`,`category_id`,`subcategory_id`,`cf1`,`cf2`,`tax_rate`, `tax_method`, `type`, `sale_unit`,`purchase_unit`,`brand`,`hsn_code`');

        $this->db->like('name', $keyword);
        $this->db->or_like('code', $keyword);
        $this->db->or_like('hsn_code', $keyword);

        $offset = ( $pageno - 1 ) * $itemsPerPage;

        $this->db->limit($offset, $itemsPerPage);

        $q = $this->db->get('products');
        $count = $q->num_rows();
        $data['count'] = $count;

        if ($count > 0) {
            foreach (($q->result()) as $row) {
                $data['items'] = $row;
            }
        }
        return $this->Arr2JSon($data);
    }

    public function getCategory($type = 'ALL', $key = '') {

        switch ($type) {
            case 'PARENT':
                $action = "?action=allParentCategories";
                break;

            case 'CHILD':
                $action = "?action=allSubcategories&parent_id=" . $key;
                break;

            case 'SEARCH':
                $action = "?action=allCategories&keyword=" . $key;
                break;

            default:
            case 'ALL':
                $action = "?action=allCategories";
                break;
        }

        $this->apiUrl = $this->basePath . "api/catlog" . $action;

        $this->apiResponce = $this->JSon2Arr($this->postUrl($this->apiUrl, $authData = ''));

        return $this->apiResponce;
    }

    public function getCategoryName($id) {
        $q = $this->db->select('name')->get_where('categories', ['id' => $id]);
        if ($q->num_rows() > 0) {
            $row = $q->result_array();
            return $row[0]['name'];
        }
        return false;
    }

    public function searchCategory($searchkey = '') {

        if (empty($searchkey) || strlen($searchkey) < 3)
            return false;

        $this->db->select('`id`, `code`,`name`,`image`');
        $this->db->like('name', $searchkey);
        $this->db->limit(0, 5);
        $q = $this->db->get('categories');

        if ($q->num_rows() > 0) {

            $list = (array) $q->result();

            return $list;
        }

        return false;
    }

    public function getParentCategories() {

        $query = "SELECT `id`, `code` ,`name` ,`image` ,
                        `id` as cat_id,(select count(id) from sma_categories where 
                        `parent_id`=`cat_id`) as subcat_count,
                        (SELECT count(`id`)  
                                FROM `sma_products` where `category_id` = `sma_categories`.`id` ) as products_count,
                        IF(parent_id IS NULL,0,parent_id) as parent_id                        
                        FROM `sma_categories`                        
                        WHERE `id` in (SELECT `category_id` 
                                FROM `sma_products` group by `category_id`) 
                  ORDER BY `sma_categories`.`name` ASC";

        $q = $this->db->query($query);

        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return FALSE;
    }

    public function getChildCategories($parent_id) {

        $query = "SELECT `id`, `code` ,`name` ,`image` ,
                        `id` as subcat_id,(select count(id) from sma_categories where 
                        `parent_id`=`subcat_id`) as subcat_count,
                        (SELECT count(`id`)  
                                FROM `sma_products` 
                                where `subcategory_id` = `sma_categories`.`id` and `category_id` = '$parent_id') as products_count,
                        IF(parent_id IS NULL,0,parent_id) as parent_id                        
                        FROM `sma_categories`                        
                        WHERE `id` in (SELECT `subcategory_id` 
                                FROM `sma_products` 
                                where `category_id` = '$parent_id' group by `subcategory_id`) 
                  ORDER BY `sma_categories`.`name` ASC";

        $q = $this->db->query($query);

        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return FALSE;
    }

    public function getAllChildCategories() {

        $query = "SELECT `id`, `code` ,`name` ,`image` ,
                        `id` as subcat_id, parent_id,
                        (SELECT count(`id`)  
                                FROM `sma_products` 
                                where `subcategory_id` = `sma_categories`.`id`) as products_count,
                        IF(parent_id IS NULL,0,parent_id) as parent_id                        
                        FROM `sma_categories`                        
                        WHERE `id` in (SELECT `subcategory_id` 
                                FROM `sma_products` 
                                group by `subcategory_id`) 
                  ORDER BY `sma_categories`.`name` ASC";

        $q = $this->db->query($query);

        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return FALSE;
    }

    public function category_navigation($category) {

        if (is_numeric($category)) {
            $category_hash = md5($category);
        } else {
            $category_hash = $category;
        }

        $query = "SELECT `name` as category,                    
                        IF(parent_id IS NULL,NULL,
                            (SELECT `name` FROM `sma_categories` WHERE `id` = A.`parent_id` )
                        ) as parent ,
                        (SELECT count(`id`)  
                                FROM `sma_products` 
                                where md5(`subcategory_id`) = '$category_hash' OR md5(`category_id`) = '$category_hash') as products_count
                        
                        FROM `sma_categories` A                        
                        WHERE md5(`id`) = '$category_hash' LIMIT 1";

        $q = $this->db->query($query);

        if ($q->num_rows() > 0) {
            return $q->result_array();
        }
        return FALSE;
    }

    public function getRecentOrderByUser($User_id) {

        if (empty($User_id)):
            return false;
        endif;

        $this->db->select("sales.id as order_id,sales.reference_no as order_no,DATE_FORMAT(sma_sales.date,'%b %d %Y %h:%i %p') as order_date,"
                . "sales.payment_status ,payments.reference_no as payment_no,payments.transaction_id as transaction_no"
                . ", deliveries.do_reference_no  as delivery_reference_no"
                . ", deliveries.status  as delivery_status"
        );
        $this->db->from('sales');
        $this->db->join('payments', 'sales.id =  payments.sale_id', 'left');
        $this->db->join('deliveries', 'sales.id =  deliveries.sale_id', 'left');
        $this->db->where('sales.customer_id', $User_id);
        $this->db->where("sales.eshop_sale='1'");
        $this->db->order_by('sales.date', 'DESC');
        $this->db->limit(5, 0);

        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            $i = 1;
            foreach (($q->result()) as $row) {
                if (!empty($row->delivery_status)):
                    $row->order_status = @ucfirst($row->delivery_status);
                elseif (!empty($row->payment_status)):
                    $row->order_status = ($row->payment_status == 'due') ? 'Payment due' : @ucfirst($row->payment_status);
                else :
                    $row->order_status = 'Payment due';
                endif;

                $data[] = $row;
                $i++;
            }
            return $data;
        }
        return FALSE;
    }

    public function getOrdersByUser($param) {
        $User_id = isset($param['user_id']) && !empty($param['user_id']) ? $param['user_id'] : NULL;
        $limit = isset($param['limit']) && !empty($param['limit']) ? $param['limit'] : NULL;
        $offset = isset($param['offset']) && !empty($param['offset']) ? $param['offset'] : 0;
        $sort_field = isset($param['sort_field']) && !empty($param['sort_field']) ? $param['sort_field'] : 'sales.id';
        $sort_dir = isset($param['sort_dir']) && !empty($param['sort_dir']) ? $param['sort_dir'] : 'desc';
        $search_by = isset($param['search_by']) && !empty($param['search_by']) ? $param['search_by'] : NULL;
        $search_param = isset($param['search_param']) && !empty($param['search_param']) ? $param['search_param'] : NULL;

        if (!empty($search_by) && is_array($search_param)):
            switch ($search_by) {
                case 'order_ref':
                    if (empty($search_param['order_ref'])):
                        return false;
                    endif;
                    $this->db->where('sales.reference_no', $search_param['order_ref']);
                    break;

                case 'order_date':
                    if (empty($search_param['order_date1']) || empty($search_param['order_date2'])):
                        return false;
                    endif;
                    $this->db->where('date(sales.`date`) between  ' . " '" . $search_param['order_date1'] . "'  and '" . $search_param['order_date2'] . "' ");
                    break;

                case 'pay_status':
                    if (empty($search_param['pay_status'])):
                        return false;
                    endif;
                    $this->db->where('sales.payment_status', $search_param['pay_status']);
                    break;

                case 'pay_ref':
                    if (empty($search_param['pay_ref'])):
                        return false;
                    endif;
                    $this->db->where('payments.reference_no', $search_param['pay_ref']);
                    break;

                case 'pay_trans':
                    if (empty($search_param['pay_trans'])):
                        return false;
                    endif;
                    $this->db->where('payments.transaction_id', $search_param['pay_trans']);
                    break;

                default:
                    break;
            }
        endif;

        if (empty($User_id)):
            return false;
        endif;

        $this->db->select("sales.id as order_id,sales.reference_no as order_no,DATE_FORMAT(sma_sales.date,'%b %d %Y %h:%i %p') as order_date,"
                . "sales.payment_status ,sales.sale_status ,payments.reference_no as payment_no,payments.transaction_id as transaction_no"
                . ", deliveries.do_reference_no  as delivery_reference_no"
                . ", deliveries.status  as delivery_status"
        );
        $this->db->from('sales');
        $this->db->join('payments', 'sales.id =  payments.sale_id', 'left');
        $this->db->join('deliveries', 'sales.id =  deliveries.sale_id', 'left');
        $this->db->order_by('sales.date', 'desc');
        $this->db->where('sales.customer_id', $User_id);
        $this->db->where("sales.eshop_sale='1'");

        //--------------SORT ------------------------------
        if (!empty($sort_field) && !empty($sort_dir)):
            $this->db->order_by($sort_field, $sort_dir);
        endif;

        //--------------Limit ------------------------------
        if (!empty($limit) && !empty($offset)):
            $this->db->limit($limit, $offset);
        endif;

        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            $i = 1;
            foreach (($q->result()) as $row) {
                if (!empty($row->delivery_status)):
                    $row->order_status = @ucfirst($row->delivery_status);
                elseif (!empty($row->payment_status)):
                    $row->order_status = ($row->payment_status == 'due') ? 'Payment due' : @ucfirst($row->payment_status);
                else :
                    $row->order_status = 'Payment due';
                endif;

                $data[] = $row;
                $i++;
            }
            return $data;
        }
        return FALSE;
    }

    public function get_billing_shipping($user_id) {

        $q = $this->db->get_where("eshop_user_details", array("user_id" => $user_id));

        if ($q->num_rows() > 0) {

            return $q->result();
        }

        return false;
    }

    public function getCompanyCustomer($arr) {

        if (is_array($arr)):
            $q = $this->db->get_where('companies', $arr, 1);
            //    echo $this->db->last_query(); 

            if ($q->num_rows() > 0) {
                return $q->row();
            }
        endif;

        return FALSE;
    }

    public function updateCompany($id, $data = array()) {
        $this->db->where('id', $id);
        if (!isset($data['is_synced'])):
            $data['is_synced'] = 0;
        endif;
        if ($this->db->update('companies', $data)) {
            if ($data['group_id'] == 3 && $data['is_synced'] != 1):
                $coustmer = $this->getCompanyByID($id);
                $this->load->library('sma');
                $this->sma->SyncCustomerData($coustmer);
            endif;
            return true;
        }
        return false;
    }

    public function getStaticPages($arr) {
        if (is_array($arr)):
            $q = $this->db->get_where('eshop_pages', $arr, 1);
            if ($q->num_rows() > 0) {
                return $q->row();
            }
        endif;
        return FALSE;
    }

    public function addPayment($data = array()) {
        if ($this->db->insert('payments', $data)) {
            if ($this->site->getReference('pay') == $data['reference_no']) {
                $this->site->updateReference('pay');
            }
            return true;
        }
        return false;
    }

    public function updateStatus($id, $status, $note, $payStatus = '') {
        $sale = $this->getInvoiceByID($id);
        $items = $this->getAllInvoiceItems($id);
        $cost = array();
        if ($status == 'completed' && $status != $sale->sale_status) {
            foreach ($items as $item) {
                $items_array[] = (array) $item;
            }
            $cost = $this->site->costing($items_array);
        }

        $payment_status = (empty($payStatus)) ? $sale->payment_status : $payStatus;

        if ($this->db->update('sales', array('sale_status' => $status, 'payment_status' => $payment_status, 'note' => $note), array('id' => $id))) {

            if ($status == 'completed' && $status != $sale->sale_status) {

                foreach ($items as $item) {
                    $item = (array) $item;
                    if ($this->site->getProductByID($item['product_id'])) {
                        $item_costs = $this->site->item_costing($item);
                        foreach ($item_costs as $item_cost) {
                            $item_cost['sale_item_id'] = $item['id'];
                            $item_cost['sale_id'] = $id;
                            if (!isset($item_cost['pi_overselling'])) {
                                $this->db->insert('costing', $item_cost);
                            }
                        }
                    }
                }
            } elseif ($status != 'completed' && $sale->sale_status == 'completed') {
                $this->resetSaleActions($id);
            }

            if (!empty($cost)) {
                $this->site->syncPurchaseItems($cost);
            }
            return true;
        }
        return false;
    }

    public function getCustomerByID($id) {
        $q = $this->db->select('id,name,email,phone,mobile_verification_code,email_verification_code,email_is_verified,mobile_is_verified,address,city,state,country,postal_code,company,vat_no,gstn_no')
                ->get_where('companies', array('id' => $id), 1);

        if ($q->num_rows() > 0) {
            return (array) $q->row();
        }
        return 0;
    }

    public function getCustomerByEmail($email) {
        $q = $this->db->select('id,name,email,phone,mobile_verification_code,email_verification_code,email_is_verified,mobile_is_verified')
                ->get_where('companies', array('email' => $email), 1);
        if ($q->num_rows() > 0) {
            return (array) $q->row();
        }
        return 0;
    }

    public function getCustomerByloginId($loginid) {
        $q = $this->db->select('id,name,email,phone,mobile_verification_code,email_verification_code,email_is_verified,mobile_is_verified')
                ->where(['phone' => $loginid])
                ->or_where(['email' => $loginid])
                ->get('companies');
        if ($q->num_rows() > 0) {
            return (array) $q->row();
        }
        return 0;
    }

    public function getInvoiceByID($id) {
        $q = $this->db->get_where('sales', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getAllInvoiceItems($sale_id, $return_id = NULL) {
        $this->db->select('sale_items.*, tax_rates.code as tax_code, tax_rates.name as tax_name, tax_rates.rate as tax_rate, products.image, products.details as details, product_variants.name as variant')
                ->join('products', 'products.id=sale_items.product_id', 'left')
                ->join('product_variants', 'product_variants.id=sale_items.option_id', 'left')
                ->join('tax_rates', 'tax_rates.id=sale_items.tax_rate_id', 'left')
                ->group_by('sale_items.id')
                ->order_by('id', 'asc');
        if ($sale_id && !$return_id) {
            $this->db->where('sale_id', $sale_id);
        } elseif ($return_id) {
            $this->db->where('sale_id', $return_id);
        }
        $q = $this->db->get('sale_items');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getProductPhotos($id) {
        $q = $this->db->get_where("product_photos", array('product_id' => $id));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {

                $data[] = $row;
            }
            return $data;
        }
    }

    //15/07/2019
    public function addWishList($data) {
        $userId = $data[0];
        $prodId = $data[1];
        $this->db->where('product_id', $prodId);
        $q = $this->db->get('eshop_wishlist');

        if ($q->num_rows() > 0) {
            $this->db->where('product_id', $prodId);
            $this->db->update('eshop_wishlist', array('user_id' => $userId, 'product_id' => $prodId, 'date' => date('Y-m-d H:i:s')));
        } else {
            $this->db->set('product_id', $prodId);
            $this->db->insert('eshop_wishlist', array('user_id' => $userId, 'product_id' => $prodId, 'date' => date('Y-m-d H:i:s')));
        }
        return true;
    }

    public function getWishListItems($userId) {
        $q = $this->db->select('sma_eshop_wishlist.*, sma_products.name, sma_products.price, sma_products.image')
                ->join('sma_products', 'sma_eshop_wishlist.product_id = sma_products.id', 'inner')
                ->where('user_id', $userId)
                ->order_by('sma_eshop_wishlist.id', 'desc')
                ->get('sma_eshop_wishlist');
        $count = $q->num_rows();
        if ($count > 0)
            $result = $q->result_array();
        return array('count' => $count, 'result' => $result);
    }

    public function brandList() {
        $q = $this->db->select('*')
                ->get('sma_brands');
        $row = $q->result_array();
        return $row;
    }

    public function FilterproductsData($getvar) {

        $catId = $getvar['catId'];
        $brandId = $getvar['BrandsId'];
        $PriceVal = $getvar['PriceVal'];
        $pageno = $getvar['pageno'];
        $itemsPerPage = $getvar['itemsPerPage'] ? $getvar['itemsPerPage'] : 20;
        $catIdss = explode('_', $catId);
        $brandIdss = explode('_', $brandId);
        $PriceVal1 = explode('_', $PriceVal);
        $pricvals = array_values($PriceVal1);
        $pricval = [];
        foreach ($pricvals as $pricvalkey => $pricvalss) {
            $pricvalss1 = explode('~', $pricvalss);
            $pricval[] = array_values($pricvalss1);
        }
        $priceArr = call_user_func_array('array_merge', $pricval);
        $priceMin = min($priceArr);
        $priceMax = max($priceArr);
        $sql = "SELECT count(id) as count FROM sma_products WHERE code != '' ";
        $this->db->select('`id`, `code`,`name`,`image`,`unit`,`cost`,`price`,`category_id`,`subcategory_id`,`cf1`,`cf2`,`tax_rate`, `tax_method`, `type`, `sale_unit`,`purchase_unit`,`brand`,`hsn_code`');

        if ($catId != "") {
            $this->db->where_in('category_id', $catIdss);
            $sql .= " AND category_id IN (" . join(',', $catIdss) . ") ";
        }
        if (($brandId) != "") {
            $this->db->where_in('brand', $brandIdss);
            $sql .= " AND brand IN (" . join(',', $brandIdss) . ") ";
        }
        if ($PriceVal != "") {
            $this->db->where("price BETWEEN '$priceMin' AND '$priceMax'");
            $sql .= " AND price  BETWEEN '$priceMin' AND '$priceMax' ";
        }

        $offset = ($pageno - 1 ) * $itemsPerPage;

        $this->db->limit($itemsPerPage, $offset);

        $q = $this->db->get('sma_products');

        $sqlcount = $this->db->query($sql)->result();

        $count = $sqlcount[0]->count;
        // $data['sqlcount'] =  $sqlcount;
        $data['count'] = $count;
        $data['totalPages'] = ($count) ? ceil($count / $itemsPerPage) : 0;
        if ($q->num_rows() > 0) {
            $data['rows'] = $q->result_array();
        }
        return $data;
    }

    public function getPriceList() {
        $q = $this->db->select("MIN(price) AS minprice, MAX(price) AS maxprice")
                ->get('sma_products');
        return $q->row_array();
    }

}
