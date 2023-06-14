<!DOCTYPE html>
<html lang="en">

<?php
require_once("init_db.php");
require_once("init_session.php");

# only run if is set
if ($_SERVER['REQUEST_METHOD'] !== 'GET'){
    http_response_code(404);
    include('404.php');
    die();
}

# no id provided
if (!isset($_GET["id"]) || empty($_GET["id"])){
    http_response_code(404);
    include('404.php'); // provide your own HTML for the error page
    die();
}

$postid = intval($_GET["id"]) ?? die; // try to get integer value, or else die

$stmt = $conn->prepare("SELECT posts.postid, title, caption, content, location, image, tag, createdtime, viewcount, username, realname, rating AS user_rating, AVG(ratings.rating) AS avg_rating
 FROM posts 
 JOIN users ON posts.userid=users.userid 
 JOIN ratings ON posts.postid=ratings.postid
 WHERE posts.postid = ?");
$stmt->bind_param("i", $postid);
if (!$stmt->execute()){
    http_response_code(500);
    die;
}
$result = $stmt->get_result();
if ($row = $result->fetch_object()){
    $post = $row;
} else {
    http_response_code(500);
    die;
}
?>

<head>
    <title>Travalog - <?php echo htmlentities($post->title); ?></title>

    <!--Bootstrap implementation-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initialscale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <!-- Google fonts - Open Sans-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">

    <!-- Theme stylesheet-->
    <link rel="stylesheet" href="https://d19m59y37dris4.cloudfront.net/blog/2-0/css/style.default.622904dd.css"
        id="theme-stylesheet">
    <!--CSS overwrite-->
    <link rel="stylesheet" href="css/main.css">
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-white border-bottom py-2 fixed-top">
        <div class="container pt-1">
            <h1>
                <a class="navbar-brand text-md fw-bold text-dark" href="index.php">Travalog</a>
            </h1>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                    <li class="nav-item"><a class="nav-link " href="index.php">Home</a>
                    </li>
                    <li class="nav-item"><a class="nav-link " href="browse.php">Browse</a>
                    </li>
                    <li class="nav-item"><a class="nav-link " href="search.php">Search</a>
                    </li>
                    <li class="nav-item"><a class="nav-link " href="contact.php">Contact</a>
                    </li>
                    <?php
                    if (isset($_SESSION["username"])) {
                        $username = $_SESSION["username"];
                        ## multiline syntax, use <<< TAG and TAG;
                        echo <<< LOGIN
                        <li class="nav-item"><a class="nav-link " href="my_posts.php">My Posts</a></li>
                        <li class="nav-item dropdown">
                            <a class="btn btn-style btn-dark ms-2 px-3 py-2 dropdown-toggle " href="#" id="navbarUserMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                @$username
                            </a>

                            <ul class="dropdown-menu" aria-labelledby="navbarUserMenuLink">
                                <li><a class="dropdown-item" href="analysis.php">Analysis</a></li>
                                <li><a class="dropdown-item" href="my_profile.php">Edit profile</a></li>
                                <li><a class="dropdown-item" href="logout.php">Log out</a></li>
                            </ul>
                        </li>
                        LOGIN;
                    } else {
                        ## multiline syntax, use <<< TAG and TAG;
                        echo <<< OUTSIDE
                        <li class="nav-item"><a class="nav-link " href="login.php">Login</a></li>
                        <li class="nav-item "><a class="btn btn-style btn-dark ms-2 px-3 py-2 " href="register.php">Sign Up</a></li>
                        OUTSIDE;
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>


    <section class="pt-1">
        <div class="mt-0">

            <!-- header background image -->
            <div class="mb-4" style="height: 300px;
            background-image: url('<?php echo $post->image; ?>');
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;">
            </div>

            <!-- blog post content -->
            <div class="article-section container-sm pb-4">
                
                <div class="float-end me-2">
                    <?php
                        $rounded = round($post->avg_rating);
                        for ($i = 0; $i < $rounded; $i++) {
                            echo '<span class="fa fa-star checked"></span>';
                        }
                        for ($i = 0; $i < 5 - $rounded; $i++) {
                            echo '<span class="fa fa-star"></span>';
                        }
                    ?>
                </div>
                <!-- header, author -->
                <h2 id="article-header">
                    <?php echo htmlentities($post->title); ?>
                </h2>
                <p id="article-author" class="d-inline">by 
                    <?php echo htmlentities(
                        isset($post->realname) ? $post->realname: $post->username
                    ); ?>
                </p> 
                | <p id="article-date" class="d-inline"><?php echo date("Y-m-d H:i", substr($post->createdtime, 0, -3)); ?></p>
                <br>
                <p id="article-location" class="mt-1"><i class="fa fa-location-dot h6"></i> <?php echo htmlentities($post->location); ?></p>

                <!-- article -->
                <h5 id="article-subtitle" class="lead mt-4">
                    <?php echo htmlentities($post->title); ?>
                    <br>
                    <small>
                        <?php echo htmlentities($post->caption); ?>
                    </small>
                </h5>

                <article id="article" class="mb-4 center-block">
                    <?php
                        include_once("helper/Parsedown.php");
                        $Parsedown = new Parsedown();
                        echo $Parsedown->text(htmlentities($post->content));
                    ?>
                </article>

                <!-- tags -->
                <div class="container p-0">
                    <?php 
                        $tags = $post->tag;
                        foreach (explode(",", $tags) as $tag) {
                            $tag = trim(htmlentities($tag));
                            echo '<a href="seach_result?keyword='.$tag.'" class="tags btn btn-sm btn-outline-secondary mx-1 my-1">'.$tag.'</a>';
                        }
                    ?>
                </div>
            </div>

            <!--comment section-->
            <div class="comment-section container-sm align-items-middle pt-4">
                <h6>Comments</h6>
                <div class="list">
                    <!-- one comment -->
                    <div class="comment-item d-flex py-3">
                        <!-- pfp and user info-->
                        <div class="comment-user d-flex overflow-hidden pe-4">
                            <div class="user-image"><img src="image/profile_man.jpeg" alt="man"></div>
                            <div class="user-meta">
                                <div class="name">Alex</div>
                                <div class="day small">13 days ago</div>
                            </div>
                        </div>
                        <div class="comment-post">Thank you for the suggestion. Love it there.</div>
                    </div>

                </div>

                <div class="comment-box py-3 overflow-hidden">
                    <!--star rating-->
                    <div class="star-widget float-end">
                        <span class="subtitle me-2">Your rating</span>
                        <form action="" id="rating-form">
                        <input type="radio" name="rate" id="rate-5" value="5">
                        <label for="rate-5" class="fa fa-star"></label>
                        <input type="radio" name="rate" id="rate-4" value="4">
                        <label for="rate-4" class="fa fa-star"></label>
                        <input type="radio" name="rate" id="rate-3" value="3">
                        <label for="rate-3" class="fa fa-star"></label>
                        <input type="radio" name="rate" id="rate-2" value="2">
                        <label for="rate-2" class="fa fa-star"></label>
                        <input type="radio" name="rate" id="rate-1" value="1">
                        <label for="rate-1" class="fa fa-star"></label>
                        </form>
                    </div>

                    <div class="comment-user py-2 d-flex">
                        <div class="user-image"><img src="image/profile_woman.jpg" alt="woman"></div>
                        <div class="name">Rachel</div>
                    </div>
                    
                    <form action="" id="comment-form" method="post" class="m-2">
                        <textarea name="comment" id="comment" class="w-100 p-2" rows="4"
                            placeholder="Type your message here..."></textarea>
                        <button type="submit" class="btn btn-dark float-end">Comment</button>
                    </form>
                </div>
            </div>
        </div>
    </section>
    <br>

    <footer>
        <div class="copyrights text-white py-4" style="background: #090909">
            <div class="container">
                <div class="row text-center gy-2">
                    <div class="col-md-12">
                        <p class="mb-0 fw-light text-sm">Copyright &copy;2023. All rights reserved.</p>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- items for notification toast -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <!-- JavaScript for star widget -->
    <script>
        var notyf = new Notyf()

        const rateWidgets = document.getElementsByName("rate")
        rateWidgets.forEach(widget => {
            widget.onclick = (e) => {
                var selectedRating = document.getElementById("rating-form")["rate"].value
                var xhttp = new XMLHttpRequest();
                xhttp.onreadystatechange = function() {
                    console.log(this.status)
                    if (this.readyState == 4 && this.status == 401) {
                        notyf.error("Please login to give a rating.")
                        const redirect = async() => {
                            //wait 2500ms
                            await new Promise(res => setTimeout(res, 2500))
                            // Refresh the page without GET variable
                            window.location.href = "login.php";
                        }
                        redirect()
                    } else if (this.readyState == 4 && parseInt(this.status / 100) == 4) {
                        notyf.error("Rating not saved. Please try again later.")
                    } else if (this.readyState == 4 && this.status == 200) {
                        notyf.success("Your rating is saved.")
                    }
                };
                xhttp.open("POST", "api_postfeedback.php", true);
                xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
                xhttp.send(`setrating=${selectedRating}&postid=<?php echo $postid?>`);
            }
        });
    </script>
    <!-- JavaScript files-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" crossorigin="anonymous">
</body>

</html>