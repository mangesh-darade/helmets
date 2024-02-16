<?php defined('BASEPATH') OR exit('No direct script access allowed'); 


?>
<div class="modal-dialog">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <h4 class="modal-title" id="myModalLabel"><?php echo lang('edit_tax_rate_attr'); ?></h4>
        </div>
        <?php echo form_open("system_settings/edit_tax_rate_attr/" . $id); ?>
        <div class="modal-body">
            <p><?= lang('enter_info'); ?><?php //var_dump($tax_rate_attr);?></p>

            <div class="form-group">
                <label class="control-label" for="name"><?php echo $this->lang->line("name"); ?></label>

                <div
                    class="controls"> <?php echo form_input('name', $tax_rate_attr->name, 'class="form-control" id="name" required="required"'); ?> </div>
            </div>
            <div class="form-group">
                <label class="control-label" for="code"><?php echo $this->lang->line("code"); ?></label>

                <div
                    class="controls"> <?php echo form_input('code', $tax_rate_attr->code, 'class="form-control" id="code"'); ?> </div>
            </div>
            
        </div>
        <div class="modal-footer">
            <?php echo form_submit('edit_tax_rate_attr', lang('edit_tax_rate_attr'), 'class="btn btn-primary"'); ?>
        </div>
    </div>
    <?php echo form_close(); ?>
</div>
<?= $modal_js ?>