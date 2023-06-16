<?php
require_once("init_db.php");
require_once("init_session.php");
require_once("init_check_logged_in.php");

$userid = $_SESSION["userid"];
// fetch post data from database
$myquery = "SELECT posts.postid, title, caption, image, viewcount, AVG(ratings.rating) AS avg_rating
            FROM posts
            LEFT JOIN ratings ON posts.postid=ratings.postid
            WHERE posts.userid= ?
            GROUP BY posts.postid
            ORDER BY avg_rating DESC";
try {
    $query = $conn->prepare($myquery);
    $query->bind_param('s', $userid);
    $query->execute();
} catch (Exception $e) {
    echo $e->getMessage();
    die;
}

// convert data to JS compatible
$data = array();
$result = $query->get_result();
while($row = $result->fetch_object()){
    $data["posts"][] = $row;
}


// fetch rating data from database
$myquery = "SELECT ratings.rating, COUNT(ratings.rating) AS total_count
            FROM posts
            LEFT JOIN ratings ON posts.postid=ratings.postid
            WHERE posts.userid= ?
            GROUP BY rating";
try {
    $query = $conn->prepare($myquery);
    $query->bind_param('s', $userid);
    $query->execute();
} catch (Exception $e) {
    echo $e->getMessage();
    die;
}

$result = $query->get_result();
while($row = $result->fetch_object()){
    $data["rating"][] = $row;
}

JSONresponse(200, $data)

?>