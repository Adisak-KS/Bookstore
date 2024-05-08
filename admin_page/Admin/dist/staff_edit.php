<?php
require_once __DIR__ . '/../../../connection.php';


if (isset($_POST['editbtn'])) {
    $stf_id = $_POST['stf_id'];
    $stf_username = $_POST['stf_username'];
    $stf_firstname = $_POST['stf_firstname'];
    $stf_lastname = $_POST['stf_lastname'];
    $stf_email = $_POST['stf_email'];

    //$_SESSION['stf_id'] = $stf_id;
    $location = $_SERVER['HTTP_REFERER'];

    // ตรวจสอบว่าชื่อผู้ใช้ที่แก้ไขซ้ำกับชื่อผู้ใช้อื่นที่มีในฐานข้อมูลหรือไม่
    $checkDuplicateQuery = "SELECT stf_id FROM bk_auth_staff WHERE stf_username = '$stf_username' AND stf_id != '$stf_id'";
    $checkDuplicateResult = mysqli_query($proj_connect, $checkDuplicateQuery);
    $checkEmailQuery = "SELECT stf_id FROM bk_auth_staff WHERE stf_email = '$stf_email' AND stf_id != '$stf_id'";
    $checkEmailResult = mysqli_query($proj_connect, $checkEmailQuery);

    if ((mysqli_num_rows($checkDuplicateResult) > 0) || (mysqli_num_rows($checkEmailResult) > 0)) {
        // ถ้าชื่อผู้ใช้ซ้ำ กำหนดข้อความแจ้งเตือน
        $_SESSION['status'] = "ชื่อผู้ใช้หรืออีเมลซ้ำกับที่มีในระบบ โปรดลองชื่ออื่น";
        $_SESSION['status_code'] = "ผิดพลาด";
        
        // ส่งกลับไปยังหน้าแก้ไข
        header('Location: ' . $location);
    } else {
        // ถ้าชื่อผู้ใช้ไม่ซ้ำ ทำการอัปเดตข้อมูลผู้ใช้
        $updateQuery = "UPDATE bk_auth_staff 
                        SET stf_username = '$stf_username', 
                        stf_firstname = '$stf_firstname',
                        stf_lastname = '$stf_lastname',
                        stf_email = '$stf_email'
                        WHERE stf_id = '$stf_id'";
        $updateResult = mysqli_query($proj_connect, $updateQuery);

        if ($updateResult) {
            $_SESSION['status'] = "อัปเดตผู้ใช้สำเร็จ";
            $_SESSION['status_code'] = "สำเร็จ";
        } else {
            $_SESSION['status'] = "เกิดข้อผิดพลาดในการอัปเดตผู้ใช้";
            $_SESSION['status_code'] = "ผิดพลาด";
        }

        // ส่งกลับไปยังหน้าที่คุณต้องการ
        header('Location: ' . $location);
    }
}


?>
