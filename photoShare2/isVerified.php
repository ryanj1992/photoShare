<!-- This page is used when upgrade to photographer is pressed-->
<?php
session_start();
include_once 'dbconnect.php';

// this statement updates the users userPermission to 2 when the user clicks the upgrade button
$sql = ("UPDATE tbl_users SET userPermission = 2 WHERE user_id=".$userRow['user_id']);

// If the query is successful then the user is redirected to previous page
// and the userPermission is updated to 2
// Else it will throw an error
    if ($DBcon->query($sql) === TRUE) {
        $_SESSION['userPermission'] = 2;
        header("Location: index.php");
    } else {
        echo "Error updating record: " . $DBcon->error;
    }
    $mysqli_close($DBcon);
?>