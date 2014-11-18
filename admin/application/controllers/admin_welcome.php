<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin_welcome extends CI_Controller {
    
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
            $this->load->model('admin_account');
            $this->load->library('session');
       }
	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -  
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in 
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */
	public function index()
	{
		$data['page']="admin_dashboard";
        $this->load->view('welcome_template',$data);
	}
    public function admin_login()
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
           $result = $this->admin_account->check_admin_login($email,md5($pass));
           if($result == 1)
           {
                $this->admin_account->add_login_history($email,"Login Successful");
                session_start();
                $x =$this->session->userdata('adminid');
                if($x == null || $x == '')
                {
                    $this->session->set_userdata(array('adminid'=>$email));
                    redirect(base_url()."dashboard.html");
                }
                else
                {
                    $msg = "User Session is already logged in.";
                    $url = base_url()."logout.html";
                    redirect($url); 
                }   
           }
           else
           {
            $this->admin_account->add_login_history($email,"Login Failed");
                $msg = "Username and password combination is wrong.";
           }
    	}
        $data['e_msg'] = $msg;
        $data['image']=$this->captcha_model->create_image();
        $data['page']="admin_login";
        $this->load->view('welcome_login',$data);
    }
    public function admin_logout()
    {
        $this->session->sess_destroy();
        $this->session->set_userdata(array('adminid'=>''));
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
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */