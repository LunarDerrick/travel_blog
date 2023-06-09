<!DOCTYPE html>
<html lang="en">

<?php
require_once("init_db.php");
require_once("init_session.php");
?>

<head>
    <title>Travalog - Search</title>

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
                    <li class="nav-item"><a class="nav-link active " href="search.php">Search</a>
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
            <div class="container section-title ">
                <h2>Search</h2>
                <p>
                    Trying to find something you like?
                </p>
            </div>

            <div class="container py-4">
                <form action="search_result.php" method="get" class="d-flex m-2">
                    <input class="form-control" type="search" id="search-term" name="keyword" placeholder="Search posts" aria-label="Search" required>
                    <select class="form-control form-select w-25" id="search-type" name="type">
                        <option selected>Everything</option>
                        <option>Topic</option>
                        <option>Location</option>
                        <option>Author</option>
                        <option>Tag</option>
                      </select>
                    <button class="btn btn-dark btn-lg" type="submit">
                        <span class="fa fa-solid fa-search"></span>
                    </button>
                </form>
            </div>

            <div class="container section-title mt-3">
                <h4>Or want to filter by tags?</h4>
                <p>
                    Try these tags!
                </p>
            </div>

            <!--3x2 card gallery-->
            <section class="gallery-block cards-gallery">
                
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 transform-on-hover">
                                <picture>
                                    <img src="image/asia.png" alt="Card Image" class="card-img-top">
                                </picture>
                                <div class="card-body">
                                    <h6><a href="search_result.php?continent=Asia" class="stretched-link">Asia</a></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 transform-on-hover">
                                <picture>
                                    <img src="image/europe.jpg" alt="Card Image" class="card-img-top">
                                </picture>
                                <div class="card-body">
                                    <h6><a href="search_result.php?continent=Europe" class="stretched-link">Europe</a></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 transform-on-hover">
                                <picture>
                                    <img src="image/australia.jpg" alt="Card Image" class="card-img-top">
                                </picture>
                                <div class="card-body">
                                    <h6><a href="search_result.php?continent=Australia" class="stretched-link">Australia</a></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 transform-on-hover">
                                <picture>
                                    <img src="image/africa.png" alt="Card Image" class="card-img-top">
                                </picture>
                                <div class="card-body">
                                    <h6><a href="search_result.php?continent=Africa" class="stretched-link">Africa</a></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 transform-on-hover">
                                <picture>
                                    <img src="image/north_america.png" alt="Card Image" class="card-img-top">
                                </picture>
                                <div class="card-body">
                                    <h6><a href="search_result.php?continent=North%20America" class="stretched-link">North America</a></h6>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 transform-on-hover">
                                <picture>
                                    <img src="image/south_america.png" alt="Card Image" class="card-img-top">
                                </picture>
                                <div class="card-body">
                                    <h6><a href="search_result.php?continent=South%20America" class="stretched-link">South America</a></h6>
                                </div>
                            </div>
                        </div>
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