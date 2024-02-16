<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Home</title>
        <link href="<?= $assets?>T1/css/bootstrap.min.css" rel="stylesheet">
        <link href="<?= $assets?>T1/css/font-awesome.min.css" rel="stylesheet">
        <link href="<?= $assets?>T1/css/main.css" rel="stylesheet">
        <link href="<?= $assets?>T1/css/responsive.css" rel="stylesheet">	
        
    </head><!--/head-->
    <body style="background: rgba(0, 0, 0, 0.5) none repeat scroll 0 0;min-height: 100%;position: relative; padding: 0;">
   
        <div class="outer-di">
            <div class="middle-di">
                <div class="inner-di">
                    <div class="col-sm-12">
                        <div class="col-md-6 col-md-offset-3">
                            <div class="modal-dialog modal-lg">
    <div class="box row">
        <div class="box-header">
            <div style="min-height:80px; background-color: #337ab7; color: #fff; font-size: 40px">E-Shop Registration</div>
        </div>
         
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id' => 'add-customer-form');
        echo form_open("shop/add_customer", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>
            <div class="text-danger"><?= $error?></div>
            <div class="row">
                <div class="col-md-8 offset-col-md-2">                    
                    <div class="form-group person">
                        <?= lang("name", "name"); ?> <span class="text-danger">*</span>
                        <?php echo form_input('name', $form['name'], 'class="form-control tip" id="name" data-bv-notempty="true" type="text" ondrop="return false;" onpaste="return false;"'); ?>
			
                    </div>
                    <div class="form-group">
                        <?= lang("email_address", "email_address"); ?> <span class="text-danger">*</span>
                        <input type="email" name="email" value="<?= $form['email']?>" required="required" maxlength="62" class="form-control" id="email_address"/>
                    </div>
                    <div class="form-group">
                        <?= lang("phone", "phone"); ?> <span class="text-danger">*</span>
                        <input type="tel" name="phone" value="<?= $form['phone']?>" class="form-control" required="required" id="phone" data-bv-notempty="true" maxlength="10" onkeypress="return IsNumeric(event,this)" type="text" id="text1" ondrop="return false" onpaste="return false">
                    </div>
                    <div class="form-group">
                        <?= lang("address", "address"); ?>
                        <?php echo form_input('address', $form['address'], 'class="form-control" id="address"'); ?>
                    </div>                           
                    <div class="form-group">
                        <?= lang("E-Shop Password", "eshop_pass"); ?> <span class="text-danger">*</span>
                        <input type="password" id="eshop_pass"  name="eshop_pass" class="form-control" required="required" placeholder="Eshop Password">
                    </div>
                </div>                
            </div>
        </div>
        <div class="box-footer">
            <div class="pull-left"><?php echo form_submit('add_customer', 'SignUp', 'class="btn btn-primary"'); ?></div>
             
            <div class="pull-right"><a href="<?= base_url('shop/login')?>" class="btn btn-info" >Already Registered! </a></div>
         </div>
    </div>
    <?php echo form_close(); ?>
</div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div> 
		
    </body>
</html>