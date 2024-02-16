<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="box" style="margin-bottom: 15px;">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-database"></i><?= lang('database_backups'); ?></h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown"><a href="<?= site_url('system_settings/backup_database') ?>" onclick="return confirmBackup();"><i
                            class="icon fa fa-database"></i><span
                            class="padding-right-10"><?= lang('backup_database'); ?></span></a>
                            <script type="text/javascript">
    function confirmBackup() {
        return confirm('Are you sure you want to backup?');
    }
</script>
                            
                            </li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <p class="introtext"><?= lang('restore_heading'); ?></p>

                <div class="row">
                    <div class="col-md-12">
                        <?php
                        foreach ($dbs as $file) {
                            $file = basename($file);
                            echo '<div class="well well-sm">';
                            $date_string = substr($file, 13, 10);
                            $time_string = substr($file, 24, 8);
                            $date = $date_string . ' ' . str_replace('-', ':', $time_string);
                            $bkdate = $this->sma->hrld($date);
                            echo '<h3>' . lang('backup_on') . ' <span class="text-primary">' . $bkdate . '</span><div class="btn-group pull-right" style="margin-top:-12px;">' . anchor('system_settings/download_database/' . substr($file, 0, -4), '<i class="fa fa-download"></i> ' . lang('download'), 'class="btn btn-primary"') . ' ' . anchor('system_settings/restore_database/' . substr($file, 0, -4), '<i class="fa fa-database"></i> ' . lang('restore'), 'class="btn btn-warning restore_db"') . ' ' . anchor('system_settings/delete_database/' . substr($file, 0, -4), '<i class="fa fa-trash-o"></i> ' . lang('delete'), 'class="btn btn-danger delete_file"') . ' </div></h3>';
                            echo '<div class="clearfix"></div></div>';
                        }
                        ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
 
<div class="modal fade" id="wModal" tabindex="-1" role="dialog" aria-labelledby="wModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="wModalLabel"><?= lang('please_wait'); ?></h4>
            </div>
            <div class="modal-body">
                <?= lang('backup_modal_msg'); ?>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
         
        $('.restore_db').click(function (e) {             
            e.preventDefault();
            var href = $(this).attr('href');
            bootbox.confirm("<?=lang('restore_confirm');?>", function (result) {
                if (result) {
                    window.location.href = href;
                }
            });
        });
        $('.delete_file').click(function (e) {
            e.preventDefault();
            var href = $(this).attr('href');
            bootbox.confirm("<?=lang('delete_confirm');?>", function (result) {
                if (result) {
                    window.location.href = href;
                }
            });
        });
    });
</script>