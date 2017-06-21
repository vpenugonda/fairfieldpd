<?php
include 'header.php';
if (isset($_POST['submit'])) {
    $fname = $_POST['first_name'];
    $lname = $_POST['last_name'];
    $old_password = $_POST['old_password'];
    $password = $_POST['password'];
    $repassword = $_POST['re_password'];
    if (!empty($old_password)){
        if ($old_password == $user['password']) {
            if ($password == $repassword) {
                $res = mysqli_query($link, "UPDATE `tbl_users` SET `first_name`='$fname',`last_name`='$lname',`password`='$password' WHERE `user_id`='" . $user['user_id'] . "'");
                if ($res == true) {
                    $message = "<div class='alert alert-success'> Profile updated Successfully ..!</div>";
                    header("refresh:1;url=profile.php");
                } else {
                    $message = "<div class='alert alert-danger'>Failed to update Profile " . $res . "</div>";
                }
            } else {
                $message = "<div class='alert alert-danger'>Passwords are Mismatched.</div>";
            }
        } else {
            $message = "<div class='alert alert-danger'>You old password is wrong. Please give correct password </div>";
        }
    }else{
        $res = mysqli_query($link, "UPDATE `tbl_users` SET `first_name`='$fname',`last_name`='$lname' WHERE `user_id`='" . $user['user_id'] . "'");
        if ($res == true) {
            $message = "<div class='alert alert-success'> Profile updated Successfully ..!</div>";
            header("refresh:1;url=profile.php");
        } else {
            $message = "<div class='alert alert-danger'>Failed to update Profile " . $res . "</div>";
        }
    }
}
?>
<section>
    <div class="col-md-offset-3 col-md-6">
        <div><?php echo !empty($message) ? $message : ""; ?></div>
        <form class="form-horizontal" method="post">
            <div class="col-md-12">
                <div class="text-right"><span class="edit btn btn-primary">Edit</span></div>
                <input type="hidden" name="user_id" value="<?php echo !empty($user['user_id']) ? $user['user_id'] : ""; ?>"/>
                <div class="form-group">
                    <label class="col-md-5">First Name</label>
                    <div class="col-md-7">
                        <input class="form-control" name="first_name" placeholder="First Name" value="<?php echo !empty($user['first_name']) ? $user['first_name'] : ""; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-5">Last Name</label>
                    <div class="col-md-7">
                        <input class="form-control" name="last_name" placeholder="Last Name" value="<?php echo !empty($user['last_name']) ? $user['last_name'] : ""; ?>" required>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-5">Email ID</label>
                    <div class="col-md-7">
                        <input type="email" class="form-control" placeholder="Email ID" name="email" value="<?php echo !empty($user['email']) ? $user['email'] : ""; ?>" required readonly>
                    </div>
                </div>
                <!-- <div class="form-group">
                    <label class="col-md-5">Department ID</label>
                    <div class="col-md-7">
                        <input class="form-control" name="department" value="<?php echo !empty($user['department']) ? $user['department'] : ""; ?>" required readonly>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-5">Level</label>
                    <div class="col-md-7">
                        <input class="form-control" name="level" value="<?php echo !empty($user['level']) ? $user['level'] : ""; ?>" required readonly>

                    </div>
                </div>-->
                <div class="form-group">
                    <label class="col-md-5">Old Password</label>
                    <div class="col-md-7">
                        <input class="form-control" type="password" placeholder="********" name="old_password">
                        <span class="text-warning">If you dont want to update your password leave empty</span>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-5">Password</label>
                    <div class="col-md-7">
                        <input class="form-control" type="password" placeholder="********" name="password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-5">Retype Password</label>
                    <div class="col-md-7">
                        <input class="form-control" type="password" placeholder="*********" name="re_password">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-5">Address 1</label>
                    <div class="col-md-7">
                        <input class="form-control" placeholder="Address 1" name="address1" value="<?php echo !empty($user['address1']) ? $user['address1'] : ""; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-5">Addredd 2</label>
                    <div class="col-md-7">
                        <input class="form-control"  placeholder="Address 2" name="address2" value="<?php echo !empty($user['address2']) ? $user['address2'] : ""; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-5">City</label>
                    <div class="col-md-7">
                        <input class="form-control" placeholder="City" name="city" value="<?php echo !empty($user['city']) ? $user['city'] : ""; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-5">State</label>
                    <div class="col-md-7">
                        <input class="form-control" placeholder="State" name="state" value="<?php echo !empty($user['state']) ? $user['state'] : ""; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-5">ZIP</label>
                    <div class="col-md-7">
                        <input class="form-control" placeholder="zip" name="zip" value="<?php echo !empty($user['zip']) ? $user['zip'] : ""; ?>">
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-5">Mobile No</label>
                    <div class="col-md-7">
                        <input class="form-control" placeholder="Mobile No" name="mobile" value="<?php echo !empty($user['mobile']) ? $user['mobile'] : ""; ?>">
                    </div>
                </div>
                <div class="col-md-offset-5 col-md-5">
                    <button type="submit" class="btn btn-success display" style="display: none">Submit</button>
                </div>
            </div>
        </form>
    </div>
</section>
<script>
$(document).ready(function(){
    $('.edit').click(function(){
        $('.display').css('display','block');
    })
})
</script>
</body></html>