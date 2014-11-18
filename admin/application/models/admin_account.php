<?php
class Admin_account extends CI_Model {
	function __construct() {
		parent::__construct();
	}
    
    function check_admin_login($name,$pass)
    {
        $name = trim($name);
           $pass = trim($pass);
        $a=array('uemail'=>$name,'pswd'=>$pass);
        $result=$this->db->get_where('admin_login',$a);
        return $result->num_rows();
    }
    function add_login_history($name,$desc)
    {
        $name = trim($name);
        $a=array('username'=>$name,'description'=>$desc,'ldate'=>date('Y-m-d H:i:s'));
        $result=$this->db->insert('user_login_history',$a);
        return $result;
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
    function check_userid($name)
    {
        $name = trim($name);
        $a=array('uemail'=>$name);
        $result=$this->db->get_where('user_profile',$a);
        return $result->num_rows();
    }
    function check_credit_account($name)
    {
        $name = trim($name);
        $a=array('username'=>$name,'ac_type'=>'credit');
        $result=$this->db->get_where('ac_detail',$a)->result();
        if(count($result)>=1)
            return true;
        return false;
    }
    function get_all_profile_by_type($name)
    {
        $name = trim($name);
        $a=array('status'=>$name);
        $result=$this->db->get_where('user_profile',$a);
        return $result->result();
    }
    function get_profile_detail_by_email($name)
    {
        $name = trim($name);
        $a=array('uemail'=>$name);
        $result=$this->db->get_where('user_profile',$a);
        return $result->result();
    }
    function chk_user_login_detail_by_email($name)
    {
        $name = trim($name);
        $a=array('uemail'=>$name);
        $result=$this->db->get_where('user_login',$a)->result();
        if(count($result) == 0)
        {
            return false;
        }
        else
            return true;
    }
    function chk_ac_detail_by_email_actype($name,$type)
    {
        $name = trim($name);
        $a=array('username'=>$name,'ac_type'=>$type);
        $result=$this->db->get_where('ac_detail',$a)->result();
        if(count($result) == 0)
        {
            return false;
        }
        else
            return true;
    }
    function get_all_ac_by_email($name)
    {
        $name = trim($name);
        $a=array('username'=>$name);
        $result=$this->db->get_where('ac_detail',$a);
        return $result->result();
    }
    function get_max_ac_no()
    {
        $this->db->select_max('ac_no');
        $result=$this->db->get('ac_detail')->result();
        //print_r($result);
        $ac_no = $result[0]->ac_no;
        if(!isset($ac_no))
            $ac_no = 0;
        return $ac_no;
    }
    function get_max_vm_card_no()
    {
        $this->db->select_max('card_no');
        $result=$this->db->get('virtual_money_card')->result();
        //print_r($result);
        $ac_no = $result[0]->card_no;
        if(!isset($ac_no))
            $ac_no = 0;
        return $ac_no;
    }
    function get_ac_no_by_email_actype($name,$type)
    {
        $a = array('username'=>$name,'ac_type'=>$type);
        $result=$this->db->get_where('ac_detail',$a)->result();
        //print_r($result);
        $ac_no = $result[0]->ac_no;
        if(!isset($ac_no))
            $ac_no = 0;
        return $ac_no;
    }
    function get_cheuging_ac_detail_by_acno($ac_no)
    {
        $name = trim($ac_no);
        $a=array('ac_no'=>$ac_no,'ac_type'=>'cheuqing');
        $result=$this->db->get_where('ac_detail',$a);
        return $result->result();
    }
    function get_credit_ac_detail_by_acno($ac_no)
    {
        $name = trim($ac_no);
        $a=array('ac_no'=>$ac_no,'ac_type'=>'credit');
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
        $result=$this->db->get_where('virtual_money_card',$a);
        return $result->result();
    }
    function get_credit_card_detail_by_cardno($card_no)
    {
        $name = trim($card_no);
        $a=array('card_no'=>$card_no,'card_type'=>'Credit');
        $result=$this->db->get_where('virtual_money_card',$a)->result();
        return $result;
    }
    function get_user_detail_by_email($email)
    {
        $name = trim($email);
        $a=array('uemail'=>$email);
        $result=$this->db->get_where('user_login',$a);
        return $result->result();
    }
    function valid_acno($ac_no,$type)
    {
        $a = array('ac_no'=>$ac_no,'ac_type'=>$type);
        $result=$this->db->get_where('ac_detail',$a)->result();
        //print_r($result);
        $ac_no = $result[0]->ac_no;
        if(!isset($ac_no))
            return false;
        return true;
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
    function update_balance_by_ac_no($ac_no,$bal)
    {
        $a = array('ac_bal'=>$bal);
        $this->db->where('ac_no',$ac_no);
        $result=$this->db->update('ac_detail',$a);
        if($result==1)
            return true;
        return false;
    }
    function update_profile_status_by_email($name,$status)
    {
        $a = array('status'=>$status);
        $this->db->where('uemail',$name);
        $result=$this->db->update('user_profile',$a);
        if($result==1)
            return true;
        return false;
    }
    function update_credit_req_status_by_email($name,$status)
    {
        $a = array('status'=>$status);
        $this->db->where('uemail',$name);
        $result=$this->db->update('manage_credit_card_request',$a);
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
    function get_bank_ac_no()
    {
        $this->db->select('ac_no');
        $a=array('ac_type'=>'bank_account');
        $result=$this->db->get_where('ac_detail',$a)->result();
        $ac_bal = $result[0]->ac_no;
        if(!isset($ac_bal))
            $ac_bal = 0;
        return $ac_bal;
    }
    function get_all_cheque($type)
    {
        $this->db->where('status',$type);
        $result = $this->db->get('cheques_detail')->result();
        return $result;
    }
    function get_cheque_detail_by_chqno_acno($chq_no,$ac_no)
    {
        $a= array('chq_no'=>$chq_no,'from_ac'=>$ac_no);
        $result = $this->db->get_where('cheques_detail',$a)->result();
        return $result;
    }
    
        //payment transfer
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
    function update_cheque_status_by_chno_acno($chq_no,$ac_no,$status)
    {
        $a = array('status'=>$status);
        $this->db->where('chq_no',$chq_no);
        $this->db->where('from_ac',$ac_no);
        $result=$this->db->update('cheques_detail',$a);
        if($result==1)
            return true;
        return false;
    }
    function get_all_bank_ac()
    {
        $this->db->join('user_profile', 'user_profile.uemail = ac_detail.username');
        $a=array('ac_type'=>'company_account');
        $result=$this->db->get_where('ac_detail',$a);
        return $result->result();
    }
    function get_bank_detail_by_acno($ac_no)
    {
        $this->db->where('ac_no',$ac_no);
        $this->db->join('user_profile', 'user_profile.uemail = ac_detail.username');
        $a=array('ac_type'=>'company_account');
        $result=$this->db->get_where('ac_detail',$a);
        return $result->result();
    }
    function get_all_pending_credit_card_req()
    {
        $this->db->where('status','Pending');
        $result = $this->db->get('manage_credit_card_request')->result();
        return $result;
    }
    function get_credit_card_type_detail_by_cid($type)
    {
        $this->db->where('cid',$type);
        $result = $this->db->get('credit_card_type')->result();
        return $result;
    }
    function get_credit_req_by_email($type)
    {
        $this->db->where('uemail',$type);
        $result = $this->db->get('manage_credit_card_request')->result();
        return $result;
    }
    function get_all_credit_card()
    {
        $result = $this->db->get('credit_card_type')->result();
        return $result;
    }
    function get_all_transaction_history()
    {
        $this->db->order_by('trans_date','desc');
        $result = $this->db->get('transaction_detail')->result();
        return $result;
    }
    function get_all_transaction_history_by_chequing_ac_no($ac_no)
    {
        $this->db->where('ac_from',$ac_no);
        $this->db->or_where('ac_to',$ac_no);
        $this->db->order_by('trans_date');
        $result = $this->db->get('transaction_detail')->result();
        return $result;
    }
    function get_last_payment_date($card_no,$type)
    {
        $credit_detail = $this->admin_account->get_credit_card_detail_by_cardno($card_no);
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
                //echo "X-Time to Generate Statement<br/>";
                //echo "Y-".date("d M,Y",$st)."-L".date("d M,Y",$int_timestamp)."<br/>";
                /*
                if(!$this->check_estatement($card_no,$st,$int_timestamp))
                {
                    echo "e-Statement Not Available";
                    //$this->add_estatement_record($card_no,$st,$int_timestamp,$card_tax);
                }
                else
                {
                    echo "e-Statement Available";
                }
                */
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
    function get_last_statment_record($card_no)
    {
        $this->db->select_max('estateid');
        $this->db->where('card_no',$card_no);
        $result = $this->db->get('credit_e_statement_record')->result();
        if($result[0]->estateid == null)
            return 0;
        else
            return $result;
    }
    function get_last_statment_record_by_id($e_id)
    {
        $this->db->where('estateid',$e_id);
        $result = $this->db->get('credit_e_statement_record')->result();
        return $result;
    }
    function add_estatement_record($card_no,$from,$to,$card_tax)
    {
        $e_id = $this->get_last_statment_record($card_no);
        if($e_id != 0)
        {
            $e_Detail = $this->get_last_statment_record_by_id($e_id[0]->estateid);
            $pre_amount = $e_Detail[0]->amount;
            $start_date = strtotime($e_Detail[0]->to);
        }
        else
        {
            $pre_amount = 0.0;
            $first_flag = 1;
            $start_date = $from;
        }
        $s_date = date("Y/m/d",$from);
        $e_date = date("Y/m/d",$to);
        
        $d = $this->get_all_transaction_by_ac_no($card_no,$s_date,$e_date);
        
        $amount = 0.0;
        $credit = 0.0;
        $debit = 0.0;
        $p_intr =0;
        if(count($d) !=0)
        {
            $xx = 0;
            $tnd =0;
            foreach($d as $row)
            {
                $xx++;
                $nd=0;
                if($first_flag == 1)
                {
                    if(count($d) != $xx)
                        $temp = date("Y/m/d",strtotime($d[$xx]->trans_date));
                    else
                        $temp = $e_date;
                    $end_date = strtotime($temp);
                }
                else
                {
                    $temp = date("Y/m/d",strtotime($row->trans_date));
                    $end_date = strtotime($temp);
                }
                
                $timeDiff = abs($start_date - $end_date);              
                $nd = $timeDiff/(86400);  // 86400 seconds in one day
                $nd = intval($nd);
                if($xx == 1)
                    $nd++;
                if($row->ac_from == $card_no)
                {
                    $pre_amount = $pre_amount - $row->amount;
                }
                else if($row->ac_to == $card_no)
                {   
                    //echo "S ".date("Y/m/d",$start_date)."- L".date("Y/m/d",$end_date)."<br/>";   
                    $pre_amount = $pre_amount + $row->amount;
                }
                if($pre_amount < 0)
                {
                    $p_intr = $p_intr + ($pre_amount*$nd);
                    $tnd = $tnd +$nd;
                }
                //echo "<br/>".$xx." - PA:".$pre_amount." - D:".$nd." - PI:".$p_intr." - S:".date("Y/m/d",$start_date)." E:".$temp;
                $start_date = $end_date;
            }
            $amount = $pre_amount;
            if($pre_amount < 0)
            {
                $fintr = ($p_intr/$tnd)*($card_tax/(100*12));
            }
            else
            {
                $fintr = 0.0;
            }
            
            $edetail = array(
            'card_no' => $card_no,
            'from' => date("Y/m/d",$from),
            'to' => date("Y/m/d",$end_date),
            'amount'=>$amount,
            'tax'=>$fintr,
            'cdate' =>date('Y-m-d H:i:s')
            );
            $this->db->insert('credit_e_statement_record',$edetail);
        }
        else
        {
            echo "Calculate as per last balance";
        }
    }
    function get_all_transaction_by_ac_no($ac_no,$from,$to)
    {
        $result = $this->db->query("SELECT * FROM (`transaction_detail`) WHERE `trans_date` >= '".$from."' AND `trans_date` <= '".$to."' AND (`ac_from` = '".$ac_no."' OR `ac_to` = '".$ac_no."') ORDER BY `trans_date`");
        return $result->result();
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
    function all_accounts_by_type($type)
    {
        $a=array('ac_type'=>$type);
        $result=$this->db->get_where('ac_detail',$a);
        return $result->num_rows();
    }
    function all_cards_by_type($type)
    {
        $a=array('card_type'=>$type);
        $result=$this->db->get_where('virtual_money_card',$a);
        return $result->num_rows();
    }
    function all_users_by_type($status)
    {
        $a=array('status'=>$status);
        $result=$this->db->get_where('user_profile',$a);
        return $result->num_rows();
    }
    function get_all_fixed_plan()
    {
        $this->db->order_by('issue_date','desc');
        $result=$this->db->get('inve_fixed_deposit')->result();
        return $result;
    }
    function get_all_stock()
    {
        $result=$this->db->get('stock_market')->result();
        if(count($result)==0)
            return 0;
        else
            return $result;
    }
 }
 ?>