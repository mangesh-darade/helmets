<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<div class="modal-dialog modal-lg no-modal-header">
    <div class="modal-content">
        <div class="modal-body">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true">
                <i class="fa fa-2x">&times;</i>
            </button>
            <button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();">
                <i class="fa fa-print"></i> <?= lang('print'); ?>
            </button>
            <div class="text-center" style="margin-bottom:20px;">
                <h3>Delivery Info </h3>
            </div>
            <div class="container">
                
               
                <table class="table">
                    <tr>
                        <td >Name</td>
                        <td>:</td>
                        <td><?= $delivery_info->name ?></td>
                    </tr>
                    <tr>
                        <td>Phone No.</td>
                        <td>:</td>
                        <td><?= $delivery_info->phone ?> <?= ($delivery_info->alt_phone)?', '.$delivery_info->alt_phone:'' ?></td>
                    </tr>
                    <tr>
                        <td>Channel Name</td>
                        <td>:</td>
                        <td><?= $delivery_info->channel_name ?></td>
                    </tr>
                    <tr>
                        <td>Order Status</td>
                        <td>:</td>
                        <td><?= $delivery_info->order_status ?></td>
                    </tr>
                    <tr>
                        <td>Comments</td>
                        <td>:</td>
                        <td><?= ($delivery_info->comments)?$delivery_info->comments:'---' ?></td>
                    </tr>
                </table>
            </div>
            
        </div>
    </div>
</div>