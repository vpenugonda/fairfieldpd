<?php include 'header.php';
$jobs_id = !empty($_GET['jobs_id']) ? $_GET['jobs_id'] : "";
if (!empty($_GET['del_id'])) {
    $delete = mysqli_query($link, "DELETE FROM `tbl_jobs` WHERE `jobs_id`='" . $_GET['del_id'] . "'");
    if ($delete) {
        header("location:" . $_SERVER['HTTP_REFERER']);
    }
}
$jobs = mysqli_query($link,"SELECT * FROM `tbl_jobs` WHERE `jobs_id`='".$jobs_id."'");
$job = mysqli_fetch_assoc($jobs);
if(isset($_POST['submit'])){
    $job_id = $_POST['job_id'];
    $title = $_POST['title'];
    $date = $_POST['date'];
    $place = $_POST['place'];
    $address = $_POST['address'];
    if(!empty($jobs_id)){
        $res = mysqli_query($link,"UPDATE `tbl_jobs` SET `job_id`='$job_id',`title`='$title',`date`='$date',`place`='$place',`address`='$address' WHERE `jobs_id`='$jobs_id'");
        if($res==true){
            $message =  "<div class='alert alert-success'> Job updated Successfully ..!</div>";
            header("refresh:1;url=jobs.php");
        }else{
            $message = "<div class='alert alert-danger'>Job ID already Exists or ".$res."</div>";
        }
    }else{
        $insert = mysqli_query($link,"INSERT INTO `tbl_jobs` (`job_id`,`title`,`date`,`place`,`address`) VALUES ('$job_id','$title','$date','$place','$address')");
        if($insert==true){
            $message =  "<div class='alert alert-success'> Job Posted Successfully ..!</div>";
            header("refresh:1;url=" . $_SERVER['PHP_SELF']);
        }else{
            $message = "<div class='alert alert-danger'>Job ID already Exists or ".$insert."</div>";
        }
    }

}
?>
<section class="container">
    <article>
        <div class="col-md-offset-3 col-md-6">
            <div><?php echo !empty($message) ? $message : ""; ?></div>
            <form method="post" class="form-horizontal">
                <input type="hidden"  name="jobs_id" value="<?php echo !empty($jobs_id) ? $jobs_id : ""; ?>"/>
                <div class="form-group">
                    <label class="col-md-4">Job ID</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="job_id" value="<?php echo !empty($jobs_id) ? $job['job_id'] : ""; ?>" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4">Job Title</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="title" value="<?php echo !empty($jobs_id) ? $job['job_id'] : ""; ?>" required/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4">Date</label>
                    <div class="col-md-8">
                        <div class="input-group ">
                            <span class="input-group-addon"><i class="fa fa-calendar"></i> </span>
                            <input type="text" class="form-control datepicker" name="date" value="<?php echo !empty($jobs_id) ? $job['date'] : ""; ?>"/>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4">Place</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="place" value="<?php echo !empty($jobs_id) ? $job['place'] : ""; ?>"/>
                    </div>
                </div>
                <div class="form-group">
                    <label class="col-md-4">Address</label>
                    <div class="col-md-8">
                        <textarea class="form-control" name="address" style="resize: none" rows="4"><?php echo !empty($jobs_id) ? $job['address'] : ""; ?></textarea>
                    </div>
                </div>
                <div class="col-md-offset-4 col-md-8">
                    <button type="submit" name="submit" class="btn btn-info">Submit</button> 					<a href="jobs.php"><button type="reset" class="btn btn-danger">Reset</button></a>
                </div>				 
            </form>
        </div>
    </article><div class="pull-right">	<a href="jobs-list.php"><button class="btn btn-info">View Jobs</button></a>	</div>
    <article class="table-list">
        <table class="table table-bordered">
            <tr>
                <th>S.No</th>
                <th>ID No</th>
                <th>Title</th>
                <th>Date</th>
                <th>place</th>
                <th>Address</th>
                <!--<th>Applied Members</th>-->
                <th>Actions</th>
            </tr>
            <?php
            $lists = mysqli_query($link,"SELECT * FROM `tbl_jobs` ORDER BY `jobs_id` ASC");
            $number = mysqli_num_rows($lists);
            if($number==0){
                echo "<tr><td colspan='7'>No Job lists are Posted yet</td>";
            }else{
                for($i=1;$i<=$number;$i++){
                    $list = mysqli_fetch_assoc($lists);
                    ?>
                    <tr>
                        <td><?php echo $i ?></td>
                        <td><?php echo $list['job_id'] ?></td>
                        <td><?php echo $list['title'] ?></td>
                        <td><?php echo $list['date'] ?></td>
                        <td><?php echo $list['place'] ?></td>
                        <td><?php echo $list['address'] ?></td>
                        <!--<td><a href="member-list.php"><label class="label label-info">Member List</label> </a></td>-->
                        <td>
                            <a href="jobs.php?jobs_id=<?php echo $list['jobs_id'] ?>" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> </a>
                            <a href="jobs.php?del_id=<?php echo $list['jobs_id']; ?>" class="delete btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>
                        </td>
                    </tr>
               <?php  }
                  }      ?>
        </table>
    </article>
</section>
</body></html>

