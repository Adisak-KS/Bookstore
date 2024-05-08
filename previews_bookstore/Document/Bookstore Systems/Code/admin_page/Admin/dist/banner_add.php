<?php
// เชื่อมต่อกับฐานข้อมูล
require_once __DIR__ . '/../../../connection.php';

$location = 'Location: banner_show.php';

// ตรวจสอบว่ามีการส่งข้อมูลมาหรือไม่
if (isset($_POST['addbtn'])) {
    // รับค่าจากฟอร์ม
    $bnn_name = $_POST['bnn_name'];
    $bnn_link = $_POST['bnn_link'];

    // ตรวจสอบว่ามีการเลือกรูปภาพหรือไม่
    if (isset($_FILES['bnn_image']) && $_FILES['bnn_image']['error'] === UPLOAD_ERR_OK) {
        // รับข้อมูลของไฟล์รูปภาพ
        $image_name = $_FILES['bnn_image']['name'];
        $image_tmp = $_FILES['bnn_image']['tmp_name'];
        $image_size = $_FILES['bnn_image']['size'];

        // ตรวจสอบประเภทของไฟล์รูปภาพ
        $image_info = getimagesize($image_tmp);
        if ($image_info !== false) {
            // ตรวจสอบขนาดของไฟล์รูปภาพ
            if ($image_size > 5 * 1024 * 1024) { // 5 MB
                // ถ้าขนาดมากกว่า 5 MB ให้แสดงข้อความแจ้งเตือน
                $_SESSION['status'] = "ขนาดไฟล์รูปภาพต้องไม่เกิน 5 MB";
                $_SESSION['status_code'] = "error";
            } else {
                // ตรวจสอบว่าชื่อแบนเนอร์ซ้ำหรือไม่
                $check_sql = "SELECT MAX(bnn_order) AS max_order FROM bk_set_banner";
                $check_result = mysqli_query($proj_connect, $check_sql);
                $max_order_row = mysqli_fetch_assoc($check_result);
                $max_order = $max_order_row['max_order'];
                $new_order = $max_order + 1;

                // กำหนดชื่อใหม่สำหรับรูปภาพ
                $new_image_name = uniqid('bnn_') . '.' . pathinfo($image_name, PATHINFO_EXTENSION);

                // บันทึกรูปภาพลงในโฟลเดอร์ bnn_image
                $target_path = __DIR__ . '/../../..//bnn_image/' . $new_image_name;
                if (move_uploaded_file($image_tmp, $target_path)) {
                    // บันทึกข้อมูลแบนเนอร์ลงในฐานข้อมูล
                    $sql = "INSERT INTO bk_set_banner (bnn_name, bnn_image, bnn_link, bnn_order) VALUES ('$bnn_name', '$new_image_name', '$bnn_link', $new_order)";
                    $result = mysqli_query($proj_connect, $sql);
                    if ($result) {
                        $_SESSION['status'] = "บันทึกข้อมูลและรูปภาพแบนเนอร์เรียบร้อยแล้ว";
                        $_SESSION['status_code'] = "success";
                    } else {
                        $_SESSION['status'] = "เกิดข้อผิดพลาดในการบันทึกข้อมูล";
                        $_SESSION['status_code'] = "error";
                    }
                } else {
                    $_SESSION['status'] = "เกิดข้อผิดพลาดในการอัปโหลดรูปภาพ";
                    $_SESSION['status_code'] = "error";
                }
            }
        } else {
            $_SESSION['status'] = "ไฟล์ที่เลือกไม่ใช่รูปภาพ";
            $_SESSION['status_code'] = "error";
        }
    } else {
        $_SESSION['status'] = "โปรดเลือกรูปภาพ";
        $_SESSION['status_code'] = "error";
    }
} else {
    $_SESSION['status'] = "ไม่พบการส่งข้อมูล";
    $_SESSION['status_code'] = "error";
}

// Redirect ไปยังหน้าที่ต้องการ
header($location);
exit(); // หยุดการทำงานของสคริปต์ที่นี่
?>
