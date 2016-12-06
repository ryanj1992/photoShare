<!-- This page is used to delete photos -->

<?php
session_start();
include_once 'dbconnect.php';

// this gets the photoId of the right photo
$id2 = $_GET['photoId'];
// this statement deletes the right photo
$sql = ("DELETE FROM photos WHERE photoId = '$id2'");

// If the query is successful then user is redirected to previous page
// Else it will throw an error
if ($DBcon->query($sql) === TRUE) {
    header('Location: ' . $_SERVER["HTTP_REFERER"]);
} else {
    echo "Error updating record: " . $DBcon->error;
}
$mysqli_close($DBcon);

?>