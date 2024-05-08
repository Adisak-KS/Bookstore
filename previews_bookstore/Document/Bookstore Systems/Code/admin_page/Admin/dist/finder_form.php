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
    echo "<script>alert('ไม่พบฟอร์มนี้ โปรดลองใหม่'); window.location='index.php';</script>";
    exit;
}

$sql_script = "SELECT * FROM bk_fnd_finder WHERE fnd_id = $edit_id";
$fnd_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$fnd_row_result = mysqli_fetch_assoc($fnd_result);


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
                                    <h4 class="header-title">รายละเอียดการหาหนังสือ</h4>
                                    <br>
                                    <div class="card card-draggable ui-sortable-handle">
                                        <?php
                                        if ($fnd_row_result['fnd_img'] != '') {
                                        ?>
                                            <img class="card-img-top img-fluid" src="../../../fnd_img/<?php echo $fnd_row_result['fnd_img']; ?>" alt="Card image cap" style="max-width: 200px; max-height: 200px;">
                                        <?php
                                        } else {
                                            echo '<p>ไม่มีรูปภาพ</p>';
                                        } ?>
                                        <div class="card-body">
                                            <h4 class="card-title">ภาพประกอบ</h4>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <input type="text" id="fnd_id" name="fnd_id" value="<?php echo $fnd_row_result['fnd_id'] ?>" hidden>
                                        <label for="pay_id" class="form-label">เวลาที่ทำรายการ</label>
                                        <input type="text" name="fnd_date" parsley-trigger="change" class="form-control" id="fnd_date" value="<?php echo $fnd_row_result['fnd_date'] ?>" readonly />
                                        <div class="mb-3">
                                            <label for="pay_id" class="form-label">ชื่อหนังสือ</label>
                                            <input type="text" name="fnd_name" parsley-trigger="change" class="form-control" id="fnd_name" value="<?php echo $fnd_row_result['fnd_name'] ?>" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="pay_id" class="form-label">สำนักพิมพ์</label>
                                            <input type="text" name="fnd_author" parsley-trigger="change" class="form-control" id="fnd_author" value="<?php echo $fnd_row_result['fnd_author'] ?>" readonly>
                                        </div>
                                        <div class="mb-3">
                                            <label for="pay_id" class="form-label">เล่มที่</label>
                                            <input type="text" name="fnd_volumn" parsley-trigger="change" class="form-control" id="fnd_volumn" value="<?php echo $fnd_row_result['fnd_volumn'] ?>" readonly>
                                        </div>
                                    </div>
                                </div>
                            </div> <!-- end card -->

                            <?php
                            $sql_script = "SELECT * FROM bk_fnd_item WHERE fnd_id = $edit_id";
                            $fdit_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());

                            while ($fdit_row_result = mysqli_fetch_assoc($fdit_result)) {
                            ?>
                                <div class="card">
                                    <div class="card-body">
                                        <h4 class="header-title"><?= $fdit_row_result['fdit_status'] ?></h4>
                                        <br>
                                        <form action="finder_item_add.php" method="POST" enctype="multipart/form-data">
                                            <div class="mb-3">
                                                <input type="text" id="fnd_id" name="fnd_id" value="<?php echo $fnd_row_result['fnd_id'] ?>" hidden>
                                                <input type="text" id="fdit_img" name="fdit_img" value="<?php echo $fdit_row_result['fdit_img'] ?>" hidden>
                                                    <img class="card-img-top img-fluid" src="../../../fdit_img/<?php echo $fdit_row_result['fdit_img']; ?>" alt="Card image cap" style="max-width: 200px; max-height: 200px;">
                                                    <div class="mb-3">
                                                        <label for="pay_id" class="form-label">ภาพประกอบ</label>
                                                    </div>

                                                <div class="mb-3">
                                                    <label for="pay_id" class="form-label">ชื่อหนังสือ</label>
                                                    <input type="text" name="fdit_name" parsley-trigger="change" class="form-control" id="fdit_name" placeholder="ชื่อหนังสือ" readonly value="<?= $fdit_row_result['fdit_name'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pay_id" class="form-label">ผู้เขียน</label>
                                                    <input type="text" name="fdit_author" parsley-trigger="change" class="form-control" id="fdit_author" placeholder="ผู้เขียน" readonly value="<?= $fdit_row_result['fdit_author'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pay_id" class="form-label">สำนักพิมพ์</label>
                                                    <input type="text" name="fdit_publisher" parsley-trigger="change" class="form-control" id="fdit_publisher" placeholder="สำนักพิมพ์" readonly value="<?= $fdit_row_result['fdit_publisher'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pay_id" class="form-label">เล่มที่</label>
                                                    <input type="text" name="fdit_volumn" parsley-trigger="change" class="form-control" id="fdit_volumn" placeholder="เล่มที่" readonly value="<?= $fdit_row_result['fdit_volumn'] ?>">
                                                </div>
                                                <div class="mb-3">
                                                    <label for="pay_id" class="form-label">รายละเอียด</label>
                                                    <textarea name="fdit_detail" id="fdit_detail" cols="30" rows="4" class="form-control" placeholder="รายละเอียดเพิ่มเติม" readonly><?= $fdit_row_result['fdit_detail'] ?></textarea>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div> <!-- end card -->
                            <?php
                            }
                            //ตอบกลับสมาชิก
                            ?>
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">ตอบกลับสมาชิก</h4>
                                    <br>
                                    <form action="finder_item_add.php" method="POST" enctype="multipart/form-data" class="needs-validation" novalidate>
                                        <div class="mb-3">
                                            <input type="text" id="fnd_id" name="fnd_id" value="<?php echo $fnd_row_result['fnd_id'] ?>" hidden>
                                            <div class="mb-3">
                                                <label for="pay_id" class="form-label">ภาพประกอบ<span class="text-danger">*</span></label>
                                                <input type="file" class="form-control" id="fdit_img" name="fdit_img" accept="image/png, image/jpeg" required>
                                                <div class="invalid-feedback">
                                                    โปรดใส่ภาพประกอบ
                                                </div>
                                            </div>

                                            <div class="mb-3">
                                                <label for="pay_id" class="form-label">ชื่อหนังสือ<span class="text-danger">*</span></label>
                                                <input type="text" name="fdit_name" parsley-trigger="change" class="form-control" id="fdit_name" placeholder="ชื่อหนังสือ" maxlength="50" required>
                                                <div class="invalid-feedback">
                                                    โปรดใส่ชื่อหนังสือ
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="pay_id" class="form-label">ผู้เขียน<span class="text-danger">*</span></label>
                                                <input type="text" name="fdit_publisher" parsley-trigger="change" class="form-control" id="fdit_publisher" placeholder="ผู้เขียน" maxlength="50" required>
                                                <div class="invalid-feedback">
                                                    โปรดใส่ผู้เขียน
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="pay_id" class="form-label">สำนักพิมพ์<span class="text-danger">*</span></label>
                                                <input type="text" name="fdit_author" parsley-trigger="change" class="form-control" id="fdit_author" placeholder="สำนักพิมพ์" maxlength="20" required>
                                                <div class="invalid-feedback">
                                                    โปรดใส่สำนักพิมพ์
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="pay_id" class="form-label">เล่มที่<span class="text-danger">*</span></label>
                                                <input type="text" name="fdit_volumn" parsley-trigger="change" class="form-control" id="fdit_volumn" placeholder="เล่มที่" maxlength="20" required>
                                                <div class="invalid-feedback">
                                                    โปรดใส่เล่มที่
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="pay_id" class="form-label">รายละเอียด<span class="text-danger">*</span></label>
                                                <textarea name="fdit_detail" id="fdit_detail" cols="30" rows="4" class="form-control" placeholder="รายละเอียดเพิ่มเติม" maxlength="100" required></textarea>
                                                <div class="invalid-feedback">
                                                    โปรดใส่รายละเอียด
                                                </div>
                                            </div>
                                            <div class="mb-3">
                                                <label for="pay_id" class="form-label">ค่าดำเนินการ + ค่าหนังสือ<span class="text-danger">*</span></label>
                                                <input type="number" name="fnd_price" parsley-trigger="change" class="form-control" id="fnd_price" placeholder="ค่าสินค้าและบริการตามหาหนังสือ" min="1" max="100000" required>
                                                <div class="invalid-feedback">
                                                    โปรดใส่ค่าดำเนินการรวมค่าหนังสือ
                                                </div>
                                            </div>
                                        </div>
                                        <div class="text-end">
                                            <button class="btn btn-primary btn-sm waves-effect waves-light" type="submit" id="editbtn" name="editbtn"><i class="mdi mdi-checkbox-marked-outline"></i> ยืนยันการหาหนังสือ</button>
                                            <button class="btn btn-danger btn-sm waves-effect waves-light" type="button" data-bs-toggle="modal" data-bs-target="#submit_danger-modal"><i class="mdi mdi-close-box-outline"></i> ยกเลิกรายการ</button>
                                            <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='finder_show.php'">ย้อนกลับ</button>
                                        </div>
                                    </form>
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
                                        <h4 class="mt-2">ยืนยันการค้นหา?</h4>
                                        <!-- <p class="mt-3">ยืนยันการชำระเงิน?</p> -->
                                        <form action="order_update.php" method="POST" name="fnd_form" id="fnd_form">
                                            <input type="text" id="ord_id" name="ord_id" value="<?php echo $fnd_row_result['ord_id'] ?>" hidden>
                                            <input type="text" id="fnd_id" name="fnd_id" value="<?php echo $fnd_row_result['fnd_id'] ?>" hidden>
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
                                        <i class="dripicons-warning h1 text-danger"></i>
                                        <h4 class="mt-2">ยกเลิกการค้นหา</h4>
                                        <p class="mt-3">ไม่พบสินค้าที่ต้องการ?</p>
                                        <form action="finder_cancel.php" method="POST">
                                            <input type="text" id="fnd_id" name="fnd_id" value="<?php echo $fnd_row_result['fnd_id'] ?>" hidden>
                                            <button type="submit" name="redobtn" class="btn btn-danger my-2" data-bs-dismiss="modal">ยืนยัน</button>
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