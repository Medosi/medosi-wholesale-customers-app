<?php 
    // Get our helper functions
    require_once("inc/functions.php");
    require_once("inc/connect_to_database.php");

    $request = $_GET;
    $hmac = $_GET['hmac'];

    $shop_url = $request['shop'];

    $serializeArray = serialize($request);
    $request = array_diff_key($request, array('hmac' => ''));
    ksort($request);

    $sql = "SELECT * FROM shops WHERE shop_url='".$shop_url."' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    $access_token = $row['access_token'];
    //$shop_url = $row['shop_url'];

    $parsedUrl = parse_url('https://' . $shop_url );
    $host = explode('.', $parsedUrl['host']);
    $subdomain = $host[0];

    $shop = $subdomain;

    $all_customers_data = shopify_call($access_token, $shop, "/admin/api/2020-01/customers/search.json?query=wholesale-declined", array(), 'GET');
    $all_customers = json_decode($all_customers_data['response']) -> customers;
?>

<?php include 'header.php' ?>

<div id="declined-table">
    <table class="table table-hover table-bordered">
        <thead>
            <tr>
                <th scope="col">CustomerID</th>
                <th scope="col">First Name</th>
                <th scope="col">Last Name</th>
                <th scope="col">Email</th>
                <th scope="col">Business Name</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($all_customers as $customer){
            ?>
                    <tr id="customer-<?=$customer->id?>">
                        <td data-action="get-customer-data"><?= $customer->id ?></td>
                        <td><?= $customer->first_name ?></td>
                        <td><?= $customer->last_name ?></td>
                        <td><?= $customer->email ?></td>
                        <td><?= $customer->addresses[0]->company ?></td>
                    </tr>
            <?php } ?>
            <tr class="empty-msg d-none">
                <td colspan="13">There are no declined accounts!</td>
            </tr>
        </tbody>
    </table>
</div>

<?php include 'footer.php' ?>