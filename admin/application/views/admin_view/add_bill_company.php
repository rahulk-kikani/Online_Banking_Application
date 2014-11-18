
                <div class="box_content">
                    <form class="product_form" action="" name="reg_form" id="reg_form"  method="post" enctype="multipart/form-data">
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