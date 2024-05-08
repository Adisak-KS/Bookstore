<?php
require_once __DIR__ . '/../../../connection.php';

$sql_script = "SELECT stf_id FROM bk_auth_admin";
$adm_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());

$decoded_stf_ids = array();

while ($adm_row_result = mysqli_fetch_assoc($adm_result)) {
    $decoded_stf_id = base64_decode($adm_row_result['stf_id']);
    $decoded_stf_ids[] = $decoded_stf_id;
}

// นำรหัสที่ถูกถอดรหัสไปใช้ใน SQL query
$in_clause = "'" . implode("','", $decoded_stf_ids) . "'";
$sql_script = "SELECT * FROM bk_auth_staff
               WHERE stf_id IN ($in_clause)";

$stf_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$stf_row_result = mysqli_fetch_assoc($stf_result);
$stf_totalrows_result = mysqli_num_rows($stf_result);

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
    echo "<script>window.location.href = 'admin_show.php';</script>";
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
                                    <h5 class="modal-title" id="scrollableModalTitle">เพิ่มผู้ดูแลระบบ</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- ฟอร์มเพิ่มผู้ดูแล -->

                                    <h4 class="header-title">เพิ่มผู้ดูแลระบบ</h4>
                                    <p class="sub-header"></p>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            var password = document.getElementById('stf_password');
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


                                    <form class="needs-validation" novalidate action="admin_add.php" method="POST" onsubmit="return validatePassword()">
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">ชื่อผู้ใช้ <span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="stf_username" name="stf_username" placeholder="ชื่อผู้ใช้" minlength="6" maxlength="20" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่ชื่อผู้ใช้ให้ถูกต้อง
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">รหัสผ่าน<span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="stf_password" name="stf_password" placeholder="รหัสผ่าน" maxlength="20" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่รหัสผ่าน
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">ยืนยันรหัสผ่าน<span class="text-danger">*</span></label>
                                            <input type="password" class="form-control" id="cpassword" name="cpassword" placeholder="ยืนยันรหัสผ่าน" maxlength="20" required />
                                            <div class="invalid-feedback">
                                                โปรดยืนยันรหัสผ่าน
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">ชื่อจริง<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="stf_firstname" name="stf_firstname" placeholder="ชื่อจริง" maxlength="20" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่ชื่อชื่อจริง
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">นามสกุล<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="stf_lastname" name="stf_lastname" placeholder="นามสกุล" maxlength="30" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่ชื่อนามสกุล
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">อีเมล<span class="text-danger">*</span></label>
                                            <input type="email" class="form-control" id="stf_email" name="stf_email" placeholder="อีเมล" maxlength="40" required />
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
                                    <h4 class="mt-0 header-title">รายการผู้ดูแลระบบ</h4>
                                    <br>
                                    <button type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#scrollable-modal"><i class="far fa-plus-square"></i> เพิ่มผู้ดูแลระบบ</button>
                                    <br><br>
                                    <?php
                                    if ($stf_row_result > 0) {
                                    ?>
                                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline">
                                            <thead>
                                                <tr>
                                                    <th>รูป</th>
                                                    <th>ชื่อผู้ใช้</th>
                                                    <th>ชื่อจริง</th>
                                                    <th>นามมสกุล</th>
                                                    <th>อีเมล</th>
                                                    <th>ตำแหน่ง</th>
                                                    <th>สถานะ</th>
                                                    <th></th>
                                                </tr>
                                            </thead>


                                            <tbody>

                                                <?php
                                                do {
                                                ?>
                                                    <tr>
                                                        <!-- ส่วนแสดงข้อมูลสมาชิก -->
                                                        <td><a href="../../../profile/<?php echo $stf_row_result['stf_profile']; ?>" target="_blank"><img src="../../../profile/<?php echo $stf_row_result['stf_profile']; ?>" style="max-height: 50px; max-width: 50px"></a></td>
                                                        <td><?php echo $stf_row_result['stf_username']; ?></td>
                                                        <td><?php echo $stf_row_result['stf_firstname']; ?></td>
                                                        <td><?php echo $stf_row_result['stf_lastname']; ?></td>
                                                        <td><?php echo $stf_row_result['stf_email']; ?></td>
                                                        <td>
                                                            <?php
                                                            $stf_id = $stf_row_result['stf_id'];
                                                            $sql_super_admin = "SELECT * FROM bk_auth_super_admin WHERE stf_id = '$stf_id'";
                                                            $sql_admin = "SELECT * FROM bk_auth_admin";
                                                            $sql_sale = "SELECT * FROM bk_auth_sale";

                                                            $super_admin_result = mysqli_query($proj_connect, $sql_super_admin);
                                                            $admin_result = mysqli_query($proj_connect, $sql_admin);
                                                            $sale_result = mysqli_query($proj_connect, $sql_sale);

                                                            if (mysqli_num_rows($super_admin_result) > 0) {
                                                                echo 'Super Admin<br>';
                                                            }

                                                            while ($admin_row = mysqli_fetch_assoc($admin_result)) {
                                                                // ใช้ password_verify เพื่อตรวจสอบถูกต้องของ stf_id
                                                                if ($stf_row_result['stf_id'] == base64_decode($admin_row['stf_id'])) {
                                                                    // ตรวจสอบสิทธิ์ Admin ที่ตรงกับ $stf_id ที่ถูกต้อง
                                                                    echo 'Admin<br>';
                                                                    break; // พบ stf_id ที่ตรงกัน ออกจากลูป
                                                                }
                                                            }
                                                            while ($sale_row = mysqli_fetch_assoc($sale_result)) {
                                                                // ใช้ password_verify เพื่อตรวจสอบถูกต้องของ stf_id
                                                                if ($stf_row_result['stf_id'] == base64_decode($sale_row['stf_id'])) {
                                                                    // ตรวจสอบสิทธิ์ Sale ที่ตรงกับ $stf_id ที่ถูกต้อง
                                                                    echo 'Sale<br>';
                                                                    break; // พบ stf_id ที่ตรงกัน ออกจากลูป
                                                                }
                                                            }
                                                            ?>

                                                        </td>
                                                        <td>
                                                            <?php
                                                            if ($stf_row_result['stf_active'] == 0) {
                                                                echo 'blocked';
                                                            } else {
                                                                echo 'active';
                                                            }
                                                            ?>
                                                        </td>
                                                        <td>
                                                            <!-- ปุ่มแก้ไข -->
                                                            <form action="role_edit_form.php" method="POST">
                                                                <input type="text" class="form-control" id="stf_id" name="stf_id" hidden value="<?php echo $stf_row_result['stf_id']; ?>" />
                                                                <input type="text" class="form-control" id="stf_id" name="stf_id" hidden value="<?php echo $stf_row_result['stf_id']; ?>" />
                                                                <button type="submit" name="editbtn" id="editbtn" <?php if (mysqli_num_rows($super_admin_result) > 0) {
                                                                                                                        echo 'disabled';
                                                                                                                    } ?> class="btn btn-warning btn-sm waves-effect waves-light"><i class="far fa-edit"></i> แก้ไขสิทธิ์</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                    <div class="modal fade" id="scrollable-modal" tabindex="-1" role="dialog" aria-labelledby="scrollableModalTitle" aria-hidden="true">
                                                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="scrollableModalTitle">แก้ไขสิทธิ์ทีมงาน</h5>
                                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                                </div>
                                                                <div class="modal-body">
                                                                    <!-- ฟอร์มแก้ไขสิทธิ์ -->

                                                                    <h4 class="header-title">เพิ่มทีมงาน</h4>
                                                                    <p class="sub-header">...</p>

                                                                    <form class="needs-validation" novalidate action="product_add.php" method="POST">
                                                                        <div class="mb-3">
                                                                            <label for="validationCustom01" class="form-label">ชื่อผู้ใช้<span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control" id="stf_username" name="stf_username" readonly value="<?php echo $stf_row_result['stf_username']; ?>" />
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="validationCustom01" class="form-label">ชื่อจริง<span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control" id="stf_firstname" name="stf_firstname" readonly value="<?php echo $stf_row_result['stf_firstname']; ?>" />
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="validationCustom01" class="form-label">นามสกุล<span class="text-danger">*</span></label>
                                                                            <input type="text" class="form-control" id="stf_lastname" name="stf_lastname" readonly value="<?php echo $stf_row_result['stf_lastname']; ?>" />
                                                                        </div>
                                                                        <div class="mb-3">
                                                                            <label for="validationCustom01" class="form-label">อีเมล<span class="text-danger">*</span></label>
                                                                            <input type="email" class="form-control" id="stf_email" name="stf_email" readonly value="<?php echo $stf_row_result['stf_email']; ?>" />
                                                                        </div>
                                                                        <button class="btn btn-success waves-effect waves-light" type="submit" id="editbtn" name="editbtn"><i class="dripicons-checkmark"></i> บันทึก</button>
                                                                    </form>

                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="button" data-bs-dismiss="modal" class="btn btn-secondary"><i class="dripicons-cross"></i> ปิด</button>
                                                                </div>
                                                            </div><!-- /.modal-content -->
                                                        </div><!-- /.modal-dialog -->
                                                    </div><!-- /.modal -->


                                                <?php
                                                } while ($stf_row_result = mysqli_fetch_assoc($stf_result));
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
    <script>
        function validatePassword() {
            var password = document.getElementById("stf_password").value;

            // เช็คความยาวของรหัสผ่าน
            if (password.length < 8) {
                alert("รหัสผ่านต้องมีความยาวอย่างน้อย 8 ตัวอักษร");
                return false;
            }

            // เช็คว่ารหัสผ่านมีตัวเลขอย่างน้อยหนึ่งตัว
            if (!/\d/.test(password)) {
                alert("รหัสผ่านต้องประกอบด้วยตัวเลขอย่างน้อย 1 ตัว");
                return false;
            }

            // เช็คว่ารหัสผ่านมีตัวอักษรตัวใหญ่อย่างน้อยหนึ่งตัว
            if (!/[A-Z]/.test(password)) {
                alert("รหัสผ่านต้องประกอบด้วยตัวอักษรตัวใหญ่อย่างน้อย 1 ตัว");
                return false;
            }

            // เช็คว่ารหัสผ่านมีตัวอักษรตัวเล็กอย่างน้อยหนึ่งตัว
            if (!/[a-z]/.test(password)) {
                alert("รหัสผ่านต้องประกอบด้วยตัวอักษรตัวเล็กอย่างน้อย 1 ตัว");
                return false;
            }

            // ถ้าผ่านการตรวจสอบทั้งหมด
            return true;
        }
    </script>



</body>

</html>