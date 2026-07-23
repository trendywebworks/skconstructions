<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Reports extends CI_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}
		$this->_party_table = 'loan_party';
		$this->_suppliers_table = 'suppliers';
		$this->_bank_table = 'banks';
		$this->_products_table = 'products';
		$this->_expense_type_table = 'expense_type';
		$this->_staff_table = 'office_staffs';
		$this->_partners_table = 'partners';
		$this->_vehicles_table = 'vehicles';
		$this->_expense_main_type_table = 'expense_main_types';
		
		$this->load->model('Report_Model');
		$this->load->model('Dailyentry_Model');

		$this->load->library('authorization');
		is_permitted();
		
	}

	public function index()
	{
		$data['titles'] = array(
			'title'	=>	'Reports',
			'subtitle'	=>	'Report',
			'addlink'	=>	''
		);

		if($this->input->post())
		{
			$this->form_validation->set_rules('report_type', 'Report Type', 'required');

            if($this->form_validation->run() == true)
            {
				$data['report_type'] = $this->input->post('report_type');

				$data['loan_party_name'] = $this->input->post('loan_party_name');
				$data['supplierename'] = $this->input->post('supplierename');
				$data['bankname'] = $this->input->post('bankname');
				$data['product_name'] = $this->input->post('product_name');
				$data['office_expense_name_type_opt'] = $this->input->post('office_expense_name_type_opt');
				$data['office_expense_name'] = $this->input->post('office_expense_name');
				$data['staffname'] = $this->input->post('staffname');
				$data['partner_name'] = $this->input->post('partner_name');
				$data['vehicle_name'] = $this->input->post('vehicle_name');
				$data['vehicle_no'] = $this->input->post('vehicle_no');

				$data['search_term'] = $this->input->post('search_term');
				$data['start_date'] = $this->input->post('start_date');
				$data['end_date'] = $this->input->post('end_date');
				$data['list'] = $this->Report_Model->getReportData($data);

				if($data['report_type'] == 'marketl')
				{
					$colspan = 2;
					$sum_cols = [2,3,5];
					$empty = 2;
				}
				else if($data['report_type'] == 'purchase')
				{
					$colspan = 3;
					$sum_cols = [3];
					$empty = 2;
				}
				else if($data['report_type'] == 'gstbill')
				{
					$colspan = 4;
					$sum_cols = [4,6];
					$empty = 2;
				}
				else if($data['report_type'] == 'ccaccount')
				{
					$colspan = 2;
					$sum_cols = [2,3,4];
					$empty = 1;
				}
				else if($data['report_type'] == 'products')
				{
					$colspan = 4;
					$sum_cols = [];
					$empty = 0;
				}
				else if($data['report_type'] == 'officeex')
				{
					$colspan = 3;
					$sum_cols = [3];
					$empty = 1;
				}
				else if($data['report_type'] == 'staffl')
				{
					$colspan = 2;
					$sum_cols = [2];
					$empty = 4;
				}
				else if($data['report_type'] == 'partn')
				{
					$colspan = 6;
					$sum_cols = [];
					$empty = 0;
				}
				else if($data['report_type'] == 'paypartn')
				{
					$colspan = 0;
					$sum_cols = [1,2,3];
					$empty = 0;
				}
				else if($data['report_type'] == 'vehicls')
				{
					$colspan = 4;
					$sum_cols = [4,5,6];
					$empty = 1;
				}
				$data['tfooter'] = array(
					'colspan' 	=> $colspan,
					'title'	  	=> 'Total',
					'sum_cols'	=> $sum_cols,
					'empty' 	=> $empty);

			}
		}
		
		$data['loan_party'] = $this->common_model->getAllWhereSelectList($this->_party_table, '*', array('status' => 'active'));
		$data['suppliers'] = $this->common_model->getAllWhereSelectList($this->_suppliers_table, '*', array('status' => 'active'));
		$data['banks'] = $this->common_model->getAllWhereSelectList($this->_bank_table, '*', array('status' => 'active'));
		$data['products'] = $this->common_model->getAllWhereSelectList($this->_products_table, '*', array('status' => 'active'));
		$data['office_expense_type_options'] = $this->common_model->getAllWhereSelectList($this->_expense_main_type_table, '*', array('status' => 'active'));
		$expense_type = ($this->input->post('office_expense_name_type_opt')==1)?'expense':'income';
		$data['office_expense_types'] = $this->common_model->getAllWhereSelectList($this->_expense_type_table, '*', array('expense'  =>  $expense_type, 'status' => 'active'));
		$data['staffs'] = $this->common_model->getAllWhereSelectList($this->_staff_table, '*', array('status' => 'active'));
		$data['partners'] = $this->common_model->getAllWhereSelectList($this->_partners_table, '*', array('status' => 'active'));
		$data['vehicles'] = $this->common_model->getAllWhereSelectList($this->_vehicles_table, '*', array('status' => 'active'));
		$data['page'] = 'reports';
		$this->load->view('main', $data);
	}

	public function daily_report($year='', $month='')
	{
		$data['titles'] = array(
			'title'	=>	'Reports',
			'subtitle'	=>	'Daily Report',
			'addlink'	=>	''
		);

		$data['year'] = ($year=='')?date('Y'):$year;
		$data['month'] = ($month=='')?date('m'):$month;

		$reportArray = [];
		$daysInMonth = cal_days_in_month(CAL_GREGORIAN, $data['month'], $data['year']);
		for ($day = 1; $day <= $daysInMonth; $day++) {
			$date = $data['year'].'-'.$data['month'].'-'.$day;
			$reportArray[$date] = $this->Dailyentry_Model->getAllDailyEntryListByDate($date);;
		}
		$data['reportArray'] = $reportArray;
		// echo '<pre>';print_r($data['reportArray']);exit;
		$data['page'] = 'daily_report';
		$this->load->view('main', $data);
	}

	public function monthly_report($year='', $month='')
	{
		$data['titles'] = array(
			'title'	=>	'Reports',
			'subtitle'	=>	'Monthly Report',
			'addlink'	=>	''
		);

		$data['year'] = ($year=='')?date('Y'):$year;

		for ($month = 1; $month <= 12; $month++) {
			$date = $data['year'].'-'.$month;
			$reportArray[$date] = $this->Dailyentry_Model->getAllDailyEntryListByMonth($data['year'], $month);
		}
		$data['reportArray'] = $reportArray;
		// echo '<pre>';print_r($data['reportArray']);exit;
		$data['theads'] = ['date', 'supplier_name', 'particular', 'quantity', 'amount', 'GST', 'total', 'remarks', 'action'];
		$data['page'] = 'monthly_report';
		$this->load->view('main', $data);
	}
	
	public function cashflow_report(){
	    $data['titles'] = array(
			'title'	=>	'Reports',
			'subtitle'	=>	'Cashflow Report',
			'addlink'	=>	''
		);
		
		if($this->input->post())
		{
		    $data['report_type'] = 'officeex';
		    $data['office_expense_name_type_opt'] = $this->input->post('office_expense_name_type_opt');
		    $data['office_expense_name'] = $this->input->post('office_expense_name');
		    $data['search_term'] = $this->input->post('search_term');
			$data['start_date'] = $this->input->post('start_date');
			$data['end_date'] = $this->input->post('end_date');
			$data['list'] = $this->Report_Model->getReportData($data);
			
			if($data['office_expense_name_type_opt']){
			    $data['office_expense_types'] = $this->common_model->getAllWhereSelectList($this->_expense_type_table, '*', array('expense'  =>  $data['office_expense_name_type_opt'], 'status' => 'active'));
			}
		}
		
		$data['office_expense_type_options'] = $this->common_model->getAllWhereSelectList($this->_expense_main_type_table, '*', array('status' => 'active'));
		
		
	    $data['page'] = 'cashflow_report';
		$this->load->view('main', $data);
	}

	// public function module_array($term)
	// {
	// 	$arr = array(
	// 		'marketl'		=>	array(
	// 			'table'		=>	'market_loans',
	// 			'select'	=>	$this->_table.id,$this->_table.created_at,$this->_party_table.party_name as party_name, CONCAT('₹', format(loan_amount,0)),CONCAT('₹', format(interest,0)),total_installments,CONCAT('₹', format(total_amount,0)),$this->_table.remarks),
	// 		'purchase'		=>	'purchase',
 //            'gstbill'		=>	'gst_bill',
 //            'ccaccount'		=>	'cc_account',
 //            'products'		=>	'products',
 //            'officeex'		=>	'office_expenses',
 //            'staffl'		=>	'staff_loans',
 //            'partn'			=>	'partners',
 //            'vehicls'		=>	'vehicles');
	// 	return $arr[$term];
	// }
}
