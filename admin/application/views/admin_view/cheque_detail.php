
<?php
    if(isset($cheque_detail))
    {
        if(count($cheque_detail)==1)
        {
            ?>
            <h1>Cheque Detail :</h1>
            <table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;">           
            <?php
            $i=0;
            foreach($cheque_detail as $row)
            {
                if($row->status != "processing")
                    $ac_status = 1;
                else 
                    $ac_status = 0;
                $doc_url = $row->attached_file;
                
                echo "<tr class='t1'>
                    <td style='width: 120px'>Account Status</td>
                    <td>".$row->status;
                    if($ac_status==0)
                    {
                        echo " <a href='".base_url()."approve-cheque/".$row->chq_no."-".$row->from_ac.".html'>Approve</a> |";
                        echo " <a href='".base_url()."disapprove-cheque/".$row->chq_no."-".$row->from_ac.".html'>Disapprove</a>";
                    }
                echo "</td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>Email</td>
                    <td>".$row->uemail."</td>
                    </tr>";
                echo "<tr class='t1'>
                    <td>From</td>
                    <td>".$row->from_ac."</td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>To</td>
                    <td>".$row->to_ac."</td>
                    </tr>";
                echo "<tr class='t1'>
                    <td>Req. Date</td>
                    <td>".date("d M,Y h:i:s",strtotime($row->cdate))."</td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>Bank Detail</td>
                    <td>".$row->bank_detail."</td>
                    </tr>";
                echo "<tr class='t1'>
                    <td>Amount</td>
                    <td>".$row->amount."</td>
                    </tr>";    
                echo "<tr class='t2'>
                    <td>Cheque Date</td>
                    <td>".$row->chq_date."</td>
                    </tr>";
                echo "<tr class='t1'>
                    <td>Document File</td>
                    <td><a href='http://cscbanking.com/upload/cheques/".$row->attached_file."' target='_blank'>Attached Document Copy</a></td>
                    </tr>";
            }
            ?>
            </table>
            <br />
            <span style="font-family: Jura-Regular;">Attached Document Copy</span><br />
            <?php
                    echo "<img src='http://cscbanking.com/upload/cheques/".$doc_url."' width='730px' style='border: 2px solid #dfdfdf;' />";
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