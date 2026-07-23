<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Officeexpense_Model extends MY_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'office_expenses';
		$this->_expense_type_table = 'expense_type';
		$this->_office_staffs_table = 'office_staffs';
	}

	public function getAllOfficeExpensesList()
	{
		$where = array("$this->_table.status != " => 'deleted');
		$select = "$this->_table.id,$this->_table.created_at,$this->_table.entry_date,$this->_expense_type_table.expense_type as particular, CONCAT('₹', format(amount,0)),$this->_table.remarks";
		$result = $this->db->select($select)->from($this->_table)->join($this->_expense_type_table, "$this->_expense_type_table.id=$this->_table.expense_type_id", 'inner')->join($this->_office_staffs_table, "$this->_office_staffs_table.id=$this->_table.staff_id", 'inner')->where($where)->order_by('id','DESC')->get();
		return $result->result_array();
	}

	public function getAllOfficeExpensesListById($id)
	{
		$where = array("$this->_table.status != " => 'deleted', "$this->_table.id" => $id);
		$select = "$this->_table.id,$this->_table.created_at,$this->_table.entry_date,$this->_expense_type_table.expense_type as expense_name,$this->_office_staffs_table.name as staff_name, CONCAT('₹', format(amount,0)) as amount,$this->_table.status,$this->_table.remarks";
		$result = $this->db->select($select)->from($this->_table)->join($this->_expense_type_table, "$this->_expense_type_table.id=$this->_table.expense_type_id", 'inner')->join($this->_office_staffs_table, "$this->_office_staffs_table.id=$this->_table.staff_id", 'inner')->where($where)->order_by('id','DESC')->get();
		return $result->row_array();
	}

	public function getAllOfficeExpensesYearly()
	{
		$where = array("$this->_table.status" => 'active');
		$select = "COALESCE(SUM(amount), 0) as total_off_exp";
		$result = $this->db->select($select)->from($this->_table)->where($where)->where('YEAR(created_at)', date('Y'))->order_by('id','DESC')->get();
		return $result->row();
	}

}