<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Report_Model extends MY_Model
{
	
	public function __construct()
	{
		parent::__construct();
		$this->_suppliers_table = 'suppliers';
		$this->_bank_table = 'banks';
		$this->_expense_type_table = 'expense_type';
		$this->_office_staffs_table = 'office_staffs';
		$this->_staff_table = 'office_staffs';
	}

	public function getReportData($data)
	{
		$report_type = $data['report_type'];
		$search_term = $data['search_term'];
		$whereLike = "";
		if($report_type == 'marketl')
		{
			$this->_table = 'market_loans';
			$this->_party_table = 'loan_party';
			$select = "$this->_table.id,$this->_table.created_at,$this->_party_table.party_name as party_name, CONCAT('₹', format(loan_amount,0)) as amount,CONCAT('₹', format(interest,0)) as interest,total_installments,CONCAT('₹', format(total_amount,0)) as total_amount,$this->_table.remarks";

			$this->db->select($select)->from($this->_table);
			$this->db->join($this->_party_table, "$this->_party_table.id=$this->_table.party_id", 'inner');

			if(isset($search_term) && $search_term!='')
			{
				$whereLike = " ($this->_party_table.party_name LIKE '%$search_term%')";
			}

			if($data['loan_party_name']!='')
			{
				$this->db->where("$this->_party_table.id", $data['loan_party_name']);
			}
		}
		else if($report_type == 'purchase')
		{
			$this->_table = 'purchase';
			$select = "$this->_table.id,$this->_table.created_at,$this->_table.reference_no,$this->_suppliers_table.firm_name as firm_name,CONCAT('₹', format(total_amount,0)) as total_amount,DATE_FORMAT($this->_table.purchase_date,'%d-%m-%Y') as purchase_date,$this->_table.remarks";
			$this->db->select($select)->from($this->_table);
			$this->db->join($this->_suppliers_table, "$this->_suppliers_table.id=$this->_table.supplier_id", 'inner');

			if(isset($search_term) && $search_term!='')
			{
				$whereLike = " ($this->_table.reference_no LIKE '%$search_term%' OR $this->_suppliers_table.firm_name as firm_name LIKE '%$search_term%')";
			}

			if($data['supplierename']!='')
			{
				$this->db->where("$this->_suppliers_table.id", $data['supplierename']);
			}
		}	
		else if($report_type == 'gstbill')
		{
			$this->_table = 'gst_bill';
			$select = "$this->_table.id,$this->_table.created_at,$this->_suppliers_table.firm_name as firm_name,$this->_table.particular,$this->_table.quantity, CONCAT('₹', format(amount,0)) as amount,CONCAT(gst, '%') as gst,CONCAT('₹', format(total_amount,0)) as total_amount,$this->_table.remarks";
			$this->db->select($select)->from($this->_table);
			$this->db->join($this->_suppliers_table, "$this->_suppliers_table.id=$this->_table.supplier_id", 'inner');

			if(isset($search_term) && $search_term!='')
			{
				$whereLike = " ($this->_suppliers_table.firm_name LIKE '%$search_term%' OR $this->_table.particular LIKE '%$search_term%')";
			}

			if($data['supplierename']!='')
			{
				$this->db->where("$this->_suppliers_table.id", $data['supplierename']);
			}
		}
		else if($report_type == 'ccaccount')
		{
			$this->_table = 'cc_account';
			$select = "$this->_table.id,$this->_table.created_at,$this->_bank_table.bank_name as party_name, CONCAT('₹', format(loan_amount,0)) as loan_amount,CONCAT('₹', format(interest,0)) as interest,CONCAT('₹', format(total_amount,0)) as total_amount,$this->_table.remarks";
			$this->db->select($select)->from($this->_table);
			$this->db->join($this->_bank_table, "$this->_bank_table.id=$this->_table.bank_id", 'inner');

			if(isset($search_term) && $search_term!='')
			{
				$whereLike = " ($this->_bank_table.bank_name LIKE '%$search_term%')";
			}

			if($data['bankname']!='')
			{
				$this->db->where("$this->_bank_table.id", $data['bankname']);
			}
		}
		else if($report_type == 'products')
		{
			$this->_table = 'products';
			$select = 'id,created_at,product_name,hsn_sac,remarks';
			$this->db->select($select)->from($this->_table);

			if(isset($search_term) && $search_term!='')
			{
				$whereLike = " (product_name LIKE '%$search_term%' OR hsn_sac LIKE '%$search_term%')";
			}

			if($data['product_name']!='')
			{
				$this->db->where("$this->_table.id", $data['product_name']);
			}
		}
		else if($report_type == 'officeex')
		{
			$this->_table = 'office_expenses';
			$select = "$this->_table.id,$this->_table.created_at,$this->_expense_type_table.expense as cashflow,$this->_expense_type_table.expense_type as expense_name,$this->_office_staffs_table.name as staff_name, CONCAT('₹', format(amount,0)) as amount,$this->_table.remarks";
			$this->db->select($select)->from($this->_table);
			$this->db->join($this->_expense_type_table, "$this->_expense_type_table.id=$this->_table.expense_type_id", 'inner');
			$this->db->join($this->_office_staffs_table, "$this->_office_staffs_table.id=$this->_table.staff_id", 'inner');

			if(isset($search_term) && $search_term!='')
			{
				$whereLike = " ($this->_expense_type_table.expense_type LIKE '%$search_term%' OR $this->_office_staffs_table.name LIKE '%$search_term%')";
			}

			if($data['office_expense_name']!='')
			{
				$this->db->where("$this->_table.expense_type_id", $data['office_expense_name']);
			}
			
			if($data['office_expense_name_type_opt']!='')
			{
				$this->db->where("$this->_expense_type_table.expense", $data['office_expense_name_type_opt']);
			}
		}
		else if($report_type == 'staffl')
		{
			$this->_table = 'staff_loans';
			$select = "$this->_table.id,$this->_table.created_at,$this->_staff_table.name as employee_name, CONCAT('₹', format(loan_amount,0)) as loan_amount,DATE_FORMAT($this->_table.created_at,'%d-%m-%Y') as loan_date,CONCAT(loan_tenure, ' Month(s)') as loan_tenure,DATE_FORMAT($this->_table.loan_last_date,'%d-%m-%Y') as loan_last_date,$this->_table.remarks";
			$this->db->select($select)->from($this->_table);
			$this->db->join($this->_staff_table, "$this->_staff_table.id=$this->_table.employee_id", 'inner');

			if(isset($search_term) && $search_term!='')
			{
				$whereLike = " ($this->_staff_table.name LIKE '%$search_term%')";
			}

			if($data['staffname']!='')
			{
				$this->db->where("$this->_staff_table.id", $data['staffname']);
			}
		}
		else if($report_type == 'partn')
		{
			$this->_table = 'partners';
			$select = 'id,created_at,full_name,phone_number,email_address,id_proof,remarks';
			$this->db->select($select)->from($this->_table);

			if(isset($search_term) && $search_term!='')
			{
				$whereLike = " (full_name LIKE '%$search_term%' OR phone_number LIKE '%$search_term%' OR email_address LIKE '%$search_term%')";
			}

			if($data['partner_name']!='')
			{
				$this->db->where("$this->_table.id", $data['partner_name']);
			}
		}
		else if($report_type == 'paypartn')
		{
			$this->_table = 'pay_partner';
			$this->_partner_table = 'partners';
			// $select = "$this->_table.id,$this->_table.created_at,$this->_table.entry_date,$this->_partner_table.full_name as partner_name, CONCAT('₹', format($this->_table.amount,0)) as amount,pay_for,pay_type,$this->_table.remarks";
			$select = "$this->_partner_table.full_name as partner_name, CONCAT('₹', FORMAT(SUM(CASE WHEN pay_type = 'debit' THEN amount ELSE 0 END), 0)) AS amount, CONCAT('₹', FORMAT(SUM(CASE WHEN pay_type = 'credit' THEN amount ELSE 0 END), 0)) AS paid, CONCAT('₹', FORMAT((SUM(CASE WHEN pay_type = 'debit' THEN amount ELSE 0 END) - SUM(CASE WHEN pay_type = 'credit' THEN amount ELSE 0 END)), 0)) AS balance";
			$this->db->select($select)->from($this->_table);
			$this->db->join($this->_partner_table, "$this->_partner_table.id=$this->_table.p_id", 'inner');

			if(isset($search_term) && $search_term!='')
			{
				$whereLike = " (pay_for LIKE '%$search_term%' OR $this->_table.remarks LIKE '%$search_term%')";
			}

			if($data['partner_name']!='')
			{
				$this->db->where("$this->_table.p_id", $data['partner_name']);
			}

			$this->db->group_by($this->_table.'.p_id');
		}
		else if($report_type == 'vehicls')
		{
			$this->_table = 'vehicles';
			$select = "id,created_at,vehicle_name,vehicle_no,vehicle_purchase_by,CONCAT('₹', format(vehicle_emi,0)) as vehicle_emi,CONCAT('₹', format(down_payment_amount,0)) as down_payment_amount,CONCAT('₹', format(down_payment_by,0)) as down_payment_by,remarks";
			$this->db->select($select)->from($this->_table);

			if(isset($search_term) && $search_term!='')
			{
				$whereLike = " (vehicle_name LIKE '%$search_term%' OR vehicle_no LIKE '%$search_term%')";
			}

			if($data['vehicle_name']!='')
			{
				$this->db->where("$this->_table.id", $data['vehicle_name']);
			}

			if($data['vehicle_no']!='')
			{
				$this->db->where("$this->_table.id", $data['vehicle_no']);
			}
		}

		$where = array("$this->_table.status" => 'active');
		if($data['start_date']!='')
		{
			$where[$this->_table.'.created_at >= '] = date('Y-m-d', strtotime($data['start_date']));
		}
		if($data['end_date']!='')
		{
			$where[$this->_table.'.created_at <= '] = date('Y-m-d', strtotime($data['end_date']));
		}

		
		$this->db->where($where);
		if($whereLike!='')
		{
			$this->db->where($whereLike);
		}
		$result = $this->db->get()->result_array();
		return $result;
	}
}
?>
