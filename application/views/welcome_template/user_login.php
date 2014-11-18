            <div class="login_1">
                <div class="box_header">
                    <span class="arrow_icon"></span>
                    <div class="box_title">User Login</div>
                    <div class="clear_all"></div>
                </div>
                <div class="box_content">
                    <form class="product_form" action="" name="reg_form" id="reg_form" method="post">
                    <table style="margin-top: 25px;width: 405px;">
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
                            <td><a href="<?php echo base_url();?>forgot-password.html" class="a_dotted">Forgot Password?</a>&nbsp;&nbsp;<a href="<?php echo base_url();?>new-registration.html" class="a_dotted">New User</a></td>
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
            <div class="login_2">
                <div class="box_header">
                    <span class="arrow_icon"></span>
                    <div class="box_title">Bank Admin Login</div>
                    <div class="clear_all"></div>
                </div>
                <div class="box_content">
                    <table style="margin-top: 25px;">
                        <tr>
                            <td>Username : </td>
                            <td><input type="text" class="input-style" /></td>
                        </tr>
                        <tr></tr>
                        <tr>
                            <td>Password : </td>
                            <td><input type="password" class="input-style" /></td>
                        </tr>
                        <tr></tr>
                        <tr>
                            <td></td>
                            <td><div style="height: 40px; width: 100px;background: #dfdfdf;"></div></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="text" class="input-style" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><div class="btn"><div style="float: left;">Submit</div><div class="white_arrow"></div></div></td>
                        </tr>
                    </table>
                </div>
                <div></div>
                <div class="clear_all"></div>
            </div>
            <div class="clear_all"></div>