<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<style>
    #s2id_customers{
        display:block !important;
    }
    li.form-group{
        list-style-type:none;
    }
</style>
<div class="row">
    <?php
    $attrib = array('role' => 'form', 'name' => "sendsmsemail", id => "sendsmsemail");
    echo form_open_multipart("sendsmsemail/add", $attrib)
    ?>
    <div class="col-sm-4 contact-group">
		<div class="box">
			<div class="box-header"><h2 class="blue">Customer List *</h2></div>
			<div class="box-content clearfix">
				<select id="customers" multiple="multiple" required="required"></select>
				<input type="hidden" value="" name="hiddencust" id="hiddencust">
				<ul style="margin-top:15px;">
					<div class="row">
						<li class="col-xs-4 form-group"> 
							<a class="bblue white quick-button small group_button" data-value="7552985733/possales@simplysafe.in" id="group" href="javascript:void(this.value);">
								<i class="fa fa-user"></i>
								<p>Group 1</p>
							</a>
						</li>
						<li class="col-xs-4 form-group"> 
							<a class="bdarkGreen white quick-button small group_button" data-value="9999985733/possales@simplysafe.in" id="group2" href="javascript:void(this.value);">
								<i class="fa fa-user"></i>
								<p>Group 2</p>
							</a>
						</li>
						<li class="col-xs-4 form-group"> 
							<a class="borange white quick-button small group_button" data-value="7552985733/possales@simplysafe.in" id="group3" href="javascript:void(this.value);">
								<i class="fa fa-user"></i>
								<p>Group 3</p>
							</a>
						</li>
						<li class="col-xs-4 form-group"> 
							<a class="blightOrange white quick-button small group_button" data-value="71124575733/possales@simplysafe.in" id="group4" href="javascript:void(this.value);">
								<i class="fa fa-user"></i>
								<p>Group 4</p>
							</a>
						</li>

						<li class="col-xs-4 form-group"> 
							<a class="bblue white quick-button small group_button" data-value="7566625133/possales@simplysafe.in" id="group5" href="javascript:void(this.value);">
								<i class="fa fa-user"></i>
								<p>Group 5</p>
							</a>
						</li>
						<li class="col-xs-4 form-group"> 
							<a class="bdarkGreen white quick-button small group_button" data-value="9564815733/possales@simplysafe.in" id="group6" href="javascript:void(this.value);">
								<i class="fa fa-user"></i>
								<p>Group 6</p>
							</a>
						</li>
						<li class="col-xs-4 form-group"> 
							<a class="borange white quick-button small group_button" data-value="9992985733/possales@simplysafe.in" id="group7" href="javascript:void(this.value);">
								<i class="fa fa-user"></i>
								<p>Group 7</p>
							</a>
						</li>
						<li class="col-xs-4 form-group"> 
							<a class="blightOrange white quick-button small group_button" data-value="9568985733/possales@simplysafe.in" id="group8" href="javascript:void(this.value);">
								<i class="fa fa-user"></i>
								<p>Group 8</p>
							</a>
						</li>
					</div>
				</ul>
				<input type="hidden" value="" name="hiddencust" id="group_id">
			</div>
		</div>
    </div>

    <div class="col-sm-8">

        <ul id="myTab" class="nav nav-tabs">
            <li class=""><a href="#sms" class="tab-grey"><?= lang('SMS') ?></a></li>
            <li class=""><a href="#email" class="tab-grey"><?= lang('Email') ?></a></li>
            <li class=""><a href="#application_msg" class="tab-grey"><?= lang('Application Message') ?></a></li>
        </ul>

        <div class="tab-content">

            <div id="sms" class="tab-pane fade in">

                <div class="box">
                    <div class="box-header">
                        <h2 class="blue"><i class="fa-fw fa fa-edit nb"></i><?= lang('SMS'); ?></h2>
                    </div>
                    <div class="box-content">
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="row">
                                    <div class="col-lg-8">
                                        <div class="form-group all"> 
                                            <?= lang("Message *", "product_details") ?>
                                            <textarea name="note" cols="40" rows="7" class="form-control skip" id="sms_body"></textarea>
                                            <div class="sms_note blue"><span id="max_sms_chars">160</span> characters remaining</div>          
                                        </div>
                                                      

                                    </div>
                                    <div class="col-lg-4">
                                        <label for="product_details">  Available Template</label>
										<div class="message-template well">
											<ul>
												<li><a data-message="birthday" id="msg1" href="javascript:void(0);">B'day Wish</a></li>
												<li><a data-message="anniversary" id="msg2" href="javascript:void(0);">Anniversary Wish</a></li>
												<li><a data-message="new_year" id="msg3" href="javascript:void(0);">New Year Wish</a></li>
												<li><a data-message="deepawali" id="msg4" href="javascript:void(0);">Deepawali Wish</a></li>
												<li><a data-message="x_mas" id="msg5" href="javascript:void(0);">X'mas Wish</a></li>
											</ul>
										</div>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-6">
                                        <p><?php echo form_submit('send_sms', lang('Send SMS'), 'class="btn btn-primary"'); ?></p>
										<div class="sms_note blue">(Note : Available SMS limit <?php print((int) $sms_limit) ?>)</div> 
                                    </div>    
                                </div>


                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="email" class="tab-pane fade in">
                <div class="box">
                    <div class="box-header">
                        <h2 class="blue"><i class="fa-fw fa fa-edit nb"></i><?= lang('Email'); ?></h2>
                    </div>
                    <div class="box-content">
                        <div class="row">
                            <div class="col-lg-12"> 
                                <div class="row">
                                    <div class="col-lg-6"> 
                                        <div class="form-group all">
                                            <?= lang("Subject *", "subject") ?>
                                            <?= form_input('subject', '', 'class="form-control" id="subject" '); ?>
                                        </div> 


                                    </div>
                                    <div class="col-lg-6">

                                        <div class="form-group all">
                                            <?= lang("Sender", "subject") ?>
                                            <?php
                                            $email_placeholder = '';
                                            if (empty($default_email)) {
                                                $email_placeholder = 'placeholder="Please provide your email in profile"';
                                            }
                                            ?>
                                            <?= form_input('sender', $default_email, 'class="form-control" id="sender"  readonly="true" ' . $email_placeholder); ?>
                                        </div>

                                    </div>
                                    <div class="col-lg-12"> <div class="form-group">
                                            <?= lang("Image ", "product_details") ?>
                                            <input id="image" type="file" data-browse-label="<?= lang('browse'); ?>" name="image" data-show-upload="false"
                                                   data-show-preview="false" accept="image/*" class="form-control file">
                                        </div></div> 
                                    <div class="col-lg-8"> 
										<label for="product_details">Message *</label>
										<textarea name="note" cols="40" rows="50" class="form-control" id="note"></textarea>
									</div>
									<div class="col-lg-4">
                                        <label for="product_details">  Available Template</label>
										<div class="message-template well">
											<ul>
												<li><a data-message="birthday" id="mail_msg1" href="javascript:void(0);">B'day Wish</a></li>
												<li><a data-message="anniversary" id="mail_msg2" href="javascript:void(0);">Anniversary Wish</a></li>
												<li><a data-message="new_year" id="mail_msg3" href="javascript:void(0);">New Year Wish</a></li>
												<li><a data-message="deepawali" id="mail_msg4" href="javascript:void(0);">Deepawali Wish</a></li>
												<li><a data-message="x_mas" id="mail_msg5" href="javascript:void(0);">X'mas Wish</a></li>
											</ul>
										</div>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-lg-12">
                                        <br>
                                        <p><?php echo form_submit('send_email', lang('Send Email'), 'class="btn btn-primary"'); ?><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#preview" style="margin-left:15px;">Preview</button><button type="button" class="btn btn-primary pull-right" data-toggle="modal">Custom Template</button></p>
                                    </div>    
                                </div>
								<!-- Modal -->
								<div id="preview" class="modal fade" role="dialog">
									<div class="modal-dialog">

										<!-- Modal content-->
										<div class="modal-content">
											<div class="modal-header">
												<button type="button" class="close" data-dismiss="modal">&times;</button>
												<h4 class="modal-title">Message priview</h4>
											</div>
											<div class="modal-body">
												<p>Message content</p>
											</div>
											<div class="modal-footer">
												<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
											</div>
										</div>

									</div>
								</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div> 
            <div id="application_msg" class="tab-pane fade in">
                <div class="box">
                    <div class="box-header">
                        <h2 class="blue"><i class="fa-fw fa fa-edit nb"></i><?= lang('Application Message'); ?></h2>
                    </div>
                    <div class="box-content">
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group all">
                                    <?= lang("Subject *", "subject") ?>
                                    <?= form_input('subject', '', 'class="form-control" id="subject" '); ?>
                                </div>
                                <div class="form-group">
                                    <?= lang("Unicode ", "product_details") ?>
                                    <?php $yn = array('1' => lang('yes'), '0' => lang('no')); ?>   
                                    <?= form_dropdown('unicode', $yn, '', 'class="form-control" id="unicode"  '); ?>                           

                                </div>

                            </div>
                            <div class="col-lg-6">

                                <div class="form-group">
                                    <?= lang("Message Type ", "product_details") ?>
                                    <?php $yn1 = array('promotional' => lang('Promotional'), 'transactional' => lang('Transactional')); ?>   
                                    <?= form_dropdown('msgtype', $yn1, '', 'class="form-control" id="msgtype"  '); ?>                           

                                </div>


                                <div class="form-group">
                                    <?= lang("Image ", "product_details") ?>
                                    <input id="image" type="file" data-browse-label="<?= lang('browse'); ?>" name="image" data-show-upload="false"
                                           data-show-preview="false" accept="image/*" class="form-control file">
                                </div>
                            </div>
                            <div class="col-lg-8">
								<label for="product_details">Message *</label>
                                <textarea name="note" cols="40" rows="7" class="form-control skip" id="notification_note"></textarea>
                            </div>
							<div class="col-lg-4">
								<label for="product_details">  Available Template</label>
								<div class="well message-template">
									<ul>
										<li><a data-message="birthday" id="notification_msg1" href="javascript:void(0);">B'day Wish</a></li>
										<li><a data-message="anniversary" id="notification_msg2" href="javascript:void(0);">Anniversary Wish</a></li>
										<li><a data-message="new_year" id="notification_msg3" href="javascript:void(0);">New Year Wish</a></li>
										<li><a data-message="deepawali" id="notification_msg4" href="javascript:void(0);">Deepawali Wish</a></li>
										<li><a data-message="x_mas" id="notification_msg5" href="javascript:void(0);">X'mas Wish</a></li>
									</ul>
								</div>
							</div>
                        </div>


                        <div class="row">
                            <div class="col-lg-12">
                                <br>
                                <p><?php echo form_submit('send_application_msg', lang('Send Application Message'), 'class="btn btn-primary"'); ?><button type="button" class="btn btn-primary" data-toggle="modal" data-target="#app_preview" style="margin-left:15px;">Preview</button><button type="button" class="btn btn-primary pull-right" data-toggle="modal">Custom Template</button></p>
                            </div>    
                        </div>
						<!-- Modal -->
						<div id="app_preview" class="modal fade" role="dialog">
							<div class="modal-dialog">

								<!-- Modal content-->
								<div class="modal-content">
									<div class="modal-header">
										<button type="button" class="close" data-dismiss="modal">&times;</button>
										<h4 class="modal-title">Message priview</h4>
									</div>
									<div class="modal-body">
										<p>Message content</p>
									</div>
									<div class="modal-footer">
										<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
									</div>
								</div>

							</div>
						</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <?= form_close(); ?>  
