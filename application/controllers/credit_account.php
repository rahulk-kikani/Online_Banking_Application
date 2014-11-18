<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Credit_account extends CI_Controller {
    
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
       
    public function new_application()
    {
        $userid=$this->session->userdata('userid');
        
        $this->load->helper('form');
    	$this->load->library('form_validation');
        
        $this->form_validation->set_rules('card_type', 'Card Type', 'greater_than[0]|numeric|callback_check_credit_type');
        $this->form_validation->set_rules('annual_income', 'Annual Income', 'trim|numeric|greater_than[100]|required');
        $this->form_validation->set_rules('annual_expe', 'Annual Expenditures', 'trim|numeric|greater_than[100]|required');
        $this->form_validation->set_rules('income_tax', 'Income Tax', 'trim|numeric|greater_than[0]|required');
        
        $msg="";
        $card_req_detail = $this->user_account->get_credit_req_by_email($userid);
        if(count($card_req_detail) == 1)
        {
            $msg = "Credit card request Found, You can't send another request.";
            $data['card_req_detail'] = $card_req_detail;
        }
        else
        {
            if ($this->form_validation->run() === TRUE)
        	{
                $card_type = $this->input->post('card_type');
                $a_income = $this->input->post('annual_income');
                $a_expe = $this->input->post('annual_expe');
                $income_tax = $this->input->post('income_tax');
                $card_deatil = array(
                'uemail' => $userid,
                'type' => $card_type,
                'annual_income' => $a_income,
                'annual_expe' => $a_expe,
                'income_tax' => $income_tax,
                'status' => "Pending",
                'cdate' => date('Y-m-d H:i:s')
                );
                if($this->db->insert('manage_credit_card_request',$card_deatil))
                {
                    $card_req_detail = $this->user_account->get_credit_req_by_email($userid);
                    $data['card_req_detail'] = $card_req_detail;
                    $msg = "Your credit card request has been submitted.";
                    $card_detail = $this->user_account->get_credit_card_type_detail_by_cid($card_type);
                    $a = array(
                                        array('Name'=>'Credit Card Type',"Value"=>$card_detail[0]->name),
                                        array('Name'=>'Annual Income',"Value"=>$a_income),
                                        array('Name'=>'Annual Expenditures',"Value"=>$a_expe),
                                        array('Name'=>'Income Tax',"Value"=>$income_tax)
                                        );
                                        $dmsg = "Your credit card request has been submitted successful..Now it's in under processing.";
                                        $this->send_mail($userid,"admin@cscbanking.com","Credit Card Request",$dmsg,$a);
                }
        	}
        }
        $data['msg'] =$msg;
        $data['tag_data'] = "Credit Card Application";
        $data['page']='new_credit_application';
        $data['userid'] = $userid;
		$this->load->view('template_user_account',$data);
    }
    public function check_credit_type($value)
    {
        if(!$this->user_account->check_credit_type($value))
        {
            $this->form_validation->set_message('check_credit_type','Selected type of Credit Card Not Available..');
            return false;
        }
        else
        {
            return true;
        }
    }
    
    public function make_credit_payment()
    {
        $userid=$this->session->userdata('userid');
        $this->load->helper('form');
    	$this->load->library('form_validation');
        $msg="";
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
                    if($ac_from_len == 8 && $ac_to_len == 13)
                    {
                        $ac_bal = $this->user_account->get_bal_by_ac($ac_from);
                        if($ac_bal >= $amount)
                        {
                            $t_detail = 'Transfter made from Cheuquing account to Credit Card';
                            if($this->user_account->transfer_money_from_acno_to_cardno($ac_from,$ac_to,$amount,$t_detail))
                            {
                                $data['s_msg1']="Money transfered....";
                                $a = array(
                                        array('Name'=>'Transaction Id',"Value"=>$this->user_account->get_transaction_no($ac_from,$ac_to,$amount,$t_detail)),
                                        array('Name'=>'A/c [From]',"Value"=>$ac_from),
                                        array('Name'=>'A/c [To]',"Value"=>"453".$ac_to),
                                        array('Name'=>'Amount',"Value"=>$amount),
                                        array('Name'=>'Credit Limit',"Value"=>$this->user_account->get_limit_of_card($ac_to))
                                        );
                                        $dmsg = "Congratulations, Transaction successfully made.....";
                                        $this->send_mail($userid,"admin@cscbanking.com","Credit Card Payment",$dmsg,$a);
                                $this->form_validation->unset_field_data();
                            }
                        }
                        else
                            $msg = "Sorry, You can not make transaction, because of your accont balance is low.";
                    }
                    else if($ac_from_len == 13 && $ac_to_len == 13)
                    {
                        $ac_bal = $this->user_account->get_bal_vm_card($ac_from);
                        if($ac_bal >= $amount)
                        {
                            $t_detail = 'Virtual Card --> Credit Card';
                            if($this->user_account->transfer_money_from_cardno_to_cardno($ac_from,$ac_to,$amount,$t_detail))
                            {
                                $data['s_msg1']="Money transfered....";
                                $a = array(
                                        array('Name'=>'Transaction Id',"Value"=>$this->user_account->get_transaction_no($ac_from,$ac_to,$amount,$t_detail)),
                                        array('Name'=>'A/c [From]',"Value"=>"453".$ac_from),
                                        array('Name'=>'A/c [To]',"Value"=>"453".$ac_to),
                                        array('Name'=>'Amount',"Value"=>$amount),
                                        array('Name'=>'Credit Limit',"Value"=>$this->user_account->get_limit_of_card($ac_to))
                                        );
                                        $dmsg = "Congratulations, Transaction successfully made.....";
                                        $this->send_mail($userid,"admin@cscbanking.com","Credit Card Payment",$dmsg,$a);
                                $this->form_validation->unset_field_data();
                            }
                        }
                        else
                            $msg = "Sorry, You can not make transaction, because of your accont balance is low.";
                    }
                }
                else
                {
                    $msg = "You can not trasfer money, with same account no.";
                }
               
            }
            $data['msg1'] = $msg;
         $data['ac_detail'] = $this->user_account->get_all_ac_by_email($userid);
        $ac_no = $this->user_account->get_ac_no_by_email_actype($userid,"cheuqing");
        $data['vm_detail'] = $this->user_account->get_debit_vm_card_detail_by_acno($ac_no);
        $c_ac_no = $this->user_account->get_ac_no_by_email_actype($userid,"credit");
        $data['credit_detail'] = $this->user_account->get_credit_card_detail_by_acno($c_ac_no);
        $data['tag_data'] = "Make Payment - Credit Card";
        $data['page']='make_credit_payment';
        $data['userid'] = $userid;
		$this->load->view('template_user_account',$data);
    }
    
    public function transaction_detail()
    {
        $userid=$this->session->userdata('userid');
        $data['tag_data'] = "Credit Card Transaction Detail";
        $c_ac_no = $this->user_account->get_ac_no_by_email_actype($userid,"credit");
        $card_no = $this->user_account->get_vm_card_no_by_acno_actype($c_ac_no,'Credit');
        $transaction_history = $this->user_account->get_all_transaction_history_by_chequing_ac_no($card_no);
        $data['credit_detail'] = $this->user_account->get_credit_card_detail_by_acno($c_ac_no);
        $data['ac_no'] = $card_no;
        $data['transaction_history'] = $transaction_history;
        $data['page']='credit_transaction_detail';
        $data['userid'] = $userid;
		$this->load->view('template_user_account',$data);
    }
    
    public function e_statement()
    {
        $userid=$this->session->userdata('userid');
        $c_ac_no = $this->user_account->get_ac_no_by_email_actype($userid,"credit");
        $card_no = $this->user_account->get_vm_card_no_by_acno_actype($c_ac_no,'Credit');
        $data['tag_data'] = "Credit Card e-Statement";
        $credit_detail = $this->user_account->get_credit_card_detail_by_cardno($card_no);
        $data['credit_detail'] = $credit_detail;
        $statement_history = $this->user_account->get_all_estatement($card_no);
        $data['statement_history'] = $statement_history;
        $data['page']="calc_credit_inr";
        $data['ac_no'] = $card_no;
        $data['page']='credit_statement_list';
        $data['userid'] = $userid;
		$this->load->view('template_user_account',$data);
    }
    function view_estatement()
    {
        $userid=$this->session->userdata('userid');
        $data['userid'] = $userid;
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
            if($this->user_account->check_estatement($card_no,$s_date,$e_date))
            {
                $s_date1 = date("Y/m/d",$s_date);
                $e_date1 = date("Y/m/d",$e_date);
                $d = $this->user_account->get_all_transaction_by_ac_no($card_no,$s_date1,$e_date1);
                $data['transaction_history'] = $d;
                $estatement_detail = $this->user_account->get_estatement($card_no,$s_date,$e_date);
                $data['estatement_detail'] = $estatement_detail;
                $pre_estatement_detail = $this->user_account->get_previous_estatement($card_no,$s_date);
                $data['pre_estatement_detail'] = $pre_estatement_detail;
                $credit_detail = $this->user_account->get_credit_card_detail_by_cardno($card_no);
                $data['credit_detail'] = $credit_detail;
            }
        }
        $data['tag_data'] = $msg;
        $data['page']="view_statement";
        $this->load->view('template_user_account',$data);
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
            if(isset($detail) && count($detail)>0)
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