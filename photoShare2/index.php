<?php
session_start();
include_once 'dbconnect.php';
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <?php require_once("menu.php"); ?>
</head>
<body>

<div class="jumbotron"
     style="text-align:center;font-family:Verdana, Geneva, sans-serif;font-size:35px; color:cornflowerblue;">
    <h1>photoShare.<br/><br/></h1>

    <!-- If the user has just registered then this will show a button
     and allow them to click it if they wish to become a photographer-->

    <?php if ($_SESSION['userPermission'] == 1) { ?>
        <h2>Upgrade to Photographer</h2>
        <p>
        <form name="isVerified" action="isVerified.php" method="post">
            <input type="submit"/><br/>
        </p>
    <?php } ?>


</div>

<div class="container"
     style="margin-top:20px;text-align:center;font-family:Verdana, Geneva, sans-serif;font-size:15px;">

    <p><?php

        // Search from MySQL database table
        $search = strip_tags($_POST['search']);

        $sql = "SELECT title, imageURL, user_id from photos where title LIKE '%$search%' LIMIT 0 , 15";
        $result = $DBcon->query($sql);

        // Display search result
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class = 'col-md-4' align = 'left'><br><br>";
                echo "<a href=/profile.php?id=" . $row["user_id"] . "><img src=" . $row["imageURL"] . " height ='350' width ='350'></a>";
                echo "</div>";
            }
        } else {
            echo 'Nothing found';
        }
        ?>
    </p>
</div>

<footer>
    <p>&copy; 2016 photoShare.</p>
</footer>

</body>
</html>