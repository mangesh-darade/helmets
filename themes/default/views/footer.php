<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<input type="hidden" name="permission_owner" id="permission_owner" value="<?php echo $Owner; ?>">
<input type="hidden" name="permission_admin" id="permission_admin" value="<?php echo $Admin; ?>">
<input type="hidden" name="page_mode" id="page_mode" value="<?php if($page_mode) echo $page_mode; ?>">
<div class="clearfix"></div>
<?= '</div></div></div></td></tr></table></div></div>'; ?>
<div class="clearfix"></div>
<footer>
<a href="#" id="toTop" class="blue" style="position: fixed; bottom: 30px; right: 30px; font-size: 30px; display: none;">
    <i class="fa fa-chevron-circle-up"></i>
</a>

    <p style="text-align:center;">&copy; <?= date('Y') . " " . $Settings->site_name; ?> ( V 4.00 )  </p>
</footer>
<?= '</div>'; ?>
<div class="modal fade in" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"></div>
<div class="modal fade in" id="myModal2" tabindex="-1" role="dialog" aria-labelledby="myModalLabel2" aria-hidden="true"></div>
<div id="modal-loading" style="display:none;">
    <div class="blackbg"></div>
    <div class="loader"></div>
</div>
<div id="ajaxCall"><i class="fa fa-spinner fa-pulse"></i></div>

<audio id="myAudio">
  <source src="alertsound.ogg" type="audio/ogg">
  <source src="<?= $assets ?>sounds/alertsound.mp3" type="audio/mpeg">
  Your browser does not support the audio element.
</audio>

<?php unset($Settings->setting_id, $Settings->smtp_user, $Settings->smtp_pass, $Settings->smtp_port, $Settings->update, $Settings->reg_ver, $Settings->allow_reg, $Settings->default_email, $Settings->mmode, $Settings->timezone, $Settings->restrict_calendar, $Settings->restrict_user, $Settings->auto_reg, $Settings->reg_notification, $Settings->protocol, $Settings->mailpath, $Settings->smtp_crypto, $Settings->corn, $Settings->customer_group, $Settings->envato_username, $Settings->purchase_code); ?>
<script type="text/javascript">
var dt_lang = <?=$dt_lang?>, dp_lang = <?=$dp_lang?>, site = <?=json_encode(array('base_url' => base_url(), 'settings' => $Settings, 'dateFormats' => $dateFormats))?>;
var lang = {paid: '<?=lang('paid');?>', pending: '<?=lang('pending');?>', completed: '<?=lang('completed');?>', ordered: '<?=lang('ordered');?>', received: '<?=lang('received');?>', partial: '<?=lang('partial');?>', sent: '<?=lang('sent');?>', r_u_sure: '<?=lang('r_u_sure');?>', due: '<?=lang('due');?>', returned: '<?=lang('returned');?>', transferring: '<?=lang('transferring');?>', active: '<?=lang('active');?>', inactive: '<?=lang('inactive');?>', unexpected_value: '<?=lang('unexpected_value');?>', select_above: '<?=lang('select_above');?>', download: '<?=lang('download');?>'};
</script>
<?php
$s2_lang_file = read_file('./assets/config_dumps/s2_lang.js');
foreach (lang('select2_lang') as $s2_key => $s2_line) {
    $s2_data[$s2_key] = str_replace(array('{', '}'), array('"+', '+"'), $s2_line);
}
$s2_file_date = $this->parser->parse_string($s2_lang_file, $s2_data, true);
?>
<script type="text/javascript" src="<?= $assets ?>js/bootstrap.min.js"></script>
<?php if(isset($page_product_varient_report)){ ?>
<script type="text/javascript" src="<?= $assets ?>js/datatable_column/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/datatable_column/dataTables.bootstrap.min.js"></script>
<?php }else{ ?>
<script type="text/javascript" src="<?= $assets ?>js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/jquery.dataTables.dtFilter.min.js"></script>
<?php } ?>
<script type="text/javascript" src="<?= $assets ?>js/select2.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/jquery-ui.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/bootstrapValidator.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/jquery.calculator.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/core.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/perfect-scrollbar.min.js"></script>
<script type="text/javascript" src="<?= $assets ?>js/bootstrap-tagsinput.min.js"></script>

