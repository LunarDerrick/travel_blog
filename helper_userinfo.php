<?php

/**
 * Find user in database and return user ID and password if found, or null if not. Only for internal use, do not expose to outside
 * @param mysqli_connection $conn database connection
 * @param string $username database connection
 * @return array of {userid=>"", password=>""} if found username, or null if not found
 */
function verifyUsername($conn, $username){
    $stmt = $conn->prepare("SELECT userid, password FROM users WHERE username=?");
    $stmt->bind_param("s", $username);
    if (!$stmt->execute()){
        return null;
    }
    $result = $stmt->get_result();
    if ($row = $result->fetch_assoc()){
        return $row;
    } else {
        return null;
    }
}