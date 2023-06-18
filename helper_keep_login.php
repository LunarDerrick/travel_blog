<?php

function keepUserLoggedIn($conn, $userID, $username){
    // Generate renew token
    $renew_token = bin2hex(random_bytes(64));

    $query = $conn->prepare('UPDATE users SET token=? WHERE userid=?');
    $query->bind_param("si", $renewtoken, $userID);
    $result = $query->execute();

    if (!$result) {
        http_response_code(500);
        return;
    }

    // store token as cookie for 30 days
    setcookie("logintoken", $renew_token, time() + (86400 * 30), "/dev/");
    setcookie("loginname", $username, time() + (86400 * 30), "/dev/");
}