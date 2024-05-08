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
    echo "<script>alert('ผิดพลาด ไม่พบช่องทางจัดส่ง'); window.location='shipping_show.php';</script>";
    exit;
}

$sql_script = "SELECT * FROM bk_ord_shipping WHERE shp_id = '$edit_id'";
$shp_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$shp_row_result = mysqli_fetch_assoc($shp_result);
$shp_totalrows_result = mysqli_num_rows($shp_result);

if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
    $status = $_SESSION['status'];
    $status_code = $_SESSION['status_code'];

    // เคลียร์ค่า session
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);

    // แสดงหน้าต่างข้อความแจ้งเตือน
    echo "<script>alert('$status');</script>";
    echo "<script>window.location.href = 'shipping_edit_form.php';</script>";
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
                                <div class="card-body  alert-danger">
                                    <h4 class="header-title">รายละเอียดช่องทางจัดส่ง</h4>
                                    <br>
                                    <form action="shipping_edit.php" class="parsley-examples" method="POST">
                                        <div class="mb-3">
                                            <input type="text" hidden id="shp_id" name="shp_id" value="<?php echo $shp_row_result['shp_id'] ?>">
                                            <label for="shp_detail" class="form-label">ชื่อช่องทางจัดส่ง</label>
                                            <input type="text" name="shp_name" parsley-trigger="change" class="form-control alert-danger" id="shp_name" value="<?php echo $shp_row_result['shp_name'] ?>" readonly />
                                            <div class="mb-3">
                                                <label for="shp_detail" class="form-label">รายละเอียดช่องทางจัดส่ง</label>
                                                <textarea name="shp_detail" parsley-trigger="change" class="form-control alert-danger" id="shp_detail" rows="4" readonly><?php echo $shp_row_result['shp_detail'] ?></textarea>
                                            </div>
                                            <label for="shp_detail" class="form-label">ราคา</label>
                                            <input type="int" name="shp_price" parsley-trigger="change" class="form-control alert-danger" id="shp_price" value="<?php echo $shp_row_result['shp_price'] ?>" readonly />
                                            <label for="shp_detail" class="form-label">แสดงช่องทางจัดส่ง</label>
                                            <select name="shp_show" parsley-trigger="change" class="form-select alert-danger" id="shp_show" disabled>
                                                <option value="0" <?php echo ($shp_row_result['shp_show'] == '0') ? 'selected' : ''; ?>>ไม่แสดง</option>
                                                <option value="1" <?php echo ($shp_row_result['shp_show'] == '1') ? 'selected' : ''; ?>>แสดง</option>
                                            </select>

                                        </div>
                                        <div class="text-end">
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#danger-alert-modal"><i class="mdi mdi-delete"></i> ลบ</button>
                                            <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='shipping_show.php'">ย้อนกลับ</button>

                                        </div>
                                    </form>
                                </div>
                            </div> <!-- end card -->
                        </div>
                        <!-- end col -->
                        <div id="danger-alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                            <div class="modal-dialog modal-sm">
                                <div class="modal-content modal-filled">
                                <div class="modal-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                    <div class="modal-body bg-danger">
                                        <div class="text-center">
                                            <i class="dripicons-wrong h1 text-white"></i>
                                            <h4 class="mt-2 text-white">แจ้งเตือน</h4>
                                            <p class="mt-3 text-white">คุณแน่ใจว่าจะลบช่องทางการขนส่งนี้?</p>
                                            <form action="shipping_delete.php" method="POST">
                                                <input type="text" hidden id="shp_id" name="shp_id" value="<?php echo $shp_row_result['shp_id'] ?>">
                                                <button type="submit" name="deletebtn" class="btn btn-light my-2" data-bs-dismiss="modal">ตกลง</button>
                                            </form>
                                        </div>
                                    </div>
                                </div><!-- /.modal-content -->
                            </div><!-- /.modal-dialog -->
                        </div><!-- /.modal -->
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