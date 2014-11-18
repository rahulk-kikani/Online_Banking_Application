            <div class="login_1">
                <div class="box_header">
                    <span class="arrow_icon"></span>
                    <div class="box_title">Set New Passord</div>
                    <div class="clear_all"></div>
                </div>
                <div class="box_content">
                    <form class="product_form" action="#" name="reg_form" id="reg_form" method="post">
                    <table style="width: 420px;">
                        <tr>
                            <td colspan="2">
                            <?php
                            
                                    if(isset($msg) && $msg !='')
                                        echo "<div class='e_msg'>".$msg."</div><br/>";
                                    if(isset($s_msg) && $s_msg !='')
                                        echo "<div class='s_msg'>".$s_msg."</div><br/>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Password : </td>
                            <td><input type="password" name="pswd1" id="pswd1" class="input-style" />
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('pswd1').'</span>';?></td>
                        </tr>
                        <tr>
                            <td>Confirm Password : </td>
                            <td><input type="password" name="pswd2" id="pswd2" class="input-style" />
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('pswd2').'</span>';?></td>
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
                                        );
                                        echo form_submit($data);
                                ?>
                            </td>
                            <td></td>
                        </tr>
                    </table>
                    </form>
                </div>
                <div></div>
                <div class="clear_all"></div>
            </div>
            <div class="clear_all"></div>