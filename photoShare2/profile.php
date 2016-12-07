<?php
session_start();
include_once 'dbconnect.php';
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
    <?php require_once("menu.php"); ?>
    <!-- Add jQuery library -->
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.min.js"></script>

    <!-- Add mousewheel plugin (this is optional) -->
    <script type="text/javascript" src="/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>

    <!-- Add fancyBox -->
    <link rel="stylesheet" href="/fancybox/source/jquery.fancybox.css?v=2.1.5" type="text/css" media="screen"/>
    <script type="text/javascript" src="/fancybox/source/jquery.fancybox.pack.js?v=2.1.5"></script>

    <!-- Optionally add helpers - button, thumbnail and/or media -->
    <link rel="stylesheet" href="/fancybox/source/helpers/jquery.fancybox-buttons.css?v=1.0.5" type="text/css"
          media="screen"/>
    <script type="text/javascript" src="/fancybox/source/helpers/jquery.fancybox-buttons.js?v=1.0.5"></script>
    <script type="text/javascript" src="/fancybox/source/helpers/jquery.fancybox-media.js?v=1.0.6"></script>

    <link rel="stylesheet" href="/fancybox/source/helpers/jquery.fancybox-thumbs.css?v=1.0.7" type="text/css"
          media="screen"/>
    <script type="text/javascript" src="/fancybox/source/helpers/jquery.fancybox-thumbs.js?v=1.0.7"></script>

</head>
<body>

<script type="text/javascript">
    $(document).ready(function () {
        $(".fancybox").fancybox();
    });
</script>

<?php

// Gets the id
$id = $_GET['id'];

