<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-barcode"></i><?= lang('Order')  ?> </h2> 
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">
                <div class="table-responsive">
                    <?php
                    echo '<pre>';
                    print_r($upOrders);
                    echo '</pre>';
                    ?>
                    <table class="table table-bordered" >
                        <tbody>
                            <tr><th colspan="2">Order Info</th></tr>
                            <tr><th>Order Id</th><td></td></tr>
                            <tr><th>Order Status</th><td></td></tr>
                            <tr><th>Order time</th><td></td></tr>
                            <tr><th>Delivery time</th><td></td></tr>
                            
                            <tr><th colspan="2">Customer</th></tr>
                            <tr><th>Customer Name</th><td></td></tr>
                            <tr><th>Customer Phone</th><td></td></tr>
                            <tr><th>Customer Address</th><td></td></tr>
                            
                            <tr><th colspan="2">Rider</th></tr>
                            <tr><th>Rider Name</th><td></td></tr>
                            <tr><th>Phone No.</th><td></td></tr>
                            <tr><th>Status</th><td></td></tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>    
</div>    
