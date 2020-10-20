<?php
header("Access-Control-Allow-Origin: *");
function get_metafields($customer_id){
    $curl = curl_init();
    $customerMetafieldsURL = "https://medosi.myshopify.com/admin/customers/".$customer_id."/metafields.json";
    curl_setopt_array($curl, array(
      CURLOPT_URL => $customerMetafieldsURL,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
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
      echo $response;
    }
}

// Run all functions
if($_POST['customer_id']){
    $customer_id = $_POST['customer_id'];
    get_metafields($customer_id);
}
?>