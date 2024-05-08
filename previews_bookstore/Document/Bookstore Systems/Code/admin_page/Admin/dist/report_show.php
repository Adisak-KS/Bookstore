<?php
require_once __DIR__ . '/../../../connection.php';
// ตรวจสอบสิทธิ์
// if (!(isset($_SESSION['sale']) || isset($_SESSION['admin']))) {
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
    echo "<script>window.location.href = 'report_show.php';</script>";
    exit();
}

if (isset($_POST['start_date']) && isset($_POST['end_date']) && ($_POST['start_date'] != '') && ($_POST['end_date'] != '')) {
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];

    // ใน MySQL คุณสามารถใช้ BETWEEN เพื่อเลือกข้อมูลที่อยู่ในช่วงเวลาที่กำหนด
    //ระหว่าง start_date และ end_date
    //$date_condition = "bk_ord_orders.ord_date BETWEEN '$start_date' AND '$end_date'";
    //$fnd_date_condition = "bk_fnd_finder.fnd_date BETWEEN '$start_date' AND '$end_date'";

    //ตั้งแต่ start_date ไปจนถึง end_date
    $date_condition = "bk_ord_orders.ord_date >= '$start_date' AND bk_ord_orders.ord_date <= '$end_date'";
    $fnd_date_condition = "bk_fnd_finder.fnd_date >= '$start_date' AND bk_fnd_finder.fnd_date <= '$end_date'";


    $sql_script = "SELECT 
    bk_ord_orders.*,
    SUM(bk_ord_item.ordi_quan) AS total_quantity,
    DATE_FORMAT(bk_ord_orders.ord_date, '%Y-%m') AS month
FROM 
    bk_ord_orders
INNER JOIN 
    bk_ord_item ON bk_ord_orders.ord_id = bk_ord_item.ord_id
WHERE 
    $date_condition AND bk_ord_orders.ord_status = 'จัดส่งสำเร็จ'
GROUP BY 
    bk_ord_orders.ord_id;
";

    $fnd_script = "SELECT 
    bk_fnd_finder.*, 
    DATE_FORMAT(bk_fnd_finder.fnd_date, '%Y-%m') AS month
FROM 
    bk_fnd_finder
WHERE 
    $fnd_date_condition AND bk_fnd_finder.fnd_status = 'จัดส่งสำเร็จ'
GROUP BY 
    bk_fnd_finder.fnd_id
";
} else {
    $sql_script = "SELECT 
    bk_ord_orders.*,
    SUM(bk_ord_item.ordi_quan) AS total_quantity,
    DATE_FORMAT(bk_ord_orders.ord_date, '%Y-%m') AS month
FROM 
    bk_ord_orders
INNER JOIN 
    bk_ord_item ON bk_ord_orders.ord_id = bk_ord_item.ord_id
WHERE 
    bk_ord_orders.ord_status = 'จัดส่งสำเร็จ'
GROUP BY 
    bk_ord_orders.ord_id;

";

    $fnd_script = "SELECT 
    bk_fnd_finder.*
FROM 
    bk_fnd_finder
WHERE 
    bk_fnd_finder.fnd_status = 'จัดส่งสำเร็จ';
";
}
$ord_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());


