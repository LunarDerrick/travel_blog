<?php
require_once("init_db.php");
require_once("init_session.php");
require_once("init_check_logged_in.php");

$userid = $_SESSION["userid"];
// prepare array to return data
$data = array();

// fetch post data by rating from database
$myquery = "SELECT posts.postid, title, caption, image, AVG(ratings.rating) AS avg_rating
            FROM posts
            LEFT JOIN ratings ON posts.postid=ratings.postid
            WHERE posts.userid= ?
            GROUP BY posts.postid
            ORDER BY avg_rating DESC
            LIMIT 5";
try {
    $query = $conn->prepare($myquery);
    $query->bind_param('s', $userid);
    $query->execute();
} catch (Exception $e) {
    echo $e->getMessage();
    die;
}
$result = $query->get_result();
while($row = $result->fetch_assoc()){
    $data["topposts"][] = $row;
}


// fetch post data by view count from database
$myquery = "SELECT posts.postid, title, caption, image, viewcount
            FROM posts
            WHERE posts.userid= ?
            ORDER BY viewcount DESC
            LIMIT 5";
try {
    $query = $conn->prepare($myquery);
    $query->bind_param('s', $userid);
    $query->execute();
} catch (Exception $e) {
    echo $e->getMessage();
    die;
}
$result = $query->get_result();
while($row = $result->fetch_assoc()){
    $data["mostviews"][] = $row;
}


// fetch post data by week from database
$myquery = "SELECT COUNT(*) AS total,
from_unixtime(posts.createdtime/1000, '%Y-%m-%d') AS postdate
FROM posts
WHERE userid = ?
AND posts.createdtime/1000 > UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 7 day))
GROUP BY postdate
ORDER BY postdate";
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
    $data["postweek"][] = $row;
}


// fetch rating data from database
$myquery = "SELECT ratings.rating, COUNT(ratings.rating) AS total
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


// fetch comment data from database
$myquery = "SELECT COUNT(*) AS total_count,
            from_unixtime(commenttime/1000, '%Y-%m-%d') AS commentdate
            FROM comments
            LEFT JOIN posts ON posts.postid=comments.postid
            WHERE posts.userid= ? 
            AND commenttime/1000 > UNIX_TIMESTAMP(DATE_SUB(NOW(), INTERVAL 7 day))
            AND comments.userid != ?
            GROUP BY commentdate
            ORDER BY commentdate";
try {
    $query = $conn->prepare($myquery);
    $query->bind_param('ss', $userid, $userid);
    $query->execute();
} catch (Exception $e) {
    echo $e->getMessage();
    die;
}

$result = $query->get_result();
while($row = $result->fetch_object()){
    $data["commentweek"][] = $row;
}

JSONresponse(200, $data)

?>