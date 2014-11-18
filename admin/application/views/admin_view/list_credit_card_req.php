<table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;">
    <tr>
        <th>No.</th>
        <th>Email</th>
        <th>Credit Card Type</th>
        <th>Annual Saving</th>
        <th>Income Tax</th>
        <th>Status</th>
        <th>Entry Date</th>
        <th>View</th>
    </tr>
<?php
    if(isset($cc_req_detail))
    {
        if(count($cc_req_detail)>0)
        {
            $i=0;
            foreach($cc_req_detail as $row)
            {
                $card_detail = $this->admin_account->get_credit_card_type_detail_by_cid($row->type);
                $i++;
                if($i%2==0)
                    echo "<tr class='t1'>";
                else 
                    echo "<tr class='t2'>";
                echo "<td>".$i."</td>";
                echo "<td>".$row->uemail."</td>";
                echo "<td>".$card_detail[0]->name." - $".$card_detail[0]->limit."</td>";
                echo "<td style='text-align: center;'>".($row->annual_income-$row->annual_expe)."</td>";  
                echo "<td style='text-align: center;'>$row->income_tax</td>";
                echo "<td style='text-align: center;'>".$row->status."</td>";                  
                echo "<td style='text-align: center;'>".date("d M,Y h:i:s",strtotime($row->cdate))."</td>";
                echo "<td style='text-align: center;'><a href='".base_url()."credit_card_detail/".str_replace('@',"%40",$row->uemail).".html'>View Detail</a></td>";
                echo "</tr>";
            }
        }
        else
            echo "<tr><td colspan=8>No Credit card request found</td></tr>";
    }
    else
            echo "<tr><td colspan=8>No Credit card request found</td></tr>";
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