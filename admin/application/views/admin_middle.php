<div class="content_area">
<div class="side_menu">
    <div class="level1">
        <div class="level1_title">User Profile Detail</div>
        <ul class="level1_ul">
            <li><a href="#"><?php 
                if(isset($userid))
                    echo $userid;
                else
                    echo "ADMIN";
            ?></a></li>
            <li><a href="<?php echo base_url();?>dashboard.html">Dashboard</a></li>
            <li><a href="<?php echo base_url();?>logout.html">Logout</a></li>
        </ul>
    </div>
    <div class="level1">
        <div class="level1_title">Manage Requests</div>
        <ul class="level1_ul">
            <li><a href="<?php echo base_url();?>new-ac-req.html">New A/c Request</a></li>
            <li><a href="<?php echo base_url();?>list-all-cheques.html">Cheque Request</a></li>
            <li><a href="<?php echo base_url();?>list-all-credit-card-req.html">Credit Card Request</a></li>
        </ul>
    </div>
    <!-- div class="level1">
        <div class="level1_title">Manage User Profile</div>
        <ul class="level1_ul">
            <li><a href="">User Detail</a></li>
            <li><a href="">Active/DeActive User</a></li>
        </ul>
    </div>
    <div class="level1">
        <div class="level1_title">Manage Accounts</div>
        <ul class="level1_ul">
            <li><a href="">Chequing A/c</a></li>
            <li><a href="">Investment A/c</a></li>
        </ul>
    </div>
    <div class="level1">
        <div class="level1_title">Manage Cards</div>
        <ul class="level1_ul">
            <li><a href="">Virtual Cards</a></li>
            <li><a href="">Credit Cards</a></li>
        </ul>
    </div --!>
    <div class="level1">
        <div class="level1_title">Add Billing Company</div>
        <ul class="level1_ul">
            <li><a href="<?php echo base_url();?>list-all-billing-companies.html">All Billing Comp.</a></li>
            <li><a href="<?php echo base_url();?>add-billing-companies.html">Add New Billing Comp.</a></li>
        </ul>
    </div>
    <div class="level1">
        <div class="level1_title">Investment Plan</div>
        <ul class="level1_ul">
            <li><a href="<?php echo base_url();?>fixed-deposit.html">Fixed Deposit</a></li>
            <li><a href="<?php echo base_url();?>stock-center.html">Stock Market</a></li>
        </ul>
    </div>
    <!-- div class="level1">
        <div class="level1_title">Credit Card Payment</div>
        <ul class="level1_ul">
            <li><a href="<?php echo base_url();?>calc-credit-inr/3222211110004.html">Calc. Credit INR</a></li>
            <li><a href="">Login History</a></li>
        </ul>
    </div --!>
    <div class="level1">
        <div class="level1_title">History</div>
        <ul class="level1_ul">
            <li><a href="<?php echo base_url();?>transaction-history.html">Transaction History</a></li>
            <li><a href="<?php echo base_url();?>cheque-history.html">Cheques History</a></li>
            <li><a href="<?php echo base_url();?>login-history.html">Login History</a></li>
        </ul>
    </div>
</div>
<div class="content_box">

        <?php
            if(isset($tag_data))
            {
                echo '<div class="tag_line"><h2>';
                echo $tag_data;
                echo '</h2></div>';
            }
            else
                echo "None!!!!"
        ?>
<br />
<?php
                        if(isset($page))
                        {
                            $this->load->view('admin_view/'.$page);
                        }
                        else
                        {
                            echo "Error : 404 Page Not Found.";
                        }
        ?>
</div>
<div class="clear_all"></div>
</div>
<div class="clear_all"></div>