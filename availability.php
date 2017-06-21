<?php
    include 'header.php';
    if (!empty($_GET['avail_id'])) {
        $query = mysqli_query($link, "SELECT * from `tbl_availabilities` WHERE `id`='" . $_GET['avail_id'] . "'");
        $data = mysqli_fetch_assoc($query);
    }
    if (!empty($_POST)) {
        $pdata['from_date'] = dateForm2DB($_POST['from_date']);
        $pdata['to_date'] = dateForm2DB($_POST['to_date']);
        $pdata['user_id'] = $_SESSION['USER_ID'];
        $pdata['availability'] = stripcslashes(json_encode(array_combine($_POST['dates'], $_POST['avail'])));
        if (!empty($data['id'])) {
            $result = mysqli_query($link, "UPDATE `tbl_availabilities` SET `availability` = '" . $pdata['availability'] . "' where `id`='" . $data['id'] . "'");
        } else {
            $result = mysqli_query($link, "INSERT INTO `tbl_availabilities`(`user_id`, `from_date`, `to_date`, `availability`) VALUES ('" . $pdata['user_id'] . "','" . $pdata['from_date'] . "','" . $pdata['to_date'] . "','" . $pdata['availability'] . "')");
        }
        if ($result) {
            header("location:availabilities.php");
        } else {
            $message = mysqli_error($link);
        }
    }
?>
<div class="container">
    <?php echo !empty($message) ? $message : ""; ?>
    <form method="post" class="form-horizontal">
        <?php if (empty($_GET['avail_id'])) { ?>
            <div class="form-group">
                <label class="control-label col-sm-3">From date :</label>
                <div class="col-sm-4">
                    <input class="form-control picker" id="from" name="from_date"/>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-3">To Date :</label>
                <div class="col-sm-4">
                    <input class="form-control picker" id="to" name="to_date" />
                </div>
            </div>
        <?php } ?>
        <div class="form-group">
            <div class="col-sm-5 col-sm-offset-3" id="result">
                <?php
                    if (!empty($data['availability']) && !empty($_GET['avail_id'])) {
                        $dateArray = json_decode($data['availability'], true);
                        $dates = array_keys($dateArray);
                        $avail = array_values($dateArray);
                        foreach ($dates as $key => $date) {
                            ?>
                            <dl class="form-group">
                                <dd class="col-sm-2 control-label text-left"><?php echo $date; ?></dd>
                                <input type="hidden" name="dates[]" value="<?php echo $date; ?>">
                                <dd class="col-sm-3">
                                    <select class="form-control" name="avail[]">
                                        <option value="YES" <?php echo ($avail[$key] == "YES") ? "selected='selected'" : ""; ?>>YES</option>
                                        <option value="NO" <?php echo ($avail[$key] == "NO") ? "selected='selected'" : ""; ?>>NO</option>
                                    </select>
                                </dd>
                                <?php if ($_SESSION['ROLE'] !== 'ADMIN') { ?>
                                    <div class="col-sm-3">
                                        <button type="button" class="btn btn-danger">
                                            <i class="glyphicon glyphicon-trash"></i></button>
                                    </div>
                                <?php } ?>
                            </dl>
                        <?php }
                    }
                ?>
            </div>
        </div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-4">
                <?php if ($_SESSION['ROLE'] !== 'ADMIN') { ?>
                <button type="submit" class="btn btn-primary">Save</button>
                <?php } ?>
            </div>
        </div>
    </form>
</div>
<script>
    $(document).ready(function () {
        $(document).on("click", ".btn-danger", function () {
            if ($('dl.form-group').length > 1) {
                $(this).parent().parent().remove();
            }
        });
        function getDates(start, end) {
            var datesArray = [];
            var startDate = new Date(start);
            while (startDate <= end) {
                datesArray.push(new Date(startDate));
                startDate.setDate(startDate.getDate() + 1);
            }
            return datesArray;
        }

        function convertDate(inputFormat) {
            function pad(s) {
                return (s < 10) ? '0' + s : s;
            }

            var d = new Date(inputFormat);
            return [pad(d.getDate()), pad(d.getMonth() + 1), d.getFullYear()].join('/');
        }

        /*$("#from").change(function(){
            var from = $("#from").datepicker("getDate");
            var to = from.getDate() + 7d;
            alert(to);
        })*/
        $('#to').on("change", function () {
            var from = $("#from").datepicker("getDate"),
                to = $("#to").datepicker("getDate");

            var dates = getDates(from, to);
            var dLen, text, i;
            dLen = dates.length;
            text = "<div class='form-horizontal'>"
            for (i = 0; i < dLen; i++) {
                text += "<dl class='form-group'>";
                text += "<dd class='col-sm-2 control-label text-left'>" + convertDate(dates[i]) + "</dd>";
                text += "<input type='hidden' name='dates[]' value='" + convertDate(dates[i]) + "'/>";
                text += "<dd class='col-sm-3'><select class='form-control' name='avail[]'><option value='YES'>YES</option><option value='NO'>NO</option></select></dd>";
                text += "</dl>";
            }
            text += "</div>";
            $("#result").html(text)
        });
    });
</script>