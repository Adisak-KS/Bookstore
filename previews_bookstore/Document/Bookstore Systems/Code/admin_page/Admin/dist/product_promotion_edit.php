<?php
require_once __DIR__ . '/../../../connection.php';


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $prp_id = $_POST['prp_id'];
    $prp_name = $_POST['prp_name'];
    $prp_detail = $_POST['prp_detail'];
    $prp_discount = $_POST['prp_discount'];
    $prp_start = $_POST['prp_start'];
    $prp_end = $_POST['prp_end'];
    $prp_show = $_POST['prp_show'];

    $location = 'Location: ' . $_SERVER['HTTP_REFERER'];

    // ตรวจสอบว่าชื่อสินค้าที่แก้ไขซ้ำกับชื่อสินค้าอื่นที่มีในฐานข้อมูลหรือไม่
    $checkDuplicateQuery = "SELECT prp_id FROM bk_promotion WHERE prp_name = '$prp_name' AND prp_id != '$prp_id'";
    $checkDuplicateResult = mysqli_query($proj_connect, $checkDuplicateQuery);

    if (mysqli_num_rows($checkDuplicateResult) > 0) {
        // ถ้าชื่อสินค้าซ้ำ กำหนดข้อความแจ้งเตือน
        $_SESSION['status'] = "ชื่อสินค้าซ้ำกับสินค้าอื่นที่มีในระบบ โปรดลองชื่ออื่น";
        $_SESSION['status_code'] = "ผิดพลาด";

        // ส่งกลับไปยังหน้าแก้ไข
        header($location);
    } else {
        // ถ้าชื่อสินค้าไม่ซ้ำ ทำการอัปเดตข้อมูลสินค้า
        $updateQuery = "UPDATE bk_promotion 
                        SET prp_name = '$prp_name', 
                            prp_detail = '$prp_detail',
                            prp_start = '$prp_start',
                            prp_end = '$prp_end',
                            prp_show = '$prp_show',
                            prp_discount = '$prp_discount'
                        WHERE prp_id = '$prp_id'";
        $updateResult = mysqli_query($proj_connect, $updateQuery);

        if ($updateResult) {
            $_SESSION['status'] = "อัปเดตโปรโมชันสำเร็จ";
            $_SESSION['status_code'] = "สำเร็จ";
        } else {
            $_SESSION['status'] = "เกิดข้อผิดพลาดในการอัปเดตโปรโมชัน";
            $_SESSION['status_code'] = "ผิดพลาด";
        }

        // ส่งกลับไปยังหน้าที่คุณต้องการ
        header($location);
    }
}
