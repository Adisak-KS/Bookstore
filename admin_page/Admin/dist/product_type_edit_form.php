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
if (isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $_SESSION['edit_id'] = $edit_id;
} elseif ($_SESSION['edit_id']) {
    $edit_id = $_SESSION['edit_id'];
} else {
    echo "<script>alert('ผิดพลาด ไม่พบประเภทสินค้า'); window.location='product_type_show.php';</script>";
    exit;
}

$sql_script = "SELECT * FROM bk_prd_type WHERE pty_id = '$edit_id'";
$pty_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$pty_row_result = mysqli_fetch_assoc($pty_result);
$pty_totalrows_result = mysqli_num_rows($pty_result);

$page_title = basename($_SERVER['PHP_SELF']);

if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
    $status = $_SESSION['status'];
    $status_code = $_SESSION['status_code'];

    // เคลียร์ค่า session
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);

    // แสดงหน้าต่างข้อความแจ้งเตือน
    echo "<script>alert('$status');</script>";
    echo "<script>window.location.href = '$page_title';</script>";
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
                                    <h4 class="header-title">แก้ไขประเภทสินค้า</h4>
                                    <br>
                                    <form action="product_type_edit.php" class="parsley-examples needs-validation" novalidate method="POST">
                                        <div class="mb-3">
                                            <input type="text" hidden id="pty_id" name="pty_id" value="<?php echo $pty_row_result['pty_id'] ?>">
                                            <label for="pty_detail" class="form-label">ชื่อประเภทสินค้า<span class="text-danger">*</span></label>
                                            <input type="text" name="pty_name" parsley-trigger="change" required maxlength="20" class="form-control" id="pty_name" value="<?php echo $pty_row_result['pty_name'] ?>" />
                                            <div class="invalid-feedback">
                                                โปรดใส่ชื่อประเภทสินค้า
                                            </div>
                                            <div class="mb-3">
                                                <label for="pty_detail" class="form-label">รายละเอียดประเภทสินค้า<span class="text-danger">*</span></label>
                                                <textarea name="pty_detail" parsley-trigger="change" required maxlength="50" class="form-control" id="pty_detail" rows="4"><?php echo $pty_row_result['pty_detail'] ?></textarea>
                                            <div class="invalid-feedback">
                                                โปรดใส่รายละเอียดประเภทสินค้า
                                            </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="pty_show" class="form-label">แสดงสินค้า<span class="text-danger">*</span></label>
                                                <select name="pty_show" parsley-trigger="change" class="form-select" required id="pty_show">
                                                    <option value="0" <?php echo ($pty_row_result['pty_show'] == '0') ? 'selected' : ''; ?>>ไม่แสดง</option>
                                                    <option value="1" <?php echo ($pty_row_result['pty_show'] == '1') ? 'selected' : ''; ?>>แสดง</option>
                                                </select>
                                                <br>
                                            <div class="invalid-feedback">
                                                โปรดเลือกแสดงประเภทสินค้า
                                            </div>
                                               
                                            </div>

                                        </div>
                                        <div class="text-end">
                                            <button class="btn btn-warning btn-sm waves-effect waves-light" type="submit" id="editbtn" name="editbtn"><i class="far fa-edit"></i> บันทึก</button>
                                            <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='product_type_show.php'">ย้อนกลับ</button>

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