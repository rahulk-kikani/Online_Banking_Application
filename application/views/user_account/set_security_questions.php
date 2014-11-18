<?php
    if(isset($secure_flag))
    {
        if($secure_flag)
        {
            ?>
<table>
    <tr>
        <td>Question :</td>
        <td>
            <?php
                echo $this->user_account->get_security_que_email($userid);
                ?>
        </td>
    </tr>
    <tr>
        <td>Answer :</td>
        <td>
            ***********
        </td>
    </tr>
</table>
            <?php
        }
        else
        {
            
?>
<form class="product_form" action="#" name="security_question_form" id="reg_form" method="post">
<table>
    <tr>
        <td>Question :</td>
        <td>
            <select class="input-style" name="secure_q" style="width: 300px;">
            <?php
                $questions = $this->db->get('secure_question')->result();
                if(count($questions)>0)
                {
                    foreach($questions as $q)
                    {
                        echo "<option value='$q->q_id'>".$q->detail."</option>";
                    }
                }
                ?>
            </select>
        </td>
    </tr>
    <tr>
        <td></td>
            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('secure_q').'</span>';?></td>
    </tr>
    <tr>
        <td>Answer :</td>
        <td>
            <input type="text" name="secure_ans" class="input-style" />
        </td>
    </tr>
        <tr>
        <td></td>
            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('secure_ans').'</span>';?></td>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit" name="submit" value="" id="submit" class="submit_button" onclick="return check_data2()"></td>
    </tr>
</table>
</form>
<?php
        }
    }
?>