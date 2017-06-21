<?php include 'header.php';
$question_id = !empty($_GET['question_id']) ? $_GET['question_id'] : "";
if (!empty($_GET['del_id'])) {
    $delete = mysqli_query($link, "DELETE FROM `tbl_questions` WHERE `question_id`='" . $_GET['del_id'] . "'");
    if ($delete) {
        header("location:" . $_SERVER['HTTP_REFERER']);
    }
}
$questions = mysqli_query($link,"SELECT * FROM `tbl_questions` WHERE `question_id`='".$question_id."'");
$question = mysqli_fetch_assoc($questions);
if(isset($_POST['submit'])){
    $que = $_POST['question'];
    $ans = $_POST['answer'];
    if(!empty($question_id)){
        $res = mysqli_query($link,"UPDATE `tbl_questions` SET `question`='$que',`answer`='$ans' WHERE `question_id`='$question_id'");
        if($res==true){
            $message =  "<div class='alert alert-success'> Question updated Successfully ..!</div>";
            header("refresh:1;url=security.php");
        }else{
            $message = "<div class='alert alert-danger'>Question already Exists or ".$res."</div>";
        }
    }else{
        $insert = mysqli_query($link,"INSERT INTO `tbl_questions` (`question`,`answer`) VALUES ('$que','$ans')");
        if($insert==true){
            $message =  "<div class='alert alert-success'> Question Posted Successfully ..!</div>";
            header("refresh:1;url=" . $_SERVER['PHP_SELF']);
        }else{
            $message = "<div class='alert alert-danger'>Question already Exists or ".$insert."</div>";
        }
    }

}
?>
<section class="container">
    <article>
        <div class="col-md-offset-3 col-md-6">
            <div><?php echo !empty($message) ? $message : ""; ?></div>
            <form method="post" class="form-horizontal">
                <input type="hidden"  name="jobs_id" value="<?php echo !empty($question_id) ? $question_id : ""; ?>"/>
                <div class="form-group">
                    <label class="col-md-4">Question</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="question" value="<?php echo !empty($question_id) ? $question['question'] : ""; ?>" required/>
                    </div>
                </div>
                <!--<div class="form-group">
                    <label class="col-md-4">Job Title</label>
                    <div class="col-md-8">
                        <input type="text" class="form-control" name="answer" value="<?/*= !empty($question_id) ? $question['answer'] : ""; */?>" required/>
                    </div>
                </div>-->
                <div class="col-md-offset-4 col-md-8">
                    <button type="submit" name="submit" class="btn btn-info">Submit</button>
                </div>
            </form>
        </div>
    </article>
    <article class="table-list">
        <div class="col-md-offset-3 col-md-6">
            <table class="table table-bordered">
                <tr>
                    <th>S.No</th>
                    <th>Question</th>
                    <!-- <th>Answer</th>-->
                    <th>Actions</th>
                </tr>
                <?php
                $lists = mysqli_query($link,"SELECT * FROM `tbl_questions` ORDER BY `question_id` DESC");
                $number = mysqli_num_rows($lists);
                if($number==0){
                    echo "<tr><td colspan='4'>No Questions are created yet</td>";
                }else{
                    for($i=1;$i<=$number;$i++){
                        $list = mysqli_fetch_assoc($lists);
                        ?>
                        <tr>
                            <td><?php echo $i ?></td>
                            <td><?php echo $list['question'] ?></td>
                            <!--<td><?/*= $list['answer'] */?></td>-->
                            <td>
                                <a href="security.php?question_id=<?php echo $list['question_id'] ?>" class="btn btn-sm btn-info"><i class="fa fa-edit"></i> </a>
                                <a href="security.php?del_id=<?php echo $list['question_id']; ?>" class="delete btn btn-sm btn-danger"><i class="fa fa-trash-o"></i></a>
                            </td>
                        </tr>
                    <?php  }
                }      ?>
            </table>
        </div>
    </article>
</section>
</body></html>

