<?php

if (!isset($_SESSION["username"])) {
    http_response_code(404);
    include('404.php'); // provide your own HTML for the error page
    die();
}