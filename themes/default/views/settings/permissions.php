<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>

<style>
    .table td:first-child {
        font-weight: bold;
    }

    label {
        margin-right: 10px;
    }
</style>
<div class="box">
    <div class="box-header">
        <h2 class="blue"><i class="fa-fw fa fa-folder-open"></i><?= lang('group_permissions'); ?></h2>
    </div>
    <div class="box-content">
        <div class="row">
            <div class="col-lg-12">

                <p class="introtext"><?= lang("set_permissions"); ?></p>

                <?php if( ! empty($p))
                {
                    if($p->group_id != 1)
                    {

                        echo form_open("system_settings/permissions/" . $id); ?>
                        <div class="table-responsive">
                            <table class="table table-bordered table-hover table-striped">

                                <thead>
                                <tr>
                                    <th colspan="6"
                                        class="text-center"><?php echo $group->description . ' ( ' . $group->name . ' ) ' . $this->lang->line("group_permissions"); ?></th>
                                </tr>
                                <tr>
                                    <th rowspan="2" class="text-center"><?= lang("module_name"); ?>
                                    </th>
                                    <th colspan="5" class="text-center"><?= lang("permissions"); ?></th>
                                </tr>
                                <tr>
                                    <th class="text-center"><?= lang("view"); ?></th>
                                    <th class="text-center"><?= lang("add"); ?></th>
                                    <th class="text-center"><?= lang("edit"); ?></th>
                                    <th class="text-center"><?= lang("delete"); ?></th>
                                    <th class="text-center"><?= lang("misc"); ?></th>
                                </tr>
                                </thead>
                                <tbody>
                                <tr>
                                    <td><?= lang("products"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="products-index" <?php echo $p->{'products-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="products-add" <?php echo $p->{'products-add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="products-edit" <?php echo $p->{'products-edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="products-delete" <?php echo $p->{'products-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <input type="checkbox" value="1" id="products_import" class="checkbox"
                                                        name="products_import" <?php echo $p->{'products-import'} ? "checked" : ''; ?>>
                                                 <label for="products_import"
                                                        class="padding05"><?= lang('products_import') ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="checkbox" value="1" id="products-cost" class="checkbox"
                                                        name="products-cost" <?php echo $p->{'products-cost'} ? "checked" : ''; ?>>
                                                 <label for="products-cost" class="padding05"><?= lang('product_cost') ?></label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="checkbox" value="1" id="products-price" class="checkbox"
                                                        name="products-price" <?php echo $p->{'products-price'} ? "checked" : ''; ?>>
                                                 <label for="products-price" class="padding05"><?= lang('product_price') ?>
                                                 </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <input type="checkbox" value="1" id="products-barcode" class="checkbox"
                                                        name="products-barcode" <?php echo $p->{'products-barcode'} ? "checked" : ''; ?>>
                                                 <label for="products-barcode"
                                                        class="padding05"><?= lang('print_barcodes') ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="checkbox" value="1" id="products-stock_count" class="checkbox"
                                                        name="products-stock_count" <?php echo $p->{'products-stock_count'} ? "checked" : ''; ?>>
                                                 <label for="products-stock_count"
                                                        class="padding05"><?= lang('stock_counts') ?></label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="checkbox" value="1" id="products-adjustments" class="checkbox"
                                                        name="products-adjustments" <?php echo $p->{'products-adjustments'} ? "checked" : ''; ?>>
                                                 <label for="products-adjustments"
                                                        class="padding05"><?= lang('adjustments') ?></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("sales"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="sales-index" <?php echo $p->{'sales-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="sales-add" <?php echo $p->{'sales-add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="sales-edit" <?php echo $p->{'sales-edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="sales-delete" <?php echo $p->{'sales-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <input type="checkbox" value="1" id="sales_date" class="checkbox"
                                                        name="sales_date" <?php echo $p->{'sales-date'} ? "checked" : ''; ?>>
                                                <label for="sales_date" class="padding05"><?= lang('sales_date') ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="checkbox" value="1" id="sales-payments" class="checkbox"
                                                        name="sales-payments" <?php echo $p->{'sales-payments'} ? "checked" : ''; ?>>
                                                 <label for="sales-payments" class="padding05"><?= lang('payments') ?></label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="checkbox" value="1" id="sales-return_sales" class="checkbox"
                                                        name="sales-return_sales" <?php echo $p->{'sales-return_sales'} ? "checked" : ''; ?>>
                                                 <label for="sales-return_sales"
                                                        class="padding05"><?= lang('return_sales') ?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <label><input type="checkbox" value="1" id="sales_delete_suspended" class="checkbox"
                                               name="sales_delete_suspended" <?php echo $p->{'sales-delete-suspended'} ? "checked" : ''; ?>>&nbsp; <?= lang('Delete_Suspended_Sales') ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="checkbox" value="1" id="sales-email" class="checkbox"
                                                        name="sales-email" <?php echo $p->{'sales-email'} ? "checked" : ''; ?>>
                                                 <label for="sales-email" class="padding05"><?= lang('email') ?></label>
                                            </div>
                                            <div class="col-sm-2">
                                                <input type="checkbox" value="1" id="sales-pdf" class="checkbox"
                                                        name="sales-pdf" <?php echo $p->{'sales-pdf'} ? "checked" : ''; ?>>
                                                 <label for="sales-pdf" class="padding05"><?= lang('pdf') ?></label>
                                            </div>
                                            <div class="col-sm-2">
                                                 <?php if(POS){ ?>
                                                     <input type="checkbox" value="1" id="pos-index" class="checkbox"
                                                            name="pos-index" <?php echo $p->{'pos-index'} ? "checked" : ''; ?>>
                                                     <label for="pos-index" class="padding05"><?= lang('pos') ?></label>
                                                 <?php } ?>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <label><input type="checkbox" value="1" id="sales_add_csv" class="checkbox"
                                               name="sales_add_csv" <?php echo $p->{'sales_add_csv'} ? "checked" : ''; ?>>&nbsp; <?= lang('Add CSV') ?></label>
                                            </div>
                                            <div class="col-sm-5">
                                                <label><input type="checkbox" value="1" id="all_sale_lists" class="checkbox"
                                               name="all_sale_lists" <?php echo $p->{'all_sale_lists'} ? "checked" : ''; ?>>&nbsp; <?= lang('All Sale Lists') ?></label>
                                        </div> 
<div class="col-sm-5">
                                                <label><input type="checkbox" value="1" id="eshop_sales-sales" class="checkbox"
                                               name="eshop_sales-sales" <?php echo $p->{'eshop_sales-sales'} ? "checked" : ''; ?>>&nbsp; <?= lang('Eshop Sale Lists') ?></label>
                                        </div>
										<div class="col-sm-5">
                                                <label><input type="checkbox" value="1" id="offline-sales" class="checkbox"
                                               name="offline-sales" <?php echo $p->{'offline-sales'} ? "checked" : ''; ?>>&nbsp; <?= lang('Offline Sale Lists') ?></label>
                                        </div>	   
                                        </div>    
                                    </td>
                                </tr>

                                   <?php if ($Settings->pos_type == 'restaurant') { ?>
                                <tr>
                                    <td>   Urbanpiper </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="urbanpiper_view" <?php echo $p->{'urbanpiper_view'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="urbanpiper_add" <?php echo $p->{'urbanpiper_add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="urbanpiper_edit" <?php echo $p->{'urbanpiper_edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="urbanpiper_delete" <?php echo $p->{'urbanpiper_delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <label><input type="checkbox" value="1" id="urbanpiper_sales" class="checkbox"
                                               name="urbanpiper_sales" <?php echo $p->{'urbanpiper_sales'} ? "checked" : ''; ?>>&nbsp; <?= lang('Urbanpiper Sales') ?></label>
                                            </div>
                                            
                                            <div class="col-sm-5">
                                                <label><input type="checkbox" value="1" id="urbanpiper_manage_order" class="checkbox"
                                               name="urbanpiper_maange_order" <?php echo $p->{'urbanpiper_maange_order'} ? "checked" : ''; ?>>&nbsp; <?= lang('Urbanpiper Manage Order') ?></label>
                                            </div>
                                        </div>
                                        
                                       <div class="row">
                                            <div class="col-sm-5">
                                                <label><input type="checkbox" value="1" id="urbanpiper_settings" class="checkbox"
                                               name="urbanpiper_settings" <?php echo $p->{'urbanpiper_settings'} ? "checked" : ''; ?>>&nbsp; <?= lang('Urbanpiper Settings') ?></label>
                                            </div>
                                            
                                            <div class="col-sm-5">
                                                <label><input type="checkbox" value="1" id="urbanpiper_maange_stores" class="checkbox"
                                               name="urbanpiper_maange_stores" <?php echo $p->{'urbanpiper_maange_stores'} ? "checked" : ''; ?>>&nbsp; <?= lang('Manage Stores') ?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                          
                                            
                                            <div class="col-sm-5">
                                                <label><input type="checkbox" value="1" id="urbanpiper_maange_catalogue" class="checkbox"
                                               name="urbanpiper_maange_catalogue" <?php echo $p->{'urbanpiper_maange_catalogue'} ? "checked" : ''; ?>>&nbsp; <?= lang('Manage Catalogue') ?></label>
                                            </div>
                                        </div> 
                                        
                                    </td>
                                    
                                </tr>


                                <?php } ?>
                                <tr>
                                    <td><?= lang("deliveries"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="sales-deliveries" <?php echo $p->{'sales-deliveries'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="sales-add_delivery" <?php echo $p->{'sales-add_delivery'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="sales-edit_delivery" <?php echo $p->{'sales-edit_delivery'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="sales-delete_delivery" <?php echo $p->{'sales-delete_delivery'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <input type="checkbox" value="1" id="sales-pdf" class="checkbox"
                                                       accept=""name="sales-pdf_delivery" <?php echo $p->{'sales-pdf_delivery'} ? "checked" : ''; ?>>
                                                <label for="sales-pdf_delivery" class="padding05"><?= lang('pdf') ?></label>
                                            </div>
                                            <div class="col-sm-6">
                                        <!--<input type="checkbox" value="1" id="sales-email" class="checkbox" name="sales-email_delivery" <?php echo $p->{'sales-email_delivery'} ? "checked" : ''; ?>><label for="sales-email_delivery" class="padding05"><?= lang('email') ?></label>-->
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?= lang("gift_cards"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="sales-gift_cards" <?php echo $p->{'sales-gift_cards'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="sales-add_gift_card" <?php echo $p->{'sales-add_gift_card'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="sales-edit_gift_card" <?php echo $p->{'sales-edit_gift_card'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="sales-delete_gift_card" <?php echo $p->{'sales-delete_gift_card'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>

                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("quotes"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="quotes-index" <?php echo $p->{'quotes-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="quotes-add" <?php echo $p->{'quotes-add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="quotes-edit" <?php echo $p->{'quotes-edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="quotes-delete" <?php echo $p->{'quotes-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <input type="checkbox" value="1" id=quotes_date" class="checkbox"
                                                        name="quotes_date" <?php echo $p->{'quotes-date'} ? "checked" : ''; ?>>
                                                 <label for="quotes_date" class="padding05"><?= lang('quotes-date') ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="checkbox" value="1" id="quotes-email" class="checkbox"
                                                        name="quotes-email" <?php echo $p->{'quotes-email'} ? "checked" : ''; ?>>
                                                <label for="quotes-email" class="padding05"><?= lang('email') ?></label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="checkbox" value="1" id="quotes-pdf" class="checkbox"
                                                        name="quotes-pdf" <?php echo $p->{'quotes-pdf'} ? "checked" : ''; ?>>
                                                <label for="quotes-pdf" class="padding05"><?= lang('pdf') ?></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("purchases"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="purchases-index" <?php echo $p->{'purchases-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="purchases-add" <?php echo $p->{'purchases-add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="purchases-edit" <?php echo $p->{'purchases-edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="purchases-delete" <?php echo $p->{'purchases-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <label ><input type="checkbox" value="1" id="purchases_date" class="checkbox"
                                                       name="purchases_date" <?php echo $p->{'purchases-date'} ? "checked" : ''; ?>>&nbsp; <?= lang('purchases_date') ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="checkbox" value="1" id="purchases-payments" class="checkbox"
                                                        name="purchases-payments" <?php echo $p->{'purchases-payments'} ? "checked" : ''; ?>>
                                                <label for="purchases-payments"
                                                        class="padding05"><?= lang('payments') ?></label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="checkbox" value="1" id="purchases-expenses" class="checkbox"
                                                        name="purchases-expenses" <?php echo $p->{'purchases-expenses'} ? "checked" : ''; ?>>
                                                <label for="purchases-expenses"
                                                        class="padding05"><?= lang('expenses') ?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <label ><input type="checkbox" value="1" id="purchases-return_purchases"
                                               class="checkbox"
                                               name="purchases-return_purchases" <?php echo $p->{'purchases-return_purchases'} ? "checked" : ''; ?>>&nbsp; <?= lang('return_purchases') ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="checkbox" value="1" id="purchases-email" class="checkbox"
                                                        name="purchases-email" <?php echo $p->{'purchases-email'} ? "checked" : ''; ?>>
                                                 <label for="purchases-email" class="padding05"><?= lang('email') ?></label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="checkbox" value="1" id="purchases-pdf" class="checkbox"
                                                        name="purchases-pdf" <?php echo $p->{'purchases-pdf'} ? "checked" : ''; ?>>
                                                 <label for="purchases-pdf" class="padding05"><?= lang('pdf') ?></label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <input type="checkbox" value="1" id="purchase_add_csv" class="checkbox"
                                                        name="purchase_add_csv" <?php echo $p->{'purchase_add_csv'} ? "checked" : ''; ?>>
                                                 <label for="purchase_add_csv" class="padding05"><?= lang('Add CSV') ?></label>
                                            </div>
                                        </div>    
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("transfers"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="transfers-index" <?php echo $p->{'transfers-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="transfers-add" <?php echo $p->{'transfers-add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="transfers-edit" <?php echo $p->{'transfers-edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="transfers-delete" <?php echo $p->{'transfers-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-4" style="padding-right:0px">
                                                <input type="checkbox" value="1" id=transfers-date" class="checkbox"
                                                        name="transfers_date" <?php echo $p->{'transfers-date'} ? "checked" : ''; ?>>
                                                <label for="transfers_date"
                                                        class="padding05"><?= lang('transfers_date') ?></label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="checkbox" value="1" id="transfers-email" class="checkbox"
                                                        name="transfers-email" <?php echo $p->{'transfers-email'} ? "checked" : ''; ?>>
                                                 <label for="transfers-email" class="padding05"><?= lang('email') ?></label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="checkbox" value="1" id="transfers-pdf" class="checkbox"
                                                        name="transfers-pdf" <?php echo $p->{'transfers-pdf'} ? "checked" : ''; ?>>
                                                <label for="transfers-pdf" class="padding05"><?= lang('pdf') ?></label>
                                            </div>
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-4" style="padding-right:0px">
                                                <input type="checkbox" value="1" id="transfers_add_csv" class="checkbox"
                                                        name="transfers_add_csv" <?php echo $p->{'transfers_add_csv'} ? "checked" : ''; ?>>
                                                 <label for="transfers_add_csv" class="padding05"><?= lang('Add CSV') ?></label>
                                            </div>
                                            
                                           <div class="col-sm-4" >
                                                <input type="checkbox" value="1" id="transfers_add_request" class="checkbox"
                                                        name="transfers_add_request" <?php echo $p->{'transfers_add_request'} ? "checked" : ''; ?>>
                                                 <label for="transfers_add_request" class="padding05"><?= lang('Add Request') ?></label>
                                            </div>

                                            <div class="col-sm-4" >
                                                <input type="checkbox" value="1" id="transfer_status_completed" class="checkbox"
                                                        name="transfer_status_completed" <?php echo $p->{'transfer_status_completed'} ? "checked" : ''; ?>>
                                                 <label for="transfer_status_completed" class="padding05"><?= lang('Status Completed') ?></label>
                                            </div>
                                            
                                        </div> 
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input type="checkbox" value="1" id="transfer_status_request" class="checkbox"
                                                        name="transfer_status_request" <?php echo $p->{'transfer_status_request'} ? "checked" : ''; ?>>
                                                 <label for="transfer_status_request" class="padding05"><?= lang('Status Request') ?></label>
                                            </div>
                                            <div class="col-sm-4">
                                                <input type="checkbox" value="1" id="transfer_status_sent" class="checkbox"
                                                        name="transfer_status_sent" <?php echo $p->{'transfer_status_sent'} ? "checked" : ''; ?>>
                                                 <label for="transfer_status_sent" class="padding05"><?= lang('Status Sent') ?></label>
                                            </div>
                                        </div>
                                        
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("customers"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="customers-index" <?php echo $p->{'customers-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="customers-add" <?php echo $p->{'customers-add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="customers-edit" <?php echo $p->{'customers-edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="customers-delete" <?php echo $p->{'customers-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                        <div class="row">
                                            <div class="col-sm-5">
                                                <input type="checkbox" value="1" id="customers-deposits" class="checkbox"
                                                        name="customers-deposits" <?php echo $p->{'customers-deposits'} ? "checked" : ''; ?>>
                                                <label for="customers-deposits"
                                                        class="padding05"><?= lang('Deposits (view, add & edit)') ?></label>
                                            </div>
                                            <div class="col-sm-5">
                                                <input type="checkbox" value="1" id="customers-delete_deposit" class="checkbox"
                                                        name="customers-delete_deposit" <?php echo $p->{'customers-delete_deposit'} ? "checked" : ''; ?>>
                                                 <label for="customers-delete_deposit"
                                                        class="padding05"><?= lang('delete_deposit') ?></label>
                                            </div>
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("suppliers"); ?></td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="suppliers-index" <?php echo $p->{'suppliers-index'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="suppliers-add" <?php echo $p->{'suppliers-add'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="suppliers-edit" <?php echo $p->{'suppliers-edit'} ? "checked" : ''; ?>>
                                    </td>
                                    <td class="text-center">
                                        <input type="checkbox" value="1" class="checkbox"
                                               name="suppliers-delete" <?php echo $p->{'suppliers-delete'} ? "checked" : ''; ?>>
                                    </td>
                                    <td>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("reports"); ?></td>
                                    <td colspan="5">
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <input type="checkbox" value="1" class="checkbox"
                                                       id="product_quantity_alerts"
                                                       name="reports-quantity_alerts" <?php echo $p->{'reports-quantity_alerts'} ? "checked" : ''; ?>>
                                                <label for="product_quantity_alerts"
                                                       class="padding05"><?= lang('Product_Qty_Alerts') ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="checkbox" value="1" class="checkbox" id="Product_expiry_alerts"
                                                       name="reports-expiry_alerts" <?php echo $p->{'reports-expiry_alerts'} ? "checked" : ''; ?>>
                                                <label for="Product_expiry_alerts"
                                                       class="padding05"><?= lang('product_expiry_alerts') ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="checkbox" value="1" class="checkbox" id="products"
                                                       name="reports-products" <?php echo $p->{'reports-products'} ? "checked" : ''; ?>><label
                                                        for="products" class="padding05"><?= lang('products') ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                            <input type="checkbox" value="1" class="checkbox" id="daily_sales"
                                                   name="reports-daily_sales" <?php echo $p->{'reports-daily_sales'} ? "checked" : ''; ?>>
                                            <label for="daily_sales"
                                                   class="padding05"><?= lang('daily_sales') ?></label>
                                        </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <input type="checkbox" value="1" class="checkbox" id="monthly_sales"
                                                       name="reports-monthly_sales" <?php echo $p->{'reports-monthly_sales'} ? "checked" : ''; ?>>
                                                <label for="monthly_sales"
                                                       class="padding05"><?= lang('monthly_sales') ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="checkbox" value="1" class="checkbox" id="sales"
                                                       name="reports-sales" <?php echo $p->{'reports-sales'} ? "checked" : ''; ?>>
                                                <label for="sales" class="padding05"><?= lang('sales') ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label><input type="checkbox" value="1" class="checkbox" id="payments"
                                                              name="reports-payments" <?php echo $p->{'reports-payments'} ? "checked" : ''; ?>>&nbsp; <?= lang('payments') ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                            <input type="checkbox" value="1" class="checkbox" id="expenses"
                                                   name="reports-expenses" <?php echo $p->{'reports-expenses'} ? "checked" : ''; ?>>
                                            <label for="expenses" class="padding05"><?= lang('expenses') ?></label>
                                        </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <input type="checkbox" value="1" class="checkbox" id="daily_purchases"
                                                       name="reports-daily_purchases" <?php echo $p->{'reports-daily_purchases'} ? "checked" : ''; ?>>
                                                <label for="daily_purchases"
                                                       class="padding05"><?= lang('daily_purchases') ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="checkbox" value="1" class="checkbox" id="monthly_purchases"
                                                       name="reports-monthly_purchases" <?php echo $p->{'reports-monthly_purchases'} ? "checked" : ''; ?>>
                                                <label for="monthly_purchases"
                                                       class="padding05"><?= lang('monthly_purchases') ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="checkbox" value="1" class="checkbox" id="purchases"
                                                       name="reports-purchases" <?php echo $p->{'reports-purchases'} ? "checked" : ''; ?>>
                                                <label for="purchases" class="padding05"><?= lang('purchases') ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                            <input type="checkbox" value="1" class="checkbox" id="customers"
                                                   name="reports-customers" <?php echo $p->{'reports-customers'} ? "checked" : ''; ?>>
                                            <label for="customers" class="padding05"><?= lang('customers') ?></label>
                                            </div>
                                            
                                            
                                            
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <input type="checkbox" value="1" class="checkbox" id="suppliers"
                                                       name="reports-suppliers" <?php echo $p->{'reports-suppliers'} ? "checked" : ''; ?>>
                                                <label for="suppliers" class="padding05"><?= lang('suppliers') ?></label>
                                            </div>
                                            <div class="col-sm-3" style="padding-right: 0px;">
                                                <input type="checkbox" value="1" class="checkbox" id="warehousesalereport"
                                                       name="reports-warehouse_sales_report" <?php echo $p->{'reports-warehouse_sales_report'} ? "checked" : ''; ?>>
                                                <label for="warehousesalereport" class="padding05"><?= lang('Warehouse Sales Report') ?></label>
                                            </div>
                                            
                                            <div class="col-sm-3">
                                                  <input type="checkbox" value="1" class="checkbox" id="purchasegstreport"
                                                       name="report_purchase_gst" <?php echo $p->{'report_purchase_gst'} ? "checked" : ''; ?>>
                                                <label for="purchasegstreport" class="padding05"><?= lang('Purchases GST Report') ?></label>
                                            </div>    
                                            
                                            
                                             
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td><?= lang("misc"); ?></td>
                                    <td colspan="5">
                                       <div class="row">
                                            <div class="col-sm-3">
                                                <input type="checkbox" value="1" class="checkbox" id="bulk_actions"
                                                       name="bulk_actions" <?php echo $p->bulk_actions ? "checked" : ''; ?>>
                                                <label for="bulk_actions"
                                                       class="padding05"><?= lang('bulk_actions') ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="checkbox" value="1" class="checkbox" id="edit_price"
                                                       name="edit_price" <?php echo $p->edit_price ? "checked" : ''; ?>>
                                                <label for="edit_price"
                                                       class="padding05"><?= lang('edit_price_on_sale') ?></label>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="checkbox" value="1" class="checkbox" id="printer_setting"
                                                       name="printer_setting" <?php echo $p->{'printer-setting'} ? "checked" : ''; ?>>
                                                <label for="printer_setting"
                                                       class="padding05"><?= lang('Printer Settings') ?>  </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <input type="checkbox" value="1" class="checkbox" id="cart_price_edit"
                                                       name="cart-price_edit" <?php echo $p->{'cart-price_edit'} ? "checked" : ''; ?>>
                                                <label for="cart_price_edit"
                                                       class="padding05"><?= lang('cart_price_edit') ?>  </label>
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-sm-3">
                                                <input type="checkbox" value="1" class="checkbox" id="cart_unit_view"
                                                       name="cart-unit_view" <?php echo $p->{'cart-unit_view'} ? "checked" : ''; ?>>
                                                <label for="cart_unit_view"
                                                       class="padding05"><?= lang('cart_unit_view') ?>  </label>
                                            </div>
                                            <div class="col-sm-3">
                                                <label><input type="checkbox" value="1" class="checkbox" id="cart_show_bill_btn"
                                                              name="cart-show_bill_btn" <?php echo $p->{'cart-show_bill_btn'} ? "checked" : ''; ?> >&nbsp; <?= lang('cart_show_bill_btn') ?>  </label>
                                            </div>
                                       </div>
                                    </td>
                                </tr>
                                <tr>
                                    <td><?= lang("pos"); ?></td>
                                    <td colspan="5">
                                       <div class="row">
                                            <div class="col-sm-4">
                                                <input type="checkbox" value="1" class="checkbox" id="pos_show_order_btn"
                                                       name="pos_show_order_btn" <?php echo $p->{'pos-show-order-btn'} ? "checked" : ''; ?>>
                                                <label for="pos_show_order_btn" class="padding05"><?= lang('Show Order Button') ?></label>
                                            </div>
                                       </div>
                                    </td>
                                </tr>
                                
                                <tr>
                                    <td><?= lang("CRM Portal") ?></td>
                                    <td colspan="5"> 
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input type="checkbox" value="1" class="checkbox" id="crm_portal"
                                                       name="crm_portal" <?php echo $p->{'crm_portal'} ? "checked" : ''; ?>>
                                                <label for="crm_portal" class="padding05"><?= lang('CRM Portal') ?></label>
                                            </div>
                                       </div>
                                    </td>    
                                </tr>
                                <tr>
                                    <td><?= lang("Data Synchronization") ?></td>
                                    <td colspan="5"> 
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <input type="checkbox" value="1" class="checkbox" id="data_synchronization"
                                                       name="data_synchronization" <?php echo $p->{'offlinepos-synchronization'} ? "checked" : ''; ?>>
                                                <label for="data_synchronization" class="padding05"><?= lang('Data Synchronization') ?></label>
                                            </div>
                                       </div>
                                    </td>    
                                </tr>
                                

                                </tbody>
                            </table>
                        </div>

                        <div class="form-actions">
                            <button type="submit" class="btn btn-primary"><?= lang('update') ?></button>
                        </div>
                        <?php echo form_close();
                    }else
                    {
                        echo $this->lang->line("group_x_allowed");
                    }
                }else
                {
                    echo $this->lang->line("group_x_allowed");
                } ?>


            </div>
        </div>
    </div>
</div>