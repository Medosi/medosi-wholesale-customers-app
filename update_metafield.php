<?php
header("Access-Control-Allow-Origin: *");
function update_customer_metafield($metafield_id, $metafield_data){
  $curl = curl_init();
  $updateMetafieldURL = "https://medosi.myshopify.com/admin/metafields/".$metafield_id.".json";
  curl_setopt_array($curl, array(
    CURLOPT_URL => $updateMetafieldURL,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "PUT",
    CURLOPT_POSTFIELDS => $metafield_data,
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
      "Authorization: Basic MTA0MGJmNjNlNzJjMGFiNmY0YmFiOTU3ZjM2NmMzNTc6YTE4MmRlOTk3NmY4NDU0NTdjMDVlZmQ4ZmVlOWFlMTY="
    ),
  ));

  $response = curl_exec($curl);
  $err = curl_error($curl);

  curl_close($curl);

  if ($err) {
      echo "cURL Error #:" . $err;
  } else {
      $metafield = $response;
      echo $metafield;
  }
}

if($_POST['update_metafield']){
  $metafield_data = $_POST['update_metafield'];
  $metafield = json_decode($metafield_data, true);
  $metafield_id = $metafield['metafield']['id'];
  update_customer_metafield($metafield_id, $metafield_data);
}
?>