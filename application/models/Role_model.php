<?php
class Role_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
        $this->_table = 'roles';
        $this->_role_permissions_table = 'role_permissions';
        $this->_permissions_table = 'permissions';
    }
    
    public function get_role_by_id($role_id) {
        return $this->db->get_where('roles', array('id' => $role_id))->row();
    }

    public function has_permission($role_id, $permission_name) {
        $this->db->select('*');
        $this->db->from('role_permissions');
        $this->db->join('permissions', 'role_permissions.permission_id = permissions.id');
        $this->db->where('role_permissions.role_id', $role_id);
        $this->db->where('permissions.name', $permission_name);
        $query = $this->db->get();

        return $query->num_rows() > 0;
    }

    public function permission_exists($permission_name)
    {
        $this->db->select('*');
        $this->db->from('permissions');
        $this->db->where('permissions.name', $permission_name);
        $query = $this->db->get();

        return $query->num_rows() > 0;
    }

    public function getRolePermissions($role_id) {
        $where = array("$this->_table.id" => $role_id, "$this->_table.status" => 'active');
        $select = "$this->_table.id,$this->_table.entry_date,$this->_table.name,$this->_role_permissions_table.permission_id";
        $this->db->select($select)->from($this->_table)->join($this->_role_permissions_table, "$this->_role_permissions_table.role_id=$this->_table.id", 'left')->where($where)->order_by('id','ASC');
        $result = $this->db->get()->result_array();
        return $result;
    }

    public function getRolePermissionsName($role_id) {
        $where = array("$this->_table.id" => $role_id, "$this->_table.status" => 'active');
        $select = "$this->_table.id,$this->_table.entry_date,$this->_table.name,$this->_role_permissions_table.permission_id,$this->_permissions_table.name as role_name";
        $this->db->select($select)->from($this->_table)->join($this->_role_permissions_table, "$this->_role_permissions_table.role_id=$this->_table.id", 'inner')->join($this->_permissions_table, "$this->_permissions_table.id=$this->_role_permissions_table.permission_id", 'inner')->where($where)->order_by('id','ASC');
        $result = $this->db->get()->result_array();
        return $result;
    }
    
}
?>