</div>    

<script type="text/javascript">

    function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test($email);
    }

    $(document).ready(function () {
        var smsLength = 160;
        $('#sms_body').keyup(function () {
            var length = $(this).val().length;

            $('#max_sms_chars').text(smsLength - length);
        });


        $.ajax({
            type: "get",
            async: false,
            url: "<?= site_url('customers/getCustomers') ?>",
            data: "data",
            dataType: "json",
            success: function (data) {
                $('#customers').select2("destroy").empty().select2({closeOnSelect: false});
                $.each(data.aaData, function () {
                    //console.log(data.aaData);
                    $("<option />", {value: this['4'] + ':' + this['3'], text: this['4'] + '/' + this['3'] + ''}).appendTo($('#customers'));
                });
                $('#customers').select2('val');

                $("#customers option").each(function () {
                    $customer_list = $(this).val();

                });
            },
            error: function () {

            }

        });
        $("#sendsmsemail").submit(function (event) {

            var cust_list = $('.select2-container').select2('val');
            $('#hiddencust').val(cust_list);
            var subject = $('#subject').val();
            if (subject.trim() == '') {
                alert('Please Enter Subject ');
                $('#subject').focus();
                return false;
                event.preventDefault();
            }
            var email_opt = '';
            $('input[name="cmbtype[]"]:checked').each(function () {
                if (this.value == 'email') {
                    email_opt = 1

                }
            });
            if (email_opt == 1) {
                var sender = $('#sender').val();
                if (sender.trim() == '') {
                    alert('Please Enter Sender Email1');
                    $('#sender').focus();
                    return false;
                    event.preventDefault();
                }

            }


        });
    });
