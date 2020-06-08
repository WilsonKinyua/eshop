<?php


/**=================================================HELPER FUNCTIONS ================================ */
/**=================================================HELPER FUNCTIONS ================================ */
/**=================================================HELPER FUNCTIONS ================================ */
/**=================================================HELPER FUNCTIONS ================================ */
/**=================================================HELPER FUNCTIONS ================================ */
/**=================================================HELPER FUNCTIONS ================================ */
/**
 * 
 * author:wilson kinyua
 * email: wilsonkinyuam@gmail.com
 * year created : May 2020
 * 
 * 
 */


function query($sql)
{

    global $connection;

    return mysqli_query($connection, $sql);
}




function redirect($location)
{

    return header("Location: $location");
}




function fetch_array($result)
{

    global $connection;

    return  mysqli_fetch_array($result);
}




function last_id_insert()
{

    global $connection;

    return mysqli_insert_id($connection);
}



function set_message($msg)
{

    if (!empty($msg)) {

        $_SESSION['message'] = $msg;
    } else {
        $msg = "";
    }
}



function display_message()
{

    if (isset($_SESSION['message'])) {

        echo $_SESSION['message'];
        unset($_SESSION['message']);
    }
}




function confirm($result)
{

    global $connection;

    if (!$result) {
        die("QUERY FAILED" . mysqli_error($connection));
    }
}



function escape($string)
{

    global $connection;

    return mysqli_real_escape_string($connection, $string);
}


function count_rows($result)
{

    global $connection;

    return mysqli_num_rows($result);
}


function clean($string)
{

    return htmlentities($string);
}


function token_generator()
{

    return $token = $_SESSION['token'] = md5(uniqid(mt_rand(), true));
}


function validation_form_errors($error_message)
{


    $error_message = <<<DELIMETER

    <div class="alert alert-danger alert-dismissible fade show" role="alert">
    <strong>Warning!</strong> $error_message
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
      <span aria-hidden="true">&times;</span>
    </button>
  </div>


DELIMETER;

    return $error_message;
}
/**=================================================MAIL FUNCTION ======================================= */

function send_mail($email, $subject, $message, $headers)
{

    return  mail($email, $subject, $message, $headers);
}

/**=================================================VALIDATION FUNCTIONS ================================ */
/**=================================================VALIDATION FUNCTIONS ================================ */
/**=================================================VALIDATION FUNCTIONS ================================ */
/**=================================================VALIDATION FUNCTIONS ================================ */
/**=================================================VALIDATION FUNCTIONS ================================ */
/**=================================================VALIDATION FUNCTIONS ================================ */




/**=================================================IF EMAIL EXIST FUNCTIONS ================================ */
/**=================================================IF EMAIL EXIST FUNCTIONS ================================ */


function email_exists($email)
{

    $query = query("SELECT id FROM users WHERE email = '$email' ");
    confirm($query);

    if (count_rows($query) == 1) {

        return true;
    } else {
        return false;
    }
}


/**=================================================IF USERNAME EXIST FUNCTIONS ================================ */
/**=================================================IF USERNAME EXIST FUNCTIONS ================================ */

function username_exists($username)
{

    $query = query("SELECT id FROM users WHERE username = '$username' ");
    confirm($query);

    if (count_rows($query) == 1) {

        return true;
    } else {
        return false;
    }
}

/**=================================================REGISTER USER VALIDATION FUNCTIONS ================================ */
/**=================================================REGISTER USER VALIDATION FUNCTIONS ================================ */


