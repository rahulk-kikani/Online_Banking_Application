<?php
    if(isset($action) && isset($stockid))
    {
        if($action == "buy")
        {
            ?>
            <form class="product_form" action="" name="ac_to_ac" id="reg_form"  method="post">
            <table>
            <tr>
                            <td colspan="3">
                            <?php
                                    if(isset($msg) && $msg !='')
                                        echo "<br/><div class='e_msg'>".$msg."</div><br/>";
                                        
                                    if(isset($s_msg))
                                        echo "<br/><div class='s_msg'>".$s_msg."</div><br/>";
                                ?>
                            </td>
                        </tr>
            <tr>
                <td>Stock Code</td>
                <td>: 
                    <?php
                        echo $stockid;
                                    echo "<input type='hidden' value='".$stockid."' name='scode' />";
                                ?>
                </td>
            </tr>
            <tr>
                <td>Buying Price / Unit</td>
                <td>: <?php
                        echo $this->user_account->get_buying_stock_price_by_code($stockid);
                    ?></td>
            </tr>
            <tr>
                <td>Available Volume</td>
                <td>: 
                    <?php
                        echo $this->user_account->get_stock_volume_by_code($stockid);
                    ?>
                </td>
            </tr>
            <tr>
                            <td>Your Volume </td>
                            <td> : 
                                <?php
                                    $data=array(
                                            'id'    => 'volume',
                                            'name'  => 'volume',
                                            'value' => set_value('volume'),
                                            'class' => 'input-style',
                                            );
                                            echo form_input($data);
                                ?>
                            </td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                    <td style="width: 300px;" colspan="2"><?php echo '<span class="ef_msg">'.form_error('volume').'</span>';?></td>
            </tr>
            <tr>
                            <td></td>
                            <td>
                                <?php
                                    $data=array(
                                        'id'    => 'submit',
                                        'name'  => 'submit1',
                                        'value' => '',
                                        'class' => 'submit_button',
                                        'onclick'=> 'return check_data2()',
                                        );
                                        echo form_submit($data);
                                ?>
                            </td>
                            <td></td>
                        </tr>
        </table>
        </form>
            <?php
        }
        
        if($action == "sell")
        {
            ?>
            <form class="product_form" action="" name="ac_to_ac" id="reg_form"  method="post">
            <table>
            <tr>
                            <td colspan="3">
                            <?php
                                    if(isset($msg) && $msg !='')
                                        echo "<br/><div class='e_msg'>".$msg."</div><br/>";
                                        
                                    if(isset($s_msg))
                                        echo "<br/><div class='s_msg'>".$s_msg."</div><br/>";
                                ?>
                            </td>
                        </tr>
            <tr>
                <td>Stock Code</td>
                <td>: 
                    <?php
                        echo $stockid;
                                    echo "<input type='hidden' value='".$stockid."' name='scode' />";
                                ?>
                </td>
            </tr>
            <tr>
                <td>Buying Price / Unit</td>
                <td>: <?php
                        echo $this->user_account->get_selling_stock_price_by_code($stockid);
                    ?></td>
            </tr>
            <tr>
                <td>Available Volume</td>
                <td>: 
                    <?php
                        echo $this->user_account->get_stock_volume_by_code_ac($stockid,$ac_no);
                    ?>
                </td>
            </tr>
            <tr>
                            <td>Your Volume </td>
                            <td> : 
                                <?php
                                    $data=array(
                                            'id'    => 'volume',
                                            'name'  => 'volume',
                                            'value' => set_value('volume'),
                                            'class' => 'input-style',
                                            );
                                            echo form_input($data);
                                ?>
                            </td>
                <td></td>
            </tr>
            <tr>
                <td></td>
                    <td style="width: 300px;" colspan="2"><?php echo '<span class="ef_msg">'.form_error('volume').'</span>';?></td>
            </tr>
            <tr>
                            <td></td>
                            <td>
                                <?php
                                    $data=array(
                                        'id'    => 'submit',
                                        'name'  => 'submit1',
                                        'value' => '',
                                        'class' => 'submit_button',
                                        'onclick'=> 'return check_data2()',
                                        );
                                        echo form_submit($data);
                                ?>
                            </td>
                            <td></td>
                        </tr>
        </table>
        </form>
            <?php
        }
    }
?>
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
}
.t1
{
    background: #dfdfdf;
}
</style>