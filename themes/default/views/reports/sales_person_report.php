<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$user_warehouse = $this->session->userdata('warehouse_id');
$v = $v1 = "";
/* if($this->input->post('name')){
  $v .= "&product=".$this->input->post('product');
  } */

if($this->input->post('sales_person'))
{
    $v .= "&sales_person=" . $this->input->post('sales_person');
}

if ($this->input->post('start_date')) {
    $v .= "&start_date=" . $this->input->post('start_date');
}
if ($this->input->post('end_date')) {
    $v .= "&end_date=" . $this->input->post('end_date');
}
?>
<style>
    #clear_customer {
        position: absolute;
        right: 40px;
        top: 35px;
    }
</style>
<script>
    $(document).ready(function () {
		//alert('<?php echo $v; ?>');
        var oTable = $('#SlRData').dataTable({
            "aaSorting": [[0, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100], [10, 25, 50, 100]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('reports/get_sales_person_report/?v=1' . $v) ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                nRow.id = aData[0];
                //nRow.className = (aData[7] > 0) ? "invoice_link2" : "invoice_link2 warning";
                return nRow;
            },
            "aoColumns": [
                {"bVisible": false},
				null,                
                {"mRender": currencyFormat},
                null,
                null,
                {"mRender": currencyFormat},
                {"mRender": currencyFormat},
                null,
            ],
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                var tot_sales = 0, tot_items = 0, tot_amt = 0, tot_discount = 0, tot_tax = 0;
                //console.log(aaData);
                for (var i = 0; i < aaData.length; i++) {
                    tot_items += parseFloat(aaData[aiDisplay[i]][2]);
                    tot_sales += parseFloat(aaData[aiDisplay[i]][3]);
                    tot_amt += parseFloat(aaData[aiDisplay[i]][4]);
                    tot_discount += parseFloat(aaData[aiDisplay[i]][5]);
                    tot_tax += parseFloat(aaData[aiDisplay[i]][6]);
                }
                var nCells = nRow.getElementsByTagName('th');
                 
                nCells[1].innerHTML = currencyFormat(parseFloat(tot_items));
                nCells[2].innerHTML = parseFloat(tot_sales);
                nCells[3].innerHTML = parseFloat(tot_amt);
                nCells[4].innerHTML = currencyFormat(parseFloat(tot_discount));
                nCells[5].innerHTML = currencyFormat(parseFloat(tot_tax));
               
            }
        });
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $("#SlRData_length .select").remove();
        $('#form').hide();
        <?php if ($this->input->post('customer')) { ?>
        $('#customer').val(<?= $this->input->post('customer') ?>).select2({
            minimumInputLength: 1,
            data: [],
            initSelection: function (element, callback) {
                $.ajax({
                    type: "get", async: false,
                    url: site.base_url + "customers/suggestions/" + $(element).val(),
                    dataType: "json",
                    success: function (data) {
                        callback(data.results[0]);
                    }
                });
            },
            ajax: {
                url: site.base_url + "customers/suggestions",
                dataType: 'json',
                quietMillis: 17,
                data: function (term, page) {
                    return {
                        term: term,
                        limit: 10
                    };
                },
                results: function (data, page) {
                    if (data.results != null) {
                        alert('<?php echo $this->input->post('customer')?>');
                        return {results: data.results};
                    } else {
                        return {results: [{id: '', text: 'No Match Found'}]};
                    }
                }
            }
        });

        $('#customer').val('<?php echo $this->input->post('customer')?>').trigger('change')
        <?php } ?>
        $('.toggle_down').click(function () {
            $("#form").slideDown();
            return false;
        });
        $('.toggle_up').click(function () {
            $("#form").slideUp();
            return false;
        });
    });
</script>


