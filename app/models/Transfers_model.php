<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Transfers_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getProductNames($term, $warehouse_id, $limit = 10)
    {
        $this->db->select('products.id, code, name, warehouses_products.quantity, cost, tax_rate, type, unit, purchase_unit, tax_method')
            ->join('warehouses_products', 'warehouses_products.product_id=products.id', 'left')
            ->group_by('products.id');
        if ($this->Settings->overselling) {
            $this->db->where("type = 'standard' AND (name LIKE '%" . $term . "%' OR code LIKE '%" . $term . "%' OR article_code LIKE '%" . $term . "%' OR  concat(name, ' (', code, ')') LIKE '%" . $term . "%')");
        } else {
            $this->db->where("type = 'standard' AND warehouses_products.warehouse_id = '" . $warehouse_id . "' AND " 
                . "(name LIKE '%" . $term . "%' OR code LIKE '%" . $term . "%' OR  concat(name, ' (', code, ')') LIKE '%" . $term . "%')");
                //AND warehouses_products.quantity > 0 
        }
        $this->db->limit($limit);
        $q = $this->db->get('products');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getWHProduct($id)
    {
        $this->db->select('products.id, code, name, warehouses_products.quantity, cost, tax_rate')
            ->join('warehouses_products', 'warehouses_products.product_id=products.id', 'left')
            ->group_by('products.id');
        $q = $this->db->get_where('products', array('warehouses_products.product_id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
    }

    public function addTransfer($data = array(), $items = array())
    {
        $status = $data['status'];
        if ($this->db->insert('transfers', $data)) {
            $transfer_id = $this->db->insert_id();
            if ($this->site->getReference('to') == $data['transfer_no']) {
                $this->site->updateReference('to');
            }
            foreach ($items as $item) {
                $item['transfer_id'] = $transfer_id;
                if ($status == 'completed') {
                    $item['date'] = date('Y-m-d');
                    $item['warehouse_id'] = $data['to_warehouse_id'];
                    $item['status'] = 'received';
                    $this->db->insert('purchase_items', $item);
                } else {
                    $this->db->insert('transfer_items', $item);
                }

                if ($status == 'sent' || $status == 'completed') {
                    $this->syncTransderdItem($item['product_id'], $data['from_warehouse_id'], $item['quantity'], $item['option_id']);
                }
            }

            return true;
        }
        return false;
    }
	public function getPurchaseItemByID($id, $ProductId,$option_id)
    {

        $q = $this->db->get_where('purchase_items', array('transfer_id' => $id, 'product_id'=>$ProductId, 'option_id' => $option_id ), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
    }
    public function updateTransfer($id, $data = array(), $items = array())
    {
		$status_main = $data['status'];
        $ostatus = $this->resetTransferActions($id, $status_main);
        $status = $status1 = $data['status'];
		//print_r($items); exit;
        if ($this->db->update('transfers', $data, array('id' => $id))) {
            $tbl = $ostatus == 'completed' ? 'purchase_items' : 'transfer_items';
            $this->db->delete($tbl, array('transfer_id' => $id));
			if($status1=='partial')
				 $status = $data['status'] = $Upddata['status']='sent';
            foreach ($items as $item) {
                $item['transfer_id'] = $id;
				if($item['unit_quantity']!=0){
					$item['unit_quantity']=$item['sent_quantity'];
				}
					if($status1=='partial'){
						if($item['request_quantity']!=$item['sent_quantity']){
							$status = $Upddata['status']=$data['status'] = $status1;
						}
					}
					
					if ($status == 'completed') {
						$item['date'] = date('Y-m-d');
						$item['warehouse_id'] = $data['to_warehouse_id'];
						$item['status'] = 'received';
						unset($item['request_quantity'],$item['sent_quantity']);
						$Res = $this->getPurchaseItemByID($id, $item['product_id'],$item['option_id']);
						if(empty($Res)){
							$this->db->insert('purchase_items', $item);
						}else{
							$this->db->update('purchase_items', $item, array('transfer_id' => $id, 'product_id'=>$item['product_id'], 'option_id' =>$item['option_id']));
						}
					   
					}else if($status ==  'partial'){
						
						$this->db->insert('transfer_items', $item); 
						
						$item['date'] = date('Y-m-d');
						$item['warehouse_id'] = $data['to_warehouse_id'];
						$item['status'] = 'received';
						
						unset($item['request_quantity'],$item['sent_quantity']);
						$this->db->insert('purchase_items', $item);
					} 
					else {
						$this->db->insert('transfer_items', $item);
					}

					if ($data['status'] == 'sent' || $data['status'] == 'completed'|| $data['status'] == 'partial' || $data['status'] == 'sent_balance') {
						$this->syncTransderdItem($item['product_id'], $data['from_warehouse_id'], $item['quantity'], $item['option_id'], $status_main);
					}
				
            }
			if($status1=='partial')
			$this->db->update('transfers', $Upddata, array('id' => $id));
            return true;
        }

        return false;
    }

    public function updateStatus($id, $status, $note)
    {
        $ostatus = $this->resetTransferActions($id);
        $transfer = $this->getTransferByID($id);
        $items = $this->getAllTransferItems($id, $transfer->status);

        if ($this->db->update('transfers', array('status' => $status, 'note' => $note), array('id' => $id))) {
            $tbl = $ostatus == 'completed' ? 'purchase_items' : 'transfer_items';
            $this->db->delete($tbl, array('transfer_id' => $id));

            foreach ($items as $item) {
                $item = (array) $item;
                $item['transfer_id'] = $id;
                unset($item['id'], $item['variant'], $item['unit']);
                if ($status == 'completed') {
                    $item['date'] = date('Y-m-d');
                    $item['warehouse_id'] = $transfer->to_warehouse_id;
                    $item['status'] = 'received';
                    $this->db->insert('purchase_items', $item);
                } else {
                    $this->db->insert('transfer_items', $item);
                }

                if ($status == 'sent' || $status == 'completed') {
                    $this->syncTransderdItem($item['product_id'], $transfer->from_warehouse_id, $item['quantity'], $item['option_id']);
                } else {
                    $this->site->syncQuantity(NULL, NULL, NULL, $item['product_id']);
                }
            }
            return true;
        }
        return false;
    }

    public function getProductWarehouseOptionQty($option_id, $warehouse_id)
    {
        $q = $this->db->get_where('warehouses_products_variants', array('option_id' => $option_id, 'warehouse_id' => $warehouse_id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getProductByCategoryID($id)
    {

        $q = $this->db->get_where('products', array('category_id' => $id), 1);
        if ($q->num_rows() > 0) {
            return true;
        }

        return FALSE;
    }

    public function getProductQuantity($product_id, $warehouse = DEFAULT_WAREHOUSE)
    {
        $q = $this->db->get_where('warehouses_products', array('product_id' => $product_id, 'warehouse_id' => $warehouse), 1);
        if ($q->num_rows() > 0) {
            return $q->row_array(); //$q->row();
        }
        return FALSE;
    }

    public function insertQuantity($product_id, $warehouse_id, $quantity)
    {
        if ($this->db->insert('warehouses_products', array('product_id' => $product_id, 'warehouse_id' => $warehouse_id, 'quantity' => $quantity))) {
            $this->site->syncProductQty($product_id, $warehouse_id);
            return true;
        }
        return false;
    }

    public function updateQuantity($product_id, $warehouse_id, $quantity)
    {
        if ($this->db->update('warehouses_products', array('quantity' => $quantity), array('product_id' => $product_id, 'warehouse_id' => $warehouse_id))) {
            $this->site->syncProductQty($product_id, $warehouse_id);
            return true;
        }
        return false;
    }

    public function getProductByCode($code)
    {

        $q = $this->db->get_where('products', array('code' => $code), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
    }

    public function getProductByName($name)
    {

        $q = $this->db->get_where('products', array('name' => $name), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
    }

    public function getTransferByID($id)
    {

        $q = $this->db->get_where('transfers', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }

        return FALSE;
    }

    public function getAllTransferItems($transfer_id, $status)
    {
        if ($status == 'completed' || ($this->uri->segment(2)=='view' && $status == 'partial')) {
            $this->db->select('purchase_items.*, product_variants.name as variant, products.unit')
                ->from('purchase_items')
                ->join('products', 'products.id=purchase_items.product_id', 'left')
                ->join('product_variants', 'product_variants.id=purchase_items.option_id', 'left')
                ->group_by('purchase_items.id')
                ->where('transfer_id', $transfer_id);
        }else {
            $this->db->select('transfer_items.*, product_variants.name as variant, products.unit')
                ->from('transfer_items')
                ->join('products', 'products.id=transfer_items.product_id', 'left')
                ->join('product_variants', 'product_variants.id=transfer_items.option_id', 'left')
                ->group_by('transfer_items.id')
                ->where('transfer_id', $transfer_id);
        }
        $q = $this->db->get();
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
    }

    public function getWarehouseProduct($warehouse_id, $product_id, $variant_id)
    {
        if ($variant_id) {
            return $this->getProductWarehouseOptionQty($variant_id, $warehouse_id);
        } else {
            return $this->getWarehouseProductQuantity($warehouse_id, $product_id);
        }
        return FALSE;
    }

    public function getWarehouseProductQuantity($warehouse_id, $product_id)
    {
        $q = $this->db->get_where('warehouses_products', array('warehouse_id' => $warehouse_id, 'product_id' => $product_id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function resetTransferActions($id, $CurrentStatus='')
    {
        $otransfer = $this->getTransferByID($id);
        $oitems = $this->getAllTransferItems($id, $otransfer->status);
        $ostatus = $otransfer->status;
        if ($ostatus == 'sent' || $ostatus == 'completed') {
            // $this->db->update('purchase_items', array('warehouse_id' => $otransfer->from_warehouse_id, 'transfer_id' => NULL), array('transfer_id' => $otransfer->id));
            foreach ($oitems as $item) {
                $option_id = (isset($item->option_id) && ! empty($item->option_id)) ? $item->option_id : NULL;
                $clause = array('purchase_id' => NULL, 'transfer_id' => NULL, 'product_id' => $item->product_id, 'warehouse_id' => $otransfer->from_warehouse_id, 'option_id' => $option_id);
                $pi = $this->site->getPurchasedItem(array('id' => $item->id));
                if ($ppi = $this->site->getPurchasedItem($clause)) {
                    $quantity_balance = $ppi->quantity_balance + $item->quantity;
					if($CurrentStatus == 'completed' && $ostatus == 'sent'){
						//$clause['quantity_balance'] = 0;
						$clause['transfer_id'] = $id;
					}
                    $this->db->update('purchase_items', array('quantity_balance' => $quantity_balance), array('id' => $ppi->id));
                } else {
					if($CurrentStatus == 'completed' && $ostatus == 'sent'){
						//$clause['quantity_balance'] = 0;
						$clause['transfer_id'] = $id;
					}
                    $clause['quantity'] = $item->quantity;
                    $clause['item_tax'] = 0;
                    $clause['quantity_balance'] = $item->quantity;
                    $clause['status'] = 'received';
                    $this->db->insert('purchase_items', $clause);
                }
            }
        }
        return $ostatus;
    }

    public function deleteTransfer($id)
    {
        $ostatus = $this->resetTransferActions($id);
        $oitems = $this->getAllTransferItems($id, $ostatus);
        $tbl = $ostatus == 'completed' ? 'purchase_items' : 'transfer_items';
        if ($this->db->delete('transfers', array('id' => $id)) && $this->db->delete($tbl, array('transfer_id' => $id))) {
            foreach ($oitems as $item) {
                $this->site->syncQuantity(NULL, NULL, NULL, $item->product_id);
            }
            return true;
        }
        return FALSE;
    }

    public function getProductOptions($product_id, $warehouse_id, $zero_check = TRUE)
    {
        $this->db->select('product_variants.id as id, product_variants.name as name, product_variants.cost as cost, product_variants.quantity as total_quantity, warehouses_products_variants.quantity as quantity')
            ->join('warehouses_products_variants', 'warehouses_products_variants.option_id=product_variants.id', 'left')
            ->where('product_variants.product_id', $product_id)
            ->where('warehouses_products_variants.warehouse_id', $warehouse_id)
            ->group_by('product_variants.id');
        if ($zero_check) {
            $this->db->where('warehouses_products_variants.quantity >', 0);
        }
        $q = $this->db->get('product_variants');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getProductComboItems($pid, $warehouse_id)
    {
        $this->db->select('products.id as id, combo_items.item_code as code, combo_items.quantity as qty, products.name as name, warehouses_products.quantity as quantity')
            ->join('products', 'products.code=combo_items.item_code', 'left')
            ->join('warehouses_products', 'warehouses_products.product_id=products.id', 'left')
            ->where('warehouses_products.warehouse_id', $warehouse_id)
            ->group_by('combo_items.id');
        $q = $this->db->get_where('combo_items', array('combo_items.product_id' => $pid));
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }

            return $data;
        }
        return FALSE;
    }

    public function getProductVariantByName($name, $product_id)
    {
        $q = $this->db->get_where('product_variants', array('name' => $name, 'product_id' => $product_id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function syncTransderdItem($product_id, $warehouse_id, $quantity, $option_id = NULL, $Status=NULL)
    {
        if ($pis = $this->site->getPurchasedItems($product_id, $warehouse_id, $option_id)) {
            $balance_qty = $quantity;
            foreach ($pis as $pi) {
                if ($balance_qty <= $quantity && $quantity > 0) {
                    if ($pi->quantity_balance >= $quantity) {
                        $balance_qty = $pi->quantity_balance - $quantity;
						if($Status!='completed')
							$this->db->update('purchase_items', array('quantity_balance' => $balance_qty), array('id' => $pi->id));
                        $quantity = 0;
                    } elseif ($quantity > 0) {
                        $quantity = $quantity - $pi->quantity_balance;
                        $balance_qty = $quantity;
                        $this->db->update('purchase_items', array('quantity_balance' => 0), array('id' => $pi->id));
                    }
                }
                if ($quantity == 0) { break; }
            }
        } else {
            $clause = array('purchase_id' => NULL, 'transfer_id' => NULL, 'product_id' => $product_id, 'warehouse_id' => $warehouse_id, 'option_id' => $option_id);
            if ($pi = $this->site->getPurchasedItem($clause)) {
                $quantity_balance = $pi->quantity_balance - $quantity;
                $this->db->update('purchase_items', array('quantity_balance' => $quantity_balance), array('id' => $pi->id));
            } else {
                $clause['quantity'] = 0;
                $clause['item_tax'] = 0;
                $clause['status'] = 'received';
                $clause['quantity_balance'] = (0 - $quantity);
                $this->db->insert('purchase_items', $clause);
            }
        }
        $this->site->syncQuantity(NULL, NULL, NULL, $product_id);
    }

    public function getProductOptionByID($id)
    {
        $q = $this->db->get_where('product_variants', array('id' => $id), 1);
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }
    
    public function getTransferProductList($warehouse_id,$werehouse_id_2){
      
         
         $this->db->select('products.id, products.code, products.name,products.cost, products.tax_rate, products.type, products.unit, products.purchase_unit, products.tax_method, product_variants.name as option,product_variants.id as varentid,tax_rates.rate,tax_rates.type as tax_type')
            ->join('warehouses_products', 'warehouses_products.product_id=products.id', 'left')
             ->join('product_variants', 'product_variants.product_id=products.id', 'left')
            ->join('tax_rates','tax_rates.id=tax_rate');  
            //->group_by('products.id');
             $this->db->where("products.type = 'standard' ")->where("warehouses_products.warehouse_id = $warehouse_id ")->order_by('products.name','ASC'); 
             //AND warehouses_products.warehouse_id = '" . $warehouse_id . "' 
             
             $q = $this->db->get('products');
            
            if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                if ($row->option) {
                
                $qty1 = $this->db->select('quantity')->where(['product_id'=>$row->id,'warehouse_id'=>$warehouse_id,'option_id'=>$row->varentid])->get('sma_warehouses_products_variants')->row();//Shock  Quantity Warehouse 1 query With Varent
                $qty2 = $this->db->select('quantity  as werehouse_2_quantity')->where(['product_id'=>$row->id,'warehouse_id'=>$werehouse_id_2,'option_id'=>$row->varentid])->get('sma_warehouses_products_variants')->row();//Shock  Quantity Warehouse 2 query With Varent
                }else{
                  $qty1 = $this->db->select('quantity')->where(['product_id'=>$row->id,'warehouse_id'=>$warehouse_id])->get('sma_warehouses_products')->row();//Shock Quantity Warehouse 1 query Without Varent
                  $this->db->select('quantity as werehouse_2_quantity')
                 ->where(['product_id'=>$row->id,'warehouse_id'=>$werehouse_id_2]);
                  $qty2 = $this->db->get('warehouses_products')->row();//Shock  Quantity Warehouse 2 query Without Varent

                
                }
                $row->werehouse_2_quantity = $qty2->werehouse_2_quantity;
                $row->quantity = $qty1->quantity;
                $sql = $this->db->where(array('product_id' => $row->id))->get('product_variants');

                
                

                $optionvartiant=array();
                if ($sql->num_rows() > 0) {
                      foreach (($sql->result()) as $rows) {
                            $optionvartiant[] = $rows;
                           // $quantity =$quantity + $row->quantity;
                        }
                        
                 }

             	 $units = $this->site->getUnitsByBUID($row->unit);
                // $data[] = $row; 
                 $data[] = array('item'=>$row,'variant'=>$optionvartiant,'units'=>$units); 
                        }
            return $data;
        }
       return FALSE;
    }


    public function getVariantQuantity($varient_id, $warehouse_id )
    {
        $this->db->select('quantity');
        $this->db->where('option_id', $varient_id);
        $this->db->where_in('warehouse_id', $warehouse_id);
        $data = $this->db->get('warehouses_products_variants');
        if ($data->num_rows() > 0) {
            return $data->result(); 
        }
        return FALSE;
    }
     

}
