 <?php defined('BASEPATH') or exit('No direct script access allowed');

class Reciept extends MY_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->lang->load('sales', $this->Settings->user_language);
        $this->load->helper('text');
        $this->load->library('form_validation');
        $this->load->model('sales_model');
        $this->load->model('eshop_model');
        $this->digital_upload_path = 'files/';
        $this->upload_path = 'assets/uploads/';
        $this->thumbs_path = 'assets/uploads/thumbs/';
        $this->image_types = 'gif|jpg|jpeg|png|tif';
        $this->digital_file_types = 'zip|psd|ai|rar|pdf|doc|docx|xls|xlsx|ppt|pptx|gif|jpg|jpeg|png|tif|txt';
        $this->allowed_file_size = '1024';
        $this->data['logo'] = true;
    }

    public function send_sms(){
        $code = $this->input->get('code');
        $res =  $this->eshop_model->validateRecieptSales($code);
       
        if($res){
            $sale_id = $id = isset($res[0]['id'])?$res[0]['id']:false;
        }
        
        if ( ! $sale_id) {
            die('No sale selected.');
        }
        
        $inv = $this->sales_model->getInvoiceByID($id);
        $str = '';
        if($inv->grand_total):
            $str = 'Thanks for visiting '.$this->Settings->site_name.'. Your Total Bill amount '.$this->sma->formatDecimal($inv->grand_total).' '.$this->Settings->default_currency;
        endif;

           //

            $url = base_url('reciept/pdf/') . $code;
            $curl = curl_init();

            curl_setopt_array($curl, array(
            CURLOPT_URL => 'https://lntp.in?key=hbfsbfnbkfsdhbkdgf367n&q='.$url,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => '',
            CURLOPT_MAXREDIRS => 10,
            CURLOPT_TIMEOUT => 0,
            CURLOPT_FOLLOWLOCATION => true,
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => 'GET',
            ));

            $response = curl_exec($curl);

            curl_close($curl);
            // echo $response;
            // exit;
            $response = json_decode($response);
        //
        
        $grand_total = isset($res[0]['grand_total'])?$res[0]['grand_total']:false;
        $no = $this->input->get('phone');
        //$url = $this->get_tiny_url(base_url('reciept/pdf/').$code);
        $url = $response->url;
        $pass_str = $str .' You can view receipt   ' . $url;
        $this->CallSMS($no,$pass_str, 'SALE_INVOICE');
    }

    public function quote_sms($quote_id,$phone)
    {
        $this->load->model('quotes_model');
        $code = md5('quote_reciept' . $quote_id);
        $res = $this->quotes_model->validateRecieptQuote($code);
        //print_r($res);
        if( ! $res)
        {

        }
        $quote_id = $id = isset($res[0]['id']) ? $res[0]['id'] : FALSE;
        if( ! $quote_id)
        {
            die('No quote selected.');
        }

        $inv = $this->quotes_model->getQuoteByID($quote_id);
        //$this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);
        //print_r($this->data['customer']);
        //print_r($inv);exit;
        $str = '';
        if($inv->grand_total):
            $str = 'Thanks for visiting ' . $this->Settings->site_name . '. Your Total Quote amount ' . $this->sma->formatDecimal($inv->grand_total) . ' ' . $this->Settings->default_currency;
        endif;

        $grand_total = isset($res[0]['grand_total']) ? $res[0]['grand_total'] : FALSE;
        $no = ($this->input->get('phone')) ? $this->input->get('phone') : $phone;
        //$no = "9881815256";
        $url = $this->get_tiny_url(base_url('quotes/pdf_view/') . $code);
        $pass_str = $str . ' You can view reciept   ' . $url;
        //$this->db->update('quotes', array('status' => 'sent'), array('id' => $quote_id));
        $this->CallSMS($no, $pass_str, 'QUOTATION_RECEPT');
    }

  public function purchase_sms($purchase_id,$phone){
        $this->load->model('purchases_model');
        $code = md5('purchase_reciept' . $purchase_id);
        $res = $this->purchases_model->validateRecieptPurchase($code);
        if( ! $res)
        {  }
        $quote_id = $id = isset($res[0]['id']) ? $res[0]['id'] : FALSE;
        if( ! $quote_id){die('No quote selected.');}
        $inv = $this->purchases_model->getPurchaseByID($purchase_id);
        $str = '';
        if($inv->grand_total):
             $str = 'Thanks for visiting ' . $this->Settings->site_name . '. Your Total Purchase Invoice ' . $this->sma->formatDecimal($inv->grand_total) . ' ' . $this->Settings->default_currency;
        endif;    
        $grand_total = isset($res[0]['grand_total']) ? $res[0]['grand_total'] : FALSE;
        $no = ($this->input->get('phone')) ? $this->input->get('phone') : $phone;
        $url = $this->get_tiny_url(base_url('purchases/pdf_view/') . $code);
        $pass_str = $str . ' You can view reciept   ' . $url;
        $this->db->update('quotes', array('status' => 'sent'), array('id' => $quote_id));
        $this->CallSMS($no, $pass_str, 'PURCHESE_INVOICE');
      
    }

    function get_tiny_url($url)  {  
	$ch = curl_init();  
	$timeout = 5;  
	curl_setopt($ch,CURLOPT_URL,'http://tinyurl.com/api-create.php?url='.$url);  
	curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
	curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
	$data = curl_exec($ch);  
	curl_close($ch);  
	return $data;  
    }

    function CallSMS($mobile, $msg, $sms_template_key = NULL) {

        if ($sms_template_key == NULL) {
            echo '{"msg":"SMS template key is null."}';
        } else {

            $res = $this->sma->SendSMS($mobile, $msg, $sms_template_key);

            if (!empty($res)):
                $Obj = json_decode($res);

                if (isset($Obj) && $Obj->status == 'success'):
                    $rec['sms_log'] = $this->sma->setSMSLog($mobile, $msg, $Obj->Description);
                    $rec['sms_balance_update'] = $this->sma->update_sms_count(1);
                    echo '{"msg":"Your receipt has been successfully sent by SMS."} ';
                else:
                    echo '{"msg": "' . $Obj->message . '"} ';
                endif;
            else:
                echo '{"msg": "Error , Please try again "} ';
            endif;
        }
    }
    
    public function pdf($id = null, $view = null, $save_bufffer = null)
    {
        if ($this->input->get('id')) {
            $code = $this->input->get('id');
        } 
      
        $res =  $this->eshop_model->validateRecieptSales($id);
        if(!$res){
            
        }
        $sale_id = $id = isset($res[0]['id'])?$res[0]['id']:false;
        if ( !$sale_id) {
            die('No sale selected.');
        } 
         
        $_PID = $this->Settings->default_printer;
    	$this->data['default_printer'] = $this->site->defaultPrinterOption($_PID); 
    	
        $this->data['error'] = (validation_errors()) ? validation_errors() : $this->session->flashdata('error');
        $inv = $this->sales_model->getInvoiceByID($id);
        
        if($this->data['default_printer']->tax_classification_view):
            $inv->rows_tax = $this->sales_model->getAllTaxItems($id,$inv->return_id) ;
        endif; 
        $isGstSale = $this->site->isGstSale($id);
        $inv->GstSale = !empty($isGstSale)?1:0;
        $this->data['taxItems'] = $this->sales_model->getAllTaxItemsGroup($inv->id,$inv->return_id) ;
        
        $this->default_currency = $this->site->getCurrencyByCode($this->Settings->default_currency);
        $this->data['default_currency'] = $this->default_currency;        
        $this->data['barcode'] = "<img src='" . site_url('products/gen_barcode/' . $inv->reference_no) . "' alt='" . $inv->reference_no . "' class='pull-left' />";
        $this->data['customer'] = $this->site->getCompanyByID($inv->customer_id);
        $this->data['payments'] = $this->sales_model->getPaymentsForSale($id);
        $this->data['biller'] = $this->site->getCompanyByID($inv->biller_id);
        $this->data['user'] = $this->site->getUser($inv->created_by);
        $this->data['warehouse'] = $this->site->getWarehouseByID($inv->warehouse_id);
        $this->data['inv'] = $inv;
        $this->data['rows'] = $this->sales_model->getAllInvoiceItems($id);
        $this->data['return_sale'] = $inv->return_id ? $this->sales_model->getInvoiceByID($inv->return_id) : NULL;
        $this->data['return_rows'] = $inv->return_id ? $this->sales_model->getAllInvoiceItems($inv->return_id) : NULL;
        
        $name = lang("sale") . "_" . str_replace('/', '_', $inv->reference_no).'_'.time() . ".pdf";
        $Settings =   $this->Settings;//$this->site->get_setting();
        
        //Set Sale items image
        $this->data['inv']->invoice_product_image= $Settings->invoice_product_image;
        if(!empty($this->data['rows'])){
            foreach ($this->data['rows'] as $key => $row) {
                $this->load->model('pos_model');
                $product = $this->pos_model->getProductByID($row->product_id, $select='image');
                $this->data['rows'][$key]->image = $product->image;
            }
        }
        
        $html = $this->load->view($this->theme . 'sales/pdf_reciept', $this->data, true);
          
        if (! $this->Settings->barcode_img) {
            $html = preg_replace("'\<\?xml(.*)\?\>'", '', $html);
        }
        
        $file_path =  $this->sma->generate_pdf($html, $name,'S', $this->data['biller']->invoice_footer);
        if(!empty($file_path)){
            $file_path1 = FCPATH.$file_path;
            if(file_exists($file_path1))   :
               $_url =  base_url($file_path)  ;
              $this->sma->md($_url);
              exit;
            endif;    
        }
    }
    
    public function post_to_url($url, $data) {
        $fields = '';
        foreach ($data as $key => $value) {
            $fields .= $key . '=' . $value . '&';
        }
        rtrim($fields, '&');
        $post = curl_init();
        curl_setopt($post, CURLOPT_URL, $url);
        curl_setopt($post, CURLOPT_POST, count($data));
        curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($post);

        curl_close($post);
        return $result;
    }
}