<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-heart"></i><?= lang('Report_Sales_Person'); ?> <?php
            if($this->input->post('start_date'))
            {
                echo "From " . $this->input->post('start_date') . " to " . $this->input->post('end_date');
            }
            ?>
        </h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a href="#" class="toggle_up tip" title="<?= lang('hide_form') ?>">
                        <i class="icon fa fa-toggle-up"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" class="toggle_down tip" title="<?= lang('show_form') ?>">
                        <i class="icon fa fa-toggle-down"></i>
                    </a>
                </li>
            </ul>
        </div>
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
                <li class="dropdown">
                    <a href="#" id="image" class="tip" title="<?= lang('save_image') ?>">
                        <i class="icon fa fa-file-picture-o"></i>
                    </a>
                </li>

            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12 table-responsive">
                <!--<p class="introtext col-lg-12"><?php //echo lang('customize_report'); ?></p>-->
                <div id="form" >
                    <?php echo form_open("reports/sales_person_report"); ?>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="sales_person"><?= lang("Sales_person"); ?></label>
                                <?php
                                $bl[""] = lang('select') . ' ' . lang('Sales_person');
								//print_r($sales_staff);
                                foreach($sales_staff as $sales_staffs)
                                { 
                                    $bl[$sales_staffs['id']] = $sales_staffs['name'] != '-' ? $sales_staffs['name'] : $sales_staffs['name'];
                               
                                }
                                echo form_dropdown('sales_person', $bl, (isset($_POST['sales_person']) ? $_POST['sales_person'] : ""), 'class="form-control" id="sales_person" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("sales_person") . '"');
                                ?>
                            </div>
                        </div>
                       
                        <div class="col-sm-4">

                            <div class="form-group choose-date hidden-xs">
                                <div class="controls">
                                    <?= lang("date_range_sales", "date_range_sales"); ?>
                                    <div class="input-group">

                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text"
                                               value="<?php echo isset($_POST['start_date']) ? $_POST['start_date'] . '-' . $_POST['end_date'] : ""; ?>"
                                               id="daterange_new" class="form-control"  autocomplete="off">
                                        <span class="input-group-addon" style="display:none;"><i class="fa fa-chevron-down"></i></span>
                                        <input type="hidden" name="start_date" id="start_date"
                                               value="<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ""; ?>">
                                        <input type="hidden" name="end_date" id="end_date"
                                               value="<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ""; ?>">

                                    </div>
                                </div>
                            </div>

                        </div>

                       


                    </div>
                    <div class="form-group">
                        <div
                                class="controls"> <?php echo form_submit('submit_report', $this->lang->line("submit"), 'class="btn btn-primary"'); ?>
                            <a href="<?= base_url('reports/sales_person_report'); ?>" class="btn btn-success">Reset
                                Filter</a></div>
                        <div></div>
                    </div>
                    <?php echo form_close(); ?>

                </div>
                <div class="clearfix"></div>

                <div class="table-responsive">
                    <table id="SlRData" class="table table-bordered table-hover table-striped table-condensed reports-table">
                        <thead>
                         <tr> 
                            <th></th> 
							<th><?= lang("Seller"); ?></th> 							
                            <th><?= lang("Sales_amount"); ?></th>
							<th><?= lang("Total_sales"); ?></th>
							<th><?= lang("No_of_sale_items"); ?></th>
							<th><?= lang("Total_discount"); ?></th>
							<th><?= lang("Total_tax"); ?></th>
                            <th><?= lang("Action"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="7" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                        </tr>
                        </tbody>
                        <tfoot class="dtFilter">
                        <tr class="active">
                            <th></th>
							<th></th>
                            <th><?= lang("Sales_amount"); ?></th>
							<th><?= lang("Total_sales"); ?></th>
							<th><?= lang("No_of_sale_items"); ?></th>
							<th><?= lang("Total_discount"); ?></th>
							<th><?= lang("Total_tax"); ?></th>
                            <th><?= lang("Action"); ?></th>
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
            window.location.href = "<?=site_url('reports/get_sales_person_report/pdf/?v=1' . $v)?>";
            return false;
        });
        $('#xls').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('reports/get_sales_person_report/0/xls/?v=1' . $v)?>";
            return false;
        });
        $('#image').click(function (event) {
             event.preventDefault();
            window.location.href = "<?=site_url('reports/get_sales_person_report/0/0/xls/?v=1' . $v)?>";
            return false;
        });
    });
</script>