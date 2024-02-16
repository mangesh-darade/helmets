<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php
$user_warehouse = $this->session->userdata('warehouse_id');
if ($this->input->post('start_date')) {
    $start_date = $this->input->post('start_date');
} else {
    $start_date = date('d/m/Y').' 00:00';
}
if ($this->input->post('end_date')) {
    $end_date = $this->input->post('end_date');
} else {
     $end_date = date('d/m/Y H:i');
}
if ($this->input->post('report_type')) {
    $report_type = $this->input->post('report_type');
} else {
    $report_type = 1;
}

$v = "&start_date=$start_date&end_date=$end_date";
$v .= "&report_type=".$report_type;
$v .=($user_warehouse=='0' ||$user_warehouse==NULL)?'':"&warehouse=" . str_replace(",", "_",$user_warehouse);


?>

 
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
        <h2 class="blue"><i class="fa-fw fa fa-heart"></i>Warehouse <?= lang('sales_report') ?> <?php
            if ($start_date) {
                echo "From " . $start_date . " to " . $end_date;
            }
            ?>
        </h2>
        <!--<div class="box-icon">
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
        </div>-->
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
                <li class="dropdown" style="display:none;">
                    <a href="#" id="image" class="tip" title="<?= lang('save_image') ?>">
                        <i class="icon fa fa-file-picture-o"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                 <?php echo form_open("reports/warehouse_sales"); ?>
                <div class="col-sm-4" style="width: 420px;" >                        
                    <div class="form-group choose-date hidden-xs">
                        <div class="controls">
                             <div class="input-group">
                                 <span class="input-group-addon"> <?= lang("Report date", "date"); ?></span>
                                 <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
                                 <input type="text"
                                        value="<?php echo isset($_POST['start_date']) ? $_POST['start_date'].'-'.$_POST['end_date'] : "$start_date - $end_date";?>"
                                        id="daterange_new" class="form-control">
                                 <span class="input-group-addon" style="display:none;"><i class="fa fa-chevron-down"></i></span>
                                  <input type="hidden" name="start_date"  id="start_date" value="<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : $start_date;?>">
                                  <input type="hidden" name="end_date"  id="end_date" value="<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : $end_date;?>" >
                             </div>
                         </div>
                     </div>
                 </div>
                 <div class="col-sm-4" style="width: 400px;">                        
                    <div class="form-group hidden-xs">
                        <div class="controls">
                            <div class="input-group">	
                                <?php
                                if($report_type){
                                    $selected = '_'.$report_type;
                                    $$selected = ' selected="selected" ';
                                }
                                ?>
                                <span class="input-group-addon"><?= lang("Report type", "report_type"); ?></span>

                                <select name="report_type" id="report_type" class="form-control" >
                                    <option value="1" <?=$_1?>>Sales compare and balance stock</option>
                                    <option value="2" <?=$_2?>>Sales compare and sold items</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
                <div>
                    <?php echo form_submit('submit_report', $this->lang->line("submit"), 'class="btn btn-primary"'); ?>                            
                     <a  id="report_reset" href="<?=base_url('reports/warehouse_sales');?>" class="btn btn-warning input-xs">Reset</a> 
                </div>
                <?php echo form_close(); ?>
                
                <div class="clearfix"></div>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive" id="report_table">
                   <?=lang('loading_data_from_server')?> 
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalDailySales" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width:80%; max-height: 500px;">
    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title" id="model_title"></h4>
      </div>
      <div class="modal-body" id="model_body"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript" src="<?= $assets ?>js/html2canvas.min.js"></script>


<script type="text/javascript">
       
    $(document).ready(function () {
        $('#pdf').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('reports/getWarehouseSalesReport/pdf/?v=1'.$v)?>";
            return false;
        });
        $('#xls').click(function (event) {
            event.preventDefault();
            window.location.href = "<?=site_url('reports/getWarehouseSalesReport/0/xls/?v=1'.$v)?>";
            return false;
        });        
		$('#image').click(function (event) {
            event.preventDefault();
			window.location.href = "<?=site_url('reports/getWarehouseSalesReport/0/0/img/?v=1'.$v)?>";
            return false;
    });
    });
  
     $.ajax({
            type: "get",
            url: 'reports/getWarehouseSalesReport',
            data:"<?='v=1'.$v?>",
            beforeSend: function(){
                $("#report_table").html("<div class='overlay'><i class='fa fa-refresh fa-spin'></i>Loading data from server</div>");
                
            },
            success: function(data){			 
               $("#report_table").html(data);
               setTimeout(function(){ $('#warehouses_products').DataTable({"aLengthMenu": [[10, 25, 50, 100, -1], [10, 25, 50, 100, "<?= lang('all') ?>"]],}); }, 1000);

               //setTimeout(function(){ $('#warehouses_products').DataTable(); }, 1000);
            }
	}); 
        
   function getsaleitems(startdate, enddata, wh){
    
        
        $('#model_title').html(wh + 'items sale report dated between: '+startdate+' to '+enddata);
        
        $('#model_body').html('<h4><i class="fa fa-refresh fa-spin text-danger" ></i> Please Wait ... </h4>');
        
	var postData = 'startdate=' + startdate;
	 postData = postData + '&enddata=' + enddata;
	 postData = postData + '&werehouse=' + wh;
          
          var href = '<?= site_url('reports/get_sales_items'); ?>?'+postData;
            $.get(href, function( data ) {
                $("#model_body").html(data);
            });
          
	
        $('#modalDailySales').modal('show');
    }
</script>
