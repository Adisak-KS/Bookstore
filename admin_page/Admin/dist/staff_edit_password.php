<?php
require_once __DIR__ . '/../../../connection.php';

if (isset($_POST['editbtn'])) {
    $stf_id = $_POST['stf_id'];
    $current_password = $_POST['current_password'];
    $new_password = $_POST['new_password'];
    $confirm_password = $_POST['confirm_password'];

    $location = $_SERVER['HTTP_REFERER'];

    // ดึงข้อมูลรหัสผ่านปัจจุบันจากฐานข้อมูล
    $getPasswordQuery = "SELECT stf_password FROM bk_auth_staff WHERE stf_id = '$stf_id'";
    $getPasswordResult = mysqli_query($proj_connect, $getPasswordQuery);

    if ($getPasswordResult) {
        $row = mysqli_fetch_assoc($getPasswordResult);
        $hashed_current_password = $row['stf_password'];

        // ตรวจสอบรหัสผ่านปัจจุบัน
        if (password_verify($current_password, $hashed_current_password)) {
            // ตรวจสอบว่ารหัสผ่านใหม่และยืนยันรหัสผ่านตรงกันหรือไม่
            if ($new_password === $confirm_password) {
                // อัปเดตรหัสผ่านใหม่
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                $updatePasswordQuery = "UPDATE bk_auth_staff SET stf_password = '$hashed_new_password' WHERE stf_id = '$stf_id'";
                $updatePasswordResult = mysqli_query($proj_connect, $updatePasswordQuery);

                if ($updatePasswordResult) {
                    $_SESSION['status'] = "เปลี่ยนรหัสผ่านสำเร็จ";
                    $_SESSION['status_code'] = "success";
                } else {
                    $_SESSION['status'] = "เกิดข้อผิดพลาดในการอัปเดตรหัสผ่าน";
                    $_SESSION['status_code'] = "error";
                }
            } else {
                $_SESSION['status'] = "รหัสผ่านใหม่และยืนยันรหัสผ่านไม่ตรงกัน";
                $_SESSION['status_ecode'] = "error";
            }
        } else {
            $_SESSION['status'] = "รหัสผ่านปัจจุบันไม่ถูกต้อง";
            $_SESSION['status_code'] = "error";
        }
    } else {
        $_SESSION['status'] = "เกิดข้อผิดพลาดในการดึงข้อมูลรหัสผ่าน";
        $_SESSION['status_code'] = "error";
    }

    // ส่งกลับไปยังหน้าที่คุณต้องการ
    header('Location: ' . $location);
}
?>
