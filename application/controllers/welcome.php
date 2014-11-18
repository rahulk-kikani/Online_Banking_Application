<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {
    
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
       }

	public function index()
	{                      
		$data['page']="welcome";
        $this->load->view('welcome_template',$data);
	}
    public function bank_service()
	{
		$data['page']="service";
        $this->load->view('welcome_template',$data);
	}
    public function image_credit()
	{
		$data['page']="image_credit";
        $this->load->view('welcome_template',$data);
	}
    public function checkuserid($value)
    {
        if($this->user_account->check_active_userid($value) != 1)
        {
            $this->form_validation->set_message('checkuserid','Entered username is not valid.');
            return false;
        }
        else
            return true;
    }
    public function forgot_password()
    {
        $this->load->helper('form');
    	$this->load->library('form_validation');
        
        $this->form_validation->set_rules('usr', 'Username', 'trim|required|valid_email|callback_checkuserid');
        $this->form_validation->set_rules('pswd', 'Answer', 'trim|required');
        $msg = "";
        $s_msg = "";
        if ($this->form_validation->run() === TRUE)
    	{
            $qno = $this->input->post('secure_q');
            $ans = $this->input->post('pswd');
            $email = $this->input->post('usr');
            if($this->user_account->check_security_ans($qno,$ans,$email)==1)
            {
                if($this->user_account->add_reset_code($email))
                {
                    $a="";
                $dmsg = "You just requested for reset password. This is link for reset your passowrd <a href='".base_url()."set-new-pswd.html?token=".$this->user_account->get_token($email)."'>Reset Password</a>. <br/>Please, Use this link within 2 hour, after it will expire.";
                $this->send_mail($email,"admin@cscbanking.com","Password Reset Token",$dmsg,$a);
                
                    $s_msg = "We sent reset link to your email, please check it and reset your password within 2hour.";
                }
                else
                    $msg = "Error to send reset link to you email.";
            }
            else
            {
                $msg = "Sorry, We can't reset your password.";
            }
    	}
        $data['msg'] = $msg;
        $data['s_msg'] = $s_msg;
        $data['page']="forgot_password";
        $this->load->view('welcome_template',$data);
    }
    public function set_new_pass()
    {
        $s_msg = "";
        $msg="";
        $this->load->helper('form');
       	$this->load->library('form_validation');
        if(isset($_GET['token']))
        {
            $token = $_GET['token'];
            if($this->user_account->validate_token($token))
            {
                $this->form_validation->set_rules('pswd1', 'Password', 'trim|strip_tags|xss_clean|min_length[6]|max_lenth[16]|required|callback_check_new_pass');
                $this->form_validation->set_rules('pswd2', 'Confirm Password', 'trim|strip_tags|xss_clean|min_length[6]|max_lenth[16]|required');
                if ($this->form_validation->run() === TRUE)
            	{
            	   $pass1 = $this->input->post('pswd1');
                   $pass2 = $this->input->post('pswd2');
                   if($pass1 == $pass2)
                   {
                    $email = $this->user_account->get_email_token($token);
                        if($this->user_account->update_pass_by_token($token,md5($pass1)))
                        {
                            $s_msg = "Thank you, your new password successfully changed.";
                                $a="";
                            $dmsg = "Thank you, your new password successfully changed. Your new password is : ".$pass1;
                            $this->send_mail($email,"admin@cscbanking.com","Password Changed",$dmsg,$a);
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
            }
            else
                $msg = "Sorry, your token is expired.";
        }
        else
            $msg = "Sorry, Your token is not valid.";
        $data['msg'] = $msg;
        $data['s_msg'] = $s_msg;
        $data['page']="f_change_password";
        $this->load->view('welcome_template',$data);
    }
    public function user_login()
    {
        $this->load->helper('form');
    	$this->load->library('form_validation');
        
        $this->form_validation->set_rules('usr', 'Username', 'trim|strip_tags|xss_clean|required|valid_email');
        $this->form_validation->set_rules('pswd', 'Password', 'trim|strip_tags|xss_clean|required');
        $this->form_validation->set_rules('captcha', 'captcha', 'required|callback_captcha_check|match_captcha[captcha.word]');
        $msg = "";        
        if ($this->form_validation->run() === TRUE)
    	{
    	   $email = $this->input->post('usr');
           $pass = $this->input->post('pswd');
           $result = $this->user_account->check_login($email,md5($pass));
           if($result == 1)
           {
                $this->user_account->add_login_history($email,"Login Successful");
                session_start();
                $x =$this->session->userdata('userid');
                if($x == null || $x == '')
                {
                    $this->session->set_userdata(array('userid'=>$email));
                }
                else
                {
                    $msg = "User Session is already logged in.";
                    $url = base_url()."user/logout.html";
                    redirect($url); 
                }
                $login_status = $this->user_account->check_login_status($email);
                echo $login_status;
                $this->user_account->reset_login_flag($email);
                if($login_status == 'half-active')
                {
                    $url = base_url()."user/set-security-questions.html";
                    redirect($url);
                }
                else if($login_status == 'partial-active')
                {
                    echo "Partial Active";
                }
                else if($login_status == 'active')
                {
                    $url = base_url()."user/dashboard.html";
                    redirect($url);    
                }
           }
           else
           {
                if($this->user_account->check_login_status($email) == "blocked")
                {
                    $msg = "Sorry, your account is locked, because of multiple wrong attemps.";
                }
                else if($this->user_account->check_login_status($email) == "inactive")
                {
                    $this->user_account->add_login_history($email,"Login Failed");
                    $msg = "Sorry, your account is not activated yet by bank officer.";
                }
                else
                {
                    $this->user_account->add_login_history($email,"Login Failed");
                    $msg = "Username and password combination is wrong.";
                }
                $this->user_account->update_login_flag($email);
           }
    	}
        $data['e_msg'] = $msg;
        $data['image']=$this->captcha_model->create_image();
        $data['page']="user_login";
        $this->load->view('welcome_template',$data);
    }
    public function captcha_check($value)
    {
        if($value=='')
        {
            $this->form_validation->set_message('captcha_check','Please enter the text from image.');
            return false;
        }
        else
        {
            return true;
        }
    }
    public function new_registration()
    {
        $this->load->helper('form');
    	$this->load->library('form_validation');
        
        $this->form_validation->set_rules('usr', 'Username', 'trim|strip_tags|xss_clean|required|valid_email');
        //$this->form_validation->set_rules('pswd', 'Password', 'trim|strip_tags|xss_clean|required|min_length[6]|max_length[16]');
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
                          if(move_uploaded_file($_FILES["doc_file"]["tmp_name"],"upload/" . $file_name))
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
                                "status" => "inactive",
                                "cdate" => date('Y-m-d H:i:s')
                                );
                               if(!$this->user_account->check_userid($this->input->post("usr")))
                               {
                                    if($this->db->insert("user_profile",$user_array))
                                    {
                                        $msg = "Successful Registration...You will get confirmation mail....";   
                                        $this->form_validation->unset_field_data();
                                                	   $a = array(
                                       array('Name'=>'Username',"Value"=>$this->input->post("usr"))
                                       );
                                       $dmsg = "Congratulation ".$this->input->post("fname").", Your new account request has been sent to CSC bank officer. You will get new account confirmation soon. Password will send with confirmation email.";
                                        $this->send_mail($this->input->post("usr"),"admin@cscbanking.com","New Account Request",$dmsg,$a);
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
        
        $data['page']="new_registration";
        $this->load->view('welcome_template',$data);
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