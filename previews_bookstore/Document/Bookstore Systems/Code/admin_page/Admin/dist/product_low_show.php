<?php
require_once __DIR__ . '/../../../connection.php';

$sql_script = "SELECT * FROM bk_prd_product WHERE prd_qty <= " . $_SESSION['remain_quantity'];
$prd_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$prd_row_result = mysqli_fetch_assoc($prd_result);
$prd_totalrows_result = mysqli_num_rows($prd_result);

$page_title = basename($_SERVER['PHP_SELF']);

$_SESSION['location_prd_show'] = $page_title;

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
if (!(isset($_SESSION['sale']) || isset($_SESSION['admin']))) {
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

                    <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mt-0 header-title">สินค้าคงใกล้หมด</h4>
                                    <br>

                                    <br><br>
                                    <?php
                                    if($prd_totalrows_result > 0){
                                        ?>
                                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline">
                                        <thead>
                                            <tr>
                                                <th>รูป</th>
                                                <th>ชื่อสินค้า</th>
                                                <th>พรีออเดอร์</th>
                                                <th>แสดงสินค้า</th>
                                                <th>จำนวน</th>
                                                <th></th>
                                                <th></th>
                                            </tr>
                                        </thead>


                                        <tbody>

                                            <?php
                                            do {
                                            ?>
                                                <tr>
                                                    <td><a href="../../../prd_img/<?php echo $prd_row_result['prd_img']; ?>" target="_blank"><img src="../../../prd_img/<?php echo $prd_row_result['prd_img']; ?>" style="max-height: 50px; max-width: 50px"></a></td>
                                                    <td><?php echo $prd_row_result['prd_name']; ?></td>
                                                    <td><?php if ($prd_row_result['prd_preorder'] == 1) {
                                                            echo 'สินค้าพรีออเดอร์';
                                                        } else {
                                                            echo 'สินค้าปกติ';
                                                        } ?>
                                                    </td>
                                                    <td><?php if ($prd_row_result['prd_show'] == 1) {
                                                            echo 'แสดง';
                                                        } else {
                                                            echo 'ไม่แสดง';
                                                        } ?></td>
                                                    <td><?php
                                                                            if ($prd_row_result['prd_qty'] == 0) {
                                                                                echo 'หมด';
                                                                            } else {
                                                                                echo $prd_row_result['prd_qty'];
                                                                            }
                                                                            ?></td>
                                                    <td>
                                                        <!-- ปุ่มแก้ไข -->
                                                        <div class="button-list">
                                                            <form action="product_show_form.php" method="post">
                                                                <input type="hidden" name="edit_id" value="<?php echo $prd_row_result['prd_id']; ?>">
                                                                <button type="submit" name="edit_btn" class="btn btn-info btn-sm waves-effect waves-light"><i class="fe-eye"></i> รายละเอียด</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- ปุ่มแก้ไข -->
                                                        <div class="button-list">
                                                            <form action="product_edit_form.php" method="post">
                                                                <input type="hidden" name="edit_id" value="<?php echo $prd_row_result['prd_id']; ?>">
                                                                <button type="submit" name="edit_btn" class="btn btn-warning btn-sm waves-effect waves-light"><i class="far fa-edit"></i> แก้ไข</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                </tr>
                                            <?php
                                            } while ($prd_row_result = mysqli_fetch_assoc($prd_result));
                                            ?>
                                        </tbody>
                                    </table>
                                    <?php
                                    }
                                    else{
                                        echo 'ไม่พบรายการ';
                                    }
                                    ?>
                                    <br>
                                    <div class="text-end">
                                        <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='index.php'">ย้อนกลับ</button>
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