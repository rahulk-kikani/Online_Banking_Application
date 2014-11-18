Welcome to Stock Center.....<br />
<div class="clear_all"></div>
<table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;margin-top: 20px;">
    <tr>
        <th>No.</th>
        <th>CODE</th>
        <th>Name</th>
        <th>Selling Price</th>
        <th>Buying Price</th>
        <th>Amount</th>
        <th>BUY</th>
        <th>SELL</th>
    </tr>
<?php
    if(isset($stock_detail))
    {
        if($stock_detail != 0)
        {
            $i=0;
            foreach($stock_detail as $row)
            {
                $i++;
                if($i%2==0)
                    echo "<tr class='t1'>";
                else 
                    echo "<tr class='t2'>";
                echo "<td style='text-align: center;'>".$i."</td>";
                echo "<td style='text-align: center;'>".$row->code."</td>";
                echo "<td style='text-align: center;'>".$row->name."</td>";
                echo "<td style='text-align: center;'>$".$row->sales_price."</td>";                
                echo "<td style='text-align: center;'>$".$row->buy_price."</td>";
                echo "<td style='text-align: center;'>".$row->total_no."</td>";
                echo "<td style='text-align: center;'><a href='".base_url()."user/stock-exchange.html?action=buy&stockid=".$row->code."'>Buy</a></td>";
                echo "<td style='text-align: center;'><a href='".base_url()."user/stock-exchange.html?action=sell&stockid=".$row->code."'>Sell</a></td>";
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