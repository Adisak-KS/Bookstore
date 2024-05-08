<?php
require_once __DIR__ . '/../../../connection.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $location = 'Location: staff_account_form.php';

    // ตรวจสอบว่าไฟล์รูปถูกอัปโหลดหรือไม่
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        // ตรวจสอบประเภทของไฟล์
        $image_info = getimagesize($_FILES['image']['tmp_name']);
        if ($image_info !== false) {
            // ไฟล์เป็นรูปภาพ
            // ดำเนินการอัปโหลดไฟล์รูป
            $file_tmp = $_FILES['image']['tmp_name'];
            $file_name = uniqid() . '_' . $_FILES['image']['name']; // เพิ่มตัวเลขสุ่มด้วย uniqid()

            // กำหนดตำแหน่งที่จะบันทึกไฟล์รูป
            $upload_path = '../../../profile/'; // ต้องสร้างโฟลเดอร์ uploads ในไดเรกทอรีเดียวกับไฟล์ PHP นี้
            $target_path = $upload_path . $file_name;

            // บันทึกไฟล์รูป
            move_uploaded_file($file_tmp, $target_path);

            // รับค่า ID ของพนักงานจากฟอร์ม
            $stf_id = $_POST['stf_id'];

            // เตรียม SQL query สำหรับอัปเดตข้อมูลในตาราง bk_auth_staff
            $update_query = "UPDATE bk_auth_staff SET stf_profile = '$file_name' WHERE stf_id = $stf_id";

            // ทำการ execute SQL query
            if (mysqli_query($proj_connect, $update_query)) {
                echo "อัปโหลดรูปภาพและอัปเดตข้อมูลสำเร็จ";
                $_SESSION['status'] = "อัปโหลดรูปภาพสำเร็จ";
                $_SESSION['status_code'] = "สำเร็จ";
                header($location);
            } else {
                echo "มีข้อผิดพลาดในการอัปเดตข้อมูล: " . mysqli_error($proj_connect);
                $_SESSION['status'] = "มีข้อผิดพลาดในการอัปเดตข้อมูล";
                $_SESSION['status_code'] = "ผิดพลาด";
                header($location);
            }
        } else {
            // ไฟล์ไม่ใช่รูปภาพ
            echo "ไฟล์ที่อัปโหลดไม่ใช่รูปภาพ";
            $_SESSION['status'] = "ไฟล์ที่อัปโหลดไม่ใช่รูปภาพ";
            $_SESSION['status_code'] = "ผิดพลาด";
            header($location);
        }
    } else {
        echo "มีข้อผิดพลาดในการอัปโหลดไฟล์รูป";
        $_SESSION['status'] = "มีข้อผิดพลาดในการอัปโหลดไฟล์รูป";
        $_SESSION['status_code'] = "ผิดพลาด";
        header($location);
    }

    // ปิดการเชื่อมต่อฐานข้อมูล
    mysqli_close($proj_connect);
}
?>
