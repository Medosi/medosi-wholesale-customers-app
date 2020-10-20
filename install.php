<?php

// Set variables for our request
$shop = $_GET['shop'];
$api_key = "393d8bf7c74f42af8ca3e8f0e38db713";
$scopes = "read_customers, write_customers, read_themes, write_themes";
$redirect_uri = "https://medosi-privateapp.com/apps/customer_data/generate_token.php";

// Build install/approval URL to redirect to
$install_url = "https://" . $shop . "/admin/oauth/authorize?client_id=" . $api_key . "&scope=" . $scopes . "&redirect_uri=" . urlencode($redirect_uri);

// Redirect
header("Location: " . $install_url);
die();