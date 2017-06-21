<?php include 'header.php';
if (!empty($_GET['del_id'])) {
    $delete = mysqli_query($link, "DELETE FROM `tbl_users` WHERE `user_id`='" . $_GET['del_id'] . "'");
    if ($delete) {
        header("location:" . $_SERVER['HTTP_REFERER']);
    }
}
if (!empty($_GET['status_id'])) {
    $status_id = !empty($_GET['status_id']) ? $_GET['status_id'] : "";
    $status = !empty($_GET['sta']) ? $_GET['sta'] : "";
    $upd = array("is_active" => $status);
    mysqli_query($link,"UPDATE `tbl_users` SET `is_active`='$status' WHERE `user_id`='$status_id'");
    //update("tbl_users", $upd, "`user_id`='" . $status_id . "'");
    header("location:" . $_SERVER['HTTP_REFERER']);
}
?>

<section class="container">
   <!-- <article>
        <div class="col-md-offset-3 col-md-6">
            <div><?/*= !empty($message) ? $message : ""; */?></div>
            <form method="post" class="form-horizontal">
                <input type="hidden"  name="jobs_id" value="<?/*= !empty($jobs_id) ? $jobs_id : ""; */?>"/>
                <div class="form-group">
                    <label class="col-md-4">Job ID</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="job_id" value="<?/*= !empty($jobs_id) ? $job['job_id'] : ""; */?>" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4">Job Title</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="title" value="<?/*= !empty($jobs_id) ? $job['job_id'] : ""; */?>" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4">Date</label>
                    <div class="col-md-8">
                        <div class="input-group ">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i> </span>
                            <input type="text" class="form-control datepicker" name="date" value="<?/*= !empty($jobs_id) ? $job['date'] : ""; */?>"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4">Place</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="place" value="<?/*= !empty($jobs_id) ? $job['place'] : ""; */?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4">Address</label>
                    <div class="col-md-8">
                        <textarea class="form-control" name="address" style="resize: none" rows="4"><?/*= !empty($jobs_id) ? $job['address'] : ""; */?></textarea>
                    </div>
                </div>
                <div class="col-md-offset-4 col-md-8">
                    <button type="submit" name="submit" class="btn btn-info">Submit</button>
                </div>
            </form>
        </div>
    </article>-->
    <article class="table-list">
        <table class="table table-bordered">
            <tr>
                <th>S.No</th>
                <th>Name</th>
                <th>Email</th>
                <th>Department</th>
                <th>Level</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            <?php
            $lists = mysqli_query($link, "SELECT * FROM `tbl_users` where `role` !='ADMIN' ORDER BY `user_id` DESC");
            $number = mysqli_num_rows($lists);
            if($number==0){
                echo "<tr><td colspan='7'> No users are added </td></tr>";
            }else{
                for($i=1;$i<=$number;$i++){
                    $list = mysqli_fetch_assoc($lists);
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $list['first_name']." ".$list['last_name'] ?></td>
                        <td><?php echo $list['email'] ?></td>
                        <td><?php echo $list['department'] ?></td>
                        <td><?php echo $list['level'] ?></td>
                        <td> <a href="users.php?status_id=<?php echo $list['user_id'] ?>&sta=<?php echo !empty($list['is_active']) ? "0" : "1"; ?>"><?php echo !empty($list['is_active']) ? "<div class=\"label label-success\"> Active</div>" : "<div class=\"label label-danger\">In Active</div>"; ?></a></td>
                        <td>
                            <a href="users.php?del_id=<?php echo $list['user_id']; ?>" class="delete btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
                <?php  }
            }      ?>
        </table>
    </article>
</section>
</body>
</html>

