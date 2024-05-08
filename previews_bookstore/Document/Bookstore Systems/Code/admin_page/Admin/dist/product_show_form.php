<?php
require_once __DIR__ . '/../../../connection.php';

// ตรวจสอบสิทธิ์
if (!(isset($_SESSION['sale']) || isset($_SESSION['admin']))) {
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
    echo "<script>alert('ผิดพลาด ไม่พบประเภทสินค้า'); window.location='product_show.php';</script>";
    exit;
}

$sql_script = "SELECT * FROM bk_prd_product WHERE prd_id = '$edit_id'";
$prd_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$prd_row_result = mysqli_fetch_assoc($prd_result);
$prd_totalrows_result = mysqli_num_rows($prd_result);

if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
    $status = $_SESSION['status'];
    $status_code = $_SESSION['status_code'];


    // เคลียร์ค่า session
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);

    // แสดงหน้าต่างข้อความแจ้งเตือน
    echo "<script>alert('$status');</script>";
    echo "<script>window.location.href = 'product_show_form.php';</script>";
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
                                    <h4 class="header-title">รายละเอียดสินค้า</h4>
                                    <br>
                                    <form action="product_edit.php" class="parsley-examples" method="POST">
                                        <div class="mb-3">
                                            <input type="text" hidden id="prd_id" name="prd_id" value="<?php echo $prd_row_result['prd_id'] ?>">
                                            <label for="prd_detail" class="form-label">ชื่อสินค้า</label>
                                            <input type="text" name="prd_name" parsley-trigger="change" class="form-control" id="prd_name" readonly value="<?php echo $prd_row_result['prd_name'] ?>" />
                                            <div class="mb-3">
                                                <label for="prd_detail" class="form-label">รายละเอียดสินค้า</label>
                                                <textarea name="prd_detail" parsley-trigger="change" class="form-control" id="prd_detail" rows="4" readonly><?php echo $prd_row_result['prd_detail'] ?></textarea>
                                            </div>
                                            <label for="prd_detail" class="form-label">ราคาสินค้า</label>
                                            <input type="text" name="prd_price" parsley-trigger="change" class="form-control" id="prd_price" readonly value="<?php echo $prd_row_result['prd_price'] ?>" />
                                            <label for="prd_detail" class="form-label">ส่วนลดสินค้า</label>
                                            <input type="text" name="prd_discount" parsley-trigger="change" class="form-control" id="prd_discount" readonly value="<?php echo $prd_row_result['prd_discount'] ?>" />
                                            <label for="prd_detail" class="form-label">แต้มสะสม</label>
                                            <input type="text" name="prd_coin" parsley-trigger="change" class="form-control" id="prd_coin" readonly value="<?php echo $prd_row_result['prd_coin'] ?>" />
                                            <label for="prd_detail" class="form-label">จำนวนสินค้า</label>
                                            <input type="text" name="prd_qty" parsley-trigger="change" class="form-control" id="prd_qty" readonly value="<?php echo $prd_row_result['prd_qty'] ?>" />
                                            <label for="prd_detail" class="form-label">ชนิดสินค้า</label>
                                            <input type="text" name="prd_preorder" parsley-trigger="change" class="form-control" id="prd_preorder" readonly value="<?php 
                                            if($prd_row_result['prd_preorder'] == 1){
                                                echo 'สินค้าพรีออเดอร์';
                                            } else {
                                                echo 'สินค้าปกติ';
                                            } ?>" />
                                            <?php
                                            $sql_script = "SELECT * FROM bk_prd_type WHERE pty_id = '{$prd_row_result['pty_id']}'";
                                            $pty_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                            $pty_row_result = mysqli_fetch_assoc($pty_result);
                                            ?>
                                            <label for="prd_detail" class="form-label">ประเภทสินค้า</label>
                                            <input type="text" name="pty_name" parsley-trigger="change" class="form-control" id="pty_name" readonly value="<?php echo $pty_row_result['pty_name'] ?>" />
                                            <?php
                                            $sql_script = "SELECT * FROM bk_prd_publisher WHERE publ_id = '{$prd_row_result['publ_id']}'";
                                            $publ_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                            $publ_row_result = mysqli_fetch_assoc($publ_result);
                                            ?>
                                            <label for="prd_detail" class="form-label">สำนักพิมพ์</label>
                                            <input type="text" name="prp_name" parsley-trigger="change" class="form-control" id="prp_name" readonly value="<?php echo $publ_row_result['publ_name'] ?>" />
                                            <?php
                                            $sql_script = "SELECT * FROM bk_promotion WHERE prp_id = '{$prd_row_result['prp_id']}'";
                                            $prp_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                            $prp_row_result = mysqli_fetch_assoc($prp_result);
                                            ?>
                                            
                                        </div>
                                        <div class="text-end">
                                            <button type="button" class="btn btn-secondary waves-effect" onclick="window.location.href='<?= $_SESSION['location_prd_show'] ?>'">ย้อนกลับ</button>

                                        </div>
                                    </form>
                                </div>
                            </div> <!-- end card -->
                        </div>
                        <!-- end col -->
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">
                                    <div class="card card-draggable ui-sortable-handle">
                                        <img class="card-img-top img-fluid" src="../../../prd_img/<?php echo $prd_row_result['prd_img']; ?>" alt="Card image cap" style="max-width: 200px; max-height: 200px;">
                                        <div class="card-body">
                                            <h4 class="card-title">รูปสินค้า</h4>
                                        </div>
                                    </div>
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