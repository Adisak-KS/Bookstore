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
                                    <h4 class="header-title">แก้ไขสมาชิก</h4>
                                    <br>
                                    <form action="member_edit.php" class="parsley-examples needs-validation" novalidate method="POST">
                                        <div class="mb-3">
                                            <input type="text" name="mmb_id" parsley-trigger="change" class="form-control" hidden id="mmb_id" value="<?php echo $mmb_row_result['mmb_id'] ?>" />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ชื่อผู้ใช้</label>
                                            <input type="text" name="mmb_username" parsley-trigger="change" required readonly class="form-control" id="mmb_username" maxlength="30" value="<?php echo $mmb_row_result['mmb_username'] ?>" />
                                            <div class="invalid-feedback">
                                                โปรดใส่ชื่อผู้ใช้
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ชื่อจริง<span class="text-danger">*</span></label>
                                            <input type="text" name="mmb_firstname" parsley-trigger="change" required class="form-control" id="mmb_firstname" maxlength="30" value="<?php echo $mmb_row_result['mmb_firstname'] ?>" />
                                            <div class="invalid-feedback">
                                                โปรดใส่ชื่อจริง
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">นามสกุล<span class="text-danger">*</span></label>
                                            <input type="text" name="mmb_lastname" parsley-trigger="change" required class="form-control" id="mmb_lastname" maxlength="30" value="<?php echo $mmb_row_result['mmb_lastname'] ?>" />
                                            <div class="invalid-feedback">
                                                โปรดใส่นามสกุล
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">อีเมล<span class="text-danger">*</span></label>
                                            <input type="email" name="mmb_email" parsley-trigger="change" required class="form-control" id="mmb_email" maxlength="80" value="<?php echo $mmb_row_result['mmb_email'] ?>" />
                                            <div class="invalid-feedback">
                                                โปรดใส่อีเมล
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">แต้มสะสม<span class="text-danger">*</span></label>
                                            <input type="number" name="mmb_coin" parsley-trigger="change" required class="form-control" id="mmb_coin" maxlength="10" value="<?php echo $mmb_row_result['mmb_coin'] ?>" />
                                            <div class="invalid-feedback">
                                                โปรดใส่แต้มสะสม
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <button class="btn btn-warning btn-sm waves-effect waves-light" type="submit" id="editbtn" name="editbtn"><i class="far fa-edit"></i> บันทึก</button>
                                            <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='member_show.php'">ย้อนกลับ</button>

                                        </div>
                                    </form>
                                </div>
                            </div> <!-- end card -->
                        </div>
                        <!-- end col -->
                        <!-- end col -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card card-draggable ui-sortable-handle">
                                        <img class="card-img-top img-fluid" src="../../../profile/<?php echo $mmb_row_result['mmb_profile']; ?>" style="max-width: 200px; max-height: 200px;" alt="Card image cap">
                                        <div class="card-body">
                                            <h4 class="card-title">รูปสมาชิก</h4>
                                        </div>
                                        <form action="member_upload.php" method="post" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <input type="text" hidden id="mmb_id" name="mmb_id" value="<?php echo $mmb_row_result['mmb_id'] ?>">
                                            <label for="fileToUpload">เลือกรูปภาพที่ต้องการอัปโหลด:<span class="text-danger">*</span></label>
                                            <input type="file" class="form-control" name="image" id="fileToUpload" accept="image/jpeg, image/png, image/gif">
                                        </div>
                                            <div class="text-end">
                                                <button class="btn btn-warning btn-sm waves-effect waves-light" type="submit" id="editbtn" name="editbtn"><i class="far fa-edit"></i> บันทึก</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
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