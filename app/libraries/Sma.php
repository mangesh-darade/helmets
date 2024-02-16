<?php defined('BASEPATH') or exit('No direct script access allowed');

class Sma
{
    private $_merchant_phone;  // Merchant Phone
    private $apiKey; // Common API KEY
    private $pos_api_url;  // Common API ENDPOINT
    private $configData;
    private $currencyLable;
    
    public function __construct(){
        $ci = get_instance();
        $config = $this->configData = $ci->config;
        $this->_merchant_phone = isset($config->config['merchant_phone'])?$config->config['merchant_phone']:'';
        $this->apiKey = isset($config->config['apiKey'])?$config->config['apiKey']:'';
        $this->pos_api_endpoint = isset($config->config['pos_api_endpoint'])?$config->config['pos_api_endpoint']:'https://simplypos.in/api';
        $this->pos_api_url = rtrim( $this->pos_api_endpoint,'/'); 
    }
    
    public function setSettings($Settings) {
            
        $this->currencyLable = ($Settings->default_currency == 'USD') ? 'Dollar' : 'Rupees';
    }

    public function __get($var) {
        return get_instance()->$var;
    }

    private function _rglobRead($source, &$array = array()) {
        
        if (!$source || trim($source) == "") {
            $source = ".";
        }
        foreach ((array) glob($source . "/*/") as $key => $value) {
            $this->_rglobRead(str_replace("//", "/", $value), $array);
        }
        $hidden_files = glob($source . ".*") and $htaccess = preg_grep('/\.htaccess$/', $hidden_files);
        $files = array_merge(glob($source . "*.*"), $htaccess);
        foreach ($files as $key => $value) {
            $array[] = str_replace("//", "/", $value);
        }
    }

    private function _zip($array, $part, $destination, $output_name = 'sma')
    {
        $zip = new ZipArchive;
        @mkdir($destination, 0777, true);

        if ($zip->open(str_replace("//", "/", "{$destination}/{$output_name}" . ($part ? '_p' . $part : '') . ".zip"), ZipArchive::CREATE)) {
            foreach ((array) $array as $key => $value) {
                $zip->addFile($value, str_replace(array("../", "./"), null, $value));
            }
            $zip->close();
        }
    }

    public function formatMoney($number)
    {
        if ($this->Settings->sac) {
            return ($this->Settings->display_symbol == 1 ? $this->Settings->symbol : '') .
            $this->formatSAC($this->formatDecimal($number)) .
            ($this->Settings->display_symbol == 2 ? $this->Settings->symbol : '');
        }
        $decimals = $this->Settings->decimals;
        $ts = $this->Settings->thousands_sep == '0' ? ' ' : $this->Settings->thousands_sep;
        $ds = $this->Settings->decimals_sep;
        return ($this->Settings->display_symbol == 1 ? $this->Settings->symbol : '') .
        number_format($number, $decimals, $ds, $ts) .
        ($this->Settings->display_symbol == 2 ? $this->Settings->symbol : '');
    }

    public function formatQuantity($number, $decimals = null){
        if (!$decimals) {
            $decimals = $this->Settings->qty_decimals;
        }
        if ($this->Settings->sac) {
            return $this->formatSAC($this->formatDecimal($number, $decimals));
        }
        $ts = $this->Settings->thousands_sep == '0' ? ' ' : $this->Settings->thousands_sep;
        $ds = $this->Settings->decimals_sep;
        return number_format($number, $decimals, $ds, $ts);
    }

    public function formatNumber($number, $decimals = null)
    {
        if (!$decimals) {
            $decimals = $this->Settings->decimals;
        }
        if ($this->Settings->sac) {
            return $this->formatSAC($this->formatDecimal($number, $decimals));
        }
        $ts = $this->Settings->thousands_sep == '0' ? ' ' : $this->Settings->thousands_sep;
        $ds = $this->Settings->decimals_sep;
        return number_format($number, $decimals, $ds, $ts);
    }

    public function formatDecimal($number, $decimals = null)
    {
        if (!is_numeric($number)) {
            return null;
        }
        if (!$decimals) {
            $decimals = $this->Settings->decimals;
        }
        return number_format($number, $decimals, '.', '');
    }

    public function clear_tags($str)
    {
        return htmlentities(
            strip_tags($str,
                '<span><div><a><br><p><b><i><u><img><blockquote><small><ul><ol><li><hr><big><pre><code><strong><em><table><tr><td><th><tbody><thead><tfoot><h3><h4><h5><h6>'
            ),
            ENT_QUOTES | ENT_XHTML | ENT_HTML5,
            'UTF-8'
        );
    }

    public function decode_html($str)
    {
        return html_entity_decode($str, ENT_QUOTES | ENT_XHTML | ENT_HTML5, 'UTF-8');
    }

    public function roundMoney($num, $nearest = 0.05)
    {
        return round($num * (1 / $nearest)) * $nearest;
    }

    public function roundNumber($number, $toref = null)
    {
        switch ($toref) {
            case 1:
                $rn = round($number * 20) / 20;
                break;
            case 2:
                $rn = round($number * 2) / 2;
                break;
            case 3:
                $rn = round($number);
                break;
            case 4:
                $rn = ceil($number);
                break;
            default:
                $rn = $number;
        }
        return $rn;
    }

    public function unset_data($ud)
    {
        if ($this->session->userdata($ud)) {
            $this->session->unset_userdata($ud);
            return true;
        }
        return false;
    }

    public function hrsd($sdate)
    {
        if ($sdate) {
            if($sdate=='0000-00-00'){
            	return false;
            }	
            return date($this->dateFormats['php_sdate'], strtotime($sdate));
        } else {
            return '0000-00-00';
        }
    }

    public function hrld($ldate)
    {
        if ($ldate) {
            return date($this->dateFormats['php_ldate'], strtotime($ldate));
        } else {
            return '0000-00-00 00:00:00';
        }
    }

    public function fsd($inv_date)
    {
        if ($inv_date) {
            $jsd = $this->dateFormats['js_sdate'];
            if ($jsd == 'dd-mm-yyyy' || $jsd == 'dd/mm/yyyy' || $jsd == 'dd.mm.yyyy') {
                $date = substr($inv_date, -4) . "-" . substr($inv_date, 3, 2) . "-" . substr($inv_date, 0, 2);
            } elseif ($jsd == 'mm-dd-yyyy' || $jsd == 'mm/dd/yyyy' || $jsd == 'mm.dd.yyyy') {
                $date = substr($inv_date, -4) . "-" . substr($inv_date, 0, 2) . "-" . substr($inv_date, 3, 2);
            } else {
                $date = $inv_date;
            }
            return $date;
        } else {
            return '0000-00-00';
        }
    }

    public function fld($ldate)
    {
        if ($ldate) {
            $date = explode(' ', $ldate);
            $jsd = $this->dateFormats['js_sdate'];
            $inv_date = $date[0];
            $time = $date[1];
            if ($jsd == 'dd-mm-yyyy' || $jsd == 'dd/mm/yyyy' || $jsd == 'dd.mm.yyyy') {
                $date = substr($inv_date, -4) . "-" . substr($inv_date, 3, 2) . "-" . substr($inv_date, 0, 2) . " " . $time;
            } elseif ($jsd == 'mm-dd-yyyy' || $jsd == 'mm/dd/yyyy' || $jsd == 'mm.dd.yyyy') {
                $date = substr($inv_date, -4) . "-" . substr($inv_date, 0, 2) . "-" . substr($inv_date, 3, 2) . " " . $time;
            } else {
                $date = $inv_date;
            }
            return $date;
        } else {
            return '0000-00-00 00:00:00';
        }
    }

    public function send_email($to, $subject, $message, $from = null, $from_name = null, $attachment = null, $cc = null, $bcc = null)
    {
  
        $this->load->library('email');
        $config['useragent'] = "Stock Manager Advance";
        $config['protocol'] = $this->Settings->protocol;
        $config['mailtype'] = "html";
        $config['crlf'] = "\r\n";
        $config['newline'] = "\r\n";
        if ($this->Settings->protocol == 'sendmail') {
    
            $config['mailpath'] = $this->Settings->mailpath;
        } elseif ($this->Settings->protocol == 'smtp') {
            $this->load->library('encrypt');
            $config['smtp_host'] = $this->Settings->smtp_host;
            $config['smtp_user'] = $this->Settings->smtp_user;
            $config['smtp_pass'] = $this->encrypt->decode($this->Settings->smtp_pass);
            $config['smtp_port'] = $this->Settings->smtp_port;
            if (!empty($this->Settings->smtp_crypto)) {
                $config['smtp_crypto'] = $this->Settings->smtp_crypto;
            }
        }

        $this->email->initialize($config);

        if ($from && $from_name) {
            $this->email->from($from, $from_name);
        } elseif ($from) {
            $this->email->from($from, $this->Settings->site_name);
        } else {
            $this->email->from($this->Settings->default_email, $this->Settings->site_name);
        }

        $this->email->to($to);
        if ($cc) {
            $this->email->cc($cc);
        }
        if ($bcc) {
            $this->email->bcc($bcc);
        }
        $this->email->subject($subject);
        $this->email->message($message);
        if ($attachment) {
            if (is_array($attachment)) {
                foreach ($attachment as $file) {
                    $this->email->attach($file);
                }
            } else {
                $this->email->attach($attachment);
            }
        }

        if ($this->email->send()) {
           // echo $this->email->print_debugger(); die();
            return true;
        } else {
            //echo $this->email->print_debugger(); die();
            return false;
        }
    }

