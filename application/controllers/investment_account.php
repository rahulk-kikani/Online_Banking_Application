<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Investment_account extends CI_Controller {
    
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
       
    public function inve_account()
    {
        $userid=$this->session->userdata('userid');
        $msg = "";
        $data['msg'] =$msg;
        $investment_ac_detail = $this->user_account->get_ac_detail_by_email_type($userid,"investment");
        $data['investment_ac_detail'] = $investment_ac_detail;
        $data['tag_data'] = "Investment Account";
        $data['page']='inve_account';
        $data['userid'] = $userid;
		$this->load->view('template_user_account',$data);
    }
    public function active_investment_account()
    {
        $userid=$this->session->userdata('userid');
        $investment_ac = $this->user_account->get_ac_no_by_email_actype($userid,"investment");
        if($investment_ac == 0)
        {
            $max_ac_no = $this->user_account->get_max_ac_no();
            $new_ac_no = $max_ac_no+1;
            $ac_detail = array(
                        "ac_no" => $new_ac_no,
                        "username" => $userid,
                        "ac_type" => "investment",
                        "ac_bal" => 0.0,
                        "ac_status" => "active",
                        "ac_cdate" => date('Y-m-d H:i:s')
                        );
            $this->db->insert('ac_detail',$ac_detail);
            $a = array(
                        array('Name'=>'Account No.',"Value"=>$new_ac_no),
                        array('Name'=>'Account Type',"Value"=>"Investment"),
                        array('Name'=>'Amount',"Value"=>0.0)
                        );
                        $dmsg = "Congratulation , Your Investment account is created successfully.";
                        $this->send_mail($userid,"admin@cscbanking.com","Investment Account",$dmsg,$a);
            redirect(base_url()."user/investment-account.html");
        }
    }
    public function stock_center()
    {
        $userid=$this->session->userdata('userid');
        $msg = "";
        $data['msg'] =$msg;
        $data['tag_data'] = "Stock Center";
        $data['page']='stock_center';
        $stock_detail = $this->user_account->get_all_stock();
        $data['stock_detail'] = $stock_detail;
        $data['userid'] = $userid;
		$this->load->view('template_user_account',$data);
    }
    public function stock_details()
    {
        $userid=$this->session->userdata('userid');
        $msg = "";
        $data['msg'] =$msg;
        $data['tag_data'] = "My Stock Details";
        $investment_ac = $this->user_account->get_ac_no_by_email_actype($userid,"investment");
        $data['sold_stock'] = $this->user_account->get_sold_stock_by_ac($investment_ac);
        $data['stock_analysis'] = $this->user_account->get_diff_stock_code_by_ac($investment_ac);
        $data['bought_stock'] = $this->user_account->get_bought_stock_by_ac($investment_ac);
        $data['page']='stock_details';
        $data['ac_no'] = $investment_ac;
        $data['userid'] = $userid;
		$this->load->view('template_user_account',$data);
    }
    public function check_scode($value)
    {
        if(!$this->user_account->check_stock_code($value))
            {
                $this->form_validation->set_message('check_scode','Sorry, This type of stock not available.');
                return false;
            }
            else
            {
                return true;
            }
    }
    public function stock_exchange()
    {
        $userid=$this->session->userdata('userid');
        $msg = "";
        $data['tag_data'] = "Stock Exchange";
        $data['page']='stock_exchange';
        $investment_ac = $this->user_account->get_ac_no_by_email_actype($userid,"investment");
        $data['ac_no'] = $investment_ac;
        if(isset($_GET['action']) && isset($_GET['stockid']))
        {
            $action = $_GET['action'];
            $data['action'] = $action;
            $data['stockid'] = $_GET['stockid'];
            
            $this->load->helper('form');
        	$this->load->library('form_validation');
            
            $this->form_validation->set_rules('scode', 'Stock Code', 'required|callback_check_scode');
            $this->form_validation->set_rules('volume', 'Stock Volume', 'required|callback_check_volume|greater_than[0]|numeric');
            
            if ($this->form_validation->run() === TRUE)
        	{
        	   
        	   $scode = $this->input->post('scode');
               $svolume = $this->input->post('volume');
               if($action == "buy")
               {
                    $total_volume = $this->user_account->get_stock_volume_by_code($scode);
                    if($total_volume >= $svolume)
                    {
                        $sb_price = $this->user_account->get_buying_stock_price_by_code($scode);
                        $t_amount = $svolume * $sb_price;
                        $bank_ac_no = $this->user_account->get_bank_ac_no("bank_account");
                        $ac_to = $bank_ac_no;
                        if($investment_ac != 0 && $bank_ac_no !=0)
                        {
                            $ac_bal = $this->user_account->get_bal_by_ac($investment_ac);
                            if($ac_bal >= $t_amount)
                            {
                                $t_detail = 'Transfter made from Investment to Bank A/c [Buying Shares]';
                                if($this->user_account->transfer_money_from_acno_to_acno($investment_ac,$ac_to,$t_amount,$t_detail))
                                {
                                    $data['s_msg1']="Money transfered....";
                                    $stock_order = array(
                                    'ac_no' =>$investment_ac,
                                    'code' =>$scode,
                                    'price' =>$sb_price,
                                    'amount' =>$svolume,
                                    'type' => "Buy",
                                    'status' => "NOT-SOLD",
                                    'cdate' =>date('Y-m-d H:i:s'),
                                    );
                                    $this->db->insert('stock_order',$stock_order);
                                    $final_volume = $total_volume - $svolume;
                                    $this->user_account->update_stock_volume($scode,$final_volume);
                                    $data['s_msg']="Congratulations, Your stock order placed successfully....";
                                    
                                    $a = array(
                                    array('Name'=>'Account No.',"Value"=>$investment_ac),
                                    array('Name'=>'Transaction Id',"Value"=>$this->user_account->get_transaction_no($investment_ac,$ac_to,$t_amount,$t_detail)),
                                    array('Name'=>'Stock Code',"Value"=>$scode),
                                    array('Name'=>'Buying Price/Unit',"Value"=>$sb_price),
                                    array('Name'=>'Amount',"Value"=>$svolume),
                                    array('Name'=>'Total Money',"Value"=>($sb_price*$svolume)),
                                    array('Name'=>'A/c Balance',"Value"=>$this->user_account->get_bal_by_ac($investment_ac))
                                    );
                                    $dmsg = "Congratulation , Your stock order placed successfully....";
                                    $this->send_mail($userid,"admin@cscbanking.com","Stock Buying Order",$dmsg,$a);
                                    
                                    $this->form_validation->unset_field_data();
                                }
                            }
                            else
                                $msg = "Sorry, You can not transfer money because of your accont balance is low.";   
                        }
                        else
                        {
                            $msg = "Sorry, Invesment account no. OR Bank A/C is not valid.";
                        }               
                    }
                    else
                    {
                        $msg = "Sorry, your volume exceed from currently you have volume of perticular stock.";
                    }
               }
               else if($action == "sell")
               {
                    $total_volume = $this->user_account->get_stock_volume_by_code_ac($scode,$investment_ac);
                    if($total_volume >= $svolume)
                    {
                        $sb_price = $this->user_account->get_selling_stock_price_by_code($scode);
                        $t_amount = $svolume * $sb_price;
                        $bank_ac_no = $this->user_account->get_bank_ac_no("bank_account");
                        $ac_to = $investment_ac;
                        $ac_from = $bank_ac_no;
                        if($investment_ac != 0 && $bank_ac_no !=0)
                        {
                            $ac_bal = $this->user_account->get_bal_by_ac($ac_from);
                            if($ac_bal >= $t_amount)
                            {
                                $t_detail = 'Transfter made from Bank A/c to Investment [Selling Shares]';
                                if($this->user_account->transfer_money_from_acno_to_acno($ac_from,$ac_to,$t_amount,$t_detail))
                                {
                                    $data['s_msg1']="Money transfered....";
                                    $stock_order = array(
                                    'ac_no' =>$investment_ac,
                                    'code' =>$scode,
                                    'price' =>$sb_price,
                                    'amount' =>$svolume,
                                    'type' => "Sell",
                                    'status' => "SOLD",
                                    'cdate' =>date('Y-m-d H:i:s'),
                                    );
                                    $this->db->insert('stock_order',$stock_order);
                                    $total_volume = $this->user_account->get_stock_volume_by_code($scode);
                                    $final_volume = $total_volume + $svolume;
                                    $this->user_account->update_stock_volume($scode,$final_volume);
                                    $data['s_msg']="Congratulations, Your stock order placed successfully....";
                                    
                                    $a = array(
                                    array('Name'=>'Account No.',"Value"=>$investment_ac),
                                    array('Name'=>'Transaction Id',"Value"=>$this->user_account->get_transaction_no($ac_from,$ac_to,$t_amount,$t_detail)),
                                    array('Name'=>'Stock Code',"Value"=>$scode),
                                    array('Name'=>'Buying Price/Unit',"Value"=>$sb_price),
                                    array('Name'=>'Amount',"Value"=>$svolume),
                                    array('Name'=>'Total Money',"Value"=>($sb_price*$svolume)),
                                    array('Name'=>'A/c Balance',"Value"=>$this->user_account->get_bal_by_ac($ac_to))
                                    );
                                    $dmsg = "Congratulation , Your stock order placed successfully....";
                                    $this->send_mail($userid,"admin@cscbanking.com","Stock Selling Order",$dmsg,$a);
                                    
                                    $this->form_validation->unset_field_data();
                                }
                            }
                            else
                                $msg = "Sorry, You can not transfer money because of your accont balance is low.";   
                        }
                        else
                        {
                            $msg = "Sorry, Invesment account no. OR Bank A/C is not valid.";
                        }               
                    }
                    else
                    {
                        $msg = "Sorry, your volume exceed from currently you have volume of perticular stock.";
                    }
               }
        	}
        }
        $data['msg'] =$msg;
        $data['userid'] = $userid;
		$this->load->view('template_user_account',$data);
    }
    public function check_inve_amount($value)
    {
        if($value < 100)
            {
                $this->form_validation->set_message('check_inve_amount','The Amount field must contain a number at least $100 or more then this.');
                return false;
            }
            else
            {
                return true;
            }
    }
    public function inves_fixed_money()
    {
        $userid=$this->session->userdata('userid');
        $msg = "";
        $data['tag_data'] = "Invest Money in Fixed Deposit Plan";
        $data['page']='inves_fixed_money';
        $investment_ac = $this->user_account->get_ac_no_by_email_actype($userid,"investment");
        $data['ac_no'] = $investment_ac;
        $bank_ac_no = $this->user_account->get_bank_ac_no("bank_account");
        $ac_to = $bank_ac_no;
        if($investment_ac != 0 && $bank_ac_no !=0)
        {
            $this->load->helper('form');
        	$this->load->library('form_validation');
            
            $this->form_validation->set_rules('volume', 'Amount', 'required|less_than[2000]|callback_check_inve_amount|numeric');
            
            if ($this->form_validation->run() === TRUE)
        	{
               $svolume = $this->input->post('volume');
 
                            $ac_bal = $this->user_account->get_bal_by_ac($investment_ac);
                            if($ac_bal >= $svolume)
                            {
                                $ex_amount = $svolume * (200/100);
                                $t_detail = 'Transfter made from Investment to Bank A/c [Fixed Deposit]';
                                if($this->user_account->transfer_money_from_acno_to_acno($investment_ac,$ac_to,$svolume,$t_detail))
                                {
                                    $data['s_msg']="Congratulations, Your Fixed Deposit investment plan is now actived.....";
                                    
                                    $stock_order = array(
                                    'ac_no' =>$investment_ac,
                                    'issue_date' =>date("Y/m/d"),
                                    'last_date' =>date("Y/m/d",strtotime('+2 year',time())),
                                    'amount' =>$svolume,
                                    'rate' => "200",
                                    'status' => "running"
                                    );
                                    $this->db->insert('inve_fixed_deposit',$stock_order);
                                    
                                    $a = array(
                                    array('Name'=>'Account No.',"Value"=>$investment_ac),
                                    array('Name'=>'Transaction Id',"Value"=>$this->user_account->get_transaction_no($investment_ac,$ac_to,$svolume,$t_detail)),
                                    array('Name'=>'Investement Amount',"Value"=>$svolume),
                                    array('Name'=>'Expected Amount',"Value"=>$ex_amount),
                                    array('Name'=>'Issue Date',"Value"=>date("d m,Y")),
                                    array('Name'=>'End Date',"Value"=>date("d m,Y",strtotime('+2 year',time()))),
                                    array('Name'=>'Duration',"Value"=>"2 Years"),
                                    array('Name'=>'Rate',"Value"=>"200% [For 2 Years]")
                                    );
                                    $dmsg = "Congratulations, Your Fixed Deposit investment plan is now actived.....";
                                    $this->send_mail($userid,"admin@cscbanking.com","Investment in Fixed Deposit",$dmsg,$a);
                                    
                                    $this->form_validation->unset_field_data();
                                }
                            }
                            else
                                $msg = "Sorry, You can not transfer money because of your accont balance is low.";                
                    }
            if($this->user_account->check_fixed_plan_exist($investment_ac,"running"))
            {
                $all_fixed_detail = $this->user_account->get_all_fixed_plan($investment_ac,"running");
                $data['all_fixed_detail'] = $all_fixed_detail;
            }
        }
        else
        {
            $msg = "Sorry, Invesment account no. OR Bank A/C is not valid.";
        }  
        $data['msg'] =$msg;
        $data['userid'] = $userid;
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