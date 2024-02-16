<?php
class Urban_piper extends MY_Controller {
    
    private $merchant_phone = '';
    private $site_name = '';
    private $api_key = '';
    private $upsetting = '';
    private $store_reff_id = '';
    private $store_id = '';
    
    public function __construct() {
        parent::__construct();
        $authentication_methods = array('orderrider','add_order','orderstatus','api_key_add','update_UP_Package','storeactioncallback','storescallback','inventorycallback');
        
        if( ! in_array($this->router->fetch_method(), $authentication_methods))
        {
            if (!$this->loggedIn) {
                $this->session->set_userdata('requested_page', $this->uri->uri_string());
                $this->sma->md('login');
            }
        }
        $this->load->model("Urban_piper_model","UPM");
        $this->load->model('site');
        $this->load->library('form_validation');
        
        $ci = get_instance();
        $config = $ci->config;
        $this->merchant_phone = isset($config->config['merchant_phone']) && !empty($config->config['merchant_phone'])?$config->config['merchant_phone']:null;
        $this->data['store_setting'] = $this->UPM->getrecords('sma_up_stores','*','row');
        $setting = $this->UPM->check_dependancy('sma_settings',array('setting_id'=>'1'),'site_name'); 
        $this->site_name = $setting->site_name;
        
        $apikey =  $this->UPM->getrecords('sma_up_settings','*','row',array('id'=>'1','is_active'=>'1'));
        $this->api_key = $apikey->api_key;
        $this->upsetting = $apikey;
        $this->data['up_setting'] = $this->UPM->getrecords('sma_up_settings','*','row');
        
            
    }
    
    public function set_store_id($storeid) {
        
        $store = $this->UPM->getallstore($storeid);
        $this->data['store'] = $store[0];
        $this->store_id = $storeid;
        $this->store_reff_id = $store[0]->ref_id;
        
        return $this->store_reff_id;
    }
    
    public function index(){
//        $this->UPM->upmnotifiy();
//        $this->data['orderring']=$this->UPM->getrecords('sma_up_stores','ordering_enabled','row',array('id'=>'1'));
//        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('Order')));
//        $meta = array('page_title' => lang('Urbanpiper  store'), 'bc' => $bc);
//        $this->page_construct('urbanpiper/order', $meta, $this->data);
          $this->orders();
    }
    
