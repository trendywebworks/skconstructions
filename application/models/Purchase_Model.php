<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Purchase_Model extends MY_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'purchase';
		$this->_purchase_details_table = 'purchase_details';
		$this->_suppliers_table = 'suppliers';
	}

	public function getAllPurchasesList($limit='')
	{
		$where = array("$this->_table.status != " => 'deleted');
		$select = "$this->_table.id,$this->_table.created_at,$this->_table.entry_date,$this->_suppliers_table.firm_name as firm_name,CONCAT('₹', FORMAT(SUM($this->_purchase_details_table.subtotal), 2)) AS bill_amount,CONCAT('₹', FORMAT(SUM($this->_purchase_details_table.gst_amount), 2)) AS gst_amount,
    CONCAT('₹', format(total_amount,2)) as total_amount,SUM($this->_purchase_details_table.quantity) AS quantity,DATE_FORMAT($this->_table.purchase_date,'%d/%m/%Y') as purchase_date,$this->_table.remarks,$this->_table.status";
		$this->db->select($select)->from($this->_table)->join($this->_suppliers_table, "$this->_suppliers_table.id=$this->_table.supplier_id", 'inner')->join($this->_purchase_details_table, "$this->_purchase_details_table.purchase_id=$this->_table.id", 'inner')->where($where)->order_by('id','DESC');
		if($limit !='')
		{
			$this->db->limit($limit);
		}
		$result = $this->db->get()->result_array();
		return $result;
	}

	public function getPurchaseDataRow($id)
	{
		$where = array("$this->_table.id" => $id, "$this->_table.status != " => 'deleted');
		$select = "$this->_table.*,$this->_table.status as pstatus,$this->_purchase_details_table.*";
		$result = $this->db->select($select)->from($this->_table)->join($this->_purchase_details_table, "$this->_purchase_details_table.purchase_id=$this->_table.id", 'inner')->where($where)->order_by("$this->_table.id",'DESC')->get();
		return $result->result_array();
	}

	public function getPurchaseDataById($id)
	{
		$where = array("$this->_table.id" => $id, "$this->_table.status != " => 'deleted');
		$select = "$this->_table.*,$this->_purchase_details_table.*,CONCAT($this->_suppliers_table.firm_name,'(',$this->_suppliers_table.contact_person,')') as supplier,$this->_table.status as pstatus";
		$result = $this->db->select($select)->from($this->_table)->join($this->_purchase_details_table, "$this->_purchase_details_table.purchase_id=$this->_table.id", 'inner')->join($this->_suppliers_table, "$this->_suppliers_table.id=$this->_table.supplier_id", 'inner')->where($where)->order_by("$this->_table.id",'DESC')->get();
		return $result->result_array();
	}

}