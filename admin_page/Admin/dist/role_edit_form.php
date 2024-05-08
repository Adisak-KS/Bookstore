<?php
require_once __DIR__ . '/../../../connection.php';

// ตรวจสอบสิทธิ์
if (!(isset($_SESSION['admin']) || isset($_SESSION['super_admin']))) {
    $_SESSION['status'] = "ไม่พบสิทธิ์การใช้งานในหน้านี้";
    $_SESSION['status_code'] = "ผิดพลาด";
    header('Location: login_form.php');
    exit;
}


// ตัวแปร location
if (isset($_SESSION['admin'])) {
    $location = 'staff_show.php';
} elseif (isset($_SESSION['super_admin'])) {
    $location = 'admin_show.php';
}

// ตรวจสอบว่ามีค่า 'stf_id' ที่ถูกส่งมาใน URL หรือไม่
if (isset($_POST['stf_id'])) {
    $stf_id = $_POST['stf_id'];
    unset($_SESSION['stf_id']);
    $_SESSION['stf_id'] = $stf_id;
} elseif (isset($_SESSION['stf_id'])) {
    $stf_id = $_SESSION['stf_id'];
} else {
    echo "<script>alert('ผิดพลาด ไม่พบรหัสผู้ใช้งาน'); window.location='staff_show.php';</script>";
    exit;
}

$sql_script = "SELECT * FROM bk_auth_staff WHERE stf_id = '$stf_id'";
$stf_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$stf_row_result = mysqli_fetch_assoc($stf_result);

// ตรวจสอบสิทธิ์
if (!(isset($_SESSION['admin']) || isset($_SESSION['super_admin']))) {
    $_SESSION['status'] = "ไม่พบสิทธิ์การใช้งานในหน้านี้";
    $_SESSION['status_code'] = "ผิดพลาด";
    header('Location: login_form.php');
    exit;
}


