<?php
    if(isset($success_msg))
        echo "<div class='s_msg'>".$success_msg."</div><br/>";
?>
<form class="product_form" action="#" name="security_question_form" id="reg_form" method="post">
<table>
    <tr>
        <td>From Account No :</td>
        <td>
            <?php 
                echo $ac_no = $this->user_account->get_ac_no_by_email_actype($userid,"cheuqing")." - ";
                echo  "$".$this->user_account->get_bal_by_ac($ac_no);
            ?>
        </td>
    </tr>
    <tr>
        <td>Amount :</td>
        <td>
            <input type="text" name="amount" class="input-style" />
        </td>
    </tr>
    <tr>
        <td></td>
            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('amount').'</span>';?></td>
    </tr>
    <tr>
        <td>To Virtual Money Card :</td>
        <td>453<?php echo $vm_card_no = $this->user_account->get_vm_card_no_by_acno_actype($ac_no,"Debit")." - ";
                    echo  "$".$this->user_account->get_bal_vm_card($vm_card_no);
            ?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td><input type="submit" name="submit" value="" id="submit" class="submit_button" onclick="return check_data2()"></td>
    </tr>
</table>
</form>