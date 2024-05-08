<?php
require_once __DIR__ . '/../../../connection.php';

if (isset($_POST['submitbtn']) || isset($_POST['redobtn'])) {
    // รับค่าจากฟอร์ม
    $fdnf_id = $_POST['fdnf_id'];
    $fnd_id = $_POST['fnd_id'];
    $fnd_status = 'เตรียมจัดส่งสินค้า';

    $location = 'Location: order_ntf_show.php';
    if (isset($_POST['redobtn'])) {
        $fnd_status = 'การชำระเงินไม่ถูกต้อง';
        // อัปเดตข้อมูลในตาราง bk_fnd_orders
        $update_order_sql = "UPDATE bk_fnd_finder
                            SET fnd_status = '$fnd_status'
                            WHERE fnd_id = '$fnd_id'";

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


        // อัปเดตข้อมูลในตาราง bk_fnd_orders
        $update_order_sql = "UPDATE bk_fnd_finder
                        SET fnd_status = '$fnd_status'
                        WHERE fnd_id = '$fnd_id'";

        if (mysqli_query($proj_connect, $update_order_sql)) {
            // อัปเดตข้อมูลในตาราง bk_fnd_notification
            $update_notification_sql = "UPDATE bk_fnd_notification
                               SET fdnf_status = 0
                               WHERE fdnf_id = '$fdnf_id'";
        }
        if (mysqli_query($proj_connect, $update_notification_sql)) {
            echo "อัปเดตข้อมูลเรียบร้อย";
            $_SESSION['status'] = 'ยืนยันการชำระเงินสำเร็จ';
            $_SESSION['status_code'] = 'success';
            header($location);
            // ทำการ redirect หรือใส่โค้ดที่ต้องการหลังจากการอัปเดตข้อมูล
        } else {
            echo "เกิดข้อผิดพลาดในการเพิ่มข้อมูล: " . mysqli_error($proj_connect);
            $_SESSION['status'] = "เกิดข้อผิดพลาดในการเพิ่มข้อมูล: " . mysqli_error($proj_connect);
            $_SESSION['status_code'] = 'error';
            header($location);
        }
    } else {
        echo "ไม่มีการส่งข้อมูลมาจากฟอร์ม";
        $_SESSION['status'] = 'ไม่มีการส่งข้อมูลมาจากฟอร์ม';
        $_SESSION['status_code'] = 'error';
        header($location);
        // ทำการ redirect หรือใส่โค้ดที่ต้องการหลังจากไม่มีการส่งข้อมูลมา
    }
} elseif (isset($_POST['shpbtn'])) {
    $location = 'Location: pay_show.php';

    $fnd_id = $_POST['fnd_id'];
    $fnd_track = $_POST['fnd_track'];

    $fnd_status = 'อยู่ระหว่างการขนส่ง';
    $update_order_sql = "UPDATE bk_fnd_finder SET fnd_status = '$fnd_status', fnd_track = '$fnd_track' WHERE fnd_id = '$fnd_id'";
    if (mysqli_query($proj_connect, $update_order_sql)) {
        echo "UPDATE bk_fnd_finder SET fnd_status = '$fnd_status' WHERE fnd_id = '$fnd_id'";
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
