<?php
require_once("init_db.php");
require_once("init_session.php");

// Expire the renew token
try {
    $q = $conn->prepare('UPDATE users SET token=? WHERE userid=?');
    $q->execute([null, $_SESSION['userid']]);
} catch (Exception $e) {
    // Do nothing
}

// unset variable
$_SESSION["userid"] = null;
$_SESSION["username"] = null;
// Destroy the session
session_destroy();

// redirect back to homepage
header("Location: .");
die; # prevent if browser dont respect redirect