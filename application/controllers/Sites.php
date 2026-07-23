<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Sites extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}

		$this->userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
		$this->_role = $this->userdata['role_id'];
		
		$this->_table = 'sites';
		$this->load->model('Dailyentry_Model');
		$this->_title = 'Sites';
		$this->_link_start = 'site';
		$this->_select_view = 'id,created_at,entry_date,site_name,site_address,status,remarks';

		$this->load->library('authorization');
		is_permitted();
	}

	public function index()
	{
		$data['titles'] = array(
			'title'	=>	'Sites',
			'subtitle'	=>	'View List',
			'addlink'	=>	'site-add',
			'edit'		=>	'site-edit',
			'view'		=>	'site-view',
			'delete'	=>	'site-delete'
		);

		$select = 'id,created_at,entry_date,site_name,site_address,status,remarks';
		$data['list'] = $this->common_model->getAllWhereSelectList($this->_table, $select, array('status != ' => 'deleted'));
		$data['theads'] = ['date', 'site_name', 'site_address', 'status', 'remarks', 'action'];
		$data['page'] = 'list';
		$this->load->view('main', $data);
	}

	public function add()
	{
		$data['titles'] = array(
			'title'	=>	'Sites',
			'subtitle'	=>	'Add New',
			'listlink'	=>	'sites-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('site_name', 'Site Name', 'required|is_unique[sites.site_name]');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'	=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'site_name'		=>	$this->input->post('site_name'),
					'site_address'	=>	$this->input->post('site_address'),
					'remarks'		=>	$this->input->post('remarks'),
					'created_at'	=>	currentDateTime(),
					'status'		=>	$status
				);
				$this->common_model->insert($this->_table, $insArray);
				$this->session->set_flashdata('success', 'Site added successfully');
				redirect('sites-list');
			}
		}

		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = 'site-add';
		$data['page'] = 'addEditDynamicForm';
		$this->load->view('main', $data);
	}

	public function edit($id)
	{
		$data['id'] = $id;
		$data['titles'] = array(
			'title'	=>	'Sites',
			'subtitle'	=>	'Edit Site',
			'listlink'	=>	'sites-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('site_name', 'Site Name', 'required|edit_unique[sites.site_name.'.$id.']');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'	=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'site_name'		=>	$this->input->post('site_name'),
					'site_address'	=>	$this->input->post('site_address'),
					'remarks'		=>	$this->input->post('remarks'),
					'updated_at'	=>	currentDateTime(),
					'status'		=>	$status
				);
				$this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);
				$this->session->set_flashdata('success', 'Site updated successfully');
				redirect('sites-list');
			}
		}

		$select = 'id,created_at,entry_date,site_name,site_address,status,remarks';
		$data['details'] = $this->common_model->getWhereRow($this->_table, $select, array('id' => $id));
		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = 'site-edit/'.$id;
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
		$data['theads'] = ['site_name'=>'site_name', 'site_address'=>'site_address', 'remarks'=>'remarks', 'entry_date'=>'entry_date'];

		$data['page'] = 'view';
		$this->load->view('main', $data);
	}

	public function expenses()
	{
		$data['titles'] = array(
			'title'	=>	$this->_title,
			'subtitle'	=>	'Filter '.$this->_title,
			'listlink'	=>	$this->_link_start.'s-list'
		);

		if($this->input->post())
		{
			$this->form_validation->set_rules('site', 'Site', 'required');
			if($this->form_validation->run() == true)
            {
				$formData = $this->input->post();
				$data['postData'] = $formData;

				$data['site'] = $this->input->post('site');
				$data['search_term'] = $this->input->post('search_term');
				$data['start_date'] = $this->input->post('start_date');
				$data['end_date'] = $this->input->post('end_date');
				$data['list'] = $this->Dailyentry_Model->getSiteData($data);
				// echo '<pre>';print_r($data['list']);exit;
			}
		}

		$select = 'id,site_name';
		$data['sites'] = $this->common_model->getAllWhereSelectList($this->_table, $select, array('status' => 'active'));

		$data['tfooter'] = array(
			'colspan' 	=> 4,
			'title'	  	=> 'Total',
			'sum_cols'	=> [4,5],
			'empty' 	=> 2);

		$data['page'] = 'site_expenses';
		$this->load->view('main', $data);
	}
}
