<?php
require_once __DIR__ . '/../../../connection.php';

if (isset($_POST['editbtn'])) {
    $shp_id = $_POST['shp_id'];
    $shp_name = $_POST['shp_name'];
    $shp_detail = $_POST['shp_detail'];
    $shp_price = $_POST['shp_price'];
    $shp_show = $_POST['shp_show'];

    $location = 'Location: ' . $_SERVER['HTTP_REFERER'];

    // ตรวจสอบว่าชื่อช่องทางการจัดส่งที่แก้ไขซ้ำกับชื่อช่องทางการจัดส่งอื่นที่มีในฐานข้อมูลหรือไม่
    $checkDuplicateQuery = "SELECT shp_id FROM bk_ord_shipping WHERE shp_name = '$shp_name' AND shp_id != '$shp_id'";
    $checkDuplicateResult = mysqli_query($proj_connect, $checkDuplicateQuery);

    if (mysqli_num_rows($checkDuplicateResult) > 0) {
        // ถ้าชื่อช่องทางการจัดส่งซ้ำ กำหนดข้อความแจ้งเตือน
        $_SESSION['status'] = "ชื่อช่องทางการจัดส่งซ้ำกับช่องทางการจัดส่งอื่นที่มีในระบบ โปรดลองชื่ออื่น";
        $_SESSION['status_code'] = "ผิดพลาด";

        // ส่งกลับไปยังหน้าแก้ไข
        header($location);
    } else {
        // ถ้าชื่อช่องทางการจัดส่งไม่ซ้ำ ทำการอัปเดตข้อมูลช่องทางการจัดส่ง
        $updateQuery = "UPDATE bk_ord_shipping 
                        SET shp_name = '$shp_name', 
                            shp_detail = '$shp_detail',
                            shp_price = '$shp_price',
                            shp_show = '$shp_show'
                        WHERE shp_id = '$shp_id'";
        $updateResult = mysqli_query($proj_connect, $updateQuery);

        if ($updateResult) {
            $_SESSION['status'] = "อัปเดตช่องทางการจัดส่งสำเร็จ";
            $_SESSION['status_code'] = "สำเร็จ";
        } else {
            $_SESSION['status'] = "เกิดข้อผิดพลาดในการอัปเดตช่องทางการจัดส่ง";
            $_SESSION['status_code'] = "ผิดพลาด";
        }

        // ส่งกลับไปยังหน้าที่คุณต้องการ
        header($location);
    }
}
