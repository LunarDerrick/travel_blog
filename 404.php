<!DOCTYPE html>
<html lang="en">

<?php
include_once("init_db.php");
include_once("init_session.php");
?>

<head>
    <title>You're lost?</title>

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
                    <li class="nav-item"><a class="nav-link active " href="index.php">Home</a>
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
                        <li class="nav-item"><a class="nav-link active" href="my_posts.php">My Posts</a></li>
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

    <!-- Divider Section-->
    <section class="text-center">
        <div class="container">
            <h1 class="display-1">404</h1>
            <p class="text-muted">It's an empty world...</p>
            <a href="./" class="btn btn-dark btn-lg py-2">Go back?</a>
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

    <!-- JavaScript files-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" crossorigin="anonymous">
</body>



</html>