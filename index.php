<?php

include 'header.php';

include_once("inc/connect_to_database.php");
require_once("inc/functions.php");

$requests = $_GET;
// echo print_r($requests);

$sql = "SELECT * FROM shops WHERE shop_url='" . $requests['shop'] . "' LIMIT 1";
$check = mysqli_query($conn, $sql);

if(mysqli_num_rows($check) < 1){
    header("Location: install.php?shop=" . $requests['shop']);
    exit();
}

?>

<div class="container pt-3">
    <h1>Medosi Customer Data</h1>
    <p>Welcome to Medosi Customer Data! Within the app you will be able to manage wholesale accounts.</p>
    <h4>How it Works</h4>
    <p>Every time a new customer registers on the website, the app will check to see if the user hit the checkbox to apply for a wholesale account. If the customer applied for a wholesale aacount, an email notification will be sent and the customer will be added to the pending list.<br/><br/>
    The app is divided into 3 separate sections (pending, approved and declined):<br/>
        <ul>
            <li>Pending page will show accounts that haven't been approved nor declined.</li>
            <li>Approved page will show approved accounts.</li>
            <li>Declined page will show declined accounts.</li>
        </ul>
    </p>
    <h4>Changing Status of Customer Account</h4>
    <p>
        To change the status of a customer account, under the staus tab, hit the green checkmark to approve the account or hit the red cross to decline the request.<br/><br/>
        Customers that have been approved, will have the <i><b>wholesale-approved</b></i> tag. Customers that have been declined, will have the <i><b>wholesale-declined</b></i> tag. Customers that are pending will have the <i><b>wholesale-pending</b></i> tag.<br/><br/>
        In the case a custumer has been approved or declined, there is the option to revert the status. On the Approved and Declined pages, there is a column at the end (to the right of status) to change the the current status of the customer account.
    </p>
    <h4>Troubleshooting</h4>
    <p>
        If you approved or declined an account and the tables are not properly displaying the information or are not updating accordingly, please wait 15-30 sec and try refreshing the page.<br/><br/>
        If the issue persist, please contact <a href="mailto:jorge@chympen.com">jorge@chympen.com</a>
    </p>
</div>

<?php include 'footer.php' ?>