<?php
require_once __DIR__ . '/../../../connection.php';

// ตรวจสอบสิทธิ์
if (!(isset($_SESSION['sale']))) {
    $_SESSION['status'] = "ไม่พบสิทธิ์การใช้งานในหน้านี้";
    $_SESSION['status_code'] = "ผิดพลาด";
    header('Location: login_form.php');
exit;
}


// ตรวจสอบว่ามีค่า 'edit_id' ที่ถูกส่งมาใน URL หรือไม่
if (isset($_GET['edit_id'])) {
    $edit_id = $_GET['edit_id'];
} elseif (isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
} else {
    echo "<script>alert('ผิดพลาด ไม่พบข้อมูล'); window.location='index.php';</script>";
    exit;
}

$sql_script = "SELECT * FROM bk_ord_orders WHERE ord_id = '$edit_id'";
$ord_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$ord_row_result = mysqli_fetch_assoc($ord_result);
$ord_totalrows_result = mysqli_num_rows($ord_result);

if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
    $status = $_SESSION['status'];
    $status_code = $_SESSION['status_code'];

    // เคลียร์ค่า session
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);

    // แสดงหน้าต่างข้อความแจ้งเตือน
    echo "<script>alert('$status');</script>";
    echo "<script>window.location.href = 'order_edit_form.php?edit_id=$edit_id';</script>";
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
                                    <h4 class="header-title">รายละเอียดคำสั่งซื้อ</h4>
                                    <br>
                                    <form action="product_edit.php" class="parsley-examples" method="POST">
                                        <div class="mb-3">
                                            <input type="text" hidden id="ord_id" name="ord_id" value="<?php echo $ord_row_result['ord_id'] ?>">
                                            <label for="ord_detail" class="form-label">เวลา</label>
                                            <input type="text" name="ord_date" parsley-trigger="change" class="form-control" id="ord_date" value="<?php echo $ord_row_result['ord_date'] ?>" readonly />
                                            <label for="ord_detail" class="form-label">ราคารวม</label>
                                            <input type="text" name="ord_amount" parsley-trigger="change" class="form-control" id="ord_amount" value="<?php echo $ord_row_result['ord_amount'] ?>" readonly />
                                            <div class="mb-3">
                                                <label for="ord_detail" class="form-label">ที่อยู่จัดส่ง</label>
                                                <textarea name="ord_address" parsley-trigger="change" class="form-control" id="ord_address" rows="4" readonly><?php echo $ord_row_result['ord_address'] ?></textarea>
                                            </div>
                                            <label for="ord_detail" class="form-label">ช่องทางการชำระเงิน</label>
                                            <input type="text" name="ord_payment" parsley-trigger="change" class="form-control" id="ord_payment" value="<?php echo $ord_row_result['ord_payment'] ?>" readonly />
                                            <label for="ord_detail" class="form-label">สถานะ</label>
                                            <select name="pty_id" id="pty_id" class="form-select">
                                                <option value='<?php echo $ord_row_result['ord_status'] ?>' selected><?php echo $ord_row_result['ord_status'] ?></option>
                                                <option value='<?php echo $ord_row_result['ord_status'] ?>' selected>กำลังดำเนินการ</option>
                                            </select>
                                            <?php
                                            $mmb_id = $ord_row_result['mmb_id'];
                                            $sql_script = "SELECT * FROM bk_auth_member WHERE mmb_id = '$mmb_id'";
                                            $mmb_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                            $mmb_row_result = mysqli_fetch_assoc($mmb_result);
                                            ?>
                                            <label for="ord_detail" class="form-label">ผู้ซื้อ</label>
                                            <input type="text" name="mmb_id" parsley-trigger="change" class="form-control" id="mmb_id" value="<?php echo $mmb_row_result['mmb_username'] ?>" readonly />
                                            <label for="ord_detail" class="form-label">เหรียญที่ได้รับ</label>
                                            <input type="text" name="ord_coin" parsley-trigger="change" class="form-control" id="ord_coin" value="<?php echo $ord_row_result['ord_coin'] ?>" readonly />
                                            <div class="mb-3">
                                                <label for="ord_detail" class="form-label">รายละเอียดเพิ่มเติม</label>
                                                <textarea name="ord_detail" parsley-trigger="change" class="form-control" id="ord_detail" rows="4" readonly><?php echo $ord_row_result['ord_detail'] ?></textarea>
                                            </div>



                                        </div>
                                        <div class="text-end">
                                            <button class="btn btn-warning btn-sm waves-effect waves-light" type="submit" id="editbtn" name="editbtn"><i class="far fa-edit"></i> บันทึก</button>
                                            <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='index.php'">ย้อนกลับ</button>

                                        </div>
                                    </form>
                                </div>
                            </div> <!-- end card -->
                        </div>
                        <!-- end col -->
                        <?php
                        $sql_script = "SELECT order_item.*, product.prd_name
                        FROM bk_ord_item
                        INNER JOIN bk_prd_product ON order_item.prd_id = product.prd_id
                        WHERE order_item.ord_id = '$edit_id'";
                        $ordi_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                        $ordi_row_result = mysqli_fetch_assoc($ordi_result);
                        $ordi_totalrows_result = mysqli_num_rows($ordi_result);
                        ?>
                        
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