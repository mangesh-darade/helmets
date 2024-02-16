<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?> 

<style>
    #myModal{
       display: block;overflow: scroll;
    }
   // body{overflow: hidden !important;}
.modal.fade {
    -webkit-transition: opacity .3s linear, top .3s ease-out;
    -moz-transition: opacity .3s linear, top .3s ease-out;
    -ms-transition: opacity .3s linear, top .3s ease-out;
    -o-transition: opacity .3s linear, top .3s ease-out;
    transition: opacity .3s linear, top .3s ease-out;
    top: -3%;
}

.modal-header .btnGrp{
      position: absolute;
      top:18px;
      right: 10px;
    } 
  .form-group {
    margin-bottom: 10px;
}
  </style>
<!--<div class="container" >-->				
<div class="mymodal" id="modal-1" role="dailog">
<div class="modal-dialog modal-lg add_quick">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i>
			</button>
            <h4 class="modal-title" id="myModalLabel">Quick <?php echo lang('add_customer'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form', 'id' => 'add-customer-form');
        echo form_open_multipart("customers/add/quick", $attrib ); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>            
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                    <label class="control-label" for="customer_group"><?php echo $this->lang->line("customer_group"); ?></label>
                        <?php
                        foreach ($customer_groups as $customer_group) {
                            $optval = $customer_group->id .'~'.$customer_group->name;
                            $cgs[$optval] = $customer_group->name;
                            $select_cgs = ($Settings->customer_group == $customer_group->id) ? $optval : null;
                        }
                        echo form_dropdown('customer_group', $cgs, $select_cgs, 'id="customer_group" data-placeholder="' . lang("customer_group") . '" class="form-control input-tip select" style="width:100%;height:30px; "  ');

//                        echo form_dropdown('customer_group', $cgs, $select_cgs, ' data-placeholder="' . lang("customer_group") . '" class="form-control input-tip select" id="customer_group" style="width:100%;" required="required"');
                        ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="price_group"><?php echo $this->lang->line("price_group"); ?></label>
                        <?php
                        $pgs[''] = lang('select').' '.lang('price_group');
                        foreach ($price_groups as $price_group) {
                            $pgoptval = $price_group->id .'~'.$price_group->name;
                            $pgs[$pgoptval] = $price_group->name;
                            $select_pg = ($Settings->price_group == $price_group->id) ? $pgoptval : null;
                        }
                        echo form_dropdown('price_group', $pgs, $select_pg, 'id="price_group" data-placeholder="' . lang("price_group") . '" class="form-control input-tip select" style="width:100%;height:30px; "  ');

//                        echo form_dropdown('price_group', $pgs, $select_pg, 'class="form-control  input-tip select" id="price_group" style="width:100%;"');
                        ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group person">
                        <?= lang("name", "name"); ?>
                        <?php echo form_input('name', '', 'class="form-control tip" id="name" data-bv-notempty="true" onkeypress="return onlyAlphabets1(event,this);" type="text" type="text" id="text1" ondrop="return false;" onpaste="return false;"'); ?>
						<span id="error2" style="color:#a94442;font-size:10px; display: none">please enter alphabets only</span>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= lang("phone", "phone"); ?>
                        <input type="tel" name="phone" class="form-control" required="required" id="phone" data-bv-phone="true" data-bv-phone-country="US" maxlength="10" required="required" onkeypress="return IsNumeric(event,this)" type="text" id="text1" ondrop="return false" onpaste="return false">
					    <span id="error" style="color:#a94442; display: none;font-size:11px;">please enter numbers only</span>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group company">
                        <?= lang("company", "company"); ?> 
                        <?php echo form_input('company', '', 'class="form-control tip" id="company"'); ?>                        
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= lang("gstn_no", "gstn_no"); ?>
                       <?php echo form_input('gstn_no', '', 'class="form-control" id="gstn_no"  onchange="return validateGstin();"'); ?>
                    </div>
                </div>
            </div>
             <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                        <?= lang("Pan Card", "Pan Card"); ?>
                        <input type="text" name="pan_card" id="pancard" class="form-control" />
                        <small class="text-danger" id="errpancard"></small>
                    </div>
                </div>
                 <div class="col-md-6">
                    <div class="form-group">
                        <?= lang("email_address", "email_address"); ?>
                        <input type="text" name="email" class="form-control" id="email_address"/>
                    </div> 
                </div>
            </div>    
            <div class="row">
                
                <div class="col-md-12">
                    <div class="form-group">
                        <?= lang("address", "address"); ?>
                        
                        <?php echo form_input('address', '', 'class="form-control" id="address"'); ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">                    
                    <div class="form-group">
                        <?= lang("country", "country"); ?>
                        <?php echo form_input('country', 'India', 'class="form-control" id="country"'); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= lang("state", "state"); ?>
                        <?php //echo form_input('state', '', 'class="form-control" id="state"'); ?>
                         <?php
				$st[""] = "";
				foreach ($states as $state) {
                                    $st_otp = $state->name . '~' . $state->code;
                                    $st[$st_otp] = $state->name.' ('.$state->code.')';
                                    $select_st = (isset($_POST['state']) ? $_POST['state'] : '')==$state->name ? $st_otp :'';
				}
				echo form_dropdown('state', $st, $select_st, 'id="state" data-placeholder="' . lang("select") . '" class="form-control input-tip select" style="width:100%;height:30px;"');
			?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                        <?= lang("city", "city"); ?>
                        <?php echo form_input('city', '', 'class="form-control" id="city"'); ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= lang("postal_code", "postal_code"); ?>
                        <?php echo form_input('postal_code', '', 'class="form-control" id="postal_code" onkeypress="return IsNumeric2(event,this)" type="text" id="text1" ondrop="return false" onpast="return false"'); ?>
                        <span id="error1" style="color:#a94442; display: none;font-size:11px;">please enter numbers only</span>
                    </div>                   
                </div>                
            </div>
           
        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_customer', lang('add_customer'), 'class="btn btn-primary" id="add_customer"'); ?>
         </div>
    </div>
    <?php echo form_close(); ?>
</div>
</div>
<!--</div>-->
<?= $modal_js ?>

<script type="text/javascript">
    $(document).ready(function (e) {
       // $('body').attr('style', 'overflow: hidden !important');
//        $('.bootbox-alert').hide();
        $('.bootbox-alert').modal('hide');
//        $('.modal-dialog').modal('show');
        
        $('.close').click(function(){
            
           // $('body').attr('style', 'overflow: scroll !important');
//            document.body.style.overflow="scroll";
        });
        
        $('#add-customer-form').bootstrapValidator({
            feedbackIcons: {
                valid: 'fa fa-check',
                invalid: 'fa fa-times',
                validating: 'fa fa-refresh'
            }, excluded: [':disabled']
        });
        $('select.select').select2({minimumResultsForSearch: 7});
        fields = $('.modal-content').find('.form-control');
        $.each(fields, function () {
            var id = $(this).attr('id');
            var iname = $(this).attr('name');
            var iid = '#' + id;
            if (!!$(this).attr('data-bv-notempty') || !!$(this).attr('required')) {
                $("label[for='" + id + "']").append(' *');
                $(document).on('change', iid, function () {
                    $('form[data-toggle="validator"]').bootstrapValidator('revalidateField', iname);
                });
            }
        });
    });
    
  var specialKeys = new Array();
		specialKeys.push(8); //Backspace
		function IsNumeric(e,t) {
		var keyCode = e.which ? e.which : e.keyCode
		var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
		document.getElementById("error").style.display = ret ? "none" : "inline";
		return ret;
		}
		
		function IsNumeric2(e,t) {
		var keyCode = e.which ? e.which : e.keyCode
		var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
		document.getElementById("error1").style.display = ret ? "none" : "inline";
		return ret;
		}
		
		 function onlyAlphabets1(e, t) {
                    var charCode = e.which ? e.which : e.keyCode
                    var ret= (charCode == 32 || (charCode>=97 && charCode<=122)|| (charCode>=65 && charCode<=90));
                    document.getElementById("error2").style.display = ret ? "none" : "inline";
		return ret;	
               } 
               
          $('#pancard').change(function(){
        $('#errpancard').html(" ");
        var patt =/^[A-Za-z]{5}[0-9]{4}[A-Za-z]{1}$/;
        var pan_card = $(this).val();
        if(patt.test(pan_card)){
            $('#errpancard').html(" ");
        } else {
           if(pan_card !=''){
             $('#errpancard').html("\"<strong>" + pan_card + " </strong>\" this no. invalid, Please enter valid pancard no.");
             $(this).val(" "); 
           }

        }
    });   
    
    $('#add_customer').click(function(){
        $('#errpancard').html(" ");
        if($('#pancard').val()==''){
            return true;
        } else {
            var patt =/^[A-Za-z]{5}[0-9]{4}[A-Za-z]{1}$/;
            var pan_card = $('#pancard').val();
            if(patt.test(pan_card)){
                return true;
            } else {
              $('#errpancard').html("\"<strong>" + pan_card + " </strong>\" this no. invalid, Please enter valid pancard no.");
                $('#pancard').val(" ");
                return false;
            }
        }
        return false;
    });
                 
    
</script>
