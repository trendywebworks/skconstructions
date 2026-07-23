<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Product extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}

		$this->userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
		$this->_role = $this->userdata['role_id'];
		
		$this->_table = 'products';
		$this->_title = 'Products';
		$this->_link_start = 'product';
		$this->_select_view = 'id,created_at,entry_date,product_name,hsn_sac,status,remarks';

		$this->load->library('authorization');
		is_permitted();
	}

	public function index()
	{
		$data['titles'] = array(
			'title'	=>	'Products',
			'subtitle'	=>	'View List',
			'addlink'	=>	'product-add',
			'edit'		=>	'product-edit',
			'view'		=>	'product-view',
			'delete'	=>	'product-delete'
		);
		$data['theads'] = ['date', 'product_name', 'HSN/SAC', 'status', 'remarks', 'action'];

		$select = 'id,created_at,entry_date,product_name,hsn_sac,status,remarks';
		$data['list'] = $this->common_model->getAllWhereSelectList($this->_table, $select, array('status != ' => 'deleted'));
		$data['page'] = 'list';
		$this->load->view('main', $data);
	}

	public function add()
	{
		$data['titles'] = array(
			'title'	=>	'Products',
			'subtitle'	=>	'Add New',
			'listlink'	=>	'products-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('product_name', 'Product Name', 'required|is_unique[products.product_name]');
            $this->form_validation->set_rules('hsn_sac', 'HSN/SAC', 'required');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'	=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'product_name'	=>	$this->input->post('product_name'),
					'hsn_sac'		=>	$this->input->post('hsn_sac'),
					'remarks'		=>	$this->input->post('remarks'),
					'created_at'	=>	currentDateTime(),
					'status'		=>	$status
				);
				$this->common_model->insert($this->_table, $insArray);
				$this->session->set_flashdata('success', 'Product added successfully');
				redirect('products-list');
			}
		}

		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = 'product-add';
		$data['formCustomization'] = $this->formCustomization();
		$data['page'] = 'addEditDynamicForm';
		$this->load->view('main', $data);
	}

	public function edit($id)
	{
		$data['id'] = $id;
		$data['titles'] = array(
			'title'	=>	'Products',
			'subtitle'	=>	'Product Edit',
			'listlink'	=>	'products-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('product_name', 'Product Name', 'required|edit_unique[products.product_name.'.$id.']');
            $this->form_validation->set_rules('hsn_sac', 'HSN/SAC', 'required');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'	=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'product_name'	=>	$this->input->post('product_name'),
					'hsn_sac'		=>	$this->input->post('hsn_sac'),
					'remarks'		=>	$this->input->post('remarks'),
					'updated_at'	=>	currentDateTime(),
					'status'		=>	$status
				);
				$this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);
				$this->session->set_flashdata('success', 'Product updated successfully');
				redirect('products-list');
			}
		}

		$select = 'id,created_at,product_name,hsn_sac,status,remarks';
		$data['details'] = $this->common_model->getWhereRow($this->_table, $select, array('id' => $id));
		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = 'product-edit/'.$id;
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
			'listlink'	=>	$this->_link_start.'s-list',
			'editlink'	=>	$this->_link_start.'-edit/'.$id
		);

		$data['list'] = $this->common_model->getAllWhereSelectListRow($this->_table, $this->_select_view, array('id' => $id));
		$data['theads'] = ['product_name'=>'product_name', 'hsn_sac'=>'hsn_sac', 'status'=>'status', 'remarks'=>'remarks', 'entry_date'=>'entry_date'];

		$data['page'] = 'view';
		$this->load->view('main', $data);
	}

	public function formCustomization($selectid = '')
	{
		$data = array(
			'fields'    => array('hsn_sac'),
			'hsn_sac' => array(
				'name'		=>	'HSN/SAC',
				'type'		=>	'text')
		);
		return $data;
	}
}
