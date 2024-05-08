<?php
// เชื่อมต่อฐานข้อมูล
require_once ('connection.php');
session_start();

// ตรวจสอบว่ามีค่า $_POST['mmb_id'] หรือไม่
if (isset($_POST['mmb_id'])) {
    $mmb_id = $_POST['mmb_id']; // รับค่า mmb_id จากฟอร์ม

    // ตัวแปร Location
    $redirect_url = 'my-account.php';
} else {
    // หากไม่มีค่า $_POST['mmb_id'] ให้กลับไปที่หน้าที่ต้องการ
    header('Location: ' . $redirect_url);
    exit(); // ออกจากการทำงานของสคริปต์
}

if (isset($_POST['upload'])) {
    $file = $_FILES['image'];

    if (isset($_FILES['image']['name'])) {
        // ดำเนินการอัปโหลดไฟล์ต่อไป
        $file_name = $_FILES['image']['name'];
        $file_tmp = $_FILES['image']['tmp_name'];
        $file_type = $_FILES['image']['type'];
    
        // ตรวจสอบประเภทของไฟล์ (ในที่นี้เราจะตรวจสอบเฉพาะรูปภาพ)
        $allowed_types = array('image/jpeg', 'image/png', 'image/gif');
        if (in_array($file_type, $allowed_types)) {
            // อัปโหลดไฟล์ไปยังโฟลเดอร์ที่ต้องการ
            $upload_dir = __DIR__ . '/profile/';
    
            // สร้างชื่อไฟล์ใหม่ตาม ID ของสมาชิก
            $new_file_name = $_POST['mmb_id'] . '.' . pathinfo($file_name, PATHINFO_EXTENSION);
            $file_path = $upload_dir . $new_file_name;
    
            // ย้ายไฟล์ที่อัปโหลดไปยังโฟลเดอร์ที่กำหนด
            move_uploaded_file($file_tmp, $file_path);
    
            // เพิ่มโค้ดสำหรับเพิ่มข้อมูลลงในฐานข้อมูล (ตามโครงสร้างฐานข้อมูลของคุณ)
            $query = "UPDATE bk_auth_member SET mmb_profile ='$new_file_name' WHERE mmb_id='{$_POST['mmb_id']}' ";
            $query_run = mysqli_query($proj_connect, $query);
    
            // ตั้งค่า session และเปลี่ยนเส้นทางหน้าเพจ
            $_SESSION['status'] = "Upload สำเร็จ";
            $_SESSION['status_code'] = "success";
            header('Location: ' . $redirect_url);
            exit(); // ออกจากการทำงานของสคริปต์
        } else {
            // ตั้งค่า session และเปลี่ยนเส้นทางหน้าเพจ
            $_SESSION['status'] = "ประเภทของไฟล์ไม่ถูกต้อง โปรดอัปโหลดรูปที่เป็น .jpeg .png หรือ .gif เท่านั้น";
            $_SESSION['status_code'] = "warning";
            header('Location: ' . $redirect_url);
            exit(); // ออกจากการทำงานของสคริปต์
        }
    } else {
        // ตั้งค่า session และเปลี่ยนเส้นทางหน้าเพจ
        $_SESSION['status'] = "ไม่พบไฟล์ที่อัปโหลด โปรดลองอีกครั้ง";
        $_SESSION['status_code'] = "warning";
        header('Location: ' . $redirect_url);
        exit(); // ออกจากการทำงานของสคริปต์
    }
    
}

// ถ้าไม่มีการอัปโหลดไฟล์ ตั้งค่า session และเปลี่ยนเส้นทางหน้าเพจ
$_SESSION['status'] = "ไม่พบไฟล์ที่อัปโหลด โปรดลองอีกครั้ง";
$_SESSION['status_code'] = "warning";
header('Location: ' . $redirect_url);
exit(); // ออกจากการทำงานของสคริปต์
?>
