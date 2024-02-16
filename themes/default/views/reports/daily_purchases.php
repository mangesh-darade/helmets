<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if($Owner || $Admin){
        $allwarehouse = '0';
}else{
    $allwarehouse = str_replace(",", "_",$this->session->userdata('warehouse_id'));
} ?>

<style>
    .table th {
        text-align: center;
    }

    .table td {
        padding: 2px;
    }

    .table td .table td:nth-child(odd) {
        text-align: left;
    }

    .table td .table td:nth-child(even) {
        text-align: right;
    }

    .table a:hover {
        text-decoration: none;
    }

    .cl_wday {
        text-align: center;
        font-weight: bold;
    }

    .cl_equal {
        width: 14%;
    }

    td.day {
        width: 14%;
        padding: 0 !important;
        vertical-align: top !important;
    }

    .day_num {
        width: 100%;
        text-align: left;
        margin: 0;
        padding: 8px;
    }

    .day_num:hover {
        background: #F5F5F5;
    }

    .content {
        width: 100%;
        text-align: left;
        color: #428bca;
        padding: 8px;
    }

    .highlight {
        color: #0088CC;
        font-weight: bold;
    }
</style>
<div class="box">
    <div class="box-header">
                     <h2 class="blue"><i class="fa-fw fa fa-calendar"></i><?= lang('daily_purchases').' ('.($sel_warehouse ? isset($sel_warehouse[$this->uri->segment(3)]->name)?$sel_warehouse[$this->uri->segment(3)]->name: lang('all_warehouses'): lang('all_warehouses')).')'; ?></h2>


        <div class="box-icon">
            <ul class="btn-tasks">
                <?php //if (!empty($warehouses) && !$this->session->userdata('warehouse_id')) { ?>
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-building-o tip" data-placement="left" title="<?=lang("warehouses")?>"></i></a>
                        <ul class="dropdown-menu pull-right tasks-menus" role="menu" aria-labelledby="dLabel">
                           
                            <li><a href="<?=site_url('reports/daily_purchases/0/'.$year.'/'.$month)?>"><i class="fa fa-building-o"></i> <?=lang('all_warehouses')?></a></li>
                           
                            <li class="divider"></li>
                            <?php
                                 $permisions_werehouse = explode(",", $warehouse_id);
                                foreach ($warehouses as $warehouse) {
                                    if($Owner || $Admin   ){
                                        echo '<li><a href="' . site_url('reports/daily_purchases/'.$warehouse->id.'/'.$year.'/'.$month) . '"><i class="fa fa-building"></i>' . $warehouse->name . '</a></li>';
                                    }elseif (in_array($warehouse->id,$permisions_werehouse)) {
                                        echo '<li><a href="' . site_url('reports/daily_purchases/'.$warehouse->id.'/'.$year.'/'.$month) . '"><i class="fa fa-building"></i>' . $warehouse->name . '</a></li>';

                                    }
                                }    
                                ?>
                        </ul>
                    </li>
                <?php //} ?>
                <li class="dropdown">
                    <a href="#" id="xls" class="tip" title="<?= lang('download_xls') ?>">
                        <i class="icon fa fa-file-excel-o"></i>
                    </a>
                </li>
                <li class="dropdown">
                    <a href="#" id="pdf" class="tip" title="<?= lang('download_pdf') ?>">
                        <i class="icon fa fa-file-pdf-o"></i>
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
            <div class="col-lg-12">
                <p class="introtext"><?= lang('get_day_profit').' '.lang("reports_calendar_text") ?></p>

                <div>
                    <?php echo $calender; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalDailyPurchase" class="modal fade" role="dialog">
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
        $('.table .day_num').click(function () {
            var day = $(this).html();
            var date = '<?= $year.'-'.$month.'-'; ?>'+day;
            var href = '<?= site_url('reports/profit'); ?>/'+date+'/<?= ($warehouse_id ? $warehouse_id : ''); ?>';
            $.get(href, function( data ) {
                $("#myModal").html(data).modal();
            });

        });
        $('#pdf').click(function (event) {
            event.preventDefault();
            //window.location.href = "<?=site_url('reports/daily_purchases/'.($sel_warehouse ? $sel_warehouse->id  : 0).'/'.$year.'/'.$month.'/pdf')?>"; // Problem for Calander
            window.location.href = "<?=site_url('reports/daily_purchases/'.(($this->uri->segment(3))?$this->uri->segment(3):0).'/'.$year.'/'.$month.'/pdf')?>"; // Update 09-09-19
            return false;
        });
         $('#xls').click(function (event) {
            event.preventDefault();
            //window.location.href = "<?=site_url('reports/daily_purchases/'.($sel_warehouse ? $sel_warehouse->id : 0).'/'.$year.'/'.$month.'/xls')?>"; // Problem for Calander
            window.location.href = "<?=site_url('reports/daily_purchases/'.(($this->uri->segment(3))?$this->uri->segment(3):0).'/'.$year.'/'.$month.'/xls')?>"; // Update 09-09-19
            return false;
        });
        $('#image').click(function (event) {
            event.preventDefault();
	   // window.location.href = "<?=site_url('reports/daily_purchases/'.($sel_warehouse ? $sel_warehouse->id : 0).'/'.$year.'/'.$month.'/img')?>"; // Problem for Calander
	    window.location.href = "<?=site_url('reports/daily_purchases/'.(($this->uri->segment(3))?$this->uri->segment(3):0).'/'.$year.'/'.$month.'/img')?>"; // Update 09-09-19
            /*html2canvas($('.box'), {
                onrendered: function (canvas) {
                    var img = canvas.toDataURL()
                    window.open(img);
                }
            });*/
            return false;
        });
    });

   function getpurchaseitems(Y,M,D){
        var date = Y+'-'+M+'-'+D;
        var Showdate = D+'-'+M+'-'+Y;
        $('#model_title').html('Daily items Purchase report dated : '+Showdate);
        $('#model_body').html('<h4><i class="fa fa-refresh fa-spin text-danger" ></i> Please Wait ... </h4>');
        var postData = 'date=' + date;
        var href = '<?= site_url('reports/daily_purchase_items'); ?>?'+postData;
            $.get(href, function( data ) {
                $("#model_body").html(data);
            });
        $('#modalDailyPurchase').modal('show');daily_purchase_items_print
    }
     
    function getpurchaseitemstaxes(Y,M,D){
        
        var date = Y+'-'+M+'-'+D;
        var Showdate = D+'-'+M+'-'+Y;
        $('#model_title').html('Daily Purchase tax report dated : '+Showdate);
        
        $('#model_body').html('<h4><i class="fa fa-refresh fa-spin text-danger" ></i> Please Wait ... </h4>');
        
	var active_warehouse_id = $('#active_warehouse_id').val(); 
      
	var postData = 'date=' + date;
        //var postData = 'date=' + date+'&active_warehouse_id='+active_warehouse_id ;
      
        var href = '<?= site_url('reports/daily_purchase_items_taxes'); ?>?'+postData;
            $.get(href, function( data ) {
                $("#model_body").html(data);
            });
       
        $('#modalDailyPurchase').modal('show');
    }


    function printdiv(date){ 
        var postData = 'date=' + date;
        var newWin = window.open();
        var href = '<?= site_url('reports/daily_purchase_items_print'); ?>?'+postData;
            $.get(href, function( data ) {
                 newWin.document.write('<!DOCTYPE HTML><html><head><title>Daily items purchase report </title><style>table { border-collapse: collapse;} table, td, th { border: 1px solid black;} </style>');
                newWin.document.write('</head><body><center>');
                newWin.document.write(data);
                newWin.document.write('</center></body>');
                newWin.document.write('</html>');
                newWin.print();
                newWin.close();
            });
               
    };
   
</script>
