<?php
class Captcha_model extends CI_Model {
	function __construct() {
		parent::__construct();
	}
    
    function create_image()
    {
        $abc=array("5","7","a","2","b","4","c","d","0","e","f","g","3","h","i","j","k","6","l","m","n","8","o","p","q","r","s","t","u","1","v","w","9","x","y","z");
        $word='';
        $n=0;
        while($n<6)
        {
            $word.=$abc[mt_rand(0,35)];
            $n++;
        }
        $vals = array(
            'word'	 => $word,
            'img_path'	 => './captcha/',
            'img_url'	 => base_url().'captcha/',
            'font_path'	 => './fonts/impact.ttf',
            'img_width'	 => '200',
            'img_height' => '50',
            'expiration' => '3600',
            'time'       => time()
            );
        $cval=array(
            'time'      => $vals['time'],
            'ip_add'    => $_SERVER['REMOTE_ADDR'],
            'word'      => $vals['word']
        );
        $this->db->insert('captcha',$cval);
                
        $cap = create_captcha($vals);
        return $data['image']=$cap['image'];
    }
    
 }
 ?>