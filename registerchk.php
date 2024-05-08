<?php
require_once('connection.php'); // เชื่อมต่อฐานข้อมูล
session_start();

if (!$proj_connect) {
    die("Connection failed: " . mysqli_connect_error());
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['mmb_username'];
    $password = $_POST['mmb_password'];
    $cpassword = $_POST['cpassword'];
    $firstname = $_POST['mmb_firstname'];
    $lastname = $_POST['mmb_lastname'];
    $email = $_POST['mmb_email'];

    // ตรวจสอบรหัสผ่านและรหัสผ่านยืนยันว่าตรงกัน
    if ($password !== $cpassword) {
        $_SESSION['status'] = "รหัสผ่านและรหัสผ่านยืนยันไม่ตรงกัน";
        $_SESSION['status_code'] = "ผิดพลาด";
        header('Location: register.php'); // เปลี่ยนเส้นทางไปที่หน้า register.php
        exit();
    }

    // ตรวจสอบว่า mmb_username และ mmb_email ไม่ซ้ำกับค่าที่มีอยู่ในตาราง member
    $sql_check_username = "SELECT mmb_username FROM bk_auth_member WHERE mmb_username = '$username'";
    $result_check_username = mysqli_query($proj_connect, $sql_check_username);
    $sql_check_email = "SELECT mmb_email FROM bk_auth_member WHERE mmb_email = '$email'";
    $result_check_email = mysqli_query($proj_connect, $sql_check_email);

    if (mysqli_num_rows($result_check_username) > 0) {
        $_SESSION['status'] = "ชื่อผู้ใช้นี้มีอยู่ในระบบแล้ว";
        $_SESSION['status_code'] = "warning";
        header('Location: ' . 'register.php');
        exit();
    }

    if (mysqli_num_rows($result_check_email) > 0) {
        $_SESSION['status'] = "อีเมลนี้มีอยู่ในระบบแล้ว";
        $_SESSION['status_code'] = "warning";
        header('Location: ' . 'register.php');
        exit();
    }

    // เข้ารหัสรหัสผ่าน
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // คำสั่ง SQL สำหรับเพิ่มข้อมูลสมาชิกใหม่
    $insert_sql = "INSERT INTO bk_auth_member (mmb_username, mmb_password, mmb_firstname, mmb_lastname, mmb_email)
                   VALUES ('$username', '$hashed_password', '$firstname', '$lastname', '$email')";

    if (mysqli_query($proj_connect, $insert_sql)) {
        $_SESSION['status'] = "สมัครสมาชิกสำเร็จ";
        $_SESSION['status_code'] = "สำเร็จ";
        header('Location: login.php'); // เปลี่ยนเส้นทางไปที่หน้า index.php
        exit();
    } else {
        $_SESSION['status'] = "เกิดข้อผิดพลาดในการสมัครสมาชิก";
        $_SESSION['status_code'] = "ผิดพลาด";
        header('Location: register.php'); // เปลี่ยนเส้นทางไปที่หน้า register.php
        exit();
    }
}

// ปิดการเชื่อมต่อฐานข้อมูล
mysqli_close($proj_connect);
