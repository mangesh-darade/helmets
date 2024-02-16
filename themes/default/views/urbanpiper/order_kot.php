<?php // echo "<pre>"; print_r($item);

   // print_r($order);
    $order_details = $order[$salesid];
    
    $up_response =  unserialize($order_details->up_response);
    $orderid = $up_response->order->details->ext_platforms;
    
?>

<button class="btn btn-primary pull-right" onclick="printDiv('printableArea')">Print</button>
<div class="container  " id="printableArea">
    
    <h3 class="text-center"> <strong><?= $Settings->site_name ?></strong></h3>
    <h4 class="text-center"><?= $order_details->customer ?></h4>
     <h4 class="text-center"> ORDER ID : <?= $orderid[0]->id ?> &nbsp; Channel : <?= $order_details->up_channel  ?></h4> 
     
     <h5 class="text-center"> OTP  : <?= substr($up_response->customer->phone, -4) ?>  &nbsp; <?= date('d/m/Y H:i',strtotime($order_details->up_state_timestamp))?> </h5>
    
    
    <table class="table">
        <?php foreach($up_response->order->items as $item){ 
            if(!empty($item->options_to_add)){
                    foreach ($item->options_to_add as $options){
                       
                       $optionAddName[] = $options->title ;
                     
                    }//end for                    
                }//end if
            ?>
        <tr>
            <td><?= $item->title ?> <?= (!empty($item->options_to_add) ? '('. join(',', $optionAddName) .')' : '') ?></td>
            <td><?= $item->quantity ?></td>
        </tr>
        <?php } ?>
    </table>
    
</div>

    


   