<?php

class Urban_piper_model  extends CI_Model{

    
    public function action_database(){
        $get_arguments = func_get_args();
        //Note: 0. action_key, 1. table name, 2. where condition array format, 3. field data Array format
        
        $msg = false;
        switch ($get_arguments[0]){
            
            case 'Insert':
                   $rec = $this->db->insert($get_arguments[1],$get_arguments[3]);
                    $msg = ($rec)?true:false;
                break;
            
            case 'Update':
                    $rec = $this->db->where($get_arguments[2])->update($get_arguments[1],$get_arguments[3]);
                    $msg = ( $rec ) ? true : false;
                break;
            
            case 'Delete':
                    $rec = $this->db->where($get_arguments[2])->delete($get_arguments[1]);
                    $msg = ( $rec )?true:false;
                break;
                       
            default :
                    $msg = false;
                break; 
        }
        
        return $msg;
    }
        
    public function check_dependancy(){
        $get_arguments = func_get_args();
        // Note: 0. Table name, 1. where condition, 2. getdata
         $return_data  =  $this->db->select($get_arguments[2])->where($get_arguments[1])->get($get_arguments[0])->row();
        return ($this->db->affected_rows() > 0)? $return_data : false; 
    }
    
    public function getStoreCategories($store_id){
     
        $sql ="SELECT  `id` ,  `name` ,  `code` ,  `parent_id` 
            FROM  `sma_categories` 
            WHERE  `id` 
            IN (

            SELECT  `category_id` 
            FROM  `sma_up_stores_categories` 
            WHERE  `store_id` =  '8'
            AND  `up_added` =  '1'
            )
            ORDER BY  `name`";
        
       $results = $this->db->query($sql)->result();
        
        if($results){
            foreach ($results as $key => $catdata) {
                $data[$catdata->id] = $catdata;
            }  
            return $data;
        }
        return false;
    }
    
    
    public function getallstore($id = ''){
        
        if($id){
            $get_data = $this->db->get_where('sma_up_stores', ['id'=>$id])->result();
        } else {
            $get_data = $this->db->get('sma_up_stores')->result();
        }
       return $get_data;
    }
    
    
    public function getrecords(){
       // Note : - 0. Tablename, 1. getfields (array format), 2. retrun type data (row,row_array,result,result_array), 3. Where Condition (array() format), 4. oredr field, 5. order field type(ASC/DESC)
       $getarg = func_get_args(); // get function arguments
       $this->db->select($getarg[1]);
       if($getarg[3]){$this->db->where($getarg[3]);}// Where condition
       if($getarg[4] && $getarg[5]){$this->db->order_by($getarg[4],$getarg[5]);}// Data order by
       $getdata = $this->db->get($getarg[0]); // Table Name
        switch ($getarg[2]){ // return data format
            case 'row':
                    $data = $getdata->row();
                break;
           
            case 'row_array':
                    $data = $getdata->row_array();
                break;
           
            case 'result': // object type data
                    $data = $getdata->result();
                break;
           
            case 'result_array': // array type data
                    $data = $getdata->result_array();
                break;
           
            default : // object type data
                   $data = $getdata->result();
               break;
        }
        return  $data;
    }
    
