<script type="text/javascript"> 
var data_tbl = '';
    function validateEmail($email) {
        var emailReg = /^([\w-\.]+@([\w-]+\.)+[\w-]{2,4})?$/;
        return emailReg.test($email);
    }


    function getSmsTabIndex() {
        if ($(".sms_tab li").hasClass('active')) {
            sms_tab_id = $(".sms_tab li.active").attr('id');
            sms_tab_id = sms_tab_id.replace('-1', '');
        }
        return sms_tab_id;
    }

    function getEmailTabIndex() {
        if ($(".email_tab li").hasClass('active')) {
            email_tab_id = $(".email_tab li.active").attr('id');
            email_tab_id = email_tab_id.replace('-2', '');
        }
        return email_tab_id;
    }

    function getAppmsgTabIndex() {
        if ($(".appmsg_tab li").hasClass('active')) {
            appmsg_tab_id = $(".appmsg_tab li.active").attr('id');
            appmsg_tab_id = appmsg_tab_id.replace('-3', '');
        }
        return appmsg_tab_id;
    }

    function setTemplateValue(TID, obj,obj1,obj2,obj3) {
        $.ajax({
            type: "get",
            async: false,
            url: "<?= site_url('smsdashboard/template_details') ?>",
            data: {template_id: TID},
            dataType: "json",
            success: function (data) { 
                if (data['res_type'] == 1 || data['res_type'] == 3) {
                   
                    if (data['res_type'] == 1) {
                        var length = data['res_content_length']+34;
                        var smsId = getSmsTabIndex();
                       
                        if (length > 250) {
                            alert("Exceed the sms lenght");
                             obj.html('');
                        }else{
                        $('#'+smsId+' .max_sms_chars').text('SMS count : '+Math.ceil(length/smsLength )+' ');
                        obj.html(data['res_content'])
                         $('#'+smsId+' .sms_preview').css('display','block');
              		 $('#'+smsId+' .sms_preview_d').text(data['res_content']);
                        }
                    }else{
                      obj.html(data['res_content']);
                      obj1.val(data['res_subject']);
                      obj2.val(data['attachment']);
                      obj3.html(data['attachment_op']);
                    }
                } else {
                
                    obj.redactor('set', data['res_content']);
                    obj1.val(data['res_subject']); 
                    obj2.val(data['attachment']);
                    obj3.html(data['attachment_op']);
                }
            },
            error: function () {
            }
        });
    }
        
    $(document).ready(function () {
       
        /*---------------- Customer Autopopulate for SMS--------------------*/
        $.ajax({
            type: "get",
            async: false,
            url: "<?= site_url('customers/getCustomers') ?>",
            data: "data",
            dataType: "json",
            success: function (data) {
                $('#customers_sms').select2("destroy").empty().select2({closeOnSelect: false});
                $.each(data.aaData, function () {
                    $("<option />", {value: this['4'] + ':' + this['3'], text: this['4'] + '/' + this['3'] + ''}).appendTo($('#customers_sms'));
                });
                $('#customers_sms').select2('val');
                $("#customers_sms option").each(function () {
                    $customer_list = $(this).val();
                });
            },
            error: function () {
            }
        });
	
        
        /*---------------- Customer Autopopulate for Email--------------------*/
        $.ajax({
            type: "get",
            async: false,
            url: "<?= site_url('customers/getCustomers') ?>",
            data: "data",
            dataType: "json",
            success: function (data) {
                $('#customers_email').select2("destroy").empty().select2({closeOnSelect: false});
                $.each(data.aaData, function () {
                    $("<option />", {value: this['4'] + ':' + this['3'], text: this['4'] + '/' + this['3'] + ''}).appendTo($('#customers_email'));
                });
                $('#customers_email').select2('val');
                $("#customers_email option").each(function () {
                    $customer_list = $(this).val();
                });
            },
            error: function () {
            }
        });
	
        
        /*---------------- Customer Autopopulate for Appmsg--------------------*/
        $.ajax({
            type: "get",
            async: false,
            url: "<?= site_url('customers/getCustomers') ?>",
            data: "data",
            dataType: "json",
            success: function (data) {
                $('#customers_app_msg').select2("destroy").empty().select2({closeOnSelect: false});
                $.each(data.aaData, function () {
                    $("<option />", {value: this['4'] + ':' + this['3'], text: this['4'] + '/' + this['3'] + ''}).appendTo($('#customers_app_msg'));
                });
                $('#customers_app_msg').select2('val');
                $("#customers_app_msg option").each(function () {
                    $customer_list = $(this).val();
                });
            },
            error: function () {
            }
        });
		
	$(document).on('click', '.sms_notallow', function (e) {
            e.preventDefault();
            
        });
     
         
   
        $(document).on('click', 'a.group_button', function () {
            $('a.group_button').removeClass('active');
            $(this).addClass('active');
        });
     
        $(document).on('change', '#customers', function () {
            $('a.group_button').removeClass('active');
            $("#group_id").val('');
        });
    
    
        $(document).on('click', '#select2-choices', function () {
            $('a.group_button').removeClass('active');
            $('#group_id').removeVal();
        });
        
        /* --------------------------- Set SMS from  template  ------------------------*/
        $(document).on('click', '.tempalte_type_1', function () {
            var smsId = getSmsTabIndex(); 
            setTemplateValue($(this).attr('data-value'),$('#'+smsId+' .sms_body'),'','','');
        });
        
         /* --------------------------- Set Email from  template  ------------------------*/
        
        $(document).on('click', '.tempalte_type_2', function () {
            var emailId = getEmailTabIndex();  
            setTemplateValue($(this).attr('data-value'),$('#'+emailId +' .email_body'),$('#'+emailId +' #subject'),$('#'+emailId +' .attachment_template'),$('#'+emailId +' .attachment_wrapper'));
        });
        
        /* --------------------------- Set Application Msg from  template  ------------------------*/
        $(document).on('click', '.tempalte_type_3', function () {
            var appmsgId = getAppmsgTabIndex(); 
//            $('#'+appmsgId+' .appmsg_body').attr('value',$(this).attr('data-message'))
            setTemplateValue($(this).attr('data-value'),$('#'+appmsgId +' .appmsg_body'),$('#'+appmsgId +' #subject'),$('#'+appmsgId +' .attachment_template'),$('#'+appmsgId +' .attachment_wrapper'));
        });
        
        /* --------------------------- Email Priview ------------------------*/
        $(document).on('click', '.btn_email_preview', function () {
            var emailId = getEmailTabIndex();
            eBody = $('#'+emailId+' .email_body').redactor('get');
            $('#emailPreview .modal-body').html(eBody);
            $('#emailPreview').modal('show'); 
         
        });
      
       $(document).on('click', '#sms_log_invoke', function () {
           
            
            $.ajax({
                type: "GET",
                async: false,
                url: "<?= site_url('smsdashboard/sms_list') ?>",
                dataType: "json",
                success: function (res) {
                	console.log(data_tbl );
                	if(data_tbl){
                		data_tbl.fnDestroy();
                	}
	                $('#sms_log_tbody').empty();
			$('#sms_log_tbody').html(res['data']) ;
			data_tbl = $('#sms_log_table').DataTable({
			         aaSorting : [[ 0, "desc" ]] 
			    });
                },
                error: function () {
                }
            }); 
        });
    });
    <?php if(!is_array($groupList) || count($groupList)==0):?> 
        $('.group_submit_button').addClass("dis_submit");
    <?php endif;?>    
</script>
