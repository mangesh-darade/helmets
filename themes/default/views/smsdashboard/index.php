<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
$g_class_arr = array('bblue' ,'bdarkGreen' ,'borange' ,'blightOrange');
$GroupGrid = $this->sma->GroupGrid($groupList, $g_class_arr); 
$GroupCount = isset($groupList) && is_array($groupList)?count($groupList):0; 
$sms_class = (int) $sms_limit > 0?'sms_allow':'sms_notallow'; 
$sms_disable_attr = (int) $sms_limit == 0?'   style="cursor: no-drop !important;" ':'';  
$sms_text_limit = $this->sma->smsCharLimit();
?>
<style>
    #s2id_customers{ display:block !important;  }
    li.form-group{list-style-type:none;}
    .select2-container-multi{min-width: 100%;}
    .na_template{color: white;padding: 10px;text-align: left;text-indent: 15px;margin-top: 15px;}
    .na_group{ padding: 10px;text-align: left;text-indent: 15px;margin-top: 15px;}
    .dis_submit,.sms_notallow{opacity: 0.5;cursor:no-drop !important;}
    .contact-group p{ font-size: 11px;text-align:center;}
    #appmsg-loader,#email-loader,#sms-loader{text-align: left !important;}
    #ajaxCall{display: none !important;}
    .alert.alert-info { display: block;}
    .dabhboard-outer.clearfix { 
    min-height: 413px; }
    .stats-internal { 
    padding: 5px;
    }
    .dabhboard-outer .tab-outer .nav-tabs li a { font-size: 14px;}
    .dabhboard-outer .tab-outer .nav-tabs li a i  {padding-right: 0.5em;}
 
</style>
<div class="row">
     
    <div class="col-sm-12" style="margin-bottom:15px;">
        <div class="dabhboard-outer clearfix">
            <div class="row">
                <div class="col-sm-3 tab-outer-column">
                    <div class="tab-outer">
                        <ul id="myTab" class="nav nav-tabs ">
                            <li class=""><a href="#dashboard" class="tab-grey"><i class="fa fa-tachometer" aria-hidden="true"></i> <?= lang('Dashboard') ?></a></li>
                            <li class=""><a href="#sms" class="tab-grey"><i class="fa fa-newspaper-o" aria-hidden="true"></i> <?= lang('SMS') ?></a></li>
                            <li class=""><a href="#email" class="tab-grey"> <i class="fa fa-envelope-o" aria-hidden="true"></i> <?= lang('Email') ?></a></li>
                            <li class=""><a href="#application_msg" class="tab-grey"><i class="fa fa-paper-plane" aria-hidden="true"></i> <?= lang('Application Message') ?></a></li>
                            <li class=""><a href="#group_tab" class="tab-grey"> <i class="fa fa-users" aria-hidden="true"></i> <?= lang('Manage Groups') ?></a></li>
                            <li class=""><a href="#template_tab" class="tab-grey"><i class="fa fa-file-text" aria-hidden="true"></i> <?= lang('Manage Template') ?></a></li>
                            <li class=""><a href="#notifications_tab" class="tab-grey"><i class="fa fa-bell"></i> <?= lang('Notifications') ?></a></li>
                            <li class=""><a href="#setting_tab" class="tab-grey"><i class="fa fa-wrench"></i> <?= lang('Setting') ?></a></li>
                             <li class=""><a href="#sms_log_tab" id="sms_log_invoke" class="tab-grey"><i class="fa fa-list"></i> <?= lang('SMS Log') ?></a></li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content col-sm-9 col-sm-offset-3">
                    <div id="dashboard" class="tab-pane fade in">
                        <?php include_once __DIR__.'/dashboard.php';?>
                    </div>
                    <div id="sms" class="tab-pane fade in">
                        <?php include_once __DIR__.'/sms.php';?>
                    </div>
                    <div id="email" class="tab-pane fade in">
                        <?php include_once __DIR__.'/email.php';?>
                    </div> 
                    <div id="application_msg" class="tab-pane fade in">
                       <?php include_once __DIR__.'/application_msg.php';?>
                    </div>
                    <div id="group_tab" class="tab-pane fade in">
                       <?php include_once __DIR__.'/group.php';?>
                    </div>
                    <div id="template_tab" class="tab-pane fade in">
                        <?php include_once __DIR__.'/template.php';?>
                    </div>
                    <div id="notifications_tab" class="tab-pane fade in">
                       <?php include_once __DIR__.'/notifications.php';?>
                    </div>
                    <div id="setting_tab" class="tab-pane fade in">
                       <?php include_once __DIR__.'/settings.php';?>
                    </div>
                     <div id="sms_log_tab" class="tab-pane fade in">
                       <?php include_once __DIR__.'/sms_log.php';?>
                    </div>
                </div>
            </div>
        </div>
    </div>
   
</div>    
<?php include_once __DIR__.'/js.php';?>