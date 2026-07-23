<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dailyentry extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}

		$this->_table = 'daily_entry';
		$this->_expense_type_table = 'expense_type';
		$this->_title = 'Daily Entry';
		$this->_link_start = 'daily-entry';
		$this->load->model('Dailyentry_Model');
		$this->_select = 'id,created_at,entry_date,expense_type,expense_id,amount,expense_date,remarks';
	}

	public function index()
	{
		$data['titles'] = array(
			'title'	=>	$this->_title,
			'subtitle'	=>	'View List',
			'addlink'	=>	$this->_link_start.'-add',
			'edit'		=>	$this->_link_start.'-edit',
			'delete'	=>	$this->_link_start.'-delete'
		);
		$data['list'] = $this->Dailyentry_Model->getAllDailyEntryList();
		$data['theads'] = ['date', 'expense_type', 'expense_id', 'amount', 'expense_date', 'remarks', 'action'];
		$data['tfooter'] = array(
			'colspan' 	=> 3,
			'title'	  	=> 'Total',
			'sum_cols'	=> [3],
			'empty' 	=> 3);
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
			$this->form_validation->set_rules('expense_type', 'Expense Type', 'required');
            $this->form_validation->set_rules('expense_id', 'Expense', 'required');
            $this->form_validation->set_rules('amount', 'Amount', 'required');
            $this->form_validation->set_rules('expense_date', 'Expense Date', 'required');

            if($this->form_validation->run() == true)
            {
				$insArray = array(
					'entry_date'			=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'expense_type'			=>	$this->input->post('expense_type'),
					'expense_id'			=>	$this->input->post('expense_id'),
					'amount'				=>	$this->input->post('amount'),
					'expense_date'			=>	date('Y-m-d', strtotime($this->input->post('expense_date'))),
					'remarks'				=>	$this->input->post('remarks'),
					'created_at'			=>	currentDateTime(),
					'status'				=>	'active'
				);
				$this->common_model->insert($this->_table, $insArray);
				$this->session->set_flashdata('success', 'Daily Entry added successfully');
				redirect($this->_link_start.'-list');
			}
		}

		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = $this->_link_start.'-add';
		$data['formCustomization'] = $this->formCustomization();
		// $data['page'] = 'addEditDynamicForm';
		$data['page'] = 'addEditDailyEntry';
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
			$this->form_validation->set_rules('expense_type', 'Expense Type', 'required');
            $this->form_validation->set_rules('expense_id', 'Expense', 'required');
            $this->form_validation->set_rules('amount', 'Amount', 'required');
            $this->form_validation->set_rules('expense_date', 'Expense Date', 'required');

            if($this->form_validation->run() == true)
            {
				$insArray = array(
					'entry_date'			=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'expense_type'			=>	$this->input->post('expense_type'),
					'expense_id'			=>	$this->input->post('expense_id'),
					'amount'				=>	$this->input->post('amount'),
					'expense_date'			=>	date('Y-m-d', strtotime($this->input->post('expense_date'))),
					'remarks'				=>	$this->input->post('remarks'),
					'updated_at'			=>	currentDateTime(),
					'status'				=>	'active'
				);
				$this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);
				$this->session->set_flashdata('success', 'Daily Entry updated successfully');
				redirect($this->_link_start.'-list');
			}
		}

		$data['details'] = $this->common_model->getWhereRow($this->_table, $this->_select, array('id' => $id));
		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = $this->_link_start.'-edit/'.$id;
		$data['formCustomization'] = $this->formCustomization($data['details']['expense_id'], $data['details']['expense_type']);
		$data['page'] = 'addEditDynamicForm';
		$this->load->view('main', $data);
	}

	public function formCustomization($selectid = '', $type='')
	{
		$data = array(
			'fields'    => array('entry_date', 'expense_type', 'expense_id', 'expense_date'),
			'entry_date'	=>	array(
				'name' 		=>  'Date',
				'type'		=>	'date',
				'readonly'	=>	1),
			'expense_type'	=>	array(
				'name' 		=> 'Expense Type',
				'type'		=>	'select',
				'values'	=>	getExpenseDropdownOptions($type)),
			'expense_id'	=>	array(
				'name' 		=> 'Expense',
				'type'		=>	'select',
				'values'	=>	getDropdownOptions($this->_expense_type_table, 'expense_type', $selectid, 1)),
			'expense_date'	=> array(
				'name'		=>	'Expense Date',
				'type'		=>	'date')
		);
		return $data;
	}
}
