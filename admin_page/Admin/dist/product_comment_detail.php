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
if (!isset($_SESSION['admin']) && !isset($_SESSION['sale'])) {
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

                    <div class="row">
                        <div class="col-sm-12">
                            <div class="card">
                                <div class="bg-picture card-body">
                                <h4 class="mt-0 header-title">รายละเอียดสินค้า</h4>
                                    <br>
                                    <div class="d-flex align-items-top">
                                        <img src="assets/images/gallery/1.jpg" class="img-fluid rounded float-start me-3" style="max-width: 100px; max-height: 100px;" alt="profile-image">

                                        <div class="flex-grow-1 overflow-hidden">
                                            <h4 class="m-0">สินค้า</h4>
                                            <p class="text-muted"><i>นิยาย</i></p>
                                            <p class="font-13">รายละเอียด...</p>
                                            <div class="flex-grow-1 overflow-hidden">
                                        <i class="fas fa-star"></i><span> 4.0/4 รีวิว</span>
                                    </div>
                                        </div>
                                        <div class="clearfix">
                                            <!-- ขวา -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!--/ meta -->


                            <div class="card">
                                <form method="post" class="card-body">
                                    <span class="input-icon icon-end">
                                        <textarea rows="3" class="form-control" placeholder="แสดงความคิดเห็น"></textarea>
                                    </span>
                                    <div class="pt-1 float-end">
                                        <a href="" class="btn btn-primary btn-sm waves-effect waves-light">ส่ง <i class="mdi mdi-send"></i></a>
                                    </div>
                                    <ul class="nav nav-pills profile-pills mt-1">
                                        <li>
                                            <a href="#"><i class=" fa fa-images"></i></a>
                                        </li>
                                    </ul>

                                </form>
                            </div>

                            <div class="card">
                                <div class="card-body">
                                <h4 class="mt-0 header-title">ความคิดเห็น</h4>
                                    <br>
                                    <div class="d-flex align-items-top mb-2">
                                        <img src="assets/images/users/user-1.jpg" alt="" class="flex-shrink-0 comment-avatar avatar-sm rounded me-2">
                                        <div class="flex-grow-1">
                                            <h5 class="mt-0"><a href="#" class="text-dark">Adam Jansen</a><small class="ms-1 text-muted">about 2 minuts ago</small></h5>
                                            <i class="mdi mdi-star"></i><i class="mdi mdi-star"></i><i class="mdi mdi-star"></i><i class="mdi mdi-star"></i><i class="mdi mdi-star-outline"></i>
                                            <p>Story based around the idea of time lapse, animation to post soon!</p>
                                            
                                            <div class="comment-footer">
                                                <h6><a href="#">ตอบกลับ</a></h6>
                                            </div>

                                            <div class="d-flex align-items-top mb-2">
                                                <img src="assets/images/users/user-3.jpg" alt="" class="flex-shrink-0 comment-avatar avatar-sm rounded me-2">
                                                <div class="flex-grow-1">
                                                    <h5 class="mt-0"><a href="#" class="text-dark">John Smith</a><small class="ms-1 text-muted">about 1 hour ago</small></h5>
                                                    <p>Wow impressive!</p>

                                                    <div class="comment-footer">
                                                        <h6><a href="#">ตอบกลับ</a></h6>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-top">
                                                <img src="assets/images/users/user-4.jpg" alt="" class="flex-shrink-0 comment-avatar avatar-sm rounded me-2">
                                                <div class="flex-grow-1">
                                                    <h5 class="mt-0"><a href="#" class="text-dark">Matt Cheuvront</a><small class="ms-1 text-muted">about 2 hour ago</small></h5>
                                                    <p>Wow, that is really nice.</p>

                                                    <div class="comment-footer mb-3">
                                                        <h6><a href="#">ตอบกลับ</a></h6>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--  media -->

                                    <div class="d-flex align-items-top mb-3">
                                        <img src="assets/images/users/user-6.jpg" alt="" class="flex-shrink-0 comment-avatar avatar-sm rounded me-2">
                                        <div class="flex-grow-1">
                                            <h5 class="mt-0"><a href="#" class="text-dark">John Smith</a><small class="ms-1 text-muted">about 4 hour ago</small></h5>
                                            <i class="mdi mdi-star"></i><i class="mdi mdi-star"></i><i class="mdi mdi-star"></i><i class="mdi mdi-star"></i><i class="mdi mdi-star-outline"></i>
                                            <p>i'm in the middle of a timelapse animation myself! (Very different though.) Awesome stuff.</p>

                                            <div class="comment-footer">
                                                <h6><a href="#">ตอบกลับ</a></h6>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="d-flex align-items-top mb-3">
                                        <img src="assets/images/users/user-7.jpg" alt="" class="flex-shrink-0 comment-avatar avatar-sm rounded me-2">
                                        <div class="flex-grow-1">
                                            <h5 class="mt-0"><a href="#" class="text-dark">Nicolai Larson</a><small class="ms-1 text-muted">about 10 hour ago</small></h5>
                                            <i class="mdi mdi-star"></i><i class="mdi mdi-star"></i><i class="mdi mdi-star"></i><i class="mdi mdi-star"></i><i class="mdi mdi-star-outline"></i>

                                            <div class="comment-footer">
                                                <h6><a href="#">ตอบกลับ</a></h6>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="text-center">
                                        <a href="" class="text-danger"><i class="mdi mdi-spin mdi-loading me-1"></i> Load more </a>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div> <!-- container -->

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