<?php
require_once __DIR__ . '/../../../connection.php';

// ตรวจสอบสิทธิ์
// if (!(isset($_SESSION['sale']) || isset($_SESSION['admin']))) {
//     $_SESSION['status'] = "ไม่พบสิทธิ์การใช้งานในหน้านี้";
//     $_SESSION['status_code'] = "ผิดพลาด";
//     header('Location: login_form.php');
// exit;
// }

$currentURL = $_SERVER['REQUEST_URI'];
if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
    $status = $_SESSION['status'];
    $status_code = $_SESSION['status_code'];

    // เคลียร์ค่า session
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);

    // แสดงหน้าต่างข้อความแจ้งเตือน
    echo "<script>alert('$status');</script>";
    echo "<script>window.location.href = '$currentURL';</script>";
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
                        <!-- แสดงข้อมูล -->

                        <div class="card">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">รายการการชำระเงิน</h4>
                                <br>
                                <?php
                               $sql_ord_script = "SELECT * FROM bk_ord_orders WHERE ord_status IN ('เตรียมจัดส่งสินค้า', 'อยู่ระหว่างการขนส่ง', 'จัดส่งสำเร็จ') ORDER BY ord_date DESC";
                               $ord_result = mysqli_query($proj_connect, $sql_ord_script) or die(mysqli_connect_error());
                               
                               $sql_fnd_script = "SELECT * FROM bk_fnd_finder WHERE fnd_status IN ('เตรียมจัดส่งสินค้า', 'อยู่ระหว่างการขนส่ง', 'จัดส่งสำเร็จ') ORDER BY fnd_date DESC";
                               $fnd_result = mysqli_query($proj_connect, $sql_fnd_script) or die(mysqli_connect_error());
                               
                                ?>

                                <?php if ((mysqli_num_rows($ord_result) > 0) || (mysqli_num_rows($fnd_result) > 0)) { ?>
                                    <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th>เวลา</th>
                                                <th>การจัดส่ง</th>
                                                <th>พรีออเดอร์</th>
                                                <th>สถานะ</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($ord_row_result = mysqli_fetch_assoc($ord_result)) { ?>
                                                <tr>
                                                    <td><?= $ord_row_result['ord_date'] ?></td>
                                                    <?php
                                                    $sql_script = "SELECT * FROM bk_ord_shipping WHERE shp_id = " . $ord_row_result['shp_id'];
                                                    $shp_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                                    $shp_row_result = mysqli_fetch_assoc($shp_result)
                                                    ?>
                                                    <td><?= $shp_row_result['shp_name'] ?></td>
                                                    <td><?php
                                                        $sql_script = "SELECT p.prd_name
                                                        FROM bk_prd_product p
                                                        INNER JOIN bk_ord_item oi ON p.prd_name = oi.ordi_name
                                                        INNER JOIN bk_ord_orders o ON oi.ord_id = o.ord_id
                                                        WHERE o.ord_id = '" . $ord_row_result['ord_id'] . "' AND p.prd_preorder = 1;
                                                        ";
                                                        $pre_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                                        // ตรวจสอบว่ามีข้อมูลหรือไม่
                                                        if (mysqli_num_rows($pre_result) > 0) {
                                                            echo "มีสินค้าพรีออเดอร์";
                                                        } else {
                                                            echo "ไม่มีสินค้าพรีออเดอร์";
                                                        }
                                                        ?></td>
                                                    <td><?= $ord_row_result['ord_status'] ?></td>
                                                    <td><button type="submit" name="edit_btn" class="btn btn-info btn-sm waves-effect waves-light" onclick="location.href='order_form.php?edit_id=<?= $ord_row_result['ord_id'] ?>';"><i class="fe-eye"></i> รายละเอียด</button></td>
                                                </tr>
                                            <?php }
                                            while ($fnd_row_result = mysqli_fetch_assoc($fnd_result)) { ?>
                                                <tr>
                                                    <td><?= $fnd_row_result['fnd_date'] ?></td>
                                                    <?php
                                                    $sql_script = "SELECT * FROM bk_ord_shipping WHERE shp_id = " . $fnd_row_result['shp_id'];
                                                    $fnd_shp_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                                    $fnd_shp_row_result = mysqli_fetch_assoc($fnd_shp_result)
                                                    ?>
                                                    <td><?= $fnd_shp_row_result['shp_name'] ?></td>
                                                    <td>หนังสือตามสั่ง</td>
                                                    <td><?= $fnd_row_result['fnd_status'] ?></td>
                                                    <td><button type="submit" name="edit_btn" class="btn btn-info btn-sm waves-effect waves-light" onclick="location.href='finder_address_form.php?edit_id=<?= $fnd_row_result['fnd_id'] ?>';"><i class="fe-eye"></i> รายละเอียด</button></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                <?php } else { ?>
                                    <p>ยังไม่มีรายการ</p>
                                <?php } ?>
                                <br>
                                <div class="text-end">
                                    <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='index.php'">ย้อนกลับ</button>
                                </div>
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