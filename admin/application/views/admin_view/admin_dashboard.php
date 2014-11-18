<table style="width: 100%;border-spacing: 0px; font-family:  Jura-Regular;">
        <tr class="t1">
            <td>Total Chequing A/c</td>
            <td><?php echo $this->admin_account->all_accounts_by_type("cheuqing");?></td>
            <td>Total Investment A/c</td>
            <td><?php echo $this->admin_account->all_accounts_by_type("investment");?></td>
        </tr>
        <tr>
            <td>Total Credit Cards</td>
            <td><?php echo $this->admin_account->all_cards_by_type("Credit");?></td>
            <td>Total Virtual Money Cards</td>
            <td><?php echo $this->admin_account->all_cards_by_type("Debit");?></td>
        </tr>
        <tr class="t1">
            <td>Total Active Users</td>
            <td><?php echo $this->admin_account->all_users_by_type("active");?></td>
            <td>Total Pending Registration</td>
            <td><?php echo $this->admin_account->all_users_by_type("inactive");?></td>
        </tr>
</table>
<style>
td
{
    padding: 4px;
    border-bottom: 1px dotted #970834;
}
.t1
{
    background: #dfdfdf;
}
</style>