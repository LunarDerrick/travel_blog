<!DOCTYPE html>
<html lang="en">

<?php
require_once("init_db.php");
require_once("init_session.php");
require_once("init_check_logged_in.php"); // only for pages that strictly require login

$userid = $_SESSION["userid"];
// fetch data from database
$myquery = "SELECT userid, username, profilepic, profileintro, realname, email, telno
            FROM users
            WHERE userid=? 
            LIMIT 1";
try {
    $query = $conn->prepare($myquery);
    $query->bind_param('i', $userid);
} catch (Exception $e) {
    echo $e->getMessage();
    die;
}

if(!$query->execute()){
    http_response_code(500);
    die;
}
$result = $query->get_result();
$userinfo = $result->fetch_assoc();
?>

<head>
    <title>Travalog - Profile</title>
    
    <!--Bootstrap implementation-->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initialscale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="css/cards-gallery.css">
    <!-- Google fonts - Open Sans-->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,700">
    <!-- Theme stylesheet-->
    <link rel="stylesheet" href="https://d19m59y37dris4.cloudfront.net/blog/2-0/css/style.default.622904dd.css"
        id="theme-stylesheet">
    <!-- Custom stylesheet - for your changes-->
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
                <h2>My Profile</h2>
                <p>
                    Show my best side to all of the world!
                </p>
            </div>

            <form id="formProfile" class="section-content" enctype='multipart/form-data'>
                <div class="container">
                    <div class="row">
                        <div class="col-md-9">
                            <div class="row">
                                <div class="col-md-12 form-label">
                                    <label for="fname"><b>Username</b></label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">@</span>
                                        <input type="text" id="username" name="username" class="form-control" placeholder="Username" aria-label="Username" aria-describedby="basic-addon1" required onchange="checkUsernameUsed();" value="<?php echo htmlentities($_SESSION["username"]); ?>">
                                    </div>
                                    <span id="username-warning" class="text-danger d-none">Username is taken. Try another one?</span>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-label">
                                    <label for="name"><b>Name</b></label>
                                    <!-- if no realname is provided, default to username value -->
                                    <input type="text" id="name" name="name" class="form-control" required value="<?php echo htmlentities($userinfo['realname']); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-6 form-label">
                                    <label for="email"><b>Email Address</b></label>
                                    <input type="text" id="email" name="email" class=" form-control" required value="<?php echo htmlentities($userinfo['email']); ?>">
                                </div>
                                <div class="col-md-6 form-label">
                                    <label for="tel"><b>Tel. Number</b></label>
                                    <input type="text" id="tel" name="tel" class="form-control" value="<?php echo htmlentities($userinfo['telno']); ?>">
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-md-12 form-label">
                                    <label for="message"><b>Profile introduction</b></label>
                                    <textarea id="message" name="message" rows="4" class="form-control"><?php echo htmlentities($userinfo['profileintro']); ?></textarea>
                                </div>
                            </div>
                            <div class="row">
                                <span>Leave blank if you do not want to change password.</span>
                                <div class="col-md-6 form-label">
                                    <label for="oldpassword"><b>Old Password</b></label>
                                    <input type="password" id="oldpassword" name="oldpassword" class="form-control">
                                </div>
                                <div class="col-md-6 form-label">
                                    <label for="newpassword"><b>New Password</b></label>
                                    <input type="password" id="newpassword" name="newpassword" class="form-control" onchange="requireOldPassword()">
                                </div>
                                <span id="require-password-warning" class="text-warning d-none">Please provide your current password when changing username or password.</span>
                            </div>
                        </div>
                        <div class="col-md-3 form-label float-md-end">
                            <picture>
                                <!-- show database photo, else show default anonymous photo -->
                                <?php echo isset($userinfo['profilepic']) ? 
                                    '<img src="'.$userinfo['profilepic'].'" id="img-preview" class="img-fluid card-img-top" alt="...">' // photo 1
                                    : 
                                    '<img src="image/profile_man.jpeg" id="img-preview" class="img-fluid card-img-top" alt="...">'; // photo 2
                                ?>
                            </picture>
                            <div class="col form-label">
                                <!-- <input type="file" class="form-control" id="inputGroupFile01"> -->
                                <input type="file" class="form-control" id="image" name="image" accept="image/*">
                            </div>
                        </div>
                    </div>
                    <div class="row mt-3">
                        <div class="col-12">
                            <input type="submit" value="Save" class="btn btn-dark py-3 px-5">
                        </div>
                    </div>
                    <br>
                    <small class="text-small">Not happy with our service? 
                        <a href="#">Delete account.</a>
                    </small>
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
    
    <!-- JavaScript files-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" crossorigin="anonymous">
    <!-- items for notification toast -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>

</body>

<script>
    const notyf = new Notyf();
    // show image preview when choosing image
    document.getElementById("image").onchange = evt => {
        const [file] = document.getElementById("image").files
        if (file) {
            document.getElementById("img-preview").src = URL.createObjectURL(file)
        }
    }

    //submit form with AJAX
    let formProfile = document.forms[0]
    formProfile.onsubmit = (e) => {
        // do not use built in formsubmit
        e.preventDefault();
        // send data from api
        try{
            fetch('api_edit_profile.php', {
                method: 'POST',
                body: new FormData(formProfile)
            }).then((response) => response.json())
            .then((response) => {
                if (response.OK) {
                    notyf.success(response.message);
                    // reset password field after submit, dont require change
                    document.getElementById("oldpassword").value = null
                    document.getElementById("oldpassword").removeAttribute("required")
                    document.getElementById("newpassword").value = null
                } else
                    notyf.error(response.data.message);
            });
        } catch (e) {
            console.error(e);
        }
    }

    var usernameField = document.getElementById("username")
    const originalUsername = usernameField.value
    function checkUsernameUsed() {
        var username = usernameField.value;
        if (username == originalUsername){
            // username no change, dont show warning
            document.getElementById("oldpassword").removeAttribute("required")
            document.getElementById("require-password-warning").classList.add("d-none");
            // do not do ajax request to check username available coz same username
            return
        }
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function() {
            if (this.readyState == 4 && this.status == 406) {
                // show username taken warning by removing bootstrap d-none class
                document.getElementById("username-warning").classList.remove("d-none");
                // set invalid state
                document.getElementById("username").setCustomValidity('Username is taken');
            } else if (this.readyState == 4 && this.status == 202) {
                document.getElementById("username-warning").classList.add("d-none");
                document.getElementById("username").setCustomValidity('');
                // require password if username is changed
                requireOldPassword()
            }
        };
        xhttp.open("POST", "api_userinfo.php", true);
        xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhttp.send("usernameverify="+username);
    }
    
    function requireOldPassword(){
        // set to require password
        document.getElementById("oldpassword").setAttribute("required", true)
        document.getElementById("require-password-warning").classList.remove("d-none");
    }
</script>

</html>