<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dailyentry extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}

		$this->load->library('authorization');

		$this->_table = 'daily_entry';
		$this->_expense_type_table = 'expense_type';
		$this->_sites_table = 'sites';
		$this->_common_expenses_table = 'common_expenses';
		$this->_party_table = 'loan_party';
		$this->_suppliers_table = 'suppliers';
		$this->_bank_table = 'banks';
		$this->_employee_table = 'office_staffs';
		$this->_market_loans_table = 'market_loans';
		$this->_vehicle_expenses_table = 'vehicle_expenses';
		$this->_cc_account_table = 'cc_account';
		$this->_staff_loans_table = 'staff_loans';

		$this->_title = 'Daily Entry';
		$this->_link_start = 'daily-entry';

		is_permitted();

		$this->load->model('Dailyentry_Model');
		$this->load->model('Marketloans_Model');
		$this->load->model('VehicleExpenses_Model');
		$this->load->model('Ccaccount_Model');
		$this->load->model('Officeexpense_Model');
		$this->load->model('Staffloans_Model');

		$this->_select = 'id,created_at,entry_date,site,payment_of_id,reference_id,reference_no,expense_type,expense_id,amount,expense_date,status,remarks';
	}

	public function index()
	{
	    if($this->input->post('filter')){
	        $data['fromDate'] = $this->input->post('from');
	        $data['toDate'] = $this->input->post('to');
		    $data['status'] = $this->input->post('status');
		    $queryFromDate = toDbDateFormat($data['fromDate']);
		    $queryToDate = toDbDateFormat($data['toDate']);
	    }
	    else if($this->input->post('approve') || $this->input->post('pending')  || $this->input->post('delete') ){
	        $userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
	        if($this->input->post('delete') && $userdata['role_id'] != 1)
	        {
	            $this->session->set_flashdata('error', 'Only admin users can delete daily entries.');
	            redirect($this->_link_start.'-list');
	        }

	        if($this->input->post('approve')){
	            $status = 'active';
	        }
	        else if($this->input->post('pending')){
	            $status = 'inactive';
	        }
	        else if($this->input->post('delete')){
	            $status = 'deleted';
	        }
	       // $status = ($this->input->post('approve'))?'active':'';
	        $ids = $this->input->post('selectRow');
	        if(isset($ids) && count($ids) > 0){
	            $updated_at = currentDateTime();
	            $upArray['updated_at'] = $updated_at;
            	$upArray['status'] = $status;
	            foreach($ids as $id){
	                $this->common_model->updateWhere($this->_table, array('id' => $id), $upArray);
	            }
	        }
	        
	        $data['fromDate'] = $this->input->post('hidfrom');
	        $data['toDate'] = $this->input->post('hidto');
		    $data['status'] = $this->input->post('hidstatus');
		    $queryFromDate = toDbDateFormat($data['fromDate']);
		    $queryToDate = toDbDateFormat($data['toDate']);
	    }
		else
		{
		    $data['fromDate'] = $data['toDate'] = date('d-m-Y');
		    $queryFromDate = $queryToDate = date('Y-m-d');
		    $data['status'] = 'inactive';
		}
		$data['list'] = $this->Dailyentry_Model->getAllDailyEntryList('', $queryFromDate, $queryToDate, $data['status']);
// 		echo '<pre>';print_r($data['list']);exit;
		$data['titles'] = array(
			'title'	=>	$this->_title,
			'subtitle'	=>	'View List',
			'addlink'	=>	$this->_link_start.'-add',
			'edit'		=>	$this->_link_start.'-edit',
			'view'		=>	$this->_link_start.'-view',
			'delete'	=>	$this->_link_start.'-delete'
		);
		
// 		$data['theads'] = ['<input type="checkbox" name="selectall" class="selectall" id="select-all">', 'date', 'expense_type', 'expense_id', 'amount', 'expense_date', 'status', 'remarks', 'action'];
        $data['theads'] = ['<input type="checkbox" name="selectall" class="selectall" id="select-all">S.No', 'date', 'particular', 'expense', 'income', 'remarks', 'status', 'action'];
		$data['tfooter'] = array(
			'colspan' 	=> 3,
			'title'	  	=> 'Total',
			'sum_cols'	=> [3,4],
			'empty' 	=> 3);
		$data['page'] = 'dailyEntryList';
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
			$this->form_validation->set_rules('expense_type', 'Expense Type', 'required');
            $this->form_validation->set_rules('option', 'Expense Option', 'required');

            if($this->form_validation->run() == true)
            {
            	$expense_option = $this->input->post('etype_id');
            	
            	$expense_option_details = $this->getOptionTable($expense_option);
            	$subtable = $expense_option_details['table_name'];


            	$entryDate = date('Y-m-d', strtotime($this->input->post('date')));
            	$remarks = $this->input->post('remarks');
            	$created_at = currentDateTime();
            	

            	$expense_id_type = 1;
            	$optionArray = $this->getArrayvalues($expense_option);
            	$insSubArray = (isset($optionArray['insSubArray']))?$optionArray['insSubArray']:[];
            	$expense_amount = $optionArray['expense_amount'];

            	$userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
            	$status = ($userdata['role_id'] != 1 )?'inactive':'active';

            	if($userdata['role_id'] == 1)
            	{
            		$status = $this->input->post('status');
            	}
            	
				$insArray = array(
					'entry_date'			=>	$entryDate,
					'site'					=>	$this->input->post('site'),
					'expense_type'			=>	$this->input->post('expense_type'),
					'expense_id'			=>	$expense_option,
					'expense_date'			=>	$entryDate,
					'expense_id_type'		=>	$expense_id_type,
					'remarks'				=>	$remarks,
					'created_at'			=>	$created_at,
					'status'				=>	$status
				);
				if($subtable != NULL)
            	{
            		if($expense_option_details['with_reference'] == 1)
            		{
            			$insArray['payment_of_id'] = $this->input->post('payment_on');
            		}
            		else
            		{
            			$insSubArray['entry_date'] = $entryDate;
		            	$insSubArray['remarks'] = $remarks;
		            	$insSubArray['created_at'] = $created_at;
		            	$insSubArray['status'] = $status;

						$reference_id = $this->common_model->insert($subtable, $insSubArray);
						$insArray['reference_id'] = $reference_id;
            		}
					$insArray['amount'] = $expense_amount;
            	}
            	else
            	{
            		$insArray['reference_no'] = $this->input->post('reference_no');
					$insArray['amount'] = $this->input->post('amount');
            	}
				$this->common_model->insert($this->_table, $insArray);
				$this->session->set_flashdata('success', 'Daily Entry added successfully');
				redirect($this->_link_start.'-list');
			}
		}

		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = $this->_link_start.'-add';
		$data['sites'] = getDropdownOptions($this->_sites_table, 'site_name', '', 1);
		$data['expense_types'] = getExpenseDropdownOptions();
		// $data['formCustomization'] = $this->formCustomization();
		// $data['page'] = 'addEditDynamicForm';
		$data['page'] = 'addEditDailyEntry';
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
			$this->form_validation->set_rules('expense_type', 'Expense Type', 'required');
            $this->form_validation->set_rules('option', 'Expense Option', 'required');

            if($this->form_validation->run() == true)
            {
				$expense_option = (is_numeric($this->input->post('option')))?$this->input->post('option'):$this->input->post('etype_id');
            	$expense_option_details = $this->getOptionTable($expense_option);
            	$subtable = $expense_option_details['table_name'];


            	$entryDate = date('Y-m-d', strtotime($this->input->post('date')));
            	$remarks = $this->input->post('remarks');

            	$id = $this->input->post('id');
            	$reference_id = $this->input->post('reference_id');

            	$updated_at = currentDateTime();
            	
            	$userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
            	$status = ($userdata['role_id'] != 1 )?'inactive':'active';

            	if($userdata['role_id'] == 1)
            	{
            		$status = $this->input->post('status');
            	}

            	$expense_id_type = 1;
            	
            	$optionArray = $this->getArrayvalues($expense_option);
            	$insSubArray = $optionArray['insSubArray'];
            	$expense_amount = $optionArray['expense_amount'];

            	$insSubArray['entry_date'] = $entryDate;
            	$insSubArray['remarks'] = $remarks;
            	$insSubArray['updated_at'] = $updated_at;
            	$insSubArray['status'] = $status;
				

				$insArray = array(
					'entry_date'			=>	$entryDate,
					'site'					=>	$this->input->post('site'),
					'expense_type'			=>	$this->input->post('expense_type'),
					'expense_id'			=>	$expense_option,
					'expense_date'			=>	$entryDate,
					'expense_id_type'		=>	$expense_id_type,
					'remarks'				=>	$remarks,
					'updated_at'			=>	$updated_at,
					'status'				=>	$status
				);

				if($subtable != NULL)
            	{
            		if($expense_option_details['with_reference'] == 1)
            		{
            			$insArray['payment_of_id'] = $this->input->post('payment_on');
            		}
            		else
            		{
            			$insSubArray['entry_date'] = $entryDate;
		            	$insSubArray['remarks'] = $remarks;
		            	$insSubArray['created_at'] = $created_at;
		            	$insSubArray['status'] = $status;

						$reference_id = $this->common_model->updateWhere($subtable, array('id' => $reference_id), $insSubArray);
            		}
					$insArray['amount'] = $expense_amount;
            	}
            	else
            	{
            		$insArray['reference_no'] = $this->input->post('reference_no');
					$insArray['amount'] = $this->input->post('amount');
            	}

				$this->common_model->updateWhere($this->_table, array('id' => $id), $insArray);
				$this->session->set_flashdata('success', 'Daily Entry updated successfully');
				redirect($this->_link_start.'-list');
			}
		}

		$data['de_details'] = $this->common_model->getWhereRow($this->_table, $this->_select, array('id' => $id));
		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = $this->_link_start.'-edit/'.$id;
		$data['formCustomization'] = $this->formCustomization($data['de_details']['expense_id'], $data['de_details']['expense_type']);
		$data['sites'] = getDropdownOptions($this->_sites_table, 'site_name', $data['de_details']['site'], 1);
		$data['expense_types'] = getExpenseDropdownOptions($data['de_details']['expense_type']);
		$data['expense_options'] = $this->common_model->getWhereResult($this->_expense_type_table, '*', array(
			'expense'	=>	$data['de_details']['expense_type'],
			'status'	=>	'active'));

		$option = $data['de_details']['expense_id'];
		$expense_option_details = $this->getOptionTable($data['de_details']['expense_id']);
		$data['table_name'] = $expense_option_details['table_name'];
		if($data['table_name']!=NULL)
		{
			if($expense_option_details['with_reference'] == 1)
			{
				$data['option_details'] = $this->common_model->getWhereRow($this->_expense_type_table, '*', array('id' => $option));
				$divForm = $this->getDropdownList($option, $data['de_details']['payment_of_id']);
				$divForm .= $this->getDataAE($data['de_details']['payment_of_id'], $option, $data);
				$data['divForm'] = $divForm;
			}
			else
			{
				$data['fields'] = $this->db->field_data($data['table_name']);
				$data['details'] = $this->common_model->getWhereRow($data['table_name'], '*', array('id'=>$data['de_details']['reference_id']));
				$data['formCustomization'] = $this->getFormCustomization($option, $data['details']);
				$data['divForm'] = $this->load->view('customFields', $data, true);
			}
		}
		else
		{
			$data['divForm'] = $this->load->view('basicFields', $data, true);
		}
		$data['page'] = 'addEditDailyEntry';
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

		$data['list'] = $this->Dailyentry_Model->getAllDailyEntryListById($id);
		$data['theads'] = ['site'=>'site', 'expense_type'=>'expense_type', 'expense'=>'Expense/Income_option', 'total_installments'=>'total_installments', 'total_amount'=>'total_amount', 'status'=>'status', 'remarks'=>'remarks', 'entry_date'=>'entry_date'];

		$data['de_details'] = $this->common_model->getWhereRow($this->_table, $this->_select, array('id' => $id));
		$data['fields'] = $this->db->field_data($this->_table);
		$data['action'] = $this->_link_start.'-edit/'.$id;
		$data['formCustomization'] = $this->formCustomization($data['de_details']['expense_id'], $data['de_details']['expense_type']);
		$data['sites'] = getDropdownOptions($this->_sites_table, 'site_name', $data['de_details']['site'], 1);
		$data['expense_types'] = getExpenseDropdownOptions($data['de_details']['expense_type']);
		$data['expense_options'] = $this->common_model->getWhereResult($this->_expense_type_table, '*', array(
			'expense'	=>	$data['de_details']['expense_type'],
			'status'	=>	'active'));

		$option = $data['de_details']['expense_id'];
		$expense_option_details = $this->getOptionTable($data['de_details']['expense_id']);
		$data['table_name'] = $expense_option_details['table_name'];
		if($data['table_name']!=NULL)
		{
			if($expense_option_details['with_reference'] == 1)
			{
				$data['option_details'] = $this->common_model->getWhereRow($this->_expense_type_table, '*', array('id' => $option));
				$divForm = $this->getDropdownList($option, $data['de_details']['payment_of_id']);
				$divForm .= $this->getDataAE($data['de_details']['payment_of_id'], $option, $data);
				$data['divForm'] = $divForm;
			}
			else
			{
				$data['fields'] = $this->db->field_data($data['table_name']);
				$data['details'] = $this->common_model->getWhereRow($data['table_name'], '*', array('id'=>$data['de_details']['reference_id']));
				$data['formCustomization'] = $this->getFormCustomization($option, $data['details']);
				$data['divForm'] = $this->load->view('customFields', $data, true);
			}
		}
		else
		{
			$data['divForm'] = $this->load->view('basicFields', $data, true);
		}

		$data['page'] = 'viewDailyEntry';
		$this->load->view('main', $data);
	}
	
	public function delete($id){
	    $userdata = $this->User_model->getUserDetails($this->session->userdata('user_id'));
	    if($userdata['role_id'] != 1)
	    {
	        $this->session->set_flashdata('error', 'Only admin users can delete daily entries.');
	        redirect($this->_link_start.'-list');
	    }

	    $this->common_model->updateWhere($this->_table, array('id' => $id), array(
	    	'status'		=>	'deleted',
	    	'updated_at'	=>	currentDateTime()
	    ));
	    $this->session->set_flashdata('success', 'Daily Entry deleted successfully');
	    redirect($this->_link_start.'-list');
	}

	public function getArrayvalues($id)
	{
		$data = [];
		if($id == 3 || $id == 4 || $id == 8)
    	{
    		$data['expense_amount'] = $this->input->post('amount');
    		$data['insSubArray'] = array();
    	}
    	else if($id == 10)
    	{
    		$data['expense_amount'] = $this->input->post('loan_amount');//amount without interest is the income
    		$data['insSubArray'] = array(
				'employee_id'		=>	$this->input->post('employee_id'),
				'loan_amount'		=>	$this->input->post('loan_amount'),
				'loan_tenure'		=>	$this->input->post('loan_tenure'),
				'loan_last_date'	=>	toDbDateFormat($this->input->post('loan_last_date'))
			);
    	}
		else if($id == 12)
    	{
    		$data['expense_amount'] = $this->input->post('loan_amount');//amount without interest is the income
    		$data['insSubArray'] = array(
				'party_id'				=>	$this->input->post('party_id'),
				'loan_amount'			=>	$data['expense_amount'],
				'interest'				=>	$this->input->post('interest'),
				'total_installments'	=>	$this->input->post('total_installments'),
				'total_amount'			=>	$this->input->post('total_amount')
			);
    	}
    	else if($id == 13)
    	{
    		$data['expense_amount'] = $this->input->post('total_amount');//amount without interest is the income
    		$data['insSubArray'] = array(
				'supplier_id'		=>	$this->input->post('supplier_id'),
				'particular'		=>	$this->input->post('particular'),
				'quantity'			=>	$this->input->post('quantity'),
				'amount'			=>	$this->input->post('amount'),
				'gst'				=>	$this->input->post('gst'),
				'total_amount'		=>	$this->input->post('total_amount')
			);
    	}
    	else if($id == 14)
    	{
    		$data['expense_amount'] = $this->input->post('amount');//amount without interest is the income
    		$data['insSubArray'] = array(
				'name'				=>	$this->input->post('name'),
				'description'		=>	$this->input->post('description'),
				'amount'			=>	$this->input->post('amount'),
				'released_amount'	=>	$this->input->post('released_amount')
			);
    	}
    	else if($id == 15)
    	{
    		$data['expense_amount'] = $this->input->post('total_amount');//amount without interest is the income
    		$data['insSubArray'] = array(
				'bank_id'				=>	$this->input->post('bank_id'),
				'loan_amount'			=>	$this->input->post('loan_amount'),
				'interest'				=>	$this->input->post('interest'),
				'total_amount'			=>	$this->input->post('total_amount')
			);
    	}

    	return $data;
	}

	public function getFormCustomization($id, $details='')
	{
		if($id == 10)
		{
			$formCustomization = $this->staffLoanFields((!empty($details))?$details['party_id']:'');
		}
		else if($id == 12)
		{
			$formCustomization = $this->marketLoanFields((!empty($details))?$details['party_id']:'');
		}
		else if($id == 13)
		{
			$formCustomization = $this->gstBillFields((!empty($details))?$details['supplier_id']:'');
		}
		else if($id == 14)
		{
			$formCustomization = $this->gstFDRFields();
		}
		else if($id == 15)
		{
			$formCustomization = $this->gstCCAccountFields((!empty($details))?$details['bank_id']:'');
		}
		else if($id == 16)
		{
			$formCustomization = $this->gstStaffLoanFields((!empty($details))?$details['bank_id']:'');
		}

		return $formCustomization;
	}

	public function formCustomization($selectid = '', $type='')
	{
		$data = array(
			'fields'    => array('entry_date', 'expense_type', 'expense_id', 'expense_date'),
			'entry_date'	=>	array(
				'name' 		=>  'Date',
				'type'		=>	'date',
				'readonly'	=>	1),
			'expense_type'	=>	array(
				'name' 		=> 'Expense Type',
				'type'		=>	'select',
				'values'	=>	getExpenseDropdownOptions($type)),
			'expense_id'	=>	array(
				'name' 		=> 'Expense',
				'type'		=>	'select',
				'values'	=>	getDropdownOptions($this->_expense_type_table, 'expense_type', $selectid, 1)),
			'expense_date'	=> array(
				'name'		=>	'Expense Date',
				'type'		=>	'date')
		);
		return $data;
	}

	public function getExpenseDrop()
	{
		$expense_type = $this->input->post('expense_type');
		$where = array(
			'expense'		=>	$expense_type,
			'status'		=>	'active');
		$values = $this->common_model->getWhereResult($this->_expense_type_table, '*', $where);

		$option = '<option value="">Select</option>';

	    if(isset($values))
	    {
	        $selected = '';
	    	foreach($values as $li)
	    	{
	            $option .= '<option value="'.$li['id'].'" '.$selected.'>'.$li['expense_type'].'</option>';
	    	}
	    }
		echo json_encode($option);
	}

	public function getOptionFields()
	{
		$option = $this->input->post('option');
		$etype = $this->input->post('etype');
		$expense_option_details = $this->getOptionTable($option, $etype);
		$data['table_name'] = $expense_option_details['table_name'];
		if($data['table_name'] != NULL)
		{
			if($expense_option_details['with_reference'] == 1)
			{
				$data['option_details'] = $this->common_model->getWhereRow($this->_expense_type_table, '*', array('id' => $option));
				$divForm = $this->getDropdownList($option);
			}
			else
			{
				$data['fields'] = $this->db->field_data($data['table_name']);
				$data['formCustomization'] = $this->getFormCustomization($option, '');
				$divForm = $this->load->view('customFields', $data, true);
			}
		}
		else
		{
			$divForm = $this->load->view('basicFields', $data, true);
		}
		$divForm .= '<input type="hidden" name="etype_id" value="'.$expense_option_details['id'].'">';
		echo json_encode($divForm);
	}

	public function getDropdownList($id, $selectid="")
	{
		$disabled = '';
		if($selectid!='')
		{$disabled = 'disabled';}
		$option = '<option value="" '.$disabled.'>Select</option>';
		if($id == 3)
		{
			$label = 'Market Loans';
			$field = 'party_name';
			$jsFunction = 'getMLData(this.value)';
			$list = $this->Marketloans_Model->getAllMarketLoansList();
		}
		else if($id == 4)
		{
			$label = 'Vehicle Expenses';
			$field = 'vehicle_name';
			$jsFunction = 'getMLData(this.value)';
			$list = $this->VehicleExpenses_Model->getAllVehicleExpenses();
		}
		else if($id == 8)
		{
			$label = 'CC Account EMI';
			$field = 'party_name';
			$jsFunction = 'getMLData(this.value)';
			$list = $this->Ccaccount_Model->getAllCCAccountList();
		}
		else if($id == 9)
		{
			$label = 'Office Expense';
			$field = 'expense_name';
			$jsFunction = 'getMLData(this.value)';
			$list = $this->Officeexpense_Model->getAllOfficeExpensesList();
		}
		else if($id == 16)
		{
			$label = 'Employees';
			$field = 'employee_name';
			$jsFunction = 'getMLData(this.value)';
			$list = $this->Staffloans_Model->getAllStaffHasLoan();
		}

		if(isset($list))
	    {
	        $selected = '';
	    	foreach($list as $li)
	    	{
	            if($selectid!='' && $selectid==$li['id'])
	            {
	                $selected = 'selected';
	            }
	            else
	            {
	            	$selected = '';
	            }
	    		$option .= '<option value="'.$li['id'].'" '.$selected.' '.$disabled.'>'.$li[$field].'</option>';
	    	}
	    }

		$select = '<div class="col-4 mb-4" id="appendAfter">
                        <label for="exampleFormControlSelect2">'.$label.'<span class="text-danger">*</span></label>
                        <select class="form-control" id="emi_type" name="emi_type" required onchange="'.$jsFunction.'">
                            '.$option.'
                        </select>
                    </div>';
        if($selectid=='')
    	{
    		$select .= '<div class="col-8" id="appendBefore"></div>';
    	}
		return $select;
	}

	public function getOptionTable($id, $etype='')
	{
		$option_details = $this->common_model->getWhereRow($this->_expense_type_table, '*', array('id' => $id));
		if(empty($option_details)){
		    $insArray = array(
				'entry_date'	=>	date('Y-m-d'),
				'expense_type'	=>	$id,
				'expense'	    =>	$etype,
				'is_show'		=>	1,
				'remarks'		=>	'',
				'created_at'	=>	currentDateTime(),
				'status'		=>	'active'
			);
		    $iid = $this->common_model->insert($this->_expense_type_table,$insArray);
		    $option_details = $this->common_model->getWhereRow($this->_expense_type_table, '*', array('id' => $iid));
		}
// 		echo '<pre>';print_r($option_details);exit;
		return $option_details;
	}

	public function getData()
	{
		$id = $this->input->post('val');
		$option = $this->input->post('opt');
		$divForm = $this->getDataAE($id, $option);
		echo json_encode($divForm);
	}

	public function getDataAE($id, $option, $editRow='')//for add and edit
	{
		$data['editRow'] = $editRow;
		if($option == 3)
		{
			$table = $this->_market_loans_table;
			$data['emi_details'] = $this->common_model->getWhereRow($table, '*', array('id' => $id));
		}
		else if($option == 4)
		{
			$table = $this->_vehicle_expenses_table;
			$data['emi_details'] = $this->common_model->getWhereRow($table, '*', array('id' => $id));
		}
		else if($option == 8)
		{
			$table = $this->_cc_account_table;
			$data['emi_details'] = $this->common_model->getWhereRow($table, '*', array('id' => $id));
		}
		else if($option == 16)
		{
			$table = $this->_staff_loans_table;
			$data['emi_details'] = $this->Staffloans_Model->getAllStaffLoansSumByStaff($id);
		}
		echo '<pre>';print_r($data['emi_details']);
		$data['option'] = $option;
		$data['paid'] = $this->db->select('sum(amount) as paid')->from($this->_table)->where(array('payment_of_id' =>$id, 'expense_id' => $option, 'status' => 'active'))->get()->row_array();
		$divForm = $this->load->view('customEmiFields', $data, true);
		return $divForm;
	}

	public function marketLoanFields($selectid = '')
	{
		$data = array(
			'fields'    => array('party_id', 'loan_amount', 'interest', 'total_amount'),
			'party_id'	=>	array(
				'name' 		=> 'Party Name',
				'type'		=>	'select',
				'values'	=>	getDropdownOptions($this->_party_table, 'party_name', $selectid)),
			'loan_amount' => array(
				'name'		=>	'Loan Amount',
				'type'		=>	'text',
				'column'	=>	'col-md-4'),
			'interest' => array(
				'name'		=>	'Interest Per/Month',
				'type'		=>	'text',
				'column'	=>	'col-md-4'),
			'total_amount'	=> array(
				'name'		=>	'Total Amount',
				'readonly'	=>	'readonly',
				'type'		=>	'text',)
		);
		return $data;
	}

	public function gstBillFields($selectid='')
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
				'column'	=>	'col-md-4',
				'type'		=>	'text',
				'readonly'	=>	'readonly')
		);
		return $data;
	}

	public function gstFDRFields($selectid = '')
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

	public function gstCCAccountFields($selectid = '')
	{
		$data = array(
			'fields'    => array('bank_id', 'loan_amount', 'interest', 'total_amount'),
			'bank_id'	=>	array(
				'name' 		=> 'Bank Name',
				'type'		=>	'select',
				'values'	=>	getDropdownOptions($this->_bank_table, 'bank_name', $selectid)),
			'loan_amount' => array(
				'name'		=>	'Loan Amount',
				'type'		=>	'text',
				'column'	=>	'col-md-4'),
			'interest' => array(
				'name'		=>	'Interest Per/Month',
				'type'		=>	'text',
				'column'	=>	'col-md-4'),
			'total_amount'	=> array(
				'name'		=>	'Total Amount',
				'readonly'	=>	'readonly',
				'type'		=>	'text',)
		);
		return $data;
	}

	public function gstStaffLoanFields($selectid = '', $tenureid='')
	{
		$data = array(
			'fields'    => array('employee_id', 'loan_amount', 'loan_tenure', 'loan_last_date'),
			'employee_id'	=>	array(
				'name'		=>	'Employee Person',
				'column'	=>	'col-md-4',
				'type'		=>	'select',
				'values'	=>	getDropdownOptions($this->_employee_table, 'name', $selectid)),
			'loan_amount' => array(
				'name'		=>	'Loan Amount',
				'column'	=>	'col-md-4',
				'type'		=>	'text'),
			'loan_tenure' => array(
				'name'		=>	'Loan Tenure',
				'column'	=>	'col-md-4',
				'type'		=>	'select',
				'values'	=>	getLoanTenureOptions($tenureid)),
			'loan_last_date' => array(
				'name'		=>	'Loan Last Date',
				'type'		=>	'text',
				'readonly'	=>	'readonly')
		);
		return $data;
	}

	public function staffLoanFields($selectid = '', $tenureid='')
	{
		$data = array(
			'fields'    => array('employee_id', 'loan_amount', 'loan_tenure', 'loan_last_date'),
			'employee_id'	=>	array(
				'name'		=>	'Employee Person',
				'column'	=>	'col-md-4',
				'type'		=>	'select',
				'values'	=>	getDropdownOptions($this->_employee_table, 'name', $selectid)),
			'loan_amount' => array(
				'name'		=>	'Loan Amount',
				'column'	=>	'col-md-4',
				'type'		=>	'text'),
			'loan_tenure' => array(
				'name'		=>	'Loan Tenure',
				'column'	=>	'col-md-4',
				'type'		=>	'select',
				'values'	=>	getLoanTenureOptions($tenureid)),
			'loan_last_date' => array(
				'name'		=>	'Loan Last Date',
				'type'		=>	'text',
				'readonly'	=>	'readonly')
		);
		return $data;
	}
}
