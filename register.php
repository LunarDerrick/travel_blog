<!DOCTYPE html>
<html lang="en">

<?php
require_once("init_db.php");
// force redirect if there is session
include_once("init_session.php");
if (isset($_SESSION["username"]) && isset($_SESSION["userid"])){
    header("Location: my_profile.php");
    die;
}
?>

<head>
    <title>Travalog - Register</title>

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

                                    <form action="register_intro.php" method="post" id="register-form">
                                        <a href="./" class="btn-close float-end" aria-label="Close"></a>

                                        <div class="d-flex align-items-center mb-3 pb-1">
                                            <a href="./" class=" text-dark">
                                                <span class="h1 fw-bold mb-0">Travalog</span>
                                            </a>
                                        </div>

                                        <div role="tab-list">

                                            <!-- step 1 -->
                                            <div role="tab-panel" id="tab-panel-1" class="tab-panel" step="1">
                                                <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Register account</h5>

                                                <div class="form-outline mb-4">
                                                    <label class="form-label mb-1" for="email">Email address</label>
                                                    <input type="email" id="email" name="email" class="form-control form-control-lg" required />
                                                </div>

                                                <div class="form-outline mb-4">
                                                    <label class="form-label mb-1" for="password">Password</label>
                                                    <input type="password" id="password" name="password" class="form-control form-control-lg" onchange="confirmPassword();" required minlength="8"/>
                                                </div>

                                                <div class="form-outline mb-4">
                                                    <label class="form-label mb-1" for="password-confirm">Confirm Password</label>
                                                    <input type="password" id="password-confirm" name="password-confirm" class="form-control form-control-lg" onchange="confirmPassword();" onkeyup="confirmPassword();" required minlength="8"/>
                                                </div>

                                                <div class="pt-1 mb-4">
                                                    <button class="btn btn-dark btn-lg py-2" id="page1-next" type="button" onclick="nextPage1();">Start now!</button>
                                                </div>
                                                
                                                <p class="pb-lg-2" style="color: #393f81;">
                                                    Have an account? 
                                                    <strong><a href="login.php" style="color: #393f81;">Log in here</a></strong>
                                                </p>
                                            </div>
                                            <!-- step 2 -->
                                            <div role="tab-panel" id="tab-panel-2" class="tab-panel d-none" step="2">
                                                <h5 class="fw-normal mb-3 pb-3" style="letter-spacing: 1px;">Introduce yourself?</h5>

                                                <div class="form-outline mb-4">
                                                    <label class="form-label mb-1" for="username">Username</label>
                                                    <div class="form-outline mb-4 input-group">
                                                        <span class="input-group-text" id="basic-addon1">@</span>
                                                        <input type="text" id="username" name="username" class="form-control form-control-lg" aria-label="Username" aria-describedby="basic-addon1" onchange="checkUsernameUsed();">
                                                    </div>
                                                    <span id="username-warning" class="text-danger d-none">Username is taken. Try another one?</span>
                                                </div>

                                                <div class="form-outline mb-4">
                                                    <label class="form-label mb-1" for="personname">Name</label>
                                                    <input type="test" id="personname" name="personname" class="form-control form-control-lg"/>
                                                </div>

                                                <div class="pt-1 mb-4">
                                                    <button class="btn btn-dark btn-lg py-2" type="submit">Register!</button>
                                                    <button class="btn btn-outline btn-sm mx-4" id="page2-back" type="button" onclick="prevPage1();">I want to go back</button>
                                                </div>
                                            </div>

                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        var registerForm = document.getElementById("register-form");
        var tabPanel1 = document.getElementById("tab-panel-1");
        var tabPanel2 = document.getElementById("tab-panel-2");

        // prevent submit form when press enter
        registerForm.onkeypress = function(e) {
            var key = e.charCode || e.keyCode || 0;     
            if (key == 13) {
                if (tabPanel1.classList.contains("d-none")) {
                // page 1 is hidden - page 2 shown
                    return true;
                } else {
                    // turn to next page
                    e.preventDefault();
                    nextPage1();
                    return false;
                }
            }
        }

        function confirmPassword() {
            const password = document.querySelector('input[name=password]');
            const confirm = document.querySelector('input[name=password-confirm]');
            
            if (confirm.value === password.value) {
                confirm.setCustomValidity('');
            } else {
                confirm.setCustomValidity('Passwords do not match');
            }
        }

        function checkUsernameUsed() {
            var username = document.getElementById("username").value;
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
                }
            };
            xhttp.open("POST", "api_userinfo.php", true);
            xhttp.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            xhttp.send("usernameverify="+username);
        }

        function nextPage1(){
            if (registerForm.checkValidity()){
                // switch tab
                tabPanel1.classList.add("d-none");
                tabPanel2.classList.remove("d-none");
                // set required
                document.getElementById("username").setAttribute("required", true);
                document.getElementById("personname").setAttribute("required", true);
            } else {
                registerForm.reportValidity();
            }
        }

        function prevPage1(){
            // reset required before going hidden
            document.getElementById("username").removeAttribute("required");
            document.getElementById("personname").removeAttribute("required");
            document.getElementById("username").setCustomValidity('');
            // switch tab
            tabPanel1.classList.remove("d-none");
            tabPanel2.classList.add("d-none");
        }
    </script>
    
    <!-- JavaScript files-->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
    <!-- FontAwesome CSS - loading as last, so it doesn't block rendering-->
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v6.4.0/css/all.css" crossorigin="anonymous">
</body>

</html>