if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
    $status = $_SESSION['status'];
    $status_code = $_SESSION['status_code'];

    // เคลียร์ค่า session
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);

    $_SESSION['stf_id'] = $stf_id;
    // แสดงหน้าต่างข้อความแจ้งเตือน
    echo "<script>alert('$status');</script>";
    echo "<script>window.location.href = 'role_edit_form.php';</script>";
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

                    <?php
                    // ตรวจสอบสิทธิ์ Admin
                    $sql_admin = "SELECT * FROM bk_auth_admin";
                    $result_admin = mysqli_query($proj_connect, $sql_admin);

                    // ทำการตรวจสอบแต่ละแถวในตาราง bk_auth_admin
                    $admin_checked = false;
                    $adm_id = 'n';
                    while ($admin_row = mysqli_fetch_assoc($result_admin)) {
                        // ใช้ password_verify เพื่อตรวจสอบถูกต้องของ stf_id
                        if (base64_encode($stf_id) == $admin_row['stf_id']) {
                            // ตรวจสอบสิทธิ์ Sale ที่ตรงกับ $stf_id ที่ถูกต้อง
                            $admin_checked = true;
                            $adm_id = $admin_row['adm_id'];
                            break; // พบ stf_id ที่ตรงกัน ออกจากลูป
                        }
                    }

                    // ตรวจสอบสิทธิ์ Sale
                    $sql_sale = "SELECT * FROM bk_auth_sale";
                    $result_sale = mysqli_query($proj_connect, $sql_sale);

                    // ทำการตรวจสอบแต่ละแถวในตาราง bk_auth_sale
                    $sale_checked = false;
                    $sle_id = 'n';
                    while ($sale_row = mysqli_fetch_assoc($result_sale)) {
                        // ใช้ password_verify เพื่อตรวจสอบถูกต้องของ stf_id
                        if (base64_encode($stf_id) == $sale_row['stf_id']) {
                            // ตรวจสอบสิทธิ์ Sale ที่ตรงกับ $stf_id ที่ถูกต้อง
                            $sale_checked = true;
                            $sle_id = $sale_row['sle_id'];
                            break; // พบ stf_id ที่ตรงกัน ออกจากลูป
                        }
                    }


                    // ดึงข้อมูล Role ของ Admin
                    //$admin_checked = mysqli_num_rows($result_admin) > 0;

                    // ดึงข้อมูล Role ของ Sale
                    //$sale_checked = mysqli_num_rows($result_sale) > 0;

                    if ($admin_checked) {
                        $role_name = 'ผู้ดูแลระบบ';
                    } elseif ($sale_checked) {
                        $role_name = 'พนักงานขาย';
                    } else {
                        $role_name = 'ทีมงาน';
                    }
                    ?>
                    <div class="row">
                        <div class="col-lg-6">

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">ข้อมูล<?= $role_name ?></h4>
                                    <?php
                                    if (isset($_SESSION['super_admin']) || (isset($_SESSION['admin']) && $admin_checked == false)) {
                                    ?>
                                        <form action="staff_edit.php" class="parsley-examples needs-validation" novalidate method="POST">
                                            <div class="mb-3">
                                                <input type="text" name="stf_id" parsley-trigger="change" hidden class="form-control" id="stf_id" value="<?php echo $stf_row_result['stf_id'] ?>" />
                                            </div>
                                            <div class="mb-3">
                                                <label for="userName" class="form-label">ชื่อผู้ใช้</label>
                                                <input type="text" name="stf_username" readonly parsley-trigger="change" minlength="6" maxlength="50" required class="form-control" id="stf_username" value="<?php echo $stf_row_result['stf_username'] ?>" />
                                                <div class="invalid-feedback">
                                                    โปรดใส่ชื่อผู้ใช้ให้ถูกต้อง
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="userName" class="form-label">อีเมล<span class="text-danger">*</span></label>
                                                <input type="text" name="stf_email" parsley-trigger="change" maxlength="50" required class="form-control" id="stf_email" value="<?php echo $stf_row_result['stf_email'] ?>" />
                                                <div class="invalid-feedback">
                                                    โปรดใส่อีเมล
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="userName" class="form-label">ชื่อจริง<span class="text-danger">*</span></label>
                                                <input type="text" name="stf_firstname" parsley-trigger="change" maxlength="50" required class="form-control" id="stf_firstname" value="<?php echo $stf_row_result['stf_firstname'] ?>" />
                                                <div class="invalid-feedback">
                                                    โปรดใส่ชื่อจริง
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="userName" class="form-label">นามสกุล<span class="text-danger">*</span></label>
                                                <input type="text" name="stf_lastname" parsley-trigger="change" maxlength="50" required class="form-control" id="stf_lastname" value="<?php echo $stf_row_result['stf_lastname'] ?>" />
                                                <div class="invalid-feedback">
                                                    โปรดใส่นามสกุล
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" id="editbtn" name="editbtn" class="btn btn-warning btn-sm waves-effect waves-light"><i class="far fa-edit"></i> บันทึก</button>
                                                <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='<?= $location ?>'">ย้อนกลับ</button>
                                            </div>
                                        </form>
                                    <?php
                                    } elseif (isset($_SESSION['admin']) && $admin_checked == true) {

                                    ?>
                                        <form action="staff_edit.php" class="parsley-examples needs-validation" novalidate method="POST">
                                            <div class="mb-3">
                                                <input type="text" name="stf_id" parsley-trigger="change" hidden class="form-control" id="stf_id" value="<?php echo $stf_row_result['stf_id'] ?>" />
                                            </div>
                                            <div class="mb-3">
                                                <label for="userName" class="form-label"><h5>ชื่อผู้ใช้</h5></label>
                                                <input type="text" name="stf_username" parsley-trigger="change" minlength="6" maxlength="50" required readonly class="form-control-plaintext" id="stf_username" value="<?php echo $stf_row_result['stf_username'] ?>" />
                                                <div class="invalid-feedback">
                                                    โปรดใส่ชื่อผู้ใช้ให้ถูกต้อง
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="userName" class="form-label"><h5>อีเมล</h5></label>
                                                <input type="text" name="stf_email" parsley-trigger="change" maxlength="50" required readonly class="form-control-plaintext" id="stf_email" value="<?php echo $stf_row_result['stf_email'] ?>" />
                                                <div class="invalid-feedback">
                                                    โปรดใส่อีเมล
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="userName" class="form-label"><h5>ชื่อจริง</h5></label>
                                                <input type="text" name="stf_firstname" parsley-trigger="change" maxlength="50" required readonly class="form-control-plaintext" id="stf_firstname" value="<?php echo $stf_row_result['stf_firstname'] ?>" />
                                                <div class="invalid-feedback">
                                                    โปรดใส่ชื่อจริง
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="userName" class="form-label"><h5>นามสกุล</h5></label>
                                                <input type="text" name="stf_lastname" parsley-trigger="change" maxlength="50" required readonly class="form-control-plaintext" id="stf_lastname" value="<?php echo $stf_row_result['stf_lastname'] ?>" />
                                                <div class="invalid-feedback">
                                                    โปรดใส่นามสกุล
                                                </div>
                                            </div>
                                            <div class="text-end">
                                                <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='<?= $location ?>'">ย้อนกลับ</button>
                                            </div>
                                        </form>
                                    <?php
                                    } else {
                                    ?>
                                        <form action="#" class="parsley-examples">
                                            <div class="mb-3">
                                                <label for="userName" class="form-label">ไอดี</label>
                                                <input type="text" name="stf_id" parsley-trigger="change" readonly class="form-control" id="stf_id" value="<?php echo $stf_row_result['stf_id'] ?>" />
                                            </div>
                                            <div class="mb-3">
                                                <label for="userName" class="form-label">ชื่อผู้ใช้</label>
                                                <input type="text" name="stf_username" parsley-trigger="change" readonly required class="form-control" id="stf_username" value="<?php echo $stf_row_result['stf_username'] ?>" />
                                            </div>
                                            <div class="mb-3">
                                                <label for="userName" class="form-label">อีเมล</label>
                                                <input type="text" name="stf_firstname" parsley-trigger="change" readonly required class="form-control" id="stf_firstname" value="<?php echo $stf_row_result['stf_email'] ?>" />
                                            </div>
                                            <div class="mb-3">
                                                <label for="userName" class="form-label">ชื่อจริง</label>
                                                <input type="text" name="stf_lastname" parsley-trigger="change" readonly required class="form-control" id="stf_lastname" value="<?php echo $stf_row_result['stf_firstname'] ?>" />
                                            </div>
                                            <div class="mb-3">
                                                <label for="userName" class="form-label">นามสกุล</label>
                                                <input type="text" name="surname" parsley-trigger="change" readonly required class="form-control" id="surname" value="<?php echo $stf_row_result['stf_lastname'] ?>" />
                                            </div>
                                        </form>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div> <!-- end card -->
                        </div>
                        <!-- end col -->

                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">ตำแหน่ง</h4>
                                    <!-- เลือกช่องที่มี stf_id อยู่ในตาราง staff -->


                                    <?php
                                    if (isset($_SESSION['admin'])) {
                                    ?>
                                        <form action="role_edit.php" method="POST">
                                            <input hidden type="text" name="stf_id" id="stf_id" value="<?php echo $stf_row_result['stf_id'] ?>">
                                            <input hidden type="text" name="sle_id" id="sle_id" value="<?php echo $sle_id ?>">

                                            <div class="form-check mb-2 form-check-primary">
                                                <input class="form-check-input" type="checkbox" value="sale" id="sale" name="sale" <?php if ($sale_checked) echo 'checked';
                                                                                                                                    if ($admin_checked) {
                                                                                                                                        echo ' disabled';
                                                                                                                                    }
                                                                                                                                    ?>>

                                                <label class="form-check-label" for="sale">Sale (พนักงานขาย)</label>
                                            </div>
                                            <!-- <input class="form-check-input" type="checkbox" checked disabled> -->
                                            <?php
                                            //if ($admin_checked) {
                                            ?>
                                                <!-- <i class="fas fa-users-cog"></i>
                                                <label class="form-check-label" for="sale">Admin (ผู้ดูแลระบบ)</label>
                                                <br> -->
                                            <?php
                                            //}
                                            ?>
                                            <i class="mdi mdi-account-multiple-outline"></i>
                                            <label class="form-check-label" for="sale">Staff (สิทธิ์พื้นฐาน)</label>

                                            <?php
                                            if (!$admin_checked) {
                                            ?>
                                                <div class="text-end">
                                                    <button type="submit" id="editbtn" name="editbtn" class="btn btn-warning btn-sm waves-effect waves-light"><i class="far fa-edit"></i> บันทึก</button>
                                                </div>
                                            <?php
                                            }
                                            ?>
                                        </form>

                                    <?php
                                    } elseif (isset($_SESSION['super_admin'])) {
                                    ?>
                                        <form action="role_edit.php" method="POST">
                                            <input hidden type="text" name="stf_id" id="stf_id" value="<?php echo $stf_row_result['stf_id'] ?>">
                                            <i class="fas fa-users-cog"></i>
                                            <label class="form-check-label" for="admin">Admin (ผู้ดูแลระบบ)</label>
                                        </form>
                                    <?php
                                    }
                                    ?>
                                </div>
                            </div> <!-- end card -->

                            <!-- active -->
                            <?php
                            if (isset($_SESSION['admin']) && $admin_checked) {
                            ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">สถานะ</h4>


                                        <form action="active_edit.php" method="POST">
                                            <input hidden type="text" name="stf_id" id="stf_id" value="<?php echo $stf_row_result['stf_id'] ?>">

                                            <div class="form-check mb-2 form-check-success">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="customradio2" value="1" <?php if ($stf_row_result['stf_active'] == 1) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    }
                                                                                                                                                    if (isset($_SESSION['admin']) && $admin_checked) {
                                                                                                                                                        echo ' disabled';
                                                                                                                                                    }
                                                                                                                                                    ?>>
                                                <label class="form-check-label" for="customradio2">Active</label>
                                            </div>
                                            <div class="form-check mb-2 form-check-danger">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="customradio4" value="0" <?php if ($stf_row_result['stf_active'] == 0) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    }
                                                                                                                                                    if (isset($_SESSION['admin']) && $admin_checked) {
                                                                                                                                                        echo ' disabled';
                                                                                                                                                    } ?>>
                                                <label class="form-check-label" for="customradio4">Block</label>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php
                            } else {
                            ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title">สถานะ</h4>


                                        <form action="active_edit.php" method="POST">
                                            <input hidden type="text" name="stf_id" id="stf_id" value="<?php echo $stf_row_result['stf_id'] ?>">

                                            <div class="form-check mb-2 form-check-success">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="customradio2" value="1" <?php if ($stf_row_result['stf_active'] == 1) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    }
                                                                                                                                                    if (isset($_SESSION['admin']) && $admin_checked) {
                                                                                                                                                        echo ' disabled';
                                                                                                                                                    }
                                                                                                                                                    ?>>
                                                <label class="form-check-label" for="customradio2">Active</label>
                                            </div>
                                            <div class="form-check mb-2 form-check-danger">
                                                <input class="form-check-input" type="radio" name="flexRadioDefault" id="customradio4" value="0" <?php if ($stf_row_result['stf_active'] == 0) {
                                                                                                                                                        echo 'checked';
                                                                                                                                                    }
                                                                                                                                                    if (isset($_SESSION['admin']) && $admin_checked) {
                                                                                                                                                        echo ' disabled';
                                                                                                                                                    } ?>>
                                                <label class="form-check-label" for="customradio4">Block</label>
                                            </div>
                                            <div class="text-end">
                                                <button type="submit" id="editbtn" name="editbtn" class="btn btn-warning btn-sm waves-effect waves-light"><i class="far fa-edit"></i> บันทึก</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            <?php
                            }
                            ?>
                            <!-- end card -->
                        </div> <!-- end col -->
                    </div> <!-- end row -->

                    <!-- ลบข้อมูลทีมงาน -->
                    <?php
                    if ((isset($_SESSION['super_admin'])) || (!$admin_checked)) {
                    ?>
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">ลบข้อมูลทีมงาน</h4>
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
                                                        <h4 class="mt-2 text-white">ลบข้อมูลทีมงาน</h4>
                                                        <p class="mt-3 text-white">คุณแน่ใจว่าจะลบข้อมูลทีมงานคนนี้ ?</p>
                                                        <form action="staff_delete.php" method="POST">
                                                            <input type="text" value="<?php echo $stf_row_result['stf_id'] ?>" hidden name="stf_id" id="stf_id">
                                                            <button type="submit" class="btn btn-light my-2" data-bs-dismiss="modal" name="delbtn" id="delbtn">แน่ใจ</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div><!-- /.modal-content -->
                                        </div><!-- /.modal-dialog -->
                                    </div><!-- /.modal -->

                                    <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#danger-alert-modal"><i class="mdi mdi-delete"></i> ลบข้อมูล</button>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

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