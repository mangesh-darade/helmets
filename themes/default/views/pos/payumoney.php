<?php defined('BASEPATH') OR exit('No direct script access allowed'); 


 
?><!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title><?=lang('pos_module') . " | " . $Settings->site_name;?></title>
    <script type="text/javascript">if(parent.frames.length !== 0){top.location = '<?=site_url('pos')?>';}</script>
    <base href="<?=base_url()?>"/>
    <meta http-equiv="cache-control" content="max-age=0"/>
    <meta http-equiv="cache-control" content="no-cache"/>
    <meta http-equiv="expires" content="0"/>
    <meta http-equiv="pragma" content="no-cache"/>
    <link rel="shortcut icon" href="<?=$assets?>images/icon.png"/>
    <link rel="stylesheet" href="<?=$assets?>styles/theme.css" type="text/css"/>
    <link rel="stylesheet" href="<?=$assets?>styles/style.css" type="text/css"/>
    <link rel="stylesheet" href="<?=$assets?>pos/css/posajax.css" type="text/css"/>
    <link rel="stylesheet" href="<?=$assets?>pos/css/print.css" type="text/css" media="print"/>
    <script type="text/javascript" src="<?=$assets?>js/jquery-2.0.3.min.js"></script>
    <script type="text/javascript" src="<?=$assets?>js/jquery-migrate-1.2.1.min.js"></script>
    <!--[if lt IE 9]>
    <script src="<?=$assets?>js/jquery.js"></script>
    <![endif]-->
    <?php if ($Settings->user_rtl) {?>
        <link href="<?=$assets?>styles/helpers/bootstrap-rtl.min.css" rel="stylesheet"/>
        <link href="<?=$assets?>styles/style-rtl.css" rel="stylesheet"/>
        <script type="text/javascript">
            $(document).ready(function () {
                $('.pull-right, .pull-left').addClass('flip');
                
            });
        </script>
    <?php }
    ?>
        <style>
            #paymentModal #s2id_paid_by_1,#paymentModal #s2id_paid_by_1 a{  pointer-events:none !important;  cursor: none !important;  } 
            .notification_counter{color: #ff0000;font-weight: bold;border: 1px solid;padding: 2px 4px;margin: 5px;border-radius: 12%}
        </style>	
</head>
<body>
<center>
<?php 
    error_reporting(0);
    $access_code=$ccavenue_access_code;//Shared by CCAVENUES
    $_url = !empty($url)?$url:'https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction'; 
?>
<form action="<?php echo $apiAction; ?>" method="post" name="payuForm">
		<input type="hidden"  name="key" 		value="<?php echo (empty($posted['key'])) ? '' : $posted['key'] ?>"  />
		<input type="hidden"  name="hash" 		value="<?php echo (empty($posted['hash'])) ? '' : $posted['hash'] ?>" />
		<input type="hidden"  name="txnid" 		value="<?php echo (empty($posted['txnid'])) ? '' : $posted['txnid'] ?>"    />
		<input type="hidden"   name="amount" value="<?php echo (empty($posted['amount'])) ? '' : $posted['amount'] ?>" />
		<input type="hidden"  name="firstname"  value="<?php echo (empty($posted['firstname'])) ? '' : $posted['firstname']; ?>" />
		<input type="hidden"  name="email" 		value="<?php echo (empty($posted['email'])) ? '' : $posted['email']; ?>" />
		<input type="hidden"  name="phone" 		value="<?php echo (empty($posted['phone'])) ? '' : $posted['phone']; ?>" />
		<input type="hidden"  name="lastname" 	value="<?php echo (empty($posted['lastname'])) ? '' : $posted['lastname']; ?>" />
		<input type="hidden"  name="address1" 	value="<?php echo (empty($posted['address1'])) ? '' : $posted['address1']; ?>" />
		<input type="hidden"  name="address2" 	value="<?php echo (empty($posted['address2'])) ? '' : $posted['address2']; ?>" />
		<input type="hidden"  name="city" 		value="<?php echo (empty($posted['city'])) ? '' : $posted['city']; ?>" />
		<input type="hidden"  name="state" 		value="<?php echo (empty($posted['state'])) ? '' : $posted['state']; ?>" />
		<input type="hidden"  name="country" 	value="" />
		<input type="hidden"  name="zipcode" 	value="<?php echo (empty($posted['zipcode'])) ? '' : $posted['zipcode']; ?>" />
		<input type="hidden"  name="productinfo" value="<?php echo (empty($posted['productinfo'])) ? '' : $posted['productinfo']; ?>" />
		<input type="hidden"  name="udf1" 		 value="<?php echo (empty($posted['udf1'])) ? '' : $posted['udf1']; ?>" />
		<input type="hidden"  name="udf2" 		 value="<?php echo (empty($posted['udf2'])) ? '' : $posted['udf2']; ?>" />
		<input type="hidden"  name="udf3" 		 value="<?php echo (empty($posted['udf3'])) ? '' : $posted['udf3']; ?>" />
		<input type="hidden"  name="udf4" 		 value="<?php echo (empty($posted['udf4'])) ? '' : $posted['udf4']; ?>" />
		<input type="hidden"  name="udf5" 		 value="<?php echo (empty($posted['udf5'])) ? '' : $posted['udf5']; ?>" />
		<input type="hidden"  name="pg"          value="" />
		<input type="hidden"  name="furl" 		 value="<?php echo (empty($posted['furl'])) ? '' : $posted['furl'] ?>"/>
		<input type="hidden"  name="surl" 		 value="<?php echo (empty($posted['surl'])) ? '' : $posted['surl'] ?>" />		
		<input type="hidden"  name="service_provider" value="payu_paisa" size="64" />
	</form>
	
	
	
</center>
<script language='javascript'>document.payuForm.submit();</script>  <!--  -->
</body>
</html>
