<?php
require_once __DIR__ . '/../../../connection.php';

// ตรวจสอบว่ามีค่า 'edit_id' ที่ถูกส่งมาใน URL หรือไม่
if (isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $_SESSION['edit_id'] = $edit_id;
} elseif ($_SESSION['edit_id']) {
    $edit_id = $_SESSION['edit_id'];
} else {
    echo "<script>alert('ผิดพลาด ไม่พบประเภทสินค้า'); window.location='publisher_show.php';</script>";
    exit;
}

$sql_script = "SELECT * FROM bk_prd_product WHERE publ_id = " . $edit_id;
$prd_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$prd_row_result = mysqli_fetch_assoc($prd_result);
$prd_totalrows_result = mysqli_num_rows($prd_result);

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
                                <div class="card-body alert-danger">
                                    <h4 class="mt-0 header-title">ลบรายการสินค้า</h4>
                                    <br><br>
                                    <form action="#" method="POST" id="productForm">

                                        <?php
                                        if ($prd_row_result > 0) {
                                        ?>
                                            <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline">
                                                <thead class="alert-danger">
                                                    <tr>
                                                        <th></th>
                                                        <th>รูป</th>
                                                        <th>ชื่อสินค้า</th>
                                                        <th>ราคา</th>
                                                        <th>แสดงสินค้า</th>
                                                        <th>พรีออเดอร์</th>
                                                    </tr>
                                                </thead>


                                                <tbody>

                                                    <?php
                                                    do {
                                                    ?>
                                                        <tr>
                                                            <td> <input type="checkbox" class="form-check-input" id="prd_id" name="prd_id" value="<?= $prd_row_result['prd_id'] ?>"></td>
                                                            <td><a href="../../../prd_img/<?php echo $prd_row_result['prd_img']; ?>" target="_blank"><img src="../../../prd_img/<?php echo $prd_row_result['prd_img']; ?>" style="max-height: 50px; max-width: 50px"></a></td>
                                                            <td><?php echo $prd_row_result['prd_name']; ?></td>
                                                            <td><?php echo $prd_row_result['prd_price']; ?></td>
                                                            <td><?php if ($prd_row_result['prd_show'] == 1) {
                                                                    echo 'แสดง';
                                                                } else {
                                                                    echo 'ไม่แสดง';
                                                                } ?></td>
                                                            <td>
                                                                <?php
                                                                if ($prd_row_result['prd_preorder'] == 1) {
                                                                    echo 'พรีออเดอร์';
                                                                } else {
                                                                    echo 'สินค้าปกติ';
                                                                }
                                                                ?>
                                                            </td>
                                                        </tr>
                                                    <?php
                                                    } while ($prd_row_result = mysqli_fetch_assoc($prd_result));
                                                    ?>
                                                </tbody>
                                            </table>
                                            <br>
                                            <div class="text-end">
                                                <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='publisher_delete_form.php'">ย้อนกลับ</button>
                                                <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#danger-alert-modal"><i class="mdi mdi-delete"></i> ลบ</button>
                                            </div>

                                        <?php
                                        } else {
                                            echo 'ไม่พบข้อมูล';
                                        }
                                        ?>
                                </div>
                            </div>

                        </div>
                    </div> <!-- end row -->
                    <div id="danger-alert-modal" class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
                        <div class="modal-dialog modal-sm">
                            <div class="modal-content modal-filled">
                            <div class="modal-header">
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                </div>
                                <div class="modal-body bg-danger">
                                    <div class="text-center">
                                        <i class="dripicons-wrong h1 text-white"></i>
                                        <h4 class="mt-2 text-white">แจ้งเตือน</h4>
                                        <p class="mt-3 text-white">คุณแน่ใจว่าจะลบสิ้นค้าที่เลือก?</p>
                                        <button type="submit" id="deleteButton" name="deleteButton" class="btn btn-light my-2" data-bs-dismiss="modal">ตกลง</button>
                                    </div>
                                    </form>
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

    <script>
        document.getElementById('productForm').addEventListener('submit', function(event) {
            event.preventDefault();

            var checkedCheckboxes = document.querySelectorAll('input[name="prd_id"]:checked');
            var orderArray = [];

            if (checkedCheckboxes.length === 0) {
                alert('กรุณาเลือกสินค้าอย่างน้อย 1 รายการ');
                return;
            }

            checkedCheckboxes.forEach(function(input, index) {
                orderArray.push({
                    "order": index + 1,
                    "prd_id": input.value,
                });
            });

            var queryString = '';
            orderArray.forEach(function(item, index) {
                queryString += 'order' + index + '=' + item.order + '&prd_id' + index + '=' + item.prd_id + '&';
            });
            queryString = queryString.slice(0, -1); // ลบเครื่องหมาย & ที่ไม่จำเป็นที่อยู่ต่ำสุด

            var url = 'product_delete_group.php?location=publ&' + queryString;
            //var url = '#?' + queryString;
            window.location.href = url;
        });
    </script>



    <!-- Right Sidebar -->
    <?php
    require_once('right_ridebar.php');
    ?>

</body>

</html>