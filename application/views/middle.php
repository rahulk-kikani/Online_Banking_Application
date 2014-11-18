<div class="content_area">
<div class="side_menu">
    <div class="level1">
        <div class="level1_title">User Profile Detail</div>
        <ul class="level1_ul">
            <li><a href="#"><?php echo $userid;?></a></li>
            <li><a href="<?php echo base_url();?>user/dashboard.html">Dashboard</a></li>
            <li><a href="<?php echo base_url();?>user/logout.html">Logout</a></li>
        </ul>
    </div>
<?php
    if(!isset($side_menu))
    {
        ?>
    <div class="level1">
        <div class="level1_title">Manage Accounts</div>
        <ul class="level1_ul">
            <li><a href="<?php echo base_url();?>user/withdraw-money.html">Withdraw</a></li>
            <li><a href="<?php echo base_url();?>user/deposite-cheque.html">Deposit Cheque</a></li>
            <li><a href="<?php echo base_url();?>user/transfer-money.html">Transfer Money</a></li>
            <li><a href="<?php echo base_url();?>user/account-history.html">Account Transaction History</a></li>
            <li><a href="<?php echo base_url();?>user/list-all-cheque.html">List All Cheques</a></li>
        </ul>
    </div>
    <div class="level1">
        <div class="level1_title">Bill Management</div>
        <ul class="level1_ul">
            <li><a href="<?php echo base_url();?>user/all_paid_bill.html">All Paid Bills</a></li>
            <li><a href="<?php echo base_url();?>user/pay_bill.html">Pay Bills</a></li>
        </ul>
    </div>
    <div class="level1">
        <div class="level1_title">Credit Card</div>
        <ul class="level1_ul">
            <li><a href="<?php echo base_url();?>user/credit-card-application.html">Apply For Credit Card</a></li>
            <li><a href="<?php echo base_url();?>user/make-credit-payment.html">Make Payment</a></li>
            <li><a href="<?php echo base_url();?>user/credit-card-transaction-detail.html">Transaction Detail</a></li>
            <li><a href="<?php echo base_url();?>user/credit-card-e-statement.html">e-Statement</a></li>
        </ul>
    </div>
    <div class="level1">
        <div class="level1_title">Investment</div>
        <ul class="level1_ul">
            <li><a href="<?php echo base_url();?>user/investment-account.html">Account Detail</a></li>
            <li><a href="<?php echo base_url();?>user/stock-center.html">Stock Market</a></li>
            <li><a href="<?php echo base_url();?>user/stock-details.html">My Stock Detail</a></li>
        </ul>
    </div>
    <div class="level1">
        <div class="level1_title">Manage Profile</div>
        <ul class="level1_ul">
            <li><a href="<?php echo base_url();?>view-profile.html">View Profile Info.</a></li>
            <li><a href="<?php echo base_url();?>change-password.html">Change Password</a></li>
            <li><a href="<?php echo base_url();?>login-history.html">Login History</a></li>
        </ul>
    </div>
    <?php
        }
    ?>
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
                            $this->load->view('user_account/'.$page);
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