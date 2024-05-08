<?php
require_once __DIR__ . '/../../../connection.php';

// ตรวจสอบสิทธิ์
// if (!(isset($_SESSION['admin']) || isset($_SESSION['sale']))) {
//     $_SESSION['status'] = "ไม่พบสิทธิ์การใช้งานในหน้านี้";
//     $_SESSION['status_code'] = "ผิดพลาด";
//     header('Location: login_form.php');
// exit;
// }

$currentURL = $_SERVER['REQUEST_URI'];
// ตรวจสอบว่ามีค่า 'edit_id' ที่ถูกส่งมาใน URL หรือไม่
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
} elseif (isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
} else {
    echo "<script>alert('ไม่พบฟอร์มนี้ โปรดลองใหม่'); window.location='pay_show.php';</script>";
    exit;
}

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
                        <!-- แสดงข้อมูล -->

                        <div class="card">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">สินค้าในรายการซื้อ (ตามหาหนังสือตามสั่ง)</h4>
                                <br>
                                <?php
                                $sql_script = "SELECT * FROM bk_fnd_item WHERE fnd_id = '$edit_id' AND fdit_status = 'ยืนยัน'";
                                $itm_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());


                                ?>

                                <?php if (mysqli_num_rows($itm_result) > 0) { ?>
                                    <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th>รูปสินค้า</th>
                                                <th>ชื่อสินค้า</th>
                                                <th>เล่มที่</th>
                                                <th>รายละเอียด</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($itm_row_result = mysqli_fetch_assoc($itm_result)) { ?>
                                                <tr>
                                                    <td><img class="card-img-top img-fluid" src="../../../fdit_img/<?php echo $itm_row_result['fdit_img']; ?>" alt="Card image cap" style="max-width: 50px; max-height: 50px;"></td>
                                                    <td><?= $itm_row_result['fdit_name'] ?></td>
                                                    <td><?= $itm_row_result['fdit_volumn'] ?></td>
                                                    <td><?= $itm_row_result['fdit_detail'] ?></a></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                <?php } else { ?>
                                    <p>ไม่พบรายการ</p>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="card">
                                <?php

                                $sql_script = "SELECT bk_fnd_finder.*, bk_ord_shipping.shp_name
FROM bk_fnd_finder
INNER JOIN bk_ord_shipping ON bk_fnd_finder.shp_id = bk_ord_shipping.shp_id
WHERE bk_fnd_finder.fnd_id = '$edit_id'";
                                $fnd_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());

                                $fnd_row_result = mysqli_fetch_assoc($fnd_result);
                                ?>
                                <div class="card-body">
                                    <h4 class="header-title">รายละเอียดการจัดส่ง</h4>
                                    <br>
                                    <div class="mb-3">
                                        <label for="pay_id" class="form-label">
                                            <h6 class="font-13 mt-3">ที่อยู่จัดส่ง </h6></label>
                                        <textarea class="form-control-plaintext" name="fnd_address" id="fnd_address" readonly><?php echo $fnd_row_result['fnd_address'] ?></textarea>
                                        <label for="pay_id" class="form-label">
                                            <h6 class="font-13 mt-3"> ช่องทางการขนส่ง </h6></label>
                                        <input type="text" name="pay_id" parsley-trigger="change" class="form-control-plaintext" id="pay_id" value="<?php echo $fnd_row_result['shp_name'] ?>" readonly>
                                        <form action="finder_update.php" method="POST" name="ship_form" id="ship_form" class="needs-validation" novalidate>
                                            <label for="pay_id" class="form-label">
                                                <h6 class="font-13 mt-3"> หมายเลขติดตามพัสดุ <span class="text-danger">*</span></h6>
                                            </label>
                                            <input type="text" name="fnd_track" parsley-trigger="change" class="form-control" id="fnd_track" placeholder="สำหรับให้ผู้ซื้อติดตามพัสดุจากบริการขนส่ง" value="<?= $fnd_row_result['fnd_track'] ?>" maxlength="20" required>
                                            <div class="invalid-feedback">
                                                โปรดใส่หมายเลขติดตามพัสดุ
                                            </div>
                                    </div>
                                    <div class="text-end">
                                        <button class="btn btn-primary btn-sm waves-effect waves-light" type="button" id="editbtn" name="editbtn" data-bs-toggle="modal" data-bs-target="#submit_alert-modal"><i class="mdi mdi-checkbox-marked-outline"></i> ยืนยันการจัดส่ง</button>
                                        <!-- <button class="btn btn-warning btn-sm waves-effect waves-light" type="button" data-bs-toggle="modal" data-bs-target="#submit_danger-modal"><i class="mdi mdi-close-box-outline"></i> ชำระไม่ถูกต้อง</button> -->
                                        <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='pay_show.php'">ย้อนกลับ</button>

                                    </div>
                                </div>
                            </div> <!-- end card -->
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
                                        <i class="ti-truck h1 text-primary"></i>
                                        <h4 class="mt-2">ยืนยันการจัดส่งสินค้า?</h4>
                                        <!-- <p class="mt-3">ยืนยันการชำระเงิน?</p> -->
                                        <input type="text" id="fnd_id" name="fnd_id" value="<?php echo $fnd_row_result['fnd_id'] ?>" hidden>
                                        <button type="submit" name="shpbtn" class="btn btn-primary my-2" data-bs-dismiss="modal">ยืนยัน</button>
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