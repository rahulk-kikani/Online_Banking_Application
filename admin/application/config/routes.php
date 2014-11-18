<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
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
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "admin_welcome/admin_login";
$route['404_override'] = '';

$route['login'] = 'admin_welcome/admin_login';
/*user Account*/
$route['dashboard'] = 'ad_user_account/dashboard';

//cheques
$route['list-all-cheques'] = 'ad_user_account/list_all_cheques';
$route['cheque_detail/(:any)']  = 'ad_user_account/cheque_detail/$1';
$route['approve-cheque/(:any)'] = 'ad_user_account/approve_cheque/$1';
$route['disapprove-cheque/(:any)'] = 'ad_user_account/disapprove_cheque/$1';

/*Manage Req*/
$route['new-ac-req'] = 'ad_user_account/new_ac_req';
$route['user-detail/(:any)'] = 'ad_user_account/user_detail/$1';
$route['gen-ac/(:any)'] = 'ad_user_account/gen_ac/$1';

//Credit Card
$route['list-all-credit-card-req'] = 'ad_user_account/credit_card_req';
$route['credit_card_detail/(:any)'] = 'ad_user_account/credit_card_detail/$1';
$route['generate_credit_card/(:any)'] = 'ad_user_account/generate_credit_card/$1';
$route['calc-credit-inr/(:any)'] = 'ad_user_account/calc_credit_inr/$1';
$route['view-estatement'] = 'ad_user_account/view_estatement';

// Billing Companies
$route['list-all-billing-companies'] = 'ad_user_account/list_all_billing_companies';
$route['add-billing-companies'] = 'ad_user_account/add_billing_companies';
$route['company_detail/(:any)'] = 'ad_user_account/company_detail/$1';

//stock
$route['stock-center'] = 'ad_user_account/stock_center';
$route['fixed-deposit'] = 'ad_user_account/fixed_deposit';

//History
$route['transaction-history'] = 'ad_user_account/transaction_history';
$route['cheque-history'] = 'ad_user_account/cheque_history';
$route['login-history'] = 'ad_user_account/login_history';
$route['logout'] = 'admin_welcome/admin_logout';
/* End of file routes.php */
/* Location: ./application/config/routes.php */