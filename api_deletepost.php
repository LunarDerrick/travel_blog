<?php
require_once("init_db.php");
require_once("init_session.php");
require_once("init_check_logged_in.php");

# only run if is post
if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    # go back to previous page
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die; # prevent if browser dont respect redirect
}

if (empty($_POST["id"]) || !is_numeric($_POST["id"])){
    # go back to previous page
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die; # prevent if browser dont respect redirect
}

$postID = intval($_POST["id"]);
$userid = $_SESSION["userid"];

//prepare select query
$stmt = $conn -> prepare("SELECT userid FROM posts WHERE postid=?");
$stmt -> bind_param("i", $postID);

if (!$stmt->execute()){
    http_response_code(500);
    die;
}

$result = $stmt->get_result();
if ($result->num_rows){
    // get first result row
    $row = $result->fetch_assoc();
    if (intval($row["userid"]) !== intval($userid)){
        // userid for post doesnt match
        JSONresponse(403, ["status" => "Post not found"]);
        die;
    }
} else {
    // no post with given postid
    JSONresponse(401, ["status" => "Post not found"]);
    die;
}

// verification success

//prepare delete query
$stmt = $conn -> prepare("DELETE FROM posts WHERE postid=?");
$stmt -> bind_param("i", $postID);

if (!$stmt->execute()){
    http_response_code(500);
    die;
}
// userid for post doesnt match
JSONresponse(200, ["OK" => "Post deleted"]);
die;