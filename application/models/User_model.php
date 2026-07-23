<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class User_model extends MY_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'users';
		$this->_roles_table = 'roles';
		$this->_user_roles_table = 'user_roles';
	}

	/**
	* Authenticate user.
	* 
	* @param array $data
	* @return type 
	*/
	public function authenticate(array $data)
	{ 
		$query = $this->db->get_where($this->_table, array('email' => $data['email'], 'password' => $data['password'], 'status'=>'active'));
		$user_id = 0;
		$is_valid = ($query->num_rows() > 0);
		if ($is_valid == TRUE)
		{ 
			$user_id = $query->row()->id; 
			$this->update_last_logged_in($user_id);
			$this->update_last_ip($user_id);
		}
		
		return $user_id;
	}

	/**
	* Update last_logged_in column for user.
	* 
	* @param type $user_id
	* @return type 
	*/
	public function update_last_logged_in($user_id)
	{
		$now = date('Y-m-d H:i:s');
		$this->db->update($this->_table, array('last_logged_in' => $now), array('id' => $user_id));
		
		return $user_id;
	}

	/**
	* Update last_ip column for user.
	* 
	* @param type $user_id
	* @return type 
	*/
	public function update_last_ip($user_id)
	{
		$this->db->update($this->_table, array('last_ip' => $this->input->ip_address()), array('id' => $user_id));
		
		return $user_id;
	}

	public function find_by_id($id)
	{
		$q = $this->db->get_where($this->_table, array('id' => $id));
		return $q->row();
	}

	public function get_user_roles($user_id) {
        $this->db->select('roles.*');
        $this->db->from('user_roles');
        $this->db->join('roles', 'user_roles.role_id = roles.id');
        $this->db->where('user_roles.user_id', $user_id);
        $query = $this->db->get();

        return $query->result();
    }

    public function getAllUserDetails() {
        $where = array("$this->_table.status" => 'active');
        $select = "$this->_table.id,$this->_table.entry_date,$this->_roles_table.name as role,$this->_table.username,$this->_table.first_name,$this->_table.last_name,$this->_table.email,$this->_table.remarks,$this->_table.status";
        $this->db->select($select)->from($this->_table)->join($this->_user_roles_table, "$this->_user_roles_table.user_id=$this->_table.id", 'inner')->join($this->_roles_table, "$this->_roles_table.id=$this->_user_roles_table.role_id", 'inner')->where($where)->order_by('id','ASC');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function getUserDetails($user_id) {
        $where = array("$this->_table.id" => $user_id, "$this->_table.status" => 'active');
        $select = "$this->_table.id,$this->_table.entry_date,$this->_roles_table.name as role,$this->_table.username,$this->_table.first_name,$this->_table.last_name,$this->_table.email,$this->_table.phone,$this->_table.city,$this->_table.address,$this->_table.profile_pic,$this->_table.state,$this->_table.remarks,$this->_table.status,$this->_user_roles_table.role_id";
        $this->db->select($select)->from($this->_table)->join($this->_user_roles_table, "$this->_user_roles_table.user_id=$this->_table.id", 'inner')->join($this->_roles_table, "$this->_roles_table.id=$this->_user_roles_table.role_id", 'inner')->where($where)->order_by('id','ASC');
        $result = $this->db->get()->row_array();
        return $result;
    }
}