<?php
require_once __DIR__ . '/../../../connection.php';

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
    echo "<script>window.location.href = 'comment.php';</script>";
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
                        <div class="col-lg-6">
                            <div class="card">
                                <div class="card-body">


                                    <!-- แสดงความเห็น -->
                                    <form action="comment_add.php" method="post" class="card-body">
                                        <input type="text" id="mmb_id" name="mmb_id" required placeholder="mmb_id">
                                        <input type="text" id="prd_id" name="prd_id" required placeholder="prd_id">
                                        <br>
                                        <label for="datetime">วันที่และเวลา:</label>
                                        <input type="datetime-local" id="datetime" name="datetime" required disabled>
                                        <script>
                                            // ดึงอินพุตของเวลา
                                            var datetimeInput = document.getElementById('datetime');

                                            // สร้างวันที่และเวลาปัจจุบัน
                                            var currentDatetime = new Date();
                                            var year = currentDatetime.getFullYear();
                                            var month = String(currentDatetime.getMonth() + 1).padStart(2, '0'); // เพิ่ม 0 หน้าเลขเดือนถ้าน้อยกว่า 10
                                            var day = String(currentDatetime.getDate()).padStart(2, '0'); // เพิ่ม 0 หน้าวันถ้าน้อยกว่า 10
                                            var hours = String(currentDatetime.getHours()).padStart(2, '0'); // เพิ่ม 0 หน้าชั่วโมงถ้าน้อยกว่า 10
                                            var minutes = String(currentDatetime.getMinutes()).padStart(2, '0'); // เพิ่ม 0 หน้านาทีถ้าน้อยกว่า 10

                                            // กำหนดค่าเริ่มต้นให้กับอินพุตเวลา
                                            datetimeInput.value = `${year}-${month}-${day}T${hours}:${minutes}`;
                                        </script>
                                        <textarea rows="3" class="form-control" placeholder="ความคิดเห็น" id="cmm_detail" name="cmm_detail" ></textarea>
                                        </span>
                                        <div class="pt-1 float-end">
                                            <button type="submit" class="btn btn-primary btn-sm waves-effect waves-light">Send</button>
                                        </div>
                                    </form>
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