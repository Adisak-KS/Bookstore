<?php
require_once('connection.php');

if ($_SERVER["REQUEST_METHOD"] == "POST") {


    // รับค่าอีเมลจากแบบฟอร์ม
    $email = $_POST['login_input'];

    // ตรวจสอบว่าอีเมลอยู่ในฐานข้อมูลหรือไม่
    $check_query = "SELECT * FROM bk_auth_member WHERE mmb_email = '$email'";
    $check_result = mysqli_query($proj_connect, $check_query);

    if (mysqli_num_rows($check_result) > 0) {
        // สร้างโทเค็นสำหรับเปลี่ยนรหัสผ่าน
        $token = bin2hex(random_bytes(32));

        // เพิ่มโทเค็นลงในฐานข้อมูล
        $insert_query = "INSERT INTO bk_password_reset (mmb_email, prs_token, prs_date) VALUES ('$email', '$token', NOW())";
        mysqli_query($proj_connect, $insert_query);

        // ส่งอีเมลด้วยลิงก์เปลี่ยนรหัสผ่าน
        $to = $email;
        $subject = 'ร้องขอการเปลี่ยนรหัสผ่าน';
        $message = 'คุณได้ร้องขอการเปลี่ยนรหัสผ่าน กรุณาคลิกที่ลิงก์นี้เพื่อเปลี่ยนรหัสผ่าน: http://example.com/reset_password.php?email=' . $email . '&token=' . $token;
        $headers = 'From: 2651032341310@rmutr.ac.th';

        mail($to, $subject, $message, $headers);

        // แสดงข้อความบนหน้าเว็บ
        echo "อีเมลเปลี่ยนรหัสผ่านถูกส่งไปที่ $email";
    } else {
        echo "ไม่พบอีเมลในระบบ";
    }
}
