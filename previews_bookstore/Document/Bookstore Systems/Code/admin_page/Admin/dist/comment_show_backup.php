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
    echo "<script>window.location.href = 'comment_show.php';</script>";
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

                    <div class="row">
                        <div class="card">
                            <div class="card-body">
                                <?php
                                $sql_script = "SELECT * FROM bk_prd_comment ORDER BY cmm_date DESC LIMIT 10";
                                $cmm_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                $cmm_row_result = mysqli_fetch_assoc($cmm_result);
                                $cmm_totalrows_result = mysqli_num_rows($cmm_result);
                                ?>
                                <div class="dropdown float-end">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">ความเห็นทั้งหมด</a>
                                    </div>
                                </div>

                                <h4 class="header-title mt-0 mb-3">ความคิดเห็นล่าสุด</h4>

                                <?php do {
                                    $prd_id = $cmm_row_result['prd_id'];
                                    $sql_script = "SELECT prd_name FROM bk_prd_product WHERE prd_id = '$prd_id'";
                                    $prd_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                    $prd_row_result = mysqli_fetch_assoc($prd_result);

                                    $mmb_id = $cmm_row_result['mmb_id'];
                                    $sql_script = "SELECT mmb_username FROM bk_auth_member WHERE mmb_id = '$mmb_id'";
                                    $mmb_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                    $mmb_row_result = mysqli_fetch_assoc($mmb_result);
                                ?>
                                    <ul class="list-group mb-0 user-list">
                                        <li class="list-group-item">
                                            <a href="#" class="user-list-item">

                                                <div class="user-desc overflow-hidden">
                                                    <h5 class="name mt-0 mb-1"><?php echo $cmm_row_result['cmm_detail']; ?></h5>
                                                    <span class="desc text-muted font-12 text-truncate d-block">
                                                        <?php echo $prd_row_result['prd_name'] . " โดย " . $mmb_row_result['mmb_username'] . " เวลา " . $cmm_row_result['cmm_date']; ?>
                                                    </span>
                                                </div>
                                            </a>
                                        </li>
                                    </ul>
                                <?php
                                } while ($cmm_row_result = mysqli_fetch_assoc($cmm_result));
                                ?>
                            </div>
                        </div>
                        <div class="card">
                            <div class="card-body">
                                <div class="dropdown float-end">
                                    <a href="#" class="dropdown-toggle arrow-none card-drop" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class="mdi mdi-dots-vertical"></i>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-end">
                                        <!-- item-->
                                        <a href="javascript:void(0);" class="dropdown-item">ความเห็นทั้งหมด</a>
                                    </div>
                                </div>

                                <h4 class="header-title mt-0 mb-3">ความคิดเห็นล่าสุด</h4>

                                <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th>ความคิดเห็น</th>
                                                <th>สินค้า</th>
                                                <th>สมาชิก</th>
                                                <th>เวลา</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $sql_script = "SELECT * FROM bk_prd_comment ORDER BY cmm_date DESC LIMIT 10";
                                            $cmm_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                            $cmm_row_result = mysqli_fetch_assoc($cmm_result);
                                            $cmm_totalrows_result = mysqli_num_rows($cmm_result);
                                            do {
                                                $prd_id = $cmm_row_result['prd_id'];
                                                $sql_script = "SELECT prd_name FROM bk_prd_product WHERE prd_id = '$prd_id'";
                                                $prd_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                                $prd_row_result = mysqli_fetch_assoc($prd_result);

                                                $mmb_id = $cmm_row_result['mmb_id'];
                                                $sql_script = "SELECT mmb_username FROM bk_auth_member WHERE mmb_id = '$mmb_id'";
                                                $mmb_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                                $mmb_row_result = mysqli_fetch_assoc($mmb_result);
                                            ?>
                                                <tr>
                                                    <td>
                                                        <h5><?php echo $cmm_row_result['cmm_detail']; ?></h5>
                                                    </td>
                                                    <td><?php echo $prd_row_result['prd_name'] ?></td>
                                                    <td><?php echo $mmb_row_result['mmb_username'] ?></td>
                                                    <td><?php
                                                        // วันที่และเวลาในฐานข้อมูล (เช่น '2023-08-15 12:30:45')
                                                        $cmm_date = $cmm_row_result['cmm_date'];

                                                        // เวลาปัจจุบัน
                                                        $current_datetime = date('Y-m-d H:i:s');

                                                        // แปลงวันที่และเวลาในฐานข้อมูลเป็น Timestamp
                                                        $cmm_timestamp = strtotime($cmm_date);

                                                        // แปลงวันที่และเวลาปัจจุบันเป็น Timestamp
                                                        $current_timestamp = strtotime($current_datetime);

                                                        // คำนวณเวลาที่ผ่านมา
                                                        $time_diff = $current_timestamp - $cmm_timestamp;

                                                        // แปลงเวลาที่ผ่านมาเป็นชั่วโมง, นาที, วัน
                                                        $hours = floor($time_diff / 3600); // 1 ชั่วโมง = 3600 วินาที
                                                        $minutes = floor(($time_diff % 3600) / 60); // 1 นาที = 60 วินาที
                                                        $days = floor($time_diff / (3600 * 24)); // 1 วัน = 24 ชั่วโมง

                                                        // สร้างข้อความเพื่อแสดงผล
                                                        if ($days > 0) {
                                                            $time_ago = "$days วันที่แล้ว";
                                                        } elseif ($hours > 0) {
                                                            $time_ago = "$hours ชั่วโมงที่แล้ว";
                                                        } elseif ($minutes > 0) {
                                                            $time_ago = "$minutes นาทีที่แล้ว";
                                                        } else {
                                                            $time_ago = "เมื่อสักครู่";
                                                        }

                                                        // แสดงผล
                                                        echo $time_ago;
                                                        ?>
                                                    </td>
                                                    <td><a href="#">รายละเอียด</a></td>
                                                </tr>
                                            <?php
                                            } while ($cmm_row_result = mysqli_fetch_assoc($cmm_result));
                                            ?>



                                        </tbody>
                                    </table>
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