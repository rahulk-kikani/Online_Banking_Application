Welcome to Investment Account
<br />
<br />
<?php
        if(isset($investment_ac_detail) && count($investment_ac_detail) !=0)
        {
            ?>
            <table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;">           
            <?php
            $i=0;
            foreach($investment_ac_detail as $row)
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
                $ac_no = $row->ac_no;
            }
            echo "</table>";
            
            if($this->user_account->check_fixed_plan_exist($ac_no,"running"))
            {
                $all_fixed_detail = $this->user_account->get_all_fixed_plan($ac_no,"");
                $data['all_fixed_detail'] = $all_fixed_detail;
                ?>
                <h2>Investment History</h2>
                <table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;margin-top: 20px;">
                    <tr>
                        <th>No.</th>
                        <th>Issue Date</th>
                        <th>Amount</th>
                        <th>End Date</th>
                        <th>Expected Amount</th>
                        <th>Rate</th>
                        <th>Duration</th>
                        <th>Status</th>
                    </tr>
                <?php
                            $i=0;
                            foreach($all_fixed_detail as $row)
                            {
                                $i++;
                                if($i%2==0)
                                    echo "<tr class='t1'>";
                                else 
                                    echo "<tr class='t2'>";
                                echo "<td style='text-align: center;'>".$i."</td>";
                                echo "<td style='text-align: center;'>".date('d M,Y',strtotime($row->issue_date))."</td>";
                                echo "<td style='text-align: center;'>$".$row->amount."</td>";
                                echo "<td style='text-align: center;'>".date('d M,Y',strtotime($row->last_date))."</td>";                
                                echo "<td style='text-align: center;'>$".($row->amount*($row->rate/100))."</td>";
                                echo "<td style='text-align: center;'>".$row->rate."%</td>";
                                echo "<td style='text-align: center;'>2 Years</td>";
                                echo "<td style='text-align: center;'>".$row->status."</td>";
                                echo "</tr>";
                            }
                ?>
                </table>
                <?php
            }
            else
            {
                ?>
                <br />
                <br /><h2>Fixed Deposite Investment</h2><br />
                Detail : Min Amount $100 for 2Year(Assume. = 2Days). After duration Money will be dubled.
                <br /><br />
                If you want to invest money <a href="<?php echo base_url();?>user/invest-fixed-money.html">CLICK HERE</a>.
                <?php
            }
        }
        else
        {
            echo "Sorry, your investment account is not active. Please Active Now.<br/><br/>";
            echo "<a href='".base_url()."user/active-investment-account.html'>CLICK HERE</a>";
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