<?php
class User_account extends CI_Model {
	function __construct() {
		parent::__construct();
	}
    function get_bank_ac_no()
    {
        $this->db->select('ac_no');
        $a=array('ac_type'=>'bank_account');
        $result=$this->db->get_where('ac_detail',$a)->result();
        $ac_no = $result[0]->ac_no;
        if(!isset($ac_no))
            $ac_no = 0;
        return $ac_no;
    }
    function check_login($name,$pass)
    {
        $name = trim($name);
           $pass = trim($pass);
        $result = $this->db->query("SELECT * FROM (`user_login`) WHERE ( `status` = 'active' OR `status` = 'half-active' ) AND `uemail` = '".$name."' AND `pswd` = '".$pass."'");
        return $result->num_rows();
    }
    function update_login_flag($name)
    {
        $this->db->select('counter');
        $name = trim($name);
        $a=array('uemail'=>$name);
        $result=$this->db->get_where('user_login',$a)->result();
        if(count($result)==1)
        {
            $flag = $result[0]->counter;
            if($flag < 3 )
                $flag = $flag +1;
            $this->db->where('uemail',$name);
            $b = array('counter'=>$flag);
            $this->db->update('user_login',$b);
            if($flag == 3)
            {
                $this->update_login_status_by_email($name,'blocked');
                $this->add_login_history($name,"Login Blocked");
                $a="";
                $dmsg = "Sorry Your login account is locked, because of 3-times countinously wrong attemps. Use forgot password link and change password.";
                $this->send_mail($name,"admin@cscbanking.com","User Login Locked",$dmsg,$a);
            }
        }
        else
            return "none";
    }
    function todays_total_transaction($email)
    {
        $ac_nos = "";
        $ac_no = $this->user_account->get_ac_no_by_email_actype($email,"cheuqing");
        $ac_from = $ac_no;
        if($ac_no != 0)
        {
            $ac_nos = $ac_nos . $ac_no .",";
            $ac_no = $this->user_account->get_vm_card_no_by_acno_actype($ac_no,"Debit");
            if($ac_no != 0)
            {
                $ac_nos = $ac_nos . $ac_no .","; 
            }
        }
        $ac_no = $this->user_account->get_ac_no_by_email_actype($email,"credit");
        if($ac_no != 0)
        {
            $ac_no = $this->user_account->get_vm_card_no_by_acno_actype($ac_no,"Credit");
            if($ac_no != 0)
            {
                $ac_nos = $ac_nos . $ac_no .","; 
            }
        }
        $ac_no = $this->user_account->get_ac_no_by_email_actype($email,"investment");
        if($ac_no != 0)
        {
            $ac_nos = $ac_nos . $ac_no .",";
        }
        $ac_nos = substr_replace($ac_nos,'',-1);
        $ac_nos = explode(",",$ac_nos);
        $this->db->where('ac_from',$ac_from);
        $this->db->where_not_in('ac_to',$ac_nos);
        $this->db->where('trans_date >=',date('Y-m-d'));
        $this->db->where('trans_date <=',date('Y-m-d H:i:s'));
        $result=$this->db->get('transaction_detail')->result();
        if(count($result)>0)
        {
            $total = 0;
            foreach($result as $row)
                $total += $row->amount;
            return $total;
        }
        else
            return 0;
    }
    function reset_login_flag($name)
    {
        $name = trim($name);
        $this->db->where('uemail',$name);
        $b = array('counter'=>0);
        $this->db->update('user_login',$b);
    }
    function validate_token($token)
    {
        $token = trim($token);
        $a=array('reset_code'=>$token);
        $limit = strtotime(date('Y-m-d H:i:s')) + 7200;
        $this->db->where('reset_time <=',date('Y-m-d H:i:s'));
        $result=$this->db->get_where('user_login',$a)->result();
        if(count($result)==1)
        {
            return true;
        }
        else
            return false;
    }
    function get_token($name)
    {
        $name = trim($name);
        $this->db->select('reset_code');
        $a=array('uemail'=>$name);
        $result=$this->db->get_where('user_login',$a)->result();
        if(count($result)==1)
        {
            return $result[0]->reset_code;
        }
        else
            return "none";
    }
    function get_email_token($token)
    {
        $token = trim($token);
        $this->db->select('uemail');
        $a=array('reset_code'=>$token);
        $result=$this->db->get_where('user_login',$a)->result();
        if(count($result)==1)
        {
            return $result[0]->uemail;
        }
        else
            return "none";
    }
    function update_pass_by_token($token,$pass)
    {
        $pass = trim($pass);
        $this->db->where('reset_code',$token);
        $b = array('pswd'=>$pass);
        $result = $this->db->update('user_login',$b);
        if($result == 1)
        {
            $this->db->where('reset_code',$token);
            $b = array('reset_code'=>"None",'counter'=>0,'status'=>'active','reset_time'=>date('Y-m-d H:i:s'));
            $result=$this->db->update('user_login',$b);
            return true;
        }
            
        else
            return false;
    }
    function update_pass_by_email($email,$pass)
    {
        $pass = trim($pass);
        $this->db->where('uemail',$email);
        $b = array('pswd'=>$pass);
        $result = $this->db->update('user_login',$b);
        if($result == 1)
        {
            return true;
        }
            
        else
            return false;
    }
    function check_login_status($name)
    {
        $name = trim($name);
        $this->db->select('status');
        $a=array('uemail'=>$name);
        $result=$this->db->get_where('user_login',$a)->result();
        if(count($result)==1)
        {
            return $result[0]->status;
        }
        else
            return "none";
    }
    function check_userid($name)
    {
        $name = trim($name);
        $a=array('uemail'=>$name);
        $result=$this->db->get_where('user_profile',$a);
        return $result->num_rows();
    }
    function check_active_userid($name)
    {
        $name = trim($name);
        $a=array('uemail'=>$name,'status'=>'active');
        $result=$this->db->get_where('user_profile',$a);
        return $result->num_rows();
    }
    function check_security_ans($q,$ans,$username)
    {
        $username = trim($username);
        $a=array('uemail'=>$username,'question_id'=>$q,'secure_ans'=>$ans);
        $result=$this->db->get_where('user_security',$a);
        return $result->num_rows();
    }
    function add_reset_code($username)
    {
        $username = trim($username);
        $code = "abcd@+".$username."#$1234".strtotime(date('Y-m-d H:i:s'));
        $this->db->where('uemail',$username);
        $a=array('reset_code'=>md5($code),'reset_time'=>date('Y-m-d H:i:s'));
        $result=$this->db->update('user_login',$a);
        if($result==1)
            return true;
        else
            return false;
    }
    function check_security_q_by_email($email)
    {
        $name = trim($email);
        $a=array('uemail'=>$email);
        $result=$this->db->get_where('user_security',$a);
        $qn = $result->num_rows();
        if($qn == 1)
            return true;
        else
            return false;
    }
    function update_login_status_by_email($name,$status)
    {
        $a = array('status'=>$status);
        $this->db->where('uemail',$name);
        $result=$this->db->update('user_login',$a);
        if($result==1)
            return true;
        return false;
    }
    
