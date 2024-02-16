<?php
/**
 * Created by PhpStorm.
 * User: ravi
 * Date: 05/12/2017
 * Time: 15:35
 */

function get_product_price($product,$customer_id=0){

    $product = (object)$product;
    if(!$customer_id){
        return $product;
    }
    $ci = get_instance();
    $ci->load->model(array('site','sales_model'));
    $ci->load->library('Sma');
    $warehouse_id = 1;

    $customer = $ci->site->getCompanyByID($customer_id);
    $warehouse = $ci->site->getWarehouseByID($warehouse_id);
    $customer_group = $ci->site->getCustomerGroupByID($customer->customer_group_id);

    //if ($rows) {
    // $c = str_replace(".", "", microtime(true));
    // $r = 0;
    //foreach ($rows as $row) {
    unset($product->cost, $product->details, $product->product_details,  $product->barcode_symbology, $product->supplier1price, $product->supplier2price, $product->cfsupplier3price, $product->supplier4price, $product->supplier5price, $product->supplier1, $product->supplier2, $product->supplier3, $product->supplier4, $product->supplier5, $product->supplier1_part_no, $product->supplier2_part_no, $product->supplier3_part_no, $product->supplier4_part_no, $product->supplier5_part_no);
    $option = false;
    $product->quantity = 0;
    $product->item_tax_method = $product->tax_method;
    $product->qty = 1;
    $product->discount = '0';
    $product->serial = '';
    $options = $ci->sales_model->getProductOptions($product->id, $warehouse_id);
    if ($options) {
        //$opt = $options[0];
        //$option_id = $opt->id;
        //$product->option = $option_id;
        $opt = $options[0];
        $option_id = $opt->id;
        $option_name = $opt->name;
        $option_price = $opt->price;
        $product->option_id = $option_id;
        $product->option_name = $option_name;
        $product->option_price = $option_price;
    } else {
        $opt = json_decode('{}');
        $opt->price = 0;
    }

    $pis = $ci->site->getPurchasedItems($product->id, $warehouse_id, $product->option_id);
    if ($pis) {
        foreach ($pis as $pi) {
            $product->quantity += $pi->quantity_balance;
        }
    }
    if ($options) {
        $option_quantity = 0;
        foreach ($options as $option) {
            $pis = $ci->site->getPurchasedItems($product->id, $warehouse_id, $product->option_id);
            if ($pis) {
                foreach ($pis as $pi) {
                    $option_quantity += $pi->quantity_balance;
                }
            }
            if ($option->quantity > $option_quantity) {
                $option->quantity = $option_quantity;
            }
        }
    }
$product->org_price=$product->price;
    if ($product->promotion) {
       echo  $product->price = $product->promo_price;
    } elseif ($customer->price_group_id) {
        if ($pr_group_price = $ci->site->getProductGroupPrice($product->id, $customer->price_group_id)) {
            $product->price = $pr_group_price->price;
        }
    } elseif ($warehouse->price_group_id) {
        if ($pr_group_price = $ci->site->getProductGroupPrice($product->id, $warehouse->price_group_id)) {
            $product->price = $pr_group_price->price;
        }
    }

if($product->price==0.0000)
$product->price=$product->org_price;

    $product->price = $product->price - (($product->price * $customer_group->percent) / 100);
    $product->real_unit_price = $product->price;
    $product->base_quantity = 1;
    $product->base_unit = $product->unit;
    $product->base_unit_price = $product->price;
    $product->unit = $product->sale_unit ? $product->sale_unit : $product->unit;
    $combo_items = false;
    if ($product->type == 'combo') {
        $combo_items = $ci->sales_model->getProductComboItems($product->id, $warehouse_id);
    }
    $units = $ci->site->getUnitsByBUID($product->base_unit);
    $tax_rate = $ci->site->getTaxRateByID($product->tax_rate);


    //$pr[] = array('id' => ($c + $r), 'item_id' => $row->id, 'label' => $row->name . " (" . $row->code . ")", 'category' => $row->category_id,
    //'row' => $row, 'combo_items' => $combo_items, 'tax_rate' => $tax_rate, 'units' => $units, 'options' => $options);
    //$r++;
    // }
    //$this->sma->send_json($pr);
    //}
    return $product;
}