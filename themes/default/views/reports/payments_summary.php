<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$v = "";
$payment_option = $this->reports_model->payment_option();



if ($this->input->post('paymenttype')) {
    $v .= "&paymenttype=" . $this->input->post('paymenttype');
}
if ($this->input->post('start_date')) {
    $startDate = explode('/', substr($this->input->post('start_date') , 0, 10));
    $start_date = $startDate[2] . "-" . $startDate[1] . "-" . $startDate[0] . "  00:00";
    $v .= "&start_date=" . $start_date;
}
if ($this->input->post('end_date')) {
    $endDate = explode('/', substr($this->input->post('end_date') , 0, 10));
    $end_date = $endDate[2] . "-" . $endDate[1] . "-" . $endDate[0]. "  23:59";
    $v .= "&end_date=" . $end_date;
}


if ($this->input->post('user')) {
    $v .= "&user=" . $this->input->post('user');
}

if ($this->input->post('warehouse')) {
    $v .= "&warehouse=" . $this->input->post('warehouse');
}


?>
<script>
    $(document).ready(function () {
        var pb = <?= json_encode($pb); ?>;
        function paid_by(x) {
            return (x != null) ? (pb[x] ? pb[x] : x) : x;
        }

        function ref(x) {
            return (x != null) ? x : ' ';
        }
        
       

        var oTable = $('#PayRData').dataTable({
            "aaSorting": [[0, "desc"]],
            "aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],
            "iDisplayLength": <?= $Settings->rows_per_page ?>,
            'bProcessing': true, 'bServerSide': true,
            'sAjaxSource': '<?= site_url('reports/getPaymentSummary/?v=1' . $v) ?>',
            'fnServerData': function (sSource, aoData, fnCallback) {
                aoData.push({
                    "name": "<?= $this->security->get_csrf_token_name() ?>",
                    "value": "<?= $this->security->get_csrf_hash() ?>"
                });
                $.ajax({'dataType': 'json', 'type': 'POST', 'url': sSource, 'data': aoData, 'success': fnCallback});
            },
            "aoColumns": [{"mRender": fsd}, {"bVisible": false}, null, <?php foreach($payment_option as $pay_option){ ?>{"mRender": currencyFormat},<?php }?>
            {"mRender": currencyFormat}],
            'fnRowCallback': function (nRow, aData, iDisplayIndex) {
                nRow.id = aData[3];
               nRow.className = " text-right text-capitalize";
              
                <?php $keydata = 2; foreach($payment_option as $pay_option){ ?>
                 var nCells = nRow.getElementsByTagName('td');
                 var paydate = aData[0];    
                 var paytype = aData[2];
                 var payoption = '<?= $pay_option?>';
                

                 var url = '<?= site_url("reports/getpaidamount/") ?>?date='+paydate+'&option='+payoption+"&type="+paytype+'<?= $v ?>';
                   $.ajax({
                    type:'ajax',
                    dataType:'json',
                    url:url,
                    async:true,
                    success:function(result){
                        nCells['<?= $keydata ?>'].innerHTML =  currencyFormat(result['data']);
                        nRow.className = "text-right text-capitalize";
                    
                     
                    }, error:function(){
                        nCells['<?= $keydata ?>'].innerHTML = currencyFormat(0);
                    }
                
                });   
            
                <?php $keydata++; } ?>
              nCells['<?= $keydata ?>'].innerHTML = currencyFormat(aData[1]);
            },
            "fnFooterCallback": function (nRow, aaData, iStart, iEnd, aiDisplay) {
                
             
                var total = 0;
        
                for (var i = 0; i < aaData.length; i++) {
                   
                    total += parseFloat(aaData[aiDisplay[i]][1]);
                }    
                var nCells = nRow.getElementsByTagName('th');
              
                 
                nCells[<?= $keydata ?>].innerHTML = currencyFormat(parseFloat(total));

                <?php $keydata = 2; foreach($payment_option as $pay_option){ ?>
                 var nCells = nRow.getElementsByTagName('th');
               
                 var payoption = '<?= $pay_option?>';
                

                 var url = '<?= site_url("reports/getpaidtotal/") ?>?&option='+payoption+'<?= $v ?>';
                   $.ajax({
                    type:'ajax',
                    dataType:'json',
                    url:url,
                    async:true,
                    success:function(result){
                      
                        nCells['<?= $keydata ?>'].innerHTML =  currencyFormat(result['data']);
                        nRow.className = "text-right text-capitalize";
                       
                    }, error:function(){
                        nCells['<?= $keydata ?>'].innerHTML = currencyFormat(0);
                    }
                
                });   
            
                <?php $keydata++; } ?>
  
            }
        }).fnSetFilteringDelay().dtFilter([
            {column_number: 0, filter_default_label: "[<?=lang('date');?> (yyyy-mm-dd)]", filter_type: "text", data: []},
            {column_number: 1  , filter_default_label: "[<?=lang('Total');?>]", filter_type: "text", data: []},
            {column_number: 2, filter_default_label: "[<?=lang('type');?>]", filter_type: "text", data: []},      
            
            <?php $key = 3; foreach($payment_option as $pay_option){ ?>
             {column_number: '<?= $key ?>', filter_default_label: "[<?= ucfirst($pay_option) ?>]", filter_type: "text", data: []},             
            <?php $key++; } ?>

            {column_number: <?= $key ?>  , filter_default_label: "[<?=lang('Total');?>]", filter_type: "text", data: []},
        ], "footer");

    });
    
    
    
    
