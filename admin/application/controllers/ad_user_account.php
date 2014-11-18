<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Ad_user_account extends CI_Controller {
    
    public function __construct()
       {
            parent::__construct();
            $this->load->helper('url');
            $this->load->helper('date');
            $this->load->library('assets');
            $this->load->helper('cookie');
            $this->load->helper('captcha');
            $this->load->helper('auto_password_generate');
            $this->load->model('captcha_model');
            date_default_timezone_set('Canada/Eastern');
            //date_default_timezone_set('Asia/Kolkata');
            $this->load->model('admin_account');
            $this->load->library('session');
            session_start();
            if($this->session->userdata('adminid') == '')
            {
                redirect(base_url(),'refresh');
            }
            else if($this->session->userdata('userid') != '')
            {
                redirect("Http://cscbanking.com/user/dashboard.html",'refresh');
            }
            // Your own constructor code
       }
	public function dashboard()
	{
	   $data['tag_data'] = "Admin Dashboard";
	   $data['page']='admin_dashboard';
		$this->load->view('admin_account',$data);
	}
    public function new_ac_req()
    {
        $data['tag_data'] = "New Account Request";
        $data['all_ac'] = $this->admin_account->get_all_profile_by_type("inactive");
        $data['page']='new_ac_req';
		$this->load->view('admin_account',$data);
    }
    public function user_detail($email=null)
    {
        $data['tag_data'] = "New User Details for New Account";
        $data['ac_data'] = $this->admin_account->get_profile_detail_by_email(urldecode($email));
        $data['page']='user_detail';
		$this->load->view('admin_account',$data);
    }
    public function gen_ac($email=null)
    {
        $email = urldecode($email);
        $user_login_detail = array();
        $cheuqing_ac_detail = array();
        $debit_vm_card_detail = array();
        $max_ac_no = $this->admin_account->get_max_ac_no();
        if($max_ac_no == 0)
        {
            $e_msg = "First, Please add Main Account of Bank.";
            $data['e_msg'] = $e_msg;
        }
        else
        {
            $ac_counter = $this->admin_account->get_all_ac_by_email($email);
            $new_ac_no = $max_ac_no+1;
            if(count($ac_counter) == 0)
            {
                if($this->admin_account->chk_user_login_detail_by_email($email))
                {
                    echo "user login Already available";
                }
                else
                {
                    $pass = get_random_password();
                    $user_login = array(
                        "uemail" => $email,
                        "pswd" => md5($pass),
                        "status" => "half-active",
                        "cdate" => date('Y-m-d H:i:s'),
                        "counter" => 0
                        );
                    $this->db->insert('user_login',$user_login);
                    $data['user_login_detail'] = $this->admin_account->get_user_detail_by_email($email);
                    $this->admin_account->update_profile_status_by_email($email,"active");
                    
                    $a = array(
                    array('Name'=>'Username',"Value"=>$email),
                    array('Name'=>'Password',"Value"=>$pass),
                    array('Name'=>'Login Status',"Value"=>"Half Active"),
                    );
                    $dmsg = "Congratulation , Your new account request is accepted by Bank officer.Your login password given below.";
                    $this->send_mail($email,"admin@cscbanking.com","New Account Credentials",$dmsg,$a);
                }
                if($this->add_ac_detail($email,$new_ac_no,"cheuqing"))
                {
                    $bank_ac_no = $this->admin_account->get_bank_ac_no("bank_account");
                    if($this->transfer_fund($bank_ac_no,$new_ac_no,1000,"This is gift from bank...."))
                    {
                        //echo "Gift rewarded in new account";
                    }
                    $cheuqing_ac_detail = $this->admin_account->get_cheuging_ac_detail_by_acno($new_ac_no);
                    $data['cheuqing_ac_detail'] = $cheuqing_ac_detail;
                    $a = array(
                    array('Name'=>'Account No.',"Value"=>$cheuqing_ac_detail[0]->ac_no),
                    array('Name'=>'Account Type',"Value"=>$cheuqing_ac_detail[0]->ac_type),
                    array('Name'=>'Account Balance',"Value"=>$cheuqing_ac_detail[0]->ac_bal),
                    array('Name'=>'Account Status',"Value"=>$cheuqing_ac_detail[0]->ac_status),
                    );
                    $dmsg = "Congratulation , This is your new cheuqing account detail.";
                    $this->send_mail($email,"admin@cscbanking.com","Cheuqing Account Detail",$dmsg,$a);
                    //echo "<br/>Cheuqing Account No Created....";
                    $pin = get_random_password(4,4,false,false,true,false);
                    if($this->add_vm_card_detail($email,$pin))
                    {
                        $debit_vm_card_detail = $this->admin_account->get_debit_vm_card_detail_by_acno($new_ac_no);
                        //echo "<br/>Virtual Card Created....";
                        $data['debit_vm_card_detail'] = $debit_vm_card_detail;
                        
                        $a = array(
                        array('Name'=>'Account No.',"Value"=>$debit_vm_card_detail[0]->ac_no),
                        array('Name'=>'Card No',"Value"=>$debit_vm_card_detail[0]->card_no),
                        array('Name'=>'Card PIN',"Value"=>$pin),
                        array('Name'=>'Card Exp. Date',"Value"=>date("M-Y",strtotime($debit_vm_card_detail[0]->card_end_date))),
                        array('Name'=>'Card CVC Code',"Value"=>$debit_vm_card_detail[0]->cvc_code),
                        array('Name'=>'Amount',"Value"=>$debit_vm_card_detail[0]->amount),
                        array('Name'=>'Name on Card',"Value"=>$debit_vm_card_detail[0]->name_on_card),
                        array('Name'=>'Card Type',"Value"=>$debit_vm_card_detail[0]->card_type)
                        );
                        $dmsg = "Congratulation , This is your new Virtual Money Card Detail";
                        $this->send_mail($email,"admin@cscbanking.com","Virtual Money Card Detail",$dmsg,$a);
                    }
                    else
                    {
                        echo "error while adding virtual card";
                    }
                }
            }
            else
            {
                //echo "User Account Already created before.....";
                $ac_no = $this->admin_account->get_ac_no_by_email_actype($email,"cheuqing");
                if($ac_no!=0)
                {
                    $user_login_detail = $this->admin_account->get_user_detail_by_email($email);
                    $data['user_login_detail'] = $user_login_detail;
                    $cheuqing_ac_detail = $this->admin_account->get_cheuging_ac_detail_by_acno($ac_no);
                    $data['cheuqing_ac_detail'] = $cheuqing_ac_detail;
                    $debit_vm_card_detail = $this->admin_account->get_debit_vm_card_detail_by_acno($ac_no);
                    $data['debit_vm_card_detail'] = $debit_vm_card_detail;
                }
            }
        }
        $data['username']=$email;
        $data['page']='gen_ac';
		$this->load->view('admin_account',$data);
    }
    
    private function add_ac_detail($email,$new_ac_no,$ac_type)
    {
        if($email!=null && $new_ac_no!=null && $ac_type!=null)
        {
            if($this->admin_account->chk_ac_detail_by_email_actype($email,$ac_type))
                {
                    //echo "User Already have One Chequing Account....";
                    return false;
                }
                else
                {
                    
                    $ac_detail = array(
                        "ac_no" => $new_ac_no,
                        "username" => $email,
                        "ac_type" => $ac_type,
                        "ac_bal" => 0.0,
                        "ac_status" => "active",
                        "ac_cdate" => date('Y-m-d H:i:s')
                        );
                    $this->db->insert('ac_detail',$ac_detail);
                    //echo "No chequing account exist for this user.....";
                    return true;
                }
        }
        else
            return false;
    }
    private function add_vm_card_detail($email,$pin)
    {
        $user_profile_detail = $this->admin_account->get_profile_detail_by_email($email);
        $ac_no = $this->admin_account->get_ac_no_by_email_actype($email,"cheuqing");
        if($email!=null && $ac_no!=null && $ac_no!=0)
        {
            $max_vm_card_no = $this->admin_account->get_max_vm_card_no();
            if($max_vm_card_no==0)
            {
                $max_vm_card_no = "3222211110000";
            }
            else
                $max_vm_card_no = $max_vm_card_no + 1;
            $ac_detail = array(
                        "ac_no" => $ac_no,
                        "card_no" => $max_vm_card_no,
                        "card_pin" =>$pin,
                        "card_end_date" => date('Y-m-d',strtotime("+1 year",time())),
                        "cvc_code" => get_random_password(3,3,false,false,true,false),
                        "amount" =>0,
                        "max_limit" =>0,
                        "card_type" =>"Debit",
                        "card_tax" =>0.0,
                        "card_cdate" => date('Y-m-d H:i:s'),
                        "name_on_card" => substr($user_profile_detail[0]->fname." ".$user_profile_detail[0]->lname,0,15)
                        );
            $this->db->insert('virtual_money_card',$ac_detail);
            return true;
        }
        else
            return false;
    }
    private function transfer_fund($ac_from,$ac_to,$amount,$detail)
    {
        $flag_from = $this->admin_account->valid_acno($ac_from,"bank_account");
        $flag_to = $this->admin_account->valid_acno($ac_to,"cheuqing");
        if($flag_from && $flag_to && $amount > 0)
        {
            $bal_from = $this->admin_account->get_bal_by_ac($ac_from);
            $bal_to = $this->admin_account->get_bal_by_ac($ac_to);
            if($bal_from > $amount)
            {
                $final_bal_from = $bal_from - $amount;
                $final_bal_to = $bal_to + $amount;
                
                if($this->admin_account->update_balance_by_ac_no($ac_from,$final_bal_from))
                {
                    if($this->admin_account->update_balance_by_ac_no($ac_to,$final_bal_to))
                    {
                        //echo "Both Done";
                        if($this->admin_account->add_transaction_detail($ac_from,$ac_to,$amount,$final_bal_from,$final_bal_to,$detail))
                        {
                            return true;
                            //echo "All Done";
                        }
                        else
                        {
                            $this->admin_account->update_balance_by_ac_no($ac_from,$bal_from);
                            $this->admin_account->update_balance_by_ac_no($ac_to,$bal_to);
                            //echo "Trans fail, all both done";
                            return false;
                        }
                    }
                    else
                    {
                        $this->admin_account->update_balance_by_ac_no($ac_from,$bal_from);
                        //echo "Transfer error TO, FROM success";
                        return false;
                    }
                }
                else
                {
                    //echo "Transfer error FROM";
                    return false;
                }
            }
            else
            {
                //echo "Account Balance not efficient....";
                return false;
            }   
        }
        else
            return false;
    }
    
    public function list_all_cheques()
    {
        $data['tag_data'] = "list All Cheques Deposite Request";
        $data['cheques_detail'] = $this->admin_account->get_all_cheque('pending');
        $data['page']='list_all_cheques';
		$this->load->view('admin_account',$data);
    }
    public function cheque_detail($x)
    {
        $x = explode("-",$x);
        if(strlen($x[0])==6 && strlen($x[1])==8)
        {
            $data['cheque_detail'] = $this->admin_account->get_cheque_detail_by_chqno_acno($x[0],$x[1]);    
        }
        $data['page']='cheque_detail';
		$this->load->view('admin_account',$data);
    }
    
    public function approve_cheque($x)
    {
        
        $x = explode("-",$x);
        if(strlen($x[0])==6 && strlen($x[1])==8)
        {
            $cheque_detail = $this->admin_account->get_cheque_detail_by_chqno_acno($x[0],$x[1]);
            $data['cheque_detail'] =$cheque_detail;
            if(count($cheque_detail) == 1)
            {
                $from = $cheque_detail[0]->from_ac;
                $to = $cheque_detail[0]->to_ac;
                $amount = $cheque_detail[0]->amount;
                $chq_no = $cheque_detail[0]->chq_no;
                $userid = $cheque_detail[0]->uemail;
                if($this->admin_account->transfer_money_from_acno_to_acno($from,$to,$amount,$chq_no."-Cheque approved. Amount Credited."))
                {
                    if(!$this->admin_account->update_cheque_status_by_chno_acno($x[0],$x[1],"Approved"))
                        echo "Error in updating status of cheque-",$cheque_detail[0]->chq_no;
                    
                    $a = array(
                                    array('Name'=>'Cheque No.',"Value"=>$cheque_detail[0]->chq_no),
                                    array('Name'=>'Amount',"Value"=>$cheque_detail[0]->amount),
                                    array('Name'=>'Bank Detail',"Value"=>$cheque_detail[0]->bank_detail),
                                    array('Name'=>'New Balance',"Value"=>$this->admin_account->get_bal_by_ac($cheque_detail[0]->to_ac))
                                    );
                                    $dmsg = "Congratulations, Your cheque resquest is approved.";
                                    $this->send_mail($userid,"admin@cscbanking.com","Cheque Approved",$dmsg,$a);
                                    
                    $url = base_url()."list-all-cheques.html";
                    redirect($url);
                }
            }
        }
    } 
    public function disapprove_cheque($x)
    {
        $x = explode("-",$x);
        if(strlen($x[0])==6 && strlen($x[1])==8)
        {
            $cheque_detail = $this->admin_account->get_cheque_detail_by_chqno_acno($x[0],$x[1]);
            if(count($cheque_detail) == 1)
            {
                $userid = $cheque_detail[0]->uemail;
                    if(!$this->admin_account->update_cheque_status_by_chno_acno($x[0],$x[1],"Disapproved"))
                        echo "Error in updating status of cheque-",$cheque_detail[0]->chq_no;
                    $a = array(
                                    array('Name'=>'Cheque No.',"Value"=>$cheque_detail[0]->chq_no),
                                    array('Name'=>'Amount',"Value"=>$cheque_detail[0]->amount),
                                    array('Name'=>'Bank Detail',"Value"=>$cheque_detail[0]->bank_detail)
                                    );
                                    $dmsg = "Sorry, Cheque request is disapprove by bank officer. Contact near branch.";
                                    $this->send_mail($userid,"admin@cscbanking.com","Cheque Disapprove",$dmsg,$a);
                    $url = base_url()."list-all-cheques.html";
                    redirect($url);
            } 
        }
    } 
    
    public function add_billing_companies()
    {
        $this->load->helper('form');
    	$this->load->library('form_validation');
        $data['tag_data'] = "Add New Billing Company";
        $this->form_validation->set_rules('usr', 'Username', 'trim|strip_tags|xss_clean|required|valid_email');
        $this->form_validation->set_rules('fname', 'First Name', 'required');
        $this->form_validation->set_rules('lname', 'Last Name', 'required');
        $this->form_validation->set_rules('city', 'City Name', 'required');
        $this->form_validation->set_rules('adrs', 'Address', 'required');
        $this->form_validation->set_rules('state', 'State Name', 'required');
        $this->form_validation->set_rules('doc_id', 'Document No./ID', 'required');
        $this->form_validation->set_rules('mno', 'Mobile number.', 'required');
        $this->form_validation->set_rules('zipc', 'Zip Code', 'required');

        if ($this->form_validation->run() === FALSE)
    	{
            
    	}
    	else
    	{
              $allowedExts = array("gif", "jpeg", "jpg", "png");
                $temp_ext = explode(".", $_FILES["doc_file"]["name"]);
                $extension = end($temp_ext);
                $extension = strtolower($extension);
                if ((($_FILES["doc_file"]["type"] == "image/gif") || ($_FILES["doc_file"]["type"] == "image/jpeg") || ($_FILES["doc_file"]["type"] == "image/jpg")
                || ($_FILES["doc_file"]["type"] == "image/pjpeg") || ($_FILES["doc_file"]["type"] == "image/x-png") || ($_FILES["doc_file"]["type"] == "image/png"))
                && ($_FILES["doc_file"]["size"] < 200000) && in_array($extension, $allowedExts))
                  {
                  if ($_FILES["doc_file"]["error"] > 0)
                    {
                        $msg = "Error: " . $_FILES["doc_file"]["error"] . "<br>";
                    }
                  else
                    {
                        $file_name = md5($_FILES["doc_file"]["name"].time()).'.'.$extension;
                          if(move_uploaded_file($_FILES["doc_file"]["tmp_name"],"../upload/" . $file_name))
                          {
                                $user_array = array(
                                "uemail" => $this->input->post("usr"),
                                "fname" => $this->input->post("fname"),
                                "lname" => $this->input->post("lname"),
                                "address" => $this->input->post("adrs"),
                                "city" => $this->input->post("city"),
                                "state" => $this->input->post("state"),
                                "zip_code" => $this->input->post("zipc"),
                                "mno" => $this->input->post("mno"),
                                "doc_file" => $file_name,
                                "doc_id" => $this->input->post("doc_id"),
                                "status" => "active",
                                "cdate" => date('Y-m-d H:i:s')
                                );
                               if(!$this->admin_account->check_userid($this->input->post("usr")))
                               {
                                    if($this->db->insert("user_profile",$user_array))
                                    {
                                        $msg = "Successful Registration.......";  
                                        $this->gen_bill_ac($this->input->post("usr"));
                                        $this->form_validation->unset_field_data();
                                    }
                               }
                               else
                                    {
                                        $msg = "User already exist....";
                                    }
                          }
                          else
                          {
                                $msg = "File uploadation error.....";
                          }
                    }
                  }
                else
                  {
                    $msg = "Invalid file";
                  }
    	   $data['msg'] = $msg;
    	}
        
        $data['page']="add_bill_company";
        $this->load->view('admin_account',$data);
    }         
    
    public function gen_bill_ac($email)
    {
        $max_ac_no = $this->admin_account->get_max_ac_no();
        if($max_ac_no == 0)
        {
            $e_msg = "First, Please add Main Account of Bank.";
            $data['e_msg'] = $e_msg;
        }
        else
        {
            $ac_counter = $this->admin_account->get_all_ac_by_email($email);
            $new_ac_no = $max_ac_no+1;
            if(count($ac_counter) == 0)
            {
/*              BILL COMPANY LOGIN
                if($this->admin_account->chk_user_login_detail_by_email($email))
                {
                    echo "user login Already available";
                }
                else
                {
                    $pass = get_random_password();
                    $user_login = array(
                        "uemail" => $email,
                        "pswd" => md5($pass),
                        "status" => "half-active",
                        "cdate" => date('Y-m-d H:i:s'),
                        "counter" => 0
                        );
                    $this->db->insert('user_login',$user_login);
                    $data['user_login_detail'] = $this->admin_account->get_user_detail_by_email($email);
                    $this->admin_account->update_profile_status_by_email($email,"active");
                }
                */
                if($this->add_ac_detail($email,$new_ac_no,"company_account"))
                {
                    return true;
                }
                else
                    return false;
            }
            else
                return false;
        }
    }
    public function list_all_billing_companies()
    {
        $company_detail = $this->admin_account->get_all_bank_ac();
        $data['company_detail'] = $company_detail;
        $data['tag_data'] = "List Billing Company";
        $data['page']="list_bill_company";
        $this->load->view('admin_account',$data);
    }
    public function company_detail($ac_no)
    {
        $company_detail = $this->admin_account->get_bank_detail_by_acno($ac_no);
        $data['company_detail'] = $company_detail;
        $data['tag_data'] = "Billing Company Detail";
        $data['page']="company_detail";
        $this->load->view('admin_account',$data);
    }
    
    public function credit_card_req()
    {
        $cc_req_detail = $this->admin_account->get_all_pending_credit_card_req();
        $data['cc_req_detail'] = $cc_req_detail;
        $data['tag_data'] = "List All Credit Card Request";
        $data['page']="list_credit_card_req";
        $this->load->view('admin_account',$data);
    }
    public function credit_card_detail($email)
    {
        $email = urldecode($email);
        $card_req_detail = $this->admin_account->get_credit_req_by_email($email);
        $data['card_req_detail'] = $card_req_detail;
        $user_profile_detail = $this->admin_account->get_profile_detail_by_email($email);
        $data['user_profile_detail'] = $user_profile_detail;
        $ac_no = $this->admin_account->get_ac_no_by_email_actype($email,"cheuqing");
        $cheuqing_ac_detail = $this->admin_account->get_cheuging_ac_detail_by_acno($ac_no);
        $data['cheuqing_ac_detail'] = $cheuqing_ac_detail;
        $debit_vm_card_detail = $this->admin_account->get_debit_vm_card_detail_by_acno($ac_no);
        $data['debit_vm_card_detail'] = $debit_vm_card_detail;
        if($this->admin_account->check_credit_account($email))
        {
            $new_ac_no = $this->admin_account->get_ac_no_by_email_actype($email,"credit");
            $credit_card_detail = $this->admin_account->get_credit_card_detail_by_acno($new_ac_no);
            $data['credit_card_detail'] = $credit_card_detail;
        }
        $data['tag_data'] = "Credit Card Request";
        $data['page']="credit_card_req_detail";
        $data['userid'] = $email;
        $this->load->view('admin_account',$data);
    }
    public function generate_credit_card($card_detail)
    {
        $card_detail = urldecode($card_detail);
        $card_detail = explode("-",$card_detail);
        if(count($card_detail)==3)
        {
            $email = $card_detail[1];
            $data['user_email'] = $email;
            if(!$this->admin_account->check_credit_account($card_detail[1]))
            {
                $cd = array('cc_req_id'=>$card_detail[0],'email'=>$card_detail[1],'card_type'=>$card_detail[2]);
                $data['card_request_detail'] =  $cd;
                $this->load->helper('form');
            	$this->load->library('form_validation');
                $this->form_validation->set_rules('card_type', 'Card Type', 'greater_than[0]|numeric|callback_check_credit_type');
                if($this->form_validation->run() === TRUE)
            	{
            	   $email = $this->input->post('email');
                   $req_id = $this->input->post('req_id');
                   $ap_card_type = $this->input->post('card_type');
                   $req_card_type = $card_detail[2];
                   if($ap_card_type != $req_card_type)
                   {
                        $this->db->update('manage_credit_card_request',array('type'=>$ap_card_type));
                   }
                   $this->admin_account->update_credit_req_status_by_email($email,"Active");
                   $ap_card_detail = $this->admin_account->get_credit_card_type_detail_by_cid($ap_card_type);
                   $max_ac_no = $this->admin_account->get_max_ac_no();
                   $new_ac_no = $max_ac_no + 1;
                   $limit = $ap_card_detail[0]->limit;
                   $int_rate = $ap_card_detail[0]->int_rate;
                   if($this->add_ac_detail($email,$new_ac_no,"credit") && $limit > 0)
                    {
                        $cheuqing_ac_detail = $this->admin_account->get_credit_ac_detail_by_acno($new_ac_no);
                        $data['credit_ac_detail'] = $cheuqing_ac_detail;
                        //echo "<br/>Cheuqing Account No Created....";
                        $pin = get_random_password(4,4,false,false,true,false);
                        if($this->add_credit_card_detail($email,$limit,$int_rate,$pin))
                        {
                            $credit_card_detail = $this->admin_account->get_credit_card_detail_by_acno($new_ac_no);
                            //echo "<br/>Virtual Card Created....";
                            $data['credit_card_detail'] = $credit_card_detail;
                            
                            $a = array(
                                array('Name'=>'Account No.',"Value"=>$credit_card_detail[0]->ac_no),
                                array('Name'=>'Card No',"Value"=>$credit_card_detail[0]->card_no),
                                array('Name'=>'Card PIN',"Value"=>$pin),
                                array('Name'=>'Card Exp. Date',"Value"=>date("M-Y",strtotime($credit_card_detail[0]->card_end_date))),
                                array('Name'=>'Card CVC Code',"Value"=>$credit_card_detail[0]->cvc_code),
                                array('Name'=>'Amount',"Value"=>$credit_card_detail[0]->amount),
                                array('Name'=>'Name on Card',"Value"=>$credit_card_detail[0]->name_on_card),
                                array('Name'=>'Card Type',"Value"=>$credit_card_detail[0]->card_type)
                                );
                                $dmsg = "Congratulation , This is your new Credit Card Detail";
                                $this->send_mail($email,"admin@cscbanking.com","Credit Card Detail",$dmsg,$a);
                        }
                        else
                        {
                            echo "Credit Account created successfully, <br/> Error: Problem to create credit card no. <br/>
                            Note: Please delete Credit Account and Contact System Admin.";
                        }
                    }
                    else
                    {
                        echo "Error: Problem to create Credit Account.";
                    }
                   $ap_card_detail = $this->admin_account->get_credit_card_type_detail_by_cid($ap_card_type);
            	}
            }
            else
            {
                $new_ac_no = $this->admin_account->get_ac_no_by_email_actype($email,"credit");
                   $cheuqing_ac_detail = $this->admin_account->get_credit_ac_detail_by_acno($new_ac_no);
                    $data['credit_ac_detail'] = $cheuqing_ac_detail;
                    $credit_card_detail = $this->admin_account->get_credit_card_detail_by_acno($new_ac_no);
                    $data['credit_card_detail'] = $credit_card_detail;
            } 
        }
        $data['tag_data'] = "Generate Account For Credit Card";
        $data['page']="generate_credit_card";
        $this->load->view('admin_account',$data);
    }
    
    //HISTORY MODULES
    public function transaction_history()
    {
        $data['tag_data'] = "list All Bank Trasanction";
        $data['transaction_history'] = $this->admin_account->get_all_transaction_history();
        $data['page']='transaction_history';
		$this->load->view('admin_account',$data);
    }
    public function cheque_history()
    {
        $data['tag_data'] = "list All Approved Cheques";
        $data['cheques_detail'] = $this->admin_account->get_all_cheque('Approved');
        $data['page']='cheque_history';
		$this->load->view('admin_account',$data);
    }
    public function login_history()
    {
        $data['tag_data'] = "Login History";
        $adminid=$this->session->userdata('adminid');
        $data['login_detail'] = $this->admin_account->get_all_login_history($adminid,20);
        $data['page']='login_history';
		$this->load->view('admin_account',$data);
    }
    
    private function add_credit_card_detail($email,$limit,$int_rate,$pin)
    {
        $user_profile_detail = $this->admin_account->get_profile_detail_by_email($email);
        $ac_no = $this->admin_account->get_ac_no_by_email_actype($email,"credit");
        if($email!=null && $ac_no!=null && $ac_no!=0 && $limit >0)
        {
            $max_vm_card_no = $this->admin_account->get_max_vm_card_no();
            if($max_vm_card_no==0)
            {
                $max_vm_card_no = "3222211110000";
            }
            else
                $max_vm_card_no = $max_vm_card_no + 1;
            $ac_detail = array(
                        "ac_no" => $ac_no,
                        "card_no" => $max_vm_card_no,
                        "card_pin" =>$pin,
                        "card_end_date" => date('Y-m-d',strtotime("+1 year",time())),
                        "cvc_code" => get_random_password(3,3,false,false,true,false),
                        "amount" =>0,
                        "max_limit" => $limit,
                        "card_type" =>"Credit",
                        "card_tax" => $int_rate,
                        "card_cdate" => date('Y-m-d H:i:s'),
                        "name_on_card" => substr($user_profile_detail[0]->fname." ".$user_profile_detail[0]->lname,0,15)
                        );
            $this->db->insert('virtual_money_card',$ac_detail);
            return true;
        }
        else
            return false;
    }
    function calc_credit_inr($card_no)
    {
        $data['tag_data'] = "Credit Card e-Statement";
        $credit_detail = $this->admin_account->get_credit_card_detail_by_cardno($card_no);
        $data['credit_detail'] = $credit_detail;
        $transaction_history = $this->admin_account->get_all_transaction_history_by_chequing_ac_no($card_no);
        if(isset($_GET['gen_estate']) && $_GET['gen_estate'] ==1)
        {
            if(isset($_GET['dstart']) && isset($_GET['dend']))
            {
                if(!$this->admin_account->check_estatement($card_no,$_GET['dstart'],$_GET['dend']))
                {
                    $this->admin_account->add_estatement_record($card_no,$_GET['dstart'],$_GET['dend'],$credit_detail[0]->card_tax);
                    header("Location:".base_url()."view-estatement.html?card_no=".$card_no."&dstart=".$_GET['dstart']."&dend=".$_GET['dend']);
                }
            }
        }
        $data['transaction_history'] = $transaction_history;
        $data['page']="calc_credit_inr";
        $data['ac_no'] = $card_no;
        $this->load->view('admin_account',$data);
    }
    function view_estatement()
    {
        $msg="Estatement Detail";
        if(isset($_GET['dstart']) && isset($_GET['dend']) && isset($_GET['card_no']))
        {
            $card_no = $_GET['card_no'];
            $s_date = $_GET['dstart'];
            $e_date = $_GET['dend'];
            $msg = "Estatement Detail for ".$card_no;
            $data['ac_no'] = $card_no;
            $data['sdate'] = $s_date;
            $data['edate'] = $e_date;
            if($this->admin_account->check_estatement($card_no,$s_date,$e_date))
            {
                $s_date1 = date("Y/m/d",$s_date);
                $e_date1 = date("Y/m/d",$e_date);
                $d = $this->admin_account->get_all_transaction_by_ac_no($card_no,$s_date1,$e_date1);
                $data['transaction_history'] = $d;
                $estatement_detail = $this->admin_account->get_estatement($card_no,$s_date,$e_date);
                $data['estatement_detail'] = $estatement_detail;
                $pre_estatement_detail = $this->admin_account->get_previous_estatement($card_no,$s_date);
                $data['pre_estatement_detail'] = $pre_estatement_detail;
                $credit_detail = $this->admin_account->get_credit_card_detail_by_cardno($card_no);
                $data['credit_detail'] = $credit_detail;
            }
        }
        $data['tag_data'] = $msg;
        $data['page']="estatement-detail";
        $this->load->view('admin_account',$data);
    }
    public function stock_center()
    {
        $userid=$this->session->userdata('userid');
        $msg = "";
        $data['msg'] =$msg;
        $data['tag_data'] = "Stock Center";
        $data['page']='stock_center';
        $stock_detail = $this->admin_account->get_all_stock();
        $data['stock_detail'] = $stock_detail;
        $data['userid'] = $userid;
		$this->load->view('admin_account',$data);
    }
    public function fixed_deposit()
    {
        $data['tag_data'] = "Fixed Deposit";
        $data['page']='fixed_deposit';
		$this->load->view('admin_account',$data);
    }
    function send_mail($to,$from,$subject,$msg,$detail)
    {
        $m_to      = $to;
        $m_subject = $subject;
        $message = '<!DOCTYPE HTML>
            <html>
            <head>
            	<meta http-equiv="content-type" content="text/html" />
            	<meta name="author" content="phpdesigner" />
            	<title>Untitled 1</title>
            </head>
            <body>
            <div style="margin: 0 auto;width: 700px;background: white;padding: 0;margin-top: -9px;box-shadow: 0 0 10px #777;">
            <div style="border: 2px solid #970834;"></div>
            <div style="font-size: 18px;height: 20px;background: #ffffff;width: 100%;border-bottom: 1px solid #970834;color: #970834; padding: 20px 0px;text-indent: 10px;">
                Bank De Concordia Student Community...
            </div>
            <div style="margin: 10px 0 10px 10px;padding: 5px;border-left: 2px solid #970834;background: #dfdfdf;color: #970834;text-transform: capitalize;">'.$m_subject.'</div>
            <br/>
            <p>'.$msg.'</p>
            <br/>
            <table style="width: 500px;border-spacing: 0px;margin: 0 0 10px 10px">';
            if(isset($detail) && $detail != "")
            {
                $i = 0;
                foreach($detail as $row)
                {
                    if($i%2 == 0)
                        $message.= "<tr>";
                    else
                        $message.= '<tr style="background: #dfdfdf;">';
                        
                    $message.= '
                        <td style="width: 200px;padding: 4px;border-bottom: 1px dotted #970834;">'.$row['Name'].'</td>
                        <td style="padding: 4px;border-bottom: 1px dotted #970834;">: '.$row['Value'].'</td>
                        </tr>';
                }
            }
            $message.= '</table>
            <div style="padding: 10px 20px 0 20px;background: #970834;height: 30px;">
                    <div style="float: left;">
                        <a class="a_white" href="http://cscbanking.com/" style="color: #fff;text-decoration: none;border-bottom: 1px dotted #fff;">Home</a> | 
                        <a class="a_white" href="http://cscbanking.com/bank-services.html" style="color: #fff;text-decoration: none;border-bottom: 1px dotted #fff;">Services</a> | 
                        <a class="a_white" href="http://cscbanking.com/new-registration.html" style="color: #fff;text-decoration: none;border-bottom: 1px dotted #fff;">New Customer</a> | 
                        <a class="a_white" href="http://cscbanking.com/user_login.html" style="color: #fff;text-decoration: none;border-bottom: 1px dotted #fff;">Customer Login</a>
                    </div>
                    <div style="float: right;color: white;">
                        C$C Banking &copy; 2014, Academic Project
                    </div> 
            </div>
            </div>
            </body>
            </html>';
            $random_hash = md5(date('r', time())); 
            $headers = "MIME-Version: 1.0" . "\r\n";
            $headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
            
            // More headers
            $headers .= 'From: CSC Bank Admin<'.$from.'>' . "\r\n";
            $headers .= 'Reply-To: CSC Bank Admin<'.$from.'>' . "\r\n";
        ob_start();
        
        $mail_sent = mail($m_to, $m_subject, $message, $headers);
        return $mail_sent;
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */