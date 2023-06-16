<?php
require_once("init_db.php");
require_once("init_session.php");
require_once("init_check_logged_in.php");

$userid = $_SESSION["userid"];
// fetch data from database
$myquery = "SELECT *
            FROM users
            WHERE userid=$userid";
try {
    $query = $conn->query($myquery);
} catch (Exception $e) {
    echo $e->getMessage();
    die;
}

// save data into a usable php variable
for ($x = 0; $x < $query->num_rows; $x++) {
    $data = $query->fetch_assoc();
}
?>