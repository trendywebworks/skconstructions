<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Officeexpense extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}

		$this->userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
		$this->_role = $this->userdata['role_id'];
		
		$this->_table = 'office_expenses';
		$this->_expense_type_table = 'expense_type';
		$this->_office_staffs_table = 'office_staffs';
		$this->_title = 'Office Expense';
		$this->_link_start = 'office-expense';
		$this->load->model('Officeexpense_Model');
		$this->_select = 'id,created_at,entry_date,expense_type_id,staff_id,amount,status,remarks';

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
		
		$data['list'] = $this->Officeexpense_Model->getAllOfficeExpensesList();
		$data['theads'] = ['s_no', 'date', 'particular',  'amount', 'remarks', 'action'];
// 		$data['theads'] = ['date', 'type', 'concern_person', 'amount', 'status', 'remarks', 'action'];
		$data['tfooter'] = array(
			'colspan' 	=> 3,
			'title'	  	=> 'Total',
			'sum_cols'	=> [3],
			'empty' 	=> 2);
		$data['allow_delete'] = ($this->_role == 1);
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
			$this->form_validation->set_rules('expense_type_id', 'Expense Type', 'required');
            $this->form_validation->set_rules('staff_id', 'Concern Person', 'required');
            $this->form_validation->set_rules('amount', 'Amount', 'required');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'			=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'expense_type_id'		=>	$this->input->post('expense_type_id'),
					'staff_id'				=>	$this->input->post('staff_id'),
					'amount'				=>	$this->input->post('amount'),
					'remarks'				=>	$this->input->post('remarks'),
					'created_at'			=>	currentDateTime(),
					'status'				=>	$status
				);
				$this->common_model->insert($this->_table, $insArray);
				$this->session->set_flashdata('success', 'Office Expenses added successfully');
				redirect($this->_link_start.'-list');
			}
		}

		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = $this->_link_start.'-add';
		$data['formCustomization'] = $this->formCustomization();
		$data['page'] = 'addEditDynamicForm';
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
			$this->form_validation->set_rules('expense_type_id', 'Expense Type', 'required');
            $this->form_validation->set_rules('staff_id', 'Concern Person', 'required');
            $this->form_validation->set_rules('amount', 'Amount', 'required');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'			=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'expense_type_id'		=>	$this->input->post('expense_type_id'),
					'staff_id'				=>	$this->input->post('staff_id'),
					'amount'				=>	$this->input->post('amount'),
					'remarks'				=>	$this->input->post('remarks'),
					'updated_at'			=>	currentDateTime(),
					'status'				=>	$status
				);
				$this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);
				$this->session->set_flashdata('success', 'Office Expenses updated successfully');
				redirect($this->_link_start.'-list');
			}
		}

		$data['details'] = $this->common_model->getWhereRow($this->_table, $this->_select, array('id' => $id));
		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = $this->_link_start.'-edit/'.$id;
		$data['formCustomization'] = $this->formCustomization($data['details']['expense_type_id'], $data['details']['staff_id']);
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

		$data['list'] = $this->Officeexpense_Model->getAllOfficeExpensesListById($id);
		$data['theads'] = ['expense_name'=>'expense_name', 'staff_name'=>'staff_name', 'amount'=>'amount', 'status'=>'status', 'remarks'=>'remarks', 'entry_date'=>'entry_date'];

		$data['page'] = 'view';
		$this->load->view('main', $data);
	}

	public function delete($id)
	{
		if($this->_role != 1)
		{
			$this->session->set_flashdata('error', 'Only admin users can delete office expenses.');
			redirect('office-expense-list');
		}

		$this->common_model->updateWhere($this->_table, array('id' => $id), array(
			'status'		=>	'deleted',
			'updated_at'	=>	currentDateTime()
		));
		$this->session->set_flashdata('success', 'Office Expense deleted successfully');
		redirect('office-expense-list');
	}

	public function formCustomization($selectid = '', $staffid = '')
	{
		$data = array(
			'fields'    => array('expense_type_id', 'staff_id', 'interest', 'total_amount'),
			'expense_type_id'	=>	array(
				'name' 		=> 'Expense Type',
				'type'		=>	'select',
				'values'	=>	getDropdownOptions($this->_expense_type_table, 'expense_type', $selectid)),
			'staff_id'	=>	array(
				'name' 		=> 'Concern Person',
				'type'		=>	'select',
				'values'	=>	getDropdownOptions($this->_office_staffs_table, 'name', $staffid))
		);
		return $data;
	}
}
