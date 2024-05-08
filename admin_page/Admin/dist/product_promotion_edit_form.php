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
    echo "<script>alert('ผิดพลาด ไม่พบประเภทสินค้า'); window.location='product_promotion_show.php';</script>";
    exit;
}

$sql_script = "SELECT * FROM bk_promotion WHERE prp_id = '$edit_id'";
$prp_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$prp_row_result = mysqli_fetch_assoc($prp_result);
$prp_totalrows_result = mysqli_num_rows($prp_result);

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
                                    <h4 class="header-title">โปรโมชั่น</h4>
                                    <br>
                                    <form action="product_promotion_edit.php" class="parsley-examples needs-validation" id="dateForm" name="dataForm" novalidate method="POST">

                                        <input type="text" hidden id="prp_id" name="prp_id" value="<?php echo $prp_row_result['prp_id'] ?>">
                                        <div class="mb-3">
                                            <label for="prp_detail" class="form-label">ชื่อโปรโมชั่น<span class="text-danger">*</span></label>
                                            <input type="text" name="prp_name" parsley-trigger="change" class="form-control" id="prp_name" value="<?php echo $prp_row_result['prp_name'] ?>" maxlength="20" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่ชื่อโปรโมชั่น
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="prp_detail" class="form-label">รายละเอียดโปรโมชั่น<span class="text-danger">*</span></label>
                                            <textarea name="prp_detail" parsley-trigger="change" class="form-control" id="prp_detail" rows="4" maxlength="50" required><?php echo $prp_row_result['prp_detail'] ?></textarea>
                                            <div class="invalid-feedback">
                                                โปรดใส่รายละเอียดโปรโมชั่น
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="prp_discount" class="form-label">ส่วนลด<span class="text-danger">*</span></label>
                                            <input type="number" name="prp_discount" parsley-trigger="change" class="form-control" id="prp_discount" value="<?php echo $prp_row_result['prp_discount'] ?>" min="1" max="99" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่ส่วนลด
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="prp_show" class="form-label">แสดงโปรโมชัน<span class="text-danger">*</span></label>
                                            <select name="prp_show" parsley-trigger="change" class="form-select" required id="prp_show">
                                                <option value="0" <?php echo ($prp_row_result['prp_show'] == '0') ? 'selected' : ''; ?>>ไม่แสดง</option>
                                                <option value="1" <?php echo ($prp_row_result['prp_show'] == '1') ? 'selected' : ''; ?>>แสดง</option>
                                            </select>
                                            <br>
                                            <div class="invalid-feedback">
                                                โปรดเลือกแสดงโปรโมชัน
                                            </div>

                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="mb-3">
                                                    <label for="start_date" class="form-label">วันที่เริ่มต้น<span class="text-danger">*</span></label>
                                                    <input class="form-control" id="prp_start" type="date" name="prp_start" value="<?php echo $prp_row_result['prp_start'] ?>" required>
                                                    <div class="invalid-feedback">กรุณาเลือกวันที่เริ่มต้นให้ถูกต้อง</div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="mb-3">
                                                    <label for="end_date" class="form-label">วันที่สิ้นสุด<span class="text-danger">*</span></label>
                                                    <input class="form-control" id="prp_end" type="date" name="prp_end" value="<?php echo $prp_row_result['prp_end'] ?>" required>
                                                    <div class="invalid-feedback">กรุณาเลือกวันที่สิ้นสุดให้ถูกต้อง</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <button class="btn btn-warning btn-sm waves-effect waves-light" type="submit" id="editbtn" name="editbtn"><i class="far fa-edit"></i> บันทึก</button>
                                            <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='product_promotion_show.php'">ย้อนกลับ</button>
                                        </div>
                                    </form>
                                    <script>
                                        document.getElementById("editbtn").addEventListener("click", function(event) {
                                            event.preventDefault(); // หยุดการกระทำของปุ่มเพื่อป้องกันการโหลดหน้าใหม่

                                            // ตรวจสอบความถูกต้องของฟอร์มโดยใช้ checkValidity()
                                            if (!document.getElementById("dateForm").checkValidity()) {
                                                // ถ้าฟอร์มไม่ถูกต้อง ให้ทำการแสดง feedback และหยุดการทำงาน
                                                document.getElementById("dateForm").classList.add('was-validated');
                                                return;
                                            }

                                            var startDate = document.getElementById("prp_start").value;
                                            var endDate = document.getElementById("prp_end").value;

                                            // ตรวจสอบว่าวันที่สิ้นสุดมากกว่าหรือเท่ากับวันที่เริ่มต้น
                                            if (endDate < startDate) {
                                                document.getElementById("prp_start").classList.remove("is-valid");
                                                document.getElementById("prp_start").classList.add("is-invalid");
                                                document.getElementById("prp_end").classList.remove("is-valid");
                                                document.getElementById("prp_end").classList.add("is-invalid");
                                                return;
                                            }

                                            // ถ้าข้อมูลถูกต้อง ให้ส่งข้อมูลไปยังหน้าที่เป้าหมาย
                                            document.forms["dataForm"].submit();
                                        });
                                    </script>
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