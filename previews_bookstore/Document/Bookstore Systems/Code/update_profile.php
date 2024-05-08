<?php
require_once('connection.php');

// ตรวจสอบว่ามีค่า $_POST['mmb_id'] หรือไม่
if (isset($_POST['mmb_id'])) {
    $edit_id = $_POST['mmb_id']; // รับค่า edit_id จากฟอร์ม

    // ตัวแปร Location
    $redirect_url = 'my-account.php';
}
// update
if (isset($_POST['updatebtn'])) {
    $mmb_id = $_POST['mmb_id'];
    $mmb_username = $_POST['mmb_username'];
    $mmb_email = $_POST['mmb_email'];
    $mmb_firstname = $_POST['mmb_firstname'];
    $mmb_lastname = $_POST['mmb_lastname'];

    // ตรวจสอบว่า mmb_username และ mmb_email ไม่ซ้ำกับค่าที่มีอยู่ในตาราง member
    $sql_check_username = "SELECT * FROM bk_auth_member WHERE mmb_username = '$mmb_username' AND mmb_id != $mmb_id";
    $result_check_username = mysqli_query($proj_connect, $sql_check_username);
    $sql_check_email = "SELECT * FROM bk_auth_member WHERE mmb_email = '$mmb_email' AND mmb_id != $mmb_id";
    $result_check_email = mysqli_query($proj_connect, $sql_check_email);

    if (mysqli_num_rows($result_check_username) > 0) {
        $_SESSION['status'] = "ชื่อผู้ใช้นี้มีอยู่ในระบบแล้ว";
        $_SESSION['status_code'] = "warning";
        header('Location: ' . $redirect_url);
        exit();
        
    }

    if (mysqli_num_rows($result_check_email) > 0) {
        $_SESSION['status'] = "อีเมลนี้มีอยู่ในระบบแล้ว";
        $_SESSION['status_code'] = "warning";
        header('Location: ' . $redirect_url);
        exit();
    } else {
        // ไม่มีชื่อผู้ใช้หรืออีเมลซ้ำ ดำเนินการอัปเดตข้อมูล
        $query = "UPDATE bk_auth_member SET mmb_username='$mmb_username', mmb_email='$mmb_email', mmb_firstname='$mmb_firstname', mmb_lastname='$mmb_lastname' WHERE mmb_id='$mmb_id' ";
        $query_run = mysqli_query($proj_connect, $query);
        
        if ($query_run) {
            $_SESSION['status'] = "แก้ไขข้อมูลสมาชิกสำเร็จ";
            $_SESSION['status_code'] = "สำเร็จ";
            header('Location: my-account.php');
        } else {
            $_SESSION['status'] = "ไม่สามารถแก้ไขข้อมูลสมาชิกได้";
            $_SESSION['status_code'] = "ผิดพลาด";
            header('Location: my-account.php');
        }
    }
}
?>