<?php
session_start();
include_once 'dbconnect.php';

//Get the comment id

$comment = $_GET['comment_id'];

// deletes the correct comment from the database
$sql = ("DELETE FROM comments WHERE comment_id = '$comment'");

// If the query is successful then user is redirected to previous page
// Else it will throw an error
if ($DBcon->query($sql) === TRUE) {
    header('Location: ' . $_SERVER["HTTP_REFERER"]);
} else {
    echo "Error updating record: " . $DBcon->error;
}
$mysqli_close($DBcon);

?>