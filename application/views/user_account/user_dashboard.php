<?php
    if(isset($userid))
    {
        ?>
            <h1>User Profile Detail : <?php echo $user_profile_detail[0]->fname.", ".$user_profile_detail[0]->lname;?></h1>
        <?php
        if(isset($user_login_detail))
        {
            ?>
            <table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;">           
            <?php
            $i=0;
            foreach($user_login_detail as $row)
            {
                echo "<tr class='t1'>
                    <td style='width: 120px'>Username</td>
                    <td style='width: 611px'>: ".$row->uemail."</td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>Password</td>
                    <td>: ************ </td>
                    </tr>";
                echo "<tr class='t1'>
                    <td>Status</td>
                    <td>: ".$row->status."</td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>Date</td>
                    <td>: ".date("d M,Y h:i:s",strtotime($row->cdate))."</td>
                    </tr>";
                echo "<tr class='t1'>
                    <td>Login Counter</td>
                    <td>: ".$row->counter."</td>
                    </tr>";
            }
            ?>
            </table>
            <?php
        }
        else
        {
            echo "<tr class='t1'>
                    <td style='width: 120px'>Username</td>
                    <td style='width: 600px'>: Not Found</td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>Password</td>
                    <td>: Not Found</td>
                    </tr>";
                echo "<tr class='t1'>
                    <td>Status</td>
                    <td>: Not Found</td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>Date</td>
                    <td>: Not Found</td>
                    </tr>";
                echo "<tr class='t1'>
                    <td>Login Counter</td>
                    <td>: Not Found</td>
                    </tr>";
        }
        
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
                    <td>Account Balance</td>
                    <td>: ".$row->ac_bal."</td>
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
                    <td style='width: 135px'>Card PIN</td>
                    <td >: ****** </td>
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
    else
    {
        echo "Internal server error. please contact administrator.";
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