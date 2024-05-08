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
if (isset($_POST['edit_id'])) {
    $edit_id = $_POST['edit_id'];
    $_SESSION['edit_id'] = $edit_id;
} elseif ($_SESSION['edit_id']) {
    $edit_id = $_SESSION['edit_id'];
} else {
    echo "<script>alert('ผิดพลาด ไม่พบสินค้า'); window.location='product_show.php';</script>";
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
    echo "<script>window.location.href = 'product_edit_form.php';</script>";
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
                                    <form action="product_edit.php" class="parsley-examples needs-validation" novalidate method="POST">
                                        <div class="mb-3">
                                            <input type="text" hidden id="prd_id" name="prd_id" value="<?php echo $prd_row_result['prd_id'] ?>">
                                            <label for="prd_detail" class="form-label">ชื่อสินค้า<span class="text-danger">*</span></label>
                                            <input type="text" name="prd_name" parsley-trigger="change" class="form-control" id="prd_name" value="<?php echo $prd_row_result['prd_name'] ?>" maxlength="50" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่ชื่อสินค้า
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="prd_detail" class="form-label">รายละเอียดสินค้า<span class="text-danger">*</span></label>
                                            <textarea name="prd_detail" parsley-trigger="change" class="form-control" id="prd_detail" rows="4" maxlength="100" required><?php echo $prd_row_result['prd_detail'] ?></textarea>
                                            <div class="invalid-feedback">
                                                โปรดใส่รายละเอียดสินค้า
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="prd_detail" class="form-label">ราคาสินค้า<span class="text-danger">*</span></label>
                                            <input type="number" name="prd_price" parsley-trigger="change" class="form-control" id="prd_price" min="1" max="100000" required value="<?php echo $prd_row_result['prd_price'] ?>" />
                                            <div class="invalid-feedback">
                                                โปรดใส่ราคาสินค้า
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="prd_detail" class="form-label">ส่วนลดสินค้า<span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <input type="number" name="prd_discount" parsley-trigger="change" class="form-control" id="prd_discount" min="0" max="99" required value="<?php echo $prd_row_result['prd_discount'] ?>" />
                                                <div class="input-group-text">
                                                    <span class="fe-percent"></span>
                                                </div>
                                                <div class="invalid-feedback">
                                                โปรดใส่ลดสินค้าให้ถูกต้อง
                                            </div>
                                            </div>
                                            
                                        </div>
                                        <div class="mb-3">
                                            <label for="prd_detail" class="form-label">แต้มสะสม<span class="text-danger">*</span></label>
                                            <input type="number" name="prd_coin" parsley-trigger="change" class="form-control" id="prd_coin" min="1" max="100000" required value="<?php echo $prd_row_result['prd_coin'] ?>" />
                                            <div class="invalid-feedback">
                                                โปรดใส่แต้มสะสม
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="prd_detail" class="form-label">จำนวนสินค้า<span class="text-danger">*</span></label>
                                            <input type="number" name="prd_qty" parsley-trigger="change" class="form-control" id="prd_qty" min="1" max="100000" required value="<?php echo $prd_row_result['prd_qty'] ?>" />
                                            <div class="invalid-feedback">
                                                โปรดใส่จำนวนสินค้า
                                            </div>
                                        </div>
                                        <?php
                                        $sql_script = "SELECT * FROM bk_prd_type WHERE pty_id = '{$prd_row_result['pty_id']}'";
                                        $pty_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                        $pty_row_result = mysqli_fetch_assoc($pty_result);
                                        ?>
                                        <div class="mb-3">
                                            <label for="prd_detail" class="form-label">แสดงสินค้า<span class="text-danger">*</span></label>
                                            <select name="prd_show" parsley-trigger="change" class="form-select" id="prd_show" required>
                                                <option value="0" <?php echo ($prd_row_result['prd_show'] == '0') ? 'selected' : ''; ?>>ไม่แสดง</option>
                                                <option value="1" <?php echo ($prd_row_result['prd_show'] == '1') ? 'selected' : ''; ?>>แสดง</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                โปรดเลือกแสดงสินค้า
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="prd_detail" class="form-label">ชนิดสินค้า<span class="text-danger">*</span></label>
                                            <select name="prd_preorder" parsley-trigger="change" class="form-select" id="prd_preorder" required>
                                                <option value="0" <?php echo ($prd_row_result['prd_preorder'] == '0') ? 'selected' : ''; ?>>สินค้าปกติ</option>
                                                <option value="1" <?php echo ($prd_row_result['prd_preorder'] == '1') ? 'selected' : ''; ?>>สินค้าพรีออเดอร์</option>
                                            </select>
                                            <div class="invalid-feedback">
                                                โปรดชนิดชนิดสินค้า
                                            </div>
                                        </div>

                                        <div class="mb-3">
                                            <label for="prd_detail" class="form-label">ประเภทสินค้า<span class="text-danger">*</span></label>
                                            <select name="pty_id" id="pty_id" class="form-select" required>
                                                <?php
                                                // คิวรีเพื่อดึงข้อมูลประเภทสินค้าทั้งหมด
                                                $sql_script = "SELECT * FROM bk_prd_type";
                                                $pty_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());

                                                // วนลูปเพื่อสร้างตัวเลือกสำหรับแต่ละประเภทสินค้า
                                                while ($pty_row_result = mysqli_fetch_assoc($pty_result)) {
                                                    $pty_id = $pty_row_result['pty_id'];
                                                    $pty_name = $pty_row_result['pty_name'];

                                                    // ตรวจสอบว่าประเภทสินค้าที่เลือกตรงกับประเภทสินค้าปัจจุบันหรือไม่
                                                    $selected = ($pty_id == $prd_row_result['pty_id']) ? "selected" : "";

                                                    // สร้างตัวเลือก
                                                    echo "<option value='$pty_id' $selected>$pty_name</option>";
                                                }
                                                ?>
                                            </select>
                                            <div class="invalid-feedback">
                                                โปรดเลือกประเภทสินค้า
                                            </div>
                                        </div>
                                        <?php
                                        $sql_script = "SELECT * FROM bk_prd_publisher WHERE publ_id = '{$prd_row_result['publ_id']}'";
                                        $publ_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                        $publ_row_result = mysqli_fetch_assoc($publ_result);
                                        ?>
                                        <div class="mb-3">
                                            <label for="publ_id" class="form-label">สำนักพิมพ์<span class="text-danger">*</span></label>
                                            <select name="publ_id" id="publ_id" class="form-select" required>
                                                <?php
                                                // คิวรีเพื่อดึงข้อมูลสำนักพิมพ์ทั้งหมด
                                                $sql_script = "SELECT * FROM bk_prd_publisher";
                                                $publ_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());

                                                // วนลูปเพื่อสร้างตัวเลือกสำหรับแต่ละสำนักพิมพ์
                                                while ($publ_row_result = mysqli_fetch_assoc($publ_result)) {
                                                    $publ_id = $publ_row_result['publ_id'];
                                                    $publ_name = $publ_row_result['publ_name'];

                                                    // ตรวจสอบว่าสำนักพิมพ์ที่เลือกตรงกับสำนักพิมพ์ปัจจุบันหรือไม่
                                                    $selected = ($publ_id == $prd_row_result['publ_id']) ? "selected" : "";

                                                    // สร้างตัวเลือก
                                                    echo "<option value='$publ_id' $selected>$publ_name</option>";
                                                }
                                                ?>
                                            </select>
                                        </div>
                                        <?php
                                        $sql_script = "SELECT * FROM bk_promotion WHERE prp_id = '{$prd_row_result['prp_id']}'";
                                        $prp_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                        $prp_row_result = mysqli_fetch_assoc($prp_result);
                                        ?>

                                        <div class="text-end">
                                            <button class="btn btn-warning btn-sm waves-effect waves-light" type="submit" id="editbtn" name="editbtn"><i class="far fa-edit"></i> บันทึก</button>
                                            <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='<?= $_SESSION['location_prd_show'] ?>'">ย้อนกลับ</button>

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
                                        <img class="card-img-top img-fluid" src="../../../prd_img/<?php echo $prd_row_result['prd_img']; ?>" alt="Card image cap" style="max-width: 200px;">
                                        <div class="card-body">
                                            <h4 class="card-title">รูปสินค้า</h4>
                                        </div>
                                        <form action="product_upload.php" method="post" enctype="multipart/form-data">

                                            <input type="text" hidden id="prd_id" name="prd_id" value="<?php echo $prd_row_result['prd_id'] ?>">
                                            <div class="mb-3">
                                                <label for="fileToUpload">เลือกรูปภาพที่ต้องการอัปโหลด:<span class="text-danger"> (ขนาดที่แนะนำ ความสูง 620px, ความกว้าง 420px)*</span></label>
                                                <input type="file" class="form-control" name="image" id="fileToUpload" accept="image/jpeg, image/png, image/gif">
                                            </div>
                                            <div class="text-end">
                                                <button class="btn btn-warning btn-sm waves-effect waves-light" type="submit" id="submit" name="submit"><i class="far fa-edit"></i> บันทึก</button>
                                            </div>
                                        </form>
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
            <script>
                function validateDiscount() {
                    var checkboxes = document.getElementsByName('prp_id[]');
                    var totalDiscount = 0;
                    for (var i = 0; i < checkboxes.length; i++) {
                        if (checkboxes[i].checked) {
                            // เก็บค่าส่วนลดของโปรโมชันที่เลือก
                            var discount = parseInt(checkboxes[i].parentNode.nextElementSibling.nextElementSibling.innerText);
                            totalDiscount += discount;
                        }
                    }
                    // ตรวจสอบว่าผลรวมของส่วนลดไม่เกิน 99
                    if (totalDiscount <= 99) {
                        return true; // ส่งฟอร์มไปยัง product_edit.php
                    } else {
                        alert('ผลรวมของส่วนลดไม่สามารถเกิน 99');
                        return false; // ไม่ส่งฟอร์ม
                    }
                }
            </script>
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