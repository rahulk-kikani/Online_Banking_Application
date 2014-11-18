<?php
    if(isset($credit_detail) && count($credit_detail)==1)
    {
        ?>
        <table>
            <tr>
                <td>Credit Limit</td>
                <td>: <?php echo $credit_detail[0]->max_limit?></td>
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
            </tr>
            <tr>
                <td>Total Limit</td>
                <td>: 
                    <?php
                        echo $credit_detail[0]->max_limit + $credit_detail[0]->amount;
                    ?>
                </td>
            </tr>
        </table>
        <?php
    }
?>
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
        else
        echo "No record found....";
    }
    else
        echo "System Error: Variable not set";
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