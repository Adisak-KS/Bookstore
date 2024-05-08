<?php
require_once __DIR__ . '/../../../connection.php';


if (isset($_POST['editbtn'])) {
    $pay_id = $_POST['pay_id'];
    $pay_name = $_POST['pay_name'];
    $pay_detail = $_POST['pay_detail'];
    $pay_show = $_POST['pay_show'];
     
    $location = 'Location: ' . $_SERVER['HTTP_REFERER'];

    // ตรวจสอบว่าชื่อช่องทางชำระเงินที่แก้ไขซ้ำกับชื่อช่องทางชำระเงินอื่นที่มีในฐานข้อมูลหรือไม่
    $checkDuplicateQuery = "SELECT pay_id FROM bk_ord_payment WHERE pay_name = '$pay_name' AND pay_id != '$pay_id'";
    $checkDuplicateResult = mysqli_query($proj_connect, $checkDuplicateQuery);

    if (mysqli_num_rows($checkDuplicateResult) > 0) {
        // ถ้าชื่อช่องทางชำระเงินซ้ำ กำหนดข้อความแจ้งเตือน
        $_SESSION['status'] = "ชื่อช่องทางชำระเงินซ้ำกับช่องทางชำระเงินอื่นที่มีในระบบ โปรดลองชื่ออื่น";
        $_SESSION['status_code'] = "ผิดพลาด";
        
        // ส่งกลับไปยังหน้าแก้ไข
        header($location);
    } else {
        // ถ้าชื่อช่องทางชำระเงินไม่ซ้ำ ทำการอัปเดตข้อมูลช่องทางชำระเงิน
        $updateQuery = "UPDATE bk_ord_payment 
                        SET pay_name = '$pay_name', 
                            pay_detail = '$pay_detail',
                            pay_show = '$pay_show'
                        WHERE pay_id = '$pay_id'";
        $updateResult = mysqli_query($proj_connect, $updateQuery);

        if ($updateResult) {
            $_SESSION['status'] = "อัปเดตช่องทางชำระเงินสำเร็จ";
            $_SESSION['status_code'] = "สำเร็จ";
        } else {
            $_SESSION['status'] = "เกิดข้อผิดพลาดในการอัปเดตช่องทางชำระเงิน";
            $_SESSION['status_code'] = "ผิดพลาด";
        }

        // ส่งกลับไปยังหน้าที่คุณต้องการ
        header($location);
    }
}


?>
