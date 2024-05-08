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
    echo "<script>alert('ผิดพลาด ไม่พบสมาชิก'); window.location='member_show.php';</script>";
    exit;
}

$sql_script = "SELECT * FROM bk_auth_member WHERE mmb_id = '$edit_id'";
$mmb_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$mmb_row_result = mysqli_fetch_assoc($mmb_result);
$mmb_totalrows_result = mysqli_num_rows($mmb_result);

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
                                    <h4 class="header-title">รายละเอียดสมาชิก</h4>
                                    <br>
                                    <form action="member_edit.php" class="parsley-examples" method="POST">
                                        <div class="mb-3">
                                            <input type="text" name="mmb_id" parsley-trigger="change" class="form-control" hidden id="mmb_id" value="<?php echo $mmb_row_result['mmb_id'] ?>" />
                                            <label class="form-label">ชื่อผู้ใช้</label>
                                            <input type="text" name="mmb_username" parsley-trigger="change" class="form-control" readonly id="mmb_username" maxlength="30" value="<?php echo $mmb_row_result['mmb_username'] ?>" />
                                            <label class="form-label">ชื่อจริง</label>
                                            <input type="text" name="mmb_firstname" parsley-trigger="change" class="form-control" readonly id="mmb_firstname" maxlength="30" value="<?php echo $mmb_row_result['mmb_firstname'] ?>" />
                                            <label class="form-label">นามสกุล</label>
                                            <input type="text" name="mmb_lastname" parsley-trigger="change" class="form-control" readonly id="mmb_lastname" maxlength="30" value="<?php echo $mmb_row_result['mmb_lastname'] ?>" />
                                            <label class="form-label">อีเมล</label>
                                            <input type="email" name="mmb_email" parsley-trigger="change" class="form-control" readonly id="mmb_email" maxlength="80" value="<?php echo $mmb_row_result['mmb_email'] ?>" />
                                            <label class="form-label">แต้มสะสม</label>
                                            <input type="number" name="mmb_coin" parsley-trigger="change" class="form-control" readonly id="mmb_coin" maxlength="10" value="<?php echo $mmb_row_result['mmb_coin'] ?>" />

                                        </div>
                                        <div class="text-end">
                                            <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='member_show.php'">ย้อนกลับ</button>
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
                                                        <p class="mt-3 text-white">คุณแน่ใจว่าจะลบสมาชิกนี้?</p>
                                                        <form action="member_delete.php" method="POST">
                                                            <input type="text" hidden id="mmb_id" name="mmb_id" value="<?php echo $mmb_row_result['mmb_id'] ?>">
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
                        <!-- end col -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="text-center">
                                        <div class="card-center card-draggable ui-sortable-handle">
                                            <img class="card-img-top img-fluid" src="../../../profile/<?php echo $mmb_row_result['mmb_profile']; ?>" style="max-width: 200px; max-height: 200px;" alt="Card image cap">
                                            <div class="card-body">
                                                <h4 class="card-title">รูปสมาชิก</h4>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                        </div> <!-- end row -->
                        <!-- ที่อยู่สมาชิก -->
                        <?php
                        $sql_script = "SELECT * FROM bk_mmb_address WHERE mmb_id = '$edit_id'";
                        $addr_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                        $addr_row_result = mysqli_fetch_assoc($addr_result);
                        $addr_totalrows_result = mysqli_num_rows($addr_result);
                        ?>
                        <div class="row">
                            <div class="col-lg-6">

                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="card-title">ที่อยู่สมาชิก </h4>
                                        <?php
                                        $i = 1;
                                        if (mysqli_num_rows($addr_result) > 0) {
                                            // ถ้ามีข้อมูลที่อยู่ให้แสดงข้อมูล
                                            do {
                                        ?>
                                                <h5 class="card-title">ที่อยู่ <?php echo $i; ?></h5>
                                                <label class="form-label">รายละเอียด</label>
                                                <input type="text" name="addr_detail" parsley-trigger="change" class="form-control" readonly id="addr_detail" maxlength="30" value="<?php echo $addr_row_result['addr_detail'] ?>" />
                                                <label class="form-label">จังหวัด</label>
                                                <input type="text" name="addr_provin" parsley-trigger="change" class="form-control" readonly id="addr_provin" maxlength="30" value="<?php echo $addr_row_result['addr_provin'] ?>" />
                                                <label class="form-label">อำเภอ</label>
                                                <input type="text" name="addr_amphu" parsley-trigger="change" class="form-control" readonly id="addr_amphu" maxlength="30" value="<?php echo $addr_row_result['addr_amphu'] ?>" />
                                                <label class="form-label">ไปรษณีย์</label>
                                                <input type="text" name="addr_postal" parsley-trigger="change" class="form-control" readonly id="addr_postal" maxlength="30" value="<?php echo $addr_row_result['addr_postal'] ?>" />
                                                <label class="form-label">เบอร์โทร</label>
                                                <input type="text" name="addr_phone" parsley-trigger="change" class="form-control" readonly id="addr_phone" maxlength="30" value="<?php echo $addr_row_result['addr_phone'] ?>" />
                                                <br>
                                            <?php
                                                $i++;
                                            } while ($addr_row_result = mysqli_fetch_assoc($addr_result));
                                        } else { ?>
                                            <h5 class="card-title">ไม่พบที่อยู่สมาชิก</h5>
                                        <?php
                                        }
                                        ?>

                                    </div>
                                </div>

                            </div>
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