</script>
<script type="text/javascript">
    $(document).ready(function () {
        $('#form').hide();
       
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
        <h2 class="blue"><i class="fa-fw fa fa-money"></i><?= lang('Payments Summary'); ?> <?php
            if ($this->input->post('start_date')) {
                echo "From " . $this->input->post('start_date') . " to " . $this->input->post('end_date');
            } ?>
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
                    <a href="#" id="pdf" class="tip" title="<?= lang('download_pdf') ?>  ">
                        <i class="icon fa fa-file-pdf-o"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" id="xls" class="tip" title="<?= lang('download_xls') ?>  ">
                        <i class="icon fa fa-file-excel-o"></i>
                    </a>
                </li>
                
                
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang('customize_report'); ?></p>

                <div id="form">

                    <?php echo form_open("reports/paymentssummary"); ?>
                    <div class="row">
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="payment Type"><?= lang("Payment Type"); ?></label>
                                <?php
                                $us[""] = lang('select').' '.lang('Type');
                                $us["sent"] = "Sent";
                                $us["received"] = "Received";
                                $us["returned"] = "Returned";

                                echo form_dropdown('paymenttype', $us, (isset($_POST['paymenttype']) ? $_POST['paymenttype'] : ""), 'class="form-control" id="user" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line('Payment Type') . '"');
                                ?>
                            </div>
                        </div>
                        <div class="col-sm-4">                        
                            <div class="form-group choose-date hidden-xs">
		                <div class="controls">
		                    <?= lang("date_range", "date_range"); ?>
		                    <div class="input-group">
		                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                        <input type="text"
		                               value="<?php echo isset($_POST['start_date']) ? $_POST['start_date'].'-'.$_POST['end_date'] : "";?>"
                                               id="daterange_new" class="form-control" autocomplete="off">
		                        <!--<span class="input-group-addon"><i class="fa fa-chevron-down"></i></span>-->
		                         <input type="hidden" name="start_date"  id="start_date" value="<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : "";?>">
		                         <input type="hidden" name="end_date"  id="end_date" value="<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : "";?>" >
                                    </div>
		                </div>
		            </div>
                        </div>
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="user"><?= lang("created_by"); ?></label>
                                <?php
                                $use[""] = lang('select').' '.lang('user');
                                foreach ($users as $user) {
                                    $use[$user->id] = $user->first_name . " " . $user->last_name;
                                }
                                echo form_dropdown('user', $use, (isset($_POST['user']) ? $_POST['user'] : ""), 'class="form-control" id="user" data-placeholder="' . $this->lang->line("select") . " " . $this->lang->line("user") . '"');
                                ?>
                            </div>
                        </div>
                        
                        <div class="col-sm-4">
                            <div class="form-group">
                                <label class="control-label" for="warehouse"><?= lang("warehouse"); ?></label>
                                <?php
                                $permisions_werehouse = explode(",", $user_warehouse);
                                $wh[""] = lang('select').' '.lang('warehouse');
                                foreach ($warehouses as $warehouse) {
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
                    </div>
                    <div class="form-group">
                        <div class="controls">
                            <?php echo form_submit('submit_report', $this->lang->line("submit"), 'class="btn btn-primary"'); ?>
                            
                            <!--<input type="button" id="report_reset" data-value="<?=base_url('reports/payments');?>" name="submit_report" value="Reset" class="btn btn-warning input-xs"> -->
                            <a href="<?=base_url('reports/paymentssummary');?>" class="btn btn-warning input-xs">Reset</a>
                        </div>
                    </div>
                    <?php echo form_close(); ?>

                </div>
                <div class="clearfix"></div>


                <div class="table-responsive">
                    <table id="PayRData"
                           class="table table-bordered table-hover table-striped table-condensed reports-table">

                        <thead>
                        <tr>
                            <th><?= lang("date"); ?></th>
                            <th><?= lang("Total"); ?></th>
                            <th><?= lang("type"); ?></th>
                            <?php foreach($payment_option as $pay_option){ ?>
                            <th class="text-capitalize"><?= ucfirst($pay_option)?></th>
                            <?php } ?>
                            <th><?= lang("Total"); ?></th>
                            
                            
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td colspan="7" class="dataTables_empty"><?= lang('loading_data_from_server') ?></td>
                        </tr>
                        </tbody>
                        <tfoot class="dtFilter">
                        <tr class="active">
                            <th></th><th></th><th></th>
                             <?php foreach($payment_option as $pay_option){ ?>
                             <th></th>
                            <?php } ?>
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
            window.location.href = "<?=site_url('reports/getPaymentSummary/pdf/?v=1'.$v)?>";
            return false;
        });
        $('#xls').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('reports/getPaymentSummary/0/xls/?v=1'.$v)?>";
            return false;
        });
    });
</script>