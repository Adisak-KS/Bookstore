<?php
require_once __DIR__ . '/../../../connection.php';

// ตรวจสอบสิทธิ์
// if (!(isset($_SESSION['admin']) || isset($_SESSION['sale']) || isset($_SESSION['super_admin']))) {
//     $_SESSION['status'] = "ไม่พบสิทธิ์การใช้งานในหน้านี้";
//     $_SESSION['status_code'] = "ผิดพลาด";
//     header('Location: login_form.php');
// }

$edit_id = $_SESSION['login_id'];

$sql_script = "SELECT * FROM bk_auth_staff WHERE stf_id = '$edit_id'";
$stf_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$stf_row_result = mysqli_fetch_assoc($stf_result);
$stf_totalrows_result = mysqli_num_rows($stf_result);

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
                                    <h4 class="header-title">บัญชีของฉัน</h4>
                                    <br>
                                    <form action="staff_edit.php" class="parsley-examples needs-validation" novalidate method="POST">
                                        <div class="mb-3">
                                            <input type="text" name="stf_id" parsley-trigger="change" class="form-control" hidden id="stf_id" value="<?php echo $stf_row_result['stf_id'] ?>" required />
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ชื่อผู้ใช้</label>
                                            <input type="text" name="stf_username" parsley-trigger="change" class="form-control" id="stf_username" minlength="6" maxlength="30" value="<?php echo $stf_row_result['stf_username'] ?>" readonly required />
                                            <div class="invalid-feedback">
                                                โปรดใส่ชื่อผู้ใช้ให้ถูกต้อง
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ชื่อจริง<span class="text-danger">*</span></label>
                                            <input type="text" name="stf_firstname" parsley-trigger="change" class="form-control" id="stf_firstname" maxlength="30" value="<?php echo $stf_row_result['stf_firstname'] ?>" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่ชื่อชื่อจริง
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">นามสกุล<span class="text-danger">*</span></label>
                                            <input type="text" name="stf_lastname" parsley-trigger="change" class="form-control" id="stf_lastname" maxlength="30" value="<?php echo $stf_row_result['stf_lastname'] ?>" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่ชื่อนามสกุล
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">อีเมล<span class="text-danger">*</span></label>
                                            <input type="email" name="stf_email" parsley-trigger="change" class="form-control" id="stf_email" maxlength="80" value="<?php echo $stf_row_result['stf_email'] ?>" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่อีเมล
                                            </div>
                                        </div>


                                        <div class="text-end">
                                            <button class="btn btn-warning btn-sm waves-effect waves-light" type="submit" id="editbtn" name="editbtn"><i class="far fa-edit"></i> บันทึก</button>
                                            <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='index.php'">ย้อนกลับ</button>

                                        </div>
                                    </form>
                                </div>
                            </div> <!-- end card -->
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">เปลี่ยนรหัสผ่าน</h4>
                                    <br>
                                    <form action="staff_edit_password.php" method="POST" class="needs-validation" novalidate onsubmit="return validatePassword()">
                                        <input type="text" name="stf_id" parsley-trigger="change" class="form-control" readonly id="stf_id" value="<?php echo $stf_row_result['stf_id'] ?>" hidden />
                                        <div class="mb-3">
                                            <label class="form-label">รหัสผ่านปัจจุบัน<span class="text-danger">*</span></label>
                                            <input type="password" name="current_password" parsley-trigger="change" class="form-control" id="current_password" maxlength="30" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่รหัสผ่านปัจจุบัน
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">รหัสผ่านใหม่<span class="text-danger">*</span></label>
                                            <input type="password" name="new_password" parsley-trigger="change" class="form-control" id="new_password" maxlength="30" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่รหัสผ่านใหม่
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">ยืนยันรหัสผ่าน<span class="text-danger">*</span></label>
                                            <input type="password" name="confirm_password" parsley-trigger="change" class="form-control" id="confirm_password" maxlength="30" required />
                                            <div class="invalid-feedback">
                                                โปรดยืนยันรหัสผ่าน
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button class="btn btn-warning btn-sm waves-effect waves-light" type="submit" id="editbtn" name="editbtn"><i class="far fa-edit"></i> บันทึก</button>
                                            <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='index.php'">ย้อนกลับ</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                        <!-- end col -->
                        <!-- end col -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card card-draggable ui-sortable-handle">
                                        <img class="card-img-top img-fluid" src="../../../profile/<?php echo $stf_row_result['stf_profile']; ?>" style="max-width: 200px; max-height: 200px;" alt="Card image cap">
                                        <div class="card-body">
                                            <h4 class="card-title">รูปสมาชิก</h4>
                                        </div>
                                        <form action="staff_upload.php" method="post" enctype="multipart/form-data">
                                            <input type="text" hidden id="stf_id" name="stf_id" value="<?php echo $stf_row_result['stf_id'] ?>">
                                            <div class="mb-3">
                                                <label for="fileToUpload">เลือกรูปภาพที่ต้องการอัปโหลด:<span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" name="image" id="fileToUpload" accept="image/jpeg, image/png, image/gif">
                                            </div>
                                            <div class="text-end">
                                                <button class="btn btn-warning btn-sm waves-effect waves-light" value="อัปโหลดรูปภาพ" type="submit" id="submit" name="submit"><i class="far fa-edit"></i> บันทึก</button>
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
            <script>
                function validatePassword() {
                    var password = document.getElementById("new_password").value;

                   var pwd_alert = 'รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร, ตัวเลขอย่างน้อย 1 ตัว, ตัวอักษรตัวใหญ่อย่างน้อย 1 ตัว และ ตัวอักษรตัวเล็กอย่างน้อย 1 ตัว'

			// เช็คความยาวของรหัสผ่าน
			if (password.length < 8) {
				alert(pwd_alert);
				return false;
			}

			// เช็คว่ารหัสผ่านมีตัวเลขอย่างน้อยหนึ่งตัว
			if (!/\d/.test(password)) {
				alert(pwd_alert);
				return false;
			}

			// เช็คว่ารหัสผ่านมีตัวอักษรตัวใหญ่อย่างน้อยหนึ่งตัว
			if (!/[A-Z]/.test(password)) {
				alert(pwd_alert);
				return false;
			}

			// เช็คว่ารหัสผ่านมีตัวอักษรตัวเล็กอย่างน้อยหนึ่งตัว
			if (!/[a-z]/.test(password)) {
				alert(pwd_alert);
				return false;
			}
                    // ถ้าผ่านการตรวจสอบทั้งหมด
                    return true;
                }
            </script>
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