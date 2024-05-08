<?php
require_once __DIR__ . '/../../../connection.php';

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
if (!isset($_SESSION['admin'])) {
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
                    <!-- Scrollable modal -->
                    <div class="modal fade" id="scrollable-modal" tabindex="-1" role="dialog" aria-labelledby="scrollableModalTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="scrollableModalTitle">เพิ่มโปรโมชัน</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- ฟอร์มเพิ่มโปรโมชัน -->

                                    <h4 class="header-title">เพิ่มโปรโมชัน</h4>
                                    <form class="needs-validation" novalidate id="dateForm" name="dataForm" action="product_promotion_add.php" method="POST">
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">ชื่อโปรโมชัน<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="prp_name" name="prp_name" placeholder="ชื่อโปรโมชัน" maxlength="20" required />
                                            <div class="invalid-feedback">
                                                โปรดใส่ชื่อโปรโมชัน
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">รายละเอียดโปรโมชัน<span class="text-danger">*</span></label>
                                            <textarea maxlength="50" required="" class="form-control" id="prp_detail" name="prp_detail" placeholder="รายละเอียดโปรโมชัน" style="height: 93px;"></textarea>
                                            <div class="invalid-feedback">
                                                โปรดใส่รายละเอียดโปรโมชัน
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">ส่วนลดโปรโมชัน<span class="text-danger">*</span></label>
                                            <div class="input-group input-group-merge">
                                                <input type="number" class="form-control" id="prp_discount" name="prp_discount" placeholder="ส่วนลดโปรโมชัน" min="1" max="99" required />
                                                <div class="input-group-text">
                                                    <span class="fe-percent"></span>
                                                </div>
                                            </div>
                                            <div class="invalid-feedback">
                                                โปรดใส่ส่วนลดโปรโมชัน
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-md-5">
                                                <div class="mb-3">
                                                    <label for="start_date" class="form-label">วันที่เริ่มต้น<span class="text-danger">*</span></label>
                                                    <input class="form-control" id="prp_start" type="date" name="prp_start" required>
                                                    <div class="invalid-feedback">กรุณาเลือกวันที่เริ่มต้นให้ถูกต้อง</div>
                                                </div>
                                            </div>
                                            <div class="col-md-5">
                                                <div class="mb-3">
                                                    <label for="end_date" class="form-label">วันที่สิ้นสุด<span class="text-danger">*</span></label>
                                                    <input class="form-control" id="prp_end" type="date" name="prp_end" required>
                                                    <div class="invalid-feedback">กรุณาเลือกวันที่สิ้นสุดให้ถูกต้อง</div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="submit" id="addbtn" name="addbtn" class="btn btn-success waves-effect waves-light"><i class="dripicons-checkmark"></i> บันทึก</button>
                                    </form>
                                    <script>
                                        document.getElementById("addbtn").addEventListener("click", function(event) {
                                            event.preventDefault(); // หยุดการกระทำของปุ่มเพื่อป้องกันการโหลดหน้าใหม่

                                            // ตรวจสอบความถูกต้องของฟอร์มโดยใช้ checkValidity()
                                            if (!document.getElementById("dateForm").checkValidity()) {
                                                // ถ้าฟอร์มไม่ถูกต้อง ให้ทำการแสดง feedback และหยุดการทำงาน
                                                document.getElementById("dateForm").classList.add('was-validated');
                                                return;
                                            }

                                            var startDate = document.getElementById("prp_start").value;
                                            var endDate = document.getElementById("prp_end").value;

                                            // ตรวจสอบว่าวันที่สิ้นสุดมากกว่าหรือเท่ากับวันที่เริ่มต้น
                                            if (endDate < startDate) {
                                                document.getElementById("prp_start").classList.remove("is-valid");
                                                document.getElementById("prp_start").classList.add("is-invalid");
                                                document.getElementById("prp_end").classList.remove("is-valid");
                                                document.getElementById("prp_end").classList.add("is-invalid");
                                                return;
                                            }

                                            // ถ้าข้อมูลถูกต้อง ให้ส่งข้อมูลไปยังหน้าที่เป้าหมาย
                                            document.forms["dataForm"].submit();
                                        });
                                    </script>





                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">ปิด</button>
                                    <!-- <button type="button" class="btn btn-primary">บันทึก</button> -->
                                </div>
                            </div>
                        </div><!-- /.modal-content -->
                    </div><!-- /.modal-dialog -->
                </div><!-- /.modal -->


                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">รายการโปรโมชัน</h4>
                                <br>
                                <button type="button" data-bs-toggle="modal" data-bs-target="#scrollable-modal" class="btn btn-success waves-effect waves-light"><i class="far fa-plus-square"></i> เพิ่มโปรโมชัน</button>
                                <br><br>

                                <?php
                                $sql_script = "SELECT * FROM bk_promotion WHERE prp_id != 69;                                ";
                                $prp_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                $prp_row_result = mysqli_fetch_assoc($prp_result);
                                $prp_totalrows_result = mysqli_num_rows($prp_result);
                                if ($prp_row_result > 0) {
                                ?>
                                    <table id="datatable" class="table table-striped table-bordered dt-responsive nowrap dataTable no-footer dtr-inline">
                                        <thead>
                                            <tr>
                                                <th>ชื่อโปรโมชัน</th>
                                                <th>ส่วนลด</th>
                                                <th>วันที่เริ่ม</th>
                                                <th>วันที่สิ้นสุด</th>
                                                <th>แสดงโปรโมชัน</th>
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
                                                    <!-- ส่วนแสดงข้อมูลสมาชิก -->
                                                    <td><?php echo $prp_row_result['prp_name']; ?></td>
                                                    <td><?php echo $prp_row_result['prp_discount']; ?></td>
                                                    <td><?php echo $prp_row_result['prp_start']; ?></td>
                                                    <td><?php echo $prp_row_result['prp_end']; ?></td>
                                                    <td><?php
                                                        if ($prp_row_result['prp_show'] == 0) {
                                                            echo 'ไม่แสดง';
                                                        } else {
                                                            echo 'แสดง';
                                                        }
                                                        ?></td>
                                                    <td>
                                                        <!-- ปุ่มแก้ไข -->
                                                        <div class="button-list">
                                                            <form action="product_promotion_show_form.php" method="post">
                                                                <input type="hidden" name="edit_id" value="<?php echo $prp_row_result['prp_id']; ?>">
                                                                <button type="submit" name="edit_btn" class="btn btn-info btn-sm waves-effect waves-light"><i class="fe-eye"></i> รายละเอียด</button>
                                                            </form>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <!-- ปุ่มแก้ไข -->
                                                        <form action="product_promotion_edit_form.php" method="post">
                                                            <input type="hidden" name="edit_id" value="<?php echo $prp_row_result['prp_id']; ?>">
                                                            <button type="submit" name="edit_btn" class="btn btn-warning btn-sm waves-effect waves-light"><i class="far fa-edit"></i> แก้ไข</button>
                                                        </form>
                                                    </td>
                                                    <td>
                                                        <!-- ปุ่มลบ -->
                                                        <form action="product_promotion_delete_form.php" method="post">
                                                            <input type="hidden" name="edit_id" value="<?php echo $prp_row_result['prp_id']; ?>">
                                                            <button type="submit" name="delete_btn" class="btn btn-danger btn-sm waves-effect waves-light"><i class="mdi mdi-delete"></i> ลบ</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php
                                            } while ($prp_row_result = mysqli_fetch_assoc($prp_result));
                                            ?>
                                        </tbody>
                                    </table>
                                <?php
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