// checks the user's userPermission complies with these laws
if (isset($_SESSION['userSession']) && $id == $_SESSION['userSession'] && $_SESSION['userPermission'] >= 3){ ?>

    <!-- Creates jumbotron -->
    <div class="jumbotron">
        <div class="container">
            <h1>Hello <?php echo $_SESSION['username']; ?></h1>
        </div>
    </div>

    <div class="container">
    <!-- Example row of columns -->
    <div class="row">
    </div>

    <!-- this creates a form so that users can edit their information -->
    <div>
        <div class="col-md-4">
            <h2>Edit Information</h2>
            <div class="row">
                <form action="editUser.php" method="post" name="editUser" enctype="multipart/form-data">
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="usr">Name:</label>
                            <input type="text" class="form-control" name="username"
                                   value="<?php echo $_SESSION['username']; ?>">

                            <label for="usr">Bio:</label>
                        <textarea class="form-control" name="bio" rows="5"
                                  cols="80"><?php echo $_SESSION['Bio']; ?></textarea>

                            <label for="usr">Country:</label>
                            <input type="text" class="form-control" name="country"
                                   value="<?php echo $_SESSION['country']; ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-default">Update Info</button>
                    </div>
                </form>
            </div>
        </div>


    </div>
    <div class="row">

        <!-- Trigger the modal with a button -->
        <button type="button" class="btn btn-info btn-lg" data-toggle="modal" data-target="#myModalUpload">Upload
            Image
        </button>

        <!-- Modal -->
        <div id="myModalUpload" class="modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal">&times;</button>
                        <h4 class="modal-title">Upload a Photo</h4>
                    </div>
                    <!-- Form to allow user to upload photos and insert prices and meta data-->
                    <form action="/s3-updated/upload.php" method="post" enctype="multipart/form-data">
                        <div class="modal-body">
                            <input type="file" name="file" required> <br>
                            <label>Insert a price:</label>
                            £<input class=form-control type="text" name="price"><br>
                            <label for="imageData">Add Meta Data:</label>
                            <textarea class="form-control" name="metaData" rows="5" cols="80"></textarea><br> <br>
                            <input type="submit" class="btn btn-info btn-md" value="Upload Image">
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>

        </div>
    </div>
    <h2>Images</h2>
    <?php

    // Selects all images of user
    $sql = "SELECT imageURL, photoId, price, title, metaData FROM photos WHERE user_id = $id";
    $result = $DBcon->query($sql);
    $i = 0;

    if (mysqli_num_rows($result) > 0) {
        // output each image along with their title
        while ($row = mysqli_fetch_assoc($result)) {
            $i++;
            echo "<div class = 'container' <br> <br>";
            echo "<h3>£".$row["price"]. "</h3>";
            echo "<a class='fancybox' rel='gallery1' href=" . $row["imageURL"] . "><img src=" . $row["imageURL"] . " height ='300' width ='300' align='left'></a>";

            // selects all comments from a specific photo
            $sql2 = "SELECT c.comment, c.comment_id, t.username, c.date FROM comments c, tbl_users t WHERE t.user_id = c.user_id AND photoId= " . $row['photoId'] . " ";
            $result2 = $DBcon->query($sql2);

            if (mysqli_num_rows($result2) > 0) {
                while ($row2 = mysqli_fetch_assoc($result2)) { // output each comment
                    echo "<div class = 'wrapText'>"; // wraps text in div
                    echo "<h4> " . $row2['comment'] . "</h4>"; // displays comment
                    echo "<p> Posted By: " . $row2['username'] . " @ " . $row2['date'] . "</p>"; // displays who it was posted by
                    echo "</div>";
                    // Display delete button for each comment
                    echo "<form action = 'deleteComment.php?comment_id=" . $row2['comment_id'] . "'name='commentDelete' method ='post'>";
                    echo "<input type='submit' class='btn btn-danger btn-sm' name='commentDelete' value='Delete Comment'></form>";
                }
            } ?>
            <!-- form to allow users to insert comments-->
            <form action="insertComment.php" method="post" enctype="multipart/form-data">
                <textarea rows='3' cols='45' name='comment' required placeholder='Type comment here..'></textarea>
                <?php echo "<input type='hidden' name = 'photoId' value = " . $row['photoId'] . ">" ?>
                <input type="submit" class="btn btn-info btn-md" value="Comment">
            </form>

            <!-- Trigger the modal with a button -->
            <button type="button" class="btn btn-info btn-md" data-toggle="modal"
                    data-target="#myModal<?php echo $i ?>">Edit
            </button>
            <div id="myModal<?php echo $i ?>" class="modal fade" role="dialog">
                <div class="modal-dialog">

                    <!-- Modal content-->
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="close" data-dismiss="modal">&times;</button>
                            <h4 class="modal-title">Edit Photo</h4>
                        </div>
                        <!-- form to allow user to update their photos price, meta data and title-->
                        <form action="editPhoto.php" method="post" enctype="multipart/form-data">
                            <div class="modal-body">
                                <?php echo "<img src=" . $row["imageURL"] . " height ='300' width ='300'>" ?><br><br>
                                <?php echo "<p>Update price: £<input type='text' class = 'form-control' value = " . $row['price'] . " name='price'></p>" ?>
                                <?php echo "<p>Update title:  <input type='text' class = 'form-control' value = " . $row['title'] . " name='title'></p>" ?>
                                <?php echo "<input type='hidden' name = 'photoId' value = " . $row['photoId'] . ">" ?>
                                <?php echo "<label for='imageData'>Meta Data:</label>" ?>
                                <textarea readonly='true' class='form-control' name='metaData' rows='5' cols='80'>
                                    <?php
                                    //read exif data from each image
                                    $exif = exif_read_data($row["imageURL"], 0, true);
                                    foreach ($exif as $key => $section) {
                                        foreach ($section as $name => $val) {
                                            echo "$key.$name: $val\n";
                                        }
                                    }
                                    // Adds users meta data input when they uploaded an image
                                    echo "Meta Data Added By User:";
                                    echo $row['metaData'];

                                    ?>
                                </textarea><br> <br>
                                <input type="submit" class="btn btn-info btn-md" value="Update"
                            </div>
                        </form>
                        <!-- displays a delete button allowing a user to delete their photo-->
                        <?php echo "<form action = 'deletePhoto.php?photoId=" . $row['photoId'] . "'name='delete' method ='post'>";
                        echo "<input type='submit' class='btn btn-danger btn-md' value='Delete Photo'></form>"; ?>

                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
            </div>
            </div>
            <?php echo "</div>" ?>
            <?php echo "<hr>" ?>
            <?php

        }
    } else {
        echo "No Images"; // display this is no images found
    }
    ?>
    <!-- checks the user's userPermission complies with these laws (shoppers and other photographers -->
<?php } elseif ($_SESSION['userPermission'] == 1 || $_SESSION['userPermission'] == 2 || $_SESSION['userPermission'] == 3) { ?>
    <div class="jumbotron"
         style="margin-top:0px;text-align:center;font-family:Verdana, Geneva, sans-serif;font-size:35px;">
        <?php

        $query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id= $id");
        $userRow = $query->fetch_array();
        ?>
        <!-- displays their name -->
        <h2>Name: <?php echo $userRow['username']; ?></h2>
        <!-- displays their bio -->
        <p>Bio: <?php echo $userRow['Bio']; ?></p>
        <!-- displays their country -->
        <p>Country: <?php echo $userRow['country']; ?></p>
    </div>
    <div>

        <?php
        // Select photos from user
        $sql = "SELECT imageURL, photoId, price, metaData, title FROM photos WHERE user_id = $id";
        $result = $DBcon->query($sql);
        $i = 0;
        if (mysqli_num_rows($result) > 0) {

            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                $i++;
                echo "<div class = 'container' <br> <br>";
                echo "<h3>£".$row["price"]. "</h3>";
                echo "<a class='fancybox' rel='gallery1' href=" . $row["imageURL"] . "><img src=" . $row["imageURL"] . " height ='300' width ='300' align='left'></a>";


                $sql2 = "SELECT c.comment, c.comment_id, t.username, c.date FROM comments c, tbl_users t WHERE t.user_id = c.user_id AND photoId= " . $row['photoId'] . " ";
                $result2 = $DBcon->query($sql2);

                if (mysqli_num_rows($result2) > 0) {
                    while ($row2 = mysqli_fetch_assoc($result2)) {
                        echo "<div class = 'wrapText'>";
                        echo "<h4> " . $row2['comment'] . "</h4>";
                        echo "<p> Posted By: " . $row2['username'] . " @ " . $row2['date'] . "</p>";
                        echo "</div>";
                    }
                }
                ?>
                <form action="insertComment.php" method="post" enctype="multipart/form-data">
                    <textarea rows='3' cols='45' name='comment' placeholder='Type comment here..' required></textarea>
                    <?php echo "<input type='hidden' name = 'photoId' value = " . $row['photoId'] . ">" ?>
                    <input type="submit" class="btn btn-info btn-md" value="Comment">
                </form>

                <button type="button" class="btn btn-info btn-md" data-toggle="modal"
                        data-target="#myModal<?php echo $i ?>">View Information
                </button>
                <?php echo "</div>" ?>
                <div id="myModal<?php echo $i ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">Image Information</h4>
                            </div>
                            <div class="modal-body">
                                <?php echo "<img src=" . $row["imageURL"] . " height ='300' width ='300'>" ?><br><br>
                                <?php echo "<input type='hidden' name = 'photoId' value = " . $row['photoId'] . ">" ?>
                                <h4>Price: £<?php echo $row['price'] ?></h4>
                                <!-- implements a paypal button so that shoppers can buy photos-->
                                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                    <input type="hidden" name="cmd" value="_xclick">
                                    <input type="hidden" name="business" value="Ryanj1992@hotmail.co.uk">
                                    <input type="hidden" name="lc" value="BM">
                                    <input type="hidden" name="button_subtype" value="services">
                                    <input type="hidden" name="no_note" value="0">
                                    <input type="hidden" name="currency_code" value="USD">
                                    <input type="hidden" name="bn"
                                           value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest">
                                    <input type="image"
                                           src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif"
                                           border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif"
                                         width="1" height="1">
                                </form>
                                <h4>Name: <?php echo $row['title'] ?> </h4>
                                <h4>Meta Data:</h4>
                                <textarea readonly='true' class='form-control' name='metaData' rows='5' cols='80'>
                                    <?php

                                    $exif = exif_read_data($row["imageURL"], 0, true);
                                    foreach ($exif as $key => $section) {
                                        foreach ($section as $name => $val) {
                                            echo "$key.$name: $val\n";
                                        }
                                    }
                                    // Adds users meta data input when they uploaded an image
                                    echo "Meta Data Added By User:";
                                    echo $row['metaData'];
                                    ?>
                                </textarea><br> <br>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>
                <?php echo "</div>";
            }
        } else {
            echo "No images";
        }
        ?>
    </div>

    <!-- This allows admins to edit others photos and comments -->
