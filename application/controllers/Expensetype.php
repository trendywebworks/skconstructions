<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Expensetype extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}

		$this->userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
		$this->_role = $this->userdata['role_id'];
		
		$this->_table = 'expense_type';
		$this->_title = 'Cashflow';
		$this->_link_start = 'expense-type';
		$this->_select_view = 'id,created_at,entry_date,expense_type,expense,is_show,with_reference,remarks,status';

		$this->load->library('authorization');
		is_permitted();
	}

	public function index()
	{
		$data['titles'] = array(
			'title'	=>	$this->_title,
			'subtitle'	=>	'View List',
			'addlink'	=>	'expense-type-add',
			'edit'		=>	'expense-type-edit',
			'view'		=>	'expense-type-view',
			'delete'	=>	'expense-type-delete'
		);

		$select = 'id,created_at,entry_date,expense_type,expense,table_name,status,remarks';
		$data['list'] = $this->common_model->getAllWhereSelectList($this->_table, $select, array('status != ' => 'deleted'));
		$data['theads'] = ['date', 'expense_title', 'expense_type', 'status', 'remarks', 'action'];
		$data['allow_delete'] = ($this->_role == 1);
		$data['page'] = 'list';
		$this->load->view('main', $data);
	}

	public function add()
	{
		$data['titles'] = array(
			'title'	=>	$this->_title,
			'subtitle'	=>	'Add New',
			'listlink'	=>	'expense-type-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('expense_type', 'Expense Type', 'required');
			$this->form_validation->set_rules('expense_title', 'Expense Title', 'required|is_unique[expense_type.expense_type]');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'	=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'expense_type'	=>	$this->input->post('expense_title'),
					'expense'	    =>	($this->input->post('expense_type')==1)?'expense':'income',//name according to change in feature
					'is_show'		=>	2,
					'remarks'		=>	$this->input->post('remarks'),
					'created_at'	=>	currentDateTime(),
					'status'		=>	$status
				);
				$this->common_model->insert($this->_table, $insArray);
				$this->session->set_flashdata('success', 'Expense Type added successfully');
				redirect('expense-type-list');
			}
		}

		$data['fields'] = $this->getFields();
		//$this->db->field_data($this->_table);
		$data['formCustomization'] = $this->formCustomization();
		$data['action'] = 'expense-type-add';
		$data['page'] = 'addEditDynamicForm';
		$this->load->view('main', $data);
	}

	public function edit($id)
	{
		$data['id'] = $id;
		$data['titles'] = array(
			'title'	=>	$this->_title,
			'subtitle'	=>	'Edit Expense Type',
			'listlink'	=>	'expense-type-list'
		);

		if($this->input->post())
		{
			$formData = $this->input->post();
			$data['postData'] = $formData;

			$this->form_validation->set_rules('date', 'Date', 'required');
			$this->form_validation->set_rules('expense_type', 'Expense Type', 'required');
			$this->form_validation->set_rules('expense_title', 'Expense Type', 'required|edit_unique[expense_type.expense_type.'.$id.']');
			if($this->_role == 1 ) 
			{
				$this->form_validation->set_rules('status', 'Status', 'required');
			}

            if($this->form_validation->run() == true)
            {
            	$status = ($this->_role != 1 )?'inactive':$this->input->post('status');
				$insArray = array(
					'entry_date'	=>	date('Y-m-d', strtotime($this->input->post('date'))),
					'expense_type'	=>	$this->input->post('expense_title'),
					'expense'	    =>	($this->input->post('expense_type')==1)?'expense':'income',//name according to change in feature
					'remarks'		=>	$this->input->post('remarks'),
					'updated_at'	=>	currentDateTime(),
					'status'		=>	$status
				);
				$this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);
				$this->session->set_flashdata('success', 'Expense Type updated successfully');
				redirect('expense-type-list');
			}
		}

		$select = 'id,created_at,entry_date,expense_type,expense,status,remarks';
		$data['details'] = $this->common_model->getWhereRow($this->_table, $select, array('id' => $id));
		$data['fields'] = $this->getFields();//$this->db->field_data($this->_table);
		$selected = ($data['details']['expense']=='expense')?1:2;
		$data['formCustomization'] = $this->formCustomization($selected);
		$data['action'] = 'expense-type-edit/'.$id;
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
		$data['theads'] = ['expense_type'=>'expense_title', 'expense'=>'expense_type', 'status'=>'status', 'remarks'=>'remarks', 'entry_date'=>'entry_date', 'status'=>'status'];

		$data['page'] = 'view';
		$this->load->view('main', $data);
	}
	
	public function getExpenseByType(){
	    if($this->input->post('expense_type')==1){
	        $expense_type = 'expense';
	    }
	    else if($this->input->post('expense_type')==2){
	        $expense_type = 'income';
	    }
	    else{
	        $expense_type = $this->input->post('expense_type');
	    }
	   // $expense_type = ($this->input->post('expense_type')==1)?'expense':'income';
	    $selectid = '';
	    $where = array(
            'expense'  =>  $expense_type,
            'status'   => 'active');
        $result = $this->db->where($where)->get($this->_table)->result_array();
    
        $option = '<option value="">Select</option>';
    
        if(isset($result))
        {
            $selected = '';
        	foreach($result as $li)
        	{
                if($selectid!='' && $selectid==$li['id'])
                {
                    $selected = 'selected';
                }
                else
                {
                    $selected = '';
                }
        		$option .= '<option value="'.$li['id'].'" '.$selected.'>'.$li['expense_type'].'</option>';
        	}
        }
        echo json_encode($option);
	}

	public function getFields()
	{
		return array(
		    0 => (object) array(
		        'name' => 'expense_type',
		        'type' => 'select',
		        'default' => '',
		        'primary_key' => 0
		    ),
		    2 => (object) array(
		        'name' => 'expense_title',
		        'type' => 'varchar',
		        'max_length' => '200',
		        'default' => '',
		        'primary_key' => 0
		    ),
		    4 => (object) array(
		        'name' => 'remarks',
		        'type' => 'text',
		        'max_length' => '',
		        'default' => '',
		        'primary_key' => 0
		    )
		);
	}

	public function delete($id)
	{
		if($this->_role != 1)
		{
			$this->session->set_flashdata('error', 'Only admin users can delete expense types.');
			redirect('expense-type-list');
		}

		$this->common_model->updateWhere($this->_table, array('id' => $id), array(
			'status'		=>	'deleted',
			'updated_at'	=>	currentDateTime()
		));
		$this->session->set_flashdata('success', 'Expense Type deleted successfully');
		redirect('expense-type-list');
	}
	
	public function formCustomization($selectid = '')
	{
		$data = array(
			'fields'    => array('expense_type'),
			'expense_type'	=>	array(
				'name' 		=> 'Expense Type',
				'type'		=>	'select',
				'values'	=>	getDropdownOptions('expense_main_types', 'title', $selectid)
				)
		);
		return $data;
	}

}