</script>
<script>
$(document).ready(function(){
    $("#msg1").click(function(){
       var a = $('#msg1').data('message'); //getter
		 $("#sms_body").html(a);
    });
	$("#msg2").click(function(){
       var a = $('#msg2').data('message'); //getter
		 $("#sms_body").html(a);
    });
	$("#msg3").click(function(){
       var a = $('#msg3').data('message'); //getter
		 $("#sms_body").html(a);
    });
	$("#msg4").click(function(){
       var a = $('#msg4').data('message'); //getter
		 $("#sms_body").html(a);
    });
	$("#msg5").click(function(){
       var a = $('#msg5').data('message'); //getter
		 $("#sms_body").html(a);
    });
	
	
	 $("#mail_msg1").click(function(){
       var a = $('#mail_msg1').data('message'); //getter
		 $(".redactor_form-control").html(a);
    });
	$("#mail_msg2").click(function(){
       var a = $('#mail_msg2').data('message'); //getter
		 $(".redactor_form-control").html(a);
    });
	$("#mail_msg3").click(function(){
       var a = $('#mail_msg3').data('message'); //getter
		 $(".redactor_form-control").html(a);
    });
	$("#mail_msg4").click(function(){
       var a = $('#mail_msg4').data('message'); //getter
		 $(".redactor_form-control").html(a);
    });
	$("#mail_msg5").click(function(){
       var a = $('#mail_msg5').data('message'); //getter
		 $(".redactor_form-control").html(a);
    });
	
	
	$("#notification_msg1").click(function(){
       var a = $('#notification_msg1').data('message'); //getter
		 $("#notification_note").html(a);
    });
	$("#notification_msg2").click(function(){
       var a = $('#notification_msg2').data('message'); //getter
		 $("#notification_note").html(a);
    });
	$("#notification_msg3").click(function(){
       var a = $('#notification_msg3').data('message'); //getter
		 $("#notification_note").html(a);
    });
	$("#notification_msg4").click(function(){
       var a = $('#notification_msg4').data('message'); //getter
		 $("#notification_note").html(a);
    });
	$("#notification_msg5").click(function(){
       var a = $('#notification_msg5').data('message'); //getter
		 $("#notification_note").html(a);
    });
	
	
	$(".group_button").click(function(){
       var a = $(this).data('value'); //getter
		 //$("#customers").html('<option>'+a+'</option>');
		 //$("#s2id_customers").html('<ul class="select2-choices"><li class="select2-search-choice"><div>'+a+'<a href="#" class="select2-search-choice-close" tabindex="-1"></a></div></li></ul>');
		 //document.getElementById("customers").reset();
		 $('.select2-choices .select2-search-choice').remove();
    });
	$(".group_button").on("click", function () {
		$('#customers option').prop('selected', function() {
			return this.defaultSelected;
		});
	});
	$(".group_button").click(function(){
		var group_id = $(this).attr('id');
		$("#group_id").val(group_id);
	});
});
</script>
<script>
$(document).ready(function() {
    $( document ).on( 'click', 'a.group_button', function () {
        $('a.group_button').removeClass('active'); 
        $(this).addClass('active');
    });
});
$(document).ready(function() {
    $( document ).on( 'change', '#customers', function () {
        $('a.group_button').removeClass('active');
		$("#group_id").val('');
    });
});
$(document).ready(function() {
    $( document ).on( 'click', '#select2-choices', function () {
        $('a.group_button').removeClass('active'); 
        $('#group_id').removeVal(); 
    });
});
</script>