    public function orders() {
                 
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('Orders')));
        $meta = array('page_title' => lang('Urbanpiper Orders'), 'bc' => $bc);
        
        $this->data['upOrderStatusList'] = $this->UPM->orderStatuslist();
        $this->data['upOrders'] = $this->UPM->getOrders();      
        
            
        $this->page_construct('urbanpiper/up_orders', $meta, $this->data);
    }
    
    public function order_details() {        
        $saleid = $_GET['saleid'];
        $upOrders = $this->UPM->getOrders($saleid);
        
        echo '<pre>'.$saleid;
                    print_r($upOrders);
                    echo '</pre>';
                    
       echo '<div class="table-responsive">
                <table class="table table-bordered" >
                    <tbody>
                        <tr><th colspan="2">Order Info</th></tr>
                        <tr><th>Order Id</th><td></td></tr>
                        <tr><th>Order Status</th><td></td></tr>
                        <tr><th>Order time</th><td></td></tr>
                        <tr><th>Delivery time</th><td></td></tr>

                        <tr><th colspan="2">Customer</th></tr>
                        <tr><th>Customer Name</th><td></td></tr>
                        <tr><th>Customer Phone</th><td></td></tr>
                        <tr><th>Customer Address</th><td></td></tr>

                        <tr><th colspan="2">Rider</th></tr>
                        <tr><th>Rider Name</th><td></td></tr>
                        <tr><th>Phone No.</th><td></td></tr>
                        <tr><th>Status</th><td></td></tr>
                    </tbody>
                </table>
            </div>';
        
        //$this->page_view('urbanpiper/up_orders_details', $this->data);
    }
    
    /*==========================================================================
    * UrbanPiper Order List
    *==========================================================================*/
    public function uprbanpiper_order(){
        
        $whare_field = array(
            'up_sales'=>'1'
        );
        
        $order_data = $this->UPM->getrecords('sma_sales','*','result',$whare_field,'id','DESC');
        
        $order_status = $this->UPM->getrecords('sma_up_status','*','result',array('is_active'=>'1'),'title','ASC');
     
        $table_data = '';
            $table_data.='<table id="storelist" class="table table-bordered table-hover table-striped">';
                $table_data.='<thead><tr><th> Sr. No.</th>';
                $table_data.='<th> Reference No.</th>'; 
                $table_data.='<th> Customer </th><th>Channel</th>'; 
                $table_data.='<th> Total Amount </th><th>Rider</th><th> Status </th></tr></thead>';  
                $table_data.='<tbody>';
                    $sr = '1';
                    foreach ($order_data as $ordervalue){
                        $table_data.='<tr>';
                            $table_data.='<td>'.$sr.'</td>';
                            $table_data.='<td><a href="pos/view/'.$ordervalue->id.'/1" style="text-decoration: none; color: #484444;" data-toggle="modal" data-target="#myModal2" >'.$ordervalue->reference_no.'</a></td>';
                            $table_data.='<td>'.$ordervalue->customer.'</td>';
                            $table_data.='<td >'.$ordervalue->up_channel.'</td>';
                            $table_data.='<td class="text-right">'.$this->sma->formatMoney($ordervalue->grand_total).'</td>';
                            $table_data.='<td class="text-center"><a href="'.site_url('urban_piper/riderinfo/'.$ordervalue->up_order_id).'" data-toggle="modal" data-target="#myModal2" class="btn btn-sm btn-info" >Show</a></td>';

                            $table_data.='<td>';
                            
                                $table_data.='<div class="text-center"><div class="btn-group text-left"><button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'.$ordervalue->up_next_status.' <span class="caret"></span></button>';
                                    $table_data.='<ul class="dropdown-menu pull-right" role="menu">';
                                        foreach($order_status as $orderstatus){
                                            if($orderstatus->title!==$ordervalue->up_next_status){
                                                $table_data.='<li> <button class="btn" style="background:none" onclick=order_status(\''.$ordervalue->up_order_id.'\',\''.$orderstatus->title.'\') >'.$orderstatus->title.'</button></li>';
                                            }
                                        }
                                        
                                    $table_data.='</ul>';
                                $table_data.'</div></div>';
                            $table_data.'</td>';
                        $table_data.='</tr>';
                        $sr++;
                    }
                    
        
                $table_data.='</tbody>';
            $table_data.='</table>';    
                    
        echo json_encode($table_data);
      
    }
   /*==========================================================================
    * End  UrbanPiper Order List
    *==========================================================================*/
   
   /*==========================================================================
    * Rider Info
    *==========================================================================*/ 

    public function riderinfo($id=NULL){
        $this->data['delivery_info']= $this->UPM->getrecords('sma_up_orderrider','*','row',array('up_order_id'=>$id));
        $this->load->view($this->theme . 'urbanpiper/orderrider_modal', $this->data);
    }
    
     /*==========================================================================
    * End  Rider Info
    *==========================================================================*/ 
   
   
   /*==========================================================================
    * Urbanpiper Sales List
    *==========================================================================*/ 

    public function sales(){
         $this->UPM->upmnotifiy();
         $this->sma->checkPermissions('index');
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        
        if (isset($this->data['error'])) {
            $error_url = "http://" . $_SERVER[HTTP_HOST] . $_SERVER[REQUEST_URI];
            $logger = array($this->data['error'], $error_url);
            $this->pos_error_log($logger);
        }
        if ($this->Owner) {
            $this->data['warehouses'] = $this->site->getAllWarehouses();
            $this->data['warehouse_id'] = $warehouse_id;
            $this->data['warehouse'] = $warehouse_id ? $this->site->getWarehouseByID($warehouse_id) : null;
        } else {
            $user = $this->site->getUser();
            $this->data['warehouses'] =  $this->site->getAllWarehouses();
            $this->data['warehouse_id'] =$warehouse_id == null? $this->session->userdata('warehouse_id'):$warehouse_id ;
            $this->data['warehouse'] = $this->session->userdata('warehouse_id') ? $this->site->getWarehouseByID($warehouse_id) : null;
        }

        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('urban_piper'), 'page' => lang('Urbanpiper')), array('link' => '#', 'page' => lang('Urbanpiper Sales')));
        $meta = array('page_title' => lang('pos_sales'), 'bc' => $bc);
        $this->page_construct('urbanpiper/sales', $meta, $this->data);
    }
    
    /*==========================================================================
    * End Urbanpiper Sales List
    *==========================================================================*/ 
    
    
    /*==========================================================================
    *  urbanpiper Sales
    *==========================================================================*/ 
   
    public function getSales($warehouse_id = null) {
        $this->sma->checkPermissions('index');

        if ((!$this->Owner || !$this->Admin) && !$warehouse_id) {
            $user = $this->site->getUser();
            $warehouse_id = $user->warehouse_id;
        }

        $duplicate_link = anchor('sales/add?sale_id=$1', '<i class="fa fa-plus-circle"></i> ' . lang('duplicate_sale'));
        $detail_link = anchor('pos/view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('view_receipt'));
        $detail_link2 = anchor('sales/modal_view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('sale_details_modal'), 'data-toggle="modal" data-target="#myModal"');
        $detail_link3 = anchor('sales/view/$1', '<i class="fa fa-file-text-o"></i> ' . lang('sale_details'));
        $payments_link = anchor('sales/payments/$1', '<i class="fa fa-money"></i> ' . lang('view_payments'), 'data-toggle="modal" data-target="#myModal"');
        $add_payment_link = anchor('pos/add_payment/$1', '<i class="fa fa-money"></i> ' . lang('add_payment'), 'data-toggle="modal" data-target="#myModal"');
        $add_delivery_link = anchor('sales/add_delivery/$1', '<i class="fa fa-truck"></i> ' . lang('add_delivery'), 'data-toggle="modal" data-target="#myModal"');
        $email_link = anchor('#', '<i class="fa fa-envelope"></i> ' . lang('email_sale'), 'class="email_receipt" data-id="$1" data-email-address="$2"');
        $edit_link = anchor('sales/edit/$1', '<i class="fa fa-edit"></i> ' . lang('edit_sale'), 'class="sledit"');
        $return_link = anchor('sales/return_sale/$1', '<i class="fa fa-angle-double-left"></i> ' . lang('return_sale'));
        $delete_link = "<a href='#' class='po' title='<b>" . lang("delete_sale") . "</b>' data-content=\"<p>"
                . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sales/delete/$1') . "'>"
                . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
                . lang('delete_sale') . "</a>";
        $action = '<div class="text-center"><div class="btn-group text-left">'
                . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
                . lang('actions') . ' <span class="caret"></span></button>
                        <ul class="dropdown-menu pull-right" role="menu">
                            <li>' . $detail_link . '</li>
                            <li>' . $detail_link2 . '</li>
                            <li>' . $detail_link3 . '</li>
                            <li>' . $duplicate_link . '</li>
                            <li>' . $payments_link . '</li>
                            <li>' . $add_payment_link . '</li>
                            <li>' . $add_delivery_link . '</li>
                            <li>' . $edit_link . '</li>
                            <li>' . $email_link . '</li>
                            <li>' . $return_link . '</li>
                            <li>' . $delete_link . '</li>
                        </ul>
                    </div></div>';
        //$action = '<div class="text-center">' . $detail_link . ' ' . $edit_link . ' ' . $email_link . ' ' . $delete_link . '</div>';

        $this->load->library('datatables'); 
                    
        if ($warehouse_id) {
            $getwarehouse = str_replace("_",",", $warehouse_id);
            $this->datatables
                    ->select($this->db->dbprefix('sales') . ".id as id, date, reference_no, biller, customer, (grand_total+rounding), paid, (grand_total-paid) as balance, sale_status, payment_status, delivery_status, companies.email as cemail")
                    ->from('sales')
                    ->join('companies', 'companies.id=sales.customer_id', 'left')
                     ->where('warehouse_id IN ('.$getwarehouse.')')
                    ->group_by('sales.id');
        } else {
            $this->datatables
                    ->select($this->db->dbprefix('sales') . ".id as id, date, reference_no, biller, customer, (grand_total+rounding), paid, (grand_total+rounding-paid) as balance, sale_status, payment_status, delivery_status, companies.email as cemail")
                    ->from('sales')
                    ->join('companies', 'companies.id=sales.customer_id', 'left')
                    ->group_by('sales.id');
        }
        $this->datatables->where('up_sales', 1);
        
        
        if (!$this->Customer && !$this->Supplier && !$this->Owner && !$this->Admin && !$this->session->userdata('view_right')) {
            $this->datatables->where('created_by', $this->session->userdata('user_id'));
        } elseif ($this->Customer) {
            $this->datatables->where('customer_id', $this->session->userdata('user_id'));
        }
        $this->datatables->add_column("Actions", $action, "id, cemail")->unset_column('cemail');
        echo $this->datatables->generate();
    }

    /*==========================================================================
    * End  urbanpiper Sales list
    *==========================================================================*/ 
    
    public function get_item_image_exist($image='') {

       $img_url = site_url('assets/uploads/no_image.png');                            

        if($image != ''){
           
           $fx = file_exists('assets/uploads/thumbs/'. $image);
            
           if($fx){
              $img_url =  site_url('assets/uploads/thumbs/'. $image);
           } else {
                $fx2 = file_exists('assets/uploads/'. $image);
                if($fx2){
                   $img_url =  site_url('assets/uploads/'. $image) ;
                }
           }
        }   
        return $img_url;
    }
    
    public function AddUpStoreCategories() {
        
        $category_id = $this->uri->segment(3);
        $store_id = $this->uri->segment(4);
        $newstatus = $this->uri->segment(5);
        
        if($store_id) {
            $store_ref_id = $this->set_store_id($store_id);
        } else {
            $store_ref_id = -1;
        }
                
        $getcategory = $this->UPM->getMasterCategories($category_id);                        

            if($getcategory[$category_id]->image){
                $file_headers = @get_headers(site_url('assets/uploads/thumbs/') . $getcategory[$category_id]->image);
                $img_url = (!$file_headers || $file_headers[0]) ? site_url('assets/uploads/thumbs/') . $getcategory[$category_id]->image : site_url('assets/uploads/no_image.png');
            } else {
                $img_url = site_url('assets/uploads/no_image.png');
            }
                
            $field =array( array(
                        'ref_id'=>$getcategory[$category_id]->category_ref_id,
                        'name'=>$getcategory[$category_id]->name,
                        'description'=>($getcategory[$category_id]->up_description) ? $getcategory[$category_id]->up_description : $getcategory[$category_id]->name,
                        'parent_ref_id'=>($getcategory[$category_id]->parent_ref_id)? $getcategory[$category_id]->parent_ref_id: '',
                        'sort_order'=> 1,
                        'active'=> (isset($newstatus) && $newstatus == 'disable') ? false : true,
                        'img_url'=>$img_url,
                        'translations'=>array()
                    ));
                    
                    $collect_category['categories'] = $field;   
                      
                    $URL = 'https://staging.urbanpiper.com/external/api/v1/inventory/locations/'.$store_ref_id.'/';
                                         
                    $getresponse = $this->call_urbanpiper($URL,$collect_category);
                   
                    $phpObject = json_decode($getresponse);
            
                    if($phpObject->status=='success'){
                        
                        if(isset($newstatus)) {
                            $action = ($newstatus == 'disable') ? 'Disable_category' : 'Enable_category';
                        }
                        
                        $retrenre = $this->UPM->updateStoreCategoryStatus($category_id,$store_id, $action);
                        if($retrenre) {
                            $response['status']= 'success';
                            if($newstatus){
                                $response['messages'] = "Category $newstatus successfully.";
                            } else {
                                $response['messages'] = "Category update successfully."; 
                            }
                        } else {
                            $response['status']= 'error';
                            $response['messages'] = 'Category Added but Status could not updated.'; 
                        }
                    }else if($phpObject->status=='error'){
                    	$response['status']= 'error';
                        $response['messages'] = $phpObject->message; 
                    }else{
                        $response['status']= 'error';
                        $response['messages'] = 'Unidentify error, Please Try Agian'; 
                    }
                    echo json_encode($response);
        
    }
    
        
    /*==========================================================================
     * All Action on Urbanpiper portal direct affected
     * ========================================================================*/
    public function action($keytype=NULL, $id=NULL, $action_ref_id=NULL, $bulk_id = NULL, $store_id=NULL){
      	
            
        if($store_id) {
            $store_ref_id = $this->set_store_id($store_id);
        } else {
            $store_ref_id = -1;
        }
        
        $response = array();
        $wharecondition = array('id'=>$id);
        switch ($keytype){
        /*=============================================================================
         * Store List Action
         ==============================================================================*/
            case 'ordering':
                        $returndata = $this->UPM->check_dependancy('sma_up_stores',$wharecondition,'city,id,ref_id,name');
	                if(empty($returndata->city)){
	                    $response['status']= 'error';
	                    $response['messages'] = 'Sorry Please  Add City Name In Urbanpiper Store Update.';
	                }else{
	                    $status = ($action_ref_id=='Disable')?'false':'true';
	                    
	                   
	                    $ordering_action = array(
	                           /* "stats"=>array(
	                            "updated"=>1,
	                            "errors"=>0,
	                            "created"=>1
	                            ),*/
	                        "stores"=>array(
	                            array(
	                                "city"=>$returndata->city,
	                                "name"=>$returndata->name,
	                                "ref_id"=>$returndata->ref_id,
	                                "ordering_enabled"=>($status=='true')?true:false,
	                               /* "upipr_status"=>array(
	                                    "action"=>"U",
	                                    "id"=> 3923,
	                                    "error"=> false
	                                ),*/
	                            ),
	                        ),
	                    ); 
	                  
	                    $URL = 'https://staging.urbanpiper.com/external/api/v1/stores/';
	                    $getresponse = $this->call_urbanpiper($URL,$ordering_action);
	                    $phpObject = json_decode($getresponse);
	                    if($phpObject->status=='success'){
	                        $field = array('ordering_enabled'=>$status,'updated_at'=>date('Y-m-d H:i:s'));   
	                        $get_response = $this->UPM->action_database('Update','sma_up_stores',$wharecondition,$field);
	                        if($get_response){
	                            $response['status']= 'success';
	                            $response['messages'] = 'Order receive status has been '.strtolower($action_ref_id).'ed successfully.'; 
	                        }else{
	                            $response['status']= 'error';
	                            $response['messages'] = 'Ordering Status Not Change';
	                        }
	                    }else if($phpObject->status=='error'){
	                        $response['status']= 'error';
	                        $response['messages'] = $phpObject->message; 
	                    }else{
	                        $response['status']= 'error';
	                        $response['messages'] = 'Sorry Please Try Agian';
	                    }
	                }
	                echo json_encode($response);
                  
                  
                break;
                
            // Store Deactivate
            case 'Store_Deactivate':
            		
	            $returndata = $this->UPM->check_dependancy('sma_up_stores',$wharecondition,'city,id,ref_id,name');
	          
	                if(empty($returndata->city)){
	                    $response['status']= 'error';
	                    $response['messages'] = 'Sorry Please  Add City Name In Urbanpiper Store Update.';
	                }else{
	                     $status = ($action_ref_id=='Disable')?'false':'true';
	                    $ordering_action = array(
	                           /* "stats"=>array(
	                            "updated"=>1,
	                            "errors"=>0,
	                            "created"=>1
	                            ),*/
	                        "stores"=>array(
	                            array(
	                                "city"=>$returndata->city,
	                                "name"=>$returndata->name,
	                                "ref_id"=>$returndata->ref_id,
	                                "active"=>($status=='true')?true:false,
	                               /* "upipr_status"=>array(
	                                    "action"=>"U",
	                                    "id"=> 3923,
	                                    "error"=> false
	                                ),*/
	                            ),
	                        ),
	                    ); 
	                    $statusmsg = ($status=='true')?'enabled ':'disabled';
	                    $URL = 'https://staging.urbanpiper.com/external/api/v1/stores/';
	                    $getresponse = $this->call_urbanpiper($URL,$ordering_action);
	                    $phpObject = json_decode($getresponse);
	                    if($phpObject->status=='success'){
	                        $status = 
	                        $field = array('active'=>$status,'updated_at'=>date('Y-m-d H:i:s'));   
	                        $get_response = $this->UPM->action_database('Update','sma_up_stores',$wharecondition,$field);
	                        if($get_response){
	                            $response['status']= 'success';
	                            $response['messages'] = ' Store has been '.$statusmsg.' successfully';
	                        }else{
	                            $response['status']= 'error';
	                            $response['messages'] = 'Store Not Deactivate';
	                        }
	                    }else if($phpObject->status=='error'){
	                        $response['status']= 'error';
	                        $response['messages'] = $phpObject->message; 
	                    }else{
	                        $response['status']= 'error';
	                        $response['messages'] = 'Sorry Please Try Agian';
	                    }
	                }
	                echo json_encode($response);
             
             
                break;
            //End Store Deactivate 
                    
            case 'Add_urbanpiper':
                   $get_storedetails =   $this->UPM->check_dependancy('sma_up_stores',$wharecondition,'*');
                  
                    if($get_storedetails){
                        $store_details = array (
                                'stores' => 
                                array (
                                    0 => 
                                        array (
                                            'city' => $get_storedetails->city,
                                            'name' => $get_storedetails->name,
                                            'min_pickup_time' =>  $get_storedetails->min_pickup_time,
                                            'min_delivery_time' => $get_storedetails->min_delivery_time,
                                            'contact_phone' =>  $get_storedetails->contact_phone,
                                            'notification_phones' => explode(", ",$get_storedetails->notification_phones),
                                            'ref_id' =>$get_storedetails->ref_id,
                                            'min_order_value' =>($get_storedetails->min_order_value)?$get_storedetails->min_order_value:0,
                                            'hide_from_ui' => $get_storedetails->hide_from_ui,
                                            'address' =>$get_storedetails->address,
                                            'notification_emails' =>explode(", ",$get_storedetails->notification_emails),
                                            'zip_codes' =>explode(", ",$get_storedetails->zip_codes), 
                                            'geo_longitude' => $get_storedetails->geo_longitude,
                                            'active' =>true,
                                            'geo_latitude' => $get_storedetails->geo_latitude,
                                            'ordering_enabled' =>true,
                                            'translations' =>($get_storedetails->translations)?explode(", ",$get_storedetails->translations):[], 
                                            'timings'=>($get_storedetails->days)?json_decode($get_storedetails->days):array(),
                                          ),

                                        ),
                                      );
                                      
                       
                        $URL = 'https://staging.urbanpiper.com/external/api/v1/stores/';
                        $getresponse = $this->call_urbanpiper($URL,$store_details);
                        $phpObject = json_decode($getresponse);
                        if($phpObject->status=='success'){
                            $update_ref  =array('urbanpiper_reference'=>$phpObject->reference,
                                                 'store_add_urbanpiper'=>'1',
                                                 'active'=>'true',
                                                 'ordering_enabled'=>'true',
                                                 'updated_at'=>date('Y-m-d H:i:s') );
                            $this->UPM->action_database('Update','sma_up_stores',$wharecondition,$update_ref);
                            $response['status']= 'success';
                            $response['messages'] ='Store has been added successfully'; 
                        }else if($phpObject->status=='error'){
                    		$response['status']= 'error';
                        	$response['messages'] = $phpObject->message; 
                    	}else{
                             $response['status']= 'error';
                             $response['messages'] = 'Sorry Store Not Add, Please Try Agian';
                        }
                    }else{
                        $response['status']= 'error';
                        $response['messages'] = 'Sorry Please Try Agian'; 
                    }
                   echo json_encode($response);
                break;
            /*=========================================================================================================
            * End  Store List Action
            ==========================================================================================================*/   
           
            /*=========================================================================================================
            * Category Block
            *==========================================================================================================*/    
            // Single  Category
            case 'category_add': // Single Category Add
                    $getcategory = $this->UPM->getrecords('sma_categories','*','row',$wharecondition);
                    $field =array( array(
                        'ref_id'=>$getcategory->code,
                        'name'=>$getcategory->name,
                        'description'=>($getcategory->up_description)?$getcategory->up_description:'',
                        'parent_ref_id'=>($getcategory->parent_code)?$getcategory->parent_code:'0',
                        'sort_order'=> 1,
                        'active'=>true,
                        'img_url'=>($getcategory->image)?site_url('assets/uploads/thumbs/').$getcategory->image:'',
                        'translations'=>array()
                    ));
                    $collect_category['categories'] = $field;   
                      
                    $URL = 'https://staging.urbanpiper.com/external/api/v1/inventory/locations/'.$store_ref_id.'/';//.$this->merchant_phone.'/';
                	
                  
                    $getresponse = $this->call_urbanpiper($URL,$collect_category);
                   
                    $phpObject = json_decode($getresponse);
                    if($phpObject->status=='success'){
                    
                        $retrenre =  $this->UPM->action_database('Update','sma_categories',$wharecondition,array('up_add_status'=>'1','up_enabled'=>'1'));
                        $response['status']= 'success';
                        $response['messages'] = "Category add successfully."; 
                    }else if($phpObject->status=='error'){
                    	$response['status']= 'error';
                        $response['messages'] = $phpObject->message; 
                    }else{
                        $response['status']= 'error';
                        $response['messages'] = 'Sorry Please Try Agian'; 
                    }
                    echo json_encode($response);
                   
        break;
        
            case 'add_store_category': // Single Category Add
            
                $category_id = $this->uri->segment(4);
                $store_id  = $this->uri->segment(5);            
                                
                $getcategory = $this->UPM->getMasterCategories($category_id);
                
                $store_ref_id   =  $this->set_store_id($store_id);            
                
                if($getcategory[$category_id]->image){
                    $file_headers = @get_headers(site_url('assets/uploads/thumbs/') . $getcategory[$category_id]->image);
                    $img_url = (!$file_headers || $file_headers[0]) ? site_url('assets/uploads/thumbs/') . $getcategory[$category_id]->image : site_url('assets/uploads/no_image.png');
                } else {
                    $img_url = site_url('assets/uploads/no_image.png');
                }
                
                $field =array( array(
                        'ref_id'=>$getcategory[$category_id]->category_ref_id,
                        'name'=>$getcategory[$category_id]->name,
                        'description'=>($getcategory[$category_id]->up_description) ? $getcategory[$category_id]->up_description : $getcategory[$category_id]->name,
                        'parent_ref_id'=>($getcategory[$category_id]->parent_ref_id)? $getcategory[$category_id]->parent_ref_id: '',
                        'sort_order'=> 1,
                        'active'=>true,
                        'img_url'=>$img_url,
                        'translations'=>array()
                    ));
                    
                    $collect_category['categories'] = $field;   
                      
                    $URL = 'https://staging.urbanpiper.com/external/api/v1/inventory/locations/'.$store_ref_id.'/';
                                  
                    $getresponse = $this->call_urbanpiper($URL,$collect_category);
                   
                    $phpObject = json_decode($getresponse);
                    
                    if($phpObject->status=='success'){
                    
                        $retrenre = $this->UPM->updateStoreCategoryStatus($category_id,$store_id);
                        if($retrenre) {
                            $response['status']= 'success';
                            $response['messages'] = "Category add successfully."; 
                        } else {
                            $response['status']= 'error';
                            $response['messages'] = 'Category Added but Status could not updated.'; 
                        }
                    }else if($phpObject->status=='error'){
                    	$response['status']= 'error';
                        $response['messages'] = $phpObject->message; 
                    }else{
                        $response['status']= 'error';
                        $response['messages'] = 'Unidentify error, Please Try Agian'; 
                    }
                    echo json_encode($response);
                   
        break;
            
            //End Single Category
            case 'category_update':
                
                $category_id = $id;
                
                $getcategory = $this->UPM->getMasterCategories($category_id);
                
                $store_id       = $getcategory[$category_id]->store_id;
                $store_ref_id   = $getcategory[$category_id]->store_ref_id;
                
                $img_url = $this->get_item_image_exist($getcategory[$category_id]->image);    
                
                $field =array( array(
                        'ref_id'=>$getcategory[$category_id]->category_ref_id,
                        'name'=>$getcategory[$category_id]->name,
                        'description'=>($getcategory[$category_id]->up_description) ? $getcategory[$category_id]->up_description : $getcategory[$category_id]->name,
                        'parent_ref_id'=>($getcategory[$category_id]->parent_ref_id)? $getcategory[$category_id]->parent_ref_id: '',
                        'sort_order'=> 1,
                        'active'=>true,
                        'img_url'=>$img_url,
                        'translations'=>array()
                    ));
                                   
                    $collect_category['categories'] = $field; 
                                       
                    $URL = 'https://staging.urbanpiper.com/external/api/v1/inventory/locations/'.$store_ref_id.'/';
                    
                    $getresponse = $this->call_urbanpiper($URL,$collect_category);
                    $phpObject = json_decode($getresponse);
                    
                    if($phpObject->status=='success'){
                    
                        $retrenre = $this->UPM->updateStoreCategoryStatus($category_id,$store_id, 'Edit_category');
                        if($retrenre) {
                            $response['status']= 'success';
                            $response['messages'] = "Category updated successfully."; 
                        } else {
                            $response['status']= 'error';
                            $response['messages'] = 'Category Added but Status could not updated.'; 
                        }
                    }else if($phpObject->status=='error'){
                    	$response['status']= 'error';
                        $response['messages'] = $phpObject->message; 
                    }else{
                        $response['status']= 'error';
                        $response['messages'] = 'Unidentify error, Please Try Agian'; 
                    }
                    echo json_encode($response);
                
                break;     
            
                
            case 'Category_Upload': // Bulk Category upload
                
                  $newArray = array();
                  $field = array();
                  $category_ids = array();
            
                  $getdata = $this->UPM->getMasterCategories($bulk_id);
            
                    // Bulk Action 
                    switch ($action_ref_id) {
                        
                        case 'Add_category':  // Add Category in Bulks
                            
                            foreach($getdata as $category_id => $getcategory){
                             
                            $img_url = $this->get_item_image_exist($getcategory->image);                            
                            
                                if($getcategory->up_added == 0) {
                                                                                
                                    $collect_category['categories'][] = array(
                                            'ref_id'=>$getcategory->category_ref_id,
                                            'name'=>$getcategory->name,
                                            'description'=>($getcategory->up_description) ? $getcategory->up_description : $getcategory->name,                                            
                                            'sort_order'=> 1,
                                            'parent_ref_id' => ($getcategory->parent_ref_id) ? $getcategory->parent_ref_id : '',
                                            'active'=>true,
                                            'img_url'=>$img_url,
                                            'translations'=>[]
                                        );
                                            
                                        $category_ids[] = $category_id;
                                } else {
                                    continue;
                                }                                
                            }
                               
                            $msg = count($category_ids). " Categories added successfully.";
                        break;
                    
                        case 'Enable_category':
                        case 'Disable_category':
                            
                            $newstatus = ($action_ref_id=='Enable_category') ? true : false;
                       
                            foreach($getdata as $category_id => $cat_data){
                                     
                                $img_url = $this->get_item_image_exist($cat_data->image);
                              
                                if($cat_data->up_added==1) {
                                
                   $collect_category['categories'][] = array(
                                        'ref_id'=>$cat_data->category_ref_id,
                                        'name'=>$cat_data->name,
                                        'description'=>($cat_data->up_description) ? $cat_data->up_description : $cat_data->name,
                                        'sort_order'=> 1,
                                        'parent_ref_id'=> ($getcategory->parent_ref_id) ? $getcategory->parent_ref_id : '',
                                        'active'=> $newstatus,
                                        'img_url'=> $img_url,
                                        'translations'=>array()
                                    );
                                                                                   
                                    $category_ids[] = $category_id;
                                    
                                }//end if.
                                
                            }//end for
                                
                                $status_msg =($action_ref_id=='Enable_category')?'enabled':'disabled'; 
                           	$msg = count($category_ids) . " Categories has been ". $status_msg ." successfully.";
                          	
                            break;
                         /*   
                        case 'Delete_category': // Delete Category in Bulks
                            	foreach($getdata as $key => $cat_data){
                                    if($cat_data->up_add_status=='1'){
                                        $newArray[$key] = array(
                                            'ref_id'=>$cat_data->code,
                                            'name'=>$cat_data->name,
                                            'upipr_status'=>array(
                                                "action"=> "D",
                                                "id"=> 658,
                                                "error"=> false
                                            )
                                        );
                                            
                                       $category_ids[]= $cat_data->id;
                                       
                                    }
                                }
                                $field= array(
                                    'up_add_status'=>'0',
                                    'up_enabled'=>'0',
                                );
                              $msg = "Categorys delete successfully.";
                            break;
                        */
                        default :
                                return false;
                            break;
                    }
                   
                    // Pass Data urbanpiper
                    //$collect_category['categories'] = $newArray;
                        
                    $store_ref_id = $this->store_reff_id ? $this->store_reff_id : -1;
                        
                    $URL = 'https://staging.urbanpiper.com/external/api/v1/inventory/locations/'.$store_ref_id.'/';
                   
                    // End Pass data urbanpiper
                  if(is_array($collect_category)) {
                      
                        $getresponse = $this->call_urbanpiper($URL,$collect_category);

                        $phpObject = json_decode($getresponse);

                        if($phpObject->status=='success'){

                            $retrenre = $this->UPM->updateStoreCategoryStatus($category_ids,$store_id,$action_ref_id);
                            if($retrenre === true) {
                                $response['status']= 'success';
                                $response['messages'] = $msg; 
                            } else {
                                $response['status']= 'error';
                                $response['messages'] = $retrenre; 
                            }
                        } else if($phpObject->status=='error'){
                            $response['status']= 'error';
                            $response['messages'] = $phpObject->message; 
                        } else {
                            $response['status']= 'error';
                            $response['messages'] = 'Unidentify error, Please Try Agian'; 
                        }
                  } else {
                      $response['status']= 'error';
                      $response['messages'] = 'Selected categories is not valid for action '.$action_ref_id; 
                  }
                  
                  return $response;                    
                    //End Bulk Action
           	
                break; // Bulk Category
            /*    
            case 'category_delete': // Delete Category on urbanpiper
                
                    $category_data = $this->UPM->getrecords('sma_categories', '*', 'row', array('id'=>$id));
                    $field =array( array(
                        'ref_id'=>$category_data->code,
                        'name'=>$category_data->name,
                        'upipr_status'=>array(
                            "action"=> "D",
                            "id"=> 658,
                            "error"=> false
                        )
                    ));
                    $collect_category['categories'] = $field;   
                   $URL = 'https://staging.urbanpiper.com/external/api/v1/inventory/locations/'.$store_ref_id.'/';
                    $getresponse = $this->call_urbanpiper($URL,$collect_category);
                     $phpObject = json_decode($getresponse);
                  
                    if($phpObject->status=='success'){
                        $this->UPM->action_database('Update','sma_categories',$wharecondition,array('up_add_status'=>'0','up_enabled'=>'0'));
                        $response['status']= 'success';
                        $response['messages'] = "Category delete successfully"; 
                    }else if($phpObject->status=='error'){
                    	$response['status']= 'error';
                        $response['messages'] = $phpObject->message; 
                    }else{
                        $response['status']= 'error';
                        $response['messages'] = 'Sorry Please Try Agian'; 
                    }
                    echo json_encode($response);
                break; // End Delete Category
              */  
                // Category  Status
            case 'category_status':
                    
                $category_id = $id;
                
                $getcategory = $this->UPM->getMasterCategories($category_id);
                
                $store_id       = $getcategory[$category_id]->store_id;
                $store_ref_id   = $getcategory[$category_id]->store_ref_id;
                
                $img_url = $this->get_item_image_exist($getcategory[$category_id]->image);    
                
                $field =array( array(
                        'ref_id'=>$getcategory[$category_id]->category_ref_id,
                        'name'=>$getcategory[$category_id]->name,
                        'description'=>($getcategory[$category_id]->up_description) ? $getcategory[$category_id]->up_description : $getcategory[$category_id]->name,
                        'parent_ref_id'=>($getcategory[$category_id]->parent_ref_id)? $getcategory[$category_id]->parent_ref_id: '',
                        'sort_order'=> 1,
                        'active'=>($action_ref_id=='Disable') ? false:true,
                        'img_url'=>$img_url,
                        'translations'=>array()
                    ));
                     
                    $collect_category['categories'] = $field;   
                    $URL = 'https://staging.urbanpiper.com/external/api/v1/inventory/locations/'.$store_ref_id.'/';
                   
                    $getresponse = $this->call_urbanpiper($URL,$collect_category);
                
                    $phpObject = json_decode($getresponse);
                    
                   if($phpObject->status=='success'){
                       
                        $newstatus = ($action_ref_id=='Disable') ? 'Disable' : 'Enable';
                       
                        $retrenre = $this->UPM->updateStoreCategoryStatus($category_id, $store_id, $newstatus);
                        
                        if($retrenre) {
                            $response['status']= 'success';
                            $response['messages'] = "Category status change successfully."; 
                        } else {
                            $response['status']= 'error';
                            $response['messages'] = 'Action success but status could not updated.'; 
                        }
                    }else if($phpObject->status=='error'){
                    	$response['status']= 'error';
                        $response['messages'] = $phpObject->message; 
                    }else{
                        $response['status']= 'error';
                        $response['messages'] = 'Unidentify error, Please Try Agian'; 
                    }
                    echo json_encode($response);
                    
                break;
            
             /*==================================================================================================================
             * Category Block   
             *===================================================================================================================*/
             
             
             /*===================================================================================================================
             * Product Block 
             *====================================================================================================================*/
             
             case 'Single_Product':
                    // Single Product all cation 
                     $where_condition = array('t1.id'=>$id);
                     $getpro_info = $this->UPM->getproductsingle($where_condition);
                     $optionGroup = array();
                     $option = array();
                     $taxarray = array();
                     $excluded_platforms = array();
                     
                     $pplatforms = $this->UPM->getproductplatformdata($getpro_info->id);
                     $tags = array(
                            "zomato"=> ($pplatforms[$productval->id]->tag_zomato) ? explode(',', $pplatforms[$productval->id]->tag_zomato) :  array(),
                            "swiggy"=> ($pplatforms[$productval->id]->tag_swiggy) ? explode(',', $pplatforms[$productval->id]->tag_swiggy) :  array(),
                            "foodpanda"=> ($pplatforms[$productval->id]->tag_foodpanda) ? explode(',', $pplatforms[$productval->id]->tag_foodpanda) :  array(),
                            "ubereats"=> ($pplatforms[$productval->id]->tag_ubereats) ? explode(',', $pplatforms[$productval->id]->tag_ubereats) :  array(),
                            "urbanpiper"=> ($pplatforms[$productval->id]->tag_urbanpiper) ? explode(',', $pplatforms[$productval->id]->tag_urbanpiper) :  array(),
                        ); 
                   // if($this->data['up_setting']->urbanpiper){ $excluded_platforms[] = 'urbanpiper'; }
                    if($this->data['up_setting']->zomato){ $excluded_platforms[] = 'zomato'; }
                    if($this->data['up_setting']->foodpanda){ $excluded_platforms[] = 'foodpanda'; }
                    if($this->data['up_setting']->swiggy){ $excluded_platforms[] = 'swiggy'; }
                    if($this->data['up_setting']->ubereats){ $excluded_platforms[] = 'ubereats'; }
                            
                    $ref_category = ($getpro_info->subcategory_id)?$getpro_info->sub_category_code:$getpro_info->category_code;
                     
                    switch($action_ref_id){
                        
                       case 'UP_Add_Product':
                                
                           $img_url = $this->get_item_image_exist($getpro_info->image);
                        
                                $itemsArray =array(array(
                                    "ref_id"=>$getpro_info->code,
                                    "title"=>$getpro_info->name,
                                    "description"=>($getpro_info->product_details)?$getpro_info->product_details:$getpro_info->name,
                                    "available"=> ($pplatforms[$productval->id]->available)? true : false,                                    
                                    "sold_at_store"=>($pplatforms[$productval->id]->sold_at_store)? true : false,
                                    "recommended"=>($pplatforms[$productval->id]->recommended)? true : false,
                                    "price"=>(float)$getpro_info->up_price,
                                    "current_stock"=>-1,
                                    "img_url"=> $img_url,
                                    "food_type"=>($getpro_info->food_type_id)?$getpro_info->food_type_id:'4',
                                    "category_ref_ids"=>array(($ref_category)?$ref_category:''),
                                    "translations"=>array(),
                                    "tags"=>(object)$tags,
                                    "excluded_platforms"=>$excluded_platforms,
                                ));
                                
                                // Group Option
                                $productoption = $this->UPM->getrecords('sma_product_variants','*','result',array('product_id'=>$id));
                                if($productoption){
                                    foreach($productoption as $pgop){
                                        $optionGroup[] = array(
                                            'ref_id'=>$getpro_info->code,
                                            'title'=>$getpro_info->name,
                                            'min_selectable'=> 1,
                                            'max_selectable'=> 1,
                                            'active'=>true,
                                            'item_ref_ids'=>array($getpro_info->code)
                                        );
                                        $option[] = array(
                                            'ref_id'=>$pgop->id,
                                            'title'=>$pgop->name,
                                            'description'=>$pgop->name,
                                            'weight'=>NULL,
                                            'available'=>true,
                                            'price'=>(float) $pgop->price, 
                                            'opt_grp_ref_ids'=>array($getpro_info->code),
                                            'sold_at_store'=>true,
                                            'opt_grp_ref_ids'=>array($getpro_info->code),
                                            'nested_opt_grps'=>array(),
                                            'translations'=>array() 
                                             
                                          );
                                    }
                                }
                                // Group option    
                                //Product Taxes
                                $taxget =  $this->UPM->check_dependancy('sma_tax_rates',array('id'=>$getpro_info->tax_rate),'*');
                                $gettaxconfig = unserialize($taxget->tax_config);
                                foreach($gettaxconfig as $taxvalue){
                                    $taxarray[] = array(
                                        "ref_id"=>$taxvalue['code'].'-'.$taxvalue['percentage'],
                                        "title"=>$taxvalue['name'],
                                        "description" => $taxvalue['percentage']."% CGST on all items",
                                        "active"=> true,
                                        "structure"=> array(
                                                "type"=> "percentage",
                                                "applicable_on" => "item.price",
                                                "value"=>$taxvalue['percentage']
                                            ),
                                            "item_ref_ids"=> [$getpro_info->code]
                                         
                                     );
                                 }
                                // End Product Taxes
                               
                                $field = array(
                                    'active_status'=>'1',
                                    'add_status'=>'1'
                                );
                               
                               $msg = "Product add successfully.";
                            break;
                       
                       case 'UP_Update_Product':
                          $img_url = $this->get_item_image_exist($getpro_info->image);
                           
                                $itemsArray =array(array(
                                    "ref_id"=>$getpro_info->code,
                                    "title"=>$getpro_info->name,
                                    "description"=>($getpro_info->product_details)?$getpro_info->product_details:$getpro_info->name,
                                    "available"=> ($pplatforms[$productval->id]->available)? true : false,                                    
                                    "sold_at_store"=>($pplatforms[$productval->id]->sold_at_store)? true : false,
                                    "recommended"=>($pplatforms[$productval->id]->recommended)? true : false,
                                    "price"=>(float)$getpro_info->up_price,
                                    "current_stock"=>-1,
                                    "img_url"=>$img_url,
                                    "food_type"=>($getpro_info->food_type_id)?$getpro_info->food_type_id:'4',
                                    "category_ref_ids"=>array(($ref_category)?$ref_category:''),
                                    "translations"=>array(),
                                    "tags"=>(object) $tags,
                                    "excluded_platforms"=>$excluded_platforms,
                                    /*'upipr_status'=>array(
                                        "action"=> "U",
                                        "id"=> 6565,
                                        "error"=> false
                                    ),*/
                                    
                                ));
                               // Group Option
                                $productoption = $this->UPM->getrecords('sma_product_variants','*','result',array('product_id'=>$id));
                                if($productoption){
                                    foreach($productoption as $pgop){
                                        $optionGroup[] = array(
                                            'ref_id'=>$getpro_info->code,
                                            'title'=>$getpro_info->name,
                                            'min_selectable'=> 1,
                                            'max_selectable'=> 1,
                                            'active'=>true,
                                            'item_ref_ids'=>array($getpro_info->code)
                                        );
                                        $option[] = array(
                                            'ref_id'=>$pgop->id,
                                            'title'=>$pgop->name,
                                            'description'=>$pgop->name,
                                            'weight'=>NULL,
                                            'available'=>true,
                                            'price'=>(float) $pgop->price, 
                                            'opt_grp_ref_ids'=>array($getpro_info->code),
                                            'nested_opt_grps'=>array(),
                                            'translations'=>array()  
                                          );
                                    }
                                }
                                // Group option    
                                //Product Taxes
                                $taxget =  $this->UPM->check_dependancy('sma_tax_rates',array('id'=>$getpro_info->tax_rate),'*');
                                $gettaxconfig = unserialize($taxget->tax_config);
                                foreach($gettaxconfig as $taxvalue){
                                    $taxarray[] = array(
                                        "ref_id"=>$taxvalue['code'].'-'.$taxvalue['percentage'],
                                        "title"=>$taxvalue['name'],
                                        "description" => $taxvalue['percentage']."% CGST on all items",
                                        "active"=> true,
                                        "structure"=> array(
                                                "type"=> "percentage",
                                                "applicable_on" => "item.price",
                                                "value"=>$taxvalue['percentage']
                                            ),
                                            "item_ref_ids"=> [$getpro_info->code]
                                         
                                     );
                                 }
                                // End Product Taxes
                                $field = array(
                                    'active_status'=>'1',
                                    'add_status'=>'1'
                                );
                                $msg= "This product successfully update on urbanpiper portal. ";
                            
                            break;             
                                    
                                    
                       case 'UP_status_Product':
                             
                                $itemsArray =array(array(
                                    "ref_id"=>$getpro_info->code,
                                    "title"=>$getpro_info->name,
                                     "description"=>($getpro_info->product_details)?$getpro_info->product_details:$getpro_info->name,
                                    "available"=> ($pplatforms[$productval->id]->available)? true : false,                                    
                                    "sold_at_store"=>($pplatforms[$productval->id]->sold_at_store)? true : false,
                                    "recommended"=>($pplatforms[$productval->id]->recommended)? true : false,
                                    "price"=>(float)$getpro_info->up_price,
                                    "current_stock"=>-1,
                                    "recommended"=>true,
                                    "food_type"=>($getpro_info->food_type_id)?$getpro_info->food_type_id:'4',
                                    "category_ref_ids"=>array(($ref_category)?$ref_category:''),
                                    "translations"=>array(),
                                    "tags"=>(object) $tags,
                                    "excluded_platforms"=>$excluded_platforms,
                                   /* 'upipr_status'=>array(
                                        "action"=> "U",
                                        "id"=> 6565,
                                        "error"=> false
                                    ),*/
                                ));
                               
                                $field = array(
                                  
                                    'active_status'=>($bulk_id=='Enable')?'1':'0',
                                );
                                $msg = "Product status  ".strtolower($bulk_id)." successfully.";
                            break;
                                    
                        default :
                                $itemsArray ='';
                            break;
                    }
                    
                   
                 if(is_array($itemsArray)){     
                      $pass = array( "items"=>$itemsArray,);    
	              if(is_array($optionGroup)){
	               	  $pass['option_groups']=$optionGroup;
	                   $pass['flush_options']=false;
	                   $pass['options']=$option;  
	              }
	             if(is_array($taxarray)){
	                 $pass['taxes']=$taxarray; 
	             }

	                    $URL = 'https://staging.urbanpiper.com/external/api/v1/inventory/locations/-1/';
	                 
	                 
	                    $getresponse_item= $this->call_urbanpiper($URL,$pass);
	                    
	                    
	                    $phpObject = json_decode($getresponse_item);
	                    if($phpObject->status=='success'){
	                        $this->UPM->action_database('Update','sma_up_products',array('product_id'=>$id),$field);
	                        $response['status']= 'success';
	                        $response['messages'] = $msg; 
	                    }else if($phpObject->status=='error'){
	                    	$response['status']= 'error';
	                        $response['messages'] = $phpObject->message; 
	                    }else{
	                        $response['status']= 'error';
	                        $response['messages'] = 'Sorry Please Try Agian'; 
	                    }
	            }else{
	            	  $response['status']= 'error';
	                  $response['messages'] = 'Sorry Please Try Agian'; 
	            }        
                    echo json_encode($response);

                break;
                
            // Single Product Action   
             
            // Bulk Products    
            case 'Products_Upload':
            	    $newArray = array();
                    $field = array();
                    $product_ids = array();
                    $products = $this->UPM->getproduct_allup($bulk_id);
                    $optionGroup = array();
                    $option  = array();
                    $taxarray = array(); 
                    $tags = array(
                    	"zomato"=>array(),
                    	"swiggy"=>array(),
                    	"foodpanda"=>array(),
                    	"ubereats"=>array(),
                    	"urbanpiper"=>array(),
                    );
                    
                    switch ($action_ref_id){
                        case 'Add_product':
                            
                                foreach($products as $items_val){
                                    if($items_val->up_add_status!='1'){
                                       $ref_category = ($items_val->subcategory_id)?$items_val->sub_category_code:$items_val->category_code; 
                                       $img_url = $this->get_item_image_exist($items_val->image);
                                        $newArray[]=array(
                                           "ref_id"=>$items_val->code,
                                           "title"=>$items_val->name,
                                           "available"=>true, 
                                           "description"=>($items_val->product_details) ? $items_val->product_details : $items_val->name,
                                           "sold_at_store"=>true,
                                           "price"=>(float)$items_val->up_price,
                                           "img_url"=>$img_url,
                                           "current_stock"=>-1,
                                           "recommended"=>true,
                                           "food_type"=>($items_val->food_type_id)?$items_val->food_type_id:'4',
                                           "category_ref_ids"=>array(($ref_category)?$ref_category:''),
                                           "translations"=>array(),
                                           "tags"=>(object) $tags,
                                           "excluded_platforms"=>array(),
                                            
                                        );
                                        
                                        
                                        // Group Option
                                        $productoption = $this->UPM->getrecords('sma_product_variants','*','result',array('product_id'=>$items_val->id));
                                        if($productoption){
                                            foreach($productoption as $pgop){
                                                $optionGroup[] = array(
                                                    'ref_id'=>$items_val->code,
                                                    'title'=>$items_val->name,
                                                    'min_selectable'=> 0,
                                                    'max_selectable'=> -1,
                                                    'active'=>true,
                                                    'item_ref_ids'=>array($items_val->code),
                                                    'translations'=>array()
                                                );
                                                $option[] = array(
                                                    'ref_id'=>$pgop->id,
                                                    'title'=>$pgop->name,
                                                    'description'=>NULL,
                                                    'weight'=>NULL,
                                                    'available'=>true,
                                                    'price'=>(float) $pgop->price, 
                                                    'opt_grp_ref_ids'=>array($items_val->code),
                                                    'nested_opt_grps'=>array(),
                                                    'translations'=>array()
                                                  );
                                            }
                                        }
                                        // Group option 
                                        
                                        //Product Taxes
                                            $taxget =  $this->UPM->check_dependancy('sma_tax_rates',array('id'=>$items_val->tax_rate),'*');
                                            $gettaxconfig = unserialize($taxget->tax_config);
                                            foreach($gettaxconfig as $taxvalue){
                                                $taxarray[] = array(
                                                    "ref_id"=>$taxvalue['code'].'-'.$taxvalue['percentage'],
                                                    "title"=>$taxvalue['name'],
                                                    "description" => $taxvalue['percentage']."% CGST on all items",
                                                    "active"=> true,
                                                    "structure"=> array(
                                                            "type"=> "percentage",
                                                            "applicable_on" => "item.price",
                                                            "value"=>$taxvalue['percentage']
                                                        ),
                                                        "item_ref_ids"=> [$items_val->code]

                                                 );
                                             }
                                        // End Product Taxes  
                                        
                                        
                                        $product_ids[] = $items_val->upproduct_id;
                                    }    
                                }
                                $field= array( 'add_status'=>'1',);
                                $msg = "Products add successfully";
                            break;
                        case 'Enable_product':
                                foreach($products as $items_val){
                                                                       
                                        $ref_category = ($items_val->subcategory_id)?$items_val->sub_category_code:$items_val->category_code;
                                        $newArray[]=array(
                                           "ref_id"=>$items_val->code,
                                           "title"=>$items_val->name,
                                           "available"=>true,
                                           "description"=>($items_val->product_details) ? $items_val->product_details : $items_val->name,
                                           "sold_at_store"=>true,
                                           "price"=>$items_val->up_price,
                                           "current_stock"=>-1,
                                           "recommended"=>true,
                                           "food_type"=>($items_val->food_type_id)?$items_val->food_type_id:'4',
                                           "category_ref_ids"=>array(($ref_category)?$ref_category:''),
                                           "translations"=>array(),
                                           "tags"=>(object) $tags,
                                           "excluded_platforms"=>array(), 
                                            /*'upipr_status'=>array(
                                                "action"=> "U",
                                                "id"=> 6565,
                                                "error"=> false
                                            ),*/
                                        );
                                        $product_ids[] = $items_val->upproduct_id;
                                      
                                }
                                $field= array( 'active_status'=>'1',);
                                $msg = "Products status enable successfully";
                            break;
                        
                        case 'Disable_product':
                                foreach($products as $items_val){

                                           $ref_category = ($items_val->subcategory_id)?$items_val->sub_category_code:$items_val->category_code;
                                           $newArray[]=array(
                                              "ref_id"=>$items_val->code,
                                              "title"=>$items_val->name,
                                              "available"=>false,
                                              "description"=>($items_val->product_details) ? $items_val->product_details : $items_val->name,
                                                "sold_at_store"=>true,
                                                "price"=>$items_val->up_price,
                                                "current_stock"=>-1,
                                                "recommended"=>true,
                                                "food_type"=>($items_val->food_type_id)?$items_val->food_type_id:'4',
                                                "category_ref_ids"=>array(($ref_category)?$ref_category:''),
                                                "translations"=>array(),
                                                "tags"=>(object) $tags,
                                                "excluded_platforms"=>array(), 
                                              /*'upipr_status'=>array(
                                                    "action"=> "U",
                                                    "id"=> 6565,
                                                    "error"=> false
                                                ),*/
                                           );
                                           $product_ids[] = $items_val->upproduct_id;
                                        
                                   }
                                   $field= array( 'active_status'=>'0',);
                                   $msg = "Products status disable successfully";
                            break;
                        
                        case 'Delete_product':
                                foreach($products as $items_val){
                                      
                                           $ref_category = ($items_val->subcategory_id)?$items_val->sub_category_code:$items_val->category_code;
                                           $newArray[]=array(
                                              "ref_id"=>$items_val->code,
                                              "title"=>$items_val->name,
                                              "price"=>(float)$items_val->up_price,
                                               'upipr_status'=>array(
                                                    "action"=> "D",
                                                    "id"=> 658,
                                                    "error"=> false
                                                ),
                                            );
                                           $product_ids[] = $items_val->upproduct_id;

                                   }
                                   $field= array( 'active_status'=>'0','add_status'=>'0',);
                                   $msg = "Products delete successfully";
                            break;
                    }
                    
                                
                    $collect_item['items'] = $newArray;
                    if(is_array($productoption)){
                        $collect_item['option_groups']=$optionGroup;
                        $collect_item['flush_options']=false;
                        $collect_item['options']=$option;  
                    }
                    if(is_array($taxarray)){
                       $collect_item['taxes']=$taxarray; 
                    }
                    
                    
                  
                    $URL = 'https://staging.urbanpiper.com/external/api/v1/inventory/locations/-1/';
                    $getresponse_item= $this->call_urbanpiper($URL,$collect_item);
                    $phpObject = json_decode($getresponse_item);
                    if($phpObject->status=='success'){
                             $this->db->where_in('id',$product_ids)->update('sma_up_products',$field);
                        $response['status']= 'success';
                        $response['messages'] = $msg; 
                    }else if($phpObject->status=='error'){
                    	$response['status']= 'error';
                        $response['messages'] = $phpObject->message; 
                    }else{
                        $response['status']= 'error';
                        $response['messages'] = 'Sorry Please Try Agian'; 
                    }
                    
                     return $response;

            	 // End Bulk Product
                       
                  
                break;
             /*==================================================================
             *  End Product Uploade on Urbanpiper 
             * =================================================================*/ 
          
           
             
            /*==================================================================
             *   Product Platform 
             ===================================================================*/   
            case 'Single_Product_platform':           
                    $product_id = $id; // Product_id
                    $store_id = $action_ref_id;
                    $platform = $bulk_id;
                    $action = $this->input->get('action');
                    $get_storedetails =   $this->UPM->check_dependancy('sma_up_stores',array('id'=>$store_id),'*');
                    $get_productdetails =   $this->UPM->check_dependancy('sma_up_products',array('product_id'=>$product_id),'*');                                     
                    
                    $item_platform =array(
                            'location_ref_id'=>$get_storedetails->ref_id,
                            'platforms'=>array($platform),
                            'item_ref_ids'=>array($get_productdetails->product_code),
                            'action'=>($action=='Enable')?'enable':'disable',
                        );
                       
                    $msg = ucfirst($patfrom[0]) .' product platform status '. strtolower($action).' successfully'; 
                   // echo json_encode( $item_platform);exit;
                    $URL = 'https://staging.urbanpiper.com/hub/api/v1/items/';
                        
                        $getresponse_platform= $this->call_urbanpiper($URL,$item_platform);
                        $phpObject = json_decode($getresponse_platform);
                        if($phpObject->status=='success'){
                           
                            // Update or insert Database
                            $check_array= array(
                                'up_store_id'=>$get_storedetails->id,
                                'up_store_ref_id'=>$get_storedetails->ref_id,
                                'product_id'=>$get_productdetails->product_id,
                                'product_code'=>$get_productdetails->product_code,
                            );
                           $get_store_patform =  $this->UPM->check_dependancy('sma_up_products_platform',$check_array,'id');
                            
                          
                            if($get_store_patform){
                       
                                $field = array($platform =>($action=='Enable')?'enable':'disable',);
                                $this->UPM->action_database('Update','sma_up_products_platform',array('id'=>$get_store_patform->id),$field);
                            }else{
                         
                                $check_array[$platform] = ($action=='Enable')?'enable':'disable';
                                $this->UPM->action_database('Insert','sma_up_products_platform','',$check_array);

                            }
                            // End Update or insert Database                            
                            
                            $response['status']= 'success';
                            $response['messages'] = $msg ; 
                        }else if($phpObject->status=='error'){
                            $response['status']= 'error';
                            $response['messages'] = $phpObject->message; 
                        }else{
                            $response['status']= 'error';
                            $response['messages'] = 'Sorry Please Try Agian'; 
                        }
                    echo json_encode($response);
                break;
                
            case 'Bulk_product_platform':
                    $patfrom = explode("~", $id);
                    $action = $action_ref_id;
                    $product_ids = $bulk_id;
                    $get_storedetails =   $this->UPM->check_dependancy('sma_up_stores',array('id'=>$patfrom['1']),'*');
                    $get_product = $this->UPM->getproduct_allup($product_ids);
                   
                    $productcode = array();
                    foreach($get_product as $product_list){
                        $getplatform =  'plat_'.$patfrom[0];
                        /*echo $getplatform;
                        if($product_list->$getplatform=='1'){*/
                        
                            $productcode[] = $product_list->code;
                       /* }*/
                    }
                 
                    $item_platform =array(
                            'location_ref_id'=>$get_storedetails->ref_id,
                            'platforms'=>array($patfrom[0]),
                            'item_ref_ids'=>$productcode,
                            'action'=>($action=='Enable')?'enable':'disable',
                        ); 
                   
                  
                    $msg = ucfirst($patfrom[0]) .' product platform status '. strtolower($action).' successfully';
                    $URL = 'https://staging.urbanpiper.com/hub/api/v1/items/';
                    $getresponse_platform= $this->call_urbanpiper($URL,$item_platform);
                    $phpObject = json_decode($getresponse_platform);
                    if($phpObject->status=='success'){    
                        // Store Database
                        foreach($get_product as $product_list){
                            $getplatform =  'plat_'.$patfrom[0];
                            $check_array = '';
                            $field = '';
                            
                            //if($product_list->up_add_status && $product_list->up_add_status && $product_list->$getplatform=='1'){
                                $get_productdetails =   $this->UPM->check_dependancy('sma_up_products',array('product_id'=>$product_list->id),'*');
                                 $check_array= array(
                                    'up_store_id'=>$get_storedetails->id,
                                    'up_store_ref_id'=>$get_storedetails->ref_id,
                                    'product_id'=>$get_productdetails->product_id,
                                    'product_code'=>$get_productdetails->product_code,
                                );
                              
                                $get_store_patform =  $this->UPM->check_dependancy('sma_up_products_platform',$check_array,'id');
                            
                                if($get_store_patform){
                                    $field = array($patfrom[0] =>($action=='Enable')?'enable':'disable',);
                                    $this->UPM->action_database('Update','sma_up_products_platform',array('id'=>$get_store_patform->id),$field);
                                }else{
                                    $check_array[$patfrom[0]] = ($action=='Enable')?'enable':'disable';
                                    $this->UPM->action_database('Insert','sma_up_products_platform','',$check_array);

                                }
                           // }
                        }
                        // End Store Database
                        $response['status']= 'success';
                        $response['messages'] =  $msg; 
                    }else if($phpObject->status=='error'){
                        $response['status']= 'error';
                        $response['messages'] = $phpObject->message; 
                    }else{
                        $response['status']= 'error';
                        $response['messages'] = 'Sorry Please Try Agian'; 
                    }
                    return $response;
                break;   
           /*==================================================================
             * End Product platfrom
             ===================================================================*/  
            
             /*==================================================================
             * Store Product Add
             ==================================================================*/
            case 'Single_Store_Product':
                    $action = $bulk_id;
                    $product_id = $id;
                    $where_condition = array('t1.id'=>$id);
                    $getpro_info = $this->UPM->getproductsingle($where_condition);
                    $ref_category = ($getpro_info->sub_category_code)?$getpro_info->sub_category_code:$getpro_info->category_code;
                    $get_storedetails =   $this->UPM->check_dependancy('sma_up_stores',array('id'=>$action_ref_id),'*');
                    
                    $img_url = $this->get_item_image_exist($getpro_info->image);
                    
                    $optionGroup = array();
                    $option      = array();
                    $taxarray    = array();       
                    $excluded_platforms = array();
                    $tags = array();
                     
                    $pplatforms = $this->UPM->getproductplatformdata($product_id);
                     
                     if($pplatforms[$product_id]->tag_zomato){
                         $tags['zomato'] = explode(',', $pplatforms[$product_id]->tag_zomato);
                     }
                     if($pplatforms[$product_id]->tag_swiggy){
                         $tags['swiggy'] = explode(',', $pplatforms[$product_id]->tag_swiggy);
                     }
                     if($pplatforms[$product_id]->tag_foodpanda){
                         $tags['foodpanda'] = explode(',', $pplatforms[$product_id]->tag_foodpanda);
                     }
                     if($pplatforms[$product_id]->tag_ubereats){
                         $tags['ubereats'] = explode(',', $pplatforms[$product_id]->tag_ubereats);
                     }
                     if($pplatforms[$product_id]->tag_urbanpiper){
                         $tags['urbanpiper'] = explode(',', $pplatforms[$product_id]->tag_urbanpiper);
                     }
                    
                        
                  //  if($this->data['up_setting']->urbanpiper){ $excluded_platforms[] = 'urbanpiper'; }
                    if($this->data['up_setting']->zomato){ $excluded_platforms[] = 'zomato'; }
                    if($this->data['up_setting']->foodpanda){ $excluded_platforms[] = 'foodpanda'; }
                    if($this->data['up_setting']->swiggy){ $excluded_platforms[] = 'swiggy'; }
                    if($this->data['up_setting']->ubereats){ $excluded_platforms[] = 'ubereats'; }
                        
                   // Group Option
                    $productoption = $this->UPM->getrecords('sma_product_variants','*','result',array('product_id'=>$id));
                    if($productoption){

                        $optgropcode = 'og_'.$getpro_info->code;

                        $optionGroup[] = array(
                                    'ref_id'=>$optgropcode,
                                    'title'=>$getpro_info->name,
                                    'min_selectable'=> 1,
                                    'max_selectable'=> 1,
                                    'active'=>true,
                                    'item_ref_ids'=>array($getpro_info->code)
                                );

                        foreach($productoption as $pgop){

                            $option[] = array(
                                'ref_id'=>$pgop->id,
                                'title'=>$pgop->name,
                                'description'=>$pgop->name,
                                'weight'=>NULL,
                                'available'=>true,
                                'price'=>(float) $pgop->price,
                                'sold_at_store'=>true,
                                'opt_grp_ref_ids'=>array($optgropcode),
                                'nested_opt_grps'=>array(),
                                'translations'=>array()
                              );
                        }
                    }
                    // Group option  
                    
                    //Product Taxes
                    $taxget =  $this->UPM->check_dependancy('sma_tax_rates',array('id'=>$getpro_info->tax_rate),'*');
                    $gettaxconfig = unserialize($taxget->tax_config);
                    foreach($gettaxconfig as $taxvalue){
                        $taxarray[] = array(
                            "ref_id"=>$taxvalue['code'].'-'.$taxvalue['percentage'],
                            "title"=>$taxvalue['name'],
                            "description" => $taxvalue['percentage']."% CGST on all items",
                            "active"=> true,
                            "structure"=> array(
                                    "type"=> "percentage",
                                    "applicable_on" => "item.price",
                                    "value"=>$taxvalue['percentage']
                                ),
                                "item_ref_ids"=> [$getpro_info->code]

                         );
                     }
                    // End Product Taxes
                    
                    switch ($action){
                        case 'UP_Add_Product':
                                $itemsArray =array(array(
                                    "ref_id"=>$getpro_info->code,
                                    "title"=>$getpro_info->name,
                                    "description"=>($getpro_info->product_details)?$getpro_info->product_details:$getpro_info->name,
                                    "available"=> ($pplatforms[$product_id]->available)? true : false,                                    
                                    "sold_at_store"=>($pplatforms[$product_id]->sold_at_store)? true : false,
                                    "recommended"=>($pplatforms[$product_id]->recommended)? true : false,
                                    "price"=>(float)$getpro_info->up_price,
                                    "img_url"=>$img_url,
                                    "current_stock"=>-1,                                   
                                    "food_type"=>($getpro_info->food_type)?$getpro_info->food_type:'4',
                                    "category_ref_ids"=>array(($ref_category)?$ref_category:''),
                                    "translations"=>array(),
                                    "tags"=>(object) $tags,
                                    "excluded_platforms"=>$excluded_platforms,
                                ));
                               
                                $field = array(
                                    'active_status'=>'1',
                                    'add_status'=>'1'
                                );
                                   $msg = 'Product add successfully.';
                                
                            break;
                            
                        case 'UP_Update_Product':
                            
                                 $itemsArray =array(array(
                                   "ref_id"=>$getpro_info->code,
                                    "title"=>$getpro_info->name,
                                    "description"=>($getpro_info->product_details)?$getpro_info->product_details:$getpro_info->name,
                                    "available"=> ($pplatforms[$product_id]->available)? true : false,                                    
                                    "sold_at_store"=>($pplatforms[$product_id]->sold_at_store)? true : false,
                                    "recommended"=>($pplatforms[$product_id]->recommended)? true : false,
                                    "price"=>(float)$getpro_info->up_price,
                                    "img_url"=>$img_url,
                                    "current_stock"=>-1,
                                    "food_type"=>($getpro_info->food_type)?$getpro_info->food_type:"4",
                                    "category_ref_ids"=>array(($ref_category)?$ref_category:''),
                                    "translations"=>array(),
                                    "excluded_platforms"=>$excluded_platforms,
                                    "tags"=> $tags,
                                    
                                   /* 'upipr_status'=>array(
                                        "action"=> "U",
                                        "id"=> 3423,
                                        "error"=> false
                                    ),*/
                                ));
                                // Group Option
                               
                                $field = array(
                                    'active_status'=>'1',
                                    'add_status'=>'1'
                                );
                                
                              $msg = 'Product update successfully.';
                            
                            break;       
                            
                        case 'UP_Product_status':
                                $itemsArray =array(array(
                                    "ref_id"=>$getpro_info->code,
                                    "title"=>$getpro_info->name,
                                    "description"=>($getpro_info->product_details)?$getpro_info->product_details:$getpro_info->name,
                                    "available"=> ($pplatforms[$product_id]->available)? true : false,                                    
                                    "sold_at_store"=>($pplatforms[$product_id]->sold_at_store)? true : false,
                                    "recommended"=>($pplatforms[$product_id]->recommended)? true : false,
                                    "price"=>(float)$getpro_info->up_price,
                                    "img_url"=>$img_url,
                                    "current_stock"=>-1,
                                    "food_type"=>$getpro_info->food_type?$getpro_info->food_type:'4' ,
                                    "category_ref_ids"=>array(($ref_category)?$ref_category:''),
                                    "translations"=>array(),
                                    "tags"=>(object) $tags,
                                ));
                                                   
                               
                                $field = array(
                                    'active_status'=>($_GET['action']=='Enable')?'1':'0',
                                );
                                $msg = 'Product status '.strtolower($_GET['action']).' successfully.';
                            break;
                        
                    }
                                   
                    if(is_array($itemsArray)){                    
                        
                        $pass = array("items"=>$itemsArray,);
                         if(is_array($optionGroup)){
                            $pass['option_groups']=$optionGroup;
                            $pass['flush_options']=false;
                            $pass['options']=$option;  
                        }
                        if(is_array($taxarray)){
                            $pass['taxes']=$taxarray; 
                        } 
                        
                        $pass['charges'][] = array(
                            "ref_id"=>"pc_1",
                            "title"=>"Packing Charge",
                            "description"=>"Packing charge per item quantity",
                            "active"=>true,
                            "structure"=>array(
                                            "type"=>"percentage",
                                            "applicable_on"=>"item.quantity",
                                            "value"=>0
                                        ),
                            "fulfillment_modes"=>["delivery"],
                            "excluded_platforms"=>$excluded_platforms,
                            "item_ref_ids"=>[$getpro_info->code]
                        );

                        $URL = 'https://staging.urbanpiper.com/external/api/v1/inventory/locations/'.$get_storedetails->ref_id.'/';
                      
                        $getresponse_item = $this->call_urbanpiper($URL,$pass);
                        
                        $phpObject = json_decode($getresponse_item);
                     
                        
                        if($phpObject->status=='success'){
                            
                            /*================================*/
                             // Update or insert Database
                            $check_array= array(
                                'up_store_id'=>$get_storedetails->id,
                                'up_store_ref_id'=>$get_storedetails->ref_id,
                                'product_id'=>$getpro_info->id,
                                'product_code'=>$getpro_info->code,
                            );
                            
                          
                           $get_store_patform = $this->UPM->check_dependancy('sma_up_products_platform',$check_array,'id');
                            
                            if($get_store_patform){
                                
                                $this->UPM->action_database('Update','sma_up_products_platform',array('id'=>$get_store_patform->id),$field);
                            }else{
                                $addfield = array_merge($check_array,$field);
                                $this->UPM->action_database('Insert','sma_up_products_platform','',$addfield);
                            }
                            // End Update or insert Database
                            
                            /*=================================*/
                            
                            $response['status']= 'success';
                            $response['messages'] = $msg ; 
                        }else if($phpObject->status=='error'){
                            $response['status']= 'error';
                            $response['messages'] = $phpObject->message; 
                        }else{
                            $response['status']= 'error';
                            $response['messages'] = 'Sorry Please Try Agian'; 
                        }
                    }else{
                        $response['status']= 'error';
                        $response['messages'] = 'Sorry Please Try Agian'; 
                    }    
                    echo json_encode($response);
                break;
                
                
            case 'Bulk_store_product':
                    $priduct_ids = $bulk_id;
                    $store_id = $id;
                    $get_storedetails =   $this->UPM->check_dependancy('sma_up_stores',array('id'=>$store_id),'*');
                    $get_product = $this->UPM->getproduct_allup($priduct_ids);
                    $itemsArray =array();
                    $optionGroup = array();
                    $option  = array();
                    $taxarray = array();
                    $tags = array(
                    	"zomato"=>array(),
                    	"swiggy"=>array(),
                    	"foodpanda"=>array(),
                    	"ubereats"=>array(),
                    	"urbanpiper"=>array(),
                    );    
                    switch ($action_ref_id){
                        case 'add':
                                foreach ($get_product as $productval){
                                $ref_category = ($productval->sub_category_code)?$productval->sub_category_code:$productval->category_code;
                                $img_url = $this->get_item_image_exist($productval->image);
                                    $itemsArray[] = array(
                                        "ref_id"=>$productval->code,
                                        "title"=>$productval->name,
                                        "available"=>false,
                                        "description"=>($productval->product_details)? strip_tags($productval->product_details) : $productval->name,
                                        "sold_at_store"=>true,
                                        "price"=>(float)$productval->up_price,
                                        "img_url"=>$img_url,
                                        "current_stock"=>-1,
                                        "recommended"=>true,
                                        "food_type"=>($productval->food_type_id)?$productval->food_type_id:'4',
                                        "category_ref_ids"=>array(($ref_category)?$ref_category:''),
                                        "translations"=>array(),
                                        "tags"=>(object) $tags,
                                        "excluded_platforms"=>array()
                                    );
                                    
                                    // Group Option
                                        $productoption = $this->UPM->getrecords('sma_product_variants','*','result',array('product_id'=>$items_val->id));
                                        if($productoption){
                                            foreach($productoption as $pgop){
                                                $optionGroup[] = array(
                                                     'ref_id'=>$productval->code,
                                                    'title'=>$productval->name,
                                                    'min_selectable'=> 1,
                                                    'max_selectable'=> 1,
                                                    'active'=>true,
                                                    'item_ref_ids'=>array($productval->code)
                                                );
                                                $option[] = array(
                                                   'ref_id'=>$pgop->id,
                                                    'title'=>$pgop->name,
                                                    'description'=>NULL,
                                                    'weight'=>NULL,
                                                    'available'=>true,
                                                    'price'=>(float) $pgop->price, 
                                                    'sold_at_store'=>true,
                                                    'opt_grp_ref_ids'=>array($productval->code),
                                                    'nested_opt_grps'=>array(),
                                                    'translations'=>array()
                                                  );
                                            }
                                        }
                                        // Group option   
                                        //Product Taxes
                                            $taxget =  $this->UPM->check_dependancy('sma_tax_rates',array('id'=>$productval->tax_rate),'*');
                                            $gettaxconfig = unserialize($taxget->tax_config);
                                            foreach($gettaxconfig as $taxvalue){
                                                $taxarray[] = array(
                                                    "ref_id"=>$taxvalue['code'].'-'.$taxvalue['percentage'],
                                                    "title"=>$taxvalue['name'],
                                                    "description" => $taxvalue['percentage']."% CGST on all items",
                                                    "active"=> true,
                                                    "structure"=> array(
                                                            "type"=> "percentage",
                                                            "applicable_on" => "item.price",
                                                            "value"=>$taxvalue['percentage']
                                                        ),
                                                        "item_ref_ids"=> [$productval->code]

                                                 );
                                             }
                                        // End Product Taxes
                                    
                                    $product_info[] =array(
                                        'product_id'=>$productval->id,
                                        'product_code'=>$productval->code,
                                        'up_store_ref_id'=>$get_storedetails->ref_id,
                                        'up_store_id'=>$get_storedetails->id,
                                         
                                    ) ;
                                   
                                }
                                $field = array(
                                   'add_status'=>'1',  
                                );
                                $msg = "Products add successfully";
                            break;
                        case 'product_enable':
                                foreach ($get_product as $productval){
                                $ref_category = ($productval->sub_category_code)?$productval->sub_category_code:$productval->category_code;
                                $img_url = $this->get_item_image_exist($productval->image);
                                    $itemsArray[] = array(
                                         "ref_id"=>$productval->code,
                                        "title"=>$productval->name,
                                        "available"=>true,
                                        "description"=>($productval->product_details)? strip_tags($productval->product_details) : $productval->name,
                                        "sold_at_store"=>true,
                                        "price"=>(float)$productval->up_price,
                                        "img_url"=>$img_url,
                                        "current_stock"=>-1,
                                        "recommended"=>true,
                                        "food_type"=>($productval->food_type_id)?$productval->food_type_id:'4',
                                        "category_ref_ids"=>array(($ref_category)?$ref_category:''),
                                        "translations"=>array(),
                                        "tags"=>(object) $tags,
                                        "excluded_platforms"=>array()
                                        /*'upipr_status'=>array(
                                            "action"=> "U",
                                            "id"=> 3423,
                                            "error"=> false
                                        ),*/
                                    );
                                    
                                    $product_info[] =array(
                                        'product_id'=>$productval->id,
                                        'product_code'=>$productval->code,
                                        'up_store_ref_id'=>$get_storedetails->ref_id,
                                        'up_store_id'=>$get_storedetails->id,
                                         
                                    ) ;
                                   
                                }
                                $field = array(
                                   'active_status'=>'1',  
                                );
                                $msg = "Products status enable successfully";
                            break;
                        case 'product_disable':
                                foreach ($get_product as $productval){
                                $ref_category = ($productval->sub_category_code)?$productval->sub_category_code:$productval->category_code;
                                $img_url = $this->get_item_image_exist($productval->image);
                                    $itemsArray[] = array(
                                        "ref_id"=>$productval->code,
                                        "title"=>$productval->name,
                                        "available"=>false,
                                        "description"=>($productval->product_details)? strip_tags($productval->product_details) : $productval->name,
                                        "sold_at_store"=>true,
                                        "price"=>(float)$productval->up_price,
                                        "img_url"=>$img_url,
                                        "current_stock"=>-1,
                                        "recommended"=>true,
                                        "food_type"=>$productval->food_type_id ? $productval->food_type_id : '4',
                                        "category_ref_ids"=>array(($ref_category)?$ref_category:''),
                                        "translations"=>array(),
                                        "tags"=>(object) $tags,
                                        "excluded_platforms"=>array()
                                        /*'upipr_status'=>array(
                                            "action"=> "U",
                                            "id"=> 3423,
                                            "error"=> false
                                        ),*/
                                    );
                                    
                                    $product_info[] =array(
                                        'product_id'=>$productval->id,
                                        'product_code'=>$productval->code,
                                        'up_store_ref_id'=>$get_storedetails->ref_id,
                                        'up_store_id'=>$get_storedetails->id,
                                         
                                    ) ;
                                   
                                }
                                $field = array(
                                   'active_status'=>'0',  
                                );
                                $msg = "Products status disable successfully";
                            break;
                        case 'product_delete':
                                foreach ($get_product as $productval){
                                $ref_category = ($productval->subcategory_id)?$productval->sub_category_code:$productval->category_code;
                                    $itemsArray[] = array(
                                        "ref_id"=>$productval->code,
                                        "title"=>$productval->name,
                                        'upipr_status'=>array(
                                        "action"=> "D",
                                        "id"=> 658,
                                        "error"=> false
                                        ),
                                    );
                                    
                                    $product_info[] =array(
                                        'product_id'=>$productval->id,
                                        'product_code'=>$productval->code,
                                        'up_store_ref_id'=>$get_storedetails->ref_id,
                                        'up_store_id'=>$get_storedetails->id,
                                         
                                    ) ;
                                   
                                }
                                $field = array(
                                    'active_status'=>'0',
                                    'add_status'=>'0',
                                    'urbanpiper'=>NULL,
                                    'zomato'=>NULL,
                                    'foodpanda'=>NULL,
                                    'swiggy'=>NULL,
                                    'ubereats'=>NULL,
                                );
                                $msg = "Products delete successfully";
                            break;
                    }//end switch.
                     
                    if(is_array($itemsArray)){
                        $pass = array( "items"=>$itemsArray, );   
                        if(is_array($productoption)){
                            $pass['option_groups']=$optionGroup;
                            $pass['flush_options']=false;
                            $pass['options']=$option;  
                        }
                        if(is_array($taxarray)){
                           $pass['taxes']=$taxarray; 
                        } 
                        $URL = 'https://staging.urbanpiper.com/external/api/v1/inventory/locations/'.$get_storedetails->ref_id.'/';
                        $getresponse_item= $this->call_urbanpiper($URL,$pass);
                        $phpObject = json_decode($getresponse_item);
                        if($phpObject->status=='success'){
                           
                           $size = sizeof($product_info);
                    
                            for($i=0;$i<$size;$i++){
                               $check_array = array(
                                   'up_store_id'=> $product_info[$i]['up_store_id'],
                                   'up_store_ref_id'=> $product_info[$i]['up_store_ref_id'],
                                   'product_id'=> $product_info[$i]['product_id'],
                                   'product_code'=> $product_info[$i]['product_code'],);

                                $get_store_patform =  $this->UPM->check_dependancy('sma_up_products_platform',$check_array,'id');
                                if($get_store_patform){
                                    $this->UPM->action_database('Update','sma_up_products_platform',array('id'=>$get_store_patform->id),$field);
                                }else{
                                    $addfield = array_merge($check_array,$field);
                                    $this->UPM->action_database('Insert','sma_up_products_platform','',$addfield);
                                }
                            }
                         
                            $response['status']= 'success';
                            $response['messages'] = $msg ; 
                        }else if($phpObject->status=='error'){
                            $response['status']= 'error';
                            $response['messages'] = $phpObject->message; 
                        }else{
                            $response['status']= 'error';
                            $response['messages'] = 'Sorry Please Try Agian'; 
                        }
                    }else{
                        $response['status']= 'error';
                        $response['messages'] = 'Sorry Please Try Agian'; 
                    }   
                    return $response;
                
                break;   
               
                
            /*==================================================================
             * End Store Product Add
             ==================================================================*/    
            
            
           /*=======================================================================
           *  Store Platfrom 
           *========================================================================*/     
           case 'Store_Platform': // Store Platform 
                   $get_storedetails =   $this->UPM->check_dependancy('sma_up_stores',$wharecondition,'*');
	                $platform_id = $this->input->get('id');
	                $action = $this->input->get('action');
	                $sstore_platform = array(
	                    "location_ref_id"=>$get_storedetails->ref_id,
	                    "platforms"=>array($action), 
	                    "action"=>$platform_id,
	                );
	              
	              
	                $URL = 'https://staging.urbanpiper.com/hub/api/v1/location/';
	                $getresponse_platform= $this->call_urbanpiper($URL,$sstore_platform);
	                        $phpObject = json_decode($getresponse_platform);
	                        if($phpObject->status=='success'){
	                            $this->UPM->action_database('Update','sma_up_stores',$wharecondition,array($action_ref_id=>$platform_id,'updated_at'=>date('Y-m-d H:i:s')));
	                            $response['status']= 'success';
	                            $response['messages'] = $phpObject->message; 
	                        }else if($phpObject->status=='error'){
	                            $response['status']= 'error';
	                            $response['messages'] = $phpObject->message; 
	                        }else{
	                            $response['status']= 'error';
	                            $response['messages'] = 'Sorry Please Try Agian'; 
	                        }
	                    echo json_encode($response);
                
                break;
             /*======================================================================
             * End Store  Platform
             *=======================================================================*/  
             
              
           /*=========================================================================
           * Order status
           *==========================================================================*/
            case 'Order_status':
            
                    $message = $this->input->get('message');
                 
                    $status = $action_ref_id;
                    $order_id = $id;
                    
                    $pass_orderstatus = array(
                        'new_status'=>$status,
                        'message'=>$message);
                                  
                   // Call Put 
                  
                    
                    $URL = 'https://staging.urbanpiper.com/external/api/v1/orders/'.$order_id.'/status/';
                    
                    $order_status = $this->call_urbanpiper_put($URL,$pass_orderstatus);
                    
                      echo json_encode($order_status);
                break;
            
            case 'update_order_status':

                break;
           /*===========================================================================
           * End Order Status
           *============================================================================*/           
         
             
                
            default :
                	  echo json_encode($response);
                break;
        }
        
     
    }
    
    public function update_order_status($order_id ,$order_status, $status_message=null) { 
              
        $data = array(
            "new_status" =>urldecode($order_status),
            "message" => urldecode($status_message)
        );
                        
        $apiurl = "https://staging.urbanpiper.com/external/api/v1/orders/$order_id/status/";
        
        //$order_status = $this->call_urbanpiper_put($apiurl, $data);
        
                        
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $apiurl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "PUT");
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
                    'Authorization: '.$this->api_key,
                    'Content-Type: application/json',
                 ));                
                        
        echo $response = curl_exec($ch);
    }
    
    /*=======================================================================================
    ** End Store Action 
    =========================================================================================*/

    /*=======================================================================================
    *   Call Urbanpiper Using  POST Method
    *========================================================================================*/
    
   public function call_urbanpiper($URL,$data){
       // $url = "https://staging.urbanpiper.com/external/api/v1/stores/";
                $data_json = json_encode($data);
   		
   	        $ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$URL);
		/*curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);*/ //apiKey biz_adm_clients_XWuoXNFAgktp:4b5300a21c68e77fe69dd81889993f6bc6ff1885
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: '.$this->api_key,'Content-Type : application/json'));
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		$response  = curl_exec($ch);
		curl_close($ch);
		return  $response;
   
   }    
   
    /*=======================================================================================
    *   End  Call Urbanpiper Using  POST Method
    *========================================================================================*/
   
    /*=======================================================================================
    *   Call Urbanpiper Using  PUT Method
    *========================================================================================*/
   public function call_urbanpiper_put($URL,$data){
       
    		$data_json = json_encode($data);
                    $ch = curl_init();
		    curl_setopt($ch, CURLOPT_URL,$URL);
                    /*curl_setopt($ch, CURLOPT_HTTPHEADER,$headers);*/
                    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: '.$this->api_key,'Content-Type : application/json'));
                    curl_setopt($ch, CURLOPT_PUT, 1);
                    curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
                    curl_setopt($ch, CURLOPT_PUT, true);
                    $response  = curl_exec($ch);
                    curl_close($ch);
                  return  $response;  
   }
   
   /*=======================================================================================
    * End  Call Urbanpiper Using  PUT Method
    *========================================================================================*/
   
   
   
   
  
   /*==========================================================================
     *  Urbenpiper Webhook get response all response json forrmat
     * ========================================================================*/
    
    /*-----------------------------------------------------------------------
        * Urbanpiper get orders response and set pos system
    -----------------------------------------------------------------------*/
    public function add_order(){
        
           $this->load->model('pos_model'); // Load pos model
           $jsonString = file_get_contents("php://input");
           $phpObject = json_decode($jsonString);
           $newJsonString = json_encode($phpObject);
           
           // Using maintain log
           $serialized_array=serialize($phpObject);
           $getorder_status = $phpObject->order->details->order_state;
           $getoredrid =$phpObject->order->details->id;
           $getchannel = $phpObject->order->details->channel;
           $log_field =array(
               'order_id'=>$getoredrid,
               'channel'=>$getchannel,
               'response_json'=>$serialized_array,
               'log_type'=>'Order placed',
               'order_status'=>$getorder_status
           );
           $this->UPM->action_database('Insert','sma_up_logs','',$log_field);
           // End Using Maintain log 
           
         //  header('Content-Type: application/json');
           
           
           $customer_id = '';
           $customer_details = $phpObject->customer;
           $getdata = $this->UPM->check_dependancy('sma_companies',array('phone'=>$customer_details->phone),'id'); // check Mobile Number 
           if($getdata){
               $customer_id = $getdata->id;
            }else{
               $customer_address = $customer_details->address;
               $customer_field = array(
                    'group_id'=>'3',
                    'group_name'=>'customer',
                    'customer_group_id'=>'10',
                    'customer_group_name'=>'UrbanPiper',
                    'name'=> $customer_details->name,
                    'company'=> $customer_details->name,
                    'phone'=>$customer_details->phone,
                    'email'=>$customer_details->email,
                    'city'=>$customer_address->city,
                    'up_is_guest_mode'=>$customer_address->is_guest_mode,
                    'up_landmark'=>$customer_address->landmark,
                    'lat'=>$customer_address->latitude,
                    'lng'=>$customer_address->longitude,
                    'address'=>$customer_address->line_1.", ".$customer_address->line_2,
                    'postal_code'=>$customer_address->pin,
                    'up_sub_locality'=>$customer_address->sub_locality,
                    'up_tag'=>$customer_address->tag,
                );
                $result =  $this->UPM->action_database('Insert','sma_companies','',$customer_field);
                $customer_id =$this->db->insert_id();
                
                $response = ($result)?'Success':'Try Again';
            }
          
          
            // order add
            //Optional Condtition check Order avalible or not
            $getorder_data = $this->UPM->check_dependancy('sma_sales',array('up_order_id'=>$phpObject->order->details->id),'id'); // check order id 
            
            if($getorder_data){              
                $order_id = $getorder_data->id;                   
            } else { // End  Optional Condition
            
                $reference  = $this->site->getReference('up');
                $order_details = $phpObject->order->details;
                // load Pos model using biller details
                // KOT Token
                $getkot_log = $this->pos_model->getkotlog(array('kot_date'=>date('Y-m-d')));
                if(empty($getkot_log)){
                    $tokan ='1';
                    $kotlog = array('tokan'=>$tokan,'kot_date'=>date('Y-m-d'));
                    $this->pos_model->actionkotlog('Insert',$kotlog,array('id'=>$getkot_log->id));
                    
                } else {
                    $tokan = $getkot_log->tokan + 1;
                    $kotlog = array('tokan'=>$tokan);
                    $this->pos_model->actionkotlog('Update',$kotlog,array('id'=>$getkot_log->id));
                }
                // End KOT Token
                       
               // Biller Details
                $this->pos_settings = $this->pos_model->getSetting();
                $biller_details = $this->site->getCompanyByID($this->pos_settings->default_biller);
                $biller = $biller_details->company != '-' ? $biller_details->company : $biller_details->name;
                $biller_id = $biller_details->id;
                // End Biller Details
                
                //$warehouse = explode("_",$phpObject->order->store->merchant_ref_id);
                $warehouse = $this->UPM->getrecords('sma_up_stores','warehouse_id','row',array('ref_id'=>$phpObject->order->store->merchant_ref_id));
                $order_field = array(
                    'date'=>date('Y-m-d H:i:s',$order_details->created / 1000),
                    'reference_no'=>$reference,
                    'customer_id'=>$customer_id,
                    'customer'=>$customer_details->name,
                    'warehouse_id'=>$warehouse->warehouse_id,
                    'biller_id'=>$biller_id,
                    'biller'=>$biller,
                    'total' =>$order_details->order_subtotal ,
                    'order_discount'=>$order_details->discount,
                    'total_discount'=>$order_details->total_external_discount,
                    'product_tax'=>$order_details->item_level_total_taxes,
                    'order_tax' =>$order_details->order_level_total_taxes,
                    'total_tax' =>$order_details->total_taxes,
                    'shipping' =>$order_details->charges[0]->value,
                    'grand_total' =>$order_details->order_total,
                    'grand_total' =>$order_details->instructions,
                    'total_items'=>count($phpObject->order->items),
                    'delivery_status'=>'pending',
                    'up_sales_notification'=>'1',
                    'up_channel'=>$order_details->channel,
                    'up_response'=>serialize($phpObject),
                    'up_sales'=>'1',
                    'up_next_status'=>$phpObject->order->next_state,
                    'up_item_level_total_charges'=>$order_details->item_level_total_charges,
                    'up_order_level_total_charges'=>$order_details->order_level_total_charges,
                    'up_order_id'=>$order_details->id,
                    'up_delivery_datetime'=>date('Y-m-d H:i:s',$order_details->delivery_datetime / 1000),
                    'up_coupon' =>$order_details->coupon
                );
                $resultorder =  $this->UPM->action_database('Insert','sma_sales','',$order_field);
                $order_id = $this->db->insert_id();
                
                // Setting Order Manage
                $getsetting = $this->UPM->check_dependancy('sma_settings',array('setting_id'=>'1'),array('up_balance_order','up_order_received'));
                
                $settingfiled = array(
                    'up_balance_order'=>$getsetting->up_balance_order - 1,
                    'up_order_received'=>$getsetting->up_order_received + 1
                );
                
                $this->UPM->action_database('Update','sma_settings',array('setting_id'=>'1'),$settingfiled); 
                // End Order Manage
               
            } // Optinal Condition order Id
            
            $order_items = $phpObject->order->items;
            foreach($order_items as $item){
                $total_charges = '';
                $price ='';
                $total_tax_rate = '';
                $total_tax_value = '';
                
                $product_details = $this->UPM->check_dependancy('sma_products',array('code'=>$item->merchant_id),'*'); 
                $getproduct_unit = $this->UPM->check_dependancy('sma_units',array('id'=>$product_details->unit),'name');
                    
                    if(empty($item->options_to_add)){
                        $price = $item->price;
                        $option_order_id=Null;
                        $option_id=Null;
                        $option_title = Null;
                    }else{
                        foreach($item->options_to_add as $option){
                            $price = $price +  $option->price;
                            $option_order_ids[] = $option->id;
                            $option_ids[] = $option->merchant_id;
                            $option_titles[] = $option->title;
                        }
                        $option_order_id = join(',', $option_order_ids);
                        $option_id = join(',', $option_ids);
                        $option_title = join(',', $option_titles);
                    }
                               
                   
                    foreach($item->charges as $charges){
                     $total_charges = $total_charges + $charges->value;
                    }
                    
                    foreach($item->taxes as $taxes){
                       $total_tax_rate = $total_tax_rate + $taxes->rate;
                       $total_tax_value = $total_tax_value + $taxes->value;
                    }
                    
                    $order_discount = $phpObject->order->details->ext_platforms;
          
                    if(empty($order_discount[0]->discounts)){
                        $subtotal = $item->total_with_tax; - $total_tax_value;
                    }else{
                        $subtotal = $item->total + ($total_charges * $item->quantity) ;
                    }
                  
                   // unset($total_charges);
                    //$price = $item->price;
                    $item_feild = array(
                        'sale_id'=>$order_id,
                        'product_code'=>$item->merchant_id,
                        'product_id'=>$product_details->id,
                        'article_code'=>$product_details->article_code,
                        'product_name'=>$product_details->name,
                        'product_type'=>$product_details->type,
                        'option_id'=>$item->options_to_add[0]->merchant_id,
                        'tax'=> $total_tax_rate,
                        'mrp'=>$product_details->mrp,
                        'real_unit_price'=>$price,
                        'unit_discount'=>$item->discount,
                        'unit_tax'=>$total_tax_value,
                        'unit_price' =>$price,
                        'net_unit_price'=>$price,
                        'invoice_unit_price'=>$price,
                        'invoice_net_unit_price'=>$subtotal,
                        'quantity'=>$item->quantity,
                        'item_discount'=>$item->discount,
                        'item_tax'=>$total_tax_value,
                        'net_price'=> $price,
                        'invoice_total_net_unit_price'=>$subtotal,
                        'subtotal'=>$subtotal,
                        'unit_quantity'=>$item->quantity,
                        'product_unit_id'=>$product_details->unit,
                        'product_unit_code'=>$getproduct_unit->name,
                        'up_option_order_id'=>$option_order_id,
                        'up_option_title'=>$option_title,
                        'up_option_price'=>$price,
                        'up_option_id'=>$option_id,
                        'up_order_id' =>$item->id, 
                        'up_packaging_charge' =>$total_charges,
                        'up_option_response'=>serialize($item->options_to_add),
                        'urbanpiper'=>'1',                
                    );
                    $taxes = $item->taxes;
                    $resultorder =  $this->UPM->action_database('Insert','sma_sale_items','',$item_feild);
                    $item_id = $this->db->insert_id();
                    foreach($taxes as $taxes_name){
                        $taxes_field = array(
                             'item_id'=>$item_id,
                             'sale_id'=>$order_id,
                             'attr_code'=>$taxes_name->title,
                             'attr_name'=>$taxes_name->title,
                             'attr_per'=>$taxes_name->rate,
                             'tax_amount'=>$taxes_name->value,
                        ); 
                     $this->UPM->action_database('Insert','sma_sales_items_tax','',$taxes_field);
                    }
            }
            $this->site->updateReference('up');
            echo json_encode($response['status']="success");
            
    }
    
   /*----------------------------------------------------------------------
     End Urbanpiper Order get response and set pos system
    *---------------------------------------------------------------------*/
     
    /*----------------------------------------------------------------------
    *  Order rider information response get and Set on pos System 
    ----------------------------------------------------------------------*/
    public function orderrider(){
        
        $response = array();
        $jsonString = file_get_contents("php://input");
        $phpObject = json_decode($jsonString);
        
        
        // Using maintain log
          $serialized_array=serialize($phpObject);
           $getorder_status = $phpObject->delivery_info->current_state;
           $getoredrid =$phpObject->order_id;
           $getchannel = $phpObject->additional_info->external_channel->name;
           $log_field =array(
               'order_id'=>$getoredrid,
               'channel'=>$getchannel,
               'response_json'=>$serialized_array,
               'log_type'=>'Order delivery status',
               'order_status'=>$getorder_status
           );
           
           
        $this->UPM->action_database('Insert','sma_up_logs','',$log_field);
        // End maintain log
                
        $channel_info = $phpObject->additional_info->external_channel;
        
        $delivery_info = $phpObject->delivery_info;
                
        // Convert to millitime to datetime
         $created_date = date('Y-m-d H:i:s', $delivery_info->status_updates[0]->created / 1000);
        // End Convert to millitime to datetime
     
        $order_rider_field = array(
             'up_order_id'=>$phpObject->order_id,
             'channel_name'=>$channel_info->name,
             'channel_order_id'=>$channel_info->order_id,
             'current_state'=>$delivery_info->current_state,
             'alt_phone'=>$delivery_info->delivery_person_details->alt_phone,
             'name'=>$delivery_info->delivery_person_details->name,
             'phone'=>$delivery_info->delivery_person_details->phone,
             'comments'=>$delivery_info->status_updates[count($delivery_info->status_updates)-1]->comments,
             'order_status'=>$delivery_info->status_updates[count($delivery_info->status_updates)-1]->status,
             'created'=>$created_date,
             'up_order_rider_response'=>serialize($phpObject),
        );
      
        $check_order = $this->UPM->check_dependancy('sma_up_orderrider',array('up_order_id'=>$phpObject->order_id),'id');
        
        if($check_order){
            $update_return = $this->UPM->action_database('Update','sma_up_orderrider',array('id'=>$check_order->id),$order_rider_field);
            if($update_return){
                $response['status']= 'success';
            }else{
                $response['status']= 'error';
            }
        } else {
            $inser_orderredier = $this->UPM->action_database('Insert','sma_up_orderrider','',$order_rider_field);
            if($inser_orderredier){
                $response['status']= 'success';
            }else{
                $response['status']= 'error';
            }
        }
        echo json_encode($response);
    }
   /*----------------------------------------------------------------------
    *  End Order rider information response get and Set on pos System 
     ----------------------------------------------------------------------*/
        
    /*----------------------------------------------------------------------
     *  Order status response get and set pos system
      ----------------------------------------------------------------------*/
    public function orderstatus() {
        $response = array();
        $jsonString = file_get_contents("php://input");
        $phpObject = json_decode($jsonString);
        
         // Using maintain log
           $serialized_array=serialize($phpObject);
           $getorder_status = $phpObject->new_state;
           $getoredrid =$phpObject->order_id;
           $getchannel = $phpObject->additional_info->external_channel->name;
           $log_field =array(
               'order_id'=>$getoredrid,
               'channel'=>$getchannel,
               'response_json'=>$serialized_array,
               'log_type'=>'Order delivery status',
               'order_status'=>$getorder_status
           );
           $this->UPM->action_database('Insert','sma_up_logs','',$log_field);
        // End maintain log
        
        $up_order_id = $phpObject->order_id;
        
        $update_status = array (
            'up_next_status'=>$phpObject->new_state,
            'sale_status'=>$phpObject->new_state,
            'up_prev_state'=>$phpObject->prev_state,
            'up_state_timestamp'=>$phpObject->timestamp,
            'up_message'=>$phpObject->message,
            'up_status_response'=>serialize($phpObject),
        );
    
        $update_order_status = $this->UPM->action_database('Update','sma_sales',array('up_order_id'=>$up_order_id),$update_status);
        
        if($update_order_status){
            $response['status']= 'success';
        } else {
            $response['status']= 'error';
        }
        
      echo json_encode($response);
    }
   	/*----------------------------------------------------------------------
         *  End Order status response get and set pos system
         ----------------------------------------------------------------------*/
     /*==========================================================================
     *  End  Urbenpiper Webhook get response all response json forrmat
     * ========================================================================*/
    
   
     /*========================================================================
     * Time Combo
     *========================================================================*/
    function get_times( $default = '', $interval = '+30 minutes' ) {

        $output = "<option value=''>Any Time</option>";

        $current = strtotime( '00:00' );
        $end = strtotime( '23:59' );

        while( $current <= $end ) {
            $time = date( 'H:i', $current );
            $sel = ( $time == $default ) ? ' selected' : '';

            $output .= "<option value=\"{$time}\"{$sel}>" . date( 'h.i A', $current ) .'</option>';
            $current = strtotime( $interval, $current );
        }

        return $output;
    }
    
   /*========================================================================
     *  End Time Combo
     *========================================================================*/
    
    /*========================================================================
     API Key Add Using POSADMIN
     =========================================================================*/
    public function api_key_add(){
        
        $api_key = $this->input->post('api_key');
        $field= array('api_key'=>$api_key);
        $result = $this->UPM->check_dependancy('sma_up_settings',array('id'=>'1'),'id');
        if($result){
           $res=  $this->UPM->action_database('Update','sma_up_settings',array('id'=>'1'),$field);
           if($res){
               $response['status']="SUCCESS";
            }else{
                $response['status']="ERROR";
            }
        }else{
              $field['id']='1';  
           $res=    $this->UPM->action_database('Insert','sma_up_settings','',$field);
            if($res){
               $response['status']="SUCCESS";
            }else{
               $response['status']="ERROR";
            }
        }
        
        echo json_encode($response);
        
    }
    /*========================================================================
     *End   API Key Add Using POSADMIN
     *=========================================================================*/
    
    /*========================================================================
     * Store Action All 
     * ========================================================================*/
    // Get Store Details
    public function getstore_details($id=NULL){
      $get_details =  $this->UPM->check_dependancy('sma_warehouses',array('id'=>$id),'*');
      echo json_encode($get_details);
   }
    // Store List page
    public function store_info(){
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => '#', 'page' => lang('Urbanpiper Store')));
            $meta = array('page_title' => lang('Urbanpiper  store'), 'bc' => $bc);
            $stores = $this->UPM->getallstore();
            if($stores) {
                $this->data['storecount'] = count($stores);
            }
            $this->page_construct('urbanpiper/store_list', $meta, $this->data);
    }

    // Store List bind
    public function getstore(){

        $store_list = $this->UPM->getallstore();

        $tabledata = '';
            $tabledata.='<table id="storelist" class="table table-bordered table-hover table-striped">';
                $tabledata.='<thead><tr><th> Sr.No.</th><th>Store Name</th>';
                  $tabledata.='<th> Reference No.</th><th>Contact No</th>'; 
                  $tabledata.='<th> City</th><th>Order Receive</th>'; 
                 $tabledata.='<th title="store status on urbanpiper">Store Status</th><th> Add Urbanpiper </th><th> Action</th></tr></thead>';  
                $tabledata.='<tbody>';
                    $sr = '1';
                    foreach($store_list as $store){
                        $tabledata.='<tr>';
                            $tabledata.='<td>'.$sr.'</td>';
                            $tabledata.='<td>'.$store->name.'</td>';
                            $tabledata.='<td>'.$store->ref_id.'</td>';
                            $tabledata.='<td>'.$store->contact_phone.'</td>';
                            $tabledata.='<td>'.$store->city.'</td>';
                            $tabledata.='<td class="text-center">';
                                if($store->store_add_urbanpiper=="1"){
                                 if($store->active=='true'){
                                    if($store->ordering_enabled=="true"){
                                      $tabledata.='<span  class=" btn  btn-success btn-small" onclick="store_status(\' stop receive order for\',\'ordering\',\''.$store->id.'\',\'Disable\')" > Enabled</span>';
                                    }else{
                                        $tabledata.='<span   class="btn btn-danger btn-small" onclick="store_status(\' start receive order for\',\'ordering\',\''.$store->id.'\',\'Enable\')"> Disable</span>';
                                    }
                                   }else{
                                        $tabledata.='<span class="text-danger"><i class="fa fa-times" aria-hidden="true"></i> </span>';
                                    }
                                }else{
                                    $tabledata.='<span class="text-danger"> <i class="fa fa-times" aria-hidden="true"></i> </span>';
                                }       
                            $tabledata.='</td>';
                            $tabledata.='<td>';
                                if($store->store_add_urbanpiper=="1"){
                                    if($store->active=='true'){
                                        $tabledata.='<span class="btn btn-success btn-small" onclick="store_status(\' disabled\',\'Store_Deactivate\',\''.$store->id.'\',\'Disable\')" > Enable </span>';
                                    }else{
                                        $tabledata.='<span class="btn btn-danger btn-small" onclick="store_status(\' enable\',\'Store_Deactivate\',\''.$store->id.'\',\'Enable\')"> Disable </span>';
                                    } 
                                }else{
                                    $tabledata.='<span class="text-danger"><i class="fa fa-times" aria-hidden="true"></i> </span>';
                                }    
                            $tabledata.='</td>';

                            $tabledata.='<td class="text-center">';
                                if($store->store_add_urbanpiper=="1"){
                                     $tabledata.='<span  class=" btn  btn-success btn-small" > Added</span>';
                                }else{
                                    $tabledata.='<span  class="btn btn-danger btn-small" onclick="store_status(\'add\',\'Add_urbanpiper\',\''.$store->id.'\')"> Add</span>';
                                }
                             $tabledata.='</td>';
                            $tabledata.='<td class="text-center"><a href="'.site_url('urban_piper/update_store/').$store->id.'" data-toggle="modal" data-target="#myModal2" class="btn btn-small btn-info" > <i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a></td>';
                        $tabledata.='</tr>';
                        $sr++; 
                    }
                $tabledata.='</tbody>';
        $tabledata.='</table>';     
        echo json_encode($tabledata);
    }

    // Add Store On Pos Urban Store
    public function add_store(){
        if($this->input->post()){
              $this->form_validation->set_rules('name', $this->lang->line("name"), 'trim|required');
              $this->form_validation->set_rules('warehouse', $this->lang->line("warehouse"), 'trim|required');
              $this->form_validation->set_rules('city', $this->lang->line("city"), 'trim|required');
              if($this->form_validation->run() == true){

                  $field = array(
                      'name'=>$this->input->post('name'),
                      'ref_id'=>time(),
                      'warehouse_id'=>$this->input->post('warehouse'),
                      'city'=>$this->input->post('city'),
                      'contact_phone'=>$this->input->post('contact_phone'),
                      'notification_phones'=>$this->input->post('notification_phones'),
                      'notification_emails'=>$this->input->post('notification_emails'),
                      'address'=>strip_tags($this->input->post('address')),
                      'zip_codes'=>$this->input->post('zip_codes'),
                      'min_pickup_time'=>$this->input->post('min_pickup_time'),
                      'min_delivery_time'=>$this->input->post('min_delivery_time'),
                      'min_order_value'=>$this->input->post('min_order_value'),
                      'min_order_value'=>$this->input->post('min_order_value'),
                      'geo_longitude' =>$this->input->post('geo_longitude'),
                      'geo_latitude' =>$this->input->post('geo_latitude'),
                      'ordering_enabled'=>$this->input->post('ordering_enabled'),
                      'days'=>$this->input->post('DaysTime'),
                      'created_at'=>date('Y-m-d H:i:s'),
                  );

                /* $check_warehouse = $this->UPM->check_dependancy('sma_up_stores',array('ref_id'=>$this->input->post('warehouse')."_".$this->input->post('code')),'id'); 
                 if($check_warehouse){
                     $this->session->set_flashdata('error',"Store  allready  add, please try again new store.");
                     redirect('urban_piper/add_store');
                 }else{*/
                      $data = $this->UPM->action_database('Insert','up_stores','',$field);
                      if($data){
                          $this->session->set_flashdata('success',"Store has been added successfully");
                      }else{
                          $this->session->set_flashdata('error',"Store  not add, please try again.");
                      }
                      redirect('urban_piper/add_store');
                /* }  */
              }else{
                  $this->data['warehouses'] =  $this->site->getAllWarehouses();
                  $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('urban_piper'), 'page' => lang('Urbanpiper')), array('link' => '#', 'page' => lang('Add Store')));
                  $meta = array('page_title' => lang('Urbanpiper add store'), 'bc' => $bc);
                  $this->page_construct('urbanpiper/add_store', $meta, $this->data);
               }

        }else{
          $this->data['warehouses'] =  $this->site->getAllWarehouses();
          $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('urban_piper'), 'page' => lang('Urbanpiper')), array('link' => '#', 'page' => lang('Add Store')));
          $meta = array('page_title' => lang('Urbanpiper add store'), 'bc' => $bc);
          $this->page_construct('urbanpiper/add_store', $meta, $this->data);
        } 

    }

    // Update Store Info
    public function update_store($id = NULL){
            if($this->input->post()){
                   $store_id = $this->input->post('store_id');     
               
                   
                    $field = array(

                        'city'=>$this->input->post('city'),
                        'contact_phone'=>$this->input->post('contact_phone'),
                        'notification_phones'=>$this->input->post('notification_phones'),
                        'notification_emails'=>$this->input->post('notification_emails'),
                        'address'=>strip_tags($this->input->post('address')),
                        'zip_codes'=>$this->input->post('zip_codes'),
                        'min_pickup_time'=>$this->input->post('min_pickup_time'),
                        'min_delivery_time'=>$this->input->post('min_delivery_time'),
                        'min_order_value'=>$this->input->post('min_order_value'),
                        'min_order_value'=>$this->input->post('min_order_value'),
                        'geo_longitude' =>$this->input->post('geo_longitude'),
                        'geo_latitude' =>$this->input->post('geo_latitude'),
                        'ordering_enabled'=>$this->input->post('ordering_enabled'),
                        'days'=>$this->input->post('DaysTime'),
                        'updated_at'=>date('Y-m-d H:i:s'),
                    );


                   $store_update =  $this->UPM->action_database('Update','sma_up_stores',array('id'=>$store_id),$field);
                   $get_storedetails =   $this->UPM->check_dependancy('sma_up_stores',array('id'=>$store_id),'*');
                   if($get_storedetails->store_add_urbanpiper=='1'){
            
                        if($get_storedetails){
                         
                              $store_details = array (    'stores' => 
                                array (
                                    0 => 
                                        array (
                                            'city' => $get_storedetails->city,
                                            'name' => $get_storedetails->name,
                                            'min_pickup_time' =>  $get_storedetails->min_pickup_time,
                                            'min_delivery_time' => $get_storedetails->min_delivery_time,
                                            'contact_phone' =>  $get_storedetails->contact_phone,
                                            'notification_phones' => explode(", ",$get_storedetails->notification_phones),
                                            'ref_id' =>$get_storedetails->ref_id,
                                            'min_order_value' =>($get_storedetails->min_order_value)?$get_storedetails->min_order_value:0,
                                            'hide_from_ui' => $get_storedetails->hide_from_ui,
                                            'address' =>$get_storedetails->address,
                                            'notification_emails' =>explode(", ",$get_storedetails->notification_emails),
                                            'zip_codes' =>explode(", ",$get_storedetails->zip_codes), 
                                            'geo_longitude' => $get_storedetails->geo_longitude,
                                            'active' =>($get_storedetails->active=='true')?true:false,
                                            'geo_latitude' => $get_storedetails->geo_latitude,
                                            'ordering_enabled' =>($get_storedetails->ordering_enabled=='true')?true:false,
                                            'translations' =>($get_storedetails->translations)?explode(", ",$get_storedetails->translations):[], 
                                            'timings'=>($get_storedetails->days)?json_decode($get_storedetails->days):array(),
                                          ),

                                        ),
                                      );          
                                          
                        	
                            $URL = 'https://staging.urbanpiper.com/external/api/v1/stores/';
                            $getresponse = $this->call_urbanpiper($URL,$store_details);
                            $phpObject = json_decode($getresponse);
                            if($phpObject->status=='success'){

                               $this->session->set_flashdata('success','Store has been update successfull');
                            }else if($phpObject->status=='error'){
                                $this->session->set_flashdata('error1',"Store  not update, please try again.");
                            }else{
                                $this->session->set_flashdata('error1',"Store  not update, please try again.");
                            }
                        }else{
                           $this->session->set_flashdata('error1',"Store  not update, please try again.");
                        }
                   }            
                  return redirect($_SERVER['HTTP_REFERER']);
            }else{
                $this->data['store_info'] =  $this->UPM->getrecords('sma_up_stores','*','row',array('id'=>$id));
                $this->load->view($this->theme . 'urbanpiper/store_update_modal', $this->data);
            }
        }
      
    /*========================================================================
     *  End Store Action
     * ========================================================================*/
     
      /*==================================================================================
     * Store Platform List and Settings
     * =================================================================================*/ 
    public function settings(){
    	if($this->input->post()){
            $field = array(
                'urbanpiper'=>($this->input->post('urbanpiper'))?$this->input->post('urbanpiper'):NULL,
                'zomato'=>($this->input->post('zomato'))?$this->input->post('zomato'):NULL,
                'foodpanda'=>($this->input->post('foodpanda'))?$this->input->post('foodpanda'):NULL,
                'swiggy'=>($this->input->post('swiggy'))?$this->input->post('swiggy'):NULL,
                'ubereats'=>($this->input->post('ubereats'))?$this->input->post('ubereats'):NULL,
            );
           
            $getres = $this->UPM->action_database('Update','sma_up_settings',array('id'=>'1'),$field);
            if($getres){
                 $this->session->set_flashdata('message',"Pos platform update successfull");
            }else{
                $this->session->set_flashdata('error',"Pos platform  not update, Please try again.");
            }
            return redirect('urban_piper/settings');
        } else {
            $this->data['urbanpiper_setting'] = $this->UPM->getrecords('sma_up_settings','*','row',array('id'=>'1'));
            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('urban_piper'), 'page' => lang('Urbanpiper')), array('link' => '#', 'page' => lang('Urbanpiper Settings')));
            $meta = array('page_title' => lang('Urbanpiper Settings'), 'bc' => $bc);
                        
            $this->page_construct('urbanpiper/settings', $meta, $this->data);
	}        
    }  
    public function store_platform_list(){
        $urbanpiper_store = $this->UPM->getrecords('sma_up_stores','*','result',array('store_add_urbanpiper'=>'1'),'name','ASC');    
        $sr = 1;
        $table = '<table class="table table-bordered table-hover table-striped" >';
            $table.='<thead>';
                $table.='<tr>';                
                    $table.='<th style="width: 7%;" > Sr. No.</th>';
                     $table.='<th>Name</th>';
                    $table.='<th>Reference No.</th>';
                    ($this->upsetting->urbanpiper)?$table.='<th>Urbanpiper</th>':'';
                    ($this->upsetting->zomato)?$table.='<th>Zomato</th>':'';
                    ($this->upsetting->foodpanda)?$table.='<th>Foodpanda</th>':'';
                    ($this->upsetting->swiggy)?$table.='<th>Swiggy</th>':'';
                    ($this->upsetting->ubereats)?$table.='<th>Ubereats</th>':'';
                $table.='</tr>';
            $table.='<thead>';
            $table.='<tbody>';
              
                foreach ($urbanpiper_store as $store):
                    $pass_status =($plat_val->platform_status=='enable')?'disable':'enable';
                    $table.='<tr>';
                        $table.='<td class="text-center">'.$sr.'</td>';
                        $table.='<td>'.$store->name.'</td>';
                        $table.='<td>'.$store->ref_id.'</td>';
                        if($this->upsetting->urbanpiper){ $table.='<td class="text-center"> ';
                            if($store->plat_urbanpiper=='enable'){
                                 $table.='<span class="btn btn-success btn-sm" onclick="action_confirm(\'Store_Platform\',\''.$store->id.'\',\'plat_urbanpiper\',\'urbanpiper\',\'disable\')" >Enable</span>';  
                            }else{
                                $table.='<span class="btn btn-danger btn-sm" onclick="action_confirm(\'Store_Platform\',\''.$store->id.'\',\'plat_urbanpiper\',\'urbanpiper\',\'enable\')" >Disable</span>'; 
                            }
                        $table.='</td>'; }
                        
                        if($this->upsetting->zomato){$table.='<td class="text-center"> ';
                            if($store->plat_zomato=='enable'){
                                 $table.='<span class="btn btn-success btn-sm" onclick="action_confirm(\'Store_Platform\',\''.$store->id.'\',\'plat_zomato\',\'zomato\',\'disable\')" >Enable</span>';  
                            }else{
                                $table.='<span class="btn btn-danger btn-sm" onclick="action_confirm(\'Store_Platform\',\''.$store->id.'\',\'plat_zomato\',\'zomato\',\'enable\')" >Disable</span>'; 
                            }
                        $table.='</td>';}
                        if($this->upsetting->foodpanda){$table.='<td class="text-center"> ';
                            if($store->plat_foodpanda=='enable'){
                                 $table.='<span class="btn btn-success btn-sm" onclick="action_confirm(\'Store_Platform\',\''.$store->id.'\',\'plat_foodpanda\',\'foodpanda\',\'disable\')" >Enable</span>';  
                            }else{
                                $table.='<span class="btn btn-danger btn-sm" onclick="action_confirm(\'Store_Platform\',\''.$store->id.'\',\'plat_foodpanda\',\'foodpanda\',\'enable\')" >Disable</span>'; 
                            }
                        $table.='</td>';}
                        if($this->upsetting->swiggy){$table.='<td class="text-center"> ';
                            if($store->plat_swiggy=='enable'){
                                 $table.='<span class="btn btn-success btn-sm" onclick="action_confirm(\'Store_Platform\',\''.$store->id.'\',\'plat_swiggy\',\'swiggy\',\'disable\')" >Enable</span>';  
                            }else{
                                $table.='<span class="btn btn-danger btn-sm" onclick="action_confirm(\'Store_Platform\',\''.$store->id.'\',\'plat_swiggy\',\'swiggy\',\'enable\')" >Disable</span>'; 
                            }
                        $table.='</td>';}
                        if($this->upsetting->ubereats){$table.='<td class="text-center"> ';
                            if($store->plat_ubereats=='enable'){
                                 $table.='<span class="btn btn-success btn-sm" onclick="action_confirm(\'Store_Platform\',\''.$store->id.'\',\'plat_ubereats\',\'ubereats\',\'disable\')" >Enable</span>';  
                            }else{
                                $table.='<span class="btn btn-danger btn-sm" onclick="action_confirm(\'Store_Platform\',\''.$store->id.'\',\'plat_ubereats\',\'ubereats\',\'enable\')" >Disable</span>'; 
                            }
                        $table.='</td>';}
                    $table.='</tr>';
                      $sr++;
                endforeach;    
            $table.='</tbody>';
        $table.='</table>';
       echo $table;
    }
    
     /*==================================================================================
     * End Store Platform List
     * =================================================================================*/ 
     
     /*===================================================================================
     *  Products
     ====================================================================================*/
    public function product(){
        if($this->input->post()){
            $post = $this->input->post();
            if(!isset($post['val'])){
                $this->session->set_flashdata('errors',"Please Select Product");
                return redirect('urban_piper/product');
            }else{
                $response =  $this->action('Products_Upload','0',$post['action'],$post['val']);
                if($response['status']=='success'){
                    $this->session->set_flashdata('success',$response['messages']);
                }else{
                    $this->session->set_flashdata('errors',"Please try again");
                }
                return redirect('urban_piper/product');
            }
        }else{
	        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('urban_piper'), 'page' => lang('Urbanpiper')), array('link' => '#', 'page' => lang('Product')));
	        $meta = array('page_title' => lang('Product'), 'bc' => $bc);
	        $this->page_construct('urbanpiper/product', $meta, $this->data);
	}        
    }
    
    public function getproduct_list(){
        $where_condition = array('up_items'=>'1');
        $getproduct = $this->UPM->getproduct($where_condition);
    
            $tabledata.='<div class="table-responsive"><table id="productlist" class="table table-bordered table-hover table-striped table-responsive">';
                $tabledata.='<thead><tr><th style="text-align: left;"> <input class="checkbox checkft input-xs" type="checkbox" name="check" id="select_all"/></th><th >Image</th><th >Code</th>';
                $tabledata.='<th >Name</th><th >Category</th>'; 
                $tabledata.='<th > Cost </th>';
                $tabledata.='<th >Status</th><th>Add Status</th></tr></thead>';
               $tabledata.='<tbody>';
                    $sr=1;
                    foreach($getproduct as $items){
                         $imgcat = $items->image;
                        if($items->image){
                            if(!file_exists('assets/uploads/thumbs/'.$imgcat)){
                                $imgcat ='no_image.png';
                            }
                        }else{
                            $imgcat ='no_image.png';
                        }
                        $tabledata.='<tr>';
                            $tabledata.='<td> <input   class="checkbox valpass  multi-select input-xs" type="checkbox" onclick="myfunction()" value="'.$items->id.'" name="val[]" id="check_box_" /> </td>';
                            $tabledata.='<td class="text-center"> <img src="'.base_url('assets/uploads/thumbs/').$imgcat.'" style="height:32px;"> </td>';
                            $tabledata.='<td>'.$items->code.'</td>';
                            $tabledata.='<td>'.$items->name.'</td>';
                            $tabledata.='<td>'.(($items->category_name)?$items->category_name:'---').'</td>';
                            $tabledata.='<td>'.$this->sma->formatMoney($items->up_price).'</td>';
                           
                            $tabledata.='<td class="text-center">';
                                $tabledata.=($items->up_add_status)?(($items->up_status)?'<span class="btn btn-success btn-small" onclick="category_status(\'status disable \',\'Single_Product\',\''.$items->id.'\',\'UP_status_Product\',\'Disable\')" >Enable </span>':'<span class="btn btn-danger btn-small" onclick="category_status(\'status enable\',\'Single_Product\',\''.$items->id.'\',\'UP_status_Product\',\'Enable\')">Disable</span>'):'<span class="text-danger"><i class="fa fa-times" aria-hidden="true"></i> </span>';
                            $tabledata.='</td>';
                            $tabledata.='<td class="text-center">';
                           
                                 $tabledata.=($items->up_add_status)?'<span class="btn btn-primary btn-small" onclick="category_status(\'update\',\'Single_Product\',\''.$items->id.'\',\'UP_Update_Product\')" title="Update"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span> | <span class="btn btn-danger btn-small" title = "Delete" onclick="category_status(\'delete\',\'Single_Product\',\''.$items->id.'\',\'UP_delete_Product\')" ><i class="fa fa-trash"></i></span>':'<span class="btn btn-danger btn-small"  titile = "Add" onclick="category_status(\'add\',\'Single_Product\',\''.$items->id.'\',\'UP_Add_Product\')" >Add</span>';

                            $tabledata.='</td>';
                        $tabledata.='</tr>';
                        $sr++;
                    }
                $tabledata.='</tbody>';
            $tabledata.='</table></div>';  
        echo json_encode($tabledata);
        
      //  print_r($tabledata);
    }
    
    
    public function add_product(){
        $data = $this->UPM->getrecords('sma_products','*','result');
        foreach($data as $product_val){
           if($product_val->up_items!='1'){
                $field = array(
                   'product_id'=>$product_val->id,
                   'product_code'=>$product_val->code,
                   'price'=>$product_val->price,
                   'food_type_id'=>$product_val->food_type_id,
                );
                $getup_product = $this->UPM->check_dependancy('sma_up_products',array('product_id'=>$product_val->id,'product_code'=>$product_val->code),'*');
                if($getup_product){
                       $this->UPM->action_database('Update','sma_up_products',array('id'=>$getup_product->id),$field);
                       $this->UPM->action_database('Update','sma_products',array('id'=>$product_val->id),array('up_items'=>'1'));
                }else{
                    $this->UPM->action_database('Insert','sma_up_products',array('id'=>$getup_product->id),$field);
                    $this->UPM->action_database('Update','sma_products',array('id'=>$product_val->id),array('up_items'=>'1'));
                    
                }
           }
    
        }
        $response['status']= 'success';
        $response['messages']= 'Product Add Successfully.';

       echo json_encode($response);
        
    }
    
     // Product Platform 
    public function product_platform(){
        $this->data['store_list'] = $this->UPM->getrecords('sma_up_stores','*','result',array('store_add_urbanpiper'=>'1'),'id','ASC');
        $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('urban_piper'), 'page' => lang('Urbanpiper')), array('link' => '#', 'page' => lang('Product')));
        $meta = array('page_title' => lang('Product'), 'bc' => $bc);
        $this->page_construct('urbanpiper/platform_store', $meta, $this->data);
    }
    
    public function up_product_bulk_action($action, $store_id, $category_id, $priduct_ids) {
                        
                    $get_storedetails =   $this->UPM->check_dependancy('sma_up_stores',array('id'=>$store_id),'*');
                    $get_product = $this->UPM->getproduct_allup($priduct_ids);
                    
                    $pplatforms = $this->UPM->getproductplatformdata($priduct_ids);
                        
                    $itemsArray = array();
                    $optionGroup = array();
                    $option  = array();
                    $taxarray = array();
                    $excluded_platforms = array();
                    
                    switch ($action){
                        case 'add':
                            foreach ($get_product as $productval){
                                $ref_category = ($productval->sub_category_code)?$productval->sub_category_code:$productval->category_code;
                                $img_url = $this->get_item_image_exist($productval->image);
                                
                                $tags = array(
                                    "zomato"=> ($pplatforms[$productval->id]->tag_zomato) ? explode(',', $pplatforms[$productval->id]->tag_zomato) :  array(),
                                    "swiggy"=> ($pplatforms[$productval->id]->tag_swiggy) ? explode(',', $pplatforms[$productval->id]->tag_swiggy) :  array(),
                                    "foodpanda"=> ($pplatforms[$productval->id]->tag_foodpanda) ? explode(',', $pplatforms[$productval->id]->tag_foodpanda) :  array(),
                                    "ubereats"=> ($pplatforms[$productval->id]->tag_ubereats) ? explode(',', $pplatforms[$productval->id]->tag_ubereats) :  array(),
                                    "urbanpiper"=> ($pplatforms[$productval->id]->tag_urbanpiper) ? explode(',', $pplatforms[$productval->id]->tag_urbanpiper) :  array(),
                                ); 
                               // if($this->data['up_setting']->urbanpiper){ $excluded_platforms[] = 'urbanpiper'; }
                                if($this->data['up_setting']->zomato){ $excluded_platforms[] = 'zomato'; }
                                if($this->data['up_setting']->foodpanda){ $excluded_platforms[] = 'foodpanda'; }
                                if($this->data['up_setting']->swiggy){ $excluded_platforms[] = 'swiggy'; }
                                if($this->data['up_setting']->ubereats){ $excluded_platforms[] = 'ubereats'; }
                                
                                    $itemsArray[] = array(
                                        "ref_id"=>$productval->code,
                                        "title"=>$productval->name,
                                        "available"=>($pplatforms[$productval->id]->available) ? true : false,
                                        "description"=>($productval->product_details)? strip_tags($productval->product_details) : $productval->name,
                                        "sold_at_store"=>($pplatforms[$productval->id]->sold_at_store) ? true : false,
                                        "price"=>(float)$productval->up_price,
                                        "img_url"=>$img_url,
                                        "current_stock"=>-1,
                                        "recommended"=>($pplatforms[$productval->id]->recommended) ? true : false,
                                        "food_type"=>($productval->food_type)?$productval->food_type:'4',
                                        "category_ref_ids"=>array($ref_category),
                                        "translations"=>array(),
                                        "tags"=>(object) $tags,
                                        "excluded_platforms"=>$excluded_platforms
                                    );
                                    
                                    // Group Option
                                        $productoption = $this->UPM->getrecords('sma_product_variants','*','result',array('product_id'=>$productval->id));
                                        if($productoption){
                                            $optgroupcode = 'og_'.$productval->code;
                                            $optionGroup[] = array(
                                                    'ref_id'=>$optgroupcode,
                                                    'title'=>$productval->name,
                                                    'min_selectable'=> 1,
                                                    'max_selectable'=> 1,
                                                    'active'=>true,
                                                    'item_ref_ids'=>array($productval->code)
                                                );
                                            foreach($productoption as $pgop){
                                               
                                                $option[] = array(
                                                    'ref_id'=>$pgop->id,
                                                    'title'=>$pgop->name,
                                                    'description'=>$pgop->name,
                                                    'weight'=>NULL,
                                                    'available'=>true,
                                                    'price'=>(float) $pgop->price, 
                                                    'sold_at_store'=>true,
                                                    'opt_grp_ref_ids'=>array($optgroupcode),
                                                    'nested_opt_grps'=>array(),
                                                    'translations'=>array()
                                                  );
                                            }
                                        }
                                        // Group option   
                                        //Product Taxes
                                            $taxget =  $this->UPM->check_dependancy('sma_tax_rates',array('id'=>$productval->tax_rate),'*');
                                            $gettaxconfig = unserialize($taxget->tax_config);
                                            foreach($gettaxconfig as $taxvalue){
                                                $taxarray[] = array(
                                                    "ref_id"=>$taxvalue['code'].'-'.$taxvalue['percentage'],
                                                    "title"=>$taxvalue['name'],
                                                    "description" => $taxvalue['percentage']."% CGST on all items",
                                                    "active"=> true,
                                                    "structure"=> array(
                                                            "type"=> "percentage",
                                                            "applicable_on" => "item.price",
                                                            "value"=>$taxvalue['percentage']
                                                        ),
                                                        "item_ref_ids"=> [$productval->code]
                                                 );
                                             }
                                        // End Product Taxes
                                    
                                    $product_info[] =array(
                                        'product_id'=>$productval->id,
                                        'product_code'=>$productval->code,
                                        'up_store_ref_id'=>$get_storedetails->ref_id,
                                        'up_store_id'=>$get_storedetails->id,                                         
                                    ) ;
                                   
                                }//end foreach.
                                $field = array( 'add_status'=>'1');
                                $msg = "Products add successfully";
                            break;
                        case 'product_enable':
                                foreach ($get_product as $productval){
                                $ref_category = ($productval->sub_category_code)?$productval->sub_category_code:$productval->category_code;
                                $img_url = $this->get_item_image_exist($productval->image);
                                
                                $tags = array(
                                    "zomato"=> ($pplatforms[$productval->id]->tag_zomato) ? explode(',', $pplatforms[$productval->id]->tag_zomato) :  array(),
                                    "swiggy"=> ($pplatforms[$productval->id]->tag_swiggy) ? explode(',', $pplatforms[$productval->id]->tag_swiggy) :  array(),
                                    "foodpanda"=> ($pplatforms[$productval->id]->tag_foodpanda) ? explode(',', $pplatforms[$productval->id]->tag_foodpanda) :  array(),
                                    "ubereats"=> ($pplatforms[$productval->id]->tag_ubereats) ? explode(',', $pplatforms[$productval->id]->tag_ubereats) :  array(),
                                    "urbanpiper"=> ($pplatforms[$productval->id]->tag_urbanpiper) ? explode(',', $pplatforms[$productval->id]->tag_urbanpiper) :  array(),
                                );
                               // if($this->data['up_setting']->urbanpiper){ $excluded_platforms[] = 'urbanpiper'; }
                                if($this->data['up_setting']->zomato){ $excluded_platforms[] = 'zomato'; }
                                if($this->data['up_setting']->foodpanda){ $excluded_platforms[] = 'foodpanda'; }
                                if($this->data['up_setting']->swiggy){ $excluded_platforms[] = 'swiggy'; }
                                if($this->data['up_setting']->ubereats){ $excluded_platforms[] = 'ubereats'; }
                                
                                    $itemsArray[] = array(
                                        "ref_id"=>$productval->code,
                                        "title"=>$productval->name,
                                        "available"=> ($pplatforms[$productval->id]->available) ? true : false,
                                        "description"=>($productval->product_details)? strip_tags($productval->product_details) : $productval->name,
                                        "sold_at_store"=>($pplatforms[$productval->id]->sold_at_store) ? true : false,
                                        "price"=>(float)$productval->up_price,
                                        "img_url"=>$img_url,
                                        "current_stock"=>-1,
                                        "recommended"=>($pplatforms[$productval->id]->recommended) ? true : false,
                                        "food_type"=>($productval->food_type)?$productval->food_type:'4',
                                        "category_ref_ids"=>array($ref_category),
                                        "translations"=>array(),
                                        "tags"=>(object) $tags,
                                        "excluded_platforms"=>$excluded_platforms
                                        /*'upipr_status'=>array(
                                            "action"=> "U",
                                            "id"=> 3423,
                                            "error"=> false
                                        ),*/
                                    );
                                    
                                    $product_info[] =array(
                                        'product_id'=>$productval->id,
                                        'product_code'=>$productval->code,
                                        'up_store_ref_id'=>$get_storedetails->ref_id,
                                        'up_store_id'=>$get_storedetails->id,                                         
                                    ) ;
                                   
                                }
                                $field = array(
                                   'active_status'=>'1',  
                                );
                                $msg = "Products status enable successfully";
                            break;
                        case 'product_disable':
                                foreach ($get_product as $productval){
                                $ref_category = ($productval->sub_category_code)?$productval->sub_category_code:$productval->category_code;
                                $img_url = $this->get_item_image_exist($productval->image);
                                
                                $tags = array(
                                    "zomato"=> ($pplatforms[$productval->id]->tag_zomato) ? explode(',', $pplatforms[$productval->id]->tag_zomato) : array(),
                                    "swiggy"=> ($pplatforms[$productval->id]->tag_swiggy) ? explode(',', $pplatforms[$productval->id]->tag_swiggy) :  array(),
                                    "foodpanda"=> ($pplatforms[$productval->id]->tag_foodpanda) ? explode(',', $pplatforms[$productval->id]->tag_foodpanda) :  array(),
                                    "ubereats"=> ($pplatforms[$productval->id]->tag_ubereats) ? explode(',', $pplatforms[$productval->id]->tag_ubereats) :  array(),
                                    "urbanpiper"=> ($pplatforms[$productval->id]->tag_urbanpiper) ? explode(',', $pplatforms[$productval->id]->tag_urbanpiper) : array(),
                                );
                                
                              //  if($this->data['up_setting']->urbanpiper){ $excluded_platforms[] = 'urbanpiper'; }
                                if($this->data['up_setting']->zomato){ $excluded_platforms[] = 'zomato'; }
                                if($this->data['up_setting']->foodpanda){ $excluded_platforms[] = 'foodpanda'; }
                                if($this->data['up_setting']->swiggy){ $excluded_platforms[] = 'swiggy'; }
                                if($this->data['up_setting']->ubereats){ $excluded_platforms[] = 'ubereats'; }
                                
                                    $itemsArray[] = array(
                                        "ref_id"=>$productval->code,
                                        "title"=>$productval->name,
                                        "available"=>($pplatforms[$productval->id]->available) ? true : false,
                                        "description"=>($productval->product_details)? strip_tags($productval->product_details) : $productval->name,
                                        "sold_at_store"=>($pplatforms[$productval->id]->sold_at_store) ? true : false,
                                        "price"=>(float)$productval->up_price,
                                        "img_url"=>$img_url,
                                        "current_stock"=>-1,
                                        "recommended"=>($pplatforms[$productval->id]->recommended) ? true : false,
                                        "food_type"=>$productval->food_type ? $productval->food_type : '4',
                                        "category_ref_ids"=>array($ref_category),
                                        "translations"=>array(),
                                        "tags"=>(object) $tags,
                                        "excluded_platforms"=>$excluded_platforms
                                        /*'upipr_status'=>array(
                                            "action"=> "U",
                                            "id"=> 3423,
                                            "error"=> false
                                        ),*/
                                    );
                                    
                                    $product_info[] =array(
                                        'product_id'=>$productval->id,
                                        'product_code'=>$productval->code,
                                        'up_store_ref_id'=>$get_storedetails->ref_id,
                                        'up_store_id'=>$get_storedetails->id,
                                    ) ;
                                   
                                }
                                $field = array(
                                   'active_status'=>'0',  
                                );
                                $msg = "Products status disable successfully";
                            break;
                       
                    }//end switch.
                     
                    if(is_array($itemsArray)){
                        $pass = array( "items"=>$itemsArray, );   
                        if(is_array($productoption)){
                            $pass['option_groups']=$optionGroup;
                            $pass['flush_options']=false;
                            $pass['options']=$option;  
                        }
                        if(is_array($taxarray)){
                           $pass['taxes']=$taxarray; 
                        } 
                       
                        
                       $URL = 'https://staging.urbanpiper.com/external/api/v1/inventory/locations/'.$get_storedetails->ref_id.'/';
                      
                      
                        $getresponse_item= $this->call_urbanpiper($URL,$pass);
                        $phpObject = json_decode($getresponse_item);
                        if($phpObject->status=='success'){
                           
                           $size = sizeof($product_info);
                    
                            for($i=0;$i<$size;$i++){
                               $check_array = array(
                                   'up_store_id'=> $product_info[$i]['up_store_id'],
                                   'up_store_ref_id'=> $product_info[$i]['up_store_ref_id'],
                                   'product_id'=> $product_info[$i]['product_id'],
                                   'product_code'=> $product_info[$i]['product_code'],);

                                $get_store_patform =  $this->UPM->check_dependancy('sma_up_products_platform',$check_array,'id');
                                if($get_store_patform){
                                    $this->UPM->action_database('Update','sma_up_products_platform',array('id'=>$get_store_patform->id),$field);
                                }else{
                                    $addfield = array_merge($check_array,$field);
                                    $this->UPM->action_database('Insert','sma_up_products_platform','',$addfield);
                                }
                            }
                         
                            $response['status']= 'success';
                            $response['messages'] = $msg ; 
                        }else if($phpObject->status=='error'){
                            $response['status']= 'error';
                            $response['messages'] = $phpObject->message; 
                        }else{
                            $response['status']= 'error';
                            $response['messages'] = 'Sorry Please Try Agian'; 
                        }
                    }else{
                        $response['status']= 'error';
                        $response['messages'] = 'Sorry Please Try Agian'; 
                    }   
                    return $response;
    }
    
    // product list 
    public function platfrom_product_list($id=NULL, $catid=NULL){
    
       if($id!=Null){
	       if($this->input->post()){
	                $post = $this->input->post();
	                if(!isset($post['val'])){
	                    $this->session->set_flashdata('errors',"Please Select Product");
	                    return redirect($_SERVER['HTTP_REFERER']);
	                } else {
	                    $platform = $this->input->post('paltfrom');
	                    $action = $this->input->post('action');
	                    $product = $this->input->post('val');
	                    $store_id = $this->input->post('store_id');
	                    $category_id = $this->input->post('store_categories');
	                    
	                    if($action=='add' || $action=='product_enable' || $action=='product_disable' || $action=='product_delete'){
                                
                            	 $response = $this->up_product_bulk_action($action, $store_id, $category_id, $product);
                            } else {
	                         $response = $this->action('Bulk_product_platform',$platform."~".$store_id,$action,$product);
	                    }     
	                    if($response['status']=='success'){
	                        $this->session->set_flashdata('success',$response['messages']);
	                    }else if($response['status']= 'error'){
	                        $this->session->set_flashdata('errors',$response['messages']);
	                    }else{
	                        $this->session->set_flashdata('errors',"Please try again");
	                    }
	                    return redirect($_SERVER['HTTP_REFERER']);
	                }
	        } else {
                    
                    $this->data['platform'] = $this->upsetting;
                    $this->data['store_info'] = $this->UPM->getrecords('sma_up_stores','*','row',array('id'=>$id));
                    $this->data['storeCategories'] = $this->UPM->getStoreCategories($id);                 
                    $this->data['category_id'] = ($catid) ? $catid : '';                 
                 
	            $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('urban_piper'), 'page' => lang('Urbanpiper')), array('link' => '#', 'page' => lang('Product')));
	            $meta = array('page_title' => lang('Product'), 'bc' => $bc);
	            $this->page_construct('urbanpiper/platform_product_list', $meta, $this->data);
	       }
	} else {
		return redirect('urban_piper/product_platform');
	}	       
    }     
    
    public function getproductplatform($id=NULL, $category=NULL){
                        
       $store_info = $this->UPM->check_dependancy('sma_up_stores',array('id'=>$id),'*');
       
         if(!$store_info) {
            $tabledata = '<div class="alert alert-danger">Invalid Store</div>';
             echo json_encode($tabledata);
             exit;
         }
       
       // $where_condition = array('up_items'=>'1');
        //$getproduct = $this->UPM->getproduct($where_condition);
        $category = ($category) ? $category : 0;
        $getproduct = $this->UPM->getStoreCategoryProducts($id , $category);
        
//        echo '<pre>';
//        print_r($getproduct);
//        echo '</pre>';
//        exit;
        
        if(is_array($getproduct)) {
                        
                $tabledata.='<div class="table-responsive"><table id="productlist" class="table table-bordered table-hover table-striped table-responsive">';
                $tabledata.='<thead><tr><th style="text-align: left;"> <input class="checkbox checkft input-xs" type="checkbox" name="check" id="select_all"/></th><th >Image</th><th >Code</th>';
                $tabledata.='<th >Name</th><th >Category</th><th >Subcategory</th><th > Product Status</th><th>Add Status</th>'; 
                /*if($this->upsetting->urbanpiper){$tabledata.='<th> Urbanpiper </th>';}
                if($this->upsetting->zomato){ $tabledata.='<th >Zomato</th>';}
                if($this->upsetting->foodpanda){ $tabledata.='<th>Foodpanda</th>';}
                if($this->upsetting->swiggy){$tabledata.='<th>Swiggy</th>';}
                if($this->upsetting->swiggy){$tabledata.='<th>Ubereats</th>';}
              */
                $tabledata.='</tr></thead>';
                $tabledata.='<tbody>';
                    $sr=1;
                    foreach($getproduct as $items){
                            $platform_condition = array(
                                'up_store_id'=>$store_info->id,
                                'up_store_ref_id'=>$store_info->ref_id,
                                'product_id'=>$items->id,
                                'product_code'=>$items->code,                           
                            );
                        // $platform_status =  $this->UPM->check_dependancy('sma_up_products_platform',$platform_condition,'*'); 
                         
                        $imgcat = $this->get_item_image_exist($items->image);
                        
                        $tabledata.='<tr>';
                            $tabledata.='<td> <input class="checkbox valpass multi-select input-xs" type="checkbox" onclick="myfunction()" value="'.$items->id.'" name="val[]" id="check_box_" /> </td>';
                            $tabledata.='<td class="text-center"> <img src="'.$imgcat.'" title="'.$items->image.'" style="height:32px;"> </td>';
                            $tabledata.='<td>'.$items->code.'</td>';
                            $tabledata.='<td>'.$items->name.'</td>';
                            $tabledata.='<td>'.$items->category_name.'</td>';
                            $tabledata.='<td>'.$items->subcategory_name.'</td>';
                            $tabledata.='<td class="text-center" id="tdstatus_'.$items->id.'" >';
                                if(isset($items->add_status) && $items->add_status){
                                   $tabledata.=(isset($items->active_status) && $items->active_status)?'<span class="text-danger"><span class="btn btn-success btn-small" onclick="change_product_status(\'Single_Store_Product\',\''.$items->id.'\','.$store_info->id.',\'UP_Product_status\',\'Disable\')">Enable </span></span>':'<span class="btn btn-small btn-danger" onclick="change_product_status(\'Single_Store_Product\',\''.$items->id.'\','.$store_info->id.',\'UP_Product_status\',\'Enable\')">Disable</span>';
                                }else{
                                    $tabledata.='<span class="text-danger"><i class="fa fa-times" aria-hidden="true"></i></span>';
                                }
                               
                            $tabledata.='</td>';
                            $tabledata.='<td class="text-center">';
                                   if(isset($items->add_status) && $items->add_status){
                                       //'| <span class="btn btn-danger btn-small" onclick="category_status(\'delete product\',\'Single_Store_Product\',\''.$items->id.'\',\''.$store_info->id.'\',\'UP_Product_delete\')"><i class="fa fa-trash"></i></span>';
                                       $tabledata.=' <span class="btn btn-primary btn-small" onclick="category_status(\'update product\',\'Single_Store_Product\',\''.$items->id.'\',\''.$store_info->id.'\',\'UP_Update_Product\')" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i></span> ';
                                   }else{
                                        $tabledata.='<span class="btn btn-danger btn-small"  onclick="category_status(\'add product\',\'Single_Store_Product\',\''.$items->id.'\',\''.$store_info->id.'\',\'UP_Add_Product\')">Add</span>';
                                   }      
                                    
                             $tabledata.='</td>';
                             /*
                            if($this->upsetting->urbanpiper){
                                $tabledata.='<td class="text-center">';
                                    $tabledata.= ($platform_status->add_status)?(($platform_status->urbanpiper=='enable')?'<span class="btn btn-success btn-small" onclick="category_status(\'platform  status disable\',\'Single_Product_platform\',\''.$items->id.'\','.$store_info->id.',\'urbanpiper\',\'Disable\')">Enable </span>' :'<span class="btn btn-small btn-danger" onclick="category_status(\' platform  status enable\',\'Single_Product_platform\',\''.$items->id.'\','.$store_info->id.',\'urbanpiper\',\'Enable\')">Disable</span>'):'<span class="text-danger"><i class="fa fa-times" aria-hidden="true"></i></span>';
                                $tabledata.='</td>';
                            }
                            if($this->upsetting->zomato){
                                $tabledata.='<td class="text-center">';
                                    $tabledata.= ($platform_status->add_status)?(($platform_status->zomato=='enable')?'<span class="btn btn-success btn-small" onclick="category_status(\' platform  status disable\',\'Single_Product_platform\',\''.$items->id.'\','.$store_info->id.',\'zomato\',\'Disable\')">Enable </span>' :'<span class="btn btn-small btn-danger" onclick="category_status(\'platform  status enable\',\'Single_Product_platform\',\''.$items->id.'\','.$store_info->id.',\'zomato\',\'Enable\')">Disable</span>') :'<span class="text-danger" ><i class="fa fa-times" aria-hidden="true"></i></span>';
                                $tabledata.='</td>';
                            }
                            if($this->upsetting->foodpanda){
                                $tabledata.='<td class="text-center"> ';
                                    $tabledata.= ($platform_status->add_status)?(($platform_status->foodpanda=='enable')?'<span class="btn btn-success btn-small" onclick="category_status(\' platform  status disable\',\'Single_Product_platform\',\''.$items->id.'\','.$store_info->id.',\'foodpanda\',\'Disable\')">Enable </span>' :'<span class="btn btn-small btn-danger" onclick="category_status(\'platform  status enable\',\'Single_Product_platform\',\''.$items->id.'\','.$store_info->id.',\'foodpanda\',\'Enable\')">Disable</span>') :'<span class="text-danger" ><i class="fa fa-times" aria-hidden="true"></i></span>';
                                $tabledata.='</td>';
                            }  
                            if($this->upsetting->swiggy){
                                $tabledata.='<td class="text-center">';
                                    $tabledata.= ($platform_status->add_status)?(($platform_status->swiggy=='enable')?'<span class="btn btn-success btn-small" onclick="category_status(\' platform  status disable\',\'Single_Product_platform\',\''.$items->id.'\','.$store_info->id.',\'swiggy\',\'Disable\')">Enable </span>' :'<span class="btn btn-small btn-danger" onclick="category_status(\'platform  status enable\',\'Single_Product_platform\',\''.$items->id.'\','.$store_info->id.',\'swiggy\',\'Enable\')">Disable</span>')  :'<span class="text-danger" ><i class="fa fa-times" aria-hidden="true"></i></span>';
                                $tabledata.='</td>';
                            }
                            if($this->upsetting->ubereats){
                                $tabledata.='<td class="text-center">';
                                    $tabledata.= ($platform_status->add_status)?(($platform_status->ubereats=='enable')?'<span class="btn btn-success btn-small" onclick="category_status(\'platform  status disable\',\'Single_Product_platform\',\''.$items->id.'\','.$store_info->id.',\'ubereats\',\'Disable\')" >Enable </span>' :'<span class="btn btn-small btn-danger" onclick="category_status(\'platform  status enable\',\'Single_Product_platform\',\''.$items->id.'\','.$store_info->id.',\'ubereats\',\'Enable\')">Disable</span>') :'<span class="text-danger" ><i class="fa fa-times" aria-hidden="true"></i></span>';
                                $tabledata.='</td>';
                            }*/    
                        $tabledata.='</tr>';
                        $sr++;
                    }
                $tabledata.='</tbody>';
            $tabledata.='</table></div>';  
           
        } else {
            
            $tabledata = '<div class="alert alert-danger">Please Select Category</div>';
        }
        
        echo json_encode($tabledata);
    }
    
    // End product list
    
    /*====================================================================================
     * End Product 
     ====================================================================================*/
     
      /*=====================================================================================
     *  Categoty 
     =====================================================================================*/
    public function category(){
        if($this->input->post()){
            $post = $this->input->post();
            $action     = $this->input->post('action');
            $catIdsArr  = $this->input->post('val');
            $store_id   = $this->input->post('store_id');
            //Set Store Id
            $this->set_store_id($store_id);
                        
            if(!is_array($catIdsArr)){
                 $this->session->set_flashdata('errors',"Please select category");
                 return redirect('urban_piper/category/'.$store_id);
            } else {
                $response =  $this->action('Category_Upload','0',$action,$catIdsArr,$store_id);
                if($response['status']=='success'){
                    $this->session->set_flashdata('success',$response['messages']);
                }else if($response['status']= 'error'){
                    $this->session->set_flashdata('errors',$response['messages']);
                }else{
                    $this->session->set_flashdata('errors',"Please try again");
                }
                return redirect('urban_piper/category/'.$store_id);
            }
        } else {
            
            if(is_numeric($this->uri->segment(3))){ 
                $this->set_store_id($this->uri->segment(3));
                $bc = array(array('link' => base_url(), 'page' => lang('home')), array('link' => site_url('urban_piper'), 'page' => lang('Urbanpiper')), array('link' => '#', 'page' => lang('Category')));
                $meta = array('page_title' => lang('Category'), 'bc' => $bc);
                $this->data['store_id'] = $store_id = $this->uri->segment(3);
                $this->data['store_ref_id'] = $this->data['store']->ref_id;
                $this->data['categoryList'] = $this->UPM->getUpStoreCategory($store_id);
                
                $this->page_construct('urbanpiper/category', $meta, $this->data);
            }  else { 
                redirect('urban_piper/product_platform');
            } 
        }
    }
    
    public function getCategories() {
        
       $store_id = $this->uri->segment(3);
       
      // $where_condition = array('t1.up_category'=>'1');
        
      // $pass_data =  $this->UPM->getcategory($where_condition); 
       $pass_data = $this->UPM->getUpStoreCategory($store_id);
       
       $tabledata.='<table id="categorylist" class="table table-bordered table-hover table-striped">';
                $tabledata.='<thead><tr><th style="text-align: left;"> <input class="checkbox checkft input-xs" type="checkbox" name="check" id="select_all"/> &nbsp; Sr.No. </th><th>Image</th><th>Code</th>';
                $tabledata.='<th>Name</th><th>Parent Category</th>'; 
                $tabledata.='<th> Status </th><th> Add Status</th>';
                $tabledata.='</tr></thead>';  
                $tabledata.='<tbody>';
                    $sr=1;
                    foreach($pass_data as $category){
                        $imgcat = $category->image;
                        if($category->image){
                            if(!file_exists('assets/uploads/thumbs/'.$imgcat)){
                                $imgcat ='no_image.png';
                            }
                        }else{
                            $imgcat ='no_image.png';
                        }
                        
                        $tabledata.='<tr>';
                            $tabledata.='<td> <input class="checkbox valpass  multi-select input-xs" type="checkbox" onclick="myfunction()" value="'.$category->id.'" name="val[]" id="check_box_" /> &nbsp; ' .$sr.'</td>';
                            $tabledata.='<td class="text-center"> <img src="'.base_url('assets/uploads/thumbs/').$imgcat.'" style="height:32px;"> </td>';
                            $tabledata.='<td>'.$category->code.'</td>';
                            $tabledata.='<td>'.$category->name.'</td>';
                            $tabledata.='<td>'.(($category->parent_id) ? $pass_data[$category->parent_id]->name :'-').'</td>';
                            $tabledata.='<td class="text-center">';
                                if($category->up_added=='1'){
                                    if($category->up_is_active=='1'){
                                        $tabledata.='<span class=" btn  btn-success btn-small" onclick="category_status(\'status\',\'category_status\',\''.$category->id.'\',\'Disable\',\''.$store_id.'\')" > Enabled</span>';
                                    } else {
                                        $tabledata.='<span class="btn btn-danger btn-small" onclick="category_status(\'status\',\'category_status\',\''.$category->id.'\',\'Enabled\',\''.$store_id.'\')"> Disable</span>';
                                    }
                                } 
//                                else{
//                                     $tabledata.='<span class="text-danger"> <i class="fa fa-times" aria-hidden="true"></i>  </span>';
//                                }    
                            $tabledata.='</td>';
                            $tabledata.='<td class="text-center">';
                                if($category->up_added=='1') {
                                    $tabledata.='<span class="btn btn-primary btn-small" onclick="category_status(\'update \',\'category_update\',\''.$category->id.'\',\'Update\',\''.$store_id.'\')" ><i class="fa fa-pencil-square-o" aria-hidden="true"></i> </span> ';
                                    //$tabledata.='<span class="btn btn-danger btn-small"  onclick="category_status(\'delete\',\'category_delete\',\''.$category->id.'\',\''.$store_id.'\')"> <i class="fa fa-trash" aria-hidden="true"></i> </span>';
                                } else {
                                    $tabledata.='<span class="btn btn-danger btn-small" onclick="add_up_category(\''.$category->id.'\',\''.$store_id.'\')">Add</span>';
                                }
                            $tabledata.='</td>';      
                        $tabledata.='</tr>';
                        $sr++;
                    }
                $tabledata.='</tbody>';
            $tabledata.='</table>';    
                
       
       echo json_encode($tabledata);
    }
    // Category Add 
    
    public function importStoreCategory() {
       
        $store_id = $this->uri->segment(3);
        
        $category =  $this->UPM->importNotStoreCategory($store_id);
                        
        if($this->db->insert_batch('sma_up_stores_categories', $category)){
            $response['status']= 'success';
            $response['messages']= 'Category Add Successfully.';
        } else {
            $response['status']= 'error';
            $response['messages']= $this->db->_error_message();
        }        
        
        echo json_encode($response);
    }
    
    public function add_category(){        
      
       $category =  $this->UPM->getrecords('sma_categories','*','result');
       
       foreach ($category as $category_value){
           if($category_value->up_category!='1'){
             
               $field = array('up_category'=>'1');
               $this->UPM->action_database('Update','sma_categories',array('id'=>$category_value->id),$field);
            }
       }
       $response['status']= 'success';
        $response['messages']= 'Category Add Successfully.';

       echo json_encode($response);
    }
    
    // End Category Add
    /*=====================================================================================
     * End Category
     =====================================================================================*/
    
     
      /*==========================================================================
     * New Order
     ==========================================================================*/
    public function new_orders() {
        
       $result = $this->UPM->count_new_sales();
       if(is_array($result)) {
       echo json_encode($result);
       } else {
           echo json_encode(['num'=>0]);
       }
    }
    /*==========================================================================
     * end new order
     ==========================================================================*/
     
     /*========================================================================
      * Curl  Request fucntion  Testing use
     *=========================================================================*/
     public function item_status(){
        $URL = "https://staging.urbanpiper.com/external/api/v1/inventory/locations/-1/";
        $data_json ='{"items":[{"ref_id":"87646942","title":"Mango Fizz","price":100,"available":false,"upipr_status":{"action":"U","id":3423,"error":false}}]}';
   	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL,$URL);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json','Authorization: apikey biz_adm_clients_XWuoXNFAgktp:4b5300a21c68e77fe69dd81889993f6bc6ff1885 ','Content-Type : application/json'));
	curl_setopt($ch, CURLOPT_POST, 1);
	curl_setopt($ch, CURLOPT_POSTFIELDS,$data_json);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$response  = curl_exec($ch);
	curl_close($ch);
	print_r($response);
    }
     // Response 
   //  {"status": "success", "message": "Your request has been queued. Once processed, a callback will be issued to the configured webhook(s) or the URL passed in.", "reference": "7aad645bb89b4b1dac50f9f2b7b2140e"}
     
     /*=======================================================================
     * Enst curl request function
     *======================================================================*/
     
     
      /*=======================================================================
      * Order Package update
      =======================================================================*/
      public function update_UP_Package() {
        
        $ordercounts = $_POST['ordercounts'];
        if($ordercounts > 0) {

            $this->db->query( "UPDATE sma_settings SET `up_balance_order` = `up_balance_order`+".$ordercounts . " WHERE `setting_id`='1' ");
            
            if($this->db->affected_rows()){
                $data['status'] = 'success';
            } else {
                $data['status'] = 'error';
                $data['msg'] = $this->db->_error_message();
            } 
        } else {
            $data['status'] = 'error';
            $data['msg'] = 'Invalid Order Count';
        }
        
        echo json_encode($data);
    }
    
    /*========================================================================
     *  End Order package Update
     =========================================================================*/ 
   
    
    public function inventorycallback(){
        
           $this->load->model('pos_model'); // Load pos model
           $jsonString = file_get_contents("php://input");
           
           $callbacklog['callback_type']= 'storeaction';
           $callbacklog['callback_data']= serialize($jsonString);
           $callbacklog['callback_time']= date('Y-m-d H:i:s');
                               
           $this->UPM->setCallbackLog($callbacklog);
                      
          // $jsonString = '{"categories":[{"active":true,"description":"famous veg and nonveg hyderabadi biryanis","img_url":"https://static.giantbomb.com/uploads/scale_small/0/6087/2437349-pikachu.png","name":"Biryanis","ref_id":"C-1","sort_order":1,"translations":[{"description":"...","language":"fr","name":"..."},{"description":"...","language":"es","name":"..."}],"upipr_status":{"action":"A","error":false,"id":13888}},{"active":true,"description":"Refreshing ice creams and drinks of summer","img_url":"https://static.giantbomb.com/uploads/scale_small/0/6087/2437349-pikachu.png","name":"Desserts and Beverages","ref_id":"C-2","sort_order":2,"translations":[],"upipr_status":{"action":"A","error":false,"id":13889}},{"active":true,"description":"Refreshing ice creams summer","img_url":"https://static.giantbomb.com/uploads/scale_small/0/6087/2437349-pikachu.png","name":"Desserts","parent_ref_id":"C-2","ref_id":"C-3","sort_order":1,"translations":[],"upipr_status":{"action":"A","error":false,"id":13890}},{"active":true,"description":"Refreshing drinks of summer","img_url":"https://static.giantbomb.com/uploads/scale_small/0/6087/2437349-pikachu.png","name":"Beverages","parent_ref_id":"C-2","ref_id":"C-4","sort_order":2,"translations":[],"upipr_status":{"action":"A","error":false,"id":13891}},{"active":true,"description":"Amercian and Italion veg and non Pizza","img_url":"https://static.giantbomb.com/uploads/scale_small/0/6087/2437349-pikachu.png","name":"Pizza","ref_id":"C-5","sort_order":5,"upipr_status":{"action":"A","error":false,"id":13892}}],"charges":[{"active":true,"description":"Packing Charge per Item Quantity","excluded_platforms":[],"fulfillment_modes":["delivery"],"item_ref_ids":["I1","I2","I3","I4"],"ref_id":"pc-1","structure":{"applicable_on":"item.quantity","type":"percentage","value":10},"title":"Packing Charge"}],"flush_items":false,"flush_options":false,"items":[{"available":true,"category_ref_ids":["C-1"],"current_stock":-1,"description":"Authentic Hyderabadi Biryanis available in small and large sizes","excluded_platforms":["zomato","swiggy"],"food_type":"1","price":0,"recommended":true,"ref_id":"I-1","sold_at_store":true,"tags":{"swiggy":["pop","edvm"],"zomato":["treat","deal99"]},"title":"Veg Biryani","translations":[{"description":"...","language":"fr","name":"..."},{"description":"...","language":"es","name":"..."}],"upipr_status":{"action":"A","error":false,"id":188149}},{"available":true,"category_ref_ids":["C-4"],"current_stock":-1,"description":"200ml pet bottle","food_type":"1","price":20,"recommended":true,"ref_id":"I-2","sold_at_store":true,"title":"Coke","translations":[],"upipr_status":{"action":"A","error":false,"id":188150}},{"available":true,"category_ref_ids":["C-3"],"current_stock":-1,"description":"Delicious mouth watering strawberry icecream","food_type":"1","price":30,"recommended":true,"ref_id":"I-3","sold_at_store":true,"title":"Strawberry Icecream Scoop","translations":[],"upipr_status":{"action":"A","error":false,"id":188151}},{"available":true,"category_ref_ids":["C-5"],"current_stock":-1,"description":"Italian handmade spl chicken bbq pizza with added toppings","food_type":"2","price":0,"recommended":true,"ref_id":"I-4","sold_at_store":true,"title":"Chicken BBQ Pizza","translations":[],"upipr_status":{"action":"A","error":false,"id":188152}}],"option_groups":[{"active":true,"item_ref_ids":["I-1"],"max_selectable":1,"min_selectable":1,"ref_id":"OG-1","title":"Choose Your Biryani size","upipr_status":{"action":"A","error":false,"id":13976}},{"active":true,"item_ref_ids":["I-4"],"max_selectable":1,"min_selectable":1,"ref_id":"OG-2","title":"Choose Your Pizza","translations":[{"description":"...","language":"fr","title":"..."},{"description":"...","language":"es","title":"..."}],"upipr_status":{"action":"A","error":false,"id":13977}},{"active":true,"item_ref_ids":["I-4"],"max_selectable":-1,"min_selectable":0,"ref_id":"OG-3","title":"Choose Your Toppings","translations":[],"upipr_status":{"action":"A","error":false,"id":13978}}],"options":[{"available":true,"description":"For Veg Biryani","nested_opt_grps":[],"opt_grp_ref_ids":["OG-1"],"price":150,"ref_id":"opt-1","sold_at_store":true,"title":"Small","translations":[{"description":"...","language":"fr","title":"..."},{"description":"...","language":"es","title":"..."}],"upipr_status":{"action":"A","error":false,"id":49551},"weight":200},{"available":true,"description":"For Veg Biryani","nested_opt_grps":[],"opt_grp_ref_ids":["OG-1"],"price":250,"ref_id":"opt-2","sold_at_store":true,"title":"Large","translations":[],"upipr_status":{"action":"A","error":false,"id":49552},"weight":400},{"available":true,"description":"For Chicken bbq pizza size","opt_grp_ref_ids":["OG-2"],"price":450,"ref_id":"opt-3","sold_at_store":true,"title":"Large","upipr_status":{"action":"A","error":false,"id":49553},"weight":0},{"available":true,"description":"For Chicken bbq pizza size","opt_grp_ref_ids":["OG-2"],"price":350,"ref_id":"opt-4","sold_at_store":true,"title":"Medium","upipr_status":{"action":"A","error":false,"id":49554},"weight":0},{"available":true,"description":"For Chicken bbq pizza size","opt_grp_ref_ids":["OG-2"],"price":250,"ref_id":"opt-5","sold_at_store":true,"title":"Small","upipr_status":{"action":"A","error":false,"id":49555},"weight":0},{"available":true,"description":"For Chicken bbq pizza topping","opt_grp_ref_ids":["OG-3"],"price":50,"ref_id":"opt-6","sold_at_store":true,"title":"Cheese","upipr_status":{"action":"A","error":false,"id":49556},"weight":0},{"available":true,"description":"For Chicken bbq pizza topping","opt_grp_ref_ids":["OG-3"],"price":60,"ref_id":"opt-7","sold_at_store":true,"title":"Chicken Sausage","upipr_status":{"action":"A","error":false,"id":49557},"weight":0},{"available":true,"description":"For Chicken bbq pizza topping","opt_grp_ref_ids":["OG-3"],"price":30,"ref_id":"opt-8","sold_at_store":true,"title":"Corn","upipr_status":{"action":"A","error":false,"id":49558},"weight":0},{"available":true,"description":"For Chicken bbq pizza topping","opt_grp_ref_ids":["OG-3"],"price":40,"ref_id":"opt-9","sold_at_store":true,"title":"Mushroom","upipr_status":{"action":"A","error":false,"id":49559},"weight":0}],"reference":"72f07c7e794845c489c0c6818b4bb2ac","stats":{"categories":{"created":5,"deleted":0,"errors":0,"updated":0},"items":{"created":4,"deleted":0,"errors":0,"updated":0},"option_groups":{"created":3,"deleted":0,"errors":0,"updated":0},"options":{"created":9,"deleted":0,"errors":0,"updated":0}},"taxes":[{"active":true,"description":"2.5% CGST on all items","item_ref_ids":["I1","I2","I3","I4"],"ref_id":"cgst-2.5","structure":{"applicable_on":"item.price","type":"percentage","value":2.5},"title":"CGST"},{"active":true,"description":"2.5% SGST on all items","item_ref_ids":["I1","I2","I3","I4"],"ref_id":"sgst-2.5","structure":{"applicable_on":"item.price","type":"percentage","value":2.5},"title":"SGST"}]}';
           
          $phpObject = json_decode($jsonString);
                      
          $categories = isset($phpObject->categories)  ? $phpObject->categories :  NULL;
          $charges = isset($phpObject->charges)        ? $phpObject->charges :     NULL;
          $items = isset($phpObject->items)            ? $phpObject->items :       NULL;
          $options = isset($phpObject->options)        ? $phpObject->options :     NULL;
          $error = false;
        
         
        if(is_array($categories)) {
            foreach ($categories as $key => $category) {
                $catdata = array('up_is_active' => $category->active);
                
                $recs[$category->ref_id] = $this->db->where('category_ref_id',$category->ref_id)->update('sma_up_stores_categories',$catdata); 
                
                if((bool)$recs[$category->ref_id]){
                    $data['categories'][$category->ref_id]['status'] = ($recs[$category->ref_id]) ? 'success' : 'failed';
                    $data['categories'][$category->ref_id]['massage'] = "category updated successfully";

                } else {                    
                    $data['categories'][$category->ref_id]['status'] = "error";
                    $data['categories'][$category->ref_id]['massage'] = $this->db->_error_message();
                }
            }
           
        } else {
            $error = true;
        }
                
        if(is_array($items)) {
            $error = false;            
            foreach ($items as $key => $item) {
                $itemsdata = array(
                        'product_code' => $item->ref_id,
                        'zomato' => (in_array('zomato', $item->excluded_platforms) ? 1 : 0),
                        'foodpanda' => (in_array('foodpanda', $item->excluded_platforms) ? 1 : 0),
                        'swiggy' => (in_array('swiggy', $item->excluded_platforms) ? 1 : 0),
                        'ubereats' => (in_array('ubereats', $item->excluded_platforms) ? 1 : 0),
                        'urbanpiper' => 1,
                    );
                $rec[$item->ref_id] = $this->db->where('product_code',$item->ref_id)->update('sma_up_products_platform',$itemsdata); 
                
                if((bool)$rec[$item->ref_id]){                
                    $data['items'][$item->ref_id]['massage'] = "Items updated successfully";
                    $data['items'][$item->ref_id]['status'] = ($rec[$item->ref_id]) ? 'success' : 'failed';

                } else {
                    $data['items'][[$item->ref_id]]['massage'] = $this->db->_error_message();
                    $data['items'][[$item->ref_id]]['status'] = "error";
                }
            }
            //$rec = $this->db->update_batch('sma_up_products_platform',$itemsdata, 'product_code'); 
            
                        
        } else {
            $error = true;
        }
        
        
        if( $error == true){
            $data['status'] = "error";
            $data['massage'] = "Invalid callback request data";
        }
        
        echo json_encode( $data);  
                        
    }
    
    public function storescallback(){
        
           $this->load->model('pos_model'); // Load pos model
           $jsonString = file_get_contents("php://input");
           
           $callbacklog['callback_type']= 'storeaction';
           $callbacklog['callback_data']= serialize($jsonString);
           $callbacklog['callback_time']= date('Y-m-d H:i:s');
           
           $this->UPM->setCallbackLog($callbacklog);
           
           $phpObject = json_decode($jsonString);
           
          $stores = $phpObject->stores;
          
        if(is_array($stores)) {
            foreach ($stores as $key => $store) {
                $storedata[] = array(
                        'ref_id' => $store->ref_id,
                        'plat_urbanpiper' => (in_array('urbanpiper', $store->excluded_platforms) ? 'enable' : 'disable'),
                        'plat_zomato' => (in_array('zomato', $store->excluded_platforms) ?  'enable' : 'disable'),
                        'plat_foodpanda' => (in_array('foodpanda', $store->excluded_platforms) ?  'enable' : 'disable'),
                        'plat_swiggy' => (in_array('swiggy', $store->excluded_platforms) ?  'enable' : 'disable'),
                        'plat_ubereats' => (in_array('ubereats', $store->excluded_platforms) ?  'enable' : 'disable'),                        
                        'active' => $store->active ? 'true' : 'false',
                        'ordering_enabled' => $store->ordering_enabled ? 'true' : 'false',
                );
            }
        }
        
        $this->db->update_batch('sma_up_stores',$storedata, 'ref_id'); 
           
            echo json_encode(['status'=>'success']);  
    }
    
    public function storeactioncallback(){
        
           $this->load->model('pos_model'); // Load pos model
           $jsonString = file_get_contents("php://input");
           
           $callbacklog['callback_type']= 'storeaction';
           $callbacklog['callback_data']= serialize($jsonString);
           $callbacklog['callback_time']= date('Y-m-d H:i:s');          
                      
           $this->UPM->setCallbackLog($callbacklog);
           
            $stores = json_decode($jsonString);
                        
        if(count($stores)>1) {
            foreach ($stores as $key => $store) {
                $storedata[] = array(
                        'ref_id' => $store->location_ref_id,
                        'plat_'.$store->platform => 'enable',
                        'active' => $store->status ? 'true' : 'false',                        
                    );
            }//end foreach.
            
            if($this->db->update_batch('sma_up_stores',$storedata, 'ref_id')){
                echo json_encode(['status'=>'success']); 
            }
        
        } elseif(count($stores)==1) {
            
            $storedata = array(
                        'plat_'.$stores->platform => 'enable',
                        'active' => $stores->status ? 'true' : 'false',                        
                    );
             $this->db->where(['ref_id'=>$stores->location_ref_id]);
             if($this->db->update('sma_up_stores',$storedata )){
                 echo json_encode(['status'=>'success']); 
             }
             
        } //elseif.
        else {
            echo json_encode(['status'=>'error', 'message'=>'Invalid callback request data']); 
        }
                        
          
                        
    }
    
     
}
