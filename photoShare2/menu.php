<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    
    <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
    <link rel="manifest" href="/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">

    <title>photoShare.</title>

    <!-- Bootstrap core CSS -->
    <link href="bootstrap/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
    <link href="bootstrap/assets/css/ie10-viewport-bug-workaround.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/jumbotron.css" rel="stylesheet">

    <!-- Just for debugging purposes. Don't actually copy these 2 lines! -->
    <!--[if lt IE 9]>
    <script src="../../assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
    <script src="bootstrap/assets/js/ie-emulation-modes-warning.js"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
    <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->

</head>

<?php

$id = "?id=" . $_SESSION['userSession'];
?>

<nav class="navbar navbar-default navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar"
                    aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand">photoShare.</a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="index.php">Home</a></li>
                <!-- only users with userPermission 4 (admin) can see this on the menu bar -->
                <?php if ($_SESSION['userPermission'] >= 4): ?>
                    <li><a href="admin.php">Admin</a></li>
                    <li><a href="profile.php<?php echo $id ?>"><span
                                class="glyphicon glyphicon-user"></span>&nbsp; <?php echo $_SESSION['username']; ?></a>
                    </li>
                    <li><a href="logout.php?logout">&nbsp; Logout</a></li>
                    <!-- only users with userPermission 3 (photographers) can see this on the menu bar -->
                <?php elseif ($_SESSION['userPermission'] == 3): ?>
                    <li><a href="profile.php<?php echo $id ?>"><span
                                class="glyphicon glyphicon-user"></span>&nbsp; <?php echo $_SESSION['username']; ?></a>
                    </li>
                    <li><a href="logout.php?logout">&nbsp; Logout</a></li>
                    <!-- only users with userPermission 2(shoppers) can see this on the menu bar -->
                <?php elseif ($_SESSION['userPermission'] == 2): ?>
                    <li><a href="logout.php?logout">&nbsp; Logout</a></li>
                    <!-- only users with userPermission 1 (awaitingApproval) can see this on the menu bar -->
                <?php elseif ($_SESSION['userPermission'] == 1): ?>
                    <li><a href="logout.php?logout">&nbsp; Logout</a></li>
                    <!-- else (general users) will see this menu bar -->
                <?php else: ?>
                    <li><a href="login.php">&nbsp; Login</a></li>

                <?php endif; ?>
                <!-- This implements the search bar into the navbar -->
                <li>
                    <form class="navbar-form" role="search" method="post">
                        <div class="input-group">
                            <input type="text" name="search" class="form-control" placeholder="Search">
                            <div class="input-group-btn">
                                <button class="btn btn-default" formaction="search.php" type="submit">Photographers<i
                                        class="glyphicon glyphicon-search"></i></button>
                                <button class="btn btn-default" formaction="index.php" type="submit">Images<i
                                        class="glyphicon glyphicon-search"></i></button>
                            </div>
                        </div>
                    </form>
                </li>

            </ul>
            <ul class="nav navbar-nav navbar-right">
            </ul>
        </div><!--/.nav-collapse -->
    </div>
</nav>

<!-- Bootstrap core JavaScript
================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
<script src = "bootstrap/dist/js/bootstrap.min.js" ></script>
<!-- IE10 viewport hack for Surface/desktop Windows 8 bug -->
<script src="bootstrap/assets/js/ie10-viewport-bug-workaround.js"></script>
</body>
</html>