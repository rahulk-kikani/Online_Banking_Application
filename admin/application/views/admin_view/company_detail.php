
<?php
    if(isset($company_detail))
    {
        if(count($company_detail)==1)
        {
            ?>
            <table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;">           
            <?php
            $i=0;
            foreach($company_detail as $row)
            {
                $doc_url = $row->doc_file;
                echo "<tr class='t1'>
                    <td>Email</td>
                    <td>".$row->uemail."</td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>Account No.</td>
                    <td>".$row->ac_no."</td>
                    </tr>";
                echo "<tr class='t1'>
                    <td>Account Balance</td>
                    <td>".$row->ac_bal."</td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>First Name</td>
                    <td>".$row->fname."</td>
                    </tr>";
                echo "<tr class='t1'>
                    <td>Last Name</td>
                    <td>".$row->lname."</td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>Req. Date</td>
                    <td>".date("d M,Y h:i:s",strtotime($row->cdate))."</td>
                    </tr>";
                echo "<tr class='t1'>
                    <td>Address</td>
                    <td>".$row->address."</td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>City, State</td>
                    <td>".$row->city.", ".$row->state."</td>
                    </tr>";    
                echo "<tr class='t1'>
                    <td>Zip Code</td>
                    <td>".$row->zip_code."</td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>Mobile No.</td>
                    <td>".$row->mno."</td>
                    </tr>";    
                echo "<tr class='t1'>
                    <td>Document ID</td>
                    <td>".$row->doc_id."</td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>Document File</td>
                    <td><a href='http://localhost/online_banking/upload/".$row->doc_file."' target='_blank'>Attached Document Copy</a></td>
                    </tr>";
            }
            ?>
            </table>
            <br />
            <span style="font-family: Jura-Regular;">Attached Document Copy</span><br />
            <?php
                    echo "<img src='http://localhost/online_banking/upload/".$doc_url."' width='730px' style='border: 2px solid #dfdfdf;' />";
            ?>
            
            <?php
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