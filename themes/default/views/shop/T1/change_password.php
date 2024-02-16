<?php include_once 'header.php';?>

<section class="middle_section"><!--Middle section view-->
    <div class="container">
        <div class="col-sm-12" >
            <div class="breadcrumbs">
                <ol class="breadcrumb">
                    <li><a href="<?php echo site_url('shop/home');?>">Home</a></li>
                    <li class="active">Change Password</li>
                </ol>
            </div>

            <div class="account-tab">
                <ul class="nav nav-tabs col-sm-3">
                    <li><a href="<?php echo site_url('shop/my_account');?>">Dashboard</a></li>
                    <li><a href="<?php echo site_url('shop/myorders');?>">Orders</a></li>             
                    <li><a href="<?php echo site_url('shop/billing_shipping');?>">Address</a></li>
                    <li class="active"><a href="#">Profile</a></li>
                    <li><a href="<?php echo site_url('shop/home');?>">Products</a></li>
                </ul>

                <div class="tab-content col-sm-9">
                    <?php
                        if(!empty($actmsg)){
                            echo $actmsg;
                        } 
                    ?>
                    <div class="shopper-info">
                        <h4>Profile Details</h4>
                        <?php $input_hidden = array('user_id' => $user_id, 'form_action'=>'update_profile'); ?>
                        <?php echo form_open('shop/change_password', ['name'=>'frm_address'],$input_hidden); ?>
                             <div class="row">
                                 <div class="col-sm-6">
                                     <label><span class="text-danger">*</span> Full Name</label>
                                     <input type="text" placeholder="Name" name="name" value="<?php echo $user->name?>"  required="required" maxlength="60"  >
                                 </div> 
                                 <div class="col-sm-6">
                                     <label><span class="text-danger">*</span> Email address</label>
                                     <input type="email" placeholder="Email address" name="email"  value="<?php echo $user->email?>"  required="required" maxlength="60" >
                                 </div>
                             </div>
                            <div class="row">
                                 <div class="col-sm-6">
                                     <label>Business Name</label>
                                     <input type="text" placeholder="Business Name" name="company" value="<?php echo $user->company?>"  maxlength="100"  >
                                 </div> 
                                 <div class="col-sm-6">
                                     <label>VAT/TAX Registration No.</label>
                                     <input type="text" placeholder="VAT Number" name="vat_no"  value="<?php echo $user->vat_no?>" maxlength="25" >
                                 </div>
                             </div>
                             <div class="col-sm-12">
                                 <div class="col-sm-3"><button type='submit' name="submit" class="btn btn-info">Update</button>
                                 </div>
                                 <div class="col-sm-9"></div>
                             </div>
                         <?php echo form_close();?>
                         <div class="row"><div class="col-sm-12">&nbsp;</div></div>
                         <?php
                            if(!empty($cpactmsg)){
                                echo $cpactmsg;
                            }
                        ?>
                         <h4>Password Change</h4>
                         
                         <?php $input_hidden = array('user_id' => $user_id, 'form_action'=>'change_password'); ?>
                         <?php echo form_open('shop/change_password', ['name'=>'frm_address'],$input_hidden); ?>
                             <div class="row">
                                 <div class="col-sm-12">
                                     <label><span class="text-danger">*</span> Current Password</label><br/>
                                     <div class="col-sm-6"><input type="password" placeholder="Current Password" required="required" name="password" /></div>
                                     <div class="col-sm-6">
                                         <span class="text-danger">Is required.</span>
                                     </div>
                                 </div>
                                 <div class="col-sm-12">
                                     <label><span class="text-danger">*</span> New Password  </label><br/>
                                     <div class="col-sm-6"><input type="password" placeholder="New password" name="new_password" required="required" maxlength="20" /></div>
                                     <div class="col-sm-6">
                                         <span class="text-danger">Is required.</span>
                                     </div>
                                 </div>
                                 <div class="col-sm-12">
                                     <label><span class="text-danger">*</span> Confirm Password </label><br/>
                                     <div class="col-sm-6">
                                         <input type="password" placeholder="Confirm password" name="confirm_password"  required="required" maxlength="20" />
                                     </div>
                                     <div class="col-sm-6">
                                         <span class="text-danger">Is required.</span>                                    
                                     </div>
                                 </div>
                                 <div class="col-sm-12">
                                     <div class="col-sm-3">
                                         <button type='submit' name="submit" class="btn btn-info" >Change Password</button>
                                     </div>
                                     <div class="col-sm-9"></div>
                                 </div>
                             </div>
                         <?php echo form_close();?>
                     </div>
                     
                </div>
            </div>
        </div>
       
    </div>             
</section><!--/Middle section view-->
    
<?php include_once 'footer.php';?>
 