<?php
require_once("init_db.php");
require_once("init_session.php");

# only run if is post
if ($_SERVER['REQUEST_METHOD'] !== 'POST'){
    http_response_code(404);
    include('404.php'); // provide your own HTML for the error page
    die; # prevent if browser dont respect redirect
}

// get userid if logged in
if (isset($_SESSION["userid"]))
    $userid = $_SESSION["userid"];
else
    $userid = null;

# verify info
foreach (["firstname", "lastname", "email", "tel", "message"] as $check) {
    if (empty($_POST[$check])){
        JSONresponse(403, ["message" => "Not all fields are provided."]);
        die;
    }
}

$stmt = $conn->prepare("INSERT INTO contact (firstname, lastname, email, telno, message, userid)
VALUES (?, ?, ?, ?, ?, ?)");
$stmt->bind_param("sssssi", $_POST["firstname"], $_POST["lastname"], $_POST["email"], $_POST["tel"], $_POST["message"], $userid);
if (!$stmt->execute()){
    JSONresponse(500, ["message" => "Some error happened."]);
    die;
}


JSONresponse(200, ["message" => "Thank you for your feedback."]);
die;