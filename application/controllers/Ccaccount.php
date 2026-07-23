<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Ccaccount extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}

		$this->userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
		$this->_role = $this->userdata['role_id'];
		
		$this->_table = 'cc_account';
		$this->_bank_table = 'banks';
		$this->_title = 'CC Account';
		$this->_link_start = 'cc-account';
		$this->load->model('Ccaccount_Model');
		$this->_select = 'id,created_at,entry_date,bank_id,loan_amount,interest,total_amount,status,remarks';

		$this->load->library('authorization');
		is_permitted();
	}

	public function index()
	{
		$data['titles'] = array(
			'title'	=>	'CC Account',
			'subtitle'	=>	'View List',
			'addlink'	=>	'cc-account-add',
			'edit'		=>	'cc-account-edit',
			'view'		=>	'cc-account-view',
			'delete'	=>	'cc-account-delete'
		);

		$data['list'] = $this->Ccaccount_Model->getAllCCAccountList();
		$data['theads'] = ['date', 'bank_name', 'loan_amount', 'interest_per/month', 'total_amount', 'status', 'remarks', 'action'];
		$data['tfooter'] = array(
			'colspan' 	=> 2,
			'title'	  	=> 'Total',
			'sum_cols'	=> [2,4],
			'empty' 	=> 4);
		$data['allow_delete'] = ($this->_role == 1);
		$data['page'] = 'list';
		$this->load->view('main', $data);
	}

	public function add()
	{
		$data['titles'] = array(
			'title'	=>	'CC Account',
			'subtitle'	=>	'Add New',
			'listlink'	=>	'cc-account-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('bank_id', 'Bank Name', 'required');
            $this->form_validation->set_rules('loan_amount', 'Loan Amount', 'required');
            $this->form_validation->set_rules('interest', 'Interest', 'required');
            $this->form_validation->set_rules('total_amount', 'Total Amount', 'required');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'			=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'bank_id'				=>	$this->input->post('bank_id'),
					'loan_amount'			=>	$this->input->post('loan_amount'),
					'interest'				=>	$this->input->post('interest'),
					'total_amount'			=>	$this->input->post('total_amount'),
					'remarks'				=>	$this->input->post('remarks'),
					'created_at'			=>	currentDateTime(),
					'status'				=>	$status
				);
				$this->common_model->insert($this->_table, $insArray);
				$this->session->set_flashdata('success', 'CC Account added successfully');
				redirect('cc-account-list');
			}
		}

		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = 'cc-account-add';
		$data['formCustomization'] = $this->formCustomization();
		$data['formLayout'] = 'cc_account';
		$data['submitButtonClass'] = 'btn-lg';
		$data['page'] = 'addEditDynamicForm';
		$this->load->view('main', $data);
	}

	public function edit($id)
	{
		$data['id'] = $id;
		$data['titles'] = array(
			'title'	=>	'CC Account',
			'subtitle'	=>	'Edit CC Account',
			'listlink'	=>	'cc-account-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('bank_id', 'Bank Name', 'required');
            $this->form_validation->set_rules('loan_amount', 'Loan Amount', 'required');
            $this->form_validation->set_rules('interest', 'Interest', 'required');
            $this->form_validation->set_rules('total_amount', 'Total Amount', 'required');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'			=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'bank_id'				=>	$this->input->post('bank_id'),
					'loan_amount'			=>	$this->input->post('loan_amount'),
					'interest'				=>	$this->input->post('interest'),
					'total_amount'			=>	$this->input->post('total_amount'),
					'remarks'				=>	$this->input->post('remarks'),
					'updated_at'			=>	currentDateTime(),
					'status'				=>	$status
				);
				$this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);
				$this->session->set_flashdata('success', 'CC Account updated successfully');
				redirect('cc-account-list');
			}
		}

		$data['details'] = $this->common_model->getWhereRow($this->_table, $this->_select, array('id' => $id));
		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = 'cc-account-edit/'.$id;
		$data['formCustomization'] = $this->formCustomization($data['details']['bank_id']);
		$data['formLayout'] = 'cc_account';
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
			'listlink'	=>	$this->_link_start.'-list',
			'editlink'	=>	$this->_link_start.'-edit/'.$id
		);

		$data['list'] = $this->Ccaccount_Model->getAllCCAccountListById($id);
		$data['theads'] = ['party_name'=>'party_name', 'loan_amount'=>'loan_amount', 'interest'=>'interest', 'total_amount'=>'total_amount', 'remarks'=>'remarks', 'entry_date'=>'entry_date'];

		$data['page'] = 'view';
		$this->load->view('main', $data);
	}

	public function delete($id)
	{
		if($this->_role != 1)
		{
			$this->session->set_flashdata('error', 'Only admin users can delete CC accounts.');
			redirect('cc-account-list');
		}

		$this->common_model->updateWhere($this->_table, array('id' => $id), array(
			'status'		=>	'deleted',
			'updated_at'	=>	currentDateTime()
		));
		$this->session->set_flashdata('success', 'CC Account deleted successfully');
		redirect('cc-account-list');
	}

	public function formCustomization($selectid = '')
	{
		$data = array(
			'fields'    => array('bank_id', 'loan_amount', 'interest', 'total_amount', 'remarks'),
			'bank_id'	=>	array(
				'name' 		=> 'Bank Name',
				'type'		=>	'select',
				'column'	=>	'col-md-6',
				'values'	=>	getDropdownOptions($this->_bank_table, 'bank_name', $selectid)),
			'loan_amount' => array(
				'name'		=>	'Loan Amount',
				'type'		=>	'text',
				'column'	=>	'col-md-6'),
			'interest' => array(
				'name'		=>	'Interest Per/Month(%)',
				'type'		=>	'text',
				'column'	=>	'col-md-6'),
			'total_amount'	=> array(
				'name'		=>	'Total Amount',
				'readonly'	=>	'readonly',
				'type'		=>	'text',
				'column'	=>	'col-12'),
			'remarks'	=>	array(
				'column'	=>	'col-12')
		);
		return $data;
	}
}
