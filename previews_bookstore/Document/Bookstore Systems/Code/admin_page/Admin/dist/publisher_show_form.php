<?php
require_once __DIR__ . '/../../../connection.php';

// ตรวจสอบสิทธิ์
if (!(isset($_SESSION['admin']))) {
    $_SESSION['status'] = "ไม่พบสิทธิ์การใช้งานในหน้านี้";
    $_SESSION['status_code'] = "ผิดพลาด";
    header('Location: login_form.php');
exit;
}


// ตรวจสอบว่ามีค่า 'edit_id' ที่ถูกส่งมาใน URL หรือไม่
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
} elseif (isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
} else {
    echo "<script>alert('ผิดพลาด ไม่พบสำนักพิมพ์'); window.location='publisher_show.php';</script>";
    exit;
}

$sql_script = "SELECT * FROM bk_prd_publisher WHERE publ_id = '$edit_id'";
$publ_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$publ_row_result = mysqli_fetch_assoc($publ_result);
$publ_totalrows_result = mysqli_num_rows($publ_result);

$page_title = basename($_SERVER['PHP_SELF']);

if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
    $status = $_SESSION['status'];
    $status_code = $_SESSION['status_code'];

    // เคลียร์ค่า session
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);

    // แสดงหน้าต่างข้อความแจ้งเตือน
    echo "<script>alert('$status');</script>";
    echo "<script>window.location.href = '$page_title?edit_id=$edit_id';</script>";
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
                    <!-- ฟอร์มแก้ไขสมาชิก -->


                    <div class="row">
                        <div class="col-lg-6">

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">รายละเอียดสำนักพิพม์</h4>
                                    <br>
                                    <form action="publisher_edit.php" class="parsley-examples" method="POST">
                                        <div class="mb-3">
                                            <input type="text" hidden id="publ_id" name="publ_id" value="<?php echo $publ_row_result['publ_id'] ?>">
                                            <label for="publ_detail" class="form-label">ชื่อสำนักพิพม์</label>
                                            <input type="text" name="publ_name" parsley-trigger="change" class="form-control" id="publ_name" readonly value="<?php echo $publ_row_result['publ_name'] ?>" />
                                            <label for="publ_detail" class="form-label">รายละเอียดสำนักพิพม์</label>
                                            <textarea name="publ_detail" parsley-trigger="change" class="form-control" id="publ_detail" readonly rows="4"><?php echo $publ_row_result['publ_detail'] ?></textarea>


                                        </div>
                                        <div class="text-end">
                                            <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='publisher_show.php'">ย้อนกลับ</button>

                                        </div>
                                    </form>
                                </div>
                            </div> <!-- end card -->

                        </div>
                        <!-- end col -->


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