<?php if (!defined('BASEPATH')) exit('No direct script access allowed');


class Dailyentry_Model extends MY_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->_table = 'daily_entry';
		$this->_expense_type_table = 'expense_type';
		$this->_sites_table = 'sites';
	}

	public function getAllDailyEntryList($limit='', $fromDate='', $toDate='', $status='')
	{
	    if($fromDate == ''){
	        $fromDate = date('Y-m-d');
	    }
	    if($toDate == ''){
	        $toDate = date('Y-m-d');
	    }
	    if($status == ''){
	        $status = 'inactive';
	    }
		$where = array("$this->_table.status" => $status);
		$select = "$this->_table.id,$this->_table.entry_date,$this->_expense_type_table.expense_type as particular, CASE 
        WHEN $this->_table.expense_type = 'expense' 
        THEN CONCAT('₹', FORMAT($this->_table.amount, 2)) 
        ELSE '' 
    END AS expense,
    CASE 
        WHEN $this->_table.expense_type = 'income' 
        THEN CONCAT('₹', FORMAT($this->_table.amount, 2)) 
        ELSE '' 
    END AS income,$this->_table.remarks,$this->_table.status";
		$this->db->select($select)->from($this->_table)->join($this->_expense_type_table, "$this->_expense_type_table.id=$this->_table.expense_id", 'left')->where($where)->order_by('id','DESC');
		
		$this->db->where("$this->_table.entry_date >=", $fromDate);
		$this->db->where("$this->_table.entry_date <=", $toDate);
		
		if($limit !='')
		{
			$this->db->limit($limit);
		}
		$result = $this->db->get()->result_array();
		return $result;
	}

	public function getLatestDailyExpenses($limit = 5)
	{
		$select = "$this->_table.id,$this->_table.created_at,$this->_table.entry_date,$this->_table.amount,$this->_table.remarks,$this->_table.status,$this->_expense_type_table.expense_type as particular,$this->_sites_table.site_name as site";
		$this->db->select($select)
			->from($this->_table)
			->join($this->_expense_type_table, "$this->_expense_type_table.id=$this->_table.expense_id", 'left')
			->join($this->_sites_table, "$this->_sites_table.id=$this->_table.site", 'left')
			->where("$this->_table.expense_type", 'expense')
			->where_not_in("$this->_table.status", array('deleted', 'delete_pending'))
			->order_by("$this->_table.entry_date", 'DESC')
			->order_by("$this->_table.id", 'DESC')
			->limit($limit);

		return $this->db->get()->result_array();
	}

	public function getAllDailyEntryListById($id)
	{
		$where = array("$this->_table.status !=" => 'deleted', "$this->_table.id" => $id);
		$select = "$this->_table.id,$this->_table.created_at,$this->_table.entry_date,$this->_table.expense_type,$this->_table.expense_id,$this->_expense_type_table.expense_type as expense, CONCAT('₹', format(amount,2)) as amount,DATE_FORMAT($this->_table.expense_date,'%d/%m/%Y') as expense_date,$this->_table.status,$this->_table.remarks,$this->_sites_table.site_name as site";
		$this->db->select($select)->from($this->_table)->join($this->_expense_type_table, "$this->_expense_type_table.id=$this->_table.expense_id", 'left')->join($this->_sites_table, "$this->_sites_table.id=$this->_table.site", 'inner')->where($where)->order_by('id','DESC');
		$result = $this->db->get()->row_array();
		return $result;
	}

	public function getAllDailyEntryListByDate($date)
	{
		$where = array("$this->_table.status" => 'active', "$this->_table.expense_date" => $date);
		$select = "SUM(CASE WHEN $this->_table.expense_type = 'expense' THEN amount ELSE 0 END) AS total_expense, SUM(CASE WHEN $this->_table.expense_type = 'income' THEN amount ELSE 0 END) AS total_income, SUM($this->_table.amount) as total";
		$this->db->select($select)->from($this->_table)->join($this->_expense_type_table, "$this->_expense_type_table.id=$this->_table.expense_id", 'left')->join($this->_sites_table, "$this->_sites_table.id=$this->_table.site", 'inner')->where($where)->order_by($this->_table.'.id','DESC');
		$result = $this->db->get()->result_array();
		return $result;
	}

	public function getAllDailyEntryListByMonth($year, $month)
	{
		$where = array("$this->_table.status" => 'active', "YEAR($this->_table.expense_date)" => $year, "MONTH($this->_table.expense_date)" => $month);
		$select = "SUM(CASE WHEN $this->_table.expense_type = 'expense' THEN amount ELSE 0 END) AS total_expense, SUM(CASE WHEN $this->_table.expense_type = 'income' THEN amount ELSE 0 END) AS total_income, SUM($this->_table.amount) as total";
		$this->db->select($select)->from($this->_table)->join($this->_expense_type_table, "$this->_expense_type_table.id=$this->_table.expense_id", 'left')->join($this->_sites_table, "$this->_sites_table.id=$this->_table.site", 'inner')->where($where)->order_by($this->_table.'.id','DESC');
		$result = $this->db->get()->result_array();
		return $result;
	}

	public function getAllProfitLose()
	{
		return $this->db->select("SUM(CASE WHEN expense_type = 'income' THEN amount ELSE 0 END) as profit, SUM(CASE WHEN expense_type = 'expense' THEN amount ELSE 0 END) as lose")->from($this->_table)->where('status', 'active')->get()->row();
	}

	public function monthlyCurrentYearIncome($mo)
	{
		return $this->db->select("MONTH(expense_date) as month, SUM(CASE WHEN expense_type = 'income' THEN amount ELSE 0 END) as profit, SUM(CASE WHEN expense_type = 'expense' THEN amount ELSE 0 END) as lose")->from($this->_table)->where('status', 'active')->where('MONTH(expense_date)', $mo)->where('YEAR(expense_date)', date('Y'))->group_by('month')->get()->row_array();
	}

	public function currentWeeklyExpense($day)
	{
		return $this->db->select("SUM(CASE WHEN expense_type = 'income' THEN amount ELSE 0 END) as profit, SUM(CASE WHEN expense_type = 'expense' THEN amount ELSE 0 END) as lose")->from($this->_table)->where('status', 'active')->where('expense_date', date('Y-m').'-'.$day)->get()->row_array();
	}

	public function getSiteData($data)
	{
		$search_term = $data['search_term'];
		$whereLike = "";

		$where = array("$this->_table.status" => 'active', "$this->_table.site" => $data['site']);
		$select = "$this->_table.id,DATE_FORMAT($this->_table.entry_date,'%d-%m-%Y') as entry_date,$this->_sites_table.site_name as site,$this->_expense_type_table.expense_type as particular, 
		CASE 
            WHEN $this->_table.expense_type = 'expense' 
            THEN CONCAT('₹', FORMAT($this->_table.amount, 2)) 
            ELSE '' 
        END AS expense,
        CASE 
            WHEN $this->_table.expense_type = 'income' 
            THEN CONCAT('₹', FORMAT($this->_table.amount, 2)) 
            ELSE '' 
        END AS income, $this->_table.remarks";
		$this->db->select($select)->from($this->_table)->join($this->_expense_type_table, "$this->_expense_type_table.id=$this->_table.expense_id", 'left')->join($this->_sites_table, "$this->_sites_table.id=$this->_table.site", 'inner')->where($where)->order_by('id','DESC');
		
		if(isset($search_term) && $search_term!='')
		{
			$whereLike = " ($this->_table.reference_no LIKE '%$search_term%' OR $this->_table.expense_type LIKE '%$search_term%' OR $this->_table.amount LIKE '%$search_term%' OR $this->_table.remarks LIKE '%$search_term%')";
		}
		if(isset($data['start_date']) && $data['start_date']!='')
		{
			$this->db->where("$this->_table.expense_date >= ", $data['start_date']);
		}
		if(isset($data['end_date']) && $data['end_date']!='')
		{
			$this->db->where("$this->_table.expense_date <= ", $data['end_date']);
		}
		if($whereLike!='')
		{
			$this->db->where($whereLike);
		}

		$result = $this->db->get()->result_array();
		return $result;
	}	
}
