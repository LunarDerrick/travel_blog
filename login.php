<!DOCTYPE html>
<html lang="en">

<?php
require_once("init_db.php");

# only run if is set
if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    if(empty($_POST["username"]) || empty($_POST["password"])) {
        // @todo
    }
    # retrieve post variable
    $username = $_POST["username"];
    $password = $_POST["password"];
    if ($userinfo = verifyUsername($conn, $username)){
        # verify password
        if(password_verify($password, $userinfo["password"])){
            require_once("init_session.php");
            # correct password
            $_SESSION["userid"] = $userinfo;
            $_SESSION["username"] = $username;
            header("Location: .");
            die; # prevent if browser dont respect redirect
        } else {
            // @todo
            echo "Incorrect passworod";
        }
    } else {
        // @todo
        echo "Username not found";
    }
}
?>

<head>
    <title>Travalog - Login</title>

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
    <link rel="stylesheet" href="/css/main.css">

</head>

<body>
    <section class="vh-100 py-0" style="background-color: grey">
        <div class="container py-0 h-100">
            <div class="row d-flex justify-content-center align-items-center h-100">
                <div class="col col-xl-10">
                    <div class="card" style="border-radius: 1rem;">
                        <div class="row g-0">
                            <div class="col-md-6 col-lg-5 d-none d-md-block">
                                <img src="image/login_background.jpg"
                                    alt="login form" class="img-fluid" style="border-radius: 1rem 0 0 1rem;" />
                            </div>
                            <div class="col-md-6 col-lg-7 d-flex align-items-top">
                                <div class="card-body p-4 p-lg-5 text-black">

                                    <form action="" method="post">
                                        <a href="./" class="btn-close float-end" aria-label="Close"></a>

                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <a href="./" class=" text-dark">
                                                <span class="h1 fw-bold mb-0">Travalog</span>
                                            </a>
                                        </div>

                                        <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Sign into your
                                            account</h5>

                                        <div class="form-outline mb-4">
                                            <label class="form-label mb-1" for="username">Username</label>
                                            <input type="text" id="username" name="username" class="form-control form-control-lg" required />
                                        </div>

                                        <div class="form-outline mb-4">
                                            <label class="form-label mb-1" for="password">Password</label>
                                            <input type="password" id="password" name="password" class="form-control form-control-lg" required/>
                                        </div>

                                        <div class="pt-1 mb-2">
                                            <button class="btn btn-dark btn-lg py-2" type="submit">Login</button>
                                        </div>

                                        <a class="small text-muted d-block mb-2" href="#!">Forgot password?</a><br>
                                        <p class="pb-lg-2" style="color: #393f81;">
                                            Don't have an account? 
                                            <strong><a href="register.php" style="color: #393f81;">Register here</a></strong>
                                        </p>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    
    <!-- JavaScript files-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" crossorigin="anonymous">
</body>

</html>