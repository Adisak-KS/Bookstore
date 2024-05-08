<?php
require_once __DIR__ . '/../../../connection.php';

// ตรวจสอบสิทธิ์
// if (!(isset($_SESSION['sale']) || isset($_SESSION['admin']))) {
//     $_SESSION['status'] = "ไม่พบสิทธิ์การใช้งานในหน้านี้";
//     $_SESSION['status_code'] = "ผิดพลาด";
//     header('Location: login_form.php');
// exit;
// }

$currentURL = $_SERVER['REQUEST_URI'];
if (isset($_SESSION['status']) && isset($_SESSION['status_code'])) {
    $status = $_SESSION['status'];
    $status_code = $_SESSION['status_code'];

    // เคลียร์ค่า session
    unset($_SESSION['status']);
    unset($_SESSION['status_code']);

    // แสดงหน้าต่างข้อความแจ้งเตือน
    echo "<script>alert('$status');</script>";
    echo "<script>window.location.href = '$currentURL';</script>";
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
                        <!-- แสดงข้อมูล -->

                        <div class="card">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">รายการตามหาหนังสือตามสั่ง</h4>
                                <br>
                                <?php
                                $sql_script = "SELECT * FROM bk_fnd_finder WHERE fnd_status = 'รอการตรวจสอบ' OR fnd_status = 'กำลังค้นหา'";
                                $fnd_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
                                ?>

                                <?php if (mysqli_num_rows($fnd_result) > 0) { ?>
                                    <table id="datatable" class="table table-bordered dt-responsive table-responsive nowrap">
                                        <thead>
                                            <tr>
                                                <th>เวลา</th>
                                                <th>ผู้ซื้อ</th>
                                                <!-- <th>ชื่อหนังสือ</th>
                                                <th>ชื่อผู้เขียน</th> -->
                                                <th>สถานะ</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php while ($fnd_row_result = mysqli_fetch_assoc($fnd_result)) { ?>
                                                <tr>
                                                    <td><?= $fnd_row_result['fnd_date'] ?></td>
                                                    <td><?php
                                                        $mmb_script = "SELECT mmb_username FROM bk_auth_member WHERE mmb_id = " . $fnd_row_result['mmb_id'];
                                                        $mmb_result = mysqli_query($proj_connect, $mmb_script) or die(mysqli_connect_error());
                                                        $mmb_row_result = mysqli_fetch_assoc($mmb_result);
                                                        if ($mmb_row_result > 0) {
                                                            echo $mmb_row_result['mmb_username'];
                                                        } else {
                                                            echo 'ไม่พบบัญชีผู้ใช้';
                                                        }
                                                        ?></td>
                                                    <td><span class="badge rounded-pill bg-warning" style="font-size: 14px; color:black;"><?= $fnd_row_result['fnd_status'] ?></span></td>
                                                    <td>
                                                        <form action="finder_form.php" method="POST">
                                                            <input type="text" name="edit_id" id="edit_id" value="<?= $fnd_row_result['fnd_id'] ?>" hidden>
                                                            <button type="submit" name="edit_btn" class="btn btn-info btn-sm waves-effect waves-light"><i class="fe-eye"></i> รายละเอียด</button>
                                                        </form>
                                                    </td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                <?php } else { ?>
                                    <p>ยังไม่มีรายการ</p>
                                <?php } ?>
                                <br>
                                <div class="text-end">
                                    <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='index.php'">ย้อนกลับ</button>
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