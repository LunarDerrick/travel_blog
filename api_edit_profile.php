<?php
require_once("init_db.php");
require_once("init_session.php");
require_once("init_check_logged_in.php");
require_once("helper/sanitisation.php");

# only run if is post
if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(404);
    include('404.php'); // provide your own HTML for the error page
    die; # prevent if browser dont respect redirect
}

# verify info
foreach (["username", "name", "email"] as $check) { // "tel", "message", "oldpassword", "newpassword" are optional
    echo $_POST[$check] . "<br>"; // debug show output
    if (empty($_POST[$check])){
        # go back to previous page
        // header('Location: ' . $_SERVER['HTTP_REFERER']);
        die; # prevent if browser dont respect redirect
    }
}
echo "username name email passed<br>";

// verify password
echo "old: " . $_POST["oldpassword"] . "<br>";
echo "new: " . $_POST["newpassword"] . "<br>";
if (!empty($_POST["oldpassword"]) || !empty($_POST["newpassword"])) {
    if (empty($_POST["oldpassword"]) || empty($_POST["newpassword"])) {
        echo <<< TEXT
        <script>
            alert('fill in both password fields to change!');
            document.location='my_profile.php'
        </script> 
        TEXT;
    }
}

// verify image uploaded
echo "img name: " . $_FILES["image"]["name"] . "<br>";
echo "img size: " . $_FILES["image"]["size"] . "<br>";
echo "img type: " . $_FILES["image"]["type"] . "<br>";
echo "img tmp: " . $_FILES["image"]["tmp_name"] . "<br>";
echo "img err: " . $_FILES["image"]["error"] . "<br>";
if ($_FILES["image"]["error"]){
    echo "upload fail" . "<br>";
    # go back to previous page
    // header('Location: ' . $_SERVER['HTTP_REFERER']);
    die; # prevent if browser dont respect redirect
}
echo "upload pass" . "<br>";

$validMime = array("image/jpeg", "image/png");
// verify image type is png or jpg                  or  image size cannot be found (not image)
if (!in_array($_FILES["image"]["type"], $validMime) || !getimagesize($_FILES["image"]["tmp_name"])) {
    echo "file type wrong" . "<br>";
    # go back to previous page
    // header('Location: ' . $_SERVER['HTTP_REFERER']);
    die; # prevent if browser dont respect redirect
}
echo "file type correct" . "<br>";

// // upload file
// $path_parts = pathinfo($_FILES["image"]["name"]);
// $image_path = "uploads/" . sha1($path_parts['basename']) . "." . $path_parts['extension'];
// while(file_exists($image_path)){
//     $image_path = "uploads/" . sha1($path_parts['basename'] . time()) . "." . $path_parts['extension'];
// }
// // move uploaded file to destination
// if (!move_uploaded_file($_FILES["image"]["tmp_name"], $image_path)){
//     // failed to move
//     JSONresponse(500, ["error" => "Upload failed"]);
//     http_response_code(500);
//     die;
// }

// // match post variables with content type
// $fields = [
//     "title" => "string",
//     "caption" => "string",
//     "content" => "string",
//     "location" => "string",
//     "continent" => "string",
//     "tags" => "string",
// ];

// // sanitise inputs
// $postvar = sanitize($_POST, $fields);
// # only allow these tags to be used
// $content = strip_tags($postvar["content"], '<table><thead><tbody><th><tr><td><br>');

// $userid = $_SESSION["userid"];
// $currenttime = round(microtime(TRUE) * 1000); // epoch timestamp

// //prepare insert query
// $query = $conn -> prepare("INSERT INTO Posts (userid, title, caption, content, location, continent, image, tag, createdtime) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

// $query -> bind_param("isssssssi", 
// $userid, $postvar["title"], $postvar["caption"], $content, $postvar["location"], $postvar["continent"], $image_path, $postvar["tags"], $currenttime);

if ($query -> execute()){
    // form header for redirect
    // header("Location: my_profile.php?done=1");

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
