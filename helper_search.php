<?php

/**
 * Use $get variable from search_result.php to search the database and return a list of all posts that match the query
 */
function search($conn, $get, $postPerPage = 6){
    $queryCountTotal = "SELECT count(*) AS postCount FROM posts LEFT JOIN users ON posts.userid=users.userid";
    $queryPosts = "SELECT posts.postid, title, caption, image, realname, username, AVG(ratings.rating) AS avg_rating
    FROM posts 
    LEFT JOIN ratings ON posts.postid=ratings.postid 
    LEFT JOIN users ON posts.userid=users.userid";

    if (isset($get["keyword"]) && isset($get["type"])){
        // prepare variable to bind later
        $keyword = '%'.$get["keyword"].'%';

        // prepare search statement
        switch($get["type"]){
            case "Everything":
                $search_query = null;
                $word = $conn->real_escape_string($get["keyword"]);
                foreach (["title", "caption", "location", "continent", "username", "realname", "tag"] as $colname){
                    if(is_null($search_query)){
                        $search_query = " WHERE $colname LIKE '%$word%'";
                    }else{
                        $search_query .= " OR $colname LIKE '%$word%'";
                    }     
                }
                $queryCountTotal .= $search_query;
                $queryPosts .= $search_query;
                break;
            case "Topic":
                $queryCountTotal .= " WHERE title LIKE ? OR caption LIKE ?";
                $queryPosts .= " WHERE title LIKE ? OR caption LIKE ?";
                break;
            case "Location":
                $queryCountTotal .= " WHERE location LIKE ? OR continent LIKE ?";
                $queryPosts .= " WHERE location LIKE ? OR continent LIKE ?";
                break;
            case "Author":
                $queryCountTotal .= " WHERE username LIKE ? OR realname LIKE ?";
                $queryPosts .= " WHERE username LIKE ? OR realname LIKE ?";
                break;
            case "Tag":
                $queryCountTotal .= " WHERE tag LIKE ? OR tag LIKE ?";
                $queryPosts .= " WHERE tag LIKE ? OR tag LIKE ?";
                break;
            default:
                break;
        }
    }
    
    if (isset($get["continent"])){
        // prepare variable to bind later
        $continent = '%'.$get["continent"].'%';

        // if contains WHERE is search query
        if (strpos($queryCountTotal, "WHERE") !== false) {
            $queryCountTotal .= " AND continent = ?";
            $queryPosts .= " AND continent = ?";
        } else {
            $queryCountTotal .= " WHERE continent = ?";
            $queryPosts .= " WHERE continent = ?";
        }
    }

    $queryCountTotal .= " GROUP BY posts.postid ORDER BY createdtime DESC ";
    $queryPosts .= " GROUP BY posts.postid ORDER BY createdtime DESC ";

    //for pagination
    $page = intval($get["page"]) - 1;
    $startRecord = $page * $postPerPage;
    $queryPosts .= " LIMIT ". $startRecord . ", " . $postPerPage;

    //get number of question marks, ascii for ? = 63
    $bindparamcount = count_chars($queryCountTotal, 0)[63];

    $stmtCount = $conn->prepare($queryCountTotal);
    $stmtPosts = $conn->prepare($queryPosts);

    switch($bindparamcount){
        case 3:
            // keyword + continent search
            $stmtCount->bind_param("sss", $keyword, $keyword, $continent);
            $stmtPosts->bind_param("sss", $keyword, $keyword, $continent);
            break;
        case 2:
            // only keyword search
            $stmtCount->bind_param("ss", $keyword, $keyword);
            $stmtPosts->bind_param("ss", $keyword, $keyword);
            break;
        case 1:
            // only continent
            $stmtCount->bind_param("s", $continent);
            $stmtPosts->bind_param("s", $continent);
            break;
        case 0:
            // no param
        default:
            break;
    }

    // count how many rows will be affected
    if(!$stmtCount->execute()){
        http_response_code(500);
        die;
    }
    $resultObj = $stmtCount->get_result()->fetch_object();
    if (!empty($resultObj))
        $resultCount = $resultObj->postCount;
    else 
        // no result
        return array(array(), 0);
    
    // get the exact posts
    if(!$stmtPosts->execute()){
        http_response_code(500);
        die;
    }
    $result = $stmtPosts->get_result();
    $resultPosts = array();
    while($row = $result->fetch_object()){
        $resultPosts[] = $row;
    }

    return array($resultPosts, $resultCount);
}