<table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;">
    <tr>
        <th>No.</th>
        <th>Bill No</th>
        <th>A/c No</th>
        <th>Company A/c No</th>
        <th>Company</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Entry Date</th>
    </tr>
<?php
    if(isset($billing_detail))
    {
        if(count($billing_detail)>0)
        {
            $i=0;
            foreach($billing_detail as $row)
            {
                $i++;
                if($i%2==0)
                    echo "<tr class='t1'>";
                else 
                    echo "<tr class='t2'>";
                echo "<td style='text-align: center;'>".$i."</td>";
                echo "<td style='text-align: center;'>".$row->bill_no."</td>";
                echo "<td style='text-align: center;'>".$row->ac_no."</td>";
                echo "<td style='text-align: center;'>$row->company_no</td>";                
                    echo "<td style='text-align: center;'>".$this->user_account->get_compnay_name_by_ac_no($row->company_no)."</td>";
                    echo "<td style='text-align: center;'>$".$row->bill_amount."</td>";
                    echo "<td style='text-align: center;'>$row->status</td>";
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