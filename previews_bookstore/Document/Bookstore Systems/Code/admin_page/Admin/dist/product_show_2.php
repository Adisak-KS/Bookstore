<?php
require_once __DIR__ . '/../../../connection.php';


$sql_script = "SELECT bk_prd_product.*, product_type.*
FROM bk_prd_product
LEFT JOIN bk_prd_type ON product.pty_id = product_type.pty_id
WHERE product.prd_show = 1 AND product_type.pty_show = 1;
;
";
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
    echo "<script>window.location.href = 'product_show_2.php';</script>";
    exit();
}

// ตรวจสอบสิทธิ์
if (!isset($_SESSION['sale'])) {
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
                    <div class="modal fade" id="scrollable-modal" tabindex="-1" role="dialog" aria-labelledby="scrollableModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="scrollableModalTitle">เพิ่มสินค้า</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- ฟอร์มเพิ่มสินค้า -->

                                    <h4 class="header-title">เพิ่มสินค้า</h4>
                                    <p class="sub-header">...</p>

                                    <form class="needs-validation" novalidate action="product_add.php" method="POST">
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">ชื่อสินค้า</label>
                                            <input type="text" class="form-control" id="prd_name" name="prd_name" placeholder="ชื่อสินค้า" required />
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">รายละเอียดสินค้า</label>
                                            <textarea required="" class="form-control" id="prd_detail" name="prd_detail" style="height: 93px;"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">ราคาสินค้า</label>
                                            <input type="number" class="form-control" id="prd_price" name="prd_price" placeholder="ราคาสินค้า" required />
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">แต้มสะสมที่ได้รับ</label>
                                            <input type="number" class="form-control" id="prd_coin" name="prd_coin" placeholder="แต้มสะสมที่ได้รับ" required />
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">จำนวนสินค้า</label>
                                            <input type="number" class="form-control" id="prd_qty" name="prd_qty" placeholder="จำนวนสินค้า" required />
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">ประเภทสินค้า</label>
                                            <select class="form-select" id="pty_id" name="pty_id">
                                                <option selected="" disabled>โปรดเลือกประเภทสินค้า</option>
                                                <?php
                                                // คำสั่ง SQL เพื่อดึงข้อมูลประเภทสินค้าจากตาราง product_type
                                                $sql_product_type = "SELECT pty_id, pty_name FROM bk_prd_type";
                                                $result_product_type = mysqli_query($proj_connect, $sql_product_type);

                                                // ตรวจสอบว่ามีข้อมูลประเภทสินค้าหรือไม่
                                                if ($result_product_type && mysqli_num_rows($result_product_type) > 0) {
                                                    while ($row_product_type = mysqli_fetch_assoc($result_product_type)) {
                                                        $pty_id = $row_product_type['pty_id'];
                                                        $pty_name = $row_product_type['pty_name'];

                                                        // แสดงตัวเลือกในฟอร์ม
                                                        echo "<option value='$pty_id'>$pty_name</option>";
                                                    }
                                                } else {
                                                    // ถ้าไม่พบข้อมูลประเภทสินค้าให้แสดงข้อความว่า "ไม่พบประเภทสินค้า"
                                                    echo "<option disabled>ไม่พบประเภทสินค้า</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">โปรโมชั่น</label>
                                            <select class="form-select" id="prp_id" name="prp_id">
                                                <option selected="" disabled>โปรดเลือกโปรโมชั่น</option>
                                                <?php
                                                // คำสั่ง SQL เพื่อดึงข้อมูลโปรโมชั่นจากตาราง product_promotion
                                                $sql_promotion = "SELECT prp_id, prp_name FROM bk_promotion";
                                                $result_promotion = mysqli_query($proj_connect, $sql_promotion);

                                                // ตรวจสอบว่ามีข้อมูลโปรโมชั่นหรือไม่
                                                if ($result_promotion && mysqli_num_rows($result_promotion) > 0) {
                                                    while ($row_promotion = mysqli_fetch_assoc($result_promotion)) {
                                                        $prp_id = $row_promotion['prp_id'];
                                                        $prp_name = $row_promotion['prp_name'];

                                                        // แสดงตัวเลือกในฟอร์ม
                                                        echo "<option value='$prp_id'>$prp_name</option>";
                                                    }
                                                } else {
                                                    // ถ้าไม่พบข้อมูลโปรโมชั่นให้แสดงข้อความว่า "ไม่พบโปรโมชั่น"
                                                    echo "<option disabled>ไม่พบโปรโมชั่น</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">สำนักพิมพ์</label>
                                            <select class="form-select" id="publ_id" name="publ_id">
                                                <option selected="" disabled>โปรดเลือกสำนักพิมพ์</option>
                                                <?php
                                                // คำสั่ง SQL เพื่อดึงข้อมูลสำนักพิมพ์จากตาราง publisher
                                                $sql_publisher = "SELECT publ_id, publ_name FROM bk_prd_publisher";
                                                $result_publisher = mysqli_query($proj_connect, $sql_publisher);

                                                // ตรวจสอบว่ามีข้อมูลสำนักพิมพ์หรือไม่
                                                if ($result_publisher && mysqli_num_rows($result_publisher) > 0) {
                                                    while ($row_publisher = mysqli_fetch_assoc($result_publisher)) {
                                                        $publ_id = $row_publisher['publ_id'];
                                                        $publ_name = $row_publisher['publ_name'];

                                                        // แสดงตัวเลือกในฟอร์ม
                                                        echo "<option value='$publ_id'>$publ_name</option>";
                                                    }
                                                } else {
                                                    // ถ้าไม่พบข้อมูลสำนักพิมพ์ให้แสดงข้อความว่า "ไม่พบสำนักพิมพ์"
                                                    echo "<option disabled>ไม่พบสำนักพิมพ์</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>

                                        <button class="btn btn-primary" type="submit" id="addbtn" name="addbtn">บันทึก</button>
                                    </form>

                                </div>
                                <div class="modal-footer">
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
                                    <h4 class="mt-0 header-title">รายการสินค้า</h4>
                                    <br>
                                    <!-- Scrollable modal -->
                                    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#scrollable-modal">เพิ่มสินค้า</button>
                                    <br>
                                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline">
                                        <thead>
                                            <tr>
                                                <th>รูป</th>
                                                <th>ชื่อสินค้า</th>
                                                <th>ราคา</th>
                                                <th>แสดงสินค้า</th>
                                                <th>ประเภท</th>
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
                                                    <td><a href="../../../prd_img/<?php echo $prd_row_result['prd_img']; ?>" target="_blank"><img src="../../../prd_img/<?php echo $prd_row_result['prd_img']; ?>" style="max-height: 50px; max-width: 50px"></a></td>
                                                    <td><?php echo $prd_row_result['prd_name']; ?></td>
                                                    <td><?php echo $prd_row_result['prd_price']; ?></td>
                                                    <td>
                                                        <?php
                                                        if ($prd_row_result['prd_show'] == 1) {
                                                            echo 'แสดง';
                                                        } else {
                                                            echo 'ไม่แสดง';
                                                        }
                                                        ?>
                                                    </td>

                                                    <?php
                                                    $sql_script = "SELECT * FROM bk_prd_type WHERE pty_id = '{$prd_row_result['pty_id']}'";
                                                    $pty_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                                    $pty_row_result = mysqli_fetch_assoc($pty_result);
                                                    ?>
                                                    <td><?php echo $pty_row_result['pty_name']; ?></td>
                                                    <td>
                                                        <!-- ปุ่มแก้ไข -->
                                                        <form action="product_show_form.php" method="post">
                                                            <input type="hidden" name="edit_id" value="<?php echo $prd_row_result['prd_id']; ?>">
                                                            <button type="submit" name="edit_btn" class="btn btn-info waves-effect waves-light"> รายละเอียด</button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <!-- ปุ่มแก้ไข -->
                                                        <form action="product_edit_form.php" method="post">
                                                            <input type="hidden" name="edit_id" value="<?php echo $prd_row_result['prd_id']; ?>">
                                                            <button type="submit" name="edit_btn" class="btn btn-warning waves-effect waves-light"> แก้ไข</button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <!-- ปุ่มลบ -->
                                                        <form action="product_delete_form.php" method="post">
                                                            <input type="hidden" name="edit_id" value="<?php echo $prd_row_result['prd_id']; ?>">
                                                            <button type="submit" name="delete_btn" class="btn btn-danger waves-effect waves-light"> ลบ</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                            } while ($prd_row_result = mysqli_fetch_assoc($prd_result));
                                            ?>
                                        </tbody>
                                    </table>
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