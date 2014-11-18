<?php
                                    if(isset($msg) && $msg !='')
                                        echo "<br/><div class='e_msg'>".$msg."</div><br/>";
                                        
                                    if(isset($s_msg))
                                        echo "<br/><div class='s_msg'>".$s_msg."</div><br/>";
                                ?>
<?php
    if(!isset($all_fixed_detail))
    {
            ?>
            <form class="product_form" action="" name="ac_to_ac" id="reg_form"  method="post">
            <table>
            <tr>
                <td>Minimum Amount</td>
                <td>: $100
                </td>
            </tr>
            <tr>
                <td>Rate</td>
                <td>: 200% (2 Year. Mean it amount will doubled in 2 Years.)</td>
            </tr>
            <tr>
                <td>Duration</td>
                <td>: 2 Years</td>
            </tr>
            <tr>
                <td>Expected Date</td>
                <td>: <?php echo date("d M, Y",strtotime('+2 year',time()))?></td>
            </tr>
            <tr>
                <td>Account Balance</td>
                <td>: 
                    <?php
                        echo $this->user_account->get_bal_by_ac($ac_no);
                    ?>
                </td>
            </tr>
            <tr>
                            <td>Enter Amount</td>
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
        else
            echo "Your already invested money";
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