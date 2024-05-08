<?php
require_once('connection.php');
// ตรวจสอบว่ามีการส่งค่า fnd_id มาหรือไม่
if(isset($_GET['fnd_id'])) {
    $fnd_id = $_GET['fnd_id'];
}
elseif(isset($_SESSION['fnd_id'])){
    $fnd_id = $_SESSION['fnd_id'];
}
    // สร้างคำสั่ง SQL สำหรับอัปเดตสถานะการค้นหาให้เป็น "ยกเลิก"
    $update_query = "UPDATE bk_fnd_finder SET fnd_status = 'cancel' WHERE fnd_id = '$fnd_id'";

    // ทำการ execute คำสั่ง SQL
    if(mysqli_query($proj_connect, $update_query)) {
        // ถ้าอัปเดตสถานะเรียบร้อย
        $_SESSION['status'] = "ยกเลิกรายการตามหาหนังสือตามสั่งสำเร็จ";
        $_SESSION['status_code'] = "success";
    } else {
        // ถ้าเกิดข้อผิดพลาดในการอัปเดตสถานะ
        $_SESSION['status'] = "เกิดข้อผิดพลาดในการยกเลิกรายการตามหาหนังสือตาม";
        $_SESSION['status_code'] = "error";
    }


// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($proj_connect);

// ส่งกลับไปยังหน้าที่คุณต้องการ
header('Location: my-account-finder-order.php');
?>