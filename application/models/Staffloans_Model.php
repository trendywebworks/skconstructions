<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Staffloans_Model extends MY_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'staff_loans';
		$this->_staff_table = 'office_staffs';
	}

	public function getAllStaffLoansList()
	{
		$where = array("$this->_table.status != " => 'deleted');
		$select = "$this->_table.id,$this->_table.created_at,$this->_table.entry_date,$this->_staff_table.name as employee_name, CONCAT('₹', format(loan_amount,2)),DATE_FORMAT($this->_table.created_at,'%d/%m/%Y') as loan_date,CONCAT(loan_tenure, ' Month(s)') as loan_tenure,DATE_FORMAT($this->_table.loan_last_date,'%d/%m/%Y'),$this->_table.status,$this->_table.remarks";
		$result = $this->db->select($select)->from($this->_table)->join($this->_staff_table, "$this->_staff_table.id=$this->_table.employee_id", 'inner')->where($where)->order_by('id','DESC')->get();
		return $result->result_array();
	}

	public function getAllStaffLoansListById($id)
	{
		$where = array("$this->_table.status != " => 'deleted', "$this->_table.id" => $id);
		$select = "$this->_table.id,$this->_table.created_at,$this->_table.entry_date,$this->_staff_table.name as employee_name, CONCAT('₹', format(loan_amount,2)) as loan_amount,DATE_FORMAT($this->_table.created_at,'%d/%m/%Y') as loan_date,CONCAT(loan_tenure, ' Month(s)') as loan_tenure,DATE_FORMAT($this->_table.loan_last_date,'%d/%m/%Y') as loan_last_date,$this->_table.status,$this->_table.remarks";
		$result = $this->db->select($select)->from($this->_table)->join($this->_staff_table, "$this->_staff_table.id=$this->_table.employee_id", 'inner')->where($where)->order_by('id','DESC')->get();
		return $result->row_array();
	}

	public function getAllStaffHasLoan()
	{
		$where = array("$this->_table.status" => 'active');
		$select = "$this->_staff_table.id,$this->_staff_table.name as employee_name";
		$result = $this->db->select($select)->from($this->_table)->join($this->_staff_table, "$this->_staff_table.id=$this->_table.employee_id", 'inner')->where($where)->order_by('id','DESC')->group_by("$this->_staff_table.id")->get();
		return $result->result_array();
	}

	public function getAllStaffLoansSumByStaff($id)
	{
		$where = array("$this->_table.status" => 'active', "$this->_table.employee_id" => $id);
		$select = "$this->_table.id,$this->_table.created_at,$this->_table.entry_date,$this->_staff_table.name as employee_name, SUM(loan_amount) AS loan_amount, SUM(loan_amount) AS paid";
		$result = $this->db->select($select)->from($this->_table)->join($this->_staff_table, "$this->_staff_table.id=$this->_table.employee_id", 'inner')->where($where)->order_by('id','DESC')->group_by("$this->_staff_table.id")->get();
		return $result->row_array();
	}

}