<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}
		
		$this->_table = 'users';
		$this->_user_roles_table = 'user_roles';
		$this->_title = 'Users';
		$this->_link_start = 'user';
		$this->load->model('User_model');
		$this->_select = 'id,created_at,entry_date,username,first_name,last_name,email,role,remarks,status';
		$this->_select_view = 'id,created_at,entry_date,username,first_name,last_name,email,phone,address,city,state,remarks,status,profile_pic';

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

		$data['list'] = $this->User_model->getAllUserDetails();//$this->common_model->getAllWhereSelectList($this->_table, $this->_select, array('status' => 'active'));
		$data['theads'] = ['date', 'role', 'username', 'first_name', 'last_name', 'email-address', 'remarks', 'status', 'action'];
		$data['page'] = 'list';
		$this->load->view('main', $data);
	}

	public function add()
	{
		$data['titles'] = array(
			'title'	=>	$this->_title,
			'subtitle'	=>	'Add New',
			'listlink'	=>	$this->_link_start.'s-list'
		);
		
		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('username', 'Username', "required|is_unique[users.username]");
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');
            $this->form_validation->set_rules('email', 'Email Address', "required|is_unique[users.email]");
            $this->form_validation->set_rules('phone', 'Phone Number', "required|is_unique[users.phone]");
            $this->form_validation->set_rules('password', 'Password', 'required');
			$this->form_validation->set_rules('cpassword', 'Confirm Password', 'required|matches[password]');
            $this->form_validation->set_rules('city', 'City', 'required');
            $this->form_validation->set_rules('state', 'State', 'required');
            $this->form_validation->set_rules('role', 'Role', 'required');

            if($this->form_validation->run() == true)
            {
				$insArray = array(
					'entry_date'	=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'username'		=>	$this->input->post('username'),
					'first_name'	=>	$this->input->post('first_name'),
					'last_name'		=>	$this->input->post('last_name'),
					'email'			=>	$this->input->post('email'),
					'phone'			=>	$this->input->post('phone'),
					'password'		=>	md5($this->input->post('password')),
					'cpassword'		=>	md5($this->input->post('password')),
					'address'		=>	$this->input->post('address'),
					'city'			=>	$this->input->post('city'),
					'state'			=>	$this->input->post('state'),
					// 'role'			=>	$this->input->post('role'),
					'remarks'		=>	$this->input->post('remarks'),
					'created_at'	=>	currentDateTime(),
					'status'		=>	'active'
				);
				$insert = $this->common_model->insert($this->_table, $insArray);

				if($insert)
				{
					$insArrayPerm = array(
						'user_id'	=>	$insert,
						'role_id'	=>	$this->input->post('role')
					);
					$this->common_model->insert($this->_user_roles_table, $insArrayPerm);
				}
				$this->session->set_flashdata('success', 'User added successfully');
				redirect($this->_link_start.'s-list');
			}
		}

		$fields = $this->db->field_data($this->_table);
		$additional_column = (object) array(
		    'name' => 'role',
		    'type' => 'varchar',
		    'max_length' => 50,
		    'default' => '',
		    'primary_key' => 0
		);
		$fields[] = $additional_column;

			$data['fields'] = $fields;
			$data['action'] = $this->_link_start.'-add';
			$data['formCustomization'] = $this->formCustomization();
			$data['formLayout'] = 'user';
			$data['submitButtonClass'] = 'btn-lg';
			$data['page'] = 'addEditDynamicForm';
			$this->load->view('main', $data);
		}

	public function edit($id)
	{
		$data['id'] = $id;
		$data['titles'] = array(
			'title'	=>	$this->_title,
			'subtitle'	=>	'Edit '.$this->_title,
			'listlink'	=>	$this->_link_start.'s-list'
		);
		
		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('username', 'Username', 'required|edit_unique[users.username.'.$id.']');
            $this->form_validation->set_rules('first_name', 'First Name', 'required');
            $this->form_validation->set_rules('last_name', 'Last Name', 'required');
            $this->form_validation->set_rules('email', 'Email Address', 'required|edit_unique[users.email.'.$id.']');
            $this->form_validation->set_rules('phone', 'Phone Number', 'required|edit_unique[users.phone.'.$id.']');
            $this->form_validation->set_rules('city', 'City', 'required');
            $this->form_validation->set_rules('state', 'State', 'required');
            $this->form_validation->set_rules('role', 'Role', 'required');

            if($this->form_validation->run() == true)
            {
				$insArray = array(
					'entry_date'	=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'username'		=>	$this->input->post('username'),
					'first_name'	=>	$this->input->post('first_name'),
					'last_name'		=>	$this->input->post('last_name'),
					'email'			=>	$this->input->post('email'),
					'phone'			=>	$this->input->post('phone'),
					'password'		=>	md5($this->input->post('password')),
					'cpassword'		=>	md5($this->input->post('password')),
					'address'		=>	$this->input->post('address'),
					'city'			=>	$this->input->post('city'),
					'state'			=>	$this->input->post('state'),
					// 'role'			=>	$this->input->post('role'),
					'remarks'		=>	$this->input->post('remarks'),
					'created_at'	=>	currentDateTime(),
					'status'		=>	'active'
				);
				$up = $this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);

				if($up)
				{
					//Delete old user role and insert as new
					$this->db->where('user_id', $id)->delete($this->_user_roles_table);
					$insArrayPerm = array(
						'user_id'	=>	$id,
						'role_id'	=>	$this->input->post('role')
					);
					$this->common_model->insert($this->_user_roles_table, $insArrayPerm);
				}

				$this->session->set_flashdata('success', 'User updated successfully');
				redirect($this->_link_start.'s-list');
			}
		}

		$select = 'id,created_at,entry_date,username,first_name,last_name,email,phone,city,state,remarks,status';
		$data['details'] = $this->User_model->getUserDetails($id);
		$fields = $this->db->field_data($this->_table);
		$additional_column = (object) array(
		    'name' => 'role',
		    'type' => 'varchar',
		    'max_length' => 50,
		    'default' => '',
		    'primary_key' => 0
		);
		$fields[] = $additional_column;

			$data['fields'] = $fields;
			$data['action'] = $this->_link_start.'-edit/'.$id;
			$data['formCustomization'] = $this->formCustomizationEdit($data['details']['role_id']);
			$data['formLayout'] = 'user';
			$data['submitButtonClass'] = 'btn-lg';
			$data['page'] = 'addEditDynamicForm';
			$this->load->view('main', $data);
		}

	public function view($id)
	{
		$data['id'] = $id;
		$data['titles'] = array(
			'title'	=>	$this->_title,
			'subtitle'	=>	'View '.$this->_title,
			'listlink'	=>	$this->_link_start.'s-list'
		);

		$data['list'] = $this->User_model->getUserDetails($id);
		$data['theads'] = ['profile_pic'=>'image', 'username'=>'username', 'first_name'=>'first_name', 'last_name'=>'last_name', 'email'=>'email-address', 'phone'=>'phone_number', 'address'=>'address', 'city'=>'city', 'state'=>'state', 'role'=>'role', 'remarks'=>'remarks', 'entry_date'=>'entry_date', 'status'=>'status'];

		$data['page'] = 'view';
		$this->load->view('main', $data);
	}

	public function formCustomization($selectid = '')
	{
			$data = array(
				'fields'    => array('username', 'first_name', 'last_name', 'email', 'phone', 'password', 'cpassword', 'city', 'state', 'address', 'remarks', 'profile_pic', 'role'),
				'username'	=>	array(
					'name' 		=> 'Username',
					'type'		=>	'text',
					'column'	=>	'col-md-6'),
				'first_name'	=>	array(
					'name' 		=> 'First Name',
					'type'		=>	'text',
					'column'	=>	'col-md-6'),
			'last_name'	=>	array(
				'name' 		=> 'Last Name',
				'type'		=>	'text',
				'column'	=>	'col-md-6'),
			'email' => array(
				'name'		=>	'Email Address',
				'column'	=>	'col-md-6',
				'type'		=>	'text'),
			'phone' => array(
				'name'		=>	'Phone Number',
				'column'	=>	'col-md-6',
				'type'		=>	'text'),
			'password' => array(
				'name'		=>	'Password',
				'column'	=>	'col-md-6',
				'type'		=>	'password'),
			'cpassword' => array(
				'name'		=>	'Confirm Password',
				'column'	=>	'col-md-6',
				'type'		=>	'password'),
			'city'	=>	array(
				'name'		=>	'City',
				'column'	=>	'col-md-6',
				'type'		=>	'text'),
				'state'	=>	array(
					'name'		=>	'State',
					'column'	=>	'col-md-6',
					'type'		=>	'text'),
				'address'	=>	array(
					'column'	=>	'col-12'),
				'remarks'	=>	array(
					'column'	=>	'col-12'),
				'profile_pic'	=>	array(
					'exclude'	=>	1),
				'role' => array(
					'name'		=>	'Role',
					'type'		=>	'select',
					'column'	=>	'col-md-6',
					'values'	=>	getPositionDropdownOptions($selectid))
			);
		return $data;
	}

	public function formCustomizationEdit($selectid = '')
	{
		$data = array(
			'fields'    => array('username', 'first_name', 'last_name', 'email', 'phone', 'password', 'cpassword', 'city', 'state', 'profile_pic', 'role'),
				'username'	=>	array(
					'name' 		=> 'Username',
					'type'		=>	'text',
					'readonly'	=>	'readonly',
					'column'	=>	'col-md-6'),
			'first_name'	=>	array(
				'name' 		=> 'First Name',
				'type'		=>	'text',
				'column'	=>	'col-md-6'),
			'last_name'	=>	array(
				'name' 		=> 'Last Name',
				'type'		=>	'text',
				'column'	=>	'col-md-6'),
			'email' => array(
				'name'		=>	'Email Address',
				'column'	=>	'col-md-6',
				'type'		=>	'text',
				'readonly'	=>	'readonly'),
			'phone' => array(
				'name'		=>	'Phone Number',
				'column'	=>	'col-md-6',
				'type'		=>	'text',
				'readonly'	=>	'readonly'),
			'password' => array(
				'name'		=>	'Password',
				'column'	=>	'col-md-6',
				'type'		=>	'password',
				'exclude'	=>	1),
			'cpassword' => array(
				'name'		=>	'Confirm Password',
				'column'	=>	'col-md-6',
				'type'		=>	'password',
				'exclude'	=>	1),
			'city'	=>	array(
				'name'		=>	'City',
				'column'	=>	'col-md-6',
				'type'		=>	'text'),
				'state'	=>	array(
					'name'		=>	'State',
					'column'	=>	'col-md-6',
					'type'		=>	'text'),
				'address'	=>	array(
					'column'	=>	'col-12'),
				'remarks'	=>	array(
					'column'	=>	'col-12'),
				'profile_pic'	=>	array(
					'exclude'	=>	1),
				'role' => array(
					'name'		=>	'Role',
					'type'		=>	'select',
					'column'	=>	'col-md-6',
					'values'	=>	getPositionDropdownOptions($selectid))
			);
		return $data;
	}
}
