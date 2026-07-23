<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Userroles extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}
		
		$this->_table = 'roles';
		$this->_permissions_table = 'permissions';
		$this->_role_permissions_table = 'role_permissions';
		$this->_title = 'User Roles';
		$this->_link_start = 'user-role';
		$this->_select = 'id,created_at,entry_date,name';
		$this->load->model('Role_model');

		$this->load->library('authorization');
		is_permitted();
	}

	public function index()
	{
		$data['titles'] = array(
			'title'	=>	$this->_title,
			'subtitle'	=>	'View List',
			'addlink'	=>	$this->_link_start.'-add',
			'edit'		=>	$this->_link_start.'-edit',
			'view'		=>	$this->_link_start.'-view',
			'delete'	=>	$this->_link_start.'-delete'
		);

		$data['list'] = $this->common_model->getAllWhereSelectList($this->_table, $this->_select, array('status' => 'active'));
		$data['theads'] = ['date', 'role', 'action'];
		$data['page'] = 'list';
		$this->load->view('main', $data);
	}

	public function add()
	{
		$data['titles'] = array(
			'title'	=>	$this->_title,
			'subtitle'	=>	'Add New',
			'listlink'	=>	$this->_link_start.'-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('name', 'Role', 'required|is_unique[roles.name]');

            if($this->form_validation->run() == true)
            {
				$insArray = array(
					'entry_date'	=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'name'			=>	$this->input->post('name'),
					'created_at'	=>	currentDateTime(),
					'status'		=>	'active'
				);

				$insert = $this->common_model->insert($this->_table, $insArray);

				if($insert)
				{
					if($this->input->post('permission_id') !== null && count($this->input->post('permission_id')) > 0)
					{
						foreach($this->input->post('permission_id') as $perm)
						{
							$insArrayPerm = array(
								'role_id'			=>	$insert,
								'permission_id'		=>	$perm
							);
							$this->common_model->insert($this->_role_permissions_table, $insArrayPerm);
						}
					}
				}
				$this->session->set_flashdata('success', 'Roles added successfully');
				redirect($this->_link_start.'-list');
			}
		}

		$data['permissions'] = $this->common_model->getAllWhereSelectListOrderAsc($this->_permissions_table, '*', array('status' => 'active'));
		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = $this->_link_start.'-add';
		$data['page'] = 'addEditUserRolesForm';
		$this->load->view('main', $data);
	}

	public function edit($id)
	{
		$data['id'] = $id;
		$data['titles'] = array(
			'title'	=>	$this->_title,
			'subtitle'	=>	'Edit '.$this->_title,
			'listlink'	=>	$this->_link_start.'-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('name', 'Role', 'required|edit_unique[roles.name.'.$id.']');

            if($this->form_validation->run() == true)
            {
				$insArray = array(
					'entry_date'	=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'name'			=>	$this->input->post('name'),
					'updated_at'	=>	currentDateTime(),
					'status'		=>	'active'
				);

				$this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);

				if($this->input->post('permission_id') !== null && count($this->input->post('permission_id')) > 0)
				{
					//Delete old permissions and insert as new
					$this->db->where('role_id', $id)->delete($this->_role_permissions_table);
					foreach($this->input->post('permission_id') as $perm)
					{
						$insArrayPerm = array(
							'role_id'			=>	$id,
							'permission_id'		=>	$perm
						);
						$this->common_model->insert($this->_role_permissions_table, $insArrayPerm);
					}
				}

				$this->session->set_flashdata('success', 'Roles updated successfully');
				redirect($this->_link_start.'-list');
			}
		}

		$data['permissions'] = $this->common_model->getAllWhereSelectListOrderAsc($this->_permissions_table, '*', array('status' => 'active'));
		$data['details'] = $this->Role_model->getRolePermissions($id);
		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = $this->_link_start.'-edit/'.$id;
		$data['page'] = 'addEditUserRolesForm';
		$this->load->view('main', $data);
	}

	public function view($id)
	{
		$data['id'] = $id;
		$data['titles'] = array(
			'title'	=>	$this->_title,
			'subtitle'	=>	'View '.$this->_title,
			'listlink'	=>	$this->_link_start.'-list'
		);

		$data['list'] = $this->Role_model->getRolePermissionsName($id);
		$data['page'] = 'viewUserRoles';
		$this->load->view('main', $data);
	}

}
