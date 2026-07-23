<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Common_model extends MY_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->table_name = 'users';
	}

	public function is_logged_in()
  	{
    	$session_data = $this->session->all_userdata();
    	return (isset($session_data['user_id']) && $session_data['user_id'] > 0 && isset($session_data['logged_in']) && $session_data['logged_in'] == TRUE);
  	}

  	public function insert($table,$data)
	{
		$this->db->insert($table,$data);
		return $this->db->insert_id();
	}

	public function getAllWhereSelectList($table, $select, $where)
	{
		$result = $this->db->select($select)->from($table)->where($where)->order_by('id','DESC')->get();
		return $result->result_array();
	}

	public function getAllWhereSelectListOrderAsc($table, $select, $where)
	{
		$result = $this->db->select($select)->from($table)->where($where)->order_by('id','ASC')->get();
		return $result->result_array();
	}

	public function getAllWhereSelectListRow($table, $select, $where)
	{
		$result = $this->db->select($select)->from($table)->where($where)->get();
		return $result->row_array();
	}

	public function getWhereResult($table, $select, $where)
	{
		$result = $this->db->select($select)->from($table)->where($where)->get();
		return $result->result_array();
	}

	public function getWhereRow($table, $select, $where)
	{
		$result = $this->db->select($select)->from($table)->where($where)->get();
		return $result->row_array();
	}

	public function updateWhere($table,$id,$data)
	{
		$this->db->where($id);
		$this->db->update($table, $data);
		return true;
	}

	public function get_last_row($table, $orderby){
		$row = $this->db->select("*")->limit(1)->order_by($orderby,"DESC")->get($table)->row();
		return $row;
	}

	public function get_last_id($table, $orderby){
		$row = $this->db->select("*")->limit(1)->order_by($orderby,"DESC")->get($table);
		if($row->num_rows() > 0)
		{ 
			return $row->row()->id;
		}
		else
		{
			return 0;
		}
	}
}