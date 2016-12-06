// This page runs a php script that
// accepts a user that whats to be a photographer

<?php
session_start();
include_once 'dbconnect.php';

$id = "?id=" . $_SESSION['userSession'];
// Gets user_id from profile page
$id2 = $_GET['user_id'];

// Generates SQL statement to update the database with new values
$sql = ("UPDATE tbl_users SET userPermission = 3 WHERE user_id = '$id2'");

// If the SQL statement is true then it will redirect the user to admin.php
// If false it will produce an error
if ($DBcon->query($sql) === TRUE) {
    header("Location: admin.php");
} else {
    echo "Error updating record: " . $DBcon->error;
}

//Close 
$mysqli_close($DBcon);
?>