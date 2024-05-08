<?php
// เช็คว่า $_SESSION['login_id'] ถูกตั้งค่าและไม่ว่างเปล่า
if (isset($_SESSION['staff'])) {
    // ดึงค่า login_id ออกมา
    $login_id = $_SESSION['login_id'];

    // คิวรี่เพื่อค้นหาข้อมูลสมาชิกด้วย login_id
    $query = "SELECT * FROM bk_auth_staff WHERE stf_id = '$login_id'";
    $query_run = mysqli_query($proj_connect, $query);
    $staff_row_result = mysqli_fetch_assoc($query_run);
} else {
    $_SESSION['status'] = "ไม่พบผู้ใช้";
    $_SESSION['status_code'] = "ผิดพลาด";
    header('Location: login_form.php');
exit;
}

?>
<div class="navbar-custom">
    <ul class="list-unstyled topnav-menu float-end mb-0">

       


        <li class="dropdown notification-list topbar-dropdown">
            <a class="nav-link dropdown-toggle nav-user me-0 waves-effect waves-light" data-bs-toggle="dropdown" href="#" role="button" aria-haspopup="false" aria-expanded="false">
                <img src="../../../profile/<?php echo $staff_row_result['stf_profile'] ?>" alt="user-image" class="rounded-circle">
                <span class="pro-user-name ms-1">
                    <?php echo $staff_row_result['stf_username']; ?> <i class="mdi mdi-chevron-down"></i>
                </span>
            </a>
            <div class="dropdown-menu dropdown-menu-end profile-dropdown ">
                <!-- item-->
                <!-- <div class="dropdown-header noti-title">
                            <h6 class="text-overflow m-0">Welcome !</h6>
                        </div> -->

                <!-- item-->
                <a href="staff_account_form.php" class="dropdown-item notify-item">
                    <i class="fe-user"></i>
                    <span>บัญชีของฉัน</span>
                </a>


                <div class="dropdown-divider"></div>

                <!-- item-->
                <a href="logout.php" class="dropdown-item notify-item">
                    <i class="fe-log-out"></i>
                    <span>ออกจากระบบ</span>
                </a>

            </div>
        </li>


    </ul>

    <!-- LOGO -->
    <div class="logo-box">
        <a href="index.html" class="logo logo-light text-center">
            <span class="logo-sm">
                <img src="assets/images/<?php echo $_SESSION['logo'] ?>" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="assets/images/logo-light.png" alt="" height="16">
            </span>
        </a>
        <a href="index.php" class="logo logo-dark text-center">
            <span class="logo-sm">
                <img src="assets/images/<?php echo $_SESSION['logo'] ?>" alt="" height="22">
            </span>
            <span class="logo-lg">
                <img src="assets/images/<?php echo $_SESSION['logo'] ?>" alt="" height="50" style="height: 50px; width: 50px;">
            </span>
        </a>
    </div>

    <ul class="list-unstyled topnav-menu topnav-menu-left mb-0">
        <li>
            <button class="button-menu-mobile disable-btn waves-effect">
                <i class="fe-menu"></i>
            </button>
        </li>

        <li>
            <!-- <h4 class="page-title-main">สำหรับทีมงาน</h4> -->
            <h4 class="page-title-main"><?= $_SESSION['maintitle'] ?></h4>
        </li>

    </ul>

    <div class="clearfix"></div>

</div>