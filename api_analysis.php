<?php
require_once("init_db.php");
require_once("init_session.php");
require_once("init_check_logged_in.php");

$userid = $_SESSION["userid"];
// fetch data from database
$myquery = "SELECT posts.postid, posts.userid, posts.location, AVG(ratings.rating) AS avg_rating
            FROM posts
            LEFT JOIN ratings
            ON posts.postid=ratings.postid
            WHERE posts.userid=$userid
            GROUP BY posts.postid";
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