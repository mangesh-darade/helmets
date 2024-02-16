<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
$(document).ready(function () {
	
$('#POSData').dataTable({
  "bSort": false,
"iDisplayLength": 10,
});

});
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
                id="myModalLabel"><?= lang('Sale_person_list'); if(!empty($SALEDATA)){
					$i=0; 
				foreach($SALEDATA as $ResValue){ if($i==0) echo ': '.$ResValue["seller"]; $i++; } } ?></h4>
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
                            <th><?= lang("Actions"); ?></th>
                        </tr>
                        </thead>
                       <tbody>
							<?php
								if(!empty($SALEDATA)){
								foreach($SALEDATA as $ResValue){	
							?>
							<tr>
								<td><?= $ResValue["date"]; ?></td>
								<td><?= $ResValue["reference_no"]; ?></td>
								<td><?= $ResValue["biller"]; ?></td>
								<td><?= $ResValue["customer"]; ?></td>
								<td><?= $this->sma->formatMoney($ResValue["grand_total"]); ?></td>
								<td><?= $this->sma->formatMoney($ResValue["paid"]); ?></td>
								<td><?= $this->sma->formatMoney($ResValue["balance"]); ?></td>
								<td><?= $ResValue["sale_status"]; ?></td>
								<td><?= $ResValue["payment_status"]; ?></td>	
								<td><?= anchor('sales/view/'.$ResValue["id"], '<i class="fa fa-search"></i> ' . lang('sale_details'), ['target' => '_blank']); ?></td>
							</tr>
								<?php } }else{ ?>
							<tr>
								<td colspan="10" class="dataTables_empty"><?= lang("loading_data"); ?></td>
							</tr>
								<?php } ?>
							</tbody>
                       <!-- <tfoot class="dtFilter">
                        <tr class="active">
                            <th><?= lang("date"); ?></th>
                            <th><?= lang("reference_no"); ?></th>
                            <th><?= lang("biller"); ?></th>
                            <th><?= lang("customer"); ?></th>
                            <th><?= lang("grand_total"); ?></th>
                            <th><?= lang("paid"); ?></th>
                            <th><?= lang("balance"); ?></th>
							<th><?= lang("sale_status"); ?></th>
                            <th><?= lang("payment_status"); ?></th>
							<th><?= lang("Actions"); ?></th>							
                        </tr>
                        </tfoot>-->
                    </table>
                </div>
        </div>
    </div>
</div>