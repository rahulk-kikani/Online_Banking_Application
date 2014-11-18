            <div class="login_1">
                <div class="box_header">
                    <span class="arrow_icon"></span>
                    <div class="box_title">Forgot Password</div>
                    <div class="clear_all"></div>
                </div>
                <div class="box_content">
                    <form class="product_form" action="#" name="reg_form" id="reg_form" method="post">
                    <table style="width: 405px;margin-top: 0px;">
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
                            <td>Username : </td>
                            <td><input type="text" class="input-style" name="usr" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 280px;"><?php echo '<span class="ef_msg">'.form_error('usr').'</span>';?></td>
                        </tr>
                        <tr>
                            <td>Security Question:</td>
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
                            <td>Answer : </td>
                            <td><input type="password" class="input-style" name="pswd" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('pswd').'</span>';?></td>
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
                    <div class="clear_all"></div>
                    </form>
                    <div class="clear_all"></div>
                </div>
                <div></div>
                <div class="clear_all"></div>
            </div>
            <div class="clear_all"></div>