<table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;">
    <tr>
        <th>No.</th>
        <th>Description</th>
        <th>Date</th>
    </tr>
<?php
    if(isset($login_detail))
    {
        if(count($login_detail)>0)
        {
            $i=0;
            foreach($login_detail as $row)
            {
                $i++;
                if($i%2==0)
                    echo "<tr class='t1'>";
                else 
                    echo "<tr class='t2'>";
                echo "<td style='text-align: center;width: 30px'>".$i."</td>";
                echo "<td style='text-align: center;'>".$row->description."</td>";
                echo "<td style='text-align: center;'>".date("d M,Y h:i:s",strtotime($row->ldate))."</td>";
                echo "</tr>";
            }
        }
        else
        {
            echo "<tr><td colspan=3>No Record Found</td></tr>";
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