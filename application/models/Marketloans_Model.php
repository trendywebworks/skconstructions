<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Marketloans_Model extends MY_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'market_loans';
		$this->_party_table = 'loan_party';
	}

	public function getAllMarketLoansList()
	{
		$where = array("$this->_table.status != " => 'deleted');
		$select = "$this->_table.id,$this->_table.created_at,$this->_table.entry_date,$this->_party_table.party_name as party_name, CONCAT('₹', format(loan_amount,2)),CONCAT(format(interest,2), '%'),total_installments,CONCAT('₹', format(total_amount,2)),$this->_table.status,$this->_table.remarks";
		$result = $this->db->select($select)->from($this->_table)->join($this->_party_table, "$this->_party_table.id=$this->_table.party_id", 'inner')->where($where)->order_by('id','DESC')->get();
		return $result->result_array();
	}

	public function getAllMarketLoansListById($id)
	{
		$where = array("$this->_table.status != " => 'deleted', "$this->_table.id" => $id);
		$select = "$this->_table.id,$this->_table.created_at,$this->_table.entry_date,$this->_party_table.party_name as party_name, CONCAT('₹', format(loan_amount,2)) as loan_amount,CONCAT(format(interest,2), '%') as interest,total_installments,CONCAT('₹', format(total_amount,2)) as total_amount,$this->_table.status,$this->_table.remarks";
		$result = $this->db->select($select)->from($this->_table)->join($this->_party_table, "$this->_party_table.id=$this->_table.party_id", 'inner')->where($where)->order_by('id','DESC')->get();
		return $result->row_array();
	}

}