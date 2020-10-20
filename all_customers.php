<?php

// Get our helper functions Edit
require_once("inc/functions.php");
require_once("inc/connect_to_database.php");

$request = $_GET;
$hmac = $_GET['hmac'];

$shop_url = $request['shop'];

$serializeArray = serialize($requests);
$requests = array_diff_key($requests, array('hmac' => ''));
ksort($requests);

$sql = "SELECT * FROM access_token WHERE store_url='".$shop_url."' LIMIT 1";
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_assoc($result);

$access_token = $row['access_token'];
//$shop_url = $row['shop_url'];

$parsedUrl = parse_url('https://' . $shop_url );
$host = explode('.', $parsedUrl['host']);
$subdomain = $host[0];

$shop = $subdomain;

$all_customers_data = shopify_call($access_token, $shop, "/admin/api/2020-01/customers.json", array(), 'GET');
$all_customers = json_decode($all_customers_data['response']) -> customers;

?>

<?php include 'header.php' ?>

<div class="customer-table_wrapper">
    <table class="customer-table">
        <thead>
            <tr>
                <th></th>
                <th>CustomerID</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Name of Pharmacy</th>
                <th>NPI#</th>
                <th>Approved</th>
            </tr>
        </thead>
        <tbody>
            <?php
                foreach($all_customers as $customer){
                    $customer_tags = explode(",",$customer->tags);
                    $customer_approved = false;
                    foreach($customer_tags as $tag){
                        if(strpos($tag, "NPI:") !== false){
                            $npi_num = explode("NPI:", $tag);
                        };
                        if($tag == 'approved'){
                            $customer_approved = true;
                        
                        }    
                    }
            ?>
                <tr>
                    <td></td>
                    <td><?= $customer->id ?></td>
                    <td><?= $customer->first_name ?></td>
                    <td><?= $customer->last_name ?></td>
                    <td><?= $customer->email ?></td>
                    <td></td>
                    <td><?php 
                        if($npi_num) echo $npi_num[1];
                    ?></td>
                    <td><?php if($customer_approved) echo('approved'); ?></td>
                </tr>
            <?php
                }
            ?>
        </tbody>
    </table>
</div>
        
<?php include 'footer.php' ?>