<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
 
<style>@media print {
        .fa {
            color: #EEE;
            display: none;
        }

        .small-box {
            border: 1px solid #CCC;
        }
    }</style>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-bars"></i>Sales Tax Summery</h2>

        <div class="box-icon">
            
        </div>
         
    </div>
    <div class="box-content profit_loss">
        <div class="row">
            <div class="col-lg-9">
                
                <div class="row"> 
                    <div class="col-sm-6">
                     
                        <div class="small-box padding1010 bblue">
                           
                            <i class="fa fa-line-chart"></i>

                            <h3 class="bold">Order Tax</h3>

                             
                              <h3 class="bold">
                              <?= $this->sma->formatMoney(($sales->order_tax)); ?></h3>
                             
                            
   				 
                        </div>
                    </div>
                	 <div class="col-sm-6">
                     
                        <div class="small-box padding1010 bmGreen">
                           
                            <i class="fa fa fa-line-chart"></i>

                            <h3 class="bold">Product Tax</h3>

                            
                              <h3 class="bold">
			     <?= $this->sma->formatMoney(($sales->product_tax)); ?></h3>
                             
                             
                            
   				 
                        </div>
                    </div>
                     <div class="col-sm-4">
                     
                        <div class="small-box padding1010 bdarkGrey ">
                           
                            <i class="fa fa-money"></i>

                            <h3 class="bold">CGST</h3>

                            <p>
                             <?= $this->sma->formatMoney(($sales->CGST)); ?> 
                              </p>  
   				 
                        </div>
                    </div>
                     <div class="col-sm-4">
                     
                        <div class="small-box padding1010 bpurple">
                           
                            <i class="fa fa-money"></i>

                            <h3 class="bold">SGST</h3>
 
                           <p>
                               <?= $this->sma->formatMoney(($sales->SGST)); ?>
                            </p>  
   				 
                        </div>
                    </div>
                     <div class="col-sm-4">
                     
                        <div class="small-box padding1010 bblue">
                           
                            <i class="fa fa-money"></i>

                            <h3 class="bold">IGST</h3>

                            <p>
                               <?= $this->sma->formatMoney(($sales->IGST)); ?>
                            </p>  
   				 
                        </div>
                    </div>
		</div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript" src="<?= $assets ?>js/html2canvas.min.js"></script>
<script type="text/javascript">
    $(document).ready(function () {
       
        $('#image').click(function (event) {
            event.preventDefault();
            html2canvas($('.box'), {
                onrendered: function (canvas) {
                    var img = canvas.toDataURL()
                    window.open(img);
                }
            });
            return false;
        });
    });
</script>