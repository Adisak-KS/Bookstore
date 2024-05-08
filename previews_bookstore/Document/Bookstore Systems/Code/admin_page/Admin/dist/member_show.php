<?php
require_once __DIR__ . '/../../../connection.php';
//session_start();


$sql_script = "SELECT * FROM bk_auth_member";
$mmb_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$mmb_row_result = mysqli_fetch_assoc($mmb_result);
$mmb_totalrows_result = mysqli_num_rows($mmb_result);

if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
    $status = $_SESSION['status'];
    $status_code = $_SESSION['status_code'];

    // เช็คว่ามีค่า upload_id ที่ส่งมาผ่าน URL
    if (isset($_GET['upload_id'])) {
        $upload_id = $_GET['upload_id'];

        // เพิ่มโค้ดที่ต้องการใช้งานกับค่า upload_id ได้ที่นี่
        // เช่น ใช้ $upload_id เพื่อดึงข้อมูลหรือประมวลผลต่อไป

        // เคลียร์ค่า session
        unset($_SESSION['status']);
        unset($_SESSION['status_code']);

        // แสดงหน้าต่างข้อความแจ้งเตือน
        echo "<script>alert('$status');</script>";
        echo "<script>window.location.href = '?upload_id=$upload_id';</script>";
        exit();
    }

    // เคลียร์ค่า session
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);

    // แสดงหน้าต่างข้อความแจ้งเตือน
    echo "<script>alert('$status');</script>";
    echo "<script>window.location.href = 'member_show.php';</script>";
    exit();
}

