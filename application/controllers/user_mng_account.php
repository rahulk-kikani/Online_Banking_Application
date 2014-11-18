<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class User_mng_account extends CI_Controller {
    
    public function __construct()
       {
            parent::__construct();
            $this->load->helper('url');
            $this->load->helper('date');
            $this->load->library('assets');
            $this->load->helper('cookie');
            $this->load->helper('captcha');
            $this->load->model('captcha_model');
            date_default_timezone_set('Canada/Eastern');
            //date_default_timezone_set('Asia/Kolkata');
            $this->load->model('user_account');
            $this->load->library('session');
            // Your own constructor code
            session_start();
            if($this->session->userdata('userid') == '')
            {
                redirect(base_url(),'refresh');
            }
       }
	public function dashboard()
	{
	   $email = $this->session->userdata('userid');
       $data['userid'] = $email;
       $ac_no = $this->user_account->get_ac_no_by_email_actype($email,"cheuqing");
       if($ac_no != 0)
       {
            $user_profile_detail = $this->user_account->get_profile_detail_by_email($email);
            $data['user_profile_detail'] = $user_profile_detail;
            $user_login_detail = $this->user_account->get_user_detail_by_email($email);
            $data['user_login_detail'] = $user_login_detail;
            $cheuqing_ac_detail = $this->user_account->get_cheuging_ac_detail_by_acno($ac_no);
            $data['cheuqing_ac_detail'] = $cheuqing_ac_detail;
            $debit_vm_card_detail = $this->user_account->get_debit_vm_card_detail_by_acno($ac_no);
            $data['debit_vm_card_detail'] = $debit_vm_card_detail;
            
            //$detail = $this->user_account->todays_total_transaction($email);
            
       }
                    
       $data['tag_data'] = "User Deshboard";
	   $data['page']='user_dashboard';
		$this->load->view('template_user_account',$data);
	}
    public function set_security_questions()
    {
        $userid=$this->session->userdata('userid');
        $data['tag_data'] = "Security Question?";
        $this->load->helper('form');
    	$this->load->library('form_validation');
        
        $this->form_validation->set_rules('secure_q', 'Security Question', 'required');
        $this->form_validation->set_rules('secure_ans', 'Answer', 'required');
        
        if ($this->form_validation->run() === TRUE)
    	{
            if(!$this->user_account->check_security_q_by_email($userid))
            {
                $question_id = $this->input->post('secure_q');
                $secure_ans = $this->input->post('secure_ans');
                $a = array('question_id'=>$question_id,'secure_ans'=>$secure_ans,'uemail'=>$userid);
                $this->db->insert('user_security',$a);
                $this->user_account->update_login_status_by_email($userid,"active");
                
                    $a = array(
                    array('Name'=>'Security Question',"Value"=>$this->user_account->get_security_que_email($userid)),
                    array('Name'=>'Answer',"Value"=>$secure_ans)
                    );
                    $dmsg = "Just you set your Secrity Question, Keep it secret. It required while resetting password.";
                    $this->send_mail($userid,"admin@cscbanking.com","Set Security Question",$dmsg,$a);
            }
            else
            {
                echo "error while adding security question";   
            }
    	}
    	else
    	{

        }
        $data['secure_flag'] = $this->user_account->check_security_q_by_email($userid);
        $data['page']='set_security_questions';
        $data['userid'] = $userid;
        $data['side_menu'] = "Hide";
		$this->load->view('template_user_account',$data);
    }
    
    public function withdraw_money()
    {
        $userid=$this->session->userdata('userid');
        
        $this->load->library('form_validation');
        $this->form_validation->set_rules('amount', 'Amount', 'trim|numeric|required');
        if ($this->form_validation->run() === TRUE)
    	{
    	   $amount = $this->input->post('amount');
           $ac_no = $this->user_account->get_ac_no_by_email_actype($userid,"cheuqing");
           $ac_bal = $this->user_account->get_bal_by_ac($ac_no);
            if($amount > 0 && $ac_bal >= $amount)
            {
                $vm_card_no = $this->user_account->get_vm_card_no_by_acno_actype($ac_no,"Debit");
                $t_detail = 'Transfter made from Chequing account to Virtual Money Card';
                if($this->user_account->transfer_money_from_acno_to_cardno($ac_no,$vm_card_no,$amount,$t_detail))
                {
                    
                    $data['success_msg']="Money transferred... Transaction receipt mailed to your email address.";
                    
                    $a = array(
                    array('Name'=>'Transaction Id',"Value"=>$this->user_account->get_transaction_no($ac_no,$vm_card_no,$amount,$t_detail)),
                    array('Name'=>'A/c [from]',"Value"=>$ac_no),
                    array('Name'=>'A/c [to]',"Value"=>"453".$vm_card_no),
                    array('Name'=>'Amount',"Value"=>$amount),
                    array('Name'=>'Detail',"Value"=>$t_detail)
                    );
                    $dmsg = "Congratulations, Transaction successfully made, and money transferred to your Virtual Money Card";
                    $this->send_mail($userid,"admin@cscbanking.com","Fund Withdraw",$dmsg,$a);
                }
            }
            
    	}
    	else
    	{

        }
        $data['tag_data'] = "Withdraw Money";
        $data['page']='withdraw_money';
        $data['userid'] = $userid;
		$this->load->view('template_user_account',$data);
    }
    public function acno_check($value)
    {
        $userid=$this->session->userdata('userid');
        $ac_no = $this->user_account->get_ac_no_by_email_actype($userid,"cheuqing");
        if((!$this->user_account->valid_acno_by_acno($value)) || $ac_no == $value)
        {
            $this->form_validation->set_message('acno_check','Cheque account no. not valid, You can not deposite this cheque.');
            return false;
        }
        else
        {
            return true;
        }
    }
    public function cheuqing_acno_check($value)
    {
        if(!$this->user_account->valid_acno_by_acno_type($value,'cheuqing'))
        {
            $this->form_validation->set_message('cheuqing_acno_check','Cheuqing account no. NOT VALID.');
            return false;
        }
        else
        {
            return true;
        }
    }
    public function company_acno_check($value)
    {
        if(!$this->user_account->valid_acno_by_acno_type($value,'company_account'))
        {
            $this->form_validation->set_message('company_acno_check','Company account no. is not valid, You can not pay bill.');
            return false;
        }
        else
        {
            return true;
        }
    }
    public function mix_acno_check($value)
    {
        $ac_type = $this->user_account->check_ac_type($value);
        if($ac_type == "cheuqing" || $ac_type == "investment")
        {
            if(!$this->user_account->valid_acno_by_acno($value))
            {
                $this->form_validation->set_message('mix_acno_check','Selected account no. is not valid.');
                return false;
            }
            else
            {
                return true;
            }
        }
        else if($ac_type == "card")
        {
            if(!$this->user_account->valid_vmc_no_by_vmc_no($value))
            {
                $this->form_validation->set_message('mix_acno_check','Selected Card no. is not valid.');
                return false;
            }
            else
            {
                return true;
            }
        }
        else
        {
            $this->form_validation->set_message('mix_acno_check','Selected A/c or Card is not valid.');
            return false;
        }
    }
    public function deposite_cheque()
    {
        $userid=$this->session->userdata('userid');
        $data['ac_detail'] = $this->user_account->get_all_ac_by_email($userid);
        $this->load->helper('form');
    	$this->load->library('form_validation');
        
        $this->form_validation->set_rules('chq_no', 'Cheque No', 'trim|exact_length[6]|numeric|required');
        $this->form_validation->set_rules('chq_ac_no', 'Cheque account no.', 'trim|exact_length[8]|numeric|required|callback_acno_check');
        $this->form_validation->set_rules('bank_detail', 'Bank Detail', 'min_length[5]|required');
        $this->form_validation->set_rules('chq_date', 'Date', 'required');
        $this->form_validation->set_rules('amount', 'Amount', 'greater_than[0]|numeric|required');
        $msg = "";
        if ($this->form_validation->run() === FALSE)
    	{
            
    	}
    	else
    	{
          $bank_detail = $this->input->post('bank_detail');
          $chq_date = $this->input->post('chq_date');
          $chq_amount = $this->input->post('amount');
          $chq_no = $this->input->post('chq_no');
          $chq_ac_no = $this->input->post('chq_ac_no');
          if(!$this->user_account->check_cheque_by_chqno_acno($chq_no,$chq_ac_no))
          {
             $ac_no = $this->user_account->get_ac_no_by_email_actype($userid,"cheuqing");
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
                        $file_name = md5("chq_".$_FILES["doc_file"]["name"].time()).'.'.$extension;
                          if(move_uploaded_file($_FILES["doc_file"]["tmp_name"],"upload/cheques/" . $file_name))
                          {
                                $user_array = array(
                                "uemail" => $userid,
                                "to_ac" => $ac_no,
                                "from_ac" => $chq_ac_no,
                                "chq_no" => $chq_no,
                                "bank_detail" => $bank_detail,
                                "amount" => $chq_amount,
                                "cdate" => date('Y-m-d H:i:s'),
                                "chq_date" => date('Y-m-d',strtotime($chq_date)),
                                "status" => "processing",
                                "msg"=>"none",
                                "attached_file" => $file_name,
                                );
                                if($this->db->insert("cheques_detail",$user_array))
                                {
                                    $s_msg = "Your cheque request has been submitted successful...You will get cheque conformaion mail,Soon....";
                                    $data['s_msg'] = $s_msg;
                                    
                                    $a = array(
                                    array('Name'=>'A/c [to]',"Value"=>$ac_no),
                                    array('Name'=>'Cheque A/c',"Value"=>$chq_ac_no),
                                    array('Name'=>'Cheque No.',"Value"=>$chq_no),
                                    array('Name'=>'Amount',"Value"=>$chq_amount),
                                    array('Name'=>'Bank Detail',"Value"=>$bank_detail),
                                    array('Name'=>'Date',"Value"=>date('Y-m-d',strtotime($chq_date)))
                                    );
                                    $dmsg = "Your cheque request has been submitted successful..Now it's in under processing.";
                                    $this->send_mail($userid,"admin@cscbanking.com","Cheque Deposite",$dmsg,$a);
                                    $this->form_validation->unset_field_data();
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
                }
                else
                    $msg = "You can not deposite this cheque, Becuase this cheque already deposited...";
    	}
        $data['msg'] = $msg;
        $data['tag_data'] = "Deposit Money by Cheque";
        $data['page']='deposite_cheque';
        $data['userid'] = $userid;
		$this->load->view('template_user_account',$data);
    }
    
    public function transfer_money()
    {
        $userid=$this->session->userdata('userid');
        $this->load->helper('form');
    	$this->load->library('form_validation');
        $msg="";
        if(isset($_POST['submit1']))
        {
            $this->form_validation->set_rules('ac_from', 'Primary Account No.', 'trim|numeric|callback_mix_acno_check');
            $this->form_validation->set_rules('ac_to', 'Destination A/c No.', 'trim|numeric|callback_mix_acno_check');
            $this->form_validation->set_rules('amount', 'Amount', 'greater_than[0]|numeric|required');
            $msg = "";
            if ($this->form_validation->run() === TRUE)
        	{
        	   $ac_from = $this->input->post('ac_from');
               $ac_to = $this->input->post('ac_to');
               $amount = $this->input->post('amount');
        	   if($ac_from != $ac_to)
                {
                    $ac_from_len = strlen($ac_from);
                    $ac_to_len = strlen($ac_to);
                    if($ac_from_len == 8 && $ac_to_len == 8)
                    {
                        $ac_bal = $this->user_account->get_bal_by_ac($ac_from);
                        if($ac_bal >= $amount)
                        {
                            $t_detail = 'Transfter made between Cheuquing account and Investment A/c';
                            if($this->user_account->transfer_money_from_acno_to_acno($ac_from,$ac_to,$amount,$t_detail))
                            {
                                $data['s_msg1']="Money transferred.... You will get receipt by email soon.";
                                $a = array(
                                array('Name'=>'Transaction Id',"Value"=>$this->user_account->get_transaction_no($ac_from,$ac_to,$amount,$t_detail)),
                                array('Name'=>'A/c [from]',"Value"=>$ac_from),
                                array('Name'=>'A/c [to]',"Value"=>$ac_to),
                                array('Name'=>'Amount',"Value"=>$amount),
                                array('Name'=>'New Balance',"Value"=>$this->user_account->get_bal_by_ac($ac_to)),
                                array('Name'=>'Detail',"Value"=>$t_detail)
                                );
                                $dmsg = "Congratulations, Transaction successfully made.";
                                $this->send_mail($userid,"admin@cscbanking.com","Fund Transfer",$dmsg,$a);
                                $this->form_validation->unset_field_data();
                            }
                            else
                                $msg = "Error: Sorry, your fund not transferred yet. ";
                        }
                        else
                            $msg = "Sorry, You can not transfer money because of your accont balance is low.";
                    }
                    else if($ac_from_len == 8 && $ac_to_len == 13)
                    {
                        $ac_bal = $this->user_account->get_bal_by_ac($ac_from);
                        if($ac_bal >= $amount)
                        {
                            $t_detail = 'Transfter made from Cheuquing account to Virtual Money Card';
                            if($this->user_account->transfer_money_from_acno_to_cardno($ac_from,$ac_to,$amount,$t_detail))
                            {
                                $data['s_msg1']="Money transferred.... You will get receipt by email soon.";
                                $a = array(
                                array('Name'=>'Transaction Id',"Value"=>$this->user_account->get_transaction_no($ac_from,$ac_to,$amount,$t_detail)),
                                array('Name'=>'A/c [from]',"Value"=>$ac_from),
                                array('Name'=>'A/c [to]',"Value"=>"453".$ac_to),
                                array('Name'=>'Amount',"Value"=>$amount),
                                array('Name'=>'New Balance',"Value"=>$this->user_account->get_bal_vm_card($ac_to)),
                                array('Name'=>'Detail',"Value"=>$t_detail)
                                );
                                $dmsg = "Congratulations, Transaction successfully made, and money transferred to Virtual Money Card";
                                $this->send_mail($userid,"admin@cscbanking.com","Fund Transfer",$dmsg,$a);
                                $this->form_validation->unset_field_data();
                            }
                            else
                                $msg = "Error: Sorry, your fund not transferred yet. ";
                        }
                        else
                            $msg = "Sorry, You can not transfer money because of your accont balance is low.";
                    }
                    else if($ac_from_len == 13 && $ac_to_len == 8)
                    {
                        $card_bal = $this->user_account->get_bal_vm_card($ac_from);
                        if($card_bal >= $amount)
                        {
                            $t_detail = 'Transfter made from Virtual Money Card to your A/c';
                            if($this->user_account->transfer_money_from_cardno_to_acno($ac_from,$ac_to,$amount,$t_detail))
                            {
                                $data['s_msg1']="Money transferred.... You will get receipt by email soon.";
                                $a = array(
                                array('Name'=>'Transaction Id',"Value"=>$this->user_account->get_transaction_no($ac_from,$ac_to,$amount,$t_detail)),
                                array('Name'=>'A/c [from]',"Value"=>"453".$ac_from),
                                array('Name'=>'A/c [to]',"Value"=>$ac_to),
                                array('Name'=>'Amount',"Value"=>$amount),
                                array('Name'=>'New Balance',"Value"=>$this->user_account->get_bal_by_ac($ac_to)),
                                array('Name'=>'Detail',"Value"=>$t_detail)
                                );
                                $dmsg = "Congratulations, Transaction successfully made, and money transferred to your A/c";
                                $this->send_mail($userid,"admin@cscbanking.com","Fund Transfer",$dmsg,$a);
                                $this->form_validation->unset_field_data();
                            }
                            else
                                $msg = "Error: Sorry, your fund not transferred yet. ";
                        }
                        else
                            $msg = "Sorry, You can not transfer money because of your accont balance is low.";
                    }
                    else
                        $msg = "System Error: A/c No problem.";
                    
                }
                else
                {
                    $msg = "You can not trasfer money, with same account no.";
                }
               
            }
            $data['msg1'] = $msg;
        }
        else
        {
            $this->form_validation->set_rules('ac_from1', 'Primary Account No.', 'trim|numeric|callback_cheuqing_acno_check');
            $this->form_validation->set_rules('ac_to1', 'Destination A/c No.', 'trim|numeric|required|callback_cheuqing_acno_check');
            $this->form_validation->set_rules('amount1', 'Amount', 'greater_than[0]|numeric|required');
            $msg = "";
            if ($this->form_validation->run() === TRUE)
        	{
        	   $ac_from = $this->input->post('ac_from1');
               $ac_to = $this->input->post('ac_to1');
               $amount = $this->input->post('amount1');
        	   if($ac_from != $ac_to)
                {
                        $ac_bal = $this->user_account->get_bal_by_ac($ac_from);
                        $limit_transfer = $this->user_account->todays_total_transaction($userid);
                        $limit_transfer += $amount;
                        if($ac_bal >= $amount)
                        {
                            if($limit_transfer < 101)
                            {
                                $t_detail = 'Transfter made from A/c to A/c within same bank...';
                                if($this->user_account->transfer_money_from_acno_to_acno($ac_from,$ac_to,$amount,$t_detail))
                                {
                                    $data['s_msg']="Money transferred.... You will get receipt by email soon.";
                                    $a = array(
                                    array('Name'=>'Transaction Id',"Value"=>$this->user_account->get_transaction_no($ac_from,$ac_to,$amount,$t_detail)),
                                    array('Name'=>'A/c [from]',"Value"=>"453".$ac_from),
                                    array('Name'=>'A/c [to]',"Value"=>$ac_to),
                                    array('Name'=>'Amount',"Value"=>$amount),
                                    array('Name'=>'New Balance',"Value"=>$this->user_account->get_bal_by_ac($ac_to)),
                                    array('Name'=>'Detail',"Value"=>$t_detail)
                                    );
                                    $dmsg = "Congratulations, Transaction successfully made, and money transferred among two different account.";
                                    $this->send_mail($userid,"admin@cscbanking.com","Fund Transfer",$dmsg,$a);
                                    $this->form_validation->unset_field_data();
                                }
                                else
                                    $msg = "Error: Sorry, your fund not transferred yet. ";
                            }
                            else
                                $msg = "Sorry, you can not trasfter your fund, You reached your limit.";
                        }
                        else
                            $msg = "Sorry, You can not transfer money because of your accont balance is low.";
                    
                    
                }
                else
                {
                    $msg = "You can not trasfer money, with same account no.";
                }
               
            }
            $data['msg'] = $msg;
        }
        $data['ac_detail'] = $this->user_account->get_all_ac_by_email($userid);
        $ac_no = $this->user_account->get_ac_no_by_email_actype($userid,"cheuqing");
        $data['vm_detail'] = $this->user_account->get_debit_vm_card_detail_by_acno($ac_no);
        $c_ac_no = $this->user_account->get_ac_no_by_email_actype($userid,"credit");
        $data['credit_detail'] = $this->user_account->get_credit_card_detail_by_acno($c_ac_no);
        $data['tag_data'] = "Transfer Money";
        $data['page']='transfer_money';
        $data['userid'] = $userid;
		$this->load->view('template_user_account',$data);
    }
    
    public function account_history()
    {
        $userid=$this->session->userdata('userid');
        $data['ac_detail'] = $this->user_account->get_all_ac_by_email($userid);
        $ac_no = $this->user_account->get_ac_no_by_email_actype($userid,"cheuqing");       
        $data['vm_detail'] = $this->user_account->get_debit_vm_card_detail_by_acno($ac_no);
        $input_ac = $this->input->post('ac_no');
        $ac_type = $this->user_account->check_ac_type($input_ac);
        if($ac_type == "investment")
            $ac_no = $this->user_account->get_ac_no_by_email_actype($userid,"investment");
        $c_ac_no = $this->user_account->get_ac_no_by_email_actype($userid,"credit");
        $data['credit_detail'] = $this->user_account->get_credit_card_detail_by_acno($c_ac_no);                        
        if($ac_type != "none")
        {
                $ac_no = $this->input->post('ac_no');
                $transaction_history = $this->user_account->get_all_transaction_history_by_chequing_ac_no($this->input->post('ac_no'));
                $data['transaction_history'] = $transaction_history;
        }
        
        $data['ac_no'] = $ac_no;
        $data['tag_data'] = "Account Transaction History";
        $data['page']='account_history';
        $data['userid'] = $userid;
		$this->load->view('template_user_account',$data);
    }
    
    public function list_all_cheque()
    {
        $userid=$this->session->userdata('userid');
        $ac_no = $this->user_account->get_ac_no_by_email_actype($userid,"cheuqing");
        $data['cheques_detail'] = $this->user_account->get_all_cheque_by_ac_no($ac_no);
        $data['ac_no'] = $ac_no;
        $data['tag_data'] = "Cheques Detail";
        $data['page']='list_all_cheques';
        $data['userid'] = $userid;
		$this->load->view('template_user_account',$data);
    }
    public function pay_bill()
    {
        $userid=$this->session->userdata('userid');
        $this->load->helper('form');
    	$this->load->library('form_validation');
        
        $this->form_validation->set_rules('ac_from', 'Primary Account No.', 'trim|numeric|callback_mix_acno_check');
        $this->form_validation->set_rules('ac_to', 'Bill Company', 'trim|numeric|callback_company_acno_check');
        $this->form_validation->set_rules('amount', 'Amount', 'greater_than[0]|numeric|required');
        $this->form_validation->set_rules('bill_no', 'Bill NO', 'required');
        $msg = "";
        if ($this->form_validation->run() === TRUE)
       	{
       	    $ac_from = $this->input->post('ac_from');
               $ac_to = $this->input->post('ac_to');
               $amount = $this->input->post('amount');
               $bill_no = $this->input->post('bill_no');
        	   if($ac_from != $ac_to)
                {
                    $ac_from_len = strlen($ac_from);
                    $ac_to_len = strlen($ac_to);
                    if($ac_from_len == 8 && $ac_to_len == 8)
                    {
                            $ac_bal = $this->user_account->get_bal_by_ac($ac_from);
                            if($ac_bal >= $amount)
                            {
                                $t_detail = 'Bill Paid by Account';
                                if($this->user_account->transfer_money_from_acno_to_acno($ac_from,$ac_to,$amount,$t_detail))
                                {
                                    $bill_detail = array(
                                    'ac_no' => $ac_from,
                                    'bill_no' => $bill_no, 
                                    'uemail' => $userid,
                                    'bill_amount' => $amount,
                                    'company_no' => $ac_to,
                                    'status' => "Paid",
                                    'cdate' => date('Y-m-d H:i:s')
                                    );
                                    $this->db->insert('billing_detail',$bill_detail);
                                    $data['s_msg']="Bill Paid Successful....";
                                    $a = array(
                                        array('Name'=>'Transaction Id',"Value"=>$this->user_account->get_transaction_no($ac_from,$ac_to,$amount,$t_detail)),
                                        array('Name'=>'Bill Company',"Value"=>$this->user_account->get_compnay_name_by_ac_no($ac_to)),
                                        array('Name'=>'A/c [From]',"Value"=>$ac_from),
                                        array('Name'=>'Amount',"Value"=>$amount),
                                        array('Name'=>'Bill No',"Value"=>$bill_no)
                                        );
                                        $dmsg = "Congratulations, Transaction successfully made, Your bill Paid.....";
                                        $this->send_mail($userid,"admin@cscbanking.com","Bill Paid By Account",$dmsg,$a);
                                    $this->form_validation->unset_field_data();
                                }
                            }
                            else
                            {
                                $data['msg'] = "You don't have enough in your cheuquing account.";
                            }
                    }
                    else if($ac_from_len == 13 && $ac_to_len == 8)
                    {
                        if($this->user_account->check_card_type($ac_from) == "Credit")
                        {
                            $card_bal = $this->user_account->get_limit_of_card($ac_from);
                            if($card_bal >= $amount)
                            {
                                $t_detail = 'Bill Paid by Credit Card';
                                if($this->user_account->transfer_money_from_credit_to_acno($ac_from,$ac_to,$amount,$t_detail))
                                {
                                    $bill_detail = array(
                                        'ac_no' => $ac_from,
                                        'bill_no' => $bill_no, 
                                        'uemail' => $userid,
                                        'bill_amount' => $amount,
                                        'company_no' => $ac_to,
                                        'status' => "Paid",
                                        'cdate' => date('Y-m-d H:i:s')
                                        );
                                        $this->db->insert('billing_detail',$bill_detail);
                                    $data['s_msg']="Bill Paid Successful....";
                                    $a = array(
                                        array('Name'=>'Transaction Id',"Value"=>$this->user_account->get_transaction_no($ac_from,$ac_to,$amount,$t_detail)),
                                        array('Name'=>'Bill Company',"Value"=>$this->user_account->get_compnay_name_by_ac_no($ac_to)),
                                        array('Name'=>'A/c [From]',"Value"=>"453".$ac_from),
                                        array('Name'=>'Amount',"Value"=>$amount),
                                        array('Name'=>'Bill No',"Value"=>$bill_no)
                                        );
                                        $dmsg = "Congratulations, Transaction successfully made, Your bill Paid.....";
                                        $this->send_mail($userid,"admin@cscbanking.com","Bill Paid By Credit Card",$dmsg,$a);
                                    $this->form_validation->unset_field_data();
                                }
                            }
                            else
                            {
                                $data['msg'] = "You don't have enough Credit in your card";
                            }
                        }
                        else
                        {
                            $card_bal = $this->user_account->get_bal_vm_card($ac_from);
                            if($card_bal >= $amount)
                            {
                                $t_detail = 'Bill Paid by Virtual Card';
                                if($this->user_account->transfer_money_from_cardno_to_acno($ac_from,$ac_to,$amount,$t_detail))
                                {
                                    $bill_detail = array(
                                        'ac_no' => $ac_from,
                                        'bill_no' => $bill_no, 
                                        'uemail' => $userid,
                                        'bill_amount' => $amount,
                                        'company_no' => $ac_to,
                                        'status' => "Paid",
                                        'cdate' => date('Y-m-d H:i:s')
                                        );
                                        $this->db->insert('billing_detail',$bill_detail);
                                    $data['s_msg']="Bill Paid Successful....";
                                    $a = array(
                                        array('Name'=>'Transaction Id',"Value"=>$this->user_account->get_transaction_no($ac_from,$ac_to,$amount,$t_detail)),
                                        array('Name'=>'Bill Company',"Value"=>$this->user_account->get_compnay_name_by_ac_no($ac_to)),
                                        array('Name'=>'A/c [From]',"Value"=>"453".$ac_from),
                                        array('Name'=>'Amount',"Value"=>$amount),
                                        array('Name'=>'Bill No',"Value"=>$bill_no)
                                        );
                                        $dmsg = "Congratulations, Transaction successfully made, Your bill Paid.....";
                                        $this->send_mail($userid,"admin@cscbanking.com","Bill Paid By Virtual Money Card",$dmsg,$a);
                                    $this->form_validation->unset_field_data();
                                }
                            }
                            else
                            {
                                $data['msg'] = "You don't have enough in your Virtual card";
                            }   
                        }
                    }
                    else if($ac_from_len == 13 && $ac_to_len == 13)
                    {
                        $msg = "This Module is not under consturct";
                    }
                    
                }
                else
                {
                    $msg = "You can not trasfer money, with same account no.";
                }
        }
        $userid=$this->session->userdata('userid');
        $data['ac_detail'] = $this->user_account->get_all_ac_by_email($userid);
        $ac_no = $this->user_account->get_ac_no_by_email_actype($userid,"cheuqing");
        $data['vm_detail'] = $this->user_account->get_debit_vm_card_detail_by_acno($ac_no);
        $company_detail = $this->user_account->get_all_bank_ac();
        $data['company_detail'] = $company_detail;
        $c_ac_no = $this->user_account->get_ac_no_by_email_actype($userid,"credit");
        $data['credit_detail'] = $this->user_account->get_credit_card_detail_by_acno($c_ac_no);
        $userid=$this->session->userdata('userid');
        $data['tag_data'] = "PAY BILL";
        $data['page']='pay_bill';
        $data['userid'] = $userid;
		$this->load->view('template_user_account',$data);
    }
    public function all_paid_bill()
    {
        $userid=$this->session->userdata('userid');
        $data['billing_detail'] = $this->user_account->get_all_bill_by_email($userid);
        $data['tag_data'] = "List all Paid Bills";
        $data['page']='all_paid_bill';
        $data['userid'] = $userid;
		$this->load->view('template_user_account',$data);
    }
    public function view_profile()
    {
        $userid=$this->session->userdata('userid');
        $data['ac_data'] = $this->user_account->get_profile_detail_by_email($userid);
        $data['tag_data'] = "Profile Detail";
        $data['page']='view_profile';
        $data['userid'] = $userid;
		$this->load->view('template_user_account',$data);
    }
    public function check_pass($value)
    {
        $userid=$this->session->userdata('userid');
        if(!$this->user_account->valid_password($userid,$value))
        {
            $this->form_validation->set_message('check_pass','Sorry, your old password was wrong. Please try again.');
            return false;
        }
        else
        {
            return true;
        }
    }
    public function check_new_pass($value)
    {
        $userid=$this->session->userdata('userid');
        if($this->user_account->valid_password($userid,$value))
        {
            $this->form_validation->set_message('check_new_pass','Sorry, you can not set same password which you have currently.');
            return false;
        }
        else
        {
            return true;
        }
    }
    public function change_password()
    {
        $userid=$this->session->userdata('userid');
        $data['userid'] = $userid;
        $data['tag_data'] = "Change New Password";
        $s_msg = "";
        $msg="";
        $this->load->helper('form');
       	$this->load->library('form_validation');
                $this->form_validation->set_rules('old_pwd', 'Password', 'trim|strip_tags|xss_clean|min_length[6]|max_lenth[16]|required|callback_check_pass');
                $this->form_validation->set_rules('pswd1', 'Password', 'trim|strip_tags|xss_clean|min_length[6]|max_lenth[16]|required|callback_check_new_pass');
                $this->form_validation->set_rules('pswd2', 'Confirm Password', 'trim|strip_tags|xss_clean|min_length[6]|max_lenth[16]|required');
                if ($this->form_validation->run() === TRUE)
            	{
            	   $pass1 = $this->input->post('pswd1');
                   $pass2 = $this->input->post('pswd2');
                   if($pass1 == $pass2)
                   {
                        if($this->user_account->update_pass_by_email($userid,md5($pass1)))
                        {
                            $s_msg = "Thank you, your new password successfully Updated.";
                                $a="";
                            $dmsg = "Thank you, your new password successfully changed. Your new password is : ".$pass1;
                            $this->send_mail($userid,"admin@cscbanking.com","Password Updated",$dmsg,$a);
                        }
                        else
                        {
                            $msg = "Sorry, system error to set your new password";
                        }
                   }
                   else
                   {
                        $msg = "Sorry, your password and confirm password is not same.";
                   }
                }
        $data['msg'] = $msg;
        $data['s_msg'] = $s_msg;
        $data['page']="change_password";
        $this->load->view('template_user_account',$data);
    }
    public function login_history()
    {
        $userid=$this->session->userdata('userid');
        $data['login_detail'] = $this->user_account->get_all_login_history($userid,20);
        $data['tag_data'] = "List all Login History";
        $data['page']='login_history';
        $data['userid'] = $userid;
		$this->load->view('template_user_account',$data);
    }
    public function user_logout()
    {
        $this->session->sess_destroy();
        $this->session->set_userdata(array('userid'=>''));
        $this->no_cache();
        echo "Successful Logout";
        redirect(base_url(),'refresh');
    }
    protected function no_cache()
    {
        header('Cache-Control: no-store, no-cache, must-revalidate');
        header('Cache-Control: post-check=0, pre-check=0',false);
        header('Pragma: no-cache'); 
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