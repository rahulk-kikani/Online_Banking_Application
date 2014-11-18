<?php
    if(isset($credit_detail) && count($credit_detail) == 1)
    {
        ?>
        <table style="float: left;">
            <tr>
                <td>Credit Limit</td>
                <td>: <?php echo $max_limit = $credit_detail[0]->max_limit?></td>
                <td></td>
                <td>Days Limit</td>
                <td>: 30 Days</td>
            </tr>
            <tr>
                <td>
                    <?php
                        if($credit_detail[0]->amount < 0)
                            echo "Borrowed Money";
                        else
                            echo "Account Balance";
                    ?>
                </td>
                <td>: <?php
                        echo $credit_detail[0]->amount;
                    ?></td>
                <td></td>
                <td>Issued Date</td>
                <td>: <?php echo date("d M,Y",strtotime($credit_detail[0]->card_cdate));
                
                $card_cdate =$credit_detail[0]->card_cdate;
                ?></td>
            </tr>
            <tr>
                <td>Total Limit</td>
                <td>: 
                    <?php
                        echo $credit_detail[0]->max_limit + $credit_detail[0]->amount;
                    ?>
                </td>
                <td></td>
                <td>Last Payment Date</td>
                <td>: <?php
                        echo $last_payment_date =$this->user_account->get_last_payment_date($credit_detail[0]->card_no,"Last-Payment-Date");
                        
                        $temp = date("Y/m/d",strtotime($last_payment_date));
                        $last_payment_date = strtotime($temp);
                    ?></td>
            </tr>
            <tr>
                <td>Total E-Statement</td>
                <td>: 
                    <?php  echo $total_e_statement = $this->user_account->count_estatement($credit_detail[0]->card_no);?>
                </td>
                <td></td>
                <td>Due Payment</td>
                <td>: <?php 
                
                        $xx = $this->user_account->get_last_estatement($ac_no);
                        if(count($xx)==1)
                            echo ($xx[0]->amount+$xx[0]->tax);
                        else
                            echo "---";
                ?></td>
            </tr>
        </table>
        <?php
    }
    else
        echo "No credit card Found";
?>
<br />
<br />
<div class="clear_all"></div>
<table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular; margin-top: 20px;">
    <tr>
        <th>No.</th>
        <th>Statement Id</th>
        <th>Start Date</th>
        <th>End Date</th>
        <th>Owned Amount</th>
        <th>Tax</th>
        <th>Date</th>
        <th>View</th>
    </tr>
<?php

        if(isset($statement_history) && $statement_history != "")
        {
            $i = 0;
            foreach($statement_history as $row)
            {
                
                if($i%2==0)
                    echo "<tr class='t2'>";
                else 
                    echo "<tr class='t1'>";
                echo "<td align='center'>".($i+1)."</td>";
                echo "<td align='center'>".$row->estateid."</td>";
                echo "<td align='center'>".date("d M,Y",strtotime($row->from))."</td>";
                echo "<td align='center'>".date("d M,Y",strtotime($row->to))."</td>";
                echo "<td align='center'>".$row->amount."</td>";
                echo "<td align='center'>".$row->tax."</td>";
                echo "<td align='center'>".date("d M,Y H:i:s",strtotime($row->cdate))."</td>";
                echo "<td align='center'><a href='".base_url()."user/view-estatement.html/?card_no=".$row->card_no."&dstart=".strtotime($row->from)."&dend=".strtotime($row->to)."'>View</a></td>";
                $i++;
            }   
        }
        else
            echo "<tr><td colspan=8>e-Statment not found.</td></tr>";
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