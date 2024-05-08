<?php
if (isset($_SESSION['admin'])) {
?>
    <!-- รอการตรวจสอบการชำระเงิน -->
    <div class="col-xl-3 col-md-6">
        <a href="order_ntf_show.php" style="cursor: pointer;">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <blockquote class="card-bodyquote mb-0">
                        <?php

                        $ntf_sql = "SELECT 
    (SELECT COUNT(*) FROM bk_fnd_finder WHERE fnd_status = 'รอการตรวจสอบการชำระเงิน') +
    (SELECT COUNT(*) FROM bk_ord_orders WHERE ord_status = 'รอการตรวจสอบการชำระเงิน') AS total_count; ";
                        $ntf_result = mysqli_query($proj_connect, $ntf_sql) or die(mysqli_error($proj_connect));
                        $ntf_row = mysqli_fetch_assoc($ntf_result);
                        ?>
                        <h2 class="text-white mb-1"> การชำระเงิน </h2>
                        <p class="text-white mb-3"><?= $ntf_row['total_count'] ?> รายการ
                            <?php
                            if ($ntf_row['total_count'] > 0) {
                            ?>
                                <i class="mdi mdi-circle text-danger me-1 font-11"></i>
                            <?php
                            } ?>
                        </p>
                    </blockquote>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="pay_show.php" style="cursor: pointer;">
            <div class="card text-white bg-purple">
                <div class="card-body">
                    <blockquote class="card-bodyquote mb-0">
                        <h2 class="text-white mb-1"> รอการจัดส่ง </h2>
                        <?php
                        $countpack_sql = "SELECT 
    (SELECT COUNT(*) FROM bk_ord_orders WHERE ord_status = 'เตรียมจัดส่งสินค้า') +
    (SELECT COUNT(*) FROM bk_fnd_finder WHERE fnd_status = 'เตรียมจัดส่งสินค้า') AS total_count;";
                        $countpack_result = mysqli_query($proj_connect, $countpack_sql) or die(mysqli_error($proj_connect));
                        $countpack_row = mysqli_fetch_assoc($countpack_result);
                        ?>
                        <p class="text-white mb-3"><?= $countpack_row['total_count'] ?> รายการ
                            <?php
                            if ($countpack_row['total_count'] > 0) {
                            ?>
                                <i class="mdi mdi-circle text-danger me-1 font-11"></i>
                            <?php
                            } ?>
                        </p>
                    </blockquote>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="finder_show.php" style="cursor: pointer;">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <blockquote class="card-bodyquote mb-0">
                        <?php

                        $countfnd_sql = "SELECT COUNT(*) AS count FROM bk_fnd_finder WHERE fnd_status = 'รอการตรวจสอบ' OR fnd_status = 'กำลังค้นหา'";
                        $countfnd_result = mysqli_query($proj_connect, $countfnd_sql) or die(mysqli_error($proj_connect));
                        $countfnd_row = mysqli_fetch_assoc($countfnd_result);
                        ?>
                        <h2 class="text-white mb-1"> ตามหาหนังสือ </h2>
                        <p class="text-white mb-3"><?= $countfnd_row['count'] ?> รายการ <?php
                                                                                        if ($countfnd_row['count'] > 0) {
                                                                                        ?>
                                <i class="mdi mdi-circle text-danger me-1 font-11"></i>
                            <?php
                                                                                        } ?>
                        </p>
                        <!-- <p class="text-white mb-3">100 รายการ <span class="badge bg-danger rounded-circle noti-icon-badge">9</span></p> -->
                    </blockquote>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="comment_show.php" style="cursor: pointer;">
            <div class="card text-white bg-info">
                <div class="card-body">
                    <blockquote class="card-bodyquote mb-0">
                        <?php
                        $startTime = date('Y-m-d H:i:s', strtotime('-12 hours'));

                        //$countcmm_sql = "SELECT COUNT(*) AS count FROM bk_prd_comment WHERE cmm_date >= '$startTime'";
                        $countcmm_sql = "SELECT 
                        (SELECT COUNT(*) FROM bk_prd_comment) AS total_comments,
                        (SELECT COUNT(*) FROM bk_prd_comment WHERE cmm_date >= '$startTime') AS comments_since_start_time;
                    ";
                        $countcmm_result = mysqli_query($proj_connect, $countcmm_sql) or die(mysqli_error($proj_connect));
                        $countcmm_row = mysqli_fetch_assoc($countcmm_result);
                        ?>
                        <h2 class="text-white mb-1"> ความคิดเห็น </h2>
                        <p class="text-white mb-3"><?= $countcmm_row['total_comments'] ?> รายการ
                            <?php
                            if ($countcmm_row['comments_since_start_time'] > 0) {
                            ?>
                                <i class="mdi mdi-circle text-danger me-1 font-11"></i>
                            <?php
                            } ?>
                        </p>
                    </blockquote>
                </div>
            </div>
        </a>
    </div>

    <div class="col-xl-3 col-md-6">
        <a href="product_low_show.php" style="cursor: pointer;">
            <div class="card text-white bg-pink">
                <div class="card-body">
                    <blockquote class="card-bodyquote mb-0">
                        <h2 class="text-white mb-1"> สินค้าที่น้อยกว่า <?= $_SESSION['remain_quantity'] ?> ชิ้น </h2>
                        <?php
                        $countqty_sql = "SELECT COUNT(*) AS count FROM bk_prd_product WHERE prd_qty <= " . $_SESSION['remain_quantity'];
                        $countqty_result = mysqli_query($proj_connect, $countqty_sql) or die(mysqli_error($proj_connect));
                        $countqty_row = mysqli_fetch_assoc($countqty_result);
                        ?>
                        <p class="text-white mb-3"><?= $countqty_row['count']; ?> รายการ
                            <?php
                            if ($countqty_row['count'] > 0) {
                            ?>
                                <i class="mdi mdi-circle text-danger me-1 font-11"></i>
                            <?php
                            } ?>
                        </p>
                    </blockquote>
                </div>
            </div>
        </a>
    </div>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <!-- <a href="report_show.php" style="cursor: pointer;"> -->
                <div class="card">
                    <div class="card-body widget-user">
                        <div class="text-center">
                            <?php

                            // ทำการ query ข้อมูล
                            $sql = "SELECT SUM(ord_amount) + SUM(fnd_totalprice) AS total_sales 
            FROM (
                SELECT ord_amount, 0 AS fnd_totalprice FROM bk_ord_orders WHERE ord_status = 'จัดส่งสำเร็จ'
                UNION ALL
                SELECT 0 AS ord_amount, fnd_totalprice FROM bk_fnd_finder WHERE fnd_status = 'จัดส่งสำเร็จ'
            ) AS combined_sales";
                            $result = mysqli_query($proj_connect, $sql) or die(mysqli_connect_error());

                            // ตรวจสอบว่ามีข้อมูลที่ได้จาก query หรือไม่
                            if (mysqli_num_rows($result) > 0) {
                                // มีข้อมูลที่ค้นพบ
                                $row = mysqli_fetch_assoc($result);
                                // ตรวจสอบว่าข้อมูล total_sales ไม่ใช่ null ก่อนที่จะใช้ number_format()
                                if ($row["total_sales"] !== null) {
                                    echo "<h2 class='fw-normal text-pink'>" . number_format($row["total_sales"]) . "</h2>";
                                } else {
                                    // กรณีที่ข้อมูล total_sales เป็น null
                                    echo "<h2 class='fw-normal text-pink'>0</h2>";
                                }
                            } else {
                                // ไม่มีข้อมูลที่ค้นพบ
                                echo "0";
                            }

                            ?>
                            <h5>ยอดขายทั้งหมด (บาท)</h5>
                        </div>

                    </div>
                </div>
            <!-- </a> -->
        </div>

        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body widget-user">
                    <div class="text-center">
                        <?php
                        // ทำการ query ข้อมูล
                        $sql = "SELECT SUM(prd_qty) AS total_product_quantity
                        FROM bk_prd_product;
                        
                        ";
                        $result = mysqli_query($proj_connect, $sql) or die(mysqli_connect_error());

                        $result = mysqli_query($proj_connect, $sql) or die(mysqli_connect_error());

                        // ตรวจสอบว่ามีข้อมูลที่ได้จาก query หรือไม่
                        if (mysqli_num_rows($result) > 0) {
                            // มีข้อมูลที่ค้นพบ
                            $row = mysqli_fetch_assoc($result);
                            // ตรวจสอบว่าข้อมูล total_product_quantity ไม่ใช่ null ก่อนที่จะใช้ number_format()
                            if ($row["total_product_quantity"] !== null) {
                                echo "<h2 class='fw-normal text-purple'>" . number_format($row["total_product_quantity"]) . "</h2>";
                            } else {
                                // กรณีที่ข้อมูล total_product_quantity เป็น null
                                echo "<h2 class='fw-normal text-purple'>0</h2>";
                            }
                        } else {
                            // ไม่มีข้อมูลที่ค้นพบ
                            echo "0";
                        }

                        ?>
                        <h5>สินค้า</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body widget-user">
                    <div class="text-center">
                        <?php

                        // ทำการ query ข้อมูล
                        $sql = "SELECT COUNT(stf_id) AS total_active_staff
                        FROM bk_auth_staff
                        WHERE stf_active = 1;
                        ";
                        $result = mysqli_query($proj_connect, $sql) or die(mysqli_connect_error());

                        $result = mysqli_query($proj_connect, $sql) or die(mysqli_connect_error());

                        // ตรวจสอบว่ามีข้อมูลที่ได้จาก query หรือไม่
                        if (mysqli_num_rows($result) > 0) {
                            // มีข้อมูลที่ค้นพบ
                            $row = mysqli_fetch_assoc($result);
                            // ตรวจสอบว่าข้อมูล total_active_staff ไม่ใช่ null ก่อนที่จะใช้ number_format()
                            if ($row["total_active_staff"] !== null) {
                                echo "<h2 class='fw-normal text-blue'>" . number_format($row["total_active_staff"] - 1) . "</h2>";
                            } else {
                                // กรณีที่ข้อมูล total_active_staff เป็น null
                                echo "<h2 class='fw-normal text-blue'>0</h2>";
                            }
                        } else {
                            // ไม่มีข้อมูลที่ค้นพบ
                            echo "0";
                        }

                        ?>
                        <h5>ทีมงาน</h5>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body widget-user">
                    <div class="text-center">
                        <?php

                        // ทำการ query ข้อมูล
                        $sql = "SELECT COUNT(mmb_id) AS total_member_count
                        FROM bk_auth_member;                        
                        ";
                        $result = mysqli_query($proj_connect, $sql) or die(mysqli_connect_error());

                        $result = mysqli_query($proj_connect, $sql) or die(mysqli_connect_error());

                        // ตรวจสอบว่ามีข้อมูลที่ได้จาก query หรือไม่
                        if (mysqli_num_rows($result) > 0) {
                            // มีข้อมูลที่ค้นพบ
                            $row = mysqli_fetch_assoc($result);
                            // ตรวจสอบว่าข้อมูล total_member_count ไม่ใช่ null ก่อนที่จะใช้ number_format()
                            if ($row["total_member_count"] !== null) {
                                echo "<h2 class='fw-normal text-success'>" . number_format($row["total_member_count"]) . "</h2>";
                            } else {
                                // กรณีที่ข้อมูล total_member_count เป็น null
                                echo "<h2 class='fw-normal text-success'>0</h2>";
                            }
                        } else {
                            // ไม่มีข้อมูลที่ค้นพบ
                            echo "0";
                        }

                        ?>
                        <h5>สมาชิก</h5>
                    </div>
                </div>
            </div>
        </div>
        <!-- <div class="col-xl-3 col-md-6">
                            <div class="card">
                                <div class="card-body widget-user">
                                    <div class="text-center">
                                        <h2 class="fw-normal text-primary" data-plugin="">1254</h2>
                                        <h5>ยอดขายวันนี้ (บาท)</h5>
                                    </div>
                                </div>
                            </div>
                        </div> -->
    </div>
<?php
    //} elseif (isset($_SESSION['sale'])) {
    //ถ้้าไม่ใช่ admin
} elseif (!(isset($_SESSION['admin']))) {
?>
    <!-- รอการตรวจสอบการชำระเงิน -->
    <div class="col-xl-3 col-md-6">
        <a href="order_ntf_show.php" style="cursor: pointer;">
            <div class="card text-white bg-success">
                <div class="card-body">
                    <blockquote class="card-bodyquote mb-0">
                        <?php

                        $ntf_sql = "SELECT 
    (SELECT COUNT(*) FROM bk_fnd_finder WHERE fnd_status = 'รอการตรวจสอบการชำระเงิน') +
    (SELECT COUNT(*) FROM bk_ord_orders WHERE ord_status = 'รอการตรวจสอบการชำระเงิน') AS total_count; ";
                        $ntf_result = mysqli_query($proj_connect, $ntf_sql) or die(mysqli_error($proj_connect));
                        $ntf_row = mysqli_fetch_assoc($ntf_result);
                        ?>
                        <h2 class="text-white mb-1"> การชำระเงิน </h2>
                        <p class="text-white mb-3"><?= $ntf_row['total_count'] ?> รายการ
                            <?php
                            if ($ntf_row['total_count'] > 0) {
                            ?>
                                <i class="mdi mdi-circle text-danger me-1 font-11"></i>
                            <?php
                            } ?>
                        </p>
                    </blockquote>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="pay_show.php" style="cursor: pointer;">
            <div class="card text-white bg-purple">
                <div class="card-body">
                    <blockquote class="card-bodyquote mb-0">
                        <h2 class="text-white mb-1"> รอการจัดส่ง </h2>
                        <?php
                        $countpack_sql = "SELECT 
    (SELECT COUNT(*) FROM bk_ord_orders WHERE ord_status = 'เตรียมจัดส่งสินค้า') +
    (SELECT COUNT(*) FROM bk_fnd_finder WHERE fnd_status = 'เตรียมจัดส่งสินค้า') AS total_count;";
                        $countpack_result = mysqli_query($proj_connect, $countpack_sql) or die(mysqli_error($proj_connect));
                        $countpack_row = mysqli_fetch_assoc($countpack_result);
                        ?>
                        <p class="text-white mb-3"><?= $countpack_row['total_count'] ?> รายการ
                            <?php
                            if ($countpack_row['total_count'] > 0) {
                            ?>
                                <i class="mdi mdi-circle text-danger me-1 font-11"></i>
                            <?php
                            } ?>
                        </p>
                    </blockquote>
                </div>
            </div>
        </a>
    </div>
    <div class="col-xl-3 col-md-6">
        <a href="finder_show.php" style="cursor: pointer;">
            <div class="card text-white bg-primary">
                <div class="card-body">
                    <blockquote class="card-bodyquote mb-0">
                        <?php

                        $countfnd_sql = "SELECT COUNT(*) AS count FROM bk_fnd_finder WHERE fnd_status = 'รอการตรวจสอบ' OR fnd_status = 'กำลังค้นหา'";
                        $countfnd_result = mysqli_query($proj_connect, $countfnd_sql) or die(mysqli_error($proj_connect));
                        $countfnd_row = mysqli_fetch_assoc($countfnd_result);
                        ?>
                        <h2 class="text-white mb-1"> ตามหาหนังสือ </h2>
                        <p class="text-white mb-3"><?= $countfnd_row['count'] ?> รายการ <?php
                                                                                        if ($countfnd_row['count'] > 0) {
                                                                                        ?>
                                <i class="mdi mdi-circle text-danger me-1 font-11"></i>
                            <?php
                                                                                        } ?>
                        </p>
                        <!-- <p class="text-white mb-3">100 รายการ <span class="badge bg-danger rounded-circle noti-icon-badge">9</span></p> -->
                    </blockquote>
                </div>
            </div>
        </a>
    </div>
    <?php
    //ถ้าไม่ใช้ admin และ เป็น sale
    if (isset($_SESSION['sale'])) {
    ?>
        <div class="col-xl-3 col-md-6">
            <a href="product_low_show.php" style="cursor: pointer;">
                <div class="card text-white bg-pink">
                    <div class="card-body">
                        <blockquote class="card-bodyquote mb-0">
                            <h2 class="text-white mb-1"> สินค้าที่น้อยกว่า <?= $_SESSION['remain_quantity'] ?> ชิ้น </h2>
                            <?php
                            $countqty_sql = "SELECT COUNT(*) AS count FROM bk_prd_product WHERE prd_qty <= " . $_SESSION['remain_quantity'];
                            $countqty_result = mysqli_query($proj_connect, $countqty_sql) or die(mysqli_error($proj_connect));
                            $countqty_row = mysqli_fetch_assoc($countqty_result);
                            ?>
                            <p class="text-white mb-3"><?= $countqty_row['count']; ?> รายการ
                                <?php
                                if ($countqty_row['count'] > 0) {
                                ?>
                                    <i class="mdi mdi-circle text-danger me-1 font-11"></i>
                                <?php
                                } ?>
                            </p>
                        </blockquote>
                    </div>
                </div>
            </a>
        </div>
    <?php
    }
    ?>
    <div class="row">
        <div class="col-xl-3 col-md-6">
            <div class="card">
                <div class="card-body widget-user">
                    <div class="text-center">
                        <?php

                        // ทำการ query ข้อมูล
                        $sql = "SELECT SUM(ord_amount) + SUM(fnd_totalprice) AS total_sales 
            FROM (
                SELECT ord_amount, 0 AS fnd_totalprice FROM bk_ord_orders WHERE ord_status = 'จัดส่งสำเร็จ'
                UNION ALL
                SELECT 0 AS ord_amount, fnd_totalprice FROM bk_fnd_finder WHERE fnd_status = 'จัดส่งสำเร็จ'
            ) AS combined_sales";
                        $result = mysqli_query($proj_connect, $sql) or die(mysqli_connect_error());

                        // ตรวจสอบว่ามีข้อมูลที่ได้จาก query หรือไม่
                        if (mysqli_num_rows($result) > 0) {
                            // มีข้อมูลที่ค้นพบ
                            $row = mysqli_fetch_assoc($result);
                            // ตรวจสอบว่าข้อมูล total_sales ไม่ใช่ null ก่อนที่จะใช้ number_format()
                            if ($row["total_sales"] !== null) {
                                echo "<h2 class='fw-normal text-pink'>" . number_format($row["total_sales"]) . "</h2>";
                            } else {
                                // กรณีที่ข้อมูล total_sales เป็น null
                                echo "<h2 class='fw-normal text-pink'>0</h2>";
                            }
                        } else {
                            // ไม่มีข้อมูลที่ค้นพบ
                            echo "0";
                        }

                        ?>
                        <h5>ยอดขายทั้งหมด (บาท)</h5>
                    </div>

                </div>
            </div>

        </div>

        <!-- <div class="col-xl-3 col-md-6">
                            <div class="card">
                                <div class="card-body widget-user">
                                    <div class="text-center">
                                        <h2 class="fw-normal text-primary" data-plugin="">1254</h2>
                                        <h5>ยอดขายวันนี้ (บาท)</h5>
                                    </div>
                                </div>
                            </div>
                        </div> -->
    </div>
<?php
} else {
?>
    ไม่พบสิทธิ์การใช้งาน
<?php
}
?>