<?php
$servername = "localhost";
$username = "jorgefco2";
$password = "3)3?,w77vT2P6t";
$db = "medosi_customer_data";

$conn = mysqli_connect($servername, $username, $password, $db);

if (!$conn) {
    die("Connection Error: " . mysqli_connect_error());
}
?>