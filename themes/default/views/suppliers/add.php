<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?> 

<style>


   .modal.fade {
    -webkit-transition: opacity .3s linear, top .3s ease-out;
    -moz-transition: opacity .3s linear, top .3s ease-out;
    -ms-transition: opacity .3s linear, top .3s ease-out;
    -o-transition: opacity .3s linear, top .3s ease-out;
    transition: opacity .3s linear, top .3s ease-out;
    top: -25%;
}

.modal-header .btnGrp{
      position: absolute;
      top:8px;
      right: 10px;
    } 
  
  </style>
<div class="container" style="margin-top:150px;">				
<div class="mymodal" id="modal-1" role="dailog">
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-times"></i>
			</button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('add_supplier'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form','id' => 'add-suppliers-form');
        echo form_open_multipart("suppliers/add", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <!--<div class="form-group">
                    <?= lang("type", "type"); ?>
                    <?php $types = array('company' => lang('company'), 'person' => lang('person'));
            echo form_dropdown('type', $types, '', 'class="form-control select" id="type" data-bv-notempty="true" required="required"'); ?>
                </div> -->

            <div class="row">
                <div class="col-md-6">
                    <div class="form-group company">
                        <?= lang("company", "company"); ?>
                        <?php echo form_input('company', '', 'class="form-control tip" id="company" data-bv-notempty="true"'); ?>
                    </div>
                    <div class="form-group person">
                        <?= lang("name", "name"); ?> 
                        <?php echo form_input('name', '', 'class="form-control tip" id="name" required="required" data-bv-notempty="true" onkeypress="return onlyAlphabets(event,this);" type="text" ondrop="return false;" onpaste="return false;"'); ?>
			<span id="error1" style="color:#a94442;font-size:11px; display: none">please enter alphabets only</span>
                    </div>
                    <div class="form-group">
                        <?= lang("vat_no", "vat_no"); ?>
                        <?php echo form_input('vat_no', '', 'class="form-control" id="vat_no"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("gstn_no", "gstn_no"); ?>
                       <?php echo form_input('gstn_no', '', 'class="form-control" id="gstn_no"  onchange="return validateGstin();"'); ?>
                   </div>
                    <!--<div class="form-group company">
                    <?= lang("contact_person", "contact_person"); ?>
                    <?php echo form_input('contact_person', '', 'class="form-control" id="contact_person" data-bv-notempty="true"'); ?>
                </div>-->
                    <div class="form-group">
                        <?= lang("email_address", "email_address"); ?>
                        <input type="text" name="email" class="form-control" id="email_address" data-bv-emailaddress
        data-bv-onerror="onFieldError" data-bv-onsuccess="onFieldSuccess" data-bv-onstatus="onFieldStatus"/>
                    </div>
                    <div class="form-group">
                        <?= lang("phone", "phone"); ?> 
                        <input type="tel" name="phone" class="form-control" required="required" data-bv-phone="true" data-bv-phone-country="US" maxlength="10" id="phone" onkeypress="return IsNumeric(event)" ondrop="return false" onpaste="return false"/>
		        <span id="error" style="color:#a94442; display: none;font-size:11px;">please enter numbers only</span>
                    </div>
                    <div class="form-group">
                        <?= lang("address", "address"); ?> 
                        <?php echo form_input('address', '', 'class="form-control" id="address"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("city", "city"); ?> 
                        <?php echo form_input('city', '', 'class="form-control" id="city" onkeypress="return onlyAlphabets1(event,this);" type="text" ondrop="return false;" onpaste="return false;"'); ?>
						<span id="error2" style="color:#a94442;font-size:11px; display: none">please enter alphabets only</span>
                    </div>
                    <div class="form-group">
                        <?= lang("state", "state"); ?>
                         <?php
				$st[""] = "";
				foreach ($states as $state) {
					$st[$state->name] = $state->name;
				}
				echo form_dropdown('state', $st, (isset($_POST['state']) ? $_POST['state'] : $supplier->state), 'id="state" data-placeholder="' . lang("select") . ' ' . lang("state") . 'class="form-control input-tip select" style="width:100%; height:30px;"');
			?>
                    </div>

                </div>
                <div class="col-md-6">
                    <div class="form-group">
                        <?= lang("postal_code", "postal_code"); ?>
                        <?php echo form_input('postal_code', '', 'class="form-control" id="postal_code" onkeypress="return IsNumeric1(event)" ondrop="return false"'); ?>

						<span id="errorp" style="color:#a94442; display: none;font-size:11px;">please enter numbers only</span>
                    </div>
                    <div class="form-group">
                        <?= lang("country", "country"); ?>
                        <?php echo form_input('country', '', 'class="form-control" id="country" onkeypress="return onlyAlphabets3(event,this);" type="text" ondrop="return false;" onpaste="return false;"'); ?>
						<span id="error4" style="color:#a94442;font-size:11px; display: none">please enter alphabets only</span>
                    </div>
                    <div class="form-group">
                        <?= lang("scf1", "cf1"); ?>
                        <?php echo form_input('cf1', '', 'class="form-control" id="cf1"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("scf2", "cf2"); ?>
                        <?php echo form_input('cf2', '', 'class="form-control" id="cf2"'); ?>

                    </div>
                    <div class="form-group">
                        <?= lang("scf3", "cf3"); ?>
                        <?php echo form_input('cf3', '', 'class="form-control" id="cf3"'); ?>
                    </div>
                    <div class="form-group">
                        <?= lang("scf4", "cf4"); ?>
                        <?php echo form_input('cf4', '', 'class="form-control" id="cf4"'); ?>

                    </div>
                    <div class="form-group">
                        <?= lang("scf5", "cf5"); ?>
                        <?php echo form_input('cf5', '', 'class="form-control" id="cf5"'); ?>

                    </div>
                    <div class="form-group">
                        <?= lang("scf6", "cf6"); ?>
                        <?php echo form_input('cf6', '', 'class="form-control" id="cf6"'); ?>
                    </div>
                </div>
            </div>


        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_supplier', lang('add_supplier'), 'class="btn btn-primary"'); ?>
         </div>
    </div>
    <?php echo form_close(); ?>
</div>
</div>
</div>
<?= $modal_js ?>
<script type="text/javascript">
    $(document).ready(function (e) {
        $('#add-suppliers-form').bootstrapValidator({
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
        function onlyAlphabets(e, t) {
                    var charCode = e.which ? e.which : e.keyCode
                    var ret= (charCode == 32 || (charCode>=97 && charCode<=122)|| (charCode>=65 && charCode<=90));
                    document.getElementById("error1").style.display = ret ? "none" : "inline";
					return ret;
					
        }
		
    	           
        function onlyAlphabets1(e, t) {
                    var charCode = e.which ? e.which : e.keyCode
                    var ret= (charCode == 32 || (charCode>=97 && charCode<=122)|| (charCode>=65 && charCode<=90));
                    document.getElementById("error2").style.display = ret ? "none" : "inline";
					return ret;
					
        }
		 function onlyAlphabets2(e, t) {
                    var charCode = e.which ? e.which : e.keyCode
                    var ret= (charCode == 32 || (charCode>=97 && charCode<=122)|| (charCode>=65 && charCode<=90));
                    document.getElementById("error3").style.display = ret ? "none" : "inline";
					return ret;
					
        }
		 function onlyAlphabets3(e, t) {
                    var charCode = e.which ? e.which : e.keyCode
                    var ret= (charCode == 32 || (charCode>=97 && charCode<=122)|| (charCode>=65 && charCode<=90));
                    document.getElementById("error4").style.display = ret ? "none" : "inline";
					return ret;
					
        }
             
		
		  function IsNumeric(e) {
		        var keyCode = e.which ? e.which : e.keyCode
				var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
				document.getElementById("error").style.display = ret ? "none" : "inline";
				return ret;
		}
 
         function IsNumeric1(e) {
		        var keyCode = e.which ? e.which : e.keyCode
				var ret = ((keyCode >= 48 && keyCode <= 57) || specialKeys.indexOf(keyCode) != -1);
				document.getElementById("errorp").style.display = ret ? "none" : "inline";
				return ret;
		}  
    
</script>