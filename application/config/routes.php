<?php
defined('BASEPATH') OR exit('No direct script access allowed');

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	https://codeigniter.com/userguide3/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are three reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router which controller/method to use if those
| provided in the URL cannot be matched to a valid route.
|
|	$route['translate_uri_dashes'] = FALSE;
|
| This is not exactly a route, but allows you to automatically route
| controller and method names that contain dashes. '-' isn't a valid
| class or method name character, so it requires translation.
| When you set this option to TRUE, it will replace ALL dashes in the
| controller and method URI segments.
|
| Examples:	my-controller/index	-> my_controller/index
|		my-controller/my-method	-> my_controller/my_method
*/
$route['default_controller'] = 'Auth';
$route['404_override'] = '';
$route['translate_uri_dashes'] = FALSE;


/************************************** Admin ***************************************/
$route['authenticate'] 			= 'Auth/authenticate';
$route['admlogout'] 			= 'Auth/logout';

// Dashboard
$route['dashboard'] 		= 'Dashboard';
$route['not-permited'] 		= 'Dashboard/notPermited';

// Daily Entry
$route['daily-entry-list'] = 'Dailyentry';
$route['daily-entry-add'] = 'Dailyentry/add';
$route['daily-entry-edit/(:num)'] = 'Dailyentry/edit/$1';
$route['daily-entry-view/(:num)'] = 'Dailyentry/view/$1';
$route['daily-entry-delete/(:num)'] = 'Dailyentry/delete/$1';

//Pay to Partner
$route['pay-partner-list'] = 'Paytopartner';
$route['pay-partner-add'] = 'Paytopartner/add';
$route['pay-partner-edit/(:num)'] = 'Paytopartner/edit/$1';
$route['pay-partner-view/(:num)'] = 'Paytopartner/view/$1';

// Market Loans
$route['market-loans-list'] = 'Marketloans';
$route['market-loans-add'] = 'Marketloans/add';
$route['market-loans-edit/(:num)'] = 'Marketloans/edit/$1';
$route['market-loans-view/(:num)'] = 'Marketloans/view/$1';

// Vehicle Expenses
$route['vehicles-expenses-list'] = 'Vehicleexpenses';
$route['vehicles-expense-add'] = 'Vehicleexpenses/add';
$route['vehicles-expense-edit/(:num)'] = 'Vehicleexpenses/edit/$1';
$route['vehicles-expense-view/(:num)'] = 'Vehicleexpenses/view/$1';

// Purchase
$route['purchase-list'] = 'Purchase';
$route['purchase-add'] = 'Purchase/add';
$route['purchase-edit/(:num)'] = 'Purchase/edit/$1';
$route['purchase-view/(:num)'] = 'Purchase/view/$1';

// GST Bill
$route['gst-bill-list'] = 'Gstbill';
$route['gst-bill-add'] = 'Gstbill/add';
$route['gst-bill-edit/(:num)'] = 'Gstbill/edit/$1';
$route['gst-bill-view/(:num)'] = 'Gstbill/view/$1';

// FDR
$route['fdr-list'] = 'Fdr';
$route['fdr-add'] = 'Fdr/add';
$route['fdr-edit/(:num)'] = 'Fdr/edit/$1';
$route['fdr-view/(:num)'] = 'Fdr/view/$1';

// CC Account
$route['cc-account-list'] = 'Ccaccount';
$route['cc-account-add'] = 'Ccaccount/add';
$route['cc-account-edit/(:num)'] = 'Ccaccount/edit/$1';
$route['cc-account-view/(:num)'] = 'Ccaccount/view/$1';

// Products
$route['products-list'] = 'Product';
$route['product-add'] = 'Product/add';
$route['product-edit/(:num)'] = 'Product/edit/$1';
$route['product-view/(:num)'] = 'Product/view/$1';

// Office Expense
$route['office-expense-list'] = 'Officeexpense';
$route['office-expense-add'] = 'Officeexpense/add';
$route['office-expense-edit/(:num)'] = 'Officeexpense/edit/$1';
$route['office-expense-view/(:num)'] = 'Officeexpense/view/$1';

