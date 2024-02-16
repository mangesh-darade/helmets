<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-lg">
    <div class="modal-content">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-2x">&times;</i>
            </button>
            <button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();">
                <i class="fa fa-print"></i> <?= lang('print'); ?>
            </button>
<!--            <h4 class="modal-title" id="myModalLabel"><?= lang('view_payments').' ('.lang('sale').' '.lang('reference').': '.$inv->reference_no.')'; ?></h4>-->
        </div>
        <div class="modal-body">
            <div class="table-responsive">
                <table id="CompTable" cellpadding="0" cellspacing="0" border="0"
                       class="table table-bordered table-hover table-striped">
                    <thead>
                    <tr>
                        <th style="width:30%;"><?= $this->lang->line("date"); ?></th>
                        <th style="width:30%;"><?= $this->lang->line("invoice_no"); ?></th>
                        <th style="width:15%;"><?= $this->lang->line("amount"); ?></th>
                        <th style="width:15%;"><?= $this->lang->line("balance"); ?></th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    //print_r($historygiftcard);
                    if (!empty($historygiftcard)) {
                        foreach ($historygiftcard as $histgiftcard) { ?>
                            <tr >
                                <td><?= $this->sma->hrld($histgiftcard->date); ?></td>
                                <td><?= $histgiftcard->invoice_id; ?></td>
                                <td><?= $histgiftcard->amount; ?></td>
                                <td><?= $histgiftcard->balance_amt; ?></td>
                            </tr>
                        <?php }
                    } else {
                        echo "<tr><td colspan='4'>" . lang('no_data_available') . "</td></tr>";
                    } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>



