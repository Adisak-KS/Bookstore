<?php
require_once __DIR__ . '/../../../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['editbtn'])) {
    $prov_id = $_POST['prov_id'];
    $prov_name = $_POST['prov_name'];

    $location = 'Location: ' . $_SERVER['HTTP_REFERER'];

    // เตรียม SQL query สำหรับตรวจสอบว่าชื่อจังหวัดซ้ำหรือไม่
    $check_duplicate_query = "SELECT prov_id FROM bk_province WHERE prov_name = '$prov_name' AND prov_id != $prov_id";
    $check_duplicate_result = mysqli_query($proj_connect, $check_duplicate_query);

    if (mysqli_num_rows($check_duplicate_result) > 0) {
        // ถ้าชื่อจังหวัดซ้ำกับข้อมูลในฐานข้อมูล
        $_SESSION['status'] = "ชื่อจังหวัดซ้ำกับที่มีในระบบ โปรดลองชื่ออื่น";
        $_SESSION['status_code'] = "ผิดพลาด";

        // ส่งกลับไปยังหน้าแก้ไข
        header($location);
    } else {
        // ถ้าชื่อจังหวัดไม่ซ้ำ ทำการอัปเดตข้อมูล
        $update_query = "UPDATE bk_province SET prov_name = '$prov_name' WHERE prov_id = $prov_id";

        // ทำการ execute SQL query
        if (mysqli_query($proj_connect, $update_query)) {
            $_SESSION['status'] = "อัปเดตข้อมูลจังหวัดสำเร็จ";
            $_SESSION['status_code'] = "สำเร็จ";
        } else {
            $_SESSION['status'] = "เกิดข้อผิดพลาดในการอัปเดตข้อมูลจังหวัด";
            $_SESSION['status_code'] = "ผิดพลาด";
        }

        // ส่งกลับไปยังหน้าที่คุณต้องการ
        header($location);
    }
}
