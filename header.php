<?php
    ob_start();
    session_start();
    if (empty($_SESSION['USER_ID'])) {
        header('Location:./index.php');
        return false;
    }
    include 'config.php';
    function current_page()
    {
        return basename($_SERVER['PHP_SELF']);
    }

    $users = mysqli_query($link, "SELECT * FROM `tbl_users` WHERE `user_id`='" . $_SESSION['USER_ID'] . "'");
    $user = mysqli_fetch_assoc($users);
?>
<!DOCTYPE html>
<html>
<head>
    <title><?php echo !empty($title) ? $title : "Police" ?></title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/bootstrap-datepicker3.min.css"/>
    <link rel="stylesheet" href="css/styles.css"/>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/bootstrap-datepicker.min.js"></script>
    <script type="text/javascript" src="js/myscript.js"></script>
</head>
<body>
<nav class="navbar navbar-default">
    <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span> <span class="icon-bar"></span>
                <span class="icon-bar"></span> <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand padding-top" href="home.php"><img src="images/policelogo.png" height="40"/> </a>
        </div>
        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
            <ul class="nav navbar-nav">
                <li><a href="#">Welcome to <?php echo $user['first_name'] . ' ' . $user['last_name'] ?></a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <li><a href="profile.php">Account Info</a></li>
                <?php if ($_SESSION['ROLE'] == 'ADMIN') { ?>
                    <li><a href="security.php">Security Questions</a></li>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Jobs
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="jobs.php">Create Job</a></li>
                            <li><a href="jobs-list.php">View Job</a></li>
                            <li><a href="applied-jobs.php">Applied Jobs</a></li>
                        </ul>
                    </li>
                    <li><a href="availabilities.php">User Availability</a></li>
                    <li><a href="users.php">Users</a></li>
                <?php } else { ?>
                    <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">Jobs
                            <span class="caret"></span></a>
                        <ul class="dropdown-menu">
                            <li><a href="jobs-list.php">View Jobs</a></li>
                            <li><a href="applied-jobs.php">Applied Jobs</a></li>
                        </ul>
                    </li>
                    <li><a href="availabilities.php">Availability</a></li>
                <?php } ?>
                <li><a href="logout.php">Logout</a></li>
            </ul>
        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->
</nav>
<?php
    $cur = current_page();
    $explode = explode(".", $cur);
?>
<div class="container">
    <ol class="breadcrumb" style="text-transform:uppercase">
        <li><a href="home.php">Home</a></li>
        <li class="active"><?php echo $explode[0]; ?></li>
    </ol>
</div>