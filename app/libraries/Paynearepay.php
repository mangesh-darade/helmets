<?php
defined('BASEPATH') OR exit('No direct script access allowed'); 
/* this class is used to integrate merchant portal to Paynear Epay. */

    Class Paynearepay {
        
        private $_merchantId;
        private $_secretkey;
        private $_testMode;
        private $_paynearEpayURLTest    = 'http://mpos.sandbox.paynear.in:8080';
        private $_paynearEpayURLLive    = 'https://secure.paynear.in';
        private $_paymentEndpoint       = '/epay/payment/request';
	private $_verifyEndpoint        = '/epay/payment/verify';
        private $_statusEndpoint        = '/epay/payment/status';
	private $_refundEndpoint        = '/epay/payment/refund';
        
        public function __construct($merchantId, $key, $testMode = false)
        {
        
       
            $this->_merchantId = $merchantId;
            $this->_secretkey = $key;
            $this->_testMode = $testMode;
        }
        
        public function isTestMode()
        {
            return ($this->_testMode == true);
        }
       
        public function initiatePayment($params)
        {
            $response = $this->_httpRequest($this->_paymentEndpoint, $params);
            
            If (floatval($params["amount"]) != $response["amount"]) {
                // throw error response details correpted
                throw new Exception("Invalid Amount");
            }  else {
                // success
                // redirection needs to be happen here, redirection url will dynamicall assigned for everysuccessfull order in redirectURL filed in RequestResponseVO
                // now customer will redirected to payment page to proceed the payment
                // redirection should be post only
                // redirect
                if(isset($response['redirectURL']) && !empty($response['redirectURL'])){
	                header('Location: ' . $response['redirectURL']);
                	exit();
		} else {
		//  throw error response details correpted
                    throw new Exception("Payment URL generation failed.<br>" . $response['responseMessage']);
		}
            }
        }
        
        public function getPaymentResponse(){
            
            $result = $_POST;
            
            if($this->_isValidResponse($result)){
                $params = array();
                $params['amount'] = $result['amount'];
                $params['orderRefNo'] = $result['orderRefNo'];
                $params['transactionDate'] = substr($result['txnDateNTime'],0,10);
                if($this->verify($params))
                    return $result;
                else
                    throw new Exception("Verification failed");
            } else {
                throw new Exception("Invalid response");
            }
        }
        
        public function verify($params)
        {
            return $this->_httpRequest($this->_verifyEndpoint, $params);
        }
        
        public function getTransactionStatus($params)
        {
            return $this->_httpRequest($this->_statusEndpoint, $params);
        }
        
        public function initiateRefund($params)
        {
            return $this->_httpRequest($this->_refundEndpoint, $params);
        }
        
        private function _httpRequest($endpoint, $params)
        {
            //Adding merchantId parameter
            $params['merchantId'] = $this->_merchantId;
            
            //Generating and adding secure hash
            $secureHash = $this->_getSecureHash($params);
            $params['secureHash'] = $secureHash;
            $data = json_encode($params);

            $headers = array(
                'Accept: application/json',
                'Content-Type: application/json',
            );
            
            if($this->isTestMode())
                $url = $this->_paynearEpayURLTest;
            else
                $url = $this->_paynearEpayURLLive;
            
            $url .= $endpoint;
            
            $handle = curl_init();
            curl_setopt($handle, CURLOPT_URL, $url);
            curl_setopt($handle, CURLOPT_HTTPHEADER, $headers);
            curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($handle, CURLOPT_SSL_VERIFYHOST, false);
            curl_setopt($handle, CURLOPT_SSL_VERIFYPEER, false);
            curl_setopt($handle, CURLOPT_POST, true);
            curl_setopt($handle, CURLOPT_POSTFIELDS, $data);
            curl_setopt($handle, CURLOPT_TIMEOUT_MS, 60000);
            $response = curl_exec($handle);
            $httpCode = curl_getinfo($handle, CURLINFO_HTTP_CODE);
            $curl_errno = curl_errno($handle);
            $curl_error = curl_error($handle);
            curl_close($handle);
            
            if (FALSE === $response)
                throw new Exception("fails to connect Server". $url );
            else if ($curl_errno > 0)
                throw new Exception("cURL Error ($curl_errno): $curl_error\n");
            else if ($httpCode != 200)
                throw new Exception("Server Error: {$httpCode} \n ");
            else {
                
                $result = json_decode($response, true);
				
                if($this->_isValidResponse($result)){
                    return $result;
                } else {
               
                   throw new Exception("Invalid response" );
                }
            }
            
        }
        
        private function _isValidResponse($params)
        {
		
            if(!is_array($params) || empty($params) || !isset($params['secureHash']))
                return false;
            
            $receivedSecureHash = $params['secureHash'];
            $generatedSecureHash = $this->_getSecureHash($params);
        
            return $receivedSecureHash == $generatedSecureHash;
        }
        
        private function _getSecureHash($params)
        {
            if(!is_array($params) || empty($params))
                return false;
            
            if(isset($params['secureHash']))
                unset($params['secureHash']);
            
            $checkSumString = $this->_secretkey;
            ksort($params);
            
            foreach($params as $key => $value){
                $checkSumString .= '|' . $value;
            }
           
            $hash = hash('SHA512', $checkSumString);
             
            return strtoupper($hash);
        }
    }
?>