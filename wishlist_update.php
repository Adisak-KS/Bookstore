<?php
require_once('connection.php');

// ตรวจสอบว่ามีการส่ง prd_id และ mmb_id มาหรือไม่
if (isset($_GET['wsl_id'])) {
    $wsl_id = $_GET['wsl_id'];

    // ตรวจสอบว่า prd_id และ mmb_id ไม่ว่าง
    $insert_query = "DELETE FROM bk_mmb_wishlist WHERE wsl_id = $wsl_id;";
    $insert_result = mysqli_query($proj_connect, $insert_query);

    if ($insert_result) {
        $_SESSION['status'] = "เพิ่มสินค้าลงใน Wishlist สำเร็จ";
        $_SESSION['status_code'] = "สำเร็จ";
    } else {
        $_SESSION['status'] = "ไม่สามารถเพิ่มสินค้าใน Wishlist ได้";
        $_SESSION['status_code'] = "ผิดพลาด";
    }
} else {
    $_SESSION['status'] = "ไม่มีข้อมูลที่ส่งมา";
    $_SESSION['status_code'] = "ผิดพลาด";
}

// ลิ้งค์กลับไปยังหน้า Wishlist
header('Location: my-account-wishlist.php');
exit();
