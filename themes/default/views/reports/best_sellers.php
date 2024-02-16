<?php defined('BASEPATH') OR exit('No direct script access allowed');
 
 ?>
<style>
    .select2-container .select2-choice, #goicon button{height:40px !important;}
</style>
    
<script src="<?= $assets; ?>js/hc/highcharts.js"></script>
<script type="text/javascript">
    $(function () {
        Highcharts.getOptions().colors = Highcharts.map(Highcharts.getOptions().colors, function (color) {
            return {
                radialGradient: {cx: 0.5, cy: 0.3, r: 0.7},
                stops: [[0, color], [1, Highcharts.Color(color).brighten(-0.3).get('rgb')]]
            };
        });
        <?php if ($m2bs) { ?>
        $('#m2bschart').highcharts({
            chart: {type: 'column'},
            title: {text: ''},
            credits: {enabled: false},
            xAxis: {type: 'category', labels: {rotation: -60, style: {fontSize: '13px'}}},
            yAxis: {min: 0, title: {text: ''}},
            legend: {enabled: false},
            series: [{
                name: '<?=lang('sold');?>',
                data: [<?php
                foreach ($m2bs as $r) {
                    if($r->quantity > 0) {
                        echo "['".$r->product_name."<br>(".$r->product_code.")', ".$r->quantity."],";
                    }
                }
                ?>],
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    overflow: 'none',
                    crop: false,
                    color: '#000',
                    align: 'right',
                    y: -25,
                    style: {fontSize: '11px'}
                }
            }]
        });
        <?php } if ($m1bs) { ?>
        $('#m1bschart').highcharts({
            chart: {type: 'column'},
            title: {text: ''},
            credits: {enabled: false},
            xAxis: {type: 'category', labels: {rotation: -60, style: {fontSize: '13px'}}},
            yAxis: {min: 0, title: {text: ''}},
            legend: {enabled: false},
            series: [{
                name: '<?=lang('sold');?>',
                data: [<?php
            foreach ($m1bs as $r) {
                if($r->quantity > 0) {
                    echo "['".$r->product_name."<br>(".$r->product_code.")', ".$r->quantity."],";
                }
            }
            ?>],
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#000',
                    align: 'right',
                     overflow: 'none',
                    crop: false,
                    y: -25,
                    style: {fontSize: '11px'}
                }
            }]
        });
        <?php } if ($m3bs) { ?>
        $('#m3bschart').highcharts({
            chart: {type: 'column'},
            title: {text: ''},
            credits: {enabled: false},
            xAxis: {type: 'category', labels: {rotation: -60, style: {fontSize: '13px'}}},
            yAxis: {min: 0, title: {text: ''}},
            legend: {enabled: false},
            series: [{
                name: '<?=lang('sold');?>',
                data: [<?php
            foreach ($m3bs as $r) {
                if($r->quantity > 0) {
                    echo "['".$r->product_name."<br>(".$r->product_code.")', ".$r->quantity."],";
                }
            }
            ?>],
                dataLabels: {
                    enabled: true,
                    rotation: -90,
                    color: '#000',
                    align: 'right',
                     overflow: 'none',
                    crop: false,
                    y: -25,
                    style: {fontSize: '11px'}
                }
            }]
        });
        <?php } if ($m4bs) { ?>
        $('#m4bschart').highcharts({
            chart: {type: 'column'},
            title: {text: ''},
            credits: {enabled: false},
            xAxis: {type: 'category', labels: {rotation: -60, style: {fontSize: '13px'}}},
            yAxis: {min: 0, title: {text: ''}},
            legend: {enabled: false},
            series: [{
                name: '<?=lang('sold');?>',
                data: [<?php
            foreach ($m4bs as $r) {
                if($r->quantity > 0) {
                    echo "['".$r->product_name."<br>(".$r->product_code.")', ".$r->quantity."],";
                }
            }
            ?>],
                dataLabels: {
                    enabled: true, 
                    rotation: -90,
                    color: '#000',
                    overflow: 'none',
                    crop: false,
                    align: 'right',
              y: -50,
                    style: {fontSize: '11px'}
                }
            }]
        });
        <?php } ?>
    });
 $(document).ready(function(){
     $("#go").click(function(){
         var year = $('#year').val();
         var month = $('#month').val();
         var wareId = $('#ware').val();
        window.location = "<?php echo site_url('reports/best_sellers/')?>"+wareId + '/' +year +'/' +month;
     })
 });

