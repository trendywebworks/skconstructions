<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Ccaccount_Model extends MY_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'cc_account';
		$this->_bank_table = 'banks';
	}

	public function getAllCCAccountList()
	{
		$where = array("$this->_table.status != " => 'deleted');
		$select = "$this->_table.id,$this->_table.created_at,$this->_table.entry_date,$this->_bank_table.bank_name as party_name, CONCAT('₹', format(loan_amount,0)),CONCAT(format(interest,0),'%'),CONCAT('₹', format(total_amount,0)),$this->_table.status,$this->_table.remarks";
		$result = $this->db->select($select)->from($this->_table)->join($this->_bank_table, "$this->_bank_table.id=$this->_table.bank_id", 'inner')->where($where)->order_by('id','DESC')->get();
		return $result->result_array();
	}

	public function getAllCCAccountListById($id)
	{
		$where = array("$this->_table.status != " => 'deleted', "$this->_table.id" => $id);
		$select = "$this->_table.id,$this->_table.created_at,$this->_table.entry_date,$this->_bank_table.bank_name as party_name, CONCAT('₹', format(loan_amount,0)) as loan_amount,CONCAT(format(interest,0),'%') as interest,CONCAT('₹', format(total_amount,0)) as total_amount,$this->_table.status,$this->_table.remarks";
		$result = $this->db->select($select)->from($this->_table)->join($this->_bank_table, "$this->_bank_table.id=$this->_table.bank_id", 'inner')->where($where)->order_by('id','DESC')->get();
		return $result->row_array();
	}

	public function getTotalAmount()
	{
		return $this->db->select("SUM(total_amount) as total_cc_loan")->from($this->_table)->where(array("$this->_table.status" => 'active'))->get()->row();
	}

}