    public function getcategory($where_condition){
        $this->db->select('t1.*, t2.code as parent_code');
        $this->db->from('sma_categories AS t1')->where($where_condition);
        $this->db->join('sma_categories AS t2','t1.parent_id = t2.id','left');
        return $this->db->get()->result();
    }
    
    
    public function updateStoreCategoryStatus($category_id, $store_id, $action = 'Add_category' ) {
        
        switch($action){
            case 'Add_category':
            case 'Edit_category':
                 $statusData = " up_is_active='1', up_added='1' ";
                break;
            case 'Enable_category':
                 $statusData =  " up_is_active ='1' ";
                break;
            case 'Disable_category':
                 $statusData =  " up_is_active='0' ";
                break;
            case 'Delete_category':
                 $statusData =  " up_is_active='0', up_added='0' ";
                break;
            default :
                $statusData = " up_is_active='1', up_added='1' ";
        }//end switch.
        
        $categoryIds = is_array($category_id) ? join(',', $category_id) : $category_id;
        
        $sql = "UPDATE `sma_up_stores_categories` SET $statusData WHERE `store_id`='$store_id' AND `category_id` IN ($categoryIds) ";
        $this->db->query($sql);
        
       /* $q = $this->db->where('store_id' , $store_id)
                ->where_in('category_id' , $categoryIds)
                ->update('sma_up_stores_categories', $statusData);
        */
        if($this->db->affected_rows()){
            return true;
        } else {
            return $this->db->_error_message();
        }
    }
    
    public function getMasterCategories($catid = ''){
        
        if($catid){
            $catid = (is_array($catid)) ? join(',', $catid) : $catid;
            $sql = "SELECT c.`id`,c.`name`,c.`image`,c.`parent_id`,c.`up_description`, upc.`store_id`, upc.`category_ref_id` , upc.`store_ref_id`, upc.parent_ref_id, upc.up_added, upc.up_is_active "
                    . "FROM `sma_categories` as c LEFT JOIN `sma_up_stores_categories` as upc on c.`id` = upc.`category_id` "
                    . "WHERE c.`id` IN ($catid) group by upc.category_id ";
            $results = $this->db->query($sql)->result();
        } else {
            $results = $this->db->from('sma_categories')->order_by('parent_id','asc')->get()->result();
        }
        if($results){
            foreach ($results as $row) {
                $data[$row->id] = $row;
                $data[$row->id]->up_description = $data[$row->id]->name;            
            }
        }
        return $data;
    }
    
    
    public function importNotStoreCategory($store_id) {
        
        $query = "SELECT id, code, parent_id FROM sma_categories WHERE id NOT IN ( SELECT category_id from sma_up_stores_categories WHERE store_id = '$store_id' ) order by parent_id asc ";
        
        $results = $this->db->query($query)->result();
        
         if(count($results)){
            
           $storedata = $this->getallstore($store_id);
             
            foreach ($results as $row) {
                $upcategory[$row->id]['category_id'] = $row->id;
                $upcategory[$row->id]['category_ref_id'] = $row->code;
                $upcategory[$row->id]['parent_id'] = $row->parent_id;
                $upcategory[$row->id]['parent_ref_id'] = $upcategory[$row->parent_id]['category_ref_id'];
                $upcategory[$row->id]['store_id'] = $store_id;
                $upcategory[$row->id]['store_ref_id'] = $storedata[0]->ref_id;
                $upcategory[$row->id]['up_is_active'] = 0;
                $upcategory[$row->id]['up_added'] = 0;
            }
           
            return $upcategory;
        }
        
        return [];
    }
    
    public function getUpStoreCategory($store_id) {
        
        $query = "SELECT c.id, c.code, c.name, c.image, upc.parent_id, upc.parent_ref_id, c.up_category, c.up_description, upc.up_is_active, upc.up_added, upc.store_ref_id "
                . "FROM sma_categories as c "
                . "Left Join sma_up_stores_categories upc ON c.id = upc.category_id "
                . "WHERE upc.store_id = '$store_id' "
                . "ORDER BY upc.parent_id ASC ";
        
        $results = $this->db->query($query)->result();
        
        //$results = $this->db->get_where('sma_up_stores_categories', ['store_id'=>$store_id])->result();
        
        if(count($results)){
            
            foreach ($results as $row) {
                $upcategory[$row->id] = $row;
                //$upcategory[$row->id]->parent_category = ($row->parent_id) ?  $results[$row->parent_id]->name : '';
            }
            
            return $upcategory;
        }
        
        return [];
    }
    
