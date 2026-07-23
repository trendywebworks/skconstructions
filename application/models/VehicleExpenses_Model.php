<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class VehicleExpenses_Model extends MY_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'vehicle_expenses';
		$this->_vehicle_table = 'vehicles';
	}

	public function getAllVehicleExpenses()
	{
		$where = array("$this->_table.status != " => 'deleted');
		$select = "$this->_table.id,$this->_table.created_at,$this->_table.entry_date,$this->_vehicle_table.vehicle_name as vehicle_name, $this->_table.particular,CONCAT('₹', format(amount,0)),CONCAT('₹', format(income,0)),$this->_table.status,$this->_table.remarks";
		$result = $this->db->select($select)->from($this->_table)->join($this->_vehicle_table, "$this->_vehicle_table.id=$this->_table.vehicle_id", 'inner')->where($where)->order_by('id','DESC')->get();
		return $result->result_array();
	}

	public function getAllVehicleExpensesById($id)
	{
		$where = array("$this->_table.status != " => 'deleted', "$this->_table.id" => $id);
		$select = "$this->_table.id,$this->_table.created_at,$this->_table.entry_date,$this->_vehicle_table.vehicle_name as vehicle_name,$this->_vehicle_table.vehicle_no, $this->_table.particular,CONCAT('₹', format(amount,0)) as amount,CONCAT('₹', format(income,0)) as income,$this->_table.status,$this->_table.remarks";
		$result = $this->db->select($select)->from($this->_table)->join($this->_vehicle_table, "$this->_vehicle_table.id=$this->_table.vehicle_id", 'inner')->where($where)->order_by('id','DESC')->get();
		return $result->row_array();
	}

	public function getAllVehicleExpensesYearly()
	{
		$where = array("$this->_table.status != " => 'deleted');
		$select = "COALESCE(SUM(amount), 0) as total_veh_exp";
		$result = $this->db->select($select)->from($this->_table)->where($where)->where('YEAR(created_at)', date('Y'))->order_by('id','DESC')->get();
		return $result->row();
	}

}