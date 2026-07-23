<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Purchase extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}

		$this->userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
		$this->_role = $this->userdata['role_id'];
		
		$this->_table = 'purchase';
		$this->_purchase_details_table = 'purchase_details';
		$this->_suppliers_table = 'suppliers';
		$this->_title = 'Purchases';
		$this->_link_start = 'purchase';
		$this->load->model('Purchase_Model');
		$this->_select = 'id,created_at,entry_date,reference_no,purchase_date,supplier_id,total_amount,remarks';

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

		$data['list'] = $this->Purchase_Model->getAllPurchasesList();
		$data['theads'] = ['s_no', 'date', 'supplier_name', 'bill_amount', 'gst', 'total_amount', 'quantity', 'bill_date', 'remarks', 'status', 'action'];
		$data['tfooter'] = array(
			'colspan' 	=> 3,
			'title'	  	=> 'Total',
			'sum_cols'	=> [3,4,5],
			'empty' 	=> 5);
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

			// $this->form_validation->set_rules('reference_no', 'Reference No', 'required');
   //          $this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
   //          $this->form_validation->set_rules('particular', 'Particular', 'required');
   //          $this->form_validation->set_rules('quantity', 'Quantity', 'required');
   //          $this->form_validation->set_rules('amount', 'Amount', 'required');
   //          $this->form_validation->set_rules('gst', 'GST', 'required');
   //          $this->form_validation->set_rules('total_amount', 'Total Amount', 'required');

				// if($this->_role == 1 ) 
				// {
				// 	$this->form_validation->set_rules('status', 'Status', 'required');
				// }

	   //          if($this->form_validation->run() == true)
	   //          {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'			=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'reference_no'			=>	$this->input->post('reference_no'),
					'purchase_date'			=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'supplier_id'			=>	$this->input->post('supplier_id'),
					// 'particular'			=>	$this->input->post('particular'),
					// 'quantity'				=>	$this->input->post('quantity'),
					// 'amount'				=>	$this->input->post('amount'),
					// 'gst'					=>	$this->input->post('gst'),
					'total_amount'			=>	$this->input->post('total_amount'),
					'remarks'				=>	$this->input->post('remarks'),
					'created_at'			=>	currentDateTime(),
					'status'				=>	$status
				);
				$insert_id = $this->common_model->insert($this->_table, $insArray);
				if($insert_id)
				{
					if(count($this->input->post('particular')) > 0)
					{
						foreach($this->input->post('particular') as $pdkey => $pd)
						{
							$insdetails = array(
								'purchase_id'	=>	$insert_id,
								'particular'	=>	$pd,
								'quantity'		=>	$this->input->post('quantity')[$pdkey],
								'amount'		=>	$this->input->post('amount')[$pdkey],
								'subtotal'		=>	$this->input->post('subtotal')[$pdkey],
								'gst'			=>	$this->input->post('gst')[$pdkey],
								'gst_amount'	=>	$this->input->post('gst_amount')[$pdkey],
								'total'			=>	$this->input->post('total')[$pdkey],
								'created_at'	=>	currentDateTime(),
								'status'		=>	'active'
							);
							$this->common_model->insert($this->_purchase_details_table, $insdetails);
						}
					}
				// }
				$this->session->set_flashdata('success', 'Purchase added successfully');
				redirect($this->_link_start.'-list');
			}
		}

		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = $this->_link_start.'-add';

		$lastId = $this->common_model->get_last_id($this->_table, 'id');
		$referenceNo = $lastId+1;
		$data['referenceNo'] = str_pad($referenceNo, 5, '0', STR_PAD_LEFT);

		$data['suppliers'] = getDropdownOptions($this->_suppliers_table, 'firm_name', '');
		$data['formCustomization'] = $this->formCustomization();
		$data['page'] = 'addEditPurchase';
		// $data['page'] = 'addEditDynamicForm';
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
		{ //echo '<pre>';print_r($_POST);exit;
			$formData = $this->input->post();
			$data['postData'] = $formData;

			// $this->form_validation->set_rules('reference_no', 'Reference No', 'required');
   //          $this->form_validation->set_rules('supplier_id', 'Supplier', 'required');
   //          $this->form_validation->set_rules('particular', 'Particular', 'required');
   //          $this->form_validation->set_rules('quantity', 'Quantity', 'required');
   //          $this->form_validation->set_rules('amount', 'Amount', 'required');
   //          $this->form_validation->set_rules('gst', 'GST', 'required');
   //          $this->form_validation->set_rules('total_amount', 'Total Amount', 'required');

   //         if($this->_role == 1 ) 
			// {
			// 	$this->form_validation->set_rules('status', 'Status', 'required');
			// }

            // if($this->form_validation->run() == true)
            // {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'			=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'reference_no'			=>	$this->input->post('reference_no'),
					'purchase_date'			=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'supplier_id'			=>	$this->input->post('supplier_id'),
					// 'particular'			=>	$this->input->post('particular'),
					// 'quantity'				=>	$this->input->post('quantity'),
					// 'amount'				=>	$this->input->post('amount'),
					// 'gst'					=>	$this->input->post('gst'),
					'total_amount'			=>	$this->input->post('total_amount'),
					'remarks'				=>	$this->input->post('remarks'),
					'created_at'			=>	currentDateTime(),
					'status'				=>	$status
				);
				$upd = $this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);
				if($upd)
				{
					//update exists
					if(!empty($this->input->post('particular')) && count($this->input->post('purchase_details_id')) > 0)
					{
						foreach($this->input->post('purchase_details_id') as $pidkey => $pid)
						{
							$insdetails = array(
								'purchase_id'	=>	$id,
								'particular'	=>	$this->input->post('edit_particular')[$pidkey],
								'quantity'		=>	$this->input->post('edit_quantity')[$pidkey],
								'amount'		=>	$this->input->post('edit_amount')[$pidkey],
								'subtotal'		=>	$this->input->post('edit_subtotal')[$pidkey],
								'gst'			=>	$this->input->post('edit_gst')[$pidkey],
								'gst_amount'	=>	$this->input->post('edit_gst_amount')[$pidkey],
								'total'			=>	$this->input->post('edit_total')[$pidkey],
								'created_at'	=>	currentDateTime(),
								'status'		=>	'active'
							);
							$this->common_model->updateWhere($this->_purchase_details_table, array('id' => $pid), $insdetails);
						}
					}

					//insert new
					if(!empty($this->input->post('particular')) && count($this->input->post('particular')) > 0)
					{
						foreach($this->input->post('particular') as $pdkey => $pd)
						{
							$insdetails = array(
								'purchase_id'	=>	$id,
								'particular'	=>	$pd,
								'quantity'		=>	$this->input->post('quantity')[$pdkey],
								'amount'		=>	$this->input->post('amount')[$pdkey],
								'subtotal'		=>	$this->input->post('subtotal')[$pdkey],
								'gst'			=>	$this->input->post('gst')[$pdkey],
								'gst_amount'	=>	$this->input->post('gst_amount')[$pdkey],
								'total'			=>	$this->input->post('total')[$pdkey],
								'created_at'	=>	currentDateTime(),
								'status'		=>	'active'
							);
							$this->common_model->insert($this->_purchase_details_table, $insdetails);
						}
					}
				}
				$this->session->set_flashdata('success', 'Purchase updated successfully');
				redirect($this->_link_start.'-list');
			// }
		}

		$data['details'] = $this->Purchase_Model->getPurchaseDataRow($id);
		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = $this->_link_start.'-edit/'.$id;
		// $data['formCustomization'] = $this->formCustomization($data['details']['supplier_id']);
		$data['suppliers'] = getDropdownOptions($this->_suppliers_table, 'firm_name', $data['details'][0]['supplier_id']);
		$data['page'] = 'addEditPurchase';
		// $data['page'] = 'addEditDynamicForm';
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

		$data['list'] = $this->Purchase_Model->getPurchaseDataById($id);//echo '<pre>';print_r($data['list']);exit;
		$data['theads'] = ['full_name'=>'full_name', 'phone_number'=>'phone_number', 'email_address'=>'email_address', 'id_proof'=>'ID_proof', 'status'=>'status', 'remarks'=>'remarks', 'entry_date'=>'entry_date'];

		$data['page'] = 'viewPurchase';
		$this->load->view('main', $data);
	}

	public function formCustomization($selectid = '')
	{
		$lastId = $this->common_model->get_last_id($this->_table, 'id');
		$referenceNo = $lastId+1;
		$referenceNo = str_pad($referenceNo, 5, '0', STR_PAD_LEFT);
		$data = array(
			'fields'    => array('entry_date','reference_no', 'purchase_date', 'supplier_id', 'quantity', 'amount', 'gst', 'total_amount'),
			'entry_date'	=>	array(
				'name' 		=>  'Date',
				'type'		=>	'date',
				'readonly'	=>	1),
			'reference_no'	=>	array(
				'name' 		=> 'Reference No',
				'type'		=>	'text',
				'readonly'	=>	'readonly',
				'value'		=>	$referenceNo),
			'purchase_date'	=>	array(
				'exclude'	=>	1),
			'supplier_id'	=>	array(
				'name' 		=> 'Supplier',
				'type'		=>	'select',
				'values'	=>	getDropdownOptions($this->_suppliers_table, 'firm_name', $selectid)),
			'quantity' => array(
				'name'		=>	'Quantity',
				'type'		=>	'text',
				'column'	=>	'col-md-4'),
			'amount' => array(
				'name'		=>	'Amount',
				'type'		=>	'text',
				'column'	=>	'col-md-4'),
			'gst'	=> array(
				'name'		=>	'GST(%)',
				'column'	=>	'col-md-4',
				'type'		=>	'text'),
			'total_amount' => array(
				'name'		=>	'Total Amount',
				'readonly'	=>	'readonly',
				'type'		=>	'text'),
		);
		return $data;
	}
}
