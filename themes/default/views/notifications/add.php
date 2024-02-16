<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('add_notification'); ?></h4>
        </div>
        <?php $attrib = array('data-toggle' => 'validator', 'role' => 'form','id' => 'add_notification-form');
        echo form_open("notifications/add", $attrib); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?></p>

            <div class="row">
                <div class="col-sm-6">
                    <div class="form-group" id="form_date_block">
                        <?php echo lang('from', 'from_date'); ?>
                        <div class="controls">
                            <?php echo form_input('from_date', '', 'class="form-control datetime" id="from_date" required="required" autocomplete="off" '); ?>
                             <small class="text-danger errormsg" id="error_from_date" > </small>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-group" id="to_date_block">
                        <?php echo lang('till', 'to_date'); ?>
                        <div class="controls">
                            <?php echo form_input('to_date', '', 'class="form-control datetime" id="to_date" required="required" autocomplete="off" '); ?>
                            <small class="text-danger errormsg" id="error_to_date" > </small>
                        </div>
                    </div>
                </div>
            </div>

            <div class="form-group">
                <?php echo lang('comment', 'comment'); ?>
                <div class="controls">
                    <?php echo form_textarea($comment); ?>
                </div>
            </div>

            <div class="form-group">
                <input type="radio" class="radio-inline checkbox" name="scope" value="1" id="customer"><label for="customer"
                                                                                                 class="padding05"><?= lang('for_customers_only') ?></label>
                <input type="radio" class="radio-inline checkbox" name="scope" value="2" id="staff"><label for="staff"
                                                                                              class="padding05"><?= lang('for_staff_only') ?></label>
                <input type="radio" class="radio-inline checkbox" name="scope" value="3" id="both" checked="checked"><label
                    for="both" class="padding05"><?= lang('for_both') ?></label>
            </div>

        </div>
        <div class="modal-footer">
            <?php echo form_submit('add_notification', lang('add_notification'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?= $modal_js ?>
<script type="text/javascript" src="<?= $assets ?>js/custom.js"></script>
<script type="text/javascript" charset="UTF-8">
    $.fn.datetimepicker.dates['sma'] = <?=$dp_lang?>;
</script>
<script type="text/javascript">
    $(document).ready(function (e) {
        $('#add_notification-form').bootstrapValidator({
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

     $('#to_date').change(function(){
        $('.errormsg').html(" ");
        var form_date = $('#from_date').val();
        if(form_date == ''){
            $('#error_from_date').html('Please select srom date');
            $('#from_date').focus();
            $(this).val('');
            var element = document.getElementById("form_date_block");
           element.classList.add("has-error");
        } else {
            var nowDate= new Date();
            var Time1 = new Date(form_date);
            var LastTenMin= new Date($(this).val());

            // Should return true 
            if( Time1 >  LastTenMin ){
               var element = document.getElementById("to_date_block");
                 element.classList.add("has-error");
               $(this).val('');
               $('#error_to_date').html('End date must be greater than start date');
            } else {
                console.log(true);
            }
            
        } 
     
    });
    
</script>