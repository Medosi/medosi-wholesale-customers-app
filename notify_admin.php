<?php
header("Access-Control-Allow-Origin: *");

// Run all functions
if (isset($_POST['customer']) && !empty($_POST['customer'])){
    $customer_data = $_POST['customer'];
    $customer = json_decode($customer_data, true);

    $name = $customer['customer']['first_name'];
    $name .= " " .$customer['customer']['last_name'];
    $email = $customer['customer']['email'];
    $company = $customer['customer']['company'];
    $tags = $customer['customer']['tags'];
    error_log($tags);

    $to      = "jorge@chympen.com";
    $subject = "New Customer Created from Shopify";

    $message = "<html><head></head><body><div style='width:100%;'>";
    $message .= "A new customer was created on:<br/><br/>";
    $message .= "Medosi<br/><br/>";
    $message .= "Name: " . $name . "<br/>";
    $message .= "Email: " . $email . "<br/>";
    $message .= "Company: " . $company . "<br/>";
    $message .= "Use the link below to accept or decline this company as a pharmacy:<br/>";
    $message .= "Link Here";
    $message .= "</div></body></html>";

    $headers = "MIME-Version: 1.0" . PHP_EOL;
    $headers .= "Content-type:text/html;charset=UTF-8" . PHP_EOL;
    $headers .= "From: Medosi <info@medosi.com>" . PHP_EOL;
    $headers .= "Reply-To: Medosi <info@medosi.com>" . PHP_EOL;
    $headers .= "Return-Path: Medosi <info@medosi.com>" . PHP_EOL;
    $headers .= "X-Mailer: PHP/" . phpversion();

    $success = mail($to, $subject, $message, $headers);

    if (!$success) {
        error_log("email did not send");
    } else {
        error_log("email successfully sent");
    }
    
}

?>
