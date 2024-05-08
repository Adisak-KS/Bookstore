<?php
require_once __DIR__ . '/../../../connection.php';

// ตรวจสอบว่ามีการอัปโหลดรูปภาพหรือไม่
if (isset($_FILES['image'])) {
    $mmb_id = $_POST['mmb_id'];

    // ตรวจสอบว่าเกิดข้อผิดพลาดขณะอัปโหลดหรือไม่
    if ($_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // ตรวจสอบประเภทของไฟล์
        $allowed_image_types = array('image/jpeg', 'image/png', 'image/gif');
        if (!in_array($_FILES['image']['type'], $allowed_image_types)) {
            $_SESSION['status'] = "รูปภาพที่อัปโหลดต้องเป็นไฟล์ประเภท JPEG, PNG, หรือ GIF เท่านั้น";
            $_SESSION['status_code'] = "error";
            header('Location: member_edit_form.php');
            exit;
        }

        // ตรวจสอบขนาดของไฟล์
        $max_file_size = 2 * 1024 * 1024; // 2 MB (ขนาดให้ใส่เป็นไบต์)
        if ($_FILES['image']['size'] > $max_file_size) {
            $_SESSION['status'] = "ขนาดไฟล์รูปภาพต้องไม่เกิน 2 MB";
            $_SESSION['status_code'] = "error";
            header('Location: member_edit_form.php');
            exit;
        }

        // กำหนดตัวแปรเก็บชื่อไฟล์ที่อัปโหลด
        $image_name = $_FILES['image']['name'];

        // อัปโหลดไฟล์ไปยังโฟลเดอร์ที่กำหนด
        $target_dir = "../../../profile/";
        $target_file = $target_dir . basename($image_name);

        // เปลี่ยนชื่อไฟล์เป็นรหัสสินค้า
        $new_image_name = $mmb_id . '.' . pathinfo($image_name, PATHINFO_EXTENSION);
        $new_target_file = $target_dir . $new_image_name;

        // ย้ายไฟล์ที่อัปโหลดไปยังโฟลเดอร์
        if (move_uploaded_file($_FILES['image']['tmp_name'], $new_target_file)) {
            // เมื่ออัปโหลดสำเร็จ บันทึกชื่อไฟล์ในฐานข้อมูล
            $sql_update_image = "UPDATE bk_auth_member SET mmb_profile = '$new_image_name' WHERE mmb_id = '$mmb_id'";
            $result_update_image = mysqli_query($proj_connect, $sql_update_image);

            if ($result_update_image) {
                // บันทึกสำเร็จ
                $_SESSION['status'] = "อัปโหลดรูปภาพเรียบร้อยแล้ว";
                $_SESSION['status_code'] = "success";
            } else {
                // บันทึกไม่สำเร็จ
                $_SESSION['status'] = "เกิดข้อผิดพลาดในการบันทึกชื่อไฟล์";
                $_SESSION['status_code'] = "error";
            }
        } else {
            // อัปโหลดไม่สำเร็จ
            $_SESSION['status'] = "เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ";
            $_SESSION['status_code'] = "error";
        }
    } else {
        // อัปโหลดไม่สำเร็จ
        $_SESSION['status'] = "เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ";
        $_SESSION['status_code'] = "error";
    }
}

// ย้อนกลับไปที่หน้าแก้ไขสินค้า
header('Location: member_edit_form.php');
?>
