<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Staffloans extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}

		$this->userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
		$this->_role = $this->userdata['role_id'];
		
		$this->_table = 'staff_loans';
		$this->_employee_table = 'office_staffs';
		$this->_title = 'Staff Loans';
		$this->_link_start = 'staff-loan';
		$this->_select = 'id,created_at,entry_date,employee_id,loan_amount,loan_tenure,loan_last_date,status,remarks';
		$this->load->model('Staffloans_Model');

		$this->load->library('authorization');
		is_permitted();
	}

	public function index()
	{
		$data['titles'] = array(
			'title'	=>	'Staff Loans',
			'subtitle'	=>	'View List',
			'addlink'	=>	'staff-loan-add',
			'edit'		=>	'staff-loan-edit',
			'view'		=>	'staff-loan-view',
			'delete'	=>	'staff-loan-delete'
		);

		$data['list'] = $this->Staffloans_Model->getAllStaffLoansList();
		$data['theads'] = ['date', 'employee_person', 'loan_amount', 'loan_date', 'loan_tenure', 'loan_last_date', 'status', 'remarks', 'action'];
		$data['tfooter'] = array(
			'colspan' 	=> 2,
			'title'	  	=> 'Total',
			'sum_cols'	=> [2],
			'empty' 	=> 6);
		$data['allow_delete'] = ($this->_role == 1);
		$data['page'] = 'list';
		$this->load->view('main', $data);
	}

	public function add()
	{
		$data['titles'] = array(
			'title'	=>	'Staff Loans',
			'subtitle'	=>	'Add New',
			'listlink'	=>	'staff-loans-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('employee_id', 'Employee', 'required');
			$this->form_validation->set_rules('loan_amount', 'Loan Amount', 'required');
			$this->form_validation->set_rules('loan_tenure', 'Loan Tenure', 'required');
			$this->form_validation->set_rules('loan_last_date', 'Loan Last Date', 'required');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'		=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'employee_id'		=>	$this->input->post('employee_id'),
					'loan_amount'		=>	$this->input->post('loan_amount'),
					'loan_tenure'		=>	$this->input->post('loan_tenure'),
					'loan_last_date'	=>	toDbDateFormat($this->input->post('loan_last_date')),
					'remarks'		=>	$this->input->post('remarks'),
					'created_at'	=>	currentDateTime(),
					'status'		=>	$status
				);

				$this->common_model->insert($this->_table, $insArray);
				$this->session->set_flashdata('success', 'Staff Loan added successfully');
				redirect('staff-loans-list');
			}
		}

		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = 'staff-loan-add';
		$data['formCustomization'] = $this->formCustomization();
		$data['page'] = 'addEditDynamicForm';
		$this->load->view('main', $data);
	}

	public function edit($id)
	{
		$data['id'] = $id;
		$data['titles'] = array(
			'title'	=>	'Staff Loans',
			'subtitle'	=>	'Edit Staff Loan',
			'listlink'	=>	'staff-loans-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('employee_id', 'Employee', 'required');
			$this->form_validation->set_rules('loan_amount', 'Loan Amount', 'required');
			$this->form_validation->set_rules('loan_tenure', 'Loan Tenure', 'required');
			$this->form_validation->set_rules('loan_last_date', 'Loan Last Date', 'required');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'		=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'employee_id'		=>	$this->input->post('employee_id'),
					'loan_amount'		=>	$this->input->post('loan_amount'),
					'loan_tenure'		=>	$this->input->post('loan_tenure'),
					'loan_last_date'	=>	toDbDateFormat($this->input->post('loan_last_date')),
					'remarks'		=>	$this->input->post('remarks'),
					'updated_at'	=>	currentDateTime(),
					'status'		=>	$status
				);

				$this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);
				$this->session->set_flashdata('success', 'Staff Loan updated successfully');
				redirect('staff-loans-list');
			}
		}

		$data['details'] = $this->common_model->getWhereRow($this->_table, $this->_select, array('id' => $id));
		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = 'staff-loan-edit/'.$id;
		$data['formCustomization'] = $this->formCustomization($data['details']['employee_id'], $data['details']['loan_tenure']);
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

		$data['list'] = $this->Staffloans_Model->getAllStaffLoansListById($id);
		$data['theads'] = ['employee_name'=>'employee_name', 'loan_amount'=>'loan_amount', 'loan_date'=>'loan_date', 'loan_tenure'=>'loan_tenure', 'loan_last_date'=>'loan_last_date', 'status'=>'status', 'remarks'=>'remarks', 'entry_date'=>'entry_date'];

		$data['page'] = 'view';
		$this->load->view('main', $data);
	}

	public function delete($id)
	{
		if($this->_role != 1)
		{
			$this->session->set_flashdata('error', 'Only admin users can delete staff loans.');
			redirect('staff-loans-list');
		}

		$this->common_model->updateWhere($this->_table, array('id' => $id), array(
			'status'		=>	'deleted',
			'updated_at'	=>	currentDateTime()
		));
		$this->session->set_flashdata('success', 'Staff Loan deleted successfully');
		redirect('staff-loans-list');
	}

	public function formCustomization($selectid = '', $tenureid='')
	{
		$data = array(
			'fields'    => array('employee_id', 'loan_amount', 'loan_tenure', 'loan_last_date'),
			'employee_id'	=>	array(
				'name'		=>	'Employee Person',
				'column'	=>	'col-md-12',
				'type'		=>	'select',
				'values'	=>	getDropdownOptions($this->_employee_table, 'name', $selectid)),
			'loan_amount' => array(
				'name'		=>	'Loan Amount',
				'column'	=>	'col-md-6',
				'type'		=>	'text'),
			'loan_tenure' => array(
				'name'		=>	'Loan Tenure',
				'column'	=>	'col-md-6',
				'type'		=>	'select',
				'values'	=>	getLoanTenureOptions($tenureid)),
			'loan_last_date' => array(
				'name'		=>	'Loan Last Date',
				'type'		=>	'text',
				'readonly'	=>	'readonly')
		);
		return $data;
	}
}
