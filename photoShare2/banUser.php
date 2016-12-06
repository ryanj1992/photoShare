<!-- This page selects the user and bans the right one-->

<?php
session_start();
include_once 'dbconnect.php';

// Gets the users id that needs to be banned
$id2 = $_GET['user_id'];

// Updates their userPermission to 5 (banned from logging in)
$sql = ("UPDATE tbl_users SET userPermission = 5 WHERE user_id = '$id2'");

// If the query is successful then user is redirected to previous page
// Else it will throw an error
if ($DBcon->query($sql) === TRUE) {
    header('Location: ' . $_SERVER["HTTP_REFERER"]);
} else {
    echo "Error updating record: " . $DBcon->error;
}

// close database connection
$mysqli_close($DBcon);
?>