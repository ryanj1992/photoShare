<!-- This page is used to edit photos -->
<?php
session_start();
include_once 'dbconnect.php';

// These variables are getting assigned to the data posted from the profile page
$id =  "?id=" . $_SESSION['userSession'];
$price = strip_tags($_POST['price']);
$photo = strip_tags($_POST['photoId']);
$title = strip_tags($_POST['title']);
$metaData = strip_tags($_POST['metaData']);

// This statement updates the price, title and metaData to the new input
$sql = ("UPDATE photos SET price = '$price', title = '$title', metaData = '$metaData' WHERE photoId = '$photo'");

// If the query is successful then user is redirected to previous page
// Else it will throw an error
if ($DBcon->query($sql) === TRUE) {
    header("location:../profile.php$id");
} else {
    echo "Error updating record: " . $DBcon->error;
}
$mysqli_close($DBcon);
?>