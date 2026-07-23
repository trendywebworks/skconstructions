<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Gstbill_Model extends MY_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'gst_bill';
		$this->_suppliers_table = 'suppliers';
	}

	public function getAllGstBillsList()//$this->_table.quantity,
	{
		$where = array("$this->_table.status != " => 'deleted');
		$select = "$this->_table.id,$this->_table.created_at,$this->_table.entry_date,$this->_suppliers_table.firm_name as firm_name,$this->_table.particular, CONCAT('₹', format(total_amount,2)) total_amount, CONCAT('₹', FORMAT(amount * quantity, 2)) AS bill_amount, $this->_table.entry_date as bill_date,,CONCAT(gst, '%'),CONCAT('₹', FORMAT((amount * quantity) * (gst / 100), 2)) AS gst_amount, $this->_table.remarks, $this->_table.status";
		$result = $this->db->select($select)->from($this->_table)->join($this->_suppliers_table, "$this->_suppliers_table.id=$this->_table.supplier_id", 'inner')->where($where)->order_by('id','DESC')->get();
		return $result->result_array();
	}

	public function getAllGstBillsListById($id)
	{
		$where = array("$this->_table.status != " => 'deleted', "$this->_table.id" => $id);
		$select = "$this->_table.id,$this->_table.created_at,$this->_table.entry_date,$this->_suppliers_table.firm_name as firm_name,$this->_table.particular,$this->_table.quantity, CONCAT('₹', format(amount,2)) as amount,CONCAT(gst, '%') as gst,CONCAT('₹', format(total_amount,2)) as total_amount,$this->_table.status,$this->_table.remarks";
		$result = $this->db->select($select)->from($this->_table)->join($this->_suppliers_table, "$this->_suppliers_table.id=$this->_table.supplier_id", 'inner')->where($where)->order_by('id','DESC')->get();
		return $result->row_array();
	}

}