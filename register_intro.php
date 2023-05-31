<!DOCTYPE html>
<html lang="en">

<?php
require_once("init_db.php");
# only run if is set
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    # verify info
    foreach (["email", "password", "password-confirm", "username", "personname"] as $check) {
        if (empty($_POST[$check])){
            # go back to previous page
            header('Location: ' . $_SERVER['HTTP_REFERER']);
            die; # prevent if browser dont respect redirect
        }
    }
    if($_POST["password"] != $_POST["password-confirm"]) {
        # go back to previous page
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die; # prevent if browser dont respect redirect
    }

    # retrieve post variable
    $email = $_POST["email"];
    $password = password_hash($_POST["password"], PASSWORD_BCRYPT, ['cost' => 12]);
    $username = $_POST["username"];
    $personname = $_POST["personname"];
    if (verifyUsername($conn, $username)){
        // redirect back, username taken
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        die; # prevent if browser dont respect redirect
    } else {
        // insert new record into database
        $id = uniqid(rand(), true);
        
        $stmt = $conn->prepare("INSERT INTO users (userid, username, password, realname, email) VALUES (?, ?, ?, ?, ?)");
        $stmt->bind_param("sssss", $id, $username, $password, $personname, $email);
        if (!$stmt->execute()){
            http_response_code(500);
            die;
        }

        require_once("init_session.php");
        # correct password
        $_SESSION["userid"] = $id;
        $_SESSION["username"] = $username;
    }
} else {
    // only for pages that strictly require login
    require_once("init_check_logged_in.php");
}
?>

<head>
    <title>Travalog - Welcome!</title>

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
                    
                    <li class="nav-item"><a class="nav-link " href="login.php">Login</a></li>
                    <li class="nav-item "><a class="btn btn-style btn-dark ms-2 px-3 py-2 " href="register.php">Sign Up</a></li>

                </ul>
            </div>
        </div>
    </nav>

    <section>
        <div class="container">
            <div class="container section-title ">
                <h2>Welcome to Travalog</h2>
                <p>
                    Yay! Wanna start writing a blog?
                </p>
            </div>

            <div class="container py-2">
            </div>

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