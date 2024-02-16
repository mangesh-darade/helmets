<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<script>
    $(document).ready(function () {
		function spb(x) {
			//console.log(x);
			console.log(x);
			if(x!=''){
				console.log('aa');
				if(x!=null){
					console.log('bb');
					v = x.split('__');
					return '(' + formatQuantity2(v[0]) + ') <strong>' + formatMoney(v[1]) + '</strong>';
				}else{
					return '0';
				}
			}
           
        }
		var oTable = $('#PrRData').dataTable({
            "aaSorting": [],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('reports/get_products_combo_items_report/') ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
				//console.log(aData)
                nRow.id = aData[1];
                //nRow.className = "product_link2";
                return nRow;
            },
            "aoColumns": [null, null, {"mRender": spb, "bSearchable": false}, {"mRender": spb, "bSearchable": false}, {"mRender": currencyFormat, "bSearchable": false}, {"mRender": spb, "bSearchable": false}],
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                var pq = 0, sq = 0, bq = 0, pa = 0, sa = 0, ba = 0, pl = 0;
                for (var i = 0; i < aaData.length; i++) {
                    p = (aaData[aiDisplay[i]][2]).split('__');
                    s = (aaData[aiDisplay[i]][3]).split('__');
                    b = (aaData[aiDisplay[i]][5]).split('__');
                    pq += parseFloat(p[0]);
                    pa += parseFloat(p[1]);
                    sq += parseFloat(s[0]);
                    sa += parseFloat(s[1]);
                    bq += parseFloat(b[0]);
                    ba += parseFloat(b[1]);
                    pl += parseFloat(aaData[aiDisplay[i]][4]);
                }
                var nCells = nRow.getElementsByTagName('th');
                nCells[2].innerHTML = '<div class="text-right">(' + formatQuantity2(pq) + ') ' + formatMoney(pa) + '</div>';
                nCells[3].innerHTML = '<div class="text-right">(' + formatQuantity2(sq) + ') ' + formatMoney(sa) + '</div>';
                nCells[4].innerHTML = currencyFormat(parseFloat(pl));
                nCells[5].innerHTML = '<div class="text-right">(' + formatQuantity2(bq) + ') ' + formatMoney(ba) + '</div>';
            }
        }).fnSetFilteringDelay().dtFilter([
            {column_number: 0, filter_default_label: "[<?=lang('Product_Name');?>]", filter_type: "text", data: []},
            {column_number: 1, filter_default_label: "[<?=lang('Product_Code');?>]", filter_type: "text", data: []},
        ], "footer");
        
    });
</script>



<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-barcode"></i><?= lang('Products_Combo_item_Report'); ?> <?php
            if($this->input->post('start_date'))
            {
                echo "From " . $this->input->post('start_date') . " to " . $this->input->post('end_date');
            }
            ?></h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a href="#" id="pdf" class="tip" title="<?= lang('download_pdf') ?>">
                        <i class="icon fa fa-file-pdf-o"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" id="xls" class="tip" title="<?= lang('download_xls') ?>">
                        <i class="icon fa fa-file-excel-o"></i>
                    </a>
                </li>
               <!-- <li class="dropdown">
                    <a href="#" id="image" class="tip" title="<?= lang('save_image') ?>">
                        <i class="icon fa fa-file-picture-o"></i>
                    </a>
                </li>-->
            </ul>
        </div>
    </div>
    <p class="introtext"><?= lang('customize_report'); ?> </p>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                
                <div class="clearfix"></div>

                <div class="table-responsive">
                    <table id="PrRData" class="table table-striped table-bordered table-condensed table-hover dfTable reports-table"
                           style="margin-bottom:5px;">
                        <thead>
                        <tr class="active">
                            <th><?= lang("Item_Name"); ?></th>
                            <th><?= lang("Item_Code"); ?></th>
                           <th><?= lang("Purchased"); ?></th>
                            <th><?= lang("Consumed"); ?></th>
                           <th><?= lang("Profit/Loss"); ?></th>
						   <th><?= lang("Stock(Qty)Amt"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
						 <tr>
                            <td colspan="8" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                        </tr>
                        </tbody>
                        <tfoot class="dtFilter">
                        <tr class="active">
                           <th></th>
                            <th></th>
							 <th><?= lang("Purchased"); ?></th>
                            <th><?= lang("Consumed"); ?></th>
                             <th><?= lang("Profit/Loss"); ?></th>
							 <th><?= lang("Stock(Qty)Amt"); ?></th>
                        </tr>
                        </tfoot>
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="<?= $assets ?>js/html2canvas.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#pdf').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('reports/get_products_combo_items_report/pdf')?>";
            return false;
        });
        $('#xls').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('reports/get_products_combo_items_report/xls')?>";
            return false;
        });
        $('#image').click(function (event) {
            event.preventDefault();
			window.location.href = "<?=site_url('reports/get_products_combo_items_report/img')?>";
            /*html2canvas($('.box'), {
                onrendered: function (canvas) {
                    var img = canvas.toDataURL()
                    window.open(img);
                }
            });*/
            return false;
        });
    });
</script>
