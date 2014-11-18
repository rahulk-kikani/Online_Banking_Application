            <div class="reg_box">
                <div class="box_header">
                    <span class="arrow_icon"></span>
                    <div class="box_title" style="width:  519px;"><span style="float: left;">New User Registration!!!! </span><a href="<?php echo base_url();?>user_login.html" style="float: right;color: #970834;text-decoration: none;">Log In!</a></div>
                    <div class="clear_all"></div>
                </div>
                <div class="box_content">
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
                                    $data=array(
                                            'id'    => 'usr',
                                            'name'  => 'usr',
                                            'value' => set_value('usr'),
                                            'class' => 'input-style',
                                            );
                                            echo form_input($data);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('usr').'</span>';?></td>
                        </tr>
                        <tr>
                            <td>First Name : </td>
                            <td>
                            <?php
                                    $data=array(
                                            'id'    => 'fname',
                                            'name'  => 'fname',
                                            'value' => set_value('fname'),
                                            'class' => 'input-style',
                                            );
                                            echo form_input($data);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('fname').'</span>';?></td>
                        </tr>
                        <tr>
                            <td>Last Name : </td>
                            <td>
                            <?php
                                    $data=array(
                                            'id'    => 'lname',
                                            'name'  => 'lname',
                                            'value' => set_value('lname'),
                                            'class' => 'input-style',
                                            );
                                            echo form_input($data);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('lname').'</span>';?></td>
                        </tr>
                        <tr>
                            <td>Document NO./ID : </td>
                            <td>
                                <?php
                                    $data=array(
                                            'id'    => 'doc_id',
                                            'name'  => 'doc_id',
                                            'value' => set_value('doc_id'),
                                            'class' => 'input-style',
                                            );
                                            echo form_input($data);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('doc_id').'</span>';?></td>
                        </tr>
                        <tr>
                            <td>Address : </td>
                            <td>
                                <?php
                                    $data=array(
                                            'id'    => 'adrs',
                                            'name'  => 'adrs',
                                            'value' => set_value('adrs'),
                                            'class' => 'input-style',
                                            );
                                            echo form_input($data);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('adrs').'</span>';?></td>
                        </tr>
                        <tr>
                            <td>City : </td>
                            <td>
                                <?php
                                    $data=array(
                                            'id'    => 'city',
                                            'name'  => 'city',
                                            'value' => set_value('city'),
                                            'class' => 'input-style',
                                            );
                                            echo form_input($data);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('city').'</span>';?></td>
                        </tr>
                        <tr>
                            <td>State : </td>
                            <td>
                                <?php
                                    $data=array(
                                            'id'    => 'state',
                                            'name'  => 'state',
                                            'value' => set_value('state'),
                                            'class' => 'input-style',
                                            );
                                            echo form_input($data);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('state').'</span>';?></td>
                        </tr>
                        <tr>
                            <td>Zip Code : </td>
                            <td>
                                <?php
                                    $data=array(
                                            'id'    => 'zipc',
                                            'name'  => 'zipc',
                                            'value' => set_value('zipc'),
                                            'class' => 'input-style',
                                            );
                                            echo form_input($data);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('zipc').'</span>';?></td>
                        </tr>
                        <tr>
                            <td>Mobile No. : </td>
                            <td>
                                <?php
                                    $data=array(
                                            'id'    => 'mno',
                                            'name'  => 'mno',
                                            'value' => set_value('mno'),
                                            'class' => 'input-style',
                                            );
                                            echo form_input($data);
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('mno').'</span>';?></td>
                        </tr>
                        <tr>
                            <td>Upload Document : </td>
                            <td><input type="file" class="input-style" name="doc_file" /></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;"><?php echo '<span class="ef_msg">'.form_error('doc_file').'</span>';?></td>
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
                <div class="clear_all"></div>
            </div>
            <div class="note_box">
                <div class="box_header">
                    <span class="arrow_icon"></span>
                    <div class="box_title">Important Notes</div>
                    <div class="clear_all"></div>
                </div>
                <div class="box_content">
                    <b>Username</b> : should be email address.
                    <br />
                    <b>Document NO./ID</b> : should be valid passport no., will be consider as your identity proof.<br />
                    <b>Address</b> : Enter your current recidance address.<br />
                    <b>City</b> : Name of city.<br />
                    <b>State</b> : Name of province.<br />
                    <b>Zip Code</b> : should be 6 characters. (eg. H3H 2S1)<br />
                    <b>Mobile No.</b> : Enter your mobile number. No neeed to enter country code. Will be use for security and alert system related to your account.<br />
                    <b>Upload Document</b> : Upload scan copy of your passport for verification of your identity. File size should be less then 1.5MB. Accepted file types are JPEG, PNG, GIF only.<br />
                    <br />
                    <b>NOTES</b> : All your information will be confidancial and saved in our secure system so, fill valid and currect information.<br />
                    <br />
                    <b>Thank You,</b>
                </div>
                <div class="clear_all"></div>
            </div>
            <div class="clear_all"></div>