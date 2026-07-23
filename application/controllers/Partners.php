<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Partners extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}

		$this->userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
		$this->_role = $this->userdata['role_id'];
		
		$this->_table = 'partners';
		$this->_title = 'Partners';
		$this->_link_start = 'partner';
		$this->_select = 'id,created_at,entry_date,full_name,phone_number,email_address,id_proof,status,remarks';
		$this->_select_view = 'id,created_at,entry_date,full_name,phone_number,email_address,id_proof,status,remarks';
		$this->_folder = 'partners';

		$this->load->library('authorization');
		is_permitted();
	}

	public function index()
	{
		$data['titles'] = array(
			'title'	=>	'Partners',
			'subtitle'	=>	'View List',
			'addlink'	=>	'partner-add',
			'edit'		=>	'partner-edit',
			'view'		=>	'partner-view',
			'delete'	=>	'partner-delete'
		);

		$data['list'] = $this->common_model->getAllWhereSelectList($this->_table, $this->_select, array('status != ' => 'deleted'));
		$data['folder'] = $this->_folder;
		$data['theads'] = ['date', 'full_name', 'phone_number', 'email-address', 'ID_proof', 'status', 'remarks', 'action'];
		$data['allow_delete'] = ($this->_role == 1);
		$data['page'] = 'list';
		$this->load->view('main', $data);
	}

	public function add()
	{
		$data['titles'] = array(
			'title'	=>	'Partners',
			'subtitle'	=>	'Add New',
			'listlink'	=>	'partners-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('full_name', 'Full Name', 'required');
			$this->form_validation->set_rules('phone_number', 'Phone Number', 'required|is_unique[partners.phone_number]');
			$this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email|is_unique[partners.email_address]');
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
					'entry_date'			=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'full_name'				=>	$this->input->post('full_name'),
					'phone_number'			=>	$this->input->post('phone_number'),
					'email_address'			=>	$this->input->post('email_address'),
					'remarks'		=>	$this->input->post('remarks'),
					'created_at'	=>	currentDateTime(),
					'status'		=>	$status
				);

				if (!empty($_FILES['id_proof']['name']))
				{
					$ret = fileUpload('id_proof', 'partners');
					if($ret['status'] == 1)
					{
						$insArray['id_proof'] = $ret['filename'];
					}
					else
					{
						//redirecting to reload page fully
						$this->session->set_flashdata('error', $ret['message'].' Try uploading again.');
						redirect('partners-list');
					}
				}
				$this->common_model->insert($this->_table, $insArray);
				$this->session->set_flashdata('success', 'Partner added successfully');
				redirect('partners-list');
			}
		}

		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = 'partner-add';
		$data['folder'] = $this->_folder;
		$data['formCustomization'] = $this->formCustomization();
		$data['page'] = 'addEditDynamicForm';
		$this->load->view('main', $data);
	}

	public function edit($id)
	{
		$data['id'] = $id;
		$data['titles'] = array(
			'title'	=>	'Partners',
			'subtitle'	=>	'Edit Partner',
			'listlink'	=>	'partners-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('full_name', 'Full Name', 'required');
			$this->form_validation->set_rules('phone_number', 'Phone Number', 'required|edit_unique[partners.phone_number.'.$id.']');
			$this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email|edit_unique[partners.email_address.'.$id.']');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'			=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'full_name'				=>	$this->input->post('full_name'),
					'phone_number'			=>	$this->input->post('phone_number'),
					'email_address'			=>	$this->input->post('email_address'),
					'remarks'		=>	$this->input->post('remarks'),
					'updated_at'	=>	currentDateTime(),
					'status'		=>	$status
				);

				if (!empty($_FILES['id_proof']['name']))
				{
					$ret = fileUpload('id_proof', 'partners');
					if($ret['status'] == 1)
					{
						$insArray['id_proof'] = $ret['filename'];
					}
					else
					{
						//redirecting to reload page fully
						$this->session->set_flashdata('error', $ret['message'].' Try uploading again.');
						redirect('partners-list');
					}
				}
				$this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);
				$this->session->set_flashdata('success', 'Partner updated successfully');
				redirect('partners-list');
			}
		}

		$data['details'] = $this->common_model->getWhereRow($this->_table, $this->_select, array('id' => $id));
		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = 'partner-edit/'.$id;
		$data['folder'] = $this->_folder;
		$data['formCustomization'] = $this->formCustomization();
		$data['page'] = 'addEditDynamicForm';
		$this->load->view('main', $data);
	}

	public function view($id)
	{
		$data['id'] = $id;
		$data['titles'] = array(
			'title'	=>	$this->_title,
			'subtitle'	=>	'View '.$this->_title,
			'listlink'	=>	$this->_link_start.'s-list',
			'editlink'	=>	$this->_link_start.'-edit/'.$id
		);
		$data['folder'] = $this->_folder;

		$data['list'] = $this->common_model->getAllWhereSelectListRow($this->_table, $this->_select_view, array('id' => $id));
		$data['theads'] = ['full_name'=>'full_name', 'phone_number'=>'phone_number', 'email_address'=>'email_address', 'id_proof'=>'ID_proof', 'status'=>'status', 'remarks'=>'remarks', 'entry_date'=>'entry_date'];

		$data['page'] = 'view';
		$this->load->view('main', $data);
	}

	public function delete($id)
	{
		if($this->_role != 1)
		{
			$this->session->set_flashdata('error', 'Only admin users can delete partners.');
			redirect('partners-list');
		}

		$this->common_model->updateWhere($this->_table, array('id' => $id), array(
			'status'		=>	'deleted',
			'updated_at'	=>	currentDateTime()
		));
		$this->session->set_flashdata('success', 'Partner deleted successfully');
		redirect('partners-list');
	}

	public function formCustomization($selectid = '')
	{
		$data = array(
			'fields'    => array('phone_number', 'email_address', 'id_proof'),
			'phone_number'	=>	array(
				'name'		=>	'Phone Number',
				'column'	=>	'col-md-6',
				'type'		=>	'text'),
			'email_address' => array(
				'name'		=>	'Email Address',
				'column'	=>	'col-md-6',
				'type'		=>	'text'),
			'id_proof' => array(
				'name'		=>	'ID Proof',
				'type'		=>	'file')
		);
		return $data;
	}
}
