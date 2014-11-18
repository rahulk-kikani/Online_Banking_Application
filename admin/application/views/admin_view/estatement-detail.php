<?php
    if(isset($estatement_detail))
    {
?>
        <table style="float: left;">
            <tr>
                <td>Starting Date</td>
                <td>: <?php echo date("d M,Y",strtotime($sdate));?></td>
                <td></td>
                <td>Closing Date</td>
                <td>: <?php echo date("d M,Y",strtotime($edate));?></td>
                <td></td>
                <td>Opening Balance</td>
                <td>: <?php
                
                    if($pre_estatement_detail!=0)
                        echo $pre_estatement_detail[0]->amount;
                    else
                        echo 0;
                ?></td>
            </tr>
            <tr>
                <td>Duation</td>
                <td>: 30 Days</td>
                <td></td>
                <td>Interest Rate</td>
                <td>: <?php
                
                    if(isset($credit_detail))
                        echo $credit_detail[0]->card_tax;
                    else
                        echo "NA";
                ?></td>
                <td></td>
                <td>Owned Money</td>
                <td>: <?php echo $estatement_detail[0]->amount;?></td>
            </tr>
            <tr>
                <td>Statement Id</td>
                <td>: <?php echo $estatement_detail[0]->estateid;?></td>
                <td></td>
                <td>Issued Date</td>
                <td>: <?php echo date("d M,Y",strtotime($estatement_detail[0]->cdate));?></td>
                <td></td>
                <td>Interest</td>
                <td>: <?php echo $estatement_detail[0]->tax;?></td>
            </tr>
            <tr>
                <td>Card No.</td>
                <td>: <?php echo $ac_no;?></td>
                <td></td>
                <td>Card Limit</td>
                <td>: $<?php echo $credit_detail[0]->max_limit;?></td>
                <td></td>
                <td>Closing Balance</td>
                <td>: <?php echo ($estatement_detail[0]->amount+$estatement_detail[0]->tax);?></td>
            </tr>
        </table>
        <?php
}?>
<br />
<br />
<table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;">
    <tr>
        <th>Date</th>
        <th>Detail</th>
        <th>Withdraw($)</th>
        <th>Deposit($)</th>
        <th>Current Balance($)</th>
    </tr>
<?php
    if(isset($transaction_history))
    {
        if(count($transaction_history)>0)
        {
            $i=0;
            foreach($transaction_history as $row)
            {
                $i++;
                if($i%2==0)
                    echo "<tr class='t1'>";
                else 
                    echo "<tr class='t2'>";
                
                echo "<td>".date("d M,Y h:i:s",strtotime($row->trans_date))."</td>";
                echo "<td>$row->description</td>";                
                if($row->ac_from == $ac_no)
                {
                    echo "<td align='center'>- $row->amount</td>";
                    echo "<td></td>";
                    echo "<td>$row->bal_from</td>";
                }
                if($row->ac_to == $ac_no)
                {
                    echo "<td></td>";
                    echo "<td  align='center'>+ $row->amount</td>";
                    echo "<td>$row->bal_to</td>";
                }
                echo "</tr>";
            }
        }
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