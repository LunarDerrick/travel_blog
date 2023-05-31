<?php
require_once("init_db.php");
require_once("init_session.php");
require_once("init_check_logged_in.php");
require_once("helper/sanitisation.php");

# only run if is post
if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    # go back to previous page
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die; # prevent if browser dont respect redirect
}

# verify info
foreach (["title", "caption", "content", "location", "tags"] as $check) {
    if (empty($_POST[$check])){
        # go back to previous page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die; # prevent if browser dont respect redirect
    }
}

// match post variables with content type
$fields = [
    "title" => "string",
    "caption" => "string",
    "content" => "string",
    "location" => "string",
    "tags" => "string",
];

// sanitise inputs
$postvar = sanitize($_POST, $fields);
# only allow these tags to be used
$content = strip_tags($postvar["content"], '<table><thead><tbody><th><tr><td><br>');

$userid = $_SESSION["userid"];
$currenttime = round(microtime(TRUE) * 1000); // epoch timestamp
$avgrating = 0;
$file = "";

//prepare insert query
$query = $conn -> prepare("INSERT INTO Posts (userid, title, caption, content, location, image, tag, createdtime, avg_rating) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

$query -> bind_param("issssssii", 
$userid, $postvar["title"], $postvar["caption"], $content, $postvar["location"], $file, $postvar["tags"], $currenttime, $avgrating);

if ($query -> execute()){
    // form header for redirect
    header("Location: my_posts.php?done=1");

    // another method to send POST data
    // echo '<form id="redirect" action="my_posts.php" method="post">';
    // echo '<input type="hidden" name="done" value=1>';
    // echo <<< TEXT
    // </form>
    // <script type="text/javascript">
    //     document.getElementById('redirect').submit();
    // </script>
    // TEXT;
} else {
    http_response_code(500);
}
