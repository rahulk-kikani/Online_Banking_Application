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

$route['default_controller'] = "welcome";
$route['404_override'] = '';

$route['user_login'] = 'welcome/user_login';
$route['login-history'] = 'user_mng_account/login_history';
$route['new-registration'] = 'welcome/new_registration';
$route['bank-services'] = 'welcome/bank_service';
$route['forgot-password'] = 'welcome/forgot_password';
$route['image_credit'] = 'welcome/image_credit';

//change password
$route['set-new-pswd'] = 'welcome/set_new_pass';
/*user Account*/
$route['user/dashboard'] = 'user_mng_account/dashboard';
$route['user/set-security-questions'] = 'user_mng_account/set_security_questions';
$route['view-profile'] = 'user_mng_account/view_profile';
$route['change-password'] = 'user_mng_account/change_password';

//fund transfer logic
$route['user/withdraw-money'] = 'user_mng_account/withdraw_money';
$route['user/deposite-cheque'] = 'user_mng_account/deposite_cheque';
$route['user/transfer-money'] = 'user_mng_account/transfer_money';
$route['user/account-history'] = 'user_mng_account/account_history';

//cheques
$route['user/list-all-cheque'] = 'user_mng_account/list_all_cheque';

//
$route['user/all_paid_bill'] = 'user_mng_account/all_paid_bill';
$route['user/pay_bill'] = 'user_mng_account/pay_bill';

//Credit Card
$route['user/credit-card-application'] = 'credit_account/new_application';
$route['user/make-credit-payment'] = 'credit_account/make_credit_payment';
$route['user/credit-card-transaction-detail'] = 'credit_account/transaction_detail';
$route['user/credit-card-e-statement'] = 'credit_account/e_statement';
$route['user/view-estatement'] = 'credit_account/view_estatement';

//Investment
$route['user/investment-account'] = 'investment_account/inve_account';
$route['user/stock-center'] = 'investment_account/stock_center';
$route['user/stock-details'] = 'investment_account/stock_details';
$route['user/active-investment-account'] = 'investment_account/active_investment_account';
$route['user/stock-exchange'] = 'investment_account/stock_exchange';
$route['user/invest-fixed-money'] = 'investment_account/inves_fixed_money';

//Logout process
$route['user/logout'] = 'user_mng_account/user_logout';

/* End of file routes.php */
/* Location: ./application/config/routes.php */