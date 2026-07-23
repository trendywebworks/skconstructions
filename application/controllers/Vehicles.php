<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Vehicles extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}

		$this->userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
		$this->_role = $this->userdata['role_id'];
		
		$this->_table = 'vehicles';
		$this->_title = 'Vehicles';
		$this->_link_start = 'vehicle';
		$this->_select_view = 'id,created_at,entry_date,vehicle_name,vehicle_no,vehicle_purchase_by,vehicle_emi,down_payment_amount,down_payment_by,remarks';
		$this->load->model('Vehicles_Model');

		$this->load->library('authorization');
		is_permitted();
	}

	public function index()
	{
		$data['titles'] = array(
			'title'	=>	'Vehicles',
			'subtitle'	=>	'View List',
			'addlink'	=>	'vehicle-add',
			'edit'		=>	'vehicle-edit',
			'view'		=>	'vehicle-view',
			'delete'	=>	'vehicle-delete'
		);

		$select = 'id,created_at,entry_date,vehicle_name,vehicle_no,vehicle_purchase_by,vehicle_emi,down_payment_amount,down_payment_by,status,remarks';
		$data['list'] = $this->Vehicles_Model->getAllVehicles();
		$data['theads'] = ['date', 'vehicle_name', 'vehicle_no', 'vehicle_purchase_by', 'vehicle_EMI/M', 'vehicle_down-payment_AMT', 'vehicle_down-payment_by', 'status', 'remarks', 'action'];
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
			'title'	=>	'Vehicles',
			'subtitle'	=>	'Add New',
			'listlink'	=>	'vehicles-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('vehicle_name', 'Vehicle Name', 'required');
			$this->form_validation->set_rules('vehicle_no', 'Vehicle No', 'required|is_unique[vehicles.vehicle_no]');
			$this->form_validation->set_rules('vehicle_purchase_by', 'Purchase By', 'required');
			$this->form_validation->set_rules('vehicle_emi', 'Vehicle EMI/M', 'required');
			$this->form_validation->set_rules('down_payment_amount', 'Down Payment Amount', 'required');
			$this->form_validation->set_rules('down_payment_by', 'Down Payment By', 'required');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'			=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'vehicle_name'			=>	$this->input->post('vehicle_name'),
					'vehicle_no'			=>	$this->input->post('vehicle_no'),
					'vehicle_purchase_by'	=>	$this->input->post('vehicle_purchase_by'),
					'vehicle_emi'			=>	$this->input->post('vehicle_emi'),
					'down_payment_amount'	=>	$this->input->post('down_payment_amount'),
					'down_payment_by'		=>	$this->input->post('down_payment_by'),
					'remarks'		=>	$this->input->post('remarks'),
					'created_at'	=>	currentDateTime(),
					'status'		=>	$status
				);
				$this->common_model->insert($this->_table, $insArray);
				$this->session->set_flashdata('success', 'Vehicle added successfully');
				redirect('vehicles-list');
			}
		}

		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = 'vehicle-add';
		$data['formCustomization'] = $this->formCustomization();
		$data['page'] = 'addEditDynamicForm';
		$this->load->view('main', $data);
	}

	public function edit($id)
	{
		$data['id'] = $id;
		$data['titles'] = array(
			'title'	=>	'Vehicles',
			'subtitle'	=>	'Edit Vehicle',
			'listlink'	=>	'vehicles-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('vehicle_name', 'Vehicle Name', 'required');
			$this->form_validation->set_rules('vehicle_no', 'Vehicle No', 'required|edit_unique[vehicles.vehicle_no.'.$id.']');
			$this->form_validation->set_rules('vehicle_purchase_by', 'Purchase By', 'required');
			$this->form_validation->set_rules('vehicle_emi', 'Vehicle EMI/M', 'required');
			$this->form_validation->set_rules('down_payment_amount', 'Down Payment Amount', 'required');
			$this->form_validation->set_rules('down_payment_by', 'Down Payment By', 'required');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'			=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'vehicle_name'			=>	$this->input->post('vehicle_name'),
					'vehicle_no'			=>	$this->input->post('vehicle_no'),
					'vehicle_purchase_by'	=>	$this->input->post('vehicle_purchase_by'),
					'vehicle_emi'			=>	$this->input->post('vehicle_emi'),
					'down_payment_amount'	=>	$this->input->post('down_payment_amount'),
					'down_payment_by'		=>	$this->input->post('down_payment_by'),
					'remarks'		=>	$this->input->post('remarks'),
					'updated_at'	=>	currentDateTime(),
					'status'		=>	$status
				);
				$this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);
				$this->session->set_flashdata('success', 'Vehicle updated successfully');
				redirect('vehicles-list');
			}
		}

		$select = 'id,created_at,entry_date,vehicle_name,vehicle_no,vehicle_purchase_by,vehicle_emi,down_payment_amount,down_payment_by,status,remarks';
		$data['details'] = $this->common_model->getWhereRow($this->_table, $select, array('id' => $id));
		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = 'vehicle-edit/'.$id;
		$data['formCustomization'] = $this->formCustomization($data['details']['vehicle_purchase_by']);
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

		$data['list'] = $this->Vehicles_Model->getAllVehiclesById($id);
		$data['theads'] = ['vehicle_name'=>'vehicle_name', 'vehicle_no'=>'vehicle_no', 'vehicle_purchase_by'=>'vehicle_purchase_by', 'vehicle_emi'=>'vehicle_emi', 'down_payment_amount'=>'down_payment_amount', 'down_payment_by'=>'down_payment_by', 'status'=>'status', 'remarks'=>'remarks', 'entry_date'=>'entry_date'];

		$data['page'] = 'view';
		$this->load->view('main', $data);
	}

	public function formCustomization($selectid = '')
	{
		$data = array(
			'fields'    => array('vehicle_name', 'vehicle_no', 'vehicle_purchase_by', 'vehicle_emi', 'down_payment_amount', 'down_payment_by'),
			'vehicle_name'	=>	array(
				'name'		=>	'Vehicle Name',
				'column'	=>	'col-md-6',
				'type'		=>	'text'),
			'vehicle_no' => array(
				'name'		=>	'Vehicle No',
				'column'	=>	'col-md-6',
				'type'		=>	'text'),
			'vehicle_purchase_by' => array(
				'name'		=>	'Vehicle Purchase By',
				'column'	=>	'col-md-6',
				'type'		=>	'select',
				'values'	=>	getPurchaseDropdownOptions($selectid)),
			'vehicle_emi'	=> array(
				'name'		=>	'Vehicle EMI/M',
				'column'	=>	'col-md-6',
				'type'		=>	'text'),
			'down_payment_amount'	=> array(
				'name'		=>	'Vehicle Down Payment Amount',
				'column'	=>	'col-md-6',
				'type'		=>	'text'),
			'down_payment_by'	=> array(
				'name'		=>	'Vehicle Down Payment By',
				'column'	=>	'col-md-6',
				'type'		=>	'text')
		);
		return $data;
	}
}
