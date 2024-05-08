<?php
require_once __DIR__ . '/../../../connection.php';

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

// ตรวจสอบสิทธิ์
if (!isset($_SESSION['admin'])) {
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
                    <!-- Scrollable modal -->
                    <div class="modal fade" id="scrollable-modal" tabindex="-1" role="dialog" aria-labelledby="scrollableModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="scrollableModalTitle">เพิ่มสำนักพิมพ์</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- ฟอร์มเพิ่มสำนักพิมพ์ -->

                                    <h4 class="header-title">เพิ่มสำนักพิมพ์</h4>
                                    <form class="needs-validation" novalidate action="publisher_add.php" method="POST">
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">ชื่อสำนักพิมพ์<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="publ_name" name="publ_name" placeholder="ชื่อสำนักพิมพ์" maxlength="30" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่ชื่อสำนักพิมพ์
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">รายละเอียดสำนักพิมพ์<span class="text-danger">*</span></label>
                                            <textarea maxlength="50" required="" class="form-control" id="publ_detail" name="publ_detail" placeholder="รายละเอียดสำนักพิมพ์" style="height: 93px;"></textarea>
                                            <div class="invalid-feedback">
                                                โปรดใส่รายละเอียดสำนักพิมพ์
                                            </div>
                                        </div>
                                </div>
                                <div class="modal-footer">
                                <button type="submit" id="addbtn" name="addbtn" class="btn btn-success waves-effect waves-light"><i class="dripicons-checkmark"></i> บันทึก</button>
                                    </form>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                    <!-- <button type="button" class="btn btn-primary">บันทึก</button> -->
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->


                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mt-0 header-title">รายการสำนักพิมพ์</h4>
                                    <br>
                                    <button type="button" data-bs-toggle="modal" data-bs-target="#scrollable-modal" class="btn btn-success waves-effect waves-light"><i class="far fa-plus-square"></i> เพิ่มสำนักพิมพ์</button>
                                    <br><br>

                                    <?php
                                    $sql_script = "SELECT * FROM bk_prd_publisher";
                                    $publ_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                    $publ_row_result = mysqli_fetch_assoc($publ_result);
                                    $publ_totalrows_result = mysqli_num_rows($publ_result);
                                    if ($publ_row_result > 0) {
                                    ?>
                                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline">
                                            <thead>
                                                <tr>
                                                    <th>ชื่อสำนักพิมพ์</th>
                                                    <th>รายละเอียด</th>
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
                                                        <td><?php echo $publ_row_result['publ_name']; ?></td>
                                                        <td><?php echo $publ_row_result['publ_detail']; ?></td>
                                                        <td>
                                                            <!-- ปุ่มแก้ไข -->
                                                            <div class="button-list">
                                                                <form action="publisher_show_form.php" method="post">
                                                                    <input type="hidden" name="edit_id" value="<?php echo $publ_row_result['publ_id']; ?>">
                                                                    <button type="submit" name="edit_btn" class="btn btn-info btn-sm waves-effect waves-light"><i class="fe-eye"></i> รายละเอียด</button>
                                                                </form>
                                                            </div>
                                                        </td>
                                                        <td>
                                                            <!-- ปุ่มแก้ไข -->
                                                            <form action="publisher_edit_form.php" method="post">
                                                                <input type="hidden" name="edit_id" value="<?php echo $publ_row_result['publ_id']; ?>">
                                                                <button type="submit" name="edit_btn" class="btn btn-warning btn-sm waves-effect waves-light"><i class="far fa-edit"></i> แก้ไข</button>
                                                            </form>
                                                        </td>
                                                        <td>
                                                            <!-- ปุ่มลบ -->
                                                            <form action="publisher_delete_form.php" method="post">
                                                                <input type="hidden" name="edit_id" value="<?php echo $publ_row_result['publ_id']; ?>">
                                                                <button type="submit" name="delete_btn" class="btn btn-danger btn-sm waves-effect waves-light"><i class="mdi mdi-delete"></i> ลบ</button>
                                                            </form>
                                                        </td>
                                                    </tr>
                                                <?php
                                                } while ($publ_row_result = mysqli_fetch_assoc($publ_result));
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