// ตรวจสอบสิทธิ์
if (!(isset($_SESSION['admin']) || isset($_SESSION['super_admin']))) {
    $_SESSION['status'] = "ไม่พบสิทธิ์การใช้งานในหน้านี้";
    $_SESSION['status_code'] = "ผิดพลาด";
    header('Location: login_form.php');
    exit;
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
                    <!-- ฟอร์มเพิ่มสมาชิก -->


                    <div class="modal fade" id="scrollable-modal" tabindex="-1" role="dialog" aria-labelledby="scrollableModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="scrollableModalTitle">เพิ่มสมาชิก</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- ฟอร์มเพิ่มสมาชิก -->

                                    <h4 class="header-title">เพิ่มสมาชิก</h4>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            var password = document.getElementById('mmb_password');
                                            var confirmPassword = document.getElementById('cpassword');
                                            var form = document.querySelector('.needs-validation');

                                            form.addEventListener('submit', function(event) {
                                                if (password.value !== confirmPassword.value) {
                                                    alert('รหัสผ่านและยืนยันรหัสผ่านไม่ตรงกัน');
                                                    event.preventDefault(); // ป้องกันฟอร์มจากการส่ง
                                                }
                                            });
                                        });
                                    </script>


                                    <form class="needs-validation" novalidate action="member_add.php" method="POST" onsubmit="return validatePassword()">
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">ชื่อผู้ใช้<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="mmb_username" name="mmb_username" placeholder="ชื่อผู้ใช้" minlength="6" maxlength="20" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่ชื่อผู้ใช้ให้ถูกต้อง
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">รหัสผ่าน<span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="mmb_password" name="mmb_password" placeholder="รหัสผ่าน" maxlength="20" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่รหัสผ่าน
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">ยืนยันรหัสผ่าน<span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="ยืนยันรหัสผ่าน" maxlength="20" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่ยืนยันรหัสผ่าน
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">ชื่อจริง<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="mmb_firstname" name="mmb_firstname" placeholder="ชื่อจริง" maxlength="20" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่ชื่อจริง
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">นามสกุล<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="mmb_lastname" name="mmb_lastname" placeholder="นามสกุล" maxlength="30" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่นามสกุล
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">อีเมล<span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="mmb_email" name="mmb_email" placeholder="อีเมล" maxlength="40" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่อีเมล
                                            </div>
                                        </div>

                                </div>
                                <div class="modal-footer">

                                    <button type="submit" id="addbtn" name="addbtn" class="btn btn-success waves-effect waves-light"><i class="dripicons-checkmark"></i> บันทึก</button>
                                    </form>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="dripicons-cross"></i> ปิด</button>
                                    <!-- <button type="button" class="btn btn-primary">บันทึก</button> -->
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mt-0 header-title">รายการสมาชิก</h4>
                                    <br>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#scrollable-modal" class="btn btn-success waves-effect waves-light"><i class="far fa-plus-square"></i> เพิ่มสมาชิก</button>
                                    <br><br>

                                    <?php
                                    if ($mmb_row_result > 0) {

                                    ?>
                                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline">
                                            <thead>
                                                <tr>
                                                    <th>รูป</th>
                                                    <th>ชื่อผู้ใช้</th>
                                                    <th>ชื่อจริง</th>
                                                    <th>นามมสกุล</th>
                                                    <th>อีเมล</th>
                                                    <th></th>
                                                    <th></th>
                                                    <th></th>
                                                </tr>
                                            </thead>


                                            <tbody>

                                                <?php
                                                do {
                                                ?>
                                                    <tr>
                                                        <!-- ส่วนแสดงข้อมูลสมาชิก -->
                                                        <td><a href="../../../profile/<?php echo $mmb_row_result['mmb_profile']; ?>" target="_blank"><img src="../../../profile/<?php echo $mmb_row_result['mmb_profile']; ?>" style="max-height: 50px; max-width: 50px"></a></td>
                                                        <td><?php echo $mmb_row_result['mmb_username']; ?></td>
                                                        <td><?php echo $mmb_row_result['mmb_firstname']; ?></td>
                                                        <td><?php echo $mmb_row_result['mmb_lastname']; ?></td>
                                                        <td><?php echo $mmb_row_result['mmb_email']; ?></td>
                                                        <td>
                                                            <!-- ปุ่มแก้ไข -->
                                                            <div class="button-list">
                                                                <form action="member_show_form.php" method="post">
                                                                    <input type="hidden" name="edit_id" value="<?php echo $mmb_row_result['mmb_id']; ?>">
                                                                    <button type="submit" name="edit_btn" class="btn btn-info btn-sm waves-effect waves-light"><i class="fe-eye"></i> รายละเอียด</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <!-- ปุ่มแก้ไข -->
                                                            <div class="button-list">
                                                                <form action="member_edit_form.php" method="post">
                                                                    <input type="hidden" name="edit_id" value="<?php echo $mmb_row_result['mmb_id']; ?>">
                                                                    <button type="submit" name="edit_btn" class="btn btn-warning btn-sm waves-effect waves-light"><i class="far fa-edit"></i> แก้ไข</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <!-- ปุ่มลบ -->
                                                            <div class="button-list">
                                                                <form action="member_delete_form.php" method="post">
                                                                    <input type="hidden" name="edit_id" value="<?php echo $mmb_row_result['mmb_id']; ?>">
                                                                    <button type="submit" name="delete_btn" class="btn btn-danger btn-sm waves-effect waves-light"><i class="mdi mdi-delete"></i> ลบ</button>
                                                                </form>
                                                            </div>
                                                        </td>


                                                    </tr>
                                                    <div class="modal fade" id="scrollable-modal" tabindex="-1" role="dialog" aria-labelledby="scrollableModalTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="scrollableModalTitle">แก้ไขสิทธิ์สมาชิก</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- ฟอร์มแก้ไขสิทธิ์ -->

                                                                    <h4 class="header-title">เพิ่มสมาชิก</h4>

                                                                    <form class="needs-validation" novalidate action="member_add.php" method="POST">
                                                                        <div class="mb-3">
                                                                            <label for="validationCustom01" class="form-label">ชื่อผู้ใช้<span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control" id="mmb_username" name="mmb_username" readonly value="<?php echo $mmb_row_result['mmb_username']; ?>" />
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="validationCustom01" class="form-label">ชื่อจริง<span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control" id="mmb_firstname" name="mmb_firstname" readonly value="<?php echo $mmb_row_result['mmb_firstname']; ?>" />
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="validationCustom01" class="form-label">นามสกุล<span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control" id="mmb_lastname" name="mmb_lastname" readonly value="<?php echo $mmb_row_result['mmb_lastname']; ?>" />
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="validationCustom01" class="form-label">อีเมล<span class="text-danger">*</span></label>
                                                                            <input type="email" class="form-control" id="mmb_email" name="mmb_email" readonly value="<?php echo $mmb_row_result['mmb_email']; ?>" />
                                                                        </div>
                                                                        <button class="btn btn-warning" type="submit" id="editbtn" name="editbtn">บันทึก</button>
                                                                    </form>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                                                    <!-- <button type="button" class="btn btn-primary">บันทึก</button> -->
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->


                                                <?php
                                                } while ($mmb_row_result = mysqli_fetch_assoc($mmb_result));
                                                ?>
                                            </tbody>
                                        </table>
                                    <?php
                                    } else {
                                        echo 'ไม่พบข้อมูล';
                                    }
                                    ?>
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
                    var password = document.getElementById("stf_password").value;

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