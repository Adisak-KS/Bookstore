<?php
require_once __DIR__ . '/../../../connection.php';
//session_start();


$sql_script = "SELECT * FROM bk_province";
$prov_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$prov_row_result = mysqli_fetch_assoc($prov_result);
$prov_totalrows_result = mysqli_num_rows($prov_result);

if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
    $status = $_SESSION['status'];
    $status_code = $_SESSION['status_code'];


    // เคลียร์ค่า session
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);

    // แสดงหน้าต่างข้อความแจ้งเตือน
    echo "<script>alert('$status');</script>";
    echo "<script>window.location.href = 'province_show.php';</script>";
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
                    <!-- ฟอร์มเพิ่มจังหวัด -->


                    <div class="modal fade" id="scrollable-modal" tabindex="-1" role="dialog" aria-labelledby="scrollableModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="scrollableModalTitle">เพิ่มจังหวัด</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- ฟอร์มเพิ่มจังหวัด -->

                                    <h4 class="header-title">เพิ่มจังหวัด</h4>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            var password = document.getElementById('prov_password');
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


                                    <form class="needs-validation" novalidate action="province_add.php" method="POST">
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">ชื่อจังหวัด<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="prov_name" name="prov_name" placeholder="ชื่อจังหวัด" maxlength="30" required />
                                        </div>
                                            <div class="invalid-feedback">
                                                โปรดใส่ชื่อจังหวัด
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
                                    <h4 class="mt-0 header-title">รายการจังหวัด</h4>
                                    <br>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#scrollable-modal" class="btn btn-success waves-effect waves-light"><i class="far fa-plus-square"></i> เพิ่มจังหวัด</button>
                                    <br><br>

                                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline">
                                        <thead>
                                            <tr>
                                                <th>ชื่อจังหวัด</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>


                                        <tbody>

                                            <?php
                                            do {
                                            ?>
                                                <tr>
                                                    <!-- ส่วนแสดงข้อมูลจังหวัด -->
                                                    <td><?php echo $prov_row_result['prov_name']; ?></td>
                                                    <td>
                                                        <!-- ปุ่มแก้ไข -->
                                                        <div class="button-list">
                                                            <form action="province_edit_form.php" method="post">
                                                                <input type="hidden" name="edit_id" value="<?php echo $prov_row_result['prov_id']; ?>">
                                                                <button type="submit" name="edit_btn" class="btn btn-warning btn-sm waves-effect waves-light"><i class="far fa-edit"></i> แก้ไข</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- ปุ่มลบ -->
                                                        <div class="button-list">
                                                            <form action="province_delete_form.php" method="post">
                                                                <input type="hidden" name="edit_id" value="<?php echo $prov_row_result['prov_id']; ?>">
                                                                <button type="submit" name="delete_btn" class="btn btn-danger btn-sm waves-effect waves-light"><i class="mdi mdi-delete"></i> ลบ</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php
                                            } while ($prov_row_result = mysqli_fetch_assoc($prov_result));
                                            ?>
                                        </tbody>
                                    </table>
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