<div>
                            <?php
                                    if(isset($msg))
                                        echo $msg;
                                ?>
                            </div>
                            <br />
<?php
    if(isset($card_req_detail))
    {
        ?>
        <table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;">           
            <?php
            $i=0;
            foreach($card_req_detail as $row)
            {
                $card_detail = $this->user_account->get_credit_card_type_detail_by_cid($row->type);
                echo "<tr class='t1'>
                    <td style='width: 170px'>Card Type</td>
                    <td style='width: 551px'>: ".$card_detail[0]->name." - $".$card_detail[0]->limit." - ".$card_detail[0]->int_rate."%</td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>Annual Income</td>
                    <td>: ".$row->annual_income."</td>
                    </tr>";
                echo "<tr class='t1'>
                    <td>Annual Expenditures</td>
                    <td>: ".$row->annual_expe."</td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>Income Tax</td>
                    <td>: ".$row->income_tax."</td>
                    </tr>";
                echo "<tr class='t1'>
                    <td>Status</td>
                    <td>: ".$row->status."</td>
                    </tr>";
                echo "<tr class='t2'>
                    <td>Date</td>
                    <td>: ".date("d M,Y h:i:s",strtotime($row->cdate))."</td>
                    </tr>";
            }
            ?>
            </table>
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
        <?php
    }
    else
    {
?>
                    <form class="product_form" action="#" name="reg_form" id="reg_form"  method="post" enctype="multipart/form-data">
                    <table>
                    <tr>
                            <td colspan="2">
                            <?php
                                    if(isset($msg))
                                        echo $msg;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Username (E-mail) : </td>
                            <td>
                            <?php
                                    echo $userid;
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Select Credit Limit </td>
                            <td>
                                <select name="card_type">
                                    <?php
                                        $cards = $this->user_account->get_all_credit_card();
                                        foreach($cards as $row)
                                        {
                                            echo "<option value='$row->cid'>$row->name - $$row->limit - $row->int_rate%</option>";
                                        }
                                    ?>
                                </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('card_type').'</span>';?></td>
                        </tr>
                        <tr>
                            <td>Annual Income : </td>
                            <td>
                                <?php
                                    $data=array(
                                            'id'    => 'annual_income',
                                            'name'  => 'annual_income',
                                            'value' => set_value('annual_income'),
                                            'class' => 'input-style',
                                            );
                                            echo form_input($data);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('annual_income').'</span>';?></td>
                        </tr>
                        <tr>
                            <td>Annual Expenditures : </td>
                            <td>
                                <?php
                                    $data=array(
                                            'id'    => 'annual_expe',
                                            'name'  => 'annual_expe',
                                            'value' => set_value('annual_expe'),
                                            'class' => 'input-style',
                                            );
                                            echo form_input($data);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('annual_expe').'</span>';?></td>
                        </tr>
                        <tr>
                            <td>Income Tax(Annual) : </td>
                            <td>
                                <?php
                                    $data=array(
                                            'id'    => 'income_tax',
                                            'name'  => 'income_tax',
                                            'value' => set_value('income_tax'),
                                            'class' => 'input-style',
                                            );
                                            echo form_input($data);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('income_tax').'</span>';?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <?php
                                    $data=array(
                                        'id'    => 'submit',
                                        'name'  => 'submit',
                                        'value' => '',
                                        'class' => 'submit_button',
                                        'onclick'=> 'return check_data2()',
                                        );
                                        echo form_submit($data);
                                ?>
                            </td>
                        </tr>
                    </table>
                    </form>
<?php
    }
    ?>