<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Testcontroller extends CI_Controller {
	public function cleartables(){
		$tables = array('banks', 'cc_account', 'daily_entry', 'expense_type', 'fdr', 'gst_bill', 'loan_party', 'market_loans', 'office_expenses', 'office_staffs', 'partners', 'pay_partner', 'products', 'purchase', 'purchase_details', 'sites', 'staff_loans', 'suppliers', 'vehicles', 'vehicle_expenses', 'vehicle_running_km');
		foreach ($tables as $table) {
            $this->db->empty_table($table); // Clear table
        }

        echo 'Tables cleared successfully!';
	}
}