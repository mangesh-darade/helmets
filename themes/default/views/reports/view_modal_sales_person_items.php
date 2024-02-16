<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
$(document).ready(function () {
	
$('#SaleItemData').dataTable({
  "bSort": false,
"iDisplayLength": 5,
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
                id="myModalLabel"><?= lang('Sales_Person_List'); if(!empty($SALEDATA)){
					$i=0; 
				foreach($SALEDATA as $ResValue){ if($i==0) echo ': '.$ResValue["seller"]; $i++; } } ?></h4>
        </div>
        <div class="modal-body">
		<div class="table-responsive">
                     <table id="SaleItemData" class="table table-bordered table-hover table-striped pos_sale_table">
                        <thead>
                        <tr>
                           <th><?= lang("Product_name"); ?></th>
                            <th><?= lang("Product_code"); ?></th>
                            <th><?= lang("Quantity"); ?></th>
                            <th><?= lang("Unit_Price"); ?></th>
                            
                        </tr>
                        </thead>
                       <tbody>
							<?php
							$tot_qty = 0;
							$tot_net_price = 0;
								if(!empty($SALEDATA)){
								foreach($SALEDATA as $ResValue){
									$tot_qty += $ResValue["tot_qty"];
							        $tot_net_price += $ResValue["tot_net_price"];
							?>
							<tr>
								<td><?= $ResValue["product_name"]; ?></td>
								<td><?= $ResValue["product_code"]; ?></td>
								<td><?= $ResValue["tot_qty"]; ?></td>
								<td><?= $this->sma->formatMoney($ResValue["tot_net_price"]); ?></td>	
							</tr>
								<?php } }else{ ?>
							<tr>
								<td colspan="4" class="dataTables_empty"><?= lang("loading_data"); ?></td>
							</tr>
								<?php } ?>
							</tbody>
                        <tfoot class="dtFilter">
                        <tr class="active">
                            <th></th>
                            <th></th>
                            <th><?= $tot_qty; ?></th>
                            <th><?= $this->sma->formatMoney($tot_net_price); ?></th>  						
                        </tr>
                        </tfoot>
                    </table>
                </div>
        </div>
    </div>
</div>