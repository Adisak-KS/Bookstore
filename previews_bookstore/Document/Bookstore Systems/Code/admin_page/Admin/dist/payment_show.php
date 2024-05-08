<?php
require_once __DIR__ . '/../../../connection.php';
//session_start();


$sql_script = "SELECT * FROM bk_ord_payment";
$pay_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$pay_row_result = mysqli_fetch_assoc($pay_result);
$pay_totalrows_result = mysqli_num_rows($pay_result);

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
    echo "<script>window.location.href = 'payment_show.php';</script>";
    exit();
}

// ตรวจสอบสิทธิ์
if (!(isset($_SESSION['admin']) || isset($_SESSION['super_admin']))) {
    $_SESSION['status'] = "ไม่พบสิทธิ์การใช้งานในหน้านี้";
    $_SESSION['status_code'] = "ผิดพลาด";
    header('Location: login_form.php');
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
                    <!-- ฟอร์มเพิ่มช่องทางชำระเงิน -->


                    <div class="modal fade" id="scrollable-modal" tabindex="-1" role="dialog" aria-labelledby="scrollableModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="scrollableModalTitle">เพิ่มช่องทางชำระเงิน</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- ฟอร์มเพิ่มช่องทางชำระเงิน -->

                                    <h4 class="header-title">เพิ่มช่องทางชำระเงิน</h4>
                                    <script>
                                        document.addEventListener('DOMContentLoaded', function() {
                                            var password = document.getElementById('pay_password');
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


                                    <form class="needs-validation" novalidate action="payment_add.php" method="POST" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">ชื่อช่องทางชำระเงิน<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="pay_name" name="pay_name" placeholder="ชื่อช่องทางชำระเงิน" maxlength="30" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่ชื่อช่องทางชำระเงิน
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">รายละเอียด<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="pay_detail" name="pay_detail" placeholder="รายละเอียด" maxlength="50" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่รายละเอียด
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fileToUpload">โลโก้ช่องทางชำระเงิน:<span class="text-danger">*</span></label>
                                            <input type="file" class="form-control" name="pay_logo" id="pay_logo" accept="image/jpeg, image/png, image/gif" required>
                                            <div class="invalid-feedback">
                                                โปรดใส่โลโก้ช่องทางชำระเงิน
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="fileToUpload">รูปภาพช่องทางชำระเงิน:<span class="text-danger">*</span></label>
                                            <input type="file" class="form-control" name="pay_img" id="pay_img" accept="image/jpeg, image/png, image/gif" required>
                                            <div class="invalid-feedback">
                                                โปรดใส่รูปภาพช่องทางชำระเงิน
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
                                    <h4 class="mt-0 header-title">รายการช่องทางชำระเงิน</h4>
                                    <br>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#scrollable-modal" class="btn btn-success waves-effect waves-light"><i class="far fa-plus-square"></i> เพิ่มช่องทางชำระเงิน</button>
                                    <br><br>
                                    <?php
                                    if ($pay_row_result > 0) {
                                    ?>
                                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline">
                                            <thead>
                                                <tr>
                                                    <th>ช่องทางชำระ</th>
                                                    <th>รายละเอียด</th>
                                                    <th>โลโก้</th>
                                                    <th>รูปภาพ</th>
                                                    <th>แสดง</th>
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
                                                        <!-- ส่วนแสดงข้อมูลช่องทางชำระเงิน -->
                                                        <td><?php echo $pay_row_result['pay_name']; ?></td>
                                                        <td><?php echo $pay_row_result['pay_detail']; ?></td>
                                                        <td>
                                                            <?php if ($pay_row_result['pay_logo'] != '') { ?>
                                                                <a href="../../../pay_logo/<?php echo $pay_row_result['pay_logo']; ?>" target="_blank"><img src="../../../pay_logo/<?php echo $pay_row_result['pay_logo']; ?>" style="max-height: 50px; max-width: 50px"></a>
                                                            <?php } ?>
                                                        </td>
                                                        <td>
                                                            <?php if ($pay_row_result['pay_img'] != '') { ?>
                                                                <a href="../../../pay_img/<?php echo $pay_row_result['pay_img']; ?>" target="_blank"><img src="../../../pay_img/<?php echo $pay_row_result['pay_img']; ?>" style="max-height: 50px; max-width: 50px"></a>
                                                            <?php } ?>
                                                        </td>
                                                        <td><?php
                                                            if ($pay_row_result['pay_show'] == 0) {
                                                                echo 'ไม่แสดง';
                                                            } else {
                                                                echo 'แสดง';
                                                            }
                                                            ?></td>
                                                        <td>
                                                            <!-- ปุ่มแก้ไข -->
                                                            <div class="button-list">
                                                                <form action="payment_show_form.php" method="post">
                                                                    <input type="hidden" name="edit_id" value="<?php echo $pay_row_result['pay_id']; ?>">
                                                                    <button type="submit" name="edit_btn" class="btn btn-info btn-sm waves-effect waves-light"><i class="fe-eye"></i> รายละเอียด</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <!-- ปุ่มแก้ไข -->
                                                            <div class="button-list">
                                                                <form action="payment_edit_form.php" method="post">
                                                                    <input type="hidden" name="edit_id" value="<?php echo $pay_row_result['pay_id']; ?>">
                                                                    <button type="submit" name="edit_btn" class="btn btn-warning btn-sm waves-effect waves-light"><i class="far fa-edit"></i> แก้ไข</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <!-- ปุ่มลบ -->
                                                            <div class="button-list">
                                                                <form action="payment_delete_form.php" method="post">
                                                                    <input type="hidden" name="edit_id" value="<?php echo $pay_row_result['pay_id']; ?>">
                                                                    <button type="submit" name="delete_btn" class="btn btn-danger btn-sm waves-effect waves-light"><i class="mdi mdi-delete"></i> ลบ</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                <?php
                                                } while ($pay_row_result = mysqli_fetch_assoc($pay_result));
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

</body>

</html>