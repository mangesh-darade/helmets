<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?> 

<style>


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
      top:8px;
      right: 10px;
    } 
  
  </style>
<div class="container" >				
<div class="mymodal" id="modal-1" role="dailog">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i>
			</button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('edit_customer'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form');
        echo form_open_multipart("customers/edit/" . $customer->id, $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group">
                    <label class="control-label" for="customer_group"><?php echo $this->lang->line("customer_group"); ?></label>
                        <?php
                        foreach ($customer_groups as $customer_group) {
                            $cgs[$customer_group->id] = $customer_group->name;
                        }
                        echo form_dropdown('customer_group', $cgs, $customer->customer_group_id, 'class="form-control select" id="customer_group" style="width:100%;" required="required"');
                        ?>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <label class="control-label" for="price_group"><?php echo $this->lang->line("price_group"); ?></label>
                        <?php
                        $pgs[''] = lang('select').' '.lang('price_group');
                        foreach ($price_groups as $price_group) {
                            $pgs[$price_group->id] = $price_group->name;
                        }
                        echo form_dropdown('price_group', $pgs, $customer->price_group_id, 'class="form-control select" id="price_group" style="width:100%;"');
                        ?>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group company">
                        <?= lang("company", "company"); ?>
                        <?php echo form_input('company', $customer->company, 'class="form-control tip" id="company"'); ?>
                    </div>
                    <div class="form-group person">
                        <?= lang("name", "name"); ?> *
                        <?php echo form_input('name', $customer->name, 'class="form-control tip" id="name" required="required"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("vat_no", "vat_no"); ?>
                        <?php echo form_input('vat_no', $customer->vat_no, 'class="form-control" id="vat_no"'); ?>
                    </div>
                     <div class="form-group">
                        <?= lang("gstn_no", "gstn_no"); ?>
                        <?php echo form_input('gstn_no', $customer->gstn_no, 'class="form-control" id="gstn_no"  onchange="return validateGstin();"'); ?>
                     </div>
                    <!--<div class="form-group company">
                    <?= lang("contact_person", "contact_person"); ?>
                    <?php //echo form_input('contact_person', $customer->contact_person, 'class="form-control" id="contact_person" required="required"'); ?>
                </div> -->
                     <div class="form-group">
                        <?= lang("email_address", "email_address"); ?>
                        <input type="email" name="email" class="form-control" id="email_address" data-bv-emailaddress data-bv-onerror="onFieldError" data-bv-onsuccess="onFieldSuccess" data-bv-onstatus="onFieldStatus"  value="<?= $customer->email ?>"/><!--type="text"-->
                    </div>
                    <div class="form-group">
                        <?= lang("phone", "phone"); ?> *
                        <input type="tel" name="phone" class="form-control" id="phone" data-bv-phone="true" data-bv-phone-country="US"  onkeypress="return IsNumeric(event,this)" maxlength="10" required="required"  type="text" value="<?= $customer->phone ?>" />
                    </div>
                    <div class="form-group">
                        <?= lang("address", "address"); ?> 
                        <?php echo form_input('address', $customer->address, 'class="form-control" id="address"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("city", "city"); ?> 
                        <?php echo form_input('city', $customer->city, 'class="form-control" id="city" onkeypress="return onlyAlphabets1(event,this);"  type="text" '); ?>
                        <span id="error2" style="color:#a94442;font-size:10px; display: none">please enter alphabets only</span>
                    </div>
                    <div class="form-group">
                        <?= lang("state", "state"); ?>
                        <?php // echo form_input('state', $customer->state, 'class="form-control" id="state"'); ?>
                        <?php
	$st[""] = "";
	foreach ($states as $state) {
		$st[$state->name] = $state->name;
	}
	echo form_dropdown('state', $st, (isset($_POST['state']) ? $_POST['state'] : $customer->state), 'id="state" data-placeholder="' . lang("select") . ' ' . lang("state") . 'class="form-control input-tip select" style="width:100%;height:30px;"');
?>
<br>
<?php echo $this->sma->dbSavedValue($st,$customer->state);?>
                    </div>
                    <div class="form-group">
                        <?= lang("postal_code", "postal_code"); ?>
                        <?php echo form_input('postal_code', $customer->postal_code, 'class="form-control" id="postal_code"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("country", "country"); ?>
                        <?php echo form_input('country', $customer->country, 'class="form-control" id="country" onkeypress="return onlyAlphabets1(event,this);"  type="text" '); ?>
                        <span id="error2" style="color:#a94442;font-size:10px; display: none">please enter alphabets only</span>
                    </div>
                    <div class="form-group">
                            <?= lang('award_points', 'award_points'); ?> 
                            <?= form_input('award_points', set_value('award_points', $customer->award_points), 'class="form-control tip" id="award_points"'); ?>
                    </div>
                    
                    
                    

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                            <?= lang("DOB", "dob"); ?>
                            <?php echo form_input('dob', (isset($_POST['dob']) ? $_POST['dob'] : $this->sma->hrsd($customer->dob)), 'class="form-control input-tip date" id="dob"  '); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("Anniversary Date", "anniversary"); ?>
                        <?php echo form_input('anniversary', (isset($_POST['anniversary']) ? $_POST['anniversary'] : $this->sma->hrsd($customer->anniversary)), 'class="form-control input-tip date" id="anniversary" '); ?>
                    </div>
                    <div class="form-group">
                            <?= lang("Older Child's Birthday", "dob_child1"); ?>
                            <?php echo form_input('dob_child1', (isset($_POST['dob_child1']) ? $_POST['dob_child1'] :  $this->sma->hrsd($customer->dob_child1)), 'class="form-control input-tip date" id="dob_child1"  '); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("Younger Child's Birthday", "dob_child2"); ?>
                        <?php echo form_input('dob_child2', (isset($_POST['dob_child2']) ? $_POST['dob_child2'] : $this->sma->hrsd($customer->dob_child2)), 'class="form-control input-tip date" id="dob_child2"  '); ?>
                    </div>
                    <div class="form-group">
                            <?= lang("Fathers Birthday", "dob_father"); ?>
                            <?php echo form_input('dob_father', (isset($_POST['dob_father']) ? $_POST['dob_father'] :  $this->sma->hrsd($customer->dob_father)), 'class="form-control input-tip date" id="dob_father"  '); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("Mothers Birthday", "dob_mother"); ?>
                        <?php echo form_input('dob_mother', (isset($_POST['dob_mother']) ? $_POST['dob_mother'] : $this->sma->hrsd($customer->dob_mother)), 'class="form-control input-tip date" id="dob_mother"  "'); ?>
                    </div>
 
                  
                    <div class="form-group">
                        <?= lang("ccf1", "cf1"); ?>
                       <?php echo form_input('cf1', $customer->cf1, 'class="form-control" id="pancard"  maxlength="10"  type="text"'); ?>
                        <small class="text-danger" id="errpancard"></small>
                    </div>
                    <div class="form-group">
                        <?= lang("ccf2", "cf2"); ?>
                        <?php echo form_input('cf2', $customer->cf2, 'class="form-control" id="cf2"'); ?>

                    </div>
                    <div class="form-group">
                        <?= lang("ccf3", "cf3"); ?>
                        <?php echo form_input('cf3', $customer->cf3, 'class="form-control" id="cf3"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("ccf4", "cf4"); ?>
                        <?php echo form_input('cf4', $customer->cf4, 'class="form-control" id="cf4"'); ?>

                    </div>
                    <div class="form-group">
                        <?= lang("ccf5", "cf5"); ?>
                        <?php echo form_input('cf5', $customer->cf5, 'class="form-control" id="cf5"'); ?>

                    </div>
                    <div class="form-group">
                        <?= lang("ccf6", "cf6"); ?>
                        <?php echo form_input('cf6', $customer->cf6, 'class="form-control" id="cf6"'); ?>
                    </div>
                    
                    <div class="form-group">
                        <?= lang("Reset E-Shop Password", "eshop_pass"); ?>
                        <input type="password" id="eshop_pass"  name="eshop_pass" class="form-control" placeholder="leave blank if you don’t want to change it">
                    </div>

					
                </div>
            </div>
           

        </div>
        <div class="modal-footer">
            <?php echo form_submit('edit_customer', lang('edit_customer'), 'class="btn btn-primary"'); ?>
         </div>
    </div>
    <?php echo form_close(); ?>
</div>
<!--</div>-->
</div>
<?= $modal_js ?>


<script type="text/javascript">
    $(document).ready(function (e) {
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
        $('.form-control').attr('autocomplete', 'off');
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
                  $('#errpancard').html( "\"<strong>" + pan_card + " </strong>\" this no. invalid, Please enter valid pancard no.")
                  $(this).val(' ');
                }
            }
        });
</script>

