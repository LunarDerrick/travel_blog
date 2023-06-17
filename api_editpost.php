<?php
require_once("init_db.php");
require_once("init_session.php");
require_once("init_check_logged_in.php");
require_once("helper/sanitisation.php");

# no id provided
if (!isset($_GET["id"]) || empty($_GET["id"])){
    http_response_code(404);
    include('404.php'); // provide your own HTML for the error page
    die();
}

$postid = intval($_GET["id"]) ?? die; // try to get integer value, or else die

# only run if is post
if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(404);
    include('404.php'); // provide your own HTML for the error page
    die; # prevent if browser dont respect redirect
}

# verify info
foreach (["title", "caption", "content", "location", "tags", "continent"] as $check) {
    if (empty($_POST[$check])){
        # go back to previous page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die; # prevent if browser dont respect redirect
    }
}

$newImageUploaded = false;
// check if new file is being uploaded
$uploadedFilePath = $_FILES["image"]["tmp_name"];
if (file_exists($uploadedFilePath) && $_FILES["image"]["error"] == 0) {
    // verify image uploaded
    if ($_FILES["image"]["error"]){
        # go back to previous page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die; # prevent if browser dont respect redirect
    }

    $validMime = array("image/jpeg", "image/png");
    // verify image type is png or jpg                  or  image size cannot be found (not image)
    if (!in_array($_FILES["image"]["type"], $validMime) || !getimagesize($_FILES["image"]["tmp_name"])) {
        # go back to previous page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die; # prevent if browser dont respect redirect
    }

    $uploadedFileHash = sha1_file($uploadedFilePath);
    // check if the file with the same hash already exists in the destination directory
    $existingFilePath = "uploads/" . $uploadedFileHash . "." . pathinfo($_FILES["image"]["name"], PATHINFO_EXTENSION);
    if (!file_exists($existingFilePath)) {
        // same file is being uploaded, handle the situation accordingly
        // upload file
        $path_parts = pathinfo($_FILES["image"]["name"]);
        $image_path = "uploads/" . sha1($path_parts['basename']) . "." . $path_parts['extension'];
        while(file_exists($image_path)){
            $image_path = "uploads/" . sha1($path_parts['basename'] . time()) . "." . $path_parts['extension'];
        }
        // move uploaded file to destination
        if (!move_uploaded_file($_FILES["image"]["tmp_name"], $image_path)){
            // failed to move
            JSONresponse(500, ["error" => "Upload failed"]);
            http_response_code(500);
            die;
        }
    }

    $newImageUploaded = true;
}

// match post variables with content type
$fields = [
    "title" => "string",
    "caption" => "string",
    "content" => "string",
    "location" => "string",
    "continent" => "string",
    "tags" => "string",
];

// sanitise inputs
$postvar = sanitize($_POST, $fields);
# only allow these tags to be used
$content = strip_tags($postvar["content"], '<table><thead><tbody><th><tr><td><br>');

if ($newImageUploaded){
    //prepare update query
    $query = $conn -> prepare("UPDATE Posts
    SET title=?, caption=?, content=?, location=?, continent=?, image=?, tag=? WHERE postid=?");
    
    $query -> bind_param("sssssssi", 
    $postvar["title"], $postvar["caption"], $content, $postvar["location"], $postvar["continent"], $image_path, $postvar["tags"], $postid);
} else {
    //prepare update query
    $query = $conn -> prepare("UPDATE Posts
    SET title=?, caption=?, content=?, location=?, continent=?, tag=? WHERE postid=?");
    
    $query -> bind_param("ssssssi", 
    $postvar["title"], $postvar["caption"], $content, $postvar["location"], $postvar["continent"], $postvar["tags"], $postid);
}

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
?>