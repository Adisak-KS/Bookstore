<?php
require_once __DIR__ . '/../../../connection.php';

if (isset($_POST['editbtn'])) {
    $publ_id = $_POST['publ_id'];
    $publ_name = $_POST['publ_name'];
    $publ_detail = $_POST['publ_detail'];

    $location = 'Location: ' . $_SERVER['HTTP_REFERER'];

    // ตรวจสอบชื่อซ้ำก่อน
    $checkQuery = "SELECT publ_id FROM bk_prd_publisher WHERE publ_name = '$publ_name' AND publ_id != '$publ_id'";
    $checkResult = mysqli_query($proj_connect, $checkQuery);

    if (mysqli_num_rows($checkResult) > 0) {
        $_SESSION['status'] = "ชื่อสำนักพิมพ์ซ้ำกับข้อมูลที่มีอยู่แล้ว";
        $_SESSION['status_code'] = "ผิดพลาด";
        header($location);
        exit();
    } else {

        $updateQuery = "UPDATE bk_prd_publisher SET publ_name = '$publ_name', publ_detail = '$publ_detail' WHERE publ_id = '$publ_id'";
        $updateResult = mysqli_query($proj_connect, $updateQuery);

        if ($updateResult) {
            $_SESSION['status'] = "อัปเดตสำนักพิมพ์สำเร็จ";
            $_SESSION['status_code'] = "สำเร็จ";
        } else {
            $_SESSION['status'] = "เกิดข้อผิดพลาดในการอัปเดตสำนักพิมพ์";
            $_SESSION['status_code'] = "ผิดพลาด";
        }
    }
    // ส่งกลับไปยังหน้าที่คุณต้องการ
    header($location);  
}