    public function checkPermissions($action = null, $js = null, $module = null)
    {
        if (!$this->actionPermissions($action, $module)) {
            $this->session->set_flashdata('error', lang("access_denied"));
            if ($js) {
                die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : site_url('welcome')) . "'; }, 10);</script>");
            } else {
                redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'welcome');
            }
        }
    }

    public function actionPermissions($action = null, $module = null)
    {
        if ($this->Owner || $this->Admin) {
            if ($this->Admin && stripos($action, 'delete') !== false) {
                return false;
            }
            return true;
        } elseif ($this->Customer || $this->Supplier) {
            return false;
        } else {
            if (!$module) {
                $module = $this->m;
            }
            if (!$action) {
                $action = $this->v;
            }
            //$gp = $this->site->checkPermissions();
            if ($this->GP[$module . '-' . $action] == 1) {
                return true;
            } else {
                return false;
            }
        }
    }

    public function save_barcode($text = null, $bcs = 'code128', $height = 56, $stext = 1, $sq = null)
    {
        $drawText = ($stext != 1) ? false : true;
        $this->load->library('zend');
        $this->zend->load('Zend/Barcode');
        $barcodeOptions = array('text' => $text, 'barHeight' => $height, 'drawText' => $drawText, 'factor' => 1);
        if ($this->Settings->barcode_img) {
            $rendererOptions = array('imageType' => 'jpg', 'horizontalPosition' => 'center', 'verticalPosition' => 'middle');
            $imageResource = Zend_Barcode::draw($bcs, 'image', $barcodeOptions, $rendererOptions);
            ob_start();
            imagepng($imageResource);
            $imagedata = ob_get_contents();
            ob_end_clean();
            return "<img src='data:image/png;base64,".base64_encode($imagedata)."' alt='{$text}' class='bcimg' />";
        } else {
            $rendererOptions = array('renderer' => 'svg', 'horizontalPosition' => 'center', 'verticalPosition' => 'middle');
            // $imageResource = Zend_Barcode::render($bcs, 'svg', $barcodeOptions, $rendererOptions);
            // return $imageResource;
            ob_start();
            Zend_Barcode::render($bcs, 'svg', $barcodeOptions, $rendererOptions);
            $imagedata = ob_get_contents();
            ob_end_clean();
            return "<img src='data:image/svg+xml;base64,".base64_encode($imagedata)."' alt='{$text}' class='bcimg' />";
        }
        return FALSE;
    }

    public function qrcode($type = 'text', $text = 'https://simplypos.in', $size = 2, $level = 'H', $sq = null)
    {
        $file_name = 'assets/uploads/qrcode' . $this->session->userdata('user_id') . ($sq ? $sq : '') . ($this->Settings->barcode_img ? '.png' : '.svg');
        if ($type == 'link') {
            $text = urldecode($text);
        }
        $this->load->library('phpqrcode');
        $config = array('data' => $text, 'size' => $size, 'level' => $level, 'savename' => $file_name);
        if (!$this->Settings->barcode_img) {
            $config['svg'] = 1;
        }
        $this->phpqrcode->generate($config);
        if ($this->Settings->barcode_img) {
            $imagedata = file_get_contents($file_name);
            return "<img src='data:image/png;base64,".base64_encode($imagedata)."' alt='{$text}' class='qrimg' style='float:right;' />";
        }
        $imagedata = file_get_contents($file_name);
        return "<img src='data:image/svg+xml;base64,".base64_encode($imagedata)."' alt='{$text}' class='qrimg' style='float:right;' />";
    }

    public function generate_pdf($content, $name = 'download.pdf', $output_type = null, $footer = null, $margin_bottom = null, $header = null, $margin_top = null, $orientation = 'P')
    {
        if (!$output_type) {
            $output_type = 'D';
        }
        if (!$margin_bottom) {
            $margin_bottom = 10;
        }
        if (!$margin_top) {
            $margin_top = 20;
        }
        $this->load->library('pdf');
        $pdf = new mPDF('utf-8', 'A4-' . $orientation, '13', '', 10, 10, $margin_top, $margin_bottom, 9, 9);
        $pdf->debug = false;
        $pdf->autoScriptToLang = true;
        $pdf->autoLangToFont = true;
        // if you need to add protection to pdf files, please uncomment the line below or modify as you need.
        // $pdf->SetProtection(array('print')); // You pass 2nd arg for user password (open) and 3rd for owner password (edit)
        // $pdf->SetProtection(array('print', 'copy')); // Comment above line and uncomment this to allow copying of content
        $pdf->SetTitle($this->Settings->site_name);
        $pdf->SetAuthor($this->Settings->site_name);
        $pdf->SetCreator($this->Settings->site_name);
        $pdf->SetDisplayMode('fullpage');
        $stylesheet = file_get_contents('assets/bs/bootstrap.min.css');
        $pdf->WriteHTML($stylesheet, 1);
        // $pdf->SetFooter($this->Settings->site_name.'||{PAGENO}/{nbpg}', '', TRUE); // For simple text footer

        if (is_array($content)) {
            $pdf->SetHeader($this->Settings->site_name.'||{PAGENO}/{nbpg}', '', TRUE); // For simple text header
            $as = sizeof($content);
            $r = 1;
            foreach ($content as $page) {
                $pdf->WriteHTML($page['content']);
                if (!empty($page['footer'])) {
                    $pdf->SetHTMLFooter('<p class="text-center">' . $page['footer'] . '</p>', '', true);
                }
                if ($as != $r) {
                    $pdf->AddPage();
                }
                $r++;
            }

        } else {

            $pdf->WriteHTML($content);
            if ($header != '') {
                $pdf->SetHTMLHeader('<p class="text-center">' . $header . '</p>', '', true);
            }
            if ($footer != '') {
                $pdf->SetHTMLFooter('<p class="text-center">' . $footer . '</p>', '', true);
            }

        }

        if ($output_type == 'S') {
            $file_content = $pdf->Output('', 'S');
            write_file('assets/uploads/' . $name, $file_content);
            return 'assets/uploads/' . $name;
        } else {
            $pdf->Output($name, $output_type);
        }
    }

    public function print_arrays()
    {
        $args = func_get_args();
        echo "<pre>";
        foreach ($args as $arg) {
            print_r($arg);
        }
        echo "</pre>";
        die();
    }

    public function logged_in()
    {
        return (bool) $this->session->userdata('identity');
    }

    public function in_group($check_group, $id = false)
    {
        if ( ! $this->logged_in()) {
            return false;
        }
        $id || $id = $this->session->userdata('user_id');
        $group = $this->site->getUserGroup($id);
        if ($group->name === $check_group) {
            return true;
        }
        return false;
    }

    public function log_payment($msg, $val = null)
    {
        $this->load->library('logs');
        return (bool) $this->logs->write('payments', $msg, $val);
    }

    public function update_award_points($total, $customer, $user, $scope = null)
    {
        if (!empty($this->Settings->each_spent) && $total >= $this->Settings->each_spent) {
            $company = $this->site->getCompanyByID($customer);
            $points = floor(($total / $this->Settings->each_spent) * $this->Settings->ca_point);
            $total_points = $scope ? $company->award_points - $points : $company->award_points + $points;
            $this->db->update('companies', array('award_points' => $total_points), array('id' => $customer));
        }
        if (!empty($this->Settings->each_sale) && !$this->Customer && $total >= $this->Settings->each_sale) {
            $staff = $this->site->getUser($user);
            $points = floor(($total / $this->Settings->each_sale) * $this->Settings->sa_point);
            $total_points = $scope ? $staff->award_points - $points : $staff->award_points + $points;
            $this->db->update('users', array('award_points' => $total_points), array('id' => $user));
        }
        return true;
    }

    public function zip($source = null, $destination = "./", $output_name = 'sma', $limit = 5000)
    {
        if (!$destination || trim($destination) == "") {
            $destination = "./";
        }

        $this->_rglobRead($source, $input);
        $maxinput = count($input);
        $splitinto = (($maxinput / $limit) > round($maxinput / $limit, 0)) ? round($maxinput / $limit, 0) + 1 : round($maxinput / $limit, 0);

        for ($i = 0; $i < $splitinto; $i++) {
            $this->_zip(array_slice($input, ($i * $limit), $limit, true), $i, $destination, $output_name);
        }

        unset($input);
        return;
    }

    public function unzip($source, $destination = './')
    {
        // @chmod($destination, 0777);
        $zip = new ZipArchive;
        if ($zip->open(str_replace("//", "/", $source)) === true) {
            $zip->extractTo($destination);
            $zip->close();
        }
        // @chmod($destination,0755);

        return true;
    }

    public function view_rights($check_id, $js = null)
    {
        if (!$this->Owner && !$this->Admin) {
            if ($check_id != $this->session->userdata('user_id')) {
                $this->session->set_flashdata('warning', $this->data['access_denied']);
                if ($js) {
                    die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'welcome') . "'; }, 10);</script>");
                } else {
                    redirect(isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'welcome');
                }
            }
        }
        return true;
    }

    public function makecomma($input)
    {
        if (strlen($input) <= 2) {return $input;}
        $length = substr($input, 0, strlen($input) - 2);
        $formatted_input = $this->makecomma($length) . "," . substr($input, -2);
        return $formatted_input;
    }

    public function formatSAC($num)
    {
        $pos = strpos((string) $num, ".");
        if ($pos === false) {$decimalpart = "00";} else {
            $decimalpart = substr($num, $pos + 1, 2);
            $num = substr($num, 0, $pos);}

        if (strlen($num) > 3 & strlen($num) <= 12) {
            $last3digits = substr($num, -3);
            $numexceptlastdigits = substr($num, 0, -3);
            $formatted = $this->makecomma($numexceptlastdigits);
            $stringtoreturn = $formatted . "," . $last3digits . "." . $decimalpart;
        } elseif (strlen($num) <= 3) {
            $stringtoreturn = $num . "." . $decimalpart;
        } elseif (strlen($num) > 12) {
            $stringtoreturn = number_format($num, 2);
        }

        if (substr($stringtoreturn, 0, 2) == "-,") {$stringtoreturn = "-" . substr($stringtoreturn, 2);}

        return $stringtoreturn;
    }

    public function md($page = FALSE)
    {
    	if($page=='login'){
            $page = base_url('login');
        } 
        die("<script type='text/javascript'>setTimeout(function(){ window.top.location.href = '" . ($page ? $page : (isset($_SERVER["HTTP_REFERER"]) ? $_SERVER["HTTP_REFERER"] : 'welcome')) . "'; }, 10);</script>");
    }

    public function analyze_term($term)
    {
        $spos = strpos($term, $this->Settings->barcode_separator);
        if ($spos !== false) {
            $st = explode($this->Settings->barcode_separator, $term);
            $sr = trim($st[0]);
            $option_id = trim($st[1]);
        } else {
            $sr = $term;
            $option_id = false;
        }
        return array('term' => $sr, 'option_id' => $option_id);
    }

    public function paid_opts($paid_by = null, $purchase = false)
    {
        $opts = '
        <option value="cash"'.($paid_by && $paid_by == 'cash' ? ' selected="selected"' : '').'>'.lang("cash").'</option>
        <option value="gift_card"'.($paid_by && $paid_by == 'gift_card' ? ' selected="selected"' : '').'>'.lang("gift_card").'</option>
        <option value="CC"'.($paid_by && $paid_by == 'CC' ? ' selected="selected"' : '').'>'.lang("CC").'</option>
        <option value="DC"'.($paid_by && $paid_by == 'DC' ? ' selected="selected"' : '').'>'.lang("dc").'</option>
        <option value="Cheque"'.($paid_by && $paid_by == 'Cheque' ? ' selected="selected"' : '').'>'.lang("cheque").'</option>
        <option value="other"'.($paid_by && $paid_by == 'other' ? ' selected="selected"' : '').'>'.lang("other").'</option> 
        <option value="NEFT"'.($paid_by && $paid_by == 'NEFT' ? ' selected="selected"' : '').'>'.lang("NEFT").'</option>
        <option value="PAYTM"'.($paid_by && $paid_by == 'PAYTM' ? ' selected="selected"' : '').'>'.lang("PAYTM").'</option>
        <option value="Googlepay"'.($paid_by && $paid_by == 'Googlepay' ? ' selected="selected"' : '').'>'.lang("Google pay").'</option>
        <option value="complimentry"'.($paid_by && $paid_by == 'complimentry' ? ' selected="selected"' : '').'>'.lang("complimentry").'</option>
        <option value="swiggy"'.($paid_by && $paid_by == 'swiggy' ? ' selected="selected"' : '').'>'.lang("swiggy").'</option>
        <option value="zomato"'.($paid_by && $paid_by == 'zomato' ? ' selected="selected"' : '').'>'.lang("zomato").'</option>
        <option value="ubereats"'.($paid_by && $paid_by == 'ubereats' ? ' selected="selected"' : '').'>'.lang("ubereats").'</option>
        
        ';
       

       
        if (!$purchase) {
            $opts .= '<option value="deposit"'.($paid_by && $paid_by == 'deposit' ? ' selected="selected"' : '').'>'.lang("deposit").'</option>';
        }
        return $opts;
    }

    public function send_json($data)
    {
        header('Content-Type: application/json');
        die(json_encode($data));
        exit;
    }

     public function pos_error_log(array $logger){
            $date = new DateTime();
            $error_time = $date->format('U = Y-m-d H:i:s');
            $data = array(
                    "action" => "setLog",
                    "error_url" => $logger[1],
                    "pos_url" => base_url(),
                    "error_message" => $logger[0]
            );
            $surl = 'https://simplypos.in/posadmin/pos_error_log.php';
           // $this->post_to_url($surl, $data);
    } 
            
    public function post_to_url($url, $data) {
        $fields = '';
        foreach ($data as $key => $value) {
            $fields .= $key . '=' . $value . '&';
        }
       // rtrim($fields, '&');
       $fields = rtrim($fields,'&');
        $post = curl_init();
        curl_setopt($post, CURLOPT_URL, $url);
        curl_setopt($post, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($post, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($post, CURLOPT_SSL_VERIFYPEER, 0);
        curl_setopt($post, CURLOPT_ENCODING, "");
        curl_setopt($post, CURLOPT_POST, count($data));
        curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
        $result = curl_exec($post);
        curl_close($post);
        return $result;
    }
	
      
    public function UPBillTable($printer,$inv,$return_sale,$rows,$return_rows,$class=null,$print=NULL){        
           
        $itemTaxes       =   isset($inv->rows_tax)?$inv->rows_tax:array();
        $column_id_str   =   isset($printer->column_id_str) && !empty($printer->column_id_str)?$printer->column_id_str:'';
        $column_name_str =   isset($printer->column_name_str) && !empty($printer->column_name_str)?$printer->column_name_str:'';
        $data            =   isset($printer->data) && !empty($printer->data)?$printer->data:'';
        $optionDetails   =   isset($printer->optionDetails) && !empty($printer->optionDetails)?$printer->optionDetails:'';
   
      
        if(empty($column_id_str) || empty($column_name_str) || empty($data) ):
            return false;
        endif;
        
        $crop_product_name = $printer->crop_product_name;
        $show_sr_no = $printer->show_sr_no;
        $column_id_arr = explode(',', $column_id_str);
        $column_name_arr = explode(',', $column_name_str);
        $data_arr = explode(',', $data);

        $table_header ='';
        if(count($column_id_arr) !=  count($column_name_arr) || count($column_id_arr) !=  count($data_arr)):
                return false;
        endif;
        $column_cnt = count($column_id_arr);
        $column_cnt =  ($show_sr_no==1)?$column_cnt+1:$column_cnt;
        $total_column_offset = $column_cnt-1;
        
        /*------------------------------------------------HEADER--------------------------------------  */
        $sr_th =  ($show_sr_no==1)?'<th class="">Sr.No</th>':'';
        foreach ($column_name_arr as $column_key =>$column_name):
            if(!empty($column_name)):
                $table_header = $table_header.'<th class="'.$data_arr[$column_key].'">'.$column_name.'</th>';
            endif;
        endforeach;
        $tableHeader = '<thead><tr>'.$sr_th.$table_header.'</tr></thead>';
        
        $mrp_total = $qty_total = $discount_total = $tax_total =  $net_total = $unit_total = 0;
        $item_arr  = $item_return_arr = '';
        /*------------------------------------------------HEADER End--------------------------------------  */
        
         /*------------------------------------------------Table Body --------------------------------------  */
        $table_body ='';
        $sr = $r = 0;
        $taxAttr =  $taxAttrName = array();
            
        foreach ($rows as $row) {
            
                $sr++;
                    $table_body = $table_body.'<tr>';
                    $sr_td =  ($show_sr_no==1)?'<td class="">'.$sr .'</td>':'';
                    $table_body = $table_body.$sr_td;
                    $i =0;
                    foreach($data_arr as $data):

                        $id = $column_id_arr[$i];
                        $obj = $optionDetails[$id];

                        if($i==0):
                            $append_product_name = '';
                                               
                            if($printer->append_product_code_in_name && !empty($row->product_code)):
                               $append_product_name .= '<br/>Code: '.$row->product_code;  
                            endif;
                            
                            $prod_name = ($crop_product_name==1) ? character_limiter($row->$data,20) : $row->$data;
                            $res =  strtolower( $prod_name.$append_product_name );
                            
                            //Show/Hide Combo Product Items
                            if(isset($row->combo_items[0]) && !empty($row->combo_items[0])){
                                if($printer->show_combo_products_list) {
                                    $res .= " + (" ;
                                    foreach($row->combo_items as $comk=>$comv){
                                        $res .= $comv->name." Qty.".(int)$comv->qty."  , ";
                                    }
                                    $res = trim($res,", ");
                                    $res .= ")" ;
                                }//end if.
                            }
                            
                            //Show/Hide Invoice Product Image
                            if($printer->show_product_image == 1) {
                                $itemImage = 'assets/uploads/thumbs/'.$row->image;
                                $image_size = ($printer->product_image_size != '') ? $printer->product_image_size : 'width:40px;height:40px;';
                                if(file_exists($itemImage)){
                                   $imgTag = '<img src="'.base_url($itemImage).'" style="'.$image_size.'margin-right:5px;" alt="'.$row->image.'" align="left" /> '; 
                                } else {
                                   $imgTag = '<img src="'.base_url('assets/uploads/thumbs/no_image.png').'" style="'.$image_size.'margin-right:5px;" align="left" alt="no_image" /> '; 
                                }
                            } else {
                               $imgTag = ''; 
                            }
                            $table_body = $table_body . '<td style="text-transform: capitalize;">'.$imgTag . $res.'</td>';
                            
                        elseif($data=='unit_price'):
                           $table_body=$table_body.'<td >'.$this->custom_format($row->unit_price,$obj->format).'</td>';
                        elseif($data=='real_unit_price'):
                           $table_body=$table_body.'<td >'.$this->custom_format($row->real_unit_price,$obj->format).'</td>';


                        elseif(!empty($obj->formula) && strpos($data, '|')):
                            $_data_arr = explode('|',$data);
                            $f_arr = explode('|',$obj->formula);
                            $f1_arr = explode('|',$obj->format);
                            $k=0;
                            $res = '';
                            foreach ($_data_arr as $_key => $_data) {

                                $unit_total = ($_data=='unit_price' && !empty($row->$_data))?$unit_total+$row->$_data : $unit_total;
                              $res =  $res.$this->custom_format($row->$_data,$f1_arr[$_key]).' '.$f_arr[$k];
                            }
                            $res = substr($res, 0,-1);
                            $table_body=$table_body.'<td>'.$res.'</td>';
                        else :

                           $class = ( in_array($data,array('mrp','subtotal','unit_quantity' ,'unit_price' ,'real_unit_price' ,'net_unit_price','item_tax' ,'item_discount')))?'text-left':'';	
                           $mrp_total  = ($data=='mrp' && !empty($row->$data))?$mrp_total+$row->$data : $mrp_total;
                           $net_total  = ($data=='real_unit_price' && !empty($row->$data))? $net_total+$row->$data : $net_total;
                           $unit_total = ($data=='unit_price' && !empty($row->$data))?$unit_total+$row->$data : $unit_total;
                           $tax_total  = ($data=='item_tax' && !empty($row->$data))?$tax_total+$row->$data : $tax_total;
                           $discount_total = ($data=='item_discount' && !empty($row->$data))?$discount_total+$row->$data : $discount_total;
                           $qty_total =  ($data=='unit_quantity' && !empty($row->$data))?$qty_total+$row->$data : $qty_total;  
                           
                           if(!empty($obj->format)):
                           	if($data=='real_unit_price'){
                                   $res = $this->custom_format(($row->real_unit_price * $qty_total),$obj->format);
                               }else{
                                   $res = $this->custom_format($row->$data,$obj->format);
                               }
                       	     //$res = $this->custom_format($row->$data,$obj->format);
                       	   else:
                       	   	 $res =  $row->$data ;
                       	   endif;

                       	   switch($data){
                               case 'subtotal':
                               case 'unit_price':
                               case 'net_unit_price':
                                   if(isset($row->combo_items[0]) && !empty($row->combo_items[0])){
                                       $total_combo_item_price = 0;
                                       foreach($row->combo_items as $comk=>$comv){
                                           $total_combo_item_price +=($comv->qty*$comv->unit_price);
                                       }
                                     //  $res = "<del>" .$this->custom_format($total_combo_item_price,$obj->format)."</del><br>".$res ;

                                   }

                               break;
                           }

                           $table_body=$table_body.'<td class="'. $class.'">'.$res.'</td>';
                        endif;

                        $i++;
                    endforeach;
                
                    $table_body = $table_body.'</tr>';
                        $taxConfig = isset($itemTaxes[$row->id])?$itemTaxes[$row->id]:NULL;
	                if (is_array($taxConfig)):
                            
                            if ($print):
                                $table_body = $table_body . $this->taxAttrTblDiv($itemTaxes, $row->id, $total_column_offset);
                            else:
                                //$table_body = $table_body . $this->taxAttrTBL($itemTaxes, $row->id, $total_column_offset);
                                $table_body = $table_body . $this->taxAttrTBLInline($itemTaxes, $row->id, $total_column_offset);
                            endif;
                        endif;
                    $r++;
        }
                if ($return_rows) {
               $table_body =$table_body . '<tr class="warning"><td colspan="'.$column_cnt.'" class="no-border"><strong>'.lang('returned_items').'</strong></td></tr>';
               $sr1 =0;
               foreach ($return_rows as $row) {
               $sr1++;
                   $table_body = $table_body.'<tr>';
                   $sr_td = ($show_sr_no==1)?'<td class="">'.$sr1.'</td>':'';
                   $table_body = $table_body.$sr_td;
                   $i = 0;
            
                    foreach($data_arr as $data):
                  
                       $id  = $column_id_arr[$i];
                       $obj = $optionDetails[$id];

                        if($i==0):
                            $tax_suffix = '';
                            if($printer->append_taxval_in_productname):
                                $row->tax = empty($row->tax)?0:$row->tax;
                                $taxVal = number_format(str_replace('%','',$row->tax), 0);
                                $tax_suffix = ' ('.$taxVal.'%) ';  
                            endif;
                            $res = ($crop_product_name==1)?character_limiter($row->$data,18). $tax_suffix:$row->$data. $tax_suffix;
                            $table_body = $table_body.'<td>'.$res.'</td>';
                            
                        elseif($data=='unit_price'):
                           $table_body=$table_body.'<td >'.$this->custom_format($row->real_unit_price ,$obj->format).'</td>';
    

                        elseif(!empty($obj->formula) && strpos($data, '|')):
                            $_data_arr = explode('|',$data);
                            $f_arr = explode('|',$obj->formula);
                            $f1_arr = explode('|',$obj->format);
                            $k=0;
                            $res = '';
                            foreach ($_data_arr as $_key => $_data) {
                                $unit_total = ($_data=='unit_price' && !empty($row->$_data))?$unit_total+$row->$_data : $unit_total;
                                $res =  $res.$this->custom_format($row->$_data,$f1_arr[$_key]).' '.$f_arr[$k];
                            }
                             $res = substr($res, 0,-1);
                            $table_body=$table_body.'<td>'.$res.'</td>'; 
                        else :
                           $class = ( in_array($data,array('mrp','subtotal','unit_quantity' ,'unit_price','real_unit_price','item_tax' ,'item_discount')))?'text-left':'';	
                       	   $res = $this->custom_format($row->$data,$obj->format);
                           
                           $mrp_total  = ($data=='mrp' && !empty($row->$data))?$mrp_total+$row->$data : $mrp_total;
                           $net_total  = ($data=='real_unit_price' && !empty($row->$data))?$net_total+$row->$data : $net_total;
                           $unit_total = ($data=='unit_price' && !empty($row->$data))?$unit_total+$row->$data : $unit_total;
                               
                           $tax_total  = ($data=='item_tax' && !empty($row->$data))?$tax_total+$row->$data : $tax_total;
                           $discount_total = ($data=='item_discount' && !empty($row->$data))?$discount_total+$row->$data : $discount_total;
                           $qty_total  =  ($data=='unit_quantity' && !empty($row->$data))?$qty_total+$row->$data : $qty_total;  
                           
                           $table_body = $table_body.'<td class="'. $class.'">'.$res.'</td>';
                        endif;

                       $i++;
                   endforeach;
                    $table_body = $table_body.'</tr>';
                    $taxConfig = isset($itemTaxes[$row->id])?$itemTaxes[$row->id]:NULL;
                        if (is_array($taxConfig)):
                            
                            if ($print):
                                $table_body = $table_body . $this->taxAttrTblDiv($itemTaxes, $row->id, $total_column_offset);
                            else:
                                //$table_body = $table_body . $this->taxAttrTBL($itemTaxes, $row->id, $total_column_offset);
                                $table_body = $table_body . $this->taxAttrTBLInline($itemTaxes, $row->id, $total_column_offset);
                            endif;
                        endif;
                   //echo $this->sma->formatMoney($row->net_unit_price + ($row->item_tax / $row->quantity)).' ('.$this->sma->formatMoney($row->net_unit_price).' + '.$this->sma->formatMoney($row->item_tax / $row->quantity) . ')</td><td class="no-border border-bottom text-right">' . $this->sma->formatMoney($row->subtotal) . '</td></tr>';
                   $r++;
               }
           }
        $tableBody = '<tbody>'.$table_body.'</tbody>';
         /*------------------------------------------------Table Body  End--------------------------------------  */
        
        
        
        /*------------------------------------------------Footer--------------------------------------  */
        $footer_row1 =  $footer_row2 =  $footer_row3 =  $footer_row4 =  $footer_row5 =  $footer_row6 =    '';
        $footer_row1_cell1 = ($show_sr_no==1)? 2: 1;
        $footer_row1 = $footer_row1.'<tr> ';
        $i =0;
            
        foreach($data_arr as $data):

           $id = $column_id_arr[$i];
           $obj = $optionDetails[$id];

           if($i==0): 
               $footer_row1=$footer_row1.'<th colspan="'.$footer_row1_cell1.'" >'.lang("total").'</th>';

           elseif(!empty($obj->formula) && strpos($data, '|')):
               $_data_arr = explode('|',$data);
               $f_arr = explode('|',$obj->formula);
               $f1_arr = explode('|',$obj->format);
               $k=0;
                $res = '';
                foreach ($_data_arr as $_key => $_data) {
                               
                    $res = ($_data=='unit_price' && $unit_price !=0)?$unit_price : $res; 
                }
            
                $footer_row1=$footer_row1.'<th>'.$res.'</th>'; 
           else :
               $class = ( in_array($data,array('mrp','subtotal','unit_quantity' ,'unit_price','real_unit_price','item_tax' ,'item_discount')))?'text-left':'';	
                       	   
               switch ($data) {
                    case 'unit_quantity':
                            $footer_row1=$footer_row1.'<th class="'. $class.'">'.$this->formatQuantity($qty_total).'</th>';
                        break;
                    
                    case 'mrp':
                             $footer_row1=$footer_row1.'<th class="'. $class.'">'.$this->formatMoney($mrp_total).'</th>';
                           // $footer_row1=$footer_row1.'<th class="'. $class.'"></th>';
                        break;
                    
                    case 'real_unit_price':
                            $footer_row1=$footer_row1.'<th class="'. $class.'">'.$this->formatMoney($net_total).'</th>';
                           //$footer_row1=$footer_row1.'<th class="'. $class.'"></th>';
                        break;
                    
                    case 'unit_price':
                            $footer_row1=$footer_row1.'<th class="'. $class.'">'.$this->formatMoney($unit_total).'</th>';
                         // $footer_row1=$footer_row1.'<th class="'. $class.'"></th>';
                        break;
                    
                    case 'item_tax':
                            $footer_row1=$footer_row1.'<th class="'. $class.'">'.$this->formatMoney($tax_total).'</th>';
                          // $footer_row1=$footer_row1.'<th class="'. $class.'"></th>';
                        break;
                    
                    case 'item_discount':
                           $footer_row1=$footer_row1.'<th class="'. $class.'">'.$this->formatMoney($discount_total).'</th>';
                           // $footer_row1=$footer_row1.'<th class="'. $class.'"></th>';
                        break;
                    
                    case 'subtotal':
                            $footer_row1=$footer_row1.'<th class="text-left">'.$this->formatMoney($return_sale ? (($inv->total + $inv->product_tax)+($return_sale->total + $return_sale->product_tax)) : ($inv->total + $inv->product_tax)).'</th>';
                        break;
                    
                    default:
                        $footer_row1=$footer_row1.'<th class="'. $class.'"> </th>';
                        break;
               }
                    
           endif;

           $i++;
       endforeach;
        
        $footer_row1 = $footer_row1.' </tr>';
        
         //------------------------Order Tax ---------------------//

        if ($inv->order_tax != 0) {
            $order_tax_label =  !empty($inv->order_tax_label) && ( $inv->order_tax_label !='-') ?  $inv->order_tax_label : lang("Order Level Tax") ;
            $footer_row2 = '<tr><th  colspan="'.$total_column_offset.'">' . $order_tax_label. '</th><th class="text-left">' . $this->formatMoney($return_sale ? ($inv->order_tax+$return_sale->order_tax) : $inv->order_tax) . '</th></tr>';
        }
        //------------------------Order Tax End---------------------//
        
        //------------------------ Order Discount  ---------------------//
        if ($inv->order_discount != 0) {
            $footer_row3 = '<tr><th  colspan="'.$total_column_offset.'">' . lang("order_discount") . '</th><th class="text-left">' . $this->formatMoney($inv->order_discount) . '</th></tr>';
        }
        //------------------------Order Discount End---------------------//
        
        //------------------------Return Surcharge ---------------------//
        if (!empty($return_sale) && $return_sale->surcharge != 0) { 
             $footer_row4 = '<tr><th  colspan="'.$total_column_offset.'">' . lang("order_discount") . '</th><th class="text-left">' . $this->formatMoney($return_sale->surcharge) . '</th></tr>';
        }
        //------------------------Return Surcharge End ---------------------//
         
        //------------------------Shipping Charges---------------------//
        $footer_row5_shipping = '';  
          if($inv->shipping) {
            $footer_row5_shipping ='<tr>'               
                . '<th colspan="'.$total_column_offset.'" >'.lang("Shipping"). '</th>'
                . '<th class="left">'. $this->formatMoney($inv->shipping).'</th>'
                . '</tr>';
            }
        
        //------------------------Grand Total ---------------------//
        if ($inv->rounding): // check Rounding  issue 
            $footer_row5 ='<tr>'
                . '<th colspan="'.$total_column_offset.'" >'.lang("rounding").'</th>'
                . '<th class="text-left">'.$this->formatMoney($inv->rounding).'</th>'
                . '</tr>';
		
            $GTotal =  	$this->formatMoney($return_sale ? (($inv->grand_total + $inv->rounding)+$return_sale->grand_total) : ($inv->grand_total + $inv->rounding));
            $GTotalW =  $this->convert_number_to_words($return_sale ? (($inv->grand_total + $inv->rounding)+$return_sale->grand_total) : ($inv->grand_total + $inv->rounding));
            $GTotalW = !empty($GTotalW)?'<span style="text-transform: uppercase;font-size: smaller;float: right;padding-right: 25px;"> ( '.$GTotalW.' '.$this->currencyLable.' Only ) </span>':'';
            $footer_row5 = $footer_row5_shipping . $footer_row5.'<tr>'
                . '<th colspan="'.$total_column_offset.'" >'.lang("grand_total"). $GTotalW .'</th>'
                . '<th class="left">'.  $GTotal.'</th>'
                . '</tr>';
        else:
          $GTotal =  	 $this->formatMoney($return_sale ? ($inv->grand_total+$return_sale->grand_total) : $inv->grand_total);
          $GTotalW =  	 $this->convert_number_to_words($return_sale ? ($inv->grand_total+$return_sale->grand_total) : $inv->grand_total);
          $GTotalW = !empty($GTotalW)?'<span style="text-transform: uppercase;font-size: smaller;float: right;padding-right: 25px;"> ( '.$GTotalW.' '.$this->currencyLable.' Only ) </span>':'';
          
            $footer_row5 = $footer_row5_shipping .'<tr>'
               
                . '<th colspan="'.$total_column_offset.'" >'.lang("grand_total"). $GTotalW .'</th>'
                . '<th class="left">'. $GTotal.'</th>'
                . '</tr>';
        endif;    
        //------------------------Grand Total End---------------------//
        
        //------------------------Partial Paid---------------------//
        if ($inv->paid < $inv->grand_total) :
            
            $footer_row6 = ' <tr>'
                . '<th colspan="'.$total_column_offset.'" >'.lang("paid_amount").'</th>'
                . '<th class="text-left">'.$this->formatMoney( $return_sale ? ($inv->paid+$return_sale->paid) : $inv->paid).'</th>'
                . '</tr>';
        
            $footer_row6 =$footer_row6.' <tr>'
                . '<th colspan="'.$total_column_offset.'" >'.lang("due_amount").'</th>'
                . '<th class="text-left">'.$this->formatMoney(($return_sale ? (($inv->grand_total + $inv->rounding)+$return_sale->grand_total) : ($inv->grand_total + $inv->rounding)) - ($return_sale ? ($inv->paid+$return_sale->paid) : $inv->paid)).'</th>'
                . '</tr>';
        endif;    
        //------------------------Partial Paid End ---------------------//
        $footer_row7 =  '';
        if(count($taxAttr) > 0){
            foreach ($taxAttr as $_code => $_value) :
                $footer_row7 = $footer_row7 . ' <tr><th colspan="'.$total_column_offset.'" >'.$_code.'</th>'
                . '<th class="text-right">'.$this->formatMoney($_value).'</th></tr>';   
            endforeach;     
        }
                
        $tableFooter = '<tfoot>'.$footer_row1.$footer_row2.$footer_row3.$footer_row4.$footer_row7.$footer_row5.$footer_row6.'</tfoot>';
        /*------------------------------------------------Footer End--------------------------------------  */
        
        
        /*------------------------------------------------Table  --------------------------------------  */
        if(!empty($class)):
                $table = '<table class="table table-bordered table-hover table-striped">'.$tableHeader.$tableBody.$tableFooter.'</table>';
        else:
                $table = '<table class="table table-striped table-condensed">'.$tableHeader.$tableBody.$tableFooter.'</table>';
        endif;
 
        /*------------------------------------------------Table Body  End--------------------------------------  */
        
        return $table;
     }
    
 
    public function posBillTable($printer,$inv,$return_sale,$rows,$return_rows,$class=null,$print=NULL){        
                    
        
        $itemTaxes       =   isset($inv->rows_tax)?$inv->rows_tax:array();
        $column_id_str   =   isset($printer->column_id_str) && !empty($printer->column_id_str)?$printer->column_id_str:'';
        $column_name_str =   isset($printer->column_name_str) && !empty($printer->column_name_str)?$printer->column_name_str:'';
        $data            =   isset($printer->data) && !empty($printer->data)?$printer->data:'';
        $optionDetails   =   isset($printer->optionDetails) && !empty($printer->optionDetails)?$printer->optionDetails:'';
   
      
        if(empty($column_id_str) || empty($column_name_str) || empty($data) ):
            return false;
        endif;
        
        $crop_product_name = $printer->crop_product_name;
        $show_sr_no = $printer->show_sr_no;
        $column_id_arr = explode(',', $column_id_str);
        $column_name_arr = explode(',', $column_name_str);
        $data_arr = explode(',', $data);

        $table_header ='';
        if(count($column_id_arr) !=  count($column_name_arr) || count($column_id_arr) !=  count($data_arr)):
                return false;
        endif;
        $column_cnt = count($column_id_arr);
        $column_cnt =  ($show_sr_no==1)?$column_cnt+1:$column_cnt;
        $total_column_offset = $column_cnt-1;
        
        /*------------------------------------------------HEADER--------------------------------------  */
        $sr_th =  ($show_sr_no==1)?'<th class="">Sr.No</th>':'';
$ColColumn = 0;
        foreach ($column_name_arr as $column_key =>$column_name):
            if(!empty($column_name)):
                $table_header = $table_header.'<th class="'.$data_arr[$column_key].'">'.$column_name.'</th>';
                $ColColumn++;
            endif;
        endforeach;
        $tableHeader = '<thead><tr>'.$sr_th.$table_header.'</tr></thead>';
        
        $mrp_total = $qty_total = $discount_total = $tax_total =  $net_total = $unit_total = $total_net_price = $totalprice = $totalmrp =  0;
        $item_arr  = $item_return_arr = '';
        /*------------------------------------------------HEADER End--------------------------------------  */
        
         /*------------------------------------------------Table Body --------------------------------------  */
        $table_body ='';
        $sr = $r = 0;
        $taxAttr =  $taxAttrName = array();
            $OldCat = '';
        foreach ($rows as $row) {
if($this->pos_settings->display_category==1){
				if($OldCat!=$row->category_id){
					$table_body = $table_body.'<tr><td colspan="'.$ColColumn.'" style="font-weight:bold;">'.$row->category_name.'</td></tr>';
				}
			}
                $VariantPrice = 0;
		if($row->option_id!=0) 
			$VariantPrice = $row->variant_price;
                $sr++;
                    $table_body = $table_body.'<tr>';
                    $sr_td =  ($show_sr_no==1)?'<td class="">'.$sr .'</td>':'';
                    $table_body = $table_body.$sr_td;
                    $i =0;
                    foreach($data_arr as $data):

                        $id = $column_id_arr[$i];
                        $obj = $optionDetails[$id];

                        if($i==0):
                            $append_product_name = '';
                            if($printer->append_taxval_in_productname):
                                $row->tax = empty($row->tax)?0:$row->tax;
                                $taxVal = number_format(str_replace('%','',$row->tax), 0);
                                $append_product_name .= '<br/>Tax: '.$taxVal.'%';  
                            endif;
                            
                            if($printer->append_product_code_in_name && !empty($row->product_code)):
                               $append_product_name .= '<br/>Code: '.$row->product_code;  
                            endif;
                            
                            if($printer->append_hsn_code_in_name && !empty($row->hsn_code)):
                                $append_product_name .= '<br/>HSN: '.$row->hsn_code;  
                            endif;
                            
                            if($printer->append_note_in_name && !empty($row->note)):
                                $append_product_name .= '<br/>Note: '.$row->note;  
                            endif;
                            
                            $prod_name = ($crop_product_name==1) ? character_limiter($row->$data,20) : $row->$data;
                            $res =  strtolower( $prod_name.$append_product_name );
                            
                            //Show/Hide Combo Product Items
                            if(isset($row->combo_items[0]) && !empty($row->combo_items[0])){
                                if($printer->show_combo_products_list) {
                                    $res .= " + (" ;
                                    foreach($row->combo_items as $comk=>$comv){
                                        $res .= $comv->name." Qty.".(int)$comv->qty."  , ";
                                    }
                                    $res = trim($res,", ");
                                    $res .= ")" ;
                                }//end if.
                            }
                            
                            //Show/Hide Invoice Product Image
                            if($printer->show_product_image == 1) {
                                $itemImage = 'assets/uploads/thumbs/'.$row->image;
                                $image_size = ($printer->product_image_size != '') ? $printer->product_image_size : 'width:40px;height:40px;';
                                if(file_exists($itemImage)){
                                   $imgTag = '<img src="'.base_url($itemImage).'" style="'.$image_size.'margin-right:5px;" alt="'.$row->image.'" align="left" /> '; 
                                } else {
                                   $imgTag = '<img src="'.base_url('assets/uploads/thumbs/no_image.png').'" style="'.$image_size.'margin-right:5px;" align="left" alt="no_image" /> '; 
                                }
                            } else {
                               $imgTag = ''; 
                            }
                            $table_body = $table_body . '<td style="text-transform: capitalize;">'.$imgTag . $res.'</td>';
                            
                        elseif($data=='unit_price'):
                           $table_body=$table_body.'<td >'.$this->custom_format($row->unit_price,$obj->format).'</td>';
                        elseif($data=='real_unit_price'):
                           $table_body=$table_body.'<td >'.$this->custom_format(($row->real_unit_price+$VariantPrice),$obj->format).'</td>';


                        elseif(!empty($obj->formula) && strpos($data, '|')):
                            $_data_arr = explode('|',$data);
                            $f_arr = explode('|',$obj->formula);
                            $f1_arr = explode('|',$obj->format);
                            $k=0;
                            $res = '';
                            foreach ($_data_arr as $_key => $_data) {

                                $unit_total = ($_data=='unit_price' && !empty($row->$_data))?$unit_total+$row->$_data : $unit_total;
                              $res =  $res.$this->custom_format($row->$_data,$f1_arr[$_key]).' '.$f_arr[$k];
                            }
                            $res = substr($res, 0,-1);
                            $table_body=$table_body.'<td>'.$res.'</td>';
                        else :

                           $class = ( in_array($data,array('mrp','subtotal','unit_quantity' ,'unit_price' ,'real_unit_price','net_price','invoice_net_unit_price','invoice_total_net_unit_price' ,'net_unit_price','item_tax' ,'item_discount')))?'text-left':'';	
                           $mrp_total  = ($data=='mrp' && !empty($row->$data))?$mrp_total+$row->$data : $mrp_total;
                           $net_total  = ($data=='real_unit_price' && !empty($row->$data))? $net_total+$row->$data : $net_total;
                           $unit_total = ($data=='unit_price' && !empty($row->$data))?$unit_total+$row->$data : $unit_total;
                           $tax_total  = ($data=='item_tax' && !empty($row->$data))?$tax_total+$row->$data : $tax_total;
                           $discount_total = ($data=='item_discount' && !empty($row->$data))?$discount_total+$row->$data : $discount_total;
                           $qty_total =  ($data=='unit_quantity' && !empty($row->$data))?$qty_total+$row->$data : $qty_total;  
                           $total_net_price = ($data=='invoice_total_net_unit_price' && !empty($row->$data))? $total_net_price+$row->$data:$total_net_price   ; 
                           $totalprice = ($data=='invoice_net_unit_price' && !empty($row->$data))? $totalprice+$row->$data:$totalprice;
                           $totalmrp = ($data=='net_price' && !empty($row->$data))? $totalmrp+$row->$data:$totalmrp;
                        
                           if(!empty($obj->format)):
                           	if($data=='real_unit_price'){
                                   $res = $this->custom_format(($row->real_unit_price * $qty_total),$obj->format);
                               }else{
                                   $res = $this->custom_format($row->$data,$obj->format);
                               }
                       	     //$res = $this->custom_format($row->$data,$obj->format);
                       	   else:
                       	   	 $res =  $row->$data ;
                       	   endif;

                       	   switch($data){
                               case 'subtotal':
                               case 'unit_price':
                               case 'net_unit_price':
                                   if(isset($row->combo_items[0]) && !empty($row->combo_items[0])){
                                       $total_combo_item_price = 0;
                                       foreach($row->combo_items as $comk=>$comv){
                                           $total_combo_item_price +=($comv->qty*$comv->unit_price);
                                       }
                                     //  $res = "<del>" .$this->custom_format($total_combo_item_price,$obj->format)."</del><br>".$res ;

                                   }

                               break;
                           }

                           $table_body=$table_body.'<td class="'. $class.'">'.$res.'</td>';
                        endif;

                        $i++;
                    endforeach;
                
                    $table_body = $table_body.'</tr>';
                        $taxConfig = isset($itemTaxes[$row->id])?$itemTaxes[$row->id]:NULL;
	                if (is_array($taxConfig)):
                            
                            if ($print):
                               
                               $table_body = $table_body . $this->taxAttrTblDiv($itemTaxes, $row->id, $total_column_offset);
                            else:
                               // $table_body = $table_body . $this->taxAttrTBL($itemTaxes, $row->id, $total_column_offset);
                               $table_body = $table_body . $this->taxAttrTBLInline($itemTaxes, $row->id, $total_column_offset);
                            endif;
                        endif;
                    $r++;
$OldCat = $row->category_id;
        }
                if ($return_rows) {
               $table_body =$table_body . '<tr class="warning"><td colspan="'.$column_cnt.'" class="no-border"><strong>'.lang('returned_items').'</strong></td></tr>';
               $sr1 =0;
               foreach ($return_rows as $row) {
               $sr1++;
                   $table_body = $table_body.'<tr>';
                   $sr_td = ($show_sr_no==1)?'<td class="">'.$sr1.'</td>':'';
                   $table_body = $table_body.$sr_td;
                   $i = 0;
            
                    foreach($data_arr as $data):
                  
                       $id  = $column_id_arr[$i];
                       $obj = $optionDetails[$id];

                        if($i==0):
                            $tax_suffix = '';
                            if($printer->append_taxval_in_productname):
                                $row->tax = empty($row->tax)?0:$row->tax;
                                $taxVal = number_format(str_replace('%','',$row->tax), 0);
                                $tax_suffix = ' ('.$taxVal.'%) ';  
                            endif;
                            $res = ($crop_product_name==1)?character_limiter($row->$data,18). $tax_suffix:$row->$data. $tax_suffix;
                            $table_body = $table_body.'<td>'.$res.'</td>';
                            
                        elseif($data=='unit_price'):
                           $table_body=$table_body.'<td >'.$this->custom_format($row->real_unit_price ,$obj->format).'</td>';
    

                        elseif(!empty($obj->formula) && strpos($data, '|')):
                            $_data_arr = explode('|',$data);
                            $f_arr = explode('|',$obj->formula);
                            $f1_arr = explode('|',$obj->format);
                            $k=0;
                            $res = '';
                            foreach ($_data_arr as $_key => $_data) {
                                $unit_total = ($_data=='unit_price' && !empty($row->$_data))?$unit_total+$row->$_data : $unit_total;
                                $res =  $res.$this->custom_format($row->$_data,$f1_arr[$_key]).' '.$f_arr[$k];
                            }
                             $res = substr($res, 0,-1);
                            $table_body=$table_body.'<td>'.$res.'</td>'; 
                        else :
                           $class = ( in_array($data,array('mrp','subtotal','unit_quantity' ,'unit_price','real_unit_price','net_price','invoice_net_unit_price','invoice_total_net_unit_price','item_tax' ,'item_discount')))?'text-left':'';	
                       	   $res = $this->custom_format($row->$data,$obj->format);
                           
                           $mrp_total  = ($data=='mrp' && !empty($row->$data))?$mrp_total+$row->$data : $mrp_total;
                           $net_total  = ($data=='real_unit_price' && !empty($row->$data))?$net_total+$row->$data : $net_total;
                           $unit_total = ($data=='unit_price' && !empty($row->$data))?$unit_total+$row->$data : $unit_total;
                               
                           $tax_total  = ($data=='item_tax' && !empty($row->$data))?$tax_total+$row->$data : $tax_total;
                           $discount_total = ($data=='item_discount' && !empty($row->$data))?$discount_total+$row->$data : $discount_total;
                           $qty_total  =  ($data=='unit_quantity' && !empty($row->$data))?$qty_total+$row->$data : $qty_total;  
                           $total_net_price = ($data=='invoice_total_net_unit_price' && !empty($row->$data))? $total_net_price+$row->$data:$total_net_price   ;
                           
                           $totalprice = ($data=='invoice_net_unit_price' && !empty($row->$data))? $totalprice+$row->$data:$totalprice;
                           $totalmrp = ($data=='net_price' && !empty($row->$data))? $totalmrp+$row->$data:$totalmrp;
                        
                           $table_body = $table_body.'<td class="'. $class.'">'.$res.'</td>';
                        endif;

                       $i++;
                   endforeach;
                    $table_body = $table_body.'</tr>';
                    $taxConfig = isset($itemTaxes[$row->id])?$itemTaxes[$row->id]:NULL;
                        if (is_array($taxConfig)):
                            
                            if ($print):
                                $table_body = $table_body . $this->taxAttrTblDiv($itemTaxes, $row->id, $total_column_offset);
                            else:
                               //$table_body = $table_body . $this->taxAttrTBL($itemTaxes, $row->id, $total_column_offset);
                                $table_body = $table_body . $this->taxAttrTBLInline($itemTaxes, $row->id, $total_column_offset);
                            endif;
                        endif;
                   //echo $this->sma->formatMoney($row->net_unit_price + ($row->item_tax / $row->quantity)).' ('.$this->sma->formatMoney($row->net_unit_price).' + '.$this->sma->formatMoney($row->item_tax / $row->quantity) . ')</td><td class="no-border border-bottom text-right">' . $this->sma->formatMoney($row->subtotal) . '</td></tr>';
                   $r++;
               }
           }
        $tableBody = '<tbody>'.$table_body.'</tbody>';
         /*------------------------------------------------Table Body  End--------------------------------------  */
        
        
        
        /*------------------------------------------------Footer--------------------------------------  */
        $footer_row1 =  $footer_row2 =  $footer_row3 =  $footer_row4 =  $footer_row5 =  $footer_row6 =    '';
        $footer_row1_cell1 =  ($show_sr_no==1)?2:1;
        $footer_row1 = $footer_row1.'<tr> ';
        $i =0;
            
        foreach($data_arr as $data):

           $id = $column_id_arr[$i];
           $obj = $optionDetails[$id];

           if($i==0): 
               $footer_row1=$footer_row1.'<th colspan="'.$footer_row1_cell1.'" >'.lang("total").'</th>';

           elseif(!empty($obj->formula) && strpos($data, '|')):
               $_data_arr = explode('|',$data);
               $f_arr = explode('|',$obj->formula);
               $f1_arr = explode('|',$obj->format);
               $k=0;
                $res = '';
                foreach ($_data_arr as $_key => $_data) {
                               
                    $res = ($_data=='unit_price' && $unit_price !=0)?$unit_price : $res; 
                }
            
                $footer_row1=$footer_row1.'<th>'.$res.'</th>'; 
           else :
               $class = ( in_array($data,array('mrp','subtotal','unit_quantity' ,'unit_price','real_unit_price','net_price','invoice_net_unit_price','invoice_total_net_unit_price','item_tax' ,'item_discount')))?'text-left':'';	
                       	   
               switch ($data) {
                    case 'unit_quantity':
                            $footer_row1=$footer_row1.'<th class="'. $class.'">'.$this->formatQuantity($qty_total).'</th>';
                        break;
                    
                    case 'mrp':
                          $footer_row1=$footer_row1.'<th class="'. $class.'">'.$this->formatMoney($mrp_total).'</th>';
                           //$footer_row1=$footer_row1.'<th class="'. $class.'"></th>';
                        break;
                    
                    case 'real_unit_price':
                          //  $footer_row1=$footer_row1.'<th class="'. $class.'">'.$this->formatMoney($net_total).'</th>';
                           $footer_row1=$footer_row1.'<th class="'. $class.'"></th>';
                        break;
                      
                    

                    case 'unit_price':
                         //   $footer_row1=$footer_row1.'<th class="'. $class.'">'.$this->formatMoney($unit_total).'</th>';
                          $footer_row1=$footer_row1.'<th class="'. $class.'"></th>';
                        break;
                    case 'invoice_total_net_unit_price':
                        
                           $footer_row1=$footer_row1.'<th class="'. $class.'">'.$this->formatMoney($total_net_price).'</th>';
                        break; 
                    case 'invoice_net_unit_price':
                           $footer_row1=$footer_row1.'<th class="'. $class.'">'.$this->formatMoney($totalprice).'</th>';
                        break;
                    
                    case 'net_price':
                        $footer_row1=$footer_row1.'<th class="'. $class.'">'.$this->formatMoney($totalmrp).'</th>';
                        break;


                    case 'item_tax':
                            $footer_row1=$footer_row1.'<th class="'. $class.'">'.$this->formatMoney($tax_total).'</th>';
                          // $footer_row1=$footer_row1.'<th class="'. $class.'"></th>';
                        break;
                    
                    case 'item_discount':
                           $footer_row1=$footer_row1.'<th class="'. $class.'">'.$this->formatMoney($discount_total).'</th>';
                           // $footer_row1=$footer_row1.'<th class="'. $class.'"></th>';
                        break;
                    
                    case 'subtotal':
                            $footer_row1=$footer_row1.'<th class="text-left">'.$this->formatMoney($return_sale ? (($inv->total + $inv->product_tax)+($return_sale->total + $return_sale->product_tax)) : ($inv->total + $inv->product_tax)).'</th>';
                        break;
                    
                    default:
                        $footer_row1=$footer_row1.'<th class="'. $class.'"> </th>';
                        break;
               }
                    
           endif;

           $i++;
       endforeach;
        
        $footer_row1 = $footer_row1.' </tr>';
        
         //------------------------Order Tax ---------------------//

        if ($inv->order_tax != 0) {
                $order_tax_label =  !empty($inv->order_tax_label) && ( $inv->order_tax_label !='-') ?  $inv->order_tax_label : lang("tax") ;
            $footer_row2 = '<tr><th  colspan="'.$total_column_offset.'">'   .  $order_tax_label. '</th><th class="text-right">' . $this->formatMoney($return_sale ? ($inv->order_tax+$return_sale->order_tax) : $inv->order_tax) . '</th></tr>';
        }
        //------------------------Order Tax End---------------------//
        
        //------------------------ Order Discount  ---------------------//
        if ($inv->order_discount != 0) {
            $footer_row3 = '<tr><th  colspan="'.$total_column_offset.'">' . lang("order_discount") . '</th><th class="text-left">' . $this->formatMoney($inv->order_discount) . '</th></tr>';
        }
        //------------------------Order Discount End---------------------//
        
        //------------------------Return Surcharge ---------------------//
        if (!empty($return_sale) && $return_sale->surcharge != 0) { 
             $footer_row4 = '<tr><th  colspan="'.$total_column_offset.'">' . lang("order_discount") . '</th><th class="text-left">' . $this->formatMoney($return_sale->surcharge) . '</th></tr>';
        }
        //------------------------Return Surcharge End ---------------------//
         
        //------------------------Shipping Charges---------------------//
        $footer_row5_shipping = '';  
          if($inv->shipping && $inv->eshop_sale) {
            $footer_row5_shipping ='<tr>'               
                . '<th colspan="'.$total_column_offset.'" >'.lang("Shipping"). '</th>'
                . '<th class="left">'. $this->formatMoney($inv->shipping).'</th>'
                . '</tr>';
            }
        
        //------------------------Grand Total ---------------------//
        if ($inv->rounding): // check Rounding  issue 
            $footer_row5 ='<tr>'
                . '<th colspan="'.$total_column_offset.'" >'.lang("rounding").'</th>'
                . '<th class="text-left">'.$this->formatMoney($inv->rounding).'</th>'
                . '</tr>';
        
            $GTotal =  	$this->formatMoney($return_sale ? (($inv->grand_total + $inv->rounding)+$return_sale->grand_total) : ($inv->grand_total + $inv->rounding));
            $GTotalW =  $this->convert_number_to_words($return_sale ? (($inv->grand_total + $inv->rounding)+$return_sale->grand_total) : ($inv->grand_total + $inv->rounding));
            $GTotalW = !empty($GTotalW)?'<span style="text-transform: uppercase;font-size: smaller;float: right;padding-right: 25px;"> ( '.$GTotalW.' '.$this->currencyLable.' Only ) </span>':'';
            $footer_row5 = $footer_row5_shipping . $footer_row5.'<tr>'
                . '<th colspan="'.$total_column_offset.'" >'.lang("grand_total"). $GTotalW .'</th>'
                . '<th class="left">'.  $GTotal.'</th>'
                . '</tr>';
        else:
          $GTotal =  	 $this->formatMoney($return_sale ? ($inv->grand_total+$return_sale->grand_total) : $inv->grand_total);
          $GTotalW =  	 $this->convert_number_to_words($return_sale ? ($inv->grand_total+$return_sale->grand_total) : $inv->grand_total);
          $GTotalW = !empty($GTotalW)?'<span style="text-transform: uppercase;font-size: smaller;float: right;padding-right: 25px;"> ( '.$GTotalW.' '.$this->currencyLable.' Only ) </span>':'';
          
            $footer_row5 = $footer_row5_shipping .'<tr>'
               
                . '<th colspan="'.$total_column_offset.'" >'.lang("grand_total"). $GTotalW .'</th>'
                . '<th class="left">'. $GTotal.'</th>'
                . '</tr>';
        endif;    
        //------------------------Grand Total End---------------------//
        
        //------------------------Partial Paid---------------------//
        if ($inv->paid < $inv->grand_total) :
            
            $footer_row6 = ' <tr>'
                . '<th colspan="'.$total_column_offset.'" >'.lang("paid_amount").'</th>'
                . '<th class="text-left">'.$this->formatMoney( $return_sale ? ($inv->paid+$return_sale->paid) : $inv->paid).'</th>'
                . '</tr>';
        
            $footer_row6 =$footer_row6.' <tr>'
                . '<th colspan="'.$total_column_offset.'" >'.lang("due_amount").'</th>'
                . '<th class="text-left">'.$this->formatMoney(($return_sale ? (($inv->grand_total + $inv->rounding)+$return_sale->grand_total) : ($inv->grand_total + $inv->rounding)) - ($return_sale ? ($inv->paid+$return_sale->paid) : $inv->paid)).'</th>'
                . '</tr>';
        endif;    
        //------------------------Partial Paid End ---------------------//
        $footer_row7 =  '';
        if(count($taxAttr) > 0){
            foreach ($taxAttr as $_code => $_value) :
                $footer_row7 =   $footer_row7 . ' <tr><th colspan="'.$total_column_offset.'" >'.$_code .'</th>'
                    . '<th  class="text-right">'.$this->formatMoney($_value).'</th></tr>';   
            endforeach;     
        }
                
        $tableFooter = '<tfoot>'.$footer_row1.$footer_row2.$footer_row3.$footer_row4.$footer_row7.$footer_row5.$footer_row6.'</tfoot>';
        /*------------------------------------------------Footer End--------------------------------------  */
        
        
        
        /*------------------------------------------------Table  --------------------------------------  */
        if(!empty($class)):
        	$table = '<table class="table table-bordered table-hover table-striped">'.$tableHeader.$tableBody.$tableFooter.'</table>';
        else:
               $table = '<table class="table table-striped table-condensed">'.$tableHeader.$tableBody.$tableFooter.'</table>';
        endif;
 
        /*------------------------------------------------Table Body  End--------------------------------------  */
        
        return $table;
     }
     
    public function custom_format($val,$format){
         switch ($format) {
            case 'formatMoney':
                return $this->formatMoney($val);
               
                 break;
                 
            case 'formatQuantity':
                    return $this->formatQuantity($val);

                 break;
             
             default:
                 break;
         } 
     }
  	  
    public function convert_number_to_words($number) {
   $number=  $this->formatNumber($number);
  $number= str_replace(",",'',$number);
     	if(class_exists ('NumberFormatter')):
    	  $f = new \NumberFormatter("en", NumberFormatter::SPELLOUT);
	  return  $f->format($number);
	endif;    
    }
     
    public function getSmsDltTeIdByTemplateKey($sms_template_key) {

        $q = $this->db->select('dlt_te_id, client_dlt_te_id')->where(['template_key'=>$sms_template_key, 'is_active'=>1])->get('sms_configs');
            
        if ($q->num_rows() > 0) {
            $row = $q->result_array();
            $dlt_te_id = $row[0]['client_dlt_te_id'] != '' ? $row[0]['client_dlt_te_id'] : $row[0]['dlt_te_id'];            
            return $dlt_te_id;
        }
        return FALSE;
    }

    public function SendSMS($mobile, $msg, $sms_template_key) {
        
        if(!$sms_template_key){
            return '{"status":"error", "message":"SMS Template Key is empty."}';
        } else {
           $DLT_TE_ID = $this->getSmsDltTeIdByTemplateKey($sms_template_key);
           if($DLT_TE_ID==FALSE){
               return '{"status":"error", "message":"SMS DLT_TE_ID not found for themplate key '.$sms_template_key.'"}';
           }
        }
        
        $smsAPI = $this->configData->config['smsAPI'];
        $datasms = "?authkey=" . $this->configData->config['authkey'];
        $datasms .= "&route=" . $this->configData->config['route'];
        $datasms .= "&response=" . $this->configData->config['response'];
        $datasms .= "&country=" . $this->configData->config['country'];
        $sender = empty($this->Settings->sms_sender) ? $this->configData->config['sender'] : $this->Settings->sms_sender;
        $datasms .= "&sender=" . $sender;
        $datasms .= "&message=" . urlencode($msg);
        $datasms .= "&mobiles=" . $mobile;
        $datasms .= "&unicode=0";
        $datasms .= "&campaign=" . $sender;
        $datasms .= "&DLT_TE_ID=" . $DLT_TE_ID;

        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL => $smsAPI . $datasms,
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_SSL_VERIFYHOST => 0,
            CURLOPT_SSL_VERIFYPEER => 0,
            CURLOPT_ENCODING => "",
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_ENCODING => "",
            CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
            CURLOPT_CUSTOMREQUEST => "GET",
        ));

        $response = curl_exec($curl);
        $err = curl_error($curl);

        curl_close($curl);

        if ($err) {
            return '{"status":"error", "message":"' . $err . '"}';
        } else {
            return $response;
        }
    }
    
    public function BalanceSMS(){
        $datasms = array(
            "mphone" => $this->_merchant_phone,
            'apikey'=>$this->apiKey,
            'action'=>'BalanceSms',
        );
        $surlsms = $this->pos_api_url.'/sms-request.php';
        $res =  $this->post_to_url($surlsms,$datasms);

        $smsBalance = '';
        if(!empty($res)):
            $Obj = json_decode($res);
            if(isset($Obj->status) && $Obj->status=='success' && $Obj->sms_count > 0):
             $smsBalance = (int)$Obj->sms_count;
            endif;
        endif;
        
        return  $smsBalance; 
    } 
    
    public function update_sms_count($smscount=1){
        $datasms = array(
            'mphone'=>$this->_merchant_phone,
            'apikey'=>$this->apiKey,
            'action'=>'UpdateBalanceSms',
            'smscount'=>$smscount
        );
        $surlsms = $this->pos_api_url.'/sms-request.php';
        $res     = $this->post_to_url($surlsms, $datasms);
        
        return json_decode($res);  
    } 
     
    public function SmsCron($pos_sms_cron, $get = null, $pos_sms_cron_type = NULL) {
        $datasms = array(
            "mphone" => $this->_merchant_phone,
            'apikey' => $this->apiKey,
            'action' => 'SmsCron',
            'pos_sms_cron' => (int) $pos_sms_cron,
            'pos_sms_cron_type' => (int) $pos_sms_cron_type,
        );

        if (!empty($get)):
            $datasms['fetch_data'] = '1';
        endif;

        $surlsms = $this->pos_api_url.'/sms-request.php';
        $res = $this->post_to_url($surlsms, $datasms);

        $return = false;
        if (!empty($res)):
            $Obj = json_decode($res);
            if (isset($Obj->status) && $Obj->status == 'success'):
                $return = $Obj;
            endif;
        endif;
        return $return;
    } 
    
    public  function SMSList($offset,$limit,$past=3) {
        
        $datasms = array(
            "mphone" => $this->_merchant_phone,
            'apikey'=>$this->apiKey,
            'action'=>'smsLog',
            'past'=>$past,
            'limit'=>(int)$limit,
            'offset'=>$offset
        ); 
        $surlsms = $this->pos_api_url.'/sms-request.php';
        $res =  $this->post_to_url($surlsms,$datasms);
            
        return $res;
     }
    
    public function setSMSLog($mobile,$msg, $smsid='') {
        
        $datasms = array(
            'mphone'=> $this->_merchant_phone,
            'apikey' => $this->apiKey,
            'action' => 'LogSMS',
            'r_phone'=> $mobile,
            'note'   => $msg,
            'sms_id' => $smsid,
            'sms_count_used'=>'1',
        );
            
        $surlsms = $this->pos_api_url.'/sms-request.php';
        $res     = $this->post_to_url($surlsms,$datasms);
            
        return $res;
    }
    
    public  function PackageInfo(){
   	    $ci = get_instance();
	    $config = $ci->config;
	    $_merchant_phone = isset($config->config['merchant_phone'])?$config->config['merchant_phone']:'';
	            
	    $datasms = array(
	        "phone" => $_merchant_phone,
	        'apikey'=>$this->apiKey,
	        'action'=>'merchantInfo',
	    );
	    $surlsms = $this->pos_api_url.'/merchantInfo.php';
	    $res =  $this->post_to_url($surlsms,$datasms);
	    
	    $data['package_info'] ='';
	    if(!empty($res)):
	        $Obj = json_decode($res);
	    
	        if(isset($Obj->status) && $Obj->status=='success' && $Obj->msg->phone== $_merchant_phone):
	       return  (array) $Obj->msg;
	          
	        endif;
	    endif;
	    
	    return  false;
    }
    
    public function SyncCustomerData($customer) {
        return true;
    	$arr = array();
	isset($customer->name) && !empty($customer->name)?$arr['name'] =$customer->name:'';
	isset($customer->email) && !empty($customer->email)?$arr['email']= $customer->email:'';
	isset($customer->address) && !empty($customer->address)?$arr['address']= $customer->address:'';
	isset($customer->gender) && !empty($customer->gender)?$arr['gender']= $customer->gender:'';
	isset($customer->city) && !empty($customer->city)?$arr['city']= $customer->city:'';
	isset($customer->dob) && !empty($customer->dob) && $customer->dob!='0000-00-00'?$arr['dob']= $customer->dob:'';
	isset($customer->anniversary) && !empty($customer->anniversary) && $customer->anniversary!='0000-00-00'?$arr['anniversary']= $customer->anniversary:'';
	isset($customer->dob_child1) && !empty($customer->dob_child1) && $customer->dob_child1!='0000-00-00'?$arr['older_child_dob']= $customer->dob_child1:'';
	isset($customer->dob_child2) && !empty($customer->dob_child2) && $customer->dob_child2!='0000-00-00'?$arr['younger_child_dob']=$customer->dob_child2:'';
	isset($customer->dob_mother) && !empty($customer->dob_mother) && $customer->dob_mother!='0000-00-00'?$arr['mother_dob']= $customer->dob_mother:'';
	isset($customer->dob_father) && !empty($customer->dob_father) && $customer->dob_father!='0000-00-00'?$arr['father_dob']= $customer->dob_father:'';
	if(count($arr)==0):
            return false;
        endif;
        
        $ci = get_instance();
        $config = $ci->config;
        $_merchant_phone = isset($config->config['merchant_phone']) ? $config->config['merchant_phone'] : '';
        $arr['merchant_phone'] = $_merchant_phone;

	    $curl = curl_init();
	    curl_setopt_array($curl, array(
	        CURLOPT_URL => "http://simplypos.co.in/api/v1/pos/merchant/update/customer/".$customer->phone,
	        CURLOPT_RETURNTRANSFER => true,
	        CURLOPT_ENCODING => "",
	        CURLOPT_MAXREDIRS => 10,
	        CURLOPT_TIMEOUT => 30,
	        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	        CURLOPT_CUSTOMREQUEST => "POST",
	        CURLOPT_POSTFIELDS => json_encode($arr),
	        CURLOPT_HTTPHEADER => array(
	            "content-type: application/json",
	        ),
	    ));
	    $response = curl_exec($curl);
	    
	      $this->load->library('logs');
            // $this->logs->write('customer_sync', json_encode($arr), $val);
            // $this->logs->write('customer_sync', $response, $val);
	    $err = curl_error($curl);
	    curl_close($curl);
	    if (!$err) {
	        if(!empty($response)):
	            $ResObj = json_decode($response);
	            if(isset($ResObj->type) && $ResObj->type=='success'):
	                 $this->db->update('companies', array('is_synced' =>1), array('id' => $customer->id));
	            endif;
	        endif;
	    }
	    return false;
  }
    
    function saveBillerLocation($biller){
    
    	    $ci = get_instance();
	    $config = $ci->config;
	    $_merchant_phone = isset($config->config['merchant_phone'])?$config->config['merchant_phone']:'';
	            
	    $data = array(
	        "phone" => $_merchant_phone,
	        'apikey'=>$this->apiKey,
	        'action'=>'saveBillerLocation',
	    );
	    
	$data['lat'] = isset($biller->lat)?$biller->lat:'';
	$data['lng'] = isset($biller->lng)?$biller->lng:'';
	if($data['lat']=='' || $data['lng']==''):
	  return false;
	endif;

	$data['id'] = isset($biller->id)?$biller->id:'';
	$data['name'] = isset($biller->name)?$biller->name:'';
	$data['company'] = isset($biller->company)?$biller->company:'';
	$data['address'] = isset($biller->address)?$biller->address:'';
	$data['city'] = isset($biller->city)?$biller->city:'';
	$data['state'] = isset($biller->state)?$biller->state:'';
	$data['postal_code'] = isset($biller->postal_code)?$biller->postal_code:'';
	$data['b_phone'] = isset($biller->phone)?$biller->phone:'';
	$data['email'] = isset($biller->email)?$biller->email:'';            
	    
        $data['logo'] = isset($biller->logo) && !empty($biller->logo)?base_url('assets/uploads/logos/' . $biller->logo):'';            

	    $surlsms = $this->pos_api_url.'/merchantInfo.php';
	    $res =  $this->post_to_url($surlsms,$data);
	    
	    $data['package_info'] ='';
	    if(!empty($res)):
	        $Obj = json_decode($res);
	    
	        if(isset($Obj->status) && $Obj->status=='success' && $Obj->msg->phone== $_merchant_phone):
	       return  (array) $Obj->msg;
	          
	        endif;
	    endif;
	    
	    return  false;
    }
    
    function removeBillerLocation($billerID){
    
    	    $ci = get_instance();
	    $config = $ci->config;
	    $_merchant_phone = isset($config->config['merchant_phone'])?$config->config['merchant_phone']:'';
	            
	    $data = array(
	        "phone" => $_merchant_phone,
	        'apikey'=>$this->apiKey,
	        'action'=>'DeleteBillerLocation',
	    );
	     
	   $data['id'] = isset($billerID)?$billerID:'';      

	    $surlsms = $this->pos_api_url.'/merchantInfo.php';
	    $res =  $this->post_to_url($surlsms,$data);
	    
	    $data['package_info'] ='';
	    if(!empty($res)):
	        $Obj = json_decode($res);
	    
	        if(isset($Obj->status) && $Obj->status=='success' && $Obj->msg->phone== $_merchant_phone):
	       return  (array) $Obj->msg;
	          
	        endif;
	    endif;
	    
	    return  false;
    }
    
    function GroupGrid($group,$g_class_arr){
        $g_cnt = 1;
        if(!is_array($group) || count($group)==0):
               return '<li class="col-xs-12 form-group"><p><i class="fa fa-info-circle" aria-hidden="true"></i> No Contact Group available  </p></li>'    ; 
        endif;
        $table ='';  
            foreach ($group as $key => $groupData) :
                $group_c = $g_class_arr[$g_cnt-1];
                $g_cnt =   ($g_cnt==4)?0:  $g_cnt;

                $table =  $table.'<li class="col-md-4 col-xs-6 form-group"> 
                        <a title=" '.$groupData->group_name.'" class="'.$group_c .' white quick-button small group_button" data-value="'. $groupData->id.'" id="group'. $groupData->id.'" href="javascript:void(this.value);">
                            <i class="fa fa-user"></i>
                            <p class="na_group"> '.$groupData->group_name    .'</p>
                        </a>
                    </li>'    ;
            $g_cnt++;
            endforeach; 
        return $table;
    }
    
    function TemplateList($template,$templateType=1){
        $g_cnt = $_g_cnt = 0; 
        $table ='<ul>';  
        if(!is_array($template) || count($template)==0):
            $_g_cnt++;
             $table =  $table.'<li class="col-xs-12 form-group"><p class="na_template"><i class="fa fa-info-circle" aria-hidden="true"></i> No template available </p></li>'    ; 
        else :
            
            foreach ($template as $key => $templateData) :

                if($templateType != $templateData->template_type):
                    continue;
                endif;
                $g_cnt++;
                  $table =  $table.'<li><a  data-value="'.$templateData->id.'"  data-message="'.$templateData->template_name.'" class="tempalte_type_'.$templateData->template_type.'" id="temp_'.$templateData->id.'" href="javascript:void(0);">'.$templateData->template_name.'</a></li>'    ;
             endforeach; 
            
        endif;
        if($g_cnt==0 && $_g_cnt==0):
             $table =  $table.'<li class="col-xs-12 form-group"><p class="na_template"><i class="fa fa-info-circle" aria-hidden="true"></i> No template available </p></li>'    ; 
        endif;    
            
        $table =  $table.'</ul>'; 
        return $table;
    }
    
    function contact_group_member($member , $selectedMember){
        $tablelist = '';
        foreach ($member as $key => $memberData) :
            $chkOpt = '';
            //if(is_numeric($selectedMember)) {
            if(!empty($selectedMember)){
                $chkOpt = in_array($memberData->id, $selectedMember)?'checked':'';
            }
            if($key == 1){
                $wic = '<li class="col-md-3 col-sm-6   col-xs-12"><label style="color:#000;font-size: 14px;" for="mem_'.$memberData->id.'" ><input type="checkbox" class="mbselect" name="group_mem[]" value="'.$memberData->id.'"  id="mem_'.$memberData->id.'" '.$chkOpt.'> '.ucfirst($memberData->name).'</label></li>'    ;
         
            } else {
                $tablelist =  $tablelist.'<li class="col-md-3 col-sm-6   col-xs-12"><label style="color:#000;font-size: 14px;" for="mem_'.$memberData->id.'" ><input type="checkbox" class="mbselect" name="group_mem[]" value="'.$memberData->id.'"  id="mem_'.$memberData->id.'" '.$chkOpt.'> '.ucfirst($memberData->name).'</label></li>'    ;
        
            }
        endforeach; 
        $table = '<ul id="group_member_list">'. $wic . $tablelist.'</ul>'; 
        return $table;
    }
    
    function contact_member_count($id){
      $cnt = $this->site->getContactGroupMemberCount($id);
      $return =  ((int)$cnt > 0)?$cnt:0;
      return $return;
    }
    
    function smsCharLimit(){
    	return 160;
    }
    
    function conatctTemplateType($type=NULL){
        $templateType = array('1' => 'SMS', '2' => 'Email', '3' => 'Application Message',);
        switch ($type) {
           case 1:
                $templateType = array('1' => 'SMS');
                break;
            case 2:
                $templateType = array('2' => 'Email');
                break;
            case 3:
                $templateType = array('3' => 'Application Message',);
                break; 
        }
        return  $templateType;
    }
    
    function contactEventNotification($param){
        $arr['users']       = isset($param['users']) && is_array($param['users']) ? $param['users']: array()  ;
        $arr['dob']         = isset($param['dob']) && is_array($param['dob']) ? $param['dob']: array()  ;
        $arr['anniversary'] = isset($param['anniversary']) && is_array($param['anniversary']) ? $param['anniversary']: array()  ;
        $arr['dob_father']  = isset($param['dob_father']) && is_array($param['dob_father']) ? $param['dob_father']: array()  ;
        $arr['dob_mother']  = isset($param['dob_mother']) && is_array($param['dob_mother']) ? $param['dob_mother']: array()  ;
        $arr['dob_child1']  = isset($param['dob_child1']) && is_array($param['dob_child1']) ? $param['dob_child1']: array()  ;
        $arr['dob_child2']  = isset($param['dob_child2']) && is_array($param['dob_child2']) ? $param['dob_child2']: array()  ;
         $tableHeader ="<thead><tr>
                         <th width='35%'>Customer</th>
                         <th>B'Day</th> 
                         <th>Anniversary</th> 
                         <th>Father's B'Day</th>
                         <th>Mother's B'Day</th>
                         <th>Older Child's B'Day</th>
                         <th>Younger Child's B'Day</th>
                     </tr></thead>";
        $tableB = '';
        $Y = '<i class="fa fa-check-square-o"></i>';
        $N = '<i class="fa fa-close"></i>';
        if(count($arr['users'])==0):
            $tableB ="<tr>
                         <td colspan='7'>No Notification Found</td> 
                     </tr>";
        else:
            foreach ($arr['users'] as $userData) {
                $userID = isset($userData['id'])?$userData['id']:'0';
                $userName = isset($userData['name'])?$userData['name']:'-';
                $userEmail = isset($userData['email'])?$userData['email']:'-';
                $userPhone = isset($userData['phone'])?$userData['phone']:'-';
                if($userID > 0 ):
                    $isBday = in_array($userID,$arr['dob'])?$Y:$N;
                    $isAnniversary = in_array($userID,$arr['anniversary'])?$Y:$N;
                    $isBdayF = in_array($userID,$arr['dob_father'])?$Y:$N;
                    $isBdayM = in_array($userID,$arr['dob_mother'])?$Y:$N;
                    $isBdayC1 = in_array($userID,$arr['dob_child1'])?$Y:$N;
                    $isBdayC2 = in_array($userID,$arr['dob_child2'])?$Y:$N;
                    
                    $tableB = $tableB."<tr>
                             <td >
                             Name : $userName
                             <br><i class='fa fa-mobile-phone'></i> : $userPhone
                             <br><i class='fa fa-envelope-o'></i>:$userEmail
                            </td> 
                             <td >$isBday</td> 
                             <td >$isAnniversary</td> 
                             <td >$isBdayF</td> 
                             <td >$isBdayM</td> 
                             <td >$isBdayC1</td> 
                             <td >$isBdayC2</td> 
                         </tr>";
                endif;
            }
        endif;
        
        $table = '<table class="table table-hover table-bordered">'.$tableHeader.'<tbody>'.$tableB.'</tbody></table>';
        return $table;
    }
        
    function tax_attr($arr=NULL){        
        $taxAttr = $this->site->getTaxAttr();
        $tableHeader =" <thead>
                        <tr>
	                    <th width='5%'>Sr.No</th>
                            <th width='15%'>Code</th>
                            <th>Name</th> 
                            <th  width='10%'> Percentage % </th> 
                        </tr>
                        </thead>";
        $tableB = '';
        $idArr = array();
        if(count($taxAttr) > 0){
        $i=1;
            foreach ($taxAttr as $key => $attr) {
           
                $selPercantage = isset($arr[$attr->id]['percentage'])?(float)$arr[$attr->id]['percentage']  :'';
                $idArr[] = $attr->id;
                $tableB= $tableB.'<tr>'
                        . '<td class="text-center">'.$i++.'</td>'
                        . '<td class="text-center">'.$attr->code.'</td>'
                        . '<td class="text-center">'.$attr->name.'</td>'
                        . '<td  class="tax_attr_td  text-right"><input  type="text" class="tax_attr_input col-md-10 text-right numaric_input" name="tax_attr_'.$attr->id.'"  value="'.$selPercantage.'"></td>'
                        . '</tr>';
            }
        }else{
            $tableB =   $tableB= $tableB.'<tr>'
                        . '<td colspan="4"> Not found any attribute  </td>'
                        . '</tr>';
        }
        $id_str = implode(",",$idArr);
        $table = '<table class="table table-bordered table-hover table-striped">'.$tableHeader.'<tbody>'.$tableB.'</tbody></table><input type="hidden" name="tax_attr_str" value="'.$id_str.'">';
        return $table;  
    }
    
    function taxAtrrClassification($tax_rate_id,$_net_unit_price,$_qty,$itemId=NULL,$saleID=NULL,$type=NULL){
        $_net_unit_price  = isset($_net_unit_price)?$_net_unit_price:0;
        $_qty               = isset($_qty)?$_qty:0;
        $_tax       =   $this->site->getTaxRateByID($tax_rate_id);
        $tax_config = isset($_tax->tax_config)?$_tax->tax_config:'';              
        $tax_config = !empty($tax_config)?unserialize($tax_config):NULL;
        
        if(empty($tax_config)):
            return false;
        endif;
        
        if(!is_array($tax_config)):
            return false;
        endif;        
        $insert_data = array();
        foreach ($tax_config as $taxID => $tax):
            
            if(isset($taxArr)):
                unset($taxArr);
            endif;
            
            $taxArr  = array();
            $taxArr['item_id']      = !empty((int)$itemId)?$itemId:0;
            
            $taxArr['attr_code']    = $tax_config[$taxID]['code'];
            $taxArr['attr_name']    = $tax_config[$taxID]['name'];
            $taxArr['attr_per']     = $tax_config[$taxID]['percentage'];
            $taxArr['tax_amount']   = ($_net_unit_price*((float)$tax_config[$taxID]['percentage'] /100))*($_qty);
            
            
            switch ($type) {              
                case 'p':
                        $taxArr['purchase_id']  = !empty((int)$saleID)?$saleID:0;
                        //$this->site->add_tax_attr_amount_purchase($taxArr);
                    break;
                
                case 'q':
                        $taxArr['quote_id']  = !empty((int)$saleID)?$saleID:0;
                        //$this->site->add_tax_attr_amount_quote($taxArr);
                    break;
                
                default:
                        $taxArr['sale_id'] = !empty((int)$saleID)?$saleID:0;
                        //$this->site->add_tax_attr_amount($taxArr);
                    break;
            }
        
        $insert_data[] = $taxArr;
        endforeach; 

        switch($type){
            case 'p':
                if($reuslt = $this->db->insert_batch('purchase_items_tax', $insert_data)):            
                    return $reuslt;
                else:
                    return FALSE;
                endif;
            break;
            case 'q':
                if($reuslt = $this->db->insert_batch('quote_items_tax', $insert_data)):            
                    return $reuslt;
                else:
                    return FALSE;
                endif;
            break;
            default:
                if($reuslt = $this->db->insert_batch('sales_items_tax', $insert_data)):            
                    return $reuslt;
                else:
                    return FALSE;
                endif;
            break;
        }

    }
    
    function taxTableAttr($taxAttr){
        if(!is_array($taxAttr) || count($taxAttr)==0):
            return false;
        endif;
        $tBody = '';
        foreach ($taxAttr as $key => $attr) {
            $tBody.='<tr>'
                    . '<td colspan="4" class="text-right">'.$key.'('.$attr['name'].')'.'</td>'
                    . '<td  class="text-right">'.$this->sma->formatMoney($attr['amt']).'</td>'
                    . '</tr>';
        }
        return  $tBody;
    }
    
    function taxInvvoiceTabel($tax_summary,$taxItems,$inv,$return_sale,$Settings,$isBorder=NULL){
    	$tclass = !empty($isBorder)?'table-bordered':'';
        $table =  '<h4 class="tax_summary_head" style="font-size: 12px; text-align:center; font-weight:bold; margin:5px 0px;">' . lang('tax_summary') . '</h4>';       
        $table .=  '<table class="table '.$tclass.' table-condensed">';       
        if (!empty($tax_summary)) {
            $tax_sum_colspan =is_array($taxItems)?count($taxItems)+3:3;
            $table .=  '<thead><tr><th  class="text-center">' . lang('name') . '</th>';
            if(is_array($taxItems)) {
            foreach ($taxItems as $_tax):
                $table .=  '<th  class="text-center">' . $_tax->attr_code . '(%)</th>';
            endforeach;
            }
            $table .= '<th class="text-right">' . lang('qty') . '</th><th class="text-right">' . lang('tax_excl') . '</th><th class="text-right">' . lang('tax_amt') . '</th></tr>'
                    . '</thead>'
                    . '<tbody>';
             if(is_array($tax_summary)) {
            foreach ($tax_summary as $summary) :
                $table .=  '<tr><td>' . $summary['name'] . '</td>';
                     if(is_array($taxItems)) {
                    foreach ($taxItems as $_tax):
                        $_tax = $this->site->taxAttrPercentageBySaleTaxId($_tax->attr_code,$summary['tax_rate_id'],$inv->id); 
                        $_tax =  ($_tax===false)?'-':$_tax;
                        $table .=  '<td  class="text-center">' .  $_tax. '</td>';
                     endforeach;
                     }//end if.
                $table .= '<td class="text-center">' . $this->sma->formatQuantity($summary['items']) . '</td><td class="text-center">' . $this->sma->formatMoney($summary['amt']) . ' </td><td class="text-center">' . $this->sma->formatMoney($summary['tax']) . '</td></tr>';
            endforeach;
             }//end if
        }
        $table .= '</tbody></table><div class="row" style="margin:2px -15px !important;">';
        
        if(isset($taxItems) &&  is_array($taxItems) && count($taxItems) && $Settings->tax_classification_view ==1):
            $colsize = (count($taxItems)==2) ? 'col-lx-4 col-md-4 col-sm-4 col-xs-4' : 'col-lx-3 col-md-3 col-sm-3 col-xs-3';
            foreach ($taxItems as $_tax) {
                //$table .= '<tr><td colspan="'.$tax_sum_colspan.'" class="text-right">' .$_tax->attr_code.' ( '.$_tax->attr_name.' ) ' . '</td><th class="text-right">' . $this->sma->formatMoney($_tax->amt) . '</th></tr>';
                $table .= '<div class="'.$colsize.'" style="margin:0px !important;">' .$_tax->attr_code.'&nbsp;' . $this->sma->formatMoney($_tax->amt) . '</div>';
            }
        endif;
        
        $table .= '<div class="'.$colsize.'" style="text-align:right;">'  . lang('Total&nbsp;Tax') . '&nbsp;' . $this->sma->formatMoney($return_sale ? $inv->product_tax+$return_sale->product_tax : $inv->product_tax) . '</div></div>';
            
      return $table;  
    }
    
    function purchaseTaxInvvoiceTabel($tax_summary,$taxItems,$inv,$return_sale,$Settings,$isBorder=NULL){
        $tclass = !empty($isBorder)?'table-bordered':'';
        $table =  '<h4 style="font-weight:bold;">' . lang('tax_summary') . '</h4>';       
        $table .=  '<table class="table '.$tclass.' table-condensed">';       
        if (!empty($tax_summary)) {
            $tax_sum_colspan =is_array($taxItems)?count($taxItems)+3:3;
            $table .=  '<thead><tr><th  class="text-center">' . lang('name') . '</th>';
            if(is_array($taxItems)):             
                foreach ($taxItems as $_tax):
                    $table .=  '<th  class="text-center">' . $_tax->attr_code . '</th>';
                endforeach;               
            endif;
            $table .=  '<th  class="text-right">' . lang('qty') . '</th><th  class="text-right">' . lang('tax_excl') . '</th><th  class="text-right">' . lang('tax_amt') . '</th></tr>'
                    . '</thead>'
                    . '<tbody>';
            if(is_array($taxItems)):            
                foreach ($tax_summary as $summary) :
                    $table .=  '<tr><td>' . $summary['name'] . '</td>';
                        foreach ($taxItems as $_tax):
                            $_tax = $this->site->taxAttrPercentageByPurchaseTaxId($_tax->attr_code,$summary['tax_rate_id'],$inv->id); 
                            $_tax =  ($_tax===false)?'-':$_tax;
                            $table .=  '<td  class="text-center">' .  $_tax. '</td>';
                         endforeach;
                    $table .= '<td class="text-right">' . $this->sma->formatQuantity($summary['items']) . '</td><td class="text-right">' . $this->sma->formatMoney($summary['amt']) . '</td><td class="text-right">' . $this->sma->formatMoney($summary['tax']) . '</td></tr>';
                endforeach;                 
            endif;
            
        }
        $table .= '</tbody></tfoot>';
       // print_r($taxItems);
        if(isset($taxItems) &&  is_array($taxItems) && count($taxItems) && $Settings->tax_classification_view__purchase==1):
            foreach ($taxItems as $_tax) {
                $table .= '<tr><td colspan="'.$tax_sum_colspan.'" class="text-right">' .$_tax->attr_code.' ( '.$_tax->attr_name.' ) ' . '</td><th class="text-right">' . $this->sma->formatMoney($_tax->amt) . '</th></tr>';
            }
        endif;
        
        $table .= '<tr>'
                    . '<th colspan="'.$tax_sum_colspan.'" class="text-right">' . lang('total_tax_amount') . '</th>'
                    . '<th class="text-right">' . $this->sma->formatMoney($return_sale ? $inv->product_tax+$return_sale->product_tax : $inv->product_tax) . '</th>'
                . '</tr>'
                .'</table>';
      return $table;  
    }
    
    public function quoteTaxInvvoiceTabel($tax_summary,$taxItems,$inv,$Settings,$isBorder=NULL){
 
        $tclass = !empty($isBorder)?'table-bordered':'';
        $table =  '<h4 style="font-weight:bold;">' . lang('tax_summary') . '</h4>';       
          $table .=  '<table class="table '.$tclass.' table-condensed">';       
        if (!empty($tax_summary)) {
            $tax_sum_colspan =is_array($taxItems)?count($taxItems)+3:3;
            $table .=  '<thead><tr><th  class="text-center">' . lang('name') . '</th>';
            if(!empty($taxItems)){
                foreach ($taxItems as $_tax):
                    $table .=  '<th  class="text-center">' . $_tax->attr_code . '</th>';
                endforeach;
            }
            $table .=  '<th  class="text-right">' . lang('qty') . '</th><th  class="text-right">' . lang('tax_excl') . '</th><th  class="text-right">' . lang('tax_amt') . '</th></tr>'
                    . '</thead>'
                    . '<tbody>';
            foreach ($tax_summary as $summary) :
                $table .=  '<tr><td>' . $summary['name'] . '</td>';
                    if(!empty($taxItems)){
                        foreach ($taxItems as $_tax):
                           $attr_code =  $_tax->attr_code;
                            $_tax = $this->site->taxAttrPercentageByQuoteTaxId($attr_code,$summary['tax_rate_id'],$inv->id); 
                            $_tax =  ($_tax===false)?'-':$_tax.'%';
                            //$_tax =  ($_tax===false)?'-':$_tax;
                            //$table .=  '<td  class="text-center">' .  $_tax. '</td>';
                            $_amt = $this->site->taxAttrAmtByQuoteTaxId($attr_code,$summary['tax_rate_id'],$inv->id);
                            $_amt =  ($_amt===false)?'':'('. $this->sma->formatMoney($_amt).')';
                            $table .=  '<td  class="text-center">' .  $_tax . ' ' . $_amt . '</td>';
                        endforeach;
                    }
                $table .= '<td class="text-right">' . $this->sma->formatQuantity($summary['items']) . '</td><td class="text-right">' . $this->sma->formatMoney($summary['amt']) . '</td><td class="text-right">' . $this->sma->formatMoney($summary['tax']) . '</td></tr>';
            endforeach;
        }
        $table .= '</tbody></tfoot>';
        
        if(isset($taxItems) &&  is_array($taxItems) && count($taxItems) && $Settings->tax_classification_view ==1):
            foreach ($taxItems as $_tax) {
                $table .= '<tr><td colspan="'.$tax_sum_colspan.'" class="text-right">' .$_tax->attr_code.' ( '.$_tax->attr_name.' ) ' . '</td><th class="text-right">' . $this->sma->formatMoney($_tax->amt) . '</th></tr>';
            }
        endif;
        
        $table .= '<tr>'
                    . '<th colspan="'.$tax_sum_colspan.'" class="text-right">' . lang('total_tax_amount') . '</th>'
                    . '<th class="text-right">' . $this->sma->formatMoney($return_sale ? $inv->product_tax+$return_sale->product_tax : $inv->product_tax) . '</th>'
                . '</tr>'
                .'</table>';
      return $table;  
    }
    
    public function taxAttrTBL($itemTaxes,$id,$total_column_offset){
        $table_body = '';
        $order_tax_label = lang("tax") ;
        $taxConfig = isset($itemTaxes[$id])?$itemTaxes[$id]:NULL;
            if(is_array($taxConfig)):
                     $table_body = $table_body. '<tr><th colspan="'.$total_column_offset.'">'. $order_tax_label. '<table class="attr_table" style="width:30%;font-weight:normal;">' ;
                    foreach ($taxConfig as $taxKey => $taxData) {
                      $table_body = $table_body.   '<tr>'
                                      . '<td>'.$taxKey.'</td>'
                                      . '<td>'.(float)$taxData->attr_per.'%</td>'
                                      . '<td>'.$this->formatMoney($taxData->amt).'</td>'
                                      . '</tr>';
                    }
                    $table_body = $table_body.'</table></th><th class="text-right"> </th></tr>';  
            endif;
            return $table_body;
    }
   /*26-11
    public function taxAttrTBLInline($itemTaxes,$id,$total_column_offset){
        $total_column_offset++;
        $table_body = '';
        $order_tax_label = lang("tax") ;
        $taxConfig = isset($itemTaxes[$id])?$itemTaxes[$id]:NULL;
            if(is_array($taxConfig)):
                     $table_body = $table_body. '<tr><th colspan="'.$total_column_offset.'"><table class="attr_table" cellpadding="2" style="width:60%;font-weight:normal;"><tr><th colspan="'.$total_column_offset.'">'. $order_tax_label.':</th>' ;
                    foreach ($taxConfig as $taxKey => $taxData) {
                      $table_body = $table_body.  '<td>'.$taxKey.' ('.(float)$taxData->attr_per.'%) '.$this->formatMoney($taxData->amt).'</td>' ;
                    }
                    $table_body = $table_body.'</tr></table></th></tr>';  
            endif;
            return $table_body;
    }
    */
     /*new*/
     public function taxAttrTBLInline($itemTaxes,$id,$total_column_offset){
        $total_column_offset++;
        $table_body = '';
        $order_tax_label = lang("tax") ;
        $taxConfig = isset($itemTaxes[$id])?$itemTaxes[$id]:NULL;
            if(is_array($taxConfig)):
                     $total_column_offset_colspan = $total_column_offset-3;
                     $table_body = $table_body. '<tr><td colspan="'.$total_column_offset_colspan.'">'. $order_tax_label.':</td>' ;
                    
                    foreach ($taxConfig as $taxKey => $taxData) {
                     
                      $table_body = $table_body.  '<td>'.$taxKey.' ('.(float)$taxData->attr_per.'%) '.$this->formatMoney($taxData->amt).'</td>' ;
                    }
                    $table_body = $table_body.'</tr>';  
            endif;
            return $table_body;
    }
  

    public function taxAttrTblDiv($itemTaxes,$id,$total_column_offset){
        $order_tax_label =  lang("tax") ;
        $table_body = '';
        $taxConfig = isset($itemTaxes[$id])?$itemTaxes[$id]:NULL;
            if(is_array($taxConfig)):
                     $table_body = $table_body. '<tr><td  class="text-left"  colspan="'.$total_column_offset.'">'. $order_tax_label.'<div class="attr_table" style="width: 40%;font-weight:normal;display: table;">' ;
                    foreach ($taxConfig as $taxKey => $taxData) {
                      $table_body = $table_body. '<ul style=" display: table-row;list-style-type: none;"  >'
                                      . '<li   > <span style=" display: table-cell;padding: 5%;">'.$taxKey.'</span>&nbsp;&nbsp;&nbsp;<span style=" display: table-cell;padding: 5%;">'.(float)$taxData->attr_per.'%</span>&nbsp;&nbsp;&nbsp;<span  style=" display: table-cell;padding: 5%;">'.$this->formatMoney($taxData->amt).'</span></li>'
                                      . '</ul>';
                    }
                    $table_body = $table_body.'</div></td><td class="text-right"> </td></tr>';  
            endif;
            return $table_body;
    } 
   
    
    
    public function validPromoDate($start_date,$end_date){
        if($start_date==$end_date):
            return false;
        endif;
        
        $ci 		= get_instance();
	$config 	= $ci->config;
	$IST_OFFSET     = isset($config->config['IST_OFFSET'])?$config->config['IST_OFFSET']:0;
        
        $sDate =  $this->fld($this->input->post('start_date')).":00";
        $eDate =  $this->fld($this->input->post('end_date')).":00";
        if(empty($sDate) || empty($eDate)):
            return false;
        endif;             
        
        $stime = strtotime($sDate);
        $etime = strtotime($eDate);
        $ctime = time();
        
        
        if($etime < $ctime || $etime < $stime):
           return false;
        endif;
        
        return true;
    }
    
    public function dbSavedValue($arr,$val) {
    
    	$arr1 = array_keys($arr);
    	if(!in_array($val,$arr1)) {
    	   return "Note: Saved state value is $val ";
    	}
    	return false;
    }
    
    public function getStateFromStateCode($code){
        return $this->site->getStateFromStateCode($code);
    }

    public function cron_group_member($member){ 
        $tablelist = '';
        foreach ($member as $key => $memberData) :
            $chkOpt = '';
            if(is_numeric($selectedMember)) {
                $chkOpt = in_array($memberData->id, $selectedMember)?'checked':'';
            }
            if($key == 1){
                $wic = '<li class="col-sm-3 col-xs-12"><label style="color:#000;font-size: 12px;" for="mem_'.$memberData->id.'" ><input type="checkbox" class="multi-select input-xs" name="customer_id[]" value="'.$memberData->id.'"  id="mem_'.$memberData->id.'" '.$chkOpt.'> '.ucfirst($memberData->name).'</label></li>'    ;
            } else {
                $tablelist =  $tablelist.'<li class="col-sm-3 col-xs-12"><label style="color:#000;font-size: 12px;" for="mem_'.$memberData->id.'" ><input type="checkbox" class="multi-select input-xs" name="customer_id[]" value="'.$memberData->id.'"  id="mem_'.$memberData->id.'" '.$chkOpt.'> '.ucfirst($memberData->name).'</label></li>';  ;
            }
        endforeach; 
        $table = '<ul id="group_member_list">'. $wic . $tablelist.'</ul>'; 
        return $table;
    }
}