$fnd_result = mysqli_query($proj_connect, $fnd_script) or die(mysqli_connect_error());
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <title><?php echo $_SESSION['titleweb']; ?></title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="A fully featured admin theme which can be used to build CRM, CMS, etc." name="description" />
    <meta content="Coderthemes" name="author" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="assets/images/favicon.ico">

    <!-- App css -->

    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" id="app-style" />

    <!-- icons -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />

    <?php
    //require_once('head.php');
    ?>
    <link href="https://cdn.datatables.net/1.13.10/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/buttons/2.4.2/css/buttons.bootstrap5.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap5.min.css" rel="stylesheet">

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
                        <!-- <div class="col-12">
                            <button type="button" class="btn btn-info waves-effect btn-sm" onclick="window.location.href='#'">ยอดขายทั้งหมด</button>
                            <button type="button" class="btn btn-info waves-effect btn-sm" onclick="window.location.href='#'">ยอดขายทั้งหมด</button>
                        </div> -->
                    </div>

                    <div class="col-6">
                        <!-- แสดงข้อมูล -->
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">ดูยอดขายตามเวลา</h4>
                                <br>
                                <form id="dateForm" action="report_show.php" method="POST" class="needs-validation" novalidate>
                                    <div class="row">
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="start_date" class="form-label">วันที่เริ่มต้น
                                                    <?php
                                                    if (isset($_POST['start_date'])) {
                                                        echo ': ' .  $_POST['start_date'];
                                                    } ?></label>
                                                <input class="form-control" id="start_date" type="date" name="start_date" required>
                                                <div class="invalid-feedback">กรุณาเลือกวันที่เริ่มต้นให้ถูกต้อง</div>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                            <div class="mb-3">
                                                <label for="end_date" class="form-label">วันที่สิ้นสุด
                                                    <?php
                                                    if (isset($_POST['end_date'])) {
                                                        echo ': ' .  $_POST['end_date'];
                                                    } ?></label>
                                                <input class="form-control" id="end_date" type="date" name="end_date" required>
                                                <div class="invalid-feedback">กรุณาเลือกวันที่สิ้นสุดให้ถูกต้อง</div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <button type="submit" class="btn btn-primary waves-effect btn-sm">ยืนยัน</button>
                                        <a href="report_show.php" class="btn btn-info waves-effect btn-sm">ดูยอดขายทั้งหมด</a>
                                    </div>
                                </form>
                                <script>
                                    document.getElementById("dateForm").addEventListener("submit", function(event) {
                                        event.preventDefault(); // หยุดการกระทำของ form เพื่อป้องกันการโหลดหน้าใหม่

                                        var startDate = document.getElementById("start_date").value;
                                        var endDate = document.getElementById("end_date").value;

                                        // ตรวจสอบว่าค่าว่างหรือไม่
                                        if (!startDate || !endDate) {
                                            // ถ้ามีค่าว่างให้แสดงข้อความเตือน
                                            document.getElementById("start_date").classList.remove("is-valid");
                                            document.getElementById("start_date").classList.add("is-invalid");
                                            document.getElementById("end_date").classList.remove("is-valid");
                                            document.getElementById("end_date").classList.add("is-invalid");
                                            return;
                                        }

                                        // ตรวจสอบว่าวันที่สิ้นสุดมากกว่าหรือเท่ากับวันที่เริ่มต้น
                                        if (endDate < startDate) {
                                            document.getElementById("start_date").classList.remove("is-valid");
                                            document.getElementById("start_date").classList.add("is-invalid");
                                            document.getElementById("end_date").classList.remove("is-valid");
                                            document.getElementById("end_date").classList.add("is-invalid");
                                            return;
                                        }

                                        // ถ้าข้อมูลถูกต้อง ให้ส่งไปยังหน้าที่เป้าหมาย
                                        document.getElementById("dateForm").submit();
                                    });
                                </script>



                            </div>
                        </div>
                    </div>

                    <div class="col-12">
                        <!-- แสดงข้อมูล -->
                        <div class="card">
                            <div class="card-body">
                                <h4 class="mt-0 header-title">ยอดขาย</h4>
                                <br>
                                <?php if ((mysqli_num_rows($ord_result) > 0) || (mysqli_num_rows($fnd_result) > 0)) { ?>

                                    <table id="datatable-buttons" class="table table-striped table-bordered dt-responsive nowrap" style="width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>เวลา</th>
                                                <th>สมาชิก</th>
                                                <th>จำนวนหนังสือ</th>
                                                <th>จำนวนเงิน</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $total_quantity = 0;
                                            $total_ord = 0;
                                            while ($ord_row_result = mysqli_fetch_assoc($ord_result)) {
                                                $usernamesql = "SELECT mmb_username FROM bk_auth_member WHERE mmb_id = " . $ord_row_result['mmb_id'];

                                                // ดำเนินการคิวรี่ข้อมูล
                                                $usernameresult = mysqli_query($proj_connect, $usernamesql);

                                            ?>
                                                <tr>
                                                    <td><?= $ord_row_result['ord_date'] ?></td>
                                                    <td><?php
                                                        if (mysqli_num_rows($usernameresult) > 0) {
                                                            // ดึงข้อมูลแถวเดียวเนื่องจาก mmb_id เป็น Primary Key ที่มีค่าซ้ำกันไม่ได้
                                                            $usernamerow = mysqli_fetch_assoc($usernameresult);
                                                            // แสดงผล mmb_username
                                                            echo $usernamerow["mmb_username"];
                                                        } else {
                                                            echo "ไม่พบผู้ใช้ท่านนี้";
                                                        } ?>
                                                    </td>
                                                    <td><?= $ord_row_result['total_quantity'] ?></td>
                                                    <td><?= $ord_row_result['ord_amount'] ?></td>
                                                </tr>
                                            <?php
                                                $total_quantity += $ord_row_result['total_quantity'];
                                                $total_ord += $ord_row_result['ord_amount'];
                                            }
                                            $total_quanfnd = 0;
                                            $fnd_totalprice = 0;
                                            while ($fnd_row_result = mysqli_fetch_assoc($fnd_result)) {

                                                $usernamesql = "SELECT mmb_username FROM bk_auth_member WHERE mmb_id = " . $fnd_row_result['mmb_id'];

                                                // ดำเนินการคิวรี่ข้อมูล
                                                $usernameresult = mysqli_query($proj_connect, $usernamesql);

                                            ?>
                                                <tr>
                                                    <td><?= $fnd_row_result['fnd_date'] ?></td>
                                                    <td><?php
                                                        if (mysqli_num_rows($usernameresult) > 0) {
                                                            // ดึงข้อมูลแถวเดียวเนื่องจาก mmb_id เป็น Primary Key ที่มีค่าซ้ำกันไม่ได้
                                                            $usernamerow = mysqli_fetch_assoc($usernameresult);
                                                            // แสดงผล mmb_username
                                                            echo $usernamerow["mmb_username"];
                                                        } else {
                                                            echo "ไม่พบผู้ใช้ท่านนี้";
                                                        } ?></td>
                                                    <td>1</td>
                                                    <td><?= number_format($fnd_row_result['fnd_totalprice'], 2) ?></td>
                                                </tr>
                                            <?php
                                                $total_quanfnd++;
                                                $fnd_totalprice += $fnd_row_result['fnd_totalprice'];
                                            }
                                            $total = $total_ord + $total_quanfnd;
                                            $total_formatted = number_format($total, 2);
                                            ?>
                                            <tr>
                                                <td colspan="2">
                                                    <h5>รวม</h5>
                                                </td>
                                                <td hidden></td>
                                                <td><?= $total_quanfnd +  $total_quantity; ?></td>
                                                <td><?= number_format($fnd_totalprice + $total_ord, 2); ?></td>
                                            </tr>
                                        </tbody>
                                    </table>
                                <?php } else { ?>
                                    <p>ไม่พบรายการ</p>
                                <?php } ?>

                                <div class="text-end">
                                    <br>
                                    <button type="button" class="btn btn-secondary waves-effect btn-sm" onclick="window.location.href='index.php'">ย้อนกลับ</button>

                                </div>
                            </div>
                        </div>
                    </div>
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

            <!-- /Right-bar -->

            <!-- Right bar overlay-->
            <div class="rightbar-overlay"></div>

            <!-- Vendor -->
            <script src="assets/libs/jquery/jquery.min.js"></script>
            <script src="assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
            <script src="assets/libs/simplebar/simplebar.min.js"></script>
            <script src="assets/libs/node-waves/waves.min.js"></script>
            <script src="assets/libs/waypoints/lib/jquery.waypoints.min.js"></script>
            <script src="assets/libs/jquery.counterup/jquery.counterup.min.js"></script>
            <script src="assets/libs/feather-icons/feather.min.js"></script>
            <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.10/js/jquery.dataTables.min.js"></script>
            <script src="https://cdn.datatables.net/1.13.10/js/dataTables.bootstrap5.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.4.2/js/dataTables.buttons.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.bootstrap5.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.colVis.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.html5.min.js"></script>
            <script src="https://cdn.datatables.net/buttons/2.4.2/js/buttons.print.min.js"></script>
            <script src="https://cdn.datatables.net/responsive/2.5.0/js/dataTables.responsive.min.js"></script>
            <script src="https://cdn.datatables.net/responsive/2.5.0/js/responsive.bootstrap5.js"></script>

            <!-- Datatables init -->
            <script>
                "use strict";
                $(document).ready(function() {
                    $("#datatable").DataTable();
                    var a = $("#datatable-buttons").DataTable({
                        lengthChange: !1,
                        buttons: ["excel", "print"],
                    });
                    $("#key-table").DataTable({
                            keys: !0
                        }),
                        $("#responsive-datatable").DataTable(),
                        $("#selection-datatable").DataTable({
                            select: {
                                style: "multi"
                            }
                        }),
                        a
                        .buttons()
                        .container()
                        .appendTo("#datatable-buttons_wrapper .col-md-6:eq(0)"),
                        $("#datatable_length select[name*='datatable_length']").addClass(
                            "form-select form-select-sm"
                        ),
                        $("#datatable_length select[name*='datatable_length']").removeClass(
                            "custom-select custom-select-sm"
                        ),
                        $(".dataTables_length label").addClass("form-label");
                });
            </script>

            <!-- Chat js -->
            <script src="assets/js/pages/jquery.chat.js"></script>

            <!-- TODO js-->
            <script src="assets/js/pages/jquery.todo.js"></script>

            <!-- Widgets demo js-->
            <script src="assets/js/pages/widgets.init.js"></script>

            <!-- App js -->
            <script src="assets/js/app.min.js"></script>
            <?php
            //require_once('right_ridebar.php');
            ?>

</body>

</html>