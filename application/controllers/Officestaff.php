<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Officestaff extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}

		$this->userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
		$this->_role = $this->userdata['role_id'];
		
		$this->_table = 'office_staffs';
		$this->_title = 'Office Staff';
		$this->_link_start = 'office-staff';
		$this->_select = 'id,created_at,entry_date,name,phone_number,email_address,position,joining_date,id_proof,status,remarks';
		$this->_select_view = 'id,created_at,entry_date,name,phone_number,email_address,position,joining_date,id_proof,status,remarks';
		$this->_folder = 'office_staffs';

		$this->load->library('authorization');
		is_permitted();
	}

	public function index()
	{
		$data['titles'] = array(
			'title'	=>	'Office Staff',
			'subtitle'	=>	'View List',
			'addlink'	=>	'office-staff-add',
			'edit'		=>	'office-staff-edit',
			'view'		=>	'office-staff-view',
			'delete'	=>	'office-staff-delete'
		);

		$data['list'] = $this->common_model->getAllWhereSelectList($this->_table, $this->_select, array('status != ' => 'deleted'));
		$data['folder'] = $this->_folder;
		$data['theads'] = ['date', 'name', 'phone_number', 'email-address', 'position', 'joining_date', 'ID_proof', 'status', 'remarks', 'action'];
		$data['allow_delete'] = ($this->_role == 1);
		$data['page'] = 'list';
		$this->load->view('main', $data);
	}

	public function add()
	{
		$data['titles'] = array(
			'title'	=>	'Office Staffs',
			'subtitle'	=>	'Add New',
			'listlink'	=>	'office-staff-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('phone_number', 'Phone Number', 'required|is_unique[office_staffs.phone_number]');
			$this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email|is_unique[office_staffs.email_address]');
			$this->form_validation->set_rules('position', 'Position', 'required');
			$this->form_validation->set_rules('joining_date', 'Joining Date', 'required');
			if (empty($_FILES['id_proof']['name']))
			{
			    $this->form_validation->set_rules('id_proof', 'ID Proof', 'required');
			}
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'		=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'name'				=>	$this->input->post('name'),
					'phone_number'		=>	$this->input->post('phone_number'),
					'email_address'		=>	$this->input->post('email_address'),
					'position'			=>	$this->input->post('position'),
					'joining_date'		=>	toDbDateFormat($this->input->post('joining_date')),
					'remarks'			=>	$this->input->post('remarks'),
					'created_at'		=>	currentDateTime(),
					'status'			=>	$status
				);

				if (!empty($_FILES['id_proof']['name']))
				{
					$ret = fileUpload('id_proof', $this->_folder);
					if($ret['status'] == 1)
					{
						$insArray['id_proof'] = $ret['filename'];
					}
					else
					{
						//redirecting to reload page fully
						$this->session->set_flashdata('error', $ret['message'].' Try uploading again.');
						redirect('office-staff-list');
					}
				}
				$this->common_model->insert($this->_table, $insArray);
				$this->session->set_flashdata('success', 'Office Staff added successfully');
				redirect('office-staff-list');
			}
		}

		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = 'office-staff-add';
		$data['folder'] = $this->_folder;
		$data['formCustomization'] = $this->formCustomization();
		$data['page'] = 'addEditDynamicForm';
		$this->load->view('main', $data);
	}

	public function edit($id)
	{
		$data['id'] = $id;
		$data['titles'] = array(
			'title'	=>	'Office Staffs',
			'subtitle'	=>	'Edit Office Staffs',
			'listlink'	=>	'office-staff-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('name', 'Name', 'required');
			$this->form_validation->set_rules('phone_number', 'Phone Number', 'required|edit_unique[office_staffs.phone_number.'.$id.']');
			$this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email|edit_unique[office_staffs.email_address.'.$id.']');
			$this->form_validation->set_rules('position', 'Position', 'required');
			$this->form_validation->set_rules('joining_date', 'Joining Date', 'required');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'		=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'name'				=>	$this->input->post('name'),
					'phone_number'		=>	$this->input->post('phone_number'),
					'email_address'		=>	$this->input->post('email_address'),
					'position'			=>	$this->input->post('position'),
					'joining_date'		=>	toDbDateFormat($this->input->post('joining_date')),
					'remarks'		=>	$this->input->post('remarks'),
					'updated_at'	=>	currentDateTime(),
					'status'		=>	$status
				);

				if (!empty($_FILES['id_proof']['name']))
				{
					$ret = fileUpload('id_proof', $this->_folder);
					if($ret['status'] == 1)
					{
						$insArray['id_proof'] = $ret['filename'];
					}
					else
					{
						//redirecting to reload page fully
						$this->session->set_flashdata('error', $ret['message'].' Try uploading again.');
						redirect('office-staff-list');
					}
				}
				$this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);
				$this->session->set_flashdata('success', 'Office Staff updated successfully');
				redirect('office-staff-list');
			}
		}

		$data['details'] = $this->common_model->getWhereRow($this->_table, $this->_select, array('id' => $id));
		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = 'office-staff-edit/'.$id;
		$data['folder'] = $this->_folder;
		$data['formCustomization'] = $this->formCustomization($data['details']['position']);
		$data['page'] = 'addEditDynamicForm';
		$this->load->view('main', $data);
	}

	public function view($id)
	{
		$data['id'] = $id;
		$data['titles'] = array(
			'title'	=>	$this->_title,
			'subtitle'	=>	'View '.$this->_title,
			'listlink'	=>	$this->_link_start.'-list',
			'editlink'	=>	$this->_link_start.'-edit/'.$id
		);
		$data['folder'] = $this->_folder;

		$data['list'] = $this->common_model->getAllWhereSelectListRow($this->_table, $this->_select_view, array('id' => $id));
		$data['theads'] = ['name'=>'name', 'phone_number'=>'phone_number', 'email_address'=>'email_address', 'position'=>'position', 'joining_date'=>'joining_date', 'id_proof'=>'ID_proof', 'status'=>'status', 'remarks'=>'remarks', 'entry_date'=>'entry_date'];

		$data['page'] = 'view';
		$this->load->view('main', $data);
	}

	public function delete($id)
	{
		if($this->_role != 1)
		{
			$this->session->set_flashdata('error', 'Only admin users can delete office staff.');
			redirect('office-staff-list');
		}

		$this->common_model->updateWhere($this->_table, array('id' => $id), array(
			'status'		=>	'deleted',
			'updated_at'	=>	currentDateTime()
		));
		$this->session->set_flashdata('success', 'Office Staff deleted successfully');
		redirect('office-staff-list');
	}

	public function formCustomization($selectid = '')
	{
		$data = array(
			'fields'    => array('phone_number', 'email_address', 'position', 'joining_date', 'id_proof'),
			'phone_number'	=>	array(
				'name'		=>	'Phone Number',
				'column'	=>	'col-md-6',
				'type'		=>	'text'),
			'email_address' => array(
				'name'		=>	'Email Address',
				'column'	=>	'col-md-6',
				'type'		=>	'text'),
			'position' => array(
				'name'		=>	'Position',
				'column'	=>	'col-md-6',
				'type'		=>	'select',
				'values'	=>	getPositionDropdownOptions($selectid)),
			'joining_date' => array(
				'name'		=>	'Joining Date',
				'column'	=>	'col-md-6',
				'type'		=>	'date'),
			'id_proof' => array(
				'name'		=>	'ID Proof- Aadhar/Pan Card',
				'type'		=>	'file')
		);
		return $data;
	}
}
