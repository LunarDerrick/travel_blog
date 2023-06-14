<?php
require_once("init_db.php");
require_once("init_session.php");
require_once("init_check_logged_in.php");

// fetch data from database
$myquery = "SELECT * FROM posts";
try {
    $query = $conn->query($myquery);
} catch (Exception $e) {
    echo $e->getMessage();
    die;
}

// convert data to JS compatible
$data = array();
for ($x = 0; $x < $query->num_rows; $x++) {
    $data[] = $query->fetch_assoc();
}
echo json_encode($data);
?>