<?php

class Post {
    public int $postID;
    public string $imageURL;
    public string $title, $caption;
    public $rating;
    
    function __construct(int $postID, string $title, string $caption, string $imageURL, $rating){
        $this->postID = $postID;
        $this->title = $title;
        $this->caption = $caption;
        $this->imageURL = $imageURL;
        $this->rating = $rating;
    }
}

/**
 * Build a HTML code for posts
 * @param Post[] $posts posts to be converted to HTML
 * @param bool $edit false for standard view, true for editable buttons
 */
function buildHTMLPostPreview($posts, $edit=false){
    if ($posts == null) {
        if ($edit) 
            echo '<p style="">No posts here... Create one?</p>';
        else 
            echo "Hmm... is that a seagull? There is no posts matching the search term.";
            
        return;
    }

    foreach ($posts as $post) {
        $output = "";
        // image and header
        $output .= <<< HEADERPOST
        <div class="col-md-6 col-lg-4">
            <div class="card border-0 transform-on-hover">
                <picture>
                    <img src="$post->imageURL" alt="Card Image" class="card-img-top">
                </picture>
                <div class="card-body">
                    <h6>$post->title</h6>
        HEADERPOST;
        // rating only for viewing
        if (!$edit) {
            $output .= '<div class="container mt-1">';
            $rounded = round($post->rating);
            for ($i = 0; $i < $rounded; $i++) {
                $output .= '<span class="fa fa-star checked"></span>';
            }
            for ($i = 0; $i < 5 - $rounded; $i++) {
                $output .= '<span class="fa fa-star"></span>';
            }
            $output .= '</div>';
        }
        // caption
        $output .= '<p class="text-muted card-text mb-2">'.$post->caption.'</p>';

        // buttons
        if ($edit){
            // editable button
            $output .= <<< BUTTONSACTION
                    <div class="float-end">
                        <!-- use stretched-link class to make whole card clickable-->
                        <a href="edit_post.php?id=$post->postID" class="fa fa-edit btn btn-lg btn-outline-primary stretched-link"></a>
                        <a href="#" class="fa fa-trash btn btn-lg btn-outline-danger" style="position: relative; z-index: 1000;" data-bs-toggle="modal" data-bs-target="#deleteModal" data-bs-postid="$post->postID" aria-hidden="true"></a>
                    </div>
            BUTTONSACTION;
        } else {
            $output .= '<a href="post.php?id=' . $post->postID . '" class="btn btn-outline-primary btn-rounded px-3 py-1 stretched-link"><small>View post</small></a>';
        }
        $output .= <<< ENDPOST
                </div>
            </div>
        </div>
        ENDPOST;

        echo $output;
    }
}

function listMyPostPreview($conn){
    $userid = $_SESSION["userid"];
    // prepare select query
    $stmt = $conn->prepare("SELECT postid, title, caption, image, avg_rating FROM posts WHERE userid=?");
    $stmt->bind_param("s", $userid);
    if (!$stmt->execute()){
        return null;
    }

    $result = $stmt->get_result();
    if ($result->num_rows){
        while($row = $result->fetch_assoc()){
            // use [] format to add to last item in PHP
            $resultarr[] = new Post($row["postid"], $row["title"], $row["caption"], $row["image"], $row["avg_rating"]);
        }
        return $resultarr;
    } else {
        return null;
    }
}