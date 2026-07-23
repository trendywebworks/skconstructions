<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Fdr extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}

		$this->userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
		$this->_role = $this->userdata['role_id'];
		
		$this->_table = 'fdr';
		$this->_title = 'FDR';
		$this->_link_start = 'fdr';

		$this->load->library('authorization');
		is_permitted();
		// $this->load->model('Gstbill_Model');
		$this->_select = 'id,created_at,entry_date,name,description,amount,released_amount,status,remarks';
		$this->_select_view = "id,created_at,entry_date,name,description,CONCAT('₹', format(amount,2)) as amount,,CONCAT('₹', format(released_amount,2)) as released_amount,status,remarks";
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

		$this->_select = "id,created_at,entry_date,name,description,CONCAT('₹', format(amount,2)) as amount,,CONCAT('₹', format(released_amount,2)) as released_amount,status,remarks";
		$data['list'] = $this->common_model->getAllWhereSelectList($this->_table, $this->_select, array('status != ' => 'deleted'));
		$data['theads'] = ['date', 'name', 'description', 'amount', 'released_amount', 'status', 'remarks', 'action'];
		$data['tfooter'] = array(
			'colspan' 	=> 3,
			'title'	  	=> 'Total',
			'sum_cols'	=> [3,4],
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
			$this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('amount', 'Amount', 'required');
            $this->form_validation->set_rules('released_amount', 'Released Amount', 'required');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'		=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'name'				=>	$this->input->post('name'),
					'description'		=>	$this->input->post('description'),
					'amount'			=>	$this->input->post('amount'),
					'released_amount'	=>	$this->input->post('released_amount'),
					'remarks'			=>	$this->input->post('remarks'),
					'created_at'		=>	currentDateTime(),
					'status'			=>	$status
				);
				$this->common_model->insert($this->_table, $insArray);
				$this->session->set_flashdata('success', 'FDR added successfully');
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
			$this->form_validation->set_rules('name', 'Name', 'required');
            $this->form_validation->set_rules('description', 'Description', 'required');
            $this->form_validation->set_rules('amount', 'Amount', 'required');
            $this->form_validation->set_rules('released_amount', 'Released Amount', 'required');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'		=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'name'				=>	$this->input->post('name'),
					'description'		=>	$this->input->post('description'),
					'amount'			=>	$this->input->post('amount'),
					'released_amount'	=>	$this->input->post('released_amount'),
					'remarks'			=>	$this->input->post('remarks'),
					'updated_at'		=>	currentDateTime(),
					'status'			=>	$status
				);
				$this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);
				$this->session->set_flashdata('success', 'FDR updated successfully');
				redirect($this->_link_start.'-list');
			}
		}

		$data['details'] = $this->common_model->getWhereRow($this->_table, $this->_select, array('id' => $id));
		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = $this->_link_start.'-edit/'.$id;
		$data['formCustomization'] = $this->formCustomization();
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

		$data['list'] = $this->common_model->getAllWhereSelectListRow($this->_table, $this->_select_view, array('id' => $id));
		$data['theads'] = ['name'=>'name', 'description'=>'description', 'amount'=>'amount', 'released_amount'=>'released_amount', 'remarks'=>'remarks', 'entry_date'=>'entry_date'];

		$data['page'] = 'view';
		$this->load->view('main', $data);
	}

	public function formCustomization($selectid = '')
	{
		$data = array(
			'fields'    => array('entry_date'),
			'entry_date'	=>	array(
				'name' 		=>  'Date',
				'type'		=>	'date',
				'readonly'	=>	1)
		);
		return $data;
	}
}
