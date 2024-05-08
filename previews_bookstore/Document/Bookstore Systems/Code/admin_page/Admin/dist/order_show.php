<?php
require_once __DIR__ . '/../../../connection.php';


$sql_script = "SELECT * FROM bk_ord_orders";
$ord_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$ord_row_result = mysqli_fetch_assoc($ord_result);
$ord_totalrows_result = mysqli_num_rows($ord_result);

// ตรวจสอบสิทธิ์
if (!(isset($_SESSION['sale']) || isset($_SESSION['admin']))) {
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

    // แสดงหน้าต่างข้อความแจ้งเตือน
    echo "<script>alert('$status');</script>";
    echo "<script>window.location.href = 'index.php';</script>";
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
                    <div class="row">
                        <div class="col-12">
                            <!-- แสดงข้อมูล -->
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mt-0 header-title">การสั่งซื้อ</h4>
                                    <br>
                                    <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th>เวลา</th>
                                                <th>จำนวนเงิน</th>
                                                <th>ช่องทางชำระเงิน</th>
                                                <th>สถานะ</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            do {
                                            ?>
                                                <tr>
                                                    <td><?php echo $ord_row_result['ord_date']; ?></td>
                                                    <td><?php echo $ord_row_result['ord_amount']; ?></td>
                                                    <td><?php echo $ord_row_result['ord_payment']; ?></td>
                                                    <td><?php echo $ord_row_result['ord_status']; ?></td>
                                                    
                                                    <td><!-- ปุ่มแก้ไข -->
                                                        <div class="button-list">
                                                            <form action="order_edit_form.php" method="post">
                                                                <input type="text" value="<?php echo $ord_row_result['ord_id']; ?>" hidden name="edit_id" id="edit_id">
                                                                <button type="submit" name="edit_btn" class="btn btn-warning btn-sm waves-effect waves-light"><i class="far fa-edit"></i> แก้ไข</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php } while ($ord_row_result = mysqli_fetch_assoc($ord_result)); ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                        </div>



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