<?php
                $all_fixed_detail = $this->admin_account->get_all_fixed_plan();
                ?>
                <table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;margin-top: 20px;">
                    <tr>
                        <th>No.</th>
                        <th>Issue Date</th>
                        <th>Amount</th>
                        <th>End Date</th>
                        <th>Expected Amount</th>
                        <th>Rate</th>
                        <th>Duration</th>
                        <th>Status</th>
                    </tr>
                <?php
                            $i=0;
                            foreach($all_fixed_detail as $row)
                            {
                                $i++;
                                if($i%2==0)
                                    echo "<tr class='t1'>";
                                else 
                                    echo "<tr class='t2'>";
                                echo "<td style='text-align: center;'>".$i."</td>";
                                echo "<td style='text-align: center;'>".date('d M,Y',strtotime($row->issue_date))."</td>";
                                echo "<td style='text-align: center;'>$".$row->amount."</td>";
                                echo "<td style='text-align: center;'>".date('d M,Y',strtotime($row->last_date))."</td>";                
                                echo "<td style='text-align: center;'>$".($row->amount*($row->rate/100))."</td>";
                                echo "<td style='text-align: center;'>".$row->rate."%</td>";
                                echo "<td style='text-align: center;'>2 Years</td>";
                                echo "<td style='text-align: center;'>".$row->status."</td>";
                                echo "</tr>";
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