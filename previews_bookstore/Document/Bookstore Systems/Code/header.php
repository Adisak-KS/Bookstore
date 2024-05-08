<?php
require_once('connection.php');


if (isset($_SESSION['mmb_id'])) {
    $login_id = $_SESSION['mmb_id'];

    $sql_script = "SELECT * FROM bk_auth_member WHERE mmb_id = '$login_id' ";
    $mmb_result = mysqli_query($proj_connect, $sql_script) or die(mysqli_connect_error());
    $mmb_row_result = mysqli_fetch_assoc($mmb_result);
    // $mmb_totalrows_result = mysqli_num_rows($mmb_result);

    if (isset($_SESSION['mmb_id']) && mysqli_num_rows($mmb_result) == 0) {
        unset($_SESSION['mmb_id']);

        $_SESSION['status'] = "ไม่พบข้อมูลผู้ใช้";
        $_SESSION['status_code'] = "error";
        header('Location: login.php');
    }
}

?>
<!-- header-top-area-start -->
<!-- <div class="header-top-area">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 col-md-6 col-12">
                <div class="account-area text-end">
                    <ul>
                        <li><a href="my-account.html">บัญชีของฉัน</a></li>
                        <li><a href="#">ช่วยเหลือ</a></li>
                        <li><a href="#">ติดต่อผู้ดูแล</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div> -->
<!-- header-top-area-end -->
<!-- header-mid-area-start -->
<div class="header-mid-area ptb-40">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-4 col-12">
                <div class="logo-area">
                    <a href="index.php"><img src="admin_page/Admin/dist/assets/images/<?= $_SESSION['logo'] ?>" alt="logo" style="height: 50px; width: 50px" /></a>
                </div>
            </div>
            <div class="col-lg-6 col-md-5 col-12">
                <div class="header-search">
                    <!-- HTML Form -->
                    <!-- HTML Form -->
                    <form id="searchForm" action="shop.php" method="GET">
                        <input type="text" name="prd_serch" placeholder="ค้นหาสินค้า..." />
                        <a href="javascript:void(0);" onclick="submitForm();"><i class="fa fa-search"></i></a>
                    </form>

                    <!-- JavaScript Function -->
                    <script>
                        function submitForm() {
                            document.getElementById("searchForm").submit();
                        }
                    </script>

                </div>
            </div>
            <?php
            if (isset($login_id)) {
            ?>
                <div class="col-lg-3 col-md-3 col-12">
                    <div class="my-cart">
                        <ul>

                            <li><a href="my-account.php">
                                    <img src="profile/<?php echo $mmb_row_result['mmb_profile']; ?>" alt="Member Profile" class="mmb_profile_icon" width="40" height="40">
                                </a>

                                <!-- <div class="mini-cart-sub">
                                    <div class="cart-bottom">
                                        <a class="view-cart" href="my-account.php">บัญชีของฉัน</a>
                                        <a href="logout.php">ออกจากระบบ</a>
                                    </div>
                                </div> -->
                            </li>

                        </ul>
                    </div>
                <?php
            } else {
                ?>
                    <div class="col-lg-3 col-md-3 col-12">
                        <div class="my-cart">
                            <ul>

                                <li><a href="login.php">เข้าสู่ระบบ / </a>
                                    <a href="register.php">สมัครสมาชิก</a>
                                </li>

                            </ul>
                            <ul></ul>
                        </div>

                    <?php } ?>


                    <div class="my-cart">
                        <ul>
                            <?php
                            if (isset($login_id) && (isset($_SESSION['total_items']))) {
                            ?>
                                <li><a href="cart.php"><i class="fa fa-shopping-cart"></i>
                                    </a>
                                    <?php if ($_SESSION['total_items'] > 0) {

                                    ?>
                                        <span><?= $_SESSION['total_items'] ?></span>
                                    <?php
                                    }
                                    ?>
                                <?php
                            } else {
                                ?>
                                <li>
                                    <a href="cart.php"><i class="fa fa-shopping-cart"></i></a>
                                <?php } ?>


                                <!-- <div class="mini-cart-sub">
                                    <div class="cart-product">
                                        <div class="single-cart">
                                            <div class="cart-img">
                                                <a href="cart.html"><img src="img/product/1.jpg" alt="book" /></a>
                                            </div>
                                            <div class="cart-info">
                                                <h5><a href="#">Joust Duffle Bag</a></h5>
                                                <p>1 x ฿200.00</p>
                                            </div>
                                            <div class="cart-icon">
                                                <a href="#"><i class="fa fa-remove"></i></a>
                                            </div>
                                        </div>
                                        <div class="single-cart">
                                            <div class="cart-img">
                                                <a href="#"><img src="img/product/3.jpg" alt="book" /></a>
                                            </div>
                                            <div class="cart-info">
                                                <h5><a href="#">Chaz Kangeroo Hoodie</a></h5>
                                                <p>1 x ฿200.00</p>
                                            </div>
                                            <div class="cart-icon">
                                                <a href="#"><i class="fa fa-remove"></i></a>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="cart-totals">
                                        <h5>รวม <span>฿200.00</span></h5>
                                    </div>
                                    <div class="cart-bottom">
                                        <a class="view-cart" href="cart.html">ดูตะกร้า</a>
                                        <a href="checkout.html">ชำระเงิน</a>
                                    </div>
                                </div> -->
                                </li>
                        </ul>
                    </div>

                    </div>
                </div>
        </div>
    </div>
    <!-- header-mid-area-end -->
    <!-- main-menu-area-start -->
    <div class="main-menu-area d-md-none d-none d-lg-block" id="header-sticky">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="menu-area">
                        <nav>
                            <ul>
                                <!-- <li class="active"><a href="index.php">Home<i class="fa fa-angle-down"></i></a>
										<div class="sub-menu">
											<ul>
												<li><a href="index.php">Home-1</a></li>
												<li><a href="index-2.html">Home-2</a></li>
												<li><a href="index-3.html">Home-3</a></li>
												<li><a href="index-4.html">Home-4</a></li>
												<li><a href="index-5.html">Home-5</a></li>
												<li><a href="index-6.html">Home-6</a></li>
												<li><a href="index-7.html">Home-7</a></li>
											</ul>
										</div>
									</li> -->
                                <?php
                                $filter_query = "SELECT t.pty_id, t.pty_name
                                FROM bk_prd_type t
                                WHERE t.pty_show = 1
                                AND t.pty_id IN (
                                    SELECT DISTINCT p.pty_id 
                                    FROM bk_prd_product p
                                    WHERE p.prd_show = 1
                                );                                
                                ";
                                $filter_result = mysqli_query($proj_connect, $filter_query) or die(mysqli_connect_error());

                                ?>
                                <li><a href="shop.php">หนังสือทั้งหมด<i></i></a>
                                </li>
                                <li><a href="#">ประเภท<i class="fa fa-angle-down"></i></a>
                                    <div class="sub-menu sub-menu-2">
                                        <ul>
                                            <?php
                                            while ($filter_row = mysqli_fetch_assoc($filter_result)) {
                                            ?>
                                                <li><a href="shop.php?prd_filter=<?= base64_encode("SELECT * 
FROM bk_prd_product 
WHERE prd_show = 1 
    AND prd_qty > 0 
    AND pty_id = " . $filter_row['pty_id'] . "
    AND pty_id IN (SELECT pty_id FROM bk_prd_type WHERE pty_show = 1)
ORDER BY prd_id
") ?>"><?= $filter_row['pty_name'] ?></a></li>

                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </li>
                                <li><a href="#">สำนักพิมพ์<i class="fa fa-angle-down"></i></a>
                                    <div class="sub-menu sub-menu-2">
                                        <ul>
                                            <?php
                                            $filter_query = "SELECT DISTINCT pub.publ_id, pub.publ_name
                                            FROM bk_prd_product prod
                                            JOIN bk_prd_type type ON prod.pty_id = type.pty_id
                                            JOIN bk_prd_publisher pub ON prod.publ_id = pub.publ_id
                                            WHERE prod.prd_show = 1
                                            AND type.pty_show = 1;
                                            ";
                                            $publ_flt_result = mysqli_query($proj_connect, $filter_query) or die(mysqli_connect_error());
                                            while ($publ_flt_row = mysqli_fetch_assoc($publ_flt_result)) {
                                            ?>
                                                <li><a href="shop.php?prd_filter=<?= base64_encode("SELECT * FROM bk_prd_product WHERE prd_show = 1 AND prd_qty > 0 AND publ_id = " . $publ_flt_row['publ_id'] . " ORDER BY prd_id") ?>"><?= $publ_flt_row['publ_name'] ?></a></li>

                                            <?php
                                            }
                                            ?>
                                        </ul>
                                    </div>
                                </li>
                                <!-- <li><a href="#">โปรโมชัน<i class="fa fa-angle-down"></i></a>
                                    <div class="sub-menu sub-menu-2">
                                        <ul> <?php
                                                //$filter_query = "SELECT * FROM bk_promotion";
                                                //$prp_flt_result = mysqli_query($proj_connect, $filter_query) or die(mysqli_connect_error());
                                                //while ($prp_flt_row = mysqli_fetch_assoc($prp_flt_result)) {
                                                ?>
                                                
                                            <?php
                                            //}
                                            ?>
                                        </ul>
                                    </div>
                                </li> -->
                                <li><a href="shop.php?prd_filter=<?= base64_encode("SELECT * FROM bk_prd_product WHERE prd_show = 1 AND prd_qty > 0 AND prd_preorder = 1 ORDER BY prd_id") ?>">พรีออเดอร์</a></li>
                                <li><a href="finder.php">หาหนังสือตามสั่ง</a></li>

                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- main-menu-area-end -->
    <!-- mobile-menu-area-start -->
    <div class="mobile-menu-area d-lg-none d-block fix">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="mobile-menu">
                        <nav id="mobile-menu-active">
                            <ul id="nav">
                                <li><a href="index.php">หนังสือทั้งหมด</a>
                                </li>
                                <li><a href="#">ประเภท</a>
                                    <ul>
                                        <?php
                                        $filter_query = "SELECT t.pty_id, t.pty_name
                                FROM bk_prd_type t
                                WHERE t.pty_show = 1
                                AND t.pty_id IN (
                                    SELECT DISTINCT p.pty_id 
                                    FROM bk_prd_product p
                                    WHERE p.prd_show = 1
                                );                                
                                ";
                                        $filter_result = mysqli_query($proj_connect, $filter_query) or die(mysqli_connect_error());

                                        while ($filter_row = mysqli_fetch_assoc($filter_result)) {
                                        ?>
                                            <li><a href="shop.php?prd_filter=<?= base64_encode("SELECT * 
FROM bk_prd_product 
WHERE prd_show = 1 
    AND prd_qty > 0 
    AND pty_id = " . $filter_row['pty_id'] . "
    AND pty_id IN (SELECT pty_id FROM bk_prd_type WHERE pty_show = 1)
ORDER BY prd_id
") ?>"><?= $filter_row['pty_name'] ?></a></li>

                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </li>
                                <li><a href="#">สำนักพิมพ์</a>
                                    <ul>
                                        <?php
                                        $filter_query = "SELECT DISTINCT pub.publ_id, pub.publ_name
                                            FROM bk_prd_product prod
                                            JOIN bk_prd_type type ON prod.pty_id = type.pty_id
                                            JOIN bk_prd_publisher pub ON prod.publ_id = pub.publ_id
                                            WHERE prod.prd_show = 1
                                            AND type.pty_show = 1;
                                            ";
                                        $publ_flt_result = mysqli_query($proj_connect, $filter_query) or die(mysqli_connect_error());
                                        while ($publ_flt_row = mysqli_fetch_assoc($publ_flt_result)) {
                                        ?>
                                            <li><a href="shop.php?prd_filter=<?= base64_encode("SELECT * FROM bk_prd_product WHERE prd_show = 1 AND prd_qty > 0 AND publ_id = " . $publ_flt_row['publ_id'] . " ORDER BY prd_id") ?>"><?= $publ_flt_row['publ_name'] ?></a></li>

                                        <?php
                                        }
                                        ?>
                                    </ul>
                                </li>
                                <li><a href="shop.php?prd_filter=<?= base64_encode("SELECT * FROM bk_prd_product WHERE prd_show = 1 AND prd_qty > 0 AND prd_preorder = 1 ORDER BY prd_id") ?>">พรีออเดอร์</a></li>
                                <li><a href="finder.php">หาหนังสือตามสั่ง</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- mobile-menu-area-end -->