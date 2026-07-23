<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class VehicleRunning_Model extends MY_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'vehicle_running_km';
		$this->_vehicle_table = 'vehicles';
	}

	public function getAllVehicleRunningKm()
	{
		$where = array("$this->_table.status != " => 'deleted');
		$select = "$this->_table.id,$this->_table.created_at,$this->_table.entry_date,$this->_vehicle_table.vehicle_name as vehicle_name,$this->_table.particular, CONCAT(
    '₹',
    FORMAT(
        COALESCE($this->_table.amount, 2) + COALESCE($this->_table.diesel_amount, 0),
    2)
) AS expenditure, CONCAT('₹', format($this->_table.income,0)) as income, CONCAT('₹', format($this->_table.balance,0)) as balance,$this->_table.remarks,$this->_table.status";
		$result = $this->db->select($select)->from($this->_table)->join($this->_vehicle_table, "$this->_vehicle_table.id=$this->_table.vehicle_id", 'inner')->where($where)->order_by('id','DESC')->get();
		return $result->result_array();
	}

	public function getAllVehicleRunningKmById($id)
	{
		$where = array("$this->_table.status != " => 'deleted', "$this->_table.id" => $id);
		$select = "$this->_table.id,$this->_table.created_at,$this->_table.entry_date,$this->_vehicle_table.vehicle_name as vehicle_name,$this->_vehicle_table.vehicle_no,$this->_table.party_name,$this->_table.start_km,$this->_table.end_km,$this->_table.total_km, $this->_table.particular,CONCAT('₹', format($this->_table.amount,0)) as amount, CONCAT('₹', format($this->_table.diesel_amount,0)) as diesel_amount, CONCAT('₹', format($this->_table.income,0)) as income, CONCAT('₹', format($this->_table.balance,0)) as balance,$this->_table.status,$this->_table.remarks";
		$result = $this->db->select($select)->from($this->_table)->join($this->_vehicle_table, "$this->_vehicle_table.id=$this->_table.vehicle_id", 'inner')->where($where)->order_by('id','DESC')->get();
		return $result->row_array();
	}
}