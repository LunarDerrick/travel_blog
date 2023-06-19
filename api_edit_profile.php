<?php
require_once("init_db.php");
require_once("init_session.php");
require_once("init_check_logged_in.php");
require_once("helper/sanitisation.php");
include_once("helper_userinfo.php");

$userid = $_SESSION["userid"];

# only run if is post
if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(404);
    include('404.php'); // provide your own HTML for the error page
    die; # prevent if browser dont respect redirect
}

# verify info
foreach (["username", "name", "email"] as $check) {
    if (empty($_POST[$check])){
        JSONresponse(403, ["message" => "Profile is missing username, real name or email."]);
        die;
    }
}

$stmt = $conn->prepare("SELECT userid, username, password FROM users WHERE userid=? LIMIT 1");
$stmt->bind_param("i", $userid);
if (!$stmt->execute()){
    JSONresponse(500, ["message" => "Some error happened."]);
    die;
}
$result = $stmt->get_result();
$currentinfo = $result->fetch_object();

// verify password if new password or username is changed
if (!empty($_POST["newpassword"]) || $_POST["username"] != $currentinfo->username) {
    if (empty($_POST["oldpassword"])) {
        JSONresponse(401, ["message"=>"Please provide old password to change username or password."]);
        die;
    }
    // old password dont match
    if (!password_verify($_POST["oldpassword"], $currentinfo->password)) {
        JSONresponse(401, ["message"=>"Old password is incorrect."]);
        die;
    }
    // check if username taken
    if (verifyUsername($conn, $_POST["username"]) != null){
        JSONresponse(405, ["message"=>"Username is taken."]);
        die;
    }
}

// check if new file is being uploaded
$uploadedFilePath = $_FILES["image"]["tmp_name"];
if (file_exists($uploadedFilePath) && $_FILES["image"]["error"] == 0) {
    // verify image uploaded
    if ($_FILES["image"]["error"]){
        JSONresponse(415, ["message"=>"Profile picture is not valid."]);
        die;
    }

    $validMime = array("image/jpeg", "image/png");
    // verify image type is png or jpg                  or  image size cannot be found (not image)
    if (!in_array($_FILES["image"]["type"], $validMime) || !getimagesize($_FILES["image"]["tmp_name"])) {
        JSONresponse(415, ["message"=>"Profile picture is not valid."]);
        die;
    }

    // upload file
    $path_parts = pathinfo($_FILES["image"]["name"]);
    $image_path = "uploads/" . sha1($path_parts['basename']) . "." . $path_parts['extension'];
    while(file_exists($image_path)){
        $image_path = "uploads/" . sha1($path_parts['basename'] . time()) . "." . $path_parts['extension'];
    }
    // move uploaded file to destination
    if (!move_uploaded_file($_FILES["image"]["tmp_name"], $image_path)){
        // failed to move
        JSONresponse(500, ["message" => "Upload failed"]);
        die;
    }
}

// match profile variables with content type
$fields = [
    "username" => "string",
    "name" => "string",
    "email" => "string",
    "tel" => "string",
    "message" => "string",
    "oldpassword" => "string",
    "newpassword" => "string",
];

// sanitise inputs
$profilevar = sanitize($_POST, $fields);
// change to null
foreach(["tel", "message", "newpassword"] as $optionalfield){
    if (empty($profilevar[$optionalfield])) 
        $profilevar[$optionalfield] = null;
}
// hash password before store
if ($profilevar["newpassword"] != null){
    $profilevar["newpassword"] = password_hash($_POST["newpassword"], PASSWORD_BCRYPT, ['cost' => 12]);
} else {
    // store old password back
    $profilevar["newpassword"] = $currentinfo->password;
}

if(isset($image_path)){
    $query = $conn -> prepare("UPDATE users
        SET username = ?, password = ?, profilepic = ?, profileintro = ?, realname = ?, email = ?, telno = ?
        WHERE userid = ? ");

    $query -> bind_param("sssssssi", 
    $profilevar["username"], $profilevar["newpassword"], $image_path, $profilevar["message"], $profilevar["name"], $profilevar["email"], $profilevar["tel"], $userid);
} else {
    $query = $conn -> prepare("UPDATE users
        SET username = ?, password = ?, profileintro = ?, realname = ?, email = ?, telno = ?
        WHERE userid = ? ");

    $query -> bind_param("ssssssi", 
    $profilevar["username"], $profilevar["newpassword"], $profilevar["message"], $profilevar["name"], $profilevar["email"], $profilevar["tel"], $userid);
}

if ($query -> execute()){
    // update cached username
    if ($_POST["username"] != $currentinfo->username){
        $_SESSION["username"] = htmlentities($_POST["username"]);
        // update cookie username
        if (isset($_COOKIE["loginname"])){
            setcookie("loginname", $_POST["username"], time() + (86400 * 30), "/dev/");
        }
    }
    // form header for redirect
    JSONresponse(200, ["message" => "Your profile is updated."]);

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
    JSONresponse(500, ["message" => "Some error happened."]);
}
