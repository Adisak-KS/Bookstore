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
    echo "<script>alert('ผิดพลาด ไม่พบแบนเนอร์'); window.location='banner_show.php';</script>";
    exit;
}

$sql_script = "SELECT * FROM bk_set_banner WHERE bnn_id = '$edit_id'";
$bnn_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$bnn_row_result = mysqli_fetch_assoc($bnn_result);
$bnn_totalrows_result = mysqli_num_rows($bnn_result);

if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
    $status = $_SESSION['status'];
    $status_code = $_SESSION['status_code'];

    // เคลียร์ค่า session
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);

    // แสดงหน้าต่างข้อความแจ้งเตือน
    echo "<script>alert('$status');</script>";
    echo "<script>window.location.href = 'banner_edit_form.php';</script>";
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
                                    <h4 class="header-title">รายละเอียดแบนเนอร์</h4>
                                    <br>
                                    <form action="banner_edit.php" name="banner_edit_form" class="parsley-examples needs-validation" novalidate method="POST">
                                        <input type="text" hidden id="bnn_id" name="bnn_id" value="<?php echo $bnn_row_result['bnn_id'] ?>">
                                        <div class="mb-3">
                                            <label for="bnn_detail" class="form-label">ชื่อแบนเนอร์<span class="text-danger">*</span></label>
                                            <input type="text" name="bnn_name" parsley-trigger="change" class="form-control" id="bnn_name" value="<?php echo $bnn_row_result['bnn_name'] ?>" maxlength="20" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่ชื่อแบนเนอร์
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">ลิ้งก์แบนเนอร์<span class="text-danger">*</span></label>
                                            <input type="url" required="" maxlength="200" class="form-control" id="bnn_link" name="bnn_link" placeholder="ลิ้งก์แบนเนอร์" value="<?php echo $bnn_row_result['bnn_link'] ?>">
                                            <div class="invalid-feedback">
                                                โปรดใส่ลิ้งก์แบนเนอร์
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="bnn_detail" class="form-label">แสดงแบนเนอร์<span class="text-danger">*</span></label>
                                            <select name="bnn_show" parsley-trigger="change" class="form-select" id="bnn_show" required>
                                                <option value="0" <?php echo ($bnn_row_result['bnn_show'] == '0') ? 'selected' : ''; ?>>ไม่แสดง</option>
                                                <option value="1" <?php echo ($bnn_row_result['bnn_show'] == '1') ? 'selected' : ''; ?>>แสดง</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                โปรดเลือกแสดงแบนเนอร์
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button class="btn btn-warning btn-sm waves-effect waves-light" type="submit" id="editbtn" name="editbtn"><i class="far fa-edit"></i> บันทึก</button>
                                            <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='banner_show.php'">ย้อนกลับ</button>
                                        </div>
                                    </form>
                                </div>
                            </div> <!-- end card -->
                        </div>
                        <!-- end col -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card card-draggable ui-sortable-handle">
                                        <?php
                                        if ($bnn_row_result['bnn_image'] != '') {
                                        ?>
                                            <img class="card-img-top img-fluid" src="../../../bnn_image/<?php echo $bnn_row_result['bnn_image']; ?>" alt="Card image cap" style="max-width: 200px; max-height: 200px;">
                                        <?php } else {
                                            echo 'ไม่มีรูป';
                                        } ?>
                                        <div class="card-body">
                                            <h4 class="card-title">ภาพแบนเนอร์</h4>
                                        </div>
                                        <form action="banner_edit.php" method="post" enctype="multipart/form-data">
                                            <input type="text" hidden id="bnn_id" name="bnn_id" value="<?php echo $bnn_row_result['bnn_id'] ?>">
                                            <div class="mb-3">
                                                <label for="fileToUpload">เลือกรูปภาพที่ต้องการอัปโหลด:<span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" name="image" id="fileToUpload" accept="image/jpeg, image/png">
                                            </div>
                                            <div class="text-end">
                                                <button class="btn btn-warning btn-sm waves-effect waves-light" value="อัปโหลดรูปภาพ" type="submit" id="submit_image" name="submit_image"><i class="far fa-edit"></i> บันทึก</button>
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