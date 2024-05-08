<?php
require_once __DIR__ . '/../../../connection.php';
// ตรวจสอบสิทธิ์
if (isset($_SESSION['super_admin'])) {
    header('Location: admin_show.php');
} 
// elseif (!(isset($_SESSION['sale']) || isset($_SESSION['admin']))) {

//     $_SESSION['status'] = "ไม่พบสิทธิ์การใช้งานในหน้านี้";
//     $_SESSION['status_code'] = "ผิดพลาด";
//     header('Location: login_form.php');
//     exit();
// }

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
                        <?php
                        require_once('databutton.php');
                        ?>
                    </div>
                

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