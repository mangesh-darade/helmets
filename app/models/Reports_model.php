<?php defined('BASEPATH') OR exit('No direct script access allowed');

class Reports_model extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }

    public function getProductNames($term, $limit = 5)
    {
        $this->db->select('id, code, name')
            ->like('name', $term, 'both')->or_like('code', $term, 'both');
        $this->db->limit($limit);
        $q = $this->db->get('products');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    public function getStaffById($user_id)
    {
       /* if ($this->Admin) {
            $this->db->where('group_id !=', 1);
        }*/
		$this->db->where('id', $user_id);
        //$this->db->where('group_id !=', 3)->where('group_id !=', 4);
        $q = $this->db->get('users');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    public function getStaff()
    {
        if ($this->Admin) {
            $this->db->where('group_id !=', 1);
        }
        $this->db->where('group_id !=', 3)->where('group_id !=', 4);
        $q = $this->db->get('users');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getSalesTotals($customer_id)
    {

        $this->db->select('SUM(COALESCE(grand_total, 0)) as total_amount, SUM(COALESCE(paid, 0)) as paid', FALSE)
            ->where('customer_id', $customer_id);
        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getCustomerSales($customer_id)
    {
        $this->db->from('sales')->where('customer_id', $customer_id);
        return $this->db->count_all_results();
    }

    public function getCustomerQuotes($customer_id)
    {
        $this->db->from('quotes')->where('customer_id', $customer_id);
        return $this->db->count_all_results();
    }

    public function getCustomerReturns($customer_id)
    {
        $this->db->from('sales')->where('customer_id', $customer_id)->where('sale_status', 'returned');
        return $this->db->count_all_results();
    }

    public function getStockValue()
    {
        $q = $this->db->query("SELECT SUM(by_price) as stock_by_price, SUM(by_cost) as stock_by_cost FROM ( Select COALESCE(sum(" . $this->db->dbprefix('warehouses_products') . ".quantity), 0)*price as by_price, COALESCE(sum(" . $this->db->dbprefix('warehouses_products') . ".quantity), 0)*cost as by_cost FROM " . $this->db->dbprefix('products') . " JOIN " . $this->db->dbprefix('warehouses_products') . " ON " . $this->db->dbprefix('warehouses_products') . ".product_id=" . $this->db->dbprefix('products') . ".id GROUP BY " . $this->db->dbprefix('products') . ".id )a");
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getWarehouseStockValue($id)
    {
        $q = $this->db->query("SELECT SUM(by_price) as stock_by_price, SUM(by_cost) as stock_by_cost FROM ( Select sum(COALESCE(" . $this->db->dbprefix('warehouses_products') . ".quantity, 0))*price as by_price, sum(COALESCE(" . $this->db->dbprefix('warehouses_products') . ".quantity, 0))*cost as by_cost FROM " . $this->db->dbprefix('products') . " JOIN " . $this->db->dbprefix('warehouses_products') . " ON " . $this->db->dbprefix('warehouses_products') . ".product_id=" . $this->db->dbprefix('products') . ".id WHERE " . $this->db->dbprefix('warehouses_products') . ".warehouse_id = ? GROUP BY " . $this->db->dbprefix('products') . ".id )a", array($id));
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    // public function getmonthlyPurchases()
    // {
    //     $myQuery = "SELECT (CASE WHEN date_format( date, '%b' ) Is Null THEN 0 ELSE date_format( date, '%b' ) END) as month, SUM( COALESCE( total, 0 ) ) AS purchases FROM purchases WHERE date >= date_sub( now( ) , INTERVAL 12 MONTH ) GROUP BY date_format( date, '%b' ) ORDER BY date_format( date, '%m' ) ASC";
    //     $q = $this->db->query($myQuery);
    //     if ($q->num_rows() > 0) {
    //         foreach (($q->result()) as $row) {
    //             $data[] = $row;
    //         }
    //         return $data;
    //     }
    //     return FALSE;
    // }

    public function getChartData()
    {
        $myQuery = "SELECT S.month,
        COALESCE(S.sales, 0) as sales,
        COALESCE( P.purchases, 0 ) as purchases,
        COALESCE(S.tax1, 0) as tax1,
        COALESCE(S.tax2, 0) as tax2,
        COALESCE( P.ptax, 0 ) as ptax
        FROM (  SELECT  date_format(date, '%Y-%m') Month,
                SUM(total) Sales,
                SUM(product_tax) tax1,
                SUM(order_tax) tax2
                FROM " . $this->db->dbprefix('sales') . "
                WHERE date >= date_sub( now( ) , INTERVAL 12 MONTH )
                GROUP BY date_format(date, '%Y-%m')) S
            LEFT JOIN ( SELECT  date_format(date, '%Y-%m') Month,
                        SUM(product_tax) ptax,
                        SUM(order_tax) otax,
                        SUM(total) purchases
                        FROM " . $this->db->dbprefix('purchases') . "
                        GROUP BY date_format(date, '%Y-%m')) P
            ON S.Month = P.Month
            ORDER BY S.Month";
        $q = $this->db->query($myQuery);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getDailySales($year, $month, $warehouse_id = NULL)
    {
        $getwarehouse = str_replace("_",",", $warehouse_id);
        
        $myQuery = "SELECT DATE_FORMAT( date,  '%e' ) AS date, SUM( COALESCE( product_tax, 0 ) ) AS tax1, SUM( COALESCE( order_tax, 0 ) ) AS tax2, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( total_discount, 0 ) ) AS discount, SUM( COALESCE( shipping, 0 ) ) AS shipping
			FROM " . $this->db->dbprefix('sales') . " WHERE ";
       /* if ($warehouse_id) {
            $myQuery .= " warehouse_id = {$warehouse_id} AND ";
        }*/
        
        if ($warehouse_id) {
            $myQuery .= " warehouse_id IN( {$getwarehouse} ) AND ";
        }
        if($this->session->userdata('view_right')=='0'){
            $myQuery .= " created_by = {$user_id} AND  ";
        }
        
        $myQuery .= " DATE_FORMAT( date,  '%Y-%m' ) =  '{$year}-{$month}'
			GROUP BY DATE_FORMAT( date,  '%e' )";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    
    public function getDailySalesItems($date, $warehouse_id=0)
    {
        $query = "SELECT  si.product_id ,si.product_code ,  si.product_name ,  si.net_unit_price, si.product_unit_code as unit,
                    SUM(  si.quantity ) as qty, SUM(  si.item_tax ) as tax, si.tax as tax_rate, SUM(  si.item_discount ) as discount, SUM(  si.subtotal ) as total, c.id as category_id, c.name as category_name
                FROM  " . $this->db->dbprefix('sale_items') . " si  left join " . $this->db->dbprefix('products') . " p on p.id=si.product_id left join  " . $this->db->dbprefix('categories') . " c on c.id=p.category_id
                WHERE  si.sale_id IN ( SELECT  `id`  FROM  " . $this->db->dbprefix('sales') . "  WHERE DATE( `date` ) =  '$date' )";
		if($warehouse_id!=0){
			$query .= " and si.warehouse_id='$warehouse_id'  ";
		}
                $query .= " GROUP BY  si.product_code 
                ORDER BY  si.product_name "; 
                    
        $q = $this->db->query($query, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    
    public function getDailySalesItemsTaxes($date, $warehouse_id=0)
    {
       $select_warehouse='';
		if($warehouse_id!=0){
			$select_warehouse = " and warehouse_id='$warehouse_id'  ";
		}
        $query = "SELECT sum(`tax_amount`) amount, ( `attr_per` * 2) as rate,item_id
            FROM  " . $this->db->dbprefix('sales_items_tax') . " 
                WHERE `sale_id` IN ( SELECT  `id`  FROM  " . $this->db->dbprefix('sales') . "  WHERE DATE( `date` ) =  '$date' ".$select_warehouse." ) 
                    AND `attr_per` > 0 GROUP BY `attr_per` ORDER BY `attr_per` ASC ";        
                    
        $q = $this->db->query($query, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    
    public function getMonthSalesItemsTaxes($month,$year)
    {
        $query = "SELECT sum(`tax_amount`) amount, ( `attr_per` * 2) as rate,item_id
            FROM  " . $this->db->dbprefix('sales_items_tax') . " 
                WHERE `sale_id` IN ( SELECT  `id`  FROM  " . $this->db->dbprefix('sales') . "  WHERE  DATE_FORMAT( date,  '%c' ) =  '{$month}' AND  DATE_FORMAT( date,  '%Y' ) =  '{$year}' ) 
                    AND `attr_per` > 0 GROUP BY `attr_per` ORDER BY `attr_per` ASC ";        
                    
        $q = $this->db->query($query, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    public function getMonthlySales($year, $warehouse_id = NULL)
    {  $getwarehouse = str_replace("_",",", $warehouse_id);
        $myQuery = "SELECT  DATE_FORMAT( date,  '%c' ) AS date, SUM( COALESCE( product_tax, 0 ) ) AS tax1, SUM( COALESCE( order_tax, 0 ) ) AS tax2, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( total_discount, 0 ) ) AS discount, SUM( COALESCE( shipping, 0 ) ) AS shipping
			FROM " . $this->db->dbprefix('sales') . " WHERE ";
        if ($warehouse_id) {
            $myQuery .= " warehouse_id IN ({$getwarehouse}) AND ";
        }
        $myQuery .= " DATE_FORMAT( date,  '%Y' ) =  '{$year}'
			GROUP BY date_format( date, '%c' ) ORDER BY date_format( date, '%c' ) ASC";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getStaffDailySales($user_id, $year, $month, $warehouse_id = NULL)
    {
        $getwarehouse = str_replace("_",",", $warehouse_id);  
        $myQuery = "SELECT DATE_FORMAT( date,  '%e' ) AS date, SUM( COALESCE( product_tax, 0 ) ) AS tax1, SUM( COALESCE( order_tax, 0 ) ) AS tax2, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( total_discount, 0 ) ) AS discount, SUM( COALESCE( shipping, 0 ) ) AS shipping
            FROM " . $this->db->dbprefix('sales')." WHERE ";
        if ($warehouse_id) {
            $myQuery .= " warehouse_id IN( {$getwarehouse} ) AND ";
        }
      if($this->Owner || $this->Admin){
				if($user_id)
				   {
					    $myQuery .= " created_by = {$user_id} AND ";
				   }
			}else{
				  if($this->session->userdata('view_right')=='0'){
            $myQuery .= " created_by = {$user_id} AND ";
        }
			}
        $myQuery .= " DATE_FORMAT( date,  '%Y-%m' ) =  '{$year}-{$month}'
            GROUP BY DATE_FORMAT( date,  '%e' )";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

     public function getStaffMonthlySales($user_id, $year, $warehouse_id = NULL)
    {$getwarehouse = str_replace("_", ',', $warehouse_id);
        $myQuery = "SELECT DATE_FORMAT( date,  '%c' ) AS date, SUM( COALESCE( product_tax, 0 ) ) AS tax1, SUM( COALESCE( order_tax, 0 ) ) AS tax2, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( total_discount, 0 ) ) AS discount, SUM( COALESCE( shipping, 0 ) ) AS shipping
            FROM " . $this->db->dbprefix('sales') . " WHERE ";
        if ($warehouse_id) {
            $myQuery .= " warehouse_id IN ({$getwarehouse}) AND ";
        }
        
        if($this->Owner || $this->Admin){
				if($user_id)
				   {
					   $myQuery .= " created_by = {$user_id} AND ";
				   }
			}else{
				  if($this->session->userdata('view_right')=='0'){
					$myQuery .= " created_by = {$user_id} AND ";
				}
			}

        $myQuery .= "  DATE_FORMAT( date,  '%Y' ) =  '{$year}'
            GROUP BY date_format( date, '%c' ) ORDER BY date_format( date, '%c' ) ASC";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getPurchasesTotals($supplier_id)
    {
        $this->db->select('SUM(COALESCE(grand_total, 0)) as total_amount, SUM(COALESCE(paid, 0)) as paid', FALSE)
            ->where('supplier_id', $supplier_id);
        $q = $this->db->get('purchases');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getSupplierPurchases($supplier_id)
    {
        $this->db->from('purchases')->where('supplier_id', $supplier_id);
        return $this->db->count_all_results();
    }

    public function getStaffPurchases($user_id)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(grand_total, 0)) as total_amount, SUM(COALESCE(paid, 0)) as paid', FALSE)
            ->where('created_by', $user_id);
        $q = $this->db->get('purchases');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getStaffSales($user_id)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(grand_total, 0)) as total_amount, SUM(COALESCE(paid, 0)) as paid', FALSE)
            ->where('created_by', $user_id);
        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTotalSales($start, $end, $warehouse_id = NULL)
    {
        $this->db->select('count(id) as total, sum(COALESCE(grand_total, 0)) as total_amount, SUM(COALESCE(paid, 0)) as paid, SUM(COALESCE(total_tax, 0)) as tax', FALSE)
            ->where('sale_status !=', 'pending')
            ->where('date BETWEEN ' . $start . ' and ' . $end);
        if ($warehouse_id) {
            $this->db->where('warehouse_id', $warehouse_id);
        }
        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTotalPurchases($start, $end, $warehouse_id = NULL)
    {
        $this->db->select('count(id) as total, sum(COALESCE(grand_total, 0)) as total_amount, SUM(COALESCE(paid, 0)) as paid, SUM(COALESCE(total_tax, 0)) as tax', FALSE)
            ->where('status !=', 'pending')
            ->where('date BETWEEN ' . $start . ' and ' . $end);
        if ($warehouse_id) {
            $this->db->where('warehouse_id', $warehouse_id);
        }
        $q = $this->db->get('purchases');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTotalExpenses($start, $end, $warehouse_id = NULL)
    {
        $this->db->select('count(id) as total, sum(COALESCE(amount, 0)) as total_amount', FALSE)
            ->where('date BETWEEN ' . $start . ' and ' . $end);
        if ($warehouse_id) {
            $this->db->where('warehouse_id', $warehouse_id);
        }
        $q = $this->db->get('expenses');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTotalPaidAmount($start, $end)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(amount, 0)) as total_amount', FALSE)
            ->where('type', 'sent')
            ->where('date BETWEEN ' . $start . ' and ' . $end);
        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTotalReceivedAmount($start, $end)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(amount, 0)) as total_amount', FALSE)
            ->where('type', 'received')
            ->where('date BETWEEN ' . $start . ' and ' . $end);
        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTotalReceivedCashAmount($start, $end)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(amount, 0)) as total_amount', FALSE)
            ->where('type', 'received')->where('paid_by', 'cash')
            ->where('date BETWEEN ' . $start . ' and ' . $end);
        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTotalReceivedCCAmount($start, $end)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(amount, 0)) as total_amount', FALSE)
            ->where('type', 'received')->where('paid_by', 'CC')
            ->where('date BETWEEN ' . $start . ' and ' . $end);
        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTotalReceivedChequeAmount($start, $end)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(amount, 0)) as total_amount', FALSE)
            ->where('type', 'received')->where('paid_by', 'Cheque')
            ->where('date BETWEEN ' . $start . ' and ' . $end);
        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTotalReceivedPPPAmount($start, $end)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(amount, 0)) as total_amount', FALSE)
            ->where('type', 'received')->where('paid_by', 'ppp')
            ->where('date BETWEEN ' . $start . ' and ' . $end);
        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTotalReceivedStripeAmount($start, $end)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(amount, 0)) as total_amount', FALSE)
            ->where('type', 'received')->where('paid_by', 'stripe')
            ->where('date BETWEEN ' . $start . ' and ' . $end);
        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getTotalReturnedAmount($start, $end)
    {
        $this->db->select('count(id) as total, SUM(COALESCE(amount, 0)) as total_amount', FALSE)
            ->where('type', 'returned')
            ->where('date BETWEEN ' . $start . ' and ' . $end);
        $q = $this->db->get('payments');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getWarehouseTotals($warehouse_id = NULL)
    {
        $this->db->select('sum(quantity) as total_quantity, count(id) as total_items', FALSE);
        $this->db->where('quantity !=', 0);
        if ($warehouse_id) {
            $this->db->where('warehouse_id', $warehouse_id);
        }
        $q = $this->db->get('warehouses_products');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return FALSE;
    }

    public function getCosting($date, $warehouse_id = NULL, $year = NULL, $month = NULL)
    {
        $this->db->select('SUM( COALESCE( purchase_unit_cost, 0 ) * quantity ) AS cost, SUM( COALESCE( sale_unit_price, 0 ) * quantity ) AS sales, SUM( COALESCE( purchase_net_unit_cost, 0 ) * quantity ) AS net_cost, SUM( COALESCE( sale_net_unit_price, 0 ) * quantity ) AS net_sales', FALSE);
        if ($date) {
            $this->db->where('costing.date', $date);
        } elseif ($month) {
            $this->load->helper('date');
            $last_day = days_in_month($month, $year);
            $this->db->where('costing.date >=', $year.'-'.$month.'-01 00:00:00');
            $this->db->where('costing.date <=', $year.'-'.$month.'-'.$last_day.' 23:59:59');
        }

        if ($warehouse_id) {
            $this->db->join('sales', 'sales.id=costing.sale_id')
            ->where('sales.warehouse_id', $warehouse_id);
        }

        $q = $this->db->get('costing');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getExpenses($date, $warehouse_id = NULL, $year = NULL, $month = NULL)
    {
        $sdate = $date.' 00:00:00';
        $edate = $date.' 23:59:59';
        $this->db->select('SUM( COALESCE( amount, 0 ) ) AS total', FALSE);
        if ($date) {
            $this->db->where('date >=', $sdate)->where('date <=', $edate);
        } elseif ($month) {
            $this->load->helper('date');
            $last_day = days_in_month($month, $year);
            $this->db->where('date >=', $year.'-'.$month.'-01 00:00:00');
            $this->db->where('date <=', $year.'-'.$month.'-'.$last_day.' 23:59:59');
        }
        

        if ($warehouse_id) {
            $this->db->where('warehouse_id', $warehouse_id);
        }

        $q = $this->db->get('expenses');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getReturns($date, $warehouse_id = NULL, $year = NULL, $month = NULL)
    {
        $sdate = $date.' 00:00:00';
        $edate = $date.' 23:59:59';
        $this->db->select('SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( total_tax, 0 ) ) AS total_tax', FALSE)
        ->where('sale_status', 'returned');
        if ($date) {
            $this->db->where('date >=', $sdate)->where('date <=', $edate);
        } elseif ($month) {
            $this->load->helper('date');
            $last_day = days_in_month($month, $year);
            $this->db->where('date >=', $year.'-'.$month.'-01 00:00:00');
            $this->db->where('date <=', $year.'-'.$month.'-'.$last_day.' 23:59:59');
        }

        if ($warehouse_id) {
            $this->db->where('warehouse_id', $warehouse_id);
        }

        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getOrderDiscount($date, $warehouse_id = NULL, $year = NULL, $month = NULL)
    {
        $sdate = $date.' 00:00:00';
        $edate = $date.' 23:59:59';
        $this->db->select('SUM( COALESCE( order_discount, 0 ) ) AS order_discount', FALSE);
        if ($date) {
            $this->db->where('date >=', $sdate)->where('date <=', $edate);
        } elseif ($month) {
            $this->load->helper('date');
            $last_day = days_in_month($month, $year);
            $this->db->where('date >=', $year.'-'.$month.'-01 00:00:00');
            $this->db->where('date <=', $year.'-'.$month.'-'.$last_day.' 23:59:59');
        }

        if ($warehouse_id) {
            $this->db->where('warehouse_id', $warehouse_id);
        }

        $q = $this->db->get('sales');
        if ($q->num_rows() > 0) {
            return $q->row();
        }
        return false;
    }

    public function getExpenseCategories()
    {
        $q = $this->db->get('expense_categories');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getDailyPurchases($year, $month, $warehouse_id = NULL)
    { $getwarehouse = str_replace("_","," ,$warehouse_id);
        $myQuery = "SELECT DATE_FORMAT( date,  '%e' ) AS date, SUM( COALESCE( product_tax, 0 ) ) AS tax1, SUM( COALESCE( order_tax, 0 ) ) AS tax2, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( total_discount, 0 ) ) AS discount, SUM( COALESCE( shipping, 0 ) ) AS shipping
            FROM " . $this->db->dbprefix('purchases') . " WHERE ";
       if ($warehouse_id) {
            $myQuery .= " warehouse_id IN ({$getwarehouse}) AND ";
        }
        $myQuery .= " DATE_FORMAT( date,  '%Y-%m' ) =  '{$year}-{$month}'
            GROUP BY DATE_FORMAT( date,  '%e' )";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getMonthlyPurchases($year, $warehouse_id = NULL)
    {  $getwarehouse = str_replace("_",",", $warehouse_id); 
        $myQuery = "SELECT DATE_FORMAT( date,  '%c' ) AS date, SUM( COALESCE( product_tax, 0 ) ) AS tax1, SUM( COALESCE( order_tax, 0 ) ) AS tax2, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( total_discount, 0 ) ) AS discount, SUM( COALESCE( shipping, 0 ) ) AS shipping
            FROM " . $this->db->dbprefix('purchases') . " WHERE ";
        if ($warehouse_id) {
            $myQuery .= " warehouse_id IN ({$getwarehouse}) AND ";
        }
        $myQuery .= " DATE_FORMAT( date,  '%Y' ) =  '{$year}'
            GROUP BY date_format( date, '%c' ) ORDER BY date_format( date, '%c' ) ASC";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getStaffDailyPurchases($user_id, $year, $month, $warehouse_id = NULL)
    { $getwarehouse = str_replace("_", ",", $warehouse_id);
        $myQuery = "SELECT DATE_FORMAT( date,  '%e' ) AS date, SUM( COALESCE( product_tax, 0 ) ) AS tax1, SUM( COALESCE( order_tax, 0 ) ) AS tax2, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( total_discount, 0 ) ) AS discount, SUM( COALESCE( shipping, 0 ) ) AS shipping
            FROM " . $this->db->dbprefix('purchases')." WHERE ";
        if ($warehouse_id) {
            $myQuery .= " warehouse_id IN ( {$getwarehouse} ) AND ";
        }
       
        // 03/04/19
        if($this->session->userdata('view_right')=='0'){
            $myQuery .= " created_by = {$user_id} AND ";
        }
        // End  03/04/19


        $myQuery .= "  DATE_FORMAT( date,  '%Y-%m' ) =  '{$year}-{$month}'
            GROUP BY DATE_FORMAT( date,  '%e' )";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }


     public function getStaffMonthlyPurchases($user_id, $year, $warehouse_id = NULL)
    { $getwarehouse = str_replace("_", ",", $warehouse_id);
        $myQuery = "SELECT DATE_FORMAT( date,  '%c' ) AS date, SUM( COALESCE( product_tax, 0 ) ) AS tax1, SUM( COALESCE( order_tax, 0 ) ) AS tax2, SUM( COALESCE( grand_total, 0 ) ) AS total, SUM( COALESCE( total_discount, 0 ) ) AS discount, SUM( COALESCE( shipping, 0 ) ) AS shipping
            FROM " . $this->db->dbprefix('purchases') . " WHERE ";
        if ($warehouse_id) {
            $myQuery .= " warehouse_id IN ( {$getwarehouse}) AND ";
        }
       
       if($this->session->userdata('view_right')=='0'){
            $myQuery .= " created_by = {$user_id} AND ";
        }

        $myQuery .= " created_by = {$user_id} AND DATE_FORMAT( date,  '%Y' ) =  '{$year}'
            GROUP BY date_format( date, '%c' ) ORDER BY date_format( date, '%c' ) ASC";
        $q = $this->db->query($myQuery, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }

    public function getBestSeller($start_date, $end_date, $warehouse_id = NULL)
    {
        $this->db
            ->select("product_name, product_code")->select_sum('quantity')
            ->join('sales', 'sales.id = sale_items.sale_id', 'left')
            ->where('date >=', $start_date)->where('date <=', $end_date)
            ->group_by('product_name, product_code')->order_by('sum(quantity)', 'desc')->limit(10);
        if ($warehouse_id) {
            $this->db->where('sale_items.warehouse_id', $warehouse_id);
        }
        $q = $this->db->get('sale_items');
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
            	$row->quantity =  number_format($row->quantity, 2, '.', '');
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    
         
    public function salesTaxReport($param=NULL) {
	$user = isset($param['user'])? $param['user']:NULL;
	$biller = isset($param['biller'])? $param['biller']:NULL;
	$customer = isset($param['customer'])? $param['customer']:NULL;
	$warehouse = isset($param['warehouse'])? $param['warehouse']:NULL;
	$reference_no = isset($param['reference_no'])? $param['reference_no']:NULL;
	$start_date = isset($param['start_date'])? $param['start_date']:NULL;
	$end_date = isset($param['end_date'])? $param['end_date']:NULL;        
        $gstn_opt = isset($param['gstn_opt'])? $param['gstn_opt']:NULL;
	$gstn_no = isset($param['gstn_no'])? $param['gstn_no']:NULL;       
	$hsn_code = isset($param['hsn_code'])? $param['hsn_code']:NULL;       
         if(!empty($hsn_code)){
               $SalesIds =  $this->getSaleIdByHsn($hsn_code);
          }      
        $this->db
            ->select_sum('order_tax')
            ->select_sum('product_tax')
            ->join('companies comp', 'sales.customer_id=comp.id', 'left')
            ->join('warehouses', 'warehouses.id=sales.warehouse_id', 'left');
            
        
            if ($user) {
                $this->db->where('sales.created_by', $user);
            }
          
            if ($biller) {
                $this->db->where('sales.biller_id', $biller);
            }
            if ($customer) {
                $this->db->where('sales.customer_id', $customer);
            }
            if ($warehouse) {
                $this->db->where('sales.warehouse_id', $warehouse);
            }
            if ($reference_no) {
                $this->db->like('sales.reference_no', $reference_no, 'both');
            }
            if ($start_date) {
                $this->db->where($this->db->dbprefix('sales').'.date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }
 	    
 	    if($gstn_opt){
                switch ($gstn_opt) {
                    case '-1':
                            $this->db->where("comp.gstn_no IS NULL OR comp.gstn_no = '' ");
                        break;
                    
                    case '1':
                            $this->db->where("comp.gstn_no IS NOT NULL and comp.gstn_no != '' ");
                        break;
                    
                    default:
                        
                        break;
                }
            }
             if($gstn_no){
            	$this->db->where("comp.gstn_no = '".$gstn_no."' ");
            }
            if(!empty($hsn_code)){
                $this->db->where('sales.id in ('.$SalesIds.')');
            }         
        $q = $this->db->get('sales');
         
        if ($q->num_rows() > 0) {
           $res =  $q->row();
           if($res){
           	 
               $res->CGST = $this->getSumOfSalesTaxAttr('CGST',$param);
               $res->SGST = $this->getSumOfSalesTaxAttr('SGST',$param);
               $res->IGST = $this->getSumOfSalesTaxAttr('IGST',$param);
              
           }
            return $res;
        }
        return FALSE;
    }
    
    
    public function purchaseTaxReport($param=NULL) {
        $user = isset($param['user'])? $param['user']:NULL;
	$supplier = isset($param['supplier'])? $param['supplier']:NULL;
	$warehouse = isset($param['warehouse'])? $param['warehouse']:NULL;
	$reference_no = isset($param['reference_no'])? $param['reference_no']:NULL;
	$start_date = isset($param['start_date'])? $param['start_date']:NULL;
	$end_date = isset($param['end_date'])? $param['end_date']:NULL;        
        $gstn_opt = isset($param['gstn_opt'])? $param['gstn_opt']:NULL;
	$gstn_no = isset($param['gstn_no'])? $param['gstn_no']:NULL;       
	$hsn_code = isset($param['hsn_code'])? $param['hsn_code']:NULL;       
         if(!empty($hsn_code)){
               $PurchaseIds =  $this->getPurchaseIdByHsn($hsn_code); 
          }   
    
        $this->db
        ->select_sum('order_tax')
        ->select_sum('product_tax')
         
        ->join('companies comp', 'purchases.supplier_id=comp.id', 'left')
        ->join('warehouses', 'warehouses.id=purchases.warehouse_id', 'left');
        
            if ($user) {
                $this->db->where('purchases.created_by', $user);
            }
            
            if ($supplier) {
                $this->db->where('purchases.supplier_id', $supplier);
            }
            if ($warehouse) {
                $this->db->where('purchases.warehouse_id', $warehouse);
            }
            if ($reference_no) {
                $this->db->like('purchases.reference_no', $reference_no, 'both');
            }
            if ($start_date) {
                $this->db->where($this->db->dbprefix('purchases').'.date BETWEEN "' . $start_date . '" and "' . $end_date . '"');
            }
            
            if($gstn_opt){
                switch ($gstn_opt) {
                    case '-1':
                            $this->db->where("comp.gstn_no IS NULL OR comp.gstn_no = '' ");
                        break;
                    
                    case '1':
                            $this->db->where("comp.gstn_no IS NOT NULL and comp.gstn_no != '' ");
                        break;
                    
                    default:
                        
                        break;
                }
            }
           
            if($gstn_no){
            	$this->db->where("comp.gstn_no = '".$gstn_no."' ");
            }
            
            if($PurchaseIds){
                $this->db->where('purchases.id in ('.$PurchaseIds.')');
            }   
            
        $q = $this->db->get('purchases');
        
        if ($q->num_rows() > 0) {
            $res =  $q->row();
           if($res){
           	 
              $res->CGST = $this->getSumOfPurchaseTaxAttr('CGST',$param);
               $res->SGST = $this->getSumOfPurchaseTaxAttr('SGST',$param);
               $res->IGST = $this->getSumOfPurchaseTaxAttr('IGST',$param);
           }
           return $res;
        }
        return FALSE;
    }
    
    
    public function getSaleIdByHsn($hsn) {
        if(empty($hsn)):
            return -1;
        endif;
    
        $this->db
            ->select('sale_id') 
            ->where('hsn_code', $hsn);
        $q = $this->db->get('sale_items'); 
        
        if ($q->num_rows() > 0) {
            $resultArr = array();
            foreach (($q->result()) as $row) {
                $resultArr[]=$row->sale_id;
            }
            return implode(',',$resultArr);
        }
        return -1;
    }
    
    public function getPurchaseIdByHsn($hsn) {
        if(empty($hsn)):
            return -1;
        endif;
        $this->db
            ->select('purchase_items.purchase_id')
            ->group_by('purchase_items.purchase_id')
            ->where('purchase_items.hsn_code', $hsn);
        $q = $this->db->get('purchase_items'); 
        if ($q->num_rows() > 0) {
            $resultArr = array();
            foreach (($q->result()) as $row) {
                $resultArr[]=$row->purchase_id;
            }
            return implode(',',$resultArr);
        }
        return -1;
    }
    
    public function getSumOfSalesTaxAttr($code,$param){
        
        $user = isset($param['user'])? $param['user']:NULL;
	$biller = isset($param['biller'])? $param['biller']:NULL;
	$customer = isset($param['customer'])? $param['customer']:NULL;
	$warehouse = isset($param['warehouse'])? $param['warehouse']:NULL;
	$reference_no = isset($param['reference_no'])? $param['reference_no']:NULL;
	$start_date = isset($param['start_date'])? $param['start_date']:NULL;
	$end_date = isset($param['end_date'])? $param['end_date']:NULL;        
        $gstn_opt = isset($param['gstn_opt'])? $param['gstn_opt']:NULL;
	$gstn_no = isset($param['gstn_no'])? $param['gstn_no']:NULL;       
	$hsn_code = isset($param['hsn_code'])? $param['hsn_code']:NULL;       
        if(!empty($hsn_code)){
              $SalesIds =  $this->getSaleIdByHsn($hsn_code);
         }     
         $whereCnd = "1=1";
      
      if ($user) {
        $whereCnd .= " and sma_sales.created_by = $user"; 
      }

      if ($biller) { 
        $whereCnd .= " and sma_sales.biller_id = $biller"; 
      }
      if ($customer) { 
        $whereCnd .= " and sma_sales.customer_id = $customer"; 
      }
      if ($warehouse) {
        $whereCnd .= " and sma_sales.warehouse_id = $warehouse"; 
      }
      if ($reference_no) { 
           $whereCnd .= " and sma_sales.reference_no like '%$reference_no%' "; 
      }
      if ($start_date) {
           $whereCnd .= " and sma_sales.date BETWEEN '$start_date' and   '$end_date' "; 
      }

      if($gstn_opt){
          switch ($gstn_opt) {
              case '-1': 
                   $whereCnd .= " and (comp.gstn_no IS NULL OR comp.gstn_no = '' ) ";
                  break;

              case '1': 
                     $whereCnd .= " and (comp.gstn_no IS NOT NULL and comp.gstn_no != '' ) ";
                  break;

              default:

                  break;
          }
      }
       if($gstn_no){ 
          $whereCnd .= " and (comp.gstn_no ='$gstn_no' ) ";
      }
      if(!empty($hsn_code)){
              
           $whereCnd .= " and (sales.id in  != '$SalesIds' ) ";
      }         
           $cnd= '';         
        if($whereCnd!='1=1'){
            
            $subsql = "SELECT sma_sales.id FROM `sma_sales` LEFT JOIN `sma_companies` `comp` ON `sma_sales`.`customer_id`=`comp`.`id` LEFT JOIN `sma_warehouses` ON `sma_sales`.`warehouse_id`= `sma_warehouses`.`id` where " .$whereCnd;
       
             $cnd = ' and sale_id IN ('.$subsql.') ';
        }
  	 $q = $this->db->query("SELECT SUM(`tax_amount`) as amt FROM  `sma_sales_items_tax` WHERE   `attr_code` =  '$code' ".$cnd);
                    
        if ($q->num_rows() > 0) {
            $res =  $q->row();
            return $res->amt;
        }
        return FALSE;
    }
    
    public function getSalesTaxAttrBySalesIds(array $saleIds){
        
        $salesIn = join(',', $saleIds );
              
  	$q = $this->db->query("SELECT * FROM  `sma_sales_items_tax` WHERE sale_id IN ($salesIn)");
              
        if ($q->num_rows() > 0) {              
            return $q->result();
        }
        return FALSE;
    }
    
    public function getSalesItemsBySaleIds(array $saleIds,$products)
    {
        $salesIn = join(',', $saleIds );
         
        /*$query = "SELECT id as items_id, sale_id, item_tax, subtotal, tax as gst, hsn_code as hsn_code, quantity as quantity, 
                    product_unit_code as unit , product_code, product_name, product_id 
                FROM  " . $this->db->dbprefix('sale_items') . "  
                WHERE `sale_id` IN ($salesIn) ";*/

        $query = "SELECT {$this->db->dbprefix('sale_items')}.id as items_id, {$this->db->dbprefix('sale_items')}.sale_id, {$this->db->dbprefix('sale_items')}.item_tax, {$this->db->dbprefix('sale_items')}.subtotal, {$this->db->dbprefix('sale_items')}.tax as gst, {$this->db->dbprefix('sale_items')}.hsn_code as hsn_code, {$this->db->dbprefix('sale_items')}.quantity as quantity, 
                    {$this->db->dbprefix('sale_items')}.product_unit_code as unit , {$this->db->dbprefix('sale_items')}.product_code, {$this->db->dbprefix('sale_items')}.product_name, {$this->db->dbprefix('sale_items')}.product_id ,{$this->db->dbprefix('product_variants')}.name as variant_name
                FROM  {$this->db->dbprefix('sale_items')}  lEFT JOIN {$this->db->dbprefix('product_variants')} ON {$this->db->dbprefix('product_variants')}.id = {$this->db->dbprefix('sale_items')}.option_id
                ";  // WHERE `sale_id` IN ($salesIn)
         if($products){
            $query .= " WHERE {$this->db->dbprefix('sale_items')}.product_id= $products";
         }else{
            $query .= " WHERE `sale_id` IN ($salesIn)";
         }      
                    
        $q = $this->db->query($query, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    
    public function getSumOfPurchaseTaxAttr($code, $param) {
        $user = isset($param['user']) ? $param['user'] : NULL;
        $supplier = isset($param['supplier']) ? $param['supplier'] : NULL;
        $warehouse = isset($param['warehouse']) ? $param['warehouse'] : NULL;
        $reference_no = isset($param['reference_no']) ? $param['reference_no'] : NULL;
        $start_date = isset($param['start_date']) ? $param['start_date'] : NULL;
        $end_date = isset($param['end_date']) ? $param['end_date'] : NULL;
        $gstn_opt = isset($param['gstn_opt']) ? $param['gstn_opt'] : NULL;
        $gstn_no = isset($param['gstn_no']) ? $param['gstn_no'] : NULL;
        $hsn_code = isset($param['hsn_code']) ? $param['hsn_code'] : NULL;
        if (!empty($hsn_code)) {
            $PurchaseIds = $this->getPurchaseIdByHsn($hsn_code);
        }
        $whereCnd = "1=1";
        if ($user) {
            $whereCnd .= " and sma_purchases.created_by = $user";
        }
        if ($supplier) {
            $whereCnd .= " and sma_purchases.supplier_id = $supplier";
        }
        if ($warehouse) {
            $whereCnd .= " and sma_purchases.warehouse_id = $warehouse";
        }

        if ($reference_no) {
            $whereCnd .= " and sma_purchases.reference_no like '%$reference_no%' ";
        }
        if ($start_date) {
            $whereCnd .= " and sma_purchases.date BETWEEN '$start_date' and   '$end_date' ";
        }

        if ($gstn_opt) {
            switch ($gstn_opt) {
                case '-1':
                    $whereCnd .= " and (comp.gstn_no IS NULL OR comp.gstn_no = '' ) ";
                    break;

                case '1':
                    $this->db->where(" ");
                    $whereCnd .= " and (comp.gstn_no IS NOT NULL and comp.gstn_no != '' ) ";
                    break;

                default:

                    break;
            }
        }

        if ($gstn_no) {
            $whereCnd .= " and (comp.gstn_no ='$gstn_no' ) ";
        }

        if ($PurchaseIds) {
            $whereCnd .= " and (sma_purchases.id in  != '$PurchaseIds' ) ";
        }
               
        $cnd = '';
        if ($whereCnd != '1=1') {
            $subsql = "  SELECT `sma_purchases`.id FROM `sma_purchases` LEFT JOIN `sma_companies` `comp` ON `sma_purchases`.`supplier_id`=`comp`.`id`LEFT JOIN `sma_warehouses` ON `sma_warehouses`.`id`=`sma_purchases`.`warehouse_id` where " . $whereCnd;
            $cnd = ' and purchase_id IN (' . $subsql . ') ';
        }
        $q = $this->db->query("SELECT SUM(`tax_amount`) as amt FROM  `sma_purchase_items_tax` WHERE   `attr_code` =  '$code' " . $cnd);

        if ($q->num_rows() > 0) {
            $res = $q->row();
            return $res->amt;
        }
        return FALSE;
    }
    
    public function warehouseSalesItems($start_date=NULL , $end_date=NULL, $warehouse = NULL) {
        
        
        if($start_date != NULL){
            
            $where = " WHERE s.`date` BETWEEN '$start_date' AND '$end_date' ";
        }
       
        if(!$warehouse ==''){
            $getwarehouse = str_replace("_", ",", $warehouse);
              $where .= 'AND si.`warehouse_id` IN('.$getwarehouse.')';  
        }
        
       $sql = "SELECT si.`product_id`, si.`product_code`, si.`product_name`, si.`warehouse_id`, sum(si.`quantity`) quantity "
                   . "FROM `sma_sale_items` si right JOIN `sma_sales` s ON si.`sale_id` = s.`id` "
                   . $where
                   . "GROUP BY si.`warehouse_id`, si.`product_id` "
                   . "ORDER BY si.`warehouse_id`, si.`product_id` "; 
         
        $q = $this->db->query($sql);
         
        if ($q->num_rows() > 0) {
            foreach ($q->result() as $row){
               
                $data[$row->product_id]['code'] = $row->product_code;
                $data[$row->product_id]['name'] = $row->product_name;
                $data[$row->product_id]['wh'][$row->warehouse_id] = $row->quantity;
                
            }//end foreach.
             return $data;
        }//end if.
        
        return false;
    }
    
    public function getSalesItems($start_date=NULL , $end_date=NULL, $warehouse_id)
    {
        $query = "SELECT  `product_id` ,`product_code` , `product_name` ,  `net_unit_price` , `product_unit_code` unit,
                    SUM(  `quantity` ) qty, SUM(  `item_tax` ) tax, tax as tax_rate, SUM(  `item_discount` ) discount, SUM(  `subtotal` ) total
                FROM  " . $this->db->dbprefix('sale_items') . "  
                WHERE  `sale_id` IN ( SELECT  `id`  FROM  " . $this->db->dbprefix('sales') . "  WHERE `date` BETWEEN '$start_date' AND '$end_date'  ) AND 
                    `warehouse_id` = '$warehouse_id' 
                GROUP BY `product_code` 
                ORDER BY `product_name` ";        
                    
        $q = $this->db->query($query, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    
    public function warehouseProductsStock($warehouse=NULL) {
        
        if($warehouse){
            $getwarehouse = str_replace("_",",", $warehouse);
            $where = " WHERE  wp.`warehouse_id` IN ({$getwarehouse})";//$warehouse' ";
        } else {
            $where = '';
        }
        
       $sql2 = "SELECT p.`name`, p.`code`, wp.`product_id`, wp.`warehouse_id`, w.`name` as warehouse, wp.`quantity` "
                        . "FROM `sma_warehouses_products` wp "
                        . "RIGHT JOIN `sma_products` p ON wp.`product_id` = p.`id` "
                        . "RIGHT JOIN `sma_warehouses` w ON wp.`warehouse_id` = w.`id` "
                        . $where 
                        . "GROUP BY wp.`warehouse_id`, wp.`product_id` "
                        . "ORDER BY p.`name`, wp.`warehouse_id`";
            
            $qp = $this->db->query($sql2);        
                    
            $nump = $qp->num_rows();
            
            if($nump > 0)
            { 
                $ws = $wps = [];
                foreach($qp->result() as $wp){
                    
                     $wps[$wp->product_id]['wpq'][$wp->warehouse_id] = $wp->quantity;
                     $wps[$wp->product_id]['name'] = $wp->name;
                     $wps[$wp->product_id]['code'] = $wp->code;
                     
                     if(!in_array($wp->warehouse, $ws)) {
                        $ws[$wp->warehouse_id] = $wp->warehouse;
                     }
                }//end foreach.
                $data['products']  = $wps;
                $data['warehouse'] = $ws;                
                return $data;
            }//end num
        return false;
    }
    
    /*--- 13-03-19  ---*/
   public function getreport($start_date,$end_date,$condition,$warehouse){
            
        $sql = "SELECT w.`id` as warehouse_id,  w.`name` as warehouse ,sum(s.`grand_total`) as total, sum(s.`total_discount`) as total_discount 
                    FROM `sma_sales` s 
                    LEFT JOIN `sma_warehouses` w on s.`warehouse_id` = w.`id`
                    ";
//             
//                    LEFT JOIN `sma_sale_items` si ON si.sale_id = s.id 
            $where = '';
           
            if($start_date)
            {
                
                
                $gettime = substr($end_date,-5);

                $end_date = str_replace($gettime,"23.59",$end_date);
                $where = "  WHERE date BETWEEN '$start_date' AND '$end_date' ";
            }
                if($condition=='due'){
              $where .= " AND payment_status = 'due'";
            }elseif($condition=='return'){
                $where .= " AND sale_status = 'returned' ";
            }   

             if($warehouse){
                $where .=" AND s.`warehouse_id` = ".$warehouse;
              }
            $sql .= $where ;
            
            $q = $this->db->query($sql);
        return $q->row();
    }
    public function getSaleBySalesPerson($Customer){
		$Sql = "SELECT s.id, DATE_FORMAT(s.date, '%Y-%m-%d %T') as date, s.reference_no, s.biller, c.name as seller, s.customer, s.sale_status, (s.grand_total+s.rounding) as grand_total, s.paid, (s.grand_total+s.rounding-s.paid) as balance, s.payment_status, s.attachment, s.return_id, s.delivery_status, c.email as cemail FROM sma_sales as s inner join sma_companies c on c.id=s.seller_id  WHERE 1 and s.seller_id=$Customer ";
		$Res = $this->db->query($Sql);
		return $Res->result_array();
	}
    public function getSaleItemsBySalesPerson($Customer){
		/*$Sql = "SELECT c.name as seller, si.product_code, si.product_name, sum(si.quantity) as tot_qty,  sum(si.net_price) as tot_net_price FROM sma_companies c inner join sma_sales s on c.id=s.seller_id inner join `sma_sale_items` si on s.id=si.`sale_id` WHERE s.seller_id=$Customer group by si.product_id";*/

$Sql = "SELECT c.name as seller, si.product_code, si.product_name, sum(si.quantity) as tot_qty,  sum(si.unit_price) as tot_net_price FROM sma_companies c inner join sma_sales s on c.id=s.seller_id inner join `sma_sale_items` si on s.id=si.`sale_id` WHERE s.seller_id=$Customer group by si.product_id";
		$Res = $this->db->query($Sql);
		return $Res->result_array();
	}




     public function getDailyPurchaseItems($date)
    {
        $query = "SELECT  `product_id` ,`product_code` ,  `product_name` ,  `net_unit_cost` , `product_unit_code` unit,
                    SUM(  `quantity` ) qty, SUM(  `item_tax` ) tax, tax as tax_rate, SUM(  `item_discount` ) discount, SUM(  `subtotal` ) total
                FROM  " . $this->db->dbprefix('purchase_items') . "  
                WHERE  `purchase_id` IN ( SELECT  `id`  FROM  " . $this->db->dbprefix('purchases') . "  WHERE DATE( `date` ) =  '$date' )
                GROUP BY  `product_code` 
                ORDER BY  `product_name` ";        
                    
        $q = $this->db->query($query, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
        public function count_product_varient_data($Data, $search = '') {
        //inner join sma_warehouses_products_variants wpv on p.id=wpv.product_id
        $Sql = "select count(Distinct spv.product_id) AS num from sma_products p inner join sma_product_variants spv on p.id = spv.product_id  ";
        if ($Data['warehouse'])
            $Sql .= " inner join sma_warehouses_products swp on swp.product_id=p.id ";
        $BJoin = ' left ';
        if ($Data['brand'])
            $BJoin = ' inner ';
        $Sql .= " inner join sma_categories c on p.category_id=c.id $BJoin join sma_brands b on b.id=p.brand where 1 ";
        if (isset($search['value'])) {
            if ($search['value'] != '') {
                $Sql .= "  and (p.name like '%" . $search['value'] . "%' or p.code like '%" . $search['value'] . "%' or c.name like '%" . $search['value'] . "%' or b.name like '%" . $search['value'] . "%' or spv.name like '%" . $search['value'] . "%') ";
            }
        }
        if ($Data['warehouse'])
            $Sql .= " and swp.warehouse_id=" . $Data['warehouse'];
        if ($Data['category'])
            $Sql .= " and p.category_id=" . $Data['category'];
        if ($Data['brand'])
            $Sql .= " and p.brand=" . $Data['brand'];
		$Variant = $this->site->showVariantFilter();
		if($Data['Type']!='')
			$Sql .= " and spv.name in (".$Variant.")";
        $Sql .= " order by p.name desc ";
        $Query = $this->db->query($Sql);
        $result = $Query->result_array();
        return $result[0]['num'];
    }

    function load_product_varient_data($Data, $startpoint = '', $per_page = '', $search = '') {
        //select p.id as product_id, p.name, p.code, c.name as cat_name, b.name as brand_name, p.quantity as qty, (p.quantity * p.cost) as product_cost, swp.quantity from sma_products p inner join sma_product_variants spv on p.id = spv.product_id inner join sma_warehouses_products_variants wpv on p.id=wpv.product_id left join sma_warehouses_products swp on swp.product_id=p.id left join sma_categories c on p.category_id=c.id left join sma_brands b on b.id=p.brand where swp.warehouse_id=1 and p.id='682' group by wpv.product_id order by p.name desc
        // $query = "select p.id as product_id, p.name, p.code, c.name as cat_name, b.name as brand_name, p.quantity as qty, (p.quantity * p.cost) as product_cost from sma_products p inner join sma_product_variants spv on p.id = spv.product_id inner join sma_warehouses_products_variants wpv on p.id=wpv.product_id left join sma_categories c on p.category_id=c.id left join sma_brands b on b.id=p.brand ";
        $query = "select p.id as product_id, p.name, p.code, c.name as cat_name, b.name as brand_name, p.quantity as qty ";
        if ($Data['warehouse'])
            $query .= " ,swp.quantity as wh_qty, (swp.quantity * p.cost) as product_cost ";
        else
            $query .= " ,(p.quantity * p.cost) as product_cost ";
        $query .= " from sma_products p inner join sma_product_variants spv on p.id = spv.product_id ";
        if ($Data['warehouse'])
            $query .= " inner join sma_warehouses_products swp on swp.product_id=p.id ";

        $BJoin = ' left ';
        if ($Data['brand'])
            $BJoin = ' inner ';
        $query .= " inner join sma_categories c on p.category_id=c.id $BJoin join sma_brands b on b.id=p.brand where 1 ";
        if ($Data['warehouse'])
            $query .= " and swp.warehouse_id=" . $Data['warehouse'];
        if ($Data['category'])
            $query .= " and p.category_id=" . $Data['category'];
        if ($Data['brand'])
            $query .= " and p.brand=" . $Data['brand'];
        if (isset($search['value'])) {
            if ($search['value'] != '') {
                $query .= " and (p.name like '%" . $search['value'] . "%' or p.code like '%" . $search['value'] . "%' or c.name like '%" . $search['value'] . "%' or b.name like '%" . $search['value'] . "%' or spv.name like '%" . $search['value'] . "%') ";
            }
        }
		$Variant = $this->site->showVariantFilter();
		if($Data['Type']!='')
			$query .= " and spv.name in (".$Variant.")";
        $query .= " group by spv.product_id order by p.name desc ";
        if ($Data['v'] == 'export') {
            $startpoint = $Data['start'];
            $per_page = $Data['limit'];
            $query .= " LIMIT {$startpoint} , {$per_page}";
        } else {
            if ($startpoint != '') {
                $query .= " LIMIT {$startpoint} , {$per_page}";
            } else {
                $query .= " ";
            }
        }
        //echo $query; exit;
        return $result = $this->db->query($query);
    }

    function max_varient_count($Type='') {
		$Variant = $this->site->showVariantFilter();
		if($Type!='')
			$whr = " and name in (".$Variant.")";
        $Sql = "SELECT MAX(count_product_id) as max_varient_count FROM (SELECT product_id, COUNT(*) AS count_product_id FROM sma_product_variants where 1 $whr GROUP BY product_id) AS Results";
        $Query = $this->db->query($Sql);
        $result = $Query->result_array();
        return $result[0]['max_varient_count'];
    }

    public function count_product_varient_sale_data($Data, $search = '') {
        //inner join sma_warehouses_products_variants wpv on p.id=wpv.product_id
        $Sql = "select count(Distinct spv.product_id) AS num from sma_products p inner join sma_product_variants spv on p.id = spv.product_id inner join sma_sale_items ssi on spv.id=ssi.option_id inner join sma_sales s on s.id=ssi.sale_id ";
        //if($Data['warehouse'])
        //$Sql .= " inner join sma_warehouses_products swp on swp.product_id=p.id ";
        $BJoin = ' left ';
        if ($Data['brand'])
            $BJoin = ' inner ';
        $Sql .= " inner join sma_categories c on p.category_id=c.id $BJoin join sma_brands b on b.id=p.brand where 1 ";
        if (isset($search['value'])) {
            if ($search['value'] != '') {
                $Sql .= "  and (p.name like '%" . $search['value'] . "%' or p.code like '%" . $search['value'] . "%' or c.name like '%" . $search['value'] . "%' or b.name like '%" . $search['value'] . "%' or spv.name like '%" . $search['value'] . "%') ";
            }
        }
        if ($Data['warehouse'])
            $Sql .= " and ssi.warehouse_id=" . $Data['warehouse'];
        if ($Data['category'])
            $Sql .= " and p.category_id=" . $Data['category'];
        if ($Data['brand'])
            $Sql .= " and p.brand=" . $Data['brand'];

        if ($Data['start_date']) {
            $Sql .= " and DATE(s.date) BETWEEN '" . $Data['start_date'] . "' and '" . $Data['end_date'] . "'";
        }
		$Variant = $this->site->showVariantFilter();
		if($Data['Type']!='')
			$Sql .= " and spv.name in (".$Variant.")";
        $Sql .= " order by p.name desc ";
        $Query = $this->db->query($Sql);
        $result = $Query->result_array();
        return $result[0]['num'];
    }

    function load_product_varient_sale_data($Data, $startpoint = '', $per_page = '', $search = '') {
        $query = "select p.id as product_id, p.name, p.code, c.name as cat_name, b.name as brand_name, p.quantity as qty, (p.quantity * p.cost) as product_cost ";
        $query .= " from sma_products p inner join sma_product_variants spv on p.id = spv.product_id inner join sma_sale_items ssi on spv.id=ssi.option_id inner join sma_sales s on s.id=ssi.sale_id ";
        //if($Data['warehouse'])
        //$query .= " inner join sma_warehouses_products swp on swp.product_id=p.id ";
        $BJoin = ' left ';
        if ($Data['brand'])
            $BJoin = ' inner ';
        $query .= " inner join sma_categories c on p.category_id=c.id $BJoin join sma_brands b on b.id=p.brand where 1 ";
        if ($Data['warehouse'])
            $query .= " and ssi.warehouse_id=" . $Data['warehouse'];
        if ($Data['category'])
            $query .= " and p.category_id=" . $Data['category'];
        if ($Data['brand'])
            $query .= " and p.brand=" . $Data['brand'];
        if ($Data['start_date']) {
            $query .= " and DATE(s.date) BETWEEN '" . $Data['start_date'] . "' and '" . $Data['end_date'] . "'";
        }
        if (isset($search['value'])) {
            if ($search['value'] != '') {
                $query .= " and (p.name like '%" . $search['value'] . "%' or p.code like '%" . $search['value'] . "%' or c.name like '%" . $search['value'] . "%' or b.name like '%" . $search['value'] . "%' or spv.name like '%" . $search['value'] . "%') ";
            }
        }
		$Variant = $this->site->showVariantFilter();
		if($Data['Type']!='')
			$query .= " and spv.name in (".$Variant.")";
        $query .= " group by spv.product_id order by p.name desc ";
        if ($Data['v'] == 'export') {
            $startpoint = $Data['start'];
            $per_page = $Data['limit'];
            $query .= " LIMIT {$startpoint} , {$per_page}";
        } else {
            if ($startpoint != '') {
                $query .= " LIMIT {$startpoint} , {$per_page}";
            } else {
                $query .= " ";
            }
        }
        //echo $query; exit;
        return $result = $this->db->query($query);
    }

    function getVarientName($Type='') {
        $this->db->select('id, name');
        $this->db->order_by('ABS(name)', 'asc');
        $this->db->group_by('name');
		if($Type!='')
		$this->db->where_in('name',['S', 'M', 'L', 'XL', '2XL', '3XL', '4XL', '5XL']);
        $q = $this->db->get('sma_product_variants');
        return $q->result_array();
        //SELECT * FROM `sma_product_variants` WHERE 1 group by name ORDER BY ABS(name) asc
    }
    
    /*** Report payment Summary  **/
        
     /**
      * 
      * @param type $start_date
      * @param type $end_date
      * @param type $type
      * @param type $user
      * @return type
      */   
    public function payment_summary($start_date, $end_date ,$type , $user, $warehouse ){
        $this->db->select(' DATE_FORMAT(sma_payments.date, "%Y-%m-%d") as date, sum(sma_payments.amount) as Total, sma_payments.type');
        if($start_date && $end_date ){
            $this->db->where('sma_payments.date '.' BETWEEN "' . $start_date . '" and "' . $end_date . '"');
        }
        
        if(isset($type)){
           $this->db->where('sma_payments.type',$type); 
        }
        
        if(isset($user)){
            $this->db->where('sma_payments.created_by',$user); 
        }
        
        
        if(isset($warehouse)){
            $this->db->join('sma_sales','sma_sales.id = sma_payments.sale_id');
            $this->db->where('sma_sales.warehouse_id',$warehouse);
        }
        $payment_summary= $this->db->group_by('DATE_FORMAT(sma_payments.date, "%Y-%m-%d"),sma_payments.type')->get('sma_payments')->result();
        
        return $payment_summary;
    }   
    /**
     * 
     * @param type $date
     * @param type $type
     * @return type
     */
     public function payment_type($date,$type){
        
        $payment_type = $this->db->select('sum(amount) as '.$type)
                ->where('type',$type)
                ->where('Date(date)',$date)
                ->group_by('DATE(date)')->get('sma_payments')->row();
        
        return $payment_type;
    } 
 
    /**
     * 
     * @param type $option
     * @param type $date
     * @param type $type
     * @return type
     */
    public function getoptionpayment($option, $date, $type, $user, $warehouse ){
        $this->db->select('sum(sma_payments.amount) as '.$option.' ');
        if(isset($date)){
            $this->db->where('Date(sma_payments.date)',$date.'%');
        }   
        
        if(isset($option)){
            $this->db->where('sma_payments.paid_by',$option);
        }
        
        if(isset($type)){
            $this->db->where('sma_payments.type',$type);
        }
        
         if(isset($user)){
            $this->db->where('sma_payments.created_by',$user); 
        }
        
        
        if(isset($warehouse)){
            $this->db->join('sma_sales','sma_sales.id = sma_payments.sale_id');
            $this->db->where('sma_sales.warehouse_id',$warehouse);
        }        
                
        $data = $this->db->get('sma_payments')->row(); 

     return $data;
    }
    
    /**
     * 
     * @param type $option
     * @param type $type
     * @param type $start_date
     * @param type $end_date
     * @param type $users
     * @param type $warehouse
     * @return type
     */
    public function  getTotal($option ,  $type, $start_date, $end_date , $users , $warehouse  ){
         $this->db->select('sum(sma_payments.amount) as '.$option.' ');
         if(isset($option)){
            $this->db->where('sma_payments.paid_by',$option);
         }
         
         if(isset($type)){
              $this->db->where('sma_payments.type',$type);
         }
         
         if($start_date && $end_date ){
             $this->db->where('sma_payments.date '.' BETWEEN "' . $start_date . '" and "' . $end_date . '"');
         }
         
         if(isset($users)){
             $this->db->where('sma_payments.created_by',$users);
         }
        
        if(isset($warehouse)){
            $this->db->join('sma_sales','sma_sales.id = sma_payments.sale_id');
            $this->db->where('sma_sales.warehouse_id',$warehouse);
        }
                
         
        $data =  $this->db->get('sma_payments')->row(); 
//     
//     print_r($this->db->last_query());
     return $data;
    }

    /**
     * 
     * @return type
     */
    public function payment_option(){
        
        $getpayment_option =  $this->db->select('authorize,instamojo,ccavenue,paytm,credit_card as CC,debit_card as DC,gift_card,neft as NEFT,google_pay as Googlepay,swiggy,zomato,ubereats,complimentary as complimentry,paynear as paynear,payumoney,stripe')->get('sma_pos_settings')->row_array();
        $optionvalue= 'cash,Cheque,deposit,other,';
        foreach($getpayment_option as $key => $option ){
           
            if($option){
                $optionvalue.= $key.',';
            }
        }
        
        $payment_option = explode(",",$optionvalue);
        
       return array_filter($payment_option);
    }
    
    /*** End Report payment Summary  **/
        
    /**
     * This method using get payment option
     * @param type $sales_id
     * @return type
     */
    public function getpaymentmode($sales_id = null){
        $getoption = $this->db->select(' GROUP_CONCAT(DISTINCT  paid_by) as paid_by')
                ->where(['sale_id' => $sales_id])
                ->get('sma_payments')->row();
        
        return $getoption->paid_by;
    }
    /** End get payment option **/

    /* Tax CGST SGST IGST*/
    public function gettaxitemid($item_id)
    {
         
                $qry = "SELECT (SELECT attr_per FROM  " . $this->db->dbprefix('sales_items_tax') . "  WHERE `attr_code` = 'CGST' AND  item_id ='$item_id' ) AS CGST ,(SELECT attr_per FROM  " . $this->db->dbprefix('sales_items_tax') . "  WHERE `attr_code` = 'SGST' AND item_id ='$item_id') AS SGST ,(SELECT attr_per FROM  " . $this->db->dbprefix('sales_items_tax') . "  WHERE `attr_code` = 'IGST' AND  item_id ='$item_id' ) AS IGST FROM  " . $this->db->dbprefix('sales_items_tax') . "  WHERE   item_id ='$item_id' Group By item_id";
                $sqlrs = $this->db->query($qry, false);
                if ($sqlrs->num_rows() > 0) {
                  foreach (($sqlrs->result()) as $row_rs) {
                    $data[] = $row_rs;
                  }
                return $data;
                }
        return FALSE;
    }
    
    
    /*11-23-2019 Purchase Item Teax*/
    public function getDailyPurchaseItemsTaxes($date)
    {
       
        $query = "SELECT sum(`tax_amount`) amount, ( `attr_per` * 2) as rate,item_id
            FROM  " . $this->db->dbprefix('purchase_items_tax') . " 
            WHERE `purchase_id` IN ( SELECT  `id`  FROM  " . $this->db->dbprefix('purchases') . "  WHERE DATE( `date` ) =  '$date' ) 
            AND `attr_per` > 0 GROUP BY `attr_per` ORDER BY `attr_per` ASC ";        
                      
        $q = $this->db->query($query, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
              
            } 
            
            return $data;
        }
        return FALSE;
    }
    
    public function getMonthPurchaseItemsTaxes($month,$year)
    {
        $query = "SELECT sum(`tax_amount`) amount, ( `attr_per` * 2) as rate,item_id 
            FROM  " . $this->db->dbprefix('purchase_items_tax') . " 
            WHERE `purchase_id` IN ( SELECT  `id`  FROM  " . $this->db->dbprefix('purchases') . "  WHERE  DATE_FORMAT( date,  '%c' ) =  '{$month}' AND  DATE_FORMAT( date,  '%Y' ) =  '{$year}' ) 
            AND `attr_per` > 0 GROUP BY `attr_per` ORDER BY `attr_per` ASC ";        
                    
        $q = $this->db->query($query, false);
        if ($q->num_rows() > 0) {
            foreach (($q->result()) as $row) {
                $data[] = $row;
            }
            return $data;
        }
        return FALSE;
    }
    
    /* Tax Purchase CGST SGST IGST*/
    public function getpurchasetaxitemid($item_id)
    {
        $qry = "SELECT (SELECT attr_per FROM  " . $this->db->dbprefix('purchase_items_tax') . "  WHERE `attr_code` = 'CGST' AND  item_id ='$item_id' ) AS CGST ,(SELECT attr_per FROM  " . $this->db->dbprefix('purchase_items_tax') . "  WHERE `attr_code` = 'SGST' AND item_id ='$item_id') AS SGST ,(SELECT attr_per FROM  " . $this->db->dbprefix('purchase_items_tax') . "  WHERE `attr_code` = 'IGST' AND  item_id ='$item_id' ) AS IGST FROM  " . $this->db->dbprefix('purchase_items_tax') . "  WHERE   item_id ='$item_id' Group By item_id";
        $sqlrs = $this->db->query($qry, false);
            if ($sqlrs->num_rows() > 0) {
                foreach (($sqlrs->result()) as $row_rs) {
                   $data[] = $row_rs;
                }
                return $data;
            }
        return FALSE;
    }
    //26-09-2020
		public function count_product_varient_purchase_data($Data, $search = '') {
        //inner join sma_warehouses_products_variants wpv on p.id=wpv.product_id
        $Sql = "select count(Distinct spv.product_id) AS num from sma_products p inner join sma_product_variants spv on p.id = spv.product_id inner join sma_purchase_items ssi on spv.id=ssi.option_id inner join sma_purchases s on s.id=ssi.purchase_id ";
        //if($Data['warehouse'])
        //$Sql .= " inner join sma_warehouses_products swp on swp.product_id=p.id ";
        $BJoin = ' left ';
        if ($Data['brand'])
            $BJoin = ' inner ';
        $Sql .= " inner join sma_categories c on p.category_id=c.id $BJoin join sma_brands b on b.id=p.brand where 1 ";
        if (isset($search['value'])) {
            if ($search['value'] != '') {
                $Sql .= "  and (p.name like '%" . $search['value'] . "%' or p.code like '%" . $search['value'] . "%' or c.name like '%" . $search['value'] . "%' or b.name like '%" . $search['value'] . "%' or spv.name like '%" . $search['value'] . "%') ";
            }
        }
        if ($Data['warehouse'])
            $Sql .= " and ssi.warehouse_id=" . $Data['warehouse'];
        if ($Data['category'])
            $Sql .= " and p.category_id=" . $Data['category'];
        if ($Data['brand'])
            $Sql .= " and p.brand=" . $Data['brand'];

        if ($Data['start_date']) {
            $Sql .= " and DATE(s.date) BETWEEN '" . $Data['start_date'] . "' and '" . $Data['end_date'] . "'";
        }
		$Variant = $this->site->showVariantFilter();
		if($Data['Type']!='')
			$Sql .= " and spv.name in (".$Variant.")";
        $Sql .= " order by p.name desc ";
        $Query = $this->db->query($Sql);
        $result = $Query->result_array();
        return $result[0]['num'];
    }
	function load_product_varient_purchase_data($Data, $startpoint = '', $per_page = '', $search = '') {
        $query = "select p.id as product_id, p.name, p.code, c.name as cat_name, b.name as brand_name, p.quantity as qty, (p.quantity * p.cost) as product_cost ";
        $query .= " from sma_products p inner join sma_product_variants spv on p.id = spv.product_id inner join sma_purchase_items ssi on spv.id=ssi.option_id inner join sma_purchases s on s.id=ssi.purchase_id ";
        //if($Data['warehouse'])
        //$query .= " inner join sma_warehouses_products swp on swp.product_id=p.id ";
        $BJoin = ' left ';
        if ($Data['brand'])
            $BJoin = ' inner ';
        $query .= " inner join sma_categories c on p.category_id=c.id $BJoin join sma_brands b on b.id=p.brand where 1 ";
        if ($Data['warehouse'])
            $query .= " and ssi.warehouse_id=" . $Data['warehouse'];
        if ($Data['category'])
            $query .= " and p.category_id=" . $Data['category'];
        if ($Data['brand'])
            $query .= " and p.brand=" . $Data['brand'];
        if ($Data['start_date']) {
            $query .= " and DATE(s.date) BETWEEN '" . $Data['start_date'] . "' and '" . $Data['end_date'] . "'";
        }
        if (isset($search['value'])) {
            if ($search['value'] != '') {
                $query .= " and (p.name like '%" . $search['value'] . "%' or p.code like '%" . $search['value'] . "%' or c.name like '%" . $search['value'] . "%' or b.name like '%" . $search['value'] . "%' or spv.name like '%" . $search['value'] . "%') ";
            }
        }
		$Variant = $this->site->showVariantFilter();
		if($Data['Type']!='')
			$query .= " and spv.name in (".$Variant.")";
        $query .= " group by spv.product_id order by p.name desc ";
        if ($Data['v'] == 'export') {
            $startpoint = $Data['start'];
            $per_page = $Data['limit'];
            $query .= " LIMIT {$startpoint} , {$per_page}";
        } else {
            if ($startpoint != '') {
                $query .= " LIMIT {$startpoint} , {$per_page}";
            } else {
                $query .= " ";
            }
        }
        //echo $query; exit;
        return $result = $this->db->query($query);
    }
	//26-09-2020

}
