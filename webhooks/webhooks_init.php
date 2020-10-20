<?php
require_once("../inc/functions.php");
require_once("../inc/connect_to_database.php");

$requests = $_GET;
$hmac = $_GET['hmac'];
$serializeArray = serialize($requests);
$requests = array_diff_key($requests, array( 'hmac' => '' ));
ksort($requests);

$sql = "SELECT * FROM access_token WHERE store_url='" . $requests['shop'] . "' LIMIT 1";
$result = mysqli_query( $conn, $sql );
$row = mysqli_fetch_assoc($result);

$token = $row['access_token'];
$shop_url = $row['store_url'];

$url = parse_url( 'https://' . $row['store_url'] );
$host = explode('.', $url['host'] );
$shop  = $host[0];

$uninstall_array = array(
		'webhook' => array(
			'topic' => 'app/uninstalled', 
			'address' => 'https://medosi-privateapp.com.com/apps/customer_data/webhooks/delete.php?shop=' . $shop_url,
			'format' => 'json'
		)
	);

$uninstall_webhook = shopify_call($token, $shop, "/admin/api/2020-04/webhooks.json", $uninstall_array, 'POST');
$uninstall_webhook = json_decode($uninstall_webhook['response'], JSON_PRETTY_PRINT);

$customer_create_array = array(
		'webhook' => array(
			'topic' => 'customers/create', 
			'address' => 'https://medosi-privateapp.com.com/apps/customer_data/webhooks/customer_create.php',
			'format' => 'json'
		)
	);

$customer_create_webhook = shopify_call($token, $shop, "/admin/api/2020-04/webhooks.json", $customer_create_array, 'POST');
$customer_create_webhook = json_decode($customer_create_webhook['response'], JSON_PRETTY_PRINT);

echo print_r( $uninstall_webhook );
echo print_r( $customer_create_webhook );
?>

<!DOCTYPE html>
<html>
<head>
	<title>Medosi Customer Data</title>
</head>
<body>
	<div>

	</div>
</body>
</html>