<?php } elseif ($_SESSION['userPermission'] == 4) { ?>

    <div class="jumbotron"
         style="margin-top:0px;text-align:center;font-family:Verdana, Geneva, sans-serif;font-size:35px;">
        <?php
        $query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id= $id");
        $userRow = $query->fetch_array();
        ?>

        <h2>Name: <?php echo $userRow['username']; ?></h2>

        <p>Bio: <?php echo $userRow['Bio']; ?></p>

        <p>Country: <?php echo $userRow['country']; ?></p>
    </div>
    <div>
        <?php
        // display images from user
        $sql = "SELECT imageURL, photoId, price FROM photos WHERE user_id = $id";
        $result = $DBcon->query($sql);

        if (mysqli_num_rows($result) > 0) {

            // output data of each row
            while ($row = mysqli_fetch_assoc($result)) {
                echo "<div class = 'container' <br> <br>";
                echo "<form action = 'deletePhoto.php?photoId=" . $row['photoId'] . "'name='delete' method ='post'>
                <input type='submit' class='btn btn-danger btn-sm' name='delete' value='Delete Photo'></form></p>";
                echo "<h3>£".$row["price"]. "</h3>";
                echo "<a class='fancybox' rel='gallery1' href=" . $row["imageURL"] . "><img src=" . $row["imageURL"] . " height ='300' width ='300' align='left'></a>";


                $sql2 = "SELECT c.comment, c.comment_id, t.username, c.date FROM comments c, tbl_users t WHERE t.user_id = c.user_id AND photoId= " . $row['photoId'] . " ";
                $result2 = $DBcon->query($sql2);

                if (mysqli_num_rows($result2) > 0) {
                    while ($row2 = mysqli_fetch_assoc($result2)) {
                        echo "<div class = 'wrapText'>";
                        echo "<h4> " . $row2['comment'] . "</h4>";
                        echo "<p> Posted By: " . $row2['username'] . " @ " . $row2['date'] . "</p>";
                        echo "</div>";
                        echo "<form action = 'deleteComment.php?comment_id=" . $row2['comment_id'] . "'name='commentDelete' method ='post'>";
                        echo "<input type='submit' class='btn btn-danger btn-sm' name='commentDelete' value='Delete Comment'></form> <br>";
                    }
                }
                ?>
                <form action="insertComment.php" method="post" enctype="multipart/form-data">
                    <textarea rows='3' cols='45' name='comment' placeholder='Type comment here..' required></textarea>
                    <br>
                    <?php echo "<input type='hidden' name = 'photoId' value = " . $row['photoId'] . ">" ?>
                    <input type="submit" class="btn btn-info btn-md" value="Comment">
                </form>

                <button type="button" class="btn btn-info btn-md" data-toggle="modal"
                        data-target="#myModal<?php echo $i ?>">View Information
                </button>
                <?php echo "</div>" ?>
                <div id="myModal<?php echo $i ?>" class="modal fade" role="dialog">
                    <div class="modal-dialog">

                        <!-- Modal content-->
                        <div class="modal-content">
                            <div class="modal-header">
                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                <h4 class="modal-title">View Meta Data</h4>
                            </div>
                            <div class="modal-body">
                                <?php echo "<img src=" . $row["imageURL"] . " height ='300' width ='300'>" ?><br><br>
                                <?php echo "<input type='hidden' name = 'photoId' value = " . $row['photoId'] . ">" ?>
                                <h4>Price: £<?php echo $row['price'] ?></h4>
                                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_top">
                                    <input type="hidden" name="cmd" value="_xclick">
                                    <input type="hidden" name="business" value="Ryanj1992@hotmail.co.uk">
                                    <input type="hidden" name="lc" value="BM">
                                    <input type="hidden" name="button_subtype" value="services">
                                    <input type="hidden" name="no_note" value="0">
                                    <input type="hidden" name="currency_code" value="USD">
                                    <input type="hidden" name="bn"
                                           value="PP-BuyNowBF:btn_buynowCC_LG.gif:NonHostedGuest">
                                    <input type="image"
                                           src="https://www.paypalobjects.com/en_US/i/btn/btn_buynowCC_LG.gif"
                                           border="0" name="submit" alt="PayPal - The safer, easier way to pay online!">
                                    <img alt="" border="0" src="https://www.paypalobjects.com/en_US/i/scr/pixel.gif"
                                         width="1" height="1">
                                </form>
                                <h4>Name: <?php echo $row['title'] ?> </h4>
                                <h4>Meta Data:</h4>
                                 <textarea readonly='true' class='form-control' name='metaData' rows='5' cols='80'>
                                    <?php

                                    $exif = exif_read_data($row["imageURL"], 0, true);
                                    foreach ($exif as $key => $section) {
                                        foreach ($section as $name => $val) {
                                            echo "$key.$name: $val\n";
                                        }
                                    }
                                    // Adds users meta data input when they uploaded an image
                                    echo "Meta Data Added By User:";
                                    echo $row['metaData'];
                                    ?>
                                </textarea><br> <br>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        </div>
                    </div>
                </div>

                <?php echo "</div>";
            }
        } else {
            echo "No Images";
        }
        ?>
    </div>


<?php }
else{ ?>
    <!-- This is what the general public can see -->
<div class="container"
     style="margin-top:150px;text-align:center;font-family:Verdana, Geneva, sans-serif;font-size:35px;">
    <?php
    $query = $DBcon->query("SELECT * FROM tbl_users WHERE user_id= $id");
    $userRow = $query->fetch_array();
    ?>

    <h2>Name: <?php echo $userRow['username']; ?></h2>

    <p>Bio: <?php echo $userRow['Bio']; ?></p>

    <p>Country: <?php echo $userRow['country']; ?></p>

    <?php

    $sql = "SELECT imageURL, photoId FROM photos WHERE user_id = $id";
    $result = $DBcon->query($sql);

    if (mysqli_num_rows($result) > 0) {

        // output data of each row
        while ($row = mysqli_fetch_assoc($result)) {
            echo "<a class='fancybox' rel='gallery1' href=" . $row["imageURL"] . "><img src=" . $row["imageURL"] . " height ='300' width ='300'></a>";
        }

    } else {
        echo "No Images";
    }
    }


    ?>

</div>

<hr>
<footer>
    <p>&copy; 2016 photoShare.</p>
</footer>
<!-- /container -->
<?php $mysqli_close($DBcon); ?>
</body>
</html>


<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src="bootstrap/dist/js/bootstrap.min.js"></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="bootstrap/assets/js/ie10"</script>