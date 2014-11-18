<?php
    if(isset($card_req_detail))
    {
        ?>
        <table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;">           
            <?php
            $i=0;
            foreach($card_req_detail as $row)
            {
                $card_detail = $this->admin_account->get_credit_card_type_detail_by_cid($row->type);
                echo "<tr class='t1'>
                    <td style='width: 170px'>Card Type</td>
                    <td style='width: 551px'>: ".$card_detail[0]->name." - $".$card_detail[0]->limit." - ".$card_detail[0]->int_rate."%</td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>Annual Income</td>
                    <td>: ".$row->annual_income."</td>
                    </tr>";
                echo "<tr class='t1'>
                    <td>Annual Expenditures</td>
                    <td>: ".$row->annual_expe."</td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>Income Tax</td>
                    <td>: ".$row->income_tax."</td>
                    </tr>";
                echo "<tr class='t1'>
                    <td><b>Saving</b></td>
                    <td>: <b>".($row->annual_income - $row->annual_expe)."</b></td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>Status</td>
                    <td>: ".$row->status."</td>
                    </tr>";
                echo "<tr class='t1'>
                    <td>Date</td>
                    <td>: ".date("d M,Y h:i:s",strtotime($row->cdate))."</td>
                    </tr>";
                $card_status = $row->status;
                $link_pera = $row->id."-".str_replace('@',"%40",$row->uemail)."-".$row->type;
            }
        }
            ?>
            </table>
<?php
    if(isset($userid))
    {
        if(!isset($credit_card_detail))
        {
            if(isset($cheuqing_ac_detail))
            {
                ?>
                <h1>User Cheuqing Account Detail :</h1>
                <table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;">           
                <?php
                $i=0;
                foreach($cheuqing_ac_detail as $row)
                {
                    echo "<tr class='t1'>
                        <td style='width: 135px'>Account No</td>
                        <td >: ".$row->ac_no."</td>
                        </tr>";
                    echo "<tr class='t2'>
                        <td>Account Type</td>
                        <td>: ".$row->ac_type."</td>
                        </tr>";
                    echo "<tr class='t1'>
                        <td><b>A/c Balance</b></td>
                        <td>: <b>".$row->ac_bal."</b></td>
                        </tr>";
                    echo "<tr class='t2'>
                        <td>Date</td>
                        <td>: ".date("d M,Y h:i:s",strtotime($row->ac_cdate))."</td>
                        </tr>";
                    echo "<tr class='t1'>
                        <td>Status</td>
                        <td>: ".$row->ac_status."</td>
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
            
            if(isset($debit_vm_card_detail))
            {
                ?>
                <h1>User Debit Virtual Money Card Detail :</h1>
                <table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;">           
                <?php
                $i=0;
                foreach($debit_vm_card_detail as $row)
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
                        <td><b>Balance</b></td>
                        <td>: <b>".$row->amount."</b></td>
                        </tr>";
                    echo "<tr class='t2'>
                        <td>Card Type</td>
                        <td>: ".$row->card_type."</td>
                        </tr>";
                    echo "<tr class='t1'>
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
            ?>
            <br />
            <center><a href="<?php echo base_url();?>generate_credit_card/<?php echo $link_pera;?>.html"><h2>Approve Request, And Generate Card No.</h2></a></center>
            <?php
        }
        else
        {
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