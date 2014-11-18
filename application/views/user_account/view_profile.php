
<?php
    if(isset($ac_data))
    {
        if(count($ac_data)==1)
        {
            ?>
            <table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;">           
            <?php
            $i=0;
            foreach($ac_data as $row)
            {
                echo "<tr class='t2'>
                    <td style='width: 120px'>Account Status</td>
                    <td> : ".$row->status;
                echo "</td>
                    </tr>";
                echo "<tr class='t1'>
                    <td>Email</td>
                    <td> : ".$row->uemail."</td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>First Name</td>
                    <td> : ".$row->fname."</td>
                    </tr>";
                echo "<tr class='t1'>
                    <td>Last Name</td>
                    <td> : ".$row->lname."</td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>Req. Date</td>
                    <td> : ".date("d M,Y h:i:s",strtotime($row->cdate))."</td>
                    </tr>";
                echo "<tr class='t1'>
                    <td>Address</td>
                    <td> : ".$row->address."</td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>City, State</td>
                    <td> : ".$row->city.", ".$row->state."</td>
                    </tr>";    
                echo "<tr class='t1'>
                    <td>Zip Code</td>
                    <td> : ".$row->zip_code."</td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>Mobile No.</td>
                    <td> : ".$row->mno."</td>
                    </tr>";    
                echo "<tr class='t1'>
                    <td>Document ID</td>
                    <td> : ".$row->doc_id."</td>
                    </tr>";
                    $doc_url = $row->doc_file;
            }
            ?>
            </table>
            <br />
            <span style="font-family: Jura-Regular;">Attached Document Copy</span><br /><br />
            <?php
                echo "<img src='http://cscbanking.com/upload/".$doc_url."' width='730px' style='border: 2px solid #dfdfdf;' />";
        }
        else
        {
            echo "Sorry, No request found.";
        }
    }
    else
    {
        echo "Internal server error. please contact administrator.";
    }
?>
<style>
th
{
    background: #dfdfdf;
    padding: 4px;
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