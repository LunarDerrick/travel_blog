<?php

// Basic connection settings
$databaseHost = 'localhost';
$databaseUsername = 'webdev';
$databasePassword = 'HKAkU8bowx.41@R_';
$databaseName = 'traveldb';

// Connect to the database
$conn = mysqli_connect($databaseHost, $databaseUsername, $databasePassword, $databaseName); 
// Check connection
if ($conn -> connect_error) {
    die("Connection failed: " . $conn -> connect_error);
}


// Sample code for access, delete before run
// $result = $conn -> query("SELECT * FROM users");
// var_dump($result -> fetch_assoc());


date_default_timezone_set('Asia/Kuala_Lumpur');