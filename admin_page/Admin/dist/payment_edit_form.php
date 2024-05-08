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
    echo "<script>alert('ผิดพลาด ไม่พบช่องทางการชำระเงิน'); window.location='payment_show.php';</script>";
    exit;
}

$sql_script = "SELECT * FROM bk_ord_payment WHERE pay_id = '$edit_id'";
$pay_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$pay_row_result = mysqli_fetch_assoc($pay_result);
$pay_totalrows_result = mysqli_num_rows($pay_result);

if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
    $status = $_SESSION['status'];
    $status_code = $_SESSION['status_code'];

    // เคลียร์ค่า session
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);

    // แสดงหน้าต่างข้อความแจ้งเตือน
    echo "<script>alert('$status');</script>";
    echo "<script>window.location.href = 'payment_edit_form.php';</script>";
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
                                    <h4 class="header-title">รายละเอียดช่องทางการชำระเงิน</h4>
                                    <br>
                                    <form action="payment_edit.php" class="parsley-examples needs-validation" novalidate method="POST">

                                        <input type="text" hidden id="pay_id" name="pay_id" value="<?php echo $pay_row_result['pay_id'] ?>">
                                        <div class="mb-3">
                                            <label for="pay_detail" class="form-label">ชื่อช่องทางการชำระเงิน<span class="text-danger">*</span></label>
                                            <input type="text" name="pay_name" parsley-trigger="change" class="form-control" id="pay_name" value="<?php echo $pay_row_result['pay_name'] ?>" maxlength="20" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่ชื่อช่องทางการชำระเงิน
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="pay_detail" class="form-label">รายละเอียดช่องทางการชำระเงิน<span class="text-danger">*</span></label>
                                            <textarea name="pay_detail" parsley-trigger="change" class="form-control" id="pay_detail" rows="4" maxlength="50" required><?php echo $pay_row_result['pay_detail'] ?></textarea>
                                            <div class="invalid-feedback">
                                                โปรดใส่รายละเอียดช่องทางการชำระเงิน
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="pay_detail" class="form-label">แสดงช่องทางการชำระเงิน<span class="text-danger">*</span></label>
                                            <select name="pay_show" parsley-trigger="change" class="form-select" id="pay_show" required>
                                                <option value="0" <?php echo ($pay_row_result['pay_show'] == '0') ? 'selected' : ''; ?>>ไม่แสดง</option>
                                                <option value="1" <?php echo ($pay_row_result['pay_show'] == '1') ? 'selected' : ''; ?>>แสดง</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                โปรดเลือกแสดงช่องทางการชำระเงิน
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <button class="btn btn-warning btn-sm waves-effect waves-light" type="submit" id="editbtn" name="editbtn"><i class="far fa-edit"></i> บันทึก</button>
                                            <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='payment_show.php'">ย้อนกลับ</button>
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
                                        if ($pay_row_result['pay_logo'] != '') {
                                        ?>
                                            <img class="card-img-top img-fluid" src="../../../pay_logo/<?php echo $pay_row_result['pay_logo']; ?>" alt="Card image cap" style="max-width: 200px; max-height: 200px;">
                                        <?php } else {
                                            echo 'ไม่มีรูป';
                                        } ?>
                                        <div class="card-body">
                                            <h4 class="card-title">โลโก้ช่องทางการชำระเงิน</h4>
                                        </div>
                                        <form action="payment_upload.php" method="post" enctype="multipart/form-data">
                                            <input type="text" hidden id="pay_id" name="pay_id" value="<?php echo $pay_row_result['pay_id'] ?>">
                                            <div class="mb-3">
                                                <label for="fileToUpload">เลือกรูปภาพที่ต้องการอัปโหลด:<span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" name="image" id="fileToUpload" accept="image/jpeg, image/png, image/gif">
                                            </div>
                                            <div class="text-end">
                                                <button class="btn btn-warning btn-sm waves-effect waves-light" type="submit" id="submit_logo" name="submit_logo"><i class="far fa-edit"></i> บันทึก</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            <div class="card">
                                <div class="card-body">
                                    <div class="card card-draggable ui-sortable-handle">
                                        <?php
                                        if ($pay_row_result['pay_img'] != '') {
                                        ?>
                                            <img class="card-img-top img-fluid" src="../../../pay_img/<?php echo $pay_row_result['pay_img']; ?>" alt="Card image cap" style="max-width: 200px; max-height: 200px;">
                                        <?php } else {
                                            echo 'ไม่มีรูป';
                                        } ?>
                                        <div class="card-body">
                                            <h4 class="card-title">รูปช่องทางการชำระเงิน</h4>
                                        </div>
                                        <form action="payment_upload.php" method="post" enctype="multipart/form-data">
                                            <input type="text" hidden id="pay_id" name="pay_id" value="<?php echo $pay_row_result['pay_id'] ?>">
                                            <div class="mb-3">
                                                <label for="fileToUpload">เลือกรูปภาพที่ต้องการอัปโหลด:<span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" name="image" id="fileToUpload" accept="image/jpeg, image/png, image/gif">
                                            </div>
                                            <div class="text-end">
                                                <button class="btn btn-warning btn-sm waves-effect waves-light" type="submit" id="submit_img" name="submit_img"><i class="far fa-edit"></i> บันทึก</button>
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