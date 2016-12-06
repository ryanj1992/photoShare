<!-- This page allows new users to register with the website -->
<?php
session_start();
if (isset($_SESSION['userSession']) != "") {
    header("Location: home.php");
}
require_once 'dbconnect.php';

if (isset($_POST['btn-signup'])) {

    // uses strip tags so that cross side scripting can not be used within the form
    // sets variables

    $uname = strip_tags($_POST['username']);
    $email = strip_tags($_POST['email']);
    $upass = strip_tags($_POST['password']);

    //escapes the string for even for security
    $uname = $DBcon->real_escape_string($uname);
    $email = $DBcon->real_escape_string($email);
    $upass = $DBcon->real_escape_string($upass);

    // hashs the password and adds a default salt
    // this makes it near impossible to brute force attack
    $hashed_password = password_hash($upass, PASSWORD_DEFAULT);

    // this checks the email is correct and has not been used with another account
    $check_email = $DBcon->query("SELECT email FROM tbl_users WHERE email='$email'");
    $count = $check_email->num_rows;

    if ($count == 0) {
        // inserts the new user into the database
        $query = "INSERT INTO tbl_users(username,email,password) VALUES('$uname','$email','$hashed_password')";

        // if successful it will give the following output
        if ($DBcon->query($query)) {
            $msg = "<div class='alert alert-success'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; successfully registered !
					</div>";
        } else {
            // if unsuccessful it will output the following
            $msg = "<div class='alert alert-danger'>
						<span class='glyphicon glyphicon-info-sign'></span> &nbsp; error while registering !
					</div>";
        }

    } else {

        // if email is aleady being used it will output the following
        $msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; sorry email already taken !
				</div>";

    }
    // close the connection
    $DBcon->close();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php require_once("menu.php"); ?>
</head>
<body>

<div class="signin-form">

    <div class="container">

        <!-- form for login -->
        <form class="form-signin" method="post" id="register-form">

            <h2 class="form-signin-heading">Sign Up</h2>
            <hr/>

            <?php
            if (isset($msg)) {
                echo $msg;
            }
            ?>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="Username" name="username" required/>
            </div>

            <div class="form-group">
                <input type="email" class="form-control" placeholder="Email address" name="email" required/>
                <span id="check-e"></span>
            </div>

            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="password" required/>
            </div>

            <hr/>

            <div class="form-group">
                <button type="submit" class="btn btn-default" name="btn-signup">
                    <span class="glyphicon glyphicon-log-in"></span> &nbsp; Create Account
                </button>
                <a href="login.php" class="btn btn-default" style="float:right;">Log In Here</a>
            </div>

        </form>

    </div>

</div>

</body>
</html>