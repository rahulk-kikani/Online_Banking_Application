<?php
    if(isset($credit_detail))
    {
        ?>
        <table style="float: left;">
            <tr>
                <td>Credit Limit</td>
                <td>: <?php echo $max_limit = $credit_detail[0]->max_limit?></td>
                <td></td>
                <td>Days Limit</td>
                <td>: 30 Days</td>
            </tr>
            <tr>
                <td>
                    <?php
                        if($credit_detail[0]->amount < 0)
                            echo "Borrowed Money";
                        else
                            echo "Account Balance";
                    ?>
                </td>
                <td>: <?php
                        echo $credit_detail[0]->amount;
                    ?></td>
                <td></td>
                <td>Issued Date</td>
                <td>: <?php echo date("d M,Y",strtotime($credit_detail[0]->card_cdate));
                
                $card_cdate =$credit_detail[0]->card_cdate;
                ?></td>
            </tr>
            <tr>
                <td>Total Limit</td>
                <td>: 
                    <?php
                        echo $credit_detail[0]->max_limit + $credit_detail[0]->amount;
                    ?>
                </td>
                <td></td>
                <td>Last Payment Date</td>
                <td>: <?php
                        echo $last_payment_date =$this->admin_account->get_last_payment_date($credit_detail[0]->card_no,"Last-Payment-Date");
                        
                        $temp = date("Y/m/d",strtotime($last_payment_date));
                        $last_payment_date = strtotime($temp);
                    ?></td>
            </tr>
            <tr>
                <td>Total E-Statement</td>
                <td>: 
                    <?php  echo $total_e_statement = $this->admin_account->count_estatement($credit_detail[0]->card_no);?>
                </td>
                <td></td>
                <td>Due Payment</td>
                <td>: <?php $xx = $this->admin_account->get_last_estatement($ac_no);
                        echo ($xx[0]->amount+$xx[0]->tax);
                ?></td>
            </tr>
        </table>
        <?php
    }
?>
<br />
<br />
<table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;">
    <tr>
        <th>No.</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>e-Statement Status</th>
    </tr>
<?php
    if($total_e_statement == 0)
    {
        $start_d = date("Y/m/d",strtotime($card_cdate));
    }
    else
    {
        $e3 =$this->admin_account->get_last3_estatement($ac_no);
        $start_d = date("Y/m/d",strtotime($e3[$total_e_statement-1]->from));
    }
    $n = 12;
            $i=0;
            $start_d = strtotime($start_d);
            for($i=0;$i<$n;$i++)
            {
                $end_d = $start_d + (30*86400);
                if($i%2==0)
                    echo "<tr class='t2'>";
                else 
                    echo "<tr class='t1'>";
                echo "<td align='center'>".($i+1)."</td>";
                echo "<td align='center'>".date("d M,Y",$start_d)."</td>";
                echo "<td align='center'>".date("d M,Y",$end_d)."</td>";
                
                if($this->admin_account->check_estatement($ac_no,$start_d,$end_d))
                {
                    echo "<td align='center'>Exist</td>";
                }
                else if(intval($end_d/1000) == intval($last_payment_date/1000))
                {
                    echo "<td align='center'><a href='".base_url()."calc-credit-inr/".$ac_no.".html?gen_estate=1&dstart=".$start_d."&dend=".$end_d."'>Time to Generate</a></td>";
                }
                else
                {
                    echo "<td align='center'>Pending</td>";
                }
                echo "</tr>";
                $start_d = $end_d + 86400;
            }
?>
</table>
<style>
th
{
    background: #dfdfdf;
    padding: 4px;
    border-bottom: 1px dotted #970834;
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