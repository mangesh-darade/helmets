<?php include_once 'header.php';?>
<?php
$address = (array)$billing_shipping[0];

 extract($address);
  
?>
<section><!--Middle section view-->
    <div class="container">
        <div class="col-sm-12" >
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="<?php echo site_url('shop/home');?>">Home</a></li>
                    <li class="active">Address</li>
                </ol>
            </div>

            <div class="account-tab">
                <ul class="nav nav-tabs col-sm-3">
                    <li><a href="<?php echo site_url('shop/my_account');?>">Dashboard</a></li>
                    <li><a href="<?php echo site_url('shop/myorders');?>">My Orders</a></li>             
                    <li class="active"><a href="#" >Billing & Shipping</a></li>
                    <li><a href="<?php echo site_url('shop/change_password');?>">Profile</a></li>
                    <li><a href="<?php echo site_url('shop/home');?>">Products</a></li>
                </ul>

                <div class="tab-content col-sm-9">
                    <?php
                    if(!empty($actmsg)){
                        if($actmsg=='success') {
                            $alertclass = 'success'; 
                            $alertMsg = "Addresses has been updated successfully.";
                        } else { 
                            $alertclass = 'danger';
                            $alertMsg = "Error in update process.";
                        }
                    ?>   
                    <div class="alert alert-<?= $alertclass?>"><?= $alertMsg?></div>
                    <?php
                    }
                    
                    ?>
                    <div class="text-address">
                        <p>The following addresses will be used on the checkout page by default.</p>
                        <?php $input_hidden = array('user_id' => $user_id, 'form_action'=>$form_action); ?>
                        <?php echo form_open('shop/save_billing_shipping', ['name'=>'frm_address'],$input_hidden); ?>
                            <div class="row">
                                <div class="col-sm-6">
                                    <h4>Billing address</h3>
                                        <table class="table table-border table-responsive">
                                            <tr><td><b class="text-danger">*</b> Name</td><td><input type="text" name="billing_name" maxlength="60" value="<?= $billing_name?>" required="required" class="form-control" /></td></tr>
                                            <tr><td><b class="text-danger">*</b> Mobile</td><td><input  type="text" name="billing_phone" maxlength="10" value="<?= $billing_phone?>" required="required"  class="form-control" /></td></tr>
                                            <tr><td><b class="text-danger">*</b> Email</td><td><input  type="email" name="billing_email" maxlength="60" value="<?= $billing_email?>" required="required"  class="form-control" /></td></tr>
                                            <tr><td><b class="text-danger">*</b> Address Line 1</td><td><input  type="text" name="billing_addr1" maxlength="250" value="<?= $billing_addr1?>"  required="required" class="form-control" /></td></tr>
                                            <tr><td>&nbsp;&nbsp; Address Line 2</td><td><input  type="text" name="billing_addr2" maxlength="250" value="<?= $billing_addr2?>"  class="form-control" /></td></tr>
                                            <tr><td><b class="text-danger">*</b> City</td><td><input type="text" name="billing_city" maxlength="60" value="<?= $billing_city?>" required="required"  class="form-control" /></td></tr>
                                            <tr><td><b class="text-danger">*</b> Pin code</td><td><input  type="text" name="billing_state" maxlength="60" value="<?= $billing_state?>" required="required"  class="form-control" /></td></tr>
                                            <tr><td><b class="text-danger">*</b> State</td><td><input  type="text" name="billing_country" maxlength="60" value="<?= $billing_country?>" required="required"  class="form-control" /></td></tr>
                                            <tr><td><b class="text-danger">*</b> Country</td><td><input  type="text" name="billing_zipcode" maxlength="6" value="<?= $billing_zipcode?>" required="required"  class="form-control" /></td></tr>
                                        </table>							 
                                </div>
                                <div class="col-sm-6">
                                    <h4>Shipping address</h3>
                                        <table class="table table-border table-responsive">
                                            <tr><td><b class="text-danger">*</b> Name</td><td><input  type="text" name="shipping_name" value="<?= $shipping_name?>" maxlength="60" required="required"  class="form-control" /></td></tr>
                                            <tr><td><b class="text-danger">*</b> Mobile</td><td><input  type="text" name="shipping_phone" value="<?= $shipping_phone?>" maxlength="10" required="required"  class="form-control" /></td></tr>
                                            <tr><td><b class="text-danger">*</b> Email</td><td><input  type="email" name="shipping_email" value="<?= $shipping_email?>" maxlength="60" required="required"  class="form-control" /></td></tr>
                                            <tr><td><b class="text-danger">*</b> Address Line 1</td><td><input  type="text" name="shipping_addr1" value="<?= $shipping_addr1?>" maxlength="250" required="required"  class="form-control" /></td></tr>
                                            <tr><td>&nbsp;&nbsp; Address Line 2</td><td><input  type="text" name="shipping_addr2" value="<?= $shipping_addr2?>" maxlength="250"  class="form-control" /></td></tr>
                                            <tr><td><b class="text-danger">*</b> City</td><td><input  type="text" name="shipping_city" value="<?= $shipping_city?>" maxlength="60" required="required"  class="form-control" /></td></tr>
                                            <tr><td><b class="text-danger">*</b> Pin Code</td><td><input  type="text" name="shipping_state" value="<?= $shipping_state?>"  maxlength="60" required="required" class="form-control" /></td></tr>
                                            <tr><td><b class="text-danger">*</b> State</td><td><input  type="text" name="shipping_country" value="<?= $shipping_country?>" maxlength="60" required="required"  class="form-control" /></td></tr>
                                            <tr><td><b class="text-danger">*</b> Country</td><td><input  type="text" name="shipping_zipcode" value="<?= $shipping_zipcode?>" maxlength="6" required="required"  class="form-control" /></td></tr>
                                        </table>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-sm-12">
                                    <button type="submit" name="submit" class="btn btn-warning" >Save</button>
                                </div>
                            </div>
                        <?php echo form_close(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>             
</section><!--/Middle section view-->
    
<?php include_once 'footer.php';?>
 