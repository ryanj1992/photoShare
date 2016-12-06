<!-- This page is used to insert comments-->

<?php
session_start();
include_once 'dbconnect.php';

// These variables are getting assigned to the data posted from the profile page
$id =  "?id=" . $_SESSION['userSession'];
$id2 = strip_tags($_SESSION['userSession']);
$photo = strip_tags($_POST['photoId']);
$comment = strip_tags($_POST['comment']);

// This statement inserts the new comment information into the database
$sql = "INSERT INTO comments (user_id, photoId, comment)
VALUES ('$id2','$photo','$comment')";

// If the query is successful then user is redirected to previous page
// Else it will throw an error
if (mysqli_query($DBcon, $sql)) {
    header('Location: ' . $_SERVER["HTTP_REFERER"] );
} else {
    echo "Error: " . $sql . "<br>" . mysqli_error($DBcon);
}

mysqli_close($DBcon);
exit;
?>