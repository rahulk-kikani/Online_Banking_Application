<?php
    if(isset($card_request_detail) && !$this->admin_account->check_credit_account($user_email))
    {
        ?>
<form class="product_form" action="" name="ac_history_form" id="reg_form" method="post">
        <table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;">           
            <?php
                $card_detail = $this->admin_account->get_credit_card_type_detail_by_cid($card_request_detail['card_type']);
                echo "<tr class='t1'>
                    <td style='width: 170px'>Card Type(User Choise)</td>
                    <td style='width: 551px'>: ".$card_detail[0]->name." - $".$card_detail[0]->limit." - ".$card_detail[0]->int_rate."%</td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>Email</td>
                    <td>: ".$card_request_detail['email']."
                    <input type='hidden' value='".$card_request_detail['email']."' name='email' />
                    </td>
                    </tr>";
                echo "<tr class='t1'>
                    <td>ID</td>
                    <td>: ".$card_request_detail['cc_req_id']."
                    <input type='hidden' value='".$card_request_detail['cc_req_id']."' name='req_id' />
                    </td>
                    </tr>";
          ?>
            <tr class='t2'>
                            <td>Select Credit Limit </td>
                            <td>
                                <select name="card_type">
                                    <?php
                                        $cards = $this->admin_account->get_all_credit_card();
                                        foreach($cards as $row)
                                        {
                                            echo "<option value='$row->cid'>$row->name - $$row->limit - $row->int_rate%</option>";
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('card_type').'</span>';?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <?php
                                    $data=array(
                                        'id'    => 'submit',
                                        'name'  => 'submit',
                                        'value' => '',
                                        'class' => 'submit_button',
                                        'onclick'=> 'return check_data2()',
                                        );
                                        echo form_submit($data);
                                ?>
                            </td>
                        </tr>
          
            </table>
        </form>
        <?php
        }
        else
        {
            if(isset($credit_ac_detail))
            {
                ?>
                <h2>Credit Account Detail</h2>
                <table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;">           
                <?php
                $i=0;
                foreach($credit_ac_detail as $row)
                {
                    echo "<tr class='t1'>
                        <td style='width: 135px'>Account No</td>
                        <td >: ".$row->ac_no."</td>
                        </tr>";
                    echo "<tr class='t2'>
                        <td>Account Type</td>
                        <td>: 453".$row->ac_type."</td>
                        </tr>";
                    echo "<tr class='t1'>
                        <td><b>Balance</b></td>
                        <td>: <b>".$row->ac_bal."</b></td>
                        </tr>";
                    echo "<tr class='t2'>
                        <td>Status</td>
                        <td>: ".$row->ac_status."</td>
                        </tr>";
                    echo "<tr class='t1'>
                        <td>Date</td>
                        <td>: ".date("d M,Y h:i:s",strtotime($row->ac_cdate))."</td>
                        </tr>";
                    
                }
                ?>
                </table>
                <?php
            }
            else
            {
                echo "<tr class='t1'>
                        <td style='width: 135px'>Account No</td>
                        <td >: Not Found</td>
                        </tr>";
                    echo "<tr class='t2'>
                        <td>Account Type</td>
                        <td>: Not Found</td>
                        </tr>";
                    echo "<tr class='t1'>
                        <td>Account Balance</td>
                        <td>: Not Found</td>
                        </tr>";
                    echo "<tr class='t2'>
                        <td>Date</td>
                        <td>: Not Found</td>
                        </tr>";
                    echo "<tr class='t1'>
                        <td>Status</td>
                        <td>: Not Found</td>
                        </tr>";
            }
            
            if(isset($credit_card_detail))
            {
                ?>
                <h2>Credit Card Detail</h2>
                <table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;">           
                <?php
                $i=0;
                foreach($credit_card_detail as $row)
                {
                    echo "<tr class='t1'>
                        <td style='width: 135px'>Account No</td>
                        <td >: ".$row->ac_no."</td>
                        </tr>";
                    echo "<tr class='t2'>
                        <td>Card No</td>
                        <td>: 453".$row->card_no."</td>
                        </tr>";
                    echo "<tr class='t1'>
                        <td style='width: 135px'>Card PIN</td>
                        <td >: ".$row->card_pin."</td>
                        </tr>";
                    echo "<tr class='t2'>
                        <td>Card Exp. Date</td>
                        <td>: ".date("M-Y",strtotime($row->card_end_date))."</td>
                        </tr>";
                    echo "<tr class='t1'>
                        <td style='width: 135px'>CVC Code</td>
                        <td >: ".$row->cvc_code."</td>
                        </tr>";
                    echo "<tr class='t2'>
                        <td>Amount</td>
                        <td>: ".$row->amount."</td>
                        </tr>";
                    echo "<tr class='t1'>
                        <td>Max Limit</td>
                        <td>: ".$row->max_limit."</td>
                        </tr>";
                    echo "<tr class='t2'>
                        <td>Card Type</td>
                        <td>: ".$row->card_type."</td>
                        </tr>";
                    echo "<tr class='t1'>
                        <td>Card Tax</td>
                        <td>: ".$row->card_tax."</td>
                        </tr>";
                    echo "<tr class='t2'>
                        <td>Name on Card</td>
                        <td>: ".$row->name_on_card."</td>
                        </tr>";
                    echo "<tr class='t2'>
                        <td>Date</td>
                        <td>: ".date("d M,Y h:i:s",strtotime($row->card_cdate))."</td>
                        </tr>";
                    
                }
                ?>
                </table>
                <?php
            }
            else
            {
                echo "<tr class='t1'>
                        <td style='width: 135px'>Account No</td>
                        <td >: Not Found</td>
                        </tr>";
                    echo "<tr class='t2'>
                        <td>Card No</td>
                        <td>: Not Found</td>
                        </tr>";
                    echo "<tr class='t1'>
                        <td style='width: 135px'>Card PIN</td>
                        <td >: Not Found</td>
                        </tr>";
                    echo "<tr class='t2'>
                        <td>Card Exp. Date</td>
                        <td>: Not Found</td>
                        </tr>";
                    echo "<tr class='t1'>
                        <td style='width: 135px'>CVC Code</td>
                        <td >: Not Found</td>
                        </tr>";
                    echo "<tr class='t2'>
                        <td>Amount</td>
                        <td>: Not Found</td>
                        </tr>";
                    echo "<tr class='t1'>
                        <td>Max Limit</td>
                        <td>: Not Found</td>
                        </tr>";
                    echo "<tr class='t2'>
                        <td>Card Type</td>
                        <td>: Not Found</td>
                        </tr>";
                    echo "<tr class='t1'>
                        <td>Card Tax</td>
                        <td>: Not Found</td>
                        </tr>";
                    echo "<tr class='t2'>
                        <td>Name on Card</td>
                        <td>: Not Found</td>
                        </tr>";
                    echo "<tr class='t2'>
                        <td>Date</td>
                        <td>: Not Found</td>
                        </tr>";
            }   
        }
        ?>
<style>
th
{
    background: #dfdfdf;
    padding: 4px;
}
td
{
    padding: 4px;
    border-bottom: 1px dotted #970834;
}
.t1
{
    background: #dfdfdf;
}
</style>