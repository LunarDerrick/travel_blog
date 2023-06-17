<!DOCTYPE html>
<html lang="en">

<?php
require_once("init_db.php");
require_once("init_session.php");
include_once("helper_list_post.php");

if (!isset($_SESSION["username"])) {
    header("Location: login.php");
    die();
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
                    
                    <li class="nav-item"><a class="nav-link active" href="my_posts.php">My Posts</a></li>
                    <li class="nav-item dropdown">
                        <a class="btn btn-style btn-dark ms-2 px-3 py-2 dropdown-toggle " href="#" id="navbarUserMenuLink" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            @<?php echo $_SESSION["username"]; ?>
                        </a>

                        <ul class="dropdown-menu" aria-labelledby="navbarUserMenuLink">
                            <li><a class="dropdown-item" href="analysis.php">Analysis</a></li>
                            <li><a class="dropdown-item" href="my_profile.php">Edit profile</a></li>
                            <li><a class="dropdown-item" href="logout.php">Log out</a></li>
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
                <a href="add_post.php" class="btn btn-iconed btn-lg btn-rounded btn-info d-block float-end">
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
                            <button type="button" class="btn btn-secondary mx-2" data-bs-postid="" id="modalDeleteBtn">
                                I'm sure, delete it
                            </button>
                            <button type="button" class="btn btn-info" data-bs-dismiss="modal" id="modalKeepBtn">
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
                        <?php 
                        [$posts, $total] = listMyPostPreview($conn);
                        buildHTMLPostPreview($posts, $edit=true); 
                        buildHTMLPagination($total, $page)?>
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

    <!-- JavaScript files-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" crossorigin="anonymous">
    <!-- items for notification toast -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

    <script>
        var deleteModal = document.getElementById('deleteModal')
        var modalKeepBtn = document.getElementById('modalKeepBtn')
        var modalDeleteBtn = document.getElementById('modalDeleteBtn')
        var notyf = new Notyf()

        // on showing modal
        deleteModal.addEventListener('shown.bs.modal', (event) => {
            // Auto focus on keep button
            modalKeepBtn.focus()
            // Button that triggered the modal
            var button = event.relatedTarget
            // Extract info from data-bs-postid attributes
            var postID = button.getAttribute('data-bs-postid')
            // Pass post id to delete button
            modalDeleteBtn.setAttribute('data-bs-postid', postID)
        })

        // delete button
        modalDeleteBtn.onclick = () => {
            // get deleted post id
            var postID = modalDeleteBtn.getAttribute('data-bs-postid')
            // prepare xhttp request
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function() {
                if (this.readyState == 4 && parseInt(this.status / 4) == 4) {
                    //default notyf 2000ms
                    notyf.error("We encountered an error when deleting the post.")
                } else if (this.readyState == 4 && this.status == 200) {
                    //hide modal
                    deleteModal.classList.add("d-none")
                    //default notyf 2000ms
                    notyf.success("Post is deleted.")
                    const redirect = async() => {
                        //wait 2500ms
                        await new Promise(res => setTimeout(res, 2500))
                        // Refresh the page without GET variable
                        window.location = window.location.href.split(/[?#]/)[0];
                    }
                    redirect()
                }
            };
            // send post request
            xhttp.open("POST", "api_deletepost.php", true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.send("id="+postID);
        }
    </script>

    <?php
    // echo popup if successfully add posts
    if ($_SERVER['REQUEST_METHOD'] === 'GET'){
        // if get variable has done=1 and page come from add_post.php
        if ( isset($_GET['done']) && intval($_GET['done']) && basename($_SERVER['HTTP_REFERER']) == "add_post.php" ){
            // display toast
            echo '<script>notyf.success("Succesfully added post.")</script>';
        }
        // if get variable has done=1 and page come from edit_post.php
        if ( isset($_GET['done']) && intval($_GET['done']) && basename($_SERVER['HTTP_REFERER']) == "edit_post.php" ){
            // display toast
            echo '<script>notyf.success("Succesfully edited post.")</script>';
        }
    }
    ?>
</body>