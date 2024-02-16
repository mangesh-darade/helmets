<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
$(document).ready(function () {
	$('#recent_pos_sale_modal-loading').hide();
$('#POSData').dataTable({
  "bSort": false,
"iDisplayLength": 5,
});
$(document).on('click', '.email_receipt', function (e) {

             e.preventDefault();

            var sid = $(this).attr('data-id');
            var ea = $(this).attr('data-email-address');
            var email = prompt("<?= lang("email_address"); ?>", ea);
            if (email != null) {
                $.ajax({
                    type: "post",
                    url: "<?= site_url('pos/email_receipt') ?>/" + sid,
                    data: { <?= $this->security->get_csrf_token_name(); ?>: "<?= $this->security->get_csrf_hash(); ?>", email: email, id: sid },
                    dataType: "json",
                        success: function (data) {
                        bootbox.alert(data.msg);
                       return true;
                    },
                    error: function () {
                        bootbox.alert('<?= lang('ajax_request_failed'); ?>');
                        return false;
                    }
                });
            }
        });
});
function detailPosDetail(POSID, ActionName){
	$('#recent_pos_sale_modal-loading').show();
	$('#recentPOsDetailModal').html('');
	if(ActionName=='sale_detail_modal'){
		$('#recentPOsDetailModal').modal({remote: site.base_url + 'sales/modal_view/' +POSID });
		$('#recentPOsDetailModal').modal('show');
		
	}
	if(ActionName=='view_payment'){
		$('#recentPOsDetailModal').modal({remote: site.base_url + 'sales/payments/' +POSID });
		$('#recentPOsDetailModal').modal('show');
		
	}
	if(ActionName=='add_payment'){
		$('#recentPOsDetailModal').modal({remote: site.base_url + 'pos/add_payment/' +POSID });
		$('#recentPOsDetailModal').modal('show');
		
	}
	if(ActionName=='add_delivery'){
		$('#recentPOsDetailModal').modal({remote: site.base_url + 'sales/add_delivery/' +POSID });
		$('#recentPOsDetailModal').modal('show');
		
	}
	
}

