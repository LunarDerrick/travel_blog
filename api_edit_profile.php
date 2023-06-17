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
foreach (["username", "name", "email"] as $check) {
    if (empty($_POST[$check])){
        # go back to previous page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die; # prevent if browser dont respect redirect
    }
}

// verify password
if (!empty($_POST["oldpassword"]) || !empty($_POST["newpassword"])) {
    if (empty($_POST["oldpassword"]) || empty($_POST["newpassword"])) {
        echo <<< TEXT
        <script>
            alert('fill in both password fields to change!');
            document.location='my_profile.php'
        </script> 
        TEXT;
    } else if ($_POST["oldpassword"] !== $_POST["newpassword"]) {
        echo <<< TEXT
        <script>
            alert('password not matched!');
            document.location='my_profile.php'
        </script> 
        TEXT;
    }
}

$validMime = array("image/jpeg", "image/png");
// verify image type is png or jpg                  or  image size cannot be found (not image)
if (!in_array($_FILES["image"]["type"], $validMime) || !getimagesize($_FILES["image"]["tmp_name"])) {
    # go back to previous page
    echo <<< TEXT
    <script>
        alert('no photo uploaded');
        document.location='my_profile.php'
    </script> 
    TEXT;
    die; # prevent if browser dont respect redirect
}

// upload file
$uploadedFilePath = $_FILES["image"]["tmp_name"];
if (file_exists($uploadedFilePath)) {

}
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
# only allow these tags to be used
$content = strip_tags($profilevar["message"], '<table><thead><tbody><th><tr><td><br>');

$userid = $_SESSION["userid"];
$currenttime = round(microtime(TRUE) * 1000); // epoch timestamp

//prepare edit query
// $query = $conn -> prepare(
//     "UPDATE users
//     SET username = ".$_POST["username"].
//     ", password = ".$_POST["newpassword"].
//     ", profilepic = ".$_FILES["image"]["tmp_name"].
//     ", profileintro = ".$_POST["message"].
//     ", realname = ".$_POST["name"].
//     ", email = ".$_POST["email"].
//     ", telno = ".$_POST["tel"].
//     "WHERE userid = ".$userid.";"
// );
// 
// $query -> bind_param("isssssssi", 
// $userid, $profilevar["username"], $profilevar["newpassword"], $image_path, $profilevar["message"], $profilevar["name"], $profilevar["email"], $profilevar["telno"]);

// if ($query -> execute()){
if (empty($query)){
    // form header for redirect
    header("Location: my_profile.php?done=1");

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
