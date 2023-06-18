<?php
require_once("init_db.php");
require_once("init_session.php");

// Expire the renew token
try {
    $token = null;
    $q = $conn->prepare('UPDATE users SET token=? WHERE userid=?');
    $q->bind_param("ii", $token, $_SESSION['userid']);
    $q->execute();
} catch (Exception $e) {
    // Do nothing
}

// unset variable
$_SESSION["userid"] = null;
$_SESSION["username"] = null;
// Destroy the session
session_destroy();

// unset cookie
setcookie("logintoken", "", time() - (86400 * 30), "/dev/");
setcookie("loginname", "", time() - (86400 * 30), "/dev/");

// redirect back to homepage
header("Location: .");
die; # prevent if browser dont respect redirect