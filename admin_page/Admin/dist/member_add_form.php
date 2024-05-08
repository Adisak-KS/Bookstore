<?php
require_once __DIR__ . '/../../../connection.php';
session_start();

$sql_script = "SELECT * FROM bk_auth_member";
$mmb_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
$mmb_row_result = mysqli_fetch_assoc($mmb_result);
$mmb_totalrows_result = mysqli_num_rows($mmb_result);

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
    echo "<script>window.location.href = 'member_show.php';</script>";
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
                    <!-- ฟอร์มเพิ่มสมาชิก -->


                    <div class="row">
                        <div class="col-lg-6">

                            <div class="card">
                                <div class="card-body">
                                    <h4 class="header-title">เพิ่มสมาชิก</h4>
                                    <p class="text-muted font-14">
                                        Parsley is a javascript form validation library. It helps you provide your users with feedback on their form submission before sending it to your server.
                                    </p>

                                    <form action="#" class="parsley-examples">
                                        <div class="mb-3">
                                            <label for="userName" class="form-label">User Name<span class="text-danger">*</span></label>
                                            <input type="text" name="nick" parsley-trigger="change" required placeholder="Enter user name" class="form-control" id="userName" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="emailAddress" class="form-label">Email address<span class="text-danger">*</span></label>
                                            <input type="email" name="email" parsley-trigger="change" required placeholder="Enter email" class="form-control" id="emailAddress" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="pass1" class="form-label">Password<span class="text-danger">*</span></label>
                                            <input id="pass1" type="password" placeholder="Password" required class="form-control" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="passWord2" class="form-label">Confirm Password <span class="text-danger">*</span></label>
                                            <input data-parsley-equalto="#pass1" type="password" required placeholder="Password" class="form-control" id="passWord2" />
                                        </div>
                                        <div class="mb-3">
                                            <div class="form-check ">
                                                <input id="checkbox6a" type="checkbox" class="form-check-input" />
                                                <label for="checkbox6a" class="form-check-label">
                                                    Remember me
                                                </label>
                                            </div>
                                        </div>

                                        <div class="text-end">
                                            <button class="btn btn-primary waves-effect waves-light" type="submit">Submit</button>
                                            <button type="reset" class="btn btn-secondary waves-effect">Cancel</button>
                                        </div>
                                    </form>
                                </div>
                            </div> <!-- end card -->
                        </div>
                        <!-- end col -->

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