<?= ($m == 'purchases' && ($v == 'add' || $v == 'edit' || $v == 'purchase_by_csv')) ? '<script type="text/javascript" src="' . $assets . 'js/purchases.js"></script>' : ''; ?>
<?= ($m == 'transfers' && ($v == 'add' || $v == 'edit')) ? '<script type="text/javascript" src="' . $assets . 'js/transfers.js"></script>' : ''; ?>
<?= ($m == 'sales' && ($v == 'add' || $v == 'edit')) ? '<script type="text/javascript" src="' . $assets . 'js/sales.js"></script>' : ''; ?>
<?= ($m == 'quotes' && ($v == 'add' || $v == 'edit')) ? '<script type="text/javascript" src="' . $assets . 'js/quotes.js"></script>' : ''; ?>
<?= ($m == 'products' && ($v == 'add_adjustment' || $v == 'edit_adjustment')) ? '<script type="text/javascript" src="' . $assets . 'js/adjustments.js"></script>' : ''; ?>
<?= ($m == 'transfers' && ($v== 'request' )) ? '<script type="text/javascript" src="' . $assets . 'js/transfers_request.js"></script>' : ''; ?>
<script type="text/javascript">
$(document).ready(function(){
	var QtyTab = $('#QtyTab').val();
	if(QtyTab==1){
		$('.tab-pane').removeClass('in');
		$('.tab-pane').removeClass('active');
		$('#damages').removeClass('fade');
		$('#damages').addClass('active');
		$('#myTab li').removeClass('active');
		$('.Qty_Adjustment_Class').addClass('active');
	}
});
</script>
<script type="text/javascript" charset="UTF-8">

$(document).ready(function(){

    var r_u_sure = "<?=lang('r_u_sure')?>";
    <?=$s2_file_date?>
    $.extend(true, $.fn.dataTable.defaults, {"oLanguage":<?=$dt_lang?>});
    $.fn.datetimepicker.dates['sma'] = <?=$dp_lang?>;
    $(window).load(function () {
        $('.mm_<?=$m?>').addClass('active');
        $('.mm_<?=$m?>').find("ul").first().slideToggle();
        $('#<?=$m?>_<?=$v?>').addClass('active');
        $('.mm_<?=$m?> a .chevron').removeClass("closed").addClass("opened");
    });

    setTimeout(function(){
        $('#ajaxCall').hide();
    }, 10000);
    
});

 var alertOn = false;
  
    function changeText() { 
      
        $.ajax({
            type: "get", 
            async: false,
            url: '<?= base_url("eshop/new_orders")?>',
            dataType: "json",
            success: function (data) { 
                
                if(data.num) {
                    $('#eshop_new_orders').html(data.num);
                    if(data.new_order > 0) {
                         playSound(1);
                        $('#eshop-order-alert').html('<div class="alert alert_notify alert-success"><button type="button" class="close fa-2x" onclick="notify_close()" >&times;</button> '+data.new_order+' new orders received from E-shop.</div>');
                        if(alertOn == false) {
                            $('.alert_notify').show();
                            alertOn = true;
                        }                    
                    } 

                    if(alertOn == true) { 
                        setTimeout(function(){
                            $('.alert_notify').hide();
                            alertOn = false;
                        }, 19000);
                    }
                }
            }
        });
    }
    
    function playSound(Play)
    {
        var x = document.getElementById("myAudio"); 
        if(Play==1){
            x.play();
            setTimeout( function(){ x.pause();  } , 4000);
        }
    }
	
   
<?php if ($Settings->pos_type == 'restaurant') { ?>	
 
    function changeText1(){
         $.ajax({
            type: "get", 
            async: false,
            url: '<?= base_url("urban_piper/new_orders")?>',
            dataType: "json",
            success: function (data) { 
                
                if(data.num) {
                    $('#urbanpipersorder').html(data.num);
                    
                    if(data.new_order > 0) {
                        playSound(1);
                        $('#urbanpiper-order-alert').html('<div class="alert alert_notify alert-success"><button type="button" class="close fa-2x" onclick="upnotify_close()" >&times;</button> '+data.new_order+' new orders received from Urbanpiper.</div>');
                        if(alertOn == false) {
                            $('.alert_notify').show();
                            alertOn = true;
                        }                    
                    } 

                    if(alertOn == true) { 
                        setTimeout(function(){
                            $('.alert_notify').hide();
                            alertOn = false;
                        }, 19000);
                    }
                }
            }
        });
    }
    
	function upnotify_close(){
        $.ajax({
            type: "get", 
            async: false,
            url: '<?= base_url("urban_piper/new_orders_alert/2")?>',
            dataType: "json",
            success: function (data) {
                $('.alert_notify').hide();
            }
        });
    }

	setInterval(changeText1, 30000);
    changeText1();
	
<?php }//end if ?>		
    
    function notify_close(){
        $.ajax({
            type: "get", 
            async: false,
            url: '<?= base_url("eshop/new_orders_alert")?>',
            dataType: "json",
            success: function (data) {
                $('.alert_notify').hide();
            }
        });
    }       
	
	
    setInterval(changeText, 30000);
    changeText();
    
 
</script>


</body>
</html>
