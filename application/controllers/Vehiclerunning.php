<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehiclerunning extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}

		$this->userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
		$this->_role = $this->userdata['role_id'];

		$this->_table = 'vehicle_running_km';
		$this->_vehicle_table = 'vehicles';
		$this->_title = 'Vehicle Running KM';
		$this->_link_start = 'vehicles-running';
		$this->load->model('VehicleRunning_Model');
		$this->_select = 'id,created_at,entry_date,vehicle_id,vehicle_no,party_name,particular,income,start_km,end_km,total_km,amount,diesel_amount,balance,status,remarks';
		
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

		$data['list'] = $this->VehicleRunning_Model->getAllVehicleRunningKm();
		$data['theads'] = ['s_no', 'date', 'vehicle_name', 'particular', 'expenditure', 'income', 'balance', 'remarks', 'status', 'action'];
		$data['tfooter'] = array(
			'colspan' 	=> 4,
			'title'	  	=> 'Total',
			'sum_cols'	=> [4,5,6],
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
			$this->form_validation->set_rules('vehicle_id', 'Vehicle', 'required');
			$this->form_validation->set_rules('vehicle_no', 'Vehicle No', 'required');
			$this->form_validation->set_rules('party_name', 'Party Name', 'required');
			$this->form_validation->set_rules('start_km', 'Start KM', 'required');
			$this->form_validation->set_rules('end_km', 'End KM', 'required');
			$this->form_validation->set_rules('total_km', 'Total KM', 'required');
			$this->form_validation->set_rules('particular', 'Particular', 'required');
			$this->form_validation->set_rules('income', 'Income', 'required');
			$this->form_validation->set_rules('amount', 'Amount', 'required');
			$this->form_validation->set_rules('diesel_amount', 'Diesel Amount', 'required');
			$this->form_validation->set_rules('balance', 'Balance', 'required');
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
					'party_name'	=>	$this->input->post('party_name'),
					'start_km'		=>	$this->input->post('start_km'),
					'end_km'		=>	$this->input->post('end_km'),
					'total_km'		=>	$this->input->post('total_km'),
					'particular'	=>	$this->input->post('particular'),
					'income'		=>	$this->input->post('income'),
					'amount'		=>	$this->input->post('amount'),
					'diesel_amount'	=>	$this->input->post('diesel_amount'),
					'balance'		=>	$this->input->post('balance'),
					'remarks'		=>	$this->input->post('remarks'),
					'created_at'	=>	currentDateTime(),
					'status'		=>	$status
				);

				$this->common_model->insert($this->_table, $insArray);
				$this->session->set_flashdata('success', 'Vehicle Running KM added successfully');
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
			$this->form_validation->set_rules('vehicle_id', 'Vehicle', 'required');
			$this->form_validation->set_rules('vehicle_no', 'Vehicle No', 'required');
			$this->form_validation->set_rules('party_name', 'Party Name', 'required');
			$this->form_validation->set_rules('start_km', 'Start KM', 'required');
			$this->form_validation->set_rules('end_km', 'End KM', 'required');
			$this->form_validation->set_rules('total_km', 'Total KM', 'required');
			$this->form_validation->set_rules('amount', 'Amount', 'required');
			$this->form_validation->set_rules('diesel_amount', 'Diesel Amount', 'required');
			$this->form_validation->set_rules('balance', 'Balance', 'required');
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
					'party_name'	=>	$this->input->post('party_name'),
					'start_km'		=>	$this->input->post('start_km'),
					'end_km'		=>	$this->input->post('end_km'),
					'total_km'		=>	$this->input->post('total_km'),
					'amount'		=>	$this->input->post('amount'),
					'diesel_amount'	=>	$this->input->post('diesel_amount'),
					'balance'		=>	$this->input->post('balance'),
					'remarks'		=>	$this->input->post('remarks'),
					'updated_at'	=>	currentDateTime(),
					'status'		=>	$status
				);

				$this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);
				$this->session->set_flashdata('success', 'Vehicle Running KM updated successfully');
				redirect($this->_link_start.'-list');
			}
		}

		$data['details'] = $this->common_model->getWhereRow($this->_table, $this->_select, array('id' => $id));
		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = $this->_link_start.'-edit/'.$id;
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

		$data['list'] = $this->VehicleRunning_Model->getAllVehicleRunningKmById($id);
		$data['theads'] = ['vehicle_name'=>'vehicle_name', 'vehicle_no'=>'vehicle_no', 'party_name'=>'party_name', 'start_km'=>'start_km', 'end_km'=>'end_km', 'total_km'=>'total_km', 'amount'=>'amount', 'diesel_amount'=>'diesel_amount', 'particular'=>'particular', 'income'=>'income', 'balance'=>'balance', 'remarks'=>'remarks', 'entry_date'=>'entry_date'];

		$data['page'] = 'view';
		$this->load->view('main', $data);
	}

	public function formCustomization($selectid = '', $staffid = '')
	{
		$data = array(
			'fields'    => array('entry_date', 'vehicle_id', 'vehicle_no', 'start_km', 'end_km'),
			'entry_date'	=>	array(
				'name' 		=>  'Date',
				'type'		=>	'date',
				'readonly'	=>	1),
			'vehicle_id'	=>	array(
				'name'		=>	'Vehicle Name',
				'column'	=>	'col-md-6',
				'type'		=>	'select',
				'values'	=>	getDropdownOptions($this->_vehicle_table, 'vehicle_name', $selectid)),
			'vehicle_no' => array(
				'name'		=>	'Vehicle Number',
				'column'	=>	'col-md-6',
				'type'		=>	'text',
				'readonly'	=>	'readonly'),
			'start_km' => array(
				'name'		=>	'Start KM',
				'type'		=>	'text',
				'column'	=>	'col-md-6'),
			'end_km' => array(
				'name'		=>	'End KM',
				'type'		=>	'text',
				'column'	=>	'col-md-6')
		);
		return $data;
	}
}