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
                                    if ($_SESSION['ROLE'] !== 'ADMIN') { ?>
                                    ?>
                                    <button type="submit" name="submit">Apply</button>
                                <?php } } ?>
                            </td>

                        </form>
                    </tr>
                <?php }
            } ?>
        </table>
    </article>
</section>
