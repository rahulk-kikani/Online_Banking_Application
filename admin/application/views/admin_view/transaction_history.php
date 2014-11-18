<table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;">
    <tr>
        <th>Id</th>
        <th>Date</th>
        <th>Detail</th>
        <th>A/c [From]</th>
        <th>A/c [to]</th>
        <th>Amount</th>
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
                echo "<td>".$i."</td>";
                echo "<td width=100px>".date("d M,Y h:i:s",strtotime($row->trans_date))."</td>";
                echo "<td width=200px>$row->description</td>";
                if(strlen($row->ac_from) == 13)
                    echo "<td>435$row->ac_from</td>";    
                else
                    echo "<td>$row->ac_from</td>";     
                if(strlen($row->ac_to) == 13)
                    echo "<td>435$row->ac_to</td>";
                else
                    echo "<td>$row->ac_to</td>"; 
                
                echo "<td align='center'>".(double)$row->amount."</td>"; 
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