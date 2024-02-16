<?php 


if(isset($config) && is_array($config) ):
    if(isset($config['base_url']) && !empty($config['base_url'])):
        $apiUrl     = rtrim($config['base_url'],'/');
	
	$eshop_url =  rtrim($config['eshop_url'],'/').'/';
        $payApiUrl  = $apiUrl.'/eshop';
         
	if(empty($_GET['payment_request_id']) || empty($_GET['payment_id'])):
            header('Location:'.$eshop_url);	
            exit;
	endif;

        $param = array();
        $param['action'] = 'check_pay_status';
        $param['payment_request_id'] = $_GET['payment_request_id'];
        $param['payment_id'] =  $_GET['payment_id'];
        $res = callApi($payApiUrl, $param);
        if(empty($res)):
            $decline_url = $eshop_url .'decline_order/'.$param['payment_id'];
            header('Location:'.$decline_url);
            exit;
        endif;
        $result = json_decode($res, true); 
        if(isset($result['success']) && !empty($result['success']) ):
            $success_url =  $eshop_url .'success_order.php?TID='.$param['payment_id']; 
            header('Location:'.$success_url);
            exit;
        endif;
    endif;
endif; 
$decline_url = $eshop_url .'decline_order.php?TID='.$param['payment_id'];
header('Location:'.$decline_url);
exit;
        	
?>