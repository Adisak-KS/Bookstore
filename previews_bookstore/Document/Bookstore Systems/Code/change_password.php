<?php
require_once('connection.php');
session_start();

if (!$proj_connect) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $mmb_id = $_POST['mmb_id'];
    $current_password = $_POST['current-pwd'];
    $new_password = $_POST['new-pwd'];
    $confirm_password = $_POST['confirm-pwd'];

    // ตรวจสอบค่าว่าง
    if (empty($current_password) || empty($new_password) || empty($confirm_password)) {
        $_SESSION['status'] = "กรุณากรอกข้อมูลให้ครบทุกช่อง";
        $_SESSION['status_code'] = "error";
        header("Location: my-account.php"); // แก้ไขเส้นทางไปยังหน้าข้อมูลผู้ใช้งาน
        exit();
    }

    // ตรวจสอบรหัสผ่านเดิม
    $sql_check_password = "SELECT mmb_password FROM bk_auth_member WHERE mmb_id = '$mmb_id'";
    $result_check_password = mysqli_query($proj_connect, $sql_check_password);
    $row_check_password = mysqli_fetch_assoc($result_check_password);
    $hashed_current_password = $row_check_password['mmb_password'];

    if (!password_verify($current_password, $hashed_current_password)) {
        $_SESSION['status'] = "รหัสผ่านเดิมไม่ถูกต้อง";
        $_SESSION['status_code'] = "error";
        header("Location: my-account.php"); // แก้ไขเส้นทางไปยังหน้าข้อมูลผู้ใช้งาน
        exit();
    }

    // ตรวจสอบรหัสผ่านใหม่
    if ($new_password !== $confirm_password) {
        $_SESSION['status'] = "ยืนยันรหัสผ่านใหม่ไม่ตรงกัน";
        $_SESSION['status_code'] = "error";
        header("Location: my-account.php"); // แก้ไขเส้นทางไปยังหน้าข้อมูลผู้ใช้งาน
        exit();
    }

    // เข้ารหัสรหัสผ่านใหม่
    $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);

    // อัปเดตรหัสผ่านใหม่ในฐานข้อมูล
    $sql_update_password = "UPDATE bk_auth_member SET mmb_password = '$hashed_new_password' WHERE mmb_id = '$mmb_id'";
    if (mysqli_query($proj_connect, $sql_update_password)) {
        $_SESSION['status'] = "เปลี่ยนรหัสผ่านสำเร็จ";
        $_SESSION['status_code'] = "success";
        header("Location: my-account.php"); // แก้ไขเส้นทางไปยังหน้าข้อมูลผู้ใช้งาน
        exit();
    } else {
        $_SESSION['status'] = "เกิดข้อผิดพลาดในการเปลี่ยนรหัสผ่าน";
        $_SESSION['status_code'] = "error";
        header("Location: my-account.php"); // แก้ไขเส้นทางไปยังหน้าข้อมูลผู้ใช้งาน
        exit();
    }
}

mysqli_close($proj_connect);
?>
