<?php
require_once __DIR__ . '/../../../connection.php';

// เช็คว่ามีไฟล์ถูกอัปโหลดหรือไม่
if (isset($_FILES['fileToUpload'])) {
    $set_id = $_POST['set_id'];

    // ระบุโฟลเดอร์ที่จะบันทึกไฟล์
    $uploadDir = 'assets/images/';

    // ตั้งชื่อไฟล์ใหม่เป็น 'webicon' ก่อนนำไปบันทึก
    // โดยเราจะใช้ชื่อเดิมของไฟล์ที่ผู้ใช้อัปโหลด
    //$newFileName = 'webicon';
    $newFileName = $set_id;

    // ดึงสกุลของไฟล์ที่อัปโหลด
    $fileExtension = pathinfo($_FILES['fileToUpload']['name'], PATHINFO_EXTENSION);

    // รวม path และชื่อไฟล์เพื่อบันทึก
    $uploadFile = $uploadDir . $newFileName . '.' . $fileExtension;

    // ตรวจสอบสกุลของไฟล์ก่อนอัปโหลด
    $allowedExtensions = ['jpg', 'jpeg', 'png'];

    if (in_array($fileExtension, $allowedExtensions)) {
        // บันทึกไฟล์
        if (move_uploaded_file($_FILES['fileToUpload']['tmp_name'], $uploadFile)) {
            // อัปเดตชื่อไฟล์ในฐานข้อมูล
            $updateQuery = "UPDATE bk_setting SET set_detail = '$newFileName.$fileExtension' WHERE set_id = '$set_id'";
            mysqli_query($proj_connect, $updateQuery);

            unset($_SESSION['logo']);

            $_SESSION['status'] = "อัปโหลดรูปภาพเรียบร้อยแล้ว";
            $_SESSION['status_code'] = "สำเร็จ";
        } else {
            $_SESSION['status'] = "เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ";
            $_SESSION['status_code'] = "ผิดพลาด";
        }
    } else {
        $_SESSION['status'] = "สกุลของไฟล์ไม่ถูกต้อง อัปโหลดรูปภาพเฉพาะไฟล์ .jpg, .jpeg, และ png เท่านั้น";
        $_SESSION['status_code'] = "ผิดพลาด";
    }
} else {
    $_SESSION['status'] = "ไม่พบรูปภาพที่จะอัปโหลด";
    $_SESSION['status_code'] = "ผิดพลาด";
}

// ส่งกลับไปยังหน้าที่คุณต้องการ
header('Location: setting_edit_form.php');