</script>
<div class="modal-dialog modal-lg no-print" style="width:95%;">
    <div class="modal-content ">
        <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal" aria-hidden="true"><i class="fa fa-2x">&times;</i>
            </button>
            <!--<button type="button" class="btn btn-xs btn-default no-print pull-right" style="margin-right:15px;" onclick="window.print();">
                <i class="fa fa-print"></i> <?= lang('print'); ?>
            </button>-->
          
            <h4 class="modal-title"
                id="myModalLabel"><?= lang('recent_pos_list'); ?></h4>
        </div>
        <div class="modal-body">
		<div class="table-responsive">
                     <table id="POSData" class="table table-bordered table-hover table-striped pos_sale_table">
                        <thead>
                        <tr>
                           
                            <th><?= lang("date"); ?></th>
                            <th><?= lang("reference_no"); ?></th>
                            <th><?= lang("biller"); ?></th>
                            <th><?= lang("customer"); ?></th>
                            <th><?= lang("grand_total"); ?></th>
                            <th><?= lang("paid"); ?></th>
                            <th><?= lang("balance"); ?></th>
                            <th><?= lang("sale_status"); ?></th>
                            <th><?= lang("payment_status"); ?></th>
                            <th><?= lang("Delivery"); ?></th>
                            <th style="width:80px; text-align:center;"><?= lang("actions"); ?></th>
                        </tr>
                        </thead>
                       <tbody>
							<?php
								
								if(!empty($POSDATA)){
								foreach($POSDATA as $ResValue){
									$POSId = $ResValue["id"];
									$cemail = $ResValue["cemail"];
									$SaleDetailModalName = "'sale_detail_modal'";
									$AddPaymentName = "'add_payment'";
									$ViewPaymentName = "'view_payment'";
									$AddDeliveryName = "'add_delivery'";
									$ViewReceiptName = "'view_receipt'";
									
									$duplicate_link = anchor("sales/add?sale_id=$POSId", '<i class="fa fa-plus-circle"></i> ' . lang('duplicate_sale'), array('id'=>'SaleDetailsView', 'target'=>'new'));
        $detail_link = anchor("pos/view/$POSId", '<i class="fa fa-file-text-o"></i> ' . lang('view_receipt'), array('target'=>'new'));
        //$detail_link2 = anchor("sales/modal_view/$POSId", '<i class="fa fa-file-text-o"></i> ' . lang('sale_details_modal'), 'data-toggle="modal" data-target="#pos_details_views"');
        $detail_link2 = anchor("#", '<i class="fa fa-file-text-o"></i> ' . lang('pos_details_modal'), 'data-toggle="modal" data-target="#pos_details_views"', array('onclick'=>'return detailPosDetail('.$POSId.');'));
        $detail_link3 = anchor("sales/view/$POSId", '<i class="fa fa-file-text-o"></i> ' . lang('pos_details'), array('target'=>'new'));
        $payments_link = anchor("sales/payments/$POSId", '<i class="fa fa-money"></i> ' . lang('view_payments'), 'data-toggle="modal" data-target="#myModal"');
        $add_payment_link = anchor("pos/add_payment/$POSId", '<i class="fa fa-money"></i> ' . lang('add_payment'), 'data-toggle="modal" data-target="#myModal"');
        $add_delivery_link = anchor("sales/add_delivery/$POSId", '<i class="fa fa-truck"></i> ' . lang('add_delivery'), 'data-toggle="modal" data-target="#myModal"');
        $email_link = anchor('#', '<i class="fa fa-envelope"></i> ' . lang('email_sale'), 'class="email_receipt" data-id="'.$POSId.'" data-email-address="'.$cemail.'"');
        $edit_link = anchor("sales/edit/$POSId", '<i class="fa fa-edit"></i> ' . lang('edit_sale'), array('target'=>'new', 'class'=>'sledit') );
        $return_link = anchor("sales/return_sale/$POSId", '<i class="fa fa-angle-double-left"></i> ' . lang('return_sale'), array('target'=>'new'));
        $delete_link = "<a href='javascript:void(0);' class='po' title='<b>" . lang("delete_sale") . "</b>' data-content=\"<p>"
                . lang('r_u_sure') . "</p><a class='btn btn-danger po-delete' href='" . site_url('sales/delete/$POSId') . "'>"
                . lang('i_m_sure') . "</a> <button class='btn po-close'>" . lang('no') . "</button>\"  rel='popover'><i class=\"fa fa-trash-o\"></i> "
                . lang('delete_sale') . "</a>";
        $action = '<div class="text-center"><div class="btn-group text-left">'
                . '<button type="button" class="btn btn-default btn-xs btn-primary dropdown-toggle" data-toggle="dropdown">'
                . lang('actions') . ' <span class="caret"></span></button>
    <ul class="dropdown-menu pull-right" role="menu">
        <li>'.$detail_link.'</li>
        <li><a href="javascript:void(0);" onclick="return detailPosDetail('.$POSId.', '.$SaleDetailModalName.');"> <i class="fa fa-file-text-o"></i>'.lang('pos_details_modal').'</a></li>
        <li>' . $detail_link3 . '</li>
        <li>' . $duplicate_link . '</li>
        <li>
        <li><a href="javascript:void(0);" onclick="return detailPosDetail('.$POSId.', '.$ViewPaymentName.');"> <i class="fa fa-money"></i>'.lang('view_payments').'</a></li>
        <li><a href="javascript:void(0);" onclick="return detailPosDetail('.$POSId.', '.$AddPaymentName.');"> <i class="fa fa-money"></i>'.lang('add_payment').'</a></li>
        <li><a href="javascript:void(0);" onclick="return detailPosDetail('.$POSId.', '.$AddDeliveryName.');"> <i class="fa fa-money"></i>'.lang('add_delivery').'</a></li>
        <li>' . $edit_link . '</li>
        <li>' . $email_link . '</li>
        <li>' . $return_link . '</li>
      
    </ul>
</div></div>';
							?>
							<tr>
							   
								<td><?= $ResValue["date"]; ?></td>
								<td><?= $ResValue["reference_no"]; ?></td>
								<td><?= $ResValue["biller"]; ?></td>
								<td><?= $ResValue["customer"]; ?></td>
								<td><?= $ResValue["grand_total"]; ?></td>
								<td><?= $ResValue["paid"]; ?></td>
								<td><?= $ResValue["balance"]; ?></td>
								<td><?= $ResValue["sale_status"]; ?></td>
								<td><?= $ResValue["payment_status"]; ?></td>
								<td><?= $ResValue["delivery_status"]; ?></td>
								<td style="width:80px; text-align:center;"><?php echo $action; ?></td>
							</tr>
								<?php } }else{ ?>
							<tr>
								<td colspan="12" class="dataTables_empty"><?= lang("loading_data"); ?></td>
							</tr>
								<?php } ?>
							</tbody>
                        <tfoot class="dtFilter">
                        <tr class="active">
                            
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th><?= lang("grand_total"); ?></th>
                            <th><?= lang("paid"); ?></th>
                            <th><?= lang("balance"); ?></th>
                            <th class="defaul-color"></th>
                            <th class="defaul-color"></th>
                            <th class="defaul-color"></th>
                            <th style="width:80px; text-align:center;"><?= lang("actions"); ?></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>
        </div>
    </div>
</div>