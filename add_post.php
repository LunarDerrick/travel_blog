<!DOCTYPE html>
<html lang="en">

<?php
require_once("init_db.php");
require_once("init_session.php");
require_once("init_check_logged_in.php"); // only for pages that strictly require login
?>

<head>
    <title>Travalog - Add Post</title>

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
                    
                    <li class="nav-item"><a class="nav-link " href="my_posts.php">My Posts</a></li>
                    <li class="nav-item dropdown">
                        <a class="btn btn-style btn-dark ms-2 px-3 py-2 dropdown-toggle " href="#" id="navbarUserMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                        @<?php echo $_SESSION["username"]; ?>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="navbarUserMenuLink">
                        <li><a class="dropdown-item" href="analysis.php">Analysis</a></li>
                        <li><a class="dropdown-item" href="my_profile.php">Edit profile</a></li>
                        <li><a class="dropdown-item" href="index.php">Log out</a></li>
                        </ul>
                    </li>
                    
                </ul>
            </div>
        </div>
    </nav>

    <section>
        <div class="container">
            <div class="container section-title ">
                <h2>Add Post</h2>
                <p></p>
            </div>
            
            <form action=# method="post">
                <div class="container">
                    <div class="row">
                        <div class="col-md-12 form-label">
                            <label for="title"><b>Title</b></label>
                            <input type="text" id="title" name="title" class="form-control" required>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12 form-label">
                            <label for="caption"><b>Caption</b></label>
                            <input type="text" id="caption" name="caption" class="form-control">
                        </div>
                    </div>
                    <div class="row">
                        <div class="form-label">
                            <label for="content"><b>Content</b></label>
                            <textarea id="content" rows="10" class="form-control"></textarea>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-7">
                            <div class="row">
                                <div class="col form-label">
                                    <label for="location"><b>Location</b></label>
                                    <input type="text" id="location" name="location" class="form-control" required>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col form-label">
                                    <label for="tags"><b>Tags</b></label>
                                    <input type="text" id="tags" class="form-control">
                                </div>
                            </div>
                        </div>  
                        <div class="col-md-5">
                            <div class="row">
                                <div class="col">
                                    <label for="image"><b>Image</b></label>
                                    <input type="file" id="image" class="form-control">
                                    <picture>
                                        <img src="image/hawaii.jpg" class="img-fluid card-img-top" alt="...">
                                    </picture>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-8 form-label">
                        </div>  
                        <div class="col-md-4">
                        </div>  
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <input type="submit" value="Add Post" class="btn btn-dark px-3">
                        </div>
                    </div>
                </div>
            </form>
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
    <script src="https://d19m59y37dris4.cloudfront.net/blog/2-0/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="https://d19m59y37dris4.cloudfront.net/blog/2-0/vendor/glightbox/glightbox.js"></script>
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.1/css/all.css"
        integrity="sha384-fnmOCqbTlWIlj8LyTjo7mOUStjsKC4pOpQbqyi7RrhN7udi9RwhKkMHpvLbHG9Sr" crossorigin="anonymous">
</body>