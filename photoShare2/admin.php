<?php

// Start the session
session_start();
include_once 'dbconnect.php';
?>

<!DOCTYPE html>

<html lang="en">

<head>
    <?php require_once("menu.php"); ?>
</head>

<body>


    <?php
    // Checks the userPermission level and displays correct output
    // This ensures that certain users are restricted
    if ($_SESSION['userPermission'] == 4): ?>
<div class="jumbotron">
    <div class="container">
        <!-- Welcomes the user and their name -->
        <h1>Welcome <?php echo $_SESSION['username']; ?></h1>
    </div>
</div>

<div class="container">
    <div class="row">
        <div class="col-md-4">
            <h2>Approval</h2>
            <p> <?php
                    // SQL statement to select all users that have clicked the upgrade button on the home page
                    $sql = "SELECT user_id, username, email, userPermission FROM tbl_users WHERE userPermission = 2";
                    $result = mysqli_query($DBcon, $sql);

                    if (mysqli_num_rows($result) > 0) {
                        // output data of each row
                        while($row = mysqli_fetch_assoc($result)) {
                            //accepts the user to become photographer
                            echo "Name: " . $row["email"]. " - <form action ='accept.php?user_id=".$row['user_id']."'name='accept' method ='post'>";
                            echo "<input type='submit' value='Accept' class = 'btn btn-warning btn-md'></form>";
                        }
                    } else {
                        echo "0 results";
                      }
                ?></p>
        </div>
        <div class="col-md-4">
            <h2>Ban Users</h2>
            <p> <?php
                //Selects all users that userPermissions are between 3 and 5
                $sql = "SELECT user_id, username, email, userPermission FROM tbl_users WHERE userPermission >= 3 && userPermission < 5";
                $result = mysqli_query($DBcon, $sql);

                if (mysqli_num_rows($result) > 0) {
                    // output data of each row
                    while($row = mysqli_fetch_assoc($result)) {
                        // button that bans the user (increases their userPermission to 5)
                        echo "Name: " . $row["email"]. " - <form action ='banUser.php?user_id=".$row['user_id']." 'name='banUser' method ='post'>";
                        echo "<input type='submit' class = 'btn btn-warning btn-md' value='Ban'></form>";
                    }
                } else {
                    echo "0 results";
                }
                ?></p>
        </div>
        <div class="col-md-4">
            <h2>Banned Users</h2>
            <p><?php
                //Selects all users that userPermissions are 5
            $sql = "SELECT user_id, username, email, userPermission FROM tbl_users WHERE userPermission = 5 ";
            $result = mysqli_query($DBcon, $sql);

            if (mysqli_num_rows($result) > 0) {
                // output data of each row
                while($row = mysqli_fetch_assoc($result)) {
                    // Button that un-bans the user (decreases their userPermission back to 3)
                    echo "Name: " . $row["email"]. " - <form action ='accept.php?user_id=".$row['user_id']."'name='accept' method ='post'>";
                    echo "<input type='submit' class = 'btn btn-warning btn-md' value='Restore User'></form>";
                }
            } else {
                echo "0 results";
            }
            ?></p>
        </div>
    </div>
    <?php else: ?>
        <!-- If the user does not have permission to access the admin page
            This message will show-->
        <div class="container" style="margin-top:150px;text-align:center;font-family:Verdana, Geneva, sans-serif;font-size:35px;">
            <p>You do not have rights to access this page!</p>
        </div>
    <?php endif; ?>
    <hr>

    <footer>
        <p>&copy; 2016 photoShare.</p>
    </footer>
</div>
<?php $mysqli_close($DBcon); ?>



<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script>window.jQuery || document.write('<script src="../../assets/js/vendor/jquery.min.js"><\/script>')</script>
<script src="bootstrap/dist/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="bootstrap/assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>
