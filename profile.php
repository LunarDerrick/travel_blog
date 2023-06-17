<!DOCTYPE html>
<html lang="en">

<?php
require_once("init_db.php");
require_once("init_session.php");
include_once("helper_list_post.php");

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

$userid = intval($_GET["id"]) ?? die; // try to get integer value, or else die

// get user info
$stmt = $conn->prepare("SELECT userid, profilepic, profileintro, realname
 FROM users
 WHERE userid=?");
$stmt->bind_param("i", $userid);
if (!$stmt->execute()){
    http_response_code(500);
    die;
}
$result = $stmt->get_result();
if ($row = $result->fetch_object()){
    $userinfo = $row;
    if (empty($userinfo->userid)) {
        // no matching userid
        http_response_code(404);
        include('404.php'); // provide your own HTML for the error page
        die();
    }
} else {
    http_response_code(500);
    die;
}

// get post item
$stmt = $conn->prepare("SELECT posts.postid, posts.userid, title, caption, image, rating AS user_rating, AVG(ratings.rating) AS avg_rating
FROM posts
JOIN ratings ON posts.postid=ratings.postid
WHERE posts.userid=?");
$stmt->bind_param("i", $userid);
if (!$stmt->execute()){
    http_response_code(500);
    die;
}
$result = $stmt->get_result();
$posts = [];
if ($result->num_rows){
    while($row = $result->fetch_object()){
        // use [] format to add to last item in PHP
        $posts[] = $row;
    }
}

if (
    !isset($_GET["page"]) || // no page
    ( isset($_GET["page"]) && !filter_var($_GET["page"], FILTER_VALIDATE_INT) ) // page is not integer
){
    // set to page 1
    $_GET["page"] = 1;
}
$page = intval($_GET["page"]);
?>

<head>
    <title>Travalog -
        <?php echo htmlentities(
        isset($userinfo->realname) ? $userinfo->realname: $userinfo->username
        ); ?>'s Page
    </title>

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
    <link rel="stylesheet" href="css/cards-gallery.css">
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

    <section>
        <div class="container">
            <div class="container section-title row">
                <div class="col-2">
                    <picture class="author-pfp">
                        <?php echo isset($data['profilepic']) ? 
                            '<img src="'.$userinfo->profilepic.'" class="img-fluid" alt="...">' // photo 1
                            : 
                            '<img src="image/profile_man.jpeg" class="img-fluid" alt="...">'; // photo 2
                        ?>
                    </picture>
                </div>
                <div class="col-10">
                    <h2>
                        <?php echo htmlentities(
                        isset($userinfo->realname) ? $userinfo->realname: $userinfo->username
                        ); ?>
                    </h2>
                    <p>
                        <?php echo htmlentities(
                        isset($userinfo->profileintro) ? $userinfo->profileintro: "This user has not provided any description yet."
                        ); ?>
                    </p>
                </div>
            </div>

            <!-- 3x2 card gallery -->
            <section class="gallery-block cards-gallery">
                <div class="container">
                    <div class="row">
                        <?php 
                        [$posts, $total] = listMyPostPreview($conn);
                        buildHTMLPostPreview($posts); 
                        buildHTMLPagination($total, $page)
                        ?>
                    </div>
                </div>
            </section>
        </div>
    </section>

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
    <!--Makes card animated-->

    <script>
        baguetteBox.run('.cards-gallery', { animation: 'slideIn' });
    </script>
    <!-- JavaScript files-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" crossorigin="anonymous">

</body>

</html>