<?php
ob_start();
session_start();
require 'config.php';
if (isset($_POST['signin'])) {
    $email = $_POST['email'];
    $pwd = $_POST['password'];
    $search = mysqli_query($link, "SELECT * FROM `tbl_users` WHERE (`email`='$email' AND `password`='$pwd')");
    $count = mysqli_num_rows($search);
    if ($count == 1) {
        $user = mysqli_fetch_assoc($search);
        if($user['is_active']==1){
            $_SESSION['ROLE'] = $user['role'];
            $_SESSION['USER_ID'] = $user['user_id'];
            header('Location:home.php');
        }else{
            $message = "<div class='label label-danger'>Please got ADMIN approval before login</div>";
        }

    } else {
        $message = "<div class='label label-danger'>Wrong Details, Please enter correct Details</div>";
    }
}
if (isset($_POST['signup'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $department = $_POST['department'];
    $level = $_POST['level'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $repassword = $_POST['re_password'];
    $q_id = $_POST['question_id'];
    $answer = $_POST['answer'];

   /* $search = mysqli_query($link, "SELECT `answer` FROM `tbl_questions` WHERE `question_id`='$q_id' ");
    $qq = mysqli_fetch_row($search);
    if($qq[0]==$answer){*/
        if($password==$repassword){
            $res = mysqli_query($link,"INSERT INTO `tbl_users` (`first_name`,`last_name`,`email`,`password`,`department`,`level`,`role`,`question_id`,`answer`,`date_of_registration`) VALUES ('$first_name','$last_name','$email','$password','$department','$level','USER','$q_id','$answer',NOW())");
            if($res==true){
                $message1 =  "<div class='alert alert-success'> Registered Successfully . You got access to login only after ADMIN approves you ..!</div>";

            }else{
                $message1 = "<div class='alert alert-danger'>Failed to register candidate details..! .".$res."</div>";
            }
        }else{
            $message1 = "<div class='alert alert-danger'>Passwords are mismatched</div>";
        }
    /*}else{
         $message1 = "<div class='alert alert-danger'>Wrong Answer for your question, Please enter correct Details</div>";
     }*/
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>::. Sign Up Form .::</title>
    <link rel="stylesheet" href="css/bootstrap.min.css"/>
    <link rel="stylesheet" href="css/font-awesome.min.css"/>
    <link rel="stylesheet" href="css/styles.css"/>
    <script type="text/javascript" src="js/jquery.min.js"></script>
    <script type="text/javascript" src="js/bootstrap.min.js"></script>
    <!--<script type="text/javascript" src="js/myscript.js"></script>-->
    <script>
        $(document).ready(function () {
            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>
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
                            <a href="forgot-password.php" title="Forgot Password" data-toggle="tooltip" data-placement="bottom" class="btn btn-default btn-sm"><i class="fa fa-question-circle"></i>
                            </a>
                        </div>
                    </div>
                </form>
                <?php echo !empty($message) ? $message : ""; ?>
            </div>
        </div>
    </article>
    <article class="">
        <div class="container">
            <div class="col-md-offset-3 col-md-6 signup-form1">

                <div class="left-image col-md-4">
                    <img src="images/policelogo.png" alt="Police Logo"/>
                </div>
                <form class="form-horizontal col-md-8" method="post">
                    <?php echo !empty($message1) ? $message1 : ""; ?>
                    <div class="row">
                        <div class="col-md-12">
                            <input class="form-control" name="first_name" placeholder="First Name" value="" required>
                       
                            <input class="form-control" name="last_name" placeholder="Last Name" value="" required>
                        
                            <input type="email" class="form-control" placeholder="Email ID" name="email" value="" required>
                        
                            <input class="form-control" name="department" placeholder="Department ID" value="" required>
                        
                            <select class="form-control" name="level" required>
                                <option value="">Select Level</option>
                                <option value="level1">Level 1</option>
                                <option value="level2">Level 2</option>
                                <option value="level3">Level 3</option>
                            </select>
                       
                            <input class="form-control" type="password" placeholder="Password" name="password" required>
                       
                            <input class="form-control" type="password" placeholder="Retype Password" name="re_password" required>
                        
                            <select class="form-control" name="question_id" required>
                                <option value="">Select a question</option>
                                <?php
                                $questions = mysqli_query($link, "SELECT `question_id`,`question` FROM `tbl_questions` ORDER BY `question_id` DESC");
                                while ($question = mysqli_fetch_row($questions)) { ?>
                                    <option value="<?php echo $question[0] ?>"><?php echo $question[1] ?></option>
                                <?php } ?>
                            </select>
                            <input class="form-control" name="answer" placeholder="Answer" required>
                        <button type="submit" class="btn btn-success" name="signup">Sign Up</button>
                    </div>
            </div>
            </form>
        </div>
        </div>
    </article>
</section>
</body>
</html>