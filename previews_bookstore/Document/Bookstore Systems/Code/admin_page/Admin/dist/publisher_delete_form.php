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
    echo "<script>alert('ผิดพลาด ไม่พบประเภทสินค้า'); window.location='publisher_show.php';</script>";
    exit;
}

$sql_script = "SELECT p.*, COUNT(prd.prd_id) AS product_count
FROM bk_prd_publisher p
LEFT JOIN bk_prd_product prd ON p.publ_id = prd.publ_id
WHERE p.publ_id = '$edit_id'
GROUP BY p.publ_id;
";
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

                            <div class="card" alert-danger>
                                <div class="card-body alert-danger">
                                    <h4 class="header-title">สำนักพิมพ์</h4>
                                    <br>
                                    <form action="publisher_delete.php" class="parsley-examples" method="POST">
                                        <div class="mb-3">
                                            <input type="text" hidden id="publ_id" name="publ_id" value="<?php echo $publ_row_result['publ_id'] ?>">
                                            <label for="publ_detail" class="form-label">ชื่อสำนักพิมพ์</label>
                                            <input type="text" name="publ_name" parsley-trigger="change" class="form-control alert-danger" id="publ_name" value="<?php echo $publ_row_result['publ_name'] ?>" readonly />
                                            <label for="prd_detail" class="form-label">รายละเอียดสำนักพิมพ์</label>
                                            <textarea name="prd_detail" parsley-trigger="change" class="form-control alert-danger" id="prd_detail" rows="4" readonly><?php echo $publ_row_result['publ_detail'] ?></textarea>

                                        </div>
                                        <div class="text-end">
                                            <?php
                                            if ($publ_row_result['product_count'] > 0) {
                                            ?>
                                                <p>ไม่สามารถลบได้ มีสินค้าใช้สำนักพิมพ์นี้อยู่ <?= $publ_row_result['product_count'] ?> รายการ</p>
                                                <button type="button" id="delprd" name="delprd" class="btn btn-danger btn-sm waves-effect waves-light" onclick="location.href='publisher-product_delete_form.php';"><i class="fas fa-box"></i> ลบสินค้า</button>
                                                <button disabled type="submit" id="delbtn" name="delbtn" class="btn btn-danger btn-sm waves-effect waves-light"><i class="mdi mdi-delete"></i> ลบ</button>
                                            <?php
                                            } else {
                                            ?>
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#danger-alert-modal"><i class="mdi mdi-delete"></i> ลบ</button>
                                            <?php
                                            }
                                            ?>
                                            <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='publisher_show.php'">ย้อนกลับ</button>

                                        </div>
                                    </form>

                                    <!-- Danger Alert Modal -->
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
                                                        <p class="mt-3 text-white">คุณแน่ใจว่าจะลบสำนักพิมพ์?</p>
                                                        <form action="publisher_delete.php" method="POST">
                                                            <input type="text" hidden id="publ_id" name="publ_id" value="<?php echo $publ_row_result['publ_id'] ?>">
                                                            <button type="submit" name="deletebtn" class="btn btn-light my-2" data-bs-dismiss="modal">ตกลง</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->

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