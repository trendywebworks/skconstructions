<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Vehicles_Model extends MY_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'vehicles';
	}

	public function getAllVehicles()
	{
		$where = array("$this->_table.status != " => 'deleted');
		$select = "$this->_table.id,$this->_table.created_at,$this->_table.entry_date,$this->_table.vehicle_name as vehicle_name,$this->_table.vehicle_no, $this->_table.vehicle_purchase_by,CONCAT('₹', vehicle_emi) as vehicle_emi,CONCAT('₹', down_payment_amount) as down_payment_amount,CONCAT('₹', down_payment_by) as down_payment_by,$this->_table.status,$this->_table.remarks";
		$result = $this->db->select($select)->from($this->_table)->where($where)->order_by('id','DESC')->get();
		return $result->result_array();
	}

	public function getAllVehiclesById($id)
	{
		$where = array("$this->_table.status != " => 'deleted', "$this->_table.id" => $id);
		$select = "$this->_table.id,$this->_table.created_at,$this->_table.entry_date,$this->_table.vehicle_name as vehicle_name,$this->_table.vehicle_no, $this->_table.vehicle_purchase_by,CONCAT('₹', vehicle_emi) as vehicle_emi,CONCAT('₹', down_payment_amount) as down_payment_amount,CONCAT('₹', down_payment_by) as down_payment_by,$this->_table.status,$this->_table.remarks";
		$result = $this->db->select($select)->from($this->_table)->where($where)->order_by('id','DESC')->get();
		return $result->row_array();
	}
}