    //user detail
    function get_cheuging_ac_detail_by_acno($ac_no)
    {
        $name = trim($ac_no);
        $a=array('ac_no'=>$ac_no,'ac_type'=>'cheuqing');
        $result=$this->db->get_where('ac_detail',$a);
        return $result->result();
    }
    function get_debit_vm_card_detail_by_acno($ac_no)
    {
        $name = trim($ac_no);
        $a=array('ac_no'=>$ac_no,'card_type'=>'Debit');
        $result=$this->db->get_where('virtual_money_card',$a);
        return $result->result();
    }
    function get_credit_card_detail_by_acno($ac_no)
    {
        $name = trim($ac_no);
        $a=array('ac_no'=>$ac_no,'card_type'=>'Credit');
        $result=$this->db->get_where('virtual_money_card',$a)->result();
        return $result;
    }
    function get_credit_card_detail_by_cardno($card_no)
    {
        $name = trim($card_no);
        $a=array('card_no'=>$card_no,'card_type'=>'Credit');
        $result=$this->db->get_where('virtual_money_card',$a)->result();
        return $result;
    }
    function check_card_type($ac_no)
    {
        $a = array('card_no'=>$ac_no);
        $result=$this->db->get_where('virtual_money_card',$a)->result();
        $card_type = $result[0]->card_type;
        return $card_type;
    }
    function get_user_detail_by_email($email)
    {
        $name = trim($email);
        $a=array('uemail'=>$email);
        $result=$this->db->get_where('user_login',$a);
        return $result->result();
    }
    function get_profile_detail_by_email($email)
    {
        $name = trim($email);
        $a=array('uemail'=>$email);
        $result=$this->db->get_where('user_profile',$a);
        return $result->result();
    }
    function valid_password($email,$pass)
    {
        $a=array('uemail'=>$email,'pswd'=>md5($pass));
        $result=$this->db->get_where('user_login',$a)->result();
        if(count($result)==1)
            return true;
        else
            return false;
    }
    function get_ac_no_by_email_actype($name,$type)
    {
        $a = array('username'=>$name,'ac_type'=>$type);
        $result=$this->db->get_where('ac_detail',$a)->result();
        //print_r($result);
        if($result != '' && count($result)==1)
        {
            $ac_no = $result[0]->ac_no;
            if(!isset($ac_no))
                $ac_no = 0;
        }
        else
            $ac_no = 0;
            return $ac_no;
        
    }
    function get_vm_card_no_by_acno_actype($ac_no,$type)
    {
        $a = array('ac_no'=>$ac_no,'card_type'=>$type);
        $result=$this->db->get_where('virtual_money_card',$a)->result();
        //print_r($result);
        if($result != '' && count($result)==1)
        {
            $card_no = $result[0]->card_no;
            if(!isset($card_no))
                $card_no = 0;
        }
        else
            $card_no = 0;
            
        return $card_no;
    }
    function get_bal_by_ac($ac_no)
    {
        $a = array('ac_no'=>$ac_no);
        $result=$this->db->get_where('ac_detail',$a)->result();
        //print_r($result);
        $ac_bal = $result[0]->ac_bal;
        if(!isset($ac_bal))
            $ac_bal = 0;
        return $ac_bal;
    }
    function get_bal_vm_card($ac_no)
    {
        $a = array('card_no'=>$ac_no);
        $result=$this->db->get_where('virtual_money_card',$a)->result();
        //print_r($result);
        $amount = $result[0]->amount;
        return $amount;
    }
    function update_balance_by_ac_no($ac_no,$bal)
    {
        $a = array('ac_bal'=>$bal);
        $this->db->where('ac_no',$ac_no);
        $result=$this->db->update('ac_detail',$a);
        if($result==1)
            return true;
        return false;
    }
    function update_bal_vm_card_by_card_no($card_no,$bal)
    {
        $a = array('amount'=>$bal);
        $this->db->where('card_no',$card_no);
        $result=$this->db->update('virtual_money_card',$a);
        if($result==1)
            return true;
        return false;
    }
    function add_transaction_detail($ac_from,$ac_to,$amount,$bal_from,$bal_to,$detail)
    {
        $a = array(
        'ac_from'=>$ac_from,
        'ac_to' => $ac_to,
        'amount' => $amount,
        'bal_from' => $bal_from,
        'bal_to' => $bal_to,
        'description' => $detail,
        'trans_date' => date('Y-m-d H:i:s')
        );
        $result=$this->db->insert('transaction_detail',$a);
        if($result==1)
            return true;
        return false;
    }
    function get_transaction_no($ac_no,$vm_card_no,$amount,$detail)
    {
        $this->db->select('trans_id');
        $this->db->limit(1);
        $this->db->order_by('trans_date','desc');
        $a=array('ac_from'=>$ac_no,'ac_to'=>$vm_card_no,'description'=>$detail);
        $this->db->like('amount',$amount);
        $result=$this->db->get_where('transaction_detail',$a)->result();
        if(count($result)==1)
        {
            return $result[0]->trans_id;
        }
        else
            return "none";
    }
    function transfer_money_from_acno_to_cardno($ac_no,$vm_card_no,$amount,$detail)
    {
        $i_ac_bal = $this->get_bal_by_ac($ac_no);
        
        $i_vc_bal = $this->get_bal_vm_card($vm_card_no);
        if($this->check_card_type($vm_card_no) == "Credit")
        {
            $credit_detail = $this->get_credit_card_detail_by_cardno($vm_card_no);
            $f_vm_card_bal = $credit_detail[0]->amount + $amount;
        }
        else
        {
            $f_vm_card_bal = $i_vc_bal + $amount;
        }
        $f_ac_bal = $i_ac_bal - $amount;
            if($this->update_balance_by_ac_no($ac_no,$f_ac_bal))
                {
                    if($this->update_bal_vm_card_by_card_no($vm_card_no,$f_vm_card_bal))
                    {
                        //echo "Both Done";
                        if($this->add_transaction_detail($ac_no,$vm_card_no,$amount,$f_ac_bal,$f_vm_card_bal,$detail))
                        {
                            return true;
                            //echo "All Done";
                        }
                        else
                        {
                            $this->update_balance_by_ac_no($ac_no,$i_ac_bal);
                            $this->update_bal_vm_card_by_card_no($vm_card_no,$i_vc_bal);
                            return false;
                        }
                    }
                    else
                    {
                        $this->update_balance_by_ac_no($ac_no,$i_ac_bal);
                        return false;
                    }
                }
                else
                {
                    return false;
                }
    }
     function transfer_money_from_cardno_to_cardno($ac_no,$vm_card_no,$amount,$detail)
    {
        $i_ac_bal = $this->get_bal_vm_card($ac_no);
        $i_vc_bal = $this->get_bal_vm_card($vm_card_no);
        
        if($this->check_card_type($vm_card_no) == "Credit")
        {
            $credit_detail = $this->get_credit_card_detail_by_cardno($vm_card_no);
            $f_vm_card_bal = $credit_detail[0]->amount + $amount;
        }
        else
        {
            return false;
        }
        $f_ac_bal = $i_ac_bal - $amount;
            if($this->update_bal_vm_card_by_card_no($ac_no,$f_ac_bal))
                {
                    if($this->update_bal_vm_card_by_card_no($vm_card_no,$f_vm_card_bal))
                    {
                        //echo "Both Done";
                        if($this->add_transaction_detail($ac_no,$vm_card_no,$amount,$f_ac_bal,$f_vm_card_bal,$detail))
                        {
                            return true;
                            //echo "All Done";
                        }
                        else
                        {
                            $this->update_bal_vm_card_by_card_no($ac_no,$i_ac_bal);
                            $this->update_bal_vm_card_by_card_no($vm_card_no,$i_vc_bal);
                            return false;
                        }
                    }
                    else
                    {
                        $this->update_bal_vm_card_by_card_no($ac_no,$i_ac_bal);
                        return false;
                    }
                }
                else
                {
                    return false;
                }
    }
    function transfer_money_from_cardno_to_acno($vm_card_no,$ac_no,$amount,$detail)
    {
        $i_ac_bal = $this->get_bal_by_ac($ac_no);
        $i_vc_bal = $this->get_bal_vm_card($vm_card_no);
        
        $f_ac_bal = $i_ac_bal + $amount;
        $f_vm_card_bal = $i_vc_bal - $amount;
            if($this->update_balance_by_ac_no($ac_no,$f_ac_bal))
                {
                    if($this->update_bal_vm_card_by_card_no($vm_card_no,$f_vm_card_bal))
                    {
                        //echo "Both Done";
                        if($this->add_transaction_detail($vm_card_no,$ac_no,$amount,$f_vm_card_bal,$f_ac_bal,$detail))
                        {
                            return true;
                            //echo "All Done";
                        }
                        else
                        {
                            $this->update_balance_by_ac_no($ac_no,$i_ac_bal);
                            $this->update_bal_vm_card_by_card_no($vm_card_no,$i_vc_bal);
                            return false;
                        }
                    }
                    else
                    {
                        $this->update_balance_by_ac_no($ac_no,$i_ac_bal);
                        return false;
                    }
                }
                else
                {
                    return false;
                }
    }
    function transfer_money_from_credit_to_acno($vm_card_no,$ac_no,$amount,$detail)
    {
        $i_ac_bal = $this->get_bal_by_ac($ac_no);
        $cc_bal = $this->get_bal_vm_card($vm_card_no);

        $f_ac_bal = $i_ac_bal + $amount;
        $f_vm_card_bal = $cc_bal - $amount;
            if($this->update_balance_by_ac_no($ac_no,$f_ac_bal))
                {
                    if($this->update_bal_vm_card_by_card_no($vm_card_no,$f_vm_card_bal))
                    {
                        //echo "Both Done";
                        if($this->add_transaction_detail($vm_card_no,$ac_no,$amount,$f_vm_card_bal,$f_ac_bal,$detail))
                        {
                            return true;
                            //echo "All Done";
                        }
                        else
                        {
                            $this->update_balance_by_ac_no($ac_no,$i_ac_bal);
                            $this->update_bal_vm_card_by_card_no($vm_card_no,$i_vc_bal);
                            return false;
                        }
                    }
                    else
                    {
                        $this->update_balance_by_ac_no($ac_no,$i_ac_bal);
                        return false;
                    }
                }
                else
                {
                    return false;
                }
    }
    function transfer_money_from_acno_to_acno($f_ac_no,$t_ac_no,$amount,$detail)
    {
        $i_f_ac_bal = $this->get_bal_by_ac($f_ac_no);
        $i_t_ac_bal = $this->get_bal_by_ac($t_ac_no);
        
        $f_ac_bal = $i_f_ac_bal - $amount;
        $t_ac_bal = $i_t_ac_bal + $amount;
        
            if($this->update_balance_by_ac_no($f_ac_no,$f_ac_bal))
                {
                    if($this->update_balance_by_ac_no($t_ac_no,$t_ac_bal))
                    {
                        //echo "Both Done";
                        if($this->add_transaction_detail($f_ac_no,$t_ac_no,$amount,$f_ac_bal,$t_ac_bal,$detail))
                        {
                            return true;
                            //echo "All Done";
                        }
                        else
                        {
                            $this->update_balance_by_ac_no($f_ac_no,$i_f_ac_bal);
                            $this->update_balance_by_ac_no($t_ac_no,$i_t_ac_bal);
                            return false;
                        }
                    }
                    else
                    {
                        $this->update_balance_by_ac_no($f_ac_no,$i_f_ac_bal);
                        return false;
                    }
                }
                else
                {
                    return false;
                }
    }
    function get_all_ac_by_email($name)
    {
        $name = trim($name);
        $a=array('username'=>$name);
        $result=$this->db->get_where('ac_detail',$a);
        return $result->result();
    }
    function get_all_login_history($name,$limit)
    {
        $name = trim($name);
        $this->db->limit($limit);
        $this->db->order_by('ldate','desc');
        $a=array('username'=>$name);
        $result=$this->db->get_where('user_login_history',$a);
        return $result->result();
    }
    function add_login_history($name,$desc)
    {
        $name = trim($name);
        $a=array('username'=>$name,'description'=>$desc,'ldate'=>date('Y-m-d H:i:s'));
        $result=$this->db->insert('user_login_history',$a);
        return $result;
    }
    function check_ac_type($ac_no)
    {
        if($ac_no != "")
        {
            if(strlen($ac_no) == 8)
            {
                $this->db->select('ac_type');
                $this->db->where('ac_no',$ac_no);
                $result = $this->db->get('ac_detail')->result();
                return $result[0]->ac_type;
            }
            else if(strlen($ac_no) == 13)
            {
                return "card";
            }
            else
                return "none";
            
        }
        else
            return "none";
    }
    function get_all_transaction_history_by_chequing_ac_no($ac_no)
    {
        $this->db->where('ac_from',$ac_no);
        $this->db->or_where('ac_to',$ac_no);
        $this->db->order_by('trans_date');
        $result = $this->db->get('transaction_detail')->result();
        return $result;
    }
    function check_cheque_by_chqno_acno($chq_no,$ac_no)
    {
        $this->db->where('chq_no',$chq_no);
        $this->db->where('from_ac',$ac_no);
        $result = $this->db->get('cheques_detail')->result();
        if(count($result)>=1)
            return true;
        return false;
    }
    function valid_acno_by_acno($ac_no)
    {
        $this->db->where('ac_no',$ac_no);
        $result = $this->db->get('ac_detail')->result();
        if(count($result)>=1)
            return true;
        return false;
    }
    function valid_acno_by_acno_type($ac_no,$type)
    {
        $this->db->where('ac_no',$ac_no);
        $this->db->where('ac_type',$type);
        $result = $this->db->get('ac_detail')->result();
        if(count($result)>=1)
            return true;
        return false;
    }
    function valid_vmc_no_by_vmc_no($card_no)
    {
        $this->db->where('card_no',$card_no);
        $result = $this->db->get('virtual_money_card')->result();
        if(count($result)>=1)
            return true;
        return false;
    }
    function get_all_cheque_by_ac_no($ac_no)
    {
        $this->db->where('to_ac',$ac_no);
        $result = $this->db->get('cheques_detail')->result();
        return $result;
    }
    function get_all_bank_ac()
    {
        $this->db->join('user_profile', 'user_profile.uemail = ac_detail.username');
        $a=array('ac_type'=>'company_account');
        $result=$this->db->get_where('ac_detail',$a);
        return $result->result();
    }
    function get_all_bill_by_email($email)
    {
        $this->db->where('uemail',$email);
        $result = $this->db->get('billing_detail')->result();
        return $result;
    }
    function get_compnay_name_by_ac_no($acno)
    {
        $this->db->where('ac_no',$acno);
        $this->db->where('ac_type','company_account');
        $result = $this->db->get('ac_detail')->result();
        if(count($result) == 1)
        {
            $this->db->where('uemail',$result[0]->username);
            $result = $this->db->get('user_profile')->result();
            if(count($result)==1)
                return $result[0]->fname.", ".$result[0]->lname;
            else
                return "NONE";
        }
        else
        {
            return "NONE";
        }
    }
    function get_all_credit_card()
    {
        $result = $this->db->get('credit_card_type')->result();
        return $result;
    }
    function check_credit_type($type)
    {
        $this->db->where('cid',$type);
        $result = $this->db->get('credit_card_type')->result();
        if(count($result)>=1)
            return true;
        return false;
    }
    function get_credit_req_by_email($type)
    {
        $this->db->where('uemail',$type);
        $result = $this->db->get('manage_credit_card_request')->result();
        return $result;
    }
    function get_credit_card_type_detail_by_cid($type)
    {
        $this->db->where('cid',$type);
        $result = $this->db->get('credit_card_type')->result();
        return $result;
    }
    function get_limit_of_card($card_no)
    {
        $this->db->where('card_no',$card_no);
        $result = $this->db->get('virtual_money_card')->result();
        $limit = $result[0]->max_limit + $result[0]->amount;
        return $limit;
    }
    function count_estatement($card_no)
    {
        $card_no = trim($card_no);
        $a=array('card_no'=>$card_no);
        $result=$this->db->get_where('credit_e_statement_record',$a)->result();
        return count($result);
    }
    function get_last3_estatement($card_no)
    {
        $card_no = trim($card_no);
        $this->db->limit(3);
        $this->db->order_by('cdate','desc');
        $a=array('card_no'=>$card_no);
        $result=$this->db->get_where('credit_e_statement_record',$a)->result();
        return $result;
    }
    function get_last_estatement($card_no)
    {
        $card_no = trim($card_no);
        $this->db->limit(1);
        $this->db->order_by('cdate','desc');
        $a=array('card_no'=>$card_no);
        $result=$this->db->get_where('credit_e_statement_record',$a)->result();
        return $result;
    }
    function get_last_payment_date($card_no,$type)
    {
        $credit_detail = $this->get_credit_card_detail_by_cardno($card_no);
        $card_tax = $credit_detail[0]->card_tax;
        $c = date("Y/m/d",strtotime($credit_detail[0]->card_cdate));
        $startTimeStamp = strtotime($c);
        $int_timestamp = $startTimeStamp;
        $endTimeStamp = strtotime(date("Y-m-d H:i:s"));
        $day = 0;
        $i=0;
        $j=0;
        $st = $int_timestamp;
        while($i!=1)
        {
            //echo $j.'=';
            if(($endTimeStamp < ($int_timestamp+(24*3600))))
            {
                $i=1;
            }
            if($i==0)
            {

                $day++;
                $st = $int_timestamp;
                $int_timestamp = $int_timestamp + (30*86400);
                //echo "Y-".date("d M,Y",$st)."-L".date("d M,Y",$int_timestamp)."<br/>";                
            }
            $j++;
            //echo $day."-".$i."-".date("d M,Y",$int_timestamp)."<br/>";
        };
                                                
        $timeDiff = abs($int_timestamp - $startTimeStamp);              
        $numberDays = $timeDiff/(30*86400);  // 86400 seconds in one day
        $numberDays = intval($numberDays);
        if($type == "Last-Payment-Date")
            return date("d M,Y",$int_timestamp);
        else if($type == "Total-Estatement")
            return $numberDays-1;
    }
    function check_estatement($card_no,$st,$int_timestamp)
    {
        $card_no = trim($card_no);
        $s_date = date("Y/m/d",$st);
        $e_date = date("Y/m/d",$int_timestamp);
        $a=array('card_no'=>$card_no,'from'=>$s_date,'to'=>$e_date);
        $result=$this->db->get_where('credit_e_statement_record',$a)->result();
        if(count($result) == 1)
            return true;
        else
            return false;
    }
    function get_estatement($card_no,$st,$int_timestamp)
    {
        $card_no = trim($card_no);
        $s_date = date("Y/m/d",$st);
        $e_date = date("Y/m/d",$int_timestamp);
        $a=array('card_no'=>$card_no,'from'=>$s_date,'to'=>$e_date);
        $result=$this->db->get_where('credit_e_statement_record',$a)->result();
        return $result;
    }
    function get_previous_estatement($card_no,$st)
    {
        $card_no = trim($card_no);
        $s_date = date("Y/m/d",$st);
        $this->db->where('to <=',$s_date);
        $this->db->limit(1);
        $a=array('card_no'=>$card_no);
        $result=$this->db->get_where('credit_e_statement_record',$a)->result();
        if(count($result)==0)
            return 0;
        else
            return $result;
    }
    function get_all_estatement($card_no)
    {
        $card_no = trim($card_no);
        $a=array('card_no'=>$card_no);
        $result=$this->db->get_where('credit_e_statement_record',$a)->result();
        if(count($result)==0)
            return 0;
        else
            return $result;
    }
    function get_all_transaction_by_ac_no($ac_no,$from,$to)
    {
        $result = $this->db->query("SELECT * FROM (`transaction_detail`) WHERE `trans_date` >= '".$from."' AND `trans_date` <= '".$to."' AND (`ac_from` = '".$ac_no."' OR `ac_to` = '".$ac_no."') ORDER BY `trans_date`");
        return $result->result();
    }
    function get_all_stock()
    {
        $result=$this->db->get('stock_market')->result();
        if(count($result)==0)
            return 0;
        else
            return $result;
    }
    function get_max_ac_no()
    {
        $this->db->select_max('ac_no');
        $result=$this->db->get('ac_detail')->result();
        $ac_no = $result[0]->ac_no;
        if(!isset($ac_no))
            $ac_no = 0;
        return $ac_no;
    }
    function get_ac_detail_by_email_type($username,$type)
    {
        $name = trim($username);
        $a=array('username'=>$username,'ac_type'=>$type);
        $result=$this->db->get_where('ac_detail',$a);
        return $result->result();
    }
    function get_buying_stock_price_by_code($code)
    {
        $this->db->select('buy_price');
        $this->db->where('code',$code);
        $result = $this->db->get('stock_market')->result();
        if(count($result) ==0 )
            return 0;
        else
            return $result[0]->buy_price;
    }
    function get_selling_stock_price_by_code($code)
    {
        $this->db->select('sales_price');
        $this->db->where('code',$code);
        $result = $this->db->get('stock_market')->result();
        if(count($result) ==0 )
            return 0;
        else
            return $result[0]->sales_price;
    }
    function get_stock_volume_by_code($code)
    {
        $this->db->select('total_no');
        $this->db->where('code',$code);
        $result = $this->db->get('stock_market')->result();
        if(count($result) ==0 )
            return 0;
        else
            return $result[0]->total_no;
    }
    function get_stock_volume_by_code_ac($code,$ac_no)
    {
        $this->db->where('code',$code);
        $this->db->where('ac_no',$ac_no);
        $result = $this->db->get('stock_order')->result();
        if(count($result) ==0)
            return 0;
        else
        {
            $total =0;
            foreach($result as $row)
            {
                if($row->type == "Buy")
                    $total = $total + $row->amount;
                else
                    $total = $total - $row->amount;
            }
            return $total;   
        }
    }
    function get_stock_volume_by_code_ac_type($code,$ac_no,$type)
    {
        $this->db->where('code',$code);
        $this->db->where('ac_no',$ac_no);
        $this->db->where('type',$type);
        $result = $this->db->get('stock_order')->result();
        if(count($result) ==0)
            return 0;
        else
        {
            $total =0;
            foreach($result as $row)
            {
                $total = $total + $row->amount;
            }
            return $total;   
        }
    }
    function get_stock_avg_price_by_code_ac_type($code,$ac_no,$type)
    {
        $this->db->where('code',$code);
        $this->db->where('ac_no',$ac_no);
        $this->db->where('type',$type);
        $result = $this->db->get('stock_order')->result();
        if(count($result) ==0)
            return 0;
        else
        {
            $total = 0;
            foreach($result as $row)
            {
                $total = $total + ( $row->amount * $row->price );
            }
            return $total;   
        }
    }
    function check_stock_code($code)
    {
        $this->db->where('code',$code);
        $result = $this->db->get('stock_market')->result();
        if(count($result) ==0 )
            return false;
        else
            return true;
    }
    function update_stock_volume($code,$volume)
    {
        $this->db->where('code',$code);
        $result = $this->db->update('stock_market',array('total_no'=>$volume));
        return $result;
    }
    function get_sold_stock_by_ac($ac_no)
    {
        $this->db->where('type',"SELL");
        $this->db->where('ac_no',$ac_no);
        $result=$this->db->get('stock_order')->result();
        if(count($result)==0)
            return 0;
        else
            return $result;
    }
    function get_diff_stock_code_by_ac($ac_no)
    {
        $this->db->distinct(true);
        $this->db->select('code');
        $this->db->where('ac_no',$ac_no);
        $result=$this->db->get('stock_order')->result();
        if(count($result)==0)
            return 0;
        else
            return $result;
    }
    function get_bought_stock_by_ac($ac_no)
    {
        $this->db->where('type',"BUY");
        $this->db->where('ac_no',$ac_no);
        $result=$this->db->get('stock_order')->result();
        if(count($result)==0)
            return 0;
        else
            return $result;
    }
    function check_fixed_plan_exist($inve_ac_no,$type)
    {
        $this->db->where('ac_no',$inve_ac_no);
        $this->db->where('status',$type);
        $result=$this->db->get('inve_fixed_deposit')->result();
        if(count($result)==1)
            return true;
        else
            return false;
    }
    function get_all_fixed_plan($inve_ac_no,$type)
    {
        $this->db->where('ac_no',$inve_ac_no);
        if($type != "")
            $this->db->where('status',$type);
        $this->db->order_by('issue_date','desc');
        $result=$this->db->get('inve_fixed_deposit')->result();
        if(count($result)==0)
            return false;
        else
            return $result;
    }
    function get_security_que_email($email)
    {
        $this->db->where('uemail',$email);
                $questions = $this->db->get('user_security')->result();
                //print_r($questions);
                if(count($questions)>0)
                {
                    foreach($questions as $q)
                    {
                        $this->db->where('q_id',$q->question_id);
                        $this->db->select('detail');
                        $result = $this->db->get('secure_question')->result();
                        if(count($result)>0)
                        {
                            return $result[0]->detail;
                        }
                        else
                            return "None";
                    }
                }
                else
                    return "None";
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
            if(isset($detail) && $detail !="")
            {
                if(count($detail)>0)
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
 ?>