<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gstbill extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}

		$this->userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
		$this->_role = $this->userdata['role_id'];
		
		$this->_table = 'gst_bill';
		$this->_suppliers_table = 'suppliers';
		$this->_title = 'GST Bills';
		$this->_link_start = 'gst-bill';
		$this->load->model('Gstbill_Model');
		$this->_select = 'id,created_at,entry_date,supplier_id,particular,quantity,amount,gst,total_amount,status,remarks';

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

		$data['list'] = $this->Gstbill_Model->getAllGstBillsList();
		$data['theads'] = ['s_no', 'date', 'supplier_name', 'particular','amount', 'bill_amount', 'bill_date', 'gst_rate', 'gst_amount', 'remarks', 'status', 'action'];
		$data['tfooter'] = array(
			'colspan' 	=> 3,
			'title'	  	=> 'Total',
			'sum_cols'	=> [4,5,8],
			'empty' 	=> 6);
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
			$this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
            $this->form_validation->set_rules('particular', 'Particular', 'required');
            $this->form_validation->set_rules('quantity', 'Quantity', 'required');
            $this->form_validation->set_rules('amount', 'Amount', 'required');
            $this->form_validation->set_rules('gst', 'GST', 'required');
            $this->form_validation->set_rules('total_amount', 'Total Amount', 'required');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'		=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'supplier_id'		=>	$this->input->post('supplier_id'),
					'particular'		=>	$this->input->post('particular'),
					'quantity'			=>	$this->input->post('quantity'),
					'amount'			=>	$this->input->post('amount'),
					'gst'				=>	$this->input->post('gst'),
					'total_amount'		=>	$this->input->post('total_amount'),
					'remarks'			=>	$this->input->post('remarks'),
					'created_at'		=>	currentDateTime(),
					'status'			=>	$status
				);
				$this->common_model->insert($this->_table, $insArray);
				$this->session->set_flashdata('success', 'GST Bill added successfully');
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
			$this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
            $this->form_validation->set_rules('particular', 'Particular', 'required');
            $this->form_validation->set_rules('quantity', 'Quantity', 'required');
            $this->form_validation->set_rules('amount', 'Amount', 'required');
            $this->form_validation->set_rules('gst', 'GST', 'required');
            $this->form_validation->set_rules('total_amount', 'Total Amount', 'required');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'		=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'supplier_id'		=>	$this->input->post('supplier_id'),
					'particular'		=>	$this->input->post('particular'),
					'quantity'			=>	$this->input->post('quantity'),
					'amount'			=>	$this->input->post('amount'),
					'gst'				=>	$this->input->post('gst'),
					'total_amount'		=>	$this->input->post('total_amount'),
					'remarks'			=>	$this->input->post('remarks'),
					'updated_at'		=>	currentDateTime(),
					'status'			=>	$status
				);
				$this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);
				$this->session->set_flashdata('success', 'GST Bill updated successfully');
				redirect($this->_link_start.'-list');
			}
		}

		$data['details'] = $this->common_model->getWhereRow($this->_table, $this->_select, array('id' => $id));
		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = $this->_link_start.'-edit/'.$id;
		$data['formCustomization'] = $this->formCustomization($data['details']['supplier_id']);
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

		$data['list'] = $this->Gstbill_Model->getAllGstBillsListById($id);
		$data['theads'] = ['firm_name'=>'firm_name', 'particular'=>'particular', 'quantity'=>'quantity', 'amount'=>'amount', 'gst'=>'gst', 'total_amount'=>'total_amount', 'remarks'=>'remarks', 'entry_date'=>'entry_date'];

		$data['page'] = 'view';
		$this->load->view('main', $data);
	}

	public function formCustomization($selectid = '')
	{
		$data = array(
			'fields'    => array('supplier_id', 'quantity', 'amount', 'gst', 'total_amount'),
			'supplier_id'	=>	array(
				'name' 		=> 'Supplier',
				'type'		=>	'select',
				'values'	=>	getDropdownOptions($this->_suppliers_table, 'firm_name', $selectid)),
			'quantity' => array(
				'name'		=>	'Quantity',
				'column'	=>	'col-md-4',
				'type'		=>	'text'),
			'amount' => array(
				'name'		=>	'Amount',
				'column'	=>	'col-md-4',
				'type'		=>	'text'),
			'gst' => array(
				'name'		=>	'GST(%)',
				'column'	=>	'col-md-4',
				'type'		=>	'text'),
			'total_amount'	=>	array(
				'name'		=>	'Total Amount',
				'column'	=>	'col-md-12',
				'type'		=>	'text',
				'readonly'	=>	'readonly')
		);
		return $data;
	}
}
