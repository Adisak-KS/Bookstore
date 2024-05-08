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
                                <div class="card-body">
                                    <h4 class="header-title">รายละเอียดช่องทางจัดส่ง</h4>
                                    <br>
                                    <form action="shipping_edit.php" class="parsley-examples needs-validation" novalidate method="POST">

                                        <input type="text" hidden id="shp_id" name="shp_id" value="<?php echo $shp_row_result['shp_id'] ?>">
                                        <div class="mb-3">
                                            <label for="shp_detail" class="form-label">ชื่อช่องทางจัดส่ง<span class="text-danger">*</span></label>
                                            <input type="text" name="shp_name" parsley-trigger="change" class="form-control" id="shp_name" value="<?php echo $shp_row_result['shp_name'] ?>" maxlength="20" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่ชื่อช่องทางจัดส่ง
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="shp_detail" class="form-label">รายละเอียดช่องทางจัดส่ง<span class="text-danger">*</span></label>
                                            <textarea name="shp_detail" parsley-trigger="change" class="form-control" id="shp_detail" rows="4" maxlength="50" required><?php echo $shp_row_result['shp_detail'] ?></textarea>
                                            <div class="invalid-feedback">
                                                โปรดใส่ชื่อรายละเอียดช่องทางจัดส่ง
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="shp_detail" class="form-label">ราคา<span class="text-danger">*</span></label>
                                            <input type="number" name="shp_price" parsley-trigger="change" class="form-control" id="shp_price" value="<?php echo $shp_row_result['shp_price'] ?>" min="1" max="10000" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่ราคา
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="shp_detail" class="form-label">แสดงช่องทางจัดส่ง<span class="text-danger">*</span></label>
                                            <select name="shp_show" parsley-trigger="change" class="form-select" id="shp_show" required>
                                                <option value="0" <?php echo ($shp_row_result['shp_show'] == '0') ? 'selected' : ''; ?>>ไม่แสดง</option>
                                                <option value="1" <?php echo ($shp_row_result['shp_show'] == '1') ? 'selected' : ''; ?>>แสดง</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                โปรดเลือกแสดงช่องทางจัดส่ง
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button class="btn btn-warning btn-sm waves-effect waves-light" type="submit" id="editbtn" name="editbtn"><i class="far fa-edit"></i> บันทึก</button>
                                            <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='shipping_show.php'">ย้อนกลับ</button>

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