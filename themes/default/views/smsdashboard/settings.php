 <?php
$cronType = array('1' => 'SMS', '2' => 'EMAIL');
$cronTypeD = ($pos_sms_cron == 1) ? '' : 'style="display:none"';
?>
<style>
    #cron_user_setting ul#group_member_list li {
        list-style-type: none;
        padding: 2px 0;
        min-height: 36px;
        font-size: 0.905em;
    }
    #cron_user_setting ul#group_member_list {
        height: 240px;
        overflow-x: hidden;
        overflow-y: scroll;
    }
    
    .border-top{
        margin-top: 5px ;padding-top: 5px ;border-top:1px solid #ccc;
    }
</style>
<div class="section-heading">
    <i class="fa fa-wrench" aria-hidden="true"></i>   Setting
</div>

<div class="row"><div class="col-md-12 "  id="cron-loader"></div></div>
<div class="welcome_msg">  
    <div class="row">
        <div class="col-lg-12">
            <?php
            $attrib = array('role' => 'form', 'name' => "cron_setting", id => "cron_setting");
            echo form_open_multipart("", $attrib)
            ?>
            <div class="row">
                <div class="col-lg-12">
                    <div class="form-group all"> 
                        <label  style="font-size: 14px;">   <input type="checkbox" value="1" name="pos_sms_cron"  id="pos_sms_cron" <? echo ($pos_sms_cron == 1) ? 'checked' : ''; ?>  > Enable Automated Customer notifications </label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-5 " >
                    <div class="form-group all cron_type"<?php echo $cronTypeD; ?>> 
                        <label  style="font-size: 14px;">    Type :  </label><?= form_dropdown('pos_sms_cron_type', $cronType, $pos_sms_cron_type, 'class="form-control" id="pos_sms_cron_type"  '); ?> 
                    </div> 
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4">    
                    <?php echo form_submit('save_cron_system', lang('Submit'), 'class="btn btn-primary   "  style="float:left;"'); ?>
                  
            </div>
            <?= form_close(); ?>   
        </div>
        <div class="col-lg-12  ">
            <?php
            $attrib = array('role' => 'form', 'name' => "cron_user_setting", id => "cron_user_setting");
            echo form_open_multipart("", $attrib)
            ?>
            <br>
            <fieldset class="scheduler-border">
                <legend class="scheduler-border"><?= lang('Select Customer') ?> <label for="mbselect">  <span> &nbsp; &nbsp; <input type="checkbox" class="checkbox checkth input-xs" name="selectall" id="mbselect" title="Select All" /> </span> Select All</label></legend>
                <div class="col-lg-12 " >
                    <div class="form-group all "> 
                        <?php echo $this->sma->cron_group_member($customerlist); ?>
                    </div> 
                </div>

                <div class="col-lg-12">    
                    <?php echo form_submit('save_cron_user', lang('Submit'), 'class="btn btn-info   "'); ?>
                      <br>
                    (Note: if no customer option will selected , system will consider as all )
                </div>  
                </div>  
            </fieldset>    
            <?= form_close(); ?>   
        </div>
    </div>     

</div>
<script>

    $('#pos_sms_cron').on('ifChecked', function (event) {
        $('.cron_type').css('display', 'block');
    });

    $('#pos_sms_cron').on('ifUnchecked', function (event) {
        $('.cron_type').css('display', 'none');
    });

    $("#cron_setting").submit(function (event) {
        event.preventDefault();
        $('#cron-loader').css('display', 'block');
        $('#cron-loader').html('<div class="alert alert-success"><i class="fa fa-refresh  fa-spin fa-fw"></i><span class="">Loading...</span></div>');
        $.ajax({
            type: "POST",
            async: false,
            url: "<?= site_url('smsdashboard/set_sms_cron') ?>",
            data: $("#cron_setting").serialize(),
            dataType: "json",
            success: function (data) {
                if (data['status'] == 'error') {
                    $('#cron-loader').html('<div class="alert alert-danger"><button data-dismiss="alert" class="close" type="button">Ã—</button> Not saved successfully </div>');
                } else if (data['status'] == 'success') {
                    $('#cron-loader').html('<div class="alert alert-success"><button data-dismiss="alert" class="close" type="button">Ã—</button>  Saved successfully </div>');
                }
            },
            error: function () {
                $('#cron-loader').html('<div class="alert alert-danger"><button data-dismiss="alert" class="close" type="button">Ã—</button> Not saved successfully </div>');
            }
        });
    });
    /*----------------------------SETTING FROM SUBMIT  ----------------------------*/

    $("#cron_user_setting").submit(function (event) {
        event.preventDefault();
        $('#cron-loader').css('display', 'block');
        $('#cron-loader').html('<div class="alert alert-success"><i class="fa fa-refresh  fa-spin fa-fw"></i><span class="">Loading...</span></div>');
        $.ajax({
            type: "POST",
            async: false,
            url: "<?= site_url('smsdashboard/set_sms_cron_user') ?>",
            data: $("#cron_user_setting").serialize(),
            dataType: "json",
            success: function (data) {
                 if (data['error']) {
                    $('#cron-loader').html('<div class="alert alert-danger"><button data-dismiss="alert" class="close" type="button">X</button> Not saved successfully </div>');
                } else if (data['success']) {
                    $('#cron-loader').html('<div class="alert alert-success"><button data-dismiss="alert" class="close" type="button">X</button>  Saved successfully </div>');
                }
            },
            error: function () {
                $('#cron-loader').html('<div class="alert alert-danger"><button data-dismiss="alert" class="close" type="button">X</button> Not saved successfully </div>');
            }
        });
    });
</script>    