// Staff Loans
$route['staff-loans-list'] = 'Staffloans';
$route['staff-loan-add'] = 'Staffloans/add';
$route['staff-loan-edit/(:num)'] = 'Staffloans/edit/$1';
$route['staff-loan-view/(:num)'] = 'Staffloans/view/$1';

// Daily Reports
$route['reports-daily'] = 'Reports/daily_report';
$route['reports-daily/(:num)/(:num)'] = 'Reports/daily_report/$1/$2';
$route['reports-monthly'] = 'Reports/monthly_report';
$route['reports-monthly/(:num)'] = 'Reports/monthly_report/$1';
$route['reports'] = 'Reports';
$route['cashflow-reports'] = 'Reports/cashflow_report';

// Sites
$route['sites-list'] = 'Sites';
$route['site-add'] = 'Sites/add';
$route['site-edit/(:num)'] = 'Sites/edit/$1';
$route['site-view/(:num)'] = 'Sites/view/$1';
$route['site-expenses'] = 'Sites/expenses';

// Partners
$route['partners-list'] = 'Partners';
$route['partner-add'] = 'Partners/add';
$route['partner-edit/(:num)'] = 'Partners/edit/$1';
$route['partner-view/(:num)'] = 'Partners/view/$1';

// Vehicles
$route['vehicles-list'] = 'Vehicles';
$route['vehicle-add'] = 'Vehicles/add';
$route['vehicle-edit/(:num)'] = 'Vehicles/edit/$1';
$route['vehicle-view/(:num)'] = 'Vehicles/view/$1';

// Office Staff
$route['office-staff-list'] = 'Officestaff';
$route['office-staff-add'] = 'Officestaff/add';
$route['office-staff-edit/(:num)'] = 'Officestaff/edit/$1';
$route['office-staff-view/(:num)'] = 'Officestaff/view/$1';

// Loan Party
$route['loan-party-list'] = 'Loanparty';
$route['loan-party-add'] = 'Loanparty/add';
$route['loan-party-edit/(:num)'] = 'Loanparty/edit/$1';
$route['loan-party-view/(:num)'] = 'Loanparty/view/$1';
$route['loan-party-delete/(:num)'] = 'Loanparty/delete/$1';

// Expense Type
$route['expense-type-list'] = 'Expensetype';
$route['expense-type-add'] = 'Expensetype/add';
$route['expense-type-edit/(:num)'] = 'Expensetype/edit/$1';
$route['expense-type-view/(:num)'] = 'Expensetype/view/$1';

// Suppliers
$route['suppliers-list'] = 'Supplier';
$route['supplier-add'] = 'Supplier/add';
$route['supplier-edit/(:num)'] = 'Supplier/edit/$1';
$route['supplier-view/(:num)'] = 'Supplier/view/$1';

// Banks
$route['banks-list'] = 'Banks';
$route['bank-add'] = 'Banks/add';
$route['bank-edit/(:num)'] = 'Banks/edit/$1';
$route['bank-view/(:num)'] = 'Banks/view/$1';

// Users
$route['users-list'] = 'Users';
$route['user-add'] = 'Users/add';
$route['user-edit/(:num)'] = 'Users/edit/$1';
$route['user-view/(:num)'] = 'Users/view/$1';

// User Roles
$route['user-role-list'] = 'Userroles';
$route['user-role-add'] = 'Userroles/add';
$route['user-role-edit/(:num)'] = 'Userroles/edit/$1';
$route['user-role-view/(:num)'] = 'Userroles/view/$1';

// Profile
$route['profile-setting'] = 'Profile';

// Vehicle Running KM
$route['vehicles-running-list'] = 'Vehiclerunning';
$route['vehicles-running-add'] = 'Vehiclerunning/add';
$route['vehicles-running-edit/(:num)'] = 'Vehiclerunning/edit/$1';
$route['vehicles-running-view/(:num)'] = 'Vehiclerunning/view/$1';

// Clear Tables
$route['clear-tables'] = 'Testcontroller/cleartables';