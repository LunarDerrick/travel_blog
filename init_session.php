<?php
session_name("Travalog");
session_start();

// only if not login
if (!isset($_SESSION) || empty($_SESSION["userid"])){
    // check cookie exist n verify
    if(isset($_COOKIE["logintoken"]) && isset($_COOKIE["loginname"])){
        $providedToken = strval($_COOKIE["logintoken"]);
        $providedUsername = strval($_COOKIE["loginname"]);
        
        // Get user info
        $query = $conn->prepare('SELECT userid, profilepic, token FROM users WHERE username=? LIMIT 1');
        $query->bind_param("s", $providedUsername);
        $query->execute();
        $result = $query->get_result();
        $user = $result->fetch_object();
        if (!empty($user) && !empty($user->userid) && !empty($user->token)) {
            if (hash_equals($user->token, $providedToken)){
                // verified the cookie is correct
                // log in user automatically
                
                $_SESSION["userid"] = $user->userid;
                $_SESSION["username"] = htmlentities($providedUsername);
                $_SESSION["pfp"] = $user->profilepic;
            }
        }
    }
}