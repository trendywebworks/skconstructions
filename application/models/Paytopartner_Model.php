<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Paytopartner_Model extends MY_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'pay_partner';
		$this->_partner_table = 'partners';
	}

	public function getAllPayList()
	{
		$where = array("$this->_table.status !=" => 'deleted');
		$select = "$this->_table.id,$this->_table.created_at,$this->_table.entry_date,$this->_partner_table.full_name as partner_name, CONCAT('₹', format($this->_table.amount,0)) as amount,$this->_table.pay_for,$this->_table.pay_type,$this->_table.status,$this->_table.remarks";
		$result = $this->db->select($select)->from($this->_table)->join($this->_partner_table, "$this->_partner_table.id=$this->_table.p_id", 'inner')->where($where)->order_by('id','DESC')->get();
		return $result->result_array();
	}

	public function getAllPayListById($id)
	{
		$where = array("$this->_table.status !=" => 'deleted', "$this->_table.id" => $id);
		$select = "$this->_table.id,$this->_table.created_at,$this->_table.entry_date,$this->_partner_table.full_name as partner_name, CONCAT('₹', format($this->_table.amount,0)) as amount,$this->_table.pay_for,$this->_table.pay_type,$this->_table.status,$this->_table.remarks";
		$result = $this->db->select($select)->from($this->_table)->join($this->_partner_table, "$this->_partner_table.id=$this->_table.p_id", 'inner')->where($where)->order_by('id','DESC')->get();
		return $result->row_array();
	}

}