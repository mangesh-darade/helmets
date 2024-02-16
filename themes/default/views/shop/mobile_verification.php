<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta name="description" content="">
        <meta name="author" content="">
        <title>Eshop User Verification</title>
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
                              if($action_status == FALSE) {  
                                echo '<span class="ord"><i class="fa fa-check aria-hidden" ></i></span>';
                                echo '<h2>Verification code has been sent on your registered mobile.</h2>';
                                
                                      
                                    $attrib = array('role' => 'form', 'id' => 'verify-mobile');
                                    $hidden = array('otp'=> $vmcode, 'mb'=>$mobile, 'id'=>$id, 'action'=>'Submit_otp');
                                    echo form_open("shop/mobile_verification/$id/" . md5($vmcode), $attrib, $hidden);                                 
                                ?>
                                    <div class="row">                                        
                                        <div class="col-md-6"> 
                                            <label for="data-mask">Enter 6 digit verification code.</label>
                                            <input id="data-mask" required="required" name="entered_otp" type="text" class="form-control text-center" data-inputmask="'mask': '9  9  9  -  9  9  9'" style="font-size: 1.8em !important; padding:5px;">
                                        </div>
                                        <div class="col-md-4"><br/><br/><a href="<?= base_url("shop/sent_otp/$id")?>">Resend Code</a></div>
                                    </div>
                                    <div class="row"> 
                                        <p class="text-center text-danger"><?= $error?></p>
                                        <div class="col-md-4 col-md-offset-4">
                                            <button class="btn btn-primary" type="submit">Verify Code</button>
                                        </div>
                                    </div>                                    
                                    <?php 
                                        echo form_close();
                              } else {
                                  echo '<span class="ord"><i class="fa fa-check aria-hidden" ></i></span>';
                                  echo '<h2>Congratulations! Mobile verified successfully.</h2>';
                                  echo '<p class="text-center"><a href="'. base_url('shop/login').'" class="btn btn-success" >E-Shop Login</a></p>';
                              }
                                    ?>
                               
                            </div>
                        <div class="clearfix"></div>
                    </div>
                </div>
            </div>
        </div>
<script src="<?= $assets?>T1/js/jquery.js"  ></script>                
<script src="<?= $assets?>T1/js/bootstrap.min.js"  ></script>                
<script src="<?= $assets?>T1/js/jquery.inputmask.js"  ></script>   
                
<script>
$(function () { 
     $('#data-mask').inputmask();
});
</script>

    </body>
    
</html>