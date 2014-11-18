<h1>Stock Exchange Analysis</h1>
        <table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;margin-top: 20px;">
    <tr>
        <th>No.</th>
        <th>CODE</th>
        <th>Bought Stock</th>
        <th>AVG. Price</th>
        <th>Sold Stock</th>
        <th>AVG. Price</th>
        <th>Left Stock</th>
        <th>Current Price</th>
        <th>Loss/Benifit</th>
        <th>Future</th>
    </tr>
<?php
    if(isset($stock_analysis))
    {
        if($stock_analysis != 0)
        {
            $i=0;
            foreach($stock_analysis as $row)
            {
                $sv_buy = $this->user_account->get_stock_volume_by_code_ac_type($row->code,$ac_no,"Buy");
                $sa_price_buy = $this->user_account->get_stock_avg_price_by_code_ac_type($row->code,$ac_no,"Buy");
                $sv_sell = $this->user_account->get_stock_volume_by_code_ac_type($row->code,$ac_no,"Sell");
                $sa_price_sell = $this->user_account->get_stock_avg_price_by_code_ac_type($row->code,$ac_no,"Sell");
                $left_volume = $this->user_account->get_stock_volume_by_code_ac($row->code,$ac_no);
                $cur_price = $this->user_account->get_selling_stock_price_by_code($row->code);
                
                $total_benefits = $sa_price_sell - $sa_price_buy + ($left_volume*$cur_price);
                $i++;
                if($i%2==0)
                    echo "<tr class='t1'>";
                else 
                    echo "<tr class='t2'>";
                echo "<td style='text-align: center;'>".$i."</td>";
                echo "<td style='text-align: center;'>".$row->code."</td>";
                echo "<td style='text-align: center;'>".$sv_buy."</td>";
                echo "<td style='text-align: center;'>$".$sa_price_buy."</td>";
                echo "<td style='text-align: center;'>".$sv_sell."</td>";
                echo "<td style='text-align: center;'>$".$sa_price_sell."</td>";                
                echo "<td style='text-align: center;'>".$left_volume."</td>";
                echo "<td style='text-align: center;'>".$cur_price."</td>";
                echo "<td style='text-align: center;'>".$total_benefits."</td>";
                if($total_benefits > 0)
                {
                    echo "<td style='text-align: center;'><div class='s_msg'>Benefits</div></td>";
                }
                else
                {
                    echo "<td style='text-align: center;'><div class='e_msg'>Loss</div></td>";
                }
                echo "</tr>";
            }
        }
                else
            echo "<tr><td colspan=10>Sorry, No record found.</td></tr>";
    }
?>
</table>
        <h1>Bought Stock</h1>
        <table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;margin-top: 20px;">
    <tr>
        <th>No.</th>
        <th>Order ID</th>
        <th>CODE</th>
        <th>Buying Price</th>
        <th>Volume</th>
        <th>Sell</th>
        <th>Date</th>
    </tr>
<?php
    if(isset($bought_stock))
    {
        if($bought_stock != 0)
        {
            $i=0;
            foreach($bought_stock as $row)
            {
                $i++;
                if($i%2==0)
                    echo "<tr class='t1'>";
                else 
                    echo "<tr class='t2'>";
                echo "<td style='text-align: center;'>".$i."</td>";
                echo "<td style='text-align: center;'>".$row->id."</td>";
                echo "<td style='text-align: center;'>".$row->code."</td>";
                echo "<td style='text-align: center;'>$".$row->price."</td>";                
                echo "<td style='text-align: center;'>".$row->amount."</td>";
                echo "<td style='text-align: center;'><a href='".base_url()."user/stock-exchange.html?action=sell&stockid=".$row->code."'>Sell</a></td>";
                echo "<td style='text-align: center;'>".date("d M,Y H:i:s",strtotime($row->cdate))."</td>";
                echo "</tr>";
            }
        }
                else
            echo "<tr><td colspan=7>Sorry, No record found.</td></tr>";
    }
?>
</table>
        <h1>Sold Stock</h1>
        <table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;margin-top: 20px;">
        <tr>
            <th>No.</th>
            <th>Order ID</th>
            <th>CODE</th>
            <th>Buying Price</th>
            <th>Volume</th>
            <th>Date</th>
        </tr>
<?php
    if(isset($sold_stock))
    {
        if($sold_stock != 0)
        {
            $i=0;
            foreach($sold_stock as $row)
            {
                $i++;
                if($i%2==0)
                    echo "<tr class='t1'>";
                else 
                    echo "<tr class='t2'>";
                echo "<td style='text-align: center;'>".$i."</td>";
                echo "<td style='text-align: center;'>".$row->id."</td>";
                echo "<td style='text-align: center;'>".$row->code."</td>";
                echo "<td style='text-align: center;'>$".$row->price."</td>";                
                echo "<td style='text-align: center;'>".$row->amount."</td>";
                echo "<td style='text-align: center;'>".date("d M,Y H:i:s",strtotime($row->cdate))."</td>";
                echo "</tr>";
            }
        }
        else
            echo "<tr><td colspan=6>Sorry, No record found.</td></tr>";
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