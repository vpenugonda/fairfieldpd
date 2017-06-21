<?php
    ob_start();
    session_start();
    require 'config.php';
    if (isset($_POST['signin'])) {
        $email = $_POST['email'];
        $pwd = $_POST['password'];
        $search = mysqli_query($link, "SELECT * FROM `Users` WHERE (`email`='$email' AND `password`='$pwd')");
        $count = mysqli_num_rows($search);
        if ($count == 1) {
            $user = mysqli_fetch_assoc($search);
            if ($user['is_active'] == 1) {
                $_SESSION['ROLE'] = $user['role'];
                $_SESSION['USER_ID'] = $user['user_id'];
                header('Location:index.php');
            } else {
                $message = "<div class='label label-danger'>Please got ADMIN approval before login</div>";
            }
        } else {
            $message = "<div class='label label-danger'>Wrong Details, Please enter correct Details</div>";
        }
    }
?>
<!DOCTYPE html>
<html>
<head>
    <title>::. Forgot Password .::</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/styles.css"/>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <script type="text/javascript" src="js/myscript.js"></script>
</head>
<body>
<section class="">
    <article class="top-login">
        <div class="container">
            <div class="col-md-6">
                <a href="index.php"><h3>Fairfield Police Department</h3></a>
            </div>
            <div class="col-md-6">
                <form class="form-horizontal" method="post">
                    <div class="col-md-5">
                        <div class="form-group">
                            <input type="email" class="form-control input-sm" name="email" placeholder="Email ID">
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group pass">
                            <input type="password" class="form-control input-sm" name="password" placeholder="********">
                        </div>
                    </div>
                    <div class="col-md-3 text-right">
                        <div class="form-group">
                            <button type="submit" class="btn btn-default btn-sm" name="signin">Sign In</button>
                            <a href="forgot-password.php" class="btn btn-default btn-sm"><i class="fa fa-question-circle"></i>
                            </a>
                        </div>
                    </div>
                </form>
                <?php echo !empty($message) ? $message : ""; ?>
            </div>
        </div>
    </article>
    <article class="signup-form">
        <div class="container">
            <!--<div class="col-md-offset-3 col-md-6">
                <?php echo !empty($message1) ? $message1 : ""; ?>
                <form class="form-horizontal" method="post">
                    <div class="form-group">
                        <label class="col-md-5">Email ID</label>
                        <div class="col-md-7">
                            <input type="email" class="form-control" placeholder="Email ID" name="email" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-5">Security Question</label>
                        <div class="col-md-7">
                            <select class="form-control" name="question_id" required>
                                <option value="">Select a question</option>
                                <?php
                $questions = mysqli_query($link, "SELECT `question_id`,`question` FROM `tbl_questions` ORDER BY `question_id` DESC");
                while ($question = mysqli_fetch_row($questions)) { ?>
                                    <option value="<?php echo $question[0] ?>"><?php echo $question[1] ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="col-md-5">Answer</label>
                        <div class="col-md-7">
                            <input class="form-control" name="answer" placeholder="Answer" required>
                        </div>
                    </div>
                    <div class="col-md-offset-5 col-md-7">
                        <button type="submit" class="btn btn-default" name="password">Request Password</button>
                        <button type="reset" class="btn btn-default">Reset</button>
                    </div>
                </form>
            </div>-->
            <div class="col-md-offset-3 col-md-4">
                <form class="form-horizontal front-form" id="form1" method="post">
                    <div class="forgot-display"></div>
                    <div class="col-md-12">
                        <div class="form-group"><label>Email ID</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-envelope-o"></i> </span>
                                <input type="email" class="form-control name" placeholder="Email ID" name="email" value="" required>
                            </div>
                        </div>
                        <div class="form-group"><label>Security Question</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-question-circle"></i> </span>
                                <select class="form-control name" name="question_id" required>
                                    <option value="">Select a question</option> <?php $questions = mysqli_query($link, "SELECT `question_id`,`question` FROM `tbl_questions` ORDER BY `question_id` DESC");
                                        while ($question = mysqli_fetch_row($questions)) { ?>
                                            <option value="<?php echo $question[0] ?>"><?php echo $question[1] ?></option>                                            <?php } ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group"><label>Answer</label>
                            <div class="input-group">
                                <span class="input-group-addon"><i class="fa fa-reply"></i> </span>
                                <input class="form-control name" name="answer" required>
                            </div>
                        </div>
                        <button class="btn btn-info " type="submit">SEND</button>
                        <button type="button" class="btn btn-danger login_cancel ">CANCEL</button>
                    </div>
                </form>
            </div>
        </div>
    </article>
</section>
</body>
</html>