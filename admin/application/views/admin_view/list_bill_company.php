<table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;">
    <tr>
        <th>No.</th>
        <th>Nmae</th>
        <th>A/c No</th>
        <th>Balance</th>
        <th>Entry Date</th>
        <th>View</th>
    </tr>
<?php
    if(isset($company_detail))
    {
        if(count($company_detail)>0)
        {
            $i=0;
            foreach($company_detail as $row)
            {
                $i++;
                if($i%2==0)
                    echo "<tr class='t1'>";
                else 
                    echo "<tr class='t2'>";
                echo "<td>".$i."</td>";
                echo "<td>".$row->fname.", ".$row->lname."</td>";
                echo "<td>".$row->ac_no."</td>";
                echo "<td style='text-align: center;'>$row->ac_bal</td>";                
                echo "<td style='text-align: center;'>".date("d M,Y h:i:s",strtotime($row->cdate))."</td>";
                echo "<td style='text-align: center;'><a href='".base_url()."company_detail/".$row->ac_no.".html'>View Detail</a></td>";
                echo "</tr>";
            }
        }
        else
            echo "<tr><td colspan=6>No Billing company detail found</td></tr>";
    }
    else
            echo "<tr><td colspan=6>No Billing company detail found</td></tr>";
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