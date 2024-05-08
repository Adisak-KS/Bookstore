<?php
require_once __DIR__ . '/../../../connection.php';
//session_start();


if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
    $status = $_SESSION['status'];
    $status_code = $_SESSION['status_code'];

    // เคลียร์ค่า session
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);

    // แสดงหน้าต่างข้อความแจ้งเตือน
    echo "<script>alert('$status');</script>";
    echo "<script>window.location.href = 'login_form.php';</script>";
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

    <div class="account-pages my-5">
        <div class="container">

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-4">
                    <div class="card">
                        <div class="card-body p-4">

                            <div class="text-center mb-4">
                                <h4 class="text-uppercase mt-0">เข้าสู่ระบบ</h4>
                            </div>

                            <form class="needs-validation" novalidate action="login.php" method="POST">
                                <div class="mb-3">
                                    <label for="emailaddress" class="form-label">ชื่อผู้ใช้<span class="text-danger">*</span></label>
                                    <input class="form-control" type="text" id="username" name="username" required="" placeholder="ชื่อผู้ใช้" maxlength="50">
                                    <div class="invalid-feedback">
                                        โปรดใส่ชื่อผู้ใช้
                                    </div>
                                </div>

                                <div class="mb-3">
                                    <label for="password" class="form-label">รหัสผ่าน<span class="text-danger">*</span></label>
                                    <input class="form-control" type="password" name="password" required="" id="password" placeholder="รหัสผ่าน" maxlength="50">
                                    <div class="invalid-feedback">
                                        โปรดใส่รหัสผ่าน
                                    </div>
                                </div>

                                <div class="mb-3 d-grid text-center">
                                    <button class="btn btn-primary" name="loginbtn" id="loginbtn" type="submit"> เข้าสู่ระบบ </button>
                                </div>
                            </form>

                        </div> <!-- end card-body -->
                    </div>
                    <!-- end card -->

                    <!-- end row -->

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