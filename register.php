<?php require("resources/init.php"); ?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>eCommerce</title>

    <!-- Font Icon -->
    <link rel="stylesheet" href="bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="fonts/material-icon/css/material-design-iconic-font.min.css">

    <!-- Main css -->
    <link rel="stylesheet" href="css/style.css">

    
</head>

<body>

    <div class="main">

        <section class="signup">
    
            <div class="container">
                <div class="signup-content">
                    <form method="post" class="signup-form" enctype="multipart/form-data">

                        <h2 class="form-title">Create account</h2>

                        <?php validate_user_registration(); ?>

                        <div class="form-group">
                            <input type="text" class="form-input" name="first_name" id="name" placeholder="Your First Name" />
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-input" name="last_name" id="name" placeholder="Your Last Name" />
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-input" name="username" id="name" placeholder="Your Username" />
                        </div>
                        <div class="form-group">
                            <input type="email" class="form-input" name="email" id="email" placeholder="Your Email" />
                        </div>
                        <div class="form-group">
                            <input type="text" class="form-input" name="password" id="password" placeholder="Password" />
                            <span toggle="#password" class="zmdi zmdi-eye field-icon toggle-password"></span>
                        </div>
                        <div class="form-group">
                            <input type="password" class="form-input" name="confirm_password" id="confirm_password" placeholder="Repeat your password" />
                        </div>
                        <div class="form-group">
                            <input type="checkbox" name="agree_term" id="agree-term" class="agree-term" />
                            <label for="agree-term" class="label-agree-term"><span><span></span></span>I agree all statements in  <a href="#" class="term-service">Terms of service</a></label>
                        </div>
                        <div class="form-group">
                            <input type="submit" name="submit" id="submit" class="form-submit" value="Sign up" />
                        </div>
                        <!-- <div class="form-group" hidden>
                            <input type="text" name="token" value="<?php  ?>">
                        </div> -->
                    </form>
                    <p class="loginhere">
                        Have already an account ? <a href="index.php" class="loginhere-link">Login here</a>
                    </p>
                </div>
            </div>
        </section>

    </div>

    <!-- JS -->
    <script src="bootstrap/js/bootstrap.min.js"></script>
    <script src="bootstrap/js/bootstrap.js"></script>
    <script src="js/jquery.js"></script>

<!--===============================================================================================-->
                    <script>
                            (function($) {

                            $(".toggle-password").click(function() {

                                $(this).toggleClass("zmdi-eye zmdi-eye-off");
                                var input = $($(this).attr("toggle"));
                                if (input.attr("type") == "password") {
                                    input.attr("type", "text");
                                } else {
                                    input.attr("type", "password");
                                }
                            });

                            })(jQuery);
                    </script>
</body>


</html>