<?php
class Authorization {

    protected $CI;

    public function __construct() {
        $this->CI = &get_instance();
        $this->CI->load->model('user_model');
        $this->CI->load->model('role_model');
        $this->CI->load->model('permission_model');
    }

    public function check_permission($permission_name) {
        $user_id = $this->CI->session->userdata('user_id');
        if (!$user_id) {
            return false;
        }

        //check permission is set or not for url
        if($this->CI->role_model->permission_exists($permission_name) <= 0)
        {
            return true;
        }

        $roles = $this->CI->user_model->get_user_roles($user_id);

        if(isset($roles) && count($roles) > 0)
        {
            foreach ($roles as $role) {
                if ($this->CI->role_model->has_permission($role->id, $permission_name)) {
                    return true;
                }
            }
        }

        // No role with the permission found
        return false;
    }

    // Other methods for role assignment, permission management, etc.
}