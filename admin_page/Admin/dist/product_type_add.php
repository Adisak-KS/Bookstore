<?php
require_once __DIR__ . '/../../../connection.php';
session_start();

if (isset($_POST['addbtn'])) {
    $pty_name = $_POST['pty_name'];
    $pty_detail = $_POST['pty_detail'];

    // ตรวจสอบความถูกต้องของข้อมูล
    if (!empty($pty_name) && !empty($pty_detail)) {
        // ตรวจสอบว่าชื่อประเภทสินค้าซ้ำหรือไม่
        $checkDuplicateQuery = "SELECT * FROM bk_prd_type WHERE pty_name = '$pty_name'";
        $checkDuplicateResult = mysqli_query($proj_connect, $checkDuplicateQuery);

        if (mysqli_num_rows($checkDuplicateResult) > 0) {
            // ถ้าชื่อซ้ำให้แสดงข้อความแจ้งเตือน
            $_SESSION['status'] = "ชื่อประเภทสินค้าซ้ำ กรุณาเลือกชื่ออื่น";
            $_SESSION['status_code'] = "ผิดพลาด";
        } else {
            // หากชื่อไม่ซ้ำให้ทำการเพิ่มประเภทสินค้า
            $insertQuery = "INSERT INTO bk_prd_type (pty_name, pty_detail) VALUES ('$pty_name', '$pty_detail')";
            $insertResult = mysqli_query($proj_connect, $insertQuery);

            if ($insertResult) {
                $_SESSION['status'] = "เพิ่มประเภทสินค้าสำเร็จ";
                $_SESSION['status_code'] = "สำเร็จ";
                header('Location: product_type_show.php'); // ย้ายไปยังหน้าอื่นหลังจากเพิ่มสำเร็จ
            } else {
                $_SESSION['status'] = "ไม่สามารถเพิ่มประเภทสินค้าได้";
                $_SESSION['status_code'] = "ผิดพลาด";
            }
        }
    } else {
        $_SESSION['status'] = "กรุณากรอกข้อมูลให้ครบถ้วน";
        $_SESSION['status_code'] = "ผิดพลาด";
    }
}

// ส่งกลับไปยังหน้าที่คุณต้องการ
header('Location: product_type_show.php');
?>
