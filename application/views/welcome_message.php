<!DOCTYPE html>
<html>
<head>
	<meta http-equiv="content-type" content="text/html" />
	<meta name="author" content="Rahul K Kikani" />
	<title>Welcome to, Bank de CSC.Concordia Student Community</title>
    <link type="text/css" href="<?php echo base_url();?>assets/css/styles.css" rel="stylesheet" />
</head>

<body>
    <div class="middel">
        <div class="header_line"></div>
        <div class="header_box">
            <div class="logo">
                <img src="<?php echo base_url();?>assets/images/Logo.jpg" />
            </div>
        </div>
        <div class="menu_box">
            Home | Services | New Customer | Contact Us | Maps | Help?
        </div>
        <div class="content_area">
            <div class="login_1">
                <div class="box_header">
                    <span class="arrow_icon"></span>
                    <div class="box_title">User Login</div>
                    <div class="clear_all"></div>
                </div>
                <div class="box_content">
                    <form class="product_form" action="<?php echo base_url();?>user_login.html" name="reg_form" id="reg_form" method="post">
                    <table style="margin-top: 25px;">
                        <tr>
                            <td>Username : </td>
                            <td><input type="text" class="input-style" name="usr" /></td>
                        </tr>
                        <tr></tr>
                        <tr>
                            <td>Password : </td>
                            <td><input type="password" class="input-style" name="pswd" /></td>
                        </tr>
                        <tr></tr>
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
                                        echo '<span class="ef_msg">'.form_error('captcha').'</span>';
                                ?></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><input type="checkbox" /> Remember Me!</td>
                        </tr>
                        <tr>
                            <td></td>
                            <td><a href="" class="a_dotted">Forgot Password?</a>&nbsp;&nbsp;<a href="" class="a_dotted">New User</a></td>
                        </tr>
                        <tr>
                            <td></td>
                            <td>
                                <?php
                                    $data=array(
                                        'id'    => 'submit',
                                        'name'  => 'submit',
                                        'value' => 'submit',
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
                            <td><input type="checkbox" /> Remember Me!</td>
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
        </div>
        <div class="footer">
            Footer Area
        </div>
    </div>
    
</body>
</html>