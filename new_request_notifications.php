<?php
header("Access-Control-Allow-Origin: *");

// Run all functions
if (isset($_POST['customer']) && !empty($_POST['customer'])){
    $customer_data = $_POST['customer'];
    $customer = json_decode($customer_data, true);

    $first_name = $customer['customer']['first_name'];
    $last_name = $customer['customer']['last_name'];
    $email = $customer['customer']['email'];
    $company = $customer['customer']['addresses'][0]['company'];

    $admin_email_success = false;
    $customer_email_success = false;

    // ADMIN EMAIL
    $admin_to      = "cmcjunkin@medosi.com,jorge@chympen.com";
    // $admin_to      = "jorge@chympen.com";
    $admin_subject = "New Wholesale Account Request";

    $admin_message = "<html><head></head><body><table width='600' style='background-color: transparent;'><tr><td width='100%'>";
    $admin_message .= "<p>A new customer is requesting a wholesale account on Medosi<br/><br/>";
    $admin_message .= "Name - ".$first_name." ".$last_name."<br/>";
    $admin_message .= "Email - ".$email."<br/>";
    $admin_message .= "Business Name - ".$company."<br/><br/>";
    $admin_message .= "Use the link below to see more information and to accept or decline this business as a wholesale account:<br/>";
    $admin_message .= "<a href='https://medosi.myshopify.com/admin/apps/medosi-customer-data'>Medosi Customer Data</a></p>";
    $admin_message .= "</td></tr></table></body></html>";

    $admin_headers = "MIME-Version: 1.0" . PHP_EOL;
    $admin_headers .= "Content-type:text/html; charset=UTF-8" . PHP_EOL;
    $admin_headers .= "From: Medosi <info@medosi.com>" . PHP_EOL;
    $admin_headers .= "Reply-To: Medosi <info@medosi.com>" . PHP_EOL;
    $admin_headers .= "Return-Path: Medosi <info@medosi.com>" . PHP_EOL;
    $admin_headers .= "X-Mailer: PHP/" . phpversion();

    if(mail($admin_to, $admin_subject, $admin_message, $admin_headers)){
        $admin_email_success = true;
    }

    // CUSTOMER EMAIL

    $user_to      = $email;
    $user_subject = "Wholesale Account Submission";

    $user_message = "<html><head></head><body><table width='600' style='background-color: transparent;'><tr><td width='100%'>";
    $user_message .= "<p>Hi ".$first_name.",<br/><br/>";
    $user_message .= "We have received your submission for a Medosi wholesale account. One of our representatives will review your submission and get back to you as soon as possible.<br/><br/>";
    $user_message .= "Thanks!<br/>";
    $user_message .= "Medosi Team";
    $user_message .= "</td></tr></table></body></html>";

    $user_headers = "MIME-Version: 1.0" . PHP_EOL;
    $user_headers .= "Content-type:text/html; charset=UTF-8" . PHP_EOL;
    $user_headers .= "From: Medosi <info@medosi.com>" . PHP_EOL;
    $user_headers .= "Reply-To: Medosi <info@medosi.com>" . PHP_EOL;
    $user_headers .= "Return-Path: Medosi <info@medosi.com>" . PHP_EOL;
    $user_headers .= "X-Mailer: PHP/" . phpversion();

    if(mail($user_to, $user_subject, $user_message, $user_headers)){
        $customer_email_success = true;
    }

    if($admin_email_success && $customer_email_success){
        error_log("Email notifications sent successfully!");
        echo "Success";
    } else {
        error_log("Email notifications not sent successfully!");
        echo "Error";
    }
}
?>
