<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MY_Controller {

	public function __construct()
	{
		parent::__construct();
		if(!is_logged_in())
		{
			redirect('');
		}

		$this->load->model('Dailyentry_Model');
		$this->load->model('Ccaccount_Model');
		$this->load->model('VehicleExpenses_Model');
		$this->load->model('Officeexpense_Model');
	}
	public function index()
	{
		$data['titles'] = array(
			'title'	=>	'Dashboard',
			'subtitle'	=>	'',
			'addlink'	=>	''
		);

		//Revenue By current year
		$monthlyTotalIncome = [];
		$monthlyTotalExpenses = [];
		for($mi=1; $mi<=12;$mi++)
		{
			$all = $this->Dailyentry_Model->monthlyCurrentYearIncome($mi);
			$monthlyTotalIncome[] = (isset($all['profit']))?$all['profit']:0;
			$monthlyTotalExpenses[] = (isset($all['lose']))?$all['lose']:0;
		}
		$data['monthlyTotalIncome'] = implode(',', $monthlyTotalIncome);
		$data['monthlyTotalExpenses'] = implode(',', $monthlyTotalExpenses);

		//All expenses
		$data['allExpenses'] = array(
			'daily_expense'			=>	array_sum($monthlyTotalExpenses),
			'vehicle_expense'		=>	$this->VehicleExpenses_Model->getAllVehicleExpensesYearly()->total_veh_exp,
			'office_expense'		=>	$this->Officeexpense_Model->getAllOfficeExpensesYearly()->total_off_exp);
		// echo '<pre>';print_r($data);exit;
		//Daily expense/ income
		$start_End_Date_of_a_week = start_End_Date_of_a_week();
		$start = date('d', strtotime($start_End_Date_of_a_week['start']));
		$end = date('d', strtotime($start_End_Date_of_a_week['end']));
		for($dei=$start; $dei <= $end; $dei++)
		{
			$daily_expense[] = $this->Dailyentry_Model->currentWeeklyExpense($dei);
		}
		$data['daily_expense'] = array(
			'profit' => (isset($daily_expense))?implode(',', array_column($daily_expense, 'profit')):'',
			'lose' => (isset($daily_expense))?implode(',', array_column($daily_expense, 'lose')):'',
		);

		// echo '<pre>';print_r($daily_expense);echo '<pre>';print_r($data['daily_expense']);exit;
		$profitLose = $this->Dailyentry_Model->getAllProfitLose();
		//CC account loan total
		$loans = $this->Ccaccount_Model->getTotalAmount();
		$data['cctotal'] = $loans->total_cc_loan;
		$data['summary'] = array(
			'profit'	=>	$profitLose->profit,
			'lose'		=>	$profitLose->lose,
			'loan'		=>	$loans->total_cc_loan,
			'plltotal'	=>	$profitLose->profit + $profitLose->lose + $loans->total_cc_loan);
		$data['latestDailyExpenses'] = $this->Dailyentry_Model->getLatestDailyExpenses(5);
		$data['page'] = 'dashboard';
		$this->load->view('main', $data);
	}

	public function notPermited()
	{
		$data['titles'] = array(
			'title'	=>	'No Permission',
			'subtitle'	=>	'',
			'addlink'	=>	''
		);
		$data['page'] = 'no_permission';
		$this->load->view('main', $data);
	}
}
