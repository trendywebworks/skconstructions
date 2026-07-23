<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Marketloans extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}

		$this->userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
		$this->_role = $this->userdata['role_id'];
		
		$this->_table = 'market_loans';
		$this->_party_table = 'loan_party';
		$this->_title = 'Market Loans';
		$this->_link_start = 'market-loans';
		$this->load->model('Marketloans_Model');

		$this->load->library('authorization');
		is_permitted();
	}

	public function index()
	{
		$data['titles'] = array(
			'title'	=>	'Market Loans',
			'subtitle'	=>	'View List',
			'addlink'	=>	'market-loans-add',
			'edit'		=>	'market-loans-edit',
			'view'		=>	'market-loans-view',
			'delete'	=>	'market-loans-delete'
		);
		$data['theads'] = ['date', 'party_name', 'loan_amount', 'interest_per/month', 'total_installments', 'total_amount', 'status', 'remarks', 'action'];
		$data['list'] = $this->Marketloans_Model->getAllMarketLoansList();
		$data['tfooter'] = array(
			'colspan' 	=> 2,
			'title'	  	=> 'Total',
			'sum_cols'	=> [2,4,5],
			'empty' 	=> 4);
		$data['page'] = 'list';
		$this->load->view('main', $data);
	}

	public function add()
	{
		$data['titles'] = array(
			'title'	=>	'Market Loans',
			'subtitle'	=>	'Add New',
			'listlink'	=>	'market-loans-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('party_id', 'Party Name', 'required');
            $this->form_validation->set_rules('loan_amount', 'Loan Amount', 'required');
            $this->form_validation->set_rules('interest', 'Interest', 'required');
            $this->form_validation->set_rules('total_installments', 'Total Installments', 'required');
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
					'party_id'				=>	$this->input->post('party_id'),
					'loan_amount'			=>	$this->input->post('loan_amount'),
					'interest'				=>	$this->input->post('interest'),
					'total_installments'	=>	$this->input->post('total_installments'),
					'total_amount'			=>	$this->input->post('total_amount'),
					'remarks'				=>	$this->input->post('remarks'),
					'created_at'			=>	currentDateTime(),
					'status'				=>	$status
				);
				$this->common_model->insert($this->_table, $insArray);
				$this->session->set_flashdata('success', 'Market Loan added successfully');
				redirect('market-loans-list');
			}
		}

		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = 'market-loans-add';
		$data['formCustomization'] = $this->formCustomization();
		$data['page'] = 'addEditDynamicForm';
		$this->load->view('main', $data);
	}

	public function edit($id)
	{
		$data['id'] = $id;
		$data['titles'] = array(
			'title'	=>	'Market Loans',
			'subtitle'	=>	'Edit Market Loan',
			'listlink'	=>	'market-loans-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('party_id', 'Party Name', 'required');
            $this->form_validation->set_rules('loan_amount', 'Loan Amount', 'required');
            $this->form_validation->set_rules('interest', 'Interest', 'required');
            $this->form_validation->set_rules('total_installments', 'Total Installments', 'required');
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
					'party_id'				=>	$this->input->post('party_id'),
					'loan_amount'			=>	$this->input->post('loan_amount'),
					'interest'				=>	$this->input->post('interest'),
					'total_installments'	=>	$this->input->post('total_installments'),
					'total_amount'			=>	$this->input->post('total_amount'),
					'remarks'				=>	$this->input->post('remarks'),
					'updated_at'			=>	currentDateTime(),
					'status'				=>	$status
				);
				$this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);
				$this->session->set_flashdata('success', 'Market Loan updated successfully');
				redirect('market-loans-list');
			}
		}

		$select = 'id,created_at,party_id,loan_amount,interest,total_installments,total_amount,status,remarks';
		$data['details'] = $this->common_model->getWhereRow($this->_table, $select, array('id' => $id));
		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = 'market-loans-edit/'.$id;
		$data['formCustomization'] = $this->formCustomization($data['details']['party_id']);
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

		$data['list'] = $this->Marketloans_Model->getAllMarketLoansListById($id);
		$data['theads'] = ['party_name'=>'party_name', 'loan_amount'=>'loan_amount', 'interest'=>'interest', 'total_installments'=>'total_installments', 'total_amount'=>'total_amount', 'remarks'=>'remarks', 'entry_date'=>'entry_date'];

		$data['page'] = 'view';
		$this->load->view('main', $data);
	}

	public function formCustomization($selectid = '')
	{
		$data = array(
			'fields'    => array('party_id', 'loan_amount', 'interest', 'total_amount'),
			'party_id'	=>	array(
				'name' 		=> 'Party Name',
				'type'		=>	'select',
				'values'	=>	getDropdownOptions($this->_party_table, 'party_name', $selectid)),
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
				'type'		=>	'text',)
		);
		return $data;
	}
	
}
