<?php
require_once "init_db.php";
require_once "helper_userinfo.php";

# only run if is set
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if (isset($_POST['usernameverify'])){
        $check = verifyUsername($conn, $_POST['usernameverify']);
        if ($check == null){
            JSONresponse(202, array("status" => "Username available"));
        } else {
            JSONresponse(406, array("status" => "Username taken"));
        }
    } else {
        http_response_code(404);
        include('404.php'); // provide your own HTML for the error page
        die();
    }
} else {
    http_response_code(404);
    include('404.php'); // provide your own HTML for the error page
    die();
}
