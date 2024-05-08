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

<div class="left-side-menu">

    <div class="h-100" data-simplebar>

        <!-- User box -->
        <div class="user-box text-center">

            <img src="../../../profile/<?php echo $staff_row_result['stf_profile'] ?>" alt="user-img" title="Mat Helme" class="rounded-circle img-thumbnail avatar-md">
            <div class="dropdown">
                <a href="#" class="user-name dropdown-toggle h5 mt-2 mb-1 d-block" data-bs-toggle="dropdown" aria-expanded="false"><?php echo $staff_row_result['stf_username'] ?></a>

            </div>
            <?php
            if (!empty($_SESSION['super_admin'])) { ?>
                <p class="text-muted left-user-info">Super Admin</p>
            <?php }
            if (!empty($_SESSION['admin'])) { ?>
                <p class="text-muted left-user-info">Admin</p>
            <?php }
            if (!empty($_SESSION['sale'])) { ?>
                <p class="text-muted left-user-info">Sale</p>
            <?php } 
            if(empty($_SESSION['super_admin']) && empty($_SESSION['admin']) && empty($_SESSION['sale'])){ ?>
            <p class="text-muted left-user-info">Staff</p>
            <?php
            }
            ?>

        </div>

        <!--- Sidemenu -->
        <div id="sidebar-menu">

            <!-- super_admin menu -->
            <?php if (isset($_SESSION['super_admin'])) { ?>
                <ul id="side-menu">
                    <li>
                        <a href="admin_show.php">
                            <i class="fas fa-users-cog"></i>
                            <span> ผู้ดูแลระบบ </span>
                        </a>
                    </li>
                    <li>
                        <a href="report_show.php">
                            <i class="ti ti-receipt"></i>
                            <span> รายงานยอดขาย </span>
                        </a>
                    </li>
                </ul>
            <?php } elseif (isset($_SESSION['admin'])) { ?>

                <!-- admin menu -->
                <ul id="side-menu">
                    <li>
                        <a href="index.php">
                            <i class="mdi mdi-view-dashboard-outline"></i>
                            <span> หน้าแรก </span>
                        </a>
                    </li>

                    <li class="menu-title">ผู้ใช้</li>
                    <li>
                        <a href="staff_show.php">
                            <i class="mdi mdi-account-group"></i>
                            <span> ทีมงาน </span>
                        </a>
                    </li>
                    <li>
                        <a href="member_show.php">
                            <i class="mdi mdi-account-multiple-outline"></i>
                            <span> สมาชิก </span>
                        </a>
                    </li>
                    <li class="menu-title">สินค้า</li>

                    <li>
                        <a href="product_type_show.php">
                            <i class="mdi mdi-book-settings"></i>
                            <span> ประเภทสินค้า </span>
                        </a>
                    </li>
                    <li>
                        <a href="publisher_show.php">
                            <i class="mdi mdi-fountain-pen"></i>
                            <span> สำนักพิมพ์ </span>
                        </a>
                    </li>
                    <?php if (isset($_SESSION['sale'])) { ?>
                        <li>
                            <a href="product_show.php">
                                <i class="fas fa-box"></i>
                                <span> สินค้า </span>
                            </a>
                        </li>
                    <?php } ?>
                    <li>
                        <a href="product_show.php">
                            <i class="fas fa-box"></i>
                            <span> สินค้า </span>
                        </a>
                    </li>
                    <li>
                        <a href="product_promotion_show.php">
                            <i class="mdi mdi-tag-multiple"></i>
                            <span> โปรโมชัน </span>
                        </a>
                    </li>
                    <li>
                        <a href="payment_show.php">
                            <i class="mdi mdi-contactless-payment-circle"></i>
                            <span> ช่องทางชำระเงิน </span>
                        </a>
                    </li>
                    <li>
                        <a href="shipping_show.php">
                            <i class="mdi mdi-truck"></i>
                            <span> ช่องทางการจัดส่ง </span>
                        </a>
                    </li>
                    <li>
                        <a href="province_show.php">
                            <i class="mdi dripicons-location"></i>
                            <span> จังหวัด </span>
                        </a>
                    </li>
                    <li class="menu-title">อื่น ๆ</li>
                    <li>
                        <a href="report_show.php">
                            <i class="ti ti-receipt"></i>
                            <span> รายงานยอดขาย </span>
                        </a>
                    </li>
                    <li>
                        <a href="order_ntf_history_show.php">
                            <i class="fas fa-receipt"></i>
                            <span> รายการการชำระเงิน </span>
                        </a>
                    </li>
                    <li>
                        <a href="banner_show.php">
                            <i class="fas fa-images"></i>
                            <span> แบนเนอร์ </span>
                        </a>
                    </li>
                    <li>
                        <a href="setting_edit_form.php">
                            <i class="fe-settings"></i>
                            <span> ตั้งค่าเว็บไซต์ </span>
                        </a>
                    </li>
                </ul>
            <?php } elseif (isset($_SESSION['sale'])) { ?>

                <!-- sale menu -->
                <ul id="side-menu">
                    <li>
                        <a href="index.php">
                            <i class="mdi mdi-view-dashboard-outline"></i>
                            <span> หน้าแรก </span>
                        </a>
                    </li>

                    <li class="menu-title">สินค้า</li>
                    <li>
                        <a href="product_show.php">
                            <i class="fas fa-box"></i>
                            <span> สินค้า </span>
                        </a>
                    </li>
                    <li class="menu-title">อื่น ๆ</li>
                </ul>
            <?php } else { ?>
                <ul id="side-menu">
                    <li>
                        <a href="index.php">
                            <i class="mdi mdi-view-dashboard-outline"></i>
                            <span> หน้าแรก </span>
                        </a>
                    </li>
                <?php
            }
                ?>
                </ul>
        </div>
        <!-- End Sidebar -->

        <div class="clearfix"></div>

    </div>
    <!-- Sidebar -left -->

</div>