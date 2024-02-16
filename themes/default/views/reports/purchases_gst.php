<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$user_warehouse = $this->session->userdata('warehouse_id');
$v = $v1 = "";

if($this->input->post('reference_no'))
{
    $v .= "&reference_no=" . $this->input->post('reference_no');
}
if($this->input->post('supplier'))
{
    $v .= "&supplier=" . $this->input->post('supplier');
}
if($this->input->post('warehouse'))
{
    $v .= "&warehouse=" . $this->input->post('warehouse');
}else{
    $v .=($user_warehouse=='0' ||$user_warehouse==NULL)?'':"&warehouse=" . str_replace(",", "_",$user_warehouse);
}
if($this->input->post('user'))
{
    $v .= "&user=" . $this->input->post('user');
}

if($this->input->post('gstn_opt'))
{
    $v .= "&gstn_opt=" . $this->input->post('gstn_opt');
}
if($this->input->post('gstn_no'))
{
    $v .= "&gstn_no=" . $this->input->post('gstn_no');
}
if($this->input->post('hsn_code'))
{
    $v .= "&hsn_code=" . $this->input->post('hsn_code');
}
$v1 = $v;

if($this->input->post('start_date'))
{
    $st = $this->sma->fld($this->input->post('start_date')) . ":00";
    $v1 .= "&start_date=" . strtotime($st);
     
    $v .= "&start_date=" . $this->input->post('start_date');
    if(empty($this->input->post('end_date')))
    {
        $v .= "&end_date=" . date("d/m/Y") . ' 23:55';
        $_POST['end_date'] = date("d/m/Y") . ' 23:55';
    }
}
if($this->input->post('end_date'))
{
    $et = $this->sma->fld($this->input->post('end_date')) . ":00";
    $v1 .= "&end_date=" . strtotime($et);
    $v .= "&end_date=" . $this->input->post('end_date');
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        var oTable = $('#PoRData').dataTable({
            "aaSorting": [[0, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('reports/getPurchasesReportC/?v=1' . $v) ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                nRow.id = aData[16];
                nRow.className = (aData[5] > 0) ? "purchase_link2" : "purchase_link2 warning";
                return nRow;
            },
            "aoColumns": [{"mRender": fld}, null, null, null, null,null,null,null,null, {"mRender": currencyFormat}, {"mRender": currencyFormat}, null, {"mRender": currencyFormat},{"mRender": currencyFormat}, {"mRender": currencyFormat}, {"mRender": row_status}],
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                var c_gst = 0, s_gst = 0, i_gst = 0, gtotal = 0, taxable_amt=0, tax_rate=0,tax_amt=0, paid = 0, balance = 0;
                for (var i = 0; i < aaData.length; i++) {
                    //c_gst += parseFloat(aaData[aiDisplay[i]][6]);
                    //s_gst += parseFloat(aaData[aiDisplay[i]][7]);
                    //i_gst += parseFloat(aaData[aiDisplay[i]][8]);

                    gtotal += parseFloat(aaData[aiDisplay[i]][9]);
                    taxable_amt += parseFloat(aaData[aiDisplay[i]][10]);
                    //tax_rate += parseFloat(aaData[aiDisplay[i]][11]);
                    tax_amt += parseFloat(aaData[aiDisplay[i]][12]);
                    paid += parseFloat(aaData[aiDisplay[i]][13]);
                    balance += parseFloat(aaData[aiDisplay[i]][14]);
                }
               var nCells = nRow.getElementsByTagName('th');
                //nCells[6].innerHTML = currencyFormat(parseFloat(c_gst));
                // nCells[7].innerHTML = currencyFormat(parseFloat(s_gst));
                // nCells[8].innerHTML = currencyFormat(parseFloat(i_gst));
                nCells[9].innerHTML = currencyFormat(parseFloat(gtotal));
                nCells[10].innerHTML = currencyFormat(parseFloat(taxable_amt));
                nCells[12].innerHTML = currencyFormat(parseFloat(tax_amt));
               // nCells[11].innerHTML = currencyFormat(parseFloat(tax_rate));
                nCells[13].innerHTML = currencyFormat(parseFloat(paid));
                nCells[14].innerHTML = currencyFormat(parseFloat(balance));
            }
        }).fnSetFilteringDelay().dtFilter([
            {
                column_number: 0,
                filter_default_label: "[<?=lang('date');?> (yyyy-mm-dd)]",
                filter_type: "text",
                data: []
            },
            {column_number: 1, filter_default_label: "[<?=lang('ref_no');?>]", filter_type: "text", data: []},
            {column_number: 2, filter_default_label: "[<?=lang('warehouse');?>]", filter_type: "text", data: []},
            {column_number: 3, filter_default_label: "[<?=lang('supplier');?>]", filter_type: "text", data: []},
            {column_number: 12, filter_default_label: "[<?=lang('status');?>]", filter_type: "text", data: []},
        ], "footer");
    });
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#form').hide();
        <?php if ($this->input->post('customer')) { ?>
        $('#supplier').val(<?= $this->input->post('supplier') ?>).select2({
            minimumInputLength: 1,
            data: [],
            initSelection: function (element, callback) {
                $.ajax({
                    type: "get", async: false,
                    url: site.base_url + "suppliers/suggestions/" + $(element).val(),
                    dataType: "json",
                    success: function (data) {
                        callback(data.results[0]);
                    }
                });
            },
            ajax: {
                url: site.base_url + "suppliers/suggestions",
                dataType: 'json',
                quietMillis: 15,
                data: function (term, page) {
                    return {
                        term: term,
                        limit: 10
                    };
                },
                results: function (data, page) {
                    if (data.results != null) {
                        return {results: data.results};
                    } else {
                        return {results: [{id: '', text: 'No Match Found'}]};
                    }
                }
            }
        });

        $('#supplier').val(<?= $this->input->post('supplier') ?>);
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
        <h2 class="blue"><i class="fa-fw fa fa-star"></i><?= lang('gst_purchases_report'); ?> <?php
            if($this->input->post('start_date'))
            {
                echo "From " . $this->input->post('start_date') . " to " . $this->input->post('end_date');
            }
            ?></h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown"><a href="#" class="toggle_up tip" title="<?= lang('hide_form') ?>"><i
                                class="icon fa fa-toggle-up"></i></a></li>
                <li class="dropdown"><a href="#" class="toggle_down tip" title="<?= lang('show_form') ?>"><i
                                class="icon fa fa-toggle-down"></i></a></li>
            </ul>
        </div>
        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle tip" href="#" title="<?= lang('purchases_tax_summary') ?>">
                        <i class="icon fa fa-tasks tip" data-placement="left"
                           ></i>
                    </a>
                    <ul class="dropdown-menu pull-right tasks-menus" role="menu" aria-labelledby="dLabel">
                        <li>
                            <a href="<?= site_url('reports/purchase_tax_report_ajax/?v=1' . $v1) ?>" data-toggle="modal"
                               data-target="#myModal">
                                <i class="fa fa-file-o"></i> <?= lang('purchases_tax_summary') ?>
                            </a>
                        </li>
                    </ul>
                </li>
                <li class="dropdown"><a href="#" id="pdf" class="tip" title="<?= lang('download_pdf') ?>"><i
                                class="icon fa fa-file-pdf-o"></i></a></li>
                <li class="dropdown"><a href="#" id="xls" class="tip" title="<?= lang('download_xls') ?>"><i
                                class="icon fa fa-file-excel-o"></i></a></li>
                <li class="dropdown"><a href="#" id="image" class="tip" title="<?= lang('save_image') ?>"><i
                                class="icon fa fa-file-picture-o"></i></a></li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang('customize_report'); ?></p>

                <div id="form">

                    <?php echo form_open("reports/purchases_gst_report"); ?>
                    <div class="row">

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="reference_no"><?= lang("reference_no"); ?></label>
                                <?php echo form_input('reference_no', (isset($_POST['reference_no']) ? $_POST['reference_no'] : ""), 'class="form-control tip" id="reference_no"'); ?>

                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="user"><?= lang("created_by"); ?></label>
                                <?php
                                $us[""] = lang('select') . ' ' . lang('user');
                                foreach($users as $user)
                                {
                                    $us[$user->id] = $user->first_name . " " . $user->last_name;
                                }
                                echo form_dropdown('user', $us, (isset($_POST['user']) ? $_POST['user'] : ""), 'class="form-control" id="user" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("user") . '"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("supplier", "supplier"); ?>
                                <?php echo form_input('supplier', (isset($_POST['supplier']) ? $_POST['supplier'] : ""), 'class="form-control" id="supplier"'); ?> </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="warehouse"><?= lang("warehouse"); ?></label>
                                <?php
                                $permisions_werehouse = explode(",",$user_warehouse);
                                $wh[""] = lang('select') . ' ' . lang('warehouse');
                                foreach($warehouses as $warehouse)
                                {
                                    if($Owner || $Admin   ){
                                        $wh[$warehouse->id] = $warehouse->name;
                                    }else if(in_array($warehouse->id,$permisions_werehouse)){
                                        $wh[$warehouse->id] = $warehouse->name;
                                    }    
                                }
                                echo form_dropdown('warehouse', $wh, (isset($_POST['warehouse']) ? $_POST['warehouse'] : ""), 'class="form-control" id="warehouse" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("warehouse") . '"');
                                ?>
                            </div>
                        </div>


                        <div class="col-sm-4">

                            <div class="form-group choose-date hidden-xs">
                                <div class="controls">
                                    <?= lang("date_range_purchase", "date_range_purchase"); ?>
                                    <div class="input-group">

                                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                        <input type="text"
                                               value="<?php echo isset($_POST['start_date']) ? $_POST['start_date'] . '-' . $_POST['end_date'] : ""; ?>"
                                               id="daterange_new" class="form-control">
                                        <span class="input-group-addon" style="display:none;"><i class="fa fa-chevron-down"></i></span>
                                        <input type="hidden" name="start_date" id="start_date"
                                               value="<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : ""; ?>">
                                        <input type="hidden" name="end_date" id="end_date"
                                               value="<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : ""; ?>">

                                    </div>
                                </div>
                            </div>

                        </div>


                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("gstn", "gstn"); ?>
                                <?php echo form_input('gstn_no', (isset($_POST['gstn_no']) ? $_POST['gstn_no'] : ""), 'class="form-control" id="gstn_no"'); ?>
                            </div>
                        </div>

                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="gstn"> With <?= lang("gstn"); ?></label>
                                <?php
                                $gstnOpt["0"] = 'ALL';
                                $gstnOpt["-1"] = 'No';
                                $gstnOpt["1"] = 'Yes';

                                echo form_dropdown('gstn_opt', $gstnOpt, (isset($_POST['gstn_opt']) ? $_POST['gstn_opt'] : "0"), 'class="form-control" id="gstn_opt" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("gstn") . ' Option"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <?= lang("hsn_code", "hsn_code"); ?>
                                <?php echo form_input('hsn_code', (isset($_POST['hsn_code']) ? $_POST['hsn_code'] : ""), 'class="form-control" id="hsn_code"'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <div  class="controls"> 
                            <?php echo form_submit('submit_report', $this->lang->line("submit"), 'class="btn btn-primary"'); ?>
                                 
                            <!--<input type="reset" id="report_reset" data-value="<?=base_url('reports/purchases_gst_report');?>" name="submit_report" value="Reset" class="btn btn-warning input-xs">-->
                                <a href="reports/restbutton" class="btn btn-success">Reset
                                </a>

<!--                            <a href="<? echo base_url('reports/purchases_gst_report'); ?>" class="btn btn-success">Reset
                                Filter</a>-->
                        </div>
                    </div>
                    <?php echo form_close(); ?>

                </div>
                <div class="clearfix"></div>

                <div class="table-responsive">
                    <table id="PoRData"
                           class="table table-bordered table-hover table-striped table-condensed reports-table">
                        <thead>
                        <tr>
                            <th><?= lang("date"); ?></th>
                            <th><?= lang("reference_no"); ?></th>
                            <th><?= lang("warehouse"); ?></th>
                            <th><?= lang("supplier"); ?></th>
                            <th><?= lang("gstn"); ?></th>
                            <th><?= lang("hsn_code", "hsn_code"); ?></th>
                            <th><?= lang("CGST"); ?></th>
                            <th><?= lang("SGST"); ?></th>
                            <th><?= lang("IGST"); ?></th>
                            <th><?= lang("grand_total"); ?></th>
                            <th><?= lang("Taxable_Amount"); ?></th>
                            <th><?= lang("GST_Rate"); ?></th>
                            <th><?= lang("Tax_Amount"); ?></th>
                            <th><?= lang("paid"); ?></th>
                            <th><?= lang("balance"); ?></th>
                            <th><?= lang("status"); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="9" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                        </tr>
                        </tbody>
                        <tfoot class="dtFilter">
                        <tr class="active">
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th></th>
                            <th><?= lang("CGST"); ?></th>
                            <th><?= lang("SGST"); ?></th>
                            <th><?= lang("IGST"); ?></th>
                            <th><?= lang("grand_total"); ?></th>
                            <th><?= lang("Taxable_Amount"); ?></th>
                            <th><?= lang("GST_Rate"); ?></th>
                            <th><?= lang("Tax_Amount"); ?></th>
                            <th><?= lang("paid"); ?></th>
                            <th><?= lang("balance"); ?></th>
                            <th></th>
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
            window.location.href = "<?=site_url('reports/getPurchasesReportC/pdf/?v=1' . $v)?>";
            return false;
        });
        $('#xls').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('reports/getPurchasesReportC/0/xls/?v=1' . $v)?>";
            return false;
        });
        $('#image').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('reports/getPurchasesReportC/0/0/xls/?v=1' . $v)?>";
            return false;
            /*event.preventDefault();
            html2canvas($('.box'), {
                onrendered: function (canvas) {
                    var img = canvas.toDataURL()
                    window.open(img);
                }
            });
            return false;*/
        });
    });
</script>