    public function getStoreCategoryProducts($store = null,$category='') {
        
        if($category) {
                        
          $sql2 = "SELECT `id`, `code`, `name`, `image`, `category_id`, `subcategory_id`, "                   
                    . " (SELECT name FROM `sma_categories` WHERE `id` = `category_id`   ) AS category_name, "
                    . " (SELECT name FROM `sma_categories` WHERE `id` = `subcategory_id`  ) AS subcategory_name  "
                   . "FROM `sma_products` WHERE `up_items` = '1' AND (`category_id`='$category' OR `subcategory_id`='$category')  "
                   . "GROUP BY  `id` ORDER BY  `name` ";
           
            $upProduct = $this->db->query($sql2)->result();
                        
            foreach ($upProduct as $key => $upproduct) {
                
                $data[$upproduct->id] = $upproduct;
            }
            
          $sql = "SELECT p.`id`, p.`code`, p.`name`, p.`image`,  p.`category_id`, p.`subcategory_id`, uppp.active_status, uppp.add_status, uppp.up_store_id, "
                    . " (SELECT name FROM `sma_categories` WHERE `id` = `category_id` ) AS category_name, "
                    . " (SELECT name FROM `sma_categories` WHERE `id` = `subcategory_id` ) AS subcategory_name  "
                    . "FROM `sma_products` p  "
                    . "LEFT JOIN `sma_up_products_platform` uppp ON p.id = uppp.product_id  "                   
                    . "WHERE `up_items` = '1' AND (`category_id`='$category' OR `subcategory_id`='$category') AND ( uppp.up_store_id = '$store' ) "
                    . "GROUP BY p.`id` ORDER BY p.`name` ";
            
            
            $resultProduct = $this->db->query($sql)->result();
            if($resultProduct) {
                foreach ($resultProduct as $key => $product) {

                    $data[$product->id] = $product;
                }
            }
            return $data;
            
        } else {
            
           $sql = "SELECT p.`id`, p.`code`, p.`name`,p.`image`, p.`category_id`, p.`subcategory_id`, uppp.active_status, uppp.add_status, uppp.up_store_id, "
                    . " (SELECT name FROM `sma_categories` WHERE `id` = p.`category_id`) AS category_name, "
                    . " (SELECT code FROM `sma_categories` WHERE `id` = p.`category_id`) AS category_code,  "
                    . " (SELECT name FROM `sma_categories` WHERE `id` = p.`subcategory_id`) AS subcategory_name, "
                    . " (SELECT code FROM `sma_categories` WHERE `id` = p.`subcategory_id`) AS subcategory_code  "
                    . "FROM `sma_products` p "
                    . "LEFT JOIN `sma_up_products_platform` uppp ON p.id = uppp.product_id "
                    . "WHERE `up_items` = '1' AND uppp.up_store_id = '$store' "
                    . "GROUP BY p.`id` ORDER BY p.`name` ";
             
            $resultProduct = $this->db->query($sql)->result();
            if($resultProduct) {
                foreach ($resultProduct as $key => $product) {

                    $data[$product->id] = $product;
                }
                return $data;
            } else {
                return false;
            }
            
        }
        
         
       
    }
    
    public function getproduct($where_condition){
        $this->db->select('t1.*,t0.price as up_price,t0.food_type_id as food_type, t0.active_status as up_status, t0.add_status as up_add_status, t0.plat_urbanpiper,t0.plat_zomato,t0.plat_foodpanda,t0.plat_swiggy  ,t0.plat_ubereats,t2.code as category_code,t2.name as category_name ,t3.code as sub_category_code,t3.name as sub_category_name');
        $this->db->from('sma_products AS t1')->where($where_condition);
        $this->db->join('sma_up_products AS t0','t1.id = t0.product_id','rigth');
        $this->db->join('sma_categories AS t2','t1.category_id = t2.id','left');
        $this->db->join('sma_categories AS t3','t1.subcategory_id = t3.id','left');
        return $this->db->get()->result();
    }
    
