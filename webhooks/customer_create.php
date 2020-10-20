<?php

define('SHOPIFY_APP_SECRET', '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');

function verify_webhook($data, $hmac_header) {
  $calculated_hmac = base64_encode(hash_hmac('sha256', $data, SHOPIFY_APP_SECRET, true));
  return hash_equals($hmac_header, $calculated_hmac);
}

$data = file_get_contents('php://input');
$hmac_header = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];
$verified = verify_webhook($data, $hmac_header);
error_log('Customer Creation Webhook Verified: '.var_export($verified, true). ' | Data: '.$data); //check error.log to see the result

//echo file_put_contents("test.txt",$data);

if($verified):
	// Decode Shopify POST
	$data = json_decode($data, true);

	$customer_name = $data['first_name'];
	$customer_name .= " " .$data['last_name'];
	$customer_email = $data['email'];
	$customer_tags = $data['tags'];

	$to      = "jorgefco95@gmail.com";
	$subject = "New Customer Created from Shopify";

	$message = "<html><head></head><body><div style='width:100%;'>";
	$message .= "A new customer was created on:<br/>";
	$message .= "https://medosi.com<br/><br/>";
	$message .= "Name: $customer_name<br/>";
	$message .= "Email: $customer_email<br/>";
	$message .= "Tags: $customer_tags<br/>";
	$message .= "</div></body></html>";

	$headers = "MIME-Version: 1.0" . PHP_EOL;
	$headers .= "Content-type:text/html;charset=UTF-8" . PHP_EOL;
	$headers .= "From: Medosi <info@medosi.com>" . PHP_EOL;
	$headers .= "Reply-To: Medosi <info@medosi.com>" . PHP_EOL;
	$headers .= "Return-Path: Medosi <info@medosi.com>" . PHP_EOL;
	$headers .= "X-Mailer: PHP/" . phpversion();

	mail($to, $subject, $message, $headers);
endif;

?>

