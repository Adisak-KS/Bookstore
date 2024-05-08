<?php
require_once('connection.php');
session_start();

unset($_SESSION['mmb_id']);
$_SESSION['status'] = "ออกจากระบบสำเร็จ";
        $_SESSION['status_code'] = "สำเร็จ";
        header('Location: index.php'); // เปลี่ยนเส้นทางไปที่หน้า register.php
        exit();
?>