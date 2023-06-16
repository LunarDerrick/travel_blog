<?php

/**
 * Build a HTML code for posts
 * @param object[] $posts posts to be converted to HTML
 * @param bool $edit false for standard view, true for editable buttons
 */
function buildHTMLPostPreview($posts, $edit=false){
    if ($posts == null) {
        if ($edit) 
            echo '<p style="">No posts here... Create one?</p>';
        else 
            echo '<p style="">Hmm... is that a seagull? There is no posts matching the search term.</p>';
            
        return;
    }

    foreach ($posts as $post) {
        $output = "";
        // image and header
        $title = htmlentities($post->title);
        $output .= <<< HEADERPOST
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 transform-on-hover">
                <picture>
                    <img src="$post->image" alt="Card Image" class="card-img-top">
                </picture>
                <div class="card-body">
                    <h6>$title</h6>
        HEADERPOST;
        // only for viewing
        if (!$edit) {
            // author
            $displayname = htmlentities(
                isset($post->realname) ? $post->realname : $post->username
            );
            $output .= '<small class="blockquote-footer mt-0">by ' . $displayname . '</small>';
            // star rating
            $output .= '<div class="container mt-1">';
            $rounded = round($post->avg_rating);
            for ($i = 0; $i < $rounded; $i++) {
                $output .= '<span class="fa fa-star checked"></span>';
            }
            for ($i = 0; $i < 5 - $rounded; $i++) {
                $output .= '<span class="fa fa-star"></span>';
            }
            $output .= '</div>';
        }
        // caption
        $caption = htmlentities($post->caption);
        $output .= '<p class="text-muted card-text mb-2">'.$caption.'</p>';

        // buttons
        if ($edit){
            // editable button
            $output .= <<< BUTTONSACTION
                    <div class="float-end">
                        <!-- use stretched-link class to make whole card clickable-->
                        <button onclick="window.location.href='edit_post.php?id=$post->postid';" class="fa fa-edit btn btn-lg btn-outline-primary stretched-link"></button>
                        <button class="fa fa-trash btn btn-lg btn-outline-danger" style="position: relative; z-index: 1000;" 
                        data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-postid="$post->postid" aria-hidden="true"></button>
                    </div>
            BUTTONSACTION;
        } else {
            $output .= '<a href="post.php?id=' . $post->postid . '" class="btn btn-outline-primary btn-rounded px-3 py-1 stretched-link"><small>View post</small></a>';
        }
        $output .= <<< ENDPOST
                </div>
            </div>
        </div>
        ENDPOST;

        echo $output;
    }
}

/**
 * Build a HTML code for pagination
 * @param Post[] $posts posts to be converted to HTML
 * @param bool $edit false for standard view, true for editable buttons
 */
function buildHTMLPagination($totalPosts, $currentPage = 1, $postsPerPage = 6, $showPageRange = 2) {
    //determine the total number of pages available  
    $numberOfPages = ceil($totalPosts / $postsPerPage);
    // if only 1 page dont need pagination
    if ($numberOfPages <= 1) return;

    $get = $_GET;
    unset($get["page"]);
    $newPagestart = "?" . http_build_query($get) . "&page=";
    
    $prev = $newPagestart . strval($currentPage - 1);
    echo <<< NAVHEADER
    <nav aria-label="Post list navigation">
        <ul class="pagination justify-content-center">
            <li class="page-item">
                <a class="page-link" href="$prev" aria-label="Previous">
                    <span aria-hidden="true">&laquo;</span>
                </a>
            </li>
    NAVHEADER;

    if ($currentPage == 1){
        echo '<li class="page-item active"><a class="page-link" href="' . $newPagestart.'1' . '">1</a></li>';
    } else {
        echo '<li class="page-item"><a class="page-link" href="' . $newPagestart.'1' . '">1</a></li>';
    }

    if ($numberOfPages < 8){
        // directly echo if less than 8 pages total
        for ($i = 2; $i < $numberOfPages; $i++){
            if ($currentPage == $i){
                echo '<li class="page-item active"><a class="page-link" href="' . $newPagestart.strval($i) . '">' . strval($i) . '</a></li>';
            } else {
                echo '<li class="page-item"><a class="page-link" href="' . $newPagestart.strval($i) . '">' . strval($i) . '</a></li>';
            }
        }
    } else {
        //hide pages if current too far away from page 1
        /**eg:
        (1) 2 3...
        1 (2) 3 4 ...
        1 2 (3) 4 5 ...
        1 2 3 (4) 5 6...
        1 ... 3 4 (5) 6 7...
         * current - page 1 must be further than $showPageRange + 1
         */
        if (($currentPage - 1) > $showPageRange + 1)
            echo '<li class="page-item">...</li>';

        // show current page and prev/next n pages, n = $showPageRange
        for ($i = $currentPage - $showPageRange; $i <= $currentPage + $showPageRange; $i++){
            if ($i <= 1) continue; //skip negative and page 1
            if ($i >= $numberOfPages) continue; //skip last few pages
            if ($currentPage == $i){
                echo '<li class="page-item active"><a class="page-link" href="' . $newPagestart.strval($i) . '">' . strval($i) . '</a></li>';
            } else {
                echo '<li class="page-item"><a class="page-link" href="' . $newPagestart.strval($i) . '">' . strval($i) . '</a></li>';
            }
        }

        // same as above, just from end
        if (($numberOfPages - $currentPage) > $showPageRange + 1)
            echo '<li class="page-item">...</li>';
    }
    
    if ($currentPage == $numberOfPages){
        echo '<li class="page-item active"><a class="page-link" href="' . $newPagestart.strval($numberOfPages) . '">' . strval($numberOfPages) . '</a></li>';
    } else {
        echo '<li class="page-item"><a class="page-link" href="' . $newPagestart.strval($numberOfPages) . '">' . strval($numberOfPages) . '</a></li>';
    }
    
    $next = $newPagestart . strval($currentPage + 1);
    echo <<< NAVFOOTER
            <li class="page-item">
                <a class="page-link" href="$next" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
                </a>
            </li>
        </ul>
    </nav>
    NAVFOOTER;
}

function listMyPostPreview($conn, ){
    $userid = $_SESSION["userid"];
    // prepare select query
    $stmt = $conn->prepare("SELECT posts.postid, title, caption, image, realname, username, AVG(ratings.rating) AS avg_rating,
      (SELECT count(*) FROM posts WHERE posts.userid= ? ) AS postCount
    FROM posts 
    LEFT JOIN ratings ON posts.postid=ratings.postid 
    LEFT JOIN users ON posts.userid=users.userid
    WHERE posts.userid= ?
    GROUP BY posts.postid
    ORDER BY createdtime DESC");
    $stmt->bind_param("ss", $userid, $userid);
    if (!$stmt->execute()){
        return null;
    }

    $result = $stmt->get_result();
    if ($result->num_rows){
        $count = 0;
        while($row = $result->fetch_object()){
            // use [] format to add to last item in PHP
            $resultarr[] = $row;
            $count = $row->postCount;
        }
        return array($resultarr, $count);
    } else {
        return null;
    }
}
