<?php
// Initialize SQL fields
$servername = "localhost";
$username = "root";
$password = "";
$database = "clinica";

// Display errors
ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL & ~E_NOTICE);
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);
?>