function validate_user_registration()
{

    $errors  = [];
    $min    = 5;
    $max    = 30;


    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        if (isset($_POST['submit'])) {

            $first_name          = clean($_POST['first_name']);
            $last_name           = clean($_POST['last_name']);
            $username            = clean($_POST['username']);
            $email               = clean($_POST['email']);
            $password            = clean($_POST['password']);
            $confirm_password    = clean($_POST['confirm_password']);
            //    $agree_term          = clean($_POST['agree_term']);

            //    if(empty($agree_term)) {

            //     $errors[] = "<div class ='alert alert-danger'>Please agree to terms to register!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            //   }
            /*******************first name validation************************************** */
            if (empty($first_name)) {

                $errors[] = "<div class ='alert alert-danger'>Your firstname field cannot be empty<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }

            /*******************last name validation******************************************/

            if (empty($last_name)) {

                $errors[] = "<div class ='alert alert-danger'>Your lastname field cannot be empty<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }

            /*******************username validation******************************************** */

            if (strlen($username) < $min) {

                $errors[] = "<div class ='alert alert-danger'>Your username cannot be less than {$min} characters<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }
            if (strlen($username) > $max) {

                $errors[] = "<div class ='alert alert-danger'>Are you sure you will remember all that username!!!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }

            if (empty($username)) {

                $errors[] = "<div class ='alert alert-danger'>Your username cannot be empty<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }

            if (username_exists($username)) {

                $errors[] = "<div class ='alert alert-danger'>Username Exists please try another one!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }

            /***********************Email validation******************************************** */

            if (email_exists($email)) {

                $errors[] = "<div class ='alert alert-danger'>Email already exists please proceed to login!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }

            if (empty($email)) {

                $errors[] = "<div class ='alert alert-danger'>Email cannot be empty!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }

            /***********************Password validation******************************************** */

            if ($password !== $confirm_password) {

                $errors[] = "<div class ='alert alert-danger'>Your password does not match to each other!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }

            /***********************Displaying the errors**************************************** */

            if (!empty($errors)) {
                foreach ($errors as $error) {

                    // echo validation_form_errors($error);

                    echo $error;
                }
            } else {

                if (register_user($first_name, $last_name, $username, $email, $password)) {

                    echo "<div class ='alert alert-success text-center'>Registered successfully. <br> Please check your email or spam folder to verify your email!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                } else {

                    echo "<div class ='alert alert-danger text-center'>Failed to register!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                }
            }
        }
    }
}
/**=================================================REGISTER USER FUNCTIONS ================================ */
/**=================================================REGISTER USER FUNCTIONS ================================ */


function register_user($first_name, $last_name, $username, $email, $password)
{


    $first_name         = escape($first_name);
    $last_name          = escape($last_name);
    $username           = escape($username);
    $email              = escape($email);
    $password           = escape($password);

    if (username_exists($username)) {

        return false;
    } elseif (email_exists($email)) {

        return false;
    } else {

        // $password                       = md5($password);
        $password                    = password_hash($password, PASSWORD_BCRYPT, array("cost" => 9));

        $validation_code                = md5(uniqid(rand(), true));

        $sql     = "INSERT INTO users (first_name, last_name, username, email, password, validation_code, active) ";
        $sql    .= " VALUES('{$first_name}', '{$last_name}', '{$username}', '{$email}', '{$password}', '{$validation_code}', 0) ";

        $result  = confirm(query($sql));

        $subject = "ACTIVATION OF ACCOUNT";
        $message = " Please click the link below to activate your account
                         http://localhost/eshop/activate.php?email=$email&code=$validation_code
                    ";
        $headers  = "From: noreply@ecommercesite.com";

        send_mail($email, $subject, $message, $headers);

        return true;
    }
}


/**=================================================ACTIVATE USER VALIDATION FUNCTIONS ================================ */
/**=================================================ACTIVATE USER VALIDATION FUNCTIONS ================================ */


function user_activation()
{


    if ($_SERVER['REQUEST_METHOD'] == "GET") {


        if (isset($_GET['email'])) {

            $activate_email       =  clean($_GET['email']);
            $verification_code    =  clean($_GET['code']);



            $sql    = "SELECT id FROM users WHERE email = '" . escape($_GET['email']) . "' AND validation_code = '" . escape($_GET['code']) . "' ";

            $result = query($sql);
            confirm($result);

            if (count_rows($result) == 1) {

                $sql2          = "UPDATE users SET active = 1, validation_code = 0 WHERE email = '" . escape($activate_email) . "' AND validation_code = '" . escape($verification_code) . "' ";

                $result2       = query($sql2);
                confirm($result2);

                set_message("<div class ='alert alert-success text-center'>User verified successfully. Please Login!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect("index.php");
            } else {

                set_message("<div class ='alert alert-danger text-center'>Sorry your account could not be verified!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                redirect("index.php");
            }
        } else {

            set_message("<div class ='alert alert-danger text-center'>Sorry your account could not be verified!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
            redirect("index.php");
        }
    }
}

/**================================================= USER LOGIN VALIDATION FUNCTIONS ================================ */
/**================================================= USER LOGIN VALIDATION FUNCTIONS ================================ */



function validate_user_login()
{


    $errors  = [];
    $min    = 3;
    $max    = 30;



    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        if (isset($_POST['submit'])) {

            $email           = clean($_POST['email']);
            $password        = clean($_POST['password']);
            $remember_me     = isset($_POST['remember_me"']);

            /***********************email validation******************************************** */

            if (empty($email)) {

                $errors[] = "<div class ='alert alert-danger'>The email field cannot be empty!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }

            /***********************password validation******************************************** */

            if (empty($password)) {

                $errors[] = "<div class ='alert alert-danger'>The password field cannot be empty!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
            }

            /***********************Displaying the errors**************************************** */

            if (!empty($errors)) {

                foreach ($errors as $error) {

                    // echo validation_form_errors($error);

                    echo $error;
                }
            } else {

                if (login_user($email, $password, $remember_me)) {

                    redirect("home/index.php");
                } else {

                    set_message("<div class ='alert alert-danger'>Error occurred while trying to login!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    redirect("index.php");
                }
            }
        }
    }
}

function login_user($email, $password, $remember_me)
{



    $query = "SELECT * FROM users WHERE email = '" . escape($email) . "' AND active = 1";

    $result = query($query);
    confirm($result);

    if (count_rows($result) == 1) {

        while ($row = fetch_array($result)) {


            $db_user_id         = $row['id'];
            $db_username        = $row['username'];
            $db_password        = $row['password'];
            $db_user_firstname  = $row['first_name'];
            $db_user_lastname   = $row['last_name'];
            $db_email           = $row['email'];


            if (password_verify($password, $db_password)) {

                $_SESSION['id']         = $db_user_id;
                $_SESSION['username']   = $db_username;
                $_SESSION['first_name'] = $db_user_firstname;
                $_SESSION['last_name']  = $db_user_lastname;
                $_SESSION['email']      = $db_email;

                if ($remember_me == "on") {

                    setcookie("email", $email, time() + 86400);
                }

                // $email      = $_SESSION['email'];

                return true;
            } else {

                return false;
            }




            //    $db_password = $row['password'];

            //         if(md5($password) === $db_password) {

            // //    if(password_hash($password, PASSWORD_BCRYPT) == $db_password) {

            //         if($remember_me == "on") {

            //             setcookie("email", $email, time() + 86400);

            //         }

            //         $email      = $_SESSION['email'];
            //         $username   = $_SESSION['username'];
            //         return true;

            //    } else {

            //        return false;
            //    }

            return true;
        }
    } else {

        return false;
    }
}


/**================================================= USER LOGIN FUNCTIONS ================================ */
/**================================================= USER LOGIN FUNCTIONS ================================ */


function logged_in_user()
{

    if (isset($_SESSION['email']) || isset($_COOKIE['email'])) {

        return true;
    } else {

        return false;
    }
}



/**================================================= USER LOGIN CHECK FUNCTIONS ================================ */
/**================================================= USER LOGIN CHECK FUNCTIONS ================================ */


function logout()
{

    session_destroy();

    if (isset($_COOKIE['email'])) {

        unset($_COOKIE['email']);
        setcookie("email", "", time() - 86400);
    }

    redirect("index.php");
}



/**================================================= USER RECOVER FUNCTIONS ================================ */
/**================================================= USER RECOVER FUNCTIONS ================================ */


function recover_password()
{


    if (!isset($_GET['forgot'])) {

        redirect("index.php");
    }

    if ($_SERVER['REQUEST_METHOD'] == "POST") {

        if (isset($_SESSION['token']) && $_POST['token'] === $_SESSION['token']) {

            if (isset($_POST['recover'])) {

                $email = escape($_POST['email']);

                if (email_exists($email)) {

                    // $reset_code = md5($email . microtime());
                    $reset_code      = md5(uniqid(rand(), true));

                    setcookie("temp_reset_code", $reset_code, time() + 9000);

                    $sql = query("UPDATE users SET validation_code = '" . escape($reset_code) . "' WHERE email = '" . escape($email) . "' ");
                    confirm($sql);

                    $subject = "RESET CODE";
                    $message = "Here is the password reset code {$reset_code}  . Please copy it and click the link below to reset password....<br>
      
                         Click here to reset your password http://localhost/eshop/code.php?email=$email&code=$reset_code
      
                            ";
                    $headers  = "From: noreply@wilsonkinyua.com";

                    if (send_mail($email, $subject, $message, $headers)) {

                        echo "<div class ='alert alert-success'>Check your email for the reset code!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                    } else {

                        echo "<div class ='alert alert-danger'>Reset code was not sent. Please try again later!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                    }
                } else {

                    echo "<div class ='alert alert-danger'>Email does not exist!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                }
            }
        } else {

            redirect("index.php");
        }
    }
}



/**================================================= VALIDATE RECOVER CODE FUNCTIONS ================================ */
/**================================================= VALIDATE RECOVER CODE FUNCTIONS ================================ */

function validate_code()
{

    if (isset($_COOKIE['temp_reset_code'])) {


        if (!isset($_GET['email']) && !isset($_GET['code'])) {

            redirect("index.php");
        } elseif (empty($_GET['email']) || empty($_GET['code'])) {

            redirect("index.php");
        } else {

            if (isset($_POST['code'])) {

                $email           = clean($_GET['email']);
                $validation_code = clean($_POST["code"]);

                $sql = "SELECT id FROM users WHERE validation_code = '" . escape($validation_code) . "' AND email =  '" . escape($email) . "'";
                $result = query($sql);

                if (count_rows($result) == 1) {

                    setcookie("temp_reset_code", $validation_code, time() + 30000);

                    redirect("reset.php?email=$email&code=$validation_code");
                } else {

                    set_message("<div class ='alert alert-danger text-center'>Sorry wrong validation code!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                    redirect("forgot_password.php");
                }
            }
        }
    } else {

        set_message("<div class ='alert alert-danger text-center'>Sorry your validation code has expired!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
        redirect("forgot_password.php");
    }
}

/**================================================= PASSWORD RESET FUNCTIONS ================================ */
/**================================================= PASSWORD RESET FUNCTIONS ================================ */



function password_reset()
{


    $errors  = [];
    $min    = 8;
    $max    = 30;
    if (isset($_COOKIE['temp_reset_code'])) {

        if (!isset($_GET['email']) || !isset($_GET['code'])) {


            redirect("index.php");
        }


            if ($_SERVER["REQUEST_METHOD"] == "POST") {


                if (isset($_POST['submit'])) {

                    $password            = clean($_POST['password']);
                    $confirm_password    = clean($_POST['confirm_password']);
                    $email               = $_GET['email'];

                    /***********************Password validation******************************************** */

                    if ($password !== $confirm_password) {

                        $errors[] = "<div class ='alert alert-danger'>Your password does not match to each other!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                    }

                    if (strlen($password) < $min) {

                        $errors[] = "<div class ='alert alert-danger'>The password must not be less than 8 characters!!!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
                    }

                    /***********************Displaying the errors**************************************** */

                    if (!empty($errors)) {
                        foreach ($errors as $error) {

                            // echo validation_form_errors($error);

                            echo $error;
                        }
                    } else {

                        $password             = password_hash($password, PASSWORD_BCRYPT, array("cost" => 9));

                        $sql                  = "UPDATE users SET password = '" . escape($password) . "', validation_code = 0 WHERE email = '" . escape($email) . "' ";
                        $result               = query($sql);

                        set_message("<div class ='alert alert-success text-center'>Password updated successfully. You can now login!!!!<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
                        redirect("index.php");
                    }
                }
            }
        
    } else {

        set_message("<div class ='alert alert-danger text-center'>Sorry your time has expired!!!!Try again<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>");
        redirect("index.php");
    }
}


/**=================================================HOME SITE FUNCTIONS ================================ */
/**=================================================HOME SITE FUNCTIONS ================================ */
/**=================================================HOME SITE FUNCTIONS ================================ */
/**=================================================HOME SITE FUNCTIONS ================================ */
/**=================================================HOME SITE FUNCTIONS ================================ */
/**=================================================HOME SITE FUNCTIONS ================================ */
/**
 * 
 * author:wilson kinyua
 * email: wilsonkinyuam@gmail.com
 * year created : June 2020
 * 
 * 
 */


 