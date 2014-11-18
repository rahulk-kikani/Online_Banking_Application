
<h2 class="h2">Internal Money Transfer</h2>
<form class="product_form" action="" name="ac_to_ac" id="reg_form"  method="post" enctype="multipart/form-data">
                    <table style="width: 100%;">
                    <tr>
                            <td colspan="3">
                            <?php
                                    if(isset($msg1) && $msg1 !='')
                                        echo "<br/><div class='e_msg'>".$msg1."</div><br/>";
                                        
                                    if(isset($s_msg1))
                                        echo "<br/><div class='s_msg'>".$s_msg1."</div><br/>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="width: 250px;">Select A/c : </td>
                            <td>
                                <select name="ac_from">
                                <?php
                                    if(isset($ac_detail))
                                    {
                                        foreach($ac_detail as $row)
                                        {
                                            if($row->ac_type == 'cheuqing')
                                            {
                                                echo "<option value='$row->ac_no'>$row->ac_no - Cheuqing Account - $$row->ac_bal</option>";
                                            }
                                            if($row->ac_type == 'investment')
                                            {
                                                echo "<option value='$row->ac_no'>$row->ac_no - Investment Account - $$row->ac_bal</option>";
                                            }
                                        }
                                            
                                    }
                                    if(isset($vm_detail))
                                    {
                                        foreach($vm_detail as $row)
                                        {
                                                echo "<option value='$row->card_no'>453$row->card_no - Virtual Money Account - $$row->amount</option>";
                                            
                                        }
                                            
                                    }
                                ?>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;" colspan="2"><?php echo '<span class="ef_msg">'.form_error('ac_from').'</span>';?></td>
                        </tr>
                        <tr>
                            <td style="width: 250px;">Transfter TO(A/c) : </td>
                            <td>
                                <select name="ac_to">
                                <?php
                                    if(isset($ac_detail))
                                    {
                                        foreach($ac_detail as $row)
                                        {
                                            if($row->ac_type == 'cheuqing')
                                            {
                                                echo "<option value='$row->ac_no'>$row->ac_no - Cheuqing Account - $$row->ac_bal</option>";
                                            }
                                            if($row->ac_type == 'investment')
                                            {
                                                echo "<option value='$row->ac_no'>$row->ac_no - Investment Account - $$row->ac_bal</option>";
                                            }
                                        }
                                            
                                    }
                                    if(isset($vm_detail))
                                    {
                                        foreach($vm_detail as $row)
                                        {
                                                echo "<option value='$row->card_no'>453$row->card_no - Virtual Money Account - $$row->amount</option>";
                                            
                                        }
                                            
                                    }
                                ?>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;" colspan="2"><?php echo '<span class="ef_msg">'.form_error('ac_to').'</span>';?></td>
                        </tr>
                        <tr>
                            <td>Amount : </td>
                            <td>
                                <?php
                                    $data=array(
                                            'id'    => 'amount',
                                            'name'  => 'amount',
                                            'value' => set_value('amount'),
                                            'class' => 'input-style',
                                            );
                                            echo form_input($data);
                                ?>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;" colspan="2"><?php echo '<span class="ef_msg">'.form_error('amount').'</span>';?></td>
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
<br />
<br />
<h2 class="h2">External Money Transfer</h2>
                    <form class="product_form" action="" name="ac_to_other" id="reg_form"  method="post" enctype="multipart/form-data">
                    <table style="width: 100%;">
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
                            <td style="width: 250px;">Select A/c : </td>
                            <td>
                                <select name="ac_from1">
                                <?php
                                    if(isset($ac_detail))
                                    {
                                        foreach($ac_detail as $row)
                                        {
                                            if($row->ac_type == 'cheuqing')
                                            {
                                                echo "<option value='$row->ac_no'>$row->ac_no - Cheuqing Account - $$row->ac_bal</option>";
                                            }
                                        }
                                            
                                    }
                                ?>
                            </select>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;" colspan="2"><?php echo '<span class="ef_msg">'.form_error('ac_from1').'</span>';?></td>
                        </tr>
                        <tr>
                            <td>Other A/c NO : </td>
                            <td>
                                <?php
                                    $data=array(
                                            'id'    => 'ac_to1',
                                            'name'  => 'ac_to1',
                                            'value' => set_value('ac_to1'),
                                            'class' => 'input-style',
                                            );
                                            echo form_input($data);
                                ?>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;" colspan="2"><?php echo '<span class="ef_msg">'.form_error('ac_to1').'</span>';?></td>
                        </tr>
                        <tr>
                            <td>Amount : </td>
                            <td>
                                <?php
                                    $data=array(
                                            'id'    => 'amount1',
                                            'name'  => 'amount1',
                                            'value' => set_value('amount1'),
                                            'class' => 'input-style',
                                            );
                                            echo form_input($data);
                                ?>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;" colspan="2"><?php echo '<span class="ef_msg">'.form_error('amount1').'</span>';?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <?php
                                    $data=array(
                                        'id'    => 'submit',
                                        'name'  => 'submit2',
                                        'value' => '',
                                        'class' => 'submit_button',
                                        'onclick'=> 'return check_data()',
                                        );
                                        echo form_submit($data);
                                ?>
                            </td>
                            <td></td>
                        </tr>
                    </table>
                    </form>
<style>
.h2
{
    border-bottom: 1px dotted #970834;
    padding-bottom: 3px;
    margin: 0px;
}
</style>