<?php

if (!isset($_SESSION["username"])) {
    http_response_code(404);
    //include('my_404.html'); // provide your own HTML for the error page
    die();
}