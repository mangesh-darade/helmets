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
        <div class="outer-di" style="padding-top: 200px;">
            <div class="middle-di">
                <div class="inner-di">
                    <div class="col-sm-12">
                        <div class="col-md-6 col-md-offset-3">                            
                            <div class="suc-ord">
                            <?php
                                if($action_status === TRUE) {
                                    echo '<span class="ord"><i class="fa fa-check aria-hidden" ></i></span>';
                                    echo '<h2>Congratulations! <br/>Your Email Verified Successfully!</h2>';
                                    if($mobile_is_verified == 0 && strlen($mobile) >= 10) {
                                  
                                        $encMobile = md5($mobile);
                                        $attrib = array('role' => 'form', 'id' => 'verify-mobile');
                                        $hidden = array('otp'=> $vmcode, 'mb'=>$mobile, 'id'=>$id);
                                        echo form_open("shop/sent_otp/$id/$encMobile", $attrib, $hidden); 
                                    ?>                                
                                        <p>You have need to verified your mobile for completed login process.</p>
                                        <p class="text-center"><button type="submit">Click To Get Mobile Verification Code</button></p>
                                    <?php 
                                        echo  form_close(); 
                                    }//end if 
                                    else
                                    {
                                ?>      
                                    <p class="text-success">You have verified your email & mobile successfully.</p>
                                    <p class="text-center"><a href="<?=base_url('shop/login')?>" class="btn btn-success">Click To Login</a></p>
                                <?php        
                                    }//end else
                                    
                                } else {                                    
                                    echo '<h2 class="text-danger">'.$error.'</h2>';
                                    echo '<p class="text-center"><a href="'. base_url('shop/login').'" class="btn btn-primary" >E-Shop Home</a></p>';
                                    if($email_is_verified == 0 && !empty($email))
                                    {
                                        $attrib = array('role' => 'form', 'id' => 'resend-verify-email');
                                        $hidden = array('vecode'=> $vecode, 'email'=>$email, 'id'=>$id);
                                        echo form_open("shop/resend_email_verification", $attrib, $hidden); 
                                    ?>   <hr/>                             
                                        <p>If you want to get verification link, Please click the below button.</p>
                                        <p class="text-center"><button type="submit" class="btn btn-info">Click To Resend Email Verification Link</button></p>
                                    <?php 
                                        echo form_close();
                                    }
                                }
                            ?> 
                            </div>                            
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div> 		
    </body>
</html>