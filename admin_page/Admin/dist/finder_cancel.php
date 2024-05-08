<?php
require_once __DIR__ . '/../../../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['fnd_id'])) {
    $fnd_id = $_POST['fnd_id'];
    $fnd_status = 'ไม่พบสินค้าที่ต้องการ';
    $location = 'Location: finder_show.php';

    // เตรียมคำสั่ง SQL สำหรับอัปเดตค่าในฐานข้อมูล
    $update_query = "UPDATE bk_fnd_finder SET fnd_status = '$fnd_status' WHERE fnd_id = $fnd_id";

    // ทำการ execute คำสั่ง SQL
    if (mysqli_query($proj_connect, $update_query)) {
        // อัปเดตข้อมูลสำเร็จ
        echo "อัปเดตข้อมูลสำเร็จ";
        $_SESSION['status'] = 'ยกเลิกรายการสำเร็จ';
        $_SESSION['status_code'] = 'success';
        header($location);
        // สามารถเพิ่มการส่งคืนไปยังหน้าอื่นได้ที่นี่
    } else {
        // อัปเดตข้อมูลไม่สำเร็จ
        echo "เกิดข้อผิดพลาดในการอัปเดตข้อมูล: " . mysqli_error($proj_connect);
        // สามารถเพิ่มการส่งคืนไปยังหน้าอื่นได้ที่นี่
        $_SESSION['status'] = 'เกิดข้อผิดพลาดในการอัปเดตข้อมูล';
        $_SESSION['status_code'] = 'success';
        header($location);
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    mysqli_close($proj_connect);
}
?>
