<?php
header("Access-Control-Allow-Origin: *");

// Run all functions
if (isset($_POST['email']) && !empty($_POST['email'])){
    $email_data = $_POST['email'];
    $email = json_decode($email_data, true);

    $customer_name = $email['email']['customer_name'];
    $customer_email = $email['email']['customer_email'];
    $status = $email['email']['status'];

    $msg = "Your wholesale account has been ".$status.". If you have any questions, please don't hesitate to contact us!";

    $to      = $customer_email;
    $subject = "Medosi Wholesale Account";

    $message = "<html><head></head><body><div style='width:100%;'>";
    $message .= "Hi " . $customer_name . ",<br/><br/>";
    $message .= $msg."<br/><br/>";
    $message .= "Best,<br/>";
    $message .= "Medosi Team";
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
        return "email did not send";
    } else {
        error_log("email successfully sent");
        return "email successfully sent!";
    }
    
}

?>
