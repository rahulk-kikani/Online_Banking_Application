<form class="product_form" action="" name="ac_history_form" id="reg_form" method="post">
<table>
    <tr>
        <td>Select Accounts :</td>
        <td>
            <select name="ac_no">
                <?php
                    if(isset($ac_detail))
                    {
                        foreach($ac_detail as $row)
                        {
                            if($row->ac_type == 'cheuqing')
                            {
                                echo "<option value='$row->ac_no'>$row->ac_no - Cheuqing Account - $$row->ac_bal</option>";
                            }
                            if($row->ac_type == 'investment')
                            {
                                echo "<option value='$row->ac_no'>$row->ac_no - Investment Account - $$row->ac_bal</option>";
                            }
                        }
                            
                    }
                    if(isset($vm_detail))
                    {
                        foreach($vm_detail as $row)
                        {
                                echo "<option value='$row->card_no'>453$row->card_no - Virtual Money Account - $$row->amount</option>";
                            
                        }
                            
                    }
                ?>
            </select>
        </td>
        <td>
            <input type="submit" name="submit" value="" id="submit" class="submit_button" />
        </td>
    </tr>
</table>
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