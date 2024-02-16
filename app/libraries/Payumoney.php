<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
/* this class is used to integrate merchant portal to Payumoney . */

    Class Payumoney {
        
        private $_PAYUMONEY_MID;
        private $_PAYUMONEY_KEY;
        private $_PAYUMONEY_SALT;
        private $_PAYUMONEY_AUTH_HEADER ;
		private $_PAYUMONEY_PAY_URL ;
        
		public function __construct($PAYUMONEY_MID, $PAYUMONEY_KEY, $PAYUMONEY_SALT,$PAYUMONEY_AUTH_HEADER ){
            $this->_PAYUMONEY_MID = $PAYUMONEY_MID;
            $this->_PAYUMONEY_KEY = $PAYUMONEY_KEY;
            $this->_PAYUMONEY_SALT = $PAYUMONEY_SALT;
			$this->_PAYUMONEY_AUTH_HEADER = $PAYUMONEY_AUTH_HEADER;
            $this->_PAYUMONEY_PAY_URL = 'https://secure.payu.in/_payment';
        }
		
		
		public function getApiUrl(){		
			return $this->_PAYUMONEY_PAY_URL;
		}// End getApiUrl()
		
		public function validateOrder($order){
			$curl = curl_init();
			curl_setopt_array($curl, array(
			  CURLOPT_URL => "https://www.payumoney.com/payment/payment/chkMerchantTxnStatus",
			  CURLOPT_RETURNTRANSFER => true,
			  CURLOPT_ENCODING => "",
			  CURLOPT_MAXREDIRS => 10,
			  CURLOPT_TIMEOUT => 300,
			  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			  CURLOPT_CUSTOMREQUEST => "POST",
			  CURLOPT_POSTFIELDS => "merchantKey=".$this->_PAYUMONEY_KEY."&merchantTransactionIds=".$order,
			  CURLOPT_HTTPHEADER => array(
				"authorization: ".$this->_PAYUMONEY_AUTH_HEADER,
				"cache-control: no-cache",
				"content-type: application/x-www-form-urlencoded",
			  ),
			));

			$response = curl_exec($curl);
			$err = curl_error($curl);

			curl_close($curl);

			if ($err) {
			 return false;
			} 
			
			return $response;
		}// End validateOrder($order)
		
       	/**
	 * @since 1.0.0
	 */
        public  function calculate_hash_before_transaction($hash_data) {

		$hash_sequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
		$hash_vars_seq = explode('|', $hash_sequence);
		$hash_string = '';

			foreach($hash_vars_seq as $hash_var) {
			  $hash_string .= isset($hash_data[$hash_var]) ? $hash_data[$hash_var] : '';
			  $hash_string .= '|';
			}

			$hash_string .= $this->_PAYUMONEY_SALT;
			$hash_data['hash'] = strtolower(hash('sha512', $hash_string));

			return $hash_data['hash'];

		} // End calculate_hash_before_transaction()


        public function check_hash_after_transaction($salt, $txnRs) {

			$hash_sequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
			$hash_vars_seq = explode('|', $hash_sequence); 
			$hash_vars_seq = array_reverse($hash_vars_seq);

			$merc_hash_string = $salt . '|' . $txnRs['status'];

			foreach ($hash_vars_seq as $merc_hash_var) {
				$merc_hash_string .= '|';
				$merc_hash_string .= isset($txnRs[$merc_hash_var]) ? $txnRs[$merc_hash_var] : '';
			}

			$merc_hash = strtolower(hash('sha512', $merc_hash_string));
					 
			/* The hash is valid */
			if($merc_hash == $txnRs['hash']) {
				return true;
			} else {
				return false;
			}

		} // End check_hash_after_transaction()


	/**
	 * @since 1.0.0
	 */
        public function calculate_hash_before_verification($hash_data) {

			$hash_sequence = "key|command|var1";
			$hash_vars_seq = explode('|', $hash_sequence);
			$hash_string = '';

			foreach($hash_vars_seq as $hash_var) {
			  $hash_string .= isset($hash_data[$hash_var]) ? $hash_data[$hash_var] : '';
			  $hash_string .= '|';
			}

			$hash_string .= $this->salt;
			$hash_data['hash'] = strtolower(hash('sha512', $hash_string));

			return $hash_data['hash'];

		} // End calculate_hash_before_verification()
   
  }
?>