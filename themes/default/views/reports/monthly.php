<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<?php if($Owner || $Admin){
        $allwarehouse = '0';
}else{
    $allwarehouse = str_replace(",", "_",$this->session->userdata('warehouse_id'));
} ?>

<style type="text/css">
    .dfTable th, .dfTable td {
        text-align: left;
        vertical-align: middle;
    }

    .dfTable td {
        padding: 2px;
    }
    
    td.center {
        text-align: center;
    }

    .data tr td:nth-child(odd) {
        color: #2FA4E7;
    }

   /* .data tr:nth-child(even) td {
        text-align: right;
    }*/
</style>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-calendar"></i><?= lang('monthly_sales').' ('.($sel_warehouse ?$sel_warehouse[$this->uri->segment(3)]->name : lang('all_warehouses')).')'; ?></h2>

        <div class="box-icon">
            <ul class="btn-tasks">
                <?php //if (!empty($warehouses) && !$this->session->userdata('warehouse_id')) { ?>
                    <li class="dropdown">
                        <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-building-o tip" data-placement="left" title="<?=lang("warehouses")?>"></i></a>
                        <ul class="dropdown-menu pull-right tasks-menus" role="menu" aria-labelledby="dLabel">
                           
                            <li><a href="<?=site_url('reports/monthly_sales/'.$allwarehouse.'/'.$year)?>"><i class="fa fa-building-o"></i> <?=lang('all_warehouses')?></a></li>
                          
                            <li class="divider"></li>
                            <?php
                                $permisions_werehouse = explode(",", $warehouse_id);
                                foreach ($warehouses as $warehouse) {
                                    if($Owner || $Admin   ){
                                        echo '<li><a href="' . site_url('reports/monthly_sales/'.$warehouse->id.'/'.$year) . '"><i class="fa fa-building"></i>' . $warehouse->name . '</a></li>';
                                    }else if(in_array($warehouse->id,$permisions_werehouse)){
                                        echo '<li><a href="' . site_url('reports/monthly_sales/'.$warehouse->id.'/'.$year) . '"><i class="fa fa-building"></i>' . $warehouse->name . '</a></li>';
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
                <p class="introtext"><?= lang("reports_calendar_text") ?></p>
                <?php $key =  $sel_warehouse ? array_keys($sel_warehouse) : 0 ;?>
                <div class="table-responsive">
                    <table class="table table-bordered table-striped dfTable reports-table">
                        <thead>
                        <tr class="year_roller">
<!--                         <th><a class="white" href="<?= site_url('reports/monthly_sales/'.($sel_warehouse ?$sel_warehouse->id : 0).'/'.($year-1)); ?>">&lt;&lt;</a></th>-->
                            <th><a class="white" href="<?= site_url('reports/monthly_sales/'.($sel_warehouse ? $key[0] : 0).'/'.($year-1)); ?>">&lt;&lt;</a></th>
                            <th colspan="4"> <?php echo $year; ?></th>
                            <th><a class="white" href="<?= site_url('reports/monthly_sales/'.($sel_warehouse ? $key[0]: 0).'/'.($year+1)); ?>">&gt;&gt;</a></th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr>
                            <td class="bold text-center">
                                <a href="<?= site_url('reports/monthly_profit/'.$year.'/01'); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= lang("cal_january"); ?>
                                </a>
                            </td>
                            <td class="bold text-center">
                                <a href="<?= site_url('reports/monthly_profit/'.$year.'/02'); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= lang("cal_february"); ?>
                                </a>
                            </td>
                            <td class="bold text-center">
                                <a href="<?= site_url('reports/monthly_profit/'.$year.'/03'); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= lang("cal_march"); ?>
                                </a>
                            </td>
                            <td class="bold text-center">
                                <a href="<?= site_url('reports/monthly_profit/'.$year.'/04'); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= lang("cal_april"); ?>
                                </a>
                            </td>
                        
                            <td class="bold text-center">
                                <a href="<?= site_url('reports/monthly_profit/'.$year.'/05'); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= lang("cal_may"); ?>
                                </a>
                            </td>
                            <td class="bold text-center">
                                <a href="<?= site_url('reports/monthly_profit/'.$year.'/06'); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= lang("cal_june"); ?>
                                </a>
                            </td>
                            
                        </tr>
                        <tr>
                            <?php
                            
                            if (!empty($sales)) {
                                 
                                foreach ($sales as $value) {
                                    $array[$value->date] = "<table class='table table-bordered table-hover table-striped table-condensed data' style='margin:0;'>$thead<tbody><tr><td>" . $this->lang->line("discount") . "</td><td>" . $this->sma->formatMoney($value->discount) . "</td></tr><tr><td>" . $this->lang->line("shipping") . "</td><td>" . $this->sma->formatMoney($value->shipping) . "</td></tr><tr style='cursor: pointer'><td onclick='getsaleitemstaxes(".$year.",".$value->date.",\"". date("F", mktime(0, 0, 0, $value->date, 10))."\")'>" . $this->lang->line("product_tax") . " <i class='fa fa-list-alt' aria-hidden='true'></i></td><td>" . $this->sma->formatMoney($value->tax1) . "</td></tr><tr><td>" . $this->lang->line("order_tax") . "</td><td>" . $this->sma->formatMoney($value->tax2) . "</td></tr><tr><td>" . $this->lang->line("total") . "</td><td>" . $this->sma->formatMoney($value->total) . "</td></tr></tbody></table>";
                                }
                                for ($i = 1; $i <= 6; $i++) {
                                    
                                    echo '<td class="center">';
                                    if (isset($array[$i])) {
                                        echo $array[$i];
                                    } else {
                                       echo "<strong><i>NULL</i></strong>";
                                    }
                                    echo '</td>';
                                }
                            } else {
                                for ($i = 1; $i <= 6; $i++) {
                                    echo '<td class="center"><strong><i>NULL</i></strong></td>';
                                }
                            }
                            ?>
                        </tr>
                        <tr>
                            <td class="bold text-center">
                                <a href="<?= site_url('reports/monthly_profit/'.$year.'/07'); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= lang("cal_july"); ?>
                                </a>
                            </td>
                            <td class="bold text-center">
                                <a href="<?= site_url('reports/monthly_profit/'.$year.'/08'); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= lang("cal_august"); ?>
                                </a>
                            </td>
                        
                            <td class="bold text-center">
                                <a href="<?= site_url('reports/monthly_profit/'.$year.'/09'); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= lang("cal_september"); ?>
                                </a>
                            </td>
                            <td class="bold text-center">
                                <a href="<?= site_url('reports/monthly_profit/'.$year.'/10'); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= lang("cal_october"); ?>
                                </a>
                            </td>
                            <td class="bold text-center">
                                <a href="<?= site_url('reports/monthly_profit/'.$year.'/11'); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= lang("cal_november"); ?>
                                </a>
                            </td>
                            <td class="bold text-center">
                                <a href="<?= site_url('reports/monthly_profit/'.$year.'/12'); ?>" data-toggle="modal" data-target="#myModal">
                                    <?= lang("cal_december"); ?>
                                </a>
                            </td>
                        </tr>
                        <tr>
                            <?php
                            
                            if (!empty($sales)) {                                 
                               
                                for ($i = 7; $i <= 12; $i++) {
                                    
                                    echo '<td class="center">';
                                    if (isset($array[$i])) {
                                        echo $array[$i];
                                    } else {
                                       echo "<strong><i>NULL</i></strong>";
                                    }
                                    echo '</td>';
                                }
                            } else {
                                for ($i = 7; $i <= 12; $i++) {
                                    echo '<td class="center"><strong><i>NULL</i></strong></td>';
                                }
                            }
                            ?>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div id="modalMonthlySales" class="modal fade" role="dialog">
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
            //window.location.href = "<?php //site_url('reports/monthly_sales/'.($sel_warehouse ?$sel_warehouse->id : 0).'/'.$year.'/pdf')?>"; // problem for calander
            window.location.href = "<?= site_url('reports/monthly_sales/'.(($this->uri->segment(3))?$this->uri->segment(3):0).'/'.$year.'/pdf')?>"; // Update 9-9-19
            return false;
        });
        
        $('#xls').click(function (event) {
            event.preventDefault();
            //window.location.href = "<?php // site_url('reports/monthly_sales/'.($sel_warehouse ?$sel_warehouse->id: 0).'/'.$year.'/xls')?>";// problem for calander
            window.location.href = "<?= site_url('reports/monthly_sales/'.(($this->uri->segment(3))?$this->uri->segment(3):0).'/'.$year.'/xls')?>"; // Update 9-9-19
            return false;
        });
        
        $('#image').click(function (event) {
            event.preventDefault();
	    //window.location.href = "<?php //site_url('reports/monthly_sales/'.($sel_warehouse ?$sel_warehouse->id: 0).'/'.$year.'/img')?>"; // problem for calander
	    window.location.href = "<?= site_url('reports/monthly_sales/'.(($this->uri->segment(3))?$this->uri->segment(3):0).'/'.$year.'/img')?>"; // Update 9-9-19
            /*html2canvas($('.box'), {
                onrendered: function (canvas) {
                    var img = canvas.toDataURL()
                    window.open(img);
                }
            });*/
			
            return false;
        });
    });
    
    
     function getsaleitemstaxes(Y,M,Month){
     
        var Showdate = Month + ' ' + Y;
       
        $('#model_title').html('Monthly sale tax report of month : '+Showdate);
        
        $('#model_body').html('<h4><i class="fa fa-refresh fa-spin text-danger" ></i> Please Wait ... </h4>');
        
	var postData = 'month=' + M + '&year=' + Y;
          
        var href = '<?= site_url('reports/monthly_sales_items_taxes'); ?>?'+postData;
        
            $.get(href, function( data ) {
                $("#model_body").html(data);
            });
	
        $('#modalMonthlySales').modal('show');
    }
</script>
