<?php
require_once('connection.php');

session_start(); // เริ่มต้น session หากยังไม่ได้ทำ

if (!$proj_connect) {
    die("Connection failed: " . mysqli_connect_error());
}

// ตรวจสอบการส่งฟอร์ม
if (isset($_POST['login_input']) && isset($_POST['mmb_password'])) {
    $login_input = $_POST['login_input']; // ชื่อผู้ใช้หรืออีเมล
    $password = $_POST['mmb_password'];
    unset($_SESSION['total_items']);
    // คำสั่ง SQL สำหรับตรวจสอบข้อมูล
    $sql = "SELECT * FROM bk_auth_member WHERE (mmb_username='$login_input' OR mmb_email='$login_input')";
    $result = mysqli_query($proj_connect, $sql);

    if (mysqli_num_rows($result) == 1) {
        $row = mysqli_fetch_assoc($result);

        // ตรวจสอบรหัสผ่านที่เข้ารหัสแล้ว
        if (password_verify($password, $row['mmb_password'])) {
            // เข้าสู่ระบบสำเร็จ
            $_SESSION['mmb_id'] = $row['mmb_id']; // เพิ่ม session mmb_id
            $_SESSION['status'] = "เข้าสู่ระบบสำเร็จ สวัสดี คุณ" . $row['mmb_username'];
            $_SESSION['status_code'] = "สำเร็จ";
            header("Location: index.php"); // เปลี่ยนเส้นทางไปที่ index.php
            exit();
        } else {
            // เข้าสู่ระบบไม่สำเร็จ
            $_SESSION['status'] = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
            $_SESSION['status_code'] = "ผิดพลาด";
            header('Location: login.php');
        }
    } else {
        // เข้าสู่ระบบไม่สำเร็จ
        $_SESSION['status'] = "ชื่อผู้ใช้หรือรหัสผ่านไม่ถูกต้อง";
        $_SESSION['status_code'] = "ผิดพลาด";
        header('Location: login.php');
    }
} else {
    // เข้าสู่ระบบไม่สำเร็จ
    $_SESSION['status'] = "ไม่พบชื่อผู้ใช้หรืออีเมลนี้";
    $_SESSION['status_code'] = "ผิดพลาด";
    header('Location: login.php');
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($proj_connect);
?>
