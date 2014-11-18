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
                <a class="a_white" href="http://cscbanking.com/">
                    <img src="http://cscbanking.com/assets/images/Logo.jpg" style="float: left;" />
                </a>
                <div class="created_by">
                    This is an Academic Project From <span style="font-size: 18px;"><b>Concordia University Student</b></span> <br />
                    Created By : <b>Rahul K Kikani</b> | <b>Nassim Eghtesadi </b>               
                </div>
                <div class="clear_all1"></div>
            </div>            
            <div class="clear_all1"></div>
        </div>
        <div class="menu_box">
            <a class="a_white" href="http://cscbanking.com/">Home</a> | <a class="a_white" href="http://cscbanking.com/bank-services.html">Services</a> | <a class="a_white" href="http://cscbanking.com/new-registration.html">New Customer</a> | <a class="a_white" href="http://cscbanking.com/user_login.html">Customer Login</a> | Help?
        </div>
<div class="content_area">
<?php
                        if(isset($page))
                        {
                            $this->load->view('welcome_template/'.$page);
                        }
                        else
                        {
                            echo "Error : 404 Page Not Found.";
                        }
        ?>
        </div>
        <div class="footer">
        <div style="float: left;">
            <a class="a_white" href="http://cscbanking.com/">Home</a> | <a class="a_white" href="http://cscbanking.com/bank-services.html">Services</a> | <a class="a_white" href="http://cscbanking.com/new-registration.html">New Customer</a> | <a class="a_white" href="http://cscbanking.com/user_login.html">Customer Login</a> | <a class="a_white" href="http://cscbanking.com/image_credit.html">Image Credit</a>
        </div>
        <div style="float: right;color: white;">
            C$C Banking &copy; 2014, Academic Project
        </div> 
        </div>
    </div>
    
</body>
</html>
