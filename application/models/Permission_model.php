<?php
class Permission_model extends CI_Model {
    
    public function __construct() {
        parent::__construct();
        $this->load->database();
    }
    
    public function get_permission_by_id($permission_id) {
        return $this->db->get_where('permissions', array('id' => $permission_id))->row();
    }
    
}
?>
