<?php
require_once __DIR__ . '/../../../connection.php';

// ตรวจสอบสิทธิ์
if (!(isset($_SESSION['admin']))) {
    $_SESSION['status'] = "ไม่พบสิทธิ์การใช้งานในหน้านี้";
    $_SESSION['status_code'] = "ผิดพลาด";
    header('Location: login_form.php');
    exit();
}
//$currentURL = $_SERVER['REQUEST_URI'];
$currentURL = 'comment_edit_form.php';
// ตรวจสอบว่ามีค่า 'edit_id' ที่ถูกส่งมาใน URL หรือไม่
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
} elseif (isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
} else {
    echo "<script>alert('ไม่พบฟอร์มนี้ โปรดลองใหม่'); window.location='comment_show.php';</script>";
    exit;
}


if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
    $status = $_SESSION['status'];
    $status_code = $_SESSION['status_code'];

    // เคลียร์ค่า session
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);

    // แสดงหน้าต่างข้อความแจ้งเตือน
    echo "<script>alert('$status');</script>";
    echo "<script>window.location.href = '$currentURL?edit_id=$edit_id';</script>";
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <?php
    require_once('head.php');
    ?>
</head>

<!-- body start -->

<body class="loading" data-layout-color="light" data-layout-mode="default" data-layout-size="fluid" data-topbar-color="light" data-leftbar-position="fixed" data-leftbar-color="light" data-leftbar-size='default' data-sidebar-user='true'>

    <!-- Begin page -->
    <div id="wrapper">

        <!-- Topbar Start -->
        <?php
        require_once('nav.php');
        ?>
        <!-- end Topbar -->

        <!-- ========== Left Sidebar Start ========== -->
        <?php
        require_once('slidebar.php');
        ?>
        <!-- Left Sidebar End -->

        <!-- ============================================================== -->
        <!-- Start Page Content here -->
        <!-- ============================================================== -->

        <div class="content-page">
            <div class="content">


                <!-- Start Content-->
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <?php

                                $sql_script = "SELECT c.*, m.mmb_username, p.prd_name
                                FROM bk_prd_comment c
                                INNER JOIN bk_auth_member m ON c.mmb_id = m.mmb_id
                                INNER JOIN bk_prd_product p ON c.prd_id = p.prd_id
                                WHERE c.cmm_id = '$edit_id';
                                ";
                                $cmm_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());

                                $cmm_row_result = mysqli_fetch_assoc($cmm_result);
                                ?>
                                <div class="card-body">
                                    <h4 class="header-title">รายละเอียดการรีวิว</h4>
                                    <br>
                                    <form action="comment_update.php" method="POST">
                                        <div class="mb-3">
                                            <label for="pay_id" class="form-label">
                                                <h6 class="font-13 mt-3"> คะแนน </h6>
                                            </label>
                                            <input type="text" parsley-trigger="change" class="form-control" readonly value="<?php echo $cmm_row_result['cmm_rating'] ?>">
                                            <label for="pay_id" class="form-label">
                                                <h6 class="font-13 mt-3">ความคิดเห็น </h6>
                                            </label>
                                            <textarea class="form-control" readonly><?php echo $cmm_row_result['cmm_detail'] ?></textarea>
                                            <label for="pay_id" class="form-label">
                                                <h6 class="font-13 mt-3"> เวลา </h6>
                                            </label>
                                            <input type="text" parsley-trigger="change" class="form-control" readonly value="<?php echo $cmm_row_result['cmm_date'] ?>">
                                            <label for="pay_id" class="form-label">
                                                <h6 class="font-13 mt-3"> สินค้า </h6>
                                            </label>
                                            <input type="text" name="cmm_detail" parsley-trigger="change" class="form-control" id="cmm_detail" readonly value="<?php echo $cmm_row_result['prd_name'] ?>">
                                            <label for="pay_id" class="form-label">
                                                <h6 class="font-13 mt-3"> สมาชิก </h6>
                                            </label>
                                            <input type="text" name="cmm_detail" parsley-trigger="change" class="form-control" id="cmm_detail" readonly value="<?php echo $cmm_row_result['mmb_username'] ?>">
                                            <label for="pay_id" class="form-label">
                                                <h6 class="font-13 mt-3"> แสดงรีวิว </h6>
                                            </label>
                                            <select name="cmm_show" id="cmm_show" class="form-select">
                                                <?php
                                                if ($cmm_row_result['cmm_show'] == 1) {
                                                ?>
                                                    <option value='1' selected>แสดง</option>
                                                    <option value='0'>ไม่แสดง</option>
                                                <?php
                                                } else {
                                                ?>
                                                    <option value='0' selected>ไม่แสดง</option>
                                                    <option value='1'>แสดง</option>
                                                <?php
                                                }
                                                ?>
                                            </select>
                                            <input type="text" name="cmm_id" id="cmm_id" hidden value="<?php echo $cmm_row_result['cmm_id'] ?>">

                                        </div>
                                        <div class="text-end">
                                            <button class="btn btn-warning btn-sm waves-effect waves-light" type="submit" id="editbtn" name="editbtn"><i class="mdi mdi-checkbox-marked-outline"></i> บันทึก</button>
                                            <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='comment_show.php'">ย้อนกลับ</button>
                                        </div>
                                    </form>
                                </div>
                            </div> <!-- end card -->
                        </div>
                    </div> <!-- end row -->


                </div> <!-- container-fluid -->

            </div> <!-- content -->

            <!-- Footer Start -->
            <?php
            require_once('footer.php');
            ?>
            <!-- end Footer -->

        </div>

        <!-- ============================================================== -->
        <!-- End Page content -->
        <!-- ============================================================== -->


    </div>
    <!-- END wrapper -->

    <!-- Right Sidebar -->
    <?php
    require_once('right_ridebar.php');
    ?>

</body>

</html>