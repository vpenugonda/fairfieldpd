<?php
$title = "Job Lists";
include_once 'header.php';
if (isset($_POST['submit'])) {
    $job_id = $_POST['jobs_id'];
    $user_id = $_POST['user_id'];
    //$date = date('Y-m-d H:i:s');
    $insert = mysqli_query($link, "INSERT INTO `tbl_applied_jobs` (`job_id`,`user_id`,`applied_time`) VALUES ('$job_id','$user_id',NOW())");
    if ($insert == true) {
        $message = "<div class='alert alert-success'> Job Posted Successfully ..!</div>";
        header("refresh:1;url=" . $_SERVER['PHP_SELF']);
    } else {
        $message = "<div class='alert alert-danger'>Fail to apply job " . $insert . "</div>";
    }
}
?>
<section class="container">
    <div><?php echo !empty($message) ? $message : ""; ?></div>
    <article class="table-list">
        <table class="table table-bordered">
            <tr>
                <!--<th>S.No</th>-->
                <!--<th>ID No</th>-->                <th>JOB ID</th>
                <th>Title</th>
                <th>Date</th>
                <th>place</th>
                <th>Address</th>				<th>Application Status </th>
                <!--<th>Actions</th>-->

            </tr>
            <?php
            $lists = mysqli_query($link, "SELECT * FROM `tbl_jobs` ORDER BY `jobs_id` DESC");
            $number = mysqli_num_rows($lists);
            if ($number == 0) {
                echo "<tr><td colspan='7'>No Job  are Posted yet</td>";
            } else {
                for ($i = 1; $i <= $number; $i++) {
                    $list = mysqli_fetch_assoc($lists);
                    $jobs = mysqli_query($link, "SELECT `status` FROM `tbl_applied_jobs` WHERE `job_id`='" . $list['jobs_id'] . "'");
                    $job = mysqli_fetch_row($jobs);
                    ?>
                    <tr>
                        <form method="post">
                            <!--<td><?php echo $i ?></td>-->
                            <td><?php echo $list['job_id'] ?>
                                <input type="hidden" name="jobs_id" value="<?php echo $list['jobs_id'] ?>"/><input
                                    type="hidden" name="user_id" value="<?php echo $_SESSION['USER_ID'] ?>"/>
                            </td>
                            <td><?php echo $list['title'] ?></td>
                            <td><?php echo $list['date'] ?></td>
                            <td><?php echo $list['place'] ?></td>
                            <td><?php echo $list['address'] ?></td>
                            <td>
                                <?php
                                if ($job[0] == '1') {
                                    echo "Accepted";
                                } elseif ($job[0] == '0') {
                                    echo "Pending";

                                } elseif ($job[0] == '-1') {
                                    echo "Rejected";
                                } else {
                                    ?>
                                    <button type="submit" name="submit">Apply</button>
                                <?php } ?>
                            </td>

                        </form>
                    </tr>
                <?php }
            } ?>
        </table>
    </article>
    <div class="text-right">
        <?php if ($_SESSION['ROLE'] == "ADMIN") { ?>
            <form method="get" id="frm" class="form-inline">
                <div class="form-group">
                    <select name="user_id" onchange="$('#frm').submit();" class="form-control">
                        <option value="">Select a User</option>
                        <?php
                            $users = mysqli_query($link, "SELECT `user_id`,`first_name` from `tbl_users` WHERE `role`='USER' ORDER BY `user_id` DESC");
                            while ($user = mysqli_fetch_assoc($users)) { ?>
                                <option value="<?php echo $user['user_id']; ?>" <?php echo (!empty($_GET['user_id']) && ($_GET['user_id'] == $user['user_id'])) ? "selected='selected'" : ""; ?>><?php echo $user['first_name']; ?></option>
                            <?php }
                        ?>
                    </select>
                </div>
            </form>
        <?php } else { ?>
            <a href="availability.php" class="btn btn-primary"><i class="fa fa-plus"></i> Add</a>
        <?php } ?>
    </div>
    <h1 class="clearfix"></h1>
    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
            <tr>
                <th>#</th>
                <?php if ($_SESSION['ROLE'] == "ADMIN") { ?>
                    <th>Added BY</th>
                <?php } ?>
                <th>From</th>
                <th>To</th>
                <th>Availability</th>
            </tr>
            </thead>
            <tbody>
            <?php
                $structure = "SELECT a.*,u.first_name from `tbl_availabilities`a LEFT JOIN `tbl_users`u ON a.`user_id`=u.`user_id`";
                if(!empty($_GET['user_id'])) {
                    $structure .= " where a.`user_id` = '".$_GET['user_id']."'";
                }
                $structure .= " ORDER BY a.id DESC";
                $query = mysqli_query($link, $structure);
                if (mysqli_num_rows($query) > 0) {
                    for ($i = 1; $i <= mysqli_num_rows($query); $i++) {
                        $data = mysqli_fetch_assoc($query);
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <?php if ($_SESSION['ROLE'] == "ADMIN") { ?>
                                <td><?php echo $data['first_name']; ?></td>
                            <?php } ?>
                            <td><?php echo $data['from_date']; ?></td>
                            <td><?php echo $data['to_date']; ?></td>
                            <td>
                                <a href="availability.php?avail_id=<?php echo $data['id'] ?>" class="btn btn-primary">Check</a>
                            </td>
                        </tr>
                    <?php }
                } else { ?>
                    <tr>
                        <td colspan="<?php echo ($_SESSION['ROLE'] == "ADMIN") ? "5" : "4" ?>" class="text-center">No Records Found..!</td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</section>