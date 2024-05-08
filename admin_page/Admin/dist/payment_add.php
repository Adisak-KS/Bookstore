<?php
require_once __DIR__ . '/../../../connection.php';
session_start();

$location = 'payment_show.php';

if (isset($_POST['addbtn'])) {
    // รับค่าจากฟอร์ม
    $pay_name = $_POST['pay_name'];
    $pay_detail = $_POST['pay_detail'];

    // ตรวจสอบว่า pay_name ไม่ซ้ำกัน
    $check_query = "SELECT * FROM bk_ord_payment WHERE pay_name = '$pay_name'";
    $check_result = mysqli_query($proj_connect, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        $_SESSION['status'] = "ชื่อช่องทางการชำระเงินซ้ำกัน";
        $_SESSION['status_code'] = "error";
        header('Location: ' . $location);
        exit();
    }

    // ตรวจสอบว่ามีการอัปโหลดไฟล์รูปภาพหรือไม่
    if (isset($_FILES['pay_logo']) && isset($_FILES['pay_img'])) {
        // รับข้อมูลไฟล์รูปภาพ
        $logo_name = $_FILES['pay_logo']['name'];
        $logo_tmp = $_FILES['pay_logo']['tmp_name'];
        $image_name = $_FILES['pay_img']['name'];
        $image_tmp = $_FILES['pay_img']['tmp_name'];

        // อัปโหลดไฟล์รูปภาพ
        $logo_upload_path = __DIR__ . '/../../../pay_logo/' . basename($logo_name);
        $image_upload_path = __DIR__ . '/../../../pay_img/' . basename($image_name);

        if (move_uploaded_file($logo_tmp, $logo_upload_path) && move_uploaded_file($image_tmp, $image_upload_path)) {
            // คำสั่ง SQL เพื่อเพิ่มข้อมูลลงในตาราง bk_ord_payment
            $query = "INSERT INTO bk_ord_payment (pay_name, pay_detail, pay_logo, pay_img) VALUES ('$pay_name', '$pay_detail', '$logo_name', '$image_name')";
            $query_run = mysqli_query($proj_connect, $query);

            if ($query_run) {
                $_SESSION['status'] = "เพิ่มสำเร็จ";
                $_SESSION['status_code'] = "success";
            } else {
                $_SESSION['status'] = "เพิ่มไม่สำเร็จ";
                $_SESSION['status_code'] = "error";
            }
        } else {
            $_SESSION['status'] = "เกิดข้อผิดพลาดในการอัปโหลดไฟล์รูปภาพ";
            $_SESSION['status_code'] = "error";
        }
    } else {
        $_SESSION['status'] = "โปรดเลือกไฟล์รูปภาพ";
        $_SESSION['status_code'] = "error";
    }

    header('Location: ' . $location);
    exit();
} else {
    $_SESSION['status'] = "ข้อมูลไม่ครบ";
    $_SESSION['status_code'] = "error";
    header('Location: ' . $location);
    exit();
}
?>
