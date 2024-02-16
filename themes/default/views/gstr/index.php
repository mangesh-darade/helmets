<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
 
<style>
 .reports-table tbody tr td { border-top:none;border-bottom:none;}
  .reports-table tbody tr.first_row  td { border-top:1px solid #ccc;}
 .reports-table tbody tr.last_row  td { border-bottom:1px solid #ccc;}
</style>

<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-heart"></i><?= lang('sales_report'); ?> <?php
            if ($this->input->post('start_date')) {
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
            <div class="col-lg-12">

                <p class="introtext"><?= lang('customize_report'); ?></p>

                <div id="form" style="display: block !important;">

                    <?php echo form_open("gstr/index"); ?>
                    <div class="row">                       
                        <div class="col-lg-6 form-group choose-date hidden-xs">
		                <div class="controls">
		                     <?= lang("date_range_purchase", "date_range_purchase"); ?>
		                    <div class="input-group">
		                     
		                        <span class="input-group-addon"><i class="fa fa-calendar"></i></span>
		                        <input type="text"
		                               value="<?php echo isset($_POST['start_date']) ? $_POST['start_date'].'-'.$_POST['end_date'] : "";?>"
		                               id="daterange_new" class="form-control">
		                        <span class="input-group-addon"><i class="fa fa-chevron-down"></i></span>
		                         <input type="hidden" name="start_date"  id="start_date" value="<?php echo isset($_POST['start_date']) ? $_POST['start_date'] : "";?>">
		                         <input type="hidden" name="end_date"  id="end_date" value="<?php echo isset($_POST['end_date']) ? $_POST['end_date'] : "";?>" >
                                 
		                    </div>
		                </div>
		         </div>
                    </div>
                    <div class="form-group">
                        <div
                            class="controls"> <?php echo form_submit('submit_report', $this->lang->line("submit"), 'class="btn btn-primary"'); ?> </div>
                    </div>
                    <?php echo form_close(); ?>

                </div>
                <div class="clearfix"></div>

                <div class="table-responsive">
                <?php if($result):?>
                    <table id="SlRData"
                           class="table table-bordered table-hover   table-condensed reports-table">
                        <thead>
			  <tr>
				<th >GSTN</th>
				<th  colspan="6">Invoice</th>
				<th  colspan="2">SGST</th>
				<th  colspan="2">CGST</th>
				<th  colspan="2">IGST</th>
				<th >POS</th>
				<th >Reverse Charges</th>
				<th >Tax on Invoice</th>
				<th >Tax Eccomerce</th>
			  </tr>
			  <tr>
				<th > </th>
				<th  >No</th>
				<th >Date</th>
				<th >Value</th>
				<th  >Product /Services</th>
				<th >HSN / SAC</th>
				<th >Taxable value</th>
				<th >Rate</th>
				<th >Amt</th>
				<th >Rate</th>
				<th >Amt</th>
				<th >Rate</th>
				<th >Amt</th>
				<th ></th>
				<th ></th>
				<th ></th>
				<th ></th>
			  </tr>
   
                        </thead>
                        <tbody>
                         <?php 
                         	$tbody='';
                        foreach($result as $rows){
			        $i = 0;
			          $frow =  $lrow = '';
			    foreach($rows->items as $item){
			           
			        $i++;    
			       
			        if($i==1): //first
			          $frow = 'first_row';
			          
			        elseif(count($rows->items)==$i): //last
			         $frow ='';
			          $lrow = 'last_row';
			        else:
			           $frow = '';
			           $lrow = '';
			        endif;
			        
			        switch ($i) {
			            case 1:
			                    $gstn = '';
			                    $invoiceNo = $rows->reference_no;
			                    $invoiceDate = date("Y-m-d",strtotime($rows->date));
			                    $invoiceValue = $rows->grand_total;
			                    $invoicePos = '';
			                    $invoiceReverseCharges = '0';
			                    $invoiceTax =  $rows->product_tax ;
			                    $invoiceEcommerce = '0'; 
			                break;
			            default:
			                
			                    $gstn = '';
			                    $invoiceNo = '';
			                    $invoiceDate = '';
			                    $invoiceValue = '';
			                    $invoicePos = '';
			                    $invoiceReverseCharges = '';
			                    $invoiceTax = '';
			                    $invoiceEcommerce = ''; 
			                break;
			        }
			        
			        $itemName     = $item['product_name'];
			        $itemHsncode  = $item['hsn_code'];
			        $itemTaxable  = $item['subtotal']- $item['item_tax'] ;
			        $ItemTax= $item['ItemTax'];
			        
			        $SGST_PER = $SGST_AMT =  $CGST_PER = $CGST_AMT =  $IGST_PER = $IGST_AMT = '-';
			        
			        $SGST =  isset($ItemTax['SGST'])?$ItemTax['SGST']:NULL;
			        if(is_array($SGST)){
			        	$SGST_PER = $SGST["attr_per"];
			        	$SGST_AMT = $SGST["tax_amount"];
			        }
			        $CGST =  isset($ItemTax['CGST'])?$ItemTax['CGST']:NULL;
			         if(is_array($SGST)){
			        	$CGST_PER = $CGST["attr_per"];
			        	$CGST_AMT = $CGST["tax_amount"];
			        }
			        $IGST =  isset($ItemTax['IGST'])?$ItemTax['IGST']:NULL;
			        if(is_array($IGST)){
			        	$IGST_PER = $IGST["attr_per"];
			        	$IGST_AMT = $IGST["tax_amount"];
			        }
			        
			        
			        $tr = '<tr class="'.$frow.'  '  .$lrow.'">'
			                 . '<td>'.$gstn.'</td>'
			                 . '<td>'.$invoiceNo.'</td>'
			                 . '<td>'.$invoiceDate.'</td>'
			                 . '<td>'.$this->sma->formatDecimal($invoiceValue).'</td>'
			                 . '<td>'.$itemName.'</td>'
			                 . '<td>'.$itemHsncode.'</td>'
			                 . '<td>'.$itemTaxable.'</td>'
			                 . '<td>'.$SGST_PER.'</td>'
			                 . '<td>'.$this->sma->formatDecimal($SGST_AMT).'</td>'
			                 . '<td>'.$CGST_PER.'</td>'
			                 . '<td>'.$this->sma->formatDecimal($CGST_AMT).'</td>'
			                 . '<td>'.$IGST_PER.'</td>'
			                 . '<td>'.$this->sma->formatDecimal($IGST_AMT).'</td>'
			                 . '<td>'.$invoicePos.'</td>'
			                 . '<td>'.$this->sma->formatDecimal($invoiceReverseCharges).'</td>'
			                 . '<td>'.$this->sma->formatDecimal($item['item_tax']).'</td>'
			                 . '<td>'.$this->sma->formatDecimal($invoiceEcommerce).'</td>'
			            . '</tr>';    
			            
			            $tbody = $tbody.$tr;     
			    }	
			}
                         echo $tbody;
                         ?>
                        </tbody>
                        
                    </table>
                  <?php endif;?>  
                </div>
            </div>
        </div>
    </div>
</div>
 