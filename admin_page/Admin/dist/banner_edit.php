<?php
require_once __DIR__ . '/../../../connection.php';

$location = 'Location: banner_show.php';

// ตรวจสอบว่ามีการส่งค่า order0 หรือไม่
if (isset($_GET['order0'])) {
    // วนลูปเพื่ออัปเดตค่าลำดับในตาราง bk_set_banner
    $index = 0;
    while (isset($_GET['order' . $index])) {
        // ดึงค่า order, bnn_id, และ bnn_show ที่ถูกส่งมา
        $order = $_GET['order' . $index];
        $bnn_id = $_GET['bnn_id' . $index];
        $bnn_show = $_GET['bnn_show' . $index];

        // อัปเดตค่าลำดับและ bnn_show ในตาราง bk_set_banner ตาม bnn_id ที่ตรงกัน
        $sql = "UPDATE bk_set_banner SET bnn_order = $order, bnn_show = $bnn_show WHERE bnn_id = $bnn_id";
        $update_query_run = mysqli_query($proj_connect, $sql);

        if ($update_query_run) {
            $_SESSION['status'] = "อัปเดตข้อมูลสำเร็จ";
            $_SESSION['status_code'] = "success";
        } else {
            $_SESSION['status'] = "เกิดข้อผิดพลาดในการอัปเดตสถานะ";
            $_SESSION['status_code'] = "error";
        }
        $index++;
    }
    echo '1';
    header($location);
    exit();
} elseif (isset($_POST['editbtn'])) {
    echo 'elseif';

    $bnn_id = $_POST['bnn_id'];
    $bnn_name = $_POST['bnn_name'];
    $bnn_link = $_POST['bnn_link'];
    $bnn_show = $_POST['bnn_show'];

    $location = 'Location: banner_edit_form.php';

    // อัปเดตข้อมูลในฐานข้อมูล
    $sql = "UPDATE bk_set_banner SET bnn_name = '$bnn_name', bnn_show = '$bnn_show', bnn_link = '$bnn_link' WHERE bnn_id = '$bnn_id'";
    $result = mysqli_query($proj_connect, $sql);

    if ($result) {
        $_SESSION['status'] = "อัปเดตข้อมูลเรียบร้อยแล้ว";
        $_SESSION['status_code'] = "success";
    } else {
        $_SESSION['status'] = "เกิดข้อผิดพลาดในการอัปเดตข้อมูล";
        $_SESSION['status_code'] = "error";
    }
    header($location);
    exit();
} elseif (isset($_POST['submit_image'])) {
    // รับค่าจากฟอร์ม
    $bnn_id = $_POST['bnn_id'];
    $location = 'Location: banner_edit_form.php';
    // ตรวจสอบว่ามีการเลือกไฟล์รูปภาพหรือไม่
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
        // รับข้อมูลของไฟล์รูปภาพ
        $image_name = $_FILES['image']['name'];
        $image_tmp = $_FILES['image']['tmp_name'];
        $image_size = $_FILES['image']['size'];

        // ตรวจสอบประเภทของไฟล์รูปภาพ
        $image_info = getimagesize($image_tmp);
        if ($image_info !== false) {
            // ตรวจสอบขนาดของไฟล์รูปภาพ
            if ($image_size > 5 * 1024 * 1024) { // 5 MB
                // ถ้าขนาดมากกว่า 5 MB ให้แสดงข้อความแจ้งเตือน
                $_SESSION['status'] = "ขนาดไฟล์รูปภาพต้องไม่เกิน 5 MB";
                $_SESSION['status_code'] = "error";
            } else {
                // กำหนดชื่อใหม่สำหรับรูปภาพ
                $new_image_name = uniqid('bnn_') . '.' . pathinfo($image_name, PATHINFO_EXTENSION);

                // บันทึกรูปภาพลงในโฟลเดอร์ bnn_image
                $target_path = __DIR__ . '/../../..//bnn_image/' . $new_image_name;
                if (move_uploaded_file($image_tmp, $target_path)) {
                    // บันทึกชื่อไฟล์รูปภาพลงในฐานข้อมูล
                    $sql = "UPDATE bk_set_banner SET bnn_image = '$new_image_name' WHERE bnn_id = '$bnn_id'";
                    $result = mysqli_query($proj_connect, $sql);
                    if ($result) {
                        $_SESSION['status'] = "อัปโหลดรูปภาพและอัปเดตข้อมูลเรียบร้อยแล้ว";
                        $_SESSION['status_code'] = "success";
                    } else {
                        $_SESSION['status'] = "เกิดข้อผิดพลาดในการอัปเดตข้อมูล";
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
        $_SESSION['status'] = "โปรดเลือกไฟล์รูปภาพ";
        $_SESSION['status_code'] = "error";
    }
    header($location);
    exit;
} else {
    $_SESSION['status'] = "ไม่พบข้อมูลการอัปเดต";
    $_SESSION['status_code'] = "error";
    echo 'else';
}
header($location);
exit(); // หยุดการทำงานของสคริปต์ที่นี่
