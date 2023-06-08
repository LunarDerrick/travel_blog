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
    if (!$stmt->execute()){
        return null;
    }
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()){
        return $row;
    } else {
        return null;
    }
}

/**
 * Return JSON response given a variable
 * @param int $code HTTP status code
 * @param array $data named array to return in JSON
 */
function JSONresponse($code, $data = null){
    header("Content-Type: application/json");
    switch(floor($code/100)){
        case 2: $ret_json = array("OK" => array("code" => $code)); break;
        case 4: $ret_json = array("error" => array("code" => $code)); break;
        case 5: $ret_json = array("error" => array("code" => $code)); break;
        default:$ret_json = array("unknown" => array("code" => $code)); break;
    }
    if(!empty($data)){
        switch(floor($code/100)){
            case 2: 
                foreach($data as $key => $val) {
                    $ret_json[$key] = $val;
                } break;
            case 4: $ret_json["data"] = $data; break;
            case 5: $ret_json["data"] = $data; break;
            default:$ret_json["data"] = $data; break;
        }
    }
    echo json_encode($ret_json); //output json as response body
    http_response_code($code);
    exit;
}