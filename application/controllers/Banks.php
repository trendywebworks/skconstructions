<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Banks extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}

		$this->userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
		$this->_role = $this->userdata['role_id'];
		
		$this->_table = 'banks';
		$this->_title = 'Banks';
		$this->_link_start = 'bank';
		$this->_select_view = 'id,created_at,entry_date,bank_name,bank_branch,status,remarks';

		$this->load->library('authorization');
		is_permitted();
	}

	public function index()
	{
		$data['titles'] = array(
			'title'	=>	'Banks',
			'subtitle'	=>	'View List',
			'addlink'	=>	'bank-add',
			'edit'		=>	'bank-edit',
			'view'		=>	'bank-view',
			'delete'	=>	'bank-delete'
		);

		$select = 'id,created_at,entry_date,bank_name,bank_branch,status,remarks';
		$data['list'] = $this->common_model->getAllWhereSelectList($this->_table, $select, array('status != ' => 'deleted'));
		$data['theads'] = ['date', 'bank_name', 'bank_branch', 'status', 'remarks', 'action'];
		$data['allow_delete'] = ($this->_role == 1);
		$data['page'] = 'list';
		$this->load->view('main', $data);
	}

	public function add()
	{
		$data['titles'] = array(
			'title'	=>	'Banks',
			'subtitle'	=>	'Add New',
			'listlink'	=>	'banks-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('bank_name', 'Bank Name', 'required');
			$this->form_validation->set_rules('bank_branch', 'Bank Branch', 'required');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'	=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'bank_name'		=>	$this->input->post('bank_name'),
					'bank_branch'	=>	$this->input->post('bank_branch'),
					'remarks'		=>	$this->input->post('remarks'),
					'created_at'	=>	currentDateTime(),
					'status'		=>	$status
				);
				$this->common_model->insert($this->_table, $insArray);
				$this->session->set_flashdata('success', 'Bank added successfully');
				redirect('banks-list');
			}
		}

			$data['fields'] = $this->db->field_data($this->_table);
			$data['action'] = 'bank-add';
			$data['formCustomization'] = $this->formCustomization();
			$data['formLayout'] = 'bank';
			$data['submitButtonClass'] = 'btn-lg';
			$data['page'] = 'addEditDynamicForm';
			$this->load->view('main', $data);
		}

	public function edit($id)
	{
		$data['id'] = $id;
		$data['titles'] = array(
			'title'	=>	'Banks',
			'subtitle'	=>	'Edit Bank',
			'listlink'	=>	'banks-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('bank_name', 'Bank Name', 'required');
			$this->form_validation->set_rules('bank_branch', 'Bank Branch', 'required');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');

            	// if($this->_role == 1)
            	// {
            	// 	$status = $this->input->post('status');
            	// }

				$insArray = array(
					'entry_date'	=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'bank_name'		=>	$this->input->post('bank_name'),
					'bank_branch'	=>	$this->input->post('bank_branch'),
					'remarks'		=>	$this->input->post('remarks'),
					'updated_at'	=>	currentDateTime(),
					'status'		=>	$status
				);
				$this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);
				$this->session->set_flashdata('success', 'Bank updated successfully');
				redirect('banks-list');
			}
		}

		$select = 'id,created_at,entry_date,bank_name,bank_branch,status,remarks';
			$data['details'] = $this->common_model->getWhereRow($this->_table, $select, array('id' => $id));
			$data['fields'] = $this->db->field_data($this->_table);
			$data['action'] = 'bank-edit/'.$id;
			$data['formCustomization'] = $this->formCustomization();
			$data['formLayout'] = 'bank';
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
			'listlink'	=>	$this->_link_start.'s-list',
			'editlink'	=>	$this->_link_start.'-edit/'.$id
		);

		$data['list'] = $this->common_model->getAllWhereSelectListRow($this->_table, $this->_select_view, array('id' => $id));
		$data['theads'] = ['bank_name'=>'bank_name', 'bank_branch'=>'bank_branch', 'status'=>'status', 'remarks'=>'remarks', 'entry_date'=>'entry_date'];

		$data['page'] = 'view';
		$this->load->view('main', $data);
	}

	public function delete($id)
	{
		if($this->_role != 1)
		{
			$this->session->set_flashdata('error', 'Only admin users can delete banks.');
			redirect('banks-list');
		}

		$this->common_model->updateWhere($this->_table, array('id' => $id), array(
			'status'		=>	'deleted',
			'updated_at'	=>	currentDateTime()
		));
		$this->session->set_flashdata('success', 'Bank deleted successfully');
		redirect('banks-list');
	}

	private function formCustomization()
	{
		return array(
			'fields'	=>	array('bank_name', 'bank_branch', 'remarks'),
			'bank_name'	=>	array(
				'name'		=>	'Bank Name',
				'type'		=>	'text',
				'column'	=>	'col-md-6'),
			'bank_branch'	=>	array(
				'name'		=>	'Branch Name',
				'type'		=>	'text',
				'column'	=>	'col-md-6'),
			'remarks'	=>	array(
				'column'	=>	'col-12')
		);
	}
}
