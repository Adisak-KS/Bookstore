<?php
require_once __DIR__ . '/../../../connection.php';
if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
    $status = $_SESSION['status'];
    $status_code = $_SESSION['status_code'];

    // เช็คว่ามีค่า upload_id ที่ส่งมาผ่าน URL
    if (isset($_GET['upload_id'])) {
        $upload_id = $_GET['upload_id'];

        // เพิ่มโค้ดที่ต้องการใช้งานกับค่า upload_id ได้ที่นี่
        // เช่น ใช้ $upload_id เพื่อดึงข้อมูลหรือประมวลผลต่อไป

        // เคลียร์ค่า session
        unset($_SESSION['status']);
        unset($_SESSION['status_code']);

        // แสดงหน้าต่างข้อความแจ้งเตือน
        echo "<script>alert('$status');</script>";
        echo "<script>window.location.href = '?upload_id=$upload_id';</script>";
        exit();
    }

    // เคลียร์ค่า session
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);

    // แสดงหน้าต่างข้อความแจ้งเตือน
    echo "<script>alert('$status');</script>";
    echo "<script>window.location.href = 'blocked.php';</script>";
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

    <body class="loading authentication-bg authentication-bg-pattern">

        <div class="account-pages mt-5 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="text-center">
                            <p class="text-muted mt-2 mb-4"></p>
                        </div>
                        <div class="card">

                            <div class="card-body p-4">

                                <div class="text-center">
                                    <h1 class="text-error">BLOCKED</h1>
                                    <h3 class="mt-3 mb-2">บัญชีของคุณถูกบล็อค</h3>
                                    <p class="text-muted mb-3"> </p>

                                    <a href="logout.php" class="btn btn-danger waves-effect waves-light"><i class="fas fa-home me-1"></i> เข้าสู่ระบบ</a>
                                </div>
    

                            </div> <!-- end card-body -->
                        </div>
                        <!-- end card -->

                    </div> <!-- end col -->
                </div>
                <!-- end row -->
            </div>
            <!-- end container -->
        </div>
        <!-- end page -->

        <!-- Vendor -->
        <script src="assets/libs/jquery/jquery.min.js"></script>
        <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="assets/libs/simplebar/simplebar.min.js"></script>
        <script src="assets/libs/node-waves/waves.min.js"></script>
        <script src="assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
        <script src="assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
        <script src="assets/libs/feather-icons/feather.min.js"></script>

        <!-- App js -->
        <script src="assets/js/app.min.js"></script>

    </body>

</html>