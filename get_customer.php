<?php
header("Access-Control-Allow-Origin: *");
function get_customer($customer_id){
    $curl = curl_init();
    curl_setopt_array($curl, array(
      CURLOPT_URL => "https://medosi.myshopify.com/admin/api/2020-04/customers/".$customer_id.".json?fields=default_address",
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 0,
      CURLOPT_FOLLOWLOCATION => true,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_HTTPHEADER => array(
        "Content-Type: application/json",
        "Authorization: Basic MTA0MGJmNjNlNzJjMGFiNmY0YmFiOTU3ZjM2NmMzNTc6YTE4MmRlOTk3NmY4NDU0NTdjMDVlZmQ4ZmVlOWFlMTY=",
        "Cache-Control: no-cache",
        "Connection: keep-alive",
        "Content-Type: application/json",
        "Host: medosi.myshopify.com",
        "accept-encoding: gzip, deflate",
        "cache-control: no-cache"
      ),
    ));
    $response = curl_exec($curl);
    
    curl_close($curl);
    echo $response;    
}

// Run all functions
if($_POST['customer_id']){
  $customer_id = $_POST['customer_id'];
  get_customer($customer_id);
}
?>