<?php
// Get our helper functions
require_once("../inc/connect_to_database.php");

define('SHOPIFY_APP_SECRET', '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'); // Replace with your SECRET KEY

function verify_webhook($data, $hmac_header)
{
  $calculated_hmac = base64_encode(hash_hmac('sha256', $data, SHOPIFY_APP_SECRET, true));
  return hash_equals($hmac_header, $calculated_hmac);
}

$res = '';
$data = file_get_contents('php://input');
$hmac_header = $_SERVER['HTTP_X_SHOPIFY_HMAC_SHA256'];
$topic_header = $_SERVER['HTTP_X_SHOPIFY_TOPIC'];
$shop_header = $_SERVER['HTTP_X_SHOPIFY_SHOP_DOMAIN'];

$verified = verify_webhook($data, $hmac_header);
error_log('App Unistall Webhook Verified: '.var_export($verified, true). ' | Data: '.$data); //check error.log to see the result

if( $verified ) {
  $decoded_data = json_decode($data, true);
  $shop_domain = $decoded_data[domain];

  if( $topic_header == 'app/uninstalled' || $topic_header == 'shop/update') {
    if( $topic_header == 'app/uninstalled' ) {

      $sql = "DELETE FROM access_token WHERE store_url='".$shop_header."' LIMIT 1";
      $result = mysqli_query($conn, $sql);

      // $response->shop_domain = $decoded_data['shop_domain'];

      $res = $shop_domain . ' is successfully deleted from the database';
    } else {
      $res = $data;
    }
  }

  $shop_name = $decoded_data['name'];
  $shop_owner = $decoded_data['shop_owner'];
  $shop_email = $decoded_data['email'];
  $shop_phone = $decoded_data['tags'];

  $to      = "jorgefco95@gmail.com";
  $subject = "Medosi Customer Data has been deleted";

  $message = "<html><head></head><body><div style='width:100%;'>";
  $message .= "Medosi Customer Data has been deleted from:<br/>";
  $message .= $shop_domain . "<br/><br/>";
  $message .= "Shop Name: $shop_name<br/>";
  $message .= "Shop Owner: $shop_owner<br/>";
  $message .= "Email: $shop_email<br/>";
  $message .= "Phone: $shop_phone<br/>";
  $message .= "</div></body></html>";

  $headers = "MIME-Version: 1.0" . PHP_EOL;
  $headers .= "Content-type:text/html;charset=UTF-8" . PHP_EOL;
  $headers .= "From: The Creative Zone <thecreativezone1@gmail.com>" . PHP_EOL;
  $headers .= "Reply-To: The Creative Zone <thecreativezone1@gmail.com>" . PHP_EOL;
  $headers .= "Return-Path: The Creative Zone <thecreativezone1@gmail.com>" . PHP_EOL;
  $headers .= "X-Mailer: PHP/" . phpversion();

  mail($to, $subject, $message, $headers);
} else {
  $res = 'The request is not from Shopify';
}

error_log('Response: '. $res); //check error.log to see the result


?>