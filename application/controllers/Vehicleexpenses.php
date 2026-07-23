<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicleexpenses extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}

		$this->userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
		$this->_role = $this->userdata['role_id'];
		
		$this->_table = 'vehicle_expenses';
		$this->_vehicle_table = 'vehicles';
		$this->_title = 'Vehicle Expenses';
		$this->_link_start = 'vehicles-expense';
		$this->_select = 'id,created_at,vehicle_id,vehicle_no,particular,amount,income,status,remarks';
		$this->load->model('VehicleExpenses_Model');

		$this->load->library('authorization');
		is_permitted();
	}

	public function index()
	{
		$data['titles'] = array(
			'title'	=>	'Vehicle Expenses',
			'subtitle'	=>	'View List',
			'addlink'	=>	'vehicles-expense-add',
			'edit'		=>	'vehicles-expense-edit',
			'view'		=>	'vehicles-expense-view',
			'delete'	=>	'vehicles-expense-delete'
		);

		$data['list'] = $this->VehicleExpenses_Model->getAllVehicleExpenses();
		$data['theads'] = ['s_no', 'date', 'vehicle_name', 'particular', 'expenditure', 'income','remarks', 'status', 'action'];
		$data['tfooter'] = array(
			'colspan' 	=> 4,
			'title'	  	=> 'Total',
			'sum_cols'	=> [4,5],
			'empty' 	=> 3);
		$data['page'] = 'list';
		$this->load->view('main', $data);
	}

	public function add()
	{
		$data['titles'] = array(
			'title'	=>	'Vehicle Expenses',
			'subtitle'	=>	'Add New',
			'listlink'	=>	'vehicles-expenses-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('vehicle_id', 'Vehicle', 'required');
			$this->form_validation->set_rules('vehicle_no', 'Vehicle No', 'required');
			$this->form_validation->set_rules('particular', 'Particular', 'required');
			$this->form_validation->set_rules('amount', 'Amount', 'required');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'	=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'vehicle_id'	=>	$this->input->post('vehicle_id'),
					'vehicle_no'	=>	$this->input->post('vehicle_no'),
					'particular'	=>	$this->input->post('particular'),
					'amount'		=>	$this->input->post('amount'),
					'income'		=>	$this->input->post('income'),
					'remarks'		=>	$this->input->post('remarks'),
					'created_at'	=>	currentDateTime(),
					'status'		=>	$status
				);

				$this->common_model->insert($this->_table, $insArray);
				$this->session->set_flashdata('success', 'Vehicle Expense added successfully');
				redirect('vehicles-expenses-list');
			}
		}

		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = 'vehicles-expense-add';
		$data['formCustomization'] = $this->formCustomization();
		$data['page'] = 'addEditDynamicForm';
		$this->load->view('main', $data);
	}

	public function edit($id)
	{
		$data['id'] = $id;
		$data['titles'] = array(
			'title'	=>	'Vehicle Expenses',
			'subtitle'	=>	'Edit Vehicle Expenses',
			'listlink'	=>	'vehicles-expenses-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('vehicle_id', 'Vehicle', 'required');
			$this->form_validation->set_rules('vehicle_no', 'Vehicle No', 'required');
			$this->form_validation->set_rules('particular', 'Particular', 'required');
			$this->form_validation->set_rules('amount', 'Amount', 'required');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'	=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'vehicle_id'	=>	$this->input->post('vehicle_id'),
					'vehicle_no'	=>	$this->input->post('vehicle_no'),
					'particular'	=>	$this->input->post('particular'),
					'amount'		=>	$this->input->post('amount'),
					'income'		=>	$this->input->post('income'),
					'remarks'		=>	$this->input->post('remarks'),
					'updated_at'	=>	currentDateTime(),
					'status'		=>	$status
				);

				$this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);
				$this->session->set_flashdata('success', 'Vehicle Expense updated successfully');
				redirect('vehicles-expenses-list');
			}
		}

		$data['details'] = $this->common_model->getWhereRow($this->_table, $this->_select, array('id' => $id));
		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = 'vehicles-expense-edit/'.$id;
		$data['formCustomization'] = $this->formCustomization($data['details']['vehicle_id']);
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

		$data['list'] = $this->VehicleExpenses_Model->getAllVehicleExpensesById($id);
		$data['theads'] = ['vehicle_name'=>'vehicle_name', 'vehicle_no'=>'vehicle_no', 'particular'=>'Particular', 'amount'=>'amount', 'income'=>'income', 'remarks'=>'remarks', 'entry_date'=>'entry_date'];

		$data['page'] = 'view';
		$this->load->view('main', $data);
	}

	public function formCustomization($selectid = '')
	{
		$data = array(
			'fields'    => array('vehicle_id', 'vehicle_no', 'loan_tenure', 'loan_last_date'),
			'vehicle_id'	=>	array(
				'name'		=>	'Vehicle Name',
				'column'	=>	'col-md-6',
				'type'		=>	'select',
				'values'	=>	getDropdownOptions($this->_vehicle_table, 'vehicle_name', $selectid)),
			'vehicle_no' => array(
				'name'		=>	'Vehicle Number',
				'column'	=>	'col-md-6',
				'type'		=>	'text',
				'readonly'	=>	'readonly')
		);
		return $data;
	}

	public function getVehicleNo()
	{
		$vehicle_id = $this->input->post('vehicle_id');
		$row = $this->common_model->getWhereRow($this->_vehicle_table, 'vehicle_no', array('id'=>$vehicle_id));
		echo json_encode($row['vehicle_no']);
	}
}
