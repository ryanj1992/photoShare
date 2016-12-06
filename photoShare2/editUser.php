<!-- This page is used to edit users information -->
<?php
session_start();
include_once 'dbconnect.php';

$id = "?id=" . $_SESSION['userSession'];
$username = strip_tags($_POST['username']);
$bio = strip_tags($_POST['bio']);
$country = strip_tags($_POST['country']);

// This statement updates the users information in the database
$sql = "UPDATE tbl_users SET username = '$username', Bio = '$bio', country = '$country'  WHERE user_id =" . $_SESSION['userSession'];
$result = mysqli_query($DBcon, $sql);


// If the query is successful it populates the session with the new input and
// then user is redirected to previous page
// Else it will say "failed"
if ($result) {
    $_SESSION['username'] = $username;
    $_SESSION['Bio'] = $bio;
    $_SESSION['country'] = $country;
    header("location:../profile.php$id");
} else {
    echo "Failed";
}

$mysqli_close($DBcon);
?>