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
    echo "<script>alert('ผิดพลาด ไม่พบสินค้า'); window.location='product_show.php';</script>";
    exit;
}

$sql_script = "SELECT * FROM bk_setting WHERE set_id = '$edit_id'";
$set_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$set_row_result = mysqli_fetch_assoc($set_result);
$set_totalrows_result = mysqli_num_rows($set_result);

if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
    $status = $_SESSION['status'];
    $status_code = $_SESSION['status_code'];

    // เคลียร์ค่า session
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);

    // แสดงหน้าต่างข้อความแจ้งเตือน
    echo "<script>alert('$status');</script>";
    echo "<script>window.location.href = 'product_edit_form.php?edit_id=$edit_id';</script>";
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
                        <!-- end col -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">แก้ไขรายละเอียดเว็บไซต์</h4>
                                    <br>
                                    <form action="setting_edit.php" class="parsley-examples needs-validation" novalidate method="POST" >
                                        <div class="mb-3">
                                            <input type="text" hidden id="set_id" name="set_id" value="<?= $set_row_result['set_id'] ?>">
                                            <label for="prp_detail" class="form-label"><?= $_POST['set_name'] ?><span class="text-danger">*</span></label>
                                            <textarea name="set_detail" parsley-trigger="change" class="form-control" id="set_detail" rows="10" maxlength="1000" required><?= $set_row_result['set_detail'] ?></textarea>
                                            <div class="invalid-feedback">
                                                โปรดใส่รายละเอียด
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button class="btn btn-warning btn-sm waves-effect waves-light" type="submit" id="editbtn" name="editbtn"><i class="far fa-edit"></i> บันทึก</button>
                                            <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='setting_edit_form.php'">ย้อนกลับ</button>

                                        </div>
                                    </form>
                                </div>
                            </div> <!-- end card -->
                        </div>
                    </div> <!-- end row -->



                </div> <!-- container-fluid -->

            </div> <!-- content -->
            <script>
    function validateMapUrl() {
        var urlInput = document.getElementById('set_detail');
        var url = urlInput.value;
        
        // เช็คว่า URL ที่กรอกเข้ามาเป็น URL ของ Google Maps หรือไม่
        if (!url.match(/^https:\/\/www\.google\.com\/maps\/embed\?pb=!1m16!1m12!1m3!1d\d+\.\d+!2d\d+\.\d+!3d\d+\.\d+!2m3!1f\d+!2f\d+!3f\d+!3m2!1i\d+!2i\d+!4f\d+\.\d+!2m\d+!1s\w+!2s\w+!5e\d+!3m\d+!1s\w+!2s\w+!4v\d+!5m\d+!1s\w+!2s\w+$/)) {
            alert("โปรดกรอก URL ของแผนที่ Google Maps เท่านั้น");
            return false;
        }
        return true;
    }
</script>

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