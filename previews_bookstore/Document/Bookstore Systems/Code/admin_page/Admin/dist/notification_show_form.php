<?php
require_once __DIR__ . '/../../../connection.php';

// ตรวจสอบสิทธิ์
// if (!(isset($_SESSION['admin']) || isset($_SESSION['sale']))) {
//     $_SESSION['status'] = "ไม่พบสิทธิ์การใช้งานในหน้านี้";
//     $_SESSION['status_code'] = "ผิดพลาด";
//     header('Location: login_form.php');
//     exit;
// }

$currentURL = $_SERVER['REQUEST_URI'];
// ตรวจสอบว่ามีค่า 'edit_id' ที่ถูกส่งมาใน URL หรือไม่
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
} elseif (isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
} else {
    echo "<script>alert('ไม่พบฟอร์มนี้ โปรดลองใหม่'); window.location='index.php';</script>";
    exit;
}

$sql_script = "SELECT n.*, p.pay_name 
               FROM bk_ord_notification n
               INNER JOIN bk_ord_payment p ON n.pay_id = p.pay_id
               WHERE n.ord_id = '$edit_id'";
$ntf_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$ntf_row_result = mysqli_fetch_assoc($ntf_result);


if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
    $status = $_SESSION['status'];
    $status_code = $_SESSION['status_code'];

    // เคลียร์ค่า session
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);

    // แสดงหน้าต่างข้อความแจ้งเตือน
    echo "<script>alert('$status');</script>";
    echo "<script>window.location.href = '$currentURL?edit_id=$edit_id';</script>";
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
                                    <h4 class="header-title">รายละเอียดการชำระเงิน</h4>
                                    <br>
                                    <input type="text" id="ord_id" name="ord_id" value="<?php echo $ntf_row_result['ord_id'] ?>" hidden>
                                    <input type="text" id="ntf_id" name="ntf_id" value="<?php echo $ntf_row_result['ntf_id'] ?>" hidden>
                                    <div class="mb-3">
                                        <label for="pay_id" class="form-label">เวลาที่ทำการชำระเงิน</label>
                                        <input type="text" name="ntf_date" parsley-trigger="change" class="form-control" id="ntf_date" value="<?php echo $ntf_row_result['ntf_date'] ?>" readonly />
                                    </div>
                                    <div class="mb-3">
                                        <label for="pay_id" class="form-label">ช่องทางการชำระเงิน</label>
                                        <input type="text" name="pay_id" parsley-trigger="change" class="form-control" id="pay_id" value="<?php echo $ntf_row_result['pay_name'] ?>" readonly>
                                    </div>
                                    <div class="mb-3">
                                        <label for="pay_id" class="form-label">จำนวนเงิน</label>
                                        <input type="text" name="ntf_amount" parsley-trigger="change" class="form-control" id="ntf_amount" value="<?php echo $ntf_row_result['ntf_amount'] ?>" readonly>
                                    </div>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='order_ntf_history_show.php'">ย้อนกลับ</button>

                                    </div>
                                </div>
                            </div> <!-- end card -->
                        </div>
                        <!-- end col -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card card-draggable ui-sortable-handle">
                                        <?php
                                        $imgSQL = "SELECT * FROM bk_ord_ntf_image WHERE ntf_id = " . $ntf_row_result['ntf_id'];
                                        $imgResult = mysqli_query($proj_connect, $imgSQL);
                                        if (mysqli_num_rows($imgResult) > 0) {
                                            while ($imgRow = mysqli_fetch_assoc($imgResult)) {
                                        ?>
                                                <img class="card-img-top img-fluid" src="../../../ntf_img/<?php echo $imgRow['nimg_img']; ?>" alt="Card image cap" style="max-width: 200px; max-height: 2000px;">
                                        <?php
                                            }
                                        } else {
                                            echo 'ไม่มีรูป';
                                        } ?>
                                        <div class="card-body">
                                            <h4 class="card-title">หลักฐานการชำระเงิน</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div> <!-- end row -->


                    <!-- Danger Alert Modal -->
                    <div id="submit_alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                            <div class="modal-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <h4 class="mt-2">ยืนยันการชำระเงิน?</h4>
                                        <!-- <p class="mt-3">ยืนยันการชำระเงิน?</p> -->
                                        <form action="order_update.php" method="POST" name="ntf_form" id="ntf_form">
                                            <input type="text" id="ord_id" name="ord_id" value="<?php echo $ntf_row_result['ord_id'] ?>" hidden>
                                            <input type="text" id="ntf_id" name="ntf_id" value="<?php echo $ntf_row_result['ntf_id'] ?>" hidden>
                                            <button type="submit" name="submitbtn" class="btn btn-primary my-2" data-bs-dismiss="modal">ยืนยัน</button>
                                        </form>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                    <div id="submit_danger-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content">
                            <div class="modal-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                <div class="modal-body">
                                    <div class="text-center">
                                        <i class="dripicons-warning h1 text-warning"></i>
                                        <h4 class="mt-2">การชำระเงินไม่ถูกต้อง</h4>
                                        <p class="mt-3">แจ้งชำระเงินใหม่อีกครั้ง?</p>
                                        <form action="order_update.php" method="POST">
                                            <input type="text" id="ord_id" name="ord_id" value="<?php echo $ntf_row_result['ord_id'] ?>" hidden>
                                            <input type="text" id="ntf_id" name="ntf_id" value="<?php echo $ntf_row_result['ntf_id'] ?>" hidden>
                                            <button type="submit" name="redobtn" class="btn btn-warning my-2" data-bs-dismiss="modal">ยืนยัน</button>
                                        </form>
                                    </div>
                                </div>
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->


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