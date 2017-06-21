<?php
    include "header.php";
?>
<div class="container">
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
</div></body></html>
