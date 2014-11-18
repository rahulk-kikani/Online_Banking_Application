                    <form class="product_form" action="" name="reg_form" id="reg_form"  method="post" enctype="multipart/form-data">
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
                            <td style="width: 250px;">Deposit To : </td>
                            <td>
                                <?php
                                    if(isset($ac_detail))
                                    {
                                        foreach($ac_detail as $row)
                                        {
                                            if($row->ac_type == 'cheuqing')
                                            {
                                                echo "<b>$row->ac_no - Cheuqing Account - $$row->ac_bal</b>";
                                                break;
                                            }
                                        }
                                            
                                    }
                                ?>
                            </td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;" colspan="2"><?php echo '<span class="ef_msg">'.form_error('usr').'</span>';?></td>
                        </tr>
                        <tr>
                            <td>Cheque NO : </td>
                            <td>
                                <?php
                                    $data=array(
                                            'id'    => 'chq_no',
                                            'name'  => 'chq_no',
                                            'value' => set_value('chq_no'),
                                            'class' => 'input-style',
                                            );
                                            echo form_input($data);
                                ?>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;" colspan="2"><?php echo '<span class="ef_msg">'.form_error('chq_no').'</span>';?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td>Cheque A/c NO : </td>
                            <td>
                                <?php
                                    $data=array(
                                            'id'    => 'chq_ac_no',
                                            'name'  => 'chq_ac_no',
                                            'value' => set_value('chq_ac_no'),
                                            'class' => 'input-style',
                                            );
                                            echo form_input($data);
                                ?>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;" colspan="2"><?php echo '<span class="ef_msg">'.form_error('chq_ac_no').'</span>';?></td>
                        </tr>
                        <tr>
                            <td>Bank Detail(eg. Name - Address) : </td>
                            <td>
                                <?php
                                    $data=array(
                                            'id'    => 'bank_detail',
                                            'name'  => 'bank_detail',
                                            'value' => set_value('bank_detail'),
                                            'class' => 'input-style',
                                            );
                                            echo form_input($data);
                                ?>
                            </td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;" colspan="2"><?php echo '<span class="ef_msg">'.form_error('bank_detail').'</span>';?></td>
                        </tr>
                        <tr>
                            <td>Date : </td>
                            <td>
                                <?php
                                    $data=array(
                                            'id'    => 'chq_date',
                                            'name'  => 'chq_date',
                                            'value' => set_value('chq_date'),
                                            'class' => 'input-style',
                                            );
                                            echo form_input($data);
                                ?>
                            </td>
                            <td>[eg. MM/DD/YYYY]</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;" colspan="2"><?php echo '<span class="ef_msg">'.form_error('chq_date').'</span>';?></td>
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
                            <td>Upload Document : </td>
                            <td><input type="file" class="input-style" name="doc_file" /></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td style="width: 300px;" colspan="2"><?php echo '<span class="ef_msg">'.form_error('doc_file').'</span>';?></td>
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
                            <td></td>
                        </tr>
                    </table>
                    </form>