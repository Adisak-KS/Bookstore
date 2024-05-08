<?php
require_once __DIR__ . '/../../../connection.php';

$sql_script = "SELECT bk_prd_product.*, bk_prd_type.pty_name
FROM bk_prd_product
INNER JOIN bk_prd_type ON bk_prd_product.pty_id = bk_prd_type.pty_id;
";
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

                                    <form class="needs-validation" novalidate action="product_add.php" method="POST">
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">ชื่อสินค้า<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="prd_name" name="prd_name" placeholder="ชื่อสินค้า" required maxlength="50" />
                                            <div class="invalid-feedback">
                                                โปรดใส่ชื่อสินค้า
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">รายละเอียดสินค้า<span class="text-danger">*</span></label>
                                            <textarea required="" maxlength="200" class="form-control" id="prd_detail" name="prd_detail" style="height: 93px;" placeholder="รายละเอียดสินค้า"></textarea>
                                            <div class="invalid-feedback">
                                                โปรดใส่รายละเอียดสินค้า
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">ราคาสินค้า<span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="prd_price" name="prd_price" placeholder="ราคาสินค้า" min="0" max="100000" required maxlength="5" />
                                            <div class="invalid-feedback">
                                                โปรดใส่ราคาสินค้า
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">ส่วนลดสินค้า<span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <input type="number" class="form-control" id="prd_discount" name="prd_discount" placeholder="ส่วนลดสินค้า" min="0" max="99" required value="0" maxlength="2" />
                                                <div class="input-group-text">
                                                    <span class="fe-percent"></span>
                                                </div>
                                                <div class="invalid-feedback">
                                                    โปรดใส่ส่วนลดสินค้าให้ถูกต้อง
                                                </div>
                                            </div>

                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">แต้มสะสมที่ได้รับ<span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="prd_coin" name="prd_coin" placeholder="แต้มสะสมที่ได้รับ" min="0" max="100000" required maxlength="5" />
                                            <div class="invalid-feedback">
                                                โปรดใส่แต้มสะสมที่ได้รับ
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">จำนวนสินค้า<span class="text-danger">*</span></label>
                                            <input type="number" class="form-control" id="prd_qty" name="prd_qty" placeholder="จำนวนสินค้า" min="0" max="100000" required maxlength="5" />
                                            <div class="invalid-feedback">
                                                โปรดใส่จำนวนสินค้า
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">ประเภทสินค้า<span class="text-danger">*</span></label>
                                            <select name="pty_id" id="pty_id" class="form-select" required>
                                                <option value="" disabled selected>กรุณาเลือกประเภทสินค้า</option>
                                                <?php
                                                // คิวรีเพื่อดึงข้อมูลประเภทสินค้าทั้งหมด
                                                $sql_script = "SELECT * FROM bk_prd_type";
                                                $pty_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());

                                                // วนลูปเพื่อสร้างตัวเลือกสำหรับแต่ละประเภทสินค้า
                                                while ($pty_row_result = mysqli_fetch_assoc($pty_result)) {
                                                    $pty_id = $pty_row_result['pty_id'];
                                                    $pty_name = $pty_row_result['pty_name'];

                                                    // สร้างตัวเลือก
                                                    echo "<option value='$pty_id'>$pty_name</option>";
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                โปรดเลือกประเภทสินค้า
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">สำนักพิมพ์<span class="text-danger">*</span></label>
                                            <select name="publ_id" id="publ_id" class="form-select" required>
                                                <option value="" selected disabled>กรุณาเลือกสำนักพิมพ์</option>
                                                <?php
                                                // คิวรีเพื่อดึงข้อมูลสำนักพิมพ์ทั้งหมด
                                                $sql_script = "SELECT * FROM bk_prd_publisher";
                                                $publ_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());

                                                // วนลูปเพื่อสร้างตัวเลือกสำหรับแต่ละสำนักพิมพ์
                                                while ($publ_row_result = mysqli_fetch_assoc($publ_result)) {
                                                    $publ_id = $publ_row_result['publ_id'];
                                                    $publ_name = $publ_row_result['publ_name'];

                                                    // สร้างตัวเลือก
                                                    echo "<option value='$publ_id'>$publ_name</option>";
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                โปรดเลือกสำนักพิมพ์
                                            </div>
                                        </div>
                                        <label for="validationCustom01" class="form-label">ชนิดสินค้า<span class="text-danger">*</span></label>
                                        <div class="form-check mb-2 form-check-success">
                                            <input class="form-check-input" type="radio" name="prd_preorder" id="prd_preorder" value="0" required>
                                            <label class="form-check-label" for="customradio2">สินค้าปกติ</label>
                                            <div class="invalid-feedback">
                                                โปรดเลือกชนิดสินค้า
                                            </div>
                                        </div>
                                        <div class="form-check mb-2 form-check-success">
                                            <input class="form-check-input" type="radio" name="prd_preorder" id="prd_preorder" value="1" required>
                                            <label class="form-check-label" for="customradio2">สินค้าพรีออเดอร์</label>
                                            <div class="invalid-feedback">
                                                โปรดเลือกชนิดสินค้า
                                            </div>
                                        </div>



                                </div>
                                <div class="modal-footer">
                                    <button class="btn btn-success waves-effect waves-light" type="submit" id="addbtn" name="addbtn"><i class="dripicons-checkmark"></i> บันทึก</button>
                                    </form>
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="dripicons-cross"></i> ปิด</button>
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
                                    <button type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#scrollable-modal"><i class="far fa-plus-square"></i> เพิ่มสินค้า</button>
                                    <br><br>
                                    <?php
                                    if ($prd_row_result > 0) {
                                    ?>
                                        <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline">
                                            <thead>
                                                <tr>
                                                    <th>รูป</th>
                                                    <th>ชื่อสินค้า</th>
                                                    <th>ราคา</th>
                                                    <th>แสดงสินค้า</th>
                                                    <th>พรีออเดอร์</th>
                                                    <th></th>
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
                                                        <td>
                                                            <!-- ปุ่มลบ -->
                                                            <div class="button-list">
                                                                <form action="product_delete_form.php" method="post">
                                                                    <input type="hidden" name="edit_id" value="<?php echo $prd_row_result['prd_id']; ?>">
                                                                    <button type="submit" name="delete_btn" class="btn btn-danger btn-sm waves-effect waves-light"><i class="mdi mdi-delete"></i> ลบ</button>
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
                                    } else {
                                        echo 'ไม่พบข้อมูล';
                                    }
                                    ?>
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