    public function getproductsingle($where_condition){
        $this->db->select('t1.*,t0.price as up_price,t0.food_type_id as food_type, t0.active_status as up_status, t0.add_status as up_add_status, t0.plat_urbanpiper,t0.plat_zomato,t0.plat_foodpanda,t0.plat_swiggy ,t0.plat_ubereats,t2.code as category_code,t2.name as category_name ,t3.code as sub_category_code,t3.name as sub_category_name');
        $this->db->from('sma_products AS t1')->where($where_condition);
        $this->db->join('sma_up_products AS t0','t1.id = t0.product_id','rigth');
        $this->db->join('sma_categories AS t2','t1.category_id = t2.id','left');
        $this->db->join('sma_categories AS t3','t1.subcategory_id = t3.id','left');
        return $this->db->get()->row();
    }
    
//    public function getproductplatformdata(array $product_ids, $store_id){
//       
//         $q = $this->db->where(['up_store_id'=>$store_id])
//                 ->where_in(['product_id'=>$product_ids])
//                 ->get('sma_up_products_platform');
//         
//         if($q->num_rows()){
//            foreach ($q->result() as $products) {
//                
//                $data[$products->product_id] = $products;
//                
//            }
//            return $data;
//         }
//         
//         return false;
//    }
    
    public function getproductplatformdata($product_ids){
       
         $q = $this->db->select('`plat_urbanpiper` as tag_urbanpiper, `plat_zomato` as tag_zomato, `plat_foodpanda` as tag_foodpanda, `plat_swiggy` as tag_swiggy, `plat_ubereats` as tag_ubereats, `available` , `sold_at_store`, `recommended`, `product_id`, `product_code` ')
                 ->where_in(['product_id'=>$product_ids])
                 ->get('sma_up_products');
         
         if($q->num_rows()){
            foreach ($q->result() as $products) {                
                $data[$products->product_id] = $products;                
            }
            return $data;
         }
         
         return false;
    }
  
    public function getproduct_allup($where_condition){
     
        $this->db->select('t1.*,t0.id as upproduct_id,t0.price as up_price,t0.food_type_id as food_type, t0.active_status as up_status, t0.add_status as up_add_status, t0.plat_urbanpiper,t0.plat_zomato,t0.plat_foodpanda,t0.plat_swiggy ,t0.plat_ubereats ,t2.code as category_code,t2.name as category_name ,t3.code as sub_category_code,t3.name as sub_category_name');
        $this->db->from('sma_products AS t1')->where_in('t1.id',$where_condition);
        $this->db->join('sma_up_products AS t0','t1.id = t0.product_id','rigth');
        $this->db->join('sma_categories AS t2','t1.category_id = t2.id','left');
        $this->db->join('sma_categories AS t3','t1.subcategory_id = t3.id','left');
        return $this->db->get()->result();
    }
    
    
     public function count_new_sales() {
        $data['num'] = 0;
        $data['notify'] = 0;
        $data['new_order'] = 0;
                        
        $q = $this->db->select('id, sale_status, up_sales, up_sales_notification')
                ->where('up_sales_notification','1')
                ->get('sma_sales');
        
        if($q->num_rows()){
            foreach ($q->result() as $sale) {
                if($sale->sale_status == 'cancle' || $sale->up_sales_notification > 1 ) continue;
                $data['num']++;
                $data['notify'] += ($sale->up_sales_notification == 1 ) ? 1 : 0;
                $data['new_order'] += ($sale->up_sales_notification == 1 ) ? 1 : 0;
                //$data['sales'][] = $sale;
            }
            return $data;
        }
    }
    
    
    public function upmnotifiy(){
        $this->db->where('up_sales_notification','1')->update('sma_sales',array('up_sales_notification'=>'2'));
    }
    
    
    public function orderStatuslist() {
        
        $q = $this->db->select('id,title')->get_where('up_status', ['is_active'=>1,'is_delete'=>0]);
        
        if($q->num_rows()){
            foreach ($q->result() as $key => $row) {
                $data[$row->title] = $row->title;
            } 
            return $data;
         }
        return false;
    }
    
    public function getOrders($saleid = null) {              
        
        $select = 's.`id` as sale_id, s.`total`,s.`sale_status`,s.`delivery_status`,'
                . 's.`up_channel`,s.`up_response`,s.`up_status`,s.`up_sales`,s.`up_item_level_total_charges`,s.`up_order_id`,s.`up_delivery_datetime`,'
                . 's.`up_coupon`,s.`up_next_status`, s.`up_prev_state`,s.`up_state_timestamp`, s.`up_message`, s.`up_status_response`, s.`up_sales_notification`, '
                . 's.`up_order_level_total_charges`,s.`customer_id`, s.`customer`, '
                . 'upor.id as order_rider_id, upor.channel_order_id, upor.current_state, upor.name, upor.phone, upor.comments, '
                . 'upor.order_status, upor.created, upor.up_order_rider_response';
        
        $wheresales = ($saleid) ? " AND s.`id` = '$saleid' " : '';
        
        $sql = "SELECT $select FROM `sma_sales` s "
                . "LEFT JOIN `sma_up_orderrider` upor ON s.up_order_id = upor.up_order_id "
                . "WHERE s.`up_sales` = '1' " . $wheresales 
                . "ORDER BY s.id DESC ";
        
        $q = $this->db->query($sql);
        
         if($q->num_rows()){
             foreach ($q->result() as $row) {
                 $data[$row->sale_id] = $row;
             }
         }
         
         return $data;
    }
    
    public function getUpOrders($type='active') {              
        
        $select = 's.`id` as sale_id, s.`total`,s.`sale_status`,s.`delivery_status`,'
                . 's.`up_channel`,s.`up_response`,s.`up_status`,s.`up_sales`,s.`up_item_level_total_charges`,s.`up_order_id`,s.`up_delivery_datetime`,'
                . 's.`up_coupon`,s.`up_next_status`, s.`up_prev_state`,s.`up_state_timestamp`, s.`up_message`, s.`up_status_response`, s.`up_sales_notification`, '
                . 's.`up_order_level_total_charges`,s.`customer_id`, s.`customer`, '
                . 'upor.id as order_rider_id, upor.channel_order_id, upor.current_state, upor.name, upor.phone, upor.comments, '
                . 'upor.order_status, upor.created, upor.up_order_rider_response';
        
        $where = ($type == 'active') ? " AND s.`sale_status` NOT IN ( 'Completed','Cancelled' ) " : " AND s.`sale_status` IN ( 'Completed','Cancelled' ) ";
        
        $sql = "SELECT $select FROM `sma_sales` s "
                . "LEFT JOIN `sma_up_orderrider` upor ON s.up_order_id = upor.up_order_id "
                . "WHERE s.`up_sales` = '1' ".$where
                . "ORDER BY s.id DESC ";
        
        $q = $this->db->query($sql);
        
         if($q->num_rows()){
             foreach ($q->result() as $row) {
                 $data[$row->sale_id] = $row;
             }
         }
         
         return $data;
    }
    
    public function getOrderItems($saleid) {
        
        $q = $this->db->where(['sale_id'=>$saleid])->get('sale_items');
        
         if($q->num_rows()){
             foreach ($q->result() as $row) {
                 $data[$row->product_code] = $row;
             }
         }
         
         return $data;
        
    }
    
    public function setCallbackLog(array $callbackdata) {        
        
        if($this->db->insert('sma_up_callback_log', $callbackdata)){
            return true;
        } 
        
        return false;
        
    }
    
    public function get_foodtype() {
     
        $q = $this->db->get('sma_food_type');
        
        if($q->num_rows()){
             foreach ($q->result() as $row) {
                 $data[$row->id] = $row->food_type;
             }
         }
         
         return $data;
    }
   
    
}
