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

$url = parse_url( 'https://' . $row['store_url'] );
$host = explode('.', $url['host'] );
$shop  = $host[0];

$all_webhooks = shopify_call($token, $shop, "/admin/api/2020-04/webhooks.json", array(), 'GET');
$webhook = json_decode($all_webhooks['response'], JSON_PRETTY_PRINT);

echo print_r( $webhook );
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