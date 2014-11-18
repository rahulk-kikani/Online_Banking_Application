            <div class="login_1">
                <div class="box_header">
                    <span class="arrow_icon"></span>
                    <div class="box_title">Admin Login</div>
                    <div class="clear_all"></div>
                </div>
                <div class="box_content">
                    <form class="product_form" action="" name="reg_form" id="reg_form" method="post">
                    <table style="margin-top: 25px;width: 445px;margin: 0 auto;padding: 20px;">
                        <tr>
                            <td colspan="2">
                            <?php
                                    if(isset($e_msg) && $e_msg !='')
                                        echo "<br/><div class='e_msg'>".$e_msg."</div><br/>";
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td>Username : </td>
                            <td><?php
                                    $data=array(
                                            'id'    => 'usr',
                                            'name'  => 'usr',
                                            'value' => set_value('usr'),
                                            'class' => 'input-style',
                                            );
                                            echo form_input($data);
                                ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('usr').'</span>';?></td>
                        </tr>
                        <tr>
                            <td>Password : </td>
                            <td><input type="password" class="input-style" name="pswd" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('pswd').'</span>';?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><?php
                                    echo $image;
                                ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><?php
                                        $data=array(
                                        'id'    => 'captcha',
                                        'name'  => 'captcha',
                                        'value' => '',
                                        'class' => 'input-style',
                                        );
                                        echo form_input($data);
                                ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('captcha').'</span>';?></td>
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
                </div>
                <div></div>
                <div class="clear_all"></div>
            </div>
            <div class="clear_all"></div>