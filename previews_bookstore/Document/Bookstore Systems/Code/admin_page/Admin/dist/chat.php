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

                        <div class="col-xl-3 col-lg-4">
                            <div class="card chat-list-card mb-xl-0">
                                <div class="card-body">
                                    <h4 class="mt-0 header-title">แชท</h4>
                                    <br>
                                    <div class="d-flex">
                                        <div class="flex-shrink-0">
                                            <img src="assets/images/users/user-1.jpg" alt="" class="flex-shrink-0 rounded-circle avatar-sm">
                                        </div>
                                        <div class="flex-grow-1 align-items-center ms-2">
                                            <h5 class="mt-0 mb-1">Nowak Helme</h5>
                                            <p class="font-13 text-muted mb-0">Admin Head</p>
                                        </div>

                                    </div>

                                    <hr class="my-3">

                                    <div class="">
                                        <ul class="list-unstyled chat-list mb-0" style="max-height: 413px;" data-simplebar>
                                            <li class="active">
                                                <a href="#">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 chat-user-img active align-self-center me-2">
                                                            <img src="assets/images/users/user-2.jpg" class="rounded-circle avatar-sm" alt="">
                                                        </div>

                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <h5 class="text-truncate font-14 mt-0 mb-1">Margaret Clayton</h5>
                                                            <p class="text-truncate mb-0">I've finished it! See you so...</p>
                                                        </div>
                                                        <div class="font-11">05 min</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 chat-user-img active avatar-sm align-self-center me-2">
                                                            <span class="avatar-title rounded-circle bg-soft-success text-success">
                                                                <i class="mdi mdi-account"></i>
                                                            </span>
                                                        </div>

                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <h5 class="text-truncate font-14 mt-0 mb-1">Jason Bent</h5>
                                                            <p class="text-truncate mb-0">Hey! there I'm available</p>
                                                        </div>
                                                        <div class="font-11">20 min</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="unread">
                                                <a href="#">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 chat-user-img align-self-center me-2">
                                                            <img src="assets/images/users/user-3.jpg" class="rounded-circle avatar-sm" alt="">
                                                        </div>

                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <h5 class="text-truncate font-14 mt-0 mb-1">Mark Nieto</h5>
                                                            <p class="text-truncate mb-0">This theme is awesome!</p>
                                                        </div>
                                                        <div class="font-11">32 min</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li class="unread">
                                                <a href="#">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 chat-user-img active align-self-center me-2">
                                                            <img src="assets/images/users/user-4.jpg" class="rounded-circle avatar-sm" alt="">
                                                        </div>

                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <h5 class="text-truncate font-14 mt-0 mb-1">Garret Sauer</h5>
                                                            <p class="text-truncate mb-0">Nice to meet you</p>
                                                        </div>
                                                        <div class="font-11">01 hr</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 chat-user-img align-self-center me-2">
                                                            <img src="assets/images/users/user-5.jpg" class="rounded-circle avatar-sm" alt="">
                                                        </div>

                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <h5 class="text-truncate font-14 mt-0 mb-1">Michael James</h5>
                                                            <p class="text-truncate mb-0">Good morning</p>
                                                        </div>
                                                        <div class="font-11">01 hr</div>
                                                    </div>
                                                </a>
                                            </li>

                                            <li class="unread">
                                                <a href="#">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 chat-user-img avatar-sm align-self-center me-2">
                                                            <span class="avatar-title  rounded-circle bg-soft-primary text-primary">
                                                                <i class="mdi mdi-account"></i>
                                                            </span>
                                                        </div>

                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <h5 class="text-truncate font-14 mt-0 mb-1">Felicia Johnson</h5>
                                                            <p class="text-truncate mb-0">Meeting 10am</p>
                                                        </div>
                                                        <div class="font-11">02 hr</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 chat-user-img active align-self-center me-2">
                                                            <img src="assets/images/users/user-6.jpg" class="rounded-circle avatar-sm" alt="">
                                                        </div>

                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <h5 class="text-truncate font-14 mt-0 mb-1">Tracy Marsh</h5>
                                                            <p class="text-truncate mb-0">Hey! there I'm available</p>
                                                        </div>
                                                        <div class="font-11">04 hr</div>
                                                    </div>
                                                </a>
                                            </li>
                                            <li>
                                                <a href="#">
                                                    <div class="d-flex">
                                                        <div class="flex-shrink-0 chat-user-img align-self-center me-2">
                                                            <img src="assets/images/users/user-7.jpg" class="rounded-circle avatar-sm" alt="">
                                                        </div>

                                                        <div class="flex-grow-1 overflow-hidden">
                                                            <h5 class="text-truncate font-14 mt-0 mb-1">Richard Lopez</h5>
                                                            <p class="text-truncate mb-0">Nice to meet you</p>
                                                        </div>
                                                        <div class="font-11">05 hr</div>
                                                    </div>
                                                </a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- แจ้งเตือน -->
                        <div class="col-xl-9 col-lg-8">
                            <div class="conversation-list-card card">
                                <div class="card-body">
                                    <div class="d-flex">
                                        <div class="flex-grow-1">
                                            <h5 class="mt-0 mb-1 text-truncate">Margaret Clayton</h5>
                                            <p class="font-13 text-muted mb-0"><i class="mdi mdi-circle text-success me-1 font-11"></i> Active</p>
                                        </div>
                                    </div>
                                    <hr class="my-3">

                                    <div>
                                        <ul class="conversation-list slimscroll" style="max-height: 410px;" data-simplebar>
                                            <li>
                                                <div class="chat-day-title">
                                                    <span class="title">Today</span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="message-list">
                                                    <div class="chat-avatar">
                                                        <img src="assets/images/users/user-2.jpg" alt="">
                                                    </div>
                                                    <div class="conversation-text">
                                                        <div class="ctext-wrap">
                                                            <span class="user-name">Margaret Clayton</span>
                                                            <p>
                                                                Hello!
                                                            </p>
                                                        </div>
                                                        <span class="time">10:00</span>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="odd">
                                                <div class="message-list">
                                                    <div class="chat-avatar">
                                                        <img src="assets/images/users/user-1.jpg" alt="">
                                                    </div>
                                                    <div class="conversation-text">
                                                        <div class="ctext-wrap">
                                                            <span class="user-name">Nowak Helme</span>
                                                            <p>
                                                                Hi, How are you? What about our next meeting?
                                                            </p>
                                                        </div>
                                                        <span class="time">10:01</span>
                                                    </div>
                                                </div>
                                            </li>

                                            <li>
                                                <div class="message-list">
                                                    <div class="chat-avatar">
                                                        <img src="assets/images/users/user-2.jpg" alt="">

                                                    </div>
                                                    <div class="conversation-text">
                                                        <div class="ctext-wrap">
                                                            <span class="user-name">Margaret Clayton</span>
                                                            <p>
                                                                Yeah everything is fine
                                                            </p>
                                                        </div>
                                                        <span class="time">10:03</span>
                                                    </div>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="message-list">
                                                    <div class="chat-avatar">
                                                        <img src="assets/images/users/user-2.jpg" alt="male">

                                                    </div>
                                                    <div class="conversation-text">
                                                        <div class="ctext-wrap">
                                                            <span class="user-name">Margaret Clayton</span>
                                                            <p>
                                                                & Next meeting tomorrow 10.00AM
                                                            </p>
                                                        </div>
                                                        <span class="time">10:03</span>
                                                    </div>
                                                </div>
                                            </li>

                                            <li class="odd">
                                                <div class="message-list">
                                                    <div class="chat-avatar">
                                                        <img src="assets/images/users/user-1.jpg" alt="">
                                                    </div>
                                                    <div class="conversation-text">
                                                        <div class="ctext-wrap">
                                                            <span class="user-name">Nowak Helme</span>
                                                            <p>
                                                                Wow that's great
                                                            </p>
                                                        </div>
                                                        <span class="time">10:04</span>
                                                    </div>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="p-3 conversation-input border-top">
                                    <div class="row">
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-outline-primary waves-effect waves-light"><i class="far fa-images"></i></button>
                                        </div>
                                        <div class="col">
                                            <div>
                                                <input type="text" class="form-control" placeholder="Enter Message...">
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <button type="submit" class="btn btn-primary chat-send width-md waves-effect waves-light"><span class="d-none d-sm-inline-block me-2">Send</span> <i class="mdi mdi-send"></i></button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                    <!-- end row -->
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