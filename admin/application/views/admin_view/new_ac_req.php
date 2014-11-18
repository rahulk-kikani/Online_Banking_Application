
            <table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;">
                <tr>
                    <th>No.</th>
                    <th style="text-align: left;">Email</th>
                    <th style="text-align: left;">Date</th>
                    <th style="text-align: left;">Name</th>
                    <th>View</th>
                </tr>            
<?php
    if(isset($all_ac))
    {
        if(count($all_ac)>0)
        {
            
            $i=0;
            foreach($all_ac as $row)
            {
                $i++;
                if($i%2==0)
                    echo "<tr class='t1'>";
                else
                    echo "<tr class='t2'>";
                echo "<td style='text-align:center'>".$i."</td>";
                echo "<td>".$row->uemail."</td>";
                echo "<td>".date("d M,Y h:i:s",strtotime($row->cdate))."</td>";
                echo "<td>".$row->fname."</td>";
                echo "<td style='text-align: center;'><a href='".base_url()."user-detail/".str_replace('@',"%40",$row->uemail).".html'>View Detail</a></td>";
            }
            
        }
        else
        {
            echo "<tr><td colspan=5>Sorry, No request found.</td>";
        }
    }
    else
    {
        echo "<tr><td colspan=5>Sorry, No request found.1</td>";
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