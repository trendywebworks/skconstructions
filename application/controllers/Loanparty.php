<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Loanparty extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}

		$this->userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
		$this->_role = $this->userdata['role_id'];
		
		$this->_table = 'loan_party';
		$this->_title = 'Loan Party';
		$this->_link_start = 'loan-party';
		$this->_select_view = 'id,created_at,entry_date,party_name,phone,address,status,remarks';

		$this->load->library('authorization');
		is_permitted();
	}

	public function index()
	{
		$data['titles'] = array(
			'title'		=>	'Loan Party',
			'subtitle'	=>	'View List',
			'addlink'	=>	'loan-party-add',
			'edit'		=>	'loan-party-edit',
			'view'		=>	'loan-party-view',
			'delete'	=>	'loan-party-delete'
		);
		$data['theads'] = ['date', 'party_name', 'phone_number', 'address', 'status', 'remarks', 'action'];

		$select = 'id,created_at,entry_date,party_name,phone,address,status,remarks';
		$data['list'] = $this->common_model->getAllWhereSelectList($this->_table, $select, array('status != ' => 'deleted'));
		$data['page'] = 'list';
		$this->load->view('main', $data);
	}

	public function add()
	{
		$data['titles'] = array(
			'title'	=>	'Loan Party',
			'subtitle'	=>	'Add New',
			'listlink'	=>	'loan-party-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('party_name', 'Party Name', 'required');
            $this->form_validation->set_rules('phone', 'Phone', 'required|is_unique[loan_party.phone]');
            $this->form_validation->set_rules('address', 'Address', 'required');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'party_name'=>	$this->input->post('party_name'),
					'phone'		=>	$this->input->post('phone'),
					'address'	=>	$this->input->post('address'),
					'remarks'	=>	$this->input->post('remarks'),
					'created_at'=>	currentDateTime(),
					'status'	=>	$status
				);
				$this->common_model->insert($this->_table, $insArray);
				$this->session->set_flashdata('success', 'Loan party added successfully');
				redirect('loan-party-list');
			}
		}

		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = 'loan-party-add';
		$data['page'] = 'addEditDynamicForm';
		$this->load->view('main', $data);
	}

	public function edit($id)
	{
		$data['id'] = $id;
		$data['titles'] = array(
			'title'	=>	'Loan Party',
			'subtitle'	=>	'Edit Loan Party',
			'listlink'	=>	'loan-party-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('party_name', 'Party Name', 'required');
            $this->form_validation->set_rules('phone', 'Phone', 'required|edit_unique[loan_party.phone.'.$id.']');
            $this->form_validation->set_rules('address', 'Address', 'required');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'party_name'=>	$this->input->post('party_name'),
					'phone'		=>	$this->input->post('phone'),
					'address'	=>	$this->input->post('address'),
					'remarks'	=>	$this->input->post('remarks'),
					'updated_at'=>	currentDateTime(),
					'status'	=>	$status
				);
				$this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);
				$this->session->set_flashdata('success', 'Loan party added successfully');
				redirect('loan-party-list');
			}
		}

		$select = 'id,created_at,entry_date,party_name,phone,address,status,remarks';
		$data['details'] = $this->common_model->getWhereRow($this->_table, $select, array('id' => $id));
		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = 'loan-party-edit/'.$id;
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
		$data['theads'] = ['party_name'=>'party_name', 'phone'=>'phone_number', 'address'=>'address', 'status'=>'status', 'remarks'=>'remarks', 'entry_date'=>'entry_date'];

		$data['page'] = 'view';
		$this->load->view('main', $data);
	}

}
