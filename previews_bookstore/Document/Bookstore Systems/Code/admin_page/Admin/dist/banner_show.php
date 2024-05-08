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
if (!(isset($_SESSION['admin']))) {
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
                                    <h5 class="modal-title" id="scrollableModalTitle">เพิ่มแบนเนอร์</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <!-- ฟอร์มเพิ่มแบนเนอร์ -->

                                    <h4 class="header-title">เพิ่มแบนเนอร์</h4>

                                    <form class="needs-validation" novalidate action="banner_add.php" method="POST" enctype="multipart/form-data">
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">ชื่อแบนเนอร์<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control" id="bnn_name" name="bnn_name" placeholder="ชื่อแบนเนอร์" required maxlength="50" />
                                            <div class="invalid-feedback">
                                                โปรดใส่ชื่อแบนเนอร์
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">รูปภาพแบนเนอร์<span class="text-danger">*</span></label>
                                            <input type="file" class="form-control" id="bnn_image" name="bnn_image" accept="image/jpeg, image/png, image/gif" required>
                                            <div class="invalid-feedback">
                                                โปรดใส่รูปภาพแบนเนอร์
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label for="validationCustom01" class="form-label">ลิ้งก์แบนเนอร์<span class="text-danger">*</span></label>
                                            <input type="url" required="" maxlength="200" class="form-control" id="bnn_link" name="bnn_link" placeholder="ลิ้งก์แบนเนอร์ เช่น https://www.google.co.th/">
                                            <div class="invalid-feedback">
                                                โปรดใส่ลิ้งก์แบนเนอร์
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
                        <div class="col-6">
                            <div class="card">
                                <div class="card-body">
                                    <h4 class="mt-0 header-title">จัดการแบนเนอร์</h4>
                                    <br>
                                    <button type="button" class="btn btn-success waves-effect waves-light" data-bs-toggle="modal" data-bs-target="#scrollable-modal"><i class="far fa-plus-square"></i> เพิ่มแบนเนอร์</button>
                                    <br><br>
                                    <?php
                                    $sql_script = "SELECT * FROM bk_set_banner
                                    ORDER BY CASE WHEN bnn_order = 0 THEN 1 ELSE 0 END, bnn_order;
                                    ";
                                    $bnn_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());

                                    if (mysqli_num_rows($bnn_result) > 0) { // ตรวจสอบว่ามีข้อมูลในฐานข้อมูลหรือไม่
                                    ?>
                                        <form action="#" id="banner_form" name="banner_form">
                                            <div class="col-xl-12">
                                                <div class="card-body taskboard-box">
                                                    <ul class="sortable-list list-unstyled taskList" id="upcoming">
                                                        <?php
                                                        while ($bnn_row_result = mysqli_fetch_assoc($bnn_result)) { // วนลูปแสดงข้อมูลที่ได้จากการ query
                                                        ?>

                                                            <li>
                                                                <div class="kanban-box">
                                                                    <div class="checkbox-wrapper float-start">
                                                                    </div>
                                                                    <div class="kanban-detail">
                                                                        <ul class="list-inline">
                                                                            <li class="list-inline-item">
                                                                                <img src="../../../bnn_image/<?= $bnn_row_result['bnn_image'] ?>" alt="image" class="img-fluid img-thumbnail" width="100" style="max-height: 100px;" />
                                                                            </li>

                                                                            <li class="list-inline-item">
                                                                                <h5 class="mt-0"><?= $bnn_row_result['bnn_name'] ?></h5>

                                                                                <div class="form-check form-check-success ">
                                                                                    <?php
                                                                                    if ($bnn_row_result['bnn_show'] == 0) {
                                                                                    ?>
                                                                                        <input class="form-check-input" type="checkbox" id="bnn_show" name="bnn_show" value="1" aria-label="Single checkbox Two">
                                                                                    <?php
                                                                                    } else {
                                                                                    ?>
                                                                                        <input class="form-check-input" type="checkbox" id="bnn_show" name="bnn_show" value="0" checked aria-label="Single checkbox Two">
                                                                                    <?php
                                                                                    }
                                                                                    ?>
                                                                                    <input type="text" name="bnn_id" id="bnn_id" hidden value="<?= $bnn_row_result['bnn_id'] ?>">
                                                                                    <label>แสดง<span class="text-danger">*</span></label>
                                                                                </div>
                                                                            </li>
                                                                        </ul>
                                                                        <ul class="list-inline">
                                                                            <div class="text-end">
                                                                                <button type="button" onclick="editBanner(<?= $bnn_row_result['bnn_id'] ?>);" class="btn btn-warning btn-sm waves-effect waves-light"><i class="far fa-edit"></i> แก้ไข</button>

                                                                                <script>
                                                                                    function editBanner(bnn_id) {
                                                                                        // เก็บค่า bnn_id ใน $_SESSION['edit_id']
                                                                                        <?php $_SESSION['edit_id'] = $bnn_row_result['bnn_id']; ?>;

                                                                                        // ส่งไปยังหน้า banner_edit_form.php โดยไม่ต้องใช้ URL แบบ GET
                                                                                        location.href = 'banner_edit_form.php';
                                                                                    }
                                                                                </script>

                                                                                <button type="button" name="delete_btn" onclick="delBanner(<?= $bnn_row_result['bnn_id'] ?>);" class="btn btn-danger btn-sm waves-effect waves-light"><i class="mdi mdi-delete"></i> ลบ</button>

                                                                                <script>
                                                                                    function delBanner(bnn_id) {
                                                                                        // เก็บค่า bnn_id ใน $_SESSION['edit_id']
                                                                                        <?php $_SESSION['edit_id'] = $bnn_row_result['bnn_id']; ?>;

                                                                                        // ส่งไปยังหน้า banner_edit_form.php โดยไม่ต้องใช้ URL แบบ GET
                                                                                        location.href = 'banner_delete_form.php';
                                                                                    }
                                                                                </script>

                                                                            </div>
                                                                        </ul>
                                                                    </div>
                                                                </div>
                                                            </li>
                                                        <?php
                                                        }
                                                        ?>
                                                    </ul>

                                                </div>

                                            </div><!-- end col -->
                                            <div class="text-end">
                                                <button type="submit" class="btn btn-warning btn-sm waves-effect waves-light"><i class="far fa-edit"></i> บันทึก</button>
                                            </div>
                                        </form>
                                    <?php
                                    } else {
                                        echo '<p>ไม่พบข้อมูล</p>';
                                    }
                                    ?>
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
        <script>
            document.getElementById('banner_form').addEventListener('submit', function(event) {
                event.preventDefault();

                var bnnIds = document.querySelectorAll('input[name="bnn_id"]');
                var bnnShows = document.querySelectorAll('input[name="bnn_show"]');
                var orderArray = [];

                bnnIds.forEach(function(input, index) {
                    orderArray.push({
                        "order": index + 1,
                        "bnn_id": input.value,
                        "bnn_show": bnnShows[index].checked ? 1 : 0 // เช็คว่า checkbox ถูกเลือกหรือไม่
                    });
                });

                var queryString = '';
                orderArray.forEach(function(item, index) {
                    queryString += 'order' + index + '=' + item.order + '&bnn_id' + index + '=' + item.bnn_id + '&bnn_show' + index + '=' + item.bnn_show + '&';
                });
                queryString = queryString.slice(0, -1); // ลบเครื่องหมาย & ที่ไม่จำเป็นที่อยู่ต่ำสุด

                var url = 'banner_edit.php?' + queryString;
                window.location.href = url;
            });
        </script>





        <!-- Vendor -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>
        <script src="assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
        <script src="assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
        <script src="assets/libs/feather-icons/feather.min.js"></script>

        <!-- <script src="assets/libs/sortablejs/Sortable.min.js"></script> -->

        <!-- Jquery Ui js -->
        <script src="assets/libs/jquery-ui/jquery-ui.min.js"></script>

        <!-- Modal-Effect -->
        <script src="assets/libs/custombox/custombox.min.js"></script>

        <!-- Init -->
        <script src="assets/js/pages/kanban.init.js"></script>

        <!-- draggable init -->
        <!-- <script src="assets/js/pages/draggable.init.js"></script> -->

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>
        <!-- Right Sidebar -->
        <?php
        require_once('right_ridebar.php');
        ?>

</body>

</html>