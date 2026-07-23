<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Supplier extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}

		$this->userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
		$this->_role = $this->userdata['role_id'];
		
		$this->_table = 'suppliers';
		$this->_title = 'Suppliers';
		$this->_link_start = 'supplier';
		$this->_select_view = 'id,created_at,entry_date,firm_name,contact_person,address,phone_number,email_address,status,remarks';

		$this->load->library('authorization');
		is_permitted();
	}

	public function index()
	{
		$data['titles'] = array(
			'title'	=>	'Suppliers',
			'subtitle'	=>	'View List',
			'addlink'	=>	'supplier-add',
			'edit'		=>	'supplier-edit',
			'view'		=>	'supplier-view',
			'delete'	=>	'supplier-delete'
		);

		$select = 'id,created_at,entry_date,firm_name,contact_person,address,phone_number,email_address,status,remarks';
		$data['list'] = $this->common_model->getAllWhereSelectList($this->_table, $select, array('status != ' => 'deleted'));
		$data['theads'] = ['date', 'firm_name', 'contact_person', 'address', 'phone_number', 'email-address', 'status', 'remarks', 'action'];
		$data['allow_delete'] = ($this->_role == 1);
		$data['page'] = 'list';
		$this->load->view('main', $data);
	}

	public function add()
	{
		$data['titles'] = array(
			'title'	=>	'Suppliers',
			'subtitle'	=>	'Add New',
			'listlink'	=>	'suppliers-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('firm_name', 'Firm Name', 'required');
            $this->form_validation->set_rules('contact_person', 'Contact Person', 'required');
            $this->form_validation->set_rules('phone_number', 'Phone Number', 'required|is_unique[suppliers.phone_number]');
            $this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email|is_unique[suppliers.email_address]');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'		=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'firm_name'			=>	$this->input->post('firm_name'),
					'contact_person'	=>	$this->input->post('contact_person'),
					'address'			=>	$this->input->post('address'),
					'phone_number'		=>	$this->input->post('phone_number'),
					'email_address'		=>	$this->input->post('email_address'),
					'remarks'			=>	$this->input->post('remarks'),
					'created_at'		=>	currentDateTime(),
					'status'			=>	$status
				);
				$this->common_model->insert($this->_table, $insArray);
				$this->session->set_flashdata('success', 'Supplier added successfully');
				redirect('suppliers-list');
			}
		}

			$data['fields'] = $this->db->field_data($this->_table);
			$data['action'] = 'supplier-add';
			$data['formCustomization'] = $this->formCustomization();
			$data['formLayout'] = 'supplier';
			$data['submitButtonClass'] = 'btn-lg';
			$data['page'] = 'addEditDynamicForm';
			$this->load->view('main', $data);
		}

	public function edit($id)
	{
		$data['id'] = $id;
		$data['titles'] = array(
			'title'	=>	'Suppliers',
			'subtitle'	=>	'Supplier Edit',
			'listlink'	=>	'suppliers-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('firm_name', 'Firm Name', 'required');
            $this->form_validation->set_rules('contact_person', 'Contact Person', 'required');
            $this->form_validation->set_rules('phone_number', 'Phone Number', 'required|edit_unique[suppliers.phone_number.'.$id.']');
            $this->form_validation->set_rules('email_address', 'Email Address', 'required|valid_email|edit_unique[suppliers.email_address.'.$id.']');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'		=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'firm_name'			=>	$this->input->post('firm_name'),
					'contact_person'	=>	$this->input->post('contact_person'),
					'address'			=>	$this->input->post('address'),
					'phone_number'		=>	$this->input->post('phone_number'),
					'email_address'		=>	$this->input->post('email_address'),
					'remarks'			=>	$this->input->post('remarks'),
					'updated_at'		=>	currentDateTime(),
					'status'			=>	$status
				);
				$this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);
				$this->session->set_flashdata('success', 'Supplier updated successfully');
				redirect('suppliers-list');
			}
		}

		$select = 'id,created_at,entry_date,firm_name,contact_person,address,phone_number,email_address,status,remarks';
			$data['details'] = $this->common_model->getWhereRow($this->_table, $select, array('id' => $id));
			$data['fields'] = $this->db->field_data($this->_table);
			$data['action'] = 'supplier-edit/'.$id;
			$data['formCustomization'] = $this->formCustomization();
			$data['formLayout'] = 'supplier';
			$data['submitButtonClass'] = 'btn-lg';
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

		$data['list'] = $this->common_model->getAllWhereSelectListRow($this->_table, $this->_select_view, array('id' => $id));
		$data['theads'] = ['firm_name'=>'firm_name', 'contact_person'=>'contact_person', 'address'=>'address', 'email_address'=>'email-address', 'phone_number'=>'phone_number', 'status'=>'status', 'remarks'=>'remarks', 'entry_date'=>'entry_date'];

		$data['page'] = 'view';
		$this->load->view('main', $data);
	}

	public function delete($id)
	{
		if($this->_role != 1)
		{
			$this->session->set_flashdata('error', 'Only admin users can delete suppliers.');
			redirect('suppliers-list');
		}

		$this->common_model->updateWhere($this->_table, array('id' => $id), array(
			'status'		=>	'deleted',
			'updated_at'	=>	currentDateTime()
		));
		$this->session->set_flashdata('success', 'Supplier deleted successfully');
		redirect('suppliers-list');
	}

	private function formCustomization()
	{
		return array(
			'fields'	=>	array('firm_name', 'contact_person', 'phone_number', 'email_address', 'address', 'remarks'),
			'firm_name'	=>	array(
				'name'		=>	'Firm Name',
				'type'		=>	'text',
				'column'	=>	'col-md-6'),
			'contact_person'	=>	array(
				'name'		=>	'Contact Person',
				'type'		=>	'text',
				'column'	=>	'col-md-6'),
			'phone_number'	=>	array(
				'name'		=>	'Phone Number',
				'type'		=>	'text',
				'column'	=>	'col-md-6'),
			'email_address'	=>	array(
				'name'		=>	'Email',
				'type'		=>	'email',
				'column'	=>	'col-12'),
			'address'	=>	array(
				'column'	=>	'col-12'),
			'remarks'	=>	array(
				'column'	=>	'col-12')
		);
	}
}
