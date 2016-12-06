<!-- This page allows a user to log in -->
<?php
session_start();
require_once 'dbconnect.php';

if (isset($_POST['btn-login'])) {

    // These variables are getting assigned to the data posted from the login page
    // Includes strip_tags so that tags cannot be entered (security feature)

    $email = strip_tags($_POST['email']);
    $password = strip_tags($_POST['password']);

    // Cleanses the data of quotes and slashes with real_escape_string (security feature)
    $email = $DBcon->real_escape_string($email);
    $password = $DBcon->real_escape_string($password);

    // This query fetches information from the database
    $query = $DBcon->query("SELECT user_id, username, email, password, userPermission, bio, country FROM tbl_users WHERE email='$email'");
    $row = $query->fetch_array();
    // if email/password are correct returns must be 1 row
    $count = $query->num_rows;

    // This if statement check to see whether the user is banned - if so it will display a message
    if (password_verify($password, $row['password']) && $count == 1 && $row['userPermission'] == 5) {
        $msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Sorry you are Banned!
				</div>";
    } // If the email and password are correct then the session is populated
    elseif (password_verify($password, $row['password']) && $count == 1) {
        $_SESSION['userSession'] = $row['user_id'];
        $_SESSION['email'] = $row['email'];
        $_SESSION['username'] = $row['username'];
        $_SESSION['Bio'] = $row['bio'];
        $_SESSION['country'] = $row['country'];
        $_SESSION['userPermission'] = $row['userPermission'];
        header("Location: index.php");
    } // if the email and password is wrong then it will output this message
    else {
        $msg = "<div class='alert alert-danger'>
					<span class='glyphicon glyphicon-info-sign'></span> &nbsp; Invalid Username or Password !
				</div>";
    }
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


        <form class="form-signin" method="post" id="login-form">

            <h2 class="form-signin-heading">Sign In.</h2>
            <hr/>

            <!-- Outputs message whether banned / incorrect -->
            <?php
            if (isset($msg)) {
                echo $msg;
            }
            ?>

            <div class="form-group">
                <input type="email" class="form-control" placeholder="Email address" name="email" required/>
                <span id="check-e"></span>
            </div>

            <div class="form-group">
                <input type="password" class="form-control" placeholder="Password" name="password" required/>
            </div>

            <hr/>

            <div class="form-group">
                <button type="submit" class="btn btn-default" name="btn-login" id="btn-login">
                    <span class="glyphicon glyphicon-log-in"></span> &nbsp; Sign In
                </button>

                <a href="register.php" class="btn btn-default" style="float:right;">Sign UP Here</a>

            </div>

        </form>

    </div>

</div>

</body>
</html>