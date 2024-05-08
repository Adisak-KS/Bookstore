<?php
require_once('connection.php');

if (!$proj_connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// ตรวจสอบว่ามีการรับ fnd_id มาจาก URL หรือไม่
if (isset($_GET['fnd_id'])) {
    $fnd_id = $_GET['fnd_id'];
    $fnd_status = 'จัดส่งสำเร็จ';

    // สร้างคำสั่ง SQL เพื่ออัปเดต fnd_status เป็น 'cancel'
    $updateOrderSQL = "UPDATE bk_fnd_finder SET fnd_status = '$fnd_status' WHERE fnd_id = $fnd_id";

    // ทำการอัปเดตฐานข้อมูล
    if (mysqli_query($proj_connect, $updateOrderSQL)) {
        echo "อัปเดตสถานะใบสั่งซื้อเป็น 'จัดส่งสำเร็จ' เรียบร้อยแล้ว";
        $_SESSION['status'] = "จัดส่งสำเร็จแล้ว ขอบคุณที่ใช้บริการ";
        $_SESSION['status_code'] = "success";
        header('Location: my-account-finder-order.php');
    } else {
        //echo "Error updating record: " . mysqli_error($proj_connect);
        $_SESSION['status'] = "การทำรายการผิดพลาด โปรดลองอีกครั้ง";
        $_SESSION['status_code'] = "error";
        header('Location: index.php');
    }
} else {
    echo "ไม่ได้รับ fnd_id จาก URL";
    $_SESSION['status'] = "การทำรายการผิดพลาด โปรดลองอีกครั้ง";
    $_SESSION['status_code'] = "error";
    header('Location: my-account-finder-order.php');
}

mysqli_close($proj_connect);
