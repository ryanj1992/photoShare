<!-- This page is for searching for photographers -->
<?php
header('Cache-Control: no cache'); //no cache
session_cache_limiter('private_no_expire'); // works
session_start();
require_once 'dbconnect.php';
?>

<head>
    <?php require_once("menu.php"); ?>
</head>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<body>

<div class="jumbotron"
     style="text-align:center;font-family:Verdana, Geneva, sans-serif;font-size:35px; color:cornflowerblue;">
    <h1>photoShare.<br/><br/></h1>
    </div>


<div class="container"
     style="margin-top:30px;text-align:center;font-family:Verdana, Geneva, sans-serif;font-size:35px;">
    Search Results.<br/><br/>

    <p><?php
        // Search from MySQL database table
        $search = strip_tags($_POST['search']);
        $sql = "select username, user_id from tbl_users where username LIKE '%$search%' AND userPermission >=2 LIMIT 0 , 10";
        $result = $DBcon->query($sql);
        // Display search result
        if (mysqli_num_rows($result) > 0) {
            echo "Profiles";
            while ($row = mysqli_fetch_assoc($result)) { //output results on a new row
                echo "<br>";
                echo $row['username']; //output username
                echo '<a href="/profile.php?id=' . $row['user_id'] . '"> Click to View</a>'; //click to go to profile
            }
            echo "</table>";
        } else {
            echo 'Nothing found'; //displays if search doesnt match anything
        }
        ?>
    </p>
</div>
</body>
</html>
