<table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;">
    <tr>
        <th>No.</th>
        <th>Cheque No</th>
        <th>A/c No</th>
        <th>Bank</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Cheque Date</th>
        <th>Entry Date</th>
    </tr>
<?php
    if(isset($cheques_detail))
    {
        if(count($cheques_detail)>0)
        {
            $i=0;
            foreach($cheques_detail as $row)
            {
                $i++;
                if($i%2==0)
                    echo "<tr class='t1'>";
                else 
                    echo "<tr class='t2'>";
                echo "<td>".$i."</td>";
                echo "<td>".$row->chq_no."</td>";
                echo "<td>$row->from_ac</td>";                
                
                    echo "<td>".$row->bank_detail."</td>";
                    echo "<td>$".$row->amount."</td>";
                    echo "<td>$row->status</td>";
               
                echo "<td>".date("d M,Y",strtotime($row->chq_date))."</td>";
                echo "<td>".date("d M,Y h:i:s",strtotime($row->cdate))."</td>";
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