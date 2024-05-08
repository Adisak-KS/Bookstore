<?php
require_once __DIR__ . '/../../../connection.php';

if (isset($_POST['submitbtn']) || isset($_POST['redobtn'])) {
    // รับค่าจากฟอร์ม
    $ntf_id = $_POST['ntf_id'];
    $ord_id = $_POST['ord_id'];
    $ord_status = 'เตรียมจัดส่งสินค้า';

    $location = 'Location: order_ntf_show.php';
    if (isset($_POST['redobtn'])) {
        $ord_status = 'การชำระเงินไม่ถูกต้อง';
        // อัปเดตข้อมูลในตาราง bk_ord_orders
        $update_order_sql = "UPDATE bk_ord_orders
                            SET ord_status = '$ord_status'
                            WHERE ord_id = '$ord_id'";

        // ทำการ execute SQL queries
        if (mysqli_query($proj_connect, $update_order_sql)) {
            echo "อัปเดตข้อมูลเรียบร้อย";
            $_SESSION['status'] = 'แจ้งชำระเงินใหม่สำเร็จ';
            $_SESSION['status_code'] = 'success';
            header($location);
            // ทำการ redirect หรือใส่โค้ดที่ต้องการหลังจากการอัปเดตข้อมูล
        } else {
            echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . mysqli_error($proj_connect);
            $_SESSION['status'] = 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล';
            $_SESSION['status_code'] = 'error';
            header($location);
            // ทำการ redirect หรือใส่โค้ดที่ต้องการหลังจากเกิดข้อผิดพลาด
        }
    } elseif (isset($_POST['submitbtn'])) {


        // อัปเดตข้อมูลในตาราง bk_ord_orders
        $update_order_sql = "UPDATE bk_ord_orders
                        SET ord_status = '$ord_status'
                        WHERE ord_id = '$ord_id'";

        // อัปเดตข้อมูลในตาราง bk_ord_notification
        $update_notification_sql = "UPDATE bk_ord_notification
                               SET ntf_status = 0
                               WHERE ntf_id = '$ntf_id'";

        if (mysqli_query($proj_connect, $update_order_sql) && mysqli_query($proj_connect, $update_notification_sql)) {
            // เพิ่มโค้ด SQL UPDATE เพื่ออัปเดต mmb_coin ใน bk_auth_member
            $update_member_sql = "UPDATE bk_auth_member
                          SET mmb_coin = mmb_coin + (SELECT ord_coin FROM bk_ord_orders WHERE ord_id = '$ord_id')
                          WHERE mmb_id = (SELECT mmb_id FROM bk_ord_orders WHERE ord_id = '$ord_id')";

            // ทำการ execute SQL query
            if (mysqli_query($proj_connect, $update_member_sql)) {
                // เพิ่มโค้ด SQL INSERT เพื่อเพิ่มข้อมูลลงใน bk_mmb_coin_history
                $insert_history_sql = "INSERT INTO bk_mmb_coin_history (mmb_id, cnh_outcome, cnh_income, cnh_coin, cnh_detail, cnh_date)
                               VALUES ((SELECT mmb_id FROM bk_ord_orders WHERE ord_id = '$ord_id'),0,
                                       (SELECT ord_coin FROM bk_ord_orders WHERE ord_id = '$ord_id'),
                                       (SELECT mmb_coin FROM bk_auth_member WHERE mmb_id = (SELECT mmb_id FROM bk_ord_orders WHERE ord_id = '$ord_id')),
                                       'ได้รับเหรียญจากรายการสั่งซื้อ $ord_id',
                                       NOW())";

                // ทำการ execute SQL query
                if (mysqli_query($proj_connect, $insert_history_sql)) {
                    echo "อัปเดตข้อมูลเรียบร้อย";
                    $_SESSION['status'] = 'ยืนยันการชำระเงินสำเร็จ';
                    $_SESSION['status_code'] = 'success';
                    header($location);
                    // ทำการ redirect หรือใส่โค้ดที่ต้องการหลังจากการอัปเดตข้อมูล
                } else {
                    echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูลลงใน bk_mmb_coin_history: " . mysqli_error($proj_connect);
                    $_SESSION['status'] = 'เกิดข้อผิดพลาดในการเพิ่มข้อมูล';
                    $_SESSION['status_code'] = 'error';
                    header($location);
                }
            } else {
                echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล mmb_coin: " . mysqli_error($proj_connect);
                $_SESSION['status'] = 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล';
                $_SESSION['status_code'] = 'error';
                header($location);
            }
        }
    } else {
        echo "ไม่มีการส่งข้อมูลมาจากฟอร์ม";
        $_SESSION['status'] = 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล';
        $_SESSION['status_code'] = 'error';
        header($location);
        // ทำการ redirect หรือใส่โค้ดที่ต้องการหลังจากไม่มีการส่งข้อมูลมา
    }
} elseif (isset($_POST['shpbtn'])) {
    $location = 'Location: pay_show.php';

    $ord_id = $_POST['ord_id'];
    $ord_detail = $_POST['ord_detail'];

    $ord_status = 'อยู่ระหว่างการขนส่ง';
    $update_order_sql = "UPDATE bk_ord_orders SET ord_status = '$ord_status', ord_detail = '$ord_detail' WHERE ord_id = '$ord_id'";
    if (mysqli_query($proj_connect, $update_order_sql)) {
        echo "อัปเดตข้อมูลเรียบร้อย";
        $_SESSION['status'] = 'จัดส่งสินค้าสำเร็จ';
        $_SESSION['status_code'] = 'success';
        header($location);
        // ทำการ redirect หรือใส่โค้ดที่ต้องการหลังจากการอัปเดตข้อมูล
    } else {
        echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . mysqli_error($proj_connect);
        $_SESSION['status'] = 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล';
        $_SESSION['status_code'] = 'error';
        header($location);
        // ทำการ redirect หรือใส่โค้ดที่ต้องการหลังจากเกิดข้อผิดพลาด
    }
} else {
    echo 'else';
}
mysqli_close($proj_connect);
