<?php
require_once('connection.php');

if (!$proj_connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// ตรวจสอบว่ามีการรับ ord_id มาจาก URL หรือไม่
if (isset($_GET['ord_id'])) {
    $ord_id = $_GET['ord_id'];
    $ord_status = 'จัดส่งสำเร็จ';

    // สร้างคำสั่ง SQL เพื่ออัปเดต ord_status เป็น 'cancel'
    $updateOrderSQL = "UPDATE bk_ord_orders SET ord_status = '$ord_status' WHERE ord_id = $ord_id";


    // ทำการอัปเดตฐานข้อมูล
    if (mysqli_query($proj_connect, $updateOrderSQL)) {
        echo "อัปเดตสถานะใบสั่งซื้อเป็น 'จัดส่งสำเร็จ' เรียบร้อยแล้ว";
        $_SESSION['status'] = "จัดส่งสำเร็จแล้ว ขอบคุณที่ใช้บริการ";
        $_SESSION['status_code'] = "success";
        //header('Location: product-details.php?prd_id=' . $prd_row['prd_id']);
        header('Location: index.php');
    } else {
        //echo "Error updating record: " . mysqli_error($proj_connect);
        $_SESSION['status'] = "การทำรายการผิดพลาด โปรดลองอีกครั้ง";
        $_SESSION['status_code'] = "error";
        header('Location: index.php');
    }
} else {
    echo "ไม่ได้รับ ord_id จาก URL";
    $_SESSION['status'] = "การทำรายการผิดพลาด โปรดลองอีกครั้ง";
    $_SESSION['status_code'] = "error";
    header('Location: index.php');
}

mysqli_close($proj_connect);
