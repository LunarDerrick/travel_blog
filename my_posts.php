<!DOCTYPE html>
<html lang="en">

<head>
    <title>Travalog - My Posts</title>

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
                <a class="navbar-brand text-md fw-bold text-dark" href="index_logged.html">Travalog</a>
            </h1>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse"
                data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false"
                aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav ms-auto mb-2 mb-lg-0 align-items-lg-center">
                    <li class="nav-item"><a class="nav-link " href="index_logged.html">Home</a>
                    </li>
                    <li class="nav-item"><a class="nav-link " href="browse_logged.html">Browse</a>
                    </li>
                    <li class="nav-item"><a class="nav-link " href="search_logged.html">Search</a>
                    </li>
                    <li class="nav-item"><a class="nav-link " href="contact_logged.html">Contact</a>
                    </li>
                    <li class="nav-item"><a class="nav-link active" href="my_posts.html">My Posts</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="btn btn-style btn-dark ms-2 px-3 py-2 dropdown-toggle " href="#" id="navbarUserMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @Username
                        </a>
                        
                        <ul class="dropdown-menu" aria-labelledby="navbarUserMenuLink">
                            <li><a class="dropdown-item" href="analysis.html">Analysis</a></li>
                            <li><a class="dropdown-item" href="profile.html">Edit profile</a></li>
                            <li><a class="dropdown-item" href="index.html">Log out</a></li>
                        </ul>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <section>
        <div class="container">
            <div class="container section-title ">
                <!-- add post button -->
                <a href="add_post.html" class="btn btn-iconed btn-lg btn-rounded btn-info d-block float-end">
                    <i class="fa fa-plus" aria-hidden="true"></i>
                    <span class="spn">Add Post</span>
                </a>

                <h2>My Posts</h2>
                <p>
                    Have a look at all your posts, edit them, or add a new one!
                </p>
            </div>

            <!-- delete modal -->
            <div class="modal fade" id="deleteModal" data-bs-backdrop="static" data-bs-keyboard="false" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="deleteModalLabel">Deleting Post....</h5>
                            <button type="button" class="close" data-bs-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <p>Are you sure you want to delete the post?</p>
                            <strong>There is no way to revert the action!</strong>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary mx-2">
                                I'm sure, delete it
                            </button>
                            <button type="button" class="btn btn-info" data-bs-dismiss="modal">
                                Keep the post
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            

            <!--3x2 card gallery-->
            <section class="gallery-block cards-gallery">
                <div class="container">
                    <div class="row">
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 transform-on-hover">
                                <picture>
                                    <img src="image/korea.jpg" alt="Card Image" class="card-img-top">
                                </picture>
                                <div class="card-body">
                                    <h6>Korea</h6>
                                    <p class="text-muted card-text mb-2">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        Nunc quam urna.
                                    </p>
                                    <div class="float-end">
                                        <!-- use stretched-link class to make whole card clickable-->
                                        <a href="edit_post.html" class="fa fa-edit btn btn-lg btn-outline-primary stretched-link"></a>
                                        <a href="#" class="fa fa-trash btn btn-lg btn-outline-danger" style="position: relative; z-index: 1000;" data-bs-toggle="modal" data-bs-target="#deleteModal" aria-hidden="true"></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-lg-4">
                            <div class="card border-0 transform-on-hover">
                                <picture>
                                    <img src="image/hawaii.jpg" alt="Card Image" class="card-img-top">
                                </picture>
                                <div class="card-body">
                                    <h6>Hawaii</h6>
                                    <p class="text-muted card-text">Lorem ipsum dolor sit amet, consectetur adipiscing elit.
                                        Nunc quam urna.
                                    </p>
                                    <div class="float-end">
                                        <!-- use stretched-link class to make whole card clickable-->
                                        <a href="edit_post.html" class="fa fa-edit btn btn-lg btn-outline-primary stretched-link"></a>
                                        <a href="#" class="fa fa-trash btn btn-lg btn-outline-danger" style="position: relative; z-index: 1000;" data-bs-toggle="modal" data-bs-target="#deleteModal" aria-hidden="true"></a>
                                    </div>
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