</script>

<div class="box">
    <div class="box-header">
        <?php $warehouse_id = $this->uri->segment(3); ?>
        <h2 class="blue">
            <i class="fa-fw fa fa-line-chart"></i>
            <?= lang('best_sellers').' (' . ($warehouse ? $warehouse[$warehouse_id]->name : lang('all_warehouses')) . ')'; ?>
        </h2>
<?php// if (!empty($warehouses)) { ?>
<!--        <div class="box-icon">
            <ul class="btn-tasks">
                <li class="dropdown">
                    <a data-toggle="dropdown" class="dropdown-toggle" href="#"><i class="icon fa fa-building-o tip" data-placement="left" title="<?= lang("warehouses") ?>"></i></a>
                    <ul class="dropdown-menu pull-right tasks-menus" role="menu" aria-labelledby="dLabel">
                        <li><a href="<?php  site_url('reports/best_sellers') ?>"><i class="fa fa-building-o"></i> <?= lang('all_warehouses') ?></a></li>
                        <li class="divider"></li>
                        <?php
                        foreach ($warehouses as $warehouse) {
                            echo '<li><a class= "ware" href="' . site_url('reports/best_sellers/' . $warehouse->id) . '"><i class="fa fa-building"></i>' . $warehouse->name . '</a></li>';
                        }
                        ?>
                    </ul>
                </li>
            </ul>
        </div>-->
        <?php //} ?>
         <?php echo form_open("reports/best_sellers"); ?>
       
         <div class="box-icon" id="goicon">
         <button type="button" id="go" class="btn btn-info" name="go">Go !</button>
         </div>
<!--        <input type="hidden" id="ware" value="<?php $warehouse->id = 0; if($warehouse->id){ $warehouse->id; } else{ echo $warehouse->id=0;}?>">-->
        <div class="box-icon" id="micon">
            <?php  $mt1 = date('m')-1;  $yr = date('Y'); //echo $yearget;   ?>
                 <select type="text" id="month" name="month" class="form-control">
                        <?php
                      
                        foreach ($months as $monthskey => $months){
                           $selected='';
                           if($monthget){
                               if($monthget== $monthskey) 
                               $selected='selected';
                           }
                           else {
                                if($monthskey == $mt1)
                                $selected='selected';
                           }
                            echo '<option value="'.$monthskey.'" '.$selected.'>' . $months . '</option>';
                        }
                        ?>
                 </select>
            
        </div>
         <div class="box-icon" id="yicon">
            <select type="text" id="year" name="year" class="form-control">
           <?php $yr = date('Y'); 
           foreach ($years as $yearkey => $years){
                $selected ='';
                if($yearget){
                    if($years == $yearget){
                        $selected ='selected';
                    }
                }else{
                    if($years == $yr)
                    $selected='selected';
                  }
                   
                echo '<option value="'.$years.'" '.$selected.'>' . $years . '</option>';
                }
            ?>
            </select>
          </div>
         <?php if (!empty($warehouses)) { ?>
        <div class="box-icon">
               <select type="text" name="warehouse" id="ware" class="form-control">
                  
                        <?php
                        if($wareget==0){
                                     $selected = 'selected';
                                }
                        echo '<option value="0" '.$selected.'>' . lang('all_warehouses'). '</option>';
                        foreach ($warehouses as $warehouse) {
                           $selected = '';
                           if($wareget){
                               if($warehouse->id == $wareget){
                                     $selected = 'selected';
                                }
                              }
                        echo '<option value="'.$warehouse->id.'" '.$selected.'>' . $warehouse->name . '</option>';
                          }
                        ?>
                <select>
        </div>
        <?php } ?>
         <?php  echo form_close(); ?>
       
</div>      
    <div class="box-content">
    <div class="row" style="margin-bottom: 15px;">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                   <h2 class="blue"><?= $m1; ?> </h2>
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="m1bschart" style="width:100%; height:450px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h2 class="blue"><?= $m2; ?>
                    </h2>
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="m2bschart" style="width:100%; height:450px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h2 class="blue"><?= $m3; ?>
                    </h2>
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="m3bschart" style="width:100%; height:450px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="box">
                <div class="box-header">
                    <h2 class="blue"><?= $m4; ?>
                    </h2>
                </div>
                <div class="box-content">
                    <div class="row">
                        <div class="col-md-12">
                            <div id="m4bschart" style="width:100%; height:450px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
</div>

