<?php
include 'header.php';
if (!empty($_GET['del_id'])) {
    $delete = mysqli_query($link, "DELETE FROM `tbl_applied_jobs` WHERE `apj_id`='" . $_GET['del_id'] . "'");
    if ($delete) {
        header("location:" . $_SERVER['HTTP_REFERER']);
    }
}
if (isset($_POST['approve'])) {
    $apj_id = $_POST['apj_id'];
    $res = mysqli_query($link, "UPDATE `tbl_applied_jobs` SET `status`='1' WHERE `apj_id`='$apj_id'");
    if ($res == true) {
        $message = "<div class='alert alert-success'>  Success ..!</div>";
        header("refresh:1;url=applied-jobs.php");
    } else {
        $message = "<div class='alert alert-danger'>Fail " . $res . "</div>";
    }
}
if (isset($_POST['reject'])) {
    $apj_id = $_POST['apj_id'];
    $res = mysqli_query($link, "UPDATE `tbl_applied_jobs` SET `status`='-1' WHERE `apj_id`='$apj_id'");
    if ($res == true) {
        $message = "<div class='alert alert-success'>  Success ..!</div>";
        header("refresh:1;url=applied-jobs.php");
    } else {
        $message = "<div class='alert alert-danger'>Fail " . $res . "</div>";
    }
}

?>
<section class="container">
    <div><?php echo !empty($message) ? $message : ""; ?></div>
    <article class="table-list">
        <table class="table table-bordered">
            <tr>
                <th>S.No</th>
                <th>Job ID</th>
               <th>User Name</th>
                <th>Job Title</th>
                <th>Job Date</th>
                <th>Applied Date</th>
                <?php if ($_SESSION['ROLE'] == "ADMIN") { ?>
                    <th>Actions</th>
                <?php } else { ?>
                    <th>Status</th>
                <?php } ?>

            </tr>
            <?php if ($_SESSION['ROLE'] == "ADMIN") {
                $lists = mysqli_query($link, "SELECT * FROM `tbl_applied_jobs` ORDER BY `apj_id` DESC");
            } else {
                $lists = mysqli_query($link, "SELECT * FROM `tbl_applied_jobs` WHERE `user_id`='" . $_SESSION['USER_ID'] . "' ORDER BY `apj_id` DESC");
            }

            $number = mysqli_num_rows($lists);
            if ($number == 0){
                echo "<tr><td colspan='5'>No Person is applied for the Job </td></tr>";
            }else{
            for ($i = 1;
            $i <= $number;
            $i++){
            $list = mysqli_fetch_assoc($lists);
            $jobs = mysqli_query($link, "SELECT * FROM `tbl_jobs` WHERE `jobs_id`='" . $list['job_id'] . "'");
            $job = mysqli_fetch_assoc($jobs);
            $members = mysqli_query($link, "SELECT * FROM `tbl_users` WHERE `user_id`='" . $list['user_id'] . "'");
            $member = mysqli_fetch_assoc($members);
            ?>
            <tr>
                <form method="post">
                    <td><?php echo $i ?>
                        <input type="hidden" name="apj_id" value="<?php echo $list['apj_id'] ?>"/>
                    </td>
                    <td><?php echo $job['job_id'] ?></td>
					<td><?php echo $member['first_name'] . " " . $member['last_name'] ?></td>
                    <td><?php echo $job['title'] ?></td>
                    <td><?php echo $job['date'] ?></td>
                   
                        <td><?php echo $list['applied_time'] ?></td>
                    <?php if ($_SESSION['ROLE'] == "ADMIN") { ?>
                        <td>
                            <?php
                        if ($list['status'] == '1') {
                            echo "<div class='label label-success'>Accepted</div>"; ?>
                                <button type="submit" class="btn btn-danger btn-sm" name="reject">Reject</button>
                            <?php } elseif ($list['status'] == '0') { ?>
                                <button type="submit" class="btn btn-success btn-sm" name="approve">Approve</button>
                                <button type="submit" class="btn btn-danger btn-sm" name="reject">Reject</button>
                           <?php } elseif ($list['status'] == '-1') {
                            echo "<div class='label label-danger'>Rejected</div>"; ?>
                                <button type="submit" class="btn btn-success btn-sm" name="approve">Approve</button>
                             <?php } ?>
                        </td>
                        <?php } else { ?>
                        <td><?php if ($list['status'] == '1') {
                        echo "<div class='label label-success'>Accepted</div>";
                    } elseif ($list['status'] == '-1') {
                        echo "<div class='label label-danger'>Rejected</div>";
                    } elseif ($list['status'] == '0') {
                        echo "<div class='label label-warning'>Pending</div>";
                    } ?></td>
                     <?php } ?>
                        </form>
                    </tr>
                <?php }
                    } ?>
        </table>
    </article>
</section>
