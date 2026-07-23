<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Paytopartner extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}

		$this->userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
		$this->_role = $this->userdata['role_id'];
		$this->_table = 'pay_partner';
		$this->_partner_table = 'partners';
		$this->load->model('Paytopartner_Model');
		$this->_title = 'Partner Payments';
		$this->_link_start = 'pay-partner';
		$this->_select_view = 'id,created_at,entry_date,p_id,expense,amount,pay_for,remarks,status';

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

		$data['list'] = $this->Paytopartner_Model->getAllPayList();
		$data['theads'] = ['date', 'partner', 'amount', 'pay_for', 'pay_type', 'status', 'remarks', 'action'];
		$data['tfooter'] = array(
			'colspan' 	=> 2,
			'title'	  	=> 'Total',
			'sum_cols'	=> [2],
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

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('p_id', 'Partner', 'required');
			$this->form_validation->set_rules('amount', 'Amount', 'required');
			$this->form_validation->set_rules('pay_for', 'Pay For', 'required');
			$this->form_validation->set_rules('pay_type', 'Pay Type', 'required');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':'active';

            	if($this->_role == 1)
            	{
            		$status = $this->input->post('status');
            	}
            	
				$insArray = array(
					'entry_date'	=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'p_id'			=>	$this->input->post('p_id'),
					'amount'		=>	$this->input->post('amount'),
					'pay_for'		=>	$this->input->post('pay_for'),
					'pay_type'		=>	$this->input->post('pay_type'),
					'remarks'		=>	$this->input->post('remarks'),
					'created_at'	=>	currentDateTime(),
					'status'		=>	$status
				);
				$this->common_model->insert($this->_table, $insArray);
				$this->session->set_flashdata('success', $this->_title.' added successfully');
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
			$this->form_validation->set_rules('p_id', 'Partner', 'required');
			$this->form_validation->set_rules('amount', 'Amount', 'required');
			$this->form_validation->set_rules('pay_for', 'Pay For', 'required');
			$this->form_validation->set_rules('pay_type', 'Pay Type', 'required');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':'active';

            	if($this->_role == 1)
            	{
            		$status = $this->input->post('status');
            	}

				$insArray = array(
					'entry_date'	=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'p_id'			=>	$this->input->post('p_id'),
					'amount'		=>	$this->input->post('amount'),
					'pay_for'		=>	$this->input->post('pay_for'),
					'pay_type'		=>	$this->input->post('pay_type'),
					'remarks'		=>	$this->input->post('remarks'),
					'updated_at'	=>	currentDateTime(),
					'status'		=>	$status
				);
				$this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);
				$this->session->set_flashdata('success', $this->_title.' updated successfully');
				redirect($this->_link_start.'-list');
			}
		}

		$select = 'id,created_at,entry_date,p_id,amount,pay_for,pay_type,remarks,status';
		$data['details'] = $this->common_model->getWhereRow($this->_table, $select, array('id' => $id));
		$data['fields'] = $this->db->field_data($this->_table);
		$data['formCustomization'] = $this->formCustomization($data['details']['p_id'], $data['details']['pay_type']);
		$data['action'] = $this->_link_start.'-edit/'.$id;
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

		$data['list'] = $this->Paytopartner_Model->getAllPayListById($id);
		$data['theads'] = ['partner_name'=>'partner', 'amount'=>'amount', 'pay_for'=>'pay_for', 'pay_type'=>'pay_type', 'remarks'=>'remarks', 'entry_date'=>'entry_date'];

		$data['page'] = 'view';
		$this->load->view('main', $data);
	}

	public function formCustomization($selectid = '', $type = '')
	{
		$data = array(
			'fields'    => array('p_id', 'pay_type'),
			'p_id'	=>	array(
				'name' 		=> 'partner',
				'type'		=>	'select',
				'values'	=>	getDropdownOptions($this->_partner_table, 'full_name', $selectid)),
			'pay_type'	=>	array(
				'name' 		=> 'Pay Type',
				'type'		=>	'select',
				'values'	=>	getPayTypeDropdownOptions($type))
		);
		return $data;
	}
}
