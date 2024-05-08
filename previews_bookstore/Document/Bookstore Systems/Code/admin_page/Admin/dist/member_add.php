<?php
require_once __DIR__ . '/../../../connection.php';

if (isset($_POST['addbtn'])) {
    $uname = $_POST['mmb_username'];
    $pwd = $_POST['mmb_password'];
    $cpassword = $_POST['cpassword'];
    $fname = $_POST['mmb_firstname'];
    $lname = $_POST['mmb_lastname'];
    $email = $_POST['mmb_email'];

    $email_query = "SELECT * FROM bk_auth_member WHERE mmb_email='$email' OR mmb_username='$uname'";
    $username_query = "SELECT * FROM bk_auth_member WHERE mmb_username='$uname'";

    $email_query_run = mysqli_query($proj_connect, $email_query);
    $username_query_run = mysqli_query($proj_connect, $username_query);

    if (mysqli_num_rows($username_query_run) > 0) {
        $_SESSION['status'] = "ชื่อผู้ใช้นี้ถูกใช้แล้ว โปรดลองชื่อผู้ใช้อื่น";
        $_SESSION['status_code'] = "ผิดพลาด";
        header('Location: member_show.php');
        exit();
    } else if (mysqli_num_rows($email_query_run) > 0) {
        $_SESSION['status'] = "อีเมลนี้ถูกใช้แล้ว โปรดลองอีเมลอื่น";
        $_SESSION['status_code'] = "ผิดพลาด";
        header('Location: member_show.php');
    } else {
        if ($pwd === $cpassword) {

            // ทำการเข้ารหัสรหัสผ่านก่อน
            $hashed_pwd = password_hash($pwd, PASSWORD_DEFAULT);

            $query = "INSERT INTO bk_auth_member (mmb_username, mmb_password, mmb_firstname, mmb_lastname, mmb_email) VALUES ('$uname', '$hashed_pwd', '$fname', '$lname', '$email')";
            $query_run = mysqli_query($proj_connect, $query);

            if ($query_run) {
                echo "Saved";
                $_SESSION['status'] = "เพิ่มสมาชิกสำเร็จ";
                $_SESSION['status_code'] = "สำเร็จ";
                header('Location: member_show.php');
            } else {
                $_SESSION['status'] = "เพิ่มสมาชิกไม่สำเร็จ";
                $_SESSION['status_code'] = "ผิดพลาด";
                header('Location: member_show.php');
            }
        } else {
            $_SESSION['status'] = "รหัสผ่านไม่ตรงกัน โปรดลองอีกครั้ง";
            $_SESSION['status_code'] = "แจ้งเตือน";
            header('Location: member_show.php');
        }
    }
}
