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


/**
 * Find user in database and return user ID and password if found, or null if not.
 * @param mysqli_connection $conn database connection
 * @param string $username database connection
 * @return array of {userid=>"", password=>""} if found username, or null if not found
 */
function verifyUsername($conn, $username){
    $stmt = $conn->prepare("SELECT userid, password FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    if ($stmt->execute()){
        $result = $stmt->get_result();
        $row = $result->fetch_array(MYSQLI_ASSOC);
        return $row;
    